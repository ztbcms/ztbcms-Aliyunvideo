
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ztb_aliyunvideo_conf
-- ----------------------------
DROP TABLE IF EXISTS `cms_aliyunvideo_conf`;
CREATE TABLE `cms_aliyunvideo_conf`  (
  `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT,
  `accesskey_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `accesskey_secret` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `video_valid_time` int(10) NOT NULL COMMENT '视频的有效期',
  `edit_time` int(15) NOT NULL COMMENT '最后编辑时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `accesskey_id`(`accesskey_id`) USING BTREE,
  INDEX `accesskey_secret`(`accesskey_secret`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ztb_aliyunvideo_video
-- ----------------------------
DROP TABLE IF EXISTS `cms_aliyunvideo_video`;
CREATE TABLE `cms_aliyunvideo_video`  (
  `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '視頻路徑',
  `video_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '視頻名稱',
  `is_aliyun` int(1) NULL DEFAULT NULL COMMENT '是否接受了阿里雲的回調 默認為0 接受了為1',
  `add_time` int(15) NULL DEFAULT NULL COMMENT '添加時間',
  `edit_time` int(15) NULL DEFAULT NULL COMMENT '編輯時間',
  `expire_time` int(15) NULL DEFAULT NULL COMMENT '到期时间',
  `video_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '視頻id',
  `video_title` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '視頻標題',
  `cover_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '封面圖片',
  `video_size` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '視頻大小',
  `upload_auth` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `upload_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `request_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `sort` int(15) NULL DEFAULT NULL COMMENT '排序',
  `group_id` int(15) NULL DEFAULT NULL COMMENT '分类id',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `video_id`(`video_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

DROP TABLE IF EXISTS `cms_aliyunvideo_group`;
CREATE TABLE `cms_aliyunvideo_group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分组名称',
  `is_delete` int(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否删除',
  `add_time` int(15) NULL DEFAULT NULL COMMENT '添加时间',
  `edit_time` int(15) NULL DEFAULT NULL COMMENT '最后编辑时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `is_display`(`is_delete`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
