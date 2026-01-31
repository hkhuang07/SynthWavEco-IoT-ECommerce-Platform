<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShipperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
   public function index()
    {
        return view('shipper.dashboard');
    }
    
    // Method getHome - có thể dùng cho route khác
    public function getHome()
    {
        return view('shipper.home');
    }
}
