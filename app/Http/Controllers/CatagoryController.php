<?php

namespace App\Http\Controllers;
use App\Models\Catagory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use thiagoalessio\TesseractOCR\TesseractOCR;

class CatagoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = DB::table('catagory')->select('*')->get();

    // $catagory = Product::all();
    return response()->json([
    "success" => true,
    "message" => "catagory List",
    "data" => $data
    ]);  
  }


  public function add(Request $request)
  {
    $catagory_name = $request->input('catagory_name');
   
    $data = DB::table('catagory')->insert([
      'catagory_name' => $catagory_name
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
    "message" => "Catagory created successfully.",
    "data" => $data
    ]);   

  }else{
    return $this->sendError('Catagory create fail');

  }
  }

  public function show($id)
  {
    $data = DB::table('catagory')->select('*')->where('catagory_id', $id)->get();

    if (!$data->isEmpty()) {

      return response()->json([
        "success" => true,
        "message" => "catagory found.",
        "data" => $data
        ]);
    } else {
      return $this->sendError('catagory not found.');
    }
   
  }
       //     DB::table('wallets')
        //         ->where('telegram_id', $id)
        //         ->update(['current_credit' => $credit]);
  public function update(Request $request, $id)
  {
    $catagory_name = $request->input('catagory_name');


    $data = DB::table('catagory')->where('catagory_id', $id)->update(['catagory_name' => $request->input('catagory_name')]);
    return response()->json([
    "success" => true,
    "message" => "catagory updated successfully.",
    ]);
  }

  public function del($id)
  {
    $data = DB::table('catagory')->where('catagory_id',$id)->update(['active' => 0]);
    $data1 = DB::table('catagory')->select('*')->where('catagory_id', $id)->get();

    if ($data1[0]->active==0) {
    $data = DB::table('products')->where('catagory_id',$id)->update(['active' => 0]);
      return response()->json([
        "success" => true,
        "message" => "success"
        ]);
    } else {

      return response()->json([
        "success" => false,
        "message" => "fail"
        ]);
    }

  
   }
}
