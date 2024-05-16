-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2024-05-16 20:26:33
-- 服务器版本： 10.4.27-MariaDB
-- PHP 版本： 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `shop_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin1', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(2, 'fkk', '86970064ea53b6d66b7c53cbc91c58b4f06fc6fd'),
(3, 'kexin', '6d04a668ccc2166d714a086df60aca8082ed8667'),
(4, 'lowrenxing', '601f1889667efaebb33b8c12572835da3f027f78');

-- --------------------------------------------------------

--
-- 表的结构 `cart`
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
-- 转存表中的数据 `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(3, 1, 2, 'Nendoroid 2339 Snow Miku: Winter Delicacy Ver.', 390, 1, '20240123154428-2024-01-23products154356G24001117.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `messages`
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
-- 转存表中的数据 `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 0, 'KKFONG', 'kiankee357@yahoo.com', '1', 'Hi, i love raiden shogun and achreon. They are my wife.'),
(2, 0, 'TKX', 'xinke0202@gmail.com', '1', 'Today\'s happiness can start from the small thungs.\r\nHappy Shopping!!!');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
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
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 1, 'Fong Kian Kee', '0197753357', 'kiankee357@yahoo.com', 'TNG eWallet', 'flat no. 3, Jalan Orchard Heights 3, Taman Orchard Heights, Batu Pahat, Johor, Malaysia - 83000', 'Hololive Production Usada Pekora 1/4 Scale Figure (1950 x 1) - ', 1950, '2024-04-25', 'pending');

-- --------------------------------------------------------

--
-- 表的结构 `products`
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
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`) VALUES
(1, 'Hololive Production Usada Pekora 1/4 Scale Figure', 'Series :Hololive Production\r\nCategory :Scale Figures\r\nSKU :S4570001512230\r\nDescription :Estimate Size H460mm', 1950, '20240123160944-2024-01-23products1609314570001512230.jpg', '20240123160945-2024-01-23products1609324570001512230-2.jpg', '20240123160945-2024-01-23products1609324570001512230-3.jpg'),
(2, 'Nendoroid 2339 Snow Miku: Winter Delicacy Ver.', 'Series :Hatsune Miku\r\nCategory :Nendoroids\r\nSKU :SG24001117\r\nDescription :Sharing a warm winter delicacy with you.\r\nEstimate Size: H100mm', 390, '20240123154428-2024-01-23products154356G24001117.jpg', '20240123154429-2024-01-23products154357G24001117-4.jpg', '20240123154429-2024-01-23products154357G24001117-5.jpg'),
(7, 'Nendoroid 1951 Nakiri Ayame', 'Series: Hololive production\r\nCategory: Nendoroids\r\nSKU: S4580590171022\r\n&#34;Greetings, Humans! Yoohoo!&#34;\r\nFrom the popular VTuber group &#34;hololive production&#34; comes a Nendoroid of hololive 2nd Generation VTuber Nakiri Ayame!\r\nShe comes with three interchangeable face plates including a standard, smug face, and excited face. Estimate Size: H100mm', 96, '20220916163445-2022-09-16products16343501.jpg', '20220916163444-2022-09-16products16343305.jpg', '20220916163445-2022-09-16products16343404.jpg'),
(8, 'Nendoroid 1861 Inugami Korone', 'Series :Hololive Production\r\nCategory :Nendoroids\r\nSKU :S4580590129214\r\nDescription :Estimate Size: H100mm', 86, '20220428171331-2022-04-28products171314.jpg', '20220428171332-2022-04-28products171320.jpg', '20220428171331-2022-04-28products171315.jpg'),
(9, 'Nendoroid 2216 Watson Amelia', 'Series: Hololive Production\r\nCategory: Nendoroids\r\nSKU: S4580590175693\r\nDescription :\r\nKonnichiWatson~\r\nFrom the popular virtual YouTube group &#34;hololive production&#34; comes a Nendoroid of English -Myth- VTuber Watson Amelia!\r\n\r\nFaceplates: Smiling face, Cheerful face, Smug face\r\nOptional parts: Magnifying glass, Bubba\r\nEstimate Size: H100mm', 86, '20230711173040-2023-07-11products17301500090175693_04.jpg', '20230711173039-2023-07-11products17301400090175693_03.jpg', '20230711173040-2023-07-11products17301700090175693_07.jpg'),
(10, 'Nendoroid 1856 Ookami Mio', 'Series: Hololive Production\r\nCategory: Nendoroids\r\nSKU: S4580590128569\r\nDescription :\r\n&#34;Hello! It is Ookami Mio!&#34;\r\nFrom the popular VTuber group &#34;hololive production&#34; comes a Nendoroid of hololive GAMERS VTuber Ookami Mio! She comes with three face plates including a standard face, and a smiling face.\r\nSpecifications: Painted plastic non-scale articulated figure with stand included. Approximately 100mm in height.', 86, '20220331163237-2022-03-31products163215.jpg', '20220331163237-2022-03-31products163217.jpg', '20220331163238-2022-03-31products163224.jpg'),
(11, 'Honor of Kings Chang&#39;e Princess of the Cold Moon Ver. 1/7 Scale Figure', 'Series: Honor of Kings\r\nCategory: Scale Figures\r\nSKU: S6971995421696\r\nDescription: Estimate Size: H350mm', 369, '20240123160603-2024-01-23products16054300095421696_01.jpg', '20240123160602-2024-01-23products16054200095421696_03.jpg', '20240123160603-2024-01-23products16054300095421696_04.jpg'),
(12, 'Girls&#39; Frontline AK-Alfa 1/7 Scale Figure', 'Series: Girls&#39; Frontline\r\nCategory: Scale Figures\r\nSKU: S4560393842886\r\nDescription: Estimate Size: H235mm', 166, '20240131122627-2024-01-31products12261000093842886_03.jpg', '20240131122628-2024-01-31products12261200093842886_06.jpg', '20240131122628-2024-01-31products12261300093842886_08.jpg'),
(13, 'Minato Aqua AQUA IRO SUPER DREAM Ver. 1/7 Scale Figure', 'Series :Hololive Production\r\nCategory :Scale Figures\r\nSKU :S4580416944427\r\nDescription :\r\nThe idol maid Aqua is here!\r\nFrom the popular VTuber group &#34;hololive production&#34; comes a 1/7 scale figure of the virtual maid Minato Aqua!\r\nAqua has been brought into figure form wearing her gorgeous princess dress from her first solo live event, &#34;Aqua Iro Super Dream♪&#34;.\r\nSpecifications: Painted plastic 1/7 scale complete product with stand included. Approximately 240mm in height.', 382, '20220225161152-2022-02-25products160951.jpg', '20220225161153-2022-02-25products160953.jpg', '20220225161153-2022-02-25products160955.jpg'),
(14, 'Genshin Impact Fischl 1/7 Scale Figure', 'Series :Genshin Impact\r\nCategory :Scale Figures\r\nSKU :S4560228206807\r\nDescription :Estimate Size: H290mm', 418, '20231228174245-2023-12-28products17415000028206807_05.jpg', '20231228174246-2023-12-28products17415100028206807_06.jpg', '20231228174246-2023-12-28products17415100028206807_07.jpg'),
(15, 'Accessories SPY x FAMILY Bangs Clip Vol. 2 B Anya & Bond', 'Series :SPY x FAMILY\r\nCategory :Accessories\r\nSKU :S4580721981254\r\nDescription :Estimate Size: H45 x W45 x D8mm\r\nRandom chose.', 11, '20230202173606-2023-02-02products173604000981254_01.jpg', '20230202173554-2023-02-02products173544000981246_01.jpg', '10941753a.jpg'),
(16, 'Accessories Genshin Impact Day of Destiny Gift Set Random', '1. Yanfei\r\n2. Hutao\r\n3. Chongyun\r\nSeries: Genshin Impact\r\nCategory: Accessories\r\nSKU: S6975213680889\r\nDescription: Estimate Size: Badge: 58mm Shikishi: 150 x 150mm Envelope: 110 x 160mm (contains Letter and Sticker) All items come in a packaged box', 30, '20221223142102-2022-12-23products142046GOODS-04241755.jpg', '20221223142430-2022-12-23products142357GOODS-04241756.jpg', '20221223142447-2022-12-23products142440GOODS-04241757.jpg'),
(17, 'Accessories Chainsaw Man Bangs Clip Set Random', '1. Makima\r\n2. Hayakawa Aki\r\n3. Power\r\nSeries: Chainsaw Man\r\nCategory: Accessories\r\nSKU: S4582662924017\r\nDescription: Estimate Size: H44 x W60 x D10mm', 14, '20221026085939-2022-10-26products085937000924019_01.jpg', '20221026085955-2022-10-26products085953000924025_01.jpg', '20221026090015-2022-10-26products090012000924032_01.jpg'),
(18, 'Accessories Chainsaw Man Bangs Clip Set Random 2', '1. Denji \r\n2. Himeno\r\n3. Higashiyama Kobeni\r\nSeries: Chainsaw Man \r\nCategory: Accessories \r\nSKU: S4582662924017 \r\nDescription: Estimate Size: H44 x W60 x D10mm', 14, '20221026085923-2022-10-26products085919000924002_01.jpg', '20221026090034-2022-10-26products090032000924048_01.jpg', '20221026090051-2022-10-26products090049000924055_01.jpg'),
(19, 'Nendoroid Honkai Star Rail 2276 Dan Heng', 'Series: Honkai: Star Rail\r\nCategory:Nendoroids\r\nSKU : S4580590177130\r\nDescription :\r\n&#34;The truth of life and death revealed in an instant.&#34;\r\nFrom the popular game &#34;Honkai: Star Rail&#34; comes a Nendoroid of Dan Heng!\r\n\r\nFaceplates: Standard face, Concentrating face, Sidelong glancing face\r\nOptional parts: Cloud-Piercer, Autumn leaf, Smartphone\r\nOther optional parts for different poses.\r\nEstimate Size: H100mm', 101, '20231003150202-2023-10-03products1501194580590177130.jpg', '20231003150204-2023-10-03products1501224580590177130-3.jpg', '20231003150203-2023-10-03products1501204580590177130-7.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'kiankee357', 'kiankee357@yahoo.com', '52cde7788bfc8c985eec58560040f294eca15b0b'),
(2, 'low', 'lowrenxing@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78'),
(5, 'kexin', 'xinke0202@gmail.com', '48d26a72adebe65089182c31b24fb1ccb24d8b0e'),
(6, 'xin', 'kexin@gmail.com', '62becc49ca74c5a31e644661984635fa18d37a81');

-- --------------------------------------------------------

--
-- 表的结构 `wishlist`
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
-- 转储表的索引
--

--
-- 表的索引 `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
