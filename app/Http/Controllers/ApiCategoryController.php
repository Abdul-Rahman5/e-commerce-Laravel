<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiCategoryController extends Controller
{
    public function all()
    {
        $products = product::all();
        return ProductResource::collection($products);
    }
    public function show($id)
    {
        $product = product::find($id);
        if ($product == null) {

            return response()->json([
                "msg" => "Product not found"
            ], 404);
        }
        
         return new ProductResource($product);
    }
    public function store( Request $request)
    {
       $validator= Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "desc"=>"required|string",
            "price"=>"required|integer",
            "quantity"=>"required|string",
            "image"=>"required|image|mimes:png,jpg,jpeg",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "msg"=>$validator->errors()
            ],301);
        }
      $imageName=  Storage::putFile("products",$request->image);
        product::create([
            "name"=>$request->name,
            "desc"=>$request->desc,
            "price"=>$request->price,
            "quantity"=>$request->quantity,
            "image"=>$imageName,
        ]);
       
        return response()->json([
            "msg"=>"data created successfuly"
        ],201);
    }
    public function update( Request $request ,$id)
    {
        //find
        $product = product::find($id);
        if ($product == null) {

            return response()->json([
                "msg" => "Product not found"
            ], 404);
        }
       $validator= Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "desc"=>"required|string",
            "price"=>"required|integer",
            "quantity"=>"required|string",
            "image"=>"image|mimes:png,jpg,jpeg",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "msg"=>$validator->errors()
            ],301);
        }
          
        //image
        $imageName=$product->image;
        if ($request->has("iamge")) {
            if ($imageName !=null) {
                Storage::delete($product->image);
            }
            $imageName=  Storage::putFile("products",$request->image);

        }
        //update
        $product->update([
            "name"=>$request->name,
            "desc"=>$request->desc,
            "price"=>$request->price,
            "quantity"=>$request->quantity,
            "image"=>$imageName,

        ]);
        return response()->json([
            "msg"=>"data update successfuly"
        ],200);
    }
    public function delete($id)
    {
        $product = product::find($id);
        if ($product == null) {

            return response()->json([
                "msg" => "Product not found"
            ], 404);
        }
        if ($product->image != null) {
            
            Storage::delete($product->image);
        }
        $product->delete();
        return response()->json([
            "msg"=>"data daleted successfuly"
        ],200);
    }
}
