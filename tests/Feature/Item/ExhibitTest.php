<?php

use App\Models\User;
use Tests\Helpers\UploadFileHelper;

test('Route::post exhibitItem', function () {
    $user = User::factory()->create();

    $file = UploadFileHelper::makeFakeImage('test.jpg');
    $response = $this->actingAs($user)
                     ->post(route('item.exhibit.store'), [
                         'name' => 'test',
                         'description' => 'test',
                         'price' => 100,
                         'quantity' => 1,
                         'images' => [$file],
                         'categories' => [
                             0 => 'test1',
                             1 => 'test2',
                         ],
                     ]);

    $headerArr = explode('/', $response->headers->get('Location'));
    $createdId = end($headerArr);

    $response->assertStatus(302);
    $response->assertRedirect(route('item.exhibit.complete', ['id' => $createdId]));
});


test('Route::get exhibitComplete', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
                     ->get(route('item.exhibit.complete', ['id' => strval($user->id)]));

    $response->assertStatus(200);
});
