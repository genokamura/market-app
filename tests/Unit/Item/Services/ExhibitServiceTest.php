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
    public function testExhibitItem()
    {
        $user = User::factory()->create();
        $category = Category::first();
        $file = UploadFileHelper::makeFakeImage('test.jpg');

        $params = [
            'name' => 'test',
            'description' => 'test',
            'price' => 100,
            'quantity' => 1,
            'images' => [$file],
            'categories' => [
                [
                    'slug' => $category->slug,
                ],
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
    }
}
