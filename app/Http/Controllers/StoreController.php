<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function parseStore(Request $request)
    {
        $id = $request->get('id');
        return response()->json(['storeId' => $id]);
    }

    public function createStore(Request $request)
    {
       return app('StoreService')->createStore($request->all());

    }

    public function getStores()
    {
        return response(app('StoreService')->getStores());
    }

}
