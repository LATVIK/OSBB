-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Тра 21 2021 р., 01:32
-- Версия сервера: 10.4.18-MariaDB
-- Версия PHP: 8.0.3


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `osbb`
--

DELIMITER $$
--
-- Процедури
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `accrualEM` ()  BEGIN
	DECLARE flatId INT;
	DECLARE cost decimal(11,2);
    DECLARE done INT DEFAULT FALSE;
	
	DECLARE flat_curs CURSOR FOR
		SELECT id
		FROM flat;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done= TRUE; 
	
	OPEN flat_curs;
	loop_flat: LOOP
	FETCH flat_curs INTO flatId;
	IF done THEN
		SET done = FALSE;
		LEAVE loop_flat;
	END IF;

	SET cost= (SELECT (rate.monthly_sum*flat.square) FROM flat inner JOIN flat_rate ON flat.id = flat_rate.flat_id INNER JOIN rate ON rate.id=flat_rate.rate_id WHERE flat.id = flatId ORDER BY flat_rate.date DESC LIMIT 1);

	
	INSERT INTO accrual (flat_id, sum, date ) 
	VALUES (flatId, cost, NOW());


	END LOOP;

	CLOSE flat_curs; 
    
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getMainPosts` ()  SELECT post.title, post.text, post.id  FROM post INNER JOIN tenant ON post.author_id = tenant.id WHERE tenant.status_id= 4 ORDER BY post.date DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getPostComments` (IN `idUser` INT(11))  SELECT CONCAT(tenant.surname, " ", tenant.name) AS name, comment.text AS text FROM tenant INNER JOIN comment ON comment.author_id = tenant.id INNER JOIN post ON post.id= comment.post_id where (post.id =idUser) ORDER BY comment.date$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sumAccrualForFlat` (IN `flat_id` INT UNSIGNED)  SELECT SUM(accrual.sum)AS sum  FROM accrual WHERE (accrual.flat_id = flat_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sumCosts` ()  SELECT SUM(costs.sum) AS sum FROM costs$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sumPayment` ()  SELECT SUM(payment.sum) AS sum FROM payment$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sumPaymentForFlat` (IN `flat_id` INT)  SELECT SUM(payment.sum) as sum  FROM payment WHERE (payment.flat_id = flat_id)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблиці `accrual`
--

CREATE TABLE `accrual` (
  `id` int NOT NULL,
  `flat_id` int NOT NULL,
  `sum` decimal(11,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `accrual`
--

INSERT INTO `accrual` (`id`, `flat_id`, `sum`, `date`) VALUES
(1, 4, '500.00', '2021-05-17 13:15:43'),
(2, 1, '75.00', '2021-05-17 13:18:38'),
(3, 2, '366.00', '2021-05-17 13:18:38'),
(4, 3, '270.00', '2021-05-17 13:18:38'),
(5, 4, '366.00', '2021-05-17 13:18:38'),
(6, 5, '90.00', '2021-05-17 13:18:38'),
(7, 6, '75.00', '2021-05-17 13:18:38'),
(8, 7, '150.00', '2021-05-17 13:18:38'),
(9, 8, '366.00', '2021-05-17 13:18:38'),
(10, 9, '366.00', '2021-05-17 13:18:38'),
(11, 10, '270.00', '2021-05-17 13:18:38'),
(12, 11, '180.00', '2021-05-17 13:18:38'),
(13, 12, '366.00', '2021-05-17 13:18:38'),
(14, 13, '270.00', '2021-05-17 13:18:38'),
(15, 14, '180.00', '2021-05-17 13:18:38'),
(16, 15, '366.00', '2021-05-17 13:18:38'),
(17, 9, '100.00', '2021-05-18 17:37:10');

-- --------------------------------------------------------

--
-- Структура таблиці `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Monthly'),
(2, 'Repair'),
(3, 'Landscaping'),
(4, 'Others');

-- --------------------------------------------------------

--
-- Структура таблиці `comment`
--

CREATE TABLE `comment` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `author_id` int NOT NULL,
  `text` varchar(1500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `author_id`, `text`, `date`) VALUES
(7, 2, 1, 'Comment', '2021-05-16 15:36:29'),
(8, 2, 4, 'well again', '2021-05-16 16:49:20'),
(9, 3, 9, 'I will come', '2021-05-16 16:55:13'),
(10, 3, 1, 'No need', '2021-05-16 16:58:51'),
(11, 4, 1, 'Hooray', '2021-05-16 18:16:15'),
(68, 3, 1, 'Great', '2021-05-17 17:49:40'),
(69, 2, 15, 'most likely they won’t fix it so quickly, half a block was flooded there', '2021-05-18 15:47:11'),
(70, 4, 15, 'I will come', '2021-05-18 16:10:30'),
(71, 5, 15, 'Add the ability to write private messages!', '2021-05-18 16:18:51');

-- --------------------------------------------------------

--
-- Структура таблиці `costs`
--

CREATE TABLE `costs` (
  `id` int NOT NULL,
  `sum` decimal(10,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `costs`
--

INSERT INTO `costs` (`id`, `sum`, `date`, `category_id`, `description`) VALUES
(1, '1500.00', '2021-05-19 12:47:06', 1, 'Accountant salary'),
(2, '2000.00', '2021-05-19 12:47:26', 1, 'Chairman salary'),
(3, '2000.00', '2021-05-19 12:47:39', 1, 'Janitor salary'),
(4, '500.00', '2021-05-19 12:49:16', 2, 'Entrance door repair - 1 entrance'),
(5, '2500.00', '2021-05-19 12:49:46', 2, 'Step painting'),
(9, '500.00', '2021-05-20 09:15:13', 3, 'Planting trees near the playground'),
(11, '500.00', '2021-05-20 09:49:29', 2, 'Painting the gazebo'),
(12, '1500.00', '2021-05-20 09:51:23', 2, 'Replacing the lock on the front door of the 2nd entrance');

-- --------------------------------------------------------

--
-- Структура таблиці `flat`
--

CREATE TABLE `flat` (
  `id` int NOT NULL,
  `square` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `flat`
--

INSERT INTO `flat` (`id`, `square`) VALUES
(1, 25),
(2, 61),
(3, 45),
(4, 61),
(5, 30),
(6, 25),
(7, 25),
(8, 61),
(9, 61),
(10, 45),
(11, 30),
(12, 61),
(13, 45),
(14, 30),
(15, 61);

-- --------------------------------------------------------

--
-- Структура таблиці `flat_rate`
--

CREATE TABLE `flat_rate` (
  `flat_id` int NOT NULL,
  `rate_id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `flat_rate`
--

INSERT INTO `flat_rate` (`flat_id`, `rate_id`, `date`) VALUES
(1, 1, '2021-05-17 07:45:37'),
(1, 2, '2021-05-17 12:22:32'),
(2, 1, '2021-05-17 07:45:43'),
(3, 1, '2021-05-17 07:45:51'),
(4, 1, '2021-05-17 07:45:59'),
(5, 2, '2021-05-17 07:46:08'),
(6, 2, '2021-05-17 07:46:15'),
(7, 1, '2021-05-17 07:46:24'),
(8, 1, '2021-05-17 07:46:34'),
(9, 1, '2021-05-17 07:46:41'),
(10, 1, '2021-05-17 07:46:45'),
(11, 1, '2021-05-17 07:46:52'),
(12, 1, '2021-05-17 07:46:58'),
(13, 1, '2021-05-17 07:47:03'),
(14, 1, '2021-05-17 07:47:07'),
(15, 1, '2021-05-17 07:47:12');

-- --------------------------------------------------------

--
-- Структура таблиці `payment`
--

CREATE TABLE `payment` (
  `id` int NOT NULL,
  `flat_id` int NOT NULL,
  `sum` decimal(11,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `payment`
--

INSERT INTO `payment` (`id`, `flat_id`, `sum`, `date`) VALUES
(1, 1, '200.00', '2021-04-07 07:54:15'),
(2, 1, '400.00', '2021-05-07 07:54:15'),
(3, 14, '50.00', '2021-05-18 17:02:39'),
(4, 14, '400.00', '2021-05-18 17:20:15'),
(5, 9, '366.00', '2021-05-18 17:21:35'),
(6, 9, '200.00', '2021-05-18 17:40:34'),
(7, 8, '10000.00', '2021-05-19 15:56:08'),
(9, 12, '670.00', '2021-05-20 13:15:53'),
(10, 2, '20.00', '2021-05-20 13:17:01'),
(11, 9, '0.00', '2021-05-20 22:04:48'),
(12, 7, '21.00', '2021-05-20 22:17:32');

-- --------------------------------------------------------

--
-- Структура таблиці `post`
--

CREATE TABLE `post` (
  `id` int NOT NULL,
  `title` varchar(32) NOT NULL,
  `text` varchar(3500) NOT NULL,
  `author_id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `post`
--

INSERT INTO `post` (`id`, `title`, `text`, `author_id`, `date`) VALUES
(2, 'Water shutdown', 'Attention 04/02/2021 from 8:00 to 16:00 there will be no water supply. Pipe repair', 18, '2021-03-30 08:50:03'),
(3, 'Meeting', '05.04. at 17:00 a meeting will be held in the gazebo near the second entrance. Discussion of the issue of rent and checking ventilation ducts.', 18, '2021-04-01 09:52:38'),
(4, 'New neighbor', 'Danil settled in our house, congratulations to him!', 18, '2021-05-16 11:21:43'),
(5, 'Website', 'The first stage of site development has been completed. At the moment, the site is functioning, but few features are provided. Send your suggestions to email@gmail.com or in the comments.', 18, '2021-05-18 16:14:36');

-- --------------------------------------------------------

--
-- Структура таблиці `rate`
--

CREATE TABLE `rate` (
  `id` int NOT NULL,
  `name` varchar(24) NOT NULL,
  `monthly_sum` decimal(4,2) NOT NULL,
  `start_of_action` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `rate`
--

INSERT INTO `rate` (`id`, `name`, `monthly_sum`, `start_of_action`) VALUES
(1, 'Standard', '6.00', '2013-05-01 19:37:16'),
(2, 'Preferential', '3.00', '2021-05-17 07:44:42');

-- --------------------------------------------------------

--
-- Структура таблиці `status`
--

CREATE TABLE `status` (
  `id` int NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Lodger'),
(2, 'Not confirmed'),
(3, 'Removed'),
(4, 'Chairman'),
(5, 'Accountant');

-- --------------------------------------------------------

--
-- Структура таблиці `tenant`
--

CREATE TABLE `tenant` (
  `id` int NOT NULL,
  `flat_id` int NOT NULL,
  `surname` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `middle_name` varchar(32) DEFAULT NULL,
  `phone` int NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status_id` int NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп даних таблиці `tenant`
--

INSERT INTO `tenant` (`id`, `flat_id`, `surname`, `name`, `middle_name`, `phone`, `email`, `password`, `status_id`) VALUES
(1, 2, 'Колесник', 'Іван', 'Васильович', 953856457, 'email@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 1),
(4, 9, 'Васильєв', 'Станіслав', 'Сергійович', 995688988, 'petrenko@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 2),
(6, 9, 'Савченко', 'Микита', 'Ігорович', 977777777, 'savenko@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 5),
(8, 3, 'Ковальчук', 'Ігор', 'Олегович', 955555555, 'kikhtenko@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 3),
(9, 6, 'Руденко', 'Максим', 'Станіславович', 922222222, 'safonov@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 1),
(10, 11, 'Степанченко', 'Данило', 'Олексійович', 999999999, 'stepanov@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 1),
(15, 14, 'Руденко', 'Олег', 'Іванович', 5555555, 'chernov@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 1),
(16, 8, 'Андрусенко', 'Ярослав', 'Олександрович', 1111111, 'alexeenko@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 1),
(17, 12, 'Павлюк', 'Сергій', 'Олександрович', 8888888, 'pavlenko@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 1),
(18, 14, 'Іваненко', 'Іван', 'Іванович', 11616546, 'ivanov@gmail.com', '8224c8f874a2aa342116e15cab7c37fe', 4);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `accrual`
--
ALTER TABLE `accrual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flat_id` (`flat_id`);

--
-- Індекси таблиці `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Індекси таблиці `costs`
--
ALTER TABLE `costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Індекси таблиці `flat`
--
ALTER TABLE `flat`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `flat_rate`
--
ALTER TABLE `flat_rate`
  ADD PRIMARY KEY (`flat_id`,`rate_id`),
  ADD KEY `flat_id` (`flat_id`,`rate_id`),
  ADD KEY `rate_id` (`rate_id`);

--
-- Індекси таблиці `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flat_id` (`flat_id`);

--
-- Індекси таблиці `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Індекси таблиці `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `flat` (`flat_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `accrual`
--
ALTER TABLE `accrual`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблиці `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT для таблиці `costs`
--
ALTER TABLE `costs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблиці `flat`
--
ALTER TABLE `flat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблиці `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблиці `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблиці `rate`
--
ALTER TABLE `rate`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблиці `status`
--
ALTER TABLE `status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `tenant`
--
ALTER TABLE `tenant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `accrual`
--
ALTER TABLE `accrual`
  ADD CONSTRAINT `accrual_ibfk_1` FOREIGN KEY (`flat_id`) REFERENCES `flat` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `tenant` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `costs`
--
ALTER TABLE `costs`
  ADD CONSTRAINT `costs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `flat_rate`
--
ALTER TABLE `flat_rate`
  ADD CONSTRAINT `flat_rate_ibfk_1` FOREIGN KEY (`flat_id`) REFERENCES `flat` (`id`),
  ADD CONSTRAINT `flat_rate_ibfk_2` FOREIGN KEY (`rate_id`) REFERENCES `rate` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`flat_id`) REFERENCES `flat` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `tenant` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `tenant`
--
ALTER TABLE `tenant`
  ADD CONSTRAINT `tenant_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `tenant_ibfk_2` FOREIGN KEY (`flat_id`) REFERENCES `flat` (`id`);

DELIMITER $$
--
-- Події
--
CREATE DEFINER=`root`@`localhost` EVENT `accrualEveryM` ON SCHEDULE EVERY 1 MONTH STARTS '2021-05-01 01:00:00' ON COMPLETION PRESERVE ENABLE DO CALL accrualEM()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
