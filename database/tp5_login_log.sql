/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : python_tj

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2017-12-21 18:01:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp5_login_log
-- ----------------------------
DROP TABLE IF EXISTS `tp5_login_log`;
CREATE TABLE `tp5_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL COMMENT '后台管理员ID',
  `account` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '账号信息',
  `ip` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '当前IP',
  `area` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'IP区域',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='后台账号登录日志';

-- ----------------------------
-- Records of tp5_login_log
-- ----------------------------
INSERT INTO `tp5_login_log` VALUES ('1', '1', '{\"id\":1,\"username\":\"sky001\",\"true_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\\u5458\",\"mobile\":null,\"email\":null}', '127.0.0.1', '', '1513839362', null);
