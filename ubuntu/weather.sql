USE funkacernette;

DROP TABLE IF EXISTS weather;

CREATE TABLE weather (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    creatat DATETIME,
    changeat DATETIME,
    w_lon DECIMAL(7,4),
    w_lat DECIMAL(7,4),
    s_weather_id INT UNSIGNED,
    s_weather_main VARCHAR(255),
    s_weather_description VARCHAR(255),
    s_weather_icon VARCHAR(255),
    w_base VARCHAR(255),
    s_main_temp DECIMAL(5,2),
    s_main_feels_like DECIMAL(5,2),
    s_main_temp_min DECIMAL(5,2),
    s_main_temp_max DECIMAL(5,2),
    s_main_pressure INT UNSIGNED,
    s_main_humidity INT UNSIGNED,
    s_main_sea_level INT UNSIGNED,
    s_main_grnd_level INT UNSIGNED,
    s_visibility INT UNSIGNED,
    s_wind_speed DECIMAL(5,2),
    s_wind_deg INT UNSIGNED,
    s_wind_gust DECIMAL(5,2),
    s_clouds INT UNSIGNED,
    w_rain_1h DECIMAL(5,2),
    s_rain_3h DECIMAL(5,2),
    w_snow_1h DECIMAL(5,2),
    s_snow_3h DECIMAL(5,2),
    s_dt INT UNSIGNED,
    w_sys_type INT UNSIGNED,
    w_sys_id INT UNSIGNED,
    w_sys_country VARCHAR(255),
    w_sys_sunrise INT UNSIGNED,
    w_sys_sunset INT UNSIGNED,
    w_timezone INT UNSIGNED,
    w_id INT UNSIGNED,
    w_name VARCHAR(255),
    s_cod INT UNSIGNED,
    f_message INT UNSIGNED,
    f_cnt INT UNSIGNED,
    f_temp_kf DECIMAL(5,2),
    f_pop INT UNSIGNED,
    f_pod VARCHAR(255),
    f_dt_txt VARCHAR(255)
);

SELECT * FROM weather;

DESC weather;

SHOW CREATE TABLE weather;

SELECT MIN(`s_main_temp`), MAX(`s_main_temp`), MIN(`s_weather_main`), MAX(`s_weather_main`)
    FROM `weather` WHERE s_dt <= (SELECT s_dt FROM `weather` WHERE id = 1) + 86400;

SELECT MIN(`s_main_temp`) temp_min, MAX(`s_main_temp`) temp_max, MIN(`s_weather_main`) weather_min, MAX(`s_weather_main`) weather_max 
FROM `weather` WHERE s_dt <= (SELECT s_dt FROM `weather` WHERE id = 1) + 86400;

SELECT MIN(`s_main_temp`) temp_min, MAX(`s_main_temp`) temp_max,
	CASE
    WHEN min(`s_weather_id`) < 600 THEN "Rain"
    WHEN min(`s_weather_id`) >= 600 and min(`s_weather_id`) < 700 THEN "Snow"
    WHEN max(`s_weather_id`) >= 800 and max(`s_weather_id`) <= 803 THEN "Clear"
    ELSE "Clouds"
    END w_main
    FROM `weather` WHERE s_dt <= (SELECT s_dt FROM `weather` WHERE id = 1) + 86400;


SELECT MIN(`s_main_temp`) temp_min, MAX(`s_main_temp`) temp_max, 
CASE WHEN min(`s_weather_id`) < 600 THEN "Rain" 
WHEN min(`s_weather_id`) >= 600 and min(`s_weather_id`) < 700 THEN "Snow" 
WHEN max(`s_weather_id`) >= 800 and max(`s_weather_id`) <= 803 THEN "Clear" 
ELSE "Clouds" END w_main, 
date(DATE_ADD(now(), INTERVAL 2 DAY)) datum 
FROM `weather` WHERE `f_dt_txt` LIKE CONCAT(date(DATE_ADD(now(), INTERVAL 2 DAY)), '%');