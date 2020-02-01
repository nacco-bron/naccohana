<?php

namespace App\Http\Controllers;

use App\Discovery;
use App\Flower;
use Illuminate\Http\Request;

class DiscoveryController extends Controller
{
    /*
    * 発見情報の一覧表示
    */
    
    public function index(Request $request) {
 
        $discoveries = Discovery::all();
                
        return view('discoveries', [
            'discoveries' => $discoveries,
        ]);
    }

}
