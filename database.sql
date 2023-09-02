-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2023 at 09:51 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pk_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `locality` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zipcode` varchar(30) DEFAULT NULL,
  `address_type` varchar(100) NOT NULL DEFAULT 'addr'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `mobile`, `locality`, `city`, `state`, `country`, `zipcode`, `address_type`) VALUES
(2, 1, NULL, '39459809', NULL, 'New Delhi', NULL, NULL, NULL, 'primary'),
(3, 1, NULL, 'abcddd', NULL, 'abcd', NULL, NULL, NULL, 'bacd');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) NOT NULL,
  `page_id` bigint(20) NOT NULL,
  `detail` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `remarks` varchar(190) DEFAULT NULL,
  `content_group` varchar(190) NOT NULL DEFAULT 'bookmark'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `book_id`, `page_id`, `detail`, `user_id`, `remarks`, `content_group`) VALUES
(1, 280, 281, '0,1', 1, NULL, 'bookmark'),
(2, 271, 272, '0,1', 1, NULL, 'bookmark');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent` int(10) DEFAULT 0,
  `status` varchar(30) DEFAULT 'published',
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'categories.png',
  `cat_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent`, `status`, `slug`, `image`, `cat_type`) VALUES
(1, 'General', 0, 'published', 'general-page-category', 'categories.png', NULL),
(30, 'Miscellaneous', 0, 'published', 'miscellaneous', 'categories.png', NULL),
(35, 'main-slider', 0, 'published', 'main-slider', 'categories.png', 'slider'),
(36, 'Content', 0, 'published', 'pages', 'categories.png', 'content'),
(38, 'Portfolio Slider', 0, 'published', 'portfolio-slider', 'categories.png', NULL),
(42, 'Salon Services', 30, 'published', 'salon-services', 'cat_42_1648030414.jpg', 'item'),
(43, 'Makeup Artist', 42, 'published', 'makeup-artist', 'cat_43_1648030397.png', 'item'),
(45, 'Makeup Artist', 0, 'published', 'makeup-artistj', 'cat_43_1648030397.png', 'item');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `content_id` bigint(20) NOT NULL,
  `replied_to` bigint(20) DEFAULT 0,
  `comment_group` varchar(30) NOT NULL DEFAULT 'post',
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `name`, `email`, `message`, `status`, `content_id`, `replied_to`, `comment_group`, `is_active`, `created_at`, `is_approved`) VALUES
(33, 'Pradeep', 'mail2pkarn@gmail.com', 'hi spam card credit http', 'pending', 322, 0, 'post', 1, '2023-05-20 10:01:01', 1),
(34, 'ergg', 'mail2pkarn@gmail.com', 'dgdfg rthtytyjhtyj', 'pending', 322, 33, 'post', 1, '2023-05-20 11:34:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(100) DEFAULT '0',
  `company` varchar(100) DEFAULT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'enquiry',
  `status` varchar(255) DEFAULT 'new',
  `obj_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `obj_group` varchar(100) DEFAULT NULL,
  `obj_owner` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `subject`, `message`, `email`, `mobile`, `company`, `type`, `status`, `obj_id`, `obj_group`, `obj_owner`) VALUES
(8, 'Pradeep Karn', NULL, 'Write your msg here', 'pk@gmail.com', '0', NULL, 'enquiry', 'new', 34, 'product', 1),
(9, 'Pradeep', NULL, 'Web testing', 'mail2pkarn@gmail.com', '0', NULL, 'enquiry', 'new', 34, 'product', 1);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_ar` varchar(255) DEFAULT NULL,
  `content_info` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `content_ar` longtext DEFAULT NULL,
  `banner` varchar(255) DEFAULT 'page.jpg',
  `slug` varchar(190) DEFAULT NULL,
  `status` varchar(30) DEFAULT 'listed',
  `content_type` varchar(30) NOT NULL DEFAULT 'page',
  `show_title` tinyint(1) NOT NULL DEFAULT 1,
  `category` bigint(20) DEFAULT NULL,
  `post_category` varchar(255) DEFAULT 'general',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `author` varchar(100) NOT NULL DEFAULT 'author',
  `views` bigint(20) DEFAULT 0,
  `other_content` longtext DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `content_group` varchar(100) NOT NULL DEFAULT 'content',
  `currency` varchar(100) DEFAULT 'JOD',
  `price` double UNSIGNED DEFAULT 0,
  `sale_price` double UNSIGNED DEFAULT 0,
  `sku` varchar(100) DEFAULT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT 0,
  `vendor_id` int(11) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `qty` double UNSIGNED DEFAULT 1,
  `json_obj` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `genre` text DEFAULT NULL,
  `content_status` varchar(100) DEFAULT NULL,
  `is_trending` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `title_ar`, `content_info`, `content`, `content_ar`, `banner`, `slug`, `status`, `content_type`, `show_title`, `category`, `post_category`, `created_at`, `updated_at`, `author`, `views`, `other_content`, `created_by`, `content_group`, `currency`, `price`, `sale_price`, `sku`, `parent_id`, `vendor_id`, `is_active`, `qty`, `json_obj`, `genre`, `content_status`, `is_trending`, `is_featured`) VALUES
(375, 'North Indian', NULL, 'North Indian Food', NULL, NULL, 'f8.png', 'north-indian', 'listed', 'page', 1, NULL, 'general', '2023-07-21 11:24:51', '2023-07-21 11:24:51', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(376, 'Burger', NULL, 'Delicious Burger', NULL, NULL, 'f6.png', 'burger', 'listed', 'page', 1, NULL, 'general', '2023-07-21 11:25:58', '2023-07-21 11:25:58', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(379, 'Spicy Burger', NULL, 'Red Chilli, Green Chilli', 'Delicious Spicy Burger', NULL, 'shop-product1.png', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-21 12:57:59', '2023-07-21 12:57:59', 'author', 0, 'Vegetarian', 1, 'food_listing_category', 'JOD', 99, 0, NULL, 376, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(383, 'Grilled Salmon with Lemon Butter Sauce', NULL, 'Salmon, butter, lemon, salt, pepper, herbs', 'A tender fillet of salmon seasoned with herbs, grilled to perfection, and served with a delightful lemon butter sauce.', NULL, 'f8.png', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-21 13:12:23', '2023-07-21 13:12:23', 'author', 0, 'Vegetarian, Gluten-free, Vegan', 1, 'food_listing_category', 'JOD', 299, 0, NULL, 374, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(422, 'test', NULL, 'tets', 'test', NULL, 'r2.png', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-21 16:47:44', '2023-07-21 16:47:44', 'author', 0, 'tetst', 1, 'food_listing_category', 'JOD', 999, 0, NULL, 375, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(424, 'dummy', NULL, 'dummyy', 'Dummy', NULL, 'f6.png', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-21 16:54:53', '2023-07-21 16:54:53', 'author', 0, 'dummy', 1, 'food_listing_category', 'JOD', 88, 0, NULL, 376, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(425, 'Spicy Burger', NULL, 'Extra Cheese, Green Chilli', 'Delicious Spicy Burger', NULL, 'shop-product1.png', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-21 17:27:09', '2023-07-21 17:27:09', 'author', 0, 'Vegetarian', 1, 'food_listing_category', 'JOD', 99, 0, NULL, 376, 5, 1, 0, NULL, NULL, NULL, 0, 0),
(426, 'Chole Bhature', NULL, 'Delicious Chole Bhature', NULL, NULL, 'f4.png', 'chole-bhature', 'listed', 'page', 1, NULL, 'general', '2023-07-22 13:47:32', '2023-07-22 13:47:32', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(427, 'Dosa', NULL, 'Delicious Dosa', NULL, NULL, 'f5.png', 'dosa', 'listed', 'page', 1, NULL, 'general', '2023-07-22 13:56:01', '2023-07-22 13:56:01', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(428, 'Idli', NULL, 'Delicious Idli', NULL, NULL, 'f7.png', 'idli', 'listed', 'page', 1, NULL, 'general', '2023-07-22 13:58:07', '2023-07-22 13:58:07', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(429, 'Cake', NULL, 'Delicious Cake', NULL, NULL, 'f9.png', 'cake', 'listed', 'page', 1, NULL, 'general', '2023-07-22 13:58:44', '2023-07-22 13:58:44', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(430, 'Thali', NULL, 'Delicious Thali', NULL, NULL, 'f10.png', 'thali', 'listed', 'page', 1, NULL, 'general', '2023-07-22 14:00:41', '2023-07-22 14:00:41', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(431, 'Biryani', NULL, 'Delicious Biryani', NULL, NULL, 'f11.png', 'biryani', 'listed', 'page', 1, NULL, 'general', '2023-07-22 14:01:21', '2023-07-22 14:01:21', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(432, 'Pizza', NULL, 'Delicious Pizza', NULL, NULL, 'f1.jpg', 'pizza', 'listed', 'page', 1, NULL, 'general', '2023-07-22 14:02:20', '2023-07-22 14:02:20', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(433, 'Paratha', NULL, 'Delicious Paratha', NULL, NULL, 'f2.png', 'paratha', 'listed', 'page', 1, NULL, 'general', '2023-07-22 14:02:59', '2023-07-22 14:02:59', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(434, 'Sandwich', NULL, 'Delicious Sandwich', NULL, NULL, 'f3.png', 'sandwich', 'listed', 'page', 1, NULL, 'general', '2023-07-22 14:03:55', '2023-07-22 14:03:55', 'author', 0, NULL, 1, 'listing_category', 'JOD', 0, 0, NULL, 0, 0, 1, 0, NULL, NULL, NULL, 0, 0),
(436, 'VM McAloo', NULL, 'Spicy, Cheese', 'A tikki delight: potato and peas patty topped with veg sauce, ketchup, tomatoes and onions with toasted buns', NULL, 'mc-burger.jpg', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-24 17:25:32', '2023-07-24 17:25:32', 'author', 0, 'Vegetarian', 115, 'food_listing_category', 'JOD', 116, 0, NULL, 376, 7, 1, 1, NULL, NULL, NULL, 0, 0),
(437, 'Veg Surprise VM', NULL, 'Cheesy', 'A surprise that will leave you wide-eyed. A scrumptious potato patty topped with a delectable italian herb sauce and shredded onions placed between perfectly toasted buns.', NULL, 'mc-burger2.jpg', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-24 17:27:08', '2023-07-24 17:27:08', 'author', 0, 'Vegetarian', 115, 'food_listing_category', 'JOD', 131, 0, NULL, 376, 7, 1, 1, NULL, NULL, NULL, 0, 0),
(438, 'VM McChicken', NULL, 'Chicken, Cheese', 'Delightfully crispy chicken sandwich with a crispy chicken patty topped with mayonnaise and shredded iceberg lettuce served on a perfectly toasty bun.', NULL, 'mc-burger3.jpg', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-24 17:29:10', '2023-07-24 17:29:10', 'author', 0, 'Non Vegetarian', 115, 'food_listing_category', 'JOD', 199, 0, NULL, 376, 7, 1, 1, NULL, NULL, NULL, 0, 0),
(439, 'VM McEgg', NULL, 'Eggs', 'An egg lover\'s delight! a unique combination of perfectly steamed egg, classic mayonnaise and chopped onions with a sprinkling of magic masala sandwiched in a toasted bun.', NULL, 'mc-burger.jpg', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-24 17:31:19', '2023-07-24 17:31:19', 'author', 0, 'Non Vegetarian', 115, 'food_listing_category', 'JOD', 116, 0, NULL, 376, 7, 1, 1, NULL, NULL, NULL, 0, 0),
(440, 'Chicken Biryani', NULL, 'Chicken, Spicies', 'Chicken Biryani Description', NULL, 'r6.png', NULL, 'listed', 'page', 1, NULL, 'general', '2023-07-27 12:04:07', '2023-07-27 12:04:07', 'author', 0, 'Non Vegetarian', 1, 'food_listing_category', 'JOD', 200, 0, NULL, 431, 8, 1, 1, NULL, NULL, NULL, 0, 0),
(441, 'VM McEgg', NULL, 'Spicy', 'An egg lover\'s delight! a unique combination of perfectly steamed egg, classic mayonnaise and chopped onions with a sprinkling of magic masala sandwiched in a toasted bun.', NULL, 'mc-burger.jpg', NULL, 'listed', 'page', 1, NULL, 'general', '2023-08-31 12:15:15', '2023-08-31 12:15:15', 'author', 0, 'Non Vegetarian', 127, 'food_listing_category', 'JOD', 116, 0, NULL, 376, 14, 1, 1, NULL, NULL, NULL, 0, 0),
(442, 'VM McChicken', NULL, 'Extra Spicy', 'Delightfully crispy chicken sandwich with a crispy chicken patty topped with mayonnaise and shredded iceberg lettuce served on a perfectly toasty bun.', NULL, 'mc-burger3.jpg', NULL, 'listed', 'page', 1, NULL, 'general', '2023-08-31 12:16:34', '2023-08-31 12:16:34', 'author', 0, 'Non Vegetarian', 127, 'food_listing_category', 'JOD', 199, 0, NULL, 376, 14, 1, 1, NULL, NULL, NULL, 0, 0),
(443, 'Veg Surprise VM', NULL, 'Cheesy', 'A surprise that will leave you wide-eyed. A scrumptious potato patty topped with a delectable italian herb sauce and shredded onions placed between perfectly toasted buns.', NULL, 'mc-burger2.jpg', NULL, 'listed', 'page', 1, NULL, 'general', '2023-08-31 12:18:02', '2023-08-31 12:18:02', 'author', 0, 'Vegetarian', 127, 'food_listing_category', 'JOD', 131, 0, NULL, 376, 14, 1, 1, NULL, NULL, NULL, 0, 0),
(444, 'VM McAloo', NULL, 'Extra Cheesy', 'A tikki delight: potato and peas patty topped with veg sauce, ketchup, tomatoes and onions with toasted buns', NULL, 'mc-burger.jpg', NULL, 'listed', 'page', 1, NULL, 'general', '2023-08-31 12:19:06', '2023-08-31 12:19:06', 'author', 0, 'Vegetarian', 127, 'food_listing_category', 'JOD', 116, 0, NULL, 376, 14, 1, 1, NULL, NULL, NULL, 0, 0),
(445, 'Pasta', NULL, 'Pepper salt', 'Delicious Pasta mi', NULL, '', NULL, 'listed', 'page', 1, NULL, 'general', '2023-08-31 12:31:35', '2023-08-31 12:31:35', 'author', 0, '', 125, 'food_listing_category', 'JOD', 100, 0, NULL, 375, 11, 1, 1, NULL, NULL, NULL, 0, 0),
(446, 'paratha', NULL, 'paratha', 'paratha', NULL, 'm9[1].jpg', NULL, 'listed', 'page', 1, NULL, 'general', '2023-08-31 13:25:27', '2023-08-31 13:25:27', 'author', 0, '', 125, 'food_listing_category', 'JOD', 200, 0, NULL, 433, 11, 1, 1, NULL, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `content_details`
--

CREATE TABLE `content_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) NOT NULL,
  `content_group` varchar(100) NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'published',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `json_obj` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_details`
--

INSERT INTO `content_details` (`id`, `content_id`, `content_group`, `heading`, `content`, `status`, `is_active`, `json_obj`) VALUES
(1, 173, 'product_more_detail', 'Listing', '15 listing included', 'published', 1, ''),
(2, 173, 'product_more_detail', 'Storage', '2 GB of storage', 'published', 1, ''),
(3, 173, 'product_more_detail', 'Support Type', 'Email support', 'published', 1, ''),
(5, 173, 'product_more_detail', 'Accessibility', 'Help center access', 'published', 1, ''),
(7, 172, 'product_more_detail', 'Listing', '20 listing included', 'published', 1, ''),
(8, 172, 'product_more_detail', 'Storage', '5 GB of storage', 'published', 1, ''),
(9, 172, 'product_more_detail', 'Support Type', 'Email and chat support', 'published', 1, ''),
(10, 172, 'product_more_detail', 'Accessibility', 'Help center access', 'published', 1, ''),
(11, 171, 'product_more_detail', 'Listing', '100 listing included', 'published', 1, ''),
(12, 171, 'product_more_detail', 'Storage', '20 GB of storage', 'published', 1, ''),
(13, 171, 'product_more_detail', 'Support Type', 'Email, chat and phone call support', 'published', 1, ''),
(14, 171, 'product_more_detail', 'Accessibility', 'Help center access', 'published', 1, ''),
(15, 422, 'product_more_img', NULL, 'test', 'approved', 1, NULL),
(16, 422, 'product_more_img', NULL, 'test', 'approved', 1, NULL),
(18, 424, 'product_more_img', NULL, 'f7424product_more_img_429670.png', 'approved', 1, NULL),
(19, 424, 'product_more_img', NULL, 'f9424product_more_img_840892.png', 'approved', 1, NULL),
(20, 425, 'product_more_img', NULL, 'f6425product_more_img_235256.png', 'approved', 1, NULL),
(21, 425, 'product_more_img', NULL, 'shop-product1425product_more_img_965091.png', 'approved', 1, NULL),
(22, 440, 'product_more_img', NULL, 'r6440product_more_img_282004.png', 'approved', 1, NULL),
(36, 22, 'menu_more_img', NULL, 'menu22menu_more_img_525569.jpg', 'approved', 1, NULL),
(37, 23, 'menu_more_img', NULL, 'italian-menu23menu_more_img_795292.jpg', 'approved', 1, NULL),
(38, 446, 'product_more_img', NULL, 'product_launch446product_more_img_760158.jpg', 'approved', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `id` bigint(20) NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rest_id` bigint(20) NOT NULL DEFAULT 0,
  `qty` float UNSIGNED NOT NULL,
  `price` float UNSIGNED NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'hold',
  `customer_email` varchar(255) DEFAULT NULL,
  `shipping_status` varchar(30) NOT NULL DEFAULT 'pending',
  `shipping_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `remark` text DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `distance` double NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`id`, `payment_id`, `item_id`, `user_id`, `rest_id`, `qty`, `price`, `status`, `customer_email`, `shipping_status`, `shipping_id`, `created_at`, `updated_at`, `remark`, `is_paid`, `distance`) VALUES
(175, 37, 444, 125, 14, 1, 116, 'paid', NULL, 'pending', NULL, '2023-09-01 16:26:14', '2023-09-01 16:26:14', NULL, 0, 1),
(176, 37, 442, 125, 14, 2, 199, 'paid', NULL, 'pending', NULL, '2023-09-01 16:26:14', '2023-09-01 16:26:14', NULL, 0, 1),
(177, 38, 446, 125, 11, 3, 200, 'paid', NULL, 'pending', NULL, '2023-09-01 16:28:44', '2023-09-01 16:28:44', NULL, 0, 1),
(178, 38, 445, 125, 11, 2, 100, 'paid', NULL, 'pending', NULL, '2023-09-01 16:28:44', '2023-09-01 16:28:44', NULL, 0, 1),
(179, 39, 446, 115, 11, 2, 200, 'paid', NULL, 'pending', NULL, '2023-09-01 16:43:07', '2023-09-01 16:43:07', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment`
--

CREATE TABLE `customer_payment` (
  `id` bigint(20) NOT NULL,
  `unique_id` varchar(255) DEFAULT NULL,
  `amount` float NOT NULL,
  `status` varchar(30) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `isd_code` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) NOT NULL,
  `locality` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` varchar(100) NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `order_note` text DEFAULT NULL,
  `landmark` text DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` bigint(20) NOT NULL,
  `genre` varchar(190) NOT NULL,
  `image` tinytext DEFAULT NULL,
  `content_group` varchar(191) DEFAULT 'book'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `genre`, `image`, `content_group`) VALUES
(1, 'fiction', NULL, 'book'),
(2, 'Comedy', NULL, 'book'),
(3, 'Horror', NULL, 'book'),
(4, 'Philosophy', NULL, 'book'),
(5, 'Literature', NULL, 'book');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `stock_qty` double NOT NULL DEFAULT 5,
  `price` double NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `tax` double NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `stock_qty`, `price`, `image`, `tax`, `created_at`, `updated_at`, `is_active`, `details`) VALUES
(1, 'TECHNOLOGY FLAT RATE', 5, 35, '', 0, '2023-04-17 13:34:16', '2023-04-17 13:34:16', 1, NULL),
(2, 'New technology', 5, 45, '', 0, '2023-04-17 13:34:16', '2023-04-17 13:34:16', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_listing`
--

CREATE TABLE `menu_listing` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `rest_id` int(11) NOT NULL DEFAULT 0,
  `menu_name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `is_listed` tinyint(4) NOT NULL DEFAULT 0,
  `jsn` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_listing`
--

INSERT INTO `menu_listing` (`id`, `user_id`, `rest_id`, `menu_name`, `description`, `is_listed`, `jsn`, `banner`) VALUES
(2, 1, 5, 'Menu 2', NULL, 1, '{\"food\": [\"425\"]}', NULL),
(23, 125, 11, 'Chinese Menu', 'Chinese Menu Desc', 1, NULL, 'chinese-menu.jpg'),
(22, 125, 11, 'Italian Menu', 'Italian Menu Description', 1, NULL, 'italian-menu.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `my_order`
--

CREATE TABLE `my_order` (
  `id` bigint(20) NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `qty` float UNSIGNED NOT NULL,
  `price` float UNSIGNED NOT NULL,
  `tax` double NOT NULL DEFAULT 0,
  `status` varchar(30) NOT NULL DEFAULT 'hold',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_status` varchar(30) NOT NULL DEFAULT 'pending',
  `shipping_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `remark` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `my_order`
--

INSERT INTO `my_order` (`id`, `payment_id`, `item_id`, `qty`, `price`, `tax`, `status`, `user_id`, `shipping_status`, `shipping_id`, `created_at`, `updated_at`, `remark`) VALUES
(11, 0, 2, 3, 10, 0, 'cart', 1, 'pending', NULL, '2023-04-17 18:07:18', '2023-04-17 18:07:18', NULL),
(12, 0, 1, 5, 20, 0, 'cart', 1, 'pending', NULL, '2023-04-17 18:07:35', '2023-04-17 18:07:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` bigint(20) NOT NULL,
  `unique_id` varchar(255) DEFAULT NULL,
  `amount` float NOT NULL,
  `status` varchar(30) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rest_id` bigint(20) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `isd_code` varchar(100) DEFAULT NULL,
  `locality` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `landmark` text DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lon` varchar(255) DEFAULT NULL,
  `distance` double DEFAULT 0,
  `unit` varchar(100) NOT NULL DEFAULT 'm',
  `deliver_by` bigint(20) NOT NULL DEFAULT 0,
  `is_delivered` tinyint(1) NOT NULL DEFAULT 0,
  `is_cancelled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `unique_id`, `amount`, `status`, `payment_method`, `user_id`, `rest_id`, `fname`, `lname`, `mobile`, `isd_code`, `locality`, `city`, `state`, `country`, `zipcode`, `created_at`, `landmark`, `lat`, `lon`, `distance`, `unit`, `deliver_by`, `is_delivered`, `is_cancelled`) VALUES
(37, '64f1c34e8888b', 514, 'paid', 'COD', 125, 14, 'Suman', 'kUmar', '9646464', '91', 'darbhanga', 'darbhanga', 'bihar', 'India', '847115', '2023-09-01 16:26:14', 'Darbhanga - Sakri Road, 846007, Gangwara, Darbhanga, Darbhanga, Bihar, India', '26.1706232', '85.9203307', 7063.115, 'm', 0, 0, 0),
(38, '64f1c3e4d6c5b', 800, 'paid', 'COD', 125, 11, 'Pradeep', 'Karn', '13212313', '91', 'Tetthan', 'Darbhanga', 'Bihar', 'India', '847115', '2023-09-01 16:28:44', 'Kharua, Darbhanga, Darbhanga, Bihar, India', '26.182091', '85.994947', 7063.115, 'm', 128, 0, 0),
(39, '64f1c74350715', 400, 'paid', 'COD', 115, 11, 'Pulkit', 'Chaddha', '654645646', '91', 'bihaR', 'DARBHANGA', 'BIHAR', 'India', '847115', '2023-09-01 16:43:07', 'Darbhanga Bypass, 846007, Ranipur, Darbhanga, Darbhanga, Bihar, India', '26.1840134', '85.9270108', 7063.115, 'm', 128, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pk_docs`
--

CREATE TABLE `pk_docs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `obj_group` varchar(255) DEFAULT NULL,
  `obj_id` bigint(20) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `media_file` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `is_active` tinyint(1) DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT 1,
  `application_id` bigint(20) DEFAULT NULL,
  `schedule_date` datetime NOT NULL DEFAULT current_timestamp(),
  `expiry_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pk_docs`
--

INSERT INTO `pk_docs` (`id`, `obj_group`, `obj_id`, `details`, `media_file`, `status`, `is_active`, `user_id`, `application_id`, `schedule_date`, `expiry_date`) VALUES
(52, 'lesson_attachment', 59, 'gerg', 'screencapture-webcache-googleusercontent-search-2022-06-13-16_45_49_1_59_lesson_attachment_196637.pdf', 'approved', 1, 1, NULL, '2022-06-17 13:31:14', '2022-06-17 13:31:14');

-- --------------------------------------------------------

--
-- Table structure for table `pk_media`
--

CREATE TABLE `pk_media` (
  `id` bigint(20) NOT NULL,
  `media_title` varchar(255) DEFAULT NULL,
  `dir_name` varchar(255) DEFAULT NULL,
  `media_file` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `is_app_banner` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pk_media`
--

INSERT INTO `pk_media` (`id`, `media_title`, `dir_name`, `media_file`, `status`, `is_app_banner`) VALUES
(1, NULL, '/media/images/pages/', '1666335826_banner_635244521233e1.jpeg', 'active', 0),
(2, NULL, '/media/images/pages/', '1666336715_banner_635247cb74f161.jpg', 'active', 0),
(3, NULL, '/media/images/pages/', '1666336772_banner_63524804eec721.jpg', 'active', 0),
(4, NULL, '/media/images/pages/', '1666341716_banner_63525b54e0bce1.png', 'active', 0),
(5, NULL, '/media/images/pages/', '1666344650_banner_635266ca1ffe31.jpeg', 'active', 0),
(6, NULL, '/media/images/pages/', '1666345127_banner_635268a748e0e1.jpg', 'active', 0),
(7, NULL, '/media/images/pages/', '1666345188_banner_635268e4358501.jpeg', 'active', 0),
(8, NULL, '/media/images/pages/', '1666345221_banner_63526905aad4b1.jpeg', 'active', 0),
(9, NULL, '/media/images/pages/', '1666345266_banner_63526932b22b51.jpg', 'active', 0),
(10, NULL, '/media/images/pages/', '1666345349_banner_6352698509faf1.jpg', 'active', 0),
(11, NULL, '/media/images/pages/', '1666345395_banner_635269b31c1b11.jpeg', 'active', 0),
(12, NULL, '/media/images/pages/', '1666345473_banner_63526a010625d1.png', 'active', 0),
(13, NULL, '/media/images/pages/', '1666345522_banner_63526a3249ebf1.jpg', 'active', 0),
(14, NULL, '/media/images/pages/', '1666345557_banner_63526a55cfc531.jpeg', 'active', 0),
(15, NULL, '/media/images/pages/', '1666345599_banner_63526a7fd7f861.jpg', 'active', 0),
(16, NULL, '/media/images/pages/', '1666345767_banner_63526b27c110d1.jpg', 'active', 0),
(17, NULL, '/media/images/pages/', '1666356986_banner_635296facdff91.jpeg', 'active', 0),
(18, NULL, '/media/images/pages/', '1666357028_banner_6352972428b541.jpeg', 'active', 0),
(19, NULL, '/media/images/pages/', '1666357117_banner_6352977dc58de1.jpeg', 'active', 0),
(20, NULL, '/media/images/pages/', '1666357158_banner_635297a615f0a1.jpeg', 'active', 0),
(21, NULL, '/media/images/pages/', '1666357196_banner_635297cc2913f1.jpg', 'active', 0),
(22, NULL, '/media/images/pages/', '1666357244_banner_635297fca21bf1.jpg', 'active', 0),
(23, NULL, '/media/images/pages/', '1666357284_banner_63529824e5fd21.jpeg', 'active', 0),
(24, NULL, '/media/images/pages/', '1666357325_banner_6352984d7893c1.jpeg', 'active', 0),
(25, NULL, '/media/images/pages/', '1666357441_banner_635298c1eb19b1.jpg', 'active', 0),
(26, NULL, '/media/images/pages/', '1666357472_banner_635298e09f59c1.jpeg', 'active', 0),
(27, NULL, '/media/images/pages/', '1666357506_banner_635299020bbe91.jpg', 'active', 0),
(28, NULL, '/media/images/pages/', 'banner_6352447de539c1666335869.png', 'active', 0),
(29, NULL, '/media/images/pages/', 'banner_6352475b054161666336603.png', 'active', 0),
(30, NULL, '/media/images/pages/', 'banner_63524785985771666336645.png', 'active', 0),
(31, NULL, '/media/images/pages/', 'cover-10_img_172196_1665050381_1.jpg', 'active', 0),
(32, NULL, '/media/images/pages/', 'cover-11_img_866668_1665050409_1.jpeg', 'active', 0),
(33, NULL, '/media/images/pages/', 'cover-1_img_13130_1665050155_1.jpeg', 'active', 0),
(34, NULL, '/media/images/pages/', 'cover-2_img_221862_1665050176_1.jpeg', 'active', 0),
(35, NULL, '/media/images/pages/', 'cover-3_img_13248_1665050189_1.jpeg', 'active', 0),
(36, NULL, '/media/images/pages/', 'cover-4_img_126700_1665050202_1.jpeg', 'active', 0),
(37, NULL, '/media/images/pages/', 'cover-5_img_385324_1665050213_1.jpeg', 'active', 0),
(38, NULL, '/media/images/pages/', 'cover-6_img_197168_1665050225_1.jpeg', 'active', 0),
(39, NULL, '/media/images/pages/', 'cover-6_img_756799_1665050294_1.jpeg', 'active', 0),
(40, NULL, '/media/images/pages/', 'cover-7_img_796003_1665050307_1.jpg', 'active', 0),
(41, NULL, '/media/images/pages/', 'cover-8_img_627295_1665050328_1.jpg', 'active', 0),
(42, NULL, '/media/images/pages/', 'cover-9_img_677238_1665050341_1.jpg', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pk_user`
--

CREATE TABLE `pk_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(190) DEFAULT NULL,
  `first_name` varchar(190) DEFAULT NULL,
  `last_name` varchar(190) DEFAULT NULL,
  `email` varchar(190) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `user_group` varchar(50) DEFAULT 'user',
  `role` varchar(100) NOT NULL DEFAULT 'subscriber',
  `isd_code` varchar(100) DEFAULT NULL,
  `mobile` varchar(190) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'unverified',
  `bio` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `zipcode` varchar(100) DEFAULT NULL,
  `company` varchar(190) DEFAULT NULL,
  `gender` enum('m','f','o') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country` varchar(190) DEFAULT NULL,
  `state` varchar(190) DEFAULT NULL,
  `city` varchar(190) DEFAULT NULL,
  `jsn` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `national_id` varchar(100) DEFAULT NULL,
  `national_id_doc` varchar(190) DEFAULT NULL,
  `driver_id` varchar(100) DEFAULT NULL,
  `driver_doc` varchar(190) DEFAULT NULL,
  `is_user` tinyint(1) NOT NULL DEFAULT 0,
  `is_driver` tinyint(1) NOT NULL DEFAULT 0,
  `is_restaurant` tinyint(1) NOT NULL DEFAULT 0,
  `dob` date DEFAULT NULL,
  `app_login_token` varchar(190) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pk_user`
--

INSERT INTO `pk_user` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `user_group`, `role`, `isd_code`, `mobile`, `status`, `bio`, `image`, `zipcode`, `company`, `gender`, `address`, `country`, `state`, `city`, `jsn`, `created_at`, `updated_at`, `is_active`, `national_id`, `national_id_doc`, `driver_id`, `driver_doc`, `is_user`, `is_driver`, `is_restaurant`, `dob`, `app_login_token`, `lat`, `lon`) VALUES
(1, 'admin', 'Pradeep', 'Karn', 'admin@gmail.com', 'e64b78fc3bc91bcbc7dc232ba8ec59e0', '05183f74a4e218fe8786a440b614b7cc510c880228c2b7210df62c4c12c3c8e5_uid_1', 'admin', 'superuser', '+91', '9801465559', 'verified', '', 'admin_6457c6e63bfa9.jpg', '847115', NULL, 'o', 'Village Lakshmipur, Post Telhan, District Darbhanga', 'India', NULL, NULL, NULL, '2023-05-07 21:26:41', '2023-05-07 21:29:47', 1, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL),
(110, 'mail2pkarn', 'Pradeep', 'Karn', 'mail2pkarn@gmail.com', '202cb962ac59075b964b07152d234b70', 'ebc461494c7b02768e4bd661a1679120c80e6b11c03fa9a1b6494c7752d2193d_uid_110', 'user', 'author', NULL, NULL, 'unverified', 'bio', 'profile_64d0ab92ab01c_110.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-07 16:20:18', '2023-05-07 21:05:21', 1, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL),
(115, NULL, 'Pulkit', 'Chadha', 'pulkitchadha114@gmail.com', '7376db47fcc04beed26874d7e518ab75', '5996d1ae7d79256b5740f8abd5beb77806d38bc17cd4314f201e68fd9baba92b_uid_115', 'customer', 'subscriber', NULL, '9884772456', 'unverified', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-19 13:31:57', NULL, 1, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, NULL, NULL),
(116, NULL, 'Testing', 'Test', 'test@gmail.com', 'cc03e747a6afbbcbf8be7668acfebee5', '0f24c39808987099a429649460e46e3bed160e988c8784b915334ed6a509ceb2_uid_116', 'customer', 'subscriber', NULL, '9575787553', 'unverified', NULL, 'profile_64d09c0cab4a5_116.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-20 17:31:11', NULL, 1, NULL, 'national_id_doc_64d09c0caba0a_116.pdf', NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL),
(117, 'test2', 'pk', 'p', 'test2@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'user', 'subscriber', NULL, '12344', 'unverified', NULL, 'profile_64d09c97833d8_117.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-07 12:54:13', NULL, 1, '12344', 'national_id_doc_64d09c9785cae_117.pdf', NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL),
(118, 'test3', 'pk', 'p', 'test3@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'user', 'subscriber', NULL, '12653725', 'unverified', NULL, 'profile_64d09cc3dbe96_118.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-07 12:56:59', NULL, 1, '12344', 'national_id_doc_64d09cc3dc239_118.pdf', NULL, NULL, 0, 1, 0, NULL, '64d09cc3e7618b221c981948b5838u118', NULL, NULL),
(119, 'driver', 'pk', 'p', 'driver@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'user', 'subscriber', NULL, '5365346', 'unverified', NULL, 'profile_64d09f287bc3d_119.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-07 12:59:37', NULL, 1, '67235423', 'national_id_doc_64d09f287c1ee_119.pdf', NULL, NULL, 0, 0, 0, NULL, '64d09d61aa8dd286af7dd6c111beeu119', NULL, NULL),
(120, 'abcd', 'P', '', 'abcd@gmail.com', '202cb962ac59075b964b07152d234b70', 'aeeeac2fe83e3f83abf8f51ac2a7305da373945dfcfa39520f57380067ea8656_uid_120', 'user', 'subscriber', NULL, '1234', 'unverified', NULL, 'profile_64d0a2ab3d7c1_120.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-07 13:22:11', NULL, 1, '123124', 'national_id_doc_64d0a2ab3db13_120.pdf', NULL, NULL, 0, 1, 0, NULL, '64d0a2ab48e4b6b92b8f6c7915015u120', NULL, NULL),
(121, 'testdt', 'tst', 'test', 'testdt@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'user', 'subscriber', NULL, '21648732', 'unverified', NULL, 'profile_64d0abb0ec0b2_121.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-07 14:00:40', NULL, 1, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, '64d0abb102cac49a40f8394aa6576u121', NULL, NULL),
(122, 'pkarn', 'tst', 'test', 'pkarn@gmail.com', '202cb962ac59075b964b07152d234b70', '8e7c27c0fae63257710eb322335c2fbebdb5ea661d551bf0a8fc95f5ee3eb49e_uid_122', 'user', 'subscriber', NULL, '1234354', 'unverified', NULL, 'profile_64d0ad7f564e8_122.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-07 14:05:37', NULL, 1, NULL, 'national_id_doc_64d0ad7f56acf_122.pdf', NULL, NULL, 1, 1, 0, NULL, '64d0acd999a9faf78cc70a10ce4e9u122', NULL, NULL),
(125, 'dummy', 'Delimacdonalds', 'user', 'dummy@gmail.com', '202cb962ac59075b964b07152d234b70', '6b9a00edafa37dba765a83a9393b1286c339ff88fd95bb3f518aacdb24812d86_uid_125', 'user', 'subscriber', NULL, NULL, 'unverified', NULL, NULL, '213131', NULL, NULL, 'Mirzapur, Darbhanga, Darbhanga, Bihar, India', NULL, NULL, NULL, NULL, '2023-08-08 12:18:40', NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, '64d1e54854fc2d1db51b198552565u125', '26.152548', '85.894543'),
(126, 'pc', NULL, NULL, 'pc@gmail.com', '5c718ebf3bd52194054375cd6a0042c1', '707d33c28b9354e2ef0871ef938d0aa8adb9d78e136e550bf39bb2c76095280e_uid_126', 'user', 'subscriber', NULL, NULL, 'unverified', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-23 11:46:08', NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, '64e5a4283e1292e62b024498bb001u126', NULL, NULL),
(127, 'mcdonald', NULL, NULL, 'mcdonald@gmail.com', '681e5acad31c5be4d26e4e2ea72bf13d', 'b335e16d3cea04da39a3c930e7c6ba228fd07fb144e8abe2bdd2d06afaf0034b_uid_127', 'user', 'subscriber', NULL, NULL, 'unverified', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-31 12:10:17', NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, '64f035d136344bc993a6f8704fbd7u127', NULL, NULL),
(128, 'sumit', 'Sumit', 'Kanth', 'sumit@gmail.com', '202cb962ac59075b964b07152d234b70', '265e38489c3f70382d4e401fb9565646c106efa8706a592fc61aa10280673e82_uid_128', 'user', 'subscriber', NULL, '1234567890', 'unverified', NULL, 'profile_64f17d6bc7654_128.jpg', '847115', NULL, NULL, 'Darbhanga, Bihar, India', NULL, NULL, NULL, NULL, '2023-09-01 11:28:03', NULL, 1, '123456', 'national_id_doc_64f17d6bc7c66_128.pdf', NULL, NULL, 0, 1, 0, NULL, '64f17d6bca0e30d75eaf36312e79du128', '26.156999', '85.899506');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_details`
--

CREATE TABLE `restaurant_details` (
  `id` bigint(20) NOT NULL,
  `restaurant_id` bigint(20) NOT NULL,
  `content_group` varchar(255) NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'published',
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `json_obj` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_details`
--

INSERT INTO `restaurant_details` (`id`, `restaurant_id`, `content_group`, `heading`, `content`, `status`, `is_active`, `json_obj`) VALUES
(1, 7, 'restaurant_more_img', NULL, 'r47product_more_img_645916.png', 'approved', 1, NULL),
(2, 7, 'restaurant_more_img', NULL, 'r57product_more_img_824982.png', 'approved', 1, NULL),
(3, 8, 'restaurant_more_img', NULL, 'f68restaurant_more_img_909898.png', 'approved', 1, NULL),
(4, 10, 'restaurant_more_img', NULL, 'cart-coffee210restaurant_more_img_233250.png', 'approved', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_listing`
--

CREATE TABLE `restaurant_listing` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rest_name` varchar(255) NOT NULL,
  `rest_address` varchar(255) NOT NULL,
  `rest_location` varchar(255) NOT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `rest_mobile` varchar(190) NOT NULL,
  `rest_landline` varchar(190) NOT NULL,
  `owner_mobile` varchar(190) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_email` varchar(255) NOT NULL,
  `banner` varchar(255) DEFAULT 'page.jpg',
  `priceforone` varchar(255) DEFAULT '0',
  `timings` varchar(255) DEFAULT NULL,
  `food_time` varchar(255) DEFAULT NULL,
  `parent_id` int(4) NOT NULL DEFAULT 0,
  `is_listed` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `ug` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_listing`
--

INSERT INTO `restaurant_listing` (`id`, `user_id`, `rest_name`, `rest_address`, `rest_location`, `latitude`, `longitude`, `rest_mobile`, `rest_landline`, `owner_mobile`, `owner_name`, `owner_email`, `banner`, `priceforone`, `timings`, `food_time`, `parent_id`, `is_listed`, `is_active`, `ug`) VALUES
(14, 127, 'McDonald\'s', 'McDonald\'s Nirman Vihar', 'McDonald\'s Nirman Vihar Ground Floor', '26.152548', '85.894543', '9484878741', '9484878722', '9484878733', 'Pulkit', 'mcdonald@gmail.com', 'r3.png', '₹250 for one', '10:00 AM To 11:00 PM', '25-35 min', 376, 1, 1, NULL),
(11, 125, 'Dummy', 'Dummy Restaurant abcd', 'Mirzapur, Darbhanga, Darbhanga, Bihar, India', '26.152548', '85.894543', '9585887578', '9585775675', '8578758775', 'Dummy', 'dummy@gmail.com', 'booking.jpg', '250 for one', '10:00 am to 11:00 pm', '25-30 min', 432, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `replied_to` bigint(20) DEFAULT 0,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `item_group` varchar(100) NOT NULL DEFAULT 'product'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_ibfk_1` (`user_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `page_id` (`page_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`content_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `content_details`
--
ALTER TABLE `content_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`content_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_payment`
--
ALTER TABLE `customer_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_listing`
--
ALTER TABLE `menu_listing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `my_order`
--
ALTER TABLE `my_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pk_docs`
--
ALTER TABLE `pk_docs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pk_media`
--
ALTER TABLE `pk_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pk_user`
--
ALTER TABLE `pk_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `restaurant_details`
--
ALTER TABLE `restaurant_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_listing`
--
ALTER TABLE `restaurant_listing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=447;

--
-- AUTO_INCREMENT for table `content_details`
--
ALTER TABLE `content_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `customer_payment`
--
ALTER TABLE `customer_payment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_listing`
--
ALTER TABLE `menu_listing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `my_order`
--
ALTER TABLE `my_order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `pk_docs`
--
ALTER TABLE `pk_docs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `pk_media`
--
ALTER TABLE `pk_media`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `pk_user`
--
ALTER TABLE `pk_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `restaurant_details`
--
ALTER TABLE `restaurant_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `restaurant_listing`
--
ALTER TABLE `restaurant_listing`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
