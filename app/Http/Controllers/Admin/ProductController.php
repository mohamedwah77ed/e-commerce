<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Brands;
use App\Models\ProductImage;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with(['cat_info', 'sub_cat_info', 'images'])
                            ->latest()
                            ->paginate(12);
        return view('backend.products.products_index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands     = Brands::all();
        return view('backend.products.products_create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'        => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'summary'      => 'required|string',
            'description'  => 'nullable|string',
            'cat_id'       => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'brand_id'     => 'nullable|exists:brands,id',
            'stock'        => 'nullable|integer|min:0',
            'discount'     => 'nullable|numeric|min:0|max:100',
            'condition'    => 'nullable|in:new,used,refurbished',
            'status'       => 'nullable|in:active,inactive',
            'is_featured'  => 'nullable|boolean',
            'images.*'     => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        $slug = Str::slug($request->title);
        $original = $slug;
        $count = 1;
        while (Products::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }
        $validatedData['slug'] = $slug;
        $validatedData['is_featured'] = $request->has('is_featured') ? 1 : 0;

        $product = Products::create($validatedData);

       if ($request->hasFile('images')) {
    foreach ($request->file('images') as $img) {
        $name = time() . '_' . uniqid() . '.jpg';

        Image::make($img)
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(public_path('uploads/' . $name), 82);

        ProductImage::create([
            'product_id' => $product->id,
            'image'      => $name,
        ]);
    }
}

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Products::with(['cat_info', 'sub_cat_info', 'images', 'brand'])
                           ->where('slug', $slug)
                           ->firstOrFail();

        $related = Products::with('images')
                           ->where('cat_id', $product->cat_id)
                           ->where('id', '!=', $product->id)
                           ->where('status', 'active')
                           ->where('stock', '>', 0)
                           ->take(4)->get();

        return view('backend.products.products_show', compact('product', 'related'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Products::with('images')->findOrFail($id);
        $categories = Category::all();
        $brands = Brands::all();
        return view('backend.products.products_edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Products::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'summary'      => 'required|string',
            'description'  => 'nullable|string',
            'cat_id'       => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'brand_id'     => 'nullable|exists:brands,id',
            'stock'        => 'nullable|integer|min:0',
            'discount'     => 'nullable|numeric|min:0|max:100',
            'condition'    => 'nullable|in:new,used,refurbished',
            'status'       => 'nullable|in:active,inactive',
            'is_featured'  => 'nullable|boolean',
            'images.*'     => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        $product->update($validated);

        if ($request->hasFile('images')) {
    foreach ($request->file('images') as $img) {
        $name = time() . '_' . uniqid() . '.jpg';

        Image::make($img)
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(public_path('uploads/' . $name), 82);

        ProductImage::create([
            'product_id' => $product->id,
            'image'      => $name,
        ]);
    }
}

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully');
    }

    /**
     * Delete a product image.
     */
    public function deleteImage($id)
    {
        $img = ProductImage::findOrFail($id);
        @unlink(public_path('uploads/' . $img->image));
        $img->delete();
        return back()->with('success', 'Image deleted');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::with('images')->findOrFail($id);

        foreach ($product->images as $img) {
            @unlink(public_path('uploads/' . $img->image));
        }

        $status = $product->delete();

        return redirect()->route('products.index')
                         ->with($status ? 'success' : 'error',
                                $status ? 'Product successfully deleted' : 'Error while deleting product');
    }
}
