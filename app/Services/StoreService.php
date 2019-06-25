<?php


namespace App\Services;


use App\Models\Link;
use App\Models\Store;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

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

    public function getStores($id)
    {
        if ($id) {
            return Store::find($id)->with('links.parsers')->get();
        }
        return Store::all();
    }

    public function checkPattern($link)
    {
        $url = $link['url'];

        $client = new Client();
        $response = $client->get($url);

        if ($response->getStatusCode() == 200) {
            $body = (string)$response->getBody()->getContents();
        } else {
            return ['error' => ''];
        }

        function build_sorter($key)
        {
            return function ($a, $b) use ($key) {
                return strnatcmp($a[$key], $b[$key]);
            };
        }

        $parsers = $link['parsers'];
        usort($link['parsers'], build_sorter('level'));


        foreach ($parsers as $key => $parser) {
            if ($parser['is_body_content']) {
                $bodyMainArray = $this->parseQuickProducts($body, $parser['pattern'], 1);
                $result['bodyMain'] = $bodyMainArray;
                unset($parsers[$key]);
                break;
            }

        }

        $searchPatterns = [];
        foreach ($parsers as $parser) {

            if ($parser['look_at_main'] == true) {
                $result[$parser['level']][] = $this->parseQuickProducts($body, $parser['pattern'], $parser['property'],
                    $parser['field']);
            } else {
                $searchPatterns[$parser['field']] = ['pattern' => $parser['pattern'], 'attr' => $parser['property']];
            }
        }
         return $this->parseQuickProducts($bodyMainArray, $searchPatterns);

    }

    public function parseQuickProducts($body, $pattern, $property = null, $field = 'main')
    {
        $response = [];

        if (!is_null($property)) {
            $crawler = new Crawler($body);
            $filter = $crawler->filter($pattern);
            if ($filter->count() > 0) {
                foreach ($filter as $key => $value) {
                    $result[] = $value;
                }

            }
            return $result;
        } else {
            foreach ($body as $key => $domEl) {
                $_crawler = new Crawler($domEl);
               foreach ($pattern as $field => $params) {
                   if (is_null($params['attr'])) {
                       $response[$key][$field] = $_crawler->filter($params['pattern'])->text();
                   } else {
                       $response[$key][$field] = $_crawler->filter($params['pattern'])->attr($params['attr']);
                   }

               }
            }
        }


        return $response;
    }

    public function saveStoreSettings($data)
    {

//        unset($data['links'][0]['parsers']);

        $store = Store::find($data['id']);
        $store->name = $data['name'];
        $store->url = $data['url'];
        $store->description = $data['description'];
        $store->save();
        $this->saveLinkSettings($data['links']);

    }

    public function saveLinkSettings($data)
    {
        foreach ($data as $linkData) {
            $parsers = $linkData['parsers'];
            unset($linkData['parsers']);
            $linkId = $linkData['id'] ?? null;
            $link = Link::updateOrCreate(['id' => $linkId], $linkData);
            foreach ($parsers as $parser) {
                $parseId = $parser['id'] ?? null;
                $link->parsers()->updateOrCreate([ 'id' => $parseId], $parser);
            }

        }

    }

    public function saveParserSettings()
    {

    }
}
