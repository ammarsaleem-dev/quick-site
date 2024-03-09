<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(3);
        return view('layouts.products.browse', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('layouts.products.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'name' => 'required|unique:products',
            'description' => 'string|nullable',
            'price' => 'required|numeric',
            'category_id' => 'numeric|nullable',
            'image' => 'required|image|mimes:jpeg,png|max:2048'
        ]);
        if ($request->hasFile('image')) {
            $filenameWithExtension = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameStore = $filename . '_' . time() . '.' . $extension;
            $request->file('image')->storeAs('public/products', $filenameStore);
            // $request->file('image')->storePubliclyAs('products/', $filenameStore, 's3');
        } else {
            $filenameStore = '';
        }


        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description') ?? "-";
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->image = $filenameStore;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('layouts.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name,' . $id,
            'price' => 'required|numeric',
            'description' => 'string|nullable',
            'category_id' => 'numeric|nullable',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048'
        ]);
        $product = Product::find($id);

        if ($request->hasFile('image')) {
            Storage::delete(["public/products/$product->image"]);
            // Storage::disk('s3')->delete("products/$product->image");
            $filenameWithExtension = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameStore = $filename . '_' . time() . '.' . $extension;
            $request->file('image')->storeAs('public/products', $filenameStore);
            // $request->file('image')->storePubliclyAs('products/', $filenameStore, 's3');
            $product->image = $filenameStore;
        } else {
            $filenameStore = '';
            $product->image = $filenameStore;
        }

        $product->name = $request->input('name');
        $product->description = $request->input('description') ?? "-";
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->save();
        return redirect()->route('products.index')->with('success', 'Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::find($id);
        if ($product->image != "") {
            Storage::delete(["public/products/$product->image"]);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Successfully');
    }


    public function deleteImage(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        if ($product->image != "") {
            Storage::delete(["public/products/$product->image"]);
            $product->image = "";
            $product->save();
        }
    }
}
