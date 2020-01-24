<?php 

namespace App\Http\Controllers;

use Storage;
use App\Flower;
use App\Family;
use Illuminate\Http\Request;

class FlowerController extends Controller
{
    /*
    * 花の一覧表示
    */
    
    public function index(Request $request) {
 
        $flowers = Flower::orderBy('name', 'asc')->take(100)->get();
        $families = $this->getFamilyList(
                                Family::orderBy('name', 'asc')
                                ->where('name', 'not like', '－')
                                ->get()
                            );
        $search_families = $this->getFamilyList(
                                Family::select('id','name')
                                ->where('name', 'not like', '－')
                                ->whereIn('id', Flower::select('family_id'))
                                ->orderBy('name', 'asc')
                                ->get()
                            );
                
        return view('flowers', [
            'flowers' => $flowers,
            'family_id' => null,
            'families' => $families,
            'search_families' => $search_families,
            'flower' => null,
        ]);
    }
    

    /*
    * 科を指定した花の一覧表示
    */
    
    public function family(Request $request, $family_id) {
        
        $flowers = Family::find($family_id)->flowers()->orderBy('name', 'asc')->get();
        $families = $this->getFamilyList(
                                Family::orderBy('name', 'asc')
                                ->where('name', 'not like', '－')
                                ->get()
                            );
        $search_families = $this->getFamilyList(
                                Family::select('id','name')
                                ->where('name', 'not like', '－')
                                ->whereIn('id', Flower::select('family_id'))
                                ->orderBy('name', 'asc')
                                ->get()
                            );
                
        return view('flowers', [
            'flowers' => $flowers,
            'family_id' => $family_id,
            'families' => $families,
            'search_families' => $search_families,
            'flower' => null,
        ]);
    }
    
    /*
    * 花の登録
    */
    
    public function regist(Request $request) {
        
        $this->validate($request, [
            'name' => 'required|max:255',
            'family_id' => 'required',
        ]);
        
        $flower = new Flower;
        $flower->name = $request->name;
        $flower->family_id = $request->family_id;
        $flower->file_name = $request->file_name;
        $flower->save();
        
        if( $request->file('image') != null ){
            $request->file('image')->storeAs('images', $flower->id . '_' . $request->file_name, '');
        }
       
        return redirect('/flowers');
    }

    
    /*
    * 花の編集
    */
    public function edit(Request $request, Flower $flower)
    {
        //レコードを検索
        $flower = Flower::find($flower->id);
        
        $flowers = Flower::orderBy('name', 'asc')->get();
        $families = $this->getFamilyList(
                                Family::orderBy('name', 'asc')
                                ->where('name', 'not like', '－')
                                ->get()
                            );
        $search_families = $this->getFamilyList(
                                Family::select('id','name')
                                ->where('name', 'not like', '－')
                                ->whereIn('id', Flower::select('family_id'))
                                ->orderBy('name', 'asc')
                                ->get()
                            );

        //検索結果をビューに渡す
        return view('flowers', [
            'flower' => $flower,
            'flowers'  => $flowers,
            'families' => $families,
            'search_families' => $search_families,
            'family_id' => null,
        ]);
    }

    /*
    * 花の更新
    */
    public function update(Request $request, Flower $flower)
    {
        // レコードを検索
        $flower = Flower::find($flower->id);
        
        // ファイル上書き判定、前ファイルの削除
        if( $request->file('image') != null &&  $flower->file_name != null ){
            $request->file('image')->storeAs('images', $flower->id . '_' . $request->file_name, '');
            Storage::delete('/images/' . $flower->id . '_' . $flower->file_name);
        }
        
        $flower->name = $request->name;
        $flower->family_id = $request->family_id;
        $flower->file_name = $request->file_name;
        $flower->save();

        // ファイルの保存
        if( $request->file('image') != null ){
            $request->file('image')->storeAs('images', $flower->id . '_' . $request->file_name, '');
        }
        
        return redirect('/flowers');
    }
   
    /*
    * 花の削除
    */
    
    public function delete(Request $request, Flower $flower) {
 
        // ファイルの削除
        if( $flower->file_name != null ){
            Storage::delete('/images/' . $flower->id . '_' . $flower->file_name);
        }
        
        $flower->delete();
        
        return redirect('/flowers');
    }    
    
    private function getFamilyList($families) {
        foreach ($families as $family) {
            $family->name = $family->name . '科';
        }
        return $families;
    }
}
