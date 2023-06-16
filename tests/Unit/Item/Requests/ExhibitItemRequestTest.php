<?php

namespace Tests\Unit\Item\Requests;

use App\Http\Requests\Item\ExhibitItemRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Tests\Helpers\UploadFileHelper;

class ExhibitItemRequestTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function passExhibitItemRequestValidation()
    {
        $request = new ExhibitItemRequest();

        $file = UploadFileHelper::makeFakeImage('test.jpg');

        $validator = Validator::make([
            'name' => 'test',
            'price' => 100,
            'description' => 'test',
            'quantity' => 1,
            'images' => [$file],
            'categories' => [
                [
                    'slug' => 'test',
                ],
                [
                    'slug' => 'test2',
                ],
            ],
        ], $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @test
     */
    public function failExhibitItemRequestValidation()
    {
        $request = new ExhibitItemRequest();

        $file = UploadFileHelper::makeFakeImage('test.jpg');

        $validator = Validator::make([
            'name' => '',
            'price' => '',
            'description' => '',
            'quantity' => '',
            'images' => [$file],
            'categories' => [
                [
                    'slug' => '',
                ],
                [
                    'slug' => '',
                ],
            ],
        ], $request->rules());

        $this->assertFalse($validator->passes());
    }
}

