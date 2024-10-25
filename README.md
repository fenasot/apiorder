# AsiaYo - Jr Backend Engineer 測驗

## laravel

### 路徑為 localhost:8080/api/orders

## SQL 

### 1
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

### 2

