SELECT *,
       (SELECT contact_name || ' ' || customer_name
        FROM customers
        WHERE orders.customer_id = customers.customer_id) AS fullName
FROM orders;


SELECT orders.*, cust.fullName
FROM orders,
     (SELECT (contact_name || ' ' || customer_name) AS fullName, customer_id FROM customers) AS cust
WHERE orders.customer_id = cust.customer_id;
