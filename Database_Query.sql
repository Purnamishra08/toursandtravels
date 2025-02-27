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