-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-11 21:40:26
-- 服务器版本： 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `carwashing`
--

-- --------------------------------------------------------

--
-- 表的结构 `car`
--

CREATE TABLE IF NOT EXISTS `car` (
  `id` int(11) NOT NULL,
  `plate` varchar(50) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `cus_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `car`
--

INSERT INTO `car` (`id`, `plate`, `brand`, `color`, `cus_id`) VALUES
(1, 'Chuan-A78U95', 'Honda', 'Blue', 1),
(2, 'Chuan-A66688', 'Ford', 'White', 1),
(3, 'Chuan-Q74110', 'BYD', 'White', 2),
(4, 'Chuan-Q54250', 'Ford', 'Grey', 2),
(5, 'Chuan-Q25045', 'Toyota', 'White', 2),
(6, 'Yu-B23454', 'Tesla', 'Black', 5),
(13, 'car1', '1', '1', 8),
(14, '', '', '', 8),
(15, '', '', '', 8),
(16, '1', '23', '2', 9),
(17, '3', '3', '3', 9),
(18, '', '', '', 9);

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `pwdhash` varchar(60) DEFAULT NULL,
  `salt` varchar(10) DEFAULT NULL,
  `FirstName` varchar(10) DEFAULT NULL,
  `LastName` varchar(10) NOT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `birth` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`id`, `username`, `pwdhash`, `salt`, `FirstName`, `LastName`, `sex`, `tel`, `address`, `balance`, `birth`) VALUES
(1, 'cus1', '4037f3d099eb4e3cd9e657df21936662', 'f018f9', 'Hao', 'Liu', 1, '123456789001', 'CDUTSong2-562', 146.3, '1996-06-01'),
(2, 'cus2', 'f056d6a7a5ec600efee50537bd50549f', 'd13ca1', 'Yuan', 'Tian', 1, '1829444332', 'CDUTSong2-334', 17.799999999999997, '1986-06-01'),
(5, 'kevin', '9abe16a3aa0abd091d9dfb9649080e37', '9879f9', 'Kevin', 'He', 3, '23333', 'CDUT562', 178, '1987-06-01'),
(8, 'test', 'e861c63b3bf88589fda553c977b0e538', 'bSK3NDPs', 'test', 'test', 2, '1233', '12333', 10, '1995-06-01'),
(9, 'test1', '96b2fde0498302384e5e282fa73e7150', '2/RwUARx', 'test1', '1', 1, '1', '1', 300.1, '1895-06-01');

-- --------------------------------------------------------

--
-- 表的结构 `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `pwdhash` varchar(60) DEFAULT NULL,
  `salt` varchar(10) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `hiredate` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `employee`
--

INSERT INTO `employee` (`id`, `username`, `pwdhash`, `salt`, `gender`, `birth`, `firstname`, `lastname`, `phone`, `role_id`, `hiredate`) VALUES
(1, 'Marshall', '434aebd7567c6a76dab0267bd10ddc10', 'c38142', 1, '1996-06-18', 'Marshall', 'Liu', '1234567890', 3, '2016-12-01'),
(2, 'Cary', '1252b17fb65291ece0f4ea4fa019de8f', 'e5b4c0', 1, '1996-02-13', 'Carry', 'Tian', '1234567890', 1, '2016-12-01'),
(3, 'Leo', '018e3904257d20399c7842526fc67c54', 'a99149', 1, '1995-04-23', 'Leo', 'Li', '1234567890', 2, '2016-12-01'),
(4, 'Kevin', 'ba16456bd49a53c1f3248055c0f0492e', '531ea7', 3, '1996-03-15', 'Kevin', 'He', '1234567890', 2, '2016-12-01'),
(5, 'test', '0cb0b90fdf40569ebae76f77c8bd64bd', 'pql7Nv6I', 3, NULL, '1', '1', '11099102', 4, '2017-03-26');

-- --------------------------------------------------------

--
-- 表的结构 `gender`
--

CREATE TABLE IF NOT EXISTS `gender` (
  `id` int(11) NOT NULL,
  `sex` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `gender`
--

INSERT INTO `gender` (`id`, `sex`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Unknown');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL,
  `cus_id` int(10) unsigned DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `rate` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `cus_id`, `Date`, `Time`, `status`, `rate`) VALUES
(41, 2, '2017-03-25', '19:21:56', 4, 5),
(50, 1, '2017-03-26', '00:26:40', 4, 0),
(51, 1, '2017-03-26', '01:03:19', 4, 2),
(53, 2, '2017-03-26', '03:03:03', 4, 3),
(56, NULL, '2017-03-26', '03:05:27', 4, 4),
(58, 8, '2017-03-26', '03:10:37', 3, 5),
(59, 5, '2017-03-28', '16:37:32', 3, 0),
(60, 2, '2017-03-28', '16:37:54', 2, 0),
(61, NULL, '2017-03-28', '16:38:19', 1, 0),
(62, NULL, '2017-04-02', '18:54:33', 1, 0),
(63, 5, '2017-04-03', '13:37:14', 4, 0),
(64, 1, '2017-04-03', '14:04:29', 4, 0),
(65, 5, '2017-04-03', '18:27:51', 4, 0),
(66, NULL, '2017-04-03', '19:24:24', 4, 0),
(67, NULL, '2017-04-03', '19:25:41', 3, 0),
(68, 1, '2017-04-11', '15:36:06', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `order_product`
--

CREATE TABLE IF NOT EXISTS `order_product` (
  `item_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned DEFAULT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `order_product`
--

INSERT INTO `order_product` (`item_id`, `order_id`, `product_id`, `Quantity`) VALUES
(98, 41, 3, 1),
(108, 50, 7, 1),
(109, 51, 17, 1),
(110, 53, 17, 1),
(112, 56, 3, 1),
(114, 58, 3, 1),
(115, 58, 4, 1),
(116, 58, 11, 1),
(117, 59, 3, 1),
(118, 59, 10, 1),
(119, 60, 17, 1),
(120, 60, 7, 1),
(121, 61, 6, 1),
(122, 62, 15, 1),
(123, 62, 13, 2),
(124, 63, 4, 1),
(125, 64, 9, 1),
(126, 64, 7, 1),
(127, 65, 11, 1),
(128, 66, 9, 2),
(129, 66, 7, 1),
(130, 67, 3, 1),
(131, 67, 9, 1),
(132, 67, 7, 1),
(133, 67, 15, 1),
(134, 68, 7, 1),
(135, 68, 15, 1);

-- --------------------------------------------------------

--
-- 表的结构 `order_service`
--

CREATE TABLE IF NOT EXISTS `order_service` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `order_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `order_service`
--

INSERT INTO `order_service` (`id`, `emp_id`, `car_id`, `order_id`) VALUES
(1, 2, 5, 41),
(6, 3, 2, 51),
(7, 2, 4, 53),
(10, 1, 13, 58),
(11, 3, 6, 59),
(12, 3, 5, 60),
(13, 3, 6, 63);

-- --------------------------------------------------------

--
-- 表的结构 `order_status`
--

CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `order_status`
--

INSERT INTO `order_status` (`id`, `status`) VALUES
(1, 'Pending'),
(2, 'Ongoing'),
(3, 'Unpaid'),
(4, 'Paid');

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL,
  `order_id` int(10) unsigned DEFAULT NULL,
  `cus_id` int(10) unsigned DEFAULT NULL,
  `price` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `pay_time` datetime DEFAULT NULL,
  `pay_type_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`id`, `order_id`, `cus_id`, `price`, `discount`, `pay_time`, `pay_type_id`, `emp_id`) VALUES
(10, 41, 5, 25, 0.9, '2017-03-25 21:13:02', 1, 1),
(11, 56, NULL, 25, 1, '2017-03-26 14:29:23', 3, 1),
(12, 51, 1, 45, 0.9, '2017-03-26 14:29:29', 1, 1),
(15, 53, 2, 45, 1, '2017-03-26 15:48:38', 2, 1),
(16, 50, 1, 180, 1, '2017-03-26 18:46:50', 2, 1),
(17, 66, NULL, 340, 1, '2017-04-03 19:24:36', 2, 1),
(18, 65, 5, 200, 1, '2017-04-06 03:13:47', 4, 1),
(19, 63, 5, 35, 0.9, '2017-04-11 15:36:56', 1, 1),
(20, 64, 9, 260, 1, '2017-04-11 15:51:51', 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `pay_type`
--

CREATE TABLE IF NOT EXISTS `pay_type` (
  `id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `pay_type`
--

INSERT INTO `pay_type` (`id`, `type`) VALUES
(1, 'Balance'),
(2, 'Alipay'),
(3, 'WeChat Pay'),
(4, 'Cash');

-- --------------------------------------------------------

--
-- 表的结构 `product_service`
--

CREATE TABLE IF NOT EXISTS `product_service` (
  `id` int(10) unsigned NOT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `product_service`
--

INSERT INTO `product_service` (`id`, `product_name`, `Price`, `type_id`) VALUES
(1, 'Service', NULL, 1),
(2, 'Accessories', NULL, 2),
(3, 'Small Car Washing', 25, 1),
(4, 'Big Car Washing', 35, 1),
(5, 'Wax', 120, 1),
(6, 'Polishing', 200, 1),
(7, 'Engine oil', 180, 2),
(8, 'Car Navigator ', 200, 2),
(9, 'Glass cleaning water ', 80, 2),
(10, 'Cushion ', 30, 2),
(11, 'Drive Recorder ', 200, 2),
(12, 'Drinks', NULL, 12),
(13, 'Cola', 4, 12),
(14, 'RedBull', 8, 12),
(15, 'Water', 3, 12),
(16, 'Fine Small Car Washing', 35, 1),
(17, 'Fine Big Car Washing', 45, 1);

-- --------------------------------------------------------

--
-- 表的结构 `recharge`
--

CREATE TABLE IF NOT EXISTS `recharge` (
  `id` int(11) NOT NULL,
  `cus_id` int(10) unsigned DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `pay_type_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `recharge`
--

INSERT INTO `recharge` (`id`, `cus_id`, `price`, `datetime`, `pay_type_id`, `emp_id`) VALUES
(12, 1, 120, '2017-03-21 15:00:43', 4, 2),
(13, 8, 10, '2017-03-26 03:11:21', 4, 1),
(14, 5, 200, '2017-03-28 16:39:34', 4, 1),
(15, 1, 123, '2017-04-06 03:14:22', 2, 1),
(16, 9, 10, '2017-04-06 03:14:47', 3, 1),
(18, 9, 300, '2017-04-11 15:49:44', 3, 1);

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`id`, `role`, `pid`) VALUES
(1, 'Manager', 3),
(2, 'Worker', 1),
(3, 'Super Admin', 0),
(4, 'Unvalidated', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`), ADD KEY `cus_id` (`cus_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`), ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`), ADD KEY `customer_id` (`cus_id`), ADD KEY `status` (`status`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`item_id`), ADD KEY `food_id` (`product_id`), ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_service`
--
ALTER TABLE `order_service`
  ADD PRIMARY KEY (`id`), ADD KEY `order_id` (`order_id`), ADD KEY `emp_id` (`emp_id`), ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`), ADD KEY `cus_id` (`cus_id`), ADD KEY `emp_id` (`emp_id`), ADD KEY `pay_type_id` (`pay_type_id`), ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `pay_type`
--
ALTER TABLE `pay_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_service`
--
ALTER TABLE `product_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recharge`
--
ALTER TABLE `recharge`
  ADD PRIMARY KEY (`id`), ADD KEY `emp_id` (`emp_id`), ADD KEY `pay_type_id` (`pay_type_id`), ADD KEY `cus_id` (`cus_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `order_service`
--
ALTER TABLE `order_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `pay_type`
--
ALTER TABLE `pay_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `product_service`
--
ALTER TABLE `product_service`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `recharge`
--
ALTER TABLE `recharge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- 限制导出的表
--

--
-- 限制表 `car`
--
ALTER TABLE `car`
ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `customer` (`id`);

--
-- 限制表 `employee`
--
ALTER TABLE `employee`
ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `customer` (`id`),
ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`status`) REFERENCES `order_status` (`id`);

--
-- 限制表 `order_product`
--
ALTER TABLE `order_product`
ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_service` (`id`);

--
-- 限制表 `order_service`
--
ALTER TABLE `order_service`
ADD CONSTRAINT `order_service_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
ADD CONSTRAINT `order_service_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`id`),
ADD CONSTRAINT `order_service_ibfk_3` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`);

--
-- 限制表 `payment`
--
ALTER TABLE `payment`
ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `customer` (`id`),
ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`id`),
ADD CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`pay_type_id`) REFERENCES `pay_type` (`id`),
ADD CONSTRAINT `payment_ibfk_4` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
ADD CONSTRAINT `payment_ibfk_5` FOREIGN KEY (`pay_type_id`) REFERENCES `pay_type` (`id`),
ADD CONSTRAINT `payment_ibfk_6` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- 限制表 `recharge`
--
ALTER TABLE `recharge`
ADD CONSTRAINT `recharge_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`id`),
ADD CONSTRAINT `recharge_ibfk_2` FOREIGN KEY (`pay_type_id`) REFERENCES `pay_type` (`id`),
ADD CONSTRAINT `recharge_ibfk_3` FOREIGN KEY (`cus_id`) REFERENCES `customer` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
