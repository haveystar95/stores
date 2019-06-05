<?php

namespace App\Http\Controllers;

use App\Http\Responses\DatasetResponse;
use Illuminate\Http\Response;

/**
 * Class IndexController
 *
 * @package App\Http\Controllers\Api
 */
class IndexController extends Controller
{
    /**
     * @return Response
     */
    public function index() : Response
    {
        return response()->view('welcome');
    }

    /**
     * @return DatasetResponse
     */
    public function dataset() : DatasetResponse
    {
        return new DatasetResponse();
    }
}
