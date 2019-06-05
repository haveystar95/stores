<?php
/**
 * Created by PhpStorm.
 * User: soloninadenis
 * Date: 2019-05-05
 * Time: 00:14
 */

namespace App\Http\Controllers;


class TestController extends Controller
{
    public function test()
    {
        return response()->json(['dd'=>'sf']);
    }

}
