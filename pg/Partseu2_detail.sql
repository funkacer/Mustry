select * from (select * from import21) t1 join (select * from import22) t2 on t1."C1" = t2."C1" and t1."C2" = t2."C2"
and (t1."C8" != t2."C8" or t1."C25" != t2."C25");

