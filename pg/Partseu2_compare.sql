with t1 as (
select "C1" from import1
union all
select "C1" from import2),
t2 as(
select "C1" from import21
union all
select "C1" from import22)
select * from
(select distinct "C1" from t1) tt1
left join
(select distinct "C1" from t2) tt2
on tt1."C1" = tt2."C1"
WHERE tt2."C1" is null;

