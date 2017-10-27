/*
Navicat MySQL Data Transfer

Source Server         : shopyii
Source Server Version : 50553
Source Host           : 192.168.2.227:3306
Source Database       : lsx

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-15 17:11:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `lsx_admin`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_admin`;
CREATE TABLE `lsx_admin` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `role_id` int(11) DEFAULT NULL COMMENT '用户角色ID',
  `user_name` text NOT NULL COMMENT '登录用户名',
  `password` text NOT NULL COMMENT '登录密码',
  `real_name` text COMMENT '真实姓名',
  `mobile` tinytext COMMENT '手机号',
  `tel` tinytext NOT NULL COMMENT '固定电话号码 ',
  `status` tinyint(1) unsigned zerofill NOT NULL COMMENT '用户状态 0-禁用 1-启用',
  `last_time` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `last_ip` tinytext NOT NULL COMMENT '最后登录IP',
  `visit_count` int(11) DEFAULT NULL COMMENT '登录次数',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`user_id`),
  KEY `FK_Reference_10` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='流水席后台管理员';

-- ----------------------------
-- Records of lsx_admin
-- ----------------------------
INSERT INTO `lsx_admin` VALUES ('1', null, 'test', '123456', null, null, '15000000000', '1', null, '192.168.2.227', null, '20170912', null);
INSERT INTO `lsx_admin` VALUES ('2', null, 'ceshi', '123456', null, null, '18011111111', '0', null, '192.168.2.227', null, '20170913', null);
INSERT INTO `lsx_admin` VALUES ('3', null, 'hhhh', '123456', '', '', '18000000000', '0', null, '192.168.2.227', null, '20170914', null);
INSERT INTO `lsx_admin` VALUES ('4', null, 'emmm', '123456', '', '', '18000000000', '0', null, '192.168.2.227', null, '20170915', null);

-- ----------------------------
-- Table structure for `lsx_back_order`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_back_order`;
CREATE TABLE `lsx_back_order` (
  `return_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '退款订单ID',
  `record_id` int(11) NOT NULL COMMENT '用户订单ID(对应用户订单ID)',
  `order_id` int(11) NOT NULL COMMENT '席单号ID(对应席单id)',
  `return_sn` varchar(20) DEFAULT NULL COMMENT '订单编号',
  `buy_seats` double NOT NULL COMMENT '购买座位数',
  `buy_price` double NOT NULL COMMENT '购买单价',
  `return_amount` double NOT NULL COMMENT '退还金额',
  `pay_meal_ticket` double NOT NULL COMMENT '退还饭票金额',
  `user_id` double NOT NULL COMMENT '购买用户ID',
  `Meal_ticket` double NOT NULL DEFAULT '0' COMMENT '退还赠送饭票金额',
  `pay_status` tinyint(1) unsigned zerofill DEFAULT '0' COMMENT '退款状态(0退款失败，1退款成功)',
  `create_time` datetime NOT NULL COMMENT '退款时间',
  PRIMARY KEY (`return_id`),
  KEY `FK_Reference_17` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='消费者退款订单';

-- ----------------------------
-- Records of lsx_back_order
-- ----------------------------
INSERT INTO `lsx_back_order` VALUES ('1', '1', '1', '2017091200001', '1', '25', '24.5', '0.5', '1', '1', '1', '2017-09-13 15:40:27');
INSERT INTO `lsx_back_order` VALUES ('2', '2', '1', '2017091200002', '2', '50', '50', '0', '2', '1', '1', '2017-09-13 15:40:27');
INSERT INTO `lsx_back_order` VALUES ('3', '3', '2', '2017091200003', '1', '40', '40', '0', '3', '1', '1', '2017-09-13 15:40:27');
INSERT INTO `lsx_back_order` VALUES ('4', '4', '3', '2017091200004', '3', '90', '80', '10', '4', '1', '0', '2017-09-14 15:40:27');

-- ----------------------------
-- Table structure for `lsx_banquet_order`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_banquet_order`;
CREATE TABLE `lsx_banquet_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '席单ID',
  `banquet_id` int(11) NOT NULL COMMENT '商家流水席ID',
  `banquet_sn` varchar(60) NOT NULL COMMENT '席单编号',
  `banquet_number` int(11) DEFAULT NULL COMMENT '座席顺序号',
  `order_status` int(11) NOT NULL DEFAULT '0' COMMENT '席单状态（0拼席中，1拼席成功，2已退款，3已完成）',
  `total_peoples` int(11) NOT NULL COMMENT '总人数',
  `joined_peoples` int(11) NOT NULL DEFAULT '0' COMMENT '已加入人数',
  `order_price` varchar(10) NOT NULL COMMENT '席单单价',
  `order_amount` double NOT NULL COMMENT '席单总额',
  `payed_amount` double NOT NULL COMMENT '已付总金额',
  `shop_id` int(11) NOT NULL COMMENT '所属商家ID',
  `update_time` datetime DEFAULT NULL COMMENT '席单更新时间',
  `create_time` datetime NOT NULL COMMENT '席单创建时间',
  PRIMARY KEY (`order_id`),
  KEY `FK_Reference_6` (`banquet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='酒席订单';

-- ----------------------------
-- Records of lsx_banquet_order
-- ----------------------------
INSERT INTO `lsx_banquet_order` VALUES ('1', '1', '20170915123456A', '7', '3', '5', '5', '30', '200', '150', '1', null, '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `lsx_banquet_type`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_banquet_type`;
CREATE TABLE `lsx_banquet_type` (
  `type_id` int(11) NOT NULL COMMENT '流水席类别ID',
  `type_name` varchar(64) DEFAULT NULL COMMENT '流水席类别名字',
  `type_path` varchar(255) DEFAULT NULL COMMENT '流水席类别图片',
  `type_url` varchar(255) DEFAULT NULL COMMENT '流水席URI',
  `type_sort` int(11) DEFAULT NULL COMMENT '流水席分类顺序号',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='流水席类别';

-- ----------------------------
-- Records of lsx_banquet_type
-- ----------------------------
INSERT INTO `lsx_banquet_type` VALUES ('1', '第一种流水席', '·······', '11', '1');

-- ----------------------------
-- Table structure for `lsx_carousel`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_carousel`;
CREATE TABLE `lsx_carousel` (
  `Carousel_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '轮播图流水号',
  `Carousel_path` varchar(255) NOT NULL COMMENT '轮播图路径 ',
  `Carousel_descprtion` varchar(255) DEFAULT NULL COMMENT '轮播图描述',
  `Carousel_urll` varchar(512) DEFAULT NULL COMMENT '轮播图链接',
  `class_sort` int(11) NOT NULL DEFAULT '0' COMMENT '流水席分类顺序号',
  `is_display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示（0，不显示，1显示）',
  `operator_id` int(11) NOT NULL COMMENT '轮播图操作者',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`Carousel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='轮播图';

-- ----------------------------
-- Records of lsx_carousel
-- ----------------------------

-- ----------------------------
-- Table structure for `lsx_category`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_category`;
CREATE TABLE `lsx_category` (
  `category_id` int(11) NOT NULL COMMENT '专题类别ID',
  `category_name` varchar(64) DEFAULT NULL COMMENT '流水席类别名字',
  `category_path` varchar(255) DEFAULT NULL COMMENT '流水席类别图片',
  `category_url` varchar(255) DEFAULT NULL COMMENT '流水席URI',
  `category_sort` int(11) DEFAULT NULL COMMENT '流水席分类顺序号',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题分类类别';

-- ----------------------------
-- Records of lsx_category
-- ----------------------------
INSERT INTO `lsx_category` VALUES ('1', '最多', null, null, null);
INSERT INTO `lsx_category` VALUES ('2', '最便宜', '', '', null);

-- ----------------------------
-- Table structure for `lsx_commission`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_commission`;
CREATE TABLE `lsx_commission` (
  `commission_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '平台分佣ID',
  `shop_id` int(11) NOT NULL COMMENT '所属商家ID',
  `commission_rate` double NOT NULL COMMENT '分佣比例（百分比）',
  `operator_id` int(11) NOT NULL COMMENT '分佣人（对应操作管理员IID）',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`commission_id`),
  KEY `FK_Reference_1` (`shop_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='平台分佣';

-- ----------------------------
-- Records of lsx_commission
-- ----------------------------
INSERT INTO `lsx_commission` VALUES ('1', '1', '20170915', '1', '2017-09-14 16:24:52');
INSERT INTO `lsx_commission` VALUES ('2', '2', '20170915', '1', '2017-09-14 16:25:16');

-- ----------------------------
-- Table structure for `lsx_meal_ticket`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_meal_ticket`;
CREATE TABLE `lsx_meal_ticket` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '饭票id',
  `ticket_price` double NOT NULL COMMENT '饭票单价',
  `operator_id` int(11) NOT NULL COMMENT '操作者ID(关联管理员ID)',
  `caeate_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='饭票信息';

-- ----------------------------
-- Records of lsx_meal_ticket
-- ----------------------------
INSERT INTO `lsx_meal_ticket` VALUES ('1', '1', '1', '2017-09-14 16:25:55');
INSERT INTO `lsx_meal_ticket` VALUES ('2', '1', '1', '2017-09-15 16:26:05');
INSERT INTO `lsx_meal_ticket` VALUES ('3', '1', '1', '2017-09-16 16:26:17');

-- ----------------------------
-- Table structure for `lsx_menu`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_menu`;
CREATE TABLE `lsx_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(60) NOT NULL COMMENT '菜单名',
  `parent_id` int(11) NOT NULL COMMENT '上级菜单ID',
  `image_path` varchar(255) DEFAULT NULL COMMENT '菜单图片',
  `menu_link` varchar(255) NOT NULL COMMENT '菜单连接地址',
  `menu_desc` varchar(255) DEFAULT NULL COMMENT '菜单描述',
  `menu_level` int(11) DEFAULT '0' COMMENT '菜单层级',
  `menu_sort` int(11) NOT NULL DEFAULT '0' COMMENT '菜单排序值',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='流水席后台功能菜单\r\n';

-- ----------------------------
-- Records of lsx_menu
-- ----------------------------
INSERT INTO `lsx_menu` VALUES ('1', '干煸洋芋丝', '1', null, 'www.baidu.com', null, '0', '1');
INSERT INTO `lsx_menu` VALUES ('2', '回锅肉', '1', '', 'www.google.com', '', '0', '1');

-- ----------------------------
-- Table structure for `lsx_pay_log`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_pay_log`;
CREATE TABLE `lsx_pay_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志记录ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `record_id` int(11) NOT NULL COMMENT '用户订单ID(对应用户订单ID)',
  `order_id` int(11) NOT NULL COMMENT '席单号ID(对应席单id)',
  `order_amount` double NOT NULL COMMENT '订单的所支付的总金额',
  `pay_code` varchar(30) NOT NULL COMMENT '订单支付方式标识',
  `pay_name` varchar(90) NOT NULL COMMENT '支付方式名称',
  `add_time` int(11) DEFAULT NULL COMMENT '添加记录时间',
  `last_time` int(11) DEFAULT NULL COMMENT '更新记录时间',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `pay_type` int(11) NOT NULL DEFAULT '0' COMMENT '支付类型(0,无支付，1，微信支付)',
  `is_paid` int(11) NOT NULL DEFAULT '0' COMMENT '是否支付成功（0未支付成功，1支付成功）',
  PRIMARY KEY (`log_id`),
  KEY `FK_Reference_18` (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='支付历史记录';

-- ----------------------------
-- Records of lsx_pay_log
-- ----------------------------
INSERT INTO `lsx_pay_log` VALUES ('1', '1', '1', '1', '1', '1', '1', '20170912', '20170912', '20170912', '1', '1');
INSERT INTO `lsx_pay_log` VALUES ('2', '2', '2', '2', '2', '1', '1', '20170913', '20170913', '20170913', '1', '1');

-- ----------------------------
-- Table structure for `lsx_region`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_region`;
CREATE TABLE `lsx_region` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '区域ID',
  `region_name` varchar(64) NOT NULL COMMENT '区域名字',
  `short_name` varchar(64) NOT NULL COMMENT '地区简称\r\n            地区简称\r\n            ',
  `region_code` varchar(64) NOT NULL COMMENT '地区代码',
  `parent_code` varchar(64) NOT NULL COMMENT '上级代码',
  `region_type` varchar(64) DEFAULT NULL COMMENT '区域类型',
  `center` varchar(64) NOT NULL COMMENT '地区经纬度',
  `city_code` int(11) NOT NULL COMMENT '城市编码',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '地区级别',
  `is_enable` int(11) NOT NULL COMMENT '是否启用(0未启用，1已启用)',
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='区域编码';

-- ----------------------------
-- Records of lsx_region
-- ----------------------------

-- ----------------------------
-- Table structure for `lsx_role`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_role`;
CREATE TABLE `lsx_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) NOT NULL COMMENT '角色名字',
  `role_type` int(11) DEFAULT NULL COMMENT '角色类型',
  `role_desc` varchar(64) DEFAULT NULL COMMENT '角色描述',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='流水席管理员角色\r\n';

-- ----------------------------
-- Records of lsx_role
-- ----------------------------

-- ----------------------------
-- Table structure for `lsx_role_auth`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_role_auth`;
CREATE TABLE `lsx_role_auth` (
  `auth_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '授权ID',
  `child_id` int(11) NOT NULL COMMENT '子菜单ID',
  `parent_id` int(11) NOT NULL COMMENT '父菜单ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  PRIMARY KEY (`auth_id`),
  KEY `FK_Reference_12` (`child_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='授权分配角色';

-- ----------------------------
-- Records of lsx_role_auth
-- ----------------------------

-- ----------------------------
-- Table structure for `lsx_shop`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_shop`;
CREATE TABLE `lsx_shop` (
  `shop_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '门店ID',
  `shop_name` varchar(128) NOT NULL COMMENT '门店名称',
  `merchant_name` varchar(32) NOT NULL COMMENT '商家姓名',
  `merchant_mobile` varchar(13) NOT NULL COMMENT '商家电话',
  `merchant_area` double NOT NULL COMMENT '商家面积',
  `merchant_seats` int(11) NOT NULL COMMENT '商家座位数',
  `service_score` double DEFAULT '5' COMMENT '店铺星级（共5 星）',
  `region_code` varchar(128) DEFAULT NULL COMMENT '地区代码',
  `address` varchar(256) DEFAULT NULL COMMENT '详细地址',
  `shop_lng` varchar(32) DEFAULT NULL COMMENT '经度',
  `shop_lat` varchar(32) DEFAULT NULL COMMENT '纬度',
  `opening_hour` varchar(24) NOT NULL COMMENT '营业时间',
  `closing_hour` varchar(24) NOT NULL COMMENT '关闭时间',
  `clearing_cycle` int(11) DEFAULT NULL COMMENT '结算周期',
  `shop_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商家状态（0停用，1启用)',
  `operator_id` int(11) NOT NULL COMMENT '操作人（对应管理员user_id）',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`shop_id`),
  KEY `FK_Reference_9` (`region_code`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商家信息';

-- ----------------------------
-- Records of lsx_shop
-- ----------------------------
INSERT INTO `lsx_shop` VALUES ('1', '小叶叶的餐馆', '叶寒松', '119', '960', '0', '5', '50，01,01', '北京天安门', '129', '128', '1:00', '9:00', '30', '1', '1', '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for `lsx_shop_account`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_shop_account`;
CREATE TABLE `lsx_shop_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家帐务ID',
  `shop_id` int(11) NOT NULL COMMENT '所属商家ID',
  `total_orders` int(11) NOT NULL DEFAULT '0' COMMENT '订单总数',
  `foods` int(11) NOT NULL DEFAULT '0' COMMENT '菜品数',
  `banquets` int(11) NOT NULL DEFAULT '0' COMMENT '流水席数',
  `banquet_orders` int(11) NOT NULL DEFAULT '0' COMMENT '成交席单数',
  `sales_amount` double NOT NULL DEFAULT '0' COMMENT '销售总额',
  `cashed_amount` double NOT NULL DEFAULT '0' COMMENT '已提现金额',
  `total_balnce` double NOT NULL DEFAULT '0' COMMENT '商家余额',
  `request_blance` double NOT NULL DEFAULT '0' COMMENT '申请提现金额',
  `withdraw_amount` double NOT NULL DEFAULT '0' COMMENT '已提现总额',
  `platform_amount` double NOT NULL DEFAULT '0' COMMENT '平台分佣总额',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`account_id`),
  KEY `FK_Reference_2` (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家经营状况';

-- ----------------------------
-- Records of lsx_shop_account
-- ----------------------------

-- ----------------------------
-- Table structure for `lsx_shop_bank`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_shop_bank`;
CREATE TABLE `lsx_shop_bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家帐务ID',
  `shop_id` int(11) NOT NULL COMMENT '所属商家ID',
  `withdraw_name` varchar(24) NOT NULL COMMENT '提现姓名',
  `withdraw_bank` varchar(26) NOT NULL COMMENT '商家开户行',
  `bank_account` int(11) NOT NULL COMMENT '商银行帐号',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`bank_id`),
  KEY `FK_Reference_14` (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家银行帐户';

-- ----------------------------
-- Records of lsx_shop_bank
-- ----------------------------

-- ----------------------------
-- Table structure for `lsx_shop_banquet`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_shop_banquet`;
CREATE TABLE `lsx_shop_banquet` (
  `banquet_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水席ID',
  `shop_id` int(11) NOT NULL COMMENT '商家ID',
  `class_id` int(11) NOT NULL COMMENT '流水席分类',
  `banquet_name` varchar(255) NOT NULL COMMENT '流水席名字',
  `banquet_amount` double NOT NULL DEFAULT '0' COMMENT '菜品总价',
  `banquet_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '流水席状态(0停用,1启用)',
  `total_peoples` int(11) NOT NULL DEFAULT '0' COMMENT '总人数',
  `price` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '座席单价',
  `banquet_url` varchar(255) NOT NULL COMMENT '流水席图片地址',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`banquet_id`),
  KEY `FK_Reference_4` (`shop_id`),
  KEY `FK_Reference_8` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商家流水席';

-- ----------------------------
-- Records of lsx_shop_banquet
-- ----------------------------
INSERT INTO `lsx_shop_banquet` VALUES ('1', '1', '1', '这不是流水席', '200', '1', '5', '30.00', 'aaa', '2017-09-15 13:31:58', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `lsx_shop_menu`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_shop_menu`;
CREATE TABLE `lsx_shop_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水席菜单ID',
  `menu_name` varchar(52) NOT NULL COMMENT '菜单名',
  `menu_price` double NOT NULL DEFAULT '0' COMMENT '单价',
  `menu_quantity` int(11) NOT NULL DEFAULT '0' COMMENT '菜单数量',
  `shop_id` int(11) NOT NULL COMMENT '所属商家ID',
  `banquet_id` int(11) NOT NULL COMMENT '所属流水席id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`menu_id`),
  KEY `FK_Reference_5` (`banquet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家菜单';

-- ----------------------------
-- Records of lsx_shop_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `lsx_shop_record`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_shop_record`;
CREATE TABLE `lsx_shop_record` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '提现记录ID',
  `shop_id` int(11) NOT NULL COMMENT '所属商家ID',
  `request_amount` double NOT NULL DEFAULT '0' COMMENT '提现金额',
  `withdraw_name` varchar(24) NOT NULL COMMENT '提现姓名',
  `withdraw_bank` varchar(26) NOT NULL COMMENT '商家开户行',
  `bank_account` varchar(20) NOT NULL COMMENT '商银行帐号',
  `approve_id` int(11) DEFAULT NULL COMMENT '审核人ID(对应管理员ID)',
  `request_status` int(1) NOT NULL DEFAULT '0' COMMENT '申请状态（0申请中，1审核通过，2。审核未通过）',
  `request_time` datetime NOT NULL COMMENT '申请时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`request_id`),
  KEY `FK_Reference_3` (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家提现记录';

-- ----------------------------
-- Records of lsx_shop_record
-- ----------------------------

-- ----------------------------
-- Table structure for `lsx_shop_user`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_shop_user`;
CREATE TABLE `lsx_shop_user` (
  `seller_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL COMMENT '门店ID',
  `shop_user` varchar(32) NOT NULL COMMENT '商家管理员帐户',
  `password` varchar(32) NOT NULL COMMENT '商家密码',
  `user_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态（0启用，1停用）',
  `operator_id` int(11) NOT NULL COMMENT '操作人（对应管理员user_id）',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`seller_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家用户信息';

-- ----------------------------
-- Records of lsx_shop_user
-- ----------------------------

-- ----------------------------
-- Table structure for `lsx_user`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_user`;
CREATE TABLE `lsx_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL COMMENT '登录用户名',
  `mobile` varchar(15) DEFAULT NULL COMMENT '用户手机号',
  `openid` varchar(64) NOT NULL COMMENT 'opid',
  `nickname` varchar(32) DEFAULT NULL COMMENT '用户昵称',
  `sex` int(11) DEFAULT NULL COMMENT '用户性别',
  `address_now` varchar(32) DEFAULT NULL COMMENT '用户现居住地址',
  `image_path` varchar(255) DEFAULT NULL COMMENT '用户头像路径',
  `meal_ticket` double DEFAULT '0' COMMENT '饭票金额',
  `mobile_validated` int(11) DEFAULT '0' COMMENT '手机是否验证（0未验证，1已验证）',
  `reg_time` int(11) DEFAULT NULL COMMENT '手机注册时间',
  `reg_ip` varchar(32) DEFAULT NULL COMMENT '注册IP',
  `last_time` int(11) DEFAULT NULL COMMENT '最近登录时间',
  `last_ip` varchar(32) DEFAULT NULL COMMENT '最近登录IP',
  `visit_count` int(11) DEFAULT NULL COMMENT '访问次数',
  `mobile_supplier` varchar(32) DEFAULT NULL COMMENT '手机运营商',
  `mobile_province` varchar(32) DEFAULT NULL COMMENT '手机归属省',
  `mobile_city` varchar(32) DEFAULT NULL COMMENT '手机归属市',
  `user_status` tinyint(1) DEFAULT '0' COMMENT '用户状态（0停用，1启用）',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='普通消费者信息';

-- ----------------------------
-- Records of lsx_user
-- ----------------------------
INSERT INTO `lsx_user` VALUES ('1', 'apie', '18500000000', '123', '啊呸', '1', '重庆市', null, '0', '0', null, null, null, null, null, null, null, null, '0');
INSERT INTO `lsx_user` VALUES ('2', '哈哈哈', '18511111111', '456', '什么', '2', '江北区', null, '0', '0', null, null, null, null, null, null, null, null, '0');
INSERT INTO `lsx_user` VALUES ('3', '呵呵呵', '18522222222', '789', '鬼东西', '2', '沙坪坝', '', '0', '0', null, '', null, '', null, '', '', '', '0');

-- ----------------------------
-- Table structure for `lsx_user_account`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_user_account`;
CREATE TABLE `lsx_user_account` (
  `account_id` int(11) NOT NULL DEFAULT '1' COMMENT '用户统计ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `total_orders` int(11) NOT NULL DEFAULT '0' COMMENT '商家订单数',
  `recommend_users` int(11) NOT NULL DEFAULT '0' COMMENT '推荐用户数',
  `meal_ticket` double NOT NULL DEFAULT '0' COMMENT '饭票总额',
  `meal_balance` double NOT NULL DEFAULT '0' COMMENT '饭票余额',
  `total_amount` double NOT NULL DEFAULT '0' COMMENT '消费总额',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`account_id`),
  KEY `FK_Reference_15` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户流水席统计数据';

-- ----------------------------
-- Records of lsx_user_account
-- ----------------------------
INSERT INTO `lsx_user_account` VALUES ('1', '1', '2', '1', '0', '0', '0', '2017-09-13 16:09:23', null);
INSERT INTO `lsx_user_account` VALUES ('2', '2', '1', '2', '1', '0', '0', '2017-09-12 16:09:56', '2017-09-13 16:09:23');
INSERT INTO `lsx_user_account` VALUES ('3', '3', '1', '2', '1', '0', '0', '2017-09-13 16:09:56', '2017-09-14 16:09:23');

-- ----------------------------
-- Table structure for `lsx_user_order`
-- ----------------------------
DROP TABLE IF EXISTS `lsx_user_order`;
CREATE TABLE `lsx_user_order` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户订单ID',
  `order_id` int(11) NOT NULL COMMENT '席单号ID',
  `shop_id` int(11) NOT NULL,
  `buy_seats` double NOT NULL DEFAULT '0' COMMENT '购买座位数',
  `buy_price` double NOT NULL DEFAULT '0' COMMENT '购买单价',
  `pay_amount` double NOT NULL DEFAULT '0' COMMENT '支付金额',
  `pay_serianlno` varchar(10) DEFAULT NULL COMMENT '支付流水号',
  `pay_meal_ticket` double DEFAULT '0' COMMENT '支付饭票金额',
  `buy_number` int(11) DEFAULT NULL COMMENT '购买号码(6位随机码)',
  `user_id` double NOT NULL COMMENT '购买用户ID',
  `meal_ticket` double DEFAULT NULL COMMENT '获取饭票金额',
  `pay_status` tinyint(1) DEFAULT '0' COMMENT '支付状态(0支付失败，1支付成功)',
  `pay_time` datetime NOT NULL COMMENT '支付时间',
  PRIMARY KEY (`record_id`),
  KEY `FK_Reference_7` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='消费者订单';

-- ----------------------------
-- Records of lsx_user_order
-- ----------------------------
INSERT INTO `lsx_user_order` VALUES ('1', '1', '1', '1', '25', '24.5', '1212121212', '0.5', '1', '1', '1', '1', '2017-09-13 09:48:39');
INSERT INTO `lsx_user_order` VALUES ('2', '2', '1', '2', '50', '50', '1212121213', '0', '2', '2', '1', '1', '2017-09-12 09:48:39');
