-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 15, 2025 at 01:41 PM
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
-- Database: `ecommerceDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`product_id`, `user_id`, `added_at`) VALUES
(2, 1, '2024-12-23 12:03:14'),
(160, 1, '2025-01-13 19:37:26'),
(1, 1, '2025-01-15 00:02:11'),
(144, 1, '2025-01-15 00:02:22'),
(145, 1, '2025-01-15 00:02:27'),
(146, 1, '2025-01-15 00:02:33'),
(182, 1, '2025-01-15 00:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `feedback_email` varchar(100) NOT NULL,
  `feedback_body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `feedback_email`, `feedback_body`, `created_at`) VALUES
(3, 'basilissarantis@gmail.com', 'This website is kinda shit.', '2025-01-15 13:28:15'),
(4, 'bobmarley@gmail.com', 'You should add a star system to the reviews instead of a like button.', '2025-01-15 13:29:44'),
(5, 'margy@unipi.gr', 'This website needs more payment options.', '2025-01-15 13:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `placement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `product_id`, `image_name`, `placement`) VALUES
(44, 1, 'image-44.png', 1),
(45, 2, 'image-45.png', 1),
(46, 2, 'image-46.webp', 2),
(47, 2, 'image-47.webp', 3),
(48, 2, 'image-48.webp', 4),
(53, 143, 'image-53.webp', 1),
(57, 143, 'image-57.webp', 2),
(58, 143, 'image-58.webp', 3),
(59, 143, 'image-59.webp', 4),
(60, 143, 'image-60.webp', 5),
(61, 144, 'image-61.jpg', 1),
(62, 145, 'image-62.jpg', 1),
(63, 147, 'image-63.webp', 1),
(64, 147, 'image-64.webp', 2),
(65, 147, 'image-65.webp', 3),
(66, 148, 'image-66.webp', 1),
(67, 148, 'image-67.webp', 2),
(68, 148, 'image-68.webp', 3),
(69, 149, 'image-69.webp', 1),
(70, 149, 'image-70.webp', 2),
(71, 149, 'image-71.webp', 3),
(72, 149, 'image-72.webp', 4),
(73, 149, 'image-73.webp', 5),
(74, 149, 'image-74.webp', 6),
(75, 149, 'image-75.webp', 7),
(76, 149, 'image-76.webp', 8),
(77, 150, 'image-77.webp', 1),
(78, 151, 'image-78.webp', 1),
(79, 151, 'image-79.webp', 2),
(80, 151, 'image-80.webp', 3),
(81, 151, 'image-81.webp', 4),
(82, 152, 'image-82.webp', 1),
(83, 153, 'image-83.webp', 1),
(84, 154, 'image-84.webp', 1),
(85, 155, 'image-85.webp', 1),
(86, 156, 'image-86.webp', 1),
(87, 146, 'image-87.jpg', 1),
(88, 157, 'image-88.webp', 1),
(89, 158, 'image-89.webp', 1),
(90, 159, 'image-90.webp', 1),
(91, 160, 'image-91.webp', 1),
(92, 160, 'image-92.webp', 2),
(93, 160, 'image-93.webp', 3),
(94, 160, 'image-94.webp', 4),
(95, 160, 'image-95.webp', 5),
(96, 160, 'image-96.webp', 6),
(97, 160, 'image-97.webp', 7),
(98, 161, 'image-98.webp', 1),
(99, 161, 'image-99.webp', 2),
(100, 161, 'image-100.webp', 3),
(101, 161, 'image-101.webp', 4),
(102, 161, 'image-102.webp', 5),
(103, 161, 'image-103.webp', 6),
(104, 162, 'image-104.webp', 1),
(105, 162, 'image-105.webp', 2),
(106, 162, 'image-106.webp', 3),
(107, 162, 'image-107.webp', 4),
(108, 162, 'image-108.webp', 5),
(109, 163, 'image-109.webp', 1),
(110, 163, 'image-110.webp', 2),
(111, 163, 'image-111.webp', 3),
(112, 163, 'image-112.webp', 4),
(113, 163, 'image-113.webp', 5),
(114, 164, 'image-114.webp', 1),
(115, 164, 'image-115.jpg', 2),
(116, 164, 'image-116.webp', 3),
(117, 164, 'image-117.webp', 4),
(118, 164, 'image-118.jpg', 5),
(119, 165, 'image-119.webp', 1),
(120, 165, 'image-120.webp', 2),
(121, 165, 'image-121.jpg', 3),
(122, 165, 'image-122.webp', 4),
(123, 166, 'image-123.webp', 1),
(124, 166, 'image-124.webp', 2),
(125, 167, 'image-125.webp', 1),
(126, 169, 'image-126.webp', 1),
(127, 168, 'image-127.webp', 1),
(128, 170, 'image-128.webp', 1),
(129, 171, 'image-129.webp', 1),
(130, 172, 'image-130.webp', 1),
(131, 173, 'image-131.webp', 1),
(132, 174, 'image-132.webp', 1),
(133, 175, 'image-133.webp', 1),
(134, 176, 'image-134.webp', 1),
(135, 177, 'image-135.webp', 1),
(136, 178, 'image-136.jpg', 1),
(137, 179, 'image-137.webp', 1),
(138, 180, 'image-138.jpg', 1),
(139, 181, 'image-139.webp', 1),
(140, 181, 'image-140.webp', 2),
(141, 181, 'image-141.webp', 3),
(142, 182, 'image-142.webp', 1),
(143, 182, 'image-143.webp', 2),
(144, 182, 'image-144.webp', 3),
(145, 183, 'image-145.webp', 1),
(146, 183, 'image-146.jpg', 2),
(147, 183, 'image-147.jpg', 3),
(148, 183, 'image-148.jpg', 4),
(149, 183, 'image-149.jpg', 5),
(150, 183, 'image-150.jpg', 6),
(151, 183, 'image-151.jpg', 7),
(152, 183, 'image-152.jpg', 8),
(153, 184, 'image-153.webp', 1),
(154, 184, 'image-154.webp', 2),
(155, 184, 'image-155.webp', 3),
(156, 185, 'image-156.jpg', 1),
(157, 186, 'image-157.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderProducts`
--

CREATE TABLE `orderProducts` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `returned` int(11) NOT NULL DEFAULT 0 COMMENT 'changed by admin manually'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderProducts`
--

INSERT INTO `orderProducts` (`order_id`, `product_id`, `quantity`, `price`, `returned`) VALUES
(17, 1, 2, 26, 0),
(17, 2, 1, 48, 0),
(18, NULL, 1, 1, 0),
(18, NULL, 1, 1, 0),
(18, NULL, 1, 1, 0),
(19, 160, 1, 26, 0),
(19, 186, 1, 7, 0),
(19, 185, 1, 35, 0),
(19, 165, 3, 30, 0),
(19, 177, 5, 17, 0),
(19, 180, 2, 23, 0),
(19, 182, 5, 12, 0),
(19, 149, 1, 50, 0),
(19, 161, 1, 30, 0),
(20, 160, 3, 26, 0),
(21, 184, 1, 9, 0),
(22, 164, 10, 3, 4),
(23, 166, 10, 26, 0),
(24, 144, 1, 55, 0),
(24, 143, 1, 40, 0),
(24, 183, 2, 9, 0),
(24, 181, 4, 16, 0),
(25, NULL, 17, 123, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_email` varchar(100) NOT NULL,
  `order_first_name` varchar(30) NOT NULL,
  `order_last_name` varchar(30) NOT NULL,
  `order_country` varchar(255) NOT NULL,
  `order_city` varchar(255) NOT NULL,
  `order_address` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `cancelled_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_email`, `order_first_name`, `order_last_name`, `order_country`, `order_city`, `order_address`, `created_at`, `cancelled_at`) VALUES
(17, 1, 'basilissarantis@gmail.com', 'Bill', 'Sarantis', 'Greece', 'Alimos', 'Homeless', '2025-01-10 14:18:17', NULL),
(18, 8, 'koroniosthanos2003@gmail.com', 'θανος', 'θανουλης', 'Greece', 'Piraeus', 'Homeful', '2025-01-10 21:38:40', NULL),
(19, 1, 'basilissarantis@gmail.com', 'Bill', 'Sarantis', 'Greece', 'Alimos', 'Homeless', '2025-01-13 18:26:52', NULL),
(20, 1, 'basilissarantis@gmail.com', 'Bill', 'Sarantis', 'Greece', 'Alimos', 'Homeless', '2025-01-13 19:38:10', NULL),
(21, 1, 'basilissarantis@gmail.com', 'Bill', 'Sarantis', 'Greece', 'Alimos', 'Homeless', '2025-01-13 19:38:50', NULL),
(22, 1, 'basilissarantis@gmail.com', 'Bill', 'Sarantis', 'Greece', 'Alimos', 'Homeless', '2025-01-13 19:45:17', NULL),
(23, 1, 'basilissarantis@gmail.com', 'Bill', 'Sarantis', 'Greece', 'Alimos', 'Homeless', '2025-01-14 22:17:08', NULL),
(24, 1, 'basilissarantis@gmail.com', 'Bill', 'Sarantis', 'Greece', 'Alimos', 'Homeless', '2025-01-14 23:37:46', NULL),
(25, 8, 'basilissarantis@gmail.com', 'Αργυρώ', 'Μαυρογιώργου', 'Greece', 'Piraeus', 'Homeful', '2025-01-15 11:50:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `sales` int(11) NOT NULL DEFAULT 0,
  `category` enum('Other','Paper','Book') NOT NULL DEFAULT 'Other',
  `discount` decimal(2,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `stock`, `description`, `sales`, `category`, `discount`, `created_at`) VALUES
(1, '75cm Super large size SAOC Color Paper, Double-sided extra large', 26.00, 197, '60gsm, each size with different colors\r\n\r\n75cm*75cm，15sheets', 43, 'Paper', 0.00, '2024-12-18 22:11:11'),
(2, 'Origami Works of Takashi Hojyo', 48.00, 96, 'Origami Works of Takashi Hojyo\r\n\r\nModel Design and Diagrams : Takashi Hojyo\r\nEditor : Makoto Yamaguchi\r\nBilingual (Japanese and English)\r\n\r\nSize : B5 (18.2cm X 25.7cm)\r\nPages : 212(includes 4 pages of color photo)\r\n11 models', 4, 'Book', 0.00, '2024-12-18 22:11:11'),
(143, 'Origami Works of Gen Hagiwara', 40.00, 99, 'Model Design and Diagrams : Gen Hagiwara\r\nEditor : Makoto Yamaguchi / Translator : Koichi Tateishi\r\nBilingual (Japanese and English)\r\n\r\n\r\nSize : B5 (18.2cm X 25.7cm)\r\nPages : 180 (includes 4 pages of color photo)\r\n20 models', 1, 'Book', 0.20, '2025-01-13 12:06:55'),
(144, 'Origami Works of Satoshi Kamiya', 55.00, 49, 'Model Design and Diagrams : Satoshi Kamiya\r\nEditor : Makoto Yamaguchi / Translator : Koichi Tateishi\r\nBilingual (Japanese and English)\r\n\r\nSize : B5 (18.2cm X 25.7cm)\r\nPages : 228 (includes 4 pages of color photo)\r\n19 models', 51, 'Book', 0.00, '2025-01-13 12:13:14'),
(145, 'Origami Works of Satoshi Kamiya 2', 55.00, 50, 'Works of Satoshi Kamiya 2\r\n\r\nModel Design and Diagrams : Satoshi Kamiya\r\nEditor : Makoto Yamaguchi / Translator : Koichi Tateishi\r\nBilingual (Japanese and English)\r\n\r\nSize : B5 (18.2cm X 25.7cm)\r\nPages : 232 (includes 8 pages of color photo)\r\n16 models', 30, 'Book', 0.00, '2025-01-13 12:15:14'),
(146, 'Origami Works of Satoshi Kamiya 3', 55.00, 50, 'Origami Works of Satoshi Kamiya 3\r\n\r\nModel Design and Diagrams : Satoshi Kamiya\r\nEditor : Makoto Yamaguchi / Translator : Koichi Tateishi\r\nBilingual (Japanese and English)\r\n\r\nSize : B5 (18.2cm X 25.7cm)\r\nPages : 232 (includes 8 pages of color photo)\r\n15 models', 20, 'Book', 0.00, '2025-01-13 12:16:45'),
(147, 'Origami Works of Kyohei Katsuta', 40.00, 100, 'Model Design and Diagrams : Kyohei Katsuta\r\nEditor : Makoto Yamaguchi / Translator : Koichi Tateishi\r\nBilingual (Japanese and English)\r\n\r\nSize : B5 (18.2cm X 25.7cm)\r\nPages : 180 (includes 4 pages of color photo)\r\n13 models', 0, 'Book', 0.50, '2025-01-13 12:18:16'),
(148, 'Origami Works of Kyohei Katsuta 2', 45.00, 200, 'Model Design and Diagrams : Kyohei Katsuta\r\nEditor : Makoto Yamaguchi / Translator : Koichi Tateishi\r\nBilingual (Japanese and English)\r\n\r\nSize : B5 (18.2cm X 25.7cm)\r\nPages : 180 (includes 4 pages of color photo)\r\n12 models', 0, 'Book', 0.00, '2025-01-13 12:20:44'),
(149, 'Potential Origami Collection (KOA2023 Origami Collection)', 50.00, 49, 'Step-by-step instructions for folding 11 designs by Korea&#039;s greatest artists.\r\n\r\n   -Doberman - Park Jong Woo\r\n   -Rabbit - Yoo Tae Yong\r\n   -Egret - Jeong Jae II\r\n   -Lion - Jang Yong Ik\r\n   -La nascita di Venere - Han Ji Woo\r\n   -Basilik Lizard 2.0 - Kim Jin Woo\r\n   -Armored Criket - Maeng Hyeong Kyu\r\n   -Horse - jeong Jae II\r\n   -Phoenix - Park Jong Woo\r\n   -Luminous dragon - Lee In Seop\r\n   -Centaur - Yoo Tae Yong\r\n\r\nDetails:\r\n\r\n   -256 pages, paperback\r\n   -Step-by-step folding instructions to fold 11 models\r\n   -Languages: Korean', 1, 'Book', 0.00, '2025-01-13 12:25:50'),
(150, 'The 13th KOREA ORIGAMI CONVENTION diagrams collection 2023', 26.00, 30, 'Product Details:\r\nsoftcover: 142 pages\r\nDate : 2023\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.20, '2025-01-13 12:28:43'),
(151, 'The 14th KOREA ORIGAMI CONVENTION diagrams collection 2024', 26.00, 300, 'Product Details:\r\nsoftcover: 147 pages\r\nDate : 2024\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.00, '2025-01-13 12:31:44'),
(152, 'The 5th KOREA ORIGAMI CONVENTION diagrams collection 2014', 26.00, 0, 'Product Details:\r\nsoftcover:\r\nDate : 2014\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.00, '2025-01-13 12:33:58'),
(153, 'The 6th KOREA ORIGAMI CONVENTION diagrams collection 2015', 26.00, 13, 'Product Details:\r\nsoftcover:\r\nDate : 2015\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.00, '2025-01-13 12:35:42'),
(154, 'The 7th KOREA ORIGAMI CONVENTION diagrams collection 2016', 26.00, 30, 'Product Details:\r\nsoftcover:\r\nDate : 2016\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.40, '2025-01-13 12:37:40'),
(155, 'The 8th KOREA ORIGAMI CONVENTION diagrams collection 2017', 26.00, 30, 'Product Details:\r\nsoftcover:\r\nDate : 2017\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.00, '2025-01-13 12:40:22'),
(156, 'The 9th KOREA ORIGAMI CONVENTION diagrams collection 2018', 26.00, 30, 'Product Details:\r\nsoftcover:\r\nDate : 2018\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.00, '2025-01-13 12:41:19'),
(157, 'The 10th KOREA ORIGAMI CONVENTION diagrams collection 2019', 26.00, 10, 'Product Details:\r\nsoftcover:\r\nDate : 2019\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.40, '2025-01-13 12:51:42'),
(158, 'The 11th KOREA ORIGAMI CONVENTION diagrams collection 2021', 26.00, 30, 'Product Details:\r\nsoftcover:\r\nDate : 2021\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.00, '2025-01-13 12:52:53'),
(159, 'The 12th KOREA ORIGAMI CONVENTION diagrams collection 2022', 26.00, 30, 'Product Details:\r\nsoftcover:\r\nDate : 2022\r\nLanguage: Korean\r\nProduct Dimensions: 21 cm x 29.7 cm', 0, 'Book', 0.00, '2025-01-13 12:54:17'),
(160, 'Origami Cats &amp; Dogs Premium', 26.00, 96, '◆CONTENTS◆\r\n1　おすわりネコ Joisel Cat\r\n2　のびをする猫　Stretching Cat\r\n3　おねむなにゃんこ　Sleepy Cat\r\n4　魚をくわえた猫　Cat Catching Fish\r\n5　ジョワゼルネコ　Joisel Cat\r\n6　白黒ねこ　Black and White Cat\r\n7　ペルシャ猫　Persian Cat\r\n8　脱力猫　Lazy Cat\r\n9　にゃんこ　Purring Cat\r\n10　つままれにゃんこ　Naughty Cat\r\n11　コーギー　Corgi\r\n12　アメリカンコッカースパニエル　American Cocker Spaniel\r\n13　チャウチャウ　Chow Chow\r\n14　ミニチュアシュナウザー　Miniature Schnauzer\r\n15　ヨークシャー　Yorkshire Terrier\r\n16　パピヨン　Papillon\r\n17　ボーダーコリー　Border Collie\r\n18　柴犬　Shiba-inu\r\n19　日本犬　Japanese Dog\r\n20　ゴールデンレトリバー　Golden Retriever\r\n21　フレンチブルドッグ　French Bulldog\r\n22　ダルメシアン　Dalmatian', 4, 'Book', 0.00, '2025-01-13 12:57:07'),
(161, 'Origami Dragons Premiun', 30.00, 29, '', 1, 'Book', 0.20, '2025-01-13 12:59:17'),
(162, 'New Generation of Origami', 40.00, 40, '28 models by young origami creators.\r\nAuthor：Yamaguchi Makoto)\r\nLanguage : Japanese\r\nSize：182 x 234mm\r\nPages : 272 / All color', 0, 'Book', 0.00, '2025-01-13 13:02:04'),
(163, 'New Generation of Origami 2', 40.00, 30, '', 0, 'Book', 0.00, '2025-01-13 13:02:56'),
(164, 'Japan foil paper KOMA', 2.50, 290, 'Foil paper\r\nExtremely thin\r\n10 colors\r\ntotal 12 sheets\r\n30gsm', 110, 'Paper', 0.00, '2025-01-13 13:40:59'),
(165, 'Hanji paper thin for complex origami double sided', 30.00, 27, 'hanji paper\r\n~40gsm\r\n11 colors\r\n16 sheets\r\n60 cm', 47, 'Paper', 0.00, '2025-01-13 13:44:31'),
(166, 'SAOC-Miogami,Washi paper, Thin and strong, Super Complex Origami', 26.00, 0, '50cm\r\n12 sheets\r\n\r\nQualities:\r\n\r\n1. For complex models: it is thin and quite strong, even thinker layers~\r\n\r\n2. Surface texture: Japanese traditional origami texture, but does not shed hair and color\r\n\r\n3. For Tessellations: easy to fold and thin, with the light, it is beautiful~', 30, 'Paper', 0.00, '2025-01-13 13:50:23'),
(167, 'Origami Tanteidan Convention Vol. 19', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:55:44'),
(168, 'Origami Tanteidan Convention Vol. 20', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:56:39'),
(169, 'Origami Tanteidan Convention Vol. 21', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:56:39'),
(170, 'Origami Tanteidan Convention Vol. 22', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:56:39'),
(171, 'Origami Tanteidan Convention Vol. 23', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:56:39'),
(172, 'Origami Tanteidan Convention Vol. 24', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:56:39'),
(173, 'Origami Tanteidan Convention Vol. 25', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:56:39'),
(174, 'Origami Tanteidan Convention Vol. 26', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:56:39'),
(175, 'Origami Tanteidan Convention Vol. 27', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:56:39'),
(176, 'Origami Tanteidan Convention Vol. 28', 30.00, 20, NULL, 0, 'Book', 0.00, '2025-01-13 13:56:39'),
(177, 'Qingyun paper thin and strong 30gsm', 16.50, 95, '50cm\r\n9 sheets\r\n3 colors', 5, 'Paper', 0.25, '2025-01-13 14:05:49'),
(178, 'Pack Washi Deluxe', 14.00, 30, '24cm\r\n14 sheets', 0, 'Paper', 0.00, '2025-01-13 14:09:54'),
(179, 'Pack Sandwich Papers (Double Colored)', 23.00, 30, '40cm\r\n10 sheets\r\nSides have different colors', 0, 'Paper', 0.00, '2025-01-13 14:12:03'),
(180, 'Pack Sandwich Papers (White Side)', 23.00, 28, '40cm\r\n10 sheets', 2, 'Paper', 0.00, '2025-01-13 14:13:17'),
(181, 'Elephant Hide Paper', 16.00, 26, '(((Not actual elephant skin)))\r\n\r\nIvory (total 36 sheets) 34cm/24 sheets+28cm/12sheets', 4, 'Paper', 0.50, '2025-01-13 14:17:03'),
(182, 'Biotope Origami Paper', 12.00, 45, '50cm\r\n13 sheets\r\n53 gsm', 5, 'Paper', 0.00, '2025-01-13 14:19:41'),
(183, 'Satogami Origami Paper', 8.90, 48, '50cm\r\n6 sheets\r\n80 gsm', 2, 'Paper', 0.00, '2025-01-13 14:26:00'),
(184, 'Jade Paper', 9.00, 29, '20cm\r\n20 sheets\r\n50 gsm', 1, 'Paper', 0.00, '2025-01-13 14:41:19'),
(185, 'ALVIN GBM Self-Healing Cutting Mat', 35.00, 29, '18 x 24 inch\r\nDouble-Sided Green/Black\r\n5-Layer Gridded Surface for Arts, Crafts and Sewing - Model GBM1824', 1, 'Other', 0.00, '2025-01-13 14:49:04'),
(186, 'Stanley 10-280 18 mm Quick-Point Snap-Off Knife', 7.00, 19, '-Made with stainless steel and high impact polymer components.\r\n    -The smooth slider mechanism features an audible &quot;click-stop&quot; and is self locking for security.\r\n    -Blade sections snap-off providing the user with fresh, sharp cutting points.\r\n    -Removable blade snapper included in cap of knife.\r\n    -High visibility spare blade holder designed for safety.\r\n    -6-3/4&quot; (179mm) handle length\r\n    -Made with stainless steel and high impact polymer components\r\n    -Smooth slider mechanism features an audible &quot;click&quot; and is self-locking for security\r\n    -Blade sections snap off to provide fresh, sharp cutting points. Removable blade snapper included in cap of knife\r\n    -Limited Lifetime Warranty', 1, 'Other', 0.00, '2025-01-13 14:52:25');

-- --------------------------------------------------------

--
-- Table structure for table `productTags`
--

CREATE TABLE `productTags` (
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productTags`
--

INSERT INTO `productTags` (`product_id`, `tag_id`) VALUES
(1, 1),
(2, 3),
(143, 3),
(144, 3),
(144, 3),
(145, 3),
(146, 3),
(147, 3),
(148, 3),
(149, 4),
(150, 4),
(151, 4),
(152, 4),
(153, 4),
(154, 4),
(155, 4),
(156, 4),
(157, 4),
(158, 4),
(159, 4),
(164, 1),
(165, 1),
(165, 10),
(166, 2),
(166, 10),
(176, 5),
(175, 5),
(174, 5),
(173, 5),
(172, 5),
(171, 5),
(170, 5),
(169, 5),
(168, 5),
(167, 5),
(177, 2),
(178, 1),
(179, 1),
(180, 1),
(181, 2),
(181, 10),
(182, 2),
(182, 10),
(183, 2),
(183, 10),
(184, 1),
(186, 6);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `body`, `created_at`) VALUES
(23, 164, 1, 1, 'this paper cured my cancer', '2025-01-13 19:45:43'),
(24, 160, 1, 1, 'This book is good, blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah \r\n\r\n\r\nblaaaaaaaah', '2025-01-14 22:25:40');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(30) NOT NULL,
  `tag_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`, `tag_category`) VALUES
(1, 'Double Sided Paper', 'Paper'),
(2, 'One Sided Paper', 'Paper'),
(3, 'JOAS', 'Book'),
(4, 'KOA', 'Book'),
(5, 'Tanteidan', 'Book'),
(6, 'Cutting Tool', 'Other'),
(10, 'Untreated Paper', 'Paper');

-- --------------------------------------------------------

--
-- Table structure for table `userLogs`
--

CREATE TABLE `userLogs` (
  `user_id` int(11) NOT NULL,
  `login_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `logout_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userLogs`
--

INSERT INTO `userLogs` (`user_id`, `login_datetime`, `logout_datetime`) VALUES
(1, '2025-01-05 14:19:19', '2025-01-05 14:39:43'),
(8, '2025-01-05 14:22:21', '2025-01-05 14:30:17'),
(1, '2025-01-05 14:40:45', '2025-01-05 14:57:33'),
(8, '2025-01-05 14:57:42', '2025-01-05 15:04:27'),
(8, '2025-01-05 15:05:34', '2025-01-05 16:53:53'),
(1, '2025-01-05 16:53:59', '2025-01-05 20:58:12'),
(8, '2025-01-05 20:58:21', NULL),
(8, '2025-01-07 15:10:53', '2025-01-07 21:32:15'),
(1, '2025-01-07 17:50:01', NULL),
(8, '2025-01-07 21:32:23', '2025-01-07 21:32:27'),
(8, '2025-01-07 21:32:30', '2025-01-08 17:26:02'),
(8, '2025-01-08 17:40:41', '2025-01-08 20:25:10'),
(1, '2025-01-08 20:25:16', '2025-01-08 20:25:22'),
(1, '2025-01-08 20:25:28', '2025-01-08 20:33:24'),
(1, '2025-01-08 20:33:33', '2025-01-08 20:33:36'),
(8, '2025-01-08 20:33:41', '2025-01-09 12:19:04'),
(8, '2025-01-09 13:08:53', '2025-01-09 13:47:12'),
(8, '2025-01-09 13:47:51', '2025-01-09 13:48:13'),
(1, '2025-01-10 12:55:16', '2025-01-10 13:03:54'),
(8, '2025-01-10 13:03:58', '2025-01-10 14:16:55'),
(1, '2025-01-10 14:16:58', '2025-01-10 14:20:10'),
(8, '2025-01-10 14:20:13', '2025-01-10 14:58:39'),
(1, '2025-01-10 14:58:42', '2025-01-10 21:36:35'),
(8, '2025-01-10 21:36:38', '2025-01-10 21:58:21'),
(8, '2025-01-12 19:37:17', '2025-01-12 23:32:12'),
(1, '2025-01-12 23:32:15', '2025-01-12 23:32:24'),
(8, '2025-01-12 23:32:27', '2025-01-12 23:36:54'),
(1, '2025-01-12 23:36:58', '2025-01-12 23:37:28'),
(8, '2025-01-12 23:37:31', '2025-01-13 12:05:16'),
(1, '2025-01-13 12:05:19', '2025-01-13 12:05:25'),
(8, '2025-01-13 12:05:29', NULL),
(1, '2025-01-13 18:24:13', '2025-01-13 19:40:04'),
(8, '2025-01-13 19:40:07', '2025-01-13 19:40:15'),
(1, '2025-01-13 19:41:17', '2025-01-13 19:43:37'),
(1, '2025-01-13 19:43:49', '2025-01-13 19:44:19'),
(1, '2025-01-13 19:44:33', '2025-01-13 19:54:11'),
(8, '2025-01-13 19:54:17', '2025-01-13 21:10:06'),
(1, '2025-01-14 20:36:23', '2025-01-14 20:36:42'),
(1, '2025-01-14 20:55:28', '2025-01-15 00:14:07'),
(8, '2025-01-15 00:20:37', '2025-01-15 11:48:36'),
(1, '2025-01-15 11:48:39', '2025-01-15 11:49:34'),
(8, '2025-01-15 11:49:37', '2025-01-15 13:24:55'),
(1, '2025-01-15 13:25:00', '2025-01-15 13:34:51'),
(8, '2025-01-15 13:34:54', '2025-01-15 13:51:55'),
(1, '2025-01-15 13:52:41', '2025-01-15 13:56:24'),
(8, '2025-01-15 13:56:28', '2025-01-15 14:03:00'),
(1, '2025-01-15 14:13:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'hashed',
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `first_name`, `last_name`, `created_at`, `country`, `city`, `address`, `role`) VALUES
(1, 'basilissarantis@gmail.com', '$2y$10$xPvwaiECD3njI/UpUw5bfuv1Ag4zp6I2wY/4OpFC.CenSWmvt5OJW', 'Bill', 'Sarantis', '2024-12-18 13:50:11', 'Greece', 'Alimos', 'Homeless', 'user'),
(8, 'admin@gmail.com', '$2y$10$HUjgyDCMJ/yJDgnNHo61BOg3LN2oCVFUe9jneLRSymBIX6s4EDNNu', 'Αργυρώ', 'Μαυρογιώργου', '2024-12-18 17:50:26', 'Greece', 'Piraeus', 'Homeful', 'admin'),
(15, 'test3', 'pass', 'etest', 'e', '2024-12-24 17:49:07', '', '', '', 'user'),
(16, 'test4', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(17, 'test5', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(18, 'test6', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(19, 'test7', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(20, 'test8', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(21, 'test9', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(22, 'test10', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(23, 'test11', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(24, 'test12', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(25, 'test13', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(26, 'test14', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(27, 'test15', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(28, 'test16', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user'),
(29, 'test17', 'pass', 'e', 'e', '2024-12-24 17:49:07', NULL, NULL, NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD KEY `favorites_ibfk_1` (`product_id`),
  ADD KEY `favorites_ibfk_2` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `images_ibfk_1` (`product_id`);

--
-- Indexes for table `orderProducts`
--
ALTER TABLE `orderProducts`
  ADD KEY `orderProducts_ibfk_2` (`product_id`),
  ADD KEY `orderProducts_ibfk_1` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `productTags`
--
ALTER TABLE `productTags`
  ADD KEY `productTags_ibfk_1` (`product_id`),
  ADD KEY `productTags_ibfk_2` (`tag_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `reviews_ibfk_1` (`product_id`),
  ADD KEY `reviews_ibfk_2` (`user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `userLogs`
--
ALTER TABLE `userLogs`
  ADD KEY `userLogs_ibfk_1` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orderProducts`
--
ALTER TABLE `orderProducts`
  ADD CONSTRAINT `orderProducts_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderProducts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `productTags`
--
ALTER TABLE `productTags`
  ADD CONSTRAINT `productTags_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productTags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `userLogs`
--
ALTER TABLE `userLogs`
  ADD CONSTRAINT `userLogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
