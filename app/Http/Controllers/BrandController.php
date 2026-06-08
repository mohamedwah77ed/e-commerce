<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Brands;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource (with pagination).
     */
    public function index()
    {
        $brands = Brands::latest('id')->paginate(10);
        return view('backend.brand.brand_index', compact('brands'));
    }

    /**
     * Get ALL brands (no pagination).
     */


    /**
     * Get all active brands only.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.brand.Create_brand');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'  => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->title);

        $latestSlug = Brands::where('slug', 'like', $slug . '%')
            ->latest('id')
            ->value('slug');

        if ($latestSlug) {
            preg_match('/-(\d+)$/', $latestSlug, $matches);
            $count = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
            $slug = $slug . '-' . $count;
        }

        $validatedData['slug'] = $slug;
        $validatedData['is_parent'] = $request->input('is_parent', 0);

        $brand = Brands::create($validatedData);

        $message = $brand
            ? 'Brand successfully added'
            : 'Error occurred, Please try again!';

        return redirect()->route('brand.index')->with(
            $brand ? 'success' : 'error',
            $message
        );
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brands::findOrFail($id);
        return view('backend.brand.brand_edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brands::findOrFail($id);

        $validatedData = $request->validate([
            'title'  => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->title);

        $latestSlug = Brands::where('slug', 'like', $slug . '%')
            ->where('id', '!=', $id)
            ->latest('id')
            ->value('slug');

        if ($latestSlug) {
            preg_match('/-(\d+)$/', $latestSlug, $matches);
            $count = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
            $slug = $slug . '-' . $count;
        }

        $validatedData['slug'] = $slug;

        $updated = $brand->update($validatedData);

        $message = $updated
            ? 'Brand successfully updated'
            : 'Error occurred, Please try again!';

        return redirect()->route('brand.index')->with(
            $updated ? 'success' : 'error',
            $message
        );
    }
    /**
 * Get products by brand slug
 */
public function productsByBrand(string $slug)
{
    $brand = Brands::where('slug', $slug)->firstOrFail();

    $products = $brand->products()
                      ->latest('id')
                      ->paginate(12);

    return view('brand.products', compact('brand', 'products'));
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brands::findOrFail($id);
        $deleted = $brand->delete();

        $message = $deleted
            ? 'Brand successfully deleted'
            : 'Error occurred, Please try again!';

        return redirect()->route('admin.brand.index')->with(
            $deleted ? 'success' : 'error',
            $message
        );
    }
}
