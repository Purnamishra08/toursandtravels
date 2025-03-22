use toursandtravels;
#Manange User
CREATE TABLE `tbl_admin_modules` (
  `amid` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`amid`),
  KEY `adminid` (`adminid`),
  KEY `moduleid` (`moduleid`),
  CONSTRAINT `tbl_admin_modules_ibfk_1` FOREIGN KEY (`moduleid`) REFERENCES `tbl_modules` (`moduleid`),
  CONSTRAINT `tbl_admin_modules_ibfk_2` FOREIGN KEY (`adminid`) REFERENCES `tbl_admin` (`adminid`)
);
ALTER TABLE `toursandtravels`.`tbl_admin_modules` 
ADD COLUMN `moduleDeleteAccess` BIT(1) NOT NULL DEFAULT b'0' COMMENT '0 = NO\n1 = YES' AFTER `moduleid`;

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
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp(),
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
INSERT INTO `toursandtravels`.`tbl_package_duration` (`duration_name`, `no_ofdays`, `no_ofnights`, `status`) VALUES ('2 Days / 1 Nights', '2', '1', '1');

use toursandtravels;
CREATE TABLE `tbl_tourpackages` (
  `tourpackageid` int(11) NOT NULL AUTO_INCREMENT,
  `tpackage_name` varchar(300) DEFAULT NULL,
  `tpackage_url` varchar(200) DEFAULT NULL,
  `tpackage_code` varchar(200) DEFAULT NULL,
  `package_duration` int(11) DEFAULT NULL,
  `price` decimal(13,2) DEFAULT NULL,
  `fakeprice` decimal(13,2) DEFAULT NULL,
  `pmargin_perctage` varchar(200) DEFAULT NULL,
  `inclusion_exclusion` text DEFAULT NULL,
  `tpackage_image` text DEFAULT NULL,
  `tour_thumb` varchar(200) DEFAULT NULL,
  `alttag_banner` varchar(64) DEFAULT NULL,
  `alttag_thumb` varchar(64) DEFAULT NULL,
  `ratings` float DEFAULT NULL,
  `itinerary_note` text DEFAULT NULL,
  `accomodation` int(11) DEFAULT NULL,
  `tourtransport` int(11) DEFAULT NULL,
  `sightseeing` int(11) DEFAULT NULL,
  `breakfast` int(11) DEFAULT NULL,
  `waterbottle` tinyint(4) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `pack_type` tinyint(4) DEFAULT NULL,
  `itinerary` int(11) DEFAULT NULL,
  `starting_city` int(11) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `show_video_itinerary` int(11) NOT NULL DEFAULT 0,
  `video_itinerary_link` longtext DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`tourpackageid`),
  KEY `INX_TBL_TOURPACKAGES 2024-05-25 11:08` (`tpackage_url`)
);

CREATE TABLE `tbl_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL COMMENT '1= destination_id ,2=place_id, 3=tourpackage_id',
  `type_id` int(11) DEFAULT NULL,
  `tagid` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`tag_id`)
);

CREATE TABLE `tbl_package_accomodation` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `noof_days` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`acc_id`)
);

CREATE TABLE `tbl_itinerary` (
  `itinerary_id` int(11) NOT NULL AUTO_INCREMENT,
  `itinerary_name` varchar(200) DEFAULT NULL,
  `iti_travelmode` varchar(200) DEFAULT NULL,
  `iti_idealstime` varchar(200) DEFAULT NULL,
  `iti_duration` int(11) DEFAULT NULL,
  `itinerary_url` varchar(200) DEFAULT NULL,
  `itineraryimg` varchar(300) DEFAULT NULL,
  `itinerarythumbimg` varchar(300) DEFAULT NULL,
  `alttag_banner` varchar(64) DEFAULT NULL,
  `alttag_thumb` varchar(64) DEFAULT NULL,
  `starting_city` int(11) DEFAULT NULL,
  `ratings` float DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `show_in_home` tinyint(4) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`itinerary_id`),
  KEY `INX_TBL_ITINERARY 2024-05-25 11:08` (`itinerary_url`)
);


#ManagePackages

select * from tbl_contact;
#Enquiry
CREATE TABLE `tbl_contact` (
  `enq_id` int(11) NOT NULL AUTO_INCREMENT,
  `cont_name` varchar(100) DEFAULT NULL,
  `cont_email` varchar(150) DEFAULT NULL,
  `cont_phone` varchar(20) DEFAULT NULL,
  `cont_enquiry_details` varchar(1200) DEFAULT NULL,
  `page_name` varchar(100) DEFAULT NULL,
  `cont_date` datetime DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`enq_id`)
);
INSERT INTO `toursandtravels`.`tbl_contact` (`cont_name`, `cont_email`, `cont_phone`, `cont_enquiry_details`, `page_name`, `cont_date`, `bit_Deleted_Flag`) VALUES ('Rohan Agarwal', 'agarwalrohan132@gmail.com', '7790058321', 'qwertyuioplkjhgfdsazxcvbnm', 'Contact Us', '2019-10-14 10:33:48', b'0');

CREATE TABLE `tbl_reply_enquiry` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) NOT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '1=enqid, 2= itinerary enquiry  id, , 3= package enquiry',
  `enq_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`reply_id`),
  KEY `adminid` (`adminid`),
  KEY `enquiry_id` (`enq_id`)
);
select * from tbl_reply_enquiry;

#ItineraryEnquiry
use toursandtravels;
CREATE TABLE `tbl_tripcustomize` (
  `tripcust_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `tsdate` datetime DEFAULT NULL,
  `duration` int(100) DEFAULT NULL,
  `tnote` varchar(1200) DEFAULT NULL,
  `itinerary_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`tripcust_id`)
) ;
INSERT INTO `toursandtravels`.`tbl_tripcustomize` (`email`, `phone`, `tsdate`, `duration`, `tnote`, `package_id`) VALUES ('agarwalrohan132@gmail.com', '7790058321', '2019-11-21 00:00:00', '2', 'Interested', '1');

#ItineraryEnquiry

#Package Enquiry
use toursandtravels;
CREATE TABLE `tbl_package_inquiry` (
  `enq_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `emailid` varchar(250) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `noof_adult` int(5) DEFAULT NULL,
  `noof_child` int(5) DEFAULT NULL,
  `tour_date` date DEFAULT NULL,
  `accomodation` int(11) DEFAULT NULL,
  `packageid` int(11) DEFAULT NULL,
  `inquiry_date` datetime DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`enq_id`)
);
select * from tbl_package_inquiry;
INSERT INTO `toursandtravels`.`tbl_package_inquiry` (`first_name`, `last_name`, `emailid`, `phone`, `message`, `noof_adult`, `noof_child`, `tour_date`, `accomodation`, `packageid`, `inquiry_date`) VALUES ('Rohan', 'Agarwal', 'agarwalrohan132@gmail.com', '7790058321', 'we have our personal travel vehicle so excluding the vehicle charges can i know the estimate', '4', '2', '2021-02-02', '2', '1', '2021-01-25 17:55:49');
#Package Enquiry


#Enquiry


#Reviews
CREATE TABLE `tbl_reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `tourtagid` text DEFAULT NULL,
  `reviewer_name` varchar(100) DEFAULT NULL,
  `reviewer_loc` varchar(150) DEFAULT NULL,
  `no_of_star` varchar(100) DEFAULT NULL,
  `feedback_msg` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`review_id`)
);


#FAQ
CREATE TABLE `tbl_faqs` (
  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
  `faq_question` varchar(400) DEFAULT NULL,
  `faq_answer` text DEFAULT NULL,
  `faq_order` smallint(6) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`faq_id`)
);

CREATE TABLE `tbl_package_faqs` (
  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) DEFAULT 0,
  `faq_question` varchar(400) DEFAULT NULL,
  `faq_answer` text DEFAULT NULL,
  `faq_order` smallint(6) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`faq_id`)
);

ALTER TABLE `toursandtravels`.`tbl_hotel` 
CHANGE COLUMN `destination_name` `destination_name` INT(11) NOT NULL ,
CHANGE COLUMN `hotel_type` `hotel_type` INT(11) NOT NULL ;



#CMS
CREATE TABLE `tbl_contents` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(50) DEFAULT NULL,
  `page_content` text DEFAULT NULL,
  `seo_title` text DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_keywords` text DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`content_id`),
  KEY `INX_TBL_CONTENTS 2024-05-25 11:08` (`content_id`)
);
INSERT INTO `tbl_contents` (`page_name`, `page_content`, `seo_title`, `seo_description`, `seo_keywords`, `updated_date`, `updated_by`, `bit_Deleted_Flag`) VALUES ('Home Page', '<div class="container">\r\n<div class="row">\r\n<div class="col-md-4">\r\n<div class="featuredbox-top"><img alt="guide" height="64" src="https://myholidayhappiness.com/assets/images/guide.png" width="64" />\r\n<div class="featuredbox-title"><span>1,000+</span> local guides</div>\r\n\r\n<div class="featuredbox-title">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<div class="col-md-4">\r\n<div class="featuredbox-top"><img alt="experience" height="64" src="https://myholidayhappiness.com/assets/images/experience.png" width="64" />\r\n<div class="featuredbox-title"><span>Handcrafted</span> experiences</div>\r\n</div>\r\n</div>\r\n\r\n<div class="col-md-4">\r\n<div class="featuredbox-top"><img alt="traveller" height="64" src="https://myholidayhappiness.com/assets/images/traveller.png" width="64" />\r\n<div class="featuredbox-title"><span>100% </span> happy travellers</div>\r\n</div>\r\n</div>\r\n\r\n<div class="clearfix">&nbsp;</div>\r\n</div>\r\n</div>', 'My Holiday Happiness - Package Tours & Travels', 'Search holiday Ideas, Plan Your Trip, Get multiple free itineraries with a price calculator. Explore multiple destinations & tour packages in India.', 'India Travel, Tour Packages, India Destinations, Travel Guide, India Destination Guide, Travel Itinerary, Build Itinerary, India Trip Planning, India Tourism, Travel India, Places to visit in India, Tourist Places in India, Things to do, plan your trips', '2025-03-20 20:26:34', 18, b'0');
INSERT INTO `tbl_contents` (`content_id`, `page_name`, `page_content`, `seo_title`, `seo_description`, `seo_keywords`, `updated_date`, `updated_by`, `bit_Deleted_Flag`) VALUES (3, 'Contact Page', '<div class="col-md-8 text-center">\r\n<h3 class="mb-2">If you need furthur details - <em><strong>Please to write us for more information</strong></em></h3>\r\n\r\n<h5 class="mb-3">You need help ?</h5>\r\n\r\n<div class="clearfix">&nbsp;</div>\r\n\r\n<p>We would be more happy to help you.Our team advisor are 24/7 at your service to help you..For any support on ongoing trips, please call Tour Manager assigned to your trip.</p>\r\n</div>', 'Contact Us - My Holiday Happiness', 'Contact My Holiday Happiness for your travel needs like package tours, Trip itineraries, Weekend getaways, Travel guide and Travel startup', 'My Holiday Happiness contact us page, Contact us, Contact My Holiday Happiness', '2025-03-20 20:27:08', 18, b'0');

#footer links
CREATE TABLE `tbl_footer` (
  `int_footer_id` int(11) NOT NULL AUTO_INCREMENT,
  `vch_Footer_Name` varchar(255) NOT NULL,
  `vch_Footer_URL` varchar(255) NOT NULL,
  `vch_Footer_Desc` text DEFAULT NULL,
  `tourpackageid` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`int_footer_id`)
);
SET SQL_SAFE_UPDATES=0;
UPDATE `toursandtravels`.`tbl_modules` SET `module` = 'Manage Footer Links' WHERE (`moduleid` = '11');

#footer links

#FOLLOWUPENQUIRY

select * from tbl_sources;
select * from tbl_statuses;
CREATE TABLE `tbl_sources` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`)
);

CREATE TABLE `tbl_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`id`)
);
#FOLLOWUPENQUIRY

select * from tbl_admin;

update tbl_admin set password='$2y$10$6NY3d1MbfEr7WCXO7ff/huVSTq3YMGXVube9/sGU2eKw24u4LDiaq' where adminid>0;
#Blogs
CREATE TABLE `tbl_blog` (
  `blogid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `blog_url` varchar(300) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `alttag_image` varchar(64) DEFAULT NULL,
  `show_in_home` tinyint(4) DEFAULT NULL COMMENT 'show = 1',
  `show_comment` tinyint(4) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `blog_meta_title` text DEFAULT NULL,
  `blog_meta_keywords` text DEFAULT NULL,
  `blog_meta_description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `bit_Deleted_Flag` bit(1) DEFAULT b'0',
  PRIMARY KEY (`blogid`)
);

#Blogs


