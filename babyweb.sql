CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gioitinh` varchar(10) DEFAULT 'Nam',
  `role` int(1) DEFAULT 0
);

INSERT INTO `users` (`id`, `username`, `password`, `email`, `gioitinh`, `role`) VALUES
(1, 'admin', '123456', 'admin@gmail.com', 'Nam', 1),
(2, 'dung', '123456', 'dung@gmail.com', 'Nam', 0),
(3, 'conga', '11111', 'conga@gmail.com', 'Nu', 0),
(4, 'chip', '222222', 'chip@gmail.com', 'Nu', 0),
(5, 'fake', '444444', 'fake@gmail.com', 'Nam', 0),
(6, 'hmd', '123', 'hmd@gmail.com', 'Nam', 0),
(7, 'hackerga', '111111', 'ga@gmailcom', '', 0);

CREATE TABLE `posts` (
  `post_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(255) NOT NULL,
  `created_at` date DEFAULT curdate(),
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
);

INSERT INTO `posts` (`post_id`, `title`, `content`, `created_at`, `user_id`, `username`) VALUES
(1, 'Hôm nay em c?m th?y th? nào', 'Th?t là 1 c?m giác tuy?t v?i khi ?ã hoàn thành ch?c n?ng CRUD ', '2024-12-05', 2, NULL),
(14, 'Thêm nhi?u ch?c n?ng n?a', 'Nh? là comment, upload, bla bla', '2024-12-05', NULL, 'conga'),
(15, 'Có m?i upload avt', 'mà qu?n qu?i vcl', '2024-12-06', NULL, 'hmd'),
(18, 'Thi?u ch?c n?ng gì', 'Thêm ch?c n?ng comment ?i ad', '2024-12-06', NULL, 'dung');
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL
);
INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(6, 1, 3, 'hi', '2024-12-07 00:06:37'),
(7, 18, 5, 'alo alo', '2024-12-07 00:07:54');

CREATE TABLE `avatars` (
  `user_id` int(11) NOT NULL,
  `path_to_image` varchar(255) NOT NULL
);
INSERT INTO `avatars` (`user_id`, `path_to_image`) VALUES
(1, 'uploads/469231049_1766778440759120_8916142141106969049_n.jpg'),
(2, 'uploads/466428076_581793634372863_370668594818802349_n.jpg'),
(3, 'uploads/469231049_1766778440759120_8916142141106969049_n.jpg'),
(6, 'uploads/469231049_1766778440759120_8916142141106969049_n.jpg');

-- Thêm khóa chính thôi, ràng bu?c ?? sau
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comments_ibfk_1` (`post_id`);

ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `posts`
  MODIFY `post_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);