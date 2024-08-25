-- Получить список всех текущих процессов
SELECT
    pid,
    usename,
    datname,
    application_name,
    client_addr,
    state,
    query
FROM
    pg_stat_activity;

-- Фильтрация процессов по конкретной базе данных
SELECT
    pid,
    usename,
    application_name,
    client_addr,
    state,
    query
FROM
    pg_stat_activity
WHERE
    datname = 'upgrade';

-- Получить информацию о процессах, выполняющихся более определенного времени
SELECT
    pid,
    usename,
    now() - query_start AS duration,
    state,
    query
FROM
    pg_stat_activity
WHERE
    state = 'active' AND
    now() - query_start > interval '2 minutes';

-- Получение информации о процессах, которые выполняются конкретным пользователем
SELECT
    pid,
    query,
    state,
    query_start
FROM
    pg_stat_activity
WHERE
    usename = 'root';

CREATE EXTENSION IF NOT EXISTS pg_stat_statements; --работет только в консоли

--Получение статистики по ресурсам, потребляемым запросами
SELECT
    pid,
    usename AS username,
    datname AS database_name,
    application_name,
    client_addr,
    client_hostname,
    client_port,
    backend_start,
    xact_start,
    query_start,
    state_change,
    state,
    backend_xid,
    backend_xmin,
    query,
    wait_event_type,
    wait_event
FROM
    pg_stat_activity;

--получения информации о блокировках
SELECT
    locktype,
    database,
    relation,
    page,
    tuple,
    virtualxid,
    transactionid,
    classid,
    objid,
    objsubid,
    virtualtransaction,
    pid,
    mode,
    granted
FROM
    pg_locks;
