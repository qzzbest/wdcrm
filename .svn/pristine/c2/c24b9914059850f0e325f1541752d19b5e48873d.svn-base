-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 07 月 09 日 17:27
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wdcrm614`
--

-- --------------------------------------------------------

--
-- 表的结构 `crm_client_project_record`
--

CREATE TABLE IF NOT EXISTS `crm_client_project_record` (
  `project_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目ID',
  `project_name` varchar(255) DEFAULT NULL COMMENT '项目名称',
  `project_url` text COMMENT '项目参考网址',
  `project_remark` text COMMENT '项目备注',
  `consultant_id` int(11) DEFAULT NULL COMMENT '咨询者ID（客户ID）',
  `repayment_id` int(11) DEFAULT NULL COMMENT '账单ID',
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='项目情况表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
