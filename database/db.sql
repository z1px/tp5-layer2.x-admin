/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100122
Source Host           : localhost:3306
Source Database       : python_tj

Target Server Type    : MYSQL
Target Server Version : 100122
File Encoding         : 65001

Date: 2017-12-29 01:27:57
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
  `icon` varchar(30) DEFAULT NULL COMMENT '图标，支持layui和fa-',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '权限类型：1-权限验证，2-权限白名单，3-权限黑名单',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '菜单状态，1-展示，2-不展示',
  `condition` varchar(100) DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_auth_rule_name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COMMENT='规则表';

-- ----------------------------
-- Records of tp5_auth_rule
-- ----------------------------
INSERT INTO `tp5_auth_rule` VALUES ('1', 'admin/Menu/default', '基础菜单', 'fa-ellipsis-h', '1', '1', null, '0', '1514476084', '1514476084');
INSERT INTO `tp5_auth_rule` VALUES ('2', 'admin?Setting/default', '系统设置', 'fa-cog', '1', '1', null, '0', '1514476120', '1514476120');
INSERT INTO `tp5_auth_rule` VALUES ('3', 'admin/Book/default', '地址库', 'fa-bookmark-o', '1', '1', null, '0', '1514476172', '1514476172');
INSERT INTO `tp5_auth_rule` VALUES ('4', 'admin/Test/default', '测试', 'fa-bug', '1', '1', null, '0', '1514476221', '1514476221');
INSERT INTO `tp5_auth_rule` VALUES ('5', 'admin/Account/default', '管理员', 'fa-user', '1', '1', null, '2', '1514476352', '1514476352');
INSERT INTO `tp5_auth_rule` VALUES ('6', 'admin/Account/table', '管理员列表', 'fa-users', '1', '1', null, '5', '1514476417', '1514476417');
INSERT INTO `tp5_auth_rule` VALUES ('7', 'admin/Auth/default', '权限管理', 'fa-file-text', '1', '1', null, '2', '1514476470', '1514476470');
INSERT INTO `tp5_auth_rule` VALUES ('8', 'admin/AuthGroup/table', '用户组', 'fa-eraser', '1', '1', null, '7', '1514476499', '1514476499');
INSERT INTO `tp5_auth_rule` VALUES ('9', 'admin/AuthRule/table', '菜单管理', '&#xe60e;', '1', '1', null, '7', '1514476540', '1514476540');
INSERT INTO `tp5_auth_rule` VALUES ('10', 'http://127.0.0.1', '常用地址', 'fa-book', '2', '1', null, '3', '1514476607', '1514476607');
INSERT INTO `tp5_auth_rule` VALUES ('11', 'http://fontawesome.dashgame.com', 'Font图标', 'fa-flag', '2', '1', null, '3', '1514476639', '1514476639');
INSERT INTO `tp5_auth_rule` VALUES ('12', 'http://www.layui.com/doc', 'LayUI文档', 'fa-file-text-o', '2', '1', null, '10', '1514476667', '1514476667');
INSERT INTO `tp5_auth_rule` VALUES ('13', 'https://www.kancloud.cn/manual/thinkphp5/118003', 'ThinkPHP5文档', 'fa-file-text-o', '2', '1', null, '10', '1514476737', '1514476737');
INSERT INTO `tp5_auth_rule` VALUES ('14', 'admin/Test/index', '测试方法', 'fa-bug', '1', '1', null, '4', '1514476781', '1514476781');
INSERT INTO `tp5_auth_rule` VALUES ('15', 'admin/Log/default', '日志管理', 'fa-file-text', '1', '1', null, '2', '1514479440', '1514479440');
INSERT INTO `tp5_auth_rule` VALUES ('16', 'admin/Account/loginLog', '登录日志', 'fa-eraser', '1', '1', null, '15', '1514479475', '1514479475');
INSERT INTO `tp5_auth_rule` VALUES ('17', 'admin/Account/behaviorLog', '行为日志', 'fa-file-text', '1', '1', null, '15', '1514479527', '1514479527');
INSERT INTO `tp5_auth_rule` VALUES ('18', 'admin/System/default', '系统菜单', 'fa-book', '1', '2', null, '2', '1514480583', '1514480723');
INSERT INTO `tp5_auth_rule` VALUES ('19', 'admin/Index/index', '首页', 'fa-book', '2', '2', null, '18', '1514480663', '1514480676');
INSERT INTO `tp5_auth_rule` VALUES ('20', 'admin/Index/main', '欢迎页', 'fa-book', '2', '2', null, '18', '1514480718', '1514480718');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='用户组明细表';

-- ----------------------------
-- Records of tp5_auth_group_access
-- ----------------------------
INSERT INTO `tp5_auth_group_access` VALUES ('1', '1', '1', '1514477143', '1514477143');

-- ----------------------------
-- Table structure for tp5_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `tp5_auth_group`;
CREATE TABLE `tp5_auth_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为2禁用',
  `rules` varchar(80) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='用户组表';

-- ----------------------------
-- Records of tp5_auth_group
-- ----------------------------
INSERT INTO `tp5_auth_group` VALUES ('1', '超级管理员', '1', '1,2,5,6,7,8,9,15,16,17,3,10,12,13,11,4,14', '1514477133', '1514479549');
INSERT INTO `tp5_auth_group` VALUES ('2', '普通管理员', '1', '1,2,15,16,17,3,10,12,13,11,4,14', '1514480400', '1514480400');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='后台用户表';

-- ----------------------------
-- Records of tp5_admin
-- ----------------------------
INSERT INTO `tp5_admin` VALUES ('1', 'sky001', '系统管理员', null, null, 'MDAwMDAwMDAwMDU1NzQ4NTJiYjU2MTlmMjlza3kxMjM', '/uploads/images/20171227/1.jpg', '1', '1514480873', '127.0.0.1', '', '1500016980', '1514480873', 'e9c9f2c5d967258722c57c24ac4748f3');
INSERT INTO `tp5_admin` VALUES ('2', 'sky002', '测试', null, null, 'MDAwMDAwMDAwMDU1NzQ4NTJiYjU2MTlmMjlza3kxMjM', null, '1', '1514481833', '127.0.0.1', '', '1514283560', '1514481833', 'b58dda1b245038cd5395a196d92fc600');
SET FOREIGN_KEY_CHECKS=1;
