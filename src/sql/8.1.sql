SELECT *, (SELECT contact_name || ' ' || customer_name FROM customers WHERE customers.customer_id = 1) AS fullName
FROM orders
WHERE customer_id = 1;


SELECT *
FROM orders, customers
WHERE orders.customer_id = 1;
