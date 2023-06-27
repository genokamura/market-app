<?php

namespace Tests\Unit\Item;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class ItemTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function itemCanBeCreatedFromFactory()
    {
        $item = Item::factory()->create();
        $this->assertInstanceOf(Item::class, $item);
    }

    /**
     * @test
     */
    public function canRegisterItem()
    {
        $user = User::factory()->create();

        $params = [
            'name' => 'Item 1',
            'description' => 'Item 1 description',
            'price' => 1000,
            'quantity' => 10,
            'seller_id' => $user->id,
        ];
        $item = Item::register($params);

        $this->assertDatabaseHas('items', $params);
    }

    /**
     * @test
     */
    public function canAddCategoryToItem()
    {
        $item = Item::factory()->create();
        $category = Category::factory()->create();
        $item->addCategory($category);

        $this->assertDatabaseHas('item_categories', [
            'item_id' => $item->id,
            'category_id' => $category['id'],
        ]);
    }
}
