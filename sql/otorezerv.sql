-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 25 Tem 2025, 15:59:38
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `otorezerv`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `banned_customers`
--

CREATE TABLE `banned_customers` (
                                    `id` int(11) NOT NULL,
                                    `company_id` int(11) DEFAULT NULL,
                                    `customer_id` int(11) DEFAULT NULL,
                                    `reason` text DEFAULT NULL,
                                    `banned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cities`
--

CREATE TABLE `cities` (
                          `id` int(11) NOT NULL,
                          `country_id` int(11) NOT NULL,
                          `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`) VALUES
                                                      (1, 1, 'Adana'),
                                                      (2, 1, 'Adıyaman'),
                                                      (3, 1, 'Afyonkarahisar'),
                                                      (4, 1, 'Ağrı'),
                                                      (5, 1, 'Amasya'),
                                                      (6, 1, 'Ankara'),
                                                      (7, 1, 'Antalya'),
                                                      (8, 1, 'Artvin'),
                                                      (9, 1, 'Aydın'),
                                                      (10, 1, 'Balıkesir'),
                                                      (11, 1, 'Bilecik'),
                                                      (12, 1, 'Bingöl'),
                                                      (13, 1, 'Bitlis'),
                                                      (14, 1, 'Bolu'),
                                                      (15, 1, 'Burdur'),
                                                      (16, 1, 'Bursa'),
                                                      (17, 1, 'Çanakkale'),
                                                      (18, 1, 'Çankırı'),
                                                      (19, 1, 'Çorum'),
                                                      (20, 1, 'Denizli'),
                                                      (21, 1, 'Diyarbakır'),
                                                      (22, 1, 'Edirne'),
                                                      (23, 1, 'Elazığ'),
                                                      (24, 1, 'Erzincan'),
                                                      (25, 1, 'Erzurum'),
                                                      (26, 1, 'Eskişehir'),
                                                      (27, 1, 'Gaziantep'),
                                                      (28, 1, 'Giresun'),
                                                      (29, 1, 'Gümüşhane'),
                                                      (30, 1, 'Hakkari'),
                                                      (31, 1, 'Hatay'),
                                                      (32, 1, 'Isparta'),
                                                      (33, 1, 'Mersin'),
                                                      (34, 1, 'İstanbul'),
                                                      (35, 1, 'İzmir'),
                                                      (36, 1, 'Kars'),
                                                      (37, 1, 'Kastamonu'),
                                                      (38, 1, 'Kayseri'),
                                                      (39, 1, 'Kırklareli'),
                                                      (40, 1, 'Kırşehir'),
                                                      (41, 1, 'Kocaeli'),
                                                      (42, 1, 'Konya'),
                                                      (43, 1, 'Kütahya'),
                                                      (44, 1, 'Malatya'),
                                                      (45, 1, 'Manisa'),
                                                      (46, 1, 'Kahramanmaraş'),
                                                      (47, 1, 'Mardin'),
                                                      (48, 1, 'Muğla'),
                                                      (49, 1, 'Muş'),
                                                      (50, 1, 'Nevşehir'),
                                                      (51, 1, 'Niğde'),
                                                      (52, 1, 'Ordu'),
                                                      (53, 1, 'Rize'),
                                                      (54, 1, 'Sakarya'),
                                                      (55, 1, 'Samsun'),
                                                      (56, 1, 'Siirt'),
                                                      (57, 1, 'Sinop'),
                                                      (58, 1, 'Sivas'),
                                                      (59, 1, 'Tekirdağ'),
                                                      (60, 1, 'Tokat'),
                                                      (61, 1, 'Trabzon'),
                                                      (62, 1, 'Tunceli'),
                                                      (63, 1, 'Şanlıurfa'),
                                                      (64, 1, 'Uşak'),
                                                      (65, 1, 'Van'),
                                                      (66, 1, 'Yozgat'),
                                                      (67, 1, 'Zonguldak'),
                                                      (68, 1, 'Aksaray'),
                                                      (69, 1, 'Bayburt'),
                                                      (70, 1, 'Karaman'),
                                                      (71, 1, 'Kırıkkale'),
                                                      (72, 1, 'Batman'),
                                                      (73, 1, 'Şırnak'),
                                                      (74, 1, 'Bartın'),
                                                      (75, 1, 'Ardahan'),
                                                      (76, 1, 'Iğdır'),
                                                      (77, 1, 'Yalova'),
                                                      (78, 1, 'Karabük'),
                                                      (79, 1, 'Kilis'),
                                                      (80, 1, 'Osmaniye'),
                                                      (81, 1, 'Düzce');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `companies`
--

CREATE TABLE `companies` (
                             `id` int(11) NOT NULL,
                             `name` varchar(100) DEFAULT NULL,
                             `whatsapp_number` varchar(20) DEFAULT NULL,
                             `status` int(1) NOT NULL DEFAULT 0,
                             `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `companies`
--

INSERT INTO `companies` (`id`, `name`, `whatsapp_number`, `status`, `created_at`) VALUES
                                                                                      (1, 'Yıldız Rent A Car', '+905551112233', 1, '2025-07-21 11:22:58'),
                                                                                      (2, 'Demir Oto Galeri', '+905554443322', 1, '2025-07-21 11:22:58'),
                                                                                      (3, 'FBÇ Cars', '+905554443000', 2, '2025-07-21 15:01:31');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `company_settings`
--

CREATE TABLE `company_settings` (
                                    `id` int(11) NOT NULL,
                                    `company_id` int(11) DEFAULT NULL,
                                    `setting_key` varchar(100) DEFAULT NULL,
                                    `setting_value` text DEFAULT NULL,
                                    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `company_user`
--

CREATE TABLE `company_user` (
                                `id` int(11) NOT NULL,
                                `user_id` int(11) DEFAULT NULL,
                                `company_id` int(11) DEFAULT NULL,
                                `role` enum('owner','employee') DEFAULT 'employee',
                                `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `company_user`
--

INSERT INTO `company_user` (`id`, `user_id`, `company_id`, `role`, `created_at`) VALUES
                                                                                     (1, 1, 1, 'employee', '2025-07-21 11:24:25'),
                                                                                     (2, 1, 2, 'employee', '2025-07-21 11:24:25'),
                                                                                     (3, 2, 2, 'employee', '2025-07-21 11:24:25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `countries`
--

CREATE TABLE `countries` (
                             `id` int(11) NOT NULL,
                             `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
    (1, 'Türkiye');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `customers`
--

CREATE TABLE `customers` (
                             `id` int(11) NOT NULL,
                             `company_id` int(11) DEFAULT NULL,
                             `name` varchar(100) DEFAULT NULL,
                             `phone` varchar(20) DEFAULT NULL,
                             `email` varchar(100) DEFAULT NULL,
                             `status` int(1) DEFAULT 1,
                             `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `customers`
--

INSERT INTO `customers` (`id`, `company_id`, `name`, `phone`, `email`, `status`, `created_at`) VALUES
                                                                                                   (1, 1, 'Mehmet Arslan', '+905320001100', NULL, 1, '2025-07-21 11:25:46'),
                                                                                                   (2, 2, 'Zeynep Kurt', '+905320002200', NULL, 0, '2025-07-21 11:25:46'),
                                                                                                   (3, 1, 'Ali Can', '+905320003300', NULL, 1, '2025-07-21 11:25:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `districts`
--

CREATE TABLE `districts` (
                             `id` int(11) NOT NULL,
                             `city_id` int(11) NOT NULL,
                             `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `districts`
--

INSERT INTO `districts` (`id`, `city_id`, `name`) VALUES
                                                      (1, 1, 'Aladağ'),
                                                      (2, 1, 'Ceyhan'),
                                                      (3, 1, 'Çukurova'),
                                                      (4, 1, 'Feke'),
                                                      (5, 1, 'İmamoğlu'),
                                                      (6, 1, 'Karaisalı'),
                                                      (7, 1, 'Karataş'),
                                                      (8, 1, 'Kozan'),
                                                      (9, 1, 'Pozantı'),
                                                      (10, 1, 'Saimbeyli'),
                                                      (11, 1, 'Sarıçam'),
                                                      (12, 1, 'Seyhan'),
                                                      (13, 1, 'Tufanbeyli'),
                                                      (14, 1, 'Yumurtalık'),
                                                      (15, 1, 'Yüreğir'),
                                                      (16, 2, 'Besni'),
                                                      (17, 2, 'Çelikhan'),
                                                      (18, 2, 'Gerger'),
                                                      (19, 2, 'Gölbaşı'),
                                                      (20, 2, 'Kahta'),
                                                      (21, 2, 'Merkez'),
                                                      (22, 2, 'Samsat'),
                                                      (23, 2, 'Sincik'),
                                                      (24, 2, 'Tut'),
                                                      (25, 3, 'Başmakçı'),
                                                      (26, 3, 'Bayat'),
                                                      (27, 3, 'Bolvadin'),
                                                      (28, 3, 'Çay'),
                                                      (29, 3, 'Çobanlar'),
                                                      (30, 3, 'Dazkırı'),
                                                      (31, 3, 'Dinar'),
                                                      (32, 3, 'Emirdağ'),
                                                      (33, 3, 'Evciler'),
                                                      (34, 3, 'Hocalar'),
                                                      (35, 3, 'İhsaniye'),
                                                      (36, 3, 'İscehisar'),
                                                      (37, 3, 'Kızılören'),
                                                      (38, 3, 'Merkez'),
                                                      (39, 3, 'Sandıklı'),
                                                      (40, 3, 'Sinanpaşa'),
                                                      (41, 3, 'Sultandağı'),
                                                      (42, 3, 'Şuhut'),
                                                      (43, 4, 'Diyadin'),
                                                      (44, 4, 'Doğubayazıt'),
                                                      (45, 4, 'Eleşkirt'),
                                                      (46, 4, 'Hamur'),
                                                      (47, 4, 'Merkez'),
                                                      (48, 4, 'Patnos'),
                                                      (49, 4, 'Taşlıçay'),
                                                      (50, 4, 'Tutak'),
                                                      (51, 5, 'Göynücek'),
                                                      (52, 5, 'Gümüşhacıköy'),
                                                      (53, 5, 'Hamamözü'),
                                                      (54, 5, 'Merkez'),
                                                      (55, 5, 'Merzifon'),
                                                      (56, 5, 'Suluova'),
                                                      (57, 5, 'Taşova'),
                                                      (58, 6, 'Akyurt'),
                                                      (59, 6, 'Altındağ'),
                                                      (60, 6, 'Ayaş'),
                                                      (61, 6, 'Bala'),
                                                      (62, 6, 'Beypazarı'),
                                                      (63, 6, 'Çamlıdere'),
                                                      (64, 6, 'Çankaya'),
                                                      (65, 6, 'Çubuk'),
                                                      (66, 6, 'Elmadağ'),
                                                      (67, 6, 'Etimesgut'),
                                                      (68, 6, 'Evren'),
                                                      (69, 6, 'Gölbaşı'),
                                                      (70, 6, 'Güdül'),
                                                      (71, 6, 'Haymana'),
                                                      (72, 6, 'Kahramankazan'),
                                                      (73, 6, 'Kalecik'),
                                                      (74, 6, 'Keçiören'),
                                                      (75, 6, 'Kızılcahamam'),
                                                      (76, 6, 'Mamak'),
                                                      (77, 6, 'Nallıhan'),
                                                      (78, 6, 'Polatlı'),
                                                      (79, 6, 'Pursaklar'),
                                                      (80, 6, 'Sincan'),
                                                      (81, 6, 'Şereflikoçhisar'),
                                                      (82, 6, 'Yenimahalle'),
                                                      (83, 7, 'Akseki'),
                                                      (84, 7, 'Aksu'),
                                                      (85, 7, 'Alanya'),
                                                      (86, 7, 'Demre'),
                                                      (87, 7, 'Döşemealtı'),
                                                      (88, 7, 'Elmalı'),
                                                      (89, 7, 'Finike'),
                                                      (90, 7, 'Gazipaşa'),
                                                      (91, 7, 'Gündoğmuş'),
                                                      (92, 7, 'İbradı'),
                                                      (93, 7, 'Kaş'),
                                                      (94, 7, 'Kemer'),
                                                      (95, 7, 'Kepez'),
                                                      (96, 7, 'Konyaaltı'),
                                                      (97, 7, 'Korkuteli'),
                                                      (98, 7, 'Kumluca'),
                                                      (99, 7, 'Manavgat'),
                                                      (100, 7, 'Muratpaşa'),
                                                      (101, 7, 'Serik'),
                                                      (102, 8, 'Ardanuç'),
                                                      (103, 8, 'Arhavi'),
                                                      (104, 8, 'Borçka'),
                                                      (105, 8, 'Hopa'),
                                                      (106, 8, 'Kemalpaşa'),
                                                      (107, 8, 'Merkez'),
                                                      (108, 8, 'Murgul'),
                                                      (109, 8, 'Şavşat'),
                                                      (110, 8, 'Yusufeli'),
                                                      (111, 9, 'Bozdoğan'),
                                                      (112, 9, 'Buharkent'),
                                                      (113, 9, 'Çine'),
                                                      (114, 9, 'Didim'),
                                                      (115, 9, 'Efeler'),
                                                      (116, 9, 'Germencik'),
                                                      (117, 9, 'İncirliova'),
                                                      (118, 9, 'Karacasu'),
                                                      (119, 9, 'Karpuzlu'),
                                                      (120, 9, 'Koçarlı'),
                                                      (121, 9, 'Köşk'),
                                                      (122, 9, 'Kuşadası'),
                                                      (123, 9, 'Kuyucak'),
                                                      (124, 9, 'Nazilli'),
                                                      (125, 9, 'Söke'),
                                                      (126, 9, 'Sultanhisar'),
                                                      (127, 9, 'Yenipazar'),
                                                      (128, 10, 'Altıeylül'),
                                                      (129, 10, 'Ayvalık'),
                                                      (130, 10, 'Balya'),
                                                      (131, 10, 'Bandırma'),
                                                      (132, 10, 'Bigadiç'),
                                                      (133, 10, 'Burhaniye'),
                                                      (134, 10, 'Dursunbey'),
                                                      (135, 10, 'Edremit'),
                                                      (136, 10, 'Erdek'),
                                                      (137, 10, 'Gömeç'),
                                                      (138, 10, 'Gönen'),
                                                      (139, 10, 'Havran'),
                                                      (140, 10, 'İvrindi'),
                                                      (141, 10, 'Karesi'),
                                                      (142, 10, 'Kepsut'),
                                                      (143, 10, 'Manyas'),
                                                      (144, 10, 'Marmara'),
                                                      (145, 10, 'Savaştepe'),
                                                      (146, 10, 'Sındırgı'),
                                                      (147, 10, 'Susurluk'),
                                                      (148, 11, 'Bozüyük'),
                                                      (149, 11, 'Gölpazarı'),
                                                      (150, 11, 'İnhisar'),
                                                      (151, 11, 'Merkez'),
                                                      (152, 11, 'Osmaneli'),
                                                      (153, 11, 'Pazaryeri'),
                                                      (154, 11, 'Söğüt'),
                                                      (155, 11, 'Yenipazar'),
                                                      (156, 12, 'Adaklı'),
                                                      (157, 12, 'Genç'),
                                                      (158, 12, 'Karlıova'),
                                                      (159, 12, 'Kiğı'),
                                                      (160, 12, 'Merkez'),
                                                      (161, 12, 'Solhan'),
                                                      (162, 12, 'Yayladere'),
                                                      (163, 12, 'Yedisu'),
                                                      (164, 13, 'Adilcevaz'),
                                                      (165, 13, 'Ahlat'),
                                                      (166, 13, 'Güroymak'),
                                                      (167, 13, 'Hizan'),
                                                      (168, 13, 'Merkez'),
                                                      (169, 13, 'Mutki'),
                                                      (170, 13, 'Tatvan'),
                                                      (171, 14, 'Dörtdivan'),
                                                      (172, 14, 'Gerede'),
                                                      (173, 14, 'Göynük'),
                                                      (174, 14, 'Kıbrıscık'),
                                                      (175, 14, 'Mengen'),
                                                      (176, 14, 'Merkez'),
                                                      (177, 14, 'Mudurnu'),
                                                      (178, 14, 'Seben'),
                                                      (179, 14, 'Yeniçağa'),
                                                      (180, 15, 'Ağlasun'),
                                                      (181, 15, 'Altınyayla'),
                                                      (182, 15, 'Bucak'),
                                                      (183, 15, 'Çavdır'),
                                                      (184, 15, 'Çeltikçi'),
                                                      (185, 15, 'Gölhisar'),
                                                      (186, 15, 'Karamanlı'),
                                                      (187, 15, 'Kemer'),
                                                      (188, 15, 'Merkez'),
                                                      (189, 15, 'Tefenni'),
                                                      (190, 15, 'Yeşilova'),
                                                      (191, 16, 'Büyükorhan'),
                                                      (192, 16, 'Gemlik'),
                                                      (193, 16, 'Gürsu'),
                                                      (194, 16, 'Harmancık'),
                                                      (195, 16, 'İnegöl'),
                                                      (196, 16, 'İznik'),
                                                      (197, 16, 'Karacabey'),
                                                      (198, 16, 'Keles'),
                                                      (199, 16, 'Kestel'),
                                                      (200, 16, 'Mudanya'),
                                                      (201, 16, 'Mustafakemalpaşa'),
                                                      (202, 16, 'Nilüfer'),
                                                      (203, 16, 'Orhaneli'),
                                                      (204, 16, 'Orhangazi'),
                                                      (205, 16, 'Osmangazi'),
                                                      (206, 16, 'Yenişehir'),
                                                      (207, 16, 'Yıldırım'),
                                                      (208, 17, 'Ayvacık'),
                                                      (209, 17, 'Bayramiç'),
                                                      (210, 17, 'Biga'),
                                                      (211, 17, 'Bozcaada'),
                                                      (212, 17, 'Çan'),
                                                      (213, 17, 'Eceabat'),
                                                      (214, 17, 'Ezine'),
                                                      (215, 17, 'Gelibolu'),
                                                      (216, 17, 'Gökçeada'),
                                                      (217, 17, 'Lapseki'),
                                                      (218, 17, 'Merkez'),
                                                      (219, 17, 'Yenice'),
                                                      (220, 18, 'Atkaracalar'),
                                                      (221, 18, 'Bayramören'),
                                                      (222, 18, 'Çerkeş'),
                                                      (223, 18, 'Eldivan'),
                                                      (224, 18, 'Ilgaz'),
                                                      (225, 18, 'Kızılırmak'),
                                                      (226, 18, 'Korgun'),
                                                      (227, 18, 'Kurşunlu'),
                                                      (228, 18, 'Merkez'),
                                                      (229, 18, 'Orta'),
                                                      (230, 18, 'Şabanözü'),
                                                      (231, 18, 'Yapraklı'),
                                                      (232, 19, 'Alaca'),
                                                      (233, 19, 'Bayat'),
                                                      (234, 19, 'Boğazkale'),
                                                      (235, 19, 'Dodurga'),
                                                      (236, 19, 'İskilip'),
                                                      (237, 19, 'Kargı'),
                                                      (238, 19, 'Laçin'),
                                                      (239, 19, 'Mecitözü'),
                                                      (240, 19, 'Merkez'),
                                                      (241, 19, 'Oğuzlar'),
                                                      (242, 19, 'Ortaköy'),
                                                      (243, 19, 'Osmancık'),
                                                      (244, 19, 'Sungurlu'),
                                                      (245, 19, 'Uğurludağ'),
                                                      (246, 20, 'Acıpayam'),
                                                      (247, 20, 'Babadağ'),
                                                      (248, 20, 'Baklan'),
                                                      (249, 20, 'Bekilli'),
                                                      (250, 20, 'Beyağaç'),
                                                      (251, 20, 'Bozkurt'),
                                                      (252, 20, 'Buldan'),
                                                      (253, 20, 'Çal'),
                                                      (254, 20, 'Çameli'),
                                                      (255, 20, 'Çardak'),
                                                      (256, 20, 'Çivril'),
                                                      (257, 20, 'Güney'),
                                                      (258, 20, 'Honaz'),
                                                      (259, 20, 'Kale'),
                                                      (260, 20, 'Merkezefendi'),
                                                      (261, 20, 'Pamukkale'),
                                                      (262, 20, 'Sarayköy'),
                                                      (263, 20, 'Serinhisar'),
                                                      (264, 20, 'Tavas'),
                                                      (265, 21, 'Bağlar'),
                                                      (266, 21, 'Bismil'),
                                                      (267, 21, 'Çermik'),
                                                      (268, 21, 'Çınar'),
                                                      (269, 21, 'Çüngüş'),
                                                      (270, 21, 'Dicle'),
                                                      (271, 21, 'Eğil'),
                                                      (272, 21, 'Ergani'),
                                                      (273, 21, 'Hani'),
                                                      (274, 21, 'Hazro'),
                                                      (275, 21, 'Kayapınar'),
                                                      (276, 21, 'Kocaköy'),
                                                      (277, 21, 'Kulp'),
                                                      (278, 21, 'Lice'),
                                                      (279, 21, 'Silvan'),
                                                      (280, 21, 'Sur'),
                                                      (281, 21, 'Yenişehir'),
                                                      (282, 22, 'Enez'),
                                                      (283, 22, 'Havsa'),
                                                      (284, 22, 'İpsala'),
                                                      (285, 22, 'Keşan'),
                                                      (286, 22, 'Lalapaşa'),
                                                      (287, 22, 'Meriç'),
                                                      (288, 22, 'Merkez'),
                                                      (289, 22, 'Süloğlu'),
                                                      (290, 22, 'Uzunköprü'),
                                                      (291, 23, 'Ağın'),
                                                      (292, 23, 'Alacakaya'),
                                                      (293, 23, 'Arıcak'),
                                                      (294, 23, 'Baskil'),
                                                      (295, 23, 'Karakoçan'),
                                                      (296, 23, 'Keban'),
                                                      (297, 23, 'Kovancılar'),
                                                      (298, 23, 'Maden'),
                                                      (299, 23, 'Merkez'),
                                                      (300, 23, 'Palu'),
                                                      (301, 23, 'Sivrice'),
                                                      (302, 24, 'Çayırlı'),
                                                      (303, 24, 'İliç'),
                                                      (304, 24, 'Kemah'),
                                                      (305, 24, 'Kemaliye'),
                                                      (306, 24, 'Merkez'),
                                                      (307, 24, 'Otlukbeli'),
                                                      (308, 24, 'Refahiye'),
                                                      (309, 24, 'Tercan'),
                                                      (310, 24, 'Üzümlü'),
                                                      (311, 25, 'Aşkale'),
                                                      (312, 25, 'Aziziye'),
                                                      (313, 25, 'Çat'),
                                                      (314, 25, 'Hınıs'),
                                                      (315, 25, 'Horasan'),
                                                      (316, 25, 'İspir'),
                                                      (317, 25, 'Karaçoban'),
                                                      (318, 25, 'Karayazı'),
                                                      (319, 25, 'Köprüköy'),
                                                      (320, 25, 'Narman'),
                                                      (321, 25, 'Oltu'),
                                                      (322, 25, 'Olur'),
                                                      (323, 25, 'Palandöken'),
                                                      (324, 25, 'Pasinler'),
                                                      (325, 25, 'Pazaryolu'),
                                                      (326, 25, 'Şenkaya'),
                                                      (327, 25, 'Tekman'),
                                                      (328, 25, 'Tortum'),
                                                      (329, 25, 'Uzundere'),
                                                      (330, 25, 'Yakutiye'),
                                                      (331, 26, 'Alpu'),
                                                      (332, 26, 'Beylikova'),
                                                      (333, 26, 'Çifteler'),
                                                      (334, 26, 'Günyüzü'),
                                                      (335, 26, 'Han'),
                                                      (336, 26, 'İnönü'),
                                                      (337, 26, 'Mahmudiye'),
                                                      (338, 26, 'Mihalgazi'),
                                                      (339, 26, 'Mihalıççık'),
                                                      (340, 26, 'Odunpazarı'),
                                                      (341, 26, 'Sarıcakaya'),
                                                      (342, 26, 'Seyitgazi'),
                                                      (343, 26, 'Sivrihisar'),
                                                      (344, 26, 'Tepebaşı'),
                                                      (345, 27, 'Araban'),
                                                      (346, 27, 'İslahiye'),
                                                      (347, 27, 'Karkamış'),
                                                      (348, 27, 'Nizip'),
                                                      (349, 27, 'Nurdağı'),
                                                      (350, 27, 'Oğuzeli'),
                                                      (351, 27, 'Şahinbey'),
                                                      (352, 27, 'Şehitkamil'),
                                                      (353, 27, 'Yavuzeli'),
                                                      (354, 28, 'Alucra'),
                                                      (355, 28, 'Bulancak'),
                                                      (356, 28, 'Çamoluk'),
                                                      (357, 28, 'Çanakçı'),
                                                      (358, 28, 'Dereli'),
                                                      (359, 28, 'Doğankent'),
                                                      (360, 28, 'Espiye'),
                                                      (361, 28, 'Eynesil'),
                                                      (362, 28, 'Görele'),
                                                      (363, 28, 'Güce'),
                                                      (364, 28, 'Keşap'),
                                                      (365, 28, 'Merkez'),
                                                      (366, 28, 'Piraziz'),
                                                      (367, 28, 'Şebinkarahisar'),
                                                      (368, 28, 'Tirebolu'),
                                                      (369, 28, 'Yağlıdere'),
                                                      (370, 29, 'Kelkit'),
                                                      (371, 29, 'Köse'),
                                                      (372, 29, 'Kürtün'),
                                                      (373, 29, 'Merkez'),
                                                      (374, 29, 'Şiran'),
                                                      (375, 29, 'Torul'),
                                                      (376, 30, 'Çukurca'),
                                                      (377, 30, 'Derecik'),
                                                      (378, 30, 'Merkez'),
                                                      (379, 30, 'Şemdinli'),
                                                      (380, 30, 'Yüksekova'),
                                                      (381, 31, 'Altınözü'),
                                                      (382, 31, 'Antakya'),
                                                      (383, 31, 'Arsuz'),
                                                      (384, 31, 'Belen'),
                                                      (385, 31, 'Defne'),
                                                      (386, 31, 'Dörtyol'),
                                                      (387, 31, 'Erzin'),
                                                      (388, 31, 'Hassa'),
                                                      (389, 31, 'İskenderun'),
                                                      (390, 31, 'Kırıkhan'),
                                                      (391, 31, 'Kumlu'),
                                                      (392, 31, 'Payas'),
                                                      (393, 31, 'Reyhanlı'),
                                                      (394, 31, 'Samandağ'),
                                                      (395, 31, 'Yayladağı'),
                                                      (396, 32, 'Aksu'),
                                                      (397, 32, 'Atabey'),
                                                      (398, 32, 'Eğirdir'),
                                                      (399, 32, 'Gelendost'),
                                                      (400, 32, 'Gönen'),
                                                      (401, 32, 'Keçiborlu'),
                                                      (402, 32, 'Merkez'),
                                                      (403, 32, 'Senirkent'),
                                                      (404, 32, 'Sütçüler'),
                                                      (405, 32, 'Şarkikaraağaç'),
                                                      (406, 32, 'Uluborlu'),
                                                      (407, 32, 'Yalvaç'),
                                                      (408, 32, 'Yenişarbademli'),
                                                      (409, 33, 'Akdeniz'),
                                                      (410, 33, 'Anamur'),
                                                      (411, 33, 'Aydıncık'),
                                                      (412, 33, 'Bozyazı'),
                                                      (413, 33, 'Çamlıyayla'),
                                                      (414, 33, 'Erdemli'),
                                                      (415, 33, 'Gülnar'),
                                                      (416, 33, 'Mezitli'),
                                                      (417, 33, 'Mut'),
                                                      (418, 33, 'Silifke'),
                                                      (419, 33, 'Tarsus'),
                                                      (420, 33, 'Toroslar'),
                                                      (421, 33, 'Yenişehir'),
                                                      (422, 34, 'Adalar'),
                                                      (423, 34, 'Arnavutköy'),
                                                      (424, 34, 'Ataşehir'),
                                                      (425, 34, 'Avcılar'),
                                                      (426, 34, 'Bağcılar'),
                                                      (427, 34, 'Bahçelievler'),
                                                      (428, 34, 'Bakırköy'),
                                                      (429, 34, 'Başakşehir'),
                                                      (430, 34, 'Bayrampaşa'),
                                                      (431, 34, 'Beşiktaş'),
                                                      (432, 34, 'Beykoz'),
                                                      (433, 34, 'Beylikdüzü'),
                                                      (434, 34, 'Beyoğlu'),
                                                      (435, 34, 'Büyükçekmece'),
                                                      (436, 34, 'Çatalca'),
                                                      (437, 34, 'Çekmeköy'),
                                                      (438, 34, 'Esenler'),
                                                      (439, 34, 'Esenyurt'),
                                                      (440, 34, 'Eyüpsultan'),
                                                      (441, 34, 'Fatih'),
                                                      (442, 34, 'Gaziosmanpaşa'),
                                                      (443, 34, 'Güngören'),
                                                      (444, 34, 'Kadıköy'),
                                                      (445, 34, 'Kağıthane'),
                                                      (446, 34, 'Kartal'),
                                                      (447, 34, 'Küçükçekmece'),
                                                      (448, 34, 'Maltepe'),
                                                      (449, 34, 'Pendik'),
                                                      (450, 34, 'Sancaktepe'),
                                                      (451, 34, 'Sarıyer'),
                                                      (452, 34, 'Silivri'),
                                                      (453, 34, 'Sultanbeyli'),
                                                      (454, 34, 'Sultangazi'),
                                                      (455, 34, 'Şile'),
                                                      (456, 34, 'Şişli'),
                                                      (457, 34, 'Tuzla'),
                                                      (458, 34, 'Ümraniye'),
                                                      (459, 34, 'Üsküdar'),
                                                      (460, 34, 'Zeytinburnu'),
                                                      (461, 35, 'Aliağa'),
                                                      (462, 35, 'Balçova'),
                                                      (463, 35, 'Bayındır'),
                                                      (464, 35, 'Bayraklı'),
                                                      (465, 35, 'Bergama'),
                                                      (466, 35, 'Beydağ'),
                                                      (467, 35, 'Bornova'),
                                                      (468, 35, 'Buca'),
                                                      (469, 35, 'Çeşme'),
                                                      (470, 35, 'Çiğli'),
                                                      (471, 35, 'Dikili'),
                                                      (472, 35, 'Foça'),
                                                      (473, 35, 'Gaziemir'),
                                                      (474, 35, 'Güzelbahçe'),
                                                      (475, 35, 'Karabağlar'),
                                                      (476, 35, 'Karaburun'),
                                                      (477, 35, 'Karşıyaka'),
                                                      (478, 35, 'Kemalpaşa'),
                                                      (479, 35, 'Kınık'),
                                                      (480, 35, 'Kiraz'),
                                                      (481, 35, 'Konak'),
                                                      (482, 35, 'Menderes'),
                                                      (483, 35, 'Menemen'),
                                                      (484, 35, 'Narlıdere'),
                                                      (485, 35, 'Ödemiş'),
                                                      (486, 35, 'Seferihisar'),
                                                      (487, 35, 'Selçuk'),
                                                      (488, 35, 'Tire'),
                                                      (489, 35, 'Torbalı'),
                                                      (490, 35, 'Urla'),
                                                      (491, 36, 'Akyaka'),
                                                      (492, 36, 'Arpaçay'),
                                                      (493, 36, 'Digor'),
                                                      (494, 36, 'Kağızman'),
                                                      (495, 36, 'Merkez'),
                                                      (496, 36, 'Sarıkamış'),
                                                      (497, 36, 'Selim'),
                                                      (498, 36, 'Susuz'),
                                                      (499, 37, 'Abana'),
                                                      (500, 37, 'Ağlı'),
                                                      (501, 37, 'Araç'),
                                                      (502, 37, 'Azdavay'),
                                                      (503, 37, 'Bozkurt'),
                                                      (504, 37, 'Cide'),
                                                      (505, 37, 'Çatalzeytin'),
                                                      (506, 37, 'Daday'),
                                                      (507, 37, 'Devrekani'),
                                                      (508, 37, 'Doğanyurt'),
                                                      (509, 37, 'Hanönü'),
                                                      (510, 37, 'İhsangazi'),
                                                      (511, 37, 'İnebolu'),
                                                      (512, 37, 'Küre'),
                                                      (513, 37, 'Merkez'),
                                                      (514, 37, 'Pınarbaşı'),
                                                      (515, 37, 'Seydiler'),
                                                      (516, 37, 'Şenpazar'),
                                                      (517, 37, 'Taşköprü'),
                                                      (518, 37, 'Tosya'),
                                                      (519, 38, 'Akkışla'),
                                                      (520, 38, 'Bünyan'),
                                                      (521, 38, 'Develi'),
                                                      (522, 38, 'Felahiye'),
                                                      (523, 38, 'Hacılar'),
                                                      (524, 38, 'İncesu'),
                                                      (525, 38, 'Kocasinan'),
                                                      (526, 38, 'Melikgazi'),
                                                      (527, 38, 'Özvatan'),
                                                      (528, 38, 'Pınarbaşı'),
                                                      (529, 38, 'Sarıoğlan'),
                                                      (530, 38, 'Sarız'),
                                                      (531, 38, 'Talas'),
                                                      (532, 38, 'Tomarza'),
                                                      (533, 38, 'Yahyalı'),
                                                      (534, 38, 'Yeşilhisar'),
                                                      (535, 39, 'Babaeski'),
                                                      (536, 39, 'Demirköy'),
                                                      (537, 39, 'Kofçaz'),
                                                      (538, 39, 'Lüleburgaz'),
                                                      (539, 39, 'Merkez'),
                                                      (540, 39, 'Pehlivanköy'),
                                                      (541, 39, 'Pınarhisar'),
                                                      (542, 39, 'Vize'),
                                                      (543, 40, 'Akçakent'),
                                                      (544, 40, 'Akpınar'),
                                                      (545, 40, 'Boztepe'),
                                                      (546, 40, 'Çiçekdağı'),
                                                      (547, 40, 'Kaman'),
                                                      (548, 40, 'Merkez'),
                                                      (549, 40, 'Mucur'),
                                                      (550, 41, 'Başiskele'),
                                                      (551, 41, 'Çayırova'),
                                                      (552, 41, 'Darıca'),
                                                      (553, 41, 'Derince'),
                                                      (554, 41, 'Dilovası'),
                                                      (555, 41, 'Gebze'),
                                                      (556, 41, 'Gölcük'),
                                                      (557, 41, 'İzmit'),
                                                      (558, 41, 'Kandıra'),
                                                      (559, 41, 'Karamürsel'),
                                                      (560, 41, 'Kartepe'),
                                                      (561, 41, 'Körfez'),
                                                      (562, 42, 'Ahırlı'),
                                                      (563, 42, 'Akören'),
                                                      (564, 42, 'Akşehir'),
                                                      (565, 42, 'Altınekin'),
                                                      (566, 42, 'Beyşehir'),
                                                      (567, 42, 'Bozkır'),
                                                      (568, 42, 'Cihanbeyli'),
                                                      (569, 42, 'Çeltik'),
                                                      (570, 42, 'Çumra'),
                                                      (571, 42, 'Derbent'),
                                                      (572, 42, 'Derebucak'),
                                                      (573, 42, 'Doğanhisar'),
                                                      (574, 42, 'Emirgazi'),
                                                      (575, 42, 'Ereğli'),
                                                      (576, 42, 'Güneysınır'),
                                                      (577, 42, 'Hadim'),
                                                      (578, 42, 'Halkapınar'),
                                                      (579, 42, 'Hüyük'),
                                                      (580, 42, 'Ilgın'),
                                                      (581, 42, 'Kadınhanı'),
                                                      (582, 42, 'Karapınar'),
                                                      (583, 42, 'Karatay'),
                                                      (584, 42, 'Kulu'),
                                                      (585, 42, 'Meram'),
                                                      (586, 42, 'Sarayönü'),
                                                      (587, 42, 'Selçuklu'),
                                                      (588, 42, 'Seydişehir'),
                                                      (589, 42, 'Taşkent'),
                                                      (590, 42, 'Tuzlukçu'),
                                                      (591, 42, 'Yalıhüyük'),
                                                      (592, 42, 'Yunak'),
                                                      (593, 43, 'Altıntaş'),
                                                      (594, 43, 'Aslanapa'),
                                                      (595, 43, 'Çavdarhisar'),
                                                      (596, 43, 'Domaniç'),
                                                      (597, 43, 'Dumlupınar'),
                                                      (598, 43, 'Emet'),
                                                      (599, 43, 'Gediz'),
                                                      (600, 43, 'Hisarcık'),
                                                      (601, 43, 'Merkez'),
                                                      (602, 43, 'Pazarlar'),
                                                      (603, 43, 'Simav'),
                                                      (604, 43, 'Şaphane'),
                                                      (605, 43, 'Tavşanlı'),
                                                      (606, 44, 'Akçadağ'),
                                                      (607, 44, 'Arapgir'),
                                                      (608, 44, 'Arguvan'),
                                                      (609, 44, 'Battalgazi'),
                                                      (610, 44, 'Darende'),
                                                      (611, 44, 'Doğanşehir'),
                                                      (612, 44, 'Doğanyol'),
                                                      (613, 44, 'Hekimhan'),
                                                      (614, 44, 'Kale'),
                                                      (615, 44, 'Kuluncak'),
                                                      (616, 44, 'Pütürge'),
                                                      (617, 44, 'Yazıhan'),
                                                      (618, 44, 'Yeşilyurt'),
                                                      (619, 45, 'Ahmetli'),
                                                      (620, 45, 'Akhisar'),
                                                      (621, 45, 'Alaşehir'),
                                                      (622, 45, 'Demirci'),
                                                      (623, 45, 'Gölmarmara'),
                                                      (624, 45, 'Gördes'),
                                                      (625, 45, 'Kırkağaç'),
                                                      (626, 45, 'Köprübaşı'),
                                                      (627, 45, 'Kula'),
                                                      (628, 45, 'Salihli'),
                                                      (629, 45, 'Sarıgöl'),
                                                      (630, 45, 'Saruhanlı'),
                                                      (631, 45, 'Selendi'),
                                                      (632, 45, 'Soma'),
                                                      (633, 45, 'Şehzadeler'),
                                                      (634, 45, 'Turgutlu'),
                                                      (635, 45, 'Yunusemre'),
                                                      (636, 46, 'Afşin'),
                                                      (637, 46, 'Andırın'),
                                                      (638, 46, 'Çağlayancerit'),
                                                      (639, 46, 'Dulkadiroğlu'),
                                                      (640, 46, 'Ekinözü'),
                                                      (641, 46, 'Elbistan'),
                                                      (642, 46, 'Göksun'),
                                                      (643, 46, 'Nurhak'),
                                                      (644, 46, 'Onikişubat'),
                                                      (645, 46, 'Pazarcık'),
                                                      (646, 46, 'Türkoğlu'),
                                                      (647, 47, 'Artuklu'),
                                                      (648, 47, 'Dargeçit'),
                                                      (649, 47, 'Derik'),
                                                      (650, 47, 'Kızıltepe'),
                                                      (651, 47, 'Mazıdağı'),
                                                      (652, 47, 'Midyat'),
                                                      (653, 47, 'Nusaybin'),
                                                      (654, 47, 'Ömerli'),
                                                      (655, 47, 'Savur'),
                                                      (656, 47, 'Yeşilli'),
                                                      (657, 48, 'Bodrum'),
                                                      (658, 48, 'Dalaman'),
                                                      (659, 48, 'Datça'),
                                                      (660, 48, 'Fethiye'),
                                                      (661, 48, 'Kavaklıdere'),
                                                      (662, 48, 'Köyceğiz'),
                                                      (663, 48, 'Marmaris'),
                                                      (664, 48, 'Menteşe'),
                                                      (665, 48, 'Milas'),
                                                      (666, 48, 'Ortaca'),
                                                      (667, 48, 'Seydikemer'),
                                                      (668, 48, 'Ula'),
                                                      (669, 48, 'Yatağan'),
                                                      (670, 49, 'Bulanık'),
                                                      (671, 49, 'Hasköy'),
                                                      (672, 49, 'Korkut'),
                                                      (673, 49, 'Malazgirt'),
                                                      (674, 49, 'Merkez'),
                                                      (675, 49, 'Varto'),
                                                      (676, 50, 'Acıgöl'),
                                                      (677, 50, 'Avanos'),
                                                      (678, 50, 'Derinkuyu'),
                                                      (679, 50, 'Gülşehir'),
                                                      (680, 50, 'Hacıbektaş'),
                                                      (681, 50, 'Kozaklı'),
                                                      (682, 50, 'Merkez'),
                                                      (683, 50, 'Ürgüp'),
                                                      (684, 51, 'Altunhisar'),
                                                      (685, 51, 'Bor'),
                                                      (686, 51, 'Çamardı'),
                                                      (687, 51, 'Çiftlik'),
                                                      (688, 51, 'Merkez'),
                                                      (689, 51, 'Ulukışla'),
                                                      (690, 52, 'Akkuş'),
                                                      (691, 52, 'Altınordu'),
                                                      (692, 52, 'Aybastı'),
                                                      (693, 52, 'Çamaş'),
                                                      (694, 52, 'Çatalpınar'),
                                                      (695, 52, 'Çaybaşı'),
                                                      (696, 52, 'Fatsa'),
                                                      (697, 52, 'Gölköy'),
                                                      (698, 52, 'Gülyalı'),
                                                      (699, 52, 'Gürgentepe'),
                                                      (700, 52, 'İkizce'),
                                                      (701, 52, 'Kabadüz'),
                                                      (702, 52, 'Kabataş'),
                                                      (703, 52, 'Korgan'),
                                                      (704, 52, 'Kumru'),
                                                      (705, 52, 'Mesudiye'),
                                                      (706, 52, 'Perşembe'),
                                                      (707, 52, 'Ulubey'),
                                                      (708, 52, 'Ünye'),
                                                      (709, 53, 'Ardeşen'),
                                                      (710, 53, 'Çamlıhemşin'),
                                                      (711, 53, 'Çayeli'),
                                                      (712, 53, 'Derepazarı'),
                                                      (713, 53, 'Fındıklı'),
                                                      (714, 53, 'Güneysu'),
                                                      (715, 53, 'Hemşin'),
                                                      (716, 53, 'İkizdere'),
                                                      (717, 53, 'İyidere'),
                                                      (718, 53, 'Kalkandere'),
                                                      (719, 53, 'Merkez'),
                                                      (720, 53, 'Pazar'),
                                                      (721, 54, 'Adapazarı'),
                                                      (722, 54, 'Akyazı'),
                                                      (723, 54, 'Arifiye'),
                                                      (724, 54, 'Erenler'),
                                                      (725, 54, 'Ferizli'),
                                                      (726, 54, 'Geyve'),
                                                      (727, 54, 'Hendek'),
                                                      (728, 54, 'Karapürçek'),
                                                      (729, 54, 'Karasu'),
                                                      (730, 54, 'Kaynarca'),
                                                      (731, 54, 'Kocaali'),
                                                      (732, 54, 'Pamukova'),
                                                      (733, 54, 'Sapanca'),
                                                      (734, 54, 'Serdivan'),
                                                      (735, 54, 'Söğütlü'),
                                                      (736, 54, 'Taraklı'),
                                                      (737, 55, '19 Mayıs'),
                                                      (738, 55, 'Alaçam'),
                                                      (739, 55, 'Asarcık'),
                                                      (740, 55, 'Atakum'),
                                                      (741, 55, 'Ayvacık'),
                                                      (742, 55, 'Bafra'),
                                                      (743, 55, 'Canik'),
                                                      (744, 55, 'Çarşamba'),
                                                      (745, 55, 'Havza'),
                                                      (746, 55, 'İlkadım'),
                                                      (747, 55, 'Kavak'),
                                                      (748, 55, 'Ladik'),
                                                      (749, 55, 'Salıpazarı'),
                                                      (750, 55, 'Tekkeköy'),
                                                      (751, 55, 'Terme'),
                                                      (752, 55, 'Vezirköprü'),
                                                      (753, 55, 'Yakakent'),
                                                      (754, 56, 'Baykan'),
                                                      (755, 56, 'Eruh'),
                                                      (756, 56, 'Kurtalan'),
                                                      (757, 56, 'Merkez'),
                                                      (758, 56, 'Pervari'),
                                                      (759, 56, 'Şirvan'),
                                                      (760, 56, 'Tillo'),
                                                      (761, 57, 'Ayancık'),
                                                      (762, 57, 'Boyabat'),
                                                      (763, 57, 'Dikmen'),
                                                      (764, 57, 'Durağan'),
                                                      (765, 57, 'Erfelek'),
                                                      (766, 57, 'Gerze'),
                                                      (767, 57, 'Merkez'),
                                                      (768, 57, 'Saraydüzü'),
                                                      (769, 57, 'Türkeli'),
                                                      (770, 58, 'Akıncılar'),
                                                      (771, 58, 'Altınyayla'),
                                                      (772, 58, 'Divriği'),
                                                      (773, 58, 'Doğanşar'),
                                                      (774, 58, 'Gemerek'),
                                                      (775, 58, 'Gölova'),
                                                      (776, 58, 'Gürün'),
                                                      (777, 58, 'Hafik'),
                                                      (778, 58, 'İmranlı'),
                                                      (779, 58, 'Kangal'),
                                                      (780, 58, 'Koyulhisar'),
                                                      (781, 58, 'Merkez'),
                                                      (782, 58, 'Suşehri'),
                                                      (783, 58, 'Şarkışla'),
                                                      (784, 58, 'Ulaş'),
                                                      (785, 58, 'Yıldızeli'),
                                                      (786, 58, 'Zara'),
                                                      (787, 59, 'Çerkezköy'),
                                                      (788, 59, 'Çorlu'),
                                                      (789, 59, 'Ergene'),
                                                      (790, 59, 'Hayrabolu'),
                                                      (791, 59, 'Kapaklı'),
                                                      (792, 59, 'Malkara'),
                                                      (793, 59, 'Marmaraereğlisi'),
                                                      (794, 59, 'Muratlı'),
                                                      (795, 59, 'Saray'),
                                                      (796, 59, 'Süleymanpaşa'),
                                                      (797, 59, 'Şarköy'),
                                                      (798, 60, 'Almus'),
                                                      (799, 60, 'Artova'),
                                                      (800, 60, 'Başçiftlik'),
                                                      (801, 60, 'Erbaa'),
                                                      (802, 60, 'Merkez'),
                                                      (803, 60, 'Niksar'),
                                                      (804, 60, 'Pazar'),
                                                      (805, 60, 'Reşadiye'),
                                                      (806, 60, 'Sulusaray'),
                                                      (807, 60, 'Turhal'),
                                                      (808, 60, 'Yeşilyurt'),
                                                      (809, 60, 'Zile'),
                                                      (810, 61, 'Akçaabat'),
                                                      (811, 61, 'Araklı'),
                                                      (812, 61, 'Arsin'),
                                                      (813, 61, 'Beşikdüzü'),
                                                      (814, 61, 'Çarşıbaşı'),
                                                      (815, 61, 'Çaykara'),
                                                      (816, 61, 'Dernekpazarı'),
                                                      (817, 61, 'Düzköy'),
                                                      (818, 61, 'Hayrat'),
                                                      (819, 61, 'Köprübaşı'),
                                                      (820, 61, 'Maçka'),
                                                      (821, 61, 'Of'),
                                                      (822, 61, 'Ortahisar'),
                                                      (823, 61, 'Sürmene'),
                                                      (824, 61, 'Şalpazarı'),
                                                      (825, 61, 'Tonya'),
                                                      (826, 61, 'Vakfıkebir'),
                                                      (827, 61, 'Yomra'),
                                                      (828, 62, 'Çemişgezek'),
                                                      (829, 62, 'Hozat'),
                                                      (830, 62, 'Mazgirt'),
                                                      (831, 62, 'Merkez'),
                                                      (832, 62, 'Nazımiye'),
                                                      (833, 62, 'Ovacık'),
                                                      (834, 62, 'Pertek'),
                                                      (835, 62, 'Pülümür'),
                                                      (836, 63, 'Akçakale'),
                                                      (837, 63, 'Birecik'),
                                                      (838, 63, 'Bozova'),
                                                      (839, 63, 'Ceylanpınar'),
                                                      (840, 63, 'Eyyübiye'),
                                                      (841, 63, 'Halfeti'),
                                                      (842, 63, 'Haliliye'),
                                                      (843, 63, 'Harran'),
                                                      (844, 63, 'Hilvan'),
                                                      (845, 63, 'Karaköprü'),
                                                      (846, 63, 'Siverek'),
                                                      (847, 63, 'Suruç'),
                                                      (848, 63, 'Viranşehir'),
                                                      (849, 64, 'Banaz'),
                                                      (850, 64, 'Eşme'),
                                                      (851, 64, 'Karahallı'),
                                                      (852, 64, 'Merkez'),
                                                      (853, 64, 'Sivaslı'),
                                                      (854, 64, 'Ulubey'),
                                                      (855, 65, 'Bahçesaray'),
                                                      (856, 65, 'Başkale'),
                                                      (857, 65, 'Çaldıran'),
                                                      (858, 65, 'Çatak'),
                                                      (859, 65, 'Edremit'),
                                                      (860, 65, 'Erciş'),
                                                      (861, 65, 'Gevaş'),
                                                      (862, 65, 'Gürpınar'),
                                                      (863, 65, 'İpekyolu'),
                                                      (864, 65, 'Muradiye'),
                                                      (865, 65, 'Özalp'),
                                                      (866, 65, 'Saray'),
                                                      (867, 65, 'Tuşba'),
                                                      (868, 66, 'Akdağmadeni'),
                                                      (869, 66, 'Aydıncık'),
                                                      (870, 66, 'Boğazlıyan'),
                                                      (871, 66, 'Çandır'),
                                                      (872, 66, 'Çayıralan'),
                                                      (873, 66, 'Çekerek'),
                                                      (874, 66, 'Kadışehri'),
                                                      (875, 66, 'Merkez'),
                                                      (876, 66, 'Saraykent'),
                                                      (877, 66, 'Sarıkaya'),
                                                      (878, 66, 'Sorgun'),
                                                      (879, 66, 'Şefaatli'),
                                                      (880, 66, 'Yenifakılı'),
                                                      (881, 66, 'Yerköy'),
                                                      (882, 67, 'Alaplı'),
                                                      (883, 67, 'Çaycuma'),
                                                      (884, 67, 'Devrek'),
                                                      (885, 67, 'Ereğli'),
                                                      (886, 67, 'Gökçebey'),
                                                      (887, 67, 'Kilimli'),
                                                      (888, 67, 'Kozlu'),
                                                      (889, 67, 'Merkez'),
                                                      (890, 68, 'Ağaçören'),
                                                      (891, 68, 'Eskil'),
                                                      (892, 68, 'Gülağaç'),
                                                      (893, 68, 'Güzelyurt'),
                                                      (894, 68, 'Merkez'),
                                                      (895, 68, 'Ortaköy'),
                                                      (896, 68, 'Sarıyahşi'),
                                                      (897, 68, 'Sultanhanı'),
                                                      (898, 69, 'Aydıntepe'),
                                                      (899, 69, 'Demirözü'),
                                                      (900, 69, 'Merkez'),
                                                      (901, 70, 'Ayrancı'),
                                                      (902, 70, 'Başyayla'),
                                                      (903, 70, 'Ermenek'),
                                                      (904, 70, 'Kazımkarabekir'),
                                                      (905, 70, 'Merkez'),
                                                      (906, 70, 'Sarıveliler'),
                                                      (907, 71, 'Bahşılı'),
                                                      (908, 71, 'Balışeyh'),
                                                      (909, 71, 'Çelebi'),
                                                      (910, 71, 'Delice'),
                                                      (911, 71, 'Karakeçili'),
                                                      (912, 71, 'Keskin'),
                                                      (913, 71, 'Merkez'),
                                                      (914, 71, 'Sulakyurt'),
                                                      (915, 71, 'Yahşihan'),
                                                      (916, 72, 'Beşiri'),
                                                      (917, 72, 'Gercüş'),
                                                      (918, 72, 'Hasankeyf'),
                                                      (919, 72, 'Kozluk'),
                                                      (920, 72, 'Merkez'),
                                                      (921, 72, 'Sason'),
                                                      (922, 73, 'Beytüşşebap'),
                                                      (923, 73, 'Cizre'),
                                                      (924, 73, 'Güçlükonak'),
                                                      (925, 73, 'İdil'),
                                                      (926, 73, 'Merkez'),
                                                      (927, 73, 'Silopi'),
                                                      (928, 73, 'Uludere'),
                                                      (929, 74, 'Amasra'),
                                                      (930, 74, 'Kurucaşile'),
                                                      (931, 74, 'Merkez'),
                                                      (932, 74, 'Ulus'),
                                                      (933, 75, 'Çıldır'),
                                                      (934, 75, 'Damal'),
                                                      (935, 75, 'Göle'),
                                                      (936, 75, 'Hanak'),
                                                      (937, 75, 'Merkez'),
                                                      (938, 75, 'Posof'),
                                                      (939, 76, 'Aralık'),
                                                      (940, 76, 'Karakoyunlu'),
                                                      (941, 76, 'Merkez'),
                                                      (942, 76, 'Tuzluca'),
                                                      (943, 77, 'Altınova'),
                                                      (944, 77, 'Armutlu'),
                                                      (945, 77, 'Çınarcık'),
                                                      (946, 77, 'Çiftlikköy'),
                                                      (947, 77, 'Merkez'),
                                                      (948, 77, 'Termal'),
                                                      (949, 78, 'Eflani'),
                                                      (950, 78, 'Eskipazar'),
                                                      (951, 78, 'Merkez'),
                                                      (952, 78, 'Ovacık'),
                                                      (953, 78, 'Safranbolu'),
                                                      (954, 78, 'Yenice'),
                                                      (955, 79, 'Elbeyli'),
                                                      (956, 79, 'Merkez'),
                                                      (957, 79, 'Musabeyli'),
                                                      (958, 79, 'Polateli'),
                                                      (959, 80, 'Bahçe'),
                                                      (960, 80, 'Düziçi'),
                                                      (961, 80, 'Hasanbeyli'),
                                                      (962, 80, 'Kadirli'),
                                                      (963, 80, 'Merkez'),
                                                      (964, 80, 'Sumbas'),
                                                      (965, 80, 'Toprakkale'),
                                                      (966, 81, 'Akçakoca'),
                                                      (967, 81, 'Cumayeri'),
                                                      (968, 81, 'Çilimli'),
                                                      (969, 81, 'Gölyaka'),
                                                      (970, 81, 'Gümüşova'),
                                                      (971, 81, 'Kaynaşlı'),
                                                      (972, 81, 'Merkez'),
                                                      (973, 81, 'Yığılca');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `files`
--

CREATE TABLE `files` (
                         `id` int(11) NOT NULL,
                         `file_name` varchar(255) DEFAULT NULL,
                         `file_path` text DEFAULT NULL,
                         `file_type` varchar(50) DEFAULT NULL,
                         `file_size` int(11) DEFAULT NULL,
                         `related_table` varchar(100) DEFAULT NULL,
                         `related_id` int(11) DEFAULT NULL,
                         `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `files`
--

INSERT INTO `files` (`id`, `file_name`, `file_path`, `file_type`, `file_size`, `related_table`, `related_id`, `created_at`) VALUES
                                                                                                                                (2, 'image0.jpeg', 'uploads/vehicles/56/photo/vehicle_68824191aaa71.jpeg', 'image/jpeg', 73697, 'vehicles', 56, '2025-07-24 17:22:09'),
                                                                                                                                (5, 'test.png', 'uploads/vehicles/56/photo/vehicle_6882442a355a9.png', 'image/png', 2943, 'vehicles', 56, '2025-07-24 17:33:14'),
                                                                                                                                (9, 'asd-img.jpg', 'uploads/vehicles/56/photo/vehicle_6882442a3ccf9.jpg', 'image/jpeg', 8810, 'vehicles', 56, '2025-07-24 17:33:14'),
                                                                                                                                (13, 'masaüstü.jpg', 'uploads/vehicles/56/photo/vehicle_6882442a420a5.jpg', 'image/jpeg', 46406, 'vehicles', 56, '2025-07-24 17:33:14'),
                                                                                                                                (14, 'x16_1260543031va5.jpg', 'uploads/vehicles/57/photo/vehicle_68837beba3d73.jpg', 'image/jpeg', 393989, 'vehicles', 57, '2025-07-25 15:43:23'),
                                                                                                                                (15, 'x16_12605430317op.jpg', 'uploads/vehicles/57/photo/vehicle_68837beba6270.jpg', 'image/jpeg', 421223, 'vehicles', 57, '2025-07-25 15:43:23'),
                                                                                                                                (16, 'x16_1260543031j97.jpg', 'uploads/vehicles/57/photo/vehicle_68837beba7d85.jpg', 'image/jpeg', 608919, 'vehicles', 57, '2025-07-25 15:43:23'),
                                                                                                                                (17, 'x16_12605430314nu.jpg', 'uploads/vehicles/57/photo/vehicle_68837bebab963.jpg', 'image/jpeg', 538215, 'vehicles', 57, '2025-07-25 15:43:23'),
                                                                                                                                (18, 'x16_1260543031399.jpg', 'uploads/vehicles/57/photo/vehicle_68837bebb3e46.jpg', 'image/jpeg', 625464, 'vehicles', 57, '2025-07-25 15:43:23');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reservations`
--

CREATE TABLE `reservations` (
                                `id` int(11) NOT NULL,
                                `vehicle_id` int(11) DEFAULT NULL,
                                `customer_id` int(11) DEFAULT NULL,
                                `type` enum('rent','buy') DEFAULT NULL,
                                `start_date` date DEFAULT NULL,
                                `end_date` date DEFAULT NULL,
                                `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
                                `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `reservations`
--

INSERT INTO `reservations` (`id`, `vehicle_id`, `customer_id`, `type`, `start_date`, `end_date`, `status`, `created_at`) VALUES
                                                                                                                             (1, 1, 1, 'rent', '2025-07-25', '2025-07-30', 'approved', '2025-07-20 07:30:00'),
                                                                                                                             (2, 2, 2, '', '2025-07-20', NULL, 'pending', '2025-07-20 08:15:00'),
                                                                                                                             (3, 3, 1, 'rent', '2025-08-01', '2025-08-10', '', '2025-07-20 09:00:00'),
                                                                                                                             (4, 4, 3, '', '2025-07-19', NULL, 'completed', '2025-07-19 06:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `name` varchar(100) DEFAULT NULL,
                         `email` varchar(100) DEFAULT NULL,
                         `password` varchar(255) DEFAULT NULL,
                         `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
                                                                          (1, 'Ahmet Yılmaz', 'ahmet@example.com', '$2y$10$qc1OGZ7NS/XxA6.FMWszdOgCzcNV2S3crxltNobtXWu7dit3oYBaC', '2025-07-21 11:19:46'),
                                                                          (2, 'Elif Demir', 'elif@example.com', 'hashed_password2', '2025-07-21 11:19:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_column_preferences`
--

CREATE TABLE `user_column_preferences` (
                                           `id` int(11) NOT NULL,
                                           `user_id` int(11) NOT NULL,
                                           `table_name` varchar(100) NOT NULL,
                                           `column_name` varchar(100) NOT NULL,
                                           `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user_column_preferences`
--

INSERT INTO `user_column_preferences` (`id`, `user_id`, `table_name`, `column_name`, `created_at`) VALUES
                                                                                                       (488, 1, 'vehicles-table', 'title', '2025-07-25 09:19:47'),
                                                                                                       (489, 1, 'vehicles-table', 'brand', '2025-07-25 09:19:47'),
                                                                                                       (490, 1, 'vehicles-table', 'model', '2025-07-25 09:19:47'),
                                                                                                       (491, 1, 'vehicles-table', 'year', '2025-07-25 09:19:47'),
                                                                                                       (492, 1, 'vehicles-table', 'price', '2025-07-25 09:19:47'),
                                                                                                       (493, 1, 'vehicles-table', 'is_for_rent', '2025-07-25 09:19:47'),
                                                                                                       (494, 1, 'vehicles-table', 'is_for_sale', '2025-07-25 09:19:47'),
                                                                                                       (495, 1, 'vehicles-table', 'status', '2025-07-25 09:19:47'),
                                                                                                       (496, 1, 'vehicles-table', 'created_at', '2025-07-25 09:19:47'),
                                                                                                       (497, 1, 'vehicles-table', 'location_address', '2025-07-25 09:19:47'),
                                                                                                       (498, 1, 'vehicles-table', 'location_city_id', '2025-07-25 09:19:47'),
                                                                                                       (499, 1, 'vehicles-table', 'location_district_id', '2025-07-25 09:19:47'),
                                                                                                       (500, 1, 'vehicles-table', 'gear_type', '2025-07-25 09:19:47'),
                                                                                                       (501, 1, 'vehicles-table', 'color', '2025-07-25 09:19:47'),
                                                                                                       (502, 1, 'vehicles-table', 'rental_type', '2025-07-25 09:19:47');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vehicles`
--

CREATE TABLE `vehicles` (
                            `id` int(11) NOT NULL,
                            `company_id` int(11) DEFAULT NULL,
                            `title` varchar(100) DEFAULT NULL,
                            `brand` varchar(50) DEFAULT NULL,
                            `model` varchar(50) DEFAULT NULL,
                            `year` int(11) DEFAULT NULL,
                            `price` decimal(10,2) DEFAULT NULL,
                            `price_currency` varchar(10) DEFAULT NULL,
                            `is_for_rent` tinyint(1) DEFAULT 0,
                            `is_for_sale` tinyint(1) DEFAULT 0,
                            `status` enum('available','reserved','sold','rented') DEFAULT 'available',
                            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                            `plate` varchar(20) DEFAULT NULL,
                            `is_plate_hidden` tinyint(1) DEFAULT 0,
                            `km` int(11) DEFAULT NULL,
                            `is_km_hidden` tinyint(1) DEFAULT 0,
                            `location_address` varchar(255) DEFAULT NULL,
                            `location_country_id` int(11) DEFAULT NULL,
                            `location_city_id` int(11) DEFAULT NULL,
                            `location_district_id` int(11) DEFAULT NULL,
                            `gear_type` enum('manual','automatic','semi-automatic') DEFAULT 'automatic',
                            `fuel_type` enum('petrol','diesel','lpg','electric','hybrid') DEFAULT 'petrol',
                            `engine_size` decimal(5,2) DEFAULT NULL COMMENT 'Motor hacmi litre cinsinden',
                            `horse_power` int(11) DEFAULT NULL COMMENT 'Motor gücü',
                            `color` varchar(30) DEFAULT NULL,
                            `body_type` enum('sedan','hatchback','suv','pickup','coupe','convertible','van','other') DEFAULT NULL,
                            `description` text DEFAULT NULL,
                            `rental_type` enum('daily','weekly','monthly','none') DEFAULT 'none',
                            `min_rent_duration` int(11) DEFAULT NULL COMMENT 'Minimum kiralama süresi gün cinsinden',
                            `min_rent_duration_unit` varchar(10) DEFAULT NULL,
                            `max_rent_duration` int(11) DEFAULT NULL COMMENT 'Maksimum kiralama süresi gün cinsinden',
                            `max_rent_duration_unit` varchar(10) DEFAULT NULL,
                            `tramers_price` decimal(10,2) DEFAULT NULL COMMENT 'Araç tramers fiyatı',
                            `tramers_price_currency` varchar(10) DEFAULT NULL,
                            `traction` enum('fwd','rwd','awd','4wd','other') DEFAULT NULL COMMENT 'Çekiş tipi',
                            `rental_km_limit` int(11) DEFAULT NULL COMMENT 'Kiralık araçlar için km sınırı',
                            `over_km_price` decimal(10,2) DEFAULT NULL COMMENT 'Kiralama km sınırı aşıldığında km başı ücret',
                            `over_km_price_currency` varchar(10) DEFAULT NULL,
                            `heavy_damage_record` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `vehicles`
--

INSERT INTO `vehicles` (`id`, `company_id`, `title`, `brand`, `model`, `year`, `price`, `price_currency`, `is_for_rent`, `is_for_sale`, `status`, `created_at`, `plate`, `is_plate_hidden`, `km`, `is_km_hidden`, `location_address`, `location_country_id`, `location_city_id`, `location_district_id`, `gear_type`, `fuel_type`, `engine_size`, `horse_power`, `color`, `body_type`, `description`, `rental_type`, `min_rent_duration`, `min_rent_duration_unit`, `max_rent_duration`, `max_rent_duration_unit`, `tramers_price`, `tramers_price_currency`, `traction`, `rental_km_limit`, `over_km_price`, `over_km_price_currency`, `heavy_damage_record`) VALUES
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (1, 1, '2020 Renault Clio Kiralık', 'Renault', 'Clio', 2020, 850.00, 'TRY', 1, 0, 'available', '2025-07-20 07:00:00', '', 0, 0, 0, 'Bağdat Caddesi No:100', 1, 76, 939, 'automatic', 'petrol', 1.20, 132, '#FFFFFF', 'sedan', '<p>asdasda</p>\r\n', 'none', 0, 'gun', 0, 'gun', 0.00, 'TRY', '', 0, 0.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (2, 1, '2022 Fiat Egea Satılık', 'Fiat', 'Egea', 2022, 385000.00, NULL, 0, 1, 'available', '2025-07-20 08:00:00', NULL, 0, NULL, 0, 'Atatürk Bulvarı No:25', 1, 6, 601, 'automatic', 'petrol', 1.60, 265, '#000000', 'sedan', 'asfacsa', 'none', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (3, 2, '2019 BMW 320i Kiralık', 'BMW', '320i', 2019, 1200.00, 'TRY', 1, 0, 'available', '2025-07-20 09:00:00', '', 0, 0, 0, 'Adnann', 1, 9, 125, 'automatic', 'petrol', 1.60, 120, '#FF0000', 'sedan', '<p>zxczxczx</p>\r\n', 'none', 0, 'gun', 0, 'gun', 0.00, 'TRY', '', 0, 0.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (4, 2, '2018 Toyota Corolla Satılık', 'Toyota', 'Corolla', 2018, 310000.00, 'TRY', 0, 1, 'sold', '2025-07-20 10:00:00', '', 0, 0, 0, 'Alsancak Mahallesi 1469. Sokak', 1, 35, 462, 'automatic', 'petrol', 3.00, 150, '#808080', 'sedan', '<p>e213e1w21</p>\r\n', 'none', 0, 'gun', 0, 'gun', 0.00, 'TRY', '', 0, 0.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (10, 1, '2023 Toyota Corolla Kiralık', 'Toyota', 'Corolla', 2023, 450.00, 'TRY', 1, 0, 'available', '2025-07-21 15:01:48', '34ABC123', 0, 15000, 0, 'İstanbul, Kadıköy Mah.', 1, 34, 434, 'automatic', 'petrol', 1.60, 132, '#8B0000', 'sedan', '<p>Bakımları tam, g&uuml;nl&uuml;k kiralık.</p>\r\n', 'daily', 1, 'gun', 30, 'gun', 150000.00, 'TRY', 'fwd', 100, 0.50, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (11, 1, '2021 BMW X5 Satılık', 'BMW', 'X5', 2021, 950000.00, NULL, 0, 1, 'available', '2025-07-21 15:01:48', '06XYZ789', 0, 60000, 0, 'Ankara, Çankaya İlçesi', 1, 6, 62, 'automatic', 'diesel', 3.02, 265, '#0000FF', 'suv', '<p>İkinci el, full donanım.111</p>\r\n', 'none', 0, NULL, 0, NULL, 2200000.00, NULL, 'awd', 0, 0.00, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (12, 1, '2022 Renault Clio Kiralık', 'Renault', 'Clio', 2022, 320.00, NULL, 1, 0, 'rented', '2025-07-21 15:01:48', '35DEF456', 1, 22000, 1, 'İzmir, Konak', 1, 35, 301, 'manual', 'lpg', 1.20, 120, '#FFD700', 'hatchback', 'Yakıt cimrisi, şehir içi ideal.', 'weekly', 7, NULL, 90, NULL, 65000.00, NULL, 'fwd', 200, 0.30, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (13, 3, '2020 Ford Transit Satılık', 'Ford', 'Transit', 2020, 450000.00, NULL, 0, 1, 'sold', '2025-07-21 15:01:48', '34GHI789', 0, 100000, 0, 'İstanbul, Esenler', 1, 34, 34, 'manual', 'diesel', 2.20, 150, '#FFFFFF', 'van', 'İş amaçlı uygun.', 'none', NULL, NULL, NULL, NULL, 80000.00, NULL, 'rwd', NULL, NULL, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (14, 2, '2024 Tesla Model 3 Kiralık', 'Tesla', 'Model 3', 2024, 1000.00, NULL, 1, 0, 'available', '2025-07-21 15:01:48', '34TES123', 0, 5000, 0, 'İstanbul, Beşiktaş', 1, 34, 23, 'automatic', 'electric', NULL, 283, '#000000', 'sedan', 'Sıfır km elektrikli araç.', 'monthly', 30, NULL, 365, NULL, 300000.00, NULL, 'rwd', 300, 1.00, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (15, 1, 'Sıfırdan farksız', 'TOGG', 'T10X', 2024, 2100000.00, NULL, 0, 1, 'available', '2025-07-21 21:15:22', '34ASD123', 1, 15487, 0, 'mugeee', 1, 3, 27, 'automatic', 'electric', 1.60, 500, '#FF1493', 'suv', '<p>fasfcasfafa harika</p>\r\n', 'none', 1, NULL, 2, NULL, 1.00, NULL, 'rwd', 100, 100.00, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (16, 1, 'Deneme aracı', 'Opel', 'Corsa', 2022, 1070000.00, 'EUR', 1, 1, 'available', '2025-07-22 22:07:20', '77AS123', 0, 15000, 0, 'Açık aAdres', 1, 25, 314, 'automatic', 'petrol', 1.20, 105, '#8B0000', 'hatchback', '<p>&Ouml;ğretmenden temiz ara&ccedil;</p>\r\n', 'none', 1, 'gun', 2, 'ay', 2672.00, 'TRY', 'fwd', 0, 50.00, 'USD', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (18, 1, 'Cillop gibi kasa', 'BMW', 'F10', 2017, 1765000.00, 'TRY', 1, 1, 'available', '2025-07-23 14:21:32', '81ASD112', 0, 210547, 0, 'Düzce Merkez Patlıyo herkez', 1, 81, 972, 'automatic', 'petrol', 1.60, 180, '#000000', 'sedan', '<p>Harika bişey ya lore&ouml; ipsum falan filan</p>\r\n', 'daily', 10, 'gun', 3, 'ay', 1000.00, 'USD', 'rwd', 20000, 10.00, 'EUR', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (29, 1, 'Uygun fiyatlı aile aracı', 'Toyota', 'Corolla', 2020, 310000.00, 'TRY', 0, 1, 'available', '2025-07-23 17:06:34', '34ABC123', 0, 48000, 0, 'Kadıköy, İstanbul', 1, 34, 436, 'automatic', 'petrol', 1.60, 132, '#FFFFFF', 'sedan', '<p>Bakımlı, sorunsuz ara&ccedil;. 1. elden.</p>\r\n', 'none', 0, 'gun', 0, 'gun', 12000.00, 'TRY', 'fwd', 0, 0.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (30, 2, 'Elektrikli şehir içi araç', 'Renault', 'ZOE', 2022, 720000.00, 'TRY', 1, 0, 'available', '2025-07-23 17:06:34', '06EV456', 1, 12000, 0, 'Çankaya, Ankara', 1, 6, 45, 'automatic', 'electric', 0.00, 110, '#0000FF', 'hatchback', 'Elektrikli araç, düşük maliyet.', 'daily', 1, 'day', 7, 'day', NULL, NULL, 'fwd', 200, 3.50, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (31, 1, 'SUV 4x4 maceraperestler için', 'Jeep', 'Wrangler', 2019, 1550000.00, 'TRY', 0, 1, 'available', '2025-07-23 17:06:34', '35JEEP78', 0, 89000, 0, 'Bornova, İzmir', 1, 35, 463, 'manual', 'diesel', 2.80, 200, '#2f4f4f', 'suv', '<p>Zorlu arazi koşullarına uygun, y&uuml;ksek performans.</p>\r\n', 'none', 0, 'gun', 0, 'gun', 30000.00, 'TRY', '4wd', 0, 0.00, 'TRY', 1),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (32, 2, 'Konforlu kiralık araç', 'BMW', '520i', 2021, 4500.00, 'TRY', 1, 0, 'available', '2025-07-23 17:06:34', '34BMW520', 1, 25000, 1, 'Beşiktaş, İstanbul', 1, 34, 3, 'automatic', 'petrol', 2.00, 184, '#808080', 'sedan', 'Haftalık ve aylık kiralamaya uygun.', 'weekly', 1, 'week', 4, 'week', NULL, NULL, 'rwd', 1000, 5.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (33, 2, 'Pickup iş aracı', 'Ford', 'Ranger', 2018, 795000.00, 'TRY', 0, 1, 'reserved', '2025-07-23 17:06:34', '16FORDR4', 0, 112000, 0, 'Nilüfer, Bursa', 1, 16, 7, 'automatic', 'diesel', 3.20, 200, '#FF0000', 'pickup', 'İş amaçlı kullanılmış, sağlam.', 'none', NULL, NULL, NULL, NULL, 15000.00, 'TRY', '4wd', NULL, NULL, NULL, 1),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (34, 1, 'Ekonomik günlük kiralık', 'Fiat', 'Egea', 2022, 1000.00, 'TRY', 1, 0, 'available', '2025-07-23 17:06:34', '34EGEA22', 1, 18000, 0, 'Bakırköy, İstanbul', 1, 34, 426, 'manual', 'petrol', 1.40, 95, '#FFFFFF', 'sedan', '<p>G&uuml;nl&uuml;k kiralık olarak idealdir.</p>\r\n', 'daily', 1, 'gun', 14, 'gun', 0.00, 'TRY', 'fwd', 150, 2.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (35, 1, 'Lüks spor araç', 'Porsche', '911 Carrera', 2020, 4750000.00, 'TRY', 0, 1, 'available', '2025-07-23 17:06:34', '34POR911', 0, 21000, 0, 'Sarıyer, İstanbul', 1, 34, 435, 'automatic', 'petrol', 3.00, 450, '#ffa500', 'coupe', '<p>L&uuml;ks ve performans isteyenler i&ccedil;in.</p>\r\n', 'none', 0, 'gun', 0, 'gun', 50000.00, 'TRY', 'rwd', 0, 0.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (36, 1, 'Geniş aile aracı', 'Volkswagen', 'Transporter', 2017, 985000.00, 'TRY', 0, 1, 'sold', '2025-07-23 17:06:34', '06VWTRP7', 1, 145000, 1, 'Yenimahalle, Ankara', 1, 6, 60, 'manual', 'diesel', 2.00, 150, '#808080', 'van', '<p>Aile ve iş i&ccedil;in ideal geniş ara&ccedil;.</p>\r\n', 'none', 0, 'gun', 0, 'gun', 18000.00, 'TRY', 'fwd', 0, 0.00, 'TRY', 1),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (37, 2, 'Kompakt hibrit şehir aracı', 'Toyota', 'Yaris Hybrid', 2023, 975000.00, 'TRY', 1, 1, 'available', '2025-07-23 17:06:34', '34HYR2023', 0, 7000, 0, 'Ataşehir, İstanbul', 1, 34, 424, 'automatic', 'hybrid', 1.50, 116, '#000000', 'hatchback', '<p>Hem satış hem kiralama opsiyonlu.</p>\r\n', 'monthly', 1, 'ay', 3, 'yil', 1000.00, 'USD', 'fwd', 2500, 4.50, 'EUR', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (38, 2, 'Cabrio yazlık keyfi', 'Mazda', 'MX-5', 2016, 1290000.00, 'TRY', 0, 1, 'available', '2025-07-23 17:06:34', '35MX5CABR', 0, 54000, 0, 'Konak, İzmir', 1, 35, 475, 'manual', 'petrol', 2.00, 160, '#8B0000', 'convertible', '<p>Yaz aylarında keyifli s&uuml;r&uuml;şler.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>HAHAHAHHA</strong></p>\r\n', 'none', 0, 'gun', 0, 'gun', 25000.00, 'TRY', 'rwd', 0, 0.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (39, 1, '2021 Audi A3 Sportback', 'Audi', 'A3', 2021, 820000.00, 'TRY', 0, 1, 'available', '2025-07-24 13:01:15', '34AUD001', 0, 42000, 0, 'Istanbul, Turkey', 1, 34, 1, 'automatic', 'petrol', 1.40, 150, '#1E1E1E', 'hatchback', 'Bakımlı, şehir içi kullanılmış, kazasız araç.', 'none', NULL, NULL, NULL, NULL, 0.00, NULL, 'fwd', NULL, NULL, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (40, 2, '2022 Honda HR-V e:HEV', 'Honda', 'HR-V', 2022, 950000.00, 'TRY', 1, 1, 'available', '2025-07-24 13:01:15', '06HND987', 0, 18000, 0, 'Ankara, Turkey', 1, 6, 3, 'automatic', 'hybrid', 1.50, 131, '#FFFFFF', 'suv', 'Yüksek donanım, elektrik destekli hibrit sistem.', 'weekly', 3, 'day', 15, 'day', 0.00, NULL, 'fwd', 600, 2.50, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (41, 1, '2023 Skoda Superb Style', 'Skoda', 'Superb', 2023, 1150000.00, 'TRY', 0, 1, 'reserved', '2025-07-24 13:01:15', '34SKD888', 0, 12000, 0, 'Istanbul, Turkey', 1, 34, 4, 'automatic', 'diesel', 2.00, 190, '#2C3E50', 'sedan', 'Yeni kasa, full paket, fabrika garantili.', 'none', NULL, NULL, NULL, NULL, 0.00, NULL, 'fwd', NULL, NULL, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (42, 2, '2020 Hyundai i20 Elite', 'Hyundai', 'i20', 2020, 570000.00, 'TRY', 1, 0, 'available', '2025-07-24 13:01:15', '06HYD123', 0, 58000, 0, 'Ankara, Turkey', 1, 6, 7, 'manual', 'petrol', 1.20, 84, '#2980B9', 'hatchback', 'Uygun fiyatlı kiralık araç. Sorunsuz çalışır.', 'daily', 1, 'day', 30, 'day', 0.00, NULL, 'fwd', 300, 1.50, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (43, 1, '2023 Volvo XC40 Recharge', 'Volvo', 'XC40', 2023, 1480000.00, 'TRY', 0, 1, 'available', '2025-07-24 13:01:15', '34VLV404', 0, 9000, 0, 'Istanbul, Turkey', 1, 34, 5, 'automatic', 'electric', NULL, 231, '#34495E', 'suv', 'Tam elektrikli Volvo SUV. Full donanım.', 'none', NULL, NULL, NULL, NULL, 0.00, NULL, 'awd', NULL, NULL, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (44, 2, '2018 Nissan Qashqai Tekna', 'Nissan', 'Qashqai', 2018, 620000.00, 'TRY', 0, 1, 'sold', '2025-07-24 13:01:15', '06NSN321', 1, 95000, 1, 'Ankara, Turkey', 1, 6, 2, 'automatic', 'diesel', 1.50, 110, '#8E44AD', 'suv', 'Aile aracı, düzenli servisli, tramer kaydı yok.', 'none', NULL, NULL, NULL, NULL, 2100.00, 'TRY', 'fwd', NULL, NULL, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (45, 1, '2023 Cupra Born Electric', 'Cupra', 'Born', 2023, 1420000.00, 'TRY', 1, 0, 'available', '2025-07-24 13:01:15', '34CPR222', 0, 6000, 0, 'Istanbul, Turkey', 1, 34, 1, 'automatic', 'electric', NULL, 204, '#F39C12', 'hatchback', 'Sportif elektrikli araç, yüksek menzil.', 'monthly', 1, 'month', 6, 'month', 0.00, NULL, 'rwd', 1800, 3.20, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (46, 2, '2019 Kia Sportage Concept Plus', 'Kia', 'Sportage', 2019, 730000.00, 'TRY', 0, 1, 'available', '2025-07-24 13:01:15', '06KIA999', 0, 67000, 0, 'Ankara, Turkey', 1, 6, 6, 'automatic', 'petrol', 1.60, 177, '#E74C3C', 'suv', 'Crossover SUV, ferah ve rahat kullanım.', 'none', NULL, NULL, NULL, NULL, 1500.00, 'TRY', 'awd', NULL, NULL, NULL, 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (47, 1, '2022 Seat Leon FR', 'Seat', 'Leon', 2022, 810000.00, 'TRY', 0, 1, 'available', '2025-07-24 13:01:15', '34STL555', 0, 21000, 0, 'Istanbul, Turkey', 1, 34, 426, 'automatic', 'petrol', 1.50, 150, '#d35400', 'hatchback', '<p>FR donanım paketi, dinamik s&uuml;r&uuml;ş.</p>\r\n', 'none', 0, 'gun', 0, 'gun', 0.00, 'TRY', 'fwd', 0, 0.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (48, 2, '2020 Mitsubishi L200 4x4', 'Mitsubishi', 'L200', 2020, 890000.00, 'TRY', 1, 1, 'available', '2025-07-24 13:01:15', '06MTS444', 0, 49000, 0, 'Ankara, Turkey', 1, 6, 4, 'manual', 'diesel', 2.40, 181, '#27AE60', 'pickup', 'Arazi koşullarına uygun güçlü 4x4 pickup.', 'weekly', 2, 'week', 6, 'week', 0.00, NULL, '4wd', 800, 4.50, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (56, 1, 'asdasdfa', 'dasdfa', 'fasfa', 2017, 0.00, 'TRY', 0, 0, 'available', '2025-07-24 14:22:09', '03AA999', 0, 50000, 1, '', 1, 4, 47, 'automatic', 'petrol', 0.00, 0, '#FFFFFF', 'sedan', '', 'none', 0, 'gun', 0, 'gun', 0.00, 'TRY', '', 0, 0.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (57, 1, 'Cillop gibi R12', 'Renault', 'Toros', 1997, 278000.00, 'TRY', 0, 1, 'available', '2025-07-25 12:43:23', '34QW888', 0, 768047, 0, 'arnavutköy merkez', 1, 34, 423, 'manual', 'lpg', 999.99, 72, '#FFFFFF', 'hatchback', '<pre>\r\n<strong>YILDIZ  RENT A CAR DAN</strong></pre>\r\n\r\n<pre>\r\n\r\nKREDİ KARTI GE&Ccedil;ER\r\n83 MODEL ORJİNAL GTS RENO 12\r\n&Ouml;N CAMLAR OTOMATİK\r\nMOTORU SIFIR MUANE SIFIR\r\nFREN AKSAMLARI SIFIR\r\nELEKTRİK AKSAMI KOMPLE ELDEN GE&Ccedil;Tİ\r\n&Ccedil;&Uuml;R&Uuml;G&Uuml; &Ccedil;ARIGI YOK\r\nARACIN ACİL OLMAYAN KABORTA BOYA MASRAFI VAR\r\nUYGUN FİYAT</pre>\r\n\r\n<pre>\r\n\r\n&nbsp;</pre>\r\n', 'none', 0, 'gun', 0, 'gun', 7091.00, 'TRY', 'fwd', 0, 0.00, 'TRY', 0),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   (58, 1, 'test sil', 'dasda', 'fasfa', 2000, 0.00, 'TRY', 0, 0, 'available', '2025-07-25 13:36:11', '', 0, 0, 0, '', 1, 4, 47, 'automatic', 'petrol', 0.00, 0, '#ffffff', '', '', 'none', 0, 'gun', 0, 'gun', 0.00, 'TRY', 'awd', 0, 0.00, 'TRY', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vehicles_damage`
--

CREATE TABLE `vehicles_damage` (
                                   `id` int(11) NOT NULL,
                                   `vehicle_id` int(11) NOT NULL,
                                   `front_bumper` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `front_hood` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `roof` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `front_right_mudguard` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `front_right_door` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `rear_right_door` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `rear_right_mudguard` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `front_left_mudguard` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `front_left_door` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `rear_left_door` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `rear_left_mudguard` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `rear_hood` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `rear_bumper` enum('original','painted','replaced','local_paint') DEFAULT 'original',
                                   `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                                   `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `vehicles_damage`
--

INSERT INTO `vehicles_damage` (`id`, `vehicle_id`, `front_bumper`, `front_hood`, `roof`, `front_right_mudguard`, `front_right_door`, `rear_right_door`, `rear_right_mudguard`, `front_left_mudguard`, `front_left_door`, `rear_left_door`, `rear_left_mudguard`, `rear_hood`, `rear_bumper`, `created_at`, `updated_at`) VALUES
                                                                                                                                                                                                                                                                                                                             (1, 47, 'original', 'original', 'original', 'original', 'original', 'original', 'original', 'original', 'original', 'original', 'original', 'original', 'original', '2025-07-25 13:18:54', '2025-07-25 13:34:45'),
                                                                                                                                                                                                                                                                                                                             (2, 58, 'original', 'painted', 'local_paint', 'original', 'replaced', 'original', 'original', 'original', 'local_paint', 'original', 'original', 'original', 'original', '2025-07-25 13:36:11', '2025-07-25 13:58:05');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vehicle_damages_old`
--

CREATE TABLE `vehicle_damages_old` (
                                       `id` int(11) NOT NULL,
                                       `vehicle_id` int(11) NOT NULL,
                                       `part_name` enum('front-bumper','rear-bumper','front-hood','roof','rear-hood','front-left-door','front-right-door','rear-left-door','rear-right-door','front-left-mudguard','front-right-mudguard','rear-left-mudguard','rear-right-mudguard') NOT NULL,
                                       `original` tinyint(1) DEFAULT 1,
                                       `replaced` tinyint(1) DEFAULT 0,
                                       `painted` tinyint(1) DEFAULT 0,
                                       `local_paint` tinyint(1) DEFAULT 0,
                                       `disassembled_reassembled` tinyint(1) DEFAULT 0,
                                       `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `vehicle_damages_old`
--

INSERT INTO `vehicle_damages_old` (`id`, `vehicle_id`, `part_name`, `original`, `replaced`, `painted`, `local_paint`, `disassembled_reassembled`, `created_at`) VALUES
                                                                                                                                                                    (66, 57, 'front-bumper', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (67, 57, 'front-hood', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (68, 57, 'roof', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (69, 57, 'front-right-mudguard', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (70, 57, 'front-right-door', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (71, 57, 'rear-right-door', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (72, 57, 'rear-right-mudguard', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (73, 57, 'front-left-mudguard', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (74, 57, 'front-left-door', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (75, 57, 'rear-left-door', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (76, 57, 'rear-left-mudguard', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (77, 57, 'rear-hood', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (78, 57, 'rear-bumper', 1, 0, 0, 0, 0, '2025-07-25 12:44:27'),
                                                                                                                                                                    (79, 56, 'front-bumper', 1, 0, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (80, 56, 'front-hood', 0, 0, 1, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (81, 56, 'roof', 0, 1, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (82, 56, 'front-right-mudguard', 1, 0, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (83, 56, 'front-right-door', 1, 0, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (84, 56, 'rear-right-door', 1, 0, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (85, 56, 'rear-right-mudguard', 1, 0, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (86, 56, 'front-left-mudguard', 1, 0, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (87, 56, 'front-left-door', 0, 0, 0, 1, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (88, 56, 'rear-left-door', 1, 0, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (89, 56, 'rear-left-mudguard', 1, 0, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (90, 56, 'rear-hood', 1, 0, 0, 0, 0, '2025-07-25 12:48:04'),
                                                                                                                                                                    (91, 56, 'rear-bumper', 1, 0, 0, 0, 0, '2025-07-25 12:48:04');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `banned_customers`
--
ALTER TABLE `banned_customers`
    ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Tablo için indeksler `cities`
--
ALTER TABLE `cities`
    ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Tablo için indeksler `companies`
--
ALTER TABLE `companies`
    ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `company_settings`
--
ALTER TABLE `company_settings`
    ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Tablo için indeksler `company_user`
--
ALTER TABLE `company_user`
    ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Tablo için indeksler `countries`
--
ALTER TABLE `countries`
    ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `customers`
--
ALTER TABLE `customers`
    ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Tablo için indeksler `districts`
--
ALTER TABLE `districts`
    ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`);

--
-- Tablo için indeksler `files`
--
ALTER TABLE `files`
    ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `reservations`
--
ALTER TABLE `reservations`
    ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `user_column_preferences`
--
ALTER TABLE `user_column_preferences`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_table_column` (`user_id`,`table_name`,`column_name`);

--
-- Tablo için indeksler `vehicles`
--
ALTER TABLE `vehicles`
    ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Tablo için indeksler `vehicles_damage`
--
ALTER TABLE `vehicles_damage`
    ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Tablo için indeksler `vehicle_damages_old`
--
ALTER TABLE `vehicle_damages_old`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_id` (`vehicle_id`,`part_name`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `banned_customers`
--
ALTER TABLE `banned_customers`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `cities`
--
ALTER TABLE `cities`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Tablo için AUTO_INCREMENT değeri `companies`
--
ALTER TABLE `companies`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `company_settings`
--
ALTER TABLE `company_settings`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `company_user`
--
ALTER TABLE `company_user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `countries`
--
ALTER TABLE `countries`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `customers`
--
ALTER TABLE `customers`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `districts`
--
ALTER TABLE `districts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=974;

--
-- Tablo için AUTO_INCREMENT değeri `files`
--
ALTER TABLE `files`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `reservations`
--
ALTER TABLE `reservations`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `user_column_preferences`
--
ALTER TABLE `user_column_preferences`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=503;

--
-- Tablo için AUTO_INCREMENT değeri `vehicles`
--
ALTER TABLE `vehicles`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Tablo için AUTO_INCREMENT değeri `vehicles_damage`
--
ALTER TABLE `vehicles_damage`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `vehicle_damages_old`
--
ALTER TABLE `vehicle_damages_old`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `banned_customers`
--
ALTER TABLE `banned_customers`
    ADD CONSTRAINT `banned_customers_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `banned_customers_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `cities`
--
ALTER TABLE `cities`
    ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Tablo kısıtlamaları `company_settings`
--
ALTER TABLE `company_settings`
    ADD CONSTRAINT `company_settings_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `company_user`
--
ALTER TABLE `company_user`
    ADD CONSTRAINT `company_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_user_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `customers`
--
ALTER TABLE `customers`
    ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `districts`
--
ALTER TABLE `districts`
    ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Tablo kısıtlamaları `reservations`
--
ALTER TABLE `reservations`
    ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `vehicles`
--
ALTER TABLE `vehicles`
    ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `vehicle_damages_old`
--
ALTER TABLE `vehicle_damages_old`
    ADD CONSTRAINT `vehicle_damages_old_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
