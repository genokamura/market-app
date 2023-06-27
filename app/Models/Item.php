<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'price',
        'quantity',
        'description',
        'seller_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'item_categories');
    }

    public static function register($params): Self
    {
        $item = new Item();
        $item->fill($params);
        $item->save();
        return $item;
    }

    public function addCategory($category)
    {
        $this->categories()->attach($category->id);
    }
}
