<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function allproducts()
    {
        $products=product::all();
        return view("admin.all",compact("products"));
    }
    public function create()
    {
        return view("admin.create");
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "desc" => "required|string",
            "price" => "required|numeric",
            "quantity" => "required|numeric",
            "image" => "required|image|mimes:png,jpg,jpej",
        ]);
        // //store

        $data['image'] = Storage::putFile("products", $data['image']);
        product::create($data);
        return redirect(url("products"))->with("success","data inserted successfuly");

    }
    public function edit($id)
    {
        $product= product::findOrfail($id);
        return view("admin.edit",compact("product"));
    }
    public function update(Request $request ,$id)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "desc" => "required|string",
            "price" => "required|numeric",
            "quantity" => "required|numeric",
            "image" => "image|mimes:png,jpg,jpej",
        ]);
        $product= product::findOrfail($id);
        if ($request->has("image")) {
            Storage::delete($product->image);
            $data['image'] = Storage::putFile("products", $data['image']);
        }
        $product->update($data);
        return redirect(url("products"))->with("success","data updated successfuly");


        
    }
    public function delete($id)
    {
        $product= product::findOrfail($id);
        Storage::delete($product->image);
        $product->delete();
        return redirect(url("products"))->with("success","data deleted successfuly");

    }
}
