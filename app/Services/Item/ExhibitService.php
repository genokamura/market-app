<?php

namespace App\Services\Item;

use App\Models\Category;
use App\Models\Item;
use App\Models\Image;

class ExhibitService
{
    private $categories;

    public function __construct()
    {
        //
    }

    public function getCategories()
    {
        return Category::all();
    }

    public function exhibitItem($param)
    {
        $this->categories = $this->getCategories();
        $sellerId = auth()->user()->id;
        $param['seller_id'] = $sellerId;
        $res = Item::register($param);

        foreach($param['categories'] as $category) {
            $cat = $this->categories->where('slug', $category)->first();
            if ($cat) {
                $res->addCategory($cat);
            }
        }
        foreach($param['images'] as $i => $image) {
            Image::register($image, $res->id, $i === 0);
        }

        return $res;
    }
}

