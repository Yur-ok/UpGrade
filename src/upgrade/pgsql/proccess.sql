-- 1) Получить список активных процессов
SELECT *
FROM pg_stat_activity
WHERE state = 'active';

-- 2) Получить список текущих блокировок
SELECT *
FROM pg_locks
         JOIN
     pg_stat_activity
     ON pg_locks.pid = pg_stat_activity.pid
where pg_locks.granted IS TRUE;

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