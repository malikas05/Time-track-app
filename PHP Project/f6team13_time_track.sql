-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Дек 05 2016 г., 10:08
-- Версия сервера: 5.5.52-cll
-- Версия PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `f6team13_time_track`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `projectId` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_catProjectId` (`projectId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `title`, `projectId`) VALUES
(2, 'School', 1),
(3, 'Stuff', 1),
(6, 'Important', 7),
(11, 'GBC', 2),
(12, 'college', 12),
(13, 'Test category', 8),
(14, '342', 13);

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `colour` varchar(55) NOT NULL,
  `userId` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `userId_2` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `project`
--

INSERT INTO `project` (`id`, `title`, `colour`, `userId`) VALUES
(1, 'Project 1 - Project Description Changed', '#324344', 32),
(2, 'Project 2 - Project Description', '#eb10bb', 32),
(3, 'Project 3 - Project Description', '#5f07ed', 32),
(4, 'Project 4 - Project Description', '#34f3ff', 32),
(5, 'Project 5 - Project Description', '#aabbcc', 32),
(6, 'Malikas First Project', '#147a37', 32),
(7, 'My First Project', '#e0142d', 41),
(8, 'Test Project', '#06fcdf', 32),
(9, 'My First Project', '#0b14f5', 46),
(10, 'PHP Project', '#ebd61b', 46),
(11, 'JavaScript', '#23a6f0', 47),
(12, 'finish semester 3', '#365ab8', 48),
(13, 'Test 11', '#000000', 49),
(14, '23432', '#155aab', 49);

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `colour` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `title`, `colour`) VALUES
(1, '$', '#666666'),
(2, 'Out of scope', '#66d30c'),
(3, 'Personal', '#993333'),
(4, 'Other stuff', '#f6ff00'),
(5, 'Sort this out', '#7423ff');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `start` int(20) DEFAULT NULL,
  `end` int(20) DEFAULT NULL,
  `userId` int(5) NOT NULL,
  `categoryId` int(5) DEFAULT NULL,
  `projectId` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tasksUserId` (`userId`),
  KEY `FK_tasksProjId` (`projectId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `description`, `start`, `end`, `userId`, `categoryId`, `projectId`) VALUES
(4, 'How to do stuff at school', 1480311307, 1480313342, 32, 2, 1),
(7, 'browsing internet', 1480313027, 1480313342, 32, 13, 8),
(10, 'watching youtube', 1480311027, 1480313342, 32, NULL, 5),
(12, 'Java assignment 2', 1480304227, 1480911242, 32, 3, 1),
(13, 'George Brown', 1480634053, 1480634153, 32, 11, 2),
(19, 'PHP project', 1480900739, 1480907490, 32, NULL, 6),
(27, 'TaskNotThisWeek12', 1280906881, 1280906581, 32, NULL, 1),
(33, 'Java assignment', 1480907772, 1480909066, 32, 3, 1),
(35, 'New Task', 1480822867, 1480822967, 32, NULL, 1),
(58, 'George Brown', 1480895585, 1480895735, 32, 11, 2),
(60, 'Test14', 1480896194, 1480896222, 32, 11, 2),
(61, 'New Task11', 1480896222, 1480896238, 32, NULL, 1),
(62, 'Enter Task Description Here', 1480896596, 1480896672, 49, NULL, 1),
(64, 'Enter Task Description Here', 1480896608, 1480896734, 49, NULL, 1),
(66, 'Enter Task Description Here', 1480896757, 1480896764, 49, NULL, 1),
(67, 'Enter Task Description Here', 1480896777, 1480896782, 49, NULL, 1),
(68, 'Enter Task Description Here', 1480896839, 1480896896, 50, NULL, 1),
(69, 'Enter Task Description Here', 1480896912, 1480896917, 50, NULL, 1),
(70, 'Enter Task Description Here', 1480897019, 1480897023, 50, NULL, 1),
(71, 'Enter Task Description Here', 1480897039, 1480897047, 50, NULL, 1),
(72, 'Enter Task Description Here', 1480897333, 1480897336, 50, NULL, 1),
(73, 'Enter Task Description Here', 1480897389, 1480897393, 50, NULL, 1),
(74, 'Enter Task Description Here', 1480897466, 1480897469, 50, NULL, 1),
(76, 'Complete C# assignment', 1480926970, 1480927009, 46, NULL, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `task_tags`
--

CREATE TABLE IF NOT EXISTS `task_tags` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `taskId` int(5) NOT NULL,
  `tagId` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_taskId` (`taskId`),
  KEY `FK_taskTagId` (`tagId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Дамп данных таблицы `task_tags`
--

INSERT INTO `task_tags` (`id`, `taskId`, `tagId`) VALUES
(7, 7, 1),
(8, 7, 2),
(9, 7, 3),
(10, 7, 4),
(11, 7, 5),
(12, 4, 1),
(13, 4, 2),
(14, 4, 3),
(15, 10, 3),
(16, 10, 2),
(42, 12, 2),
(43, 12, 4),
(44, 12, 5),
(45, 19, 3),
(46, 13, 2),
(47, 13, 4),
(48, 68, 4),
(51, 76, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(32, 'Malik', 'mr.yavari@mail.ru', 'a180a4cf023657969656b1358015e518'),
(33, 'Max Bondarenko', 'maxim.bondarenko@georgebrown.ca', '7f362777ce7835261bf1d51e8ea3f474'),
(39, 'Max The Second', 'max.bondarenko@georgebrown.ca', '5f2ef07bc894d592e463a79edcf13138'),
(44, '234', 'max3.bondarenko@georgebrown.ca', '754ba9e1c0cb6d55bd6995bcf08108d6'),
(45, 'Max Bondarenko', 'max.bond@georgebrown.ca', '85a679ab5faca954b95aa0640cd84f47'),
(46, 'Ali', 'ali444kazan@mail.ru', 'c4c4026f2deedf1dbbcc954be141509c'),
(47, 'Roman', 'kov-rv007@ukr.net', '6996293873a4132dc7d95e59476250b4'),
(49, 'Bob 11', 'blah@mail.ru', '9b6ce880c3caa9042f7ba2a5424ec502'),
(50, '1111', 'mr.111@mail.ru', 'a892cfa3465947cd6468cd678c834b9b');

-- --------------------------------------------------------

--
-- Структура таблицы `user_projects`
--

CREATE TABLE IF NOT EXISTS `user_projects` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userId` int(5) NOT NULL,
  `projectId` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_projects_userId` (`userId`),
  KEY `FK_user_projects_projectId` (`projectId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `user_projects`
--

INSERT INTO `user_projects` (`id`, `userId`, `projectId`) VALUES
(1, 32, 1),
(2, 32, 2),
(3, 32, 3),
(4, 32, 4),
(5, 32, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `user_tags`
--

CREATE TABLE IF NOT EXISTS `user_tags` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userId` int(5) NOT NULL,
  `tagId` int(5) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `colour` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tagUserId` (`userId`),
  KEY `FK_tagTagId` (`tagId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- Дамп данных таблицы `user_tags`
--

INSERT INTO `user_tags` (`id`, `userId`, `tagId`, `title`, `colour`) VALUES
(2, 32, 2, 'Out of scope', '#f09713'),
(3, 32, 3, 'Personal', '#993333'),
(4, 32, 4, 'Other stuff', '#f6ff00'),
(5, 32, 5, 'Sort this out', '#7423ff'),
(11, 39, 1, '$', '#666666'),
(12, 39, 2, 'Out of scope', '#66d30c\n'),
(13, 39, 3, 'Personal', '#993333'),
(14, 39, 4, 'Other stuff', '#f6ff00'),
(15, 39, 5, 'Sort this out', '#7423ff'),
(36, 44, 1, '$', '#666666'),
(37, 44, 2, 'Out of scope', '#66d30c'),
(38, 44, 3, 'Personal', '#993333'),
(39, 44, 4, 'Other stuff', '#f6ff00'),
(40, 44, 5, 'Sort this out', '#7423ff'),
(41, 45, 1, '$', '#666666'),
(42, 45, 2, 'Out of scope', '#66d30c'),
(43, 45, 3, 'Personal', '#993333'),
(44, 45, 4, 'Other stuff', '#f6ff00'),
(45, 45, 5, 'Sort this out', '#7423ff'),
(46, 46, 1, '$', '#666666'),
(47, 46, 2, 'Out of scope', '#66d30c'),
(48, 46, 3, 'Personal', '#993333'),
(49, 46, 4, 'Other stuff', '#f6ff00'),
(50, 46, 5, 'Sort this out', '#7423ff'),
(51, 47, 1, '$', '#666666'),
(52, 47, 2, 'Out of scope', '#66d30c'),
(53, 47, 3, 'Personal', '#993333'),
(54, 47, 4, 'Other stuff', '#f6ff00'),
(55, 47, 5, 'Sort this out', '#7423ff'),
(56, 32, 1, '$', '#666666'),
(62, 49, 1, '$', '#069e43'),
(63, 49, 2, 'Out of scope', '#964f4f'),
(64, 49, 3, 'Personal', '#bf9494'),
(65, 49, 4, 'Other stuff', '#dedede'),
(66, 49, 5, 'Sort this out', '#520bc7'),
(67, 50, 1, '$', '#666666'),
(68, 50, 2, 'Out of scope', '#66d30c'),
(69, 50, 3, 'Personal', '#993333'),
(70, 50, 4, 'Other stuff', '#f6ff00'),
(71, 50, 5, 'Sort this out', '#7423ff');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_catProjectId` FOREIGN KEY (`projectId`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `FK_tasksProjId` FOREIGN KEY (`projectId`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_tasksUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `task_tags`
--
ALTER TABLE `task_tags`
  ADD CONSTRAINT `FK_taskTagId` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_taskId` FOREIGN KEY (`taskId`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_projects`
--
ALTER TABLE `user_projects`
  ADD CONSTRAINT `FK_user_projects_projectId` FOREIGN KEY (`projectId`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user_projects_userId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_tags`
--
ALTER TABLE `user_tags`
  ADD CONSTRAINT `FK_tagTagId` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tagUserId` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
