SELECT *
FROM customers
WHERE customers.customer_id IN (SELECT customer_id
                                    FROM orders);


SELECT *
FROM customers
WHERE EXISTS (SELECT customer_id
              FROM orders
              WHERE orders.customer_id = customers.customer_id);