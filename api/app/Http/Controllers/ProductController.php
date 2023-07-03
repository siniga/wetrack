<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

class ProductController extends Controller {
    public function index() {
        $products = Product::all();
        return response()->json( $products );
    }

    public function store( Request $request ) {
        // $request->validate( [
        //     'name' => 'required',
        //     'cost' => 'required|numeric',
        //     'price' => 'required|numeric',
        //     'stock' => 'required|integer',
        //     'sku' => 'required|unique:products',
        //     'business_id' => 'required|exists:businesses,id',
        //     'category_id' => 'required|exists:categories,id',
        // ] );

        // Validate the uploaded file
        // $request->validate( [
        //     'file' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Adjust the validation rules as per your requirements
        // ] );

        if ( !empty( request()->file( 'file' ) ) ) {

            $doc = request()->file( 'file' );
            $uplodedDoc = $doc->store( 'uploads' );

            //get original file name
            $originalFileName =  request()->file( 'file' )
            ->getClientOriginalName();

            //get file extention
            $extension = $doc->getClientOriginalExtension();

        } else {
            $uplodedDoc = $request->img;
        }

        $product = Product::create( [
            'name'=>$request->name,
            'cost'=>$request->cost,
            'price'=>$request->price,
            'stock'=>$request->stock,
            'sku'=>$request->sku,
            'img'=> $uplodedDoc,
            'business_id'=>$request->business_id,
            'category_id'=>$request->category_id
        ] );

        return response()->json( $product, 201 );
    }

    public function show( Product $product ) {
        return response()->json( $product );
    }

    public function update( Request $request, Product $product ) {
        // $request->validate( [
        //     'name' => 'required',
        //     'cost' => 'required|numeric',
        //     'price' => 'required|numeric',
        //     'stock' => 'required|integer',
        //     'sku' => 'required|unique:products,sku,' . $product->id,
        //     'business_id' => 'required|exists:businesses,id',
        //     'category_id' => 'required|exists:categories,id',
        // ] );

        $product->update( [
            'name'=>$request->name,
            'cost'=>$request->cost,
            'price'=>$request->price,
            'stock' =>$request->stock,
            'sku'=>$request->sku,
            'business_id'=>$request->business_id,
            'category_id'=>$request->category_id
        ] );

        return response()->json( $product );
    }

    public function destroy( $id ) {
        // Find the item by ID
        $item = Product::find( $id );

        if ( !$item ) {
            // Handle the case where the item doesn't exist
        abort(404, 'Item not found');
    }

    // Delete the item
    $item->delete();

    // Optionally, you can return a response or redirect
    return response()->json(['message' => 'Item deleted successfully']);
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
        ->select('products.*', 'businesses.id as business_id','businesses.name as business', 'categories.id as category_id','categories.name as category' )
            ->orderBy( 'products.id', 'desc' )
            ->get();

            $products = $products->map( function ( $product ) {
                $product->created_at_ago = Carbon::parse( $product->created_at )->diffForHumans();
                return $product;
            }
        );

        return response()->json( $products );
    }
}
