<?php


namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class StoreController extends Controller
{
    public function parseStore(Request $request)
    {

        $pageUrl = 'https://ua.sportsdirect.com/outlet/adidas-outlet?promo_name=outlet-landing';
        if(!$pageUrl) {
            return response()->json($this->getActionStatus("ERROR", "Product page url not found."));
        }
        $errors = array();

        $result = $this->makeWebRequest($pageUrl, $errors);
        if(empty($errors)) {
            $response['content'] = $this->parseQuickProductsJson($result, '');
            $response['Status'] = 'SUCCESS';
            $response['Message'] = 'Products downloaded successfully';
        } else {
            $response['Errors'] = $errors;
            $response['Status'] = 'ERROR';
            $response['Message'] = "Error in fetching products from the url. Errors: " . implode('|', $errors);
        }
        return response()->json($response);



    }


    private function parseQuickProductsJson($result, $category) {
        $response = '';
        try {
            $crawler = new Crawler($result);
            $filter = $crawler->filter('ul.s-productscontainer2 > li');

            foreach ($filter as $i => $domElement) {
                $_crawler = new Crawler($domElement);

                $arr[$i] = array(
                    'productName' => $_crawler->filter('p.product-title')->text(),
                    'productUrl' => $_crawler->filter('a.noUdLine')->attr('href'),
                    'imageUrl' => $_crawler->filter('input.compareImg')->attr('value'),
                    'offerPrice' => $_crawler->filter('span.product-price')->text(),
                    'inStock' => $_crawler->filter('span.badge-soldout')->count() > 0 ? false : true,
                    'size' => $_crawler->filter('span.attr-value')
                );
            }
        } catch (\Exception $ex) {
        }
        return $arr;
    }

    /**
     * Make web request to affiliate server url
     * @param String $url
     */
    private function makeWebRequest($url, &$errors) {
        $client = new Client();
        $response = $client->get($url);

        if($response->getStatusCode() == 200) {
            return (string)$response->getBody();
        } else {
            array_push($errors, $response->getReasonPhrase());
            return;
        }
    }


    public function createStore(Request $request)
    {
       return app('StoreService')->createStore($request->all());

    }

    public function getStores(Request $request)
    {
        $id = $request->id ?? null;
        return response(app('StoreService')->getStores($id));
    }

    public function checkPattern(Request $request)
    {
        $link = $request->link;
        return response(app('StoreService')->checkPattern($link));
    }


    public function saveStoreSettings(Request $request)
    {
        $saveData = $request->all();
        return response(app('StoreService')->saveStoreSettings($saveData));

    }

}
