<?php

namespace App\Services;

use Illuminate\Http\Exceptions\HttpResponseException;

class OrderService implements OrderServiceInterface
{
    const USD_TO_TWD_RATE = 31; // USD 轉 TWD 的固定匯率

    /**
     * 驗證json資料內容是否正確，並轉換部分資料為統一的格式
     * 
     * @param array $data
     * @throw HttpResponseException
     */
    public function checkJson(array $data): array
    {
        // 檢查 name 是否只包含英文字母與空格
        if (isset($data['name']) && !$this->containsOnlyEnglishLetters($data['name'])) {
            return [
                'status' => 'error',
                'message' => 'Name contains non-English characters',
            ];
        }

        // 檢查 name 單字開頭是否大寫
        if (isset($data['name']) && !$this->isEachWordCapitalized($data['name'])) {
            return [
                'status' => 'error',
                'message' => 'Name is not capitalized',
            ];
        }

        // 檢查 currency 是否是 TWD 或 USD
        if (isset($data['currency']) && !$this->isUsdOrTwd($data['currency'])) {
            return [
                'status' => 'error',
                'message' => 'Currency format is wrong',
            ];
        }

        // 如果是 USD，將金額與貨幣欄位都轉換為 TWD 的格式
        if (isset($data['currency']) && $data['currency'] == 'USD') {
            $data['price'] = $this->ChangePriceFromUsdToTwd($data['price']);
            $data['currency'] = 'TWD';
        }

        // 檢查 price 金額是否不超過 2000 且不小於 0 (包含轉換後)
        if (isset($data['price']) && !$this->isOverLimitPrice($data['price'])) {
            return [
                'status' => 'error',
                'message' => 'Price is over 2000',
            ];
        }

        return [
            'status' => 'success',
            'message' => '訂單檢查通過',
            'data' => $data
        ];
    }

    /**
     * 檢查是否只包含英文字母與空格
     * 
     * @param string $string
     * @return bool
     */
    private function containsOnlyEnglishLetters(string $string): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $string) === 1;
    }

    /**
     * 檢查每個單字是否都是大寫開頭
     * 
     * @param string $string
     * @return bool
     */
    private function isEachWordCapitalized(string $string): bool
    {
        $words = explode(' ', $string);

        foreach ($words as $word) {
            if (!preg_match('/^[A-Z]/', $word)) {
                return false; // 不是開頭大寫就 false
            }
        }
        return true;
    }

    /**
     * 檢查金額是否大於 2000 且不小於 0
     * 
     * @param float $price
     * @return bool
     */
    private function isOverLimitPrice(float $price): bool
    {
        return $price <= 2000 && $price >= 0;
    }

    /**
     * 檢查是否是 USD 或 TWD
     * 
     * @param string $string
     * @return bool
     */
    private function isUsdOrTwd(string $string): bool
    {
        $validCurrencies = ['TWD', 'USD'];

        return in_array($string, $validCurrencies);
    }

    /**
     * 將金額從 USD 轉換為 TWD
     * 
     * @param float $price
     * @return float
     */
    private function ChangePriceFromUsdToTwd(float $price): float
    {
        return $price * self::USD_TO_TWD_RATE;
    }

    /**
     * 執行並回傳結果
     * 
     * @param string $message 錯誤訊息
     * @param int $httpStatusCode Https 狀態碼
     */
    private function jsonResponse(string $message, int $httpStatusCode)
    {
        throw new HttpResponseException(response()->json([
            'message' => $message,
        ], $httpStatusCode));
    }
}
