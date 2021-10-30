-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 24, 2020 at 08:31 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `connectm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

ALTER TABLE `forms` ADD `access_roles` VARCHAR(255) NULL AFTER `slug`, ADD `feedback_for` VARCHAR(255) NULL AFTER `access_roles`;

ALTER TABLE `form_submissions` ADD `feedback_for` INT(10) NULL AFTER `submitted_data`;