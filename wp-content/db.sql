-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-05-03 17:09:43
-- 服务器版本： 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mysite2`
--

-- --------------------------------------------------------

--
-- 表的结构 `xq_airlines`
--

CREATE TABLE IF NOT EXISTS `xq_airlines` (
  `ID` bigint(20) unsigned NOT NULL,
  `start_airport_id` bigint(20) unsigned NOT NULL COMMENT '出发航站楼ID',
  `arrive_airport_id` bigint(20) unsigned NOT NULL COMMENT '到达航站楼ID',
  `airline_price` double NOT NULL COMMENT '航线常规价格',
  `reserved_text` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `xq_airports`
--

CREATE TABLE IF NOT EXISTS `xq_airports` (
  `ID` bigint(20) unsigned NOT NULL,
  `airport_icao` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `airport_iata` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `airport_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '航站名称',
  `city_code` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '城市拼音',
  `reserved_text` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `xq_cities`
--

CREATE TABLE IF NOT EXISTS `xq_cities` (
  `city_code` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '城市拼音',
  `city_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '城市中文名称',
  `province_code` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '省市拼音',
  `province_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '省市中文名',
  `reserved_text` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `xq_discount_airlines`
--

CREATE TABLE IF NOT EXISTS `xq_discount_airlines` (
  `ID` bigint(20) unsigned NOT NULL,
  `start_airport_id` bigint(20) unsigned NOT NULL COMMENT '出发航站ID',
  `arrive_airport_id` bigint(20) unsigned NOT NULL COMMENT '到达航站ID',
  `discount_price` double NOT NULL COMMENT '折扣价格',
  `discount_date` date NOT NULL COMMENT '折扣日期',
  `reserved_text` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `xq_products`
--

CREATE TABLE IF NOT EXISTS `xq_products` (
  `ID` bigint(20) unsigned NOT NULL,
  `product_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '产品名称',
  `product_price` double NOT NULL COMMENT '产品价格（元）',
  `product_dealer_price` double NOT NULL COMMENT '经销商产品价格',
  `product_description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '产品描述',
  `product_advantage` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '产品优势',
  `product_type` int(11) NOT NULL DEFAULT '0' COMMENT '产品类别。0：疫苗类产品；1:其他。',
  `product_paytype` int(11) NOT NULL DEFAULT '0' COMMENT '0:对应流程一，1:对应流程2',
  `reserved_text` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `xq_sets`
--

CREATE TABLE IF NOT EXISTS `xq_sets` (
  `ID` bigint(20) unsigned NOT NULL,
  `set_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '套餐名称',
  `set_price` double NOT NULL COMMENT '套餐价格',
  `set_dealer_price` double NOT NULL COMMENT '套餐经销商价格',
  `product_ids` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '产品id集合，用英文逗号间隔',
  `product_total_price` double NOT NULL COMMENT '产品价格总和',
  `set_description` text COLLATE utf8mb4_unicode_ci COMMENT '套餐描述',
  `set_advantage` text COLLATE utf8mb4_unicode_ci COMMENT '套餐优势',
  `set_priority` int(11) NOT NULL DEFAULT '0' COMMENT '套餐优先级，0最高，依次降低',
  `reserved_text` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `xq_set_product`
--

CREATE TABLE IF NOT EXISTS `xq_set_product` (
  `ID` bigint(20) unsigned NOT NULL,
  `set_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `reserved_text` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `xq_users`
--

CREATE TABLE IF NOT EXISTS `xq_users` (
  `user_id` bigint(20) unsigned NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_type` int(11) NOT NULL DEFAULT '0' COMMENT '0:普通用户，1:企业用户，2:经销商',
  `user_phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户手机',
  `user_city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户地区，用户自己填写',
  `user_joinmsg` longtext COLLATE utf8mb4_unicode_ci COMMENT '用户加盟时的留言',
  `reserved_text` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `xq_airlines`
--
ALTER TABLE `xq_airlines`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xq_airports`
--
ALTER TABLE `xq_airports`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xq_cities`
--
ALTER TABLE `xq_cities`
  ADD PRIMARY KEY (`city_code`);

--
-- Indexes for table `xq_discount_airlines`
--
ALTER TABLE `xq_discount_airlines`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xq_products`
--
ALTER TABLE `xq_products`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xq_sets`
--
ALTER TABLE `xq_sets`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xq_set_product`
--
ALTER TABLE `xq_set_product`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xq_users`
--
ALTER TABLE `xq_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `xq_airlines`
--
ALTER TABLE `xq_airlines`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `xq_airports`
--
ALTER TABLE `xq_airports`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `xq_discount_airlines`
--
ALTER TABLE `xq_discount_airlines`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `xq_products`
--
ALTER TABLE `xq_products`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `xq_sets`
--
ALTER TABLE `xq_sets`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `xq_set_product`
--
ALTER TABLE `xq_set_product`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `xq_products` (`ID`, `product_name`, `product_price`, `product_dealer_price`, `product_description`, `product_advantage`, `product_type`, `product_paytype`, `reserved_text`) VALUES
(3, '产品测试', 1000, 800, '非颠三倒四v 发多少财产', '反对是非得失出差 到达地 到达 ', 0, 0, '');
