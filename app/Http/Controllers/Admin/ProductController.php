<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MineralFertilizer;

class ProductController extends Controller
{
    // ===================== PRODUCT FUNCTIONS =====================

    // 🧾 Show all products
    public function productIndex()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // 🆕 Show create product form
    public function productCreate()
    {
        return view('admin.products.create');
    }

    // 💾 Store new product
    public function productStore(Request $request)
    {
        $request->validate([
            'crop_name' => 'required',
            'variety_name' => 'required',
            'breeder_name' => 'required',
            'country_origin' => 'required',
            'registration_number' => 'required',
            'variety_type' => 'required',
            'seed_category' => 'nullable',
            'other_recommendations_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('other_recommendations_photo')) {
            $fileName = time() . '.' . $request->other_recommendations_photo->extension();
            $request->other_recommendations_photo->move(public_path('uploads/products'), $fileName);
            $data['other_recommendations_photo'] = 'uploads/products/' . $fileName;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    // 🗑️ Delete product
    public function productDestroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image if exists
        if ($product->other_recommendations_photo && file_exists(public_path($product->other_recommendations_photo))) {
            unlink(public_path($product->other_recommendations_photo));
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    // ===================== MINERAL FERTILIZER FUNCTIONS =====================

    // 🧾 Show all mineral fertilizers
    public function fertilizerIndex()
    {
        $fertilizers = MineralFertilizer::latest()->get();
        return view('admin.products.fertilizers_index', compact('fertilizers'));
    }

    // 🆕 Show create mineral fertilizer form
    public function fertilizerCreate()
    {
        return view('admin.products.mineral_fertilizers');
    }

    // 💾 Store new mineral fertilizer
    public function fertilizerStore(Request $request)
    {
        $request->validate([
            'fertilizer_type' => 'required',
            'registration_number' => 'required',
            'physical_form' => 'required',
            'trade_name' => 'required',
            'n' => 'nullable',
            'p2' => 'nullable',
            'k2' => 'nullable',
            'zn' => 'nullable',
            'ca' => 'nullable',
            'mg' => 'nullable',
            's' => 'nullable',
            'b' => 'nullable',
            'mo' => 'nullable',
            'application_rate' => 'nullable',
            'wholesale_price' => 'nullable',
            'semiwholesale_price' => 'nullable',
            'retail_price' => 'nullable',
        ]);

        MineralFertilizer::create($request->all());

        return redirect()->route('fertilizers.create')->with('success', 'Mineral Fertilizer added successfully!');
    }

    // 🗑️ Delete mineral fertilizer
    public function fertilizerDestroy($id)
    {
        $fertilizer = MineralFertilizer::findOrFail($id);
        $fertilizer->delete();
        return redirect()->route('fertilizers.index')->with('success', 'Mineral Fertilizer deleted successfully!');
    }
}
