<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\UploadedFile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use thiagoalessio\TesseractOCR\TesseractOCR;

class ProductController extends Controller
{
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
    $data = null;
    $product_name = $request->input('product_name');
    $product_price = $request->input('product_price');
    $product_key = $request->input('product_key');
    $catagory_id = $request->input('catagory_id');
    try {

      if ($request->file('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        // File upload location
        $location = './../uploads';
        // Upload file
        $file->move($location, $filename);
        $data = DB::table('products')->insert([
          'product_name' => $product_name,
          'product_price' => $product_price,
          'product_key' => $product_key,
          'catagory_id' => $catagory_id,
          'name_pic' => $filename,
          'file_path' => $location
        ]);
      }
      if (!$request->file('file')) {

        $data = DB::table('products')->insert([
          'product_name' => $product_name,
          'product_price' => $product_price,
          'product_key' => $product_key,
          'catagory_id' => $catagory_id
        ]);
      }

      return response()->json([
        "success" => true,
        "message" => "Product created successfully.",
      ]);
    } catch (\Throwable $e) {
      return response()->json([
        "success" => FALSE,
        "message" => "Product created fail.",
      ]);
    }
  }



  public function show($id)
  {
    // try {
    $data = DB::table('products')->select('*')->where('product_id', $id)->get();
    // $data = DB::table('products')->select('*')->where('product_id', $data[0]->product_id)->get();

    if (!$data->isEmpty()) {

      return response()->json([
        "success" => true,
        "message" => "Product found.",
        "data" => $data
      ]);
    } else {
      return response()->json([
        "success" => FALSE,
        "message" => "Product not found.",
      ]);
    }
    // } catch (\Throwable $th) {
    //   // return $this->sendError('Product not found.');
    //   return response()->json([
    //     "success" => FALSE,
    //     "message" => "Product not found.",
    //   ]);
    // }
  }

  public function update(Request $request, $id)
  {
    // $product_name = $request->input('product_name');
    // $product_price = $request->input('product_price');
    // $product_key = $request->input('product_key');
    // $catagory_id = $request->input('catagory_id');
    try {

      $data = DB::table('products')->where('product_id', $id)
        ->update([
          'product_name' => $request->input('product_name'),
          'product_price' => $request->input('product_price'),
          'product_key' => $request->input('product_key'),
          'catagory_id' => $request->input('catagory_id')
        ]);
      return response()->json([
        "success" => true,
        "message" => "Product updated successfully.",
      ]);
    } catch (\Throwable $e) {
      return response()->json([
        "success" => FALSE,
        "message" => "Product updated fail.",
      ]);
    }
  }


  public function del($id)
  {
    try {
      $data = DB::table('products')->select('*')->where('product_id', $id)->get();
      // if (!$data->isEmpty()) {

      DB::table('products')->where('product_id', $data[0]->product_id)->update(['active' => 0]);
      return response()->json([
        "success" => true,
        "message" => "Product deleted successfully.",
      ]);
      // }
    } catch (\Throwable $e) {
      return response()->json([
        "success" => FALSE,
        "message" => "Product deleted fail.",
      ]);
    }
  }
}
