<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::all();
        return Inertia::render('Products', [
            'products' => $products
        ]);
    }
    public function show()
    {

        $products = Product::all();
        return Inertia::render('Admin/Products', [
            'products' => $products
        ]);
    }


    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'category' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);
        //            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        $product = Product::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description
        ]);

        if ($request->hasFile('imageFile')) {
            $imagePath = $request->file('imageFile')->store('Products', 'public');
            $product->image
                = $imagePath;
            $product->save();
        }

        return redirect()->back()->with('success', 'Product added successfully.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
         $formFields = $request->validate([
             'name' => 'required',
             'quantity' => 'required',
             'category' => 'required',
             'price' => 'required',
             'description' => 'required',

        ]);

        if ($request->hasFile('imageFile')) {
            $formFields['image'] = $request->file('imageFile')->store('Products', 'public');
        }
    
        $isCreated = $product->update($formFields);
        if (!$isCreated) {
            // return to_route('admin.product',);
        }
        // return to_route('admin.product',);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {

            $product->delete();
           /// return to_route('admin.product',);
        } catch (Exception $e) {

         //   return to_route('admin.product',);
        }
    }
}
