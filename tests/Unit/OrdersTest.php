<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    // /**
    //  * @test
    //  * OrdersController ordersCheck 驗證功能測試
    //  */
    // public function testOrdersCheck()
    // {
    //     $response = $this->postJson('/api/orders', [
    //         'item' => 'Product Name',
    //         'quantity' => 2,
    //     ]);

    //     $response->assertStatus(201)
    //         ->assertJson([
    //             'message' => 'Order created successfully',
    //             'data' => [
    //                 'item' => 'hahaahhahaha',
    //                 'quantity' => 2,
    //             ],
    //         ]);
    // } 
}
