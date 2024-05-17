-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2023 at 05:21 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_sci`
--
CREATE DATABASE IF NOT EXISTS `project_sci` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `project_sci`;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `banner_id` bigint(20) NOT NULL,
  `banner_img` varchar(255) NOT NULL,
  `banner_topic` varchar(255) NOT NULL,
  `banner_description` varchar(255) NOT NULL,
  `banner_link` longtext NOT NULL,
  `banner_created` datetime NOT NULL,
  `banner_edit` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`banner_id`, `banner_img`, `banner_topic`, `banner_description`, `banner_link`, `banner_created`, `banner_edit`) VALUES
(1, 'topev_902_645b8ca169476.png', 'test', 'test', 'https://www.facebook.com/', '2023-05-10 19:22:57', NULL),
(2, 'boba-fett-main_a8fade4d-645ba59584a84.jpeg', 'test', 'test', '', '2023-05-10 19:29:07', '2023-05-10 21:16:58'),
(3, 'prev-desktop_new-japan-market-nissan-gt-r-unveiled-93385_000000058339_c04b3480_4cca_426b_8139_6af0754254a4_6467e2454ac6b.jpg', '', '', '', '2023-05-20 03:55:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` bigint(20) NOT NULL,
  `category_unique` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_unique`, `category_name`) VALUES
(2, 'cat_333', 'ข่าวทั่วไป'),
(12, 'category_3ASG4L9NZP', 'ภาควิชาฟิสิกส์'),
(13, 'category_4MIWBPU7GX', 'ภาควิชาคณิต'),
(14, 'category_CVUGPK8N4X', 'ภาควิชาเคมี');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` bigint(20) NOT NULL,
  `news_unique` varchar(255) NOT NULL,
  `news_topic` varchar(255) NOT NULL,
  `news_banner` varchar(255) NOT NULL DEFAULT 'online-article.svg',
  `news_article` longtext NOT NULL,
  `news_category` varchar(255) DEFAULT NULL,
  `news_author` varchar(255) NOT NULL,
  `news_view` bigint(20) NOT NULL DEFAULT 0,
  `news_status` varchar(255) NOT NULL DEFAULT 'ร่าง',
  `news_created` datetime NOT NULL,
  `news_edit` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_unique`, `news_topic`, `news_banner`, `news_article`, `news_category`, `news_author`, `news_view`, `news_status`, `news_created`, `news_edit`) VALUES
(14, 'news_KFNWE7XCHU', 'กไฟกฟไ', 'honda_civic_type_R_002-646d840fc91f0.jpg', '<p>กไฟกฟไกไฟกไฟ</p>', 'cat_333', 'user_IA6LGN0ZXD', 9, 'เผยแพร่', '2023-05-23 22:10:30', '2023-05-24 10:27:11'),
(15, 'news_NB8FT92GRZ', 'กไฟกไฟกไฟ', 'ดูหนังกับหมี-ปก-2-768x433_646cd7a4a9a67.jpg', '<p>กไฟกฟไกฟไกไฟกไฟกฟไ</p>', 'cat_333', 'user_IA6LGN0ZXD', 0, 'ร่าง', '2023-05-23 22:11:32', NULL),
(16, 'news_ZNAWIOE7Q5', 'NiceCNXXXX', 'hq5MAPUc_400x400_646cdb6c1583a.jpg', '<p>dwadawdwadawdawdaw</p>', 'category_4MIWBPU7GX', 'user_IA6LGN0ZXD', 3, 'เผยแพร่', '2023-05-23 22:27:40', NULL),
(17, 'news_N4QFV8ZPL7', 'dawdawdaw', '267280398_799518398110412_3566650173291825363_n_646d38b3e259c.jpg', '<p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(68, 68, 68);font-family:Kanit;font-size:18px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:300;letter-spacing:normal;margin:0px 0px 1.5em;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"box-sizing:border-box;font-weight:400;\">สำหรับสาวกตัว H อย่าง Honda ตัวแรงในรหัส Type R ถือเป็นที่สุดแห่งความแรง เพราะนี่คือ ยานยนต์ที่รวบรวมเทคโนโลยีจากสนามแข่งที่ Honda สั่งสมมาจากมอเตอร์สปอร์ตรายการต่างๆ ทั่วโลก ทั้ง F1 BTCC และ Super GT ก่อนที่จะนำมาประยุกต์และตกผลึกเป็นองค์ความรู้ในการนำไปสู่การพัฒนาเพื่อการใช้งานบนถนนสำหรับ Road Car รุ่นต่างๆ ที่จำหน่ายอยู่ในตลาด</span></p><figure class=\"image\"><img style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(68, 68, 68);font-family:Kanit;font-size:18px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:300;letter-spacing:normal;margin-bottom:1.5em;margin-right:0px;margin-top:0px;orphans:2;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\" src=\"https://www.grandprix.co.th/wp-content/uploads/2022/01/Honda-Civic_Type_R_Sedan-2007-1600-08.jpg\" alt=\"\"></figure><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(68, 68, 68);font-family:Kanit;font-size:18px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:300;letter-spacing:normal;margin:0px 0px 1.5em;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><b style=\"box-sizing:border-box;\"><strong>จุดเริ่มต้นแห่งความเร้าใจจากสนามแข่ง</strong></b></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(68, 68, 68);font-family:Kanit;font-size:18px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:300;letter-spacing:normal;margin:0px 0px 1.5em;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"box-sizing:border-box;font-weight:400;\">ก่อนอื่นต้องบอกก่อนว่า ปรัชญาในเชิงนโยบายด้านเทคโนโลยียานยนต์ของ Honda นั้นมีส่วนผลักดันให้ทีมงานของพวกเขาเดินหน้าต่อไปเรื่อยๆ และสนามแข่งมอเตอร์สปอร์ตรายการต่างๆ คือ พื้นที่และสนามทดลององค์ความรู้ของพวกเขาก่อนที่จะนำมาใช้งานกับรถยนต์บนท้องถนน</span></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(68, 68, 68);font-family:Kanit;font-size:18px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:300;letter-spacing:normal;margin:0px 0px 1.5em;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"box-sizing:border-box;font-weight:400;\">Honda เข้าร่วมการแข่งขัน F1 มาโดยตลอด ซึ่งนับจากทศวรรษที่ 1960 ซึ่งถือเป็น 1st Era ของแบรนด์ จนกระทั่งปัจจุบัน สนามแข่ง F1 ถือเป็นห้องทดลองที่บรรดาวิศวกรของ Honda จะต้องพัฒนาเทคโนโลยียานยนต์ โดยเฉพาะเครื่องยนต์ออกมาเพื่อแข่งขันกับวิศวกรจากค่ายอื่นๆ และความสำเร็จกับการเป็นผู้สนับสนุนเครื่องยนต์ให้กัลทีมแข่งอย่าง McLaren ในช่วงรอยต่อระหว่างทศวรรษที่ 1980 และ 1990&nbsp;</span></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(68, 68, 68);font-family:Kanit;font-size:18px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:300;letter-spacing:normal;margin:0px 0px 1.5em;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\"><span style=\"box-sizing:border-box;font-weight:400;\">ตรงนี้แหละถือว่าเป็นจุดเริ่มต้นของการนำองค์ความรู้จากสนามแข่งมาถ่ายทอดลงในรถยนต์บ้าน และนำไปสู่การพัฒนาตัวแรงที่เรียกว่า Type R หรือ Type Racing ออกมาสู่ตลาด ผ่านทางรถยนต์รุ่นต่างๆ ทั้ง NSX Integra แต่ที่โด่งดังสุดๆ คือ การทำให้รถยนต์บ้านๆ อย่าง Civic มีที่ยืนอยู่ในตลาดความแรง</span></p><figure class=\"image\"><img style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(68, 68, 68);font-family:Kanit;font-size:18px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:300;letter-spacing:normal;margin-bottom:1.5em;margin-right:0px;margin-top:0px;orphans:2;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\" src=\"https://www.grandprix.co.th/wp-content/uploads/2022/01/Honda-Civic_Type_R_Sedan-2007-1600-1c.jpg\" alt=\"\"></figure>', 'cat_333', 'user_IA6LGN0ZXD', 101207, 'เผยแพร่', '2023-05-24 05:05:39', '2023-05-24 05:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `newsletter_id` bigint(20) NOT NULL,
  `newsletter_unique` varchar(255) NOT NULL,
  `newsletter_topic` varchar(255) NOT NULL,
  `newsletter_file` varchar(255) NOT NULL,
  `newsletter_author` varchar(255) NOT NULL,
  `newsletter_created` datetime NOT NULL,
  `newsletter_edit` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`newsletter_id`, `newsletter_unique`, `newsletter_topic`, `newsletter_file`, `newsletter_author`, `newsletter_created`, `newsletter_edit`) VALUES
(1, 'newsletter_SWU5TOQXXX', 'ปีที่ 1 ฉบับที่ 1 ประจำเดือน ตุลาคม - ธันวาคม 2563', 'document (14)_6467cbb65a295.pdf', 'user_IA6LGN0ZXD', '2023-05-20 02:19:18', NULL),
(2, 'newsletter_SWU5TOQIMC', 'test', 'AdminLTE 3  DataTables (1)-6467d382accaa.pdf', 'user_IA6LGN0ZXD', '2023-05-20 02:29:06', '2023-05-20 02:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `user_unique` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_fname` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_role` varchar(255) NOT NULL DEFAULT 'สมาชิก',
  `user_created` datetime NOT NULL,
  `user_edit` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_unique`, `user_email`, `user_password`, `user_fname`, `user_lname`, `user_image`, `user_role`, `user_created`, `user_edit`) VALUES
(10, 'user_IA6LGN0ZXD', 'aungsuthon.ph.62@ubu.ac.th', '$2y$10$BvHJ0y2F1GNaGRLB9QsVMeNXCq5vL3mR78D7bGzacTLrwvO6Zwmgu', 'อังศุธร', 'โพธิ์สุ', 'e8ff48847d4a23442337ee928048df4c-64686a3138672.jpg', 'แอดมิน', '2023-04-25 12:17:22', '2023-05-20 13:38:18'),
(11, 'user_61E4NF7JZ5', 'test@test.com', '$2y$10$66E6rW1bu2eHplvAFbyf2eJwpjaG5M6H2sC8E91rhJXcodFSD/T/2', 'testzz', 'test', '', 'ประชาสัมพันธ์', '2023-04-25 12:18:16', '2023-05-17 02:34:44'),
(15, 'user_9V0WLPMIY5', 'test123@test.com', '$2y$10$ZtK3.uEnYs2/xJFjieOkMOjkbc8G533.vMYKfdrnuCfK37GSEcr8m', 'test123', 'test123', NULL, 'นักสื่อสารองค์กร', '2023-05-10 09:20:55', '2023-05-10 10:12:47'),
(16, 'user_CD6H21BNVI', 'test_xd@test.com', '$2y$10$LM9aLojtdx3r4beQSVG6EeKk08iKVm9kww3JLAZfqvVNvdSxK64hO', 'อังศุธร', 'โพธิ์สุ', NULL, 'บรรณาธิการ', '2023-05-20 14:51:58', '2023-05-20 14:54:17'),
(17, 'user_DJRC90TVO7', 'monkung.mullet@gmail.com', '$2y$10$g0sa1CyDlgGguKRXeoFHYOObpT2pYut5vrNVvsuLz.Cd1OKAO3UUq', 'อังศุธร', 'โพธิ์สุ', 'e8ff48847d4a23442337ee928048df4c-646f6e1206d34.jpg', 'สมาชิก', '2023-05-20 15:16:51', '2023-05-25 21:17:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `category_ref` (`category_unique`) USING BTREE;

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`),
  ADD KEY `news_author` (`news_author`),
  ADD KEY `news_category` (`news_category`) USING BTREE;

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`newsletter_id`),
  ADD KEY `newsletter_by` (`newsletter_author`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `news_author` (`user_unique`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `newsletter_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_author` FOREIGN KEY (`news_author`) REFERENCES `users` (`user_unique`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `news_department` FOREIGN KEY (`news_category`) REFERENCES `category` (`category_unique`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD CONSTRAINT `newsletter_by` FOREIGN KEY (`newsletter_author`) REFERENCES `users` (`user_unique`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
