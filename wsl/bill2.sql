SET ROLE funka;

CREATE TABLE public.bill2 (id SERIAL, month DATE, type varchar(1), amount INTEGER);

INSERT INTO public.bill2 (month,type, amount) VALUES
('2021-01-01', 'M', 2000),
('2021-01-01', 'F', 1200),
('2021-01-02', 'M', 3000),
('2021-01-02', 'F', 1500),
('2021-01-02', 'F', 2200),
('2021-01-03', 'M', 1800);

update public.bill2 SET amount = 2000 WHERE amount = 2200; --potrebuju 2 stejne hodnoty