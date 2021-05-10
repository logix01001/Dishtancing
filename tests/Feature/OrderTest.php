<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_OrderSuccess()
    {
        $productData = [
            "product_id" => 1,
            "quantity" => 2
        ];

        $this->json('POST', 'api/order',  $productData, ['Accept' => 'application/json','Authorization'=> 'Bearer 9|DZ10PpjAHgx8Ez7kH9husUoQE5V3a6VMx86v1ZAa'])
            ->assertStatus(201)
            ->assertJson([
                "message" => "You have successfully ordered this product"
            ]);
    }

    public function test_OrderFailed()
    {

        $productData = [
            "product_id" => 1,
            "quantity" => 6
        ];
        $this->json('POST', 'api/order',$productData, ['Accept' => 'application/json','Authorization'=> 'Bearer 9|DZ10PpjAHgx8Ez7kH9husUoQE5V3a6VMx86v1ZAa'])
            ->assertStatus(400)
            ->assertJson([
                "message" => "Failed to order this product due to unavailability of the stock"
            ]);
    }
}
