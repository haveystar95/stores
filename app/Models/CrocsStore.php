<?php

namespace App\Models;

use App\Services\ParseProduct;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\DomCrawler\Crawler;

class CrocsStore extends Model
{
    const VIEW_ALL_TAG = 'a.view-all';
    const PRODUCT_LINK_TAG = 'li.cx-productcard-list-item > div.cx-productcard > a.cx-productcard-link';
    const PRODUCT_FULL_PRICE = 'li.cx-productcard-list-item > div.cx-productcard > a.cx-productcard-link > div.cx-productcard-main > div.cx-productcard-price > div.cx-price.text-gray-dark > s.cx-price-msrp > span.cx-price-value';
    const PRODUCT_DISCOUNT_PRICE = 'li.cx-productcard-list-item > div.cx-productcard > a.cx-productcard-link > div.cx-productcard-main > div.cx-productcard-price > div.cx-price.text-gray-dark > div.cx-price-current.text-red > span.cx-price-current-low.js-price > span.cx-price-value';
    const PRODUCT_PROMO_MESSAGE = 'li.cx-productcard-list-item > div.cx-productcard > a.cx-productcard-link > div.cx-productcard-main > div.cx-productcard-promos > div.cx-productcard-promo > span.cx-productcard-promo-message';
    protected $fillable = [
        'id',
        'name',
        'url',
        'full_price',
        'discount_price',
        'gender'
    ];

    /**
     * Get page content by url
     *
     * @param string $link
     * @return Crawler
     */
    public static function getPageContentByUrl(string $link): Crawler
    {
        return new Crawler(file_get_contents($link));
    }

    /**
     * Find "view all" link
     *
     * @param Crawler $pageContent
     * @return string
     */
    public static function findViewAllLink(Crawler $pageContent): string
    {
        return $pageContent
            ->filter(self::VIEW_ALL_TAG)
            ->first()
            ->attr('href');
    }

    /**
     * Get products link with price and discount
     *
     * @param Crawler $allItemsPageContent
     * @return array
     */
    public static function getProductLinksAndPrices(Crawler $allItemsPageContent): array
    {
        $data['productLink'] = $allItemsPageContent
            ->filter(self::PRODUCT_LINK_TAG)
            ->each(function ($node) {
                return $node->attr('href');
            });
        $data['fullPrice'] = $allItemsPageContent
            ->filter(self::PRODUCT_FULL_PRICE)
            ->each(function ($node) {
                return $node->text();
            });
        $data['discountPrice'] = $allItemsPageContent
            ->filter(self::PRODUCT_DISCOUNT_PRICE)
            ->each(function ($node) {
                return $node->text();
            });
        $result = [];
        foreach ($data['productLink'] as $key => $productLink) {
            $result[$key]['productLink'] = $productLink;
            $result[$key]['fullPrice'] = $data['fullPrice'][$key];
            $result[$key]['discountPrice'] = $data['discountPrice'][$key];
        }
        return $result;
    }

    /**
     * Parse product info
     *
     * @param array $productLink
     * @return array
     */
    public static function parseProduct(array $productLink): array
    {
        $classNames = [
            'name' => 'div.product-page > div.cs_row > div.floatRight > h1.product-name.cx-brand-font',
            'getProductId' => 'dd#product-details > div > h3.cx-heading.cx-brand-font > div.smaller',
            'getAvailableSizesByGender' => 'ol > li:last-child > div.size-refine-sizes',
            'getAvailableColors' => 'ol > li:first-child > div > ul.color-refine-colors > li:first-child > ul',
            'getGender' => 'div.js-size-refine-sizes.size-refine-sizes > div.size-refine-label.cx-copy',
            'getPromoMessage' => 'div.product-page > div.cs_row > div:last-child > div.clearfix > div.product-promo.cx-copy.clear > span.redText'
        ];
        $crocsProduct = new ParseProduct(self::getPageContentByUrl($productLink['productLink']));
        foreach ($classNames as $key => $className) {
            $html = $crocsProduct->getTextByClassName($className);
            if (gettype($html) != 'string' && $html->count() > 1) {
                $productLink[$key] = $html->each(function ($node) {
                    return $node->text();
                });
            } else {
                $productLink[$key] = $crocsProduct->getTextByClassName($className);
            }
        }
        return $productLink;
    }
}
