CREATE TABLE IF NOT EXISTS `cafecham_shoe`.`shoes` (
  `shoe_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id of each shoe, unique index',
  `shoe_name` VARCHAR(100) NOT NULL COMMENT 'Shoe name',
  `shoe_brand` VARCHAR(100) NOT NULL COMMENT 'Brand of the shoe',
  `shoe_price` DECIMAL(5,2) NOT NULL COMMENT 'Price up to 999.99 Recommended retail price',
  `shoe_blurb` TEXT NOT NULL COMMENT 'Short description of shoe',
  `shoe_traction` TINYINT NOT NULL COMMENT 'Traction score',
  `shoe_cushion` TINYINT NOT NULL COMMENT 'Cushion score',
  `shoe_materials` TINYINT NOT NULL COMMENT 'Materials score',
  `shoe_fit` TINYINT NOT NULL COMMENT 'Fit score',
  `shoe_support` TINYINT NOT NULL COMMENT 'Support score',
  `shoe_image` VARCHAR(255) NOT NULL COMMENT 'Path to shoe image',
  PRIMARY KEY (`shoe_id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='shoe data';