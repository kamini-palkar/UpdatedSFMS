<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.common.main');
    }


    public function storeSelectedMenuItemId(Request $request)
    {
        session()->forget('selected_menu_item_id');
        
        $menuItemId = $request->input('menuItemId');
        session()->put('selected_menu_item_id', $menuItemId);
        // session(['selected_menu_item_id' => $menuItemId]);
        $id=session('selected_menu_item_id');
        return response()->json(['success' => true, 'treecode' =>  '','id'=>$id]);
    }
}
