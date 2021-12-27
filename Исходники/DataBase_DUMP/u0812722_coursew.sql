-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 04 2021 г., 17:39
-- Версия сервера: 5.7.27-30
-- Версия PHP: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `u0812722_coursew`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_data`
--

CREATE TABLE `admin_data` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `name` text NOT NULL,
  `shoplink` text NOT NULL,
  `shopid` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admin_data`
--

INSERT INTO `admin_data` (`id`, `login`, `password`, `email`, `phone`, `name`, `shoplink`, `shopid`) VALUES
(4, 'donlees', 'sUUVU3xC4LFLkdS9L46BDmJudqS25sRSqDS1ePUWfPSyeKV2EnNkW3pIK3sUfzVg', 'ulvih99@gmail.com', '79991636048', 'Ulvi', 'aquilacheats.ru', 'FJMYMHDX5786336'),
(5, 'aloha', 'sUUVU3xC4LFLkdS9L46BDmJudqS25sRSqDS1ePUWfPSyeKV2EnNkW3pIK3sUfzVg', 'uh02@mail.ru', '994504750003', 'Andrey', 'Lol.ru', 'QMTETPNA3392150');

-- --------------------------------------------------------

--
-- Структура таблицы `item_data`
--

CREATE TABLE `item_data` (
  `id` int(11) NOT NULL,
  `shopid` text NOT NULL,
  `item_name` text NOT NULL,
  `item_code` text NOT NULL,
  `item_price` text NOT NULL,
  `item_inst` text NOT NULL,
  `item_status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `item_data`
--

INSERT INTO `item_data` (`id`, `shopid`, `item_name`, `item_code`, `item_price`, `item_inst`, `item_status`) VALUES
(1, 'FJMYMHDX5786336', 'Apex Legends ESP 1 day', '983882FBC63390188566468FD74C739A', '20', 'inst', 1),
(4, 'FJMYMHDX5786336', 'Apex Legends ESP 3 days', 'F503F787E54B45E803CF2655A7DF118E', '200', 'inst1234', 1),
(5, 'FJMYMHDX5786336', '123', '202CB962AC59075B964B07152D234B70', '123', '123', 0),
(6, 'FJMYMHDX5786336', '456', '250CF8B51C773F3F8DC8B4BE867A9A02', '456', '456', 1),
(7, 'FJMYMHDX5786336', 'Abruh', '0E8B8278C7ADB4B9714C31DB1DF47EDE', '131', '3131', 1),
(2, 'FJMYMHDX5786336', 'Apex Legends ESP 5 days', '4638A9B6AE146802D38EA17F4A1B1602', '100', 'ITS CHECK TEXT', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `keys_data`
--

CREATE TABLE `keys_data` (
  `shopid` text NOT NULL,
  `item_code` text NOT NULL,
  `item_key` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `keys_data`
--

INSERT INTO `keys_data` (`shopid`, `item_code`, `item_key`) VALUES
('FJMYMHDX5786336', '4638A9B6AE146802D38EA17F4A1B1602', '12321'),
('FJMYMHDX5786336', '202CB962AC59075B964B07152D234B70', '123'),
('FJMYMHDX5786336', '4638A9B6AE146802D38EA17F4A1B1602', '43242'),
('FJMYMHDX5786336', 'F503F787E54B45E803CF2655A7DF118E', '1234'),
('', '', '1232223'),
('', '', '13131');

-- --------------------------------------------------------

--
-- Структура таблицы `promo_data`
--

CREATE TABLE `promo_data` (
  `id` int(11) NOT NULL,
  `shopid` text NOT NULL,
  `promo_data` text NOT NULL,
  `percent_data` text NOT NULL,
  `promo_expired` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `promo_data`
--

INSERT INTO `promo_data` (`id`, `shopid`, `promo_data`, `percent_data`, `promo_expired`) VALUES
(1, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '5', '10.10.2021'),
(10, 'FJMYMHDX5786336', 'F503F787E54B45E803CF2655A7DF118E', '20', '20.10.2021'),
(11, 'FJMYMHDX5786336', '13131313231231', '10', '30.09.2021');

-- --------------------------------------------------------

--
-- Структура таблицы `sell_data`
--

CREATE TABLE `sell_data` (
  `id` int(11) NOT NULL,
  `shopid` text NOT NULL,
  `item_code` text NOT NULL,
  `item_price` text NOT NULL,
  `item_seller` text NOT NULL,
  `item_percent` text NOT NULL,
  `sell_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sell_data`
--

INSERT INTO `sell_data` (`id`, `shopid`, `item_code`, `item_price`, `item_seller`, `item_percent`, `sell_data`) VALUES
(1, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '200', 'none', 'none', '21.09.2021'),
(2, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '100', 'none', 'none', '25.09.2021'),
(3, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '100', 'none', 'none', '25.09.2021'),
(4, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '10', 'mee', 'none', '28.09.2021'),
(8, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '10', 'mee', 'none', '28.09.2021'),
(9, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '18', 'aquilacheats.ru', 'none', '28.09.2021'),
(12, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '10', 'mee', 'none', '30.09.2021'),
(10, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '10', 'mee', 'none', '28.09.2021'),
(11, 'FJMYMHDX5786336', '983882FBC63390188566468FD74C739A', '10', 'mee', 'none', '29.09.2021');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_data`
--

CREATE TABLE `shop_data` (
  `id` int(11) NOT NULL,
  `shopid` text NOT NULL,
  `bottoken` text NOT NULL,
  `tgchatid` text NOT NULL,
  `imagelink` text NOT NULL,
  `anykey` text NOT NULL,
  `any_id` text NOT NULL,
  `cardkey` text NOT NULL,
  `card_id` text NOT NULL,
  `freekey` text NOT NULL,
  `fk_id` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_data`
--

INSERT INTO `shop_data` (`id`, `shopid`, `bottoken`, `tgchatid`, `imagelink`, `anykey`, `any_id`, `cardkey`, `card_id`, `freekey`, `fk_id`) VALUES
(2, 'FJMYMHDX5786336', '123', '443926124', 'title.png', '321', '7387', '32131', '342', '650vyg8a', '214815'),
(3, 'QMTETPNA3392150', '', '', 'def_logo.png', '', '', '', '', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin_data`
--
ALTER TABLE `admin_data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `item_data`
--
ALTER TABLE `item_data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `promo_data`
--
ALTER TABLE `promo_data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sell_data`
--
ALTER TABLE `sell_data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shop_data`
--
ALTER TABLE `shop_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin_data`
--
ALTER TABLE `admin_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `item_data`
--
ALTER TABLE `item_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `promo_data`
--
ALTER TABLE `promo_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `sell_data`
--
ALTER TABLE `sell_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `shop_data`
--
ALTER TABLE `shop_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
