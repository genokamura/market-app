<?php

namespace Tests\Unit\Item\Services;

use App\Models\Category;
use App\Models\User;
use App\Services\Item\ExhibitService;
use Tests\TestCase;
use Tests\Helpers\UploadFileHelper;

class ExhibitServiceTest extends TestCase
{
    protected $exhibitService;

    public function setUp(): void
    {
        parent::setUp();
        $this->exhibitService = new ExhibitService();
    }

    /**
     * @test
     */
    public function testExhibitItemWithOneImageAndOneCategory()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $file = UploadFileHelper::makeFakeImage('test.jpg');

        $params = [
            'name' => 'test',
            'description' => 'test',
            'price' => 100,
            'quantity' => 1,
            'images' => [$file],
            'categories' => [
                $category->slug,
            ],
        ];

        $result = $this->actingAs($user)->exhibitService->exhibitItem($params);

        // assert
        $this->assertDatabaseHas('items', [
            'name' => 'test',
            'description' => 'test',
            'price' => 100,
            'quantity' => 1,
            'seller_id' => $user->id,
        ]);

        $this->assertDatabaseHas('item_categories', [
            'item_id' => $result->id,
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('images', [
            'item_id' => $result->id,
            'name' => 'test.jpg',
            'path' => $file->hashName(),
            'is_primary' => true,
        ]);
    }

    /**
     * @test
     */
    public function testExhibitItemWithMultipleImagesAndMultipleCategories()
    {
        $user = User::factory()->create();
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        $file1 = UploadFileHelper::makeFakeImage('test1.jpg');
        $file2 = UploadFileHelper::makeFakeImage('test2.jpg');
        $file3 = UploadFileHelper::makeFakeImage('test3.jpg');


        $params = [
            'name' => 'test',
            'description' => 'test',
            'price' => 100,
            'quantity' => 1,
            'images' => [
                $file1,
                $file2,
                $file3,
            ],
            'categories' => [
                $category1->slug,
                $category2->slug,
            ],
        ];

        $result = $this->actingAs($user)->exhibitService->exhibitItem($params);

        // assert
        $this->assertDatabaseHas('items', [
            'name' => 'test',
            'description' => 'test',
            'price' => 100,
            'quantity' => 1,
            'seller_id' => $user->id,
        ]);

        $this->assertDatabaseHas('item_categories', [
            'item_id' => $result->id,
            'category_id' => $category1->id,
        ]);
        $this->assertDatabaseHas('item_categories', [
            'item_id' => $result->id,
            'category_id' => $category2->id,
        ]);

        $this->assertDatabaseHas('images', [
            'item_id' => $result->id,
            'name' => 'test1.jpg',
            'path' => $file1->hashName(),
            'is_primary' => true,
        ]);
        $this->assertDatabaseHas('images', [
            'item_id' => $result->id,
            'name' => 'test2.jpg',
            'path' => $file2->hashName(),
            'is_primary' => false,
        ]);
        $this->assertDatabaseHas('images', [
            'item_id' => $result->id,
            'name' => 'test3.jpg',
            'path' => $file3->hashName(),
            'is_primary' => false,
        ]);
    }
}
