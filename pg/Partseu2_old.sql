with t as (select 'import21' as a, count(*) as b from import21
union all
select 'import22' as a, count(*) as b from import22
union all
select 'shodne uplne' as a, -count(*) as b from (select * from import21) t1 join (select * from import22) t2 on t1."C1" = t2."C1" and t1."C2" = t2."C2"
and t1."C8" = t2."C8" and t1."C25" = t2."C25"
union all
select 'shodne krome ceny' as a, -count(*) as b from (select * from import21) t1 join (select * from import22) t2 on t1."C1" = t2."C1" and t1."C2" = t2."C2"
and (t1."C8" != t2."C8" or t1."C25" != t2."C25"))
select * from t
union all
select 'sum' as a, sum(b)
from t;

