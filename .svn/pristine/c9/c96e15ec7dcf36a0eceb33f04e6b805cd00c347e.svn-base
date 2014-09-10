-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1:3306
-- 生成日期: 2014 年 06 月 19 日 02:05
-- 服务器版本: 5.1.28
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wdcrm614`
--

-- --------------------------------------------------------

--
-- 表的结构 `crm_integral`
--

CREATE TABLE IF NOT EXISTS `crm_integral` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '积分id',
  `integral` int(11) NOT NULL COMMENT '具体积分',
  `mark` int(11) NOT NULL COMMENT '评分对象id',
  `mark_by` int(11) NOT NULL COMMENT '评分人id',
  `message` text NOT NULL COMMENT '评分理由',
  `date` varchar(15) NOT NULL COMMENT '评分时间',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态：0待审核，1通过，-1未通过',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 导出表中的数据 `crm_integral`
--

INSERT INTO `crm_integral` (`id`, `integral`, `mark`, `mark_by`, `message`, `date`, `state`) VALUES
(1, 10, 4, 3, '最近表现不错', '1402827885', 0),
(2, 1, 1, 3, '还好', '1402828037', 1),
(3, 5, 5, 3, '冯绍峰是否发', '1402828134', 1),
(4, 5, 5, 3, '送到能够输给神东公司', '1402828152', 1),
(5, 0, 1, 3, '', '1402902531', 0),
(6, 0, 1, 3, '', '1402906278', -1),
(7, 5, 4, 3, 'sdf', '1402911730', 0),
(8, 7, 1, 3, '表现良好', '1402911758', 1),
(9, 5, 1, 3, '表现良好', '1402911788', 1),
(10, 3, 6, 3, '还不错', '1402911949', 1),
(11, 3, 5, 3, '微盘搜索那个山东大公司收到了能够使你公司公司能够收到公司董松金佛但是能够对付god烦恼god发宫东风godfog哦该烦恼都共哦佛对方能够', '1402970753', 0),
(12, 5, 3, 1, '发士大夫十分飞洒发', '1403077425', 1);
