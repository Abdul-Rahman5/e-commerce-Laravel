<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  public function redirect()
  {
    if (Auth::User()->user_type == '1') {
      return  view("admin.home");
    } else {
      $products=product::paginate(2);
      return  view("user.home",compact("products"));
    }
  }
  public function index()
  {
    $products=product::paginate(2);
    return  view("user.home",compact("products"));
  }
  public function search(Request $request)
  {
    $key=$request->key;
   $products= product::where("name","like","%$key%")->paginate(2);
    return  view("user.home",compact("products"));


  }
}
