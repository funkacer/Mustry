--with t1 AS (SELECT EXTRACT(YEAR FROM now()) AS rok, EXTRACT(MONTH FROM now()) AS mesic, generate_series(0,100) as posun_zpet)
--with t1 AS (SELECT 2023 AS rok, 3 AS mesic, generate_series(0,100) as posun_zpet)

with t1 AS (SELECT EXTRACT(YEAR FROM now()) AS rok, EXTRACT(MONTH FROM now()) AS mesic, generate_series(0,22) as posun_zpet)

/*SELECT rok,
	mesic,
	posun_zpet,
	rok - FLOOR((12 - mesic + posun_zpet) / 12) AS rok_zpet,
	12 - (12 - mesic + posun_zpet) % 12 AS mesic_zpet
	from t1;

SELECT rok,
	mesic,
	posun_zpet,
	EXTRACT(YEAR FROM date(concat(rok::varchar, '-', mesic::varchar, '-01')) - interval '1 month' * posun_zpet) AS rok_zpet,
	EXTRACT(MONTH FROM date(concat(rok::varchar, '-', mesic::varchar, '-01')) - interval '1 month' * posun_zpet) AS mesic_zpet
	from t1;

SELECT rok,
	mesic,
	posun_zpet,
	EXTRACT(YEAR FROM date(concat(rok::varchar, '-', mesic::varchar, '-01')) - CAST(posun_zpet || ' month' AS Interval)) AS rok_zpet,
	EXTRACT(MONTH FROM date(concat(rok::varchar, '-', mesic::varchar, '-01')) - CAST(posun_zpet || ' month' AS Interval)) AS mesic_zpet
	from t1;
*/

SELECT rok,
	mesic,
	posun_zpet,
	EXTRACT(YEAR FROM date(concat(rok::varchar, '-', mesic::varchar, '-01')) - concat(posun_zpet, ' month')::Interval) AS rok_zpet,
	EXTRACT(MONTH FROM date(concat(rok::varchar, '-', mesic::varchar, '-01')) - concat(posun_zpet, ' month')::Interval) AS mesic_zpet
	from t1;