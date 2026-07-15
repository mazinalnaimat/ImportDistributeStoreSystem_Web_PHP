-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 15, 2026 at 05:58 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basic_dgs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `BranchId` int NOT NULL AUTO_INCREMENT,
  `BranchName` varchar(50) NOT NULL,
  `CreatedUserId` int NOT NULL,
  `CreatedDateTime` datetime NOT NULL,
  `Phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `BranchImgName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`BranchId`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`BranchId`, `BranchName`, `CreatedUserId`, `CreatedDateTime`, `Phone`, `Email`, `Address`, `BranchImgName`) VALUES
(1, 'الأفق - خلدا', 1, '2026-07-01 09:15:00', '1234213242', 'khalda@alofoq.com', 'Amman - khalda', '7d6ec8d7-2184-49ee-a7ea-7507b92784e6.png'),
(2, 'الأفق - وسط البلد', 1, '2026-07-02 10:30:00', '57678678', 'albalad@alofoq.com', 'Amman - Down Town', '7f1cc17a-a494-4500-8aa3-75e2106a9289.png'),
(3, 'الأفق - معان', 1, '2026-07-03 11:20:00', '7527856785', 'maan@alofoq.com', 'Ma\'an', '1a6b2b63-d633-4852-8bd3-9b9d463070d2.png'),
(9, 'سلط', 1, '2026-07-05 14:45:00', '7867867867', 'salt@alofoq.com', 'Salt', '57bd2641-bd88-47a8-b7f3-b5c581a39b91.png'),
(10, 'الأفق - المطار', 1, '2026-07-08 16:10:00', '786786', 'almatar@alofoq.com', 'Amman - Airport Road Street', 'a80597b3-0340-43d5-a26d-b294ccb8ce90.png'),
(16, 'خلدا 2', 1, '2026-07-15 01:43:33', '2390849823', 'khalda2@alofoq.com', 'Amman - Khalda', '8ab4366a-5826-4600-83df-0e88aaa2278a.png');

-- --------------------------------------------------------

--
-- Table structure for table `distribution_products`
--

DROP TABLE IF EXISTS `distribution_products`;
CREATE TABLE IF NOT EXISTS `distribution_products` (
  `DistributionProductId` int NOT NULL AUTO_INCREMENT,
  `PurchasedProductId` int NOT NULL,
  `BranchId` int NOT NULL,
  `CreatedUserId` int NOT NULL,
  `CreatedDateTime` datetime NOT NULL,
  `ExportToBranchDateTime` datetime NOT NULL,
  `Quantity` int NOT NULL,
  `FinalSellingPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`DistributionProductId`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `distribution_products`
--

INSERT INTO `distribution_products` (`DistributionProductId`, `PurchasedProductId`, `BranchId`, `CreatedUserId`, `CreatedDateTime`, `ExportToBranchDateTime`, `Quantity`, `FinalSellingPrice`) VALUES
(15, 15, 1, 0, '2026-07-08 15:00:00', '2026-07-12 14:30:00', 20, 150.00),
(14, 15, 1, 0, '2026-07-07 13:20:00', '2026-07-11 12:45:00', 10, 150.00),
(13, 14, 1, 0, '2026-07-06 11:45:00', '2026-07-09 10:15:00', 18, 920.00),
(12, 15, 10, 0, '2026-07-05 10:30:00', '2026-07-08 09:00:00', 30, 160.00),
(11, 15, 2, 0, '2026-07-04 09:10:00', '2026-07-06 08:30:00', 20, 150.00),
(16, 14, 3, 0, '2026-07-10 09:30:00', '2026-07-13 16:00:00', 30, 950.00),
(17, 13, 10, 0, '2026-07-15 16:30:42', '2026-07-18 17:30:00', 50, 1000.00),
(18, 14, 10, 0, '2026-07-15 16:38:54', '2026-07-18 20:38:00', 12, 930.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchased_products`
--

DROP TABLE IF EXISTS `purchased_products`;
CREATE TABLE IF NOT EXISTS `purchased_products` (
  `PurchasedProductId` int NOT NULL AUTO_INCREMENT,
  `PurchasedProductName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Quantity` int NOT NULL,
  `RemainingQuantity` int NOT NULL,
  `CreatedDateTime` datetime NOT NULL,
  `ImportArrivalDateTime` datetime NOT NULL,
  `PurchasePrice` decimal(10,2) NOT NULL,
  `BaseSellingPrice` decimal(10,2) NOT NULL,
  `Details` varchar(255) NOT NULL,
  `ProductImgName` varchar(255) NOT NULL,
  `SupplierName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`PurchasedProductId`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchased_products`
--

INSERT INTO `purchased_products` (`PurchasedProductId`, `PurchasedProductName`, `Quantity`, `RemainingQuantity`, `CreatedDateTime`, `ImportArrivalDateTime`, `PurchasePrice`, `BaseSellingPrice`, `Details`, `ProductImgName`, `SupplierName`) VALUES
(7, 'Laptop Dell G3 15', 20, 20, '2026-07-18 20:23:48', '2026-02-18 00:00:00', 560.00, 620.00, 'لابتوب Dell G3 15 يأتي بشاشة 15.6 بوصة بدقة FHD، ومعالج Intel Core i5 أو i7، وذاكرة وصول عشوائي تصل إلى 16 جيجابايت. يحتوي على كرت شاشة NVIDIA GeForce GTX مناسب للألعاب. يمتاز بتصميم أنيق ومتانة عالية، وبطارية تدوم لفترة جيدة. مناسب للألعاب والعمل المكتبي', '0333803a-70c0-4976-9934-146f3b47e20c.webp', 'البرق - عمان'),
(8, 'Samsung 65 7900F 4K Smart TV', 120, 120, '0000-00-00 00:00:00', '2026-02-02 00:00:00', 800.00, 950.00, 'تلفاز سامسونج 65 بوصة Crystal UHD U7900F بدقة 4K مع ألوان حية ووضوح عالي. يتميز بتقنية Crystal Display لتجربة مشاهدة واقعية. مزود بنظام Smart TV لتصفح التطبيقات والأفلام بسهولة. تصميم أنيق ونحيف يناسب أي غرفة. يدعم اتصال Wi-Fi وميزات متعددة للتحكم الذكي.', '094f3d80-c5b7-46a9-8dd2-b2d007302f97.webp', 'البرق - عمان'),
(9, 'TV Samsung N5200 Series Full HD ', 90, 90, '0000-00-00 00:00:00', '2026-01-13 00:00:00', 230.00, 300.00, 'يعتبر تلفزيون سامسونج N5200 مقاس 40 بوصة من أفضل الخيارات في فئته، حيث يأتي بدقة Full HD 1080p لعرض صورة واضحة ومشرقة. يدعم تقنيات اتصال متعددة تشمل Wi-Fi، USB، HDMI، Ethernet، والصوت البصري. يتميز بمعالج يحسّن جودة الصورة ويعزز التفاصيل. يمنحك تجربة Smar', 'd47aaeb8-4ce8-4cee-b531-097332d96e04.webp', 'Samix - بيجين - الصين'),
(10, 'TV Samsung 65-Inch Class Neo QLED 8K QN900F', 80, 80, '0000-00-00 00:00:00', '2026-01-20 00:00:00', 1000.00, 1150.00, 'تلفزيون سامسونج Neo QLED 8K مقاس 65 بوصة (QN900F) يقدم جودة صورة فائقة بدقة 8K مع ألوان وتفاصيل مذهلة. يستخدم تقنية Neo QLED لتحسين التباين والإضاءة الدقيقة. مزوّد بذكاء اصطناعي لتحسين المحتوى وجودة الصورة تلقائيًا. يتمتع بنظام Smart TV لدعم التطبيقات وال', 'db2a865c-209b-43d3-a2c3-e8c0e837eeaa.webp', 'Samix - بيجين - الصين'),
(11, 'TV LG 65-inch QNED99 MiniLED 8k Samrt TV', 140, 140, '0000-00-00 00:00:00', '2026-02-10 00:00:00', 850.00, 950.00, 'تلفزيون إل جي QNED99 مقاس 65 بوصة يأتي بدقة 8K لتفاصيل فائقة ووضوح غير مسبوق. يعتمد تقنية MiniLED + QNED لتحسين الإضاءة والتباين وتقديم ألوان أكثر دقة. مزوَّد بواجهة Smart TV للوصول السريع للتطبيقات والبث المباشر. يدعم تقنيات صوت وصورة متقدمة لتجربة سينما', 'e40eb5ac-acab-4699-b380-59cd033d629c.jpg', 'Samix - بيجين - الصين'),
(12, 'TV  LG 50 inch UHD AI UT81 4K Smart TV 2024', 60, 60, '0000-00-00 00:00:00', '2026-01-18 00:00:00', 800.00, 900.00, 'إليك وصفًا مختصرًا باللغة العربية لجهاز TV LG 50-inch UHD AI UT81 4K Smart TV 2024 في أقل من 5 أسطر:\r\n\r\nتلفزيون إل جي UT81 مقاس 50 بوصة بدقة 4K UHD يقدم صورة واضحة وتفاصيل غنية. مزوَّد بتقنية الذكاء الاصطناعي لتحسين جودة الصورة والصوت تلقائيًا. يدعم نظام ', '62097f16-3e0f-43e3-bdef-7c4df78cb10f.webp', 'Ran - بيجين - الصين'),
(13, ' Laptop ASUS TUF Gaming F16 13th Gen Intel® Core™ i5-13', 130, 80, '0000-00-00 00:00:00', '2026-01-12 00:00:00', 850.00, 950.00, 'لابتوب ASUS TUF Gaming F16 مزود بمعالج Intel Core i5-13th Gen لأداء قوي في الألعاب والمهام اليومية. يأتي بشاشة 16 بوصة عالية الوضوح مع معدل تحديث سريع لتجربة سلسة. يحتوي على كرت شاشة مخصص لتشغيل الألعاب والتطبيقات الثقيلة بكفاءة. يتميز بتبريد فعال وبطارية', '53b217a8-ba56-4597-aec4-c367ec849e2a.png', 'Ran - بيجين - الصين'),
(14, 'Laptop ASUS ROG Strix G16 13th Gen Intel® Core™ i5-13', 60, 0, '0000-00-00 00:00:00', '2026-02-01 00:00:00', 750.00, 900.00, 'لابتوب ASUS ROG Strix G16 مزود بمعالج Intel Core i5-13th Gen وأداء قوي يناسب الألعاب والتصميم. يتميز بشاشة 16 بوصة بدقة عالية ومعدل تحديث سريع لتجربة لعب سلسة. يحتوي على بطاقة رسومية قوية لتشغيل الألعاب الحديثة بكفاءة. تصميمه أنيق مع نظام تبريد متطور لتفا', 'c56eac15-6d20-42f8-bbcc-2117600fc0dc.png', 'Samix - بيجين - الصين'),
(15, 'Dell Monitor P2425H (2024) 24 IPS Full HD 100Hz', 80, 0, '0000-00-00 00:00:00', '2026-01-12 00:00:00', 120.00, 145.00, 'شاشة Dell P2425H مقاس 24 بوصة بتقنية IPS ودقة Full HD تقدم ألوانًا واضحة وزوايا رؤية واسعة. تتميز بمعدل تحديث 100 هرتز لعرض سلس وخالٍ من التقطيع. لها تصميم أنيق مع حواف رفيعة لتجربة مشاهدة مريحة. مناسبة للاستخدام المكتبي، الترفيهي، والعمل الإبداعي. توفر م', '370c7b1b-3896-4b6c-af6f-09a5b152875a.jpg', 'Samix - بيجين - الصين'),
(16, 'Dell Pro E2225HM 22 Full HD (1920x1080) Monitor', 40, 40, '0000-00-00 00:00:00', '2026-02-02 00:00:00', 80.00, 95.00, 'شاشة Dell Pro E2225HM مقاس 22 بوصة بدقة Full HD (1920×1080) تقدم وضوحًا جيدًا وألوانًا متوازنة للمستخدمين اليوميين. تتميز بتقنية IPS لزوايا رؤية واسعة وتجربة مشاهدة مريحة. تصميمها عملي وأنيق مع حواف رفيعة تناسب المكاتب والمنزل. مناسبة للاستخدام المكتبي، ا', '2b28995e-e4b0-4204-af31-a50c3d2faa33.png', 'البرق - عمان'),
(17, 'Laptop Dell Alienware 16 Aurora, Intel Core 5 Processor 210H', 45, 45, '0000-00-00 00:00:00', '2026-02-01 00:00:00', 650.00, 860.00, 'لابتوب Dell Alienware 16 Aurora مزوَّد بمعالج Intel Core i5-210H وأداء قوي مناسب للألعاب والتطبيقات الثقيلة. يأتي بشاشة 16 بوصة بجودة عرض ممتازة وتجربة لعب سلسة. يمتاز بنظام تبريد متقدّم لتقليل الحرارة أثناء الاستخدام الطويل. تصميمه أنيق ومتين مع إضاءة RG', '657bfe15-df34-4d4e-884a-1180b92de018.jpg', 'Samix - بيجين - الصين'),
(18, 'simone 12000 btu mini split air conditioner and heater', 80, 80, '0000-00-00 00:00:00', '2026-02-02 00:00:00', 500.00, 650.00, 'مكيف هواء وسخان Simone 12000 وحدة حرارية بريطانية يعمل بتقنية الإنفرتر لتوفير الطاقة.\r\nيغطي مساحة تقريبية 600–750 قدم مربع ويعمل على التبريد والتدفئة.\r\nمزود بعدة أوضاع: تبريد، تدفئة، مروحة، إزالة الرطوبة، ووضع النوم.\r\nيأتي مع وحدة داخلية وخارجية، جهاز تحك', '5bb8f5a9-b740-4530-a533-52eb7dbdc55a.webp', 'Samix - بيجين - الصين'),
(19, 'TURBRO 12,000 BTU Ductless Mini Split Inverter AC with Heat Pump', 20, 20, '0000-00-00 00:00:00', '2026-02-01 00:00:00', 500.00, 650.00, 'مكيف وتدفئة TURBRO 12,000 BTU Ductless Mini Split Inverter يعمل بتقنية الإنفرتر لتوفير الطاقة.\r\nيوفر تبريدًا وتدفئة لمساحات تصل إلى حوالي 750 قدم مربع.\r\nيأتي مع وحدة داخلية وخارجية وجهاز تحكم عن بُعد للتحكم السهل.\r\nيدعم تشغيل هادئ وكفاءة عالية طوال العام.', '79b7a02f-b637-4325-a99f-4095a77cf15a.jpg', 'Samix - بيجين - الصين'),
(20, 'Samsung 647 Liter Double Door Refrigerator with Digital Inverter Technology', 40, 40, '0000-00-00 00:00:00', '2026-02-01 00:00:00', 1200.00, 1300.00, 'ثلاجة سامسونج بسعة 647 لتر مع بابين مزدوجين وتقنية الإنفرتر الرقمي لتوفير الطاقة وكفاءة عالية.\r\nتوفر تبريدًا وتجميدًا متوازنًا لحفظ الطعام طازجًا لفترة أطول.\r\nتتميز بتصميم واسع ومنظم لتخزين كميات كبيرة بسهولة.\r\nتشمل رفوف قابلة للتعديل وصناديق حفظ متنوعة ل', 'f97f0b24-efa6-435b-b8ae-30c014af7172.webp', 'Samix - بيجين - الصين'),
(21, 'Samsung Bespoke AI French Door Refrigerator 26.7 Cu.ft757 L, Triple Cooling, Interior Display, Smart', 30, 30, '0000-00-00 00:00:00', '2026-02-03 00:00:00', 800.00, 950.00, 'ثلاجة سامسونج بيسبوك AI باب فرنسي بسعة 757 لتر مع تقنية التبريد الثلاثي Triple Cooling للحفاظ على الطعام طازجًا لفترة أطول.\r\nمزودة بشاشة داخلية للتحكم الذكي وعرض المعلومات بسهولة.\r\nتدعم التحكم الذكي بالذكاء الاصطناعي AI Smart Control لضبط الإعدادات تلقائي', 'b8376821-ec42-45ae-a6f5-9610f5ef9ff5.jpg', 'Samix - بيجين - الصين'),
(22, 'Logitech MX Mechanical Wireless Illuminated Performance Keyboard', 10, 10, '0000-00-00 00:00:00', '2026-02-12 00:00:00', 80.00, 90.00, 'لوحة مفاتيح ميكانيكية منخفضة الارتفاع تقدم إحساس كتابة ممتازاً وسريعاً.\r\nتعمل لاسلكياً عبر Bluetooth أو مستقبل Logi Bolt مع بطارية تدوم طويلاً.\r\nمزودة بإضاءة خلفية ذكية تتفاعل مع حركة اليد.\r\nتدعم الاتصال بثلاثة أجهزة مع التبديل بينها بلمسة زر.\r\nتصميم متين', '7a5384ab-dfc2-49a9-a5ea-ee0d431b5950.webp', 'Samix - بيجين - الصين'),
(23, 'mouse logitech m510', 20, 20, '2026-07-14 21:17:13', '2026-07-14 20:15:00', 30.00, 35.00, 'ماوس Logitech M510 هو فأرة لاسلكية مريحة مصممة للاستخدام اليومي والعمل لفترات طويلة.\r\nيعمل بتقنية الاتصال اللاسلكي 2.4 جيجاهرتز عبر مستقبل USB صغير (Nano Receiver).\r\nيحتوي على أزرار قابلة للتخصيص وعجلة تمرير تدعم التمرير الأفقي والرأسي لسهولة التنقل.\r\nيتم', '69af26ba-9e18-484f-948b-a27a56ffcaa9.jpg', 'Temu'),
(24, 'logitech keyboard k350', 60, 60, '2026-07-14 21:21:58', '2026-07-14 20:21:00', 50.00, 55.00, 'لوحة المفاتيح Logitech K350 هي لوحة لاسلكية بتصميم Wave المنحني، مما يوفر راحة أكبر أثناء الكتابة لفترات طويلة.\r\nتعمل بتقنية 2.4 جيجاهرتز عبر مستقبل Logitech Unifying USB، ويمكن توصيلها بسهولة بأجهزة الكمبيوتر المتوافقة.\r\nتحتوي على أزرار وسائط متعددة ومفا', 'bdaa566e-953c-435b-adae-f3d04339db58.jpg', 'Temu');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `DoB` date NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `PersonalImgName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `Password`, `FirstName`, `LastName`, `Gender`, `DoB`, `Phone`, `Email`, `Address`, `PersonalImgName`) VALUES
(1, 'Ahmed26', 'e9cee71ab932fde863338d08be4de9dfe39ea049bdafb342ce659ec5450b69ae', 'أحمد', 'عمران', 'm', '2001-09-20', '54486468', 'ahmed3em@example.com', 'عمان', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
