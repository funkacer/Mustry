with t1 as (
select id, "C1", "C2", "C8", "C25", row_number() OVER () as row_id from import41)
select * from t1 where (select max(row_id) from t1) - row_id < 5;