<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Brands;
use App\Models\Category;

class FrontendController extends Controller
{
    public function show_all_products()
    {
        $categories = Category::where('status', 'active')
                              ->orderBy('title', 'asc')
                              ->get();

        $brands = Brands::where('status', 'active')
                        ->orderBy('title', 'asc')
                        ->get();

        $bestSellers = $this->getProductsByCategorySlug('phone', 10);

        $appleBrand = Brands::where('slug', 'apple')->first();
        $appleProducts = $appleBrand
            ? Products::with(['images'])
                        ->where('brand_id', $appleBrand->id)
                        ->where('status', 'active')
                        ->where('stock', '>', 0)
                        ->latest()
                        ->take(10)
                        ->get()
            : collect();

        $laptopCategoryIds = Category::whereIn('slug', ['laptops', 'tablets', 'gaming'])->pluck('id');
        $laptopProducts = Products::with(['images'])
                                  ->where(function($q) use ($laptopCategoryIds) {
                                      $q->whereIn('cat_id', $laptopCategoryIds)
                                        ->orWhereIn('child_cat_id', $laptopCategoryIds);
                                  })
                                  ->where('status', 'active')
                                  ->where('stock', '>', 0)
                                  ->latest()
                                  ->take(10)
                                  ->get();

        $goalProducts = Products::with(['images'])
                                ->where('status', 'active')
                                ->where('stock', '>', 0)
                                ->latest()
                                ->take(10)
                                ->get();

        return view("frontend.home", compact(
            "categories",
            "brands",
            "bestSellers",
            "appleProducts",
            "laptopProducts",
            "goalProducts"
        ));
    }

    public function getProductsByCategoryAjax(Request $request)
    {
        $categorySlug = $request->get('category');
        $limit = $request->get('limit', 10);

        $products = $this->getProductsByCategorySlug($categorySlug, $limit);

        $html = view('frontend.partials.product-carousel', ['products' => $products])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $products->count()
        ]);
    }

private function getProductsByCategorySlug(string $slug, int $limit = 10)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return collect();
        }

        return Products::with(['images', 'brand', 'cat_info'])
                       ->where(function($query) use ($category) {
                           $query->where('cat_id', $category->id)
                                 ->orWhere('child_cat_id', $category->id);
                       })
                       ->where('status', 'active')
                       ->where('stock', '>', 0)
                       ->latest()
                       ->take($limit)
                       ->get();
    }


public function show_details($slug)
{
    $product = Products::with(['cat_info', 'sub_cat_info', 'images'])
                       ->where('slug', $slug)
                       ->firstOrFail();

    // ── Recently Viewed ──
    $viewed = session()->get('recently_viewed', []);
    $viewed = array_filter($viewed, fn($p) => $p['id'] !== $product->id);
    array_unshift($viewed, [
        'id'    => $product->id,
        'slug'  => $product->slug,
        'title' => $product->title,
        'price' => $product->price,
        'image' => $product->images->first()?->image,
    ]);
    session()->put('recently_viewed', array_slice($viewed, 0, 10));

    // ── Related Products ──
    $related = Products::with('images')
                       ->where('status', 'active')
                       ->where('stock', '>', 0)
                       ->where('id', '!=', $product->id)
                       ->where(function($query) use ($product) {
                           $query->where('cat_id', $product->cat_id)
                                 ->orWhere('brand_id', $product->brand_id);
                       })
                       ->take(4)->get();

    return view('frontend.product-details', compact('product', 'related'));
}
public function brandProducts(string $slug)
{
    $brand    = Brands::getBySlug($slug);
    $products = Products::getByBrand($brand->id);

    return view('frontend.brand-products', compact('brand', 'products'));
}

public function categoryProducts(string $slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();

    $products = Products::with(['cat_info', 'sub_cat_info', 'images'])
                        ->where(function ($query) use ($category) {
                            $query->where('cat_id', $category->id)
                                  ->orWhere('child_cat_id', $category->id);
                        })
                        ->where('status', 'active')
                        ->where('stock', '>', 0)
                        ->latest()
                        ->paginate(12);

    return view('frontend.category-products', compact('category', 'products'));
}

public function search(Request $request)
{
    $keyword  = trim($request->get('q', ''));
    $products = Products::search($keyword);

    return view('frontend.search-results', compact('products', 'keyword'));
}
}
