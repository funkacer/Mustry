--
-- PostgreSQL database dump
--

-- Dumped from database version 14.7 (Ubuntu 14.7-0ubuntu0.22.04.1)
-- Dumped by pg_dump version 15.1

-- Started on 2023-03-16 17:05:18

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

-- *not* creating schema, since initdb creates it


ALTER SCHEMA public OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 214 (class 1259 OID 24587)
-- Name: Device; Type: TABLE; Schema: public; Owner: pos
--

CREATE TABLE public."Device" (
    "ID" integer NOT NULL,
    "KlientID" integer,
    nazev character varying,
    stav character varying,
    vytvoreno timestamp with time zone,
    posledni_aktivita timestamp with time zone,
    "HW_info" character varying,
    verze character varying
);


ALTER TABLE public."Device" OWNER TO pos;

--
-- TOC entry 213 (class 1259 OID 24586)
-- Name: Device_ID_seq; Type: SEQUENCE; Schema: public; Owner: pos
--

CREATE SEQUENCE public."Device_ID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Device_ID_seq" OWNER TO pos;

--
-- TOC entry 3359 (class 0 OID 0)
-- Dependencies: 213
-- Name: Device_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pos
--

ALTER SEQUENCE public."Device_ID_seq" OWNED BY public."Device"."ID";


--
-- TOC entry 212 (class 1259 OID 24577)
-- Name: Klient; Type: TABLE; Schema: public; Owner: pos
--

CREATE TABLE public."Klient" (
    "ID" integer NOT NULL,
    nazev character varying NOT NULL,
    stav character varying NOT NULL,
    "createdAt" timestamp with time zone DEFAULT now() NOT NULL
);


ALTER TABLE public."Klient" OWNER TO pos;

--
-- TOC entry 211 (class 1259 OID 24576)
-- Name: Klient_ID_seq; Type: SEQUENCE; Schema: public; Owner: pos
--

CREATE SEQUENCE public."Klient_ID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Klient_ID_seq" OWNER TO pos;

--
-- TOC entry 3360 (class 0 OID 0)
-- Dependencies: 211
-- Name: Klient_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pos
--

ALTER SEQUENCE public."Klient_ID_seq" OWNED BY public."Klient"."ID";


--
-- TOC entry 217 (class 1259 OID 24609)
-- Name: licence_cerpani; Type: TABLE; Schema: public; Owner: pos
--

CREATE TABLE public.licence_cerpani (
    "KlientID" integer NOT NULL,
    "Licence_typID" integer NOT NULL,
    "DatumOD" date NOT NULL,
    "DatumDO" date NOT NULL,
    stav character varying NOT NULL
);


ALTER TABLE public.licence_cerpani OWNER TO pos;

--
-- TOC entry 216 (class 1259 OID 24601)
-- Name: licence_typy; Type: TABLE; Schema: public; Owner: pos
--

CREATE TABLE public.licence_typy (
    "ID" integer NOT NULL,
    nazev character varying NOT NULL,
    popis character varying NOT NULL,
    stav character varying NOT NULL
);


ALTER TABLE public.licence_typy OWNER TO pos;

--
-- TOC entry 215 (class 1259 OID 24600)
-- Name: licence_typy_ID_seq; Type: SEQUENCE; Schema: public; Owner: pos
--

CREATE SEQUENCE public."licence_typy_ID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."licence_typy_ID_seq" OWNER TO pos;

--
-- TOC entry 3361 (class 0 OID 0)
-- Dependencies: 215
-- Name: licence_typy_ID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pos
--

ALTER SEQUENCE public."licence_typy_ID_seq" OWNED BY public.licence_typy."ID";


--
-- TOC entry 210 (class 1259 OID 16421)
-- Name: uzivatele; Type: TABLE; Schema: public; Owner: pos
--

CREATE TABLE public.uzivatele (
    "ID" integer NOT NULL,
    login character varying NOT NULL,
    password character varying NOT NULL,
    stav character varying NOT NULL,
    "createdAt" timestamp with time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.uzivatele OWNER TO pos;

--
-- TOC entry 209 (class 1259 OID 16420)
-- Name: uzivatele_id_seq; Type: SEQUENCE; Schema: public; Owner: pos
--

CREATE SEQUENCE public.uzivatele_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.uzivatele_id_seq OWNER TO pos;

--
-- TOC entry 3362 (class 0 OID 0)
-- Dependencies: 209
-- Name: uzivatele_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: pos
--

ALTER SEQUENCE public.uzivatele_id_seq OWNED BY public.uzivatele."ID";


--
-- TOC entry 3192 (class 2604 OID 24590)
-- Name: Device ID; Type: DEFAULT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public."Device" ALTER COLUMN "ID" SET DEFAULT nextval('public."Device_ID_seq"'::regclass);


--
-- TOC entry 3190 (class 2604 OID 24580)
-- Name: Klient ID; Type: DEFAULT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public."Klient" ALTER COLUMN "ID" SET DEFAULT nextval('public."Klient_ID_seq"'::regclass);


--
-- TOC entry 3193 (class 2604 OID 24604)
-- Name: licence_typy ID; Type: DEFAULT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public.licence_typy ALTER COLUMN "ID" SET DEFAULT nextval('public."licence_typy_ID_seq"'::regclass);


--
-- TOC entry 3188 (class 2604 OID 16424)
-- Name: uzivatele ID; Type: DEFAULT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public.uzivatele ALTER COLUMN "ID" SET DEFAULT nextval('public.uzivatele_id_seq'::regclass);


--
-- TOC entry 3349 (class 0 OID 24587)
-- Dependencies: 214
-- Data for Name: Device; Type: TABLE DATA; Schema: public; Owner: pos
--

COPY public."Device" ("ID", "KlientID", nazev, stav, vytvoreno, posledni_aktivita, "HW_info", verze) FROM stdin;
1	1	Device 1 pro Klient 1	funkcni	2023-03-13 13:13:13+01	2023-03-14 14:14:14+01	NUC	15.1
2	1	Device 2 pro Klient 1	funkcni	2023-03-23 13:13:13+01	2023-03-24 14:14:14+01	NUC	15.2
3	2	Device 1 pro Klienta 2	nefunkční	2023-03-27 13:13:13+02	2023-03-29 14:14:14+02	Umax	15.0
\.


--
-- TOC entry 3347 (class 0 OID 24577)
-- Dependencies: 212
-- Data for Name: Klient; Type: TABLE DATA; Schema: public; Owner: pos
--

COPY public."Klient" ("ID", nazev, stav, "createdAt") FROM stdin;
1	Název klienta 1	online	2023-03-14 09:23:55.622442+01
2	Název klienta 2	offline	2023-03-14 09:24:09.563235+01
3	Název klienta 3	neznámý	2023-03-16 14:16:35.005699+01
4	Název klienta 4	neznámý	2023-03-16 14:17:11.78066+01
5	Název klienta 5	neznámý	2023-03-16 14:17:15.875992+01
6	Název klienta 6	neznámý	2023-03-16 14:18:01.476484+01
7	Název klienta 7	neznámý	2023-03-16 14:18:01.476484+01
8	Název klienta 8	neznámý	2023-03-16 14:18:01.476484+01
9	Název klienta 9	neznámý	2023-03-16 14:18:01.476484+01
10	Název klienta 10	neznámý	2023-03-16 14:19:02.243837+01
11	Název klienta 11	neznámý	2023-03-16 14:19:02.243837+01
12	Název klienta 12	neznámý	2023-03-16 14:19:02.243837+01
13	Název klienta 13	neznámý	2023-03-16 14:19:02.243837+01
14	Název klienta 14	neznámý	2023-03-16 14:19:02.243837+01
15	Název klienta 15	neznámý	2023-03-16 14:19:02.243837+01
16	Název klienta 16	neznámý	2023-03-16 14:19:02.243837+01
17	Název klienta 17	neznámý	2023-03-16 14:19:02.243837+01
18	Název klienta 18	neznámý	2023-03-16 14:19:02.243837+01
19	Název klienta 19	neznámý	2023-03-16 14:19:02.243837+01
20	Název klienta 20	neznámý	2023-03-16 14:19:24.01253+01
21	Název klienta 21	neznámý	2023-03-16 14:19:24.01253+01
22	Název klienta 22	neznámý	2023-03-16 14:19:24.01253+01
23	Název klienta 23	neznámý	2023-03-16 14:19:24.01253+01
24	Název klienta 24	neznámý	2023-03-16 14:19:24.01253+01
25	Název klienta 25	neznámý	2023-03-16 14:19:24.01253+01
26	Název klienta 26	neznámý	2023-03-16 14:19:24.01253+01
27	Název klienta 27	neznámý	2023-03-16 14:19:24.01253+01
28	Název klienta 28	neznámý	2023-03-16 14:19:24.01253+01
29	Název klienta 29	neznámý	2023-03-16 14:19:24.01253+01
30	Název klienta 30	neznámý	2023-03-16 14:19:36.305167+01
31	Název klienta 31	neznámý	2023-03-16 14:19:36.305167+01
32	Název klienta 32	neznámý	2023-03-16 14:19:36.305167+01
33	Název klienta 33	neznámý	2023-03-16 14:19:36.305167+01
34	Název klienta 34	neznámý	2023-03-16 14:19:36.305167+01
35	Název klienta 35	neznámý	2023-03-16 14:19:36.305167+01
36	Název klienta 36	neznámý	2023-03-16 14:19:36.305167+01
37	Název klienta 37	neznámý	2023-03-16 14:19:36.305167+01
38	Název klienta 38	neznámý	2023-03-16 14:19:36.305167+01
39	Název klienta 39	neznámý	2023-03-16 14:19:36.305167+01
40	Název klienta 40	neznámý	2023-03-16 14:19:50.127062+01
41	Název klienta 41	neznámý	2023-03-16 14:19:50.127062+01
42	Název klienta 42	neznámý	2023-03-16 14:19:50.127062+01
43	Název klienta 43	neznámý	2023-03-16 14:19:50.127062+01
44	Název klienta 44	neznámý	2023-03-16 14:19:50.127062+01
45	Název klienta 45	neznámý	2023-03-16 14:19:50.127062+01
46	Název klienta 46	neznámý	2023-03-16 14:19:50.127062+01
47	Název klienta 47	neznámý	2023-03-16 14:19:50.127062+01
48	Název klienta 48	neznámý	2023-03-16 14:19:50.127062+01
49	Název klienta 49	neznámý	2023-03-16 14:19:50.127062+01
50	Název klienta 50	neznámý	2023-03-16 14:20:05.554989+01
51	Název klienta 51	neznámý	2023-03-16 14:20:05.554989+01
52	Název klienta 52	neznámý	2023-03-16 14:20:05.554989+01
53	Název klienta 53	neznámý	2023-03-16 14:20:05.554989+01
54	Název klienta 54	neznámý	2023-03-16 14:20:05.554989+01
55	Název klienta 55	neznámý	2023-03-16 14:20:05.554989+01
56	Název klienta 56	neznámý	2023-03-16 14:20:05.554989+01
57	Název klienta 57	neznámý	2023-03-16 14:20:05.554989+01
58	Název klienta 58	neznámý	2023-03-16 14:20:05.554989+01
59	Název klienta 59	neznámý	2023-03-16 14:20:05.554989+01
\.


--
-- TOC entry 3352 (class 0 OID 24609)
-- Dependencies: 217
-- Data for Name: licence_cerpani; Type: TABLE DATA; Schema: public; Owner: pos
--

COPY public.licence_cerpani ("KlientID", "Licence_typID", "DatumOD", "DatumDO", stav) FROM stdin;
1	1	2023-03-14	2024-03-14	aktivní
1	2	2023-03-01	2024-03-01	aktivní
2	2	2022-03-01	2023-03-01	neaktivní
\.


--
-- TOC entry 3351 (class 0 OID 24601)
-- Dependencies: 216
-- Data for Name: licence_typy; Type: TABLE DATA; Schema: public; Owner: pos
--

COPY public.licence_typy ("ID", nazev, popis, stav) FROM stdin;
1	FlexiPOS Basic	základní licence	aktivní
2	ABRA Flexi konektor	zajišťuje komunikaci s Abra FLEXI	aktivní
\.


--
-- TOC entry 3345 (class 0 OID 16421)
-- Dependencies: 210
-- Data for Name: uzivatele; Type: TABLE DATA; Schema: public; Owner: pos
--

COPY public.uzivatele ("ID", login, password, stav, "createdAt") FROM stdin;
1	admin	secret	activ	2023-03-13 16:53:26.232833+01
2	pos	pos	banned	2023-03-13 16:54:53.654582+01
\.


--
-- TOC entry 3363 (class 0 OID 0)
-- Dependencies: 213
-- Name: Device_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: pos
--

SELECT pg_catalog.setval('public."Device_ID_seq"', 3, true);


--
-- TOC entry 3364 (class 0 OID 0)
-- Dependencies: 211
-- Name: Klient_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: pos
--

SELECT pg_catalog.setval('public."Klient_ID_seq"', 59, true);


--
-- TOC entry 3365 (class 0 OID 0)
-- Dependencies: 215
-- Name: licence_typy_ID_seq; Type: SEQUENCE SET; Schema: public; Owner: pos
--

SELECT pg_catalog.setval('public."licence_typy_ID_seq"', 2, true);


--
-- TOC entry 3366 (class 0 OID 0)
-- Dependencies: 209
-- Name: uzivatele_id_seq; Type: SEQUENCE SET; Schema: public; Owner: pos
--

SELECT pg_catalog.setval('public.uzivatele_id_seq', 2, true);


--
-- TOC entry 3199 (class 2606 OID 24594)
-- Name: Device Device_pkey; Type: CONSTRAINT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public."Device"
    ADD CONSTRAINT "Device_pkey" PRIMARY KEY ("ID");


--
-- TOC entry 3197 (class 2606 OID 24585)
-- Name: Klient Klient_pkey; Type: CONSTRAINT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public."Klient"
    ADD CONSTRAINT "Klient_pkey" PRIMARY KEY ("ID");


--
-- TOC entry 3201 (class 2606 OID 24608)
-- Name: licence_typy licence_typy_pkey; Type: CONSTRAINT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public.licence_typy
    ADD CONSTRAINT licence_typy_pkey PRIMARY KEY ("ID");


--
-- TOC entry 3195 (class 2606 OID 16429)
-- Name: uzivatele uzivatele_pkey; Type: CONSTRAINT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public.uzivatele
    ADD CONSTRAINT uzivatele_pkey PRIMARY KEY ("ID");


--
-- TOC entry 3202 (class 2606 OID 24595)
-- Name: Device fk_klient; Type: FK CONSTRAINT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public."Device"
    ADD CONSTRAINT fk_klient FOREIGN KEY ("KlientID") REFERENCES public."Klient"("ID");


--
-- TOC entry 3203 (class 2606 OID 24614)
-- Name: licence_cerpani fk_klient; Type: FK CONSTRAINT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public.licence_cerpani
    ADD CONSTRAINT fk_klient FOREIGN KEY ("KlientID") REFERENCES public."Klient"("ID");


--
-- TOC entry 3204 (class 2606 OID 24619)
-- Name: licence_cerpani fk_licence_typ; Type: FK CONSTRAINT; Schema: public; Owner: pos
--

ALTER TABLE ONLY public.licence_cerpani
    ADD CONSTRAINT fk_licence_typ FOREIGN KEY ("Licence_typID") REFERENCES public.licence_typy("ID");


--
-- TOC entry 3358 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2023-03-16 17:05:18

--
-- PostgreSQL database dump complete
--

