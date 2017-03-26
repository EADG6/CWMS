-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-03-26 15:30:34
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
  `balance` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`id`, `username`, `pwdhash`, `salt`, `FirstName`, `LastName`, `sex`, `tel`, `address`, `balance`) VALUES
(1, 'cus1', '4037f3d099eb4e3cd9e657df21936662', 'f018f9', 'Hao', 'Liu', 1, '123456789001', 'CDUTSong2-562', 23.30000000000001),
(2, 'cus2', 'f056d6a7a5ec600efee50537bd50549f', 'd13ca1', 'Yuan', 'Tian', 1, '1829444332', 'CDUTSong2-334', 17.799999999999997),
(5, 'kevin', '9abe16a3aa0abd091d9dfb9649080e37', '9879f9', 'Kevin', 'He', 0, '23333', 'CDUT562', 9.5),
(8, 'test', 'e861c63b3bf88589fda553c977b0e538', 'bSK3NDPs', 'test', 'test', 0, '1233', '12333', 10),
(9, 'test1', '96b2fde0498302384e5e282fa73e7150', '2/RwUARx', 'test1', '1', 0, '1', '1', 0);

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
(4, 'Kevin', 'ba16456bd49a53c1f3248055c0f0492e', '531ea7', 0, '1996-03-15', 'Kevin', 'He', '1234567890', 2, '2016-12-01'),
(5, 'test', '0cb0b90fdf40569ebae76f77c8bd64bd', 'pql7Nv6I', 0, NULL, '1', '1', '11099102', 4, '2017-03-26');

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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `cus_id`, `Date`, `Time`, `status`, `rate`) VALUES
(41, 2, '2017-03-25', '19:21:56', 4, 5),
(50, 1, '2017-03-26', '00:26:40', 4, 0),
(51, 1, '2017-03-26', '01:03:19', 4, 2),
(53, 2, '2017-03-26', '03:03:03', 4, 3),
(56, NULL, '2017-03-26', '03:05:27', 4, 4),
(58, 8, '2017-03-26', '03:10:37', 3, 5);

-- --------------------------------------------------------

--
-- 表的结构 `order_product`
--

CREATE TABLE IF NOT EXISTS `order_product` (
  `item_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned DEFAULT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=latin1;

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
(116, 58, 11, 1);

-- --------------------------------------------------------

--
-- 表的结构 `order_service`
--

CREATE TABLE IF NOT EXISTS `order_service` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `order_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `order_service`
--

INSERT INTO `order_service` (`id`, `emp_id`, `car_id`, `order_id`) VALUES
(1, 2, 5, 41),
(6, 3, 2, 51),
(7, 2, 4, 53),
(10, 1, 13, 58);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`id`, `order_id`, `cus_id`, `price`, `discount`, `pay_time`, `pay_type_id`, `emp_id`) VALUES
(10, 41, 5, 25, 0.9, '2017-03-25 21:13:02', 1, 1),
(11, 56, NULL, 25, 1, '2017-03-26 14:29:23', 3, 1),
(12, 51, 1, 45, 0.9, '2017-03-26 14:29:29', 1, 1),
(15, 53, 2, 45, 1, '2017-03-26 15:48:38', 2, 1),
(16, 50, 1, 180, 1, '2017-03-26 18:46:50', 2, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `recharge`
--

INSERT INTO `recharge` (`id`, `cus_id`, `price`, `datetime`, `pay_type_id`, `emp_id`) VALUES
(1, 1, 100, '2016-12-02 12:00:00', 4, 1),
(2, 2, 150, '2016-12-02 09:22:25', 2, 1),
(3, 5, 10, '2017-03-03 00:11:30', 3, 1),
(4, 1, 100, '2017-03-03 00:14:28', 4, 1),
(5, 1, 100, '2017-03-03 00:19:57', 4, 1),
(6, 1, 100, '2017-03-03 00:20:21', 4, 1),
(7, 1, 100, '2017-03-03 00:20:32', 4, 1),
(8, 2, 21, '2017-03-03 00:21:00', 2, 1),
(9, 2, 12, '2017-03-11 16:10:58', 4, 1),
(10, 5, 12, '2017-03-18 16:27:59', 4, 1),
(11, 5, 10, '2017-03-18 17:20:03', 4, 1),
(12, 1, 120, '2017-03-21 15:00:43', 4, 2),
(13, 8, 10, '2017-03-26 03:11:21', 4, 1);

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

-- --------------------------------------------------------

--
-- 表的结构 `salary_category`
--

CREATE TABLE IF NOT EXISTS `salary_category` (
  `id` int(11) NOT NULL,
  `kpi` varchar(100) DEFAULT NULL,
  `monthlysalary` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `salary_category`
--

INSERT INTO `salary_category` (`id`, `kpi`, `monthlysalary`) VALUES
(1, '< 20', 2000),
(2, '20-30', 2200),
(3, '30-40', 2400),
(4, '40-50', 2600),
(5, '50-60', 2800),
(6, '60-70', 3000),
(7, '70-80', 3200),
(8, '80-90', 3400),
(9, '90-100', 3600),
(10, '100-120', 3800),
(11, '> 120', 4000);

-- --------------------------------------------------------

--
-- 表的结构 `salary_record`
--

CREATE TABLE IF NOT EXISTS `salary_record` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `kpi` int(11) DEFAULT NULL,
  `salary_category_id` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for table `salary_category`
--
ALTER TABLE `salary_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_record`
--
ALTER TABLE `salary_record`
  ADD PRIMARY KEY (`id`), ADD KEY `emp_id` (`emp_id`), ADD KEY `salary_category_id` (`salary_category_id`);

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT for table `order_service`
--
ALTER TABLE `order_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `salary_category`
--
ALTER TABLE `salary_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `salary_record`
--
ALTER TABLE `salary_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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

--
-- 限制表 `salary_record`
--
ALTER TABLE `salary_record`
ADD CONSTRAINT `salary_record_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`id`),
ADD CONSTRAINT `salary_record_ibfk_2` FOREIGN KEY (`salary_category_id`) REFERENCES `salary_category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
