WITH countries AS (SELECT *
                   FROM customers
                   WHERE country IN (SELECT country
                                     FROM customers
                                     WHERE country NOT LIKE '%a%'))
SELECT *
FROM countries
WHERE city LIKE '%a%'
ORDER BY country;