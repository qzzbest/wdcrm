-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 09 月 10 日 19:12
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
-- 表的结构 `crm_employee_weixin`
--

CREATE TABLE IF NOT EXISTS `crm_employee_weixin` (
  `employee_weixin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `employee_weixin_number` varchar(50) NOT NULL,
  PRIMARY KEY (`employee_weixin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='员工微信表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `crm_employee_weixin`
--

INSERT INTO `crm_employee_weixin` (`employee_weixin_id`, `employee_id`, `employee_weixin_number`) VALUES
(1, 52, '22'),
(4, 51, '88888666');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
