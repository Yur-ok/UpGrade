-- Получить список столбцов таблицы
SELECT column_name, data_type, is_nullable, character_maximum_length
FROM information_schema.columns
WHERE table_name = 'goals';


--Получить первичный ключ таблицы goals
SELECT a.attname AS column_name
FROM pg_index i
         JOIN pg_attribute a ON a.attnum = ANY (i.indkey)
WHERE i.indrelid = 'goals'::regclass
  AND i.indisprimary;


-- Получить название поле для связи двух таблиц, имеющих ограничение целостности в виде внешнего ключа
SELECT tc.constraint_name,
       kcu.column_name AS foreign_key_column,
       ccu.table_name  AS foreign_table_name,
       ccu.column_name AS foreign_column_name
FROM information_schema.table_constraints AS tc
         JOIN
     information_schema.key_column_usage AS kcu
     ON tc.constraint_name = kcu.constraint_name
         JOIN
     information_schema.constraint_column_usage AS ccu
     ON ccu.constraint_name = tc.constraint_name
WHERE tc.constraint_type = 'FOREIGN KEY'
  AND tc.table_name = 'tasks';
