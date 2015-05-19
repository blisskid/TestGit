-- --------------------------------------------------------

--
-- 表的结构 `xq_airlines`
--
DROP TABLE IF EXISTS `xq_airlines`;
CREATE TABLE IF NOT EXISTS `xq_airlines` (
  `ID` bigint(20) unsigned NOT NULL,
  `start_airport_code` varchar(20) NOT NULL COMMENT '出发航站楼代号',
  `arrive_airport_code` varchar(20) NOT NULL COMMENT '到达航站楼代号',
  `airline_price` double NOT NULL COMMENT '航线常规价格',
  `reserved_text` varchar(60) DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `xq_airports`
--
DROP TABLE IF EXISTS `xq_airports`;
CREATE TABLE IF NOT EXISTS `xq_airports` (
  `airport_code` varchar(20) NOT NULL,
  `airport_icao` varchar(20) NOT NULL DEFAULT '',
  `airport_iata` varchar(20) NOT NULL DEFAULT '',
  `airport_name` varchar(100) NOT NULL DEFAULT '' COMMENT '航站名称',
  `city_code` varchar(60) NOT NULL DEFAULT '' COMMENT '城市拼音',
  `city_name` varchar(60) NOT NULL DEFAULT '' COMMENT '城市中文名称',
  `province_code` varchar(60) NOT NULL DEFAULT '' COMMENT '省市拼音',
  `province_name` varchar(60) NOT NULL DEFAULT '' COMMENT '省市中文名',
  `reserved_text` varchar(60) DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 表的结构 `xq_discount_airlines`
--
DROP TABLE IF EXISTS `xq_discount_airlines`;
CREATE TABLE IF NOT EXISTS `xq_discount_airlines` (
  `ID` bigint(20) unsigned NOT NULL,
  `start_airport_code` varchar(20) NOT NULL COMMENT '出发航站楼代号',
  `arrive_airport_code` varchar(20) NOT NULL COMMENT '到达航站楼代号',
  `discount_price` double NOT NULL COMMENT '折扣价格',
  `discount_date` date NOT NULL COMMENT '折扣日期',
  `reserved_text` varchar(60) DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `xq_orders` 订单信息表
--
DROP TABLE IF EXISTS `xq_orders`;
CREATE TABLE IF NOT EXISTS `xq_orders` (
  `ID` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL COMMENT '产品代号',
  `product_price` double NOT NULL COMMENT '产品价格',
  `start_airport_code` varchar(20) NOT NULL COMMENT '出发航站楼代号',
  `arrive_airport_code` varchar(20) NOT NULL COMMENT '到达航站楼代号',
  `airline_price` double NOT NULL COMMENT '往返机票价格',
  `start_date` date NOT NULL COMMENT '出发日期',
  `back_date` date NOT NULL COMMENT '返回日期',
  `total_price` double NOT NULL COMMENT '总价格',
  `order_status` int(11) NOT NULL DEFAULT '0' COMMENT '订单状态。0：未支付；1：已支付；2：已取消。',
  `reserved_text` varchar(60) DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `xq_products`
--
DROP TABLE IF EXISTS `xq_products`;
CREATE TABLE IF NOT EXISTS `xq_products` (
  `ID` bigint(20) unsigned NOT NULL,
  `product_name` varchar(60) NOT NULL DEFAULT '' COMMENT '产品名称',
  `product_price` double NOT NULL COMMENT '产品价格（元）',
  `product_dealer_price` double NOT NULL COMMENT '经销商产品价格',
  `product_type` int(11) NOT NULL DEFAULT '0' COMMENT '产品类别。0：疫苗类产品；1:其他。',
  `product_paytype` int(11) NOT NULL DEFAULT '0' COMMENT '0:对应流程一，1:对应流程2',
  `product_show` int(11) NOT NULL DEFAULT '1' COMMENT '0:不在首页显示，1:在首页显示',
  `product_description` longtext NOT NULL COMMENT '产品描述',
  `reserved_text` varchar(60) DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `xq_sets`
--
DROP TABLE IF EXISTS `xq_sets`;
CREATE TABLE IF NOT EXISTS `xq_sets` (
  `ID` bigint(20) unsigned NOT NULL,
  `set_name` varchar(60) NOT NULL DEFAULT '' COMMENT '套餐名称',
  `set_price` double NOT NULL COMMENT '套餐价格',
  `set_dealer_price` double NOT NULL COMMENT '套餐经销商价格',
  `product_ids` varchar(500) NOT NULL DEFAULT '' COMMENT '产品id集合，用英文逗号间隔',
  `product_total_price` double NOT NULL COMMENT '产品价格总和',
  `set_description` text COMMENT '套餐描述',
  `set_advantage` text COMMENT '套餐优势',
  `set_priority` int(11) NOT NULL DEFAULT '0' COMMENT '套餐优先级，0最高，依次降低',
  `reserved_text` varchar(60) DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `xq_set_product`
--
DROP TABLE IF EXISTS `xq_set_product`;
CREATE TABLE IF NOT EXISTS `xq_set_product` (
  `ID` bigint(20) unsigned NOT NULL,
  `set_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `reserved_text` varchar(60) DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `xq_users`
--
DROP TABLE IF EXISTS `xq_users`;
CREATE TABLE IF NOT EXISTS `xq_users` (
  `user_id` bigint(20) unsigned NOT NULL,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_name` varchar(200) NOT NULL DEFAULT '',
  `user_type` int(11) NOT NULL DEFAULT '0' COMMENT '0:普通用户，1:企业用户',
  `user_email` varchar(30) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `user_phone` varchar(30) NOT NULL DEFAULT '' COMMENT '用户手机',
  `user_city` varchar(100) NOT NULL DEFAULT '' COMMENT '用户地区，用户自己填写',
  `user_joinmsg` longtext COMMENT '用户加盟时的留言',
  `reserved_text` varchar(60) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  ADD PRIMARY KEY (`airport_code`);

--
-- Indexes for table `xq_discount_airlines`
--
ALTER TABLE `xq_discount_airlines`
  ADD PRIMARY KEY (`ID`);
--
-- Indexes for table `xq_discount_airlines`
--
ALTER TABLE `xq_orders`
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
--
-- AUTO_INCREMENT for table `xq_discount_airlines`
--
ALTER TABLE `xq_discount_airlines`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
--
-- AUTO_INCREMENT for table `xq_discount_airlines`
--
ALTER TABLE `xq_orders`
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
  --
-- AUTO_INCREMENT for table `xq_users`
--
ALTER TABLE `xq_users`
  MODIFY `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;


INSERT INTO `xq_airports`(`airport_code`, `airport_icao`, `airport_iata`, `airport_name`, `city_code`, `reserved_text`) VALUES ('ZBAA_PEK','ZBAA','PEK','北京首都国际机场','beijing','');
