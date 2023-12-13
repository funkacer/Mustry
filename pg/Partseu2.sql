with t1 as (
select "C1" from import1
union all
select "C1" from import2),
t2 as(
select "C1" from import21
union all
select "C1" from import22),
t as (select 'import21' as a, count(*) as b from import21
union all
select 'import22' as a, count(*) as b from import22
union all
select 'shodne uplne' as a, -count(*) as b from (select * from import21) t1 join (select * from import22) t2 on t1."C1" = t2."C1" and t1."C2" = t2."C2"
and t1."C8" = t2."C8" and t1."C25" = t2."C25"
union all
select 'shodne krome ceny' as a, -count(*) as b from (select * from import21) t1 join (select * from import22) t2 on t1."C1" = t2."C1" and t1."C2" = t2."C2"
and (t1."C8" != t2."C8" or t1."C25" != t2."C25")
union all
select 'z minula' as a, count(*) as b from
(select distinct "C1" from t1) tt1
left join
(select distinct "C1" from t2) tt2
on tt1."C1" = tt2."C1"
WHERE tt2."C1" is null)
select * from t
union all
select 'sum' as a, sum(b)
from t;

