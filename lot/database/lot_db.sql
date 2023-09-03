-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2020 at 03:59 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lot_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE `division` (
  `id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `map_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id`, `name`, `description`, `map_img`) VALUES
(3, 'Phase 1', 'Sample', '1603089660_devSitePlansTileMobile02.jpg'),
(4, 'Phase 2 ', 'Sample only', '1603089960_devSitePlansTileMobile01.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

CREATE TABLE `lots` (
  `id` int(30) NOT NULL,
  `division_id` int(30) NOT NULL,
  `marker_position` text NOT NULL,
  `model_id` int(30) NOT NULL,
  `lot` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=lot ,2= house and lot',
  `details` text NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=unavailable,1=available,2 = reserve'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`id`, `division_id`, `marker_position`, `model_id`, `lot`, `type`, `details`, `price`, `status`) VALUES
(2, 3, '{\"top\":\"200px\",\"left\":\"233px\"}', 1, 'Lot 1 Block 1', 2, '&lt;b&gt;Area: 6400 sq. ft.&lt;/b&gt;&lt;p&gt;&lt;ul&gt;&lt;li&gt;&lt;b&gt;sample&lt;/b&gt;&lt;/li&gt;&lt;li&gt;&lt;b&gt;sample&lt;/b&gt;&lt;/li&gt;&lt;li&gt;&lt;b&gt;sample&lt;/b&gt;&lt;/li&gt;&lt;li&gt;&lt;b&gt;sample&lt;/b&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam pretium tortor a sem ultrices faucibus. Aenean placerat efficitur venenatis. Sed eros metus, imperdiet sit amet mauris eget, vehicula pellentesque justo. Proin ac nunc sed est ornare placerat. Mauris quis orci fringilla mauris imperdiet mattis.&lt;/span&gt;&lt;b&gt;&lt;/p&gt;&lt;/p&gt;', 15000, 0),
(3, 4, '{\"top\":\"148px\",\"left\":\"248px\"}', 0, 'Lot 2 Block 1', 1, 'Sample only', 500000, 1),
(4, 4, '{\"top\":\"85px\",\"left\":\"363px\"}', 1, 'Lot 23 Block 6', 2, '&lt;ul&gt;&lt;li&gt;Sample&lt;/li&gt;&lt;li&gt;Sample&lt;/li&gt;&lt;li&gt;sample&lt;/li&gt;&lt;li&gt;Test&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;b style=&quot;margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;Lorem Ipsum&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;#x2019;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 2300000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_houses`
--

CREATE TABLE `model_houses` (
  `id` int(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `cover` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `model_houses`
--

INSERT INTO `model_houses` (`id`, `title`, `description`, `cover`) VALUES
(1, 'Two-Story House', '&lt;b&gt;Area:150 sq. m.&lt;/b&gt;&lt;p&gt;&lt;ul&gt;&lt;li&gt;3 Bed Rooms&lt;/li&gt;&lt;li&gt;1 Comfort Room each Floor&lt;/li&gt;&lt;li&gt;Kitchen Area&lt;/li&gt;&lt;li&gt;Dining Area&lt;/li&gt;&lt;li&gt;Sample&lt;/li&gt;&lt;li&gt;Sample&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;', '1603095120_images.jpg'),
(2, 'Sample Model House', '&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam pretium tortor a sem ultrices faucibus. Aenean placerat efficitur venenatis. Sed eros metus, imperdiet sit amet mauris eget, vehicula pellentesque justo. Proin ac nunc sed est ornare placerat. Mauris quis orci fringilla mauris imperdiet mattis. Nam nibh leo, sollicitudin eget massa ut, consectetur pellentesque nulla. Curabitur quis mi faucibus, interdum elit sed, auctor ex. Aenean elementum ac lorem ut feugiat. Praesent varius, tortor consectetur varius iaculis, erat sem malesuada velit, in lobortis dolor nibh mollis lectus. Etiam elementum sodales ultricies. Donec non odio non urna laoreet malesuada. Donec tincidunt, purus id condimentum dapibus, tortor risus venenatis leo, in molestie lorem ante ut dui. Mauris pulvinar augue nisl, ut commodo leo blandit tristique. In hac habitasse platea dictumst. Nunc semper, nisi ac aliquet lacinia, eros massa dapibus lacus, eu interdum turpis mi vitae nisi.&lt;/span&gt;&lt;p&gt;&lt;ul&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;sample&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;sample&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;sample&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;sample&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;sample&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;sample&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/p&gt;', '1603095180_images.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reserved`
--

CREATE TABLE `reserved` (
  `id` int(30) NOT NULL,
  `lot_id` int(30) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=declined/backed out,1= reserved,2=confimed',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reserved`
--

INSERT INTO `reserved` (`id`, `lot_id`, `firstname`, `middlename`, `lastname`, `email`, `contact`, `address`, `message`, `status`, `date_created`) VALUES
(2, 2, 'Jsmith', 'C', 'Smith', 'jsmith@sample.com', '0123456548', 'Sample', 'Sample only', 2, '2020-10-20 09:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Lot Reservation Management System', 'info@sample.comm', '+6948 8542 623', '1603096200_1602738120_pngtree-purple-hd-business-banner-image_5493.jpg', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: 400; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&rsquo;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff, 3= subscriber'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_houses`
--
ALTER TABLE `model_houses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserved`
--
ALTER TABLE `reserved`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `model_houses`
--
ALTER TABLE `model_houses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reserved`
--
ALTER TABLE `reserved`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
