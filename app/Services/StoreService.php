<?php


namespace App\Services;


use App\Models\Store;

class StoreService
{

    public function createStore($data)
    {
        $store = new Store();
        $store->name = $data['name'];
        $store->url = $data['url'];
        $store->description = $data['description'];
        $store->save();
        return $store;

    }

    public function getStores()
    {
        return Store::all();
    }
}
