SELECT *
FROM customers
WHERE customers.customer_id NOT IN (SELECT customer_id
                                    FROM orders);


SELECT *
FROM customers
WHERE EXISTS (SELECT customer_id
              FROM orders);