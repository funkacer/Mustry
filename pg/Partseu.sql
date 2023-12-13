with t as (select 'import1' as a, count(*) as b from import1
union all
select 'import2' as a, count(*) as b from import2
union all
select 'shodne uplne' as a, -count(*) as b from (select * from import1) t1 join (select * from import2) t2 on t1."C1" = t2."C1" and t1."C2" = t2."C2"
and t1."C8" = t2."C8" and t1."C25" = t2."C25"
union all
select 'shodne krome ceny' as a, -count(*) as b from (select * from import1) t1 join (select * from import2) t2 on t1."C1" = t2."C1" and t1."C2" = t2."C2"
and (t1."C8" != t2."C8" or t1."C25" != t2."C25"))
select * from t
union all
select 'sum' as a, sum(b)
from t;

