-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2026 at 02:20 PM
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
-- Database: `shop_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `credit_book`
--

CREATE TABLE `credit_book` (
  `id` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `purchaseDate` date NOT NULL,
  `purchaseTotal` float(10,0) NOT NULL DEFAULT 0,
  `paid` float(10,0) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` int(11) NOT NULL,
  `phone2` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `district` varchar(30) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `fullName`, `email`, `mobile`, `phone2`, `address`, `address2`, `city`, `district`, `status`, `createdOn`) VALUES
(1, 'Regular1', NULL, 812221931, NULL, '', NULL, NULL, 'Abuja', 'Active', '2026-06-22 19:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `productID` int(11) NOT NULL,
  `itemNumber` varchar(255) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `unitPrice` float NOT NULL DEFAULT 0,
  `imageURL` varchar(255) NOT NULL DEFAULT 'imageNotAvailable.jpg',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`productID`, `itemNumber`, `itemName`, `discount`, `stock`, `unitPrice`, `imageURL`, `status`, `description`) VALUES
(1, '6mm slide binder', '6mm slide binder', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(2, '8mm slide binder', '8mm slide binder', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(3, '10mm slide binder', '10mm slide binder', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(4, '12mm slide binder', '12mm slide binder', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(5, 'long plastic ruler', 'long plastic ruler', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(6, 'short plastic ruler', 'short plastic ruler', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(7, 'long wooden ruler', 'long wooden ruler', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(8, 'push pin', 'push pin', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(9, 'fancy pencil', 'fancy pencil', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(10, 'HB pencil', 'HB pencil', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(11, '2B pencil', '2B pencil', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(12, 'non sharpen pencil', 'non sharpen pencil', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(13, 'tikky 20 eraser', 'tikky 20 eraser', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(14, 'small white eraser by 36', 'small white eraser by 36', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(15, 'tikky 30 eraser', 'tikky 30 eraser', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(16, 'heart sharpner', 'heart sharpner', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(17, 'permanent marker', 'permanent marker', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(18, 'a-star white board marker', 'a-star white board marker', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(19, 'a-star sharpner', 'a-star sharpner', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(20, '100 yards tape', '100 yards tape', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(21, '130 yards tape', '130 yards tape', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(22, '2 inch tape', '2 inch tape', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(23, '1 inch tape', '1 inch tape', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(24, '240 yards tape', '240 yards tape', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(25, '1000 yards tape', '1000 yards tape', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(26, 'water colour', 'water colour', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(27, '88 wax crayon', '88 wax crayon', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(28, '66 small wax crayon', '66 small wax crayon', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(29, 'wax crayon by 6', 'wax crayon by 6', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(30, 'wax crayon by 12', 'wax crayon by 12', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(31, 'swan glue', 'swan glue', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(32, 'Natarag mathset', 'Natarag mathset', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(33, 'stamp pad ink', 'stamp pad ink', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(34, '400 yards tape', '400 yards tape', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(35, 'oxford mathset', 'oxford mathset', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(36, '369 pin', '369 pin', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(37, '56 pin', '56 pin', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(38, 'skrebba pin', 'skrebba pin', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(39, 'short pencil colour', 'short pencil colour', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(40, 'kangaro stepler', 'kangaro stepler', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(41, 'small stepler', 'small stepler', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(42, 'Refillable marker', 'Refillable marker', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(43, 'correction pen', 'correction pen', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(44, 'New ink 50ml', 'New ink 50ml', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(45, 'bottle ink 500ml', 'bottle ink 500ml', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(46, 'whot', 'whot', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(47, 'white board duster', 'white board duster', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(48, 'Heavy duty punch', 'Heavy duty punch', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(49, 'Hand punch', 'Hand punch', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(50, 'double stamp pad', 'double stamp pad', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(51, 'hero stamp pad', 'hero stamp pad', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(52, 'pvc front', 'pvc front', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(53, 'pvc back', 'pvc back', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(54, 'blue carbon', 'blue carbon', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(55, 'laminating film', 'laminating film', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(56, 'thick clear bag', 'thick clear bag', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(57, 'light clear bag', 'light clear bag', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(58, 'T square', 'T square', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(59, 'set square', 'set square', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(60, 'french curve', 'french curve', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(61, 'Arch file', 'Arch file', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(62, 'A5 ring jotter', 'A5 ring jotter', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(63, 'A6 ring jotter', 'A6 ring jotter', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(64, 'B5 ring jotter', 'B5 ring jotter', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(65, 'A5 fancy notebook', 'A5 fancy notebook', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(66, '100 page jotter', '100 page jotter', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(67, '200 page jotter', '200 page jotter', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(68, 'A6 jotter', 'A6 jotter', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(69, 'A7 jotter', 'A7 jotter', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(70, '12 in one notebook', '12 in one notebook', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(71, '10 in one notebook', '10 in one notebook', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(72, '8 in one notebook', '8 in one notebook', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(73, '5 in one notebook', '5 in one notebook', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(74, 'hardcover no1 short', 'hardcover no1 short', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(75, 'hardcover no2 short', 'hardcover no2 short', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(76, 'hardcover no3 short', 'hardcover number 3 short', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(77, 'hardcover no4 short', 'hardcover number 4 short', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(78, 'hardcover no5 short', 'hardcover number 5 short', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(79, 'hardcover no1 long', 'hardcover number 1 long', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(80, 'hardcover no2 long', 'hardcover number 2 long', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(81, 'hardcover no3 long', 'hardcover number 3 long', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(82, 'hardcover no4 long', 'hardcover number 4 long', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(83, 'hardcover no5 long', 'hardcover number 5 long', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(84, 'small poster colour by 6', 'small poster colour by 6', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(85, 'big poster colour by 12', 'big poster colour by 12', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(86, 'big top gum', 'big top gum', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(87, 'small top gum', 'small top gum', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(88, 'small top bond', 'small top bond', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(89, 'POS paper', 'POS paper', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(90, '80/80 thermal paper', '80/80 thermal paper', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(91, 'A4 paper 70grams', 'A4 paper 70grams', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(92, 'A4 paper 75grams', 'A4 paper 75grams', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(93, 'A4 paper 80grams', 'A4 paper 80grams', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(94, 'vista 40 leaves', 'vista 40 leaves', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(95, 'vista 60 leaves', 'vista 60 leaves', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(96, 'vista 80 leaves short', 'vista 80 leaves short', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(97, 'vista 80 leaves long', 'vista 80 leaves long', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(98, 'vista 2A', 'vista 2A', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(99, 'vista 20', 'vista 20', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(100, '150grams rubber ring', '150grams rubber ring', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(101, '300grams rubber ring', '300grams rubber ring', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(102, 'Avanti golden pride biro blue', 'Avanti golden pride biro blue', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(103, 'Avanti m.gold biro blue', 'Avanti m.gold biro blue', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(104, 'Avanti leader biro blue', 'Avanti leader biro blue', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(105, 'Avanti superior biro blue', 'Avanti superior biro blue', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(106, 'vista dollar biro blue', 'vista dollar biro blue', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(107, 'vista max biro blue', 'vista max biro blue', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(108, 'vista titian biro blue', 'vista titian biro blue', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(109, 'EEZEE biro blue', 'EEZEE biro blue', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(110, 'EEZEE red biro', 'EEZEE red biro', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(111, 'EEZEE black biro', 'EEZEE black biro', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(112, 'Avanti black m.gold', 'Avanti black m.gold', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(113, 'Avanti black golden pride', 'Avanti black golden pride', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(114, 'Avanti black superior', 'Avanti black superior', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(115, 'Avanti red superior', 'Avanti red superior', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(116, 'Avanti red m.gold', 'Avanti red m.gold', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(117, 'Avanti red golden pride', 'Avanti red golden pride', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(118, '15/10 fullscap envelope', '15/10 fullscap envelope', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(119, '12/10 A4 envelop', '12/10 A4 envelop', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(120, '18/4 A3 envelope', '18/4 A3 envelope', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(121, '8/10 quotor envelope', '8/10 quotor envelope', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(122, '9/4 small envelope no glue brown', '9/4 small envelope without glue brown', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(123, '9/4 Niger Manivan brown', '9/4 Niger Manivan brown', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(124, 'masking tape', 'masking tape', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(125, '9/4 small white envelope', '9/4 small white envelope', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(126, 'sketch pad', 'sketch pad', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(127, 'big graph book', 'big graph book', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(128, 'small graph book', 'small graph book', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(129, 'big drawing book', 'big drawing book', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(130, 'office flat file', 'office flat file', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(131, 'Bic biro', 'Bic biro', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(132, 'casio fx-991Es plus white', 'casio fx-991Es plus white', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(133, 'casio FX-991 ms black', 'casio FX-991 ms black', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(134, 'porpo YH-2000', 'porpo YH-2000', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(135, 'porpo YH-105', 'porpo YH-105', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', ''),
(136, 'sutec mathset calculator', 'sutec mathset calculator', 0, 0, 0, 'imageNotAvailable.jpg', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchaseID` int(11) NOT NULL,
  `itemNumber` varchar(255) NOT NULL,
  `purchaseDate` date NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `unitPrice` float NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `vendorName` varchar(255) NOT NULL DEFAULT 'Test Vendor',
  `vendorID` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_archive`
--

CREATE TABLE `purchase_archive` (
  `purchaseID` int(11) NOT NULL,
  `itemNumber` varchar(255) NOT NULL,
  `purchaseDate` date NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `unitPrice` float NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `vendorName` varchar(255) NOT NULL DEFAULT 'Test Vendor',
  `vendorID` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `saleID` int(11) NOT NULL,
  `itemNumber` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `customerID` int(11) NOT NULL,
  `customerName` varchar(255) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `saleDate` date NOT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unitPrice` float(10,0) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_archive`
--

CREATE TABLE `sales_archive` (
  `saleID` int(11) NOT NULL,
  `itemNumber` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `customerID` int(11) NOT NULL,
  `customerName` varchar(255) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `saleDate` date NOT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unitPrice` float(10,0) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `fullName`, `username`, `password`, `status`) VALUES
(1, 'Admin', 'admin', 'b59c67bf196a4758191e42f76670ceba', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendorID` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(22) NOT NULL,
  `phone2` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `district` varchar(30) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendorID`, `fullName`, `email`, `mobile`, `phone2`, `address`, `address2`, `city`, `district`, `status`, `createdOn`) VALUES
(1, 'System Default', '', '803033405', 0, '', '', 'Suleja', 'Abuja', 'Active', '2026-05-28 08:04:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credit_book`
--
ALTER TABLE `credit_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchaseID`);

--
-- Indexes for table `purchase_archive`
--
ALTER TABLE `purchase_archive`
  ADD PRIMARY KEY (`purchaseID`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`saleID`);

--
-- Indexes for table `sales_archive`
--
ALTER TABLE `sales_archive`
  ADD PRIMARY KEY (`saleID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credit_book`
--
ALTER TABLE `credit_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchaseID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_archive`
--
ALTER TABLE `purchase_archive`
  MODIFY `purchaseID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `saleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_archive`
--
ALTER TABLE `sales_archive`
  MODIFY `saleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
