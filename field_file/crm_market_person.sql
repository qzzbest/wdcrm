-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 08 月 15 日 19:50
-- 服务器版本: 5.1.46-community
-- PHP 版本: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wdcrm`
--

-- --------------------------------------------------------

--
-- 表的结构 `crm_market_person`
--

CREATE TABLE IF NOT EXISTS `crm_market_person` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '联系人id',
  `market_id` int(11) NOT NULL COMMENT '市场资源id',
  `person_name` varchar(30) NOT NULL COMMENT '联系人',
  `role` varchar(30) NOT NULL COMMENT '职责',
  `mobilephone` varchar(20) NOT NULL COMMENT '手机号码',
  `telephone` varchar(20) NOT NULL COMMENT '固定电话',
  `qq` varchar(20) NOT NULL COMMENT 'QQ',
  `email` varchar(35) NOT NULL COMMENT '邮箱',
  PRIMARY KEY (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='市场联系人表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
