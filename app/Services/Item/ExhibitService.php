<?php

namespace App\Services\Item;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class ExhibitService
{
    private $categories;

    public function __construct()
    {
        $this->categories = Category::all();
    }

    public function exhibitItem($param)
    {
        Log::info($param);
        $sellerId = auth()->user()->id;
        $param['seller_id'] = $sellerId;
        $res = Item::register($param);

        foreach($param['categories'] as $category) {
            if ($this->categories->where('slug', $category['slug'])->first()) {
                $res->addCategory($this->categories->where('slug', $category['slug'])->first());
            }
        }

        return $res;
    }
}

