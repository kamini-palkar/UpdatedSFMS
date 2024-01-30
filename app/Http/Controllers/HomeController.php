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
        $menuItemId = $request->input('menuItemId');
       
        session()->forget('selected_menu_item_id');
        session(['selected_menu_item_id' => $menuItemId]);

        return response()->json(['success' => true, 'treecode' => '']);
    }
}
