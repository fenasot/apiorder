# AsiaYo - Jr Backend Engineer 測驗

## laravel

### 啟動 ( 路徑為 `localhost:8080/api/orders` )

建立並啟動環境

``` cmd
docker-compose build
```

``` cmd
docker-compose up -d
```

提供了 `http://localhost:8080/api/test` 的api測試頁面，可使用該頁面測試 `http://localhost:8080/api/orders` 的 post 請求

這是提供的範例 json 資料
``` json
{
    "id": "A0000001",
    "name": "Melody Holiday Inn",
    "address": {
        "city": "taipei-city",
        "district": "da-an-district",
        "street": "fuxing-south-road"
    },
    "price": 2000,
    "currency": "TWD"
}

```

### 

### 設計風格

* 使用了 TDD 的方式來開發API功能。
* 使用了 OOAD 中的 SOLID、OOP、KISS、YAGNI、DRY  原則。
* SOILD 的部分使用了
    * SRP: 將業務邏輯與功能邏輯分開撰寫，Controller負責驗證Json資料完整性，以及https的狀態碼回傳，Service負責驗證資料內容的正確性，以及回傳驗證結果。
    * OCP: 使用了 Interface ，讓 orderservice 在之後需要擴充的情況下可不更改原有的程式碼。
    * DIP: 使用了依賴注入的方式注入了 OrderService。

* KISS 原則: 在撰寫Api時，若不需要太複雜的邏輯，就盡量的使用較簡單的方式設計，不過度的追求完美的設計法則，導致降低程式碼的可讀性，以及過多開發成本。
* YAGNI 原則: 不考慮未來不確定的需求，而實作目前不需要的功能，但保留了未來需要時可快速擴充的可能性。
* DRY 原則: 重複的部分若條件允許，我一定會包成function，以便後續的維護與提高可讀性
* Guard Code: 將嵌套邏輯全都優化，讓邏輯較複雜的判斷語句不會有多重嵌套，降低可讀性




## SQL 題目 

### 1.
``` sql
SELECT 
    o.bnb_id,
    o.bnb_name,
    SUN(o.amount) AS may_amount
FROM 
    orders o
WHERE 
    o.currency = 'TWD' 
    AND o.created_at >= '2023-05-01'
    AND o.created_at < '2023-06/01'
GROUP BY
    o.bnb_id
ORDER BY 
    may_amount DESC
LIMIT 
    10;
```

### 2.

1. 首先我會先嘗試改為CTE的寫法
```SQL
WITH MayOrders AS (
    SELECT 
        o.bnb_id,
        o.bnb_name,
        SUM(amount) AS may_amount
    FROM 
        orders o
    WHERE 
        o.order_date BETWEEN '2023-05-01' AND '2023-05-31'
        AND currency = 'TWD'
    GROUP BY 
        bnb_id,
        bnb_name
)
SELECT 
    *
FROM 
    MayOrders
ORDER BY 
    may_amount DESC
LIMIT 
    10;
```

2. 之後直接檢查常用的搜尋欄位是否有設定索引

3. 確認或設定完後，使用EXPLAIN確認那些欄位的rows過大，並進一步確認欄位的Extar內是否有filesort

4. 若rows過大，可能需要對搜尋範圍再添加額外的限制，若有filesort，就可考慮將該欄位添加索引，或是考慮複合索引的可能性

5. 最後再尋找是否還有正規化的可能性，將低資料表內，單一資料的長度