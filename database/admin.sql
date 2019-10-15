-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('1', '0', '1', '首页', 'fa-bar-chart', '/', null, null, '2019-10-15 15:14:20');
INSERT INTO `admin_menu` VALUES ('2', '0', '6', '系统管理', 'fa-tasks', null, null, null, '2019-10-15 15:24:58');
INSERT INTO `admin_menu` VALUES ('3', '2', '7', '管理员', 'fa-users', 'auth/users', null, null, '2019-10-15 15:24:58');
INSERT INTO `admin_menu` VALUES ('4', '2', '8', '角色', 'fa-user', 'auth/roles', null, null, '2019-10-15 15:24:58');
INSERT INTO `admin_menu` VALUES ('5', '2', '9', '权限', 'fa-ban', 'auth/permissions', null, null, '2019-10-15 15:24:58');
INSERT INTO `admin_menu` VALUES ('6', '2', '10', '菜单', 'fa-bars', 'auth/menu', null, null, '2019-10-15 15:24:58');
INSERT INTO `admin_menu` VALUES ('7', '2', '11', '操作日志', 'fa-history', 'auth/logs', null, null, '2019-10-15 15:24:58');
INSERT INTO `admin_menu` VALUES ('8', '0', '2', '用户管理', 'fa-users', '/users', null, '2019-10-15 15:16:13', '2019-10-15 15:24:57');
INSERT INTO `admin_menu` VALUES ('9', '0', '4', '订单管理', 'fa-rmb', '/orders', null, '2019-10-15 15:18:11', '2019-10-15 15:24:57');
INSERT INTO `admin_menu` VALUES ('10', '0', '3', '商品管理', 'fa-cubes', '/products', null, '2019-10-15 15:18:24', '2019-10-15 15:24:57');
INSERT INTO `admin_menu` VALUES ('11', '0', '5', '优惠券管理', 'fa-tags', '/coupon_codes', null, '2019-10-15 15:18:59', '2019-10-15 15:24:57');

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES ('1', 'All permission', '*', '', '*', null, null);
INSERT INTO `admin_permissions` VALUES ('2', 'Dashboard', 'dashboard', 'GET', '/', null, null);
INSERT INTO `admin_permissions` VALUES ('3', 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', null, null);
INSERT INTO `admin_permissions` VALUES ('4', 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', null, null);
INSERT INTO `admin_permissions` VALUES ('5', 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', null, null);
INSERT INTO `admin_permissions` VALUES ('6', '用户管理', 'users', '', '/users*', '2019-10-15 15:25:47', '2019-10-15 15:25:47');
INSERT INTO `admin_permissions` VALUES ('7', '商品管理', 'products', '', '/products*', '2019-10-15 15:26:22', '2019-10-15 15:26:22');
INSERT INTO `admin_permissions` VALUES ('8', '优惠券管理', 'coupon_codes', '', '/coupon_codes*', '2019-10-15 15:27:34', '2019-10-15 15:27:34');
INSERT INTO `admin_permissions` VALUES ('9', '订单管理', 'orders', '', '/orders*', '2019-10-15 15:28:14', '2019-10-15 15:28:14');

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
INSERT INTO `admin_role_menu` VALUES ('1', '2', null, null);

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
INSERT INTO `admin_role_permissions` VALUES ('1', '1', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '2', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '3', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '4', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '6', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '7', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '8', null, null);
INSERT INTO `admin_role_permissions` VALUES ('2', '9', null, null);

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES ('1', '1', null, null);
INSERT INTO `admin_role_users` VALUES ('2', '2', null, null);

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES ('1', 'Administrator', 'administrator', '2019-10-15 14:48:48', '2019-10-15 14:48:48');
INSERT INTO `admin_roles` VALUES ('2', '运营经理', 'operation', '2019-10-15 15:32:07', '2019-10-15 15:32:07');

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('1', 'admin', '$2y$10$hFC2weUuvx1xoFkIkM6b6./0Y.QSyHqfSuVhIV1bzMd42mzaBmNMe', 'Administrator', null, '16F9excD9NG8xXQSqMjbEgTrDsOug9e0Jx78lRDeLRVNUxRpaHpWMEQbX3ws', '2019-10-15 14:48:48', '2019-10-15 14:48:48');
INSERT INTO `admin_users` VALUES ('2', 'operator', '$2y$10$3vhIatm7mi5fXxeDrYnr8eQmoZRg.qOirnxmFuWTUQc45rHed5MeC', 'Josh.manager', null, 'P4Q6KByR1e49sIH7TbRnGysZNa3J30xRTEbg3Wb9PW9zjACHk42kNQ9rv9E9', '2019-10-15 15:33:32', '2019-10-15 15:33:32');
