<?php

namespace App\Services;

class ParseProduct
{
    public $productPageContent;

    public function __construct($productPageContent)
    {
        $this->productPageContent = $productPageContent;
    }

    public function getTextByClassName($className)
    {
        $htmlTag = $this->productPageContent
            ->filter($className);
        if ($htmlTag->count() == 1) {
            return $htmlTag->text();
        } else {
            return $htmlTag;
        }
    }
}
