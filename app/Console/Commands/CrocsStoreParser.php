<?php

namespace App\Console\Commands;

use App\Models\CrocsStore;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class CrocsStoreParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:parse';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $crocsCategoryPages = [
            'https://www.crocs.com/c/sale'
        ];
        foreach ($crocsCategoryPages as $categoryPage) {
            $pageContent = CrocsStore::getPageContentByUrl($categoryPage);
            $allItemsLink = CrocsStore::findViewAllLink($pageContent);
            $allItemsPageContent = CrocsStore::getPageContentByUrl($allItemsLink);
            $productLinks = CrocsStore::getProductLinksAndPrices($allItemsPageContent);
            $products = [];
            foreach ($productLinks as $productLink) {
                $products[] = CrocsStore::parseProduct($productLink);
                print_r($products);
            }
            //@TODO formating and save products to db
        }
    }
}
