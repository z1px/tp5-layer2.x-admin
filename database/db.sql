/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100122
Source Host           : localhost:3306
Source Database       : python_tj

Target Server Type    : MYSQL
Target Server Version : 100122
File Encoding         : 65001

Date: 2017-12-26 00:41:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp5_login_log
-- ----------------------------
DROP TABLE IF EXISTS `tp5_login_log`;
CREATE TABLE `tp5_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL COMMENT '后台管理员ID',
  `username` varchar(30) DEFAULT NULL COMMENT '账号',
  `account` varchar(255) DEFAULT NULL COMMENT '账号信息',
  `ip` varchar(30) DEFAULT NULL COMMENT '当前IP',
  `area` varchar(50) DEFAULT NULL COMMENT 'IP区域',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台账号登录日志';

-- ----------------------------
-- Records of tp5_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for tp5_behavior_log
-- ----------------------------
DROP TABLE IF EXISTS `tp5_behavior_log`;
CREATE TABLE `tp5_behavior_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '行为名称',
  `module` varchar(30) NOT NULL COMMENT '模块',
  `controller` varchar(50) NOT NULL COMMENT '控制器',
  `action` varchar(255) NOT NULL COMMENT '方法',
  `url` varchar(255) DEFAULT NULL COMMENT '请求地址',
  `type` varchar(100) DEFAULT NULL COMMENT '请求类型',
  `request` text COMMENT '请求参数',
  `response` text COMMENT '处理结果',
  `ip` varchar(30) DEFAULT NULL COMMENT '当前IP',
  `area` varchar(50) DEFAULT NULL COMMENT 'IP区域',
  `admin_id` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `username` varchar(30) DEFAULT NULL COMMENT '账号',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台用户行为记录';

-- ----------------------------
-- Records of tp5_behavior_log
-- ----------------------------

-- ----------------------------
-- Table structure for tp5_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tp5_auth_rule`;
CREATE TABLE `tp5_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'type为1， condition字段就可以定义规则表达式',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `condition` varchar(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_auth_rule_name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='规则表';

-- ----------------------------
-- Records of tp5_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for tp5_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `tp5_auth_group_access`;
CREATE TABLE `tp5_auth_group_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `group_id` int(11) unsigned NOT NULL COMMENT '用户组id',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_auth_group_access_uid_groupid` (`uid`,`group_id`) USING BTREE,
  KEY `ind_auth_group_access_uid` (`uid`) USING BTREE,
  KEY `ind_auth_group_access_groupid` (`group_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户组明细表';

-- ----------------------------
-- Records of tp5_auth_group_access
-- ----------------------------

-- ----------------------------
-- Table structure for tp5_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `tp5_auth_group`;
CREATE TABLE `tp5_auth_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `rules` varchar(80) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户组表';

-- ----------------------------
-- Records of tp5_auth_group
-- ----------------------------

-- ----------------------------
-- Table structure for tp5_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp5_admin`;
CREATE TABLE `tp5_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(30) NOT NULL COMMENT '账号',
  `true_name` varchar(30) DEFAULT NULL COMMENT '真实姓名',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱号',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `img` varchar(200) DEFAULT NULL COMMENT '管理员头像',
  `status` tinyint(2) DEFAULT '1' COMMENT '账号状态：1-正常，2-禁用',
  `last_login_time` int(11) DEFAULT NULL COMMENT '最后一次登录时间',
  `ip` varchar(30) DEFAULT NULL COMMENT '当前IP',
  `area` varchar(50) DEFAULT NULL COMMENT 'IP区域',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `login_key` varchar(50) DEFAULT NULL COMMENT '登陆成功标记',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_tp5_admin_username` (`username`),
  UNIQUE KEY `uni_tp5_admin_email` (`email`),
  UNIQUE KEY `uni_tp5_admin_mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';

-- ----------------------------
-- Records of tp5_admin
-- ----------------------------
INSERT INTO `tp5_admin` VALUES ('1', 'sky001', '系统管理员', null, null, 'MDAwMDAwMDAwMDU1NzQ4NTJiYjU2MTlmMjlza3kxMjM', '/uploads/images/20171225/1.jpg', '1', '1514209995', '127.0.0.1', '', '1500016980', '1514210170', '5bc2810590bc81267326c3fec9c701bf');
SET FOREIGN_KEY_CHECKS=1;
