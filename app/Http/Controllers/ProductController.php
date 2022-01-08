<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use thiagoalessio\TesseractOCR\TesseractOCR;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = DB::table('products')->select('*')->get();

    // $products = Product::all();
    return response()->json([
    "success" => true,
    "message" => "Product List",
    "data" => $data
    ]);  
  }  
  public function search($name)
  {
    $data = DB::table('products')->select('*')->where('product_name', 'LIKE', "%$name%")->get();

    // $products = Product::all();
    return response()->json([
    "success" => true,
    "message" => "Product List",
    "data" => $data
    ]);  
  }
  


  public function add(Request $request)
  {
    $product_name = $request->input('product_name');
    $product_price = $request->input('product_price');
    $product_key = $request->input('product_key');
    $catagory_id = $request->input('catagory_id');

    $data = DB::table('products')->insert([
      'product_name' => $product_name,
      'product_price' => $product_price,
      'product_key' => $product_key,
      'catagory_id' => $catagory_id
  ]);
  // $data = Product::create([
  //   'product_name' => $request->product_name,
  //   'product_price' => $request->product_price,
  //   'product_key' => $request->product_key,
  //   'catagory_id' => $request->catagory_id,
  //   'active' => $request->active
  // ]);
  // $data->safe();
  if ($data===true) {

    return response()->json([
    "success" => true,
    "message" => "Product created successfully.",
    "data" => $data
    ]);   

  }else{
    return $this->sendError('Product create fail');

  }
  }

  public function show($id)
  {
    $data = DB::table('products')->select('*')->where('product_id', $id)->get();

    if (!$data->isEmpty()) {

      return response()->json([
        "success" => true,
        "message" => "Product found.",
        "data" => $data
        ]);
    } else {
      return $this->sendError('Product not found.');
    }
   
  }
       //     DB::table('wallets')
        //         ->where('telegram_id', $id)
        //         ->update(['current_credit' => $credit]);
  public function update(Request $request, $id)
  {
    $product_name = $request->input('product_name');
    $product_price = $request->input('product_price');
    $product_key = $request->input('product_key');
    $catagory_id = $request->input('catagory_id');

    $data = DB::table('products')->where('product_id', $id)
                ->update([
                  'product_name' => $request->input('product_name'),
                  'product_price' => $request->input('product_price'),
                  'product_key' => $request->input('product_key'),
                  'catagory_id' => $request->input('catagory_id')
                ]);



    // $input = $request->all();
    // $product->name = $input['name'];
    // $product->detail = $input['detail'];
    // $product->save();
    return response()->json([
    "success" => true,
    "message" => "Product updated successfully.",
    ]);
  }

  public function del($id)
  {
    DB::table('products')->where('product_id',$id)->update(['active' => 0]);
    return response()->json([
    "success" => true,
    "message" => "Product deleted successfully.",
  ]);
  
}}
