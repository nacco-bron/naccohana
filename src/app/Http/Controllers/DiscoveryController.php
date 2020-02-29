<?php

namespace App\Http\Controllers;

use App\Discovery;
use App\Flower;
use App\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    /*
    * 発見情報の登録画面
    */
    
    public function create(Request $request) {
        
        $discovery = new Discovery;
        $flowers = Family::find(1)->flowers()->orderBy('name', 'asc')->get();
        $families = Family::orderBy('name', 'asc')
                    ->where('name', 'not like', '－')
                    ->get();

        return view('discovery', [ 
            'discovery' => $discovery, 
            'flowers' => $flowers, 
            'families' => $families, 
        ]); 
    }



    /*
    * 発見情報の登録
    */
    
    public function store(Request $request) {
        
        $this->validate($request, [
        ]);
        

        $discovery = new Discovery;
        $discovery->flower_id = $request->flower_id;
        $discovery->file_name1 = $request->file_name1;
        $discovery->file_name2 = $request->file_name2;
        $discovery->file_name3 = $request->file_name3;
        $discovery->file_name4 = $request->file_name4;
        $discovery->discovered_at = $request->discovered_at;
        // $discovery->latlng['lat'] = $request->lat;
        // $discovery->latlng['lng'] = $request->lng;
        $discovery->save();
        
        for ($i=1; $i <= 4; $i++) { 
            if( $request->file('image'.$i) != null ){
                $request->file('image'.$i)->storeAs('images'.$i, $discovery->id . '_' . $request->file_name.$i, '');
            }
        }
       
        return redirect('/discoveries')->with('success','発見情報を登録しました。');;
    }


}
