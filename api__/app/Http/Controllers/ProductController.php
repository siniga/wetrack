<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
class ProductController extends Controller
{
 public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'cost' => 'required|numeric',
        //     'price' => 'required|numeric',
        //     'stock' => 'required|integer',
        //     'sku' => 'required|unique:products',
        //     'business_id' => 'required|exists:businesses,id',
        //     'category_id' => 'required|exists:categories,id',
        // ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
        }

        $product = Product::create([
            "name"=>$request->name,
            "cost"=>$request->cost,
            "price"=>$request->price,
            "stock"=>$request->stock,
            "sku"=>$request->sku,
            'img'=> "jdjdj",
            "business_id"=>$request->business_id,
            "category_id"=>$request->category_id
    ]);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'cost' => 'required|numeric',
        //     'price' => 'required|numeric',
        //     'stock' => 'required|integer',
        //     'sku' => 'required|unique:products,sku,' . $product->id,
        //     'business_id' => 'required|exists:businesses,id',
        //     'category_id' => 'required|exists:categories,id',
        // ]);

        $product->update([
            "name"=>$request->name,
            "cost"=>$request->cost,
            "price"=>$request->price,
            "stock" =>$request->stock,
            "sku"=>$request->sku,
            "business_id"=>$request->business_id,
            "category_id"=>$request->category_id
    ]);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function getProductsByCategoryId($categoryId)
    {
        $products = Product::with('category')->where('category_id', $categoryId)->get();

        return response()->json($products);
    }

    public function getProductsByBusinessId($businessId){
        $products = Product::where('products.business_Id', $businessId)
        ->join('categories', 'categories.id','products.category_id')
        ->join('businesses','businesses.id','products.business_id')
        ->select('products.*', 'businesses.id as business_id','businesses.name as business', 'categories.id as category_id','categories.name as category')
        ->orderBy("products.id","desc")
        ->get();

        $products = $products->map(function ($product) {
            $product->created_at_ago = Carbon::parse($product->created_at)->diffForHumans();
            return $product;
        });

        return response()->json($products);
    }
}
