<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'item_id',
        'is_primary',
        'name',
        'path',
    ];

    protected $guarded = [
        'id',
    ];

    public static function register($file, $itemId, $isPrimary = false): Self
    {
        Storage::putFile('', $file);
        $image = new Image();
        $image->fill([
            'item_id' => intval($itemId),
            'name' => $file->getClientOriginalName(),
            'path' => $file->hashName(),
            'is_primary' => $isPrimary,
        ]);
        $image->save();
        return $image;
    }
}
