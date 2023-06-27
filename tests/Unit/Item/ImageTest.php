<?php

namespace Tests\Unit\Item;

use App\Models\Image;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Helpers\UploadFileHelper;

class ImageTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function canRegisterImageWithIsPrimary()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'seller_id' => $user->id,
        ]);

        $file = UploadFileHelper::makeFakeImage('test.jpg');

        $image = Image::register($file, $item->id, true);

        $expected = [
            'id' => $image->id,
            'item_id' => $item->id,
            'name' => 'test.jpg',
            'path' => $file->hashName(),
            'is_primary' => true,
        ];

        $this->assertDatabaseHas('images', $expected);
        Storage::assertExists($file->hashName());
    }
    /**
     * @test
     */
    public function canRegisterImageWithIsNotPrimary()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'seller_id' => $user->id,
        ]);

        $file = UploadFileHelper::makeFakeImage('test.jpg');

        $image = Image::register($file, $item->id);

        $expected = [
            'id' => $image->id,
            'item_id' => $item->id,
            'name' => 'test.jpg',
            'path' => $file->hashName(),
            'is_primary' => false,
        ];

        $this->assertDatabaseHas('images', $expected);
        Storage::assertExists($file->hashName());
    }
}
