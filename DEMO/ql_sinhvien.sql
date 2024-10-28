-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 02:55 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ql_sinhvien`
--

-- --------------------------------------------------------

--
-- Table structure for table `lophoc`
--

CREATE TABLE `lophoc` (
  `maLop` varchar(12) NOT NULL,
  `tenLop` varchar(100) NOT NULL,
  `ghiChu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lophoc`
--

INSERT INTO `lophoc` (`maLop`, `tenLop`, `ghiChu`) VALUES
('DA21TTA', 'Đại học Công Nghệ Thông Tin A', ''),
('DA21TTB', 'Đại học Công Nghệ Thông Tin B', ''),
('DA21TTC', 'Đại học công nghệ thông tin C khóa 21', ''),
('DA21TTD', 'Đại học công nghệ thông tin D khóa 21', ''),
('DA21TYA', 'Đại học thú y A khóa 21', '');

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien`
--

CREATE TABLE `sinhvien` (
  `maSV` varchar(9) NOT NULL COMMENT 'Mã sinh viên',
  `hoLot` varchar(20) NOT NULL COMMENT 'Họ lót',
  `tenSV` varchar(10) NOT NULL COMMENT 'Tên sinh viên',
  `ngaySinh` date NOT NULL COMMENT 'Ngày sinh',
  `gioiTinh` varchar(6) NOT NULL COMMENT 'Giới tính',
  `maLop` varchar(20) NOT NULL COMMENT 'Mã Lớp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`maSV`, `hoLot`, `tenSV`, `ngaySinh`, `gioiTinh`, `maLop`) VALUES
('11222233', 'Nguyễn Hữu ', 'Luân', '2024-10-17', 'Nam', 'DA21TTC'),
('117521001', 'Phạm Quang', 'Duy', '2024-10-27', 'Nam', 'DA21TTC'),
('117521003', 'Nguyễn Hữu ', 'Luân', '2003-02-17', 'Nam', 'DA21TTC');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'HuuLuan1702', '', '$2y$10$a1ZiSOWFWO/oJoLhr8kq5O3PTqRvWMphirHiU/kHCyyZa6veRHc2O', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lophoc`
--
ALTER TABLE `lophoc`
  ADD PRIMARY KEY (`maLop`);

--
-- Indexes for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`maSV`),
  ADD KEY `maLop` (`maLop`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD CONSTRAINT `sinhvien_ibfk_1` FOREIGN KEY (`maLop`) REFERENCES `lophoc` (`maLop`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
