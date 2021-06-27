CREATE DATABASE IF NOT EXISTS WebSecurityBBoard;
USE WebSecurityBBoard;

CREATE USER IF NOT EXISTS 'websecbboard'@'localhost' IDENTIFIED BY 'websecbboardpassword';
GRANT ALL PRIVILEGES ON WebSecurityBBoard.* TO 'websecbboard'@'localhost';

DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `user` int NOT NULL,
  `post` varchar(255) NOT NULL,
  `sql_used` varchar(255) DEFAULT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user`, `post`, `sql_used`, `posted_date`) VALUES
(1, 2, 'First post ever, yay!', 'INSERT INTO posts (user, post) VALUES (\'2\', \'First post ever, yay!\')', '2021-06-26 22:39:26'),
(2, 1, 'Welcome, John!  Enjoy the site.', 'INSERT INTO posts (user, post) VALUES (\'1\', \'Welcome, John!  Enjoy the site.\')', '2021-06-27 00:46:52'),
(3, 2, 'Thanks for the <strong>warm</strong> welcome!', 'INSERT INTO posts (user, post) VALUES (\'2\', \'Thanks for the <strong>warm</strong> welcome!\')', '2021-06-27 01:04:26'),
(4, 3, 'Hello everyone!', 'INSERT INTO posts (user, post) VALUES (\'3\', \'Hello everyone!\')', '2021-06-27 01:12:52'),
(6, 1, 'Welcome Amy!', 'INSERT INTO posts (user, post) VALUES (\'1\', \'Welcome Amy!\')', '2021-06-27 02:32:28');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int DEFAULT NULL,
  `about` text,
  `profile_pic` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `role`, `about`, `profile_pic`, `last_login`) VALUES
(1, 'admin@admin.com', 'Admin', 'mypassword', 1, 'I am the admin!', 'Admin', NULL),
(2, 'john@john.com', 'John', 'johnspassword', 2, 'My name is John and this is something about me.  Not much, but something.', 'John', NULL),
(3, 'amy@amy.com', 'Amy', 'amyspassword', 2, 'I prefer not to share anything about myself, sorry.', 'Amy', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_ibfk_1` (`user`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);
