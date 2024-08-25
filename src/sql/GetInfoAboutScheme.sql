-- Получить списко всех таблиц
SELECT table_name
FROM information_schema.tables
WHERE table_schema = 'public';

-- Получить информацию о столбцах определенной таблицы
SELECT column_name, data_type, is_nullable, column_default
FROM information_schema.columns
WHERE table_name = 'goals';

-- Получить список всех индексов в таблице
SELECT
    indexname,
    indexdef
FROM
    pg_indexes
WHERE
    tablename = 'goals';

-- Получить информацию о внешних ключах
SELECT
    tc.table_name,
    kcu.column_name,
    ccu.table_name AS foreign_table_name,
    ccu.column_name AS foreign_column_name
FROM
    information_schema.table_constraints AS tc
        JOIN information_schema.key_column_usage AS kcu
             ON tc.constraint_name = kcu.constraint_name
                 AND tc.table_schema = kcu.table_schema
        JOIN information_schema.constraint_column_usage AS ccu
             ON ccu.constraint_name = tc.constraint_name
                 AND ccu.table_schema = tc.table_schema
WHERE tc.constraint_type = 'FOREIGN KEY' AND tc.table_name='tasks';

-- все таблицы и схемы в базе данных:
SELECT table_schema, table_name
FROM information_schema.tables
ORDER BY table_schema, table_name;

-- Получение информации о таблицах и их размере:
SELECT
    schemaname AS table_schema,
    relname AS table_name,
    pg_size_pretty(pg_total_relation_size(relid)) AS total_size,
    pg_size_pretty(pg_relation_size(relid)) AS table_size,
    pg_size_pretty(pg_total_relation_size(relid) - pg_relation_size(relid)) AS index_size
FROM pg_catalog.pg_statio_user_tables
ORDER BY pg_total_relation_size(relid) DESC;