-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 03:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin1', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(2, 'fkk', '86970064ea53b6d66b7c53cbc91c58b4f06fc6fd'),
(3, 'kexin', '6d04a668ccc2166d714a086df60aca8082ed8667'),
(4, 'lowrenxing', '601f1889667efaebb33b8c12572835da3f027f78');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(3, 1, 2, 'Nendoroid 2339 Snow Miku: Winter Delicacy Ver.', 390, 1, '20240123154428-2024-01-23products154356G24001117.jpg'),
(4, 7, 8, 'Nendoroid 1861 Inugami Korone', 86, 1, '20220428171331-2022-04-28products171314.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 0, 'KKFONG', 'kiankee357@yahoo.com', '1', 'Hi, i love raiden shogun and achreon. They are my wife.'),
(2, 0, 'TKX', 'xinke0202@gmail.com', '1', 'Today\'s happiness can start from the small thungs.\r\nHappy Shopping!!!');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 1, 'Fong Kian Kee', '0197753357', 'kiankee357@yahoo.com', 'TNG eWallet', 'flat no. 3, Jalan Orchard Heights 3, Taman Orchard Heights, Batu Pahat, Johor, Malaysia - 83000', 'Hololive Production Usada Pekora 1/4 Scale Figure (1950 x 1) - ', 1950, '2024-04-25', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`) VALUES
(1, 'Hololive Production Usada Pekora 1/4 Scale Figure', 'Series :Hololive Production\r\nCategory :Scale Figures\r\nSKU :S4570001512230\r\nDescription :Estimate Size H460mm', 1950, '20240123160944-2024-01-23products1609314570001512230.jpg', '20240123160945-2024-01-23products1609324570001512230-2.jpg', '20240123160945-2024-01-23products1609324570001512230-3.jpg'),
(2, 'Nendoroid 2339 Snow Miku: Winter Delicacy Ver.', 'Series :Hatsune Miku\r\nCategory :Nendoroids\r\nSKU :SG24001117\r\nDescription :Sharing a warm winter delicacy with you.\r\nEstimate Size: H100mm', 390, '20240123154428-2024-01-23products154356G24001117.jpg', '20240123154429-2024-01-23products154357G24001117-4.jpg', '20240123154429-2024-01-23products154357G24001117-5.jpg'),
(7, 'Nendoroid 1951 Nakiri Ayame', 'Series: Hololive production\r\nCategory: Nendoroids\r\nSKU: S4580590171022\r\nShe comes with three interchangeable face plates: a standard, smug, and excited face. Estimate Size: H100mm', 396, '20220916163445-2022-09-16products16343501.jpg', '20220916163444-2022-09-16products16343305.jpg', '20220916163445-2022-09-16products16343404.jpg'),
(8, 'Nendoroid 1861 Inugami Korone', 'Series :Hololive Production\r\nCategory :Nendoroids\r\nSKU :S4580590129214\r\nDescription :Estimate Size: H100mm', 286, '20220428171331-2022-04-28products171314.jpg', '20220428171332-2022-04-28products171320.jpg', '20220428171331-2022-04-28products171315.jpg'),
(9, 'Nendoroid 2216 Watson Amelia', 'Series: Hololive Production\r\nCategory: Nendoroids\r\nSKU: S4580590175693\r\nDescription: From the popular virtual YouTube group comes a Nendoroid of English -Myth- VTuber Watson Amelia!\r\nFaceplates: Smiling face, Cheerful face, Smug face\r\nOptional parts: Magnifying glass, Bubba\r\nEstimate Size: H100mm', 286, '20230711173040-2023-07-11products17301500090175693_04.jpg', '20230711173039-2023-07-11products17301400090175693_03.jpg', '20230711173040-2023-07-11products17301700090175693_07.jpg'),
(10, 'Nendoroid 1856 Ookami Mio', 'Series: Hololive Production\r\nCategory: Nendoroids\r\nSKU: S4580590128569\r\nDescription :From the popular YouTuber group comes a Nendoroid of hololive GAMERS VTuber Ookami Mio! She comes with three face plates including a standard face, and a smiling face.\r\nSpecifications: Painted plastic non-scale articulated figure with stand included. Approximately 100mm in height.', 386, '20220331163237-2022-03-31products163215.jpg', '20220331163237-2022-03-31products163217.jpg', '20220331163238-2022-03-31products163224.jpg'),
(11, 'Honor of Kings Chang&#39;e Princess of the Cold Moon Ver. 1/7 Scale Figure', 'Series: Honor of Kings\r\nCategory: Scale Figures\r\nSKU: S6971995421696\r\nDescription: Estimate Size: H350mm', 369, '20240123160603-2024-01-23products16054300095421696_01.jpg', '20240123160602-2024-01-23products16054200095421696_03.jpg', '20240123160603-2024-01-23products16054300095421696_04.jpg'),
(12, 'Girls&#39; Frontline AK-Alfa 1/7 Scale Figure', 'Series: Girls&#39; Frontline\r\nCategory: Scale Figures\r\nSKU: S4560393842886\r\nDescription: Estimate Size: H235mm', 166, '20240131122627-2024-01-31products12261000093842886_03.jpg', '20240131122628-2024-01-31products12261200093842886_06.jpg', '20240131122628-2024-01-31products12261300093842886_08.jpg'),
(13, 'Minato Aqua AQUA IRO SUPER DREAM Ver. 1/7 Scale Figure', 'Series :Hololive Production\r\nCategory :Scale Figures\r\nSKU :S4580416944427\r\nDescription :\r\nThe idol maid Aqua is here!\r\nFrom the popular VTuber group &#34;hololive production&#34; comes a 1/7 scale figure of the virtual maid Minato Aqua!\r\nAqua has been brought into figure form wearing her gorgeous princess dress from her first solo live event, &#34;Aqua Iro Super Dream♪&#34;.\r\nSpecifications: Painted plastic 1/7 scale complete product with stand included. Approximately 240mm in height.', 382, '20220225161152-2022-02-25products160951.jpg', '20220225161153-2022-02-25products160953.jpg', '20220225161153-2022-02-25products160955.jpg'),
(14, 'Genshin Impact Fischl 1/7 Scale Figure', 'Series :Genshin Impact\r\nCategory :Scale Figures\r\nSKU :S4560228206807\r\nDescription :Estimate Size: H290mm', 418, '20231228174245-2023-12-28products17415000028206807_05.jpg', '20231228174246-2023-12-28products17415100028206807_06.jpg', '20231228174246-2023-12-28products17415100028206807_07.jpg'),
(15, 'Accessories SPY x FAMILY Bangs Clip Vol. 2 B Anya & Bond', 'Series :SPY x FAMILY\r\nCategory :Accessories\r\nSKU :S4580721981254\r\nDescription :Estimate Size: H45 x W45 x D8mm\r\nRandom chose.', 11, '20230202173606-2023-02-02products173604000981254_01.jpg', '20230202173554-2023-02-02products173544000981246_01.jpg', '10941753a.jpg'),
(16, 'Accessories Genshin Impact Day of Destiny Gift Set Random', '1. Yanfei\r\n2. Hutao\r\n3. Chongyun\r\nSeries: Genshin Impact\r\nCategory: Accessories\r\nSKU: S6975213680889\r\nDescription: Estimate Size: Badge: 58mm Shikishi: 150 x 150mm Envelope: 110 x 160mm (contains Letter and Sticker) All items come in a packaged box', 30, '20221223142102-2022-12-23products142046GOODS-04241755.jpg', '20221223142430-2022-12-23products142357GOODS-04241756.jpg', '20221223142447-2022-12-23products142440GOODS-04241757.jpg'),
(17, 'Accessories Chainsaw Man Bangs Clip Set Random', '1. Makima\r\n2. Hayakawa Aki\r\n3. Power\r\nSeries: Chainsaw Man\r\nCategory: Accessories\r\nSKU: S4582662924017\r\nDescription: Estimate Size: H44 x W60 x D10mm', 14, '20221026085939-2022-10-26products085937000924019_01.jpg', '20221026085955-2022-10-26products085953000924025_01.jpg', '20221026090015-2022-10-26products090012000924032_01.jpg'),
(18, 'Accessories Chainsaw Man Bangs Clip Set Random 2', '1. Denji \r\n2. Himeno\r\n3. Higashiyama Kobeni\r\nSeries: Chainsaw Man \r\nCategory: Accessories \r\nSKU: S4582662924017 \r\nDescription: Estimate Size: H44 x W60 x D10mm', 14, '20221026085923-2022-10-26products085919000924002_01.jpg', '20221026090034-2022-10-26products090032000924048_01.jpg', '20221026090051-2022-10-26products090049000924055_01.jpg'),
(19, 'Nendoroid Honkai Star Rail 2276 Dan Heng', 'Series: Honkai: Star Rail\r\nCategory: Nendoroids\r\nSKU: S4580590177130\r\nDescription: A Nendoroid of Dan Heng comes from the popular game &#34;Honkai: Star Rail&#34;!\r\nFaceplates: Standard face, Concentrating face, Sidelong glancing face\r\nOptional parts: Cloud-Piercer, Autumn leaf, Smartphone\r\nOther optional parts for different poses.\r\nEstimate Size: H100mm', 511, '20231003150202-2023-10-03products1501194580590177130.jpg', '20231003150204-2023-10-03products1501224580590177130-3.jpg', '20231003150203-2023-10-03products1501204580590177130-7.jpg'),
(20, '(New) Overlord Albedo: Black Bunny Ver. 1/4 Scale Figure', 'Series: Overlord\r\nProduct Line: B-style\r\nManufacturer: FREEing\r\nSpecifications: Painted, non-articulated, 1/4 scale PVC figure\r\nHeight (approx.): 300 mm | 11.8&#34;\r\nLength (approx.): 440 mm | 17.3&#34;', 1350, '04e6edc6f4b9455fa85d9d3c8e789fb5.jpg.webp', '6e651c455b184253ac99b9edb5a32b5f.jpg.webp', '33e52d48a0be4524959d9502e5df5704.jpg.webp'),
(21, '(New) Pop Up Parade JoJo&#39;s Bizarre Adventure: Battle Tendency Joseph Joestar', 'Series: JoJo&#39;s Bizarre Adventure: Battle Tendency\r\nProduct Line: POP UP PARADE\r\nManufacturer: Good Smile Company\r\nSculptor: Kurosawatsu (Acxyz Creativ)\r\nSpecifications: Painted, non-articulated, non-scale plastic figure with stand\r\nHeight (approx.): 190 mm | 7.5&#34;', 68, '11421c9ef8ff48268e4df15174e0778b.jpg.webp', '5918f7afddee4b69bcf759b2d5382958.jpg.webp', 'ed4f14d894cd43f7b9ce98b411291396.jpg.webp'),
(22, '(New) Bunny Girl Anna 1/4 Scale Figure', 'Manufacturer: FIGMON\r\nSpecifications: Painted, non-articulated, 1/4 scale PVC&ABS figure with stand\r\nHeight (approx.): 450 mm | 17.7&#34; (including stand)', 288, 'cf5721dd854f4a96803fb713c5203497.jpg.webp', 'fedbf397ba4643b78479db10ba196dbe.jpg.webp', '2c7d764907e44386b29c29f6475ba190.jpg.webp'),
(23, 'RG 1/144 V GUNDAM / NU GUNDAM', 'MANUFACTURER : BANDAI\r\nGRADE : REAL GRADE (RG)\r\nRELEASE DATE : JUL., 2019\r\nWEIGHT : 1452 GRAMS', 160, 'image_4761.jpg', '1.jpg', '2.jpg'),
(24, 'RG 1/144 HI-Ν GUNDAM HI-NU GUNDAM', 'MANUFACTURER : BANDAI\r\nGRADE : REAL GRADE (RG)\r\nRELEASE DATE : SEP., 2021\r\nWEIGHT : 3790 GRAMS', 176, 'image_6374.jpg', '1 (1).jpg', '2 (1).jpg'),
(25, 'RG 1/144 FULL ARMOR UNICORN GUNDAM', 'MANUFACTURER : BANDAI\r\nGRADE : REAL GRADE (RG)\r\nRELEASE DATE : DEC., 2018\r\nWEIGHT : 2481 GRAMS', 194, 'image_4371.jpg', '2 (2).jpg', '3.jpg'),
(26, '13602 FFS STUDIO Raiden Shogun (GK)', 'Product number: 13602\r\nTeam: FFS STUDIO\r\nSize: Height 25CM', 1099, '72758275.webp', '72758269.webp', '72758277.webp'),
(27, '(New) reservation 13617 Flash Studio Nika Lufi (GK)', 'Product Code: 13617\r\nTeam: Flash Studio          \r\nConfiguration main body + platform', 600, '72796200.webp', '72796199.webp', '72796196.webp'),
(28, 'AniMester - Jujutsu Kaisen Gojo Satoru (GK)', 'Studio: AniMester\r\nProduct Category: Anime Action Figure, Statues, Collectibles\r\nProduct Name: Jujutsu Kaisen Gojo Satoru\r\nMaterial: PVC, ABS', 550, '1_dcfdd2db-8bf4-44a7-925e-682fa53077d5.webp', '4_1c82421f-2906-4f3f-a898-e367b705c194.webp', '7_3b6b5c89-b9a8-43f2-a402-53c54e727ef8.webp'),
(29, 'Kodansha - Fairy Tail Erza Scarlet Heaven’s Wheel Armor Version (GK)', 'Studio:  Kodansha \r\nProduct Category: Anime Action Figure, Statues, Collectibles\r\nMaterial: Resin, PU Resin (Polyurethane) \r\nRatio: 1/6 \r\nEst. Size:  50cm (L) x 50cm (W) x 58cm (H)', 2799, 'image_784605db-f309-47d5-bcbc-4a890a816283.webp', 'image_16d32ed9-1a9a-4ff2-8500-bd80055917ae.webp', 'image_de99ca02-0fcb-4e40-ad59-07dab94441c6.webp'),
(30, 'Nendoroid Honkai Star Rail 2276 March 7th', 'Series: Honkai: Star Rail\r\nCategory: Nendoroids\r\nSKU: S4580590177130\r\nDescription: A Nendoroid of March 7th comes from the popular game &#34;Honkai: Star Rail&#34;!\r\nFaceplates: Standard face, Concentrating face, Sidelong glancing face\r\nOptional parts: Cloud-Piercer, Autumn leaf, Smartphone\r\nOther optional parts for different poses.\r\nEstimate Size: H100mm', 511, '427894083_345757805192107_7511603364909456440_n.jpg', '441419225_345757778525443_8165966731963488287_n.jpg', '441889738_345757798525441_8459399972030402331_n.jpg'),
(31, 'Nendoroid 1979 Hoshimachi Suisei', 'Series: Hoshimachi Suisei\r\nCategory: Nendoroids \r\nSKU: SG24001118\r\nDescription: Sharing a warm winter delicacy with you. \r\nEstimate Size: H100mm', 369, '442474800_345756748525546_7409350585181179571_n.jpg', '440871867_345756751858879_8921728632711257233_n.jpg', '441899403_345756758525545_7562903260101193185_n.jpg'),
(32, 'Modoking 1/12 Batman Tumbler & the Bat-Pod Batmobile GUNDAM / NU GUNDAM', 'Features:\r\n- Batman Tumbler and The Bat-Pod in a box\r\n- Batman Black Tumbler is approximately 37cm\r\n- The Bat-Pod is approximately 28.8cm\r\n- The Bat-Pod can be stored underneath the Black Tumbler\r\n- The tumbler has 6 LED Light Set, also comes with effect part\r\n- 1/12 Modoking Batman (Not included) can sit in the Batman Tumbler', 699, '436405989_759142936354535_8583960117908757415_n.jpg', '441950829_759143463021149_7459024471346475942_n.jpg', '442468636_759143806354448_792753366162724218_n.jpg'),
(33, 'EINTA INDUSTRIES 1/72 SKY DEFENDER ASSEMBLY GUNDAM MODEL KIT', 'Features:\r\n- Inner frame with metal parts\r\n- Body height 27cm, total height with accessories up to 34cm\r\n- Body weight upto 1.11kg\r\n- Width with full wings open up to 50cm\r\n- Total runners parts 1108 parts\r\n- High precision decal paper\r\n- Etching stickers\r\n- Manual book with full color\r\n- Spectacular action base - can be used to store all the weapons and armors ', 699, '428698566_714818357453660_7130420505813482127_n.jpg', '428707790_714818587453637_1039815319868886699_n.jpg', '428695642_714818690786960_7128756816655954205_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `phoneNum` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address1`, `address2`, `address3`, `phoneNum`) VALUES
(1, 'kiankee357', 'kiankee357@yahoo.com', '52cde7788bfc8c985eec58560040f294eca15b0b', NULL, NULL, NULL, NULL),
(2, 'low', 'lowrenxing@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', NULL, NULL, NULL, NULL),
(5, 'kexin', 'xinke0202@gmail.com', '48d26a72adebe65089182c31b24fb1ccb24d8b0e', NULL, NULL, NULL, NULL),
(6, 'xin', 'kexin@gmail.com', '62becc49ca74c5a31e644661984635fa18d37a81', NULL, NULL, NULL, NULL),
(7, 'lowrenxing', 'lowrenxing2003@gmail.com', 'fa0c208897c5b217b1bb7ed4024417a71b7fa2e0', '7,jalan berlian, 4 taman berlian, 83700 Yong peng', 'C-12-05, MC Office, Ixora Apartment Melaka Tengah, Melaka, 75450', '', '0175831405');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
