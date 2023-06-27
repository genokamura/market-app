<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics/Computers',
            'Electronics/TV, Audio & Surveillance',
            'Electronics/Cameras & Accessories',
            'Electronics/Games & Consoles',
            'Electronics/Kitchen & Home Appliances',
            'Electronics/Other Electronics',
            'Vehicles/Cars',
            'Vehicles/Car Parts & Accessories',
            'Vehicles/Motorcycles & Scooters',
            'Vehicles/Vans & Buses',
            'Vehicles/Trucks & Trailers',
            'Vehicles/Auto Services',
            'Property/Houses & Apartments For Sale',
            'Property/Houses & Apartments For Rent',
            'Property/Land & Plots For Sale',
            'Property/Land & Plots For Rent',
            'Property/Commercial Property For Sale',
            'Property/Commercial Property For Rent',
            'Property/Event centres & Venues',
            'Property/Short Lets',
            'Property/Hotels & Guest Houses',
            'Property/Other Property',
            'Fashion/Clothing & Shoes',
            'Fashion/Watches & Jewellery',
            'Fashion/Bags',
            'Fashion/Health & Beauty',
            'Fashion/Accessories',
            'Home, Garden & Kids/Furniture & Garden',
            'Home, Garden & Kids/Home Appliances',
            'Home, Garden & Kids/Kitchen & Dining',
            'Home, Garden & Kids/Decor, Garden & Accesories',
            'Home, Garden & Kids/Children & Baby Items',
            'Home, Garden & Kids/Toys',
            'Home, Garden & Kids/Other Items',
            'Sports, Arts & Outdoors/Sports & Fitness Equipment',
            'Sports, Arts & Outdoors/Books & Games',
            'Sports, Arts & Outdoors/Musical Instruments',
            'Sports, Arts & Outdoors/Arts & Crafts',
            'Sports, Arts & Outdoors/CDs, DVDs & Records',
            'Sports, Arts & Outdoors/Tickets & Vouchers',
            'Sports, Arts & Outdoors/Other Items',
            'Mobile Phones & Tablets/Mobile Phones',
            'Mobile Phones & Tablets/Tablets',
            'Mobile Phones & Tablets/Accessories for Mobile Phones & Tablets',
            'Mobile Phones & Tablets/Electronics',
            'Mobile Phones & Tablets/TV & DVD Equipment',
            'Mobile Phones & Tablets/Video Games & Consoles',
            'Mobile Phones & Tablets/Other Electronics',
        ];
        Category::factory()
            ->count(count($categories))
            ->sequence(fn ($sequence) => [
                'name' => $categories[$sequence->index],
            ])
            ->create();
    }
}
