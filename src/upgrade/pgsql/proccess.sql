-- 1) Получить список активных процессов
SELECT *
FROM pg_stat_activity
WHERE state = 'active';

-- 2) Получить список текущих блокировок
SELECT *
FROM pg_locks;


-- 3) Получить список текущих эксклюзивных блокировок
SELECT *
FROM pg_locks
WHERE mode = 'ExclusiveLock';


-- 4) Получить список “тяжёлых” запросов и времени их
SELECT *, now() - query_start AS duration
FROM pg_stat_activity
WHERE state = 'active'
ORDER BY duration DESC
LIMIT 10;