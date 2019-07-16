/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 50625
 Source Host           : localhost
 Source Database       : declaranetv2_copy

 Target Server Type    : MySQL
 Target Server Version : 50625
 File Encoding         : utf-8

 Date: 03/06/2017 10:55:21 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `acuerdo_dec_pub`
-- ----------------------------
DROP TABLE IF EXISTS `acuerdo_dec_pub`;
CREATE TABLE `acuerdo_dec_pub` (
  `ID_AcuerdoPub` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` int(11) DEFAULT NULL,
  `Fecha_Doc` date DEFAULT NULL,
  `Motivo` text COLLATE utf8_spanish_ci,
  `Documento` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Estatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_AcuerdoPub`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `agenda`
-- ----------------------------
DROP TABLE IF EXISTS `agenda`;
CREATE TABLE `agenda` (
  `ID_Agenda` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha_Agenda` datetime NOT NULL,
  `INICIAL` int(11) NOT NULL DEFAULT '0',
  `FINAL` int(11) NOT NULL DEFAULT '0',
  `ANUAL` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Agenda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `ciudades`
-- ----------------------------
DROP TABLE IF EXISTS `ciudades`;
CREATE TABLE `ciudades` (
  `ID_Ciudad` int(11) NOT NULL,
  `ID_Estado` int(11) NOT NULL,
  `Ciudad` text NOT NULL,
  PRIMARY KEY (`ID_Ciudad`),
  UNIQUE KEY `Ciudad` (`ID_Ciudad`),
  KEY `Estado` (`ID_Estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `ciudades`
-- ----------------------------
BEGIN;
INSERT INTO `ciudades` VALUES ('1', '1', 'Aguascalientes'), ('2', '1', 'Asientos'), ('3', '1', 'Calvillo'), ('4', '1', 'Cosío'), ('5', '1', 'Jesús María'), ('6', '1', 'Pabellón de Arteaga'), ('7', '1', 'Rincón de Romos'), ('8', '1', 'San José de Gracia'), ('9', '1', 'Tepezalá'), ('10', '1', 'El Llano'), ('11', '1', 'San Francisco de los Romo'), ('12', '2', 'Ensenada'), ('13', '2', 'Mexicali'), ('14', '2', 'Tecate'), ('15', '2', 'Tijuana'), ('16', '2', 'Playas de Rosarito'), ('17', '3', 'Comondú'), ('18', '3', 'Mulegé'), ('19', '3', 'La Paz'), ('20', '3', 'Los Cabos'), ('21', '3', 'Loreto'), ('22', '4', 'Calkiní'), ('23', '4', 'Campeche'), ('24', '4', 'Carmen'), ('25', '4', 'Champotón'), ('26', '4', 'Hecelchakán'), ('27', '4', 'Hopelchén'), ('28', '4', 'Palizada'), ('29', '4', 'Tenabo'), ('30', '4', 'Escárcega'), ('31', '4', 'Calakmul'), ('32', '4', 'Candelaria'), ('33', '5', 'Abasolo'), ('34', '5', 'Acuña'), ('35', '5', 'Allende'), ('36', '5', 'Arteaga'), ('37', '5', 'Candela'), ('38', '5', 'Castaños'), ('39', '5', 'Cuatro Ciénegas'), ('40', '5', 'Escobedo'), ('41', '5', 'Francisco I. Madero'), ('42', '5', 'Frontera'), ('43', '5', 'General Cepeda'), ('44', '5', 'Guerrero'), ('45', '5', 'Hidalgo'), ('46', '5', 'Jiménez'), ('47', '5', 'Juárez'), ('48', '5', 'Lamadrid'), ('49', '5', 'Matamoros'), ('50', '5', 'Monclova'), ('51', '5', 'Morelos'), ('52', '5', 'Múzquiz'), ('53', '5', 'Nadadores'), ('54', '5', 'Nava'), ('55', '5', 'Ocampo'), ('56', '5', 'Parras'), ('57', '5', 'Piedras Negras'), ('58', '5', 'Progreso'), ('59', '5', 'Ramos Arizpe'), ('60', '5', 'Sabinas'), ('61', '5', 'Sacramento'), ('62', '5', 'Saltillo'), ('63', '5', 'San Buenaventura'), ('64', '5', 'San Juan de Sabinas'), ('65', '5', 'San Pedro'), ('66', '5', 'Sierra Mojada'), ('67', '5', 'Torreón'), ('68', '5', 'Viesca'), ('69', '5', 'Villa Unión'), ('70', '5', 'Zaragoza'), ('71', '6', 'Armería'), ('72', '6', 'Colima'), ('73', '6', 'Comala'), ('74', '6', 'Coquimatlán'), ('75', '6', 'Cuauhtémoc'), ('76', '6', 'Ixtlahuacán'), ('77', '6', 'Manzanillo'), ('78', '6', 'Minatitlán'), ('79', '6', 'Tecomán'), ('80', '6', 'Villa de Álvarez'), ('81', '7', 'Acacoyagua'), ('82', '7', 'Acala'), ('83', '7', 'Acapetahua'), ('84', '7', 'Altamirano'), ('85', '7', 'Amatán'), ('86', '7', 'Amatenango de la Frontera'), ('87', '7', 'Amatenango del Valle'), ('88', '7', 'Angel Albino Corzo'), ('89', '7', 'Arriaga'), ('90', '7', 'Bejucal de Ocampo'), ('91', '7', 'Bella Vista'), ('92', '7', 'Berriozábal'), ('93', '7', 'Bochil'), ('94', '7', 'El Bosque'), ('95', '7', 'Cacahoatán'), ('96', '7', 'Catazajá'), ('97', '7', 'Cintalapa'), ('98', '7', 'Coapilla'), ('99', '7', 'Comitán de Domínguez'), ('100', '7', 'La Concordia'), ('101', '7', 'Copainalá'), ('102', '7', 'Chalchihuitán'), ('103', '7', 'Chamula'), ('104', '7', 'Chanal'), ('105', '7', 'Chapultenango'), ('106', '7', 'Chenalhó'), ('107', '7', 'Chiapa de Corzo'), ('108', '7', 'Chiapilla'), ('109', '7', 'Chicoasén'), ('110', '7', 'Chicomuselo'), ('111', '7', 'Chilón'), ('112', '7', 'Escuintla'), ('113', '7', 'Francisco León'), ('114', '7', 'Frontera Comalapa'), ('115', '7', 'Frontera Hidalgo'), ('116', '7', 'La Grandeza'), ('117', '7', 'Huehuetán'), ('118', '7', 'Huixtán'), ('119', '7', 'Huitiupán'), ('120', '7', 'Huixtla'), ('121', '7', 'La Independencia'), ('122', '7', 'Ixhuatán'), ('123', '7', 'Ixtacomitán'), ('124', '7', 'Ixtapa'), ('125', '7', 'Ixtapangajoya'), ('126', '7', 'Jiquipilas'), ('127', '7', 'Jitotol'), ('128', '7', 'Juárez'), ('129', '7', 'Larráinzar'), ('130', '7', 'La Libertad'), ('131', '7', 'Mapastepec'), ('132', '7', 'Las Margaritas'), ('133', '7', 'Mazapa de Madero'), ('134', '7', 'Mazatán'), ('135', '7', 'Metapa'), ('136', '7', 'Mitontic'), ('137', '7', 'Motozintla'), ('138', '7', 'Nicolás Ruíz'), ('139', '7', 'Ocosingo'), ('140', '7', 'Ocotepec'), ('141', '7', 'Ocozocoautla de Espinosa'), ('142', '7', 'Ostuacán'), ('143', '7', 'Osumacinta'), ('144', '7', 'Oxchuc'), ('145', '7', 'Palenque'), ('146', '7', 'Pantelhó'), ('147', '7', 'Pantepec'), ('148', '7', 'Pichucalco'), ('149', '7', 'Pijijiapan'), ('150', '7', 'El Porvenir'), ('151', '7', 'Villa Comaltitlán'), ('152', '7', 'Pueblo Nuevo Solistahuacán'), ('153', '7', 'Rayón'), ('154', '7', 'Reforma'), ('155', '7', 'Las Rosas'), ('156', '7', 'Sabanilla'), ('157', '7', 'Salto de Agua'), ('158', '7', 'San Cristóbal de las Casas'), ('159', '7', 'San Fernando'), ('160', '7', 'Siltepec'), ('161', '7', 'Simojovel'), ('162', '7', 'Sitalá'), ('163', '7', 'Socoltenango'), ('164', '7', 'Solosuchiapa'), ('165', '7', 'Soyaló'), ('166', '7', 'Suchiapa'), ('167', '7', 'Suchiate'), ('168', '7', 'Sunuapa'), ('169', '7', 'Tapachula'), ('170', '7', 'Tapalapa'), ('171', '7', 'Tapilula'), ('172', '7', 'Tecpatán'), ('173', '7', 'Tenejapa'), ('174', '7', 'Teopisca'), ('175', '7', 'Tila'), ('176', '7', 'Tonalá'), ('177', '7', 'Totolapa'), ('178', '7', 'La Trinitaria'), ('179', '7', 'Tumbalá'), ('180', '7', 'Tuxtla Gutiérrez'), ('181', '7', 'Tuxtla Chico'), ('182', '7', 'Tuzantán'), ('183', '7', 'Tzimol'), ('184', '7', 'Unión Juárez'), ('185', '7', 'Venustiano Carranza'), ('186', '7', 'Villa Corzo'), ('187', '7', 'Villaflores'), ('188', '7', 'Yajalón'), ('189', '7', 'San Lucas'), ('190', '7', 'Zinacantán'), ('191', '7', 'San Juan Cancuc'), ('192', '7', 'Aldama'), ('193', '7', 'Benemérito de las Américas'), ('194', '7', 'Maravilla Tenejapa'), ('195', '7', 'Marqués de Comillas'), ('196', '7', 'Montecristo de Guerrero'), ('197', '7', 'San Andrés Duraznal'), ('198', '7', 'Santiago el Pinar'), ('199', '8', 'Ahumada'), ('200', '8', 'Aldama'), ('201', '8', 'Allende'), ('202', '8', 'Aquiles Serdán'), ('203', '8', 'Ascensión'), ('204', '8', 'Bachíniva'), ('205', '8', 'Balleza'), ('206', '8', 'Batopilas'), ('207', '8', 'Bocoyna'), ('208', '8', 'Buenaventura'), ('209', '8', 'Camargo'), ('210', '8', 'Carichí'), ('211', '8', 'Casas Grandes'), ('212', '8', 'Coronado'), ('213', '8', 'Coyame del Sotol'), ('214', '8', 'La Cruz'), ('215', '8', 'Cuauhtémoc'), ('216', '8', 'Cusihuiriachi'), ('217', '8', 'Chihuahua'), ('218', '8', 'Chínipas'), ('219', '8', 'Delicias'), ('220', '8', 'Dr. Belisario Domínguez'), ('221', '8', 'Galeana'), ('222', '8', 'Santa Isabel'), ('223', '8', 'Gómez Farías'), ('224', '8', 'Gran Morelos'), ('225', '8', 'Guachochi'), ('226', '8', 'Guadalupe'), ('227', '8', 'Guadalupe y Calvo'), ('228', '8', 'Guazapares'), ('229', '8', 'Guerrero'), ('230', '8', 'Hidalgo del Parral'), ('231', '8', 'Huejotitán'), ('232', '8', 'Ignacio Zaragoza'), ('233', '8', 'Janos'), ('234', '8', 'Jiménez'), ('235', '8', 'Juárez'), ('236', '8', 'Julimes'), ('237', '8', 'López'), ('238', '8', 'Madera'), ('239', '8', 'Maguarichi'), ('240', '8', 'Manuel Benavides'), ('241', '8', 'Matachí'), ('242', '8', 'Matamoros'), ('243', '8', 'Meoqui'), ('244', '8', 'Morelos'), ('245', '8', 'Moris'), ('246', '8', 'Namiquipa'), ('247', '8', 'Nonoava'), ('248', '8', 'Nuevo Casas Grandes'), ('249', '8', 'Ocampo'), ('250', '8', 'Ojinaga'), ('251', '8', 'Praxedis G. Guerrero'), ('252', '8', 'Riva Palacio'), ('253', '8', 'Rosales'), ('254', '8', 'Rosario'), ('255', '8', 'San Francisco de Borja'), ('256', '8', 'San Francisco de Conchos'), ('257', '8', 'San Francisco del Oro'), ('258', '8', 'Santa Bárbara'), ('259', '8', 'Satevó'), ('260', '8', 'Saucillo'), ('261', '8', 'Temósachic'), ('262', '8', 'El Tule'), ('263', '8', 'Urique'), ('264', '8', 'Uruachi'), ('265', '8', 'Valle de Zaragoza'), ('266', '9', 'Azcapotzalco'), ('267', '9', 'Coyoacán'), ('268', '9', 'Cuajimalpa de Morelos'), ('269', '9', 'Gustavo A. Madero'), ('270', '9', 'Iztacalco'), ('271', '9', 'Iztapalapa'), ('272', '9', 'La Magdalena Contreras'), ('273', '9', 'Milpa Alta'), ('274', '9', 'Álvaro Obregón'), ('275', '9', 'Tláhuac'), ('276', '9', 'Tlalpan'), ('277', '9', 'Xochimilco'), ('278', '9', 'Benito Juárez'), ('279', '9', 'Cuauhtémoc'), ('280', '9', 'Miguel Hidalgo'), ('281', '9', 'Venustiano Carranza'), ('282', '10', 'Canatlán'), ('283', '10', 'Canelas'), ('284', '10', 'Coneto de Comonfort'), ('285', '10', 'Cuencamé'), ('286', '10', 'Durango'), ('287', '10', 'General Simón Bolívar'), ('288', '10', 'Gómez Palacio'), ('289', '10', 'Guadalupe Victoria'), ('290', '10', 'Guanaceví'), ('291', '10', 'Hidalgo'), ('292', '10', 'Indé'), ('293', '10', 'Lerdo'), ('294', '10', 'Mapimí'), ('295', '10', 'Mezquital'), ('296', '10', 'Nazas'), ('297', '10', 'Nombre de Dios'), ('298', '10', 'Ocampo'), ('299', '10', 'El Oro'), ('300', '10', 'Otáez'), ('301', '10', 'Pánuco de Coronado'), ('302', '10', 'Peñón Blanco'), ('303', '10', 'Poanas'), ('304', '10', 'Pueblo Nuevo'), ('305', '10', 'Rodeo'), ('306', '10', 'San Bernardo'), ('307', '10', 'San Dimas'), ('308', '10', 'San Juan de Guadalupe'), ('309', '10', 'San Juan del Río'), ('310', '10', 'San Luis del Cordero'), ('311', '10', 'San Pedro del Gallo'), ('312', '10', 'Santa Clara'), ('313', '10', 'Santiago Papasquiaro'), ('314', '10', 'Súchil'), ('315', '10', 'Tamazula'), ('316', '10', 'Tepehuanes'), ('317', '10', 'Tlahualilo'), ('318', '10', 'Topia'), ('319', '10', 'Vicente Guerrero'), ('320', '10', 'Nuevo Ideal'), ('321', '11', 'Abasolo'), ('322', '11', 'Acámbaro'), ('323', '11', 'San Miguel de Allende'), ('324', '11', 'Apaseo el Alto'), ('325', '11', 'Apaseo el Grande'), ('326', '11', 'Atarjea'), ('327', '11', 'Celaya'), ('328', '11', 'Manuel Doblado'), ('329', '11', 'Comonfort'), ('330', '11', 'Coroneo'), ('331', '11', 'Cortazar'), ('332', '11', 'Cuerámaro'), ('333', '11', 'Doctor Mora'), ('334', '11', 'Dolores Hidalgo Cuna de la Independencia Nacional'), ('335', '11', 'Guanajuato'), ('336', '11', 'Huanímaro'), ('337', '11', 'Irapuato'), ('338', '11', 'Jaral del Progreso'), ('339', '11', 'Jerécuaro'), ('340', '11', 'León'), ('341', '11', 'Moroleón'), ('342', '11', 'Ocampo'), ('343', '11', 'Pénjamo'), ('344', '11', 'Pueblo Nuevo'), ('345', '11', 'Purísima del Rincón'), ('346', '11', 'Romita'), ('347', '11', 'Salamanca'), ('348', '11', 'Salvatierra'), ('349', '11', 'San Diego de la Unión'), ('350', '11', 'San Felipe'), ('351', '11', 'San Francisco del Rincón'), ('352', '11', 'San José Iturbide'), ('353', '11', 'San Luis de la Paz'), ('354', '11', 'Santa Catarina'), ('355', '11', 'Santa Cruz de Juventino Rosas'), ('356', '11', 'Santiago Maravatío'), ('357', '11', 'Silao de la Victoria'), ('358', '11', 'Tarandacuao'), ('359', '11', 'Tarimoro'), ('360', '11', 'Tierra Blanca'), ('361', '11', 'Uriangato'), ('362', '11', 'Valle de Santiago'), ('363', '11', 'Victoria'), ('364', '11', 'Villagrán'), ('365', '11', 'Xichú'), ('366', '11', 'Yuriria'), ('367', '12', 'Acapulco de Juárez'), ('368', '12', 'Ahuacuotzingo'), ('369', '12', 'Ajuchitlán del Progreso'), ('370', '12', 'Alcozauca de Guerrero'), ('371', '12', 'Alpoyeca'), ('372', '12', 'Apaxtla'), ('373', '12', 'Arcelia'), ('374', '12', 'Atenango del Río'), ('375', '12', 'Atlamajalcingo del Monte'), ('376', '12', 'Atlixtac'), ('377', '12', 'Atoyac de Álvarez'), ('378', '12', 'Ayutla de los Libres'), ('379', '12', 'Azoyú'), ('380', '12', 'Benito Juárez'), ('381', '12', 'Buenavista de Cuéllar'), ('382', '12', 'Coahuayutla de José María Izazaga'), ('383', '12', 'Cocula'), ('384', '12', 'Copala'), ('385', '12', 'Copalillo'), ('386', '12', 'Copanatoyac'), ('387', '12', 'Coyuca de Benítez'), ('388', '12', 'Coyuca de Catalán'), ('389', '12', 'Cuajinicuilapa'), ('390', '12', 'Cualác'), ('391', '12', 'Cuautepec'), ('392', '12', 'Cuetzala del Progreso'), ('393', '12', 'Cutzamala de Pinzón'), ('394', '12', 'Chilapa de Álvarez'), ('395', '12', 'Chilpancingo de los Bravo'), ('396', '12', 'Florencio Villarreal'), ('397', '12', 'General Canuto A. Neri'), ('398', '12', 'General Heliodoro Castillo'), ('399', '12', 'Huamuxtitlán'), ('400', '12', 'Huitzuco de los Figueroa'), ('401', '12', 'Iguala de la Independencia'), ('402', '12', 'Igualapa'), ('403', '12', 'Ixcateopan de Cuauhtémoc'), ('404', '12', 'Zihuatanejo de Azueta'), ('405', '12', 'Juan R. Escudero'), ('406', '12', 'Leonardo Bravo'), ('407', '12', 'Malinaltepec'), ('408', '12', 'Mártir de Cuilapan'), ('409', '12', 'Metlatónoc'), ('410', '12', 'Mochitlán'), ('411', '12', 'Olinalá'), ('412', '12', 'Ometepec'), ('413', '12', 'Pedro Ascencio Alquisiras'), ('414', '12', 'Petatlán'), ('415', '12', 'Pilcaya'), ('416', '12', 'Pungarabato'), ('417', '12', 'Quechultenango'), ('418', '12', 'San Luis Acatlán'), ('419', '12', 'San Marcos'), ('420', '12', 'San Miguel Totolapan'), ('421', '12', 'Taxco de Alarcón'), ('422', '12', 'Tecoanapa'), ('423', '12', 'Técpan de Galeana'), ('424', '12', 'Teloloapan'), ('425', '12', 'Tepecoacuilco de Trujano'), ('426', '12', 'Tetipac'), ('427', '12', 'Tixtla de Guerrero'), ('428', '12', 'Tlacoachistlahuaca'), ('429', '12', 'Tlacoapa'), ('430', '12', 'Tlalchapa'), ('431', '12', 'Tlalixtaquilla de Maldonado'), ('432', '12', 'Tlapa de Comonfort'), ('433', '12', 'Tlapehuala'), ('434', '12', 'La Unión de Isidoro Montes de Oca'), ('435', '12', 'Xalpatláhuac'), ('436', '12', 'Xochihuehuetlán'), ('437', '12', 'Xochistlahuaca'), ('438', '12', 'Zapotitlán Tablas'), ('439', '12', 'Zirándaro'), ('440', '12', 'Zitlala'), ('441', '12', 'Eduardo Neri'), ('442', '12', 'Acatepec'), ('443', '12', 'Marquelia'), ('444', '12', 'Cochoapa el Grande'), ('445', '12', 'José Joaquín de Herrera'), ('446', '12', 'Juchitán'), ('447', '12', 'Iliatenco'), ('448', '13', 'Acatlán'), ('449', '13', 'Acaxochitlán'), ('450', '13', 'Actopan'), ('451', '13', 'Agua Blanca de Iturbide'), ('452', '13', 'Ajacuba'), ('453', '13', 'Alfajayucan'), ('454', '13', 'Almoloya'), ('455', '13', 'Apan'), ('456', '13', 'El Arenal'), ('457', '13', 'Atitalaquia'), ('458', '13', 'Atlapexco'), ('459', '13', 'Atotonilco el Grande'), ('460', '13', 'Atotonilco de Tula'), ('461', '13', 'Calnali'), ('462', '13', 'Cardonal'), ('463', '13', 'Cuautepec de Hinojosa'), ('464', '13', 'Chapantongo'), ('465', '13', 'Chapulhuacán'), ('466', '13', 'Chilcuautla'), ('467', '13', 'Eloxochitlán'), ('468', '13', 'Emiliano Zapata'), ('469', '13', 'Epazoyucan'), ('470', '13', 'Francisco I. Madero'), ('471', '13', 'Huasca de Ocampo'), ('472', '13', 'Huautla'), ('473', '13', 'Huazalingo'), ('474', '13', 'Huehuetla'), ('475', '13', 'Huejutla de Reyes'), ('476', '13', 'Huichapan'), ('477', '13', 'Ixmiquilpan'), ('478', '13', 'Jacala de Ledezma'), ('479', '13', 'Jaltocán'), ('480', '13', 'Juárez Hidalgo'), ('481', '13', 'Lolotla'), ('482', '13', 'Metepec'), ('483', '13', 'San Agustín Metzquititlán'), ('484', '13', 'Metztitlán'), ('485', '13', 'Mineral del Chico'), ('486', '13', 'Mineral del Monte'), ('487', '13', 'La Misión'), ('488', '13', 'Mixquiahuala de Juárez'), ('489', '13', 'Molango de Escamilla'), ('490', '13', 'Nicolás Flores'), ('491', '13', 'Nopala de Villagrán'), ('492', '13', 'Omitlán de Juárez'), ('493', '13', 'San Felipe Orizatlán'), ('494', '13', 'Pacula'), ('495', '13', 'Pachuca de Soto'), ('496', '13', 'Pisaflores'), ('497', '13', 'Progreso de Obregón'), ('498', '13', 'Mineral de la Reforma'), ('499', '13', 'San Agustín Tlaxiaca'), ('500', '13', 'San Bartolo Tutotepec'), ('501', '13', 'San Salvador'), ('502', '13', 'Santiago de Anaya'), ('503', '13', 'Santiago Tulantepec de Lugo Guerrero'), ('504', '13', 'Singuilucan'), ('505', '13', 'Tasquillo'), ('506', '13', 'Tecozautla'), ('507', '13', 'Tenango de Doria'), ('508', '13', 'Tepeapulco'), ('509', '13', 'Tepehuacán de Guerrero'), ('510', '13', 'Tepeji del Río de Ocampo'), ('511', '13', 'Tepetitlán'), ('512', '13', 'Tetepango'), ('513', '13', 'Villa de Tezontepec'), ('514', '13', 'Tezontepec de Aldama'), ('515', '13', 'Tianguistengo'), ('516', '13', 'Tizayuca'), ('517', '13', 'Tlahuelilpan'), ('518', '13', 'Tlahuiltepa'), ('519', '13', 'Tlanalapa'), ('520', '13', 'Tlanchinol'), ('521', '13', 'Tlaxcoapan'), ('522', '13', 'Tolcayuca'), ('523', '13', 'Tula de Allende'), ('524', '13', 'Tulancingo de Bravo'), ('525', '13', 'Xochiatipan'), ('526', '13', 'Xochicoatlán'), ('527', '13', 'Yahualica'), ('528', '13', 'Zacualtipán de Ángeles'), ('529', '13', 'Zapotlán de Juárez'), ('530', '13', 'Zempoala'), ('531', '13', 'Zimapán'), ('532', '14', 'Acatic'), ('533', '14', 'Acatlán de Juárez'), ('534', '14', 'Ahualulco de Mercado'), ('535', '14', 'Amacueca'), ('536', '14', 'Amatitán'), ('537', '14', 'Ameca'), ('538', '14', 'San Juanito de Escobedo'), ('539', '14', 'Arandas'), ('540', '14', 'El Arenal'), ('541', '14', 'Atemajac de Brizuela'), ('542', '14', 'Atengo'), ('543', '14', 'Atenguillo'), ('544', '14', 'Atotonilco el Alto'), ('545', '14', 'Atoyac'), ('546', '14', 'Autlán de Navarro'), ('547', '14', 'Ayotlán'), ('548', '14', 'Ayutla'), ('549', '14', 'La Barca'), ('550', '14', 'Bolaños'), ('551', '14', 'Cabo Corrientes'), ('552', '14', 'Casimiro Castillo'), ('553', '14', 'Cihuatlán'), ('554', '14', 'Zapotlán el Grande'), ('555', '14', 'Cocula'), ('556', '14', 'Colotlán'), ('557', '14', 'Concepción de Buenos Aires'), ('558', '14', 'Cuautitlán de García Barragán'), ('559', '14', 'Cuautla'), ('560', '14', 'Cuquío'), ('561', '14', 'Chapala'), ('562', '14', 'Chimaltitán'), ('563', '14', 'Chiquilistlán'), ('564', '14', 'Degollado'), ('565', '14', 'Ejutla'), ('566', '14', 'Encarnación de Díaz'), ('567', '14', 'Etzatlán'), ('568', '14', 'El Grullo'), ('569', '14', 'Guachinango'), ('570', '14', 'Guadalajara'), ('571', '14', 'Hostotipaquillo'), ('572', '14', 'Huejúcar'), ('573', '14', 'Huejuquilla el Alto'), ('574', '14', 'La Huerta'), ('575', '14', 'Ixtlahuacán de los Membrillos'), ('576', '14', 'Ixtlahuacán del Río'), ('577', '14', 'Jalostotitlán'), ('578', '14', 'Jamay'), ('579', '14', 'Jesús María'), ('580', '14', 'Jilotlán de los Dolores'), ('581', '14', 'Jocotepec'), ('582', '14', 'Juanacatlán'), ('583', '14', 'Juchitlán'), ('584', '14', 'Lagos de Moreno'), ('585', '14', 'El Limón'), ('586', '14', 'Magdalena'), ('587', '14', 'Santa María del Oro'), ('588', '14', 'La Manzanilla de la Paz'), ('589', '14', 'Mascota'), ('590', '14', 'Mazamitla'), ('591', '14', 'Mexticacán'), ('592', '14', 'Mezquitic'), ('593', '14', 'Mixtlán'), ('594', '14', 'Ocotlán'), ('595', '14', 'Ojuelos de Jalisco'), ('596', '14', 'Pihuamo'), ('597', '14', 'Poncitlán'), ('598', '14', 'Puerto Vallarta'), ('599', '14', 'Villa Purificación'), ('600', '14', 'Quitupan'), ('601', '14', 'El Salto'), ('602', '14', 'San Cristóbal de la Barranca'), ('603', '14', 'San Diego de Alejandría'), ('604', '14', 'San Juan de los Lagos'), ('605', '14', 'San Julián'), ('606', '14', 'San Marcos'), ('607', '14', 'San Martín de Bolaños'), ('608', '14', 'San Martín Hidalgo'), ('609', '14', 'San Miguel el Alto'), ('610', '14', 'Gómez Farías'), ('611', '14', 'San Sebastián del Oeste'), ('612', '14', 'Santa María de los Ángeles'), ('613', '14', 'Sayula'), ('614', '14', 'Tala'), ('615', '14', 'Talpa de Allende'), ('616', '14', 'Tamazula de Gordiano'), ('617', '14', 'Tapalpa'), ('618', '14', 'Tecalitlán'), ('619', '14', 'Tecolotlán'), ('620', '14', 'Techaluta de Montenegro'), ('621', '14', 'Tenamaxtlán'), ('622', '14', 'Teocaltiche'), ('623', '14', 'Teocuitatlán de Corona'), ('624', '14', 'Tepatitlán de Morelos'), ('625', '14', 'Tequila'), ('626', '14', 'Teuchitlán'), ('627', '14', 'Tizapán el Alto'), ('628', '14', 'Tlajomulco de Zúñiga'), ('629', '14', 'San Pedro Tlaquepaque'), ('630', '14', 'Tolimán'), ('631', '14', 'Tomatlán'), ('632', '14', 'Tonalá'), ('633', '14', 'Tonaya'), ('634', '14', 'Tonila'), ('635', '14', 'Totatiche'), ('636', '14', 'Tototlán'), ('637', '14', 'Tuxcacuesco'), ('638', '14', 'Tuxcueca'), ('639', '14', 'Tuxpan'), ('640', '14', 'Unión de San Antonio'), ('641', '14', 'Unión de Tula'), ('642', '14', 'Valle de Guadalupe'), ('643', '14', 'Valle de Juárez'), ('644', '14', 'San Gabriel'), ('645', '14', 'Villa Corona'), ('646', '14', 'Villa Guerrero'), ('647', '14', 'Villa Hidalgo'), ('648', '14', 'Cañadas de Obregón'), ('649', '14', 'Yahualica de González Gallo'), ('650', '14', 'Zacoalco de Torres'), ('651', '14', 'Zapopan'), ('652', '14', 'Zapotiltic'), ('653', '14', 'Zapotitlán de Vadillo'), ('654', '14', 'Zapotlán del Rey'), ('655', '14', 'Zapotlanejo'), ('656', '14', 'San Ignacio Cerro Gordo'), ('657', '15', 'Acambay de Ruíz Castañeda'), ('658', '15', 'Acolman'), ('659', '15', 'Aculco'), ('660', '15', 'Almoloya de Alquisiras'), ('661', '15', 'Almoloya de Juárez'), ('662', '15', 'Almoloya del Río'), ('663', '15', 'Amanalco'), ('664', '15', 'Amatepec'), ('665', '15', 'Amecameca'), ('666', '15', 'Apaxco'), ('667', '15', 'Atenco'), ('668', '15', 'Atizapán'), ('669', '15', 'Atizapán de Zaragoza'), ('670', '15', 'Atlacomulco'), ('671', '15', 'Atlautla'), ('672', '15', 'Axapusco'), ('673', '15', 'Ayapango'), ('674', '15', 'Calimaya'), ('675', '15', 'Capulhuac'), ('676', '15', 'Coacalco de Berriozábal'), ('677', '15', 'Coatepec Harinas'), ('678', '15', 'Cocotitlán'), ('679', '15', 'Coyotepec'), ('680', '15', 'Cuautitlán'), ('681', '15', 'Chalco'), ('682', '15', 'Chapa de Mota'), ('683', '15', 'Chapultepec'), ('684', '15', 'Chiautla'), ('685', '15', 'Chicoloapan'), ('686', '15', 'Chiconcuac'), ('687', '15', 'Chimalhuacán'), ('688', '15', 'Donato Guerra'), ('689', '15', 'Ecatepec de Morelos'), ('690', '15', 'Ecatzingo'), ('691', '15', 'Huehuetoca'), ('692', '15', 'Hueypoxtla'), ('693', '15', 'Huixquilucan'), ('694', '15', 'Isidro Fabela'), ('695', '15', 'Ixtapaluca'), ('696', '15', 'Ixtapan de la Sal'), ('697', '15', 'Ixtapan del Oro'), ('698', '15', 'Ixtlahuaca'), ('699', '15', 'Xalatlaco'), ('700', '15', 'Jaltenco'), ('701', '15', 'Jilotepec'), ('702', '15', 'Jilotzingo'), ('703', '15', 'Jiquipilco'), ('704', '15', 'Jocotitlán'), ('705', '15', 'Joquicingo'), ('706', '15', 'Juchitepec'), ('707', '15', 'Lerma'), ('708', '15', 'Malinalco'), ('709', '15', 'Melchor Ocampo'), ('710', '15', 'Metepec'), ('711', '15', 'Mexicaltzingo'), ('712', '15', 'Morelos'), ('713', '15', 'Naucalpan de Juárez'), ('714', '15', 'Nezahualcóyotl'), ('715', '15', 'Nextlalpan'), ('716', '15', 'Nicolás Romero'), ('717', '15', 'Nopaltepec'), ('718', '15', 'Ocoyoacac'), ('719', '15', 'Ocuilan'), ('720', '15', 'El Oro'), ('721', '15', 'Otumba'), ('722', '15', 'Otzoloapan'), ('723', '15', 'Otzolotepec'), ('724', '15', 'Ozumba'), ('725', '15', 'Papalotla'), ('726', '15', 'La Paz'), ('727', '15', 'Polotitlán'), ('728', '15', 'Rayón'), ('729', '15', 'San Antonio la Isla'), ('730', '15', 'San Felipe del Progreso'), ('731', '15', 'San Martín de las Pirámides'), ('732', '15', 'San Mateo Atenco'), ('733', '15', 'San Simón de Guerrero'), ('734', '15', 'Santo Tomás'), ('735', '15', 'Soyaniquilpan de Juárez'), ('736', '15', 'Sultepec'), ('737', '15', 'Tecámac'), ('738', '15', 'Tejupilco'), ('739', '15', 'Temamatla'), ('740', '15', 'Temascalapa'), ('741', '15', 'Temascalcingo'), ('742', '15', 'Temascaltepec'), ('743', '15', 'Temoaya'), ('744', '15', 'Tenancingo'), ('745', '15', 'Tenango del Aire'), ('746', '15', 'Tenango del Valle'), ('747', '15', 'Teoloyucan'), ('748', '15', 'Teotihuacán'), ('749', '15', 'Tepetlaoxtoc'), ('750', '15', 'Tepetlixpa'), ('751', '15', 'Tepotzotlán'), ('752', '15', 'Tequixquiac'), ('753', '15', 'Texcaltitlán'), ('754', '15', 'Texcalyacac'), ('755', '15', 'Texcoco'), ('756', '15', 'Tezoyuca'), ('757', '15', 'Tianguistenco'), ('758', '15', 'Timilpan'), ('759', '15', 'Tlalmanalco'), ('760', '15', 'Tlalnepantla de Baz'), ('761', '15', 'Tlatlaya'), ('762', '15', 'Toluca'), ('763', '15', 'Tonatico'), ('764', '15', 'Tultepec'), ('765', '15', 'Tultitlán'), ('766', '15', 'Valle de Bravo'), ('767', '15', 'Villa de Allende'), ('768', '15', 'Villa del Carbón'), ('769', '15', 'Villa Guerrero'), ('770', '15', 'Villa Victoria'), ('771', '15', 'Xonacatlán'), ('772', '15', 'Zacazonapan'), ('773', '15', 'Zacualpan'), ('774', '15', 'Zinacantepec'), ('775', '15', 'Zumpahuacán'), ('776', '15', 'Zumpango'), ('777', '15', 'Cuautitlán Izcalli'), ('778', '15', 'Valle de Chalco Solidaridad'), ('779', '15', 'Luvianos'), ('780', '15', 'San José del Rincón'), ('781', '15', 'Tonanitla'), ('782', '16', 'Acuitzio'), ('783', '16', 'Aguililla'), ('784', '16', 'Álvaro Obregón'), ('785', '16', 'Angamacutiro'), ('786', '16', 'Angangueo'), ('787', '16', 'Apatzingán'), ('788', '16', 'Aporo'), ('789', '16', 'Aquila'), ('790', '16', 'Ario'), ('791', '16', 'Arteaga'), ('792', '16', 'Briseñas'), ('793', '16', 'Buenavista'), ('794', '16', 'Carácuaro'), ('795', '16', 'Coahuayana'), ('796', '16', 'Coalcomán de Vázquez Pallares'), ('797', '16', 'Coeneo'), ('798', '16', 'Contepec'), ('799', '16', 'Copándaro'), ('800', '16', 'Cotija'), ('801', '16', 'Cuitzeo'), ('802', '16', 'Charapan'), ('803', '16', 'Charo'), ('804', '16', 'Chavinda'), ('805', '16', 'Cherán'), ('806', '16', 'Chilchota'), ('807', '16', 'Chinicuila'), ('808', '16', 'Chucándiro'), ('809', '16', 'Churintzio'), ('810', '16', 'Churumuco'), ('811', '16', 'Ecuandureo'), ('812', '16', 'Epitacio Huerta'), ('813', '16', 'Erongarícuaro'), ('814', '16', 'Gabriel Zamora'), ('815', '16', 'Hidalgo'), ('816', '16', 'La Huacana'), ('817', '16', 'Huandacareo'), ('818', '16', 'Huaniqueo'), ('819', '16', 'Huetamo'), ('820', '16', 'Huiramba'), ('821', '16', 'Indaparapeo'), ('822', '16', 'Irimbo'), ('823', '16', 'Ixtlán'), ('824', '16', 'Jacona'), ('825', '16', 'Jiménez'), ('826', '16', 'Jiquilpan'), ('827', '16', 'Juárez'), ('828', '16', 'Jungapeo'), ('829', '16', 'Lagunillas'), ('830', '16', 'Madero'), ('831', '16', 'Maravatío'), ('832', '16', 'Marcos Castellanos'), ('833', '16', 'Lázaro Cárdenas'), ('834', '16', 'Morelia'), ('835', '16', 'Morelos'), ('836', '16', 'Múgica'), ('837', '16', 'Nahuatzen'), ('838', '16', 'Nocupétaro'), ('839', '16', 'Nuevo Parangaricutiro'), ('840', '16', 'Nuevo Urecho'), ('841', '16', 'Numarán'), ('842', '16', 'Ocampo'), ('843', '16', 'Pajacuarán'), ('844', '16', 'Panindícuaro'), ('845', '16', 'Parácuaro'), ('846', '16', 'Paracho'), ('847', '16', 'Pátzcuaro'), ('848', '16', 'Penjamillo'), ('849', '16', 'Peribán'), ('850', '16', 'La Piedad'), ('851', '16', 'Purépero'), ('852', '16', 'Puruándiro'), ('853', '16', 'Queréndaro'), ('854', '16', 'Quiroga'), ('855', '16', 'Cojumatlán de Régules'), ('856', '16', 'Los Reyes'), ('857', '16', 'Sahuayo'), ('858', '16', 'San Lucas'), ('859', '16', 'Santa Ana Maya'), ('860', '16', 'Salvador Escalante'), ('861', '16', 'Senguio'), ('862', '16', 'Susupuato'), ('863', '16', 'Tacámbaro'), ('864', '16', 'Tancítaro'), ('865', '16', 'Tangamandapio'), ('866', '16', 'Tangancícuaro'), ('867', '16', 'Tanhuato'), ('868', '16', 'Taretan'), ('869', '16', 'Tarímbaro'), ('870', '16', 'Tepalcatepec'), ('871', '16', 'Tingambato'), ('872', '16', 'Tingüindín'), ('873', '16', 'Tiquicheo de Nicolás Romero'), ('874', '16', 'Tlalpujahua'), ('875', '16', 'Tlazazalca'), ('876', '16', 'Tocumbo'), ('877', '16', 'Tumbiscatío'), ('878', '16', 'Turicato'), ('879', '16', 'Tuxpan'), ('880', '16', 'Tuzantla'), ('881', '16', 'Tzintzuntzan'), ('882', '16', 'Tzitzio'), ('883', '16', 'Uruapan'), ('884', '16', 'Venustiano Carranza'), ('885', '16', 'Villamar'), ('886', '16', 'Vista Hermosa'), ('887', '16', 'Yurécuaro'), ('888', '16', 'Zacapu'), ('889', '16', 'Zamora'), ('890', '16', 'Zináparo'), ('891', '16', 'Zinapécuaro'), ('892', '16', 'Ziracuaretiro'), ('893', '16', 'Zitácuaro'), ('894', '16', 'José Sixto Verduzco'), ('895', '17', 'Amacuzac'), ('896', '17', 'Atlatlahucan'), ('897', '17', 'Axochiapan'), ('898', '17', 'Ayala'), ('899', '17', 'Coatlán del Río'), ('900', '17', 'Cuautla'), ('901', '17', 'Cuernavaca'), ('902', '17', 'Emiliano Zapata'), ('903', '17', 'Huitzilac'), ('904', '17', 'Jantetelco'), ('905', '17', 'Jiutepec'), ('906', '17', 'Jojutla'), ('907', '17', 'Jonacatepec'), ('908', '17', 'Mazatepec'), ('909', '17', 'Miacatlán'), ('910', '17', 'Ocuituco'), ('911', '17', 'Puente de Ixtla'), ('912', '17', 'Temixco'), ('913', '17', 'Tepalcingo'), ('914', '17', 'Tepoztlán'), ('915', '17', 'Tetecala'), ('916', '17', 'Tetela del Volcán'), ('917', '17', 'Tlalnepantla'), ('918', '17', 'Tlaltizapán de Zapata'), ('919', '17', 'Tlaquiltenango'), ('920', '17', 'Tlayacapan'), ('921', '17', 'Totolapan'), ('922', '17', 'Xochitepec'), ('923', '17', 'Yautepec'), ('924', '17', 'Yecapixtla'), ('925', '17', 'Zacatepec'), ('926', '17', 'Zacualpan'), ('927', '17', 'Temoac'), ('928', '18', 'Acaponeta'), ('929', '18', 'Ahuacatlán'), ('930', '18', 'Amatlán de Cañas'), ('931', '18', 'Compostela'), ('932', '18', 'Huajicori'), ('933', '18', 'Ixtlán del Río'), ('934', '18', 'Jala'), ('935', '18', 'Xalisco'), ('936', '18', 'Del Nayar'), ('937', '18', 'Rosamorada'), ('938', '18', 'Ruíz'), ('939', '18', 'San Blas'), ('940', '18', 'San Pedro Lagunillas'), ('941', '18', 'Santa María del Oro'), ('942', '18', 'Santiago Ixcuintla'), ('943', '18', 'Tecuala'), ('944', '18', 'Tepic'), ('945', '18', 'Tuxpan'), ('946', '18', 'La Yesca'), ('947', '18', 'Bahía de Banderas'), ('948', '19', 'Abasolo'), ('949', '19', 'Agualeguas'), ('950', '19', 'Los Aldamas'), ('951', '19', 'Allende'), ('952', '19', 'Anáhuac'), ('953', '19', 'Apodaca'), ('954', '19', 'Aramberri'), ('955', '19', 'Bustamante'), ('956', '19', 'Cadereyta Jiménez'), ('957', '19', 'El Carmen'), ('958', '19', 'Cerralvo'), ('959', '19', 'Ciénega de Flores'), ('960', '19', 'China'), ('961', '19', 'Doctor Arroyo'), ('962', '19', 'Doctor Coss'), ('963', '19', 'Doctor González'), ('964', '19', 'Galeana'), ('965', '19', 'García'), ('966', '19', 'San Pedro Garza García'), ('967', '19', 'General Bravo'), ('968', '19', 'General Escobedo'), ('969', '19', 'General Terán'), ('970', '19', 'General Treviño'), ('971', '19', 'General Zaragoza'), ('972', '19', 'General Zuazua'), ('973', '19', 'Guadalupe'), ('974', '19', 'Los Herreras'), ('975', '19', 'Higueras'), ('976', '19', 'Hualahuises'), ('977', '19', 'Iturbide'), ('978', '19', 'Juárez'), ('979', '19', 'Lampazos de Naranjo'), ('980', '19', 'Linares'), ('981', '19', 'Marín'), ('982', '19', 'Melchor Ocampo'), ('983', '19', 'Mier y Noriega'), ('984', '19', 'Mina'), ('985', '19', 'Montemorelos'), ('986', '19', 'Monterrey'), ('987', '19', 'Parás'), ('988', '19', 'Pesquería'), ('989', '19', 'Los Ramones'), ('990', '19', 'Rayones'), ('991', '19', 'Sabinas Hidalgo'), ('992', '19', 'Salinas Victoria'), ('993', '19', 'San Nicolás de los Garza'), ('994', '19', 'Hidalgo'), ('995', '19', 'Santa Catarina'), ('996', '19', 'Santiago'), ('997', '19', 'Vallecillo'), ('998', '19', 'Villaldama'), ('999', '20', 'Abejones'), ('1000', '20', 'Acatlán de Pérez Figueroa'), ('1001', '20', 'Asunción Cacalotepec'), ('1002', '20', 'Asunción Cuyotepeji'), ('1003', '20', 'Asunción Ixtaltepec'), ('1004', '20', 'Asunción Nochixtlán'), ('1005', '20', 'Asunción Ocotlán'), ('1006', '20', 'Asunción Tlacolulita'), ('1007', '20', 'Ayotzintepec'), ('1008', '20', 'El Barrio de la Soledad'), ('1009', '20', 'Calihualá'), ('1010', '20', 'Candelaria Loxicha'), ('1011', '20', 'Ciénega de Zimatlán'), ('1012', '20', 'Ciudad Ixtepec'), ('1013', '20', 'Coatecas Altas'), ('1014', '20', 'Coicoyán de las Flores'), ('1015', '20', 'La Compañía'), ('1016', '20', 'Concepción Buenavista'), ('1017', '20', 'Concepción Pápalo'), ('1018', '20', 'Constancia del Rosario'), ('1019', '20', 'Cosolapa'), ('1020', '20', 'Cosoltepec'), ('1021', '20', 'Cuilápam de Guerrero'), ('1022', '20', 'Cuyamecalco Villa de Zaragoza'), ('1023', '20', 'Chahuites'), ('1024', '20', 'Chalcatongo de Hidalgo'), ('1025', '20', 'Chiquihuitlán de Benito Juárez'), ('1026', '20', 'Heroica Ciudad de Ejutla de Crespo'), ('1027', '20', 'Eloxochitlán de Flores Magón'), ('1028', '20', 'El Espinal'), ('1029', '20', 'Tamazulápam del Espíritu Santo'), ('1030', '20', 'Fresnillo de Trujano'), ('1031', '20', 'Guadalupe Etla'), ('1032', '20', 'Guadalupe de Ramírez'), ('1033', '20', 'Guelatao de Juárez'), ('1034', '20', 'Guevea de Humboldt'), ('1035', '20', 'Mesones Hidalgo'), ('1036', '20', 'Villa Hidalgo'), ('1037', '20', 'Heroica Ciudad de Huajuapan de León'), ('1038', '20', 'Huautepec'), ('1039', '20', 'Huautla de Jiménez'), ('1040', '20', 'Ixtlán de Juárez'), ('1041', '20', 'Heroica Ciudad de Juchitán de Zaragoza'), ('1042', '20', 'Loma Bonita'), ('1043', '20', 'Magdalena Apasco'), ('1044', '20', 'Magdalena Jaltepec'), ('1045', '20', 'Santa Magdalena Jicotlán'), ('1046', '20', 'Magdalena Mixtepec'), ('1047', '20', 'Magdalena Ocotlán'), ('1048', '20', 'Magdalena Peñasco'), ('1049', '20', 'Magdalena Teitipac'), ('1050', '20', 'Magdalena Tequisistlán'), ('1051', '20', 'Magdalena Tlacotepec'), ('1052', '20', 'Magdalena Zahuatlán'), ('1053', '20', 'Mariscala de Juárez'), ('1054', '20', 'Mártires de Tacubaya'), ('1055', '20', 'Matías Romero Avendaño'), ('1056', '20', 'Mazatlán Villa de Flores'), ('1057', '20', 'Miahuatlán de Porfirio Díaz'), ('1058', '20', 'Mixistlán de la Reforma'), ('1059', '20', 'Monjas'), ('1060', '20', 'Natividad'), ('1061', '20', 'Nazareno Etla'), ('1062', '20', 'Nejapa de Madero'), ('1063', '20', 'Ixpantepec Nieves'), ('1064', '20', 'Santiago Niltepec'), ('1065', '20', 'Oaxaca de Juárez'), ('1066', '20', 'Ocotlán de Morelos'), ('1067', '20', 'La Pe'), ('1068', '20', 'Pinotepa de Don Luis'), ('1069', '20', 'Pluma Hidalgo'), ('1070', '20', 'San José del Progreso'), ('1071', '20', 'Putla Villa de Guerrero'), ('1072', '20', 'Santa Catarina Quioquitani'), ('1073', '20', 'Reforma de Pineda'), ('1074', '20', 'La Reforma'), ('1075', '20', 'Reyes Etla'), ('1076', '20', 'Rojas de Cuauhtémoc'), ('1077', '20', 'Salina Cruz'), ('1078', '20', 'San Agustín Amatengo'), ('1079', '20', 'San Agustín Atenango'), ('1080', '20', 'San Agustín Chayuco'), ('1081', '20', 'San Agustín de las Juntas'), ('1082', '20', 'San Agustín Etla'), ('1083', '20', 'San Agustín Loxicha'), ('1084', '20', 'San Agustín Tlacotepec'), ('1085', '20', 'San Agustín Yatareni'), ('1086', '20', 'San Andrés Cabecera Nueva'), ('1087', '20', 'San Andrés Dinicuiti'), ('1088', '20', 'San Andrés Huaxpaltepec'), ('1089', '20', 'San Andrés Huayápam'), ('1090', '20', 'San Andrés Ixtlahuaca'), ('1091', '20', 'San Andrés Lagunas'), ('1092', '20', 'San Andrés Nuxiño'), ('1093', '20', 'San Andrés Paxtlán'), ('1094', '20', 'San Andrés Sinaxtla'), ('1095', '20', 'San Andrés Solaga'), ('1096', '20', 'San Andrés Teotilálpam'), ('1097', '20', 'San Andrés Tepetlapa'), ('1098', '20', 'San Andrés Yaá'), ('1099', '20', 'San Andrés Zabache'), ('1100', '20', 'San Andrés Zautla'), ('1101', '20', 'San Antonino Castillo Velasco'), ('1102', '20', 'San Antonino el Alto'), ('1103', '20', 'San Antonino Monte Verde'), ('1104', '20', 'San Antonio Acutla'), ('1105', '20', 'San Antonio de la Cal'), ('1106', '20', 'San Antonio Huitepec'), ('1107', '20', 'San Antonio Nanahuatípam'), ('1108', '20', 'San Antonio Sinicahua'), ('1109', '20', 'San Antonio Tepetlapa'), ('1110', '20', 'San Baltazar Chichicápam'), ('1111', '20', 'San Baltazar Loxicha'), ('1112', '20', 'San Baltazar Yatzachi el Bajo'), ('1113', '20', 'San Bartolo Coyotepec'), ('1114', '20', 'San Bartolomé Ayautla'), ('1115', '20', 'San Bartolomé Loxicha'), ('1116', '20', 'San Bartolomé Quialana'), ('1117', '20', 'San Bartolomé Yucuañe'), ('1118', '20', 'San Bartolomé Zoogocho'), ('1119', '20', 'San Bartolo Soyaltepec'), ('1120', '20', 'San Bartolo Yautepec'), ('1121', '20', 'San Bernardo Mixtepec'), ('1122', '20', 'San Blas Atempa'), ('1123', '20', 'San Carlos Yautepec'), ('1124', '20', 'San Cristóbal Amatlán'), ('1125', '20', 'San Cristóbal Amoltepec'), ('1126', '20', 'San Cristóbal Lachirioag'), ('1127', '20', 'San Cristóbal Suchixtlahuaca'), ('1128', '20', 'San Dionisio del Mar'), ('1129', '20', 'San Dionisio Ocotepec'), ('1130', '20', 'San Dionisio Ocotlán'), ('1131', '20', 'San Esteban Atatlahuca'), ('1132', '20', 'San Felipe Jalapa de Díaz'), ('1133', '20', 'San Felipe Tejalápam'), ('1134', '20', 'San Felipe Usila'), ('1135', '20', 'San Francisco Cahuacuá'), ('1136', '20', 'San Francisco Cajonos'), ('1137', '20', 'San Francisco Chapulapa'), ('1138', '20', 'San Francisco Chindúa'), ('1139', '20', 'San Francisco del Mar'), ('1140', '20', 'San Francisco Huehuetlán'), ('1141', '20', 'San Francisco Ixhuatán'), ('1142', '20', 'San Francisco Jaltepetongo'), ('1143', '20', 'San Francisco Lachigoló'), ('1144', '20', 'San Francisco Logueche'), ('1145', '20', 'San Francisco Nuxaño'), ('1146', '20', 'San Francisco Ozolotepec'), ('1147', '20', 'San Francisco Sola'), ('1148', '20', 'San Francisco Telixtlahuaca'), ('1149', '20', 'San Francisco Teopan'), ('1150', '20', 'San Francisco Tlapancingo'), ('1151', '20', 'San Gabriel Mixtepec'), ('1152', '20', 'San Ildefonso Amatlán'), ('1153', '20', 'San Ildefonso Sola'), ('1154', '20', 'San Ildefonso Villa Alta'), ('1155', '20', 'San Jacinto Amilpas'), ('1156', '20', 'San Jacinto Tlacotepec'), ('1157', '20', 'San Jerónimo Coatlán'), ('1158', '20', 'San Jerónimo Silacayoapilla'), ('1159', '20', 'San Jerónimo Sosola'), ('1160', '20', 'San Jerónimo Taviche'), ('1161', '20', 'San Jerónimo Tecóatl'), ('1162', '20', 'San Jorge Nuchita'), ('1163', '20', 'San José Ayuquila'), ('1164', '20', 'San José Chiltepec'), ('1165', '20', 'San José del Peñasco'), ('1166', '20', 'San José Estancia Grande'), ('1167', '20', 'San José Independencia'), ('1168', '20', 'San José Lachiguiri'), ('1169', '20', 'San José Tenango'), ('1170', '20', 'San Juan Achiutla'), ('1171', '20', 'San Juan Atepec'), ('1172', '20', 'Ánimas Trujano'), ('1173', '20', 'San Juan Bautista Atatlahuca'), ('1174', '20', 'San Juan Bautista Coixtlahuaca'), ('1175', '20', 'San Juan Bautista Cuicatlán'), ('1176', '20', 'San Juan Bautista Guelache'), ('1177', '20', 'San Juan Bautista Jayacatlán'), ('1178', '20', 'San Juan Bautista Lo de Soto'), ('1179', '20', 'San Juan Bautista Suchitepec'), ('1180', '20', 'San Juan Bautista Tlacoatzintepec'), ('1181', '20', 'San Juan Bautista Tlachichilco'), ('1182', '20', 'San Juan Bautista Tuxtepec'), ('1183', '20', 'San Juan Cacahuatepec'), ('1184', '20', 'San Juan Cieneguilla'), ('1185', '20', 'San Juan Coatzóspam'), ('1186', '20', 'San Juan Colorado'), ('1187', '20', 'San Juan Comaltepec'), ('1188', '20', 'San Juan Cotzocón'), ('1189', '20', 'San Juan Chicomezúchil'), ('1190', '20', 'San Juan Chilateca'), ('1191', '20', 'San Juan del Estado'), ('1192', '20', 'San Juan del Río'), ('1193', '20', 'San Juan Diuxi'), ('1194', '20', 'San Juan Evangelista Analco'), ('1195', '20', 'San Juan Guelavía'), ('1196', '20', 'San Juan Guichicovi'), ('1197', '20', 'San Juan Ihualtepec'), ('1198', '20', 'San Juan Juquila Mixes'), ('1199', '20', 'San Juan Juquila Vijanos'), ('1200', '20', 'San Juan Lachao'), ('1201', '20', 'San Juan Lachigalla'), ('1202', '20', 'San Juan Lajarcia'), ('1203', '20', 'San Juan Lalana'), ('1204', '20', 'San Juan de los Cués'), ('1205', '20', 'San Juan Mazatlán'), ('1206', '20', 'San Juan Mixtepec -Dto. 08 -'), ('1207', '20', 'San Juan Mixtepec -Dto. 26 -'), ('1208', '20', 'San Juan Ñumí'), ('1209', '20', 'San Juan Ozolotepec'), ('1210', '20', 'San Juan Petlapa'), ('1211', '20', 'San Juan Quiahije'), ('1212', '20', 'San Juan Quiotepec'), ('1213', '20', 'San Juan Sayultepec'), ('1214', '20', 'San Juan Tabaá'), ('1215', '20', 'San Juan Tamazola'), ('1216', '20', 'San Juan Teita'), ('1217', '20', 'San Juan Teitipac'), ('1218', '20', 'San Juan Tepeuxila'), ('1219', '20', 'San Juan Teposcolula'), ('1220', '20', 'San Juan Yaeé'), ('1221', '20', 'San Juan Yatzona'), ('1222', '20', 'San Juan Yucuita'), ('1223', '20', 'San Lorenzo'), ('1224', '20', 'San Lorenzo Albarradas'), ('1225', '20', 'San Lorenzo Cacaotepec'), ('1226', '20', 'San Lorenzo Cuaunecuiltitla'), ('1227', '20', 'San Lorenzo Texmelúcan'), ('1228', '20', 'San Lorenzo Victoria'), ('1229', '20', 'San Lucas Camotlán'), ('1230', '20', 'San Lucas Ojitlán'), ('1231', '20', 'San Lucas Quiaviní'), ('1232', '20', 'San Lucas Zoquiápam'), ('1233', '20', 'San Luis Amatlán'), ('1234', '20', 'San Marcial Ozolotepec'), ('1235', '20', 'San Marcos Arteaga'), ('1236', '20', 'San Martín de los Cansecos'), ('1237', '20', 'San Martín Huamelúlpam'), ('1238', '20', 'San Martín Itunyoso'), ('1239', '20', 'San Martín Lachilá'), ('1240', '20', 'San Martín Peras'), ('1241', '20', 'San Martín Tilcajete'), ('1242', '20', 'San Martín Toxpalan'), ('1243', '20', 'San Martín Zacatepec'), ('1244', '20', 'San Mateo Cajonos'), ('1245', '20', 'Capulálpam de Méndez'), ('1246', '20', 'San Mateo del Mar'), ('1247', '20', 'San Mateo Yoloxochitlán'), ('1248', '20', 'San Mateo Etlatongo'), ('1249', '20', 'San Mateo Nejápam'), ('1250', '20', 'San Mateo Peñasco'), ('1251', '20', 'San Mateo Piñas'), ('1252', '20', 'San Mateo Río Hondo'), ('1253', '20', 'San Mateo Sindihui'), ('1254', '20', 'San Mateo Tlapiltepec'), ('1255', '20', 'San Melchor Betaza'), ('1256', '20', 'San Miguel Achiutla'), ('1257', '20', 'San Miguel Ahuehuetitlán'), ('1258', '20', 'San Miguel Aloápam'), ('1259', '20', 'San Miguel Amatitlán'), ('1260', '20', 'San Miguel Amatlán'), ('1261', '20', 'San Miguel Coatlán'), ('1262', '20', 'San Miguel Chicahua'), ('1263', '20', 'San Miguel Chimalapa'), ('1264', '20', 'San Miguel del Puerto'), ('1265', '20', 'San Miguel del Río'), ('1266', '20', 'San Miguel Ejutla'), ('1267', '20', 'San Miguel el Grande'), ('1268', '20', 'San Miguel Huautla'), ('1269', '20', 'San Miguel Mixtepec'), ('1270', '20', 'San Miguel Panixtlahuaca'), ('1271', '20', 'San Miguel Peras'), ('1272', '20', 'San Miguel Piedras'), ('1273', '20', 'San Miguel Quetzaltepec'), ('1274', '20', 'San Miguel Santa Flor'), ('1275', '20', 'Villa Sola de Vega'), ('1276', '20', 'San Miguel Soyaltepec'), ('1277', '20', 'San Miguel Suchixtepec'), ('1278', '20', 'Villa Talea de Castro'), ('1279', '20', 'San Miguel Tecomatlán'), ('1280', '20', 'San Miguel Tenango'), ('1281', '20', 'San Miguel Tequixtepec'), ('1282', '20', 'San Miguel Tilquiápam'), ('1283', '20', 'San Miguel Tlacamama'), ('1284', '20', 'San Miguel Tlacotepec'), ('1285', '20', 'San Miguel Tulancingo'), ('1286', '20', 'San Miguel Yotao'), ('1287', '20', 'San Nicolás'), ('1288', '20', 'San Nicolás Hidalgo'), ('1289', '20', 'San Pablo Coatlán'), ('1290', '20', 'San Pablo Cuatro Venados'), ('1291', '20', 'San Pablo Etla'), ('1292', '20', 'San Pablo Huitzo'), ('1293', '20', 'San Pablo Huixtepec'), ('1294', '20', 'San Pablo Macuiltianguis'), ('1295', '20', 'San Pablo Tijaltepec'), ('1296', '20', 'San Pablo Villa de Mitla'), ('1297', '20', 'San Pablo Yaganiza'), ('1298', '20', 'San Pedro Amuzgos'), ('1299', '20', 'San Pedro Apóstol'), ('1300', '20', 'San Pedro Atoyac'), ('1301', '20', 'San Pedro Cajonos'), ('1302', '20', 'San Pedro Coxcaltepec Cántaros'), ('1303', '20', 'San Pedro Comitancillo'), ('1304', '20', 'San Pedro el Alto'), ('1305', '20', 'San Pedro Huamelula'), ('1306', '20', 'San Pedro Huilotepec'), ('1307', '20', 'San Pedro Ixcatlán'), ('1308', '20', 'San Pedro Ixtlahuaca'), ('1309', '20', 'San Pedro Jaltepetongo'), ('1310', '20', 'San Pedro Jicayán'), ('1311', '20', 'San Pedro Jocotipac'), ('1312', '20', 'San Pedro Juchatengo'), ('1313', '20', 'San Pedro Mártir'), ('1314', '20', 'San Pedro Mártir Quiechapa'), ('1315', '20', 'San Pedro Mártir Yucuxaco'), ('1316', '20', 'San Pedro Mixtepec -Dto. 22 -'), ('1317', '20', 'San Pedro Mixtepec -Dto. 26 -'), ('1318', '20', 'San Pedro Molinos'), ('1319', '20', 'San Pedro Nopala'), ('1320', '20', 'San Pedro Ocopetatillo'), ('1321', '20', 'San Pedro Ocotepec'), ('1322', '20', 'San Pedro Pochutla'), ('1323', '20', 'San Pedro Quiatoni'), ('1324', '20', 'San Pedro Sochiápam'), ('1325', '20', 'San Pedro Tapanatepec'), ('1326', '20', 'San Pedro Taviche'), ('1327', '20', 'San Pedro Teozacoalco'), ('1328', '20', 'San Pedro Teutila'), ('1329', '20', 'San Pedro Tidaá'), ('1330', '20', 'San Pedro Topiltepec'), ('1331', '20', 'San Pedro Totolápam'), ('1332', '20', 'Villa de Tututepec de Melchor Ocampo'), ('1333', '20', 'San Pedro Yaneri'), ('1334', '20', 'San Pedro Yólox'), ('1335', '20', 'San Pedro y San Pablo Ayutla'), ('1336', '20', 'Villa de Etla'), ('1337', '20', 'San Pedro y San Pablo Teposcolula'), ('1338', '20', 'San Pedro y San Pablo Tequixtepec'), ('1339', '20', 'San Pedro Yucunama'), ('1340', '20', 'San Raymundo Jalpan'), ('1341', '20', 'San Sebastián Abasolo'), ('1342', '20', 'San Sebastián Coatlán'), ('1343', '20', 'San Sebastián Ixcapa'), ('1344', '20', 'San Sebastián Nicananduta'), ('1345', '20', 'San Sebastián Río Hondo'), ('1346', '20', 'San Sebastián Tecomaxtlahuaca'), ('1347', '20', 'San Sebastián Teitipac'), ('1348', '20', 'San Sebastián Tutla'), ('1349', '20', 'San Simón Almolongas'), ('1350', '20', 'San Simón Zahuatlán'), ('1351', '20', 'Santa Ana'), ('1352', '20', 'Santa Ana Ateixtlahuaca'), ('1353', '20', 'Santa Ana Cuauhtémoc'), ('1354', '20', 'Santa Ana del Valle'), ('1355', '20', 'Santa Ana Tavela'), ('1356', '20', 'Santa Ana Tlapacoyan'), ('1357', '20', 'Santa Ana Yareni'), ('1358', '20', 'Santa Ana Zegache'), ('1359', '20', 'Santa Catalina Quierí'), ('1360', '20', 'Santa Catarina Cuixtla'), ('1361', '20', 'Santa Catarina Ixtepeji'), ('1362', '20', 'Santa Catarina Juquila'), ('1363', '20', 'Santa Catarina Lachatao'), ('1364', '20', 'Santa Catarina Loxicha'), ('1365', '20', 'Santa Catarina Mechoacán'), ('1366', '20', 'Santa Catarina Minas'), ('1367', '20', 'Santa Catarina Quiané'), ('1368', '20', 'Santa Catarina Tayata'), ('1369', '20', 'Santa Catarina Ticuá'), ('1370', '20', 'Santa Catarina Yosonotú'), ('1371', '20', 'Santa Catarina Zapoquila'), ('1372', '20', 'Santa Cruz Acatepec'), ('1373', '20', 'Santa Cruz Amilpas'), ('1374', '20', 'Santa Cruz de Bravo'), ('1375', '20', 'Santa Cruz Itundujia'), ('1376', '20', 'Santa Cruz Mixtepec'), ('1377', '20', 'Santa Cruz Nundaco'), ('1378', '20', 'Santa Cruz Papalutla'), ('1379', '20', 'Santa Cruz Tacache de Mina'), ('1380', '20', 'Santa Cruz Tacahua'), ('1381', '20', 'Santa Cruz Tayata'), ('1382', '20', 'Santa Cruz Xitla'), ('1383', '20', 'Santa Cruz Xoxocotlán'), ('1384', '20', 'Santa Cruz Zenzontepec'), ('1385', '20', 'Santa Gertrudis'), ('1386', '20', 'Santa Inés del Monte'), ('1387', '20', 'Santa Inés Yatzeche'), ('1388', '20', 'Santa Lucía del Camino'), ('1389', '20', 'Santa Lucía Miahuatlán'), ('1390', '20', 'Santa Lucía Monteverde'), ('1391', '20', 'Santa Lucía Ocotlán'), ('1392', '20', 'Santa María Alotepec'), ('1393', '20', 'Santa María Apazco'), ('1394', '20', 'Santa María la Asunción'), ('1395', '20', 'Heroica Ciudad de Tlaxiaco'), ('1396', '20', 'Ayoquezco de Aldama'), ('1397', '20', 'Santa María Atzompa'), ('1398', '20', 'Santa María Camotlán'), ('1399', '20', 'Santa María Colotepec'), ('1400', '20', 'Santa María Cortijo'), ('1401', '20', 'Santa María Coyotepec'), ('1402', '20', 'Santa María Chachoápam'), ('1403', '20', 'Villa de Chilapa de Díaz'), ('1404', '20', 'Santa María Chilchotla'), ('1405', '20', 'Santa María Chimalapa'), ('1406', '20', 'Santa María del Rosario'), ('1407', '20', 'Santa María del Tule'), ('1408', '20', 'Santa María Ecatepec'), ('1409', '20', 'Santa María Guelacé'), ('1410', '20', 'Santa María Guienagati'), ('1411', '20', 'Santa María Huatulco'), ('1412', '20', 'Santa María Huazolotitlán'), ('1413', '20', 'Santa María Ipalapa'), ('1414', '20', 'Santa María Ixcatlán'), ('1415', '20', 'Santa María Jacatepec'), ('1416', '20', 'Santa María Jalapa del Marqués'), ('1417', '20', 'Santa María Jaltianguis'), ('1418', '20', 'Santa María Lachixío'), ('1419', '20', 'Santa María Mixtequilla'), ('1420', '20', 'Santa María Nativitas'), ('1421', '20', 'Santa María Nduayaco'), ('1422', '20', 'Santa María Ozolotepec'), ('1423', '20', 'Santa María Pápalo'), ('1424', '20', 'Santa María Peñoles'), ('1425', '20', 'Santa María Petapa'), ('1426', '20', 'Santa María Quiegolani'), ('1427', '20', 'Santa María Sola'), ('1428', '20', 'Santa María Tataltepec'), ('1429', '20', 'Santa María Tecomavaca'), ('1430', '20', 'Santa María Temaxcalapa'), ('1431', '20', 'Santa María Temaxcaltepec'), ('1432', '20', 'Santa María Teopoxco'), ('1433', '20', 'Santa María Tepantlali'), ('1434', '20', 'Santa María Texcatitlán'), ('1435', '20', 'Santa María Tlahuitoltepec'), ('1436', '20', 'Santa María Tlalixtac'), ('1437', '20', 'Santa María Tonameca'), ('1438', '20', 'Santa María Totolapilla'), ('1439', '20', 'Santa María Xadani'), ('1440', '20', 'Santa María Yalina'), ('1441', '20', 'Santa María Yavesía'), ('1442', '20', 'Santa María Yolotepec'), ('1443', '20', 'Santa María Yosoyúa'), ('1444', '20', 'Santa María Yucuhiti'), ('1445', '20', 'Santa María Zacatepec'), ('1446', '20', 'Santa María Zaniza'), ('1447', '20', 'Santa María Zoquitlán'), ('1448', '20', 'Santiago Amoltepec'), ('1449', '20', 'Santiago Apoala'), ('1450', '20', 'Santiago Apóstol'), ('1451', '20', 'Santiago Astata'), ('1452', '20', 'Santiago Atitlán'), ('1453', '20', 'Santiago Ayuquililla'), ('1454', '20', 'Santiago Cacaloxtepec'), ('1455', '20', 'Santiago Camotlán'), ('1456', '20', 'Santiago Comaltepec'), ('1457', '20', 'Santiago Chazumba'), ('1458', '20', 'Santiago Choápam'), ('1459', '20', 'Santiago del Río'), ('1460', '20', 'Santiago Huajolotitlán'), ('1461', '20', 'Santiago Huauclilla'), ('1462', '20', 'Santiago Ihuitlán Plumas'), ('1463', '20', 'Santiago Ixcuintepec'), ('1464', '20', 'Santiago Ixtayutla'), ('1465', '20', 'Santiago Jamiltepec'), ('1466', '20', 'Santiago Jocotepec'), ('1467', '20', 'Santiago Juxtlahuaca'), ('1468', '20', 'Santiago Lachiguiri'), ('1469', '20', 'Santiago Lalopa'), ('1470', '20', 'Santiago Laollaga'), ('1471', '20', 'Santiago Laxopa'), ('1472', '20', 'Santiago Llano Grande'), ('1473', '20', 'Santiago Matatlán'), ('1474', '20', 'Santiago Miltepec'), ('1475', '20', 'Santiago Minas'), ('1476', '20', 'Santiago Nacaltepec'), ('1477', '20', 'Santiago Nejapilla'), ('1478', '20', 'Santiago Nundiche'), ('1479', '20', 'Santiago Nuyoó'), ('1480', '20', 'Santiago Pinotepa Nacional'), ('1481', '20', 'Santiago Suchilquitongo'), ('1482', '20', 'Santiago Tamazola'), ('1483', '20', 'Santiago Tapextla'), ('1484', '20', 'Villa Tejúpam de la Unión'), ('1485', '20', 'Santiago Tenango'), ('1486', '20', 'Santiago Tepetlapa'), ('1487', '20', 'Santiago Tetepec'), ('1488', '20', 'Santiago Texcalcingo'), ('1489', '20', 'Santiago Textitlán'), ('1490', '20', 'Santiago Tilantongo'), ('1491', '20', 'Santiago Tillo'), ('1492', '20', 'Santiago Tlazoyaltepec'), ('1493', '20', 'Santiago Xanica'), ('1494', '20', 'Santiago Xiacuí'), ('1495', '20', 'Santiago Yaitepec'), ('1496', '20', 'Santiago Yaveo'), ('1497', '20', 'Santiago Yolomécatl'), ('1498', '20', 'Santiago Yosondúa'), ('1499', '20', 'Santiago Yucuyachi'), ('1500', '20', 'Santiago Zacatepec'), ('1501', '20', 'Santiago Zoochila'), ('1502', '20', 'Nuevo Zoquiápam'), ('1503', '20', 'Santo Domingo Ingenio'), ('1504', '20', 'Santo Domingo Albarradas'), ('1505', '20', 'Santo Domingo Armenta'), ('1506', '20', 'Santo Domingo Chihuitán'), ('1507', '20', 'Santo Domingo de Morelos'), ('1508', '20', 'Santo Domingo Ixcatlán'), ('1509', '20', 'Santo Domingo Nuxaá'), ('1510', '20', 'Santo Domingo Ozolotepec'), ('1511', '20', 'Santo Domingo Petapa'), ('1512', '20', 'Santo Domingo Roayaga'), ('1513', '20', 'Santo Domingo Tehuantepec'), ('1514', '20', 'Santo Domingo Teojomulco'), ('1515', '20', 'Santo Domingo Tepuxtepec'), ('1516', '20', 'Santo Domingo Tlatayápam'), ('1517', '20', 'Santo Domingo Tomaltepec'), ('1518', '20', 'Santo Domingo Tonalá'), ('1519', '20', 'Santo Domingo Tonaltepec'), ('1520', '20', 'Santo Domingo Xagacía'), ('1521', '20', 'Santo Domingo Yanhuitlán'), ('1522', '20', 'Santo Domingo Yodohino'), ('1523', '20', 'Santo Domingo Zanatepec'), ('1524', '20', 'Santos Reyes Nopala'), ('1525', '20', 'Santos Reyes Pápalo'), ('1526', '20', 'Santos Reyes Tepejillo'), ('1527', '20', 'Santos Reyes Yucuná'), ('1528', '20', 'Santo Tomás Jalieza'), ('1529', '20', 'Santo Tomás Mazaltepec'), ('1530', '20', 'Santo Tomás Ocotepec'), ('1531', '20', 'Santo Tomás Tamazulapan'), ('1532', '20', 'San Vicente Coatlán'), ('1533', '20', 'San Vicente Lachixío'), ('1534', '20', 'San Vicente Nuñú'), ('1535', '20', 'Silacayoápam'), ('1536', '20', 'Sitio de Xitlapehua'), ('1537', '20', 'Soledad Etla'), ('1538', '20', 'Villa de Tamazulápam del Progreso'), ('1539', '20', 'Tanetze de Zaragoza'), ('1540', '20', 'Taniche'), ('1541', '20', 'Tataltepec de Valdés'), ('1542', '20', 'Teococuilco de Marcos Pérez'), ('1543', '20', 'Teotitlán de Flores Magón'), ('1544', '20', 'Teotitlán del Valle'), ('1545', '20', 'Teotongo'), ('1546', '20', 'Tepelmeme Villa de Morelos'), ('1547', '20', 'Heroica Villa Tezoatlán de Segura y Luna, Cuna de la Independencia de Oaxaca'), ('1548', '20', 'San Jerónimo Tlacochahuaya'), ('1549', '20', 'Tlacolula de Matamoros'), ('1550', '20', 'Tlacotepec Plumas'), ('1551', '20', 'Tlalixtac de Cabrera'), ('1552', '20', 'Totontepec Villa de Morelos'), ('1553', '20', 'Trinidad Zaachila'), ('1554', '20', 'La Trinidad Vista Hermosa'), ('1555', '20', 'Unión Hidalgo'), ('1556', '20', 'Valerio Trujano'), ('1557', '20', 'San Juan Bautista Valle Nacional'), ('1558', '20', 'Villa Díaz Ordaz'), ('1559', '20', 'Yaxe'), ('1560', '20', 'Magdalena Yodocono de Porfirio Díaz'), ('1561', '20', 'Yogana'), ('1562', '20', 'Yutanduchi de Guerrero'), ('1563', '20', 'Villa de Zaachila'), ('1564', '20', 'San Mateo Yucutindoo'), ('1565', '20', 'Zapotitlán Lagunas'), ('1566', '20', 'Zapotitlán Palmas'), ('1567', '20', 'Santa Inés de Zaragoza'), ('1568', '20', 'Zimatlán de Álvarez'), ('1569', '21', 'Acajete'), ('1570', '21', 'Acateno'), ('1571', '21', 'Acatlán'), ('1572', '21', 'Acatzingo'), ('1573', '21', 'Acteopan'), ('1574', '21', 'Ahuacatlán'), ('1575', '21', 'Ahuatlán'), ('1576', '21', 'Ahuazotepec'), ('1577', '21', 'Ahuehuetitla'), ('1578', '21', 'Ajalpan'), ('1579', '21', 'Albino Zertuche'), ('1580', '21', 'Aljojuca'), ('1581', '21', 'Altepexi'), ('1582', '21', 'Amixtlán'), ('1583', '21', 'Amozoc'), ('1584', '21', 'Aquixtla'), ('1585', '21', 'Atempan'), ('1586', '21', 'Atexcal'), ('1587', '21', 'Atlixco'), ('1588', '21', 'Atoyatempan'), ('1589', '21', 'Atzala'), ('1590', '21', 'Atzitzihuacán'), ('1591', '21', 'Atzitzintla'), ('1592', '21', 'Axutla'), ('1593', '21', 'Ayotoxco de Guerrero'), ('1594', '21', 'Calpan'), ('1595', '21', 'Caltepec'), ('1596', '21', 'Camocuautla'), ('1597', '21', 'Caxhuacan'), ('1598', '21', 'Coatepec'), ('1599', '21', 'Coatzingo'), ('1600', '21', 'Cohetzala'), ('1601', '21', 'Cohuecan'), ('1602', '21', 'Coronango'), ('1603', '21', 'Coxcatlán'), ('1604', '21', 'Coyomeapan'), ('1605', '21', 'Coyotepec'), ('1606', '21', 'Cuapiaxtla de Madero'), ('1607', '21', 'Cuautempan'), ('1608', '21', 'Cuautinchán'), ('1609', '21', 'Cuautlancingo'), ('1610', '21', 'Cuayuca de Andrade'), ('1611', '21', 'Cuetzalan del Progreso'), ('1612', '21', 'Cuyoaco'), ('1613', '21', 'Chalchicomula de Sesma'), ('1614', '21', 'Chapulco'), ('1615', '21', 'Chiautla'), ('1616', '21', 'Chiautzingo'), ('1617', '21', 'Chiconcuautla'), ('1618', '21', 'Chichiquila'), ('1619', '21', 'Chietla'), ('1620', '21', 'Chigmecatitlán'), ('1621', '21', 'Chignahuapan'), ('1622', '21', 'Chignautla'), ('1623', '21', 'Chila'), ('1624', '21', 'Chila de la Sal'), ('1625', '21', 'Honey'), ('1626', '21', 'Chilchotla'), ('1627', '21', 'Chinantla'), ('1628', '21', 'Domingo Arenas'), ('1629', '21', 'Eloxochitlán'), ('1630', '21', 'Epatlán'), ('1631', '21', 'Esperanza'), ('1632', '21', 'Francisco Z. Mena'), ('1633', '21', 'General Felipe Ángeles'), ('1634', '21', 'Guadalupe'), ('1635', '21', 'Guadalupe Victoria'), ('1636', '21', 'Hermenegildo Galeana'), ('1637', '21', 'Huaquechula'), ('1638', '21', 'Huatlatlauca'), ('1639', '21', 'Huauchinango'), ('1640', '21', 'Huehuetla'), ('1641', '21', 'Huehuetlán el Chico'), ('1642', '21', 'Huejotzingo'), ('1643', '21', 'Hueyapan'), ('1644', '21', 'Hueytamalco'), ('1645', '21', 'Hueytlalpan'), ('1646', '21', 'Huitzilan de Serdán'), ('1647', '21', 'Huitziltepec'), ('1648', '21', 'Atlequizayan'), ('1649', '21', 'Ixcamilpa de Guerrero'), ('1650', '21', 'Ixcaquixtla'), ('1651', '21', 'Ixtacamaxtitlán'), ('1652', '21', 'Ixtepec'), ('1653', '21', 'Izúcar de Matamoros'), ('1654', '21', 'Jalpan'), ('1655', '21', 'Jolalpan'), ('1656', '21', 'Jonotla'), ('1657', '21', 'Jopala'), ('1658', '21', 'Juan C. Bonilla'), ('1659', '21', 'Juan Galindo'), ('1660', '21', 'Juan N. Méndez'), ('1661', '21', 'Lafragua'), ('1662', '21', 'Libres'), ('1663', '21', 'La Magdalena Tlatlauquitepec'), ('1664', '21', 'Mazapiltepec de Juárez'), ('1665', '21', 'Mixtla'), ('1666', '21', 'Molcaxac'), ('1667', '21', 'Cañada Morelos'), ('1668', '21', 'Naupan'), ('1669', '21', 'Nauzontla'), ('1670', '21', 'Nealtican'), ('1671', '21', 'Nicolás Bravo'), ('1672', '21', 'Nopalucan'), ('1673', '21', 'Ocotepec'), ('1674', '21', 'Ocoyucan'), ('1675', '21', 'Olintla'), ('1676', '21', 'Oriental'), ('1677', '21', 'Pahuatlán'), ('1678', '21', 'Palmar de Bravo'), ('1679', '21', 'Pantepec'), ('1680', '21', 'Petlalcingo'), ('1681', '21', 'Piaxtla'), ('1682', '21', 'Puebla'), ('1683', '21', 'Quecholac'), ('1684', '21', 'Quimixtlán'), ('1685', '21', 'Rafael Lara Grajales'), ('1686', '21', 'Los Reyes de Juárez'), ('1687', '21', 'San Andrés Cholula'), ('1688', '21', 'San Antonio Cañada'), ('1689', '21', 'San Diego la Mesa Tochimiltzingo'), ('1690', '21', 'San Felipe Teotlalcingo'), ('1691', '21', 'San Felipe Tepatlán'), ('1692', '21', 'San Gabriel Chilac'), ('1693', '21', 'San Gregorio Atzompa'), ('1694', '21', 'San Jerónimo Tecuanipan'), ('1695', '21', 'San Jerónimo Xayacatlán'), ('1696', '21', 'San José Chiapa'), ('1697', '21', 'San José Miahuatlán'), ('1698', '21', 'San Juan Atenco'), ('1699', '21', 'San Juan Atzompa'), ('1700', '21', 'San Martín Texmelucan'), ('1701', '21', 'San Martín Totoltepec'), ('1702', '21', 'San Matías Tlalancaleca'), ('1703', '21', 'San Miguel Ixitlán'), ('1704', '21', 'San Miguel Xoxtla'), ('1705', '21', 'San Nicolás Buenos Aires'), ('1706', '21', 'San Nicolás de los Ranchos'), ('1707', '21', 'San Pablo Anicano'), ('1708', '21', 'San Pedro Cholula'), ('1709', '21', 'San Pedro Yeloixtlahuaca'), ('1710', '21', 'San Salvador el Seco'), ('1711', '21', 'San Salvador el Verde'), ('1712', '21', 'San Salvador Huixcolotla'), ('1713', '21', 'San Sebastián Tlacotepec'), ('1714', '21', 'Santa Catarina Tlaltempan'), ('1715', '21', 'Santa Inés Ahuatempan'), ('1716', '21', 'Santa Isabel Cholula'), ('1717', '21', 'Santiago Miahuatlán'), ('1718', '21', 'Huehuetlán el Grande'), ('1719', '21', 'Santo Tomás Hueyotlipan'), ('1720', '21', 'Soltepec'), ('1721', '21', 'Tecali de Herrera'), ('1722', '21', 'Tecamachalco'), ('1723', '21', 'Tecomatlán'), ('1724', '21', 'Tehuacán'), ('1725', '21', 'Tehuitzingo'), ('1726', '21', 'Tenampulco'), ('1727', '21', 'Teopantlán'), ('1728', '21', 'Teotlalco'), ('1729', '21', 'Tepanco de López'), ('1730', '21', 'Tepango de Rodríguez'), ('1731', '21', 'Tepatlaxco de Hidalgo'), ('1732', '21', 'Tepeaca'), ('1733', '21', 'Tepemaxalco'), ('1734', '21', 'Tepeojuma'), ('1735', '21', 'Tepetzintla'), ('1736', '21', 'Tepexco'), ('1737', '21', 'Tepexi de Rodríguez'), ('1738', '21', 'Tepeyahualco'), ('1739', '21', 'Tepeyahualco de Cuauhtémoc'), ('1740', '21', 'Tetela de Ocampo'), ('1741', '21', 'Teteles de Avila Castillo'), ('1742', '21', 'Teziutlán'), ('1743', '21', 'Tianguismanalco'), ('1744', '21', 'Tilapa'), ('1745', '21', 'Tlacotepec de Benito Juárez'), ('1746', '21', 'Tlacuilotepec'), ('1747', '21', 'Tlachichuca'), ('1748', '21', 'Tlahuapan'), ('1749', '21', 'Tlaltenango'), ('1750', '21', 'Tlanepantla'), ('1751', '21', 'Tlaola'), ('1752', '21', 'Tlapacoya'), ('1753', '21', 'Tlapanalá'), ('1754', '21', 'Tlatlauquitepec'), ('1755', '21', 'Tlaxco'), ('1756', '21', 'Tochimilco'), ('1757', '21', 'Tochtepec'), ('1758', '21', 'Totoltepec de Guerrero'), ('1759', '21', 'Tulcingo'), ('1760', '21', 'Tuzamapan de Galeana'), ('1761', '21', 'Tzicatlacoyan'), ('1762', '21', 'Venustiano Carranza'), ('1763', '21', 'Vicente Guerrero'), ('1764', '21', 'Xayacatlán de Bravo'), ('1765', '21', 'Xicotepec'), ('1766', '21', 'Xicotlán'), ('1767', '21', 'Xiutetelco'), ('1768', '21', 'Xochiapulco'), ('1769', '21', 'Xochiltepec'), ('1770', '21', 'Xochitlán de Vicente Suárez'), ('1771', '21', 'Xochitlán Todos Santos'), ('1772', '21', 'Yaonáhuac'), ('1773', '21', 'Yehualtepec'), ('1774', '21', 'Zacapala'), ('1775', '21', 'Zacapoaxtla'), ('1776', '21', 'Zacatlán'), ('1777', '21', 'Zapotitlán'), ('1778', '21', 'Zapotitlán de Méndez'), ('1779', '21', 'Zaragoza'), ('1780', '21', 'Zautla'), ('1781', '21', 'Zihuateutla'), ('1782', '21', 'Zinacatepec'), ('1783', '21', 'Zongozotla'), ('1784', '21', 'Zoquiapan'), ('1785', '21', 'Zoquitlán'), ('1786', '22', 'Amealco de Bonfil'), ('1787', '22', 'Pinal de Amoles'), ('1788', '22', 'Arroyo Seco'), ('1789', '22', 'Cadereyta de Montes'), ('1790', '22', 'Colón'), ('1791', '22', 'Corregidora'), ('1792', '22', 'Ezequiel Montes'), ('1793', '22', 'Huimilpan'), ('1794', '22', 'Jalpan de Serra'), ('1795', '22', 'Landa de Matamoros'), ('1796', '22', 'El Marqués'), ('1797', '22', 'Pedro Escobedo'), ('1798', '22', 'Peñamiller'), ('1799', '22', 'Querétaro'), ('1800', '22', 'San Joaquín'), ('1801', '22', 'San Juan del Río'), ('1802', '22', 'Tequisquiapan'), ('1803', '22', 'Tolimán'), ('1804', '23', 'Cozumel'), ('1805', '23', 'Felipe Carrillo Puerto'), ('1806', '23', 'Isla Mujeres'), ('1807', '23', 'Othón P. Blanco'), ('1808', '23', 'Benito Juárez'), ('1809', '23', 'José María Morelos'), ('1810', '23', 'Lázaro Cárdenas'), ('1811', '23', 'Solidaridad'), ('1812', '23', 'Tulum'), ('1813', '23', 'Bacalar'), ('1814', '24', 'Ahualulco'), ('1815', '24', 'Alaquines'), ('1816', '24', 'Aquismón'), ('1817', '24', 'Armadillo de los Infante'), ('1818', '24', 'Cárdenas'), ('1819', '24', 'Catorce'), ('1820', '24', 'Cedral'), ('1821', '24', 'Cerritos'), ('1822', '24', 'Cerro de San Pedro'), ('1823', '24', 'Ciudad del Maíz'), ('1824', '24', 'Ciudad Fernández'), ('1825', '24', 'Tancanhuitz'), ('1826', '24', 'Ciudad Valles'), ('1827', '24', 'Coxcatlán'), ('1828', '24', 'Charcas'), ('1829', '24', 'Ebano'), ('1830', '24', 'Guadalcázar'), ('1831', '24', 'Huehuetlán'), ('1832', '24', 'Lagunillas'), ('1833', '24', 'Matehuala'), ('1834', '24', 'Mexquitic de Carmona'), ('1835', '24', 'Moctezuma'), ('1836', '24', 'Rayón'), ('1837', '24', 'Rioverde'), ('1838', '24', 'Salinas'), ('1839', '24', 'San Antonio'), ('1840', '24', 'San Ciro de Acosta'), ('1841', '24', 'San Luis Potosí'), ('1842', '24', 'San Martín Chalchicuautla'), ('1843', '24', 'San Nicolás Tolentino'), ('1844', '24', 'Santa Catarina'), ('1845', '24', 'Santa María del Río'), ('1846', '24', 'Santo Domingo'), ('1847', '24', 'San Vicente Tancuayalab'), ('1848', '24', 'Soledad de Graciano Sánchez'), ('1849', '24', 'Tamasopo'), ('1850', '24', 'Tamazunchale'), ('1851', '24', 'Tampacán'), ('1852', '24', 'Tampamolón Corona'), ('1853', '24', 'Tamuín'), ('1854', '24', 'Tanlajás'), ('1855', '24', 'Tanquián de Escobedo'), ('1856', '24', 'Tierra Nueva'), ('1857', '24', 'Vanegas'), ('1858', '24', 'Venado'), ('1859', '24', 'Villa de Arriaga'), ('1860', '24', 'Villa de Guadalupe'), ('1861', '24', 'Villa de la Paz'), ('1862', '24', 'Villa de Ramos'), ('1863', '24', 'Villa de Reyes'), ('1864', '24', 'Villa Hidalgo'), ('1865', '24', 'Villa Juárez'), ('1866', '24', 'Axtla de Terrazas'), ('1867', '24', 'Xilitla'), ('1868', '24', 'Zaragoza'), ('1869', '24', 'Villa de Arista'), ('1870', '24', 'Matlapa'), ('1871', '24', 'El Naranjo'), ('1872', '25', 'Ahome'), ('1873', '25', 'Angostura'), ('1874', '25', 'Badiraguato'), ('1875', '25', 'Concordia'), ('1876', '25', 'Cosalá'), ('1877', '25', 'Culiacán'), ('1878', '25', 'Choix'), ('1879', '25', 'Elota'), ('1880', '25', 'Escuinapa'), ('1881', '25', 'El Fuerte'), ('1882', '25', 'Guasave'), ('1883', '25', 'Mazatlán'), ('1884', '25', 'Mocorito'), ('1885', '25', 'Rosario'), ('1886', '25', 'Salvador Alvarado'), ('1887', '25', 'San Ignacio'), ('1888', '25', 'Sinaloa'), ('1889', '25', 'Navolato'), ('1890', '26', 'Aconchi'), ('1891', '26', 'Agua Prieta'), ('1892', '26', 'Alamos'), ('1893', '26', 'Altar'), ('1894', '26', 'Arivechi'), ('1895', '26', 'Arizpe'), ('1896', '26', 'Atil'), ('1897', '26', 'Bacadéhuachi'), ('1898', '26', 'Bacanora'), ('1899', '26', 'Bacerac'), ('1900', '26', 'Bacoachi'), ('1901', '26', 'Bácum'), ('1902', '26', 'Banámichi'), ('1903', '26', 'Baviácora'), ('1904', '26', 'Bavispe'), ('1905', '26', 'Benjamín Hill'), ('1906', '26', 'Caborca'), ('1907', '26', 'Cajeme'), ('1908', '26', 'Cananea'), ('1909', '26', 'Carbó'), ('1910', '26', 'La Colorada'), ('1911', '26', 'Cucurpe'), ('1912', '26', 'Cumpas'), ('1913', '26', 'Divisaderos'), ('1914', '26', 'Empalme'), ('1915', '26', 'Etchojoa'), ('1916', '26', 'Fronteras'), ('1917', '26', 'Granados'), ('1918', '26', 'Guaymas'), ('1919', '26', 'Hermosillo'), ('1920', '26', 'Huachinera'), ('1921', '26', 'Huásabas'), ('1922', '26', 'Huatabampo'), ('1923', '26', 'Huépac'), ('1924', '26', 'Imuris'), ('1925', '26', 'Magdalena'), ('1926', '26', 'Mazatán'), ('1927', '26', 'Moctezuma'), ('1928', '26', 'Naco'), ('1929', '26', 'Nácori Chico'), ('1930', '26', 'Nacozari de García'), ('1931', '26', 'Navojoa'), ('1932', '26', 'Nogales'), ('1933', '26', 'Onavas'), ('1934', '26', 'Opodepe'), ('1935', '26', 'Oquitoa'), ('1936', '26', 'Pitiquito'), ('1937', '26', 'Puerto Peñasco'), ('1938', '26', 'Quiriego'), ('1939', '26', 'Rayón'), ('1940', '26', 'Rosario'), ('1941', '26', 'Sahuaripa'), ('1942', '26', 'San Felipe de Jesús'), ('1943', '26', 'San Javier'), ('1944', '26', 'San Luis Río Colorado'), ('1945', '26', 'San Miguel de Horcasitas'), ('1946', '26', 'San Pedro de la Cueva'), ('1947', '26', 'Santa Ana'), ('1948', '26', 'Santa Cruz'), ('1949', '26', 'Sáric'), ('1950', '26', 'Soyopa'), ('1951', '26', 'Suaqui Grande'), ('1952', '26', 'Tepache'), ('1953', '26', 'Trincheras'), ('1954', '26', 'Tubutama'), ('1955', '26', 'Ures'), ('1956', '26', 'Villa Hidalgo'), ('1957', '26', 'Villa Pesqueira'), ('1958', '26', 'Yécora'), ('1959', '26', 'General Plutarco Elías Calles'), ('1960', '26', 'Benito Juárez'), ('1961', '26', 'San Ignacio Río Muerto'), ('1962', '27', 'Balancán'), ('1963', '27', 'Cárdenas'), ('1964', '27', 'Centla'), ('1965', '27', 'Centro');



INSERT INTO `ciudades` VALUES ('1966', '27', 'Comalcalco'), ('1967', '27', 'Cunduacán'), ('1968', '27', 'Emiliano Zapata'), ('1969', '27', 'Huimanguillo'), ('1970', '27', 'Jalapa'), ('1971', '27', 'Jalpa de Méndez'), ('1972', '27', 'Jonuta'), ('1973', '27', 'Macuspana'), ('1974', '27', 'Nacajuca'), ('1975', '27', 'Paraíso'), ('1976', '27', 'Tacotalpa'), ('1977', '27', 'Teapa'), ('1978', '27', 'Tenosique'), ('1979', '28', 'Abasolo'), ('1980', '28', 'Aldama'), ('1981', '28', 'Altamira'), ('1982', '28', 'Antiguo Morelos'), ('1983', '28', 'Burgos'), ('1984', '28', 'Bustamante'), ('1985', '28', 'Camargo'), ('1986', '28', 'Casas'), ('1987', '28', 'Ciudad Madero'), ('1988', '28', 'Cruillas'), ('1989', '28', 'Gómez Farías'), ('1990', '28', 'González'), ('1991', '28', 'Güémez'), ('1992', '28', 'Guerrero'), ('1993', '28', 'Gustavo Díaz Ordaz'), ('1994', '28', 'Hidalgo'), ('1995', '28', 'Jaumave'), ('1996', '28', 'Jiménez'), ('1997', '28', 'Llera'), ('1998', '28', 'Mainero'), ('1999', '28', 'El Mante'), ('2000', '28', 'Matamoros'), ('2001', '28', 'Méndez'), ('2002', '28', 'Mier'), ('2003', '28', 'Miguel Alemán'), ('2004', '28', 'Miquihuana'), ('2005', '28', 'Nuevo Laredo'), ('2006', '28', 'Nuevo Morelos'), ('2007', '28', 'Ocampo'), ('2008', '28', 'Padilla'), ('2009', '28', 'Palmillas'), ('2010', '28', 'Reynosa'), ('2011', '28', 'Río Bravo'), ('2012', '28', 'San Carlos'), ('2013', '28', 'San Fernando'), ('2014', '28', 'San Nicolás'), ('2015', '28', 'Soto la Marina'), ('2016', '28', 'Tampico'), ('2017', '28', 'Tula'), ('2018', '28', 'Valle Hermoso'), ('2019', '28', 'Victoria'), ('2020', '28', 'Villagrán'), ('2021', '28', 'Xicoténcatl'), ('2022', '29', 'Amaxac de Guerrero'), ('2023', '29', 'Apetatitlán de Antonio Carvajal'), ('2024', '29', 'Atlangatepec'), ('2025', '29', 'Atltzayanca'), ('2026', '29', 'Apizaco'), ('2027', '29', 'Calpulalpan'), ('2028', '29', 'El Carmen Tequexquitla'), ('2029', '29', 'Cuapiaxtla'), ('2030', '29', 'Cuaxomulco'), ('2031', '29', 'Chiautempan'), ('2032', '29', 'Muñoz de Domingo Arenas'), ('2033', '29', 'Españita'), ('2034', '29', 'Huamantla'), ('2035', '29', 'Hueyotlipan'), ('2036', '29', 'Ixtacuixtla de Mariano Matamoros'), ('2037', '29', 'Ixtenco'), ('2038', '29', 'Mazatecochco de José María Morelos'), ('2039', '29', 'Contla de Juan Cuamatzi'), ('2040', '29', 'Tepetitla de Lardizábal'), ('2041', '29', 'Sanctórum de Lázaro Cárdenas'), ('2042', '29', 'Nanacamilpa de Mariano Arista'), ('2043', '29', 'Acuamanala de Miguel Hidalgo'), ('2044', '29', 'Natívitas'), ('2045', '29', 'Panotla'), ('2046', '29', 'San Pablo del Monte'), ('2047', '29', 'Santa Cruz Tlaxcala'), ('2048', '29', 'Tenancingo'), ('2049', '29', 'Teolocholco'), ('2050', '29', 'Tepeyanco'), ('2051', '29', 'Terrenate'), ('2052', '29', 'Tetla de la Solidaridad'), ('2053', '29', 'Tetlatlahuca'), ('2054', '29', 'Tlaxcala'), ('2055', '29', 'Tlaxco'), ('2056', '29', 'Tocatlán'), ('2057', '29', 'Totolac'), ('2058', '29', 'Ziltlaltépec de Trinidad Sánchez Santos'), ('2059', '29', 'Tzompantepec'), ('2060', '29', 'Xaloztoc'), ('2061', '29', 'Xaltocan'), ('2062', '29', 'Papalotla de Xicohténcatl'), ('2063', '29', 'Xicohtzinco'), ('2064', '29', 'Yauhquemehcan'), ('2065', '29', 'Zacatelco'), ('2066', '29', 'Benito Juárez'), ('2067', '29', 'Emiliano Zapata'), ('2068', '29', 'Lázaro Cárdenas'), ('2069', '29', 'La Magdalena Tlaltelulco'), ('2070', '29', 'San Damián Texóloc'), ('2071', '29', 'San Francisco Tetlanohcan'), ('2072', '29', 'San Jerónimo Zacualpan'), ('2073', '29', 'San José Teacalco'), ('2074', '29', 'San Juan Huactzinco'), ('2075', '29', 'San Lorenzo Axocomanitla'), ('2076', '29', 'San Lucas Tecopilco'), ('2077', '29', 'Santa Ana Nopalucan'), ('2078', '29', 'Santa Apolonia Teacalco'), ('2079', '29', 'Santa Catarina Ayometla'), ('2080', '29', 'Santa Cruz Quilehtla'), ('2081', '29', 'Santa Isabel Xiloxoxtla'), ('2082', '30', 'Acajete'), ('2083', '30', 'Acatlán'), ('2084', '30', 'Acayucan'), ('2085', '30', 'Actopan'), ('2086', '30', 'Acula'), ('2087', '30', 'Acultzingo'), ('2088', '30', 'Camarón de Tejeda'), ('2089', '30', 'Alpatláhuac'), ('2090', '30', 'Alto Lucero de Gutiérrez Barrios'), ('2091', '30', 'Altotonga'), ('2092', '30', 'Alvarado'), ('2093', '30', 'Amatitlán'), ('2094', '30', 'Naranjos Amatlán'), ('2095', '30', 'Amatlán de los Reyes'), ('2096', '30', 'Angel R. Cabada'), ('2097', '30', 'La Antigua'), ('2098', '30', 'Apazapan'), ('2099', '30', 'Aquila'), ('2100', '30', 'Astacinga'), ('2101', '30', 'Atlahuilco'), ('2102', '30', 'Atoyac'), ('2103', '30', 'Atzacan'), ('2104', '30', 'Atzalan'), ('2105', '30', 'Tlaltetela'), ('2106', '30', 'Ayahualulco'), ('2107', '30', 'Banderilla'), ('2108', '30', 'Benito Juárez'), ('2109', '30', 'Boca del Río'), ('2110', '30', 'Calcahualco'), ('2111', '30', 'Camerino Z. Mendoza'), ('2112', '30', 'Carrillo Puerto'), ('2113', '30', 'Catemaco'), ('2114', '30', 'Cazones de Herrera'), ('2115', '30', 'Cerro Azul'), ('2116', '30', 'Citlaltépetl'), ('2117', '30', 'Coacoatzintla'), ('2118', '30', 'Coahuitlán'), ('2119', '30', 'Coatepec'), ('2120', '30', 'Coatzacoalcos'), ('2121', '30', 'Coatzintla'), ('2122', '30', 'Coetzala'), ('2123', '30', 'Colipa'), ('2124', '30', 'Comapa'), ('2125', '30', 'Córdoba'), ('2126', '30', 'Cosamaloapan de Carpio'), ('2127', '30', 'Cosautlán de Carvajal'), ('2128', '30', 'Coscomatepec'), ('2129', '30', 'Cosoleacaque'), ('2130', '30', 'Cotaxtla'), ('2131', '30', 'Coxquihui'), ('2132', '30', 'Coyutla'), ('2133', '30', 'Cuichapa'), ('2134', '30', 'Cuitláhuac'), ('2135', '30', 'Chacaltianguis'), ('2136', '30', 'Chalma'), ('2137', '30', 'Chiconamel'), ('2138', '30', 'Chiconquiaco'), ('2139', '30', 'Chicontepec'), ('2140', '30', 'Chinameca'), ('2141', '30', 'Chinampa de Gorostiza'), ('2142', '30', 'Las Choapas'), ('2143', '30', 'Chocamán'), ('2144', '30', 'Chontla'), ('2145', '30', 'Chumatlán'), ('2146', '30', 'Emiliano Zapata'), ('2147', '30', 'Espinal'), ('2148', '30', 'Filomeno Mata'), ('2149', '30', 'Fortín'), ('2150', '30', 'Gutiérrez Zamora'), ('2151', '30', 'Hidalgotitlán'), ('2152', '30', 'Huatusco'), ('2153', '30', 'Huayacocotla'), ('2154', '30', 'Hueyapan de Ocampo'), ('2155', '30', 'Huiloapan de Cuauhtémoc'), ('2156', '30', 'Ignacio de la Llave'), ('2157', '30', 'Ilamatlán'), ('2158', '30', 'Isla'), ('2159', '30', 'Ixcatepec'), ('2160', '30', 'Ixhuacán de los Reyes'), ('2161', '30', 'Ixhuatlán del Café'), ('2162', '30', 'Ixhuatlancillo'), ('2163', '30', 'Ixhuatlán del Sureste'), ('2164', '30', 'Ixhuatlán de Madero'), ('2165', '30', 'Ixmatlahuacan'), ('2166', '30', 'Ixtaczoquitlán'), ('2167', '30', 'Jalacingo'), ('2168', '30', 'Xalapa'), ('2169', '30', 'Jalcomulco'), ('2170', '30', 'Jáltipan'), ('2171', '30', 'Jamapa'), ('2172', '30', 'Jesús Carranza'), ('2173', '30', 'Xico'), ('2174', '30', 'Jilotepec'), ('2175', '30', 'Juan Rodríguez Clara'), ('2176', '30', 'Juchique de Ferrer'), ('2177', '30', 'Landero y Coss'), ('2178', '30', 'Lerdo de Tejada'), ('2179', '30', 'Magdalena'), ('2180', '30', 'Maltrata'), ('2181', '30', 'Manlio Fabio Altamirano'), ('2182', '30', 'Mariano Escobedo'), ('2183', '30', 'Martínez de la Torre'), ('2184', '30', 'Mecatlán'), ('2185', '30', 'Mecayapan'), ('2186', '30', 'Medellín'), ('2187', '30', 'Miahuatlán'), ('2188', '30', 'Las Minas'), ('2189', '30', 'Minatitlán'), ('2190', '30', 'Misantla'), ('2191', '30', 'Mixtla de Altamirano'), ('2192', '30', 'Moloacán'), ('2193', '30', 'Naolinco'), ('2194', '30', 'Naranjal'), ('2195', '30', 'Nautla'), ('2196', '30', 'Nogales'), ('2197', '30', 'Oluta'), ('2198', '30', 'Omealca'), ('2199', '30', 'Orizaba'), ('2200', '30', 'Otatitlán'), ('2201', '30', 'Oteapan'), ('2202', '30', 'Ozuluama de Mascareñas'), ('2203', '30', 'Pajapan'), ('2204', '30', 'Pánuco'), ('2205', '30', 'Papantla'), ('2206', '30', 'Paso del Macho'), ('2207', '30', 'Paso de Ovejas'), ('2208', '30', 'La Perla'), ('2209', '30', 'Perote'), ('2210', '30', 'Platón Sánchez'), ('2211', '30', 'Playa Vicente'), ('2212', '30', 'Poza Rica de Hidalgo'), ('2213', '30', 'Las Vigas de Ramírez'), ('2214', '30', 'Pueblo Viejo'), ('2215', '30', 'Puente Nacional'), ('2216', '30', 'Rafael Delgado'), ('2217', '30', 'Rafael Lucio'), ('2218', '30', 'Los Reyes'), ('2219', '30', 'Río Blanco'), ('2220', '30', 'Saltabarranca'), ('2221', '30', 'San Andrés Tenejapan'), ('2222', '30', 'San Andrés Tuxtla'), ('2223', '30', 'San Juan Evangelista'), ('2224', '30', 'Santiago Tuxtla'), ('2225', '30', 'Sayula de Alemán'), ('2226', '30', 'Soconusco'), ('2227', '30', 'Sochiapa'), ('2228', '30', 'Soledad Atzompa'), ('2229', '30', 'Soledad de Doblado'), ('2230', '30', 'Soteapan'), ('2231', '30', 'Tamalín'), ('2232', '30', 'Tamiahua'), ('2233', '30', 'Tampico Alto'), ('2234', '30', 'Tancoco'), ('2235', '30', 'Tantima'), ('2236', '30', 'Tantoyuca'), ('2237', '30', 'Tatatila'), ('2238', '30', 'Castillo de Teayo'), ('2239', '30', 'Tecolutla'), ('2240', '30', 'Tehuipango'), ('2241', '30', 'Álamo Temapache'), ('2242', '30', 'Tempoal'), ('2243', '30', 'Tenampa'), ('2244', '30', 'Tenochtitlán'), ('2245', '30', 'Teocelo'), ('2246', '30', 'Tepatlaxco'), ('2247', '30', 'Tepetlán'), ('2248', '30', 'Tepetzintla'), ('2249', '30', 'Tequila'), ('2250', '30', 'José Azueta'), ('2251', '30', 'Texcatepec'), ('2252', '30', 'Texhuacán'), ('2253', '30', 'Texistepec'), ('2254', '30', 'Tezonapa'), ('2255', '30', 'Tierra Blanca'), ('2256', '30', 'Tihuatlán'), ('2257', '30', 'Tlacojalpan'), ('2258', '30', 'Tlacolulan'), ('2259', '30', 'Tlacotalpan'), ('2260', '30', 'Tlacotepec de Mejía'), ('2261', '30', 'Tlachichilco'), ('2262', '30', 'Tlalixcoyan'), ('2263', '30', 'Tlalnelhuayocan'), ('2264', '30', 'Tlapacoyan'), ('2265', '30', 'Tlaquilpa'), ('2266', '30', 'Tlilapan'), ('2267', '30', 'Tomatlán'), ('2268', '30', 'Tonayán'), ('2269', '30', 'Totutla'), ('2270', '30', 'Tuxpan'), ('2271', '30', 'Tuxtilla'), ('2272', '30', 'Ursulo Galván'), ('2273', '30', 'Vega de Alatorre'), ('2274', '30', 'Veracruz'), ('2275', '30', 'Villa Aldama'), ('2276', '30', 'Xoxocotla'), ('2277', '30', 'Yanga'), ('2278', '30', 'Yecuatla'), ('2279', '30', 'Zacualpan'), ('2280', '30', 'Zaragoza'), ('2281', '30', 'Zentla'), ('2282', '30', 'Zongolica'), ('2283', '30', 'Zontecomatlán de López y Fuentes'), ('2284', '30', 'Zozocolco de Hidalgo'), ('2285', '30', 'Agua Dulce'), ('2286', '30', 'El Higo'), ('2287', '30', 'Nanchital de Lázaro Cárdenas del Río'), ('2288', '30', 'Tres Valles'), ('2289', '30', 'Carlos A. Carrillo'), ('2290', '30', 'Tatahuicapan de Juárez'), ('2291', '30', 'Uxpanapa'), ('2292', '30', 'San Rafael'), ('2293', '30', 'Santiago Sochiapan'), ('2294', '31', 'Abalá'), ('2295', '31', 'Acanceh'), ('2296', '31', 'Akil'), ('2297', '31', 'Baca'), ('2298', '31', 'Bokobá'), ('2299', '31', 'Buctzotz'), ('2300', '31', 'Cacalchén'), ('2301', '31', 'Calotmul'), ('2302', '31', 'Cansahcab'), ('2303', '31', 'Cantamayec'), ('2304', '31', 'Celestún'), ('2305', '31', 'Cenotillo'), ('2306', '31', 'Conkal'), ('2307', '31', 'Cuncunul'), ('2308', '31', 'Cuzamá'), ('2309', '31', 'Chacsinkín'), ('2310', '31', 'Chankom'), ('2311', '31', 'Chapab'), ('2312', '31', 'Chemax'), ('2313', '31', 'Chicxulub Pueblo'), ('2314', '31', 'Chichimilá'), ('2315', '31', 'Chikindzonot'), ('2316', '31', 'Chocholá'), ('2317', '31', 'Chumayel'), ('2318', '31', 'Dzán'), ('2319', '31', 'Dzemul'), ('2320', '31', 'Dzidzantún'), ('2321', '31', 'Dzilam de Bravo'), ('2322', '31', 'Dzilam González'), ('2323', '31', 'Dzitás'), ('2324', '31', 'Dzoncauich'), ('2325', '31', 'Espita'), ('2326', '31', 'Halachó'), ('2327', '31', 'Hocabá'), ('2328', '31', 'Hoctún'), ('2329', '31', 'Homún'), ('2330', '31', 'Huhí'), ('2331', '31', 'Hunucmá'), ('2332', '31', 'Ixil'), ('2333', '31', 'Izamal'), ('2334', '31', 'Kanasín'), ('2335', '31', 'Kantunil'), ('2336', '31', 'Kaua'), ('2337', '31', 'Kinchil'), ('2338', '31', 'Kopomá'), ('2339', '31', 'Mama'), ('2340', '31', 'Maní'), ('2341', '31', 'Maxcanú'), ('2342', '31', 'Mayapán'), ('2343', '31', 'Mérida'), ('2344', '31', 'Mocochá'), ('2345', '31', 'Motul'), ('2346', '31', 'Muna'), ('2347', '31', 'Muxupip'), ('2348', '31', 'Opichén'), ('2349', '31', 'Oxkutzcab'), ('2350', '31', 'Panabá'), ('2351', '31', 'Peto'), ('2352', '31', 'Progreso'), ('2353', '31', 'Quintana Roo'), ('2354', '31', 'Río Lagartos'), ('2355', '31', 'Sacalum'), ('2356', '31', 'Samahil'), ('2357', '31', 'Sanahcat'), ('2358', '31', 'San Felipe'), ('2359', '31', 'Santa Elena'), ('2360', '31', 'Seyé'), ('2361', '31', 'Sinanché'), ('2362', '31', 'Sotuta'), ('2363', '31', 'Sucilá'), ('2364', '31', 'Sudzal'), ('2365', '31', 'Suma'), ('2366', '31', 'Tahdziú'), ('2367', '31', 'Tahmek'), ('2368', '31', 'Teabo'), ('2369', '31', 'Tecoh'), ('2370', '31', 'Tekal de Venegas'), ('2371', '31', 'Tekantó'), ('2372', '31', 'Tekax'), ('2373', '31', 'Tekit'), ('2374', '31', 'Tekom'), ('2375', '31', 'Telchac Pueblo'), ('2376', '31', 'Telchac Puerto'), ('2377', '31', 'Temax'), ('2378', '31', 'Temozón'), ('2379', '31', 'Tepakán'), ('2380', '31', 'Tetiz'), ('2381', '31', 'Teya'), ('2382', '31', 'Ticul'), ('2383', '31', 'Timucuy'), ('2384', '31', 'Tinum'), ('2385', '31', 'Tixcacalcupul'), ('2386', '31', 'Tixkokob'), ('2387', '31', 'Tixmehuac'), ('2388', '31', 'Tixpéhual'), ('2389', '31', 'Tizimín'), ('2390', '31', 'Tunkás'), ('2391', '31', 'Tzucacab'), ('2392', '31', 'Uayma'), ('2393', '31', 'Ucú'), ('2394', '31', 'Umán'), ('2395', '31', 'Valladolid'), ('2396', '31', 'Xocchel'), ('2397', '31', 'Yaxcabá'), ('2398', '31', 'Yaxkukul'), ('2399', '31', 'Yobaín'), ('2400', '32', 'Apozol'), ('2401', '32', 'Apulco'), ('2402', '32', 'Atolinga'), ('2403', '32', 'Benito Juárez'), ('2404', '32', 'Calera'), ('2405', '32', 'Cañitas de Felipe Pescador'), ('2406', '32', 'Concepción del Oro'), ('2407', '32', 'Cuauhtémoc'), ('2408', '32', 'Chalchihuites'), ('2409', '32', 'Fresnillo'), ('2410', '32', 'Trinidad García de la Cadena'), ('2411', '32', 'Genaro Codina'), ('2412', '32', 'General Enrique Estrada'), ('2413', '32', 'General Francisco R. Murguía'), ('2414', '32', 'El Plateado de Joaquín Amaro'), ('2415', '32', 'General Pánfilo Natera'), ('2416', '32', 'Guadalupe'), ('2417', '32', 'Huanusco'), ('2418', '32', 'Jalpa'), ('2419', '32', 'Jerez'), ('2420', '32', 'Jiménez del Teul'), ('2421', '32', 'Juan Aldama'), ('2422', '32', 'Juchipila'), ('2423', '32', 'Loreto'), ('2424', '32', 'Luis Moya'), ('2425', '32', 'Mazapil'), ('2426', '32', 'Melchor Ocampo'), ('2427', '32', 'Mezquital del Oro'), ('2428', '32', 'Miguel Auza'), ('2429', '32', 'Momax'), ('2430', '32', 'Monte Escobedo'), ('2431', '32', 'Morelos'), ('2432', '32', 'Moyahua de Estrada'), ('2433', '32', 'Nochistlán de Mejía'), ('2434', '32', 'Noria de Ángeles'), ('2435', '32', 'Ojocaliente'), ('2436', '32', 'Pánuco'), ('2437', '32', 'Pinos'), ('2438', '32', 'Río Grande'), ('2439', '32', 'Sain Alto'), ('2440', '32', 'El Salvador'), ('2441', '32', 'Sombrerete'), ('2442', '32', 'Susticacán'), ('2443', '32', 'Tabasco'), ('2444', '32', 'Tepechitlán'), ('2445', '32', 'Tepetongo'), ('2446', '32', 'Teúl de González Ortega'), ('2447', '32', 'Tlaltenango de Sánchez Román'), ('2448', '32', 'Valparaíso'), ('2449', '32', 'Vetagrande'), ('2450', '32', 'Villa de Cos'), ('2451', '32', 'Villa García'), ('2452', '32', 'Villa González Ortega'), ('2453', '32', 'Villa Hidalgo'), ('2454', '32', 'Villanueva'), ('2455', '32', 'Zacatecas'), ('2456', '32', 'Trancoso'), ('2457', '32', 'Santa María de la Paz');
COMMIT;

-- ----------------------------
--  Table structure for `consultas`
-- ----------------------------
DROP TABLE IF EXISTS `consultas`;
CREATE TABLE `consultas` (
  `ID_Consulta` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_Serv` bigint(20) NOT NULL,
  `ID_User` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_Consulta`),
  UNIQUE KEY `Consulta` (`ID_Consulta`),
  KEY `Serv` (`ID_Serv`),
  KEY `User` (`ID_User`),
  KEY `Fecha` (`Fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `correcciones`
-- ----------------------------
DROP TABLE IF EXISTS `correcciones`;
CREATE TABLE `correcciones` (
  `ID_Correccion` int(11) NOT NULL,
  `ID_Temp` int(11) NOT NULL,
  `ID_Serv` int(11) NOT NULL,
  `Correccion` text NOT NULL,
  `Fecha_Correccion` datetime NOT NULL,
  `ID_User` int(11) NOT NULL,
  `ID_Valida` int(11) DEFAULT NULL,
  `Fecha_Valida` datetime DEFAULT NULL,
  `Observaciones` text,
  `Estatus` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID_Correccion`),
  UNIQUE KEY `Correct` (`ID_Correccion`),
  KEY `Temp` (`ID_Temp`),
  KEY `Serv` (`ID_Serv`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `dadeudos`
-- ----------------------------
DROP TABLE IF EXISTS `dadeudos`;
CREATE TABLE `dadeudos` (
  `ID_Adeudo` bigint(20) NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `Tipo_Ad` varchar(50) NOT NULL,
  `Institucion_Ad` text NOT NULL,
  `Cuenta_Ad` text,
  `Plazo_Ad` text,
  `Pago_Ad` text,
  `Titular_Ad` bigint(20) DEFAULT NULL,
  `Estatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Adeudo`),
  UNIQUE KEY `ID` (`ID_Adeudo`),
  KEY `Serv` (`ID_Serv`),
  KEY `Tipo` (`Tipo_Ad`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `ddependientes`
-- ----------------------------
DROP TABLE IF EXISTS `ddependientes`;
CREATE TABLE `ddependientes` (
  `ID_Depend` bigint(20) NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `Tipo_Depend` varchar(50) NOT NULL,
  `Nombre_Depend` text NOT NULL,
  `RFC_Depend` text NOT NULL,
  `CURP_Depend` text,
  `Nacimiento_Depend` date NOT NULL,
  `Estatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Depend`),
  UNIQUE KEY `ID` (`ID_Depend`),
  KEY `Tipo` (`Tipo_Depend`),
  KEY `Serv` (`ID_Serv`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `declaraciones`
-- ----------------------------
DROP TABLE IF EXISTS `declaraciones`;
CREATE TABLE `declaraciones` (
  `ID_Dec` bigint(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` bigint(11) NOT NULL,
  `ID_Info` bigint(20) NOT NULL,
  `Fecha_Dec` datetime NOT NULL,
  `Tipo_Dec` varchar(20) NOT NULL,
  `Balanza` float(15,2) DEFAULT NULL,
  `Balanza_Conyuge` float(15,2) DEFAULT NULL,
  `Balanza_Depend` float(15,2) DEFAULT NULL,
  PRIMARY KEY (`ID_Dec`),
  UNIQUE KEY `ID` (`ID_Dec`),
  KEY `Serv` (`ID_Serv`),
  KEY `Info` (`ID_Info`),
  KEY `Fecha` (`Fecha_Dec`),
  KEY `Tipo` (`Tipo_Dec`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `depend_hist`
-- ----------------------------
DROP TABLE IF EXISTS `depend_hist`;
CREATE TABLE `depend_hist` (
  `ID_Hist` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha_Hist` datetime NOT NULL,
  `ID_Depend` int(11) NOT NULL,
  `Domicilio_Depend` text NOT NULL,
  `Ocupacion_Depend` varchar(50) NOT NULL,
  `Lugar_Trabajo` text,
  `Domicilio_Trabajo` text,
  PRIMARY KEY (`ID_Hist`),
  KEY `Depend` (`ID_Depend`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `dependencias`
-- ----------------------------
DROP TABLE IF EXISTS `dependencias`;
CREATE TABLE `dependencias` (
  `ID_Dependencia` int(11) NOT NULL,
  `Dependencia` text NOT NULL,
  `Activo` bit(1) NOT NULL,
  PRIMARY KEY (`ID_Dependencia`),
  UNIQUE KEY `ID` (`ID_Dependencia`),
  KEY `Activo` (`Activo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

BEGIN;
INSERT INTO dependencias values(1, 'STRC', 1); 
COMMIT;

-- ----------------------------
--  Table structure for `dias_inhabiles`
-- ----------------------------
DROP TABLE IF EXISTS `dias_inhabiles`;
CREATE TABLE `dias_inhabiles` (
  `ID_Fecha` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  PRIMARY KEY (`ID_Fecha`),
  KEY `Fecha` (`Fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `dingresos`
-- ----------------------------
DROP TABLE IF EXISTS `dingresos`;
CREATE TABLE `dingresos` (
  `ID_Ingreso` bigint(20) NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `Tipo_Ing` tinyint(4) NOT NULL,
  `Concepto_Ing` text,
  `Importe_ing` text NOT NULL,
  `ID_in` bigint(20) DEFAULT NULL,
  `Contratista_Ing` text,
  PRIMARY KEY (`ID_Ingreso`),
  UNIQUE KEY `ID` (`ID_Ingreso`),
  KEY `Serv` (`ID_Serv`),
  KEY `TIpo` (`Tipo_Ing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `dinmuebles`
-- ----------------------------
DROP TABLE IF EXISTS `dinmuebles`;
CREATE TABLE `dinmuebles` (
  `ID_Inmueble` bigint(20) NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `Tipo_In` varchar(50) NOT NULL,
  `TerrenoM2` text,
  `ConstruccionM2` text,
  `Calle_In` text NOT NULL,
  `Numero_In` text NOT NULL,
  `Colonia_In` text NOT NULL,
  `Ciudad_In` text NOT NULL,
  `CP_In` text,
  `Titular_In` bigint(20) DEFAULT NULL,
  `Estatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Inmueble`),
  UNIQUE KEY `ID` (`ID_Inmueble`),
  KEY `Serv` (`ID_Serv`),
  KEY `Tipo` (`Tipo_In`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `dinversiones`
-- ----------------------------
DROP TABLE IF EXISTS `dinversiones`;
CREATE TABLE `dinversiones` (
  `ID_Inversion` bigint(20) NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `Tipo_Inv` varchar(50) NOT NULL,
  `Institucion_Inv` text,
  `Cuenta_Inv` text,
  `Titular_Inv` bigint(20) DEFAULT NULL,
  `Estatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Inversion`),
  UNIQUE KEY `ID` (`ID_Inversion`),
  KEY `Serv` (`ID_Serv`),
  KEY `Tipo` (`Tipo_Inv`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `dmuebles`
-- ----------------------------
DROP TABLE IF EXISTS `dmuebles`;
CREATE TABLE `dmuebles` (
  `ID_Mueble` bigint(20) NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `Tipo_Mue` varchar(50) NOT NULL,
  `Descripcion_Mue` text NOT NULL,
  `Titular_Mue` bigint(20) DEFAULT NULL,
  `Estatus` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID_Mueble`),
  UNIQUE KEY `ID` (`ID_Mueble`),
  KEY `Serv` (`ID_Serv`),
  KEY `Tipo` (`Tipo_Mue`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `dtransacciones`
-- ----------------------------
DROP TABLE IF EXISTS `dtransacciones`;
CREATE TABLE `dtransacciones` (
  `ID_Trans` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha_Trans` datetime NOT NULL,
  `ID_Dec` bigint(20) DEFAULT NULL,
  `ID_Elem` bigint(20) DEFAULT NULL,
  `Tipo_Elem` varchar(20) NOT NULL,
  `Fecha_Mov` date DEFAULT NULL,
  `Tipo_Trans` tinyint(20) NOT NULL,
  `Forma_Trans` varchar(10) DEFAULT NULL,
  `ID_Credito` bigint(20) DEFAULT NULL,
  `Importe` float(10,2) DEFAULT NULL,
  `Saldo` float(10,2) DEFAULT NULL,
  `Plazo` text,
  `Observaciones` text,
  `Aclaracion` text,
  PRIMARY KEY (`ID_Trans`),
  UNIQUE KEY `ID` (`ID_Trans`),
  KEY `Dec` (`ID_Dec`),
  KEY `Elem` (`ID_Elem`),
  KEY `Tipo` (`Tipo_Elem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `dvehiculos`
-- ----------------------------
DROP TABLE IF EXISTS `dvehiculos`;
CREATE TABLE `dvehiculos` (
  `ID_Vehiculo` bigint(20) NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `Tipo_Veh` varchar(50) NOT NULL,
  `Marca_Veh` text NOT NULL,
  `Serie_Veh` text,
  `Modelo_Veh` text NOT NULL,
  `Anio_Veh` text NOT NULL,
  `Titular_Veh` bigint(20) DEFAULT NULL,
  `Estatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Vehiculo`),
  UNIQUE KEY `ID` (`ID_Vehiculo`),
  KEY `Serv` (`ID_Serv`),
  KEY `Tip` (`Tipo_Veh`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `encuestas`
-- ----------------------------
DROP TABLE IF EXISTS `encuestas`;
CREATE TABLE `encuestas` (
  `ID_Encuesta` int(11) NOT NULL,
  `ID_Declaracion` int(11) NOT NULL,
  `ID_Serv` int(11) NOT NULL,
  `Respuesta` text NOT NULL,
  PRIMARY KEY (`ID_Encuesta`),
  UNIQUE KEY `ID` (`ID_Encuesta`),
  KEY `Dec` (`ID_Declaracion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `estados`
-- ----------------------------
DROP TABLE IF EXISTS `estados`;
CREATE TABLE `estados` (
  `ID_Estado` int(11) NOT NULL,
  `Estado` text NOT NULL,
  PRIMARY KEY (`ID_Estado`),
  UNIQUE KEY `ID` (`ID_Estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `estados`
-- ----------------------------
BEGIN;
INSERT INTO `estados` VALUES ('1', 'Aguascalientes'), ('2', 'Baja California'), ('3', 'Baja California Sur'), ('4', 'Campeche'), ('5', 'Coahuila de Zaragoza'), ('6', 'Colima'), ('7', 'Chiapas'), ('8', 'Chihuahua'), ('9', 'Distrito Federal'), ('10', 'Durango'), ('11', 'Guanajuato'), ('12', 'Guerrero'), ('13', 'Hidalgo'), ('14', 'Jalisco'), ('15', 'México'), ('16', 'Michoacán de Ocampo'), ('17', 'Morelos'), ('18', 'Nayarit'), ('19', 'Nuevo León'), ('20', 'Oaxaca'), ('21', 'Puebla'), ('22', 'Querétaro'), ('23', 'Quintana Roo'), ('24', 'San Luis Potosí'), ('25', 'Sinaloa'), ('26', 'Sonora'), ('27', 'Tabasco'), ('28', 'Tamaulipas'), ('29', 'Tlaxcala'), ('30', 'Veracruz de Ignacio de la Llave'), ('31', 'Yucatán'), ('32', 'Zacatecas');
COMMIT;

-- ----------------------------
--  Table structure for `estatus_bienes`
-- ----------------------------
DROP TABLE IF EXISTS `estatus_bienes`;
CREATE TABLE `estatus_bienes` (
  `ID_Estatus` int(11) NOT NULL,
  `Estatus` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `estatus_bienes`
-- ----------------------------
BEGIN;
INSERT INTO `estatus_bienes` VALUES ('-1', 'Eliminado'), ('0', 'Nuevo'), ('1', 'Activo'), ('2', 'Vendido'), ('3', 'Por validar'), ('4', 'Descartado'), ('5', 'Fusionado');
COMMIT;

-- ----------------------------
--  Table structure for `estatus_serv`
-- ----------------------------
DROP TABLE IF EXISTS `estatus_serv`;
CREATE TABLE `estatus_serv` (
  `ID_Estatus` int(11) NOT NULL,
  `Estatus` text NOT NULL,
  PRIMARY KEY (`ID_Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `estatus_serv`
-- ----------------------------
BEGIN;
INSERT INTO `estatus_serv` VALUES ('0', 'Desactivado'), ('1', 'Activo'), ('2', 'Baja'), ('3', 'Promocionado'), ('4', 'Licencia');
COMMIT;

-- ----------------------------
--  Table structure for `faqs`
-- ----------------------------
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `ID_Faq` int(11) NOT NULL,
  `Descripcion` text NOT NULL,
  `Respuesta` text NOT NULL,
  PRIMARY KEY (`ID_Faq`),
  UNIQUE KEY `ID` (`ID_Faq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `fiscal_dec`
-- ----------------------------
DROP TABLE IF EXISTS `fiscal_dec`;
CREATE TABLE `fiscal_dec` (
  `ID_DecFis` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` bigint(20) NOT NULL,
  `Fecha_DecFis` datetime NOT NULL,
  `Documento` text NOT NULL,
  PRIMARY KEY (`ID_DecFis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `fracciones`
-- ----------------------------
DROP TABLE IF EXISTS `fracciones`;
CREATE TABLE `fracciones` (
  `ID_Fraccion` int(11) NOT NULL,
  `Fraccion` varchar(10) NOT NULL,
  `Descripcion` text,
  `Activo` bit(1) NOT NULL,
  PRIMARY KEY (`ID_Fraccion`),
  UNIQUE KEY `ID` (`ID_Fraccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `funciones`
-- ----------------------------
DROP TABLE IF EXISTS `funciones`;
CREATE TABLE `funciones` (
  `ID_Funcion` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` int(11) NOT NULL,
  `Funcion` text NOT NULL,
  PRIMARY KEY (`ID_Funcion`),
  UNIQUE KEY `ID` (`ID_Funcion`),
  KEY `Serv` (`ID_Serv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `grupos`
-- ----------------------------
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos` (
  `ID_Grupo` int(11) NOT NULL,
  `Grupo` text NOT NULL,
  `Image` text NOT NULL,
  PRIMARY KEY (`ID_Grupo`),
  UNIQUE KEY `ID` (`ID_Grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `grupos`
-- ----------------------------
BEGIN;
INSERT INTO `grupos` VALUES ('1', 'Ayuda', 'img/help.png'), ('2', 'Contraseña', 'img/key.png'), ('3', 'Captura', 'img/form.png'), ('4', 'Reportes', 'img/stat.png'), ('5', 'Convenios y Recordatorios', 'img/books.png'), ('6', 'Padrón', 'img/people.png'), ('7', 'Calendario', 'img/calendar.png'), ('8', 'Sistema', 'img/preferences.png'), ('9', 'Procedimientos', 'img/proced.png'), ('10', 'Verificación', 'img/task.png'), ('11', 'Prórrogas', 'img/crono.png'), ('12', 'Catálogos', 'img/catalog.png'), ('13', 'Tareas', 'img/ray.png'), ('14', 'Chat', 'img/chat.png'), ('15', 'Alertas', 'img');
COMMIT;

-- ----------------------------
--  Table structure for `infoserv`
-- ----------------------------
DROP TABLE IF EXISTS `infoserv`;
CREATE TABLE `infoserv` (
  `ID_Info` bigint(11) NOT NULL,
  `ID_Serv` int(11) NOT NULL,
  `Calle` text,
  `Numero` text,
  `Colonia` text,
  `ID_Ciudad` int(11) DEFAULT NULL,
  `CP` varchar(10) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Civil` varchar(20) DEFAULT NULL,
  `CURP` varchar(50) DEFAULT NULL,
  `Identificacion` varchar(50) DEFAULT NULL,
  `Clave` text,
  PRIMARY KEY (`ID_Info`),
  UNIQUE KEY `ID` (`ID_Info`),
  KEY `Serv` (`ID_Serv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `intereses_dec`
-- ----------------------------
DROP TABLE IF EXISTS `intereses_dec`;
CREATE TABLE `intereses_dec` (
  `ID_DecInt` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_Serv` bigint(20) NOT NULL,
  `ID_Info` int(11) NOT NULL,
  `Fecha_DecInt` datetime NOT NULL,
  PRIMARY KEY (`ID_DecInt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `intereses_diversos`
-- ----------------------------
DROP TABLE IF EXISTS `intereses_diversos`;
CREATE TABLE `intereses_diversos` (
  `ID_IntDiv` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` int(11) NOT NULL,
  `ID_DecInt` bigint(20) DEFAULT NULL,
  `RazonSocial` varchar(255) DEFAULT NULL,
  `Cargo` varchar(255) DEFAULT NULL,
  `Anio` int(11) DEFAULT NULL,
  `Vigente` tinyint(4) DEFAULT NULL,
  `Participacion` varchar(50) DEFAULT NULL,
  `Parentesco` varchar(50) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Emisor` varchar(255) DEFAULT NULL,
  `Receptor` varchar(255) DEFAULT NULL,
  `Pais` varchar(255) DEFAULT NULL,
  `Descripcion` text,
  `ValorTotal` double(10,2) DEFAULT NULL,
  `ID_Depend` int(11) DEFAULT NULL,
  `Tipo` varchar(50) DEFAULT NULL,
  `Registro` varchar(50) DEFAULT NULL,
  `Estatus` tinyint(4) DEFAULT NULL,
  `Captura` datetime DEFAULT NULL,
  `Aclaracion` text,
  PRIMARY KEY (`ID_IntDiv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `intereses_economicos`
-- ----------------------------
DROP TABLE IF EXISTS `intereses_economicos`;
CREATE TABLE `intereses_economicos` (
  `ID_IntEco` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` int(11) NOT NULL,
  `ID_DecInt` bigint(20) DEFAULT NULL,
  `RazonSocial` varchar(255) DEFAULT NULL,
  `SectorEco` varchar(255) DEFAULT NULL,
  `Pais` varchar(255) DEFAULT NULL,
  `Antiguedad` int(11) DEFAULT NULL,
  `Cargo` varchar(255) DEFAULT NULL,
  `Participacion` varchar(50) DEFAULT NULL,
  `MontoAnual` double(10,2) DEFAULT NULL,
  `Titular` text,
  `Porcentaje` int(11) DEFAULT NULL,
  `DependEco` text,
  `Actividad` text,
  `FechaInicio` date DEFAULT NULL,
  `Mayoritario` tinyint(4) DEFAULT NULL,
  `Registro` varchar(50) DEFAULT NULL COMMENT 'DECLARANTE/DEPENDIENTE',
  `Tipo` varchar(50) DEFAULT NULL,
  `Estatus` tinyint(4) DEFAULT NULL,
  `Captura` datetime DEFAULT NULL,
  `Aclaracion` text,
  PRIMARY KEY (`ID_IntEco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `intereses_otros`
-- ----------------------------
DROP TABLE IF EXISTS `intereses_otros`;
CREATE TABLE `intereses_otros` (
  `ID_IntOtro` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` int(11) NOT NULL,
  `ID_DecInt` bigint(20) DEFAULT NULL,
  `Descripcion` text,
  `Estatus` tinyint(4) DEFAULT NULL,
  `Captura` datetime DEFAULT NULL,
  `Aclaracion` text,
  PRIMARY KEY (`ID_IntOtro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `intereses_profesionales`
-- ----------------------------
DROP TABLE IF EXISTS `intereses_profesionales`;
CREATE TABLE `intereses_profesionales` (
  `ID_IntPro` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` int(11) NOT NULL,
  `ID_DecInt` bigint(20) DEFAULT NULL,
  `RazonSocial` varchar(255) DEFAULT NULL,
  `SectorEco` varchar(255) DEFAULT NULL,
  `Cargo` varchar(255) DEFAULT NULL,
  `Pais` varchar(255) DEFAULT NULL,
  `Actividad` varchar(255) DEFAULT NULL,
  `FechaInicio` date DEFAULT NULL,
  `FechaTermino` date DEFAULT NULL,
  `DependProf` text,
  `MontoAnual` double(10,2) DEFAULT NULL,
  `PersonaFisica` tinyint(4) DEFAULT NULL,
  `Registro` varchar(50) DEFAULT NULL,
  `Estatus` tinyint(4) DEFAULT NULL,
  `Captura` datetime DEFAULT NULL,
  `Aclaracion` text,
  PRIMARY KEY (`ID_IntPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `log`
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `ID_Log` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` bigint(20) NOT NULL,
  `Tipo_Dec` varchar(20) NOT NULL,
  `Fecha` datetime NOT NULL,
  `ID_User` int(11) NOT NULL,
  PRIMARY KEY (`ID_Log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `mensajes`
-- ----------------------------
DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes` (
  `ID_Mensaje` bigint(20) NOT NULL,
  `Tipo` tinyint(4) NOT NULL,
  `Alcance` varchar(20) DEFAULT NULL,
  `ID_Emisor` int(11) NOT NULL,
  `ID_Receptor` int(11) DEFAULT NULL,
  `Fecha_Creacion` datetime NOT NULL,
  `Fecha_Expiracion` date DEFAULT NULL,
  `Asunto` text NOT NULL,
  `Mensaje` text NOT NULL,
  `Leido` bit(1) DEFAULT NULL,
  PRIMARY KEY (`ID_Mensaje`),
  UNIQUE KEY `ID` (`ID_Mensaje`),
  KEY `Tipo` (`Tipo`),
  KEY `Alcance` (`Alcance`),
  KEY `Emisor` (`ID_Emisor`),
  KEY `Receptor` (`ID_Receptor`),
  KEY `Leido` (`Leido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `modificaciones`
-- ----------------------------
DROP TABLE IF EXISTS `modificaciones`;
CREATE TABLE `modificaciones` (
  `ID_Modif` int(11) NOT NULL,
  `Fecha_Modif` datetime DEFAULT NULL,
  `ID_Dec` bigint(20) DEFAULT NULL,
  `ID_User` int(11) DEFAULT NULL,
  `Fecha_Limite` date DEFAULT NULL,
  PRIMARY KEY (`ID_Modif`),
  KEY `Dec` (`ID_Dec`),
  KEY `Lmit` (`Fecha_Limite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `modulos`
-- ----------------------------
DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos` (
  `ID_Modulo` int(11) NOT NULL,
  `Modulo` text NOT NULL,
  `Page` text NOT NULL,
  `ID_Grupo` int(11) NOT NULL,
  PRIMARY KEY (`ID_Modulo`),
  UNIQUE KEY `ID` (`ID_Modulo`),
  KEY `Grupo` (`ID_Grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `modulos`
-- ----------------------------
BEGIN;
INSERT INTO `modulos` VALUES ('1', 'Preguntas frecuentes', 'help.php', '1'), ('2', 'Manual de usuario', 'media/manual.pdf', '1'), ('3', 'Mi contraseña', 'change.php', '2'), ('4', 'Información personal', 'infoserv.php', '3'), ('5', 'Rep. Declaraciones', 'repdec.php', '4'), ('7', 'Convenios y Record.', 'reminder.php', '5'), ('8', 'Altas', 'register.php', '6'), ('9', 'Rep. Movimientos', 'repmov.php', '4'), ('10', 'Movimientos', 'mov.php', '6'), ('11', 'Rep. Encuestas', 'repenc.php', '4'), ('13', 'Días inhábiles', 'calendar.php', '7'), ('14', 'Puestos', 'position.php', '12'), ('15', 'Dependencias', 'depend.php', '12'), ('16', 'Fracciones', 'fracc.php', '12'), ('17', 'Usuarios', 'users.php', '8'), ('18', 'Permisos', 'allow.php', '8'), ('23', 'Casos omisos', 'omited.php', '9'), ('24', 'Procedimientos', 'procedure.php', '9'), ('25', 'Oficios', 'ofic.php', '13'), ('26', 'Consultas', 'consult.php', '13'), ('27', 'Verificación', 'verify.php', '13'), ('28', 'Procedimientos', 'procedure.php', '13'), ('29', 'Opciones', 'config.php', '8'), ('30', 'Mensajes/Notif', 'message.php', '8'), ('31', 'Chat', 'chat.php', '14'), ('32', 'Gestionar prórrogas', 'prorrogue.php', '11'), ('33', 'Alertas', 'alert.php', '15'), ('34', 'Declaraciones', 'consult.php', '13'), ('35', 'Rep. Cumplimiento', 'repcump.php', '4'), ('36', 'Rep. Obligados', 'repobligados.php', '4'), ('37', 'Gestionar acuerdos declaración pública', 'adopublica.php', '13');
COMMIT;

-- ----------------------------
--  Table structure for `movimientos`
-- ----------------------------
DROP TABLE IF EXISTS `movimientos`;
CREATE TABLE `movimientos` (
  `ID_Mov` bigint(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` bigint(11) NOT NULL,
  `Fecha_Mov` date NOT NULL,
  `Tipo_Mov` int(11) NOT NULL,
  `Tipo_Reg` varchar(20) DEFAULT NULL,
  `Documento` text,
  `Procedencia` int(11) DEFAULT NULL,
  `Inicio` date DEFAULT NULL,
  `Termino` date DEFAULT NULL,
  `Motivo` text,
  `ID_User` int(11) NOT NULL,
  PRIMARY KEY (`ID_Mov`),
  UNIQUE KEY `ID` (`ID_Mov`),
  KEY `Fecha` (`Fecha_Mov`),
  KEY `Serv` (`ID_Serv`),
  KEY `Tipo` (`Tipo_Mov`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `oficios`
-- ----------------------------
DROP TABLE IF EXISTS `oficios`;
CREATE TABLE `oficios` (
  `ID_Oficio` int(11) NOT NULL AUTO_INCREMENT,
  `ID_User` int(11) NOT NULL,
  `ID_Responsable` int(11) NOT NULL,
  `Expediente` text NOT NULL,
  `ID_Dependencia` int(11) NOT NULL,
  `Fecha_Turno` datetime NOT NULL,
  `Instruccion` text NOT NULL,
  `Fecha_Resp` datetime DEFAULT NULL,
  `Estatus` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID_Oficio`),
  UNIQUE KEY `ID` (`ID_Oficio`),
  KEY `User` (`ID_User`),
  KEY `Resp` (`ID_Responsable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `parametros`
-- ----------------------------
DROP TABLE IF EXISTS `parametros`;
CREATE TABLE `parametros` (
  `ID_Parametro` int(11) NOT NULL DEFAULT '0',
  `Nombre` text COLLATE utf8_spanish_ci,
  `Valor` text COLLATE utf8_spanish_ci,
  `ToolTip` text COLLATE utf8_spanish_ci,
  `Tipo` text COLLATE utf8_spanish_ci,
  `Orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Parametro`),
  UNIQUE KEY `ID` (`ID_Parametro`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `parametros`
-- ----------------------------
BEGIN;
INSERT INTO `parametros` VALUES ('1', 'Nombre del Director', 'Lic. Patricia Cabrera Hidalgo', 'Nombre del representante del área que figura en los documentos', 'text', '3'), ('2', 'Firma de documentos', 'null', 'Archivo de imagèn que contiene la firma escaneada del director', 'jpg,png,gif', '4'), ('3', 'Plazo Oficial de Declaración (días)', '60', 'Número de días hábiles permitidos para la presentación de las declaraciones', 'text', '7'), ('4', 'Manual de usuario', 'media/ManualUsuario.pdf', 'Archivo que contiene manual general para el usuario', 'pdf', '8'), ('5', 'Fecha Límite de Anuales', '2015-06-01', 'Fecha límite para presentación de declaración anual, de cada año', 'date', '9'), ('6', 'DIrección Correo Oficial', 'notificaciones_strc@guanajuato.gob.mx', 'Dirección de correo electrónico para envios automáticos', 'text', '10'), ('7', 'Contraseña de correo', 'AdM1nM@1L001', 'Contraseña del correo oficial', 'password', '11'), ('8', 'Remitente de correo', 'Declaranet Guanajuato', 'Nombre del remitente visible en los correos enviados', 'text', '12'), ('9', 'Host de correo', 'ssl://smtp.gmail.com', 'Dirección del host SMTP para correo oficial', 'text', '13'), ('10', 'Puerto de correo', '465', 'Puerto destinado en el servidor para el envio de correos', 'text', '14'), ('11', 'Autenticación SMTP', 'true', 'Determina si requiere autenticación SMTP para el envio', 'text', '15'), ('12', 'Dimensión de firma (ancho)', '25', 'Tamaño aproximado de la firma en el documento (mm)', 'text', '5'), ('13', 'Dimensión de firma (alto)', '50', 'Tamaño aproximado de la firma en el documento (mm)', 'text', '6'), ('14', 'Nombre de la Dependencia', 'Secretaría de la Transparencia y Rendición de Cuentas', 'Nombre de la dependencia encargada', 'text', '1'), ('15', 'Título de gobierno', 'Gobierno del Estado de Guanajuato', 'Título de gobierno', 'text', '2'), ('16', 'Información de contacto', 'Secretaría de la Transparencia y Rendición de Cuentas <br> Conjunto Administrativo Pozuelos s/n C.P. 36080 Guanajuato, Gto. <br> Tel. 01 (473)  735-13-64 y LADA SIN COSTO 01 (800) 506 16 16', 'Datos de contacto mostrados en la parte inferior del sitio', 'textarea', '17'), ('17', 'Título del sitio', 'Declaranet Guanajuato', 'Título mostrado en la parte superior del navegador', 'text', '16'), ('18', 'Logo de Gobierno', 'img/LogoGobierno.png', 'Logotipo oficial de gobierno', 'jpg,png,gif', '18'), ('19', 'Logo de la Dependencia', 'img/LogoDependencia.png', 'Logotipo oficial de la dependencia', 'jpg,png,gif', '19');
COMMIT;

-- ----------------------------
--  Table structure for `perfiles`
-- ----------------------------
DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE `perfiles` (
  `ID_Perfil` int(11) NOT NULL,
  `Perfil` text NOT NULL,
  `Acceso` text,
  PRIMARY KEY (`ID_Perfil`),
  UNIQUE KEY `ID` (`ID_Perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `perfiles`
-- ----------------------------
BEGIN;
INSERT INTO `perfiles` VALUES ('1', 'Administrador', '5|12|16|62|63|10|11|13|14|15|29|36|37|38|56|18|19|26|27|54|55|59|46|48|49|35|20|21|22|23|24|25|57|51|58|65|61|64|44|60|'), ('2', 'Asesor', '5|12|16|62|7|9|10|11|13|14|15|29|36|37|56|18|55|46|49|20|22|24|50|52|58|61|44|60|'), ('3', 'Recursos Humanos', '5|12|63|7|9|10|11|13|14|15|29|36|37|18|55|46|'), ('4', 'Director', '5|12|16|18|46|49|'), ('5', 'Asistente', '13|29|18|20|22|50|44|'), ('6', 'Auditoría', '12|13|18|46|20|22|24|52|58|61|'), ('7', 'Reportes', '5|18|46|'), ('8', 'Procedimientos', '5|12|9|13|37|18|46|48|49|'), ('9', 'Contralor', '5|12|63|18|55|46|');
COMMIT;

-- ----------------------------
--  Table structure for `permisos`
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos` (
  `ID_Permiso` int(11) NOT NULL,
  `ID_Modulo` int(11) NOT NULL,
  `Permiso` text NOT NULL,
  PRIMARY KEY (`ID_Permiso`),
  UNIQUE KEY `ID` (`ID_Permiso`),
  KEY `Modulo` (`ID_Modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `permisos`
-- ----------------------------
BEGIN;
INSERT INTO `permisos` VALUES ('5', '5', 'Ver reporte de declaraciones'), ('7', '7', 'Gestionar convenios'), ('9', '7', 'Gestionar recordatorios'), ('10', '8', 'Realizar alta manual'), ('11', '8', 'Habilitar método Batch'), ('12', '9', 'Ver reporte de movimientos'), ('13', '10', 'Consulta de registros'), ('14', '10', 'Gestionar licencias'), ('15', '10', 'Gestionar bajas'), ('16', '11', 'Ver reporte de encuestas'), ('18', '13', 'Ver calendario'), ('19', '13', 'Modificar calendario'), ('20', '14', 'Ver puestos'), ('21', '14', 'Gestionar puestos'), ('22', '15', 'Ver dependencias'), ('23', '15', 'Gestionar dependencias'), ('24', '16', 'Ver fracciones'), ('25', '16', 'Gestionar fracciones'), ('26', '17', 'Gestionar usuarios de sistema'), ('27', '18', 'Gestionar perfiles y permisos'), ('29', '10', 'Reasignación de claves'), ('35', '32', 'Gestionar prórrogas'), ('36', '10', 'Gestionar promociones'), ('37', '10', 'Realizar correcciones'), ('38', '10', 'Validar correcciones'), ('44', '31', 'Atender consultas vía chat'), ('46', '23', 'Ver casos omisos'), ('48', '24', 'Iniciar procedimientos'), ('49', '24', 'Ver procedimientos'), ('50', '25', 'Ver oficios asignados'), ('51', '27', 'Gestionar registros de verificación'), ('52', '27', 'Ver verificaciones asignadas'), ('54', '29', 'Configurar opciones del sistema'), ('55', '30', 'Enviar mensajes internos'), ('56', '10', 'Desactivar registros del padrón'), ('57', '25', 'Crear Oficios'), ('58', '27', 'Consultar información general y declaraciones desde inicio'), ('59', '30', 'Crear notificaciones'), ('60', '33', 'Verificar alertas del sistema'), ('61', '34', 'Consultar detalles de declaraciones'), ('62', '35', 'Ver reporte de cumplimiento'), ('63', '36', 'Ver reporte de obligados'), ('64', '37', 'Gestionar acuerdos declaración pública'), ('65', '27', 'Ver reporte de verificaciones');
COMMIT;

-- ----------------------------
--  Table structure for `procedimientos`
-- ----------------------------
DROP TABLE IF EXISTS `procedimientos`;
CREATE TABLE `procedimientos` (
  `ID_Proc` bigint(11) NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `Fecha_Proc` datetime NOT NULL,
  `Tipo_Proc` tinyint(4) NOT NULL,
  `ID_Verif` bigint(20) DEFAULT NULL,
  `Omision` varchar(10) DEFAULT NULL,
  `PRA` text,
  `Fecha_PRA` date DEFAULT NULL,
  `Bloqueado` bit(1) DEFAULT NULL,
  `ID_User` int(11) DEFAULT NULL,
  `Activo` bit(1) NOT NULL,
  PRIMARY KEY (`ID_Proc`),
  UNIQUE KEY `ID` (`ID_Proc`),
  KEY `Serv` (`ID_Serv`),
  KEY `Fecha` (`Fecha_Proc`),
  KEY `Tipo` (`Tipo_Proc`),
  KEY `Activo` (`Activo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `prorrogas`
-- ----------------------------
DROP TABLE IF EXISTS `prorrogas`;
CREATE TABLE `prorrogas` (
  `ID_Prorroga` int(11) NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `Fecha_Solicitud` datetime NOT NULL,
  `Fecha_Pro` date NOT NULL,
  `Motivo` text NOT NULL,
  `Ruta_Doc` text NOT NULL,
  `Fecha_Aut` date DEFAULT NULL,
  `Respuesta` text,
  `Estatus` tinyint(4) NOT NULL,
  `Terminado` bit(1) NOT NULL,
  PRIMARY KEY (`ID_Prorroga`),
  UNIQUE KEY `ID` (`ID_Prorroga`),
  KEY `Serv` (`ID_Serv`),
  KEY `Aut` (`Fecha_Aut`),
  KEY `Estatus` (`Estatus`),
  KEY `Term` (`Terminado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `publicaciones`
-- ----------------------------
DROP TABLE IF EXISTS `publicaciones`;
CREATE TABLE `publicaciones` (
  `ID_Public` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Serv` bigint(20) NOT NULL,
  `Fecha_Publica` datetime NOT NULL,
  `Fecha_Oculta` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_Public`),
  KEY `ID_Serv` (`ID_Serv`),
  KEY `Fecha` (`Fecha_Oculta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `puestos`
-- ----------------------------
DROP TABLE IF EXISTS `puestos`;
CREATE TABLE `puestos` (
  `ID_Puesto` int(11) NOT NULL,
  `Puesto` text NOT NULL,
  `Activo` bit(1) NOT NULL,
  PRIMARY KEY (`ID_Puesto`),
  UNIQUE KEY `ID` (`ID_Puesto`),
  KEY `Activo` (`Activo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `reactivos`
-- ----------------------------
DROP TABLE IF EXISTS `reactivos`;
CREATE TABLE `reactivos` (
  `ID_Reactivo` int(11) NOT NULL,
  `Reactivo` text NOT NULL,
  `Opciones` text,
  `Activo` bit(1) NOT NULL,
  PRIMARY KEY (`ID_Reactivo`),
  UNIQUE KEY `ID` (`ID_Reactivo`),
  KEY `Activo` (`Activo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `seguimiento`
-- ----------------------------
DROP TABLE IF EXISTS `seguimiento`;
CREATE TABLE `seguimiento` (
  `ID_Seg` bigint(20) NOT NULL,
  `ID_Verificacion` bigint(20) NOT NULL,
  `ID_Trans` bigint(20) NOT NULL,
  `ID_User` int(11) NOT NULL,
  `Estatus` tinyint(4) NOT NULL,
  `Verificacion` text,
  `Observaciones` text,
  `Fecha_Seg` datetime NOT NULL,
  PRIMARY KEY (`ID_Seg`),
  UNIQUE KEY `ID` (`ID_Seg`),
  KEY `Ver` (`ID_Verificacion`),
  KEY `Trans` (`ID_Trans`),
  KEY `User` (`ID_User`),
  KEY `Estatus` (`Estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `serv_ex`
-- ----------------------------
DROP TABLE IF EXISTS `serv_ex`;
CREATE TABLE `serv_ex` (
  `ID_Ex` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_Serv` bigint(20) NOT NULL,
  `Fecha` datetime NOT NULL,
  `ID_User` int(11) NOT NULL,
  `Opcion` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_Ex`),
  KEY `Serv` (`ID_Serv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `servpub`
-- ----------------------------
DROP TABLE IF EXISTS `servpub`;
CREATE TABLE `servpub` (
  `ID_Serv` bigint(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Paterno` text NOT NULL,
  `Materno` text NOT NULL,
  `RFC` varchar(13) DEFAULT NULL,
  `ID_Dependencia` int(11) DEFAULT NULL,
  `ID_Puesto` int(11) DEFAULT NULL,
  `Cargo_Funcional` text,
  `Contratacion` varchar(20) DEFAULT NULL,
  `ART64` text,
  `AG172` varchar(50) DEFAULT NULL,
  `Area` text,
  `Nivel` int(11) DEFAULT NULL,
  `Tel_Trabajo` text,
  `Per_Mensual` varchar(50) DEFAULT NULL,
  `Calle_Trabajo` text,
  `Num_Trabajo` text,
  `Col_Trabajo` text,
  `CP_Trabajo` text,
  `Ciudad_Trabajo` text,
  `Fecha_Inicio` date DEFAULT NULL,
  `Fecha_Termino` date DEFAULT NULL,
  `Fecha_Captura` datetime DEFAULT NULL,
  `Correo` text,
  `Correo2` text,
  `Password` text,
  `Clave_Nueva` bit(1) NOT NULL,
  `Estatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID_Serv`),
  UNIQUE KEY `ID` (`ID_Serv`),
  KEY `RFC` (`RFC`),
  KEY `Dep` (`ID_Dependencia`),
  KEY `Pos` (`ID_Puesto`),
  KEY `Estatus` (`Estatus`),
  KEY `Key` (`Clave_Nueva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `temporal`
-- ----------------------------
DROP TABLE IF EXISTS `temporal`;
CREATE TABLE `temporal` (
  `ID_Temp` int(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Paterno` text NOT NULL,
  `Materno` text NOT NULL,
  `RFC` text NOT NULL,
  `ID_Dependencia` int(11) NOT NULL,
  `ID_Puesto` int(11) NOT NULL,
  `Cargo_Funcional` text NOT NULL,
  `Contratacion` varchar(50) NOT NULL,
  `AG172` varchar(20) NOT NULL,
  `Nivel` int(11) NOT NULL,
  `Area` text NOT NULL,
  `Calle_Trabajo` text NOT NULL,
  `Num_Trabajo` text NOT NULL,
  `Col_Trabajo` text NOT NULL,
  `CP_Trabajo` text NOT NULL,
  `Ciudad_Trabajo` text NOT NULL,
  `Tel_Trabajo` text NOT NULL,
  `Per_Mensual` varchar(50) NOT NULL,
  `Fecha_inicio` date NOT NULL,
  PRIMARY KEY (`ID_Temp`),
  UNIQUE KEY `ID` (`ID_Temp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `tipo_ingresos`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_ingresos`;
CREATE TABLE `tipo_ingresos` (
  `ID_Tipo` int(11) NOT NULL,
  `Tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `tipo_ingresos`
-- ----------------------------
BEGIN;
INSERT INTO `tipo_ingresos` VALUES ('1', 'Sueldos'), ('2', 'Actividad Empresarial'), ('3', 'Servicios Profesionales'), ('4', 'Arrendamiento'), ('5', 'Otros');
COMMIT;

-- ----------------------------
--  Table structure for `tipo_mov`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_mov`;
CREATE TABLE `tipo_mov` (
  `ID_Tipo` int(11) NOT NULL,
  `Movimiento` text NOT NULL,
  PRIMARY KEY (`ID_Tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `tipo_mov`
-- ----------------------------
BEGIN;
INSERT INTO `tipo_mov` VALUES ('1', 'ALTA'), ('2', 'BAJA'), ('3', 'PROMOCION'), ('4', 'LICENCIA'), ('5', 'DESACTIVACIÓN');
COMMIT;

-- ----------------------------
--  Table structure for `tipo_trans`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_trans`;
CREATE TABLE `tipo_trans` (
  `ID_Tipo` tinyint(4) NOT NULL DEFAULT '0',
  `Tipo` text NOT NULL,
  PRIMARY KEY (`ID_Tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `tipo_trans`
-- ----------------------------
BEGIN;
INSERT INTO `tipo_trans` VALUES ('1', 'Compra/Adquisicion'), ('2', 'Venta/Abono'), ('3', 'Donacion (Positiva)'), ('4', 'Donacion (Negativa)'), ('5', 'Perdida material'), ('6', 'Separación familiar'), ('7', 'Pagar/Liquidar saldo'), ('8', 'Retiro/Finiquitar inversion'), ('9', 'Cancelar venta'), ('10', 'Deposito en inversion'), ('11', 'Ingresos extras'), ('12', 'Actualización'), ('13', 'Descartar registro'), ('14', 'Validar registro'), ('15', 'CESIÓN'), ('16', 'HERENCIA'), ('17', 'PERMUTA'), ('18', 'RIFA'), ('19', 'TRANSPASO');
COMMIT;

-- ----------------------------
--  Table structure for `tipos_rubros`
-- ----------------------------
DROP TABLE IF EXISTS `tipos_rubros`;
CREATE TABLE `tipos_rubros` (
  `ID` int(11) NOT NULL,
  `Rubro` text NOT NULL,
  `Tipo` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `tipos_rubros`
-- ----------------------------
BEGIN;
INSERT INTO `tipos_rubros` VALUES ('1', 'Dependientes', 'CONYUGE'), ('2', 'Depenidnetes', 'HIJO'), ('3', 'Dependientes', 'HERMANO'), ('4', 'Dependientes', 'PADRE'), ('5', 'Dependientes', 'MADRE'), ('6', 'Dependientes', 'OTRO'), ('7', 'Inmuebles', 'CASA HABITACION'), ('8', 'Inmuebles', 'TERRENO'), ('9', 'Inmuebles', 'DEPARTAMENTO'), ('10', 'Inmuebles', 'LOCAL COMERCIAL'), ('11', 'Inmuebles', 'OTRO'), ('12', 'Muebles', 'MUEBLES CASA'), ('13', 'Muebles', 'LINEA BLANCA'), ('14', 'Muebles', 'ELECTRONICA'), ('15', 'Muebles', 'COMPUTO'), ('16', 'Muebles', 'JOYAS/ARTE'), ('17', 'Muebles', 'OFICINA'), ('18', 'Muebles', 'OTRO'), ('19', 'Vehiculos', 'AUTOMOVIL'), ('20', 'Vehiculos', 'MOTOCICLETA'), ('21', 'Vehiculos', 'MAQUINARIA'), ('22', 'Vehiculos', 'OTRO'), ('23', 'Inversiones', 'AHORRO EN CASA'), ('24', 'Inversiones', 'BANCARIA'), ('25', 'Inversiones', 'INSTITUCION'), ('26', 'Inversiones', 'PRESTAMO'), ('27', 'Inversiones', 'NEGOCIO'), ('28', 'Inversiones', 'OTRO'), ('29', 'Adeudos', 'HIPOTECARIO'), ('30', 'Adeudos', 'INSTITUCION'), ('31', 'Adeudos', 'AUTOFINANCIAMIENTO'), ('32', 'Adeudos', 'PARTICULAR'), ('33', 'Adeudos', 'TARJETA');
COMMIT;

-- ----------------------------
--  Table structure for `user_profile`
-- ----------------------------
DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE `user_profile` (
  `ID_Pro` int(11) NOT NULL,
  `ID_Perfil` int(11) NOT NULL,
  `ID_User` int(11) NOT NULL,
  PRIMARY KEY (`ID_Pro`),
  UNIQUE KEY `ID` (`ID_Pro`),
  KEY `User` (`ID_User`),
  KEY `Pro` (`ID_Perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `user_profile`
-- ----------------------------
BEGIN;
INSERT INTO `user_profile` VALUES ('5', '1', '1'), ('14', '2', '1'), ('15', '3', '1');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `ID_User` int(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Paterno` text NOT NULL,
  `Materno` text NOT NULL,
  `User` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Old` text,
  `Fecha_Clave` date DEFAULT NULL,
  `Fecha_Alta` date NOT NULL,
  `Tipo` varchar(10) NOT NULL,
  `ID_Dependencia` int(11) DEFAULT NULL,
  `Fecha_Baja` date DEFAULT NULL,
  PRIMARY KEY (`ID_User`),
  UNIQUE KEY `ID` (`ID_User`),
  KEY `User` (`User`),
  KEY `Pwd` (`Password`),
  KEY `Baja` (`Fecha_Baja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'Admin', 'General', '', 'declaranet@guanajuato.gob.mx', 'b15c36fc67d7a73eb38932efd92ee9a77f9330c9', null, null, '2013-07-18', 'GLOBAL', '1', null);
COMMIT;

-- ----------------------------
--  Table structure for `verificacion`
-- ----------------------------
DROP TABLE IF EXISTS `verificacion`;
CREATE TABLE `verificacion` (
  `ID_Verificacion` bigint(20) NOT NULL,
  `Fecha_Inclusion` date NOT NULL,
  `ID_Serv` bigint(20) NOT NULL,
  `ID_User` int(11) NOT NULL,
  `ID_Resp` int(11) DEFAULT NULL,
  `General` tinyint(4) NOT NULL,
  `Fecha_Cierre` date DEFAULT NULL,
  `Since` bigint(20) NOT NULL,
  `Until` bigint(20) NOT NULL,
  PRIMARY KEY (`ID_Verificacion`),
  UNIQUE KEY `ID` (`ID_Verificacion`),
  KEY `Serv` (`ID_Serv`),
  KEY `Since` (`Since`),
  KEY `Until` (`Until`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `verificacion_obs`
-- ----------------------------
DROP TABLE IF EXISTS `verificacion_obs`;
CREATE TABLE `verificacion_obs` (
  `ID_Obs` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Obs` varchar(50) DEFAULT NULL,
  `ID_Verif` int(11) DEFAULT NULL,
  `Fecha_Obs` datetime DEFAULT NULL,
  `Observacion` text,
  PRIMARY KEY (`ID_Obs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Procedure structure for `applyDec`
-- ----------------------------
DROP PROCEDURE IF EXISTS `applyDec`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `applyDec`(IN serv BIGINT, IN dl BIGINT)
BEGIN
	update dtransacciones set ID_Dec = dl 
	where ID_Dec is null and Tipo_Elem = 'adeudos' and ID_Elem in 
	(select ID_Adeudo from dadeudos where ID_Serv = serv);
	
	update dtransacciones set ID_Dec = dl 
	where ID_Dec is null and Tipo_Elem = 'inversiones' and ID_Elem in 
	(select ID_Inversion from dinversiones where ID_Serv = serv);

	update dtransacciones set ID_Dec = dl 
	where ID_Dec is null and Tipo_Elem = 'inmuebles' and ID_Elem in 
	(select ID_Inmueble from dinmuebles where ID_Serv = serv);

	update dtransacciones set ID_Dec = dl 
	where ID_Dec is null and Tipo_Elem = 'muebles' and ID_Elem in 
	(select ID_Mueble from dmuebles where ID_Serv = serv);

	update dtransacciones set ID_Dec = dl 
	where ID_Dec is null and Tipo_Elem = 'vehiculos' and ID_Elem in 
	(select ID_Vehiculo from dvehiculos where ID_Serv = serv);

	update dtransacciones set ID_Dec = dl 
	where ID_Dec is null and Tipo_Elem = 'dependientes' and ID_Elem in 
	(select ID_Depend from ddependientes where ID_Serv = serv);

	update dadeudos set Estatus = 1 where Estatus = 0 and ID_Serv = serv;
	update dadeudos set Estatus = -2 where Estatus = 4 and ID_Serv = serv;

	update dinversiones set Estatus = 1 where Estatus = 0 and ID_Serv = serv;
	update dinversiones set Estatus = -2 where Estatus = 4 and ID_Serv = serv;

	update dinmuebles set Estatus = 1 where Estatus = 0 and ID_Serv = serv;
	
	update dmuebles set Estatus = 1 where Estatus = 0 and ID_Serv = serv;

	update dvehiculos set Estatus = 1 where Estatus = 0 and ID_Serv = serv;

	update ddependientes set Estatus = 1 where Estatus = 0 and ID_Serv = serv;

	update prorrogas set Terminado = 1 where ID_Serv = serv and Terminado = 0;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `Balance`
-- ----------------------------
DROP PROCEDURE IF EXISTS `Balance`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Balance`(IN dl BIGINT)
BEGIN
	declare sueldo float;
	declare honorarios float; 
	declare ing_otros float; 
	declare ing_conyuge float;
	declare ing_depend float;
	declare pensiones float;
	declare ad_inmuebles float;
	declare ad_inmuebles_con float;
	declare ad_inmuebles_dep float;
	declare en_inmuebles float;
	declare en_inmuebles_con float;
	declare en_inmuebles_dep float;
	declare ad_vehiculos float;
	declare ad_vehiculos_con float;
	declare ad_vehiculos_dep float;
	declare en_vehiculos float;
	declare en_vehiculos_con float;
	declare en_vehiculos_dep float;
	declare ad_muebles float;
	declare ad_muebles_con float;
	declare ad_muebles_dep float;
	declare en_muebles float;
	declare en_muebles_con float;
	declare en_muebles_dep float;
	declare inversiones float;
	declare inversiones_con float;
	declare inversiones_dep float;
	declare adeudos float;
	declare adeudos_con float;
	declare adeudos_dep float;
	declare depositos float;
	declare depositos_con float;
	declare depositos_dep float;
	declare pagos float;
	declare pagos_con float;
	declare pagos_dep float;
	declare ventas_in float;
	declare ventas_mue float;
	declare ventas_veh float;
	declare ventas_in_con float;
	declare ventas_mue_con float;
	declare ventas_veh_con float;
	declare ventas_in_dep float;
	declare ventas_mue_dep float;
	declare ventas_veh_dep float;
	declare retiros float;
	declare retiros_con float;
	declare retiros_dep float;
	declare plus_inmuebles float;
	declare plus_muebles float;
	declare plus_vehiculos float;
	declare minus_inmuebles float;
	declare minus_muebles float;
	declare minus_vehiculos float;
	declare haveCon int;
	declare haveDep int;
	declare type text;

### Obtiene tipo de declaracion ############################################################
	select Tipo_Dec into type from declaraciones where ID_Dec = dl;

### Determina si tiene conyuge o dependientes ############################################################
	select COUNT(ID_Depend) into haveCon from ddependientes d 
	join dtransacciones t on t.ID_Elem = d.ID_Depend and Tipo_Elem = 'dependientes'
	where ID_Dec = dl and d.Estatus >= 0 and Tipo_Depend = 'CONYUGE';

	select COUNT(ID_Depend) into haveDep from ddependientes d 
	join dtransacciones t on t.ID_Elem = d.ID_Depend and Tipo_Elem = 'dependientes'
	where ID_Dec = dl and d.Estatus >= 0 and Tipo_Depend <> 'CONYUGE';

### Ingresos del declarante ############################################################
	select IFNULL(SUM(Importe), 0) into sueldo from dtransacciones t 
	join dingresos i on i.ID_Ingreso = t.ID_Elem  and Tipo_Elem = 'ingresos' 
	where ID_Dec = dl and Tipo_Ing = 1;

	select IFNULL(SUM(Importe), 0) into honorarios from dtransacciones t 
	join dingresos i on i.ID_Ingreso = t.ID_Elem  and Tipo_Elem = 'ingresos' 
	where ID_Dec = dl and Tipo_Ing in (2, 3);
	
	select IFNULL(SUM(Importe), 0) into ing_otros from dtransacciones t 
	join dingresos i on i.ID_Ingreso = t.ID_Elem  and Tipo_Elem = 'ingresos' 
	where ID_Dec = dl and Tipo_ing in (4, 5);

### Ingresos del conyuge ############################################################
	select IFNULL(SUM(Importe), 0) into ing_conyuge from dtransacciones t 
	join ddependientes d on d.ID_Depend = t.ID_Elem and Tipo_Elem = 'dependientes'
	where ID_Dec = dl and Tipo_Trans = 11 and Tipo_Depend = 'CONYUGE';

### Ingresos de otros ##############################################################
	select IFNULL(SUM(Importe), 0) into ing_depend from dtransacciones t 
	join ddependientes d on d.ID_Depend = t.ID_Elem and Tipo_Elem = 'dependientes'
	where ID_Dec = dl and Tipo_Trans = 11 and Tipo_Depend <> 'CONYUGE';

### Pensiones pagadas ##############################################################
	select IFNULL(SUM(Importe), 0) into pensiones from dtransacciones where Tipo_Elem = 'pensiones' and ID_Dec = dl;
	
### Adquisicion de inmuebles ############################################################
### Declarante
	select IFNULL(SUM(Importe), 0) into ad_inmuebles from dtransacciones t 
	join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'
	where ID_Dec = dl and Titular_In is null and Tipo_Trans = 1 and Forma_Trans = 'CONTADO';
### Conyuge 
	IF(haveCon > 0) THEN
		select IFNULL(SUM(Importe), 0) into ad_inmuebles_con from dtransacciones t 
		join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'
		join ddependientes d on d.ID_Depend = i.Titular_In and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 1 and Forma_Trans = 'CONTADO';
	ELSE
		set ad_inmuebles_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN
		select IFNULL(SUM(Importe), 0) into ad_inmuebles_dep from dtransacciones t 
		join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'
		join ddependientes d on d.ID_Depend = i.Titular_In and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 1 and Forma_Trans = 'CONTADO';
	ELSE
		set ad_inmuebles_dep = 0;
	END IF;

### Enajenacion de inmuebles ############################################################
### Declarante
	select IFNULL(SUM(Importe), 0) into en_inmuebles from dtransacciones t 
	join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'
	where ID_Dec = dl and Titular_In is null and Tipo_Trans = 2 and Forma_Trans <> 'CREDITO';
### Conyuge
	IF(haveCon > 0) THEN
		select IFNULL(SUM(Importe), 0) into en_inmuebles_con from dtransacciones t 
		join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'
		join ddependientes d on d.ID_Depend = i.Titular_In and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans <> 'CREDITO';
	ELSE
		set en_inmuebles_con = 0;
	END IF;
### Dependientes
	IF(haveDep > 0) THEN
		select IFNULL(SUM(Importe), 0) into en_inmuebles_dep from dtransacciones t 
		join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'
		join ddependientes d on d.ID_Depend = i.Titular_In and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans <> 'CREDITO';
	ELSE
		set en_inmuebles_dep = 0;
	END IF;

### Adquisicion de vehiculos ###########################################################
### Declarante
	select IFNULL(SUM(Importe), 0) into ad_vehiculos from dtransacciones t 
	join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
	where ID_Dec = dl and Titular_Veh is null and Tipo_Trans = 1 and Forma_Trans = 'CONTADO';
### Conyuge 
	IF(haveCon > 0) THEN
		select IFNULL(SUM(Importe), 0) into ad_vehiculos_con from dtransacciones t 
		join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
		join ddependientes d on d.ID_Depend = v.Titular_Veh and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 1 and Forma_Trans = 'CONTADO';
	ELSE
		set ad_vehiculos_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN
		select IFNULL(SUM(Importe), 0) into ad_vehiculos_dep from dtransacciones t 
		join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
		join ddependientes d on d.ID_Depend = v.Titular_Veh and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 1 and Forma_Trans = 'CONTADO';
	ELSE
		set ad_vehiculos_dep = 0;
	END IF;

### Enajenacion de vehiculos ############################################################
### Declarante
	select IFNULL(SUM(Importe), 0) into en_vehiculos from dtransacciones t 
	join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
	where ID_Dec = dl and Titular_Veh is null and Tipo_Trans = 2 and Forma_Trans <> 'CREDITO';
### Conyuge 
	IF(haveCon > 0) THEN
		select IFNULL(SUM(Importe), 0) into en_vehiculos_con from dtransacciones t 
		join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
		join ddependientes d on d.ID_Depend = v.Titular_Veh and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans <> 'CREDITO';
	ELSE
		set en_vehiculos_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN
		select IFNULL(SUM(Importe), 0) into en_vehiculos_dep from dtransacciones t 
		join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
		join ddependientes d on d.ID_Depend = v.Titular_Veh and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans <> 'CREDITO';
	ELSE
		set en_vehiculos_dep = 0;
	END IF;

### Adquisicion de muebles ###########################################################
### Declarante
	select IFNULL(SUM(Importe), 0) into ad_muebles from dtransacciones t 
	join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
	where ID_Dec = dl and Titular_Mue is null and Tipo_Trans = 1 and Forma_Trans = 'CONTADO';
### Conyuge 
	IF(haveCon > 0) THEN
		select IFNULL(SUM(Importe), 0) into ad_muebles_con from dtransacciones t 
		join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
		join ddependientes d on d.ID_Depend = m.Titular_Mue and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 1 and Forma_Trans = 'CONTADO';
	ELSE
		set ad_muebles_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN
		select IFNULL(SUM(Importe), 0) into ad_muebles_dep from dtransacciones t 
		join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
		join ddependientes d on d.ID_Depend = m.Titular_Mue and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 1 and Forma_Trans = 'CONTADO';
	ELSE
		set ad_muebles_dep = 0;
	END IF;

### Enajenacion de muebles #############################################################
### Declarante 
	select IFNULL(SUM(Importe), 0) into en_muebles from dtransacciones t 
	join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
	where ID_Dec = dl and Titular_Mue is null and Tipo_Trans = 2 and Forma_Trans <> 'CREDITO';
### Conyuge 
	IF(haveCon > 0) THEN
		select IFNULL(SUM(Importe), 0) into en_muebles_con from dtransacciones t 
		join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
		join ddependientes d on d.ID_Depend = m.Titular_Mue and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans <> 'CREDITO';
	ELSE
		set en_muebles_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN
		select IFNULL(SUM(Importe), 0) into en_muebles_dep from dtransacciones t 
		join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
		join ddependientes d on d.ID_Depend = m.Titular_Mue and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans <> 'CREDITO';
	ELSE
		set en_muebles_dep = 0;
	END IF;

### Adquisicion de inversiones ####################################################
### Declarante 
	select IFNULL(SUM(Saldo), 0) into inversiones from dtransacciones t 
	join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
	where ID_Dec = dl and Titular_Inv is null and IF(type = 'INICIAL', Tipo_Trans = 1, Tipo_Trans = 10);
### Conyuge 
	IF(haveCon > 0) THEN
		select IFNULL(SUM(Saldo), 0) into inversiones_con from dtransacciones t 
		join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
		join ddependientes d on d.ID_Depend = i.Titular_Inv and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and IF(type = 'INICIAL', Tipo_Trans = 1, Tipo_Trans = 10);
	ELSE
		set inversiones_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN
		select IFNULL(SUM(Saldo), 0) into inversiones_dep from dtransacciones t 
		join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
		join ddependientes d on d.ID_Depend = i.Titular_Inv and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and IF(type = 'INICIAL', Tipo_Trans = 1, Tipo_Trans = 10);
	ELSE
		set inversiones_dep = 0;
	END IF;

### Adquisicion de adeudos #########################################################
### Declarante
	select IFNULL(SUM(Saldo), 0) into adeudos from dtransacciones t 
	join dadeudos a on a.ID_Adeudo = t.ID_Elem and Tipo_Elem = 'adeudos'
	where ID_Dec = dl and Titular_Ad is null and IF(type = 'INICIAL', Tipo_Trans = 1, Tipo_Trans = 7);
### Conyuge 
	IF(haveCon > 0) THEN 
		select IFNULL(SUM(Saldo), 0) into adeudos_con from dtransacciones t 
		join dadeudos a on a.ID_Adeudo = t.ID_Elem and Tipo_Elem = 'adeudos'
		join ddependientes d on d.ID_Depend = a.Titular_Ad and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and IF(type = 'INICIAL', Tipo_Trans = 1, Tipo_Trans = 7);
	ELSE
		set adeudos_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN 
		select IFNULL(SUM(Saldo), 0) into adeudos_dep from dtransacciones t 
		join dadeudos a on a.ID_Adeudo = t.ID_Elem and Tipo_Elem = 'adeudos'
		join ddependientes d on d.ID_Depend = a.Titular_Ad and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and IF(type = 'INICIAL', Tipo_Trans = 1, Tipo_Trans = 7);
	ELSE
		set adeudos_dep = 0;
	END IF;

### Depositos en inversiones ##################################################
### Declarante
	select IFNULL(SUM(Importe), 0) into depositos from dtransacciones t 
	join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
	where ID_Dec = dl and Titular_Inv is null and Tipo_Trans = 10;
### Conyuge
	IF(haveCon > 0) THEN 
		select IFNULL(SUM(Importe), 0) into depositos_con from dtransacciones t 
		join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
		join ddependientes d on d.ID_Depend = i.Titular_Inv and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 10;
	ELSE
		set depositos_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN 
		select IFNULL(SUM(Importe), 0) into depositos_dep from dtransacciones t 
		join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
		join ddependientes d on d.ID_Depend = i.Titular_Inv and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 10;
	ELSE
		set depositos_dep = 0;
	END IF;

### Pago de adeudos ########################################################
### Declarante
	select IFNULL(SUM(Importe), 0) into pagos from dtransacciones t 
	join dadeudos a on a.ID_Adeudo = t.ID_Elem and Tipo_Elem = 'adeudos'
	where ID_Dec = dl and Titular_Ad is null and Tipo_Trans = 7;
### Conyuge 
	IF(haveCon > 0) THEN 
		select IFNULL(SUM(Importe), 0) into pagos_con from dtransacciones t 
		join dadeudos a on a.ID_Adeudo = t.ID_Elem and Tipo_Elem = 'adeudos'
		join ddependientes d on d.ID_Depend = a.Titular_Ad and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl  and Tipo_Trans = 7;
	ELSE
		set pagos_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN 
		select IFNULL(SUM(Importe), 0) into pagos_dep from dtransacciones t 
		join dadeudos a on a.ID_Adeudo = t.ID_Elem and Tipo_Elem = 'adeudos'
		join ddependientes d on d.ID_Depend = a.Titular_Ad and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl  and Tipo_Trans = 7;
	ELSE
		set pagos_dep = 0;
	END IF;
	
### Venta de bienes ########################################################
### Declarante
	select IFNULL(SUM(Importe), 0) into ventas_in from dtransacciones t 
	join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'
	where ID_Dec = dl and Titular_In is null and Tipo_Trans = 2 and Forma_Trans is null;
	
	select IFNULL(SUM(Importe), 0) into ventas_mue from dtransacciones t 
	join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
	where ID_Dec = dl and Titular_Mue is null and Tipo_Trans = 2 and Forma_Trans is null;

	select IFNULL(SUM(Importe), 0) into ventas_veh from dtransacciones t 
	join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
	where ID_Dec = dl and Titular_Veh is null and Tipo_Trans = 2 and Forma_Trans is null;
### Conyuge 
	IF(haveCon > 0) THEN
		select IFNULL(SUM(Importe), 0) into ventas_in_con from dtransacciones t 
		join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'	
		join ddependientes d on d.ID_Depend = i.Titular_In and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans is null;
		
		select IFNULL(SUM(Importe), 0) into ventas_mue_con from dtransacciones t 
		join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
		join ddependientes d on d.ID_Depend = m.Titular_Mue and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans is null;

		select IFNULL(SUM(Importe), 0) into ventas_veh_con from dtransacciones t 
		join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
		join ddependientes d on d.ID_Depend = v.Titular_Veh and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans is null;
	ELSE
		set ventas_in_con = 0;
		set ventas_mue_con = 0;
		set ventas_veh_con = 0;
	END IF;
### Dependientes 
	IF(haveDep > 0) THEN
		select IFNULL(SUM(Importe), 0) into ventas_in_dep from dtransacciones t 
		join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'	
		join ddependientes d on d.ID_Depend = i.Titular_In and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans is null;
		
		select IFNULL(SUM(Importe), 0) into ventas_mue_dep from dtransacciones t 
		join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
		join ddependientes d on d.ID_Depend = m.Titular_Mue and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans is null;

		select IFNULL(SUM(Importe), 0) into ventas_veh_dep from dtransacciones t 
		join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
		join ddependientes d on d.ID_Depend = v.Titular_Veh and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 2 and Forma_Trans is null;
	ELSE
		set ventas_in_dep = 0;
		set ventas_mue_dep = 0;
		set ventas_veh_dep = 0;
	END IF;

### Retiros de inversiones #################################################
### Declarante
	select IFNULL(SUM(Importe), 0) into retiros from dtransacciones t 
	join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
	where ID_Dec = dl and Titular_Inv is null and Tipo_Trans = 8;
## Conyuge
	IF(haveCon > 0) THEN 
		select IFNULL(SUM(Importe), 0) into retiros_con from dtransacciones t 
		join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
		join ddependientes d on d.ID_Depend = Titular_Inv and Tipo_Depend = 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 8;
	ELSE
		set retiros_con = 0;
	END IF;
### Dependientes
	IF(haveDep > 0) THEN 
		select IFNULL(SUM(Importe), 0) into retiros_dep from dtransacciones t 
		join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
		join ddependientes d on d.ID_Depend = Titular_Inv and Tipo_Depend <> 'CONYUGE'
		where ID_Dec = dl and Tipo_Trans = 8;
	ELSE
		set retiros_dep = 0;
	END IF;

### Donaciones ##################################################################
	select IFNULL(SUM(Importe), 0) into plus_inmuebles from dtransacciones 
	where ID_Dec = dl and Tipo_Trans = 3 and Tipo_Elem = 'inmuebles';

	select IFNULL(SUM(Importe), 0) into plus_muebles from dtransacciones 
	where ID_Dec = dl and Tipo_Trans = 3 and Tipo_Elem = 'muebles';

	select IFNULL(SUM(Importe), 0) into plus_vehiculos from dtransacciones 
	where ID_Dec = dl and Tipo_Trans = 3 and Tipo_Elem = 'vehiculos';

	select IFNULL(SUM(Importe), 0) into minus_inmuebles from dtransacciones 
	where ID_Dec = dl and Tipo_Trans = 4 and Tipo_Elem = 'inmuebles';

	select IFNULL(SUM(Importe), 0) into minus_muebles from dtransacciones 
	where ID_Dec = dl and Tipo_Trans = 4 and Tipo_Elem = 'muebles';

	select IFNULL(SUM(Importe), 0) into minus_vehiculos from dtransacciones 
	where ID_Dec = dl and Tipo_Trans = 4 and Tipo_Elem = 'vehiculos';

### Resultados ##################################################################
select sueldo, honorarios, (ing_otros + retiros + ventas_in + ventas_mue + ventas_veh) as otros, pensiones, 
	  (ing_conyuge + retiros_con + ventas_in_con + ventas_mue_con + ventas_veh_con) as conyuge, 
	  (ing_depend + retiros_dep + ventas_in_dep + ventas_mue_dep + ventas_veh_dep) as depend, 
	  ad_inmuebles, ad_muebles, ad_vehiculos, en_inmuebles, en_muebles, en_vehiculos,
	  ad_inmuebles_con, ad_muebles_con, ad_vehiculos_con, en_inmuebles_con, en_muebles_con, en_vehiculos_con, 
	  ad_inmuebles_dep, ad_muebles_dep, ad_vehiculos_dep, en_inmuebles_dep, en_muebles_dep, en_vehiculos_dep, 
	  (en_inmuebles - ad_inmuebles) as inmuebles, 
	  (en_inmuebles_con - ad_inmuebles_con) as inmuebles_con, 
	  (en_inmuebles_dep - ad_inmuebles_dep) as inmuebles_dep, 
	  (en_muebles - ad_muebles) as muebles, 
	  (en_muebles_con - ad_muebles_con) as muebles_con, 
	  (en_vehiculos - ad_vehiculos) as vehiculos, 
	  (en_vehiculos_con - ad_vehiculos_con) as vehiculos_con, 
	  (en_vehiculos_dep - ad_vehiculos_dep) as vehiculos_dep,
	  inversiones, inversiones_con, inversiones_dep, 
	  adeudos, adeudos_con, adeudos_dep, 
	  depositos, depositos_con, depositos_dep, 
	  pagos, pagos_con, pagos_dep, 
	  plus_inmuebles, plus_muebles, plus_vehiculos, 
	  minus_inmuebles, minus_muebles, minus_vehiculos;
	  
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `checkLicense`
-- ----------------------------
DROP PROCEDURE IF EXISTS `checkLicense`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkLicense`()
BEGIN
update servpub set Estatus = 1 where Estatus = 4 and ID_Serv in
(select ID_Serv from movimientos where Tipo_Mov = 4 and Termino is not null and Termino < NOW());
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `CountElem`
-- ----------------------------
DROP PROCEDURE IF EXISTS `CountElem`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `CountElem`(IN serv BIGINT)
BEGIN
	declare dep int;
	declare inm int;
	declare mue int;
	declare veh int; 
	declare inv int; 
	declare ade int; 

	select COUNT(ID_Depend) into dep from ddependientes where Estatus in (0, 1, 2, 3) and ID_Serv = serv; 
	select COUNT(ID_Mueble) into mue from dmuebles where Estatus in (0, 1, 2, 3) and ID_Serv = serv; 	
	select COUNT(ID_Vehiculo) into veh from dvehiculos where Estatus in (0, 1, 2, 3) and ID_Serv = serv; 
	select COUNT(ID_Inversion) into inv from dinversiones where Estatus in (0, 1, 2, 3) and ID_Serv = serv; 
	select COUNT(ID_Adeudo) into ade from dadeudos where Estatus in (0, 1, 2, 3) and ID_Serv = serv; 
	select COUNT(ID_Inmueble) into inm from dinmuebles where Estatus in (0, 1, 2, 3) and ID_Serv = serv;

	select dep, inm, mue, veh, inv, ade;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `EditEmail`
-- ----------------------------
DROP PROCEDURE IF EXISTS `EditEmail`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `EditEmail`(IN `in_Correo` varchar(255), IN in_Alter varchar(255), IN `in_ID_Serv` int)
BEGIN

	UPDATE `servpub` SET 

	Correo = in_Correo, 
	Correo2 = in_Alter 

	WHERE ID_Serv= in_ID_Serv;





END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `EditInfo`
-- ----------------------------
DROP PROCEDURE IF EXISTS `EditInfo`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `EditInfo`(IN `in_ID_Info` int,IN `in_ID_Serv` int,IN `in_Calle` text,IN `in_Colonia` text,IN `in_Numero` text,IN `in_Ciudad` text,IN `in_CP` varchar(255),IN `in_Telefono` varchar(255),IN `in_Civil` varchar(255),IN `in_CURP` varchar(255))
BEGIN

	UPDATE `infoserv` SET 

		Calle=in_Calle,

		Numero=in_Numero,

		Colonia=in_Colonia,

		ID_Ciudad=in_Ciudad,

		CP=in_CP,

		Telefono=in_Telefono,

		Civil=in_Civil,

		CURP=in_CURP

	WHERE ID_Info=in_ID_Info;

END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindAdeudos`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindAdeudos`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindAdeudos`(IN serv BIGINT)
select ID_Adeudo as ID, Tipo_Ad as Tipo, CONCAT_WS('|', Institucion_Ad, Cuenta_Ad) as Descripcion, Estatus, 
(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = t.ID_Dec) as Declared 
from dadeudos a 
join dtransacciones t on t.ID_Elem = a.ID_Adeudo and Tipo_Elem = 'adeudos' and Tipo_Trans in (1, 3)
where Estatus in (0, 1, 2, 3) and ID_Serv = serv
order by ID_Adeudo
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindAndRecover`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindAndRecover`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindAndRecover`(IN type text, IN search text)
BEGIN 
IF type = '#SP' THEN
	select CONCAT_WS(' ', Nombre, Paterno, Materno) as Nombre, Correo as Mail from servpub where RFC = CONVERT(search using utf8) collate utf8_spanish_ci and Estatus in (1, 2) order by ID_Serv DESC LIMIT 1;
ELSE
	select CONCAT_WS(' ', Nombre, Paterno, Materno) as Nombre, User as Mail from users where User = CONVERT(search using utf8) collate utf8_spanish_ci and Fecha_Baja is null; 
END IF;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindDeclaraciones`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindDeclaraciones`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindDeclaraciones`(IN `ui`bigint)
BEGIN
	SELECT ID_Dec, ID_Serv,ID_Info, Fecha_Dec, Tipo_Dec FROM declaraciones WHERE ID_Serv =ui  ORDER BY ID_Dec DESC;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindDeclaracionValida`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindDeclaracionValida`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindDeclaracionValida`(IN `IN_ID_Declaracion` bigint,IN `IN_ID_Serv` bigint)
BEGIN

SELECT ID_Dec FROM declaraciones WHERE ID_Dec=IN_ID_Declaracion AND ID_Serv=IN_ID_Serv;

END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindDependientes`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindDependientes`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindDependientes`(IN serv bigint)
select ID_Depend as ID, Tipo_Depend as Tipo, 
CONCAT_WS('|', Nombre_Depend, (select Ocupacion_Depend from depend_hist where ID_Depend = d.ID_Depend order by ID_Hist DESC LIMIT 1)) as Descripcion, Estatus, 
(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = t.ID_Dec) as Declared 
from ddependientes d 
join dtransacciones t on t.ID_Elem = d.ID_Depend and Tipo_Elem = 'dependientes' and Tipo_Trans in (1, 3)
where Estatus in (0, 1, 2, 3) and ID_Serv = serv
order by ID_Depend
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindEmail`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindEmail`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindEmail`(IN `ui` int)
BEGIN

	SELECT Correo, Correo2 FROM servpub WHERE ID_Serv =ui LIMIT 1 ;

END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindInfo`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindInfo`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindInfo`(IN `ui` int)
BEGIN

	SELECT * FROM infoserv WHERE ID_Serv =ui  ORDER BY ID_Info DESC LIMIT 1 ;

END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindInmuebles`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindInmuebles`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindInmuebles`(IN serv bigint)
select ID_Inmueble as ID, Tipo_In as Tipo, CONCAT_WS('|', Calle_In, Numero_In, Colonia_In, Ciudad_In) as Descripcion, Estatus, 
(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = t.ID_Dec) as Declared
from dinmuebles i 
join dtransacciones t on t.ID_Elem = i.ID_Inmueble and Tipo_Elem = 'inmuebles' and Tipo_Trans in (1, 3, 15, 16, 17, 18, 19)
where Estatus in (0, 1, 2, 3) and ID_Serv = serv
order by ID_Inmueble
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindInversiones`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindInversiones`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindInversiones`(IN serv BIGINT)
select ID_Inversion as ID, Tipo_Inv as Tipo, CONCAT_WS('|', Institucion_Inv, Cuenta_Inv) as Descripcion, Estatus,
(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = t.ID_Dec) as Declared 
from dinversiones i 
join dtransacciones t on t.ID_Elem = i.ID_Inversion and Tipo_Elem = 'inversiones' and Tipo_Trans in (1, 3)
where Estatus in (0, 1, 2, 3) and ID_Serv = serv
order by ID_Inversion
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindMensajes`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindMensajes`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindMensajes`(IN `IN_ID_Serv` int,IN `IN_Tipo` int,IN `IN_ID_Dependencia` int)
BEGIN

	SELECT MSG.ID_Mensaje, MSG.Leido, MSG.Alcance, MSG.Asunto, MSG.Fecha_Creacion, Fecha_Expiracion, MSG.Mensaje, MSG.Leido, CONCAT_WS(' ',US.Nombre,US.Paterno, US.Materno)as nombre 
	FROM mensajes MSG
	INNER JOIN users US ON US.ID_User=MSG.ID_Emisor
	WHERE ((MSG.Alcance IS NULL  AND ID_Receptor=IN_ID_Serv) 
			OR (MSG.Alcance ='UNICO' AND ID_Receptor=IN_ID_Serv)
			OR (MSG.Alcance ='DEPENDENCIA' AND ID_Receptor=IN_ID_Dependencia)
			OR (MSG.Alcance='GLOBAL')
			)
	AND MSG.Tipo=IN_Tipo
	AND (MSG.Fecha_Expiracion is NULL || MSG.Fecha_Expiracion >=NOW())
	ORDER BY MSG.Fecha_Creacion DESC;



END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindMuebles`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindMuebles`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindMuebles`(IN serv BIGINT)
select ID_Mueble as ID, Tipo_Mue as Tipo, Descripcion_Mue as Descripcion, Estatus, 
(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = t.ID_Dec) as Declared 
from dmuebles m 
join dtransacciones t on t.ID_Elem = m.ID_Mueble and Tipo_Elem = 'muebles' and Tipo_Trans in (1, 3)
where Estatus in (0, 1, 2, 3) and ID_Serv = serv
order by ID_Mueble
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindNotificaciones`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindNotificaciones`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindNotificaciones`(IN `IN_ID_Serv` int, IN `tipo` int)
BEGIN
	IF tipo=1 THEN
			SELECT MSG.ID_Mensaje, MSG.Alcance, MSG.Asunto, MSG.Mensaje, MSG.Leido, 
		DATE_FORMAT(MSG.Fecha_Creacion,'%d/%m/%Y')as Fecha_Creacion,
		DATE_FORMAT(MSG.Fecha_Expiracion,'%d/%m/%Y')as Fecha_Expiracion, MSG.ID_Emisor,
		CONCAT_WS(' ',US.Nombre, US.Paterno, US.Materno) as Creado,
		IFNULL(SERV.RFC,
		DEP.Dependencia) as Destino


		FROM mensajes MSG
		INNER JOIN users US on MSG.ID_Emisor=US.ID_User
		LEFT JOIN servpub SERV ON (MSG.ID_Receptor=SERV.ID_Serv AND MSG.Alcance='UNICO')
		LEFT JOIN dependencias DEP ON (MSG.ID_Emisor=DEP.ID_Dependencia AND MSG.Alcance='DEPENDENCIA')
		WHERE MSG.Tipo=2
		AND	MSG.Fecha_Expiracion < DATE(NOW());
	ELSE
			SELECT MSG.ID_Mensaje, MSG.Alcance, MSG.Asunto, MSG.Mensaje, MSG.Leido, 
		DATE_FORMAT(MSG.Fecha_Creacion,'%d/%m/%Y')as Fecha_Creacion,
		DATE_FORMAT(MSG.Fecha_Expiracion,'%d/%m/%Y')as Fecha_Expiracion, MSG.ID_Emisor,
		CONCAT_WS(' ',US.Nombre, US.Paterno, US.Materno) as Creado,
		IFNULL(SERV.RFC,
		DEP.Dependencia) as Destino


		FROM mensajes MSG
		INNER JOIN users US on MSG.ID_Emisor=US.ID_User
		LEFT JOIN servpub SERV ON (MSG.ID_Receptor=SERV.ID_Serv AND MSG.Alcance='UNICO')
		LEFT JOIN dependencias DEP ON (MSG.ID_Emisor=DEP.ID_Dependencia AND MSG.Alcance='DEPENDENCIA')
		WHERE MSG.Tipo=2
		AND	MSG.Fecha_Expiracion >= DATE(NOW());
	END IF;

END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `findServ`
-- ----------------------------
DROP PROCEDURE IF EXISTS `findServ`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `findServ`(IN search text, IN dep int)
select ID_Serv from servpub where RFC = CONVERT(search using utf8) collate utf8_spanish_ci and ID_Dependencia = dep and Estatus in (1, 4)
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindSurvey`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindSurvey`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindSurvey`(IN `IN_ID_Declaracion` int,IN `IN_ID_Serv` int)
BEGIN

	SELECT * FROM encuestas WHERE ID_Declaracion =IN_ID_Declaracion AND ID_Serv=IN_ID_Serv LIMIT 1 ;


END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `FindVehiculos`
-- ----------------------------
DROP PROCEDURE IF EXISTS `FindVehiculos`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `FindVehiculos`(IN serv BIGINT)
select ID_Vehiculo as ID, Tipo_Veh as Tipo, CONCAT_WS('|', Marca_Veh, Modelo_Veh, Anio_Veh) as Descripcion, Estatus, 
(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = t.ID_Dec) as Declared
from dvehiculos v 
join dtransacciones t on t.ID_Elem = v.ID_Vehiculo and Tipo_Elem = 'vehiculos' and Tipo_Trans in (1,3,15,16,17,18,19)
where Estatus in (0, 1, 2, 3) and ID_Serv = serv
order by ID_Vehiculo
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `getElementsByDec`
-- ----------------------------
DROP PROCEDURE IF EXISTS `getElementsByDec`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getElementsByDec`(IN dl BIGINT, IN type text)
    DETERMINISTIC
BEGIN
	declare conyuge float;
	declare dependientes float;
	
	CASE type 
	when 'inmuebles' then 
		select t.*, i.*, a.*, IFNULL(d.Tipo_Depend, 'ME') as Own, 
		(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = dl) as Declared,
		(select CONCAT_WS('|', Nombre_Depend, TIpo_Depend) from ddependientes where ID_Depend = Titular_In) as Titular,
		s.ID_Seg, s.ID_User, s.Estatus as StSeg, s.Verificacion, s.Observaciones as ObsSeg, s.Fecha_Seg, 
		CONCAT_WS(' ', u.Nombre, u.Paterno) as Resp
		from dtransacciones t 
		join dinmuebles i on i.ID_Inmueble = t.ID_Elem and Tipo_Elem = 'inmuebles'
		left join dadeudos a on a.ID_Adeudo = t.ID_Credito
		left join ddependientes d on d.ID_Depend = i.Titular_In
		left join seguimiento s on s.ID_Trans = t.ID_Trans
		left join users u on u.ID_User = s.ID_User
		where ID_Dec = dl and i.Estatus in (-1, 1, 2)
		order by ID_Elem, Fecha_Mov;
	when 'muebles' then 
		select t.*, m.*, a.*, IFNULL(d.Tipo_Depend, 'ME') as Own, 
		(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = dl) as Declared,
		(select CONCAT_WS('|', Nombre_Depend, TIpo_Depend) from ddependientes where ID_Depend = Titular_Mue) as Titular,
		s.ID_Seg, s.ID_User, s.Estatus as StSeg, s.Verificacion, s.Observaciones as ObsSeg, s.Fecha_Seg,
		CONCAT_WS(' ', u.Nombre, u.Paterno) as Resp
		from dtransacciones t 
		join dmuebles m on m.ID_Mueble = t.ID_Elem and Tipo_Elem = 'muebles'
		left join dadeudos a on a.ID_Adeudo = t.ID_Credito
		left join ddependientes d on d.ID_Depend = m.Titular_Mue
		left join seguimiento s on s.ID_Trans = t.ID_Trans
		left join users u on u.ID_User = s.ID_User
		where ID_Dec = dl and m.Estatus in (-1, 1, 2)
		order by ID_Elem, Fecha_Mov;
	when 'vehiculos' then 
		select t.*, v.*, a.*, IFNULL(d.Tipo_Depend, 'ME') as Own, 
		(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = dl) as Declared,
		(select CONCAT_WS('|', Nombre_Depend, TIpo_Depend) from ddependientes where ID_Depend = Titular_Veh) as Titular,
		s.ID_Seg, s.ID_User, s.Estatus as StSeg, s.Verificacion, s.Observaciones as ObsSeg, s.Fecha_Seg,
		CONCAT_WS(' ', u.Nombre, u.Paterno) as Resp
		from dtransacciones t 
		join dvehiculos v on v.ID_Vehiculo = t.ID_Elem and Tipo_Elem = 'vehiculos'
		left join dadeudos a on a.ID_Adeudo = t.ID_Credito
		left join ddependientes d on d.ID_Depend = v.Titular_Veh
		left join seguimiento s on s.ID_Trans = t.ID_Trans
		left join users u on u.ID_User = s.ID_User
		where ID_Dec = dl and v.Estatus in (-1, 1, 2)
		order by ID_Elem, Fecha_Mov;
	when 'inversiones' then 
		select t.*, i.*, IFNULL(d.Tipo_Depend, 'ME') as Own, 
		(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = dl) as Declared,
		(select CONCAT_WS('|', Nombre_Depend, TIpo_Depend) from ddependientes where ID_Depend = Titular_Inv) as Titular,
		s.ID_Seg, s.ID_User, s.Estatus as StSeg, s.Verificacion, s.Observaciones as ObsSeg, s.Fecha_Seg,
		CONCAT_WS(' ', u.Nombre, u.Paterno) as Resp
		from dtransacciones t 
		join dinversiones i on i.ID_Inversion = t.ID_Elem and Tipo_Elem = 'inversiones'
		left join ddependientes d on d.ID_Depend = i.Titular_Inv
		left join seguimiento s on s.ID_Trans = t.ID_Trans
		left join users u on u.ID_User = s.ID_User
		where ID_Dec = dl and i.Estatus in (-1, 1, 2)
		order by ID_Elem, Fecha_Mov;
	when 'adeudos' then 
		select t.*, a.*, IFNULL(d.Tipo_Depend, 'ME') as Own, 
		(select CONCAT_WS(' ', Tipo_Dec, YEAR(Fecha_Dec)) from declaraciones where ID_Dec = dl) as Declared,
		(select CONCAT_WS('|', Nombre_Depend, TIpo_Depend) from ddependientes where ID_Depend = Titular_Ad) as Titular,
		s.ID_Seg, s.ID_User, s.Estatus as StSeg, s.Verificacion, s.Observaciones as ObsSeg, s.Fecha_Seg,
		CONCAT_WS(' ', u.Nombre, u.Paterno) as Resp
		from dtransacciones t 
		join dadeudos a on a.ID_Adeudo = t.ID_Elem and Tipo_Elem = 'adeudos'
		left join ddependientes d on d.ID_Depend = a.Titular_Ad
		left join seguimiento s on s.ID_Trans = t.ID_Trans
		left join users u on u.ID_User = s.ID_User
		where ID_Dec = dl and a.Estatus in (-1, 1, 2)
		order by ID_Elem, Fecha_Mov;
	when 'dependientes' then 
		select t.*, d.Nombre_Depend, d.RFC_Depend, d.Nacimiento_Depend, 
		(select CONCAT_WS('|', Domicilio_Depend, Ocupacion_Depend, Lugar_Trabajo, Domicilio_Trabajo) from depend_hist where ID_Depend = d.ID_Depend order by ID_Hist DESC LIMIT 1) as Info, 
		IFNULL(d.Tipo_Depend, 'ME') as Own, s.ID_Seg, s.ID_User, s.Estatus as StSeg, s.Verificacion, s.Observaciones as ObsSeg, s.Fecha_Seg,
		CONCAT_WS(' ', u.Nombre, u.Paterno) as Resp
		from dtransacciones t 
		join ddependientes d on d.ID_Depend = t.ID_Elem and t.Tipo_Elem = 'dependientes'
		left join seguimiento s on s.ID_Trans = t.ID_Trans
		left join users u on u.ID_User = s.ID_User
		where Tipo_Trans in (1, 6, 12) and ID_Dec = dl
		order by ID_Elem, Fecha_Mov;
	when 'ingresos' then 
		select t.*, ing.*, i.*, tp.Tipo, s.ID_Seg, s.ID_User, s.Estatus as StSeg, s.Verificacion, s.Observaciones as ObsSeg, s.Fecha_Seg,
		CONCAT_WS(' ', u.Nombre, u.Paterno) as Resp, conyuge as Ing_Conyuge, dependientes as Ing_Depend 
		from dtransacciones t 
		join dingresos ing on ing.ID_Ingreso = t.ID_Elem and Tipo_Elem = 'ingresos'
		join tipo_ingresos tp on tp.ID_Tipo = ing.Tipo_Ing
		left join dinmuebles i on i.ID_Inmueble = ing.ID_In
		left join seguimiento s on s.ID_Trans = t.ID_Trans
		left join users u on u.ID_User = s.ID_User
		where ID_Dec = dl 
		order by ID_Elem, Fecha_Mov;
	when "extras" then
		select IFNULL(SUM(Importe), 0) into conyuge from dtransacciones t 
		join ddependientes d on d.ID_Depend = t.ID_Elem and Tipo_Elem = 'dependientes'
		where ID_Dec = dl and Tipo_Trans = 11 and Tipo_Depend = 'CONYUGE';
		select IFNULL(SUM(Importe), 0) into dependientes from dtransacciones t 
		join ddependientes d on d.ID_Depend = t.ID_Elem and Tipo_Elem = 'dependientes'
		where ID_Dec = dl and Tipo_Trans = 11 and Tipo_Depend <> 'CONYUGE';
		select conyuge as Ing_Conyuge, dependientes as Ing_Depend;
	when "pensiones" then
		select * from dtransacciones where Tipo_Elem = 'pensiones' and ID_Dec = dl;
	END CASE;

END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `getMovimientos`
-- ----------------------------
DROP PROCEDURE IF EXISTS `getMovimientos`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getMovimientos`(IN serv BIGINT, IN mov BIGINT)
BEGIN
select DISTINCT(ID_Mov), m.ID_Serv, Procedencia, Fecha_Mov, Movimiento, Tipo_Reg, 
m.Inicio, m.Termino, Documento, Dependencia, Puesto 
from movimientos m 
join tipo_mov t on t.ID_Tipo = m.Tipo_Mov 
join servpub sp on sp.ID_Serv = m.ID_Serv 
join dependencias d on d.ID_Dependencia = sp.ID_Dependencia 
join puestos p on p.ID_Puesto = sp.ID_Puesto 
where m.ID_Serv = serv and IF(mov is null, true, ID_Mov > mov)
order by ID_Mov DESC;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `getOmited`
-- ----------------------------
DROP PROCEDURE IF EXISTS `getOmited`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `getOmited`(IN type text, IN dep int)
BEGIN
	CASE type 
	when 'INICIAL' THEN 
		select DISTINCT(sp.ID_Serv), RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Fecha_Inicio as Fecha, Dependencia, Puesto, sp.Area, sp.Correo, p.Fecha_Aut, sp.ART64
		from servpub sp 
		join dependencias depend on depend.ID_Dependencia = sp.ID_Dependencia
		join puestos pos on pos.ID_Puesto = sp.ID_Puesto
		left join prorrogas p on p.ID_Serv = sp.ID_Serv and p.Terminado = 0 and p.Estatus = 1
		where sp.Estatus = 1 and (IF(dep is null, true, sp.ID_Dependencia = dep))
		and DATEDIFF(NOW(), Fecha_Inicio) > (select Valor from parametros where ID_Parametro = 3)
		and sp.ID_Serv not in 
		(select ID_Serv from declaraciones where Tipo_Dec = 'INICIAL')
		and sp.ID_Serv not in 
		(select ID_Serv from prorrogas where Estatus = 1 and Terminado = 0 and Fecha_Aut >= DATE(NOW()))
		and sp.ID_Serv not in 
		(select ID_Serv from serv_ex);
	when 'FINAL' THEN 
		select DISTINCT(sp.ID_Serv), RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Fecha_Termino as Fecha, Dependencia, Puesto, sp.Area, sp.Correo, p.Fecha_Aut, sp.ART64
		from servpub sp 
		join dependencias depend on depend.ID_Dependencia = sp.ID_Dependencia
		join puestos pos on pos.ID_Puesto = sp.ID_Puesto
		join movimientos m on m.ID_Serv = sp.ID_Serv and Tipo_Mov = 2
		left join prorrogas p on p.ID_Serv = sp.ID_Serv and p.Terminado = 0 and p.Estatus = 1
		where sp.Estatus = 2  and m.Tipo_Reg <> 'DEFUNCION' and (IF(dep is null, true, sp.ID_Dependencia = dep))
		and DATEDIFF(NOW(), Fecha_Termino) > (select Valor from parametros where ID_Parametro = 3)
		and sp.ID_Serv not in 
		(select ID_Serv from prorrogas where Estatus = 1 and Terminado = 0 and Fecha_Aut >= DATE(NOW()))
		and sp.ID_Serv not in 
		(select ID_Serv from declaraciones where Tipo_Dec = 'FINAL')
		and sp.ID_Serv not in 
		(select ID_Serv from serv_ex);
	when 'ANUAL' THEN 
		select DISTINCT(sp.ID_Serv), RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Fecha_Inicio as Fecha, Dependencia, Puesto, sp.Area, sp.Correo, p.Fecha_Aut, sp.ART64
		from servpub sp 
		join dependencias depend on depend.ID_Dependencia = sp.ID_Dependencia
		join puestos pos on pos.ID_Puesto = sp.ID_Puesto
		left join prorrogas p on p.ID_Serv = sp.ID_Serv and p.Terminado = 0 and p.Estatus = 1
		where sp.Estatus = 1 and YEAR(Fecha_Inicio) < YEAR(NOW()) and IF(dep is null, true, sp.ID_Dependencia = dep)
		and sp.ID_Serv not in 
		(select ID_Serv from prorrogas where Estatus = 1 and Terminado = 0 and Fecha_Aut >= DATE(NOW()))
		and sp.ID_Serv not in 
		(select ID_Serv from declaraciones where Tipo_Dec = 'ANUAL' and YEAR(Fecha_Dec) = YEAR(NOW()))
		and sp.ID_Serv not in 
		(select ID_Serv from serv_ex);
	when 'INTERESES' THEN 
		select DISTINCT(sp.ID_Serv), RFC, CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, Fecha_Inicio as Fecha, Dependencia, Puesto, sp.Area, sp.Correo, p.Fecha_Aut, sp.ART64
		from servpub sp 
		join dependencias depend on depend.ID_Dependencia = sp.ID_Dependencia
		join puestos pos on pos.ID_Puesto = sp.ID_Puesto
		left join prorrogas p on p.ID_Serv = sp.ID_Serv and p.Terminado = 0 and p.Estatus = 1
		where sp.Estatus = 1 and YEAR(Fecha_Inicio) < YEAR(NOW()) and IF(dep is null, true, sp.ID_Dependencia = dep)
		and sp.ID_Serv not in 
		(select ID_Serv from intereses_dec where YEAR(Fecha_DecInt) = YEAR(NOW()))
		and sp.ID_Serv not in 
		(select ID_Serv from serv_ex);
	END CASE;
	
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `NewDec`
-- ----------------------------
DROP PROCEDURE IF EXISTS `NewDec`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `NewDec`(IN serv bigint, IN info bigint, IN type text)
BEGIN 
insert into declaraciones(ID_Serv, ID_Info, Fecha_Dec, Tipo_Dec) values(serv, info, NOW(), type);
select max(ID_Dec) as ID_Dec from declaraciones where ID_Serv = serv;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `NewInfo`
-- ----------------------------
DROP PROCEDURE IF EXISTS `NewInfo`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `NewInfo`(IN id int, IN serv int, IN st text, IN num text, IN col text, IN city text, IN cp text, IN tel text, IN civil text, IN cu text)
insert into infoserv values (id, serv, st, num, col, city, cp, tel, civil, cu, null, null)
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `NewServ`
-- ----------------------------
DROP PROCEDURE IF EXISTS `NewServ`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `NewServ`(IN ID bigint, IN name text, IN paterno text, IN materno text, IN rfc text, IN dep int, IN pos int, IN func text, IN contra text, 
						  IN fracc text, IN art text, IN area text, IN level int, IN phone text, IN percep text, IN calle text, IN num text, IN col text, IN CP text, IN city text, IN start text, IN mail text, IN pwd text)
insert into servpub values (
ID, 
name, 
paterno, 
materno, 
rfc, 
dep, 
pos, 
func, 
contra, 
fracc, 
art, 
area, 
level, 
phone, 
percep, 
calle, 
num, 
col, 
CP, 
city,
start, 
null, 
NOW(), 
mail, 
NULL, 
pwd, 
1,
1)
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `NewSurvey`
-- ----------------------------
DROP PROCEDURE IF EXISTS `NewSurvey`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `NewSurvey`(IN `IN_ID_Encuesta` int,IN `IN_ID_Declaracion` int,IN `IN_ID_Serv` int,IN `IN_Respuesta` text)
BEGIN
insert into encuestas(ID_Encuesta, ID_Declaracion,ID_Serv, Respuesta) values (IN_ID_Encuesta, IN_ID_Declaracion,IN_ID_Serv, IN_Respuesta);
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `NewTransaction`
-- ----------------------------
DROP PROCEDURE IF EXISTS `NewTransaction`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `NewTransaction`(IN de bigint, IN elem bigint, IN tipo text, IN mov date, IN trans TINYINT, IN form text, IN credit bigint,  IN imp float, IN balance float, IN term text, IN obs text)
insert into dtransacciones (Fecha_Trans, ID_Dec, ID_Elem, Tipo_Elem, Fecha_Mov, Tipo_Trans, Forma_Trans, ID_Credito, Importe, Saldo, Plazo, Observaciones )
VALUES
(NOW(), de, elem, tipo, mov, trans, form, credit, imp, balance, term, obs)
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `RegisterConsult`
-- ----------------------------
DROP PROCEDURE IF EXISTS `RegisterConsult`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegisterConsult`(IN serv BIGINT, IN ui int, IN type text)
BEGIN
insert into consultas (ID_Serv, ID_User, Fecha, Tipo) values(serv, ui, NOW(), type);
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `registerMov`
-- ----------------------------
DROP PROCEDURE IF EXISTS `registerMov`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `registerMov`(IN serv int, IN type int, IN reg text, IN doc text, IN proc int, IN ini date, IN term date, IN mot text, IN user int)
insert into movimientos (ID_Serv, Fecha_Mov, Tipo_Mov, Tipo_Reg, Documento, Procedencia, Inicio, Termino, Motivo, ID_User) 
values 
(serv, NOW(), type, reg, doc, proc, ini, term, mot, user)
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `Search4ISSEG`
-- ----------------------------
DROP PROCEDURE IF EXISTS `Search4ISSEG`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Search4ISSEG`(IN serv BIGINT, IN tbl TEXT, IN type TEXT, IN inst TEXT, IN ref TEXT)
BEGIN 
	CASE tbl 
	WHEN 'inversiones' THEN 
		select ID_Inversion from dinversiones 
		where ID_Serv = serv and Estatus in (0, 1, 2, 3)
		and Tipo_Inv = CONVERT(type USING utf8) collate utf8_spanish_ci 
		and Institucion_Inv = CONVERT(inst USING utf8) collate utf8_spanish_ci 
		and Cuenta_Inv = CONVERT(ref USING utf8) collate utf8_spanish_ci;
	WHEN 'adeudos' THEN 
		select ID_Adeudo from dadeudos 
		where ID_Serv = serv and Estatus in (0, 1, 2, 3)
		and Tipo_Ad = CONVERT(type USING utf8) collate utf8_spanish_ci 
		and Institucion_Ad = CONVERT(inst USING utf8) collate utf8_spanish_ci 
		and Cuenta_Ad = CONVERT(ref USING utf8) collate utf8_spanish_ci;
	END CASE;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `SearchTrans`
-- ----------------------------
DROP PROCEDURE IF EXISTS `SearchTrans`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SearchTrans`(IN dl bigint, IN elem bigint, IN type text, IN trans int)
BEGIN
select ID_Trans from dtransacciones where ID_Dec = dl and ID_Elem = elem and Tipo_Trans = trans and Tipo_Elem = CONVERT(type using utf8) collate utf8_spanish_ci;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `setAdeudo`
-- ----------------------------
DROP PROCEDURE IF EXISTS `setAdeudo`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `setAdeudo`(IN id BIGINT, IN serv BIGINT, IN type text, IN inst text, IN account text, IN term text, IN pay text, IN tit BIGINT)
BEGIN
declare cont int; 
select count(*) into cont from dadeudos where ID_Adeudo = id;
IF cont > 0 THEN 
	update dadeudos set Tipo_Ad = type, Institucion_Ad = inst, Cuenta_Ad = account, Plazo_Ad = term, Pago_Ad = pay, Titular_Ad = tit where ID_Adeudo = id;
ELSE
	insert into dadeudos values(id, serv, type, inst, account, term, pay, tit, 0);
END IF;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `setDependiente`
-- ----------------------------
DROP PROCEDURE IF EXISTS `setDependiente`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `setDependiente`(IN id BIGINT, IN serv BIGINT, IN tipo text, IN nombre text, IN rfc text, IN curp text, IN direc text, IN nacim date, IN ocup text, IN place text, IN address text)
BEGIN
declare cont int; 
select count(*) into cont from ddependientes where ID_Depend = id;
IF cont > 0 THEN 
	update ddependientes set Tipo_Depend = tipo, Nombre_Depend = nombre, RFC_Depend = rfc, CURP_Depend = curp, Nacimiento_Depend = nacim where ID_Depend = id;
	update depend_hist set Fecha_Hist = NOW(), Domicilio_Depend = direc, Ocupacion_Depend = ocup, Lugar_Trabajo = place, Domicilio_Trabajo = address where ID_Depend = id order by ID_Hist DESC LIMIT 1;
ELSE
	insert into ddependientes values (id, serv, tipo, nombre, rfc, curp, nacim, 0);
	insert into depend_hist values(NULL, NOW(), id, direc, ocup, place, address);
END IF;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `setFunction`
-- ----------------------------
DROP PROCEDURE IF EXISTS `setFunction`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `setFunction`(IN serv int, IN fn text)
insert into funciones (ID_Serv, Funcion) values(serv, fn)
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `setIngreso`
-- ----------------------------
DROP PROCEDURE IF EXISTS `setIngreso`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `setIngreso`(IN id BIGINT, IN serv BIGINT, IN type int, IN concept text, IN imp text, IN inmueble BIGINT, IN contra text)
insert into dingresos values(id, serv, type, concept, imp, inmueble,  contra)
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `setInmueble`
-- ----------------------------
DROP PROCEDURE IF EXISTS `setInmueble`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `setInmueble`(IN id BIGINT, IN serv BIGINT, IN type text,  IN tm2 text, IN cm2 text, IN street text, IN num text, IN col text, IN city text, IN CP text, IN tit BIGINT)
BEGIN
declare cont int; 
select count(*) into cont from dinmuebles where ID_Inmueble = id;
IF cont > 0 THEN 
	update dinmuebles set Tipo_In = type, TerrenoM2 = tm2, ConstruccionM2 = cm2, Calle_In = street, Numero_In = num, Colonia_In = col, Ciudad_In = city, CP_In = CP, Titular_In = tit where ID_Inmueble = id;
ELSE
	insert into dinmuebles values(id, serv, type, tm2, cm2, street, num, col, city, CP, tit, 0);
END IF;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `setInversion`
-- ----------------------------
DROP PROCEDURE IF EXISTS `setInversion`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `setInversion`(IN id BIGINT, IN serv BIGINT, IN type text, IN inst text, IN account text,  IN tit BIGINT)
BEGIN
declare cont int; 
select count(*) into cont from dinversiones where ID_Inversion = id;
IF cont > 0 THEN 
	update dinversiones set Tipo_Inv = type, Institucion_Inv = inst, Cuenta_Inv = account, Titular_Inv = tit where ID_Inversion = id;
ELSE
	insert into dinversiones values(id, serv, type, inst, account, tit, 0);
END IF;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `setMueble`
-- ----------------------------
DROP PROCEDURE IF EXISTS `setMueble`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `setMueble`(IN id BIGINT, IN serv BIGINT, IN type text, IN des text, IN tit BIGINT)
BEGIN
declare cont int; 
select count(*) into cont from dmuebles where ID_Mueble = id;
IF cont > 0 THEN 
	update dmuebles set Tipo_Mue = type, Descripcion_Mue = des, Titular_Mue = tit where ID_Mueble = id;
ELSE
	insert into dmuebles values(id, serv, type, des, tit, 0);
END IF;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `setVehiculo`
-- ----------------------------
DROP PROCEDURE IF EXISTS `setVehiculo`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `setVehiculo`(IN id BIGINT, IN serv BIGINT, IN type text, IN mark text, IN serie text, IN model text, IN anio text, IN tit BIGINT)
BEGIN
declare cont int; 
select count(*) into cont from dvehiculos where ID_Vehiculo = id;
IF cont > 0 THEN 
	update dvehiculos set Tipo_Veh = type, Marca_Veh = mark, Serie_Veh = serie, Modelo_Veh = model, Anio_Veh = anio, Titular_Veh = tit where ID_Vehiculo = id;
ELSE
	insert into dvehiculos values(id, serv, type, mark, serie, model, anio, tit, 0);
END IF;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `Test`
-- ----------------------------
DROP PROCEDURE IF EXISTS `Test`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Test`(IN id int)
BEGIN
declare cont int;
declare doing varchar(20);
select count(*) into cont from ddependientes where ID_Depend = id;
IF cont > 0 THEN 
	set doing = 'UPDATE';
ELSE
	set doing = 'INSERT';
END IF;
select doing;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `Transfer`
-- ----------------------------
DROP PROCEDURE IF EXISTS `Transfer`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Transfer`(IN src BIGINT, IN dest BIGINT)
BEGIN
	declare pwd text;
	select Password into pwd from servpub where ID_Serv = src;
	update servpub set Password = pwd where ID_Serv = dest;
	update dinmuebles set ID_Serv = dest where ID_Serv = src;
	update dmuebles set ID_Serv = dest where ID_Serv = src;
	update dvehiculos set ID_Serv = dest where ID_Serv = src;
	update dadeudos set ID_Serv = dest where ID_Serv = src;
	update dinversiones set ID_Serv = dest where ID_Serv = src;
	update ddependientes set ID_Serv = dest where ID_Serv = src;
	update dingresos set ID_Serv = dest where ID_Serv = src;
	update declaraciones set ID_Serv = dest where ID_Serv = src;
	update infoserv set ID_Serv = dest where ID_Serv = src;
	update verificacion set ID_Serv = dest where ID_Serv = src;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `updateDec`
-- ----------------------------
DROP PROCEDURE IF EXISTS `updateDec`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateDec`(IN dl BIGINT, IN balance float, IN balance_con float, IN balance_dep float )
BEGIN 
update declaraciones set Balanza = balance, Balanza_Conyuge = balance_con, Balanza_Depend = balance_dep where ID_Dec = dl;
END
 ;;
delimiter ;

-- ----------------------------
--  Procedure structure for `updateLab`
-- ----------------------------
DROP PROCEDURE IF EXISTS `updateLab`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateLab`(IN ui BIGINT, IN a text, IN percep text, IN lev int, IN phone text, IN street text, IN num text, IN col text, IN cp text, IN city text)
BEGIN 
	update servpub set 
	Area = a, 
	Per_Mensual = percep, 
	Nivel = lev, 
	Tel_Trabajo = phone, 
	Calle_Trabajo = street, 
	Num_Trabajo = num, 
	Col_Trabajo = col, 
	CP_Trabajo = cp, 
	Ciudad_Trabajo = city 
	where ID_Serv = ui;
END
 ;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
