/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : art_calendar

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-05-27 10:28:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ac_art
-- ----------------------------
DROP TABLE IF EXISTS `ac_art`;
CREATE TABLE `ac_art` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `calid` tinyint(1) NOT NULL,
  `openid` varchar(200) NOT NULL,
  `poster` varchar(200) NOT NULL,
  `show_time` datetime NOT NULL,
  `cityid` int(10) NOT NULL,
  `address` varchar(20) NOT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `group_code` varchar(150) DEFAULT NULL,
  `price_min` int(10) NOT NULL DEFAULT '0',
  `price_max` int(10) NOT NULL DEFAULT '0',
  `price_link` varchar(255) DEFAULT NULL,
  `ext_content` varchar(255) DEFAULT NULL COMMENT '扩展内容json，图文，链接等',
  `ext_link` varchar(125) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 正常 -1 删除',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`(191))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ac_art
-- ----------------------------
INSERT INTO `ac_art` VALUES ('1', '音乐会', '1', '123', 'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo_top_ca79a146.png', '2017-05-22 16:00:00', '110100', '北京海淀区', '简介简介1', 'https://res.wx.qq.com/mpres/htmledition/images/mp_qrcode218877.gif', '111', '22', 'http://www.baidu.com/', '', 'http://www.baidu.com/', '0', '2017-05-22 16:17:34');
INSERT INTO `ac_art` VALUES ('2', '话剧演出1', '1', '1231', 'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo_top_ca79a146.png', '2017-05-22 16:00:00', '110100', '北京海淀区', '简介简介2', 'https://res.wx.qq.com/mpres/htmledition/images/mp_qrcode218877.gif', '33', '444', 'http://www.baidu.com/', '', 'http://www.baidu.com/', '0', '2017-05-22 16:18:51');
INSERT INTO `ac_art` VALUES ('3', '话剧演出12222', '1', '123', 'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo_top_ca79a146.png', '2017-05-23 16:00:00', '110100', '北京海淀区', '简介简介2', 'https://res.wx.qq.com/mpres/htmledition/images/mp_qrcode218877.gif', '555', '666', 'http://www.baidu.com/', '', 'http://www.baidu.com/', '0', '2017-05-22 16:19:02');
INSERT INTO `ac_art` VALUES ('4', '话剧演出44443222', '1', '123', 'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo_top_ca79a146.png', '2017-05-19 16:00:00', '110100', '北京海淀区', '简介简介', 'https://res.wx.qq.com/mpres/htmledition/images/mp_qrcode218877.gif', '22', '33', 'http://www.baidu.com/', '', 'http://www.baidu.com/', '0', '2017-05-22 16:19:50');

-- ----------------------------
-- Table structure for ac_art_item
-- ----------------------------
DROP TABLE IF EXISTS `ac_art_item`;
CREATE TABLE `ac_art_item` (
  `artid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `dictid` tinyint(1) NOT NULL COMMENT '2 价格  3 演出类型  4 演出者',
  KEY `art_item` (`artid`,`itemid`,`dictid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ac_art_item
-- ----------------------------
INSERT INTO `ac_art_item` VALUES ('1', '12', '2');
INSERT INTO `ac_art_item` VALUES ('1', '13', '2');
INSERT INTO `ac_art_item` VALUES ('1', '25', '3');
INSERT INTO `ac_art_item` VALUES ('1', '26', '3');
INSERT INTO `ac_art_item` VALUES ('1', '27', '4');
INSERT INTO `ac_art_item` VALUES ('1', '28', '4');
INSERT INTO `ac_art_item` VALUES ('2', '12', '2');
INSERT INTO `ac_art_item` VALUES ('3', '12', '2');
INSERT INTO `ac_art_item` VALUES ('3', '13', '2');
INSERT INTO `ac_art_item` VALUES ('3', '25', '3');
INSERT INTO `ac_art_item` VALUES ('3', '26', '3');
INSERT INTO `ac_art_item` VALUES ('3', '27', '4');
INSERT INTO `ac_art_item` VALUES ('4', '28', '4');
INSERT INTO `ac_art_item` VALUES ('4', '29', '4');

-- ----------------------------
-- Table structure for ac_calendar
-- ----------------------------
DROP TABLE IF EXISTS `ac_calendar`;
CREATE TABLE `ac_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `catid` tinyint(1) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `view_count` int(10) DEFAULT '10',
  `relation_userinfo` varchar(255) NOT NULL DEFAULT '""' COMMENT '关联用户信息json',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 正常 -1 删除',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`(191))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ac_calendar
-- ----------------------------
INSERT INTO `ac_calendar` VALUES ('1', '就爱重金属23', '1', '123', '455', '{\"relation_num\":\"1232333\",\"relation_nickname\":\"\\u5c31\\u7231\\u91cd\\u91d1\\u5c5e22\",\"relation_avatar\":\"http:\\/\\/g.yaolanimage.cn\\/www\\/images\\/avatar50.gif\"}', '0', '2017-05-21 18:30:36');
INSERT INTO `ac_calendar` VALUES ('2', '就爱重金属', '2', '123', '19', '{\"relation_num\":\"12322222333\",\"relation_nickname\":\"\\u5c31\\u7231\\u91cd\\u91d1\\u5c5e22\",\"relation_avatar\":\"http:\\/\\/g.yaolanimage.cn\\/www\\/images\\/avatar50.gif\"}', '-1', '2017-05-03 18:33:06');
INSERT INTO `ac_calendar` VALUES ('3', '哈哈', '2', '12333', '11', '{\"relation_num\":\"12323333121233\",\"relation_nickname\":\"\\u5c31\\u7231\\u91cd\\u91d1\\u5c5e22\",\"relation_avatar\":\"http:\\/\\/g.yaolanimage.cn\\/www\\/images\\/avatar50.gif\"}', '0', '2017-05-21 18:35:03');

-- ----------------------------
-- Table structure for ac_city
-- ----------------------------
DROP TABLE IF EXISTS `ac_city`;
CREATE TABLE `ac_city` (
  `cityid` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `offical_name` varchar(255) NOT NULL,
  `isshow` tinyint(1) DEFAULT '0',
  `sort` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cityid`),
  UNIQUE KEY `PK_CITYLIST` (`cityid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ac_city
-- ----------------------------
INSERT INTO `ac_city` VALUES ('0', '其它', '其它', '1', '99');
INSERT INTO `ac_city` VALUES ('110100', '北京', '北京市', '1', '0');
INSERT INTO `ac_city` VALUES ('120100', '天津', '天津市', '1', '0');
INSERT INTO `ac_city` VALUES ('130100', '石家庄', '石家庄市', '1', '0');
INSERT INTO `ac_city` VALUES ('130200', '唐山', '唐山市', '0', '0');
INSERT INTO `ac_city` VALUES ('130300', '秦皇岛', '秦皇岛市', '0', '0');
INSERT INTO `ac_city` VALUES ('130400', '邯郸', '邯郸市', '0', '0');
INSERT INTO `ac_city` VALUES ('130500', '邢台', '邢台市', '0', '0');
INSERT INTO `ac_city` VALUES ('130600', '保定', '保定市', '0', '0');
INSERT INTO `ac_city` VALUES ('130700', '张家口', '张家口市', '0', '0');
INSERT INTO `ac_city` VALUES ('130800', '承德', '承德市', '0', '0');
INSERT INTO `ac_city` VALUES ('130900', '沧州', '沧州市', '0', '0');
INSERT INTO `ac_city` VALUES ('131000', '廊坊', '廊坊市', '0', '0');
INSERT INTO `ac_city` VALUES ('131100', '衡水', '衡水市', '0', '0');
INSERT INTO `ac_city` VALUES ('140100', '太原', '太原市', '1', '0');
INSERT INTO `ac_city` VALUES ('140200', '大同', '大同市', '0', '0');
INSERT INTO `ac_city` VALUES ('140300', '阳泉', '阳泉市', '0', '0');
INSERT INTO `ac_city` VALUES ('140400', '长治', '长治市', '0', '0');
INSERT INTO `ac_city` VALUES ('140500', '晋城', '晋城市', '0', '0');
INSERT INTO `ac_city` VALUES ('140600', '朔州', '朔州市', '0', '0');
INSERT INTO `ac_city` VALUES ('140700', '晋中', '晋中市', '0', '0');
INSERT INTO `ac_city` VALUES ('140800', '运城', '运城市', '0', '0');
INSERT INTO `ac_city` VALUES ('140900', '忻州', '忻州市', '0', '0');
INSERT INTO `ac_city` VALUES ('141000', '临汾', '临汾市', '0', '0');
INSERT INTO `ac_city` VALUES ('141100', '吕梁', '吕梁市', '0', '0');
INSERT INTO `ac_city` VALUES ('150100', '呼和浩特', '呼和浩特市', '0', '0');
INSERT INTO `ac_city` VALUES ('150200', '包头', '包头市', '0', '0');
INSERT INTO `ac_city` VALUES ('150300', '乌海', '乌海市', '0', '0');
INSERT INTO `ac_city` VALUES ('150400', '赤峰', '赤峰市', '0', '0');
INSERT INTO `ac_city` VALUES ('150500', '通辽', '通辽市', '0', '0');
INSERT INTO `ac_city` VALUES ('150600', '鄂尔多斯', '鄂尔多斯市', '0', '0');
INSERT INTO `ac_city` VALUES ('150700', '呼伦贝尔', '呼伦贝尔市', '0', '0');
INSERT INTO `ac_city` VALUES ('150800', '巴彦淖尔', '巴彦淖尔市', '0', '0');
INSERT INTO `ac_city` VALUES ('150900', '乌兰察布', '乌兰察布市', '0', '0');
INSERT INTO `ac_city` VALUES ('152200', '兴安', '兴安盟', '0', '0');
INSERT INTO `ac_city` VALUES ('152500', '锡林郭勒', '锡林郭勒盟', '0', '0');
INSERT INTO `ac_city` VALUES ('152900', '阿拉善', '阿拉善盟', '0', '0');
INSERT INTO `ac_city` VALUES ('210100', '沈阳', '沈阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('210200', '大连', '大连市', '0', '0');
INSERT INTO `ac_city` VALUES ('210300', '鞍山', '鞍山市', '0', '0');
INSERT INTO `ac_city` VALUES ('210400', '抚顺', '抚顺市', '0', '0');
INSERT INTO `ac_city` VALUES ('210500', '本溪', '本溪市', '0', '0');
INSERT INTO `ac_city` VALUES ('210600', '丹东', '丹东市', '0', '0');
INSERT INTO `ac_city` VALUES ('210700', '锦州', '锦州市', '0', '0');
INSERT INTO `ac_city` VALUES ('210800', '营口', '营口市', '0', '0');
INSERT INTO `ac_city` VALUES ('210900', '阜新', '阜新市', '0', '0');
INSERT INTO `ac_city` VALUES ('211000', '辽阳', '辽阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('211100', '盘锦', '盘锦市', '0', '0');
INSERT INTO `ac_city` VALUES ('211200', '铁岭', '铁岭市', '0', '0');
INSERT INTO `ac_city` VALUES ('211300', '朝阳', '朝阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('211400', '葫芦岛', '葫芦岛市', '0', '0');
INSERT INTO `ac_city` VALUES ('220100', '长春', '长春市', '0', '0');
INSERT INTO `ac_city` VALUES ('220200', '吉林', '吉林市', '0', '0');
INSERT INTO `ac_city` VALUES ('220300', '四平', '四平市', '0', '0');
INSERT INTO `ac_city` VALUES ('220400', '辽源', '辽源市', '0', '0');
INSERT INTO `ac_city` VALUES ('220500', '通化', '通化市', '0', '0');
INSERT INTO `ac_city` VALUES ('220600', '白山', '白山市', '0', '0');
INSERT INTO `ac_city` VALUES ('220700', '松原', '松原市', '0', '0');
INSERT INTO `ac_city` VALUES ('220800', '白城', '白城市', '0', '0');
INSERT INTO `ac_city` VALUES ('222400', '延边', '延边朝鲜族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('230100', '哈尔滨', '哈尔滨市', '0', '0');
INSERT INTO `ac_city` VALUES ('230200', '齐齐哈尔', '齐齐哈尔市', '0', '0');
INSERT INTO `ac_city` VALUES ('230300', '鸡西', '鸡西市', '0', '0');
INSERT INTO `ac_city` VALUES ('230400', '鹤岗', '鹤岗市', '0', '0');
INSERT INTO `ac_city` VALUES ('230500', '双鸭山', '双鸭山市', '0', '0');
INSERT INTO `ac_city` VALUES ('230600', '大庆', '大庆市', '0', '0');
INSERT INTO `ac_city` VALUES ('230700', '伊春', '伊春市', '0', '0');
INSERT INTO `ac_city` VALUES ('230800', '佳木斯', '佳木斯市', '0', '0');
INSERT INTO `ac_city` VALUES ('230900', '七台河', '七台河市', '0', '0');
INSERT INTO `ac_city` VALUES ('231000', '牡丹江', '牡丹江市', '0', '0');
INSERT INTO `ac_city` VALUES ('231100', '黑河', '黑河市', '0', '0');
INSERT INTO `ac_city` VALUES ('231200', '绥化', '绥化市', '0', '0');
INSERT INTO `ac_city` VALUES ('232700', '大兴安岭', '大兴安岭地区', '0', '0');
INSERT INTO `ac_city` VALUES ('310100', '上海', '上海市', '1', '0');
INSERT INTO `ac_city` VALUES ('320100', '南京', '南京市', '0', '0');
INSERT INTO `ac_city` VALUES ('320200', '无锡', '无锡市', '0', '0');
INSERT INTO `ac_city` VALUES ('320300', '徐州', '徐州市', '0', '0');
INSERT INTO `ac_city` VALUES ('320400', '常州', '常州市', '0', '0');
INSERT INTO `ac_city` VALUES ('320500', '苏州', '苏州市', '0', '0');
INSERT INTO `ac_city` VALUES ('320600', '南通', '南通市', '0', '0');
INSERT INTO `ac_city` VALUES ('320700', '连云港', '连云港市', '0', '0');
INSERT INTO `ac_city` VALUES ('320800', '淮安', '淮安市', '0', '0');
INSERT INTO `ac_city` VALUES ('320900', '盐城', '盐城市', '0', '0');
INSERT INTO `ac_city` VALUES ('321000', '扬州', '扬州市', '0', '0');
INSERT INTO `ac_city` VALUES ('321100', '镇江', '镇江市', '0', '0');
INSERT INTO `ac_city` VALUES ('321200', '泰州', '泰州市', '0', '0');
INSERT INTO `ac_city` VALUES ('321300', '宿迁', '宿迁市', '0', '0');
INSERT INTO `ac_city` VALUES ('330100', '杭州', '杭州市', '0', '0');
INSERT INTO `ac_city` VALUES ('330200', '宁波', '宁波市', '0', '0');
INSERT INTO `ac_city` VALUES ('330300', '温州', '温州市', '0', '0');
INSERT INTO `ac_city` VALUES ('330400', '嘉兴', '嘉兴市', '0', '0');
INSERT INTO `ac_city` VALUES ('330500', '湖州', '湖州市', '0', '0');
INSERT INTO `ac_city` VALUES ('330600', '绍兴', '绍兴市', '0', '0');
INSERT INTO `ac_city` VALUES ('330700', '金华', '金华市', '0', '0');
INSERT INTO `ac_city` VALUES ('330800', '衢州', '衢州市', '0', '0');
INSERT INTO `ac_city` VALUES ('330900', '舟山', '舟山市', '0', '0');
INSERT INTO `ac_city` VALUES ('331000', '台州', '台州市', '0', '0');
INSERT INTO `ac_city` VALUES ('331100', '丽水', '丽水市', '0', '0');
INSERT INTO `ac_city` VALUES ('340100', '合肥', '合肥市', '0', '0');
INSERT INTO `ac_city` VALUES ('340200', '芜湖', '芜湖市', '0', '0');
INSERT INTO `ac_city` VALUES ('340300', '蚌埠', '蚌埠市', '0', '0');
INSERT INTO `ac_city` VALUES ('340400', '淮南', '淮南市', '0', '0');
INSERT INTO `ac_city` VALUES ('340500', '马鞍山', '马鞍山市', '0', '0');
INSERT INTO `ac_city` VALUES ('340600', '淮北', '淮北市', '0', '0');
INSERT INTO `ac_city` VALUES ('340700', '铜陵', '铜陵市', '0', '0');
INSERT INTO `ac_city` VALUES ('340800', '安庆', '安庆市', '0', '0');
INSERT INTO `ac_city` VALUES ('341000', '黄山', '黄山市', '0', '0');
INSERT INTO `ac_city` VALUES ('341100', '滁州', '滁州市', '0', '0');
INSERT INTO `ac_city` VALUES ('341200', '阜阳', '阜阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('341300', '宿州', '宿州市', '0', '0');
INSERT INTO `ac_city` VALUES ('341400', '巢湖', '巢湖市', '0', '0');
INSERT INTO `ac_city` VALUES ('341500', '六安', '六安市', '0', '0');
INSERT INTO `ac_city` VALUES ('341600', '亳州', '亳州市', '0', '0');
INSERT INTO `ac_city` VALUES ('341700', '池州', '池州市', '0', '0');
INSERT INTO `ac_city` VALUES ('341800', '宣城', '宣城市', '0', '0');
INSERT INTO `ac_city` VALUES ('350100', '福州', '福州市', '0', '0');
INSERT INTO `ac_city` VALUES ('350200', '厦门', '厦门市', '0', '0');
INSERT INTO `ac_city` VALUES ('350300', '莆田', '莆田市', '0', '0');
INSERT INTO `ac_city` VALUES ('350400', '三明', '三明市', '0', '0');
INSERT INTO `ac_city` VALUES ('350500', '泉州', '泉州市', '0', '0');
INSERT INTO `ac_city` VALUES ('350600', '漳州', '漳州市', '0', '0');
INSERT INTO `ac_city` VALUES ('350700', '南平', '南平市', '0', '0');
INSERT INTO `ac_city` VALUES ('350800', '龙岩', '龙岩市', '0', '0');
INSERT INTO `ac_city` VALUES ('350900', '宁德', '宁德市', '0', '0');
INSERT INTO `ac_city` VALUES ('360100', '南昌', '南昌市', '0', '0');
INSERT INTO `ac_city` VALUES ('360200', '景德镇', '景德镇市', '0', '0');
INSERT INTO `ac_city` VALUES ('360300', '萍乡', '萍乡市', '0', '0');
INSERT INTO `ac_city` VALUES ('360400', '九江', '九江市', '0', '0');
INSERT INTO `ac_city` VALUES ('360500', '新余', '新余市', '0', '0');
INSERT INTO `ac_city` VALUES ('360600', '鹰潭', '鹰潭市', '0', '0');
INSERT INTO `ac_city` VALUES ('360700', '赣州', '赣州市', '0', '0');
INSERT INTO `ac_city` VALUES ('360800', '吉安', '吉安市', '0', '0');
INSERT INTO `ac_city` VALUES ('360900', '宜春', '宜春市', '0', '0');
INSERT INTO `ac_city` VALUES ('361000', '抚州', '抚州市', '0', '0');
INSERT INTO `ac_city` VALUES ('361100', '上饶', '上饶市', '0', '0');
INSERT INTO `ac_city` VALUES ('370100', '济南', '济南市', '0', '0');
INSERT INTO `ac_city` VALUES ('370200', '青岛', '青岛市', '0', '0');
INSERT INTO `ac_city` VALUES ('370300', '淄博', '淄博市', '0', '0');
INSERT INTO `ac_city` VALUES ('370400', '枣庄', '枣庄市', '0', '0');
INSERT INTO `ac_city` VALUES ('370500', '东营', '东营市', '0', '0');
INSERT INTO `ac_city` VALUES ('370600', '烟台', '烟台市', '0', '0');
INSERT INTO `ac_city` VALUES ('370700', '潍坊', '潍坊市', '0', '0');
INSERT INTO `ac_city` VALUES ('370800', '济宁', '济宁市', '0', '0');
INSERT INTO `ac_city` VALUES ('370900', '泰安', '泰安市', '0', '0');
INSERT INTO `ac_city` VALUES ('371000', '威海', '威海市', '0', '0');
INSERT INTO `ac_city` VALUES ('371100', '日照', '日照市', '0', '0');
INSERT INTO `ac_city` VALUES ('371200', '莱芜', '莱芜市', '0', '0');
INSERT INTO `ac_city` VALUES ('371300', '临沂', '临沂市', '0', '0');
INSERT INTO `ac_city` VALUES ('371400', '德州', '德州市', '0', '0');
INSERT INTO `ac_city` VALUES ('371500', '聊城', '聊城市', '0', '0');
INSERT INTO `ac_city` VALUES ('371600', '滨州', '滨州市', '0', '0');
INSERT INTO `ac_city` VALUES ('371700', '菏泽', '菏泽市', '0', '0');
INSERT INTO `ac_city` VALUES ('410100', '郑州', '郑州市', '0', '0');
INSERT INTO `ac_city` VALUES ('410200', '开封', '开封市', '0', '0');
INSERT INTO `ac_city` VALUES ('410300', '洛阳', '洛阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('410400', '平顶山', '平顶山市', '0', '0');
INSERT INTO `ac_city` VALUES ('410500', '安阳', '安阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('410600', '鹤壁', '鹤壁市', '0', '0');
INSERT INTO `ac_city` VALUES ('410700', '新乡', '新乡市', '0', '0');
INSERT INTO `ac_city` VALUES ('410800', '焦作', '焦作市', '0', '0');
INSERT INTO `ac_city` VALUES ('410900', '濮阳', '濮阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('411000', '许昌', '许昌市', '0', '0');
INSERT INTO `ac_city` VALUES ('411100', '漯河', '漯河市', '0', '0');
INSERT INTO `ac_city` VALUES ('411200', '三门峡', '三门峡市', '0', '0');
INSERT INTO `ac_city` VALUES ('411300', '南阳', '南阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('411400', '商丘', '商丘市', '0', '0');
INSERT INTO `ac_city` VALUES ('411500', '信阳', '信阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('411600', '周口', '周口市', '0', '0');
INSERT INTO `ac_city` VALUES ('411700', '驻马店', '驻马店市', '0', '0');
INSERT INTO `ac_city` VALUES ('420100', '武汉', '武汉市', '0', '0');
INSERT INTO `ac_city` VALUES ('420200', '黄石', '黄石市', '0', '0');
INSERT INTO `ac_city` VALUES ('420300', '十堰', '十堰市', '0', '0');
INSERT INTO `ac_city` VALUES ('420500', '宜昌', '宜昌市', '0', '0');
INSERT INTO `ac_city` VALUES ('420600', '襄樊', '襄樊市', '0', '0');
INSERT INTO `ac_city` VALUES ('420700', '鄂州', '鄂州市', '0', '0');
INSERT INTO `ac_city` VALUES ('420800', '荆门', '荆门市', '0', '0');
INSERT INTO `ac_city` VALUES ('420900', '孝感', '孝感市', '0', '0');
INSERT INTO `ac_city` VALUES ('421000', '荆州', '荆州市', '0', '0');
INSERT INTO `ac_city` VALUES ('421100', '黄冈', '黄冈市', '0', '0');
INSERT INTO `ac_city` VALUES ('421200', '咸宁', '咸宁市', '0', '0');
INSERT INTO `ac_city` VALUES ('421300', '随州', '随州市', '0', '0');
INSERT INTO `ac_city` VALUES ('422800', '恩施', '恩施土家族苗族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('429000', '省直辖县级行政单位', '省直辖县级行政单位', '0', '0');
INSERT INTO `ac_city` VALUES ('430100', '长沙', '长沙市', '0', '0');
INSERT INTO `ac_city` VALUES ('430200', '株洲', '株洲市', '0', '0');
INSERT INTO `ac_city` VALUES ('430300', '湘潭', '湘潭市', '0', '0');
INSERT INTO `ac_city` VALUES ('430400', '衡阳', '衡阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('430500', '邵阳', '邵阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('430600', '岳阳', '岳阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('430700', '常德', '常德市', '0', '0');
INSERT INTO `ac_city` VALUES ('430800', '张家界', '张家界市', '0', '0');
INSERT INTO `ac_city` VALUES ('430900', '益阳', '益阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('431000', '郴州', '郴州市', '0', '0');
INSERT INTO `ac_city` VALUES ('431100', '永州', '永州市', '0', '0');
INSERT INTO `ac_city` VALUES ('431200', '怀化', '怀化市', '0', '0');
INSERT INTO `ac_city` VALUES ('431300', '娄底', '娄底市', '0', '0');
INSERT INTO `ac_city` VALUES ('433100', '湘西', '湘西土家族苗族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('440100', '广州', '广州市', '0', '0');
INSERT INTO `ac_city` VALUES ('440200', '韶关', '韶关市', '0', '0');
INSERT INTO `ac_city` VALUES ('440300', '深圳', '深圳市', '0', '0');
INSERT INTO `ac_city` VALUES ('440400', '珠海', '珠海市', '0', '0');
INSERT INTO `ac_city` VALUES ('440500', '汕头', '汕头市', '0', '0');
INSERT INTO `ac_city` VALUES ('440600', '佛山', '佛山市', '0', '0');
INSERT INTO `ac_city` VALUES ('440700', '江门', '江门市', '0', '0');
INSERT INTO `ac_city` VALUES ('440800', '湛江', '湛江市', '0', '0');
INSERT INTO `ac_city` VALUES ('440900', '茂名', '茂名市', '0', '0');
INSERT INTO `ac_city` VALUES ('441200', '肇庆', '肇庆市', '0', '0');
INSERT INTO `ac_city` VALUES ('441300', '惠州', '惠州市', '0', '0');
INSERT INTO `ac_city` VALUES ('441400', '梅州', '梅州市', '0', '0');
INSERT INTO `ac_city` VALUES ('441500', '汕尾', '汕尾市', '0', '0');
INSERT INTO `ac_city` VALUES ('441600', '河源', '河源市', '0', '0');
INSERT INTO `ac_city` VALUES ('441700', '阳江', '阳江市', '0', '0');
INSERT INTO `ac_city` VALUES ('441800', '清远', '清远市', '0', '0');
INSERT INTO `ac_city` VALUES ('441900', '东莞', '东莞市', '0', '0');
INSERT INTO `ac_city` VALUES ('442000', '中山', '中山市', '0', '0');
INSERT INTO `ac_city` VALUES ('445100', '潮州', '潮州市', '0', '0');
INSERT INTO `ac_city` VALUES ('445200', '揭阳', '揭阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('445300', '云浮', '云浮市', '0', '0');
INSERT INTO `ac_city` VALUES ('450100', '南宁', '南宁市', '0', '0');
INSERT INTO `ac_city` VALUES ('450200', '柳州', '柳州市', '0', '0');
INSERT INTO `ac_city` VALUES ('450300', '桂林', '桂林市', '0', '0');
INSERT INTO `ac_city` VALUES ('450400', '梧州', '梧州市', '0', '0');
INSERT INTO `ac_city` VALUES ('450500', '北海', '北海市', '0', '0');
INSERT INTO `ac_city` VALUES ('450600', '防城港', '防城港市', '0', '0');
INSERT INTO `ac_city` VALUES ('450700', '钦州', '钦州市', '0', '0');
INSERT INTO `ac_city` VALUES ('450800', '贵港', '贵港市', '0', '0');
INSERT INTO `ac_city` VALUES ('450900', '玉林', '玉林市', '0', '0');
INSERT INTO `ac_city` VALUES ('451000', '百色', '百色市', '0', '0');
INSERT INTO `ac_city` VALUES ('451100', '贺州', '贺州市', '0', '0');
INSERT INTO `ac_city` VALUES ('451200', '河池', '河池市', '0', '0');
INSERT INTO `ac_city` VALUES ('451300', '来宾', '来宾市', '0', '0');
INSERT INTO `ac_city` VALUES ('451400', '崇左', '崇左市', '0', '0');
INSERT INTO `ac_city` VALUES ('460100', '海口', '海口市', '0', '0');
INSERT INTO `ac_city` VALUES ('460200', '三亚', '三亚市', '0', '0');
INSERT INTO `ac_city` VALUES ('469000', '省直辖县级行政单位', '省直辖县级行政单位', '0', '0');
INSERT INTO `ac_city` VALUES ('500100', '重庆', '重庆市', '0', '0');
INSERT INTO `ac_city` VALUES ('510100', '成都', '成都市', '0', '0');
INSERT INTO `ac_city` VALUES ('510300', '自贡', '自贡市', '0', '0');
INSERT INTO `ac_city` VALUES ('510400', '攀枝花', '攀枝花市', '0', '0');
INSERT INTO `ac_city` VALUES ('510500', '泸州', '泸州市', '0', '0');
INSERT INTO `ac_city` VALUES ('510600', '德阳', '德阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('510700', '绵阳', '绵阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('510800', '广元', '广元市', '0', '0');
INSERT INTO `ac_city` VALUES ('510900', '遂宁', '遂宁市', '0', '0');
INSERT INTO `ac_city` VALUES ('511000', '内江', '内江市', '0', '0');
INSERT INTO `ac_city` VALUES ('511100', '乐山', '乐山市', '0', '0');
INSERT INTO `ac_city` VALUES ('511300', '南充', '南充市', '0', '0');
INSERT INTO `ac_city` VALUES ('511400', '眉山', '眉山市', '0', '0');
INSERT INTO `ac_city` VALUES ('511500', '宜宾', '宜宾市', '0', '0');
INSERT INTO `ac_city` VALUES ('511600', '广安', '广安市', '0', '0');
INSERT INTO `ac_city` VALUES ('511700', '达州', '达州市', '0', '0');
INSERT INTO `ac_city` VALUES ('511800', '雅安', '雅安市', '0', '0');
INSERT INTO `ac_city` VALUES ('511900', '巴中', '巴中市', '0', '0');
INSERT INTO `ac_city` VALUES ('512000', '资阳', '资阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('513200', '阿坝', '阿坝藏族羌族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('513300', '甘孜', '甘孜藏族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('513400', '凉山', '凉山彝族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('520100', '贵阳', '贵阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('520200', '六盘水', '六盘水市', '0', '0');
INSERT INTO `ac_city` VALUES ('520300', '遵义', '遵义市', '0', '0');
INSERT INTO `ac_city` VALUES ('520400', '安顺', '安顺市', '0', '0');
INSERT INTO `ac_city` VALUES ('522200', '铜仁', '铜仁地区', '0', '0');
INSERT INTO `ac_city` VALUES ('522300', '黔西南', '黔西南布依族苗族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('522400', '毕节', '毕节地区', '0', '0');
INSERT INTO `ac_city` VALUES ('522600', '黔东南', '黔东南苗族侗族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('522700', '黔南', '黔南布依族苗族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('530100', '昆明', '昆明市', '0', '0');
INSERT INTO `ac_city` VALUES ('530300', '曲靖', '曲靖市', '0', '0');
INSERT INTO `ac_city` VALUES ('530400', '玉溪', '玉溪市', '0', '0');
INSERT INTO `ac_city` VALUES ('530500', '保山', '保山市', '0', '0');
INSERT INTO `ac_city` VALUES ('530600', '昭通', '昭通市', '0', '0');
INSERT INTO `ac_city` VALUES ('530700', '丽江', '丽江市', '0', '0');
INSERT INTO `ac_city` VALUES ('530800', '普洱', '普洱市', '0', '0');
INSERT INTO `ac_city` VALUES ('530900', '临沧', '临沧市', '0', '0');
INSERT INTO `ac_city` VALUES ('532300', '楚雄', '楚雄彝族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('532500', '红河', '红河哈尼族彝族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('532600', '文山', '文山壮族苗族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('532800', '西双版纳', '西双版纳傣族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('532900', '大理', '大理白族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('533100', '德宏', '德宏傣族景颇族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('533300', '怒江', '怒江傈僳族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('533400', '迪庆', '迪庆藏族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('540100', '拉萨', '拉萨市', '0', '0');
INSERT INTO `ac_city` VALUES ('542100', '昌都', '昌都地区', '0', '0');
INSERT INTO `ac_city` VALUES ('542200', '山南', '山南地区', '0', '0');
INSERT INTO `ac_city` VALUES ('542300', '日喀则', '日喀则地区', '0', '0');
INSERT INTO `ac_city` VALUES ('542400', '那曲', '那曲地区', '0', '0');
INSERT INTO `ac_city` VALUES ('542500', '阿里', '阿里地区', '0', '0');
INSERT INTO `ac_city` VALUES ('542600', '林芝', '林芝地区', '0', '0');
INSERT INTO `ac_city` VALUES ('610100', '西安', '西安市', '0', '0');
INSERT INTO `ac_city` VALUES ('610200', '铜川', '铜川市', '0', '0');
INSERT INTO `ac_city` VALUES ('610300', '宝鸡', '宝鸡市', '0', '0');
INSERT INTO `ac_city` VALUES ('610400', '咸阳', '咸阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('610500', '渭南', '渭南市', '0', '0');
INSERT INTO `ac_city` VALUES ('610600', '延安', '延安市', '0', '0');
INSERT INTO `ac_city` VALUES ('610700', '汉中', '汉中市', '0', '0');
INSERT INTO `ac_city` VALUES ('610800', '榆林', '榆林市', '0', '0');
INSERT INTO `ac_city` VALUES ('610900', '安康', '安康市', '0', '0');
INSERT INTO `ac_city` VALUES ('611000', '商洛', '商洛市', '0', '0');
INSERT INTO `ac_city` VALUES ('620100', '兰州', '兰州市', '0', '0');
INSERT INTO `ac_city` VALUES ('620200', '嘉峪关', '嘉峪关市', '0', '0');
INSERT INTO `ac_city` VALUES ('620300', '金昌', '金昌市', '0', '0');
INSERT INTO `ac_city` VALUES ('620400', '白银', '白银市', '0', '0');
INSERT INTO `ac_city` VALUES ('620500', '天水', '天水市', '0', '0');
INSERT INTO `ac_city` VALUES ('620600', '武威', '武威市', '0', '0');
INSERT INTO `ac_city` VALUES ('620700', '张掖', '张掖市', '0', '0');
INSERT INTO `ac_city` VALUES ('620800', '平凉', '平凉市', '0', '0');
INSERT INTO `ac_city` VALUES ('620900', '酒泉', '酒泉市', '0', '0');
INSERT INTO `ac_city` VALUES ('621000', '庆阳', '庆阳市', '0', '0');
INSERT INTO `ac_city` VALUES ('621100', '定西', '定西市', '0', '0');
INSERT INTO `ac_city` VALUES ('621200', '陇南', '陇南市', '0', '0');
INSERT INTO `ac_city` VALUES ('622900', '临夏', '临夏回族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('623000', '甘南', '甘南藏族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('630100', '西宁', '西宁市', '0', '0');
INSERT INTO `ac_city` VALUES ('632100', '海东', '海东地区', '0', '0');
INSERT INTO `ac_city` VALUES ('632200', '海北', '海北藏族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('632300', '黄南', '黄南藏族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('632500', '海南', '海南藏族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('632600', '果洛', '果洛藏族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('632700', '玉树', '玉树藏族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('632800', '海西', '海西蒙古族藏族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('640100', '银川', '银川市', '0', '0');
INSERT INTO `ac_city` VALUES ('640200', '石嘴山', '石嘴山市', '0', '0');
INSERT INTO `ac_city` VALUES ('640300', '吴忠', '吴忠市', '0', '0');
INSERT INTO `ac_city` VALUES ('640400', '固原', '固原市', '0', '0');
INSERT INTO `ac_city` VALUES ('640500', '中卫', '中卫市', '0', '0');
INSERT INTO `ac_city` VALUES ('650100', '乌鲁木齐', '乌鲁木齐市', '0', '0');
INSERT INTO `ac_city` VALUES ('650200', '克拉玛依', '克拉玛依市', '0', '0');
INSERT INTO `ac_city` VALUES ('652100', '吐鲁番', '吐鲁番地区', '0', '0');
INSERT INTO `ac_city` VALUES ('652200', '哈密', '哈密地区', '0', '0');
INSERT INTO `ac_city` VALUES ('652300', '昌吉', '昌吉回族自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('652700', '博尔塔拉', '博尔塔拉蒙古自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('652800', '巴音郭楞', '巴音郭楞蒙古自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('652900', '阿克苏', '阿克苏地区', '0', '0');
INSERT INTO `ac_city` VALUES ('653000', '克孜勒苏柯尔克孜', '克孜勒苏柯尔克孜自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('653100', '喀什', '喀什地区', '0', '0');
INSERT INTO `ac_city` VALUES ('653200', '和田', '和田地区', '0', '0');
INSERT INTO `ac_city` VALUES ('654000', '伊犁哈萨克', '伊犁哈萨克自治州', '0', '0');
INSERT INTO `ac_city` VALUES ('654200', '塔城', '塔城地区', '0', '0');
INSERT INTO `ac_city` VALUES ('654300', '阿勒泰', '阿勒泰地区', '0', '0');
INSERT INTO `ac_city` VALUES ('659000', '自治区直辖县级行政单位', '自治区直辖县级行政单位', '0', '0');

-- ----------------------------
-- Table structure for ac_dictionary
-- ----------------------------
DROP TABLE IF EXISTS `ac_dictionary`;
CREATE TABLE `ac_dictionary` (
  `dictionaryid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `mark` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `openid` varchar(128) DEFAULT '',
  `type` int(11) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dictionaryid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ac_dictionary
-- ----------------------------
INSERT INTO `ac_dictionary` VALUES ('1', '日历类型', '日历类型', '1', '', '1', '2017-05-18 17:27:08', '2017-05-18 17:27:08');
INSERT INTO `ac_dictionary` VALUES ('2', '价格范围', '价格范围', '1', '', '1', '2017-05-18 17:33:49', '2017-05-18 17:33:49');
INSERT INTO `ac_dictionary` VALUES ('3', '演出类型', '演出类型', '1', '', '1', '2017-05-21 13:15:19', '2017-05-21 13:15:19');
INSERT INTO `ac_dictionary` VALUES ('4', '演出者', '演出者', '1', '', '1', '2017-05-21 13:15:57', '2017-05-21 13:15:57');

-- ----------------------------
-- Table structure for ac_dictionary_item
-- ----------------------------
DROP TABLE IF EXISTS `ac_dictionary_item`;
CREATE TABLE `ac_dictionary_item` (
  `itemid` int(11) NOT NULL AUTO_INCREMENT,
  `dictionaryid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `mark` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `type` int(11) DEFAULT '1',
  `ctype` int(11) NOT NULL DEFAULT '0',
  `calid` int(11) DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`itemid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ac_dictionary_item
-- ----------------------------
INSERT INTO `ac_dictionary_item` VALUES ('1', '1', '摇滚', '摇滚', '1', '1', '0', '0', '2017-05-18 17:48:40', '2017-05-18 17:48:40');
INSERT INTO `ac_dictionary_item` VALUES ('2', '1', '音乐', '音乐', '1', '1', '0', '0', '2017-05-18 17:48:40', '2017-05-18 17:48:40');
INSERT INTO `ac_dictionary_item` VALUES ('3', '1', '亲子', '亲子', '1', '1', '0', '0', '2017-05-18 17:48:40', '2017-05-18 17:48:40');
INSERT INTO `ac_dictionary_item` VALUES ('4', '1', '老年', '老年', '1', '1', '0', '0', '2017-05-18 17:48:40', '2017-05-18 17:48:40');
INSERT INTO `ac_dictionary_item` VALUES ('5', '1', '曲艺', '曲艺', '1', '1', '0', '0', '2017-05-18 17:48:40', '2017-05-18 17:48:40');
INSERT INTO `ac_dictionary_item` VALUES ('6', '1', '戏曲', '戏曲', '1', '1', '0', '0', '2017-05-18 17:48:40', '2017-05-18 17:48:40');
INSERT INTO `ac_dictionary_item` VALUES ('7', '1', '舞蹈', '舞蹈', '1', '1', '0', '0', '2017-05-18 17:48:40', '2017-05-18 17:48:40');
INSERT INTO `ac_dictionary_item` VALUES ('8', '1', '体育', '体育', '1', '1', '0', '0', '2017-05-18 17:48:40', '2017-05-18 17:48:40');
INSERT INTO `ac_dictionary_item` VALUES ('9', '1', '其他', '其他', '1', '1', '0', '0', '2017-05-18 17:48:40', '2017-05-18 17:48:40');
INSERT INTO `ac_dictionary_item` VALUES ('10', '2', '免费', '免费', '1', '1', '0', '0', '2017-05-21 13:03:37', '2017-05-21 13:03:37');
INSERT INTO `ac_dictionary_item` VALUES ('11', '2', '100以内', '100以内', '1', '1', '0', '0', '2017-05-21 13:06:26', '2017-05-21 13:06:26');
INSERT INTO `ac_dictionary_item` VALUES ('12', '2', '100-300', '100-300', '1', '1', '0', '0', '2017-05-21 13:06:42', '2017-05-21 13:06:42');
INSERT INTO `ac_dictionary_item` VALUES ('13', '2', '300-500', '300-500', '1', '1', '0', '0', '2017-05-21 13:09:25', '2017-05-21 13:09:25');
INSERT INTO `ac_dictionary_item` VALUES ('14', '2', '500以上', '500以上', '1', '1', '0', '0', '2017-05-21 13:09:47', '2017-05-21 13:09:47');
INSERT INTO `ac_dictionary_item` VALUES ('20', '3', '黑金', '黑金', '1', '1', '0', '1', '2017-05-22 16:01:42', '2017-05-22 16:01:42');
INSERT INTO `ac_dictionary_item` VALUES ('21', '3', '乡村', '乡村', '1', '1', '0', '1', '2017-05-22 16:01:42', '2017-05-22 16:01:42');
INSERT INTO `ac_dictionary_item` VALUES ('22', '3', '清新', '清新', '1', '1', '0', '1', '2017-05-22 16:01:42', '2017-05-22 16:01:42');
INSERT INTO `ac_dictionary_item` VALUES ('23', '3', '忧郁', '忧郁', '1', '1', '0', '1', '2017-05-22 16:01:42', '2017-05-22 16:01:42');
INSERT INTO `ac_dictionary_item` VALUES ('27', '4', '葛优', '葛优', '1', '1', '0', '1', '2017-05-22 16:10:48', '2017-05-22 16:10:48');
INSERT INTO `ac_dictionary_item` VALUES ('28', '4', '姜文', '姜文', '1', '1', '0', '1', '2017-05-22 16:10:48', '2017-05-22 16:10:48');

-- ----------------------------
-- Table structure for ac_favorite
-- ----------------------------
DROP TABLE IF EXISTS `ac_favorite`;
CREATE TABLE `ac_favorite` (
  `favid` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `idtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 日历 2 演出',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 正常 -1 删除',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`favid`),
  KEY `idtype` (`id`,`idtype`,`openid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=152903 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ac_favorite
-- ----------------------------
INSERT INTO `ac_favorite` VALUES ('152899', '123', '1', '1', '1', '2017-05-22 22:36:46');
INSERT INTO `ac_favorite` VALUES ('152900', '123', '3', '2', '1', '2017-05-22 22:54:32');
INSERT INTO `ac_favorite` VALUES ('152901', '123', '2', '1', '0', '2017-05-24 12:38:47');
INSERT INTO `ac_favorite` VALUES ('152902', '123', '2', '2', '-1', '2017-05-24 12:39:20');

-- ----------------------------
-- Table structure for ac_member
-- ----------------------------
DROP TABLE IF EXISTS `ac_member`;
CREATE TABLE `ac_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(150) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别 0：未知、1：男、2：女',
  `authKey` varchar(50) DEFAULT NULL,
  `accessToken` varchar(50) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ac_member
-- ----------------------------
INSERT INTO `ac_member` VALUES ('1', '123', '哈哈', 'aasdfasdf', '1', null, null, '0', '2017-05-21 21:25:16');
INSERT INTO `ac_member` VALUES ('2', '12333', '乐乐', 'asf', '2', null, null, '0', '2017-05-21 21:25:47');

-- ----------------------------
-- Table structure for ac_remind
-- ----------------------------
DROP TABLE IF EXISTS `ac_remind`;
CREATE TABLE `ac_remind` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artid` int(10) NOT NULL,
  `msg_body` varchar(255) NOT NULL,
  `remind_time` datetime NOT NULL,
  `openid` varchar(255) NOT NULL COMMENT '客户的openids集合',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_push` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 已经提醒 0 未提醒',
  `push_time` datetime DEFAULT NULL,
  `form_id` varchar(255) DEFAULT NULL COMMENT '用户发送模版消息',
  PRIMARY KEY (`id`),
  KEY `artid` (`artid`,`openid`(191))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ac_remind
-- ----------------------------
INSERT INTO `ac_remind` VALUES ('1', '1', '音乐会将于2017-05-22 16:00:00 开始，记得提前观看。', '2017-05-22 15:45:00', '1', '2017-05-22 21:30:35', '0', null, null);

-- ----------------------------
-- Table structure for ac_user
-- ----------------------------
DROP TABLE IF EXISTS `ac_user`;
CREATE TABLE `ac_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ac_user
-- ----------------------------
INSERT INTO `ac_user` VALUES ('1', 'admin', 'MBNJqL0Z1Ykv-VGpEoH4_65y6g8zwNSU', '$2y$13$8DPwPV6aBH3xiyLiRmVVT.ygFoNGVC5IQ55voW7MvpiSpkO765pky', null, 'admin@admin.com', '10', '1494829008', '1494829008');
