-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 05, 2025 lúc 10:26 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webthuctap`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_khachhang` int(11) NOT NULL,
  `code_cart` varchar(10) NOT NULL,
  `cart_status` int(11) NOT NULL,
  `cart_date` varchar(50) NOT NULL,
  `cart_payment` varchar(50) NOT NULL,
  `cart_shipping` int(11) NOT NULL,
  `email_sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id_cart`, `id_khachhang`, `code_cart`, `cart_status`, `cart_date`, `cart_payment`, `cart_shipping`, `email_sent`) VALUES
(204, 123, '427303', 2, '2025-05-02 04:21:18', 'tienmat', 37, 0),
(205, 125, '979056', 3, '2025-05-02 11:54:40', 'tienmat', 38, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_details`
--

CREATE TABLE `cart_details` (
  `id_cart_details` int(11) NOT NULL,
  `code_cart` varchar(10) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `soluong_buy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_details`
--

INSERT INTO `cart_details` (`id_cart_details`, `code_cart`, `id_sanpham`, `soluong_buy`) VALUES
(307, '427303', 66, 1),
(308, '427303', 68, 1),
(309, '979056', 75, 1),
(310, '979056', 81, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id_sanpham` int(11) NOT NULL,
  `tensanpham` varchar(250) NOT NULL,
  `masp` varchar(100) NOT NULL,
  `giasp` varchar(100) NOT NULL,
  `soluong` int(11) NOT NULL,
  `soluongban` int(11) DEFAULT NULL,
  `hinhanh` varchar(50) NOT NULL,
  `tomtat` tinytext NOT NULL,
  `tinhtrang` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id_sanpham`, `tensanpham`, `masp`, `giasp`, `soluong`, `soluongban`, `hinhanh`, `tomtat`, `tinhtrang`, `id`) VALUES
(66, 'Quần Short logo Teelab', '489104', '50000', 98, 2, '1745478378_anh1.jpg', '<p>Quần đ&ugrave;i basic d&acirc;y r&uacute;t chất cotton thỏa m&aacute;i tho&aacute;ng m&aacute;t thấm h&uacute;t mồ h&ocirc;i năng động được l&agrave;m bằng chất liệu ni ch&acirc;n cua m&agrave;u kem.&nbsp;</p>', 1, 67),
(67, 'Quần Short ZONEF CLUB', '488062', '80000', 100, NULL, '1745479732_anh2.jpg', '<p>Quần Short Kaki ZF.CLUB Nam Nữ, Quần Đ&ugrave;i Chất Liệu Cao Cấp Tho&aacute;ng M&aacute;t Đi Chơi Đi Du Lịch ( SKK ), m&agrave;u đen</p>', 1, 67),
(68, 'Quẩn dài nỉ tăm PN STORE', '156346', '100000', 98, 2, '1745480108_anh3.jpg', '<p>Quẩn d&agrave;i nỉ tăm PN STORE nam nữ cạp chun form su&ocirc;ng ống rộng kiểu d&aacute;ng basic đen&nbsp;QNI</p>', 1, 66),
(69, 'Quần tây nam, Quần âu nam hàn quốc', '127965', '150000', 100, NULL, '1745480197_anh4.jpg', '<p>Quần t&acirc;y nam, Quần &acirc;u nam h&agrave;n quốc ống c&ocirc;n slimfit c&ocirc;ng sở vải tuyết h&agrave;n co gi&atilde;n d&agrave;y dặn PN STORE QA1. M&agrave;u be</p>', 1, 66),
(70, 'Bộ Đồ Thể Thao Nam Tập Gym Chơi Thể Thao', '907769', '200000', 100, NULL, '1745480325_anh5.jpg', '<p>Bộ Đồ Thể Thao Nam Tập Gym Chơi Thể Thao Vải Thun Lạnh Tho&aacute;ng M&aacute;t Co Gi&atilde;n Năng Động Aventino J25. M&agrave;u x&aacute;m</p>', 1, 65),
(71, 'Set Đồ Tập Yoga Gym Hibi Sports', '802635', '899000', 100, NULL, '1745480457_anh6.jpg', '<p>Set Đồ Tập Yoga Gym Hibi Sports H147 &Aacute;o Croptop C&oacute; Tay K&egrave;m M&uacute;t Ngực, Vải Hi Fabric. M&agrave;u xanh x&aacute;m</p>', 1, 65),
(72, 'Chân váy hoa xếp ly cạp chun Oxatyl M20', '484313', '185000', 100, NULL, '1745480591_anh7.jpg', '<p>Ch&acirc;n v&aacute;y hoa xếp ly cạp chun Oxatyl M20 mặc đi chơi, đi biển m&ugrave;a h&egrave;</p>', 1, 62),
(73, 'Jiashucheng Chân Váy Đuôi Cá', '932854', '200000', 100, NULL, '1745483914_anh8.jpg', '<p>Jiashucheng Ch&acirc;n V&aacute;y Đu&ocirc;i C&aacute; D&aacute;ng Chữ a Lưng Cao Thời Trang M&ugrave;a H&egrave; Cho Nữ. M&agrave;u n&acirc;u</p>', 1, 62),
(74, 'BLOOMRIDGE áo khoác nam thể thao', '441286', '400000', 100, NULL, '1745484086_anh9.jpg', '<p>BLOOMRIDGE &aacute;o kho&aacute;c nam thể thao Phong c&aacute;ch đại học Đ&agrave;n &ocirc;ng M-2XL</p>', 1, 61),
(75, 'Áo Khoác Gió 2 lớp Teelab Legacy', '825150', '280000', 99, 1, '1745484165_anh10.jpg', '<p>&Aacute;o Kho&aacute;c Gi&oacute; 2 lớp Teelab Legacy Line Jacket Chống nước Cản gi&oacute; C&oacute; t&uacute;i trong Local Brand AK074</p>', 1, 61),
(76, 'Jiashuchen Đen Đầm Gạc Dài Chia Nữ', '788860', '150000', 100, NULL, '1745484436_anh12.jpg', '<p>Jiashuchen Đen Đầm Gạc D&agrave;i Chia Nữ Xu&acirc;n H&egrave; Thu Một Từ Đơn Giản&nbsp;</p>', 1, 60),
(77, 'Jiashuchen Royal Sister 2025', '932945', '160000', 100, NULL, '1745484660_anh13.jpg', '<p>Jiashuchen Royal Sister 2025&nbsp;Phong C&aacute;ch Mới Đầm Sling Nữ M&ugrave;a H&egrave; Cao Cấp Cảm Gi&aacute;c H&ocirc;ng V&aacute;y D&agrave;i</p>', 1, 60),
(78, 'Áo Sơ Mi Nam Kẻ Sọc Dài Tay', '843826', '169000', 100, NULL, '1745484835_anh14.jpg', '<p>&Aacute;o Sơ Mi Nam Kẻ Sọc D&agrave;i Tay Chất Oxford Cao Cấp Mềm Mại V&agrave; Tho&aacute;ng M&aacute;t VESCA A88</p>', 1, 58),
(79, 'Áo sơ mi nam PN STORE dài tay giấu cúc', '614731', '120000', 100, NULL, '1745484909_anh15.jpg', '<p>&Aacute;o sơ mi nam PN STORE d&agrave;i tay giấu c&uacute;c form h&agrave;n vải lụa chống nhăn . &Aacute;o sơ mi c&ocirc;ng sở cao cấp SMGC</p>', 1, 58),
(80, 'Áo Thun Tay Ngắn Sinh Viên', '436937', '60000', 100, NULL, '1745485077_anh16.jpg', '<p>&Aacute;o Thun Tay Ngắn Sinh Vi&ecirc;n M&ugrave;a H&egrave; Thanh Ni&ecirc;n Nửa Tay K&iacute;ch Thước Rộng</p>', 1, 57),
(81, 'Áo Thun Unisex Local Brand', '346299', '300000', 99, 1, '1745485213_anh17.jpg', '<p>&Aacute;o Thun Unisex Local Brand Lourents Signature Tee - TEE1</p>', 1, 57);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_catelog`
--

CREATE TABLE `product_catelog` (
  `id` int(11) NOT NULL,
  `ten` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_catelog`
--

INSERT INTO `product_catelog` (`id`, `ten`) VALUES
(57, 'Áo thun'),
(58, 'Áo sơ mi'),
(60, 'Váy đầm'),
(61, 'Áo khoác'),
(62, 'Chân váy'),
(65, 'Đồ thể thao'),
(66, 'Quần dài'),
(67, 'Quần ngắn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping`
--

CREATE TABLE `shipping` (
  `id_shipping` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `note` varchar(255) NOT NULL,
  `id_dangky` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `shipping`
--

INSERT INTO `shipping` (`id_shipping`, `name`, `phone`, `address`, `note`, `id_dangky`) VALUES
(37, 'Trâ', 'dfg', 'sdgf', 'sgdhfn', 123),
(38, 'ưerty', 'ẻtyu', 'ưerty', 'ưerty', 125);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `email` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active',
  `role` varchar(10) NOT NULL,
  `verification_code` varchar(6) DEFAULT NULL,
  `token_expiry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email_verified`, `email`, `phone`, `diachi`, `created_at`, `updated_at`, `status`, `role`, `verification_code`, `token_expiry`) VALUES
(123, 'Hieu', '$2y$10$/OUFFsC.buoJpSPhzXfOtuueKEahVWq2cWYZQQvfhpSfLUMO94ZKa', 1, '14.trantrunghieu124@gmail.com', '0702523598', 'Thanh Khuê, Đà Nẵng', '2025-03-07 04:02:29', '2025-05-01 21:24:13', 'active', 'admin', NULL, NULL),
(125, 'Hieumap', '$2y$10$knLut72.tcIgGzsUMSa8weUWPBFnU.IcGz.8xPTlC812.o7jT6r/S', 1, 'abcdfbbb@gmail.com', '0935613038', 'Thanh Khuê, Đà Nẵng', '2025-05-02 04:54:02', '2025-05-02 04:54:24', 'active', 'user', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`);

--
-- Chỉ mục cho bảng `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`id_cart_details`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_sanpham`);

--
-- Chỉ mục cho bảng `product_catelog`
--
ALTER TABLE `product_catelog`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id_shipping`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT cho bảng `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `id_cart_details` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id_sanpham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT cho bảng `product_catelog`
--
ALTER TABLE `product_catelog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT cho bảng `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id_shipping` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
