-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2019 at 01:47 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundress`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_no` int(11) NOT NULL,
  `category_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_no`, `category_name`) VALUES
(1, 'T-shirt and Polo'),
(2, 'Sleeveless'),
(3, 'Long Sleeve'),
(4, 'Pants'),
(5, 'Shorts'),
(6, 'Skirt'),
(7, 'Dress'),
(8, 'Blankets, Curtains, etc.'),
(9, 'Socks, Gloves, etc'),
(10, 'Towels'),
(11, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `client_inventory`
--

CREATE TABLE `client_inventory` (
  `cinv_no` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `category_no` int(11) NOT NULL,
  `cinv_itemTag` varchar(100) NOT NULL,
  `cinv_itemBrand` varchar(100) NOT NULL,
  `cinv_itemColor` varchar(100) NOT NULL,
  `cinv_noOfPieces` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_inventory`
--

INSERT INTO `client_inventory` (`cinv_no`, `client_id`, `category_no`, `cinv_itemTag`, `cinv_itemBrand`, `cinv_itemColor`, `cinv_noOfPieces`) VALUES
(1, 11, 1, 'Tshirt', 'Bench', 'Black', 1),
(2, 11, 1, 'Polo', 'Penshoppe', 'Red', 2);

-- --------------------------------------------------------

--
-- Table structure for table `laundryclient`
--

CREATE TABLE `laundryclient` (
  `client_id` int(11) NOT NULL,
  `client_fname` varchar(50) NOT NULL,
  `client_midname` varchar(50) NOT NULL,
  `client_lname` varchar(50) NOT NULL,
  `client_address` varchar(100) NOT NULL,
  `client_bdate` date DEFAULT NULL,
  `client_gender` varchar(10) DEFAULT NULL,
  `client_contact` varchar(11) NOT NULL,
  `client_email` varchar(50) NOT NULL,
  `client_password` varchar(100) NOT NULL,
  `client_user` varchar(30) NOT NULL DEFAULT 'laundryclient',
  `client_photo` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laundryclient`
--

INSERT INTO `laundryclient` (`client_id`, `client_fname`, `client_midname`, `client_lname`, `client_address`, `client_bdate`, `client_gender`, `client_contact`, `client_email`, `client_password`, `client_user`, `client_photo`) VALUES
(10, 'Chris', 'Morales', 'Munda', 'Naga, Cebu', '2012-03-12', 'Male', '12345555555', 'sample@gmail.com', '5e8ff9bf55ba3508199d22e984129be6', 'laundryclient', NULL),
(11, 'Jeah Mairi', 'Habel', 'Baya', 'Naga', '1999-08-08', 'Male', '09083057969', 'jeah@gmail.com', '004ca71f970ce151143a19e872b345cf', 'laundryclient', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `laundryhandwasher`
--

CREATE TABLE `laundryhandwasher` (
  `handwasher_id` int(11) NOT NULL,
  `lsp_id` int(10) NOT NULL,
  `handwasher_fname` varchar(30) NOT NULL,
  `handwasher_midname` varchar(20) NOT NULL,
  `handwasher_lname` varchar(30) NOT NULL,
  `handwasher_address` varchar(100) NOT NULL,
  `handwasher_bdate` date DEFAULT NULL,
  `handwasher_gender` varchar(10) DEFAULT NULL,
  `handwasher_civilstatus` varchar(10) DEFAULT NULL,
  `handwasher_contact` varchar(11) NOT NULL,
  `handwasher_username` varchar(30) NOT NULL,
  `handwasher_password` varchar(500) NOT NULL,
  `handwasher_photo` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laundryhandwasher`
--

INSERT INTO `laundryhandwasher` (`handwasher_id`, `lsp_id`, `handwasher_fname`, `handwasher_midname`, `handwasher_lname`, `handwasher_address`, `handwasher_bdate`, `handwasher_gender`, `handwasher_civilstatus`, `handwasher_contact`, `handwasher_username`, `handwasher_password`, `handwasher_photo`) VALUES
(5, 1, 'Senyora', 'Antonio', 'Santibanes', 'Sanciangco St. Cebu City', '1995-12-05', 'Female', 'Single', '09194526416', 'senyora@gmail.com', 'ef5919f641d7e49e84ad0efce30879bc', NULL),
(6, 1, 'Chris', 'Morales', 'Munda', 'Carbon Cebu City', '1970-01-01', 'Male', 'Single', '09083541248', 'chris@gmail.com', '6b34fe24ac2ff8103f6fce1f0da2ef57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `laundryowner`
--

CREATE TABLE `laundryowner` (
  `owner_id` int(11) NOT NULL,
  `owner_fname` varchar(100) NOT NULL,
  `owner_lname` varchar(100) NOT NULL,
  `owner_midname` varchar(100) NOT NULL,
  `owner_address` varchar(100) NOT NULL,
  `owner_contactno` varchar(11) NOT NULL,
  `owner_username` varchar(100) NOT NULL,
  `owner_password` varchar(100) NOT NULL,
  `owner_photo` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laundryowner`
--

INSERT INTO `laundryowner` (`owner_id`, `owner_fname`, `owner_lname`, `owner_midname`, `owner_address`, `owner_contactno`, `owner_username`, `owner_password`, `owner_photo`) VALUES
(1, 'Renante', 'Morales', 'Gucela', 'Brgy. Ermita Cebu City', '09184567854', 'renante.morales@gmail.com', 'renante', '');

-- --------------------------------------------------------

--
-- Table structure for table `laundryshop`
--

CREATE TABLE `laundryshop` (
  `shop_id` int(11) NOT NULL,
  `owner_id` int(10) NOT NULL,
  `lsp_id` int(10) NOT NULL,
  `shop_name` varchar(100) NOT NULL,
  `shop_address` varchar(100) NOT NULL,
  `shop_contactno1` varchar(11) NOT NULL,
  `shop_contactno2` varchar(11) DEFAULT NULL,
  `shop_contactno3` varchar(11) DEFAULT NULL,
  `shop_dtino` varchar(100) NOT NULL,
  `shop_dtiphoto` blob NOT NULL,
  `shop_businessno` varchar(100) NOT NULL,
  `shop_businessphoto` blob NOT NULL,
  `shop_openhours` time DEFAULT NULL,
  `shop_closehours` time DEFAULT NULL,
  `shop_username` varchar(100) NOT NULL,
  `shop_password` varchar(100) NOT NULL,
  `shop_photo` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laundryshop`
--

INSERT INTO `laundryshop` (`shop_id`, `owner_id`, `lsp_id`, `shop_name`, `shop_address`, `shop_contactno1`, `shop_contactno2`, `shop_contactno3`, `shop_dtino`, `shop_dtiphoto`, `shop_businessno`, `shop_businessphoto`, `shop_openhours`, `shop_closehours`, `shop_username`, `shop_password`, `shop_photo`) VALUES
(2, 1, 2, 'Washn\'Dry', 'Brgy. Kawit Ermita Cebu city', '4894855', '4875621', NULL, '12345689', '', '145268752', '', '08:00:00', '20:00:00', 'washndry@gmail.com', 'washndry', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `serviceprov`
--

CREATE TABLE `serviceprov` (
  `lsp_id` int(11) NOT NULL,
  `lsp_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `serviceprov`
--

INSERT INTO `serviceprov` (`lsp_id`, `lsp_type`) VALUES
(1, 'Laundry Handwasher'),
(2, 'Laundry Shop');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_no`);

--
-- Indexes for table `client_inventory`
--
ALTER TABLE `client_inventory`
  ADD PRIMARY KEY (`cinv_no`),
  ADD KEY `fk_client` (`client_id`),
  ADD KEY `fk_category` (`category_no`);

--
-- Indexes for table `laundryclient`
--
ALTER TABLE `laundryclient`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `laundryhandwasher`
--
ALTER TABLE `laundryhandwasher`
  ADD PRIMARY KEY (`handwasher_id`),
  ADD KEY `fk_lsp` (`lsp_id`);

--
-- Indexes for table `laundryowner`
--
ALTER TABLE `laundryowner`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `laundryshop`
--
ALTER TABLE `laundryshop`
  ADD PRIMARY KEY (`shop_id`),
  ADD KEY `fk_owner` (`owner_id`),
  ADD KEY `lsp_fk` (`lsp_id`);

--
-- Indexes for table `serviceprov`
--
ALTER TABLE `serviceprov`
  ADD PRIMARY KEY (`lsp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `client_inventory`
--
ALTER TABLE `client_inventory`
  MODIFY `cinv_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laundryclient`
--
ALTER TABLE `laundryclient`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `laundryhandwasher`
--
ALTER TABLE `laundryhandwasher`
  MODIFY `handwasher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `laundryowner`
--
ALTER TABLE `laundryowner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `laundryshop`
--
ALTER TABLE `laundryshop`
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `serviceprov`
--
ALTER TABLE `serviceprov`
  MODIFY `lsp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_inventory`
--
ALTER TABLE `client_inventory`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_no`) REFERENCES `category` (`category_no`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`client_id`) REFERENCES `laundryclient` (`client_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `laundryhandwasher`
--
ALTER TABLE `laundryhandwasher`
  ADD CONSTRAINT `fk_lsp` FOREIGN KEY (`lsp_id`) REFERENCES `serviceprov` (`lsp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `laundryshop`
--
ALTER TABLE `laundryshop`
  ADD CONSTRAINT `fk_owner` FOREIGN KEY (`owner_id`) REFERENCES `laundryowner` (`owner_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lsp_fk` FOREIGN KEY (`lsp_id`) REFERENCES `serviceprov` (`lsp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
