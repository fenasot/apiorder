<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrdersControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * OrdersController ordersCheck() 驗證Json格式是否正確功能(成功) 
     * 
     * @see \App\Http\Controllers\OrdersController
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckVaildJsonFormat()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2000,
            'currency' => 'TWD'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => '訂單檢查通過',
            ]);
    }

    /**
     * OrdersController ordersCheck() 驗證Json格式是否正確功能(資料為空) 
     * 
     * @see \App\Http\Controllers\OrdersController
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonEmpty()
    {
        $response = $this->postJson('/api/orders', [
            'id' => '',
            'name' => '',
            'address' => [
                'city' => '',
                'district' => '',
                'street' => ''
            ],
            'price' => 0,
            'currency' => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * OrdersController ordersCheck() 驗證Json格式是否正確功能(id 欄位缺失)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonFormatId()
    {
        $response = $this->postJson('/api/orders', [
            // 少了 id
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2000',
            'currency' => 'TWD'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['id']);
    }

    /**
     * OrdersController ordersCheck() 驗證Json格式是否正確功能(name 欄位缺失)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonFormatAddressName()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            // 少了 name
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2000',
            'currency' => 'TWD'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * OrdersController ordersCheck() 驗證Json格式是否正確功能(address.city 欄位缺失)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonFormatAddressCity()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                // 少了 city
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2000',
            'currency' => 'TWD'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['address.city']);
    }

    /**
     * OrdersController ordersCheck() 驗證Json格式是否正確功能(address.district 欄位缺失)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonFormatAddressDistrict()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                // 少了 district
                'street' => 'fuxing-south-road'
            ],
            'price' => '2000',
            'currency' => 'TWD'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['address.district']);
    }

    /**
     * OrdersController ordersCheck() 驗證Json格式是否正確功能(address.street 欄位缺失)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonFormatAddressStreet()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                // 少了street
            ],
            'price' => '2000',
            'currency' => 'TWD'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['address.street']);
    }

    /**
     * OrdersController ordersCheck() 驗證Json格式是否正確功能(price 欄位缺失)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonFormatPrice()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            // 少了 price
            'currency' => 'TWD'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['price']);
    }

    /**
     * OrdersController ordersCheck() 驗證Json格式是否正確功能(currency 欄位缺失)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonFormatCurrency()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => '2000',
            // 少了 currency
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['currency']);
    }


    /**
     * OrdersController ordersCheck() 驗證Json資料內容是否正確功能(name 欄位包含非英文字母或空格的字元)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonDataNameContainsOnlyEnglishLetters()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => '我Melody 愛 Ho人liday I人nn', // 內含非英文字母
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2000,
            'currency' => 'TWD'
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Name contains non-English characters',
            ]);
    }

    /**
     * OrdersController ordersCheck() 驗證Json資料內容是否正確功能(name 欄位每個單字首字母非大寫)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonDataNameIsNotCapitalized()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody holiday Inn', // holidat 開頭非大寫
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2000,
            'currency' => 'TWD'
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Name is not capitalized',
            ]);
    }

    /**
     * OrdersController ordersCheck() 驗證Json資料內容是否正確功能(price 欄位金額超過2000)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonDataPriceIsOverLimit()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2100, // 價格超過2000
            'currency' => 'TWD'
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Price is over 2000',
            ]);
    }

    /**
     * OrdersController ordersCheck() 驗證Json資料內容是否正確功能(currency 欄位
     * 貨幣格式不是 TWD 或 USD)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckInvaildJsonDataCurrencyFormatIsWrong()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 2000,
            'currency' => 'TDD' // 不是 TWD 或 USD
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Currency format is wrong',
            ]);
    }

    /**
     * OrdersController ordersCheck() 驗證Json資料內容是否正確功能(currency 欄位
     * 貨幣格式如果是 USD，將修改price金額並乘上固定匯率 31，並轉為TWD)
     */
    #[Test]
    public function testOrdersConotrollerOrdersCheckVaildJsonDataCurrencyChangeTwdToUsd()
    {
        $price = 20; // USD 價格

        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => $price,
            'currency' => 'USD'
        ]);

        $expectedPrice = $price * 31; // 預期轉為 TWD 的價格

        $response->assertStatus(200)
            ->assertJson([
                'message' => '訂單檢查通過',
                'data' => [
                    'price' => $expectedPrice,
                    'currency' => 'TWD'
                ]
            ]);
    }
}
