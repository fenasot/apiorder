# AsiaYo - Jr Backend Engineer 測驗

## laravel

### 啟動 ( 路徑為 `localhost:8080/api/orders` )

啟動環境後，即可使用 `localhost:8080/api/orders` 執行 post 請求
``` cmd
docker-compose up -d
```

### 

### 設計風格

* 使用了 TDD 的方式來開發API功能
* 使用了 OOAD 中的 SOLID、OOP、KISS、YAGNI、DRY  原則


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
    o.currency = 'TWD' AND
    o.created_at >= '2023-05-01' AND
    o.created_at < '2023-06/01'
GROUP BY
    o.bnb_id
ORDER BY 
    may_amount DESC
LIMIT 10;
```

### 2.
    

