-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2018 at 08:09 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acme`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(10) UNSIGNED NOT NULL,
  `categoryName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Category classifications of inventory items';

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `categoryName`) VALUES
(1, 'Cannon'),
(2, 'Explosive'),
(3, 'Misc'),
(4, 'Rocket'),
(5, 'Trap');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `clientId` int(10) UNSIGNED NOT NULL,
  `clientFirstname` varchar(15) NOT NULL,
  `clientLastname` varchar(25) NOT NULL,
  `clientEmail` varchar(40) NOT NULL,
  `clientPassword` varchar(255) NOT NULL,
  `clientLevel` enum('1','2','3') NOT NULL DEFAULT '1',
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`clientId`, `clientFirstname`, `clientLastname`, `clientEmail`, `clientPassword`, `clientLevel`, `comments`) VALUES
(1, 'Kirk', 'Brown', 'reddogfan2@gmail.com', '$2y$10$Yf5FjK.l1oa1QQhs.6mvh.g/f8S6n80cMbsJexg37LSdVIj/22PnG', '3', ''),
(2, 'James', 'Brown', 'mumpster@gmail.com', '$2y$10$60omqYf8Oxgx6Rg/beIsb.ne2akLR2Uv66N.gzu2mnkKClBRwBM9u', '1', ''),
(3, 'Carolyn', 'Brown', 'mellie9496@gmail.com', '$2y$10$4RjMK182fX/PxkCqHzzrpOJ48LDcBh033HVpeyRo9PqYgfJQB5NDC', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imgId` int(10) UNSIGNED NOT NULL,
  `invId` int(10) UNSIGNED NOT NULL,
  `imgName` varchar(100) NOT NULL,
  `imgPath` varchar(150) NOT NULL,
  `imgDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`imgId`, `invId`, `imgName`, `imgPath`, `imgDate`) VALUES
(67, 8, 'anvil.png', '/acme/images/products/anvil.png', '2018-06-13 01:55:16'),
(68, 8, 'anvil-tn.png', '/acme/images/products/anvil-tn.png', '2018-06-13 01:55:16'),
(69, 3, 'catapult.png', '/acme/images/products/catapult.png', '2018-06-13 01:55:22'),
(70, 3, 'catapult-tn.png', '/acme/images/products/catapult-tn.png', '2018-06-13 01:55:22'),
(71, 14, 'helmet.jpg', '/acme/images/products/helmet.jpg', '2018-06-13 01:55:27'),
(72, 14, 'helmet-tn.jpg', '/acme/images/products/helmet-tn.jpg', '2018-06-13 01:55:27'),
(73, 4, 'roadrunner.jpg', '/acme/images/products/roadrunner.jpg', '2018-06-13 01:55:41'),
(74, 4, 'roadrunner-tn.jpg', '/acme/images/products/roadrunner-tn.jpg', '2018-06-13 01:55:41'),
(75, 5, 'trap.jpg', '/acme/images/products/trap.jpg', '2018-06-13 01:55:48'),
(76, 5, 'trap-tn.jpg', '/acme/images/products/trap-tn.jpg', '2018-06-13 01:55:48'),
(77, 13, 'piano.jpg', '/acme/images/products/piano.jpg', '2018-06-13 01:55:54'),
(78, 13, 'piano-tn.jpg', '/acme/images/products/piano-tn.jpg', '2018-06-13 01:55:54'),
(79, 6, 'hole.png', '/acme/images/products/hole.png', '2018-06-13 01:55:59'),
(80, 6, 'hole-tn.png', '/acme/images/products/hole-tn.png', '2018-06-13 01:55:59'),
(81, 7, 'no-image.png', '/acme/images/products/no-image.png', '2018-06-13 01:56:05'),
(82, 7, 'no-image-tn.png', '/acme/images/products/no-image-tn.png', '2018-06-13 01:56:05'),
(83, 10, 'mallet.png', '/acme/images/products/mallet.png', '2018-06-13 01:56:14'),
(84, 10, 'mallet-tn.png', '/acme/images/products/mallet-tn.png', '2018-06-13 01:56:14'),
(85, 9, 'rubberband.jpg', '/acme/images/products/rubberband.jpg', '2018-06-13 01:56:20'),
(86, 9, 'rubberband-tn.jpg', '/acme/images/products/rubberband-tn.jpg', '2018-06-13 01:56:20'),
(87, 2, 'mortar.jpg', '/acme/images/products/mortar.jpg', '2018-06-13 01:56:30'),
(88, 2, 'mortar-tn.jpg', '/acme/images/products/mortar-tn.jpg', '2018-06-13 01:56:30'),
(89, 15, 'rope.jpg', '/acme/images/products/rope.jpg', '2018-06-13 01:56:40'),
(90, 15, 'rope-tn.jpg', '/acme/images/products/rope-tn.jpg', '2018-06-13 01:56:40'),
(91, 12, 'seed.jpg', '/acme/images/products/seed.jpg', '2018-06-13 01:56:47'),
(92, 12, 'seed-tn.jpg', '/acme/images/products/seed-tn.jpg', '2018-06-13 01:56:47'),
(93, 1, 'rocket.png', '/acme/images/products/rocket.png', '2018-06-13 01:56:54'),
(94, 1, 'rocket-tn.png', '/acme/images/products/rocket-tn.png', '2018-06-13 01:56:54'),
(95, 17, 'bomb.jpg', '/acme/images/products/bomb.jpg', '2018-06-13 01:57:02'),
(96, 17, 'bomb-tn.jpg', '/acme/images/products/bomb-tn.jpg', '2018-06-13 01:57:02'),
(97, 16, 'fence.png', '/acme/images/products/fence.png', '2018-06-13 01:57:11'),
(98, 16, 'fence-tn.png', '/acme/images/products/fence-tn.png', '2018-06-13 01:57:11'),
(99, 11, 'tnt.jpg', '/acme/images/products/tnt.jpg', '2018-06-13 01:57:18'),
(100, 11, 'tnt-tn.jpg', '/acme/images/products/tnt-tn.jpg', '2018-06-13 01:57:18'),
(113, 4, 'roadrunner1.jpg', '/acme/images/products/roadrunner1.jpg', '2018-06-13 02:31:38'),
(114, 4, 'roadrunner1-tn.jpg', '/acme/images/products/roadrunner1-tn.jpg', '2018-06-13 02:31:38'),
(115, 4, 'roadrunner2.jpg', '/acme/images/products/roadrunner2.jpg', '2018-06-13 02:31:45'),
(116, 4, 'roadrunner2-tn.jpg', '/acme/images/products/roadrunner2-tn.jpg', '2018-06-13 02:31:45'),
(117, 17, 'bomb1.jpg', '/acme/images/products/bomb1.jpg', '2018-06-13 02:31:52'),
(118, 17, 'bomb1-tn.jpg', '/acme/images/products/bomb1-tn.jpg', '2018-06-13 02:31:52'),
(119, 17, 'bomb2.jpg', '/acme/images/products/bomb2.jpg', '2018-06-13 02:31:58'),
(120, 17, 'bomb2-tn.jpg', '/acme/images/products/bomb2-tn.jpg', '2018-06-13 02:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `invId` int(10) UNSIGNED NOT NULL,
  `invName` varchar(50) NOT NULL DEFAULT '',
  `invDescription` text NOT NULL,
  `invImage` varchar(50) NOT NULL DEFAULT '',
  `invThumbnail` varchar(50) NOT NULL DEFAULT '',
  `invPrice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invStock` smallint(6) NOT NULL DEFAULT '0',
  `invSize` smallint(6) NOT NULL DEFAULT '0',
  `invWeight` smallint(6) NOT NULL DEFAULT '0',
  `invLocation` varchar(35) NOT NULL DEFAULT '',
  `categoryId` int(10) UNSIGNED NOT NULL,
  `invVendor` varchar(20) NOT NULL DEFAULT '',
  `invStyle` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Acme Inc. Inventory Table';

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`invId`, `invName`, `invDescription`, `invImage`, `invThumbnail`, `invPrice`, `invStock`, `invSize`, `invWeight`, `invLocation`, `categoryId`, `invVendor`, `invStyle`) VALUES
(1, 'Rocket', 'Rocket for multiple purposes. This can be launched independently to deliver a payload or strapped on to help get you to where you want to be FAST!!! Really Fast!', '/acme/images/products/rocket.png', '/acme/images/products/rocket-tn.png', '1320.00', 5, 60, 90, 'California', 4, 'Goddard', 'metal'),
(2, 'Mortar', 'Our Mortar is very powerful. This cannon can launch a projectile or bomb 3 miles. Made of solid steel and mounted on cement or metal stands [not included].', '/acme/images/products/mortar.jpg', '/acme/images/products/mortar-tn.jpg', '1500.00', 26, 250, 750, 'San Jose', 1, 'Smith & Wesson', 'Metal'),
(3, 'Catapult', 'Our best wooden catapult. Ideal for hurling objects for up to 1000 yards. Payloads of up to 300 lbs.', '/acme/images/products/catapult.png', '/acme/images/products/catapult-tn.png', '2500.00', 4, 1569, 400, 'Cedar Point, IO', 1, 'Wooden Creations', 'Wood'),
(4, 'Female RoadRunner Cutout', 'This carbon fiber backed cutout of a female roadrunner is sure to catch the eye of any male roadrunner.', '/acme/images/products/roadrunner.jpg', '/acme/images/products/roadrunner-tn.jpg', '20.00', 500, 27, 2, 'San Jose', 5, 'Picture Perfect', 'Carbon Fiber'),
(5, 'Giant Mouse Trap', 'Our big mouse trap. This trap is multifunctional. It can be used to catch dogs, mountain lions, road runners or even muskrats. Must be staked for larger varmints [stakes not included] and baited with approptiate bait [sold seperately].\r\n', '/acme/images/products/trap.jpg', '/acme/images/products/trap-tn.jpg', '20.00', 34, 470, 28, 'Cedar Point, IO', 5, 'Rodent Control', 'Wood'),
(6, 'Instant Hole', 'Instant hole - Wonderful for creating the appearance of openings.', '/acme/images/products/hole.png', '/acme/images/products/hole-tn.png', '25.00', 269, 24, 2, 'San Jose', 3, 'Hidden Valley', 'Ether'),
(7, 'Koenigsegg CCX', 'This high performance car is sure to get you where you are going fast. It holds the production car land speed record at an amazing 250mph.', '/acme/images/products/no-image.png', '/acme/images/products/no-image.png', '500000.00', 1, 25000, 3000, 'San Jose', 3, 'Koenigsegg', 'Metal'),
(8, 'Anvil', '50 lb. Anvil - perfect for any task requireing lots of weight. Made of solid, tempered steel.', '/acme/images/products/anvil.png', '/acme/images/products/anvil-tn.png', '150.00', 15, 80, 50, 'San Jose', 5, 'Steel Made', 'Metal'),
(9, 'Monster Rubber Band', 'These are not tiny rubber bands. These are MONSTERS! These bands can stop a train locamotive or be used as a slingshot for cows. Only the best materials are used!', '/acme/images/products/rubberband.jpg', '/acme/images/products/rubberband-tn.jpg', '4.00', 4589, 75, 1, 'Cedar Point, IO', 3, 'Rubbermaid', 'Rubber'),
(10, 'Mallet', 'Ten pound mallet for bonking roadrunners on the head. Can also be used for bunny rabbits.', '/acme/images/products/mallet.png', '/acme/images/products/mallet-tn.png', '25.00', 100, 36, 10, 'Cedar Point, IA', 3, 'Wooden Creations', 'Wood'),
(11, 'TNT', 'The biggest bang for your buck with our nitro-based TNT. Price is per stick.', '/acme/images/products/tnt.jpg', '/acme/images/products/tnt-tn.jpg', '10.00', 1000, 25, 2, 'San Jose', 2, 'Nobel Enterprises', 'Plastic'),
(12, 'Roadrunner Custom Bird Seed Mix', 'Our best varmint seed mix - varmints on two or four legs can\'t resist this mix. Contains meat, nuts, cereals and our own special ingredient. Guaranteed to bring them in. Can be used with our monster trap.', '/acme/images/products/seed.jpg', '/acme/images/products/seed-tn.jpg', '8.00', 150, 24, 3, 'San Jose', 5, 'Acme', 'Plastic'),
(13, 'Grand Piano', 'This grand piano is guaranteed to play well and smash anything beneath it if dropped from a height.', '/acme/images/products/piano.jpg', '/acme/images/products/piano-tn.jpg', '3500.00', 36, 500, 1200, 'Cedar Point, IA', 3, 'Wulitzer', 'Wood'),
(14, 'Crash Helmet', 'This carbon fiber and plastic helmet is the ultimate in protection for your head. comes in assorted colors.', '/acme/images/products/helmet.png', '/acme/images/products/helmet-tn.png', '100.00', 25, 48, 9, 'San Jose', 3, 'Suzuki', 'Carbon Fiber'),
(15, 'Nylon Rope', 'This nylon rope is ideal for all uses. Each rope is the highest quality nylon and comes in 100 foot lengths.', '/acme/images/products/rope.jpg', '/acme/images/products/rope-tn.jpg', '15.00', 200, 200, 6, 'San Jose', 3, 'Marina Sales', 'Nylon'),
(16, 'Sticky Fence', 'This fence is covered with Gorilla Glue and is guaranteed to stick to anything that touches it and is sure to hold it tight.', '/acme/images/products/fence.png', '/acme/images/products/fence-tn.png', '75.00', 15, 48, 2, 'San Jose', 3, 'Acme', 'Nylon'),
(17, 'Small Bomb', 'Bomb with a fuse - A little old fashioned, but highly effective. This bomb has the ability to devistate anything within 30 feet.', '/acme/images/products/bomb.jpg', '/acme/images/products/bomb-tn.jpg', '275.00', 58, 30, 12, 'San Jose', 2, 'Nobel Enterprises', 'Metal');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` int(10) UNSIGNED NOT NULL,
  `reviewText` text NOT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invId` int(10) UNSIGNED NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewId`, `reviewText`, `reviewDate`, `invId`, `clientId`) VALUES
(19, 'asdg', '2018-06-13 07:22:18', 11, 1),
(20, 'Watch out! You might get your own head blown off by this. I&#39;ve lost 6 fingers and one leg! Be warned!', '2018-06-14 05:56:53', 11, 1),
(22, 'asldga;sldgha', '2018-06-14 06:03:16', 3, 1),
(24, 'aasgsadgf', '2018-06-14 06:07:19', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`clientId`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imgId`),
  ADD KEY `invId` (`invId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `FK_reviews_clients` (`clientId`),
  ADD KEY `FK_reviews_inventory` (`invId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `clientId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imgId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `invId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_inv_image` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_reviews_clients` FOREIGN KEY (`clientId`) REFERENCES `clients` (`clientId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_reviews_inventory` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
