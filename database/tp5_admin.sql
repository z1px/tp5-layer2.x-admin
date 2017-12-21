/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : python_tj

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2017-12-21 18:01:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp5_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp5_admin`;
CREATE TABLE `tp5_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '账号',
  `true_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '真实姓名',
  `email` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '邮箱号',
  `mobile` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT '手机号',
  `password` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `img` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '管理员头像',
  `status` tinyint(2) DEFAULT '1' COMMENT '账号状态：1-正常，2-禁用',
  `last_login_time` int(11) DEFAULT NULL COMMENT '最后一次登录时间',
  `ip` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '当前IP',
  `area` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'IP区域',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `login_key` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '登陆成功标记',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_tp5_admin_username` (`username`),
  UNIQUE KEY `uni_tp5_admin_email` (`email`),
  UNIQUE KEY `uni_tp5_admin_mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='新后台用户表';

-- ----------------------------
-- Records of tp5_admin
-- ----------------------------
INSERT INTO `tp5_admin` VALUES ('1', 'sky001', '系统管理员', null, null, 'MDAwMDAwMDAwMDU1NzQ4NTJiYjU2MTlmMjlza3kxMjM', '/uploads/images/20171031/622762d0f703918fc7b7cdc2533d269759eec450.jpg', '1', '1513839362', '127.0.0.1', '', '1500016980', '1513839362', 'eeb95de55c6ea8f8e296a6051cf1bca0');
