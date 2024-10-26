<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{

    // 驗證資料格式的 Class
    protected $orderService;

    /**
     * 依賴注入 orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Api 驗證資料
     */
    function ordersCheck(Request $request)
    {
        // 驗證 Json 格式
        $validated = $request->validate([
            'id' => 'required|string',
            'name' => 'required|string',
            'address.city' => 'required|string',
            'address.district' => 'required|string',
            'address.street' => 'required|string',
            'price' => 'required|numeric',
            'currency' => 'required|string|size:3', // 限制長度3
        ]);

        $data = $request->json()->all();

        // 檢查資料內容是否正確
        try {
            $result = $this->orderService->checkJson($data);
        } catch (\Exception $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return response()->json(['message' => '發生意外錯誤，請重試'], 500); // 屏蔽意外錯誤資訊
        }

        if ($result['status'] === 'error') {
            return response()->json($result, 400); // 失敗回傳失敗原因
        }

        return response()->json($result, 200); // 成功就回傳 data
    }
}
