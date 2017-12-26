/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : python_tj

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2017-12-26 19:07:52
*/

SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO `tp5_admin` VALUES ('1', 'sky001', '系统管理员1', null, null, 'MDAwMDAwMDAwMDU1NzQ4NTJiYjU2MTlmMjlza3kxMjM', '/uploads/images/20171226/622762d0f703918fc7b7cdc2533d269759eec450.jpg', '1', '1514248878', '127.0.0.1', '', '1500016980', '1514283541', '8936572d410bb0fa87ab83b0863a2b89');
INSERT INTO `tp5_admin` VALUES ('2', 'sky002', '11', null, null, 'MDAwMDAwMDAwMDU1NzQ4NTJiYjU2MTlmMjlza3kxMjM', null, '1', '1970', '127.0.0.1', '', '1514283560', '1514283599', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='用户组表';

-- ----------------------------
-- Records of tp5_auth_group
-- ----------------------------
INSERT INTO `tp5_auth_group` VALUES ('1', '超级管理员', '1', '1,2', '1514270273', '1514278093');
INSERT INTO `tp5_auth_group` VALUES ('2', '管理员', '1', '2', '1514278007', '1514278007');
INSERT INTO `tp5_auth_group` VALUES ('3', '测试', '2', '1', '1514278016', '1514278394');
INSERT INTO `tp5_auth_group` VALUES ('4', '开发', '1', '1', '1514278036', '1514278036');
INSERT INTO `tp5_auth_group` VALUES ('5', '商务', '2', '2', '1514278055', '1514278396');
INSERT INTO `tp5_auth_group` VALUES ('6', '财务', '2', '1', '1514278078', '1514278397');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COMMENT='用户组明细表';

-- ----------------------------
-- Records of tp5_auth_group_access
-- ----------------------------
INSERT INTO `tp5_auth_group_access` VALUES ('10', '1', '2', '1514283541', '1514283541');
INSERT INTO `tp5_auth_group_access` VALUES ('11', '2', '4', '1514283560', '1514283560');

-- ----------------------------
-- Table structure for tp5_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tp5_auth_rule`;
CREATE TABLE `tp5_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `icon` varchar(30) DEFAULT NULL COMMENT '图标，支持layui和fa-',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'type为1， condition字段就可以定义规则表达式',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为2禁用',
  `condition` varchar(100) DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_auth_rule_name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='规则表';

-- ----------------------------
-- Records of tp5_auth_rule
-- ----------------------------
INSERT INTO `tp5_auth_rule` VALUES ('1', 'admin/Menu/default', '基本菜单', 'fa-book', '1', '1', null, '0', '1514250467', '1514286300');
INSERT INTO `tp5_auth_rule` VALUES ('2', 'admin/Setting/default', '系统设置', '', '1', '1', null, '0', '1514250841', '1514286303');

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
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COMMENT='后台用户行为记录';

-- ----------------------------
-- Records of tp5_behavior_log
-- ----------------------------
INSERT INTO `tp5_behavior_log` VALUES ('1', '修改个人信息', 'admin', 'Account', 'myinfo', 'http://py.thinkphp5.com/account/myinfo.html', 'post', '{\"username\":\"sky001\",\"true_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\\u5458\",\"mobile\":\"\",\"email\":\"\",\"file\":\"\",\"img\":\"\\/uploads\\/images\\/20171226\\/622762d0f703918fc7b7cdc2533d269759eec450.jpg\",\"password\":\"\",\"check_password\":\"\",\"id\":\"1\"}', '{\"code\":1,\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514248885', null);
INSERT INTO `tp5_behavior_log` VALUES ('2', '图片上传', 'admin', 'Upload', 'img', 'http://py.thinkphp5.com/upload/img.html', 'post', '{\"upload\":\"file\"}', '{\"code\":\"0\",\"msg\":\"\\u56fe\\u7247\\u4e0a\\u4f20\\u6210\\u529f\",\"data\":{\"src\":\"\\/uploads\\/images\\/20171226\\/622762d0f703918fc7b7cdc2533d269759eec450.jpg\",\"title\":\"622762d0f703918fc7b7cdc2533d269759eec450.jpg\"}}', '127.0.0.1', '', '1', 'sky001', '1514249065', null);
INSERT INTO `tp5_behavior_log` VALUES ('3', '', 'admin', 'AuthRule', 'add', 'http://py.thinkphp5.com/auth_rule/add.html', 'post', '{\"title\":\"\\u9996\\u9875\",\"name\":\"admin\\/Index\\/index\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\"}', '{\"code\":\"0\",\"msg\":\"condition\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514250223', null);
INSERT INTO `tp5_behavior_log` VALUES ('4', '', 'admin', 'AuthRule', 'add', 'http://py.thinkphp5.com/auth_rule/add.html', 'post', '{\"title\":\"\\u9996\\u9875\",\"name\":\"admin\\/Index\\/index\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\"}', '{\"code\":\"1\",\"msg\":\"\\u65b0\\u589e\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"name\":\"admin\\/Index\\/index\",\"title\":\"\\u9996\\u9875\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"create_time\":\"2017-12-26 09:07:47\",\"update_time\":\"2017-12-26 09:07:47\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514250468', null);
INSERT INTO `tp5_behavior_log` VALUES ('5', '', 'admin', 'AuthRule', 'editstatus', 'http://py.thinkphp5.com/auth_rule/editstatus.html', 'post', '{\"id\":\"1\",\"status\":\"2\"}', '{\"code\":\"0\",\"msg\":\"status\\u5fc5\\u987b\\u5728 0,1 \\u8303\\u56f4\\u5185\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514250692', null);
INSERT INTO `tp5_behavior_log` VALUES ('6', '', 'admin', 'AuthRule', 'editstatus', 'http://py.thinkphp5.com/auth_rule/editstatus.html', 'post', '{\"id\":\"1\",\"status\":\"2\"}', '{\"code\":\"0\",\"msg\":\"\\u7cfb\\u7edf\\u8d26\\u53f7\\u4e0d\\u53ef\\u4ee5\\u7981\\u7528\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514250717', null);
INSERT INTO `tp5_behavior_log` VALUES ('7', '', 'admin', 'AuthRule', 'editstatus', 'http://py.thinkphp5.com/auth_rule/editstatus.html', 'post', '{\"id\":\"1\",\"status\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"name\":\"admin\\/Index\\/index\",\"title\":\"\\u9996\\u9875\",\"type\":\"1\",\"status\":\"2\",\"condition\":\"\",\"create_time\":\"2017-12-26 09:07:47\",\"update_time\":\"2017-12-26 09:12:53\",\"type_name\":\"\\u5b9a\\u4e49\\u89c4\\u5219\\u8868\\u8fbe\\u5f0f\",\"status_name\":\"\\u7981\\u7528\"}}', '127.0.0.1', '', '1', 'sky001', '1514250773', null);
INSERT INTO `tp5_behavior_log` VALUES ('8', '', 'admin', 'AuthRule', 'editstatus', 'http://py.thinkphp5.com/auth_rule/editstatus.html', 'post', '{\"id\":\"1\",\"status\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"name\":\"admin\\/Index\\/index\",\"title\":\"\\u9996\\u9875\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"create_time\":\"2017-12-26 09:07:47\",\"update_time\":\"2017-12-26 09:12:55\",\"type_name\":\"\\u5b9a\\u4e49\\u89c4\\u5219\\u8868\\u8fbe\\u5f0f\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514250775', null);
INSERT INTO `tp5_behavior_log` VALUES ('9', '', 'admin', 'AuthRule', 'add', 'http://py.thinkphp5.com/auth_rule/add.html', 'post', '{\"title\":\"\\u4e3b\\u9875\",\"name\":\"admin\\/Index\\/main\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\"}', '{\"code\":\"1\",\"msg\":\"\\u65b0\\u589e\\u6210\\u529f\",\"data\":{\"id\":\"2\",\"name\":\"admin\\/Index\\/main\",\"title\":\"\\u4e3b\\u9875\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"create_time\":\"2017-12-26 09:14:01\",\"update_time\":\"2017-12-26 09:14:01\",\"type_name\":\"\\u5b9a\\u4e49\\u89c4\\u5219\\u8868\\u8fbe\\u5f0f\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514250848', null);
INSERT INTO `tp5_behavior_log` VALUES ('10', '', 'admin', 'AuthRule', 'add', 'http://py.thinkphp5.com/auth_rule/add.html', 'post', '{\"title\":\"\\u4e3b\\u9875\",\"name\":\"admin\\/Index\\/main\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\"}', '{\"code\":\"0\",\"msg\":\"name\\u5df2\\u5b58\\u5728\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514250857', null);
INSERT INTO `tp5_behavior_log` VALUES ('11', '', 'admin', 'AuthRule', 'add', 'http://py.thinkphp5.com/auth_rule/add.html', 'post', '{\"title\":\"\\u4e3b\\u9875\",\"name\":\"admin\\/Index\\/main\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\"}', '{\"code\":\"0\",\"msg\":\"name\\u5df2\\u5b58\\u5728\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514250858', null);
INSERT INTO `tp5_behavior_log` VALUES ('12', '', 'admin', 'AuthRule', 'editstatus', 'http://py.thinkphp5.com/auth_rule/editstatus.html', 'post', '{\"id\":\"2\",\"status\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"2\",\"name\":\"admin\\/Index\\/main\",\"title\":\"\\u4e3b\\u9875\",\"type\":\"1\",\"status\":\"2\",\"condition\":\"\",\"create_time\":\"2017-12-26 09:14:01\",\"update_time\":\"2017-12-26 09:16:46\",\"type_name\":\"\\u5b9a\\u4e49\\u89c4\\u5219\\u8868\\u8fbe\\u5f0f\",\"status_name\":\"\\u7981\\u7528\"}}', '127.0.0.1', '', '1', 'sky001', '1514251006', null);
INSERT INTO `tp5_behavior_log` VALUES ('13', '', 'admin', 'AuthRule', 'editstatus', 'http://py.thinkphp5.com/auth_rule/editstatus.html', 'post', '{\"id\":\"2\",\"status\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"2\",\"name\":\"admin\\/Index\\/main\",\"title\":\"\\u4e3b\\u9875\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"create_time\":\"2017-12-26 09:14:01\",\"update_time\":\"2017-12-26 09:16:46\",\"type_name\":\"\\u5b9a\\u4e49\\u89c4\\u5219\\u8868\\u8fbe\\u5f0f\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514251007', null);
INSERT INTO `tp5_behavior_log` VALUES ('14', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514253377', null);
INSERT INTO `tp5_behavior_log` VALUES ('15', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514253395', null);
INSERT INTO `tp5_behavior_log` VALUES ('16', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514253476', null);
INSERT INTO `tp5_behavior_log` VALUES ('17', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514253547', null);
INSERT INTO `tp5_behavior_log` VALUES ('18', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514253603', null);
INSERT INTO `tp5_behavior_log` VALUES ('19', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\",\"status\":\"1\",\"rules\":\"79,81\"}', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514254635', null);
INSERT INTO `tp5_behavior_log` VALUES ('20', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514256157', null);
INSERT INTO `tp5_behavior_log` VALUES ('21', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\",\"status\":\"1\",\"rules\":\"77,1\"}', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514256168', null);
INSERT INTO `tp5_behavior_log` VALUES ('22', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\",\"status\":\"1\"}', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514262275', null);
INSERT INTO `tp5_behavior_log` VALUES ('23', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514269707', null);
INSERT INTO `tp5_behavior_log` VALUES ('24', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514269819', null);
INSERT INTO `tp5_behavior_log` VALUES ('25', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514269826', null);
INSERT INTO `tp5_behavior_log` VALUES ('26', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514269836', null);
INSERT INTO `tp5_behavior_log` VALUES ('27', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514269839', null);
INSERT INTO `tp5_behavior_log` VALUES ('28', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514269863', null);
INSERT INTO `tp5_behavior_log` VALUES ('29', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514269867', null);
INSERT INTO `tp5_behavior_log` VALUES ('30', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"72,73,76,74,75,41,42,48,49,50,51,45,52,53,54,55,47,64,65,66\"}', '{\"code\":\"1\",\"msg\":\"\\u65b0\\u589e\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"72,73,76,74,75,41,42,48,49,50,51,45,52,53,54,55,47,64,65,66\",\"create_time\":\"2017-12-26 14:37:53\",\"update_time\":\"2017-12-26 14:37:53\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514270273', null);
INSERT INTO `tp5_behavior_log` VALUES ('31', '', 'admin', 'AuthGroup', 'edit', 'http://py.thinkphp5.com/auth_group/edit.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"id\":\"1\",\"rules\":\"72,73,76,74,75,41,42,48,49,50,51\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"72,73,76,74,75,41,42,48,49,50,51\",\"create_time\":\"2017-12-26 14:37:53\",\"update_time\":\"2017-12-26 14:45:01\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514270702', null);
INSERT INTO `tp5_behavior_log` VALUES ('32', '', 'admin', 'AuthGroup', 'edit', 'http://py.thinkphp5.com/auth_group/edit.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"id\":\"1\",\"rules\":\"41,42,48,49,50,51,45,52,53,54,55,47,64,65,66\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"41,42,48,49,50,51,45,52,53,54,55,47,64,65,66\",\"create_time\":\"2017-12-26 14:37:53\",\"update_time\":\"2017-12-26 14:45:21\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514270721', null);
INSERT INTO `tp5_behavior_log` VALUES ('33', '', 'admin', 'AuthGroup', 'edit', 'http://py.thinkphp5.com/auth_group/edit.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"id\":\"1\",\"rules\":\"\"}', '{\"code\":\"0\",\"msg\":\"rules\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514270804', null);
INSERT INTO `tp5_behavior_log` VALUES ('34', '', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\",\"status\":\"1\",\"rules\":\"1\"}', '{\"code\":\"0\",\"msg\":\"title\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514273612', null);
INSERT INTO `tp5_behavior_log` VALUES ('35', '', 'admin', 'AuthGroup', 'edit', 'http://py.thinkphp5.com/auth_group/edit.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"id\":\"1\",\"rules\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"1\",\"create_time\":\"2017-12-26 14:37:53\",\"update_time\":\"2017-12-26 15:33:40\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514273620', null);
INSERT INTO `tp5_behavior_log` VALUES ('36', '', 'admin', 'AuthGroup', 'edit', 'http://py.thinkphp5.com/auth_group/edit.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"id\":\"1\",\"rules\":\"1\"}', '{\"code\":\"0\",\"msg\":\"\\u4fee\\u6539\\u5931\\u8d25\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514273921', null);
INSERT INTO `tp5_behavior_log` VALUES ('37', '', 'admin', 'AuthGroup', 'edit', 'http://py.thinkphp5.com/auth_group/edit.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"id\":\"1\",\"rules\":\"1,2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"1,2\",\"create_time\":\"2017-12-26 14:37:53\",\"update_time\":\"2017-12-26 15:38:44\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514273924', null);
INSERT INTO `tp5_behavior_log` VALUES ('38', '', 'admin', 'AuthGroup', 'edit', 'http://py.thinkphp5.com/auth_group/edit.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"id\":\"1\",\"rules\":\"\"}', '{\"code\":\"0\",\"msg\":\"rules\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514274566', null);
INSERT INTO `tp5_behavior_log` VALUES ('39', '', 'admin', 'AuthGroup', 'edit', 'http://py.thinkphp5.com/auth_group/edit.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"id\":\"1\",\"rules\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"1\",\"create_time\":\"2017-12-26 14:37:53\",\"update_time\":\"2017-12-26 15:49:29\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514274569', null);
INSERT INTO `tp5_behavior_log` VALUES ('40', '', 'admin', 'AuthRule', 'editstatus', 'http://py.thinkphp5.com/auth_rule/editstatus.html', 'post', '{\"id\":\"2\",\"status\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"2\",\"name\":\"admin\\/Index\\/main\",\"title\":\"\\u4e3b\\u9875\",\"type\":\"1\",\"status\":\"2\",\"condition\":\"\",\"create_time\":\"2017-12-26 09:14:01\",\"update_time\":\"2017-12-26 16:07:59\",\"type_name\":\"\\u5b9a\\u4e49\\u89c4\\u5219\\u8868\\u8fbe\\u5f0f\",\"status_name\":\"\\u7981\\u7528\"}}', '127.0.0.1', '', '1', 'sky001', '1514275679', null);
INSERT INTO `tp5_behavior_log` VALUES ('41', '', 'admin', 'AuthRule', 'editstatus', 'http://py.thinkphp5.com/auth_rule/editstatus.html', 'post', '{\"id\":\"2\",\"status\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"2\",\"name\":\"admin\\/Index\\/main\",\"title\":\"\\u4e3b\\u9875\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"create_time\":\"2017-12-26 09:14:01\",\"update_time\":\"2017-12-26 16:08:00\",\"type_name\":\"\\u5b9a\\u4e49\\u89c4\\u5219\\u8868\\u8fbe\\u5f0f\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514275680', null);
INSERT INTO `tp5_behavior_log` VALUES ('42', '添加用户组', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u65b0\\u589e\\u6210\\u529f\",\"data\":{\"id\":\"2\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"2\",\"create_time\":\"2017-12-26 16:46:47\",\"update_time\":\"2017-12-26 16:46:47\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514278007', null);
INSERT INTO `tp5_behavior_log` VALUES ('43', '添加用户组', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\\u6d4b\\u8bd5\",\"status\":\"1\",\"rules\":\"1\"}', '{\"code\":\"0\",\"msg\":\"title\\u5df2\\u5b58\\u5728\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514278026', null);
INSERT INTO `tp5_behavior_log` VALUES ('44', '添加用户组', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\\u6d4b\\u8bd5\",\"status\":\"1\",\"rules\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u65b0\\u589e\\u6210\\u529f\",\"data\":{\"id\":\"3\",\"title\":\"\\u6d4b\\u8bd5\",\"status\":\"1\",\"rules\":\"1\",\"create_time\":\"2017-12-26 16:46:56\",\"update_time\":\"2017-12-26 16:46:56\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514278026', null);
INSERT INTO `tp5_behavior_log` VALUES ('45', '添加用户组', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\\u5f00\\u53d1\",\"status\":\"1\",\"rules\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u65b0\\u589e\\u6210\\u529f\",\"data\":{\"id\":\"4\",\"title\":\"\\u5f00\\u53d1\",\"status\":\"1\",\"rules\":\"1\",\"create_time\":\"2017-12-26 16:47:16\",\"update_time\":\"2017-12-26 16:47:16\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514278036', null);
INSERT INTO `tp5_behavior_log` VALUES ('46', '添加用户组', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\\u5546\\u52a1\",\"status\":\"1\",\"rules\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u65b0\\u589e\\u6210\\u529f\",\"data\":{\"id\":\"5\",\"title\":\"\\u5546\\u52a1\",\"status\":\"1\",\"rules\":\"2\",\"create_time\":\"2017-12-26 16:47:35\",\"update_time\":\"2017-12-26 16:47:35\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514278055', null);
INSERT INTO `tp5_behavior_log` VALUES ('47', '添加用户组', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\\u8d22\\u52a1\",\"status\":\"1\",\"rules\":\"\"}', '{\"code\":\"0\",\"msg\":\"rules\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514278078', null);
INSERT INTO `tp5_behavior_log` VALUES ('48', '添加用户组', 'admin', 'AuthGroup', 'add', 'http://py.thinkphp5.com/auth_group/add.html', 'post', '{\"title\":\"\\u8d22\\u52a1\",\"status\":\"1\",\"rules\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u65b0\\u589e\\u6210\\u529f\",\"data\":{\"id\":\"6\",\"title\":\"\\u8d22\\u52a1\",\"status\":\"1\",\"rules\":\"1\",\"create_time\":\"2017-12-26 16:47:58\",\"update_time\":\"2017-12-26 16:47:58\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514278083', null);
INSERT INTO `tp5_behavior_log` VALUES ('49', '修改用户组信息', 'admin', 'AuthGroup', 'edit', 'http://py.thinkphp5.com/auth_group/edit.html', 'post', '{\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"id\":\"1\",\"rules\":\"1,2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"1\",\"title\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"rules\":\"1,2\",\"create_time\":\"2017-12-26 14:37:53\",\"update_time\":\"2017-12-26 16:48:13\",\"status_name\":\"\\u6b63\\u5e38\"}}', '127.0.0.1', '', '1', 'sky001', '1514278093', null);
INSERT INTO `tp5_behavior_log` VALUES ('50', '修改用户组状态', 'admin', 'AuthGroup', 'editstatus', 'http://py.thinkphp5.com/auth_group/editstatus.html', 'post', '{\"id\":\"3\",\"status\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"3\",\"title\":\"\\u6d4b\\u8bd5\",\"status\":\"2\",\"rules\":\"1\",\"create_time\":\"2017-12-26 16:46:56\",\"update_time\":\"2017-12-26 16:53:14\",\"status_name\":\"\\u7981\\u7528\"}}', '127.0.0.1', '', '1', 'sky001', '1514278394', null);
INSERT INTO `tp5_behavior_log` VALUES ('51', '修改用户组状态', 'admin', 'AuthGroup', 'editstatus', 'http://py.thinkphp5.com/auth_group/editstatus.html', 'post', '{\"id\":\"5\",\"status\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"5\",\"title\":\"\\u5546\\u52a1\",\"status\":\"2\",\"rules\":\"2\",\"create_time\":\"2017-12-26 16:47:35\",\"update_time\":\"2017-12-26 16:53:16\",\"status_name\":\"\\u7981\\u7528\"}}', '127.0.0.1', '', '1', 'sky001', '1514278396', null);
INSERT INTO `tp5_behavior_log` VALUES ('52', '修改用户组状态', 'admin', 'AuthGroup', 'editstatus', 'http://py.thinkphp5.com/auth_group/editstatus.html', 'post', '{\"id\":\"6\",\"status\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":{\"id\":\"6\",\"title\":\"\\u8d22\\u52a1\",\"status\":\"2\",\"rules\":\"1\",\"create_time\":\"2017-12-26 16:47:58\",\"update_time\":\"2017-12-26 16:53:17\",\"status_name\":\"\\u7981\\u7528\"}}', '127.0.0.1', '', '1', 'sky001', '1514278397', null);
INSERT INTO `tp5_behavior_log` VALUES ('53', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_ids\":{\"1\":\"on\",\"2\":\"on\"},\"group_id\":\"2\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514278860', null);
INSERT INTO `tp5_behavior_log` VALUES ('54', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_ids\":{\"1\":\"on\",\"4\":\"on\"},\"group_id\":\"2\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514278904', null);
INSERT INTO `tp5_behavior_log` VALUES ('55', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"1\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"uid\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281278', null);
INSERT INTO `tp5_behavior_log` VALUES ('56', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"1\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281726', null);
INSERT INTO `tp5_behavior_log` VALUES ('57', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281749', null);
INSERT INTO `tp5_behavior_log` VALUES ('58', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281752', null);
INSERT INTO `tp5_behavior_log` VALUES ('59', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281777', null);
INSERT INTO `tp5_behavior_log` VALUES ('60', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281801', null);
INSERT INTO `tp5_behavior_log` VALUES ('61', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281813', null);
INSERT INTO `tp5_behavior_log` VALUES ('62', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281842', null);
INSERT INTO `tp5_behavior_log` VALUES ('63', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"\\u4fee\\u6539\\u5931\\u8d25\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281879', null);
INSERT INTO `tp5_behavior_log` VALUES ('64', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"\\u4fee\\u6539\\u5931\\u8d25\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281893', null);
INSERT INTO `tp5_behavior_log` VALUES ('65', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281913', null);
INSERT INTO `tp5_behavior_log` VALUES ('66', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281932', null);
INSERT INTO `tp5_behavior_log` VALUES ('67', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514281980', null);
INSERT INTO `tp5_behavior_log` VALUES ('68', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282024', null);
INSERT INTO `tp5_behavior_log` VALUES ('69', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282089', null);
INSERT INTO `tp5_behavior_log` VALUES ('70', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282125', null);
INSERT INTO `tp5_behavior_log` VALUES ('71', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282160', null);
INSERT INTO `tp5_behavior_log` VALUES ('72', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"4\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"\\u4fee\\u6539\\u5931\\u8d25\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282176', null);
INSERT INTO `tp5_behavior_log` VALUES ('73', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"4\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"\\u4fee\\u6539\\u5931\\u8d25\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282189', null);
INSERT INTO `tp5_behavior_log` VALUES ('74', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"4\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"\\u4fee\\u6539\\u5931\\u8d25\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282232', null);
INSERT INTO `tp5_behavior_log` VALUES ('75', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"4\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282484', null);
INSERT INTO `tp5_behavior_log` VALUES ('76', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"4\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282504', null);
INSERT INTO `tp5_behavior_log` VALUES ('77', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"1\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"data normal\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282523', null);
INSERT INTO `tp5_behavior_log` VALUES ('78', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"1\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282562', null);
INSERT INTO `tp5_behavior_log` VALUES ('79', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"1\":\"on\",\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282585', null);
INSERT INTO `tp5_behavior_log` VALUES ('80', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"4\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"\\u4fee\\u6539\\u5931\\u8d25\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282590', null);
INSERT INTO `tp5_behavior_log` VALUES ('81', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"4\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282634', null);
INSERT INTO `tp5_behavior_log` VALUES ('82', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"4\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282642', null);
INSERT INTO `tp5_behavior_log` VALUES ('83', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"1\":\"on\",\"2\":\"on\",\"4\":\"on\"},\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282684', null);
INSERT INTO `tp5_behavior_log` VALUES ('84', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":{\"1\":\"on\",\"2\":\"on\"},\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282689', null);
INSERT INTO `tp5_behavior_log` VALUES ('85', '修改用户组', 'admin', 'Account', 'editgroup', 'http://py.thinkphp5.com/account/editgroup.html', 'post', '{\"group_id\":\"1\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514282713', null);
INSERT INTO `tp5_behavior_log` VALUES ('86', '修改管理员信息', 'admin', 'Account', 'edit', 'http://py.thinkphp5.com/account/edit.html', 'post', '{\"username\":\"sky001\",\"password\":\"sky123\",\"mobile\":\"\",\"email\":\"\",\"true_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"group_id\":\"2\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"id\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283211', null);
INSERT INTO `tp5_behavior_log` VALUES ('87', '修改管理员信息', 'admin', 'Account', 'edit', 'http://py.thinkphp5.com/account/edit.html', 'post', '{\"username\":\"sky001\",\"password\":\"sky123\",\"mobile\":\"\",\"email\":\"\",\"true_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"group_id\":\"2\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"id\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283224', null);
INSERT INTO `tp5_behavior_log` VALUES ('88', '修改管理员信息', 'admin', 'Account', 'edit', 'http://py.thinkphp5.com/account/edit.html', 'post', '{\"username\":\"sky001\",\"password\":\"sky123\",\"mobile\":\"\",\"email\":\"\",\"true_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\\u5458\",\"status\":\"1\",\"group_id\":\"2\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"id\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283310', null);
INSERT INTO `tp5_behavior_log` VALUES ('89', '修改管理员信息', 'admin', 'Account', 'edit', 'http://py.thinkphp5.com/account/edit.html', 'post', '{\"username\":\"sky001\",\"password\":\"sky123\",\"mobile\":\"\",\"email\":\"\",\"true_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\\u54581\",\"status\":\"1\",\"group_id\":\"2\",\"id\":\"1\"}', '{\"code\":\"0\",\"msg\":\"id\\u4e0d\\u80fd\\u4e3a\\u7a7a\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283318', null);
INSERT INTO `tp5_behavior_log` VALUES ('90', '修改管理员信息', 'admin', 'Account', 'edit', 'http://py.thinkphp5.com/account/edit.html', 'post', '{\"username\":\"sky001\",\"password\":\"sky123\",\"mobile\":\"\",\"email\":\"\",\"true_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\\u54581\",\"status\":\"1\",\"group_id\":\"2\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283542', null);
INSERT INTO `tp5_behavior_log` VALUES ('91', '添加管理员', 'admin', 'Account', 'add', 'http://py.thinkphp5.com/account/add.html', 'post', '{\"username\":\"sky002\",\"password\":\"sky123\",\"mobile\":\"\",\"email\":\"\",\"true_name\":\"\",\"status\":\"2\",\"group_id\":\"4\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283560', null);
INSERT INTO `tp5_behavior_log` VALUES ('92', '修改管理员状态', 'admin', 'Account', 'editstatus', 'http://py.thinkphp5.com/account/editstatus.html', 'post', '{\"id\":\"2\",\"status\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283577', null);
INSERT INTO `tp5_behavior_log` VALUES ('93', '修改管理员信息', 'admin', 'Account', 'edit', 'http://py.thinkphp5.com/account/edit.html', 'post', '{\"id\":\"2\",\"username\":\"sky002\",\"true_name\":\"11\",\"mobile\":\"\",\"email\":\"\",\"status\":\"1\",\"create_time\":\"2017-12-26 18:19:20\",\"last_login_time\":\"1970-01-01 08:00:00\",\"ip\":\"127.0.0.1\",\"area\":\"\",\"status_name\":\"\\u6b63\\u5e38\",\"LAY_TABLE_INDEX\":\"0\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283599', null);
INSERT INTO `tp5_behavior_log` VALUES ('94', '修改规则信息', 'admin', 'AuthRule', 'edit', 'http://py.thinkphp5.com/auth_rule/edit.html', 'post', '{\"title\":\"\\u57fa\\u672c\\u83dc\\u5355\",\"name\":\"admin\\/default\\/menu\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283699', null);
INSERT INTO `tp5_behavior_log` VALUES ('95', '修改规则信息', 'admin', 'AuthRule', 'edit', 'http://py.thinkphp5.com/auth_rule/edit.html', 'post', '{\"title\":\"\\u4e3b\\u9875\",\"name\":\"admin\\/Setting\\/default\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"id\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283721', null);
INSERT INTO `tp5_behavior_log` VALUES ('96', '修改规则信息', 'admin', 'AuthRule', 'edit', 'http://py.thinkphp5.com/auth_rule/edit.html', 'post', '{\"title\":\"\\u57fa\\u672c\\u83dc\\u5355\",\"name\":\"admin\\/Menu\\/default\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283733', null);
INSERT INTO `tp5_behavior_log` VALUES ('97', '修改规则信息', 'admin', 'AuthRule', 'edit', 'http://py.thinkphp5.com/auth_rule/edit.html', 'post', '{\"title\":\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\",\"name\":\"admin\\/Setting\\/default\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"id\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514283742', null);
INSERT INTO `tp5_behavior_log` VALUES ('98', '修改规则信息', 'admin', 'AuthRule', 'edit', 'http://py.thinkphp5.com/auth_rule/edit.html', 'post', '{\"title\":\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\",\"name\":\"admin\\/Setting\\/default\",\"icon\":\"&#xe62e;\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"id\":\"2\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514285686', null);
INSERT INTO `tp5_behavior_log` VALUES ('99', '修改规则信息', 'admin', 'AuthRule', 'edit', 'http://py.thinkphp5.com/auth_rule/edit.html', 'post', '{\"title\":\"\\u57fa\\u672c\\u83dc\\u5355\",\"name\":\"admin\\/Menu\\/default\",\"icon\":\"fa-book\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"id\":\"1\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514285786', null);
INSERT INTO `tp5_behavior_log` VALUES ('100', '修改规则信息', 'admin', 'AuthRule', 'edit', 'http://py.thinkphp5.com/auth_rule/edit.html', 'post', '{\"title\":\"\\u57fa\\u672c\\u83dc\\u5355\",\"name\":\"admin\\/Menu\\/default\",\"icon\":\"fa-book\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"id\":\"1\",\"rules\":\"\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514286300', null);
INSERT INTO `tp5_behavior_log` VALUES ('101', '修改规则信息', 'admin', 'AuthRule', 'edit', 'http://py.thinkphp5.com/auth_rule/edit.html', 'post', '{\"title\":\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\",\"name\":\"admin\\/Setting\\/default\",\"icon\":\"\\ue62e\",\"type\":\"1\",\"status\":\"1\",\"condition\":\"\",\"id\":\"2\",\"rules\":\"\"}', '{\"code\":\"1\",\"msg\":\"\\u4fee\\u6539\\u6210\\u529f\",\"data\":[]}', '127.0.0.1', '', '1', 'sky001', '1514286303', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='后台账号登录日志';

-- ----------------------------
-- Records of tp5_login_log
-- ----------------------------
INSERT INTO `tp5_login_log` VALUES ('1', '1', 'sky001', '{\"id\":1,\"username\":\"sky001\",\"true_name\":\"\\u7cfb\\u7edf\\u7ba1\\u7406\\u5458\",\"mobile\":null,\"email\":null}', '127.0.0.1', '', '1514248878', null);
