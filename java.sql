-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2024 at 06:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `java`
--

-- --------------------------------------------------------

--
-- Table structure for table `docgia2`
--

CREATE TABLE `docgia2` (
  `readerId` int(11) NOT NULL,
  `readername` varchar(30) NOT NULL,
  `lop` varchar(30) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `docgia2`
--

INSERT INTO `docgia2` (`readerId`, `readername`, `lop`, `gender`, `email`, `phone`) VALUES
(0, 'Thao', '12', 'Nữ', 'thaoklool@gmail.com', 376062380),
(1, 'a', '12', 'Nam', '1', 1),
(3, 'ac', '13', 'Nam', 'sd', 134),
(5, 'Phạm Thị Kim Dung', '72DCTT23', 'Nữ', 'dung@gmail.com', 998765345),
(6, 'Trần Thị Hồng Ánh', '72DCTT23', 'Nữ', 'anh@gmail.com', 937848932),
(7, 'Đỗ Thị Phương Thảo', '72DCTT23', 'Nữ', 'thao@gmai.com', 523456786),
(8, 'Lê Thị Phương Hoa', '72DCTT23', 'Nữ', 'hoa@gmail.com', 876543453),
(9, 'Hoàng Hải Nam', '72DCTT24', 'Nam', 'nam@gamilcom', 987654323),
(10, 'Nguyễn Quang Hưng', '72DCTT24', 'Nam', 'hung@gmail.com', 965432345),
(11, 'Đỗ Ngọc Khanh', '72DCTT25', 'Nam', 'khanh@gmailcom', 765432345),
(12, 'Bùi Hông Khanh', '72DCTT23', 'Nữ', 'khanh@gmail.com', 234567890),
(13, 'Nguyễn Thị Như Quỳnh', '73DCTT24', 'Khác', 'quynh@gmail.com', 123456677),
(14, 'kjnj', 'tt56', 'Nam', 'db@', 567890876);

-- --------------------------------------------------------

--
-- Table structure for table `phieu_muon`
--

CREATE TABLE `phieu_muon` (
  `id_phieu_muon` int(11) NOT NULL,
  `bookId` int(11) NOT NULL,
  `readerID` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `phi_muon` varchar(40) NOT NULL,
  `ngay_muon` date NOT NULL,
  `ngay_tra` date NOT NULL,
  `tinh_trang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieu_muon`
--

INSERT INTO `phieu_muon` (`id_phieu_muon`, `bookId`, `readerID`, `so_luong`, `phi_muon`, `ngay_muon`, `ngay_tra`, `tinh_trang`) VALUES
(28, 1, 1, 1, '2001', '2024-04-16', '2024-04-25', 'Đã Trả'),
(29, 3, 6, 5, '20000', '2024-04-01', '2024-04-26', 'Đang Mượn'),
(30, 1, 1, 1, '10000', '2024-04-02', '2024-04-23', 'Đang Mượn'),
(31, 6, 8, 2, '5000', '2024-04-01', '2024-04-25', 'Đang Mượn'),
(32, 8, 5, 1, '5000', '2024-04-09', '2024-04-05', 'Đã Trả'),
(33, 36, 12, 1, '20000', '2024-04-03', '2024-04-11', 'Đang Mượn');

--
-- Triggers `phieu_muon`
--
DELIMITER $$
CREATE TRIGGER `update_phieu_tra` AFTER INSERT ON `phieu_muon` FOR EACH ROW BEGIN INSERT INTO phieu_tra (id_phieu_muon, tinh_trang) VALUES (NEW.id_phieu_muon, 'Đang Mượn'); END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `phieu_tra`
--

CREATE TABLE `phieu_tra` (
  `id_phieu_tra` int(11) NOT NULL,
  `id_phieu_muon` int(11) NOT NULL,
  `tinh_trang` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieu_tra`
--

INSERT INTO `phieu_tra` (`id_phieu_tra`, `id_phieu_muon`, `tinh_trang`) VALUES
(1, 4, 'Đang Mượn'),
(2, 2, 'Đã Trả'),
(5, 7, 'Đã Trả'),
(7, 9, 'Đã Trả'),
(8, 10, 'Đã Trả'),
(9, 11, 'Đang Mượn'),
(10, 12, 'Đã Trả'),
(11, 13, 'Đang Mượn'),
(12, 14, 'Đã Trả'),
(13, 15, 'Đang Mượn'),
(14, 16, 'Đang Mượn'),
(15, 17, 'Đang Mượn'),
(16, 18, 'Đang Mượn'),
(17, 19, 'Đang Mượn'),
(18, 20, 'Đang Mượn'),
(19, 21, 'Đang Mượn'),
(20, 22, 'Đang Mượn'),
(21, 23, 'Đang Mượn'),
(22, 24, 'Đang Mượn'),
(23, 25, 'Đang Mượn'),
(24, 26, 'Đang Mượn'),
(25, 27, 'Đang Mượn'),
(26, 28, 'Đang Mượn'),
(27, 29, 'Đang Mượn'),
(28, 30, 'Đang Mượn'),
(29, 31, 'Đang Mượn'),
(30, 32, 'Đang Mượn'),
(31, 33, 'Đang Mượn');

-- --------------------------------------------------------

--
-- Table structure for table `qlythe`
--

CREATE TABLE `qlythe` (
  `ID` int(11) NOT NULL,
  `IDDocGia` int(11) NOT NULL,
  `NgayDangKy` date NOT NULL,
  `NgayHetHan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qlythe`
--

INSERT INTO `qlythe` (`ID`, `IDDocGia`, `NgayDangKy`, `NgayHetHan`) VALUES
(1, 3, '2024-04-03', '2024-04-06'),
(3, 5, '2024-04-08', '2024-04-08'),
(12, 1, '2024-04-03', '2024-04-07');

-- --------------------------------------------------------

--
-- Table structure for table `themsach`
--

CREATE TABLE `themsach` (
  `bookID` int(11) NOT NULL,
  `bookName` varchar(100) NOT NULL,
  `language` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `themsach`
--

INSERT INTO `themsach` (`bookID`, `bookName`, `language`, `price`, `quantity`, `category`, `publisher`, `year`) VALUES
(22, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(23, 'english', 'englisha', 200000, 200000, '40', 'Kim Đồng', '2003'),
(24, 'english', 'englisha', 0, 200000, '40', 'Kim Đồng', '2003'),
(25, 'english', 'englisha', 0, 200000, '40', 'Kim Đồng', '2003'),
(26, 'english', 'tiếng anh', 20, 200000, '40', 'Kim Đồng', '2003'),
(27, 'english', 'englisha', 0, 200000, '40', 'Kim Đồng', '2003'),
(28, 'english', 'englisha', 0, 200000, '40', 'Kim Đồng', '2003'),
(29, 'englishaa', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(31, 'english', 'englisha', 0, 200000, '40', 'Kim Đồng', '2003'),
(32, 'english', 'englisha', 0, 200000, '40', 'Kim Đồng', '2003'),
(33, 'english', 'englisha', 0, 200000, '40', 'Kim Đồng', '2003'),
(34, 'english', 'englisha', 0, 200000, '40', 'Kim Đồng', '2003'),
(35, 'english', 'englisha', 0, 200000, '40', 'Kim Đồng', '2003'),
(37, 'Ngữ Văn', 'Tiếng Việt', 0, 20000, '5', 'Kim Đồng', '2013'),
(38, 'Toán', 'Tiếng Anh', 30000, 4, 'Giáo Trình', 'Kim Đồng', '2003'),
(41, 'Mỹ Thuật', 'Tiếng Anh', 5000000, 3, 'Giáo Trình', 'Kim Đồng', '2003'),
(42, 'Thể Dục', 'Tiếng Việt', 5000000, 2, 'Giáo Trình', 'Kim Đồng', '2003'),
(43, 'Mỹ Thuật', 'Tiếng Anh', 50000000, 13, 'Giáo Trình', 'Kim Đồng', '2000'),
(44, 'Ngữ Văn', 'Tiếng Anh', 20000, 3, 'Giáo Trình', 'Kim Đồng', '2000'),
(46, 'Toán', 'Tiếng Anh', 50000000, 3, 'Giáo Trình', 'Kim Đồng', '2000'),
(47, 'Thể Dục', 'Tiếng Việt', 50000000, 1, 'Giáo Trình', 'Kim Đồng', '2000'),
(48, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(49, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(50, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(51, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(52, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(53, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(54, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(55, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(56, 'Toán a', 'Tiếng Anh', 30000, 4, 'Giáo Trình', 'Kim Đồng', '2005'),
(57, 'Toán', 'Tiếng Anh', 30000, 4, 'Giáo Trình', 'Kim Đồng', '2003'),
(59, 'englisha', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(61, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(62, 'english', 'englisha', 2001, 200001, '40', 'Kim Đồng', '2003'),
(63, ' Ngôn Ngữ JavaaA', 'Tiếng Việt', 20000, 5, 'Giáo trình', 'Tài Chính', '2013');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `docgia2`
--
ALTER TABLE `docgia2`
  ADD PRIMARY KEY (`readerId`);

--
-- Indexes for table `phieu_muon`
--
ALTER TABLE `phieu_muon`
  ADD PRIMARY KEY (`id_phieu_muon`);

--
-- Indexes for table `phieu_tra`
--
ALTER TABLE `phieu_tra`
  ADD PRIMARY KEY (`id_phieu_tra`),
  ADD KEY `id_phieu_muon` (`id_phieu_muon`);

--
-- Indexes for table `qlythe`
--
ALTER TABLE `qlythe`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_DocGia` (`IDDocGia`);

--
-- Indexes for table `themsach`
--
ALTER TABLE `themsach`
  ADD PRIMARY KEY (`bookID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phieu_muon`
--
ALTER TABLE `phieu_muon`
  MODIFY `id_phieu_muon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `phieu_tra`
--
ALTER TABLE `phieu_tra`
  MODIFY `id_phieu_tra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `themsach`
--
ALTER TABLE `themsach`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `qlythe`
--
ALTER TABLE `qlythe`
  ADD CONSTRAINT `ID_DocGia` FOREIGN KEY (`IDDocGia`) REFERENCES `docgia2` (`readerId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
