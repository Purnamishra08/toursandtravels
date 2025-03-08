use toursandtravels;
#Manage Vehicles
CREATE TABLE `tbl_vehicletypes` (
  `vehicleid` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_name` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`vehicleid`)
);
CREATE TABLE `tbl_vehicleprices` (
  `priceid` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_name` int(11) DEFAULT NULL,
  `destination` int(11) DEFAULT NULL,
  `price` decimal(13,2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`priceid`)
  );
#Manage Vehicles
  
#Manage Hotels
  CREATE TABLE `tbl_hotel_type` (
  `hotel_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_type_name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`hotel_type_id`)
);

CREATE TABLE `tbl_season_type` (
  `season_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `season_type_name` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`season_type_id`)
);

CREATE TABLE `tbl_hotel` (
  `hotel_id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_name` varchar(200) NOT NULL,
  `destination_name` varchar(200) NOT NULL,
  `hotel_type` varchar(200) NOT NULL,
  `default_price` decimal(10,2) NOT NULL,
  `room_type` varchar(1000) DEFAULT NULL,
  `trip_advisor_url` varchar(1500) DEFAULT NULL,
  `star_rating` decimal(4,1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`hotel_id`)
);

CREATE TABLE `tbl_season` (
  `season_id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` int(11) NOT NULL,
  `season_type` varchar(200) NOT NULL,
  `sesonstart_month` varchar(200) NOT NULL,
  `sesonend_month` varchar(200) NOT NULL,
  `sesonstart_day` varchar(200) NOT NULL,
  `sesonend_day` varchar(200) NOT NULL,
  `adult_price` decimal(10,2) NOT NULL,
  `couple_price` decimal(10,2) NOT NULL,
  `kid_price` decimal(10,2) NOT NULL,
  `adult_extra` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`season_id`)
);
#ManageHotels

#ManageLocation
CREATE TABLE `tbl_state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(200) DEFAULT NULL,
  `state_url` varchar(200) DEFAULT NULL,
  `showmenu` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `state_meta_title` text DEFAULT NULL,
  `state_meta_keywords` text DEFAULT NULL,
  `state_meta_description` text DEFAULT NULL,
  `bannerimg` text DEFAULT NULL,
  `alttag_banner` text DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`state_id`)
);


CREATE TABLE `tbl_destination_type` (
  `destination_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `destination_type_name` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`destination_type_id`)
);
CREATE TABLE `tbl_destination` (
  `destination_id` int(11) NOT NULL AUTO_INCREMENT,
  `destination_name` varchar(500) DEFAULT NULL,
  `destination_url` varchar(500) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `trip_duration` varchar(500) DEFAULT NULL,
  `nearest_city` varchar(500) DEFAULT NULL,
  `visit_time` varchar(500) DEFAULT NULL,
  `peak_season` varchar(500) DEFAULT NULL,
  `weather_info` varchar(500) DEFAULT NULL,
  `destiimg` varchar(500) DEFAULT NULL,
  `destiimg_thumb` varchar(500) DEFAULT NULL,
  `alttag_banner` varchar(64) DEFAULT NULL,
  `alttag_thumb` varchar(64) DEFAULT NULL,
  `google_map` text DEFAULT NULL,
  `about_destination` text DEFAULT NULL,
  `places_visit_desc` text DEFAULT NULL,
  `internet_availability` varchar(500) NOT NULL,
  `std_code` varchar(500) NOT NULL,
  `language_spoken` varchar(500) NOT NULL,
  `major_festivals` varchar(500) NOT NULL,
  `note_tips` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `desttype_for_home` int(11) DEFAULT NULL,
  `show_on_footer` tinyint(4) DEFAULT NULL,
  `pick_drop_price` decimal(10,2) DEFAULT NULL,
  `accomodation_price` decimal(10,2) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `place_meta_title` text DEFAULT NULL,
  `place_meta_keywords` text DEFAULT NULL,
  `place_meta_description` text DEFAULT NULL,
  `package_meta_title` text DEFAULT NULL,
  `package_meta_keywords` text DEFAULT NULL,
  `package_meta_description` text DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`destination_id`)
);

CREATE TABLE `tbl_destination_places` (
  `dest_placeid` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT NULL COMMENT 'similar=1, near by=2',
  `destination_id` int(11) DEFAULT NULL,
  `simdest_id` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`dest_placeid`)
) ENGINE=InnoDB AUTO_INCREMENT=25140 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `tbl_destination_cats` (
  `destcat_id` int(11) NOT NULL AUTO_INCREMENT,
  `destination_id` int(11) DEFAULT NULL,
  `cat_id` int(200) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`destcat_id`),
  KEY `continent_id` (`cat_id`),
  KEY `destination_id` (`destination_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2564 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `tbl_multdest_type` (
  `multdest_id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_type` tinyint(11) DEFAULT NULL COMMENT 'destination = 1, place = 2',
  `loc_id` int(11) DEFAULT NULL,
  `loc_type_id` int(100) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`multdest_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29594 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `tbl_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL COMMENT '1= destination_id ,2=place_id, 3=tourpackage_id',
  `type_id` int(11) DEFAULT NULL,
  `tagid` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24627 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `tbl_parameters` (
  `parid` int(11) NOT NULL AUTO_INCREMENT,
  `parameter` varchar(150) DEFAULT NULL,
  `par_value` text DEFAULT NULL,
  `param_type` varchar(100) DEFAULT NULL,
  `input_type` tinyint(4) NOT NULL COMMENT 'text box=1, text area= 2, file= 3, editor=4',
  `status` tinyint(1) DEFAULT 1,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`parid`),
  KEY `INX_TBL_PARAMETERS 2024-05-25 21:26` (`parid`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#ManageLocation



#Menus
CREATE TABLE `tbl_menus` (
  `menuid` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`menuid`),
  KEY `continent_id` (`menu_name`)
);
CREATE TABLE `tbl_menutags` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `menuid` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `tag_name` varchar(200) DEFAULT NULL,
  `about_tag` text DEFAULT NULL,
  `tag_url` varchar(200) DEFAULT NULL,
  `menutag_img` varchar(200) DEFAULT NULL,
  `menutagthumb_img` varchar(200) DEFAULT NULL,
  `alttag_banner` varchar(64) DEFAULT NULL,
  `alttag_thumb` varchar(64) DEFAULT NULL,
  `show_on_home` tinyint(4) DEFAULT NULL COMMENT '1= show',
  `show_on_footer` tinyint(4) DEFAULT NULL COMMENT '1= show',
  `meta_title` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`tagid`),
  KEY `continent_id` (`cat_id`),
  KEY `INX_TBL_MENUTAGS 2024-05-25 11:08` (`tag_url`)
);
CREATE TABLE `tbl_menucategories` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `menuid` int(11) DEFAULT NULL,
  `cat_name` varchar(200) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT 0,
  `updated_by` int(11) DEFAULT 0,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`catid`),
  KEY `continent_id` (`cat_name`)
);
#Menus

#ManagePackages

CREATE TABLE `tbl_package_duration` (
  `durationid` int(11) NOT NULL AUTO_INCREMENT,
  `duration_name` varchar(200) DEFAULT NULL,
  `no_ofdays` int(11) DEFAULT NULL,
  `no_ofnights` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`durationid`)
);

#ManagePackages


