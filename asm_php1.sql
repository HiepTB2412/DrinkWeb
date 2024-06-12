-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 19, 2024 lúc 07:14 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `asm_php1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Trà ', '2021-07-07 11:50:15', '2024-05-17 05:54:01'),
(2, 'Sinh tố,Nước ép', '2021-07-07 11:50:15', '2024-05-17 04:20:55'),
(3, 'Coffe', '2021-07-07 11:50:15', '2024-05-17 04:29:55'),
(38, 'Đồ ăn vặt', '2021-07-13 10:57:52', '2024-05-17 05:30:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(200) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `fullname`, `phone_number`, `email`, `address`, `note`, `order_date`) VALUES
(145, 'TIENVU', '0982324', 'ulwdgknudoryv@eurokool.com', 'sdasdsf', 'sffsdfds', '2024-05-17 09:10:03'),
(146, 'TIENVU', '0982324', 'tienvu0831dxtb@gmail.com', 'Đông Sơn', 'adasdas', '2024-05-17 09:38:03'),
(147, 'TIENVU', '0982324', 'tienvu0831dxtb@gmail.com', 'dx', 'ko', '2024-05-17 16:28:15'),
(148, 'TIENVU', '0982324', 'oqkrpmnl@triots.com', 'ab', 'ưsdsfsdf', '2024-05-17 16:42:51'),
(149, 'TIENVU', '0982324', 'nromii.contact@gmail.com', '1', 'ádasd', '2024-05-17 16:46:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` float NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `id_user`, `num`, `price`, `status`) VALUES
(155, 146, 56, 7, 2, 35000, 'Đã nhận hàng'),
(156, 147, 52, 7, 3, 40000, 'Đang chuẩn bị'),
(157, 148, 45, 7, 1, 35000, 'Đang chuẩn bị'),
(158, 149, 57, 7, 1, 35000, 'Đang chuẩn bị');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `number` float NOT NULL,
  `thumbnail` varchar(500) NOT NULL,
  `content` longtext NOT NULL,
  `id_category` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `title`, `price`, `number`, `thumbnail`, `content`, `id_category`, `created_at`, `updated_at`) VALUES
(2, 'Trà Sen Vàng', 35000, 50, 'uploads/TRASENVANG.png', '<font color=\"#000000\">Thức uống chinh phục những thực khách khó tính! Sự kết hợp độc đáo giữa trà Ô long, hạt sen thơm bùi và củ năng giòn tan. Thêm vào chút sữa sẽ để vị thêm ngọt ngào.</font><br>', 1, '2021-07-07 17:41:08', '2021-08-15 16:53:50'),
(8, 'Trà sữa trân trâu đen', 50000, 10, 'uploads/Trà-sữa-Trân-châu-đen-1.png', '<p><span style=\"color: rgb(0, 0, 0); font-family: \" times=\"\" new=\"\" roman\";=\"\" font-size:=\"\" 20px;=\"\" font-weight:=\"\" 700;=\"\" text-align:=\"\" center;\"=\"\">Trà sữa trân trâu đường đen</span><br></p>', 1, '2021-07-11 16:07:58', '2021-08-15 16:44:51'),
(9, 'Trà sữa Matcha', 25000, 46, 'uploads/TRATHANHDAO.png', '<p>Trà sữa Matcha<br></p>', 1, '2021-07-11 16:38:58', '2021-08-15 16:02:52'),
(18, 'Trà Thạch Đào', 50000, 10, 'uploads/TRATHANHDAO.png', '<p><span style=\"color: rgb(0, 0, 0); font-size: 1rem;\">Vị trà đậm đà kết hợp cùng những miếng đào thơm ngon mọng nước cùng thạch đào giòn dai. Thêm vào ít sữa để gia tăng vị béo</span><br></p><p><br></p>', 1, '2021-07-11 16:07:58', '2021-08-15 16:48:55'),
(19, 'Trà Thạch Vải', 50000, 46, 'uploads/TRATHACHVAI_1.png', '<p>Một sự kết hợp thú vị giữa trà đen, những quả vải thơm ngon và thạch giòn khó cưỡng, mang đến thức uống tuyệt hảo!<br></p>', 1, '2021-07-11 16:38:58', '2021-08-15 16:03:56'),
(20, 'Trà Đào', 50000, 44, 'uploads/TRATHANHDAO (1).png', '<p><span style=\"color: rgb(83, 56, 44); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Một sự kết hợp thú vị giữa trà đen, những quả vải thơm ngon và thạch giòn khó cưỡng, mang đến thức uống tuyệt hảo!</span><br></p>', 1, '2021-07-11 16:12:59', '2021-08-15 16:20:56'),
(43, 'Ô Long Sữa Trân Châu Ngũ Cốc', 25000, 100, 'uploads/Ô Long Sữa Trân Châu Ngũ Cốc.png', '<p>Trà sữa ô long khói thanh nhiệt thơm béo, topping trân châu ngũ cốc dẻo bùiđược làm từ khoai langĐà Lạt. Sản phẩm có thể uống nóng hoặc lạnh<br></p>', 1, '2024-05-17 09:05:00', '2024-05-17 09:05:00'),
(44, 'Trà sữa ba anh em', 25, 100, 'uploads/Trà sữa ba anh em.png', '<p>Vị trà sữa thơm béo đậm đà đặc trưng với 3 loại topping: pudding phô mai tươi dẻo thơm, topping trân châu sợi và trân châu hoàng kim dẻo dai kích thích vị giác<br></p>', 1, '2024-05-17 09:48:00', '2024-05-17 09:48:00'),
(45, 'Trà sữa okinawa', 35000, 100, 'uploads/Trà sữa okinawa.png', '<p>Hương siro okinawa hoà cùng hồng trà và sữa béo thơm. Có sẵn topping thạch cà phê giòn sần sật, thạch sương sáo mềm mướt và trân châu hoàng kim dẻo thơm<br></p>', 1, '2024-05-17 09:02:02', '2024-05-17 09:02:02'),
(46, ' Trà sữa phô mai tươi', 40000, 100, 'uploads/Trà sữa phô mai tươi.png', '<p>Hồng trà đậm đà hoà cùng sữa béo béo, kết hợp pudding phô mai tươi thơm thơm,vừa dẻo lại vừa mịn kích thích vị giác<br></p>', 1, '2024-05-17 09:42:02', '2024-05-17 09:42:02'),
(47, 'Americano', 35000, 100, 'uploads/americano.jpg', '<p>Americano tại Highlands Coffee là sự kết hợp giữa cà phê espresso thêm vào nước đun sôi.Bạn có thể tùy thích lựa chọn uống nóng hoặc dùng chung với đá.<br></p>', 3, '2024-05-17 09:17:03', '2024-05-17 09:17:03'),
(48, 'Bạc xỉu', 29, 200, 'uploads/bạc xỉu đá.jpg', '<p>Nếu Phin Sữa dành cho các bạn đam mê vị đậm đà, thì Bạc Xỉu là một sự lựa chọn nhẹ “đô\" cà phê nhưng vẫn thơm ngon, chất lừ không kém!<br></p>', 3, '2024-05-17 09:02:04', '2024-05-17 09:02:04'),
(49, 'Cappucino', 35000, 100, 'uploads/cappucino.jpg', '<p>Ly cà phê sữa đậm đà thời thượng! Một chút đậm đà hơn so với Latte, Cappuccino của chúng tôi bắt đầu với cà phê espresso, sau đó thêm một lượng tương đương giữa sữa tươi và bọt sữa cho thật hấp dẫn. Bạn có thể tùy thích lựa chọn uống nóng hoặc dùng chung với đá.<br></p>', 3, '2024-05-17 09:40:04', '2024-05-17 09:40:04'),
(50, 'Caramel Macchiato', 40000, 100, 'uploads/caramel macchiato.jpg', '<p>Thỏa mãn cơn thèm ngọt! Ly cà phê Caramel Macchiato bắt đầu từ dòng sữa tươi và lớp bọt sữa béo ngậy, sau đó hòa quyện cùng cà phê espresso đậm đà và sốt caramel ngọt ngào. Thông qua bàn tay điêu luyện của các chuyên gia pha chế, mọi thứ hoàn toàn được nâng tầm thành nghệ thuật! Bạn có thể tùy thích lựa chọn uống nóng hoặc dùng chung với đá.<br></p>', 3, '2024-05-17 09:09:05', '2024-05-17 09:09:05'),
(51, 'Latte', 35000, 100, 'uploads/AMERICANO.png', '<p>Ly cà phê sữa ngọt ngào đến khó quên! Với một chút nhẹ nhàng hơn so với Cappuccino, Latte của chúng tôi bắt đầu với cà phê espresso, sau đó thêm sữa tươi và bọt sữa một cách đầy nghệ thuật. Bạn có thể tùy thích lựa chọn uống nóng hoặc dùng chung với đá.<br></p>', 3, '2024-05-17 09:17:06', '2024-05-17 09:17:06'),
(52, 'Mocha Mocchiato', 40000, 100, 'uploads/mocha mocchiato.jpg', '<p>Một thức uống yêu thích được kết hợp bởi giữa sốt sô cô la ngọt ngào, sữa tươi và đặc biệt là cà phê espresso đậm đà mang thương hiệu Highlands Coffee. Bạn có thể tùy thích lựa chọn uống nóng hoặc dùng chung với đá.<br></p>', 3, '2024-05-17 09:57:06', '2024-05-17 09:57:06'),
(53, 'Phindi Choco', 40000, 100, 'uploads/phindi choco.jpg', '<p>PhinDi Choco - Cà phê Phin thế hệ mới với chất Phin êm hơn, kết hợp cùng Choco ngọt tan mang đến hương vị mới lạ, không thể hấp dẫn hơn!<br></p>', 3, '2024-05-17 09:27:07', '2024-05-17 09:27:07'),
(54, 'Phindi kem sữa', 30000, 100, 'uploads/phindi kem sữa.jpg', '<p>PhinDi Kem Sữa - Cà phê Phin thế hệ mới với chất Phin êm hơn, kết hợp cùng Kem Sữa béo ngậy mang đến hương vị mới lạ, không thể hấp dẫn hơn!<br></p>', 3, '2024-05-17 09:04:08', '2024-05-17 09:04:08'),
(55, 'nước ép Thơm', 35000, 122, 'uploads/nuoc-ep-thom.png', '<p>Nước ép thơm có màu vàng sáng, vị ngọt và hơi chua nhẹ, mùi thơm đặc trưng của dứa. Đây là loại nước ép giải khát tốt và giúp cung cấp nhiều vitamin C, enzyme bromelain có lợi cho tiêu hóa.<br></p>', 2, '2024-05-17 09:37:34', '2024-05-17 09:37:34'),
(56, 'nước ép Cam', 35000, 122, 'uploads/nuoc-ep-cam.png', '<p>Nước ép từ quả cam, có màu cam tươi sáng, vị ngọt dịu, đôi khi có chút chua nhẹ. Nước ép cam rất giàu vitamin C, giúp tăng cường hệ miễn dịch, tốt cho da và mắt.<br></p>', 2, '2024-05-17 09:04:35', '2024-05-17 09:04:35'),
(57, 'nước ép Dâu', 35000, 122, 'uploads/nuoc-ep-dau.png', '<p>Nước ép từ quả dâu tây, có màu đỏ rực rỡ, vị ngọt ngào, hương thơm quyến rũ. Dâu tây chứa nhiều chất chống oxy hóa, vitamin C và mangan, tốt cho sức khỏe tim mạch và da.<br></p>', 2, '2024-05-17 09:29:35', '2024-05-17 09:29:35'),
(58, 'nước ép Táo', 35000, 122, 'uploads/nuoc-ep-tao.png', '<p>Nước ép được làm từ quả táo, có màu vàng nhạt hoặc xanh lá cây, vị ngọt thanh, mùi thơm đặc trưng của táo. Nước ép táo giúp làm sạch hệ tiêu hóa, cung cấp nhiều vitamin và khoáng chất như vitamin C, K và kali.<br></p>', 2, '2024-05-17 09:57:35', '2024-05-17 09:57:35'),
(59, 'nước ép Táo Dâu', 35000, 122, 'uploads/nước ép táo dâu.png', '<p>Là sự kết hợp giữa nước ép táo và dâu tây, có màu hồng nhạt hoặc đỏ nhạt, vị ngọt hòa quyện giữa táo và dâu tây, hương thơm hấp dẫn. Loại nước ép này kết hợp lợi ích của cả hai loại trái cây, rất giàu vitamin và chất chống oxy hóa.<br></p>', 2, '2024-05-17 09:31:36', '2024-05-17 09:31:36'),
(60, 'nước ép Bưởi', 35000, 122, 'uploads/nuoc-ep-buoi.png', '<p>Nước ép từ quả bưởi, có màu hồng nhạt hoặc vàng nhạt, vị chua nhẹ, hơi đắng nhưng rất tươi mát. Bưởi chứa nhiều vitamin C, A và chất chống oxy hóa, giúp giảm cân, cải thiện tiêu hóa và tăng cường hệ miễn dịch.<br></p>', 2, '2024-05-17 09:00:37', '2024-05-17 09:00:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `hoten` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone` varchar(28) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id_user`, `hoten`, `username`, `password`, `phone`, `email`) VALUES
(7, 'vũ văn tiến', 'tienvu', 'tienvu', '+84387578520', 'bossryo68@gmail.com'),
(8, 'thanh dang', 'thanhthanh', 'thanhthanh', '0387578520', 'bossryo6811@gmail.com'),
(55, 'thanh dang', 'thanh0990909', 'thanh10', '0387578520', 'bossryoa68@gmail.com'),
(57, 'thanh dang', 'thanh', 'thanh', '0387578520', 'bossryo681@gmail.com'),
(58, 'thanh dang', 'LoginLogin', 'thanh', '0387578520', 'bossryo6Login8@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `id_user` (`id_user`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
