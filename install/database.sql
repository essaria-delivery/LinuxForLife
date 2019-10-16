-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 08, 2019 at 11:37 AM
-- Server version: 10.2.25-MariaDB
-- PHP Version: 7.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u737921556_gofre`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_payment`
--

CREATE TABLE `admin_payment` (
  `id` int(200) NOT NULL,
  `store_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_request`
--

CREATE TABLE `admin_request` (
  `id` int(200) NOT NULL,
  `from_date` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_date` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_share` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_by` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_by_admin` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_to` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_to_store_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_transaction`
--

CREATE TABLE `admin_transaction` (
  `id` int(200) NOT NULL,
  `store_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_date` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_transaction`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `ads_key` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ads`
--


-- --------------------------------------------------------

--
-- Table structure for table `app_dashboard_banner`
--

CREATE TABLE `app_dashboard_banner` (
  `id` int(11) NOT NULL,
  `slider_title` varchar(100) NOT NULL,
  `slider_image` varchar(100) NOT NULL,
  `slider_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_dashboard_banner`
--

INSERT INTO `app_dashboard_banner` (`id`, `slider_title`, `slider_image`, `slider_status`) VALUES
(1, 'first banner', '11.jpg', 1),
(2, 'second banner', '2.jpg', 1),
(3, 'third banner', '3.jpg', 1),
(6, 'forth slider', '4.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_password` longtext NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `user_bdate` date NOT NULL,
  `is_email_varified` int(11) NOT NULL,
  `varified_token` varchar(255) NOT NULL,
  `user_gcm_code` longtext NOT NULL,
  `user_ios_token` longtext NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_city` int(11) NOT NULL,
  `user_login_status` int(11) NOT NULL DEFAULT 0,
  `lat` varchar(200) NOT NULL,
  `lon` varchar(200) NOT NULL,
  `profit_percent` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`user_id`, `user_name`, `user_email`, `user_phone`, `user_fullname`, `user_password`, `user_type_id`, `user_bdate`, `is_email_varified`, `varified_token`, `user_gcm_code`, `user_ios_token`, `user_status`, `user_image`, `user_city`, `user_login_status`, `lat`, `lon`, `profit_percent`) VALUES
(1, 'Sub Admin', 'saurabh.rawat@tecmanic.com', '5678904443', '0', 'd8578edf8458ce06fbc5bb76a58c5ca4', 0, '0000-00-00', 0, '', '', '', 1, '3Cscreencapture-1556622659301.png', 0, 1, '51.3812676', '11.6041294', 'surajpur');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `slider_title` varchar(100) NOT NULL,
  `slider_url` varchar(100) NOT NULL,
  `slider_image` varchar(100) NOT NULL,
  `sub_cat` int(11) NOT NULL,
  `slider_status` int(11) NOT NULL,
  `store_id_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(200) NOT NULL,
  `qty` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `store_id` varchar(200) NOT NULL,
  `store_name` varchar(200) NOT NULL,
  `product_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `arb_title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `parent` int(50) NOT NULL,
  `leval` int(50) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(200) NOT NULL,
  `image2` varchar(200) NOT NULL,
  `image2_status` varchar(300) NOT NULL,
  `status` varchar(100) NOT NULL,
  `store_id_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `closing_hours`
--

CREATE TABLE `closing_hours` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `store_id` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `closing_hours`
--

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE `commission` (
  `id` int(200) NOT NULL,
  `store_id` int(11) NOT NULL,
  `store_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `on_date` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(200) NOT NULL,
  `admin_share` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'cod & sp=0,online=1,2=db',
  `status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_request` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commission`
--

-- --------------------------------------------------------

--
-- Table structure for table `complain`
--

CREATE TABLE `complain` (
  `complain_id` int(200) NOT NULL,
  `complain` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complain`
--

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_name` varchar(200) NOT NULL,
  `coupon_code` varchar(20) NOT NULL,
  `valid_from` varchar(20) NOT NULL,
  `valid_to` varchar(20) NOT NULL,
  `validity_type` varchar(50) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `discount_type` varchar(50) NOT NULL,
  `discount_value` int(11) NOT NULL,
  `cart_value` int(11) NOT NULL,
  `uses_restriction` int(11) NOT NULL,
  `store_id_login` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

-- --------------------------------------------------------

--
-- Table structure for table `currency_setting`
--

CREATE TABLE `currency_setting` (
  `id` int(200) NOT NULL,
  `currency_type` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency_setting`
--

INSERT INTO `currency_setting` (`id`, `currency_type`) VALUES
(1, 'Rs.');

-- --------------------------------------------------------

--
-- Table structure for table `deal_product`
--

CREATE TABLE `deal_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `deal_price` varchar(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `start_time` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `end_time` varchar(200) NOT NULL,
  `store_id_login` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deal_product`
--

-- --------------------------------------------------------

--
-- Table structure for table `deelofday`
--

CREATE TABLE `deelofday` (
  `id` int(11) NOT NULL,
  `product_price` varchar(500) NOT NULL,
  `image_title` varchar(200) NOT NULL,
  `img_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivered_order`
--

CREATE TABLE `delivered_order` (
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `on_date` date NOT NULL,
  `delivery_time_from` varchar(200) NOT NULL,
  `delivery_time_to` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `note` longtext NOT NULL,
  `is_paid` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `total_rewards` varchar(200) NOT NULL,
  `total_kg` double NOT NULL,
  `total_items` double NOT NULL,
  `socity_id` int(11) NOT NULL,
  `delivery_address` longtext NOT NULL,
  `location_id` int(11) NOT NULL,
  `delivery_charge` double NOT NULL,
  `new_store_id` varchar(200) NOT NULL DEFAULT '0',
  `assign_to` int(11) NOT NULL DEFAULT 0,
  `payment_method` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivered_order`
--


-- --------------------------------------------------------

--
-- Table structure for table `delivery_assign_store`
--

CREATE TABLE `delivery_assign_store` (
  `assign_id` int(200) NOT NULL,
  `boy_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_assign_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy`
--

CREATE TABLE `delivery_boy` (
  `id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_phone` varchar(200) NOT NULL,
  `user_status` varchar(200) NOT NULL,
  `work_status` varchar(200) NOT NULL,
  `user_lat` varchar(500) NOT NULL,
  `user_lng` varchar(500) NOT NULL,
  `charge` varchar(500) NOT NULL,
  `store_id` varchar(500) NOT NULL,
  `device_id` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_boy`
--


-- --------------------------------------------------------

--
-- Table structure for table `delivery_charge`
--

CREATE TABLE `delivery_charge` (
  `charge_id` int(200) NOT NULL,
  `store_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_from` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_to` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge_amount` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_charge`
--

INSERT INTO `delivery_charge` (`charge_id`, `store_id`, `cart_from`, `cart_to`, `charge_amount`) VALUES
(1, '292', '1', '99', '40'),
(2, '292', '100', '499', '35'),
(3, '292', '500', '1000', '30'),
(4, '292', '1000', '5000', '20'),
(5, '293', '1', '99', '40'),
(6, '293', '100', '499', '35'),
(7, '293', '500', '1000', '30'),
(8, '293', '1000', '5000', '20'),
(9, '294', '1', '99', '40'),
(10, '294', '100', '499', '35'),
(11, '294', '500', '1000', '30'),
(12, '294', '1000', '5000', '20');

-- --------------------------------------------------------

--
-- Table structure for table `feature_slider`
--

CREATE TABLE `feature_slider` (
  `id` int(11) NOT NULL,
  `slider_title` varchar(100) NOT NULL,
  `slider_url` varchar(100) NOT NULL,
  `slider_image` varchar(100) NOT NULL,
  `sub_cat` int(200) NOT NULL,
  `slider_status` int(11) NOT NULL,
  `store_id_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feature_slider`
--

INSERT INTO `feature_slider` (`id`, `slider_title`, `slider_url`, `slider_image`, `sub_cat`, `slider_status`, `store_id_login`) VALUES
(16, 'featured', '', 'Paperboat_Banner_750X375pix.jpg', 0, 1, 0),
(17, 'test12', '', 'banner11.jpg', 32, 1, 0),
(18, 'test', '', 'banner4.jpg', 26, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `header_categories`
--

CREATE TABLE `header_categories` (
  `id` int(40) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `parent` int(50) NOT NULL,
  `leval` int(50) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `header_products`
--

CREATE TABLE `header_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_image` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `price` double NOT NULL,
  `unit_value` double NOT NULL,
  `unit` varchar(10) NOT NULL,
  `increament` double NOT NULL,
  `rewards` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `icons`
--

CREATE TABLE `icons` (
  `id` int(255) NOT NULL,
  `service` varchar(500) NOT NULL,
  `image_name` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instamojo`
--

CREATE TABLE `instamojo` (
  `id` int(200) NOT NULL,
  `api_key` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instamojo`
--

INSERT INTO `instamojo` (`id`, `api_key`, `status`) VALUES
(1, 'rez_test_JzclM3LTkxBGXs', '1');

-- --------------------------------------------------------

--
-- Table structure for table `language_setting`
--

CREATE TABLE `language_setting` (
  `id` int(200) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language_setting`
--

INSERT INTO `language_setting` (`id`, `status`) VALUES
(1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `plan_id` int(200) NOT NULL,
  `plan_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_amount` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_time` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_time_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_desc` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`plan_id`, `plan_name`, `plan_amount`, `plan_time`, `plan_time_type`, `plan_desc`) VALUES
(1, 'Basic Plan', '999', '30', '1', 'this is basic plan'),
(2, 'stand Plan', '1999', '60', '', 'this is second plan'),
(3, 'premium Plan', '2999', '90', '', 'this is basic plan'),
(4, 'dimand Plan', '3999', '365', '', 'this is second plan'),
(5, 'King Plan new', '10,000', '6', '2', 'update_array  update_array update_array     update_array\r\nupdate_array\r\nupdate_array\r\nupdate_array\r\nupdate_array');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(200) NOT NULL,
  `store_id` int(200) NOT NULL,
  `msg_register` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `msg_new_order` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `msg_order_assign` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `msg_complete_order` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `mail_register` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `mail_new_order` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `mail_order_assign` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `mail_complete_order` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `msg_cancel` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_cancel` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_pickupby_dboy` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_pickupby_dboy` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `store_id`, `msg_register`, `msg_new_order`, `msg_order_assign`, `msg_complete_order`, `mail_register`, `mail_new_order`, `mail_order_assign`, `mail_complete_order`, `msg_cancel`, `mail_cancel`, `msg_pickupby_dboy`, `mail_pickupby_dboy`) VALUES
(1, 0, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pageapp`
--

CREATE TABLE `pageapp` (
  `id` int(11) NOT NULL,
  `pg_title` varchar(200) NOT NULL,
  `pg_slug` varchar(100) NOT NULL,
  `pg_descri` longtext NOT NULL,
  `pg_status` int(50) NOT NULL,
  `pg_foot` int(50) NOT NULL,
  `crated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pageapp`
--

INSERT INTO `pageapp` (`id`, `pg_title`, `pg_slug`, `pg_descri`, `pg_status`, `pg_foot`, `crated_date`) VALUES
(1, ''),
(2, 'About Us', 'about-us', '', 0, 0, '2019-08-06 13:09:38'),
(3, 'Terms of Use', '', 0, 0, '2019-08-06 13:11:18');
INSERT INTO `pageapp` (`id`, `pg_title`, `pg_slug`, `pg_descri`, `pg_status`, `pg_foot`, `crated_date`) VALUES
(4, 'FAQ', 'faq', '', 0, 0, '2019-08-07 05:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `paypal`
--

CREATE TABLE `paypal` (
  `id` int(200) NOT NULL,
  `client_id` varchar(200) NOT NULL,
  `sb_id` varchar(200) NOT NULL,
  `status` int(10) NOT NULL,
  `store_id_login` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paypal`
--

INSERT INTO `paypal` (`id`, `client_id`, `sb_id`, `status`, `store_id_login`) VALUES
(1, 'hgvjbn@gmail.com', 'facilitator@tecmanic.com', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `pincode`
--

CREATE TABLE `pincode` (
  `pincode` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_arb_name` varchar(200) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_arb_description` longtext NOT NULL,
  `product_image` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `price` double NOT NULL,
  `mrp` int(200) NOT NULL,
  `unit_value` double NOT NULL,
  `unit` varchar(10) NOT NULL,
  `arb_unit` varchar(200) DEFAULT NULL,
  `increament` double NOT NULL,
  `rewards` varchar(200) NOT NULL DEFAULT '0',
  `tax` int(100) NOT NULL,
  `store_id_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--


-- --------------------------------------------------------

--
-- Table structure for table `products_complain`
--

CREATE TABLE `products_complain` (
  `id` int(200) NOT NULL,
  `product_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complain` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

CREATE TABLE `products_images` (
  `id` int(200) NOT NULL,
  `product_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `unit` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `store` varchar(200) NOT NULL,
  `store_id_login` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase`
--



-- --------------------------------------------------------

--
-- Table structure for table `purchase_plan`
--

CREATE TABLE `purchase_plan` (
  `purchase_id` int(200) NOT NULL,
  `store_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `razorpay`
--

CREATE TABLE `razorpay` (
  `id` int(200) NOT NULL,
  `api_key` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `store_id_login` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `razorpay`
--

INSERT INTO `razorpay` (`id`, `api_key`, `status`, `store_id_login`) VALUES
(1, '1', '0', '7');

-- --------------------------------------------------------

--
-- Table structure for table `registers`
--

CREATE TABLE `registers` (
  `user_id` int(11) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `socity_id` int(11) NOT NULL,
  `house_no` longtext NOT NULL,
  `mobile_verified` int(11) NOT NULL,
  `user_gcm_code` longtext NOT NULL,
  `user_ios_token` longtext NOT NULL,
  `varified_token` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `reg_code` int(6) NOT NULL,
  `wallet` int(11) NOT NULL,
  `rewards` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registers`
--


-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(200) NOT NULL,
  `from_date` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_date` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_share` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_by_store_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_by` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_to` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` int(200) NOT NULL,
  `point` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `point`) VALUES
(1, '9');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `on_date` date NOT NULL,
  `delivery_time_from` varchar(200) NOT NULL,
  `delivery_time_to` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `note` longtext NOT NULL,
  `is_paid` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `total_rewards` varchar(200) NOT NULL,
  `total_kg` double NOT NULL,
  `total_items` double NOT NULL,
  `socity_id` int(11) NOT NULL,
  `delivery_address` longtext NOT NULL,
  `location_id` int(11) NOT NULL,
  `delivery_charge` double NOT NULL,
  `new_store_id` varchar(200) NOT NULL DEFAULT '0',
  `assign_to` varchar(30) NOT NULL DEFAULT '0',
  `payment_method` varchar(200) NOT NULL,
  `previous_amount` varchar(200) NOT NULL DEFAULT '0',
  `coupon_code` varchar(200) NOT NULL DEFAULT '0',
  `used_amount` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sale`
--


-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `sale_item_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `qty` double NOT NULL,
  `unit` enum('gram','kg','nos') NOT NULL,
  `unit_value` double NOT NULL,
  `price` double NOT NULL,
  `qty_in_kg` double NOT NULL,
  `rewards` varchar(200) NOT NULL,
  `product_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sale_items`
--



-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` varchar(200) NOT NULL,
  `title` varchar(100) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `value`) VALUES
('1', 'minmum order amount', '1'),
('2', 'maxmum order amount', '7000');

-- --------------------------------------------------------

--
-- Table structure for table `signature`
--

CREATE TABLE `signature` (
  `id` int(200) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `signature` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `signature`
--



-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `slider_title` varchar(100) NOT NULL,
  `slider_url` varchar(100) NOT NULL,
  `slider_image` varchar(100) NOT NULL,
  `sub_cat` int(200) NOT NULL,
  `slider_status` int(11) NOT NULL,
  `store_id_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `slider_title`, `slider_url`, `slider_image`, `sub_cat`, `slider_status`, `store_id_login`) VALUES
(1, 'easy day', '', 'sliderofed.jpg', 0, 1, 263),
(2, 'slider2', '', 'slider.jpg', 0, 1, 263),
(4, 'big bazaar1', '', 'bbslider.jpg', 0, 1, 264),
(5, 'slider', '', 'reliance-freshlider.jpg', 0, 1, 265),
(6, 'slidermain1', '', 'slider_reliance.jpg', 0, 1, 265),
(7, 'slider', '', 'walmartslider.jpg', 0, 1, 266),
(8, 'slidermain1', '', 'walmartslider2.jpg', 0, 1, 266),
(9, 'main slider1', '', 'banner_(1).png', 0, 1, 264),
(11, 'Nasi goreng', '', 'ic_launcher.png', 0, 1, 282),
(12, 'Nasi goreng', '', 'ic_launcher1.png', 0, 1, 282),
(13, 'Vegetables', '', 'fresh_vegetables_hhp_stores.jpg', 0, 1, 292),
(14, 'Grocery & Staples', '', 'grocery_banner.jpg', 0, 1, 293);

-- --------------------------------------------------------

--
-- Table structure for table `socity`
--

CREATE TABLE `socity` (
  `socity_id` int(11) NOT NULL,
  `socity_name` varchar(200) NOT NULL,
  `pincode` varchar(15) NOT NULL,
  `delivery_charge` double NOT NULL,
  `store_id` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `socity`
--

INSERT INTO `socity` (`socity_id`, `socity_name`, `pincode`, `delivery_charge`, `store_id`) VALUES
(7, 'nangla', '06268', 50, ''),
(8, 'abc', '282007', 40, '');

-- --------------------------------------------------------

--
-- Table structure for table `store_login`
--

CREATE TABLE `store_login` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_password` longtext NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `user_bdate` date NOT NULL,
  `is_email_varified` int(11) NOT NULL,
  `varified_token` varchar(255) NOT NULL,
  `user_gcm_code` longtext NOT NULL,
  `user_ios_token` longtext NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_main_banner` varchar(500) NOT NULL,
  `delivery_range` varchar(500) NOT NULL,
  `user_city` varchar(200) NOT NULL,
  `user_login_status` int(11) NOT NULL DEFAULT 0,
  `lat` varchar(200) NOT NULL,
  `lon` varchar(200) NOT NULL,
  `profit_percent` varchar(200) NOT NULL,
  `create_by` varchar(500) NOT NULL,
  `account_type` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_login`
--


-- --------------------------------------------------------

--
-- Table structure for table `store_paid`
--

CREATE TABLE `store_paid` (
  `id` int(200) NOT NULL,
  `store_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commision_id` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_transaction`
--

CREATE TABLE `store_transaction` (
  `id` int(200) NOT NULL,
  `store_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_date` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_transaction`
--

INSERT INTO `store_transaction` (`id`, `store_id`, `store_name`, `from_date`, `to_date`, `amount`, `transaction_id`) VALUES
(10, '264', 'Big Bazar', '2019-07-16', '2019-07-17', '23.04', '46565');

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `time_slot` int(11) NOT NULL,
  `store_id` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `time_slots`
--

-- --------------------------------------------------------

--
-- Table structure for table `top_selling`
--

CREATE TABLE `top_selling` (
  `id` int(255) NOT NULL,
  `product_price` varchar(1000) NOT NULL,
  `image_title` varchar(1000) NOT NULL,
  `img_url` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_password` longtext NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `user_bdate` date NOT NULL,
  `is_email_varified` int(11) NOT NULL,
  `varified_token` varchar(255) NOT NULL,
  `user_gcm_code` longtext NOT NULL,
  `user_ios_token` longtext NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_city` varchar(200) NOT NULL,
  `user_login_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_phone`, `user_fullname`, `user_password`, `user_type_id`, `user_bdate`, `is_email_varified`, `varified_token`, `user_gcm_code`, `user_ios_token`, `user_status`, `user_image`, `user_city`, `user_login_status`) VALUES
(1, ' venkat', 'tecmanic@gmail.com', '9876534321', 'Mr. venkat', '6b15822dadec6e84cfb87d38f0e3514b', 0, '0000-00-00', 0, '', '', '', 1, '19.png', 'noida', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_complain`
--

CREATE TABLE `user_complain` (
  `id` int(200) NOT NULL,
  `user_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_contact` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complain_id` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complain` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_complain`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_location`
--

CREATE TABLE `user_location` (
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `socity_id` int(11) NOT NULL,
  `house_no` longtext NOT NULL,
  `address` varchar(300) NOT NULL,
  `lat` varchar(300) NOT NULL,
  `lng` varchar(300) NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `receiver_mobile` varchar(15) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_location`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `user_type_id` int(11) NOT NULL,
  `user_type_title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`user_type_id`, `user_type_title`) VALUES
(1, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `user_type_access`
--

CREATE TABLE `user_type_access` (
  `user_type_id` int(11) NOT NULL,
  `class` varchar(30) NOT NULL,
  `method` varchar(30) NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type_access`
--

INSERT INTO `user_type_access` (`user_type_id`, `class`, `method`, `access`) VALUES
(0, 'admin', '*', 1),
(0, 'child', '*', 1),
(0, 'parents', '*', 1),
(0, 'timeline', '*', 1),
(0, 'users', '*', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_payment`
--
ALTER TABLE `admin_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_request`
--
ALTER TABLE `admin_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_transaction`
--
ALTER TABLE `admin_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_dashboard_banner`
--
ALTER TABLE `app_dashboard_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `closing_hours`
--
ALTER TABLE `closing_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complain`
--
ALTER TABLE `complain`
  ADD PRIMARY KEY (`complain_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_setting`
--
ALTER TABLE `currency_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deal_product`
--
ALTER TABLE `deal_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deelofday`
--
ALTER TABLE `deelofday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivered_order`
--
ALTER TABLE `delivered_order`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `delivery_assign_store`
--
ALTER TABLE `delivery_assign_store`
  ADD PRIMARY KEY (`assign_id`);

--
-- Indexes for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_charge`
--
ALTER TABLE `delivery_charge`
  ADD PRIMARY KEY (`charge_id`);

--
-- Indexes for table `feature_slider`
--
ALTER TABLE `feature_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_categories`
--
ALTER TABLE `header_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_products`
--
ALTER TABLE `header_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instamojo`
--
ALTER TABLE `instamojo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_setting`
--
ALTER TABLE `language_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pageapp`
--
ALTER TABLE `pageapp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paypal`
--
ALTER TABLE `paypal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `products_complain`
--
ALTER TABLE `products_complain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_plan`
--
ALTER TABLE `purchase_plan`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `razorpay`
--
ALTER TABLE `razorpay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registers`
--
ALTER TABLE `registers`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`sale_item_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `signature`
--
ALTER TABLE `signature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socity`
--
ALTER TABLE `socity`
  ADD PRIMARY KEY (`socity_id`);

--
-- Indexes for table `store_login`
--
ALTER TABLE `store_login`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `store_paid`
--
ALTER TABLE `store_paid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_transaction`
--
ALTER TABLE `store_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_selling`
--
ALTER TABLE `top_selling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `user_complain`
--
ALTER TABLE `user_complain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_location`
--
ALTER TABLE `user_location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `user_type_access`
--
ALTER TABLE `user_type_access`
  ADD UNIQUE KEY `user_type_id` (`user_type_id`,`class`,`method`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_payment`
--
ALTER TABLE `admin_payment`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_request`
--
ALTER TABLE `admin_request`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_transaction`
--
ALTER TABLE `admin_transaction`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `app_dashboard_banner`
--
ALTER TABLE `app_dashboard_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1325;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `closing_hours`
--
ALTER TABLE `closing_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `commission`
--
ALTER TABLE `commission`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `complain`
--
ALTER TABLE `complain`
  MODIFY `complain_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `currency_setting`
--
ALTER TABLE `currency_setting`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deal_product`
--
ALTER TABLE `deal_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `deelofday`
--
ALTER TABLE `deelofday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_assign_store`
--
ALTER TABLE `delivery_assign_store`
  MODIFY `assign_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `delivery_charge`
--
ALTER TABLE `delivery_charge`
  MODIFY `charge_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `feature_slider`
--
ALTER TABLE `feature_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `header_categories`
--
ALTER TABLE `header_categories`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `header_products`
--
ALTER TABLE `header_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instamojo`
--
ALTER TABLE `instamojo`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `language_setting`
--
ALTER TABLE `language_setting`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `plan_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pageapp`
--
ALTER TABLE `pageapp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `paypal`
--
ALTER TABLE `paypal`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=591;

--
-- AUTO_INCREMENT for table `products_complain`
--
ALTER TABLE `products_complain`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=638;

--
-- AUTO_INCREMENT for table `purchase_plan`
--
ALTER TABLE `purchase_plan`
  MODIFY `purchase_id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `razorpay`
--
ALTER TABLE `razorpay`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `registers`
--
ALTER TABLE `registers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `sale_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=479;

--
-- AUTO_INCREMENT for table `signature`
--
ALTER TABLE `signature`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `socity`
--
ALTER TABLE `socity`
  MODIFY `socity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `store_login`
--
ALTER TABLE `store_login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `store_paid`
--
ALTER TABLE `store_paid`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_transaction`
--
ALTER TABLE `store_transaction`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `top_selling`
--
ALTER TABLE `top_selling`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_complain`
--
ALTER TABLE `user_complain`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_location`
--
ALTER TABLE `user_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
