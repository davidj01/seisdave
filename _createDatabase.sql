--
-- Create database 'seisdave'
--

CREATE DATABASE seisdave;

--
-- Use database 'seisdave'
--

USE seisdave;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message` varchar(4000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `username`, `date`, `message`) VALUES
(20, 'djames', '2014-03-04 01:08:28', 'Jimi and Phil - lets meet for dinner at 7pm.  How does White Castle sound?'),
(21, 'phillsman', '2014-03-04 01:34:06', 'Sounds good.  See you guys there!'),
(22, 'jhendrix', '2014-03-04 01:39:48', 'I love White Castle!'),
(23, 'jnettles', '2014-03-05 05:12:59', 'Hi Sid. Whats new?'),
(24, 'skelsow', '2014-03-05 05:14:06', 'Hi Johan.  Im eating cornflakes.');

-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE IF NOT EXISTS `relationships` (
  `rel_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `friend` varchar(60) NOT NULL,
  PRIMARY KEY (`rel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `relationships`
--

INSERT INTO `relationships` (`rel_id`, `username`, `friend`) VALUES
(8, 'djames', 'jhendrix'),
(9, 'phillsman', 'jhendrix'),
(10, 'phillsman', 'djames'),
(11, 'jhendrix', 'phillsman'),
(12, 'jhendrix', 'djames'),
(13, 'skelsow', 'jnettles'),
(14, 'jnettles', 'skelsow'),
(16, 'djames', 'phillsman');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `join_date` datetime DEFAULT NULL,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `picture` varchar(32) DEFAULT NULL,
  `displayname` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `join_date`, `first_name`, `last_name`, `gender`, `birthdate`, `city`, `state`, `picture`, `displayname`) VALUES
(17, 'skelsow', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2009-06-11 14:51:46', 'Sidney', 'Kelsow', 'F', '1984-07-19', 'Tempe', 'AZ', 'sidneypic.jpg', 'sidneyk'),
(18, 'njohansson', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2008-08-20 14:52:09', 'Nevil', 'Johansson', 'M', '1973-05-13', 'Reno', 'NV', 'nevilpic.jpg', 'nevilj'),
(19, 'acooper', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2008-06-03 14:53:05', 'Alex', 'Cooper', 'M', '1974-09-13', 'Boise', 'ID', 'alexpic.jpg', 'alexc'),
(20, 'sdaniels', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2009-02-20 14:58:40', 'Susannah', 'Daniels', 'F', '1977-02-23', 'Pasadena', 'CA', 'susannahpic.jpg', 'susannahd'),
(21, 'eheckel', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2009-05-28 15:00:37', 'Ethel', 'Heckel', 'F', '1943-03-27', 'Wichita', 'KS', 'ethelpic.jpg', 'ethelh'),
(22, 'oklugman', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2008-06-03 15:00:48', 'Oscar', 'Klugman', 'M', '1968-06-04', 'Providence', 'RI', 'oscarpic.jpg', 'oscark'),
(23, 'bchevy', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2011-06-21 15:01:08', 'Belita', 'Chevy', 'F', '1975-07-08', 'El Paso', 'TX', 'belitapic.jpg', 'belitac'),
(24, 'jfilmington', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2010-06-18 15:01:19', 'Jason', 'Filmington', 'M', '1969-09-24', 'Hollywood', 'CA', 'jasonpic.jpg', 'jasonf'),
(25, 'dpennington', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2011-01-19 15:01:51', 'Dierdre', 'Pennington', 'F', '1970-04-26', 'Cambridge', 'MA', 'dierdrepic.jpg', 'dierdrep'),
(26, 'phillsman', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2013-12-17 15:02:02', 'Paul', 'Hillsman', 'M', '1964-12-18', 'Charleston', 'SC', 'paulpic.jpg', 'paulh'),
(27, 'jnettles', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2014-02-13 15:02:13', 'Johan', 'Nettles', 'M', '1981-11-03', 'Athens', 'GA', 'johanpic.jpg', 'johann'),
(28, 'jhendrix', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2014-03-01 19:42:16', 'James', 'Hendrix', 'M', NULL, NULL, NULL, 'jimipic.jpg', 'jimih'),
(29, 'djames', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2014-03-01 20:45:22', 'Dave', 'James', 'M', '1968-10-09', 'Minneapolis', 'MN', 'davepic.jpg', 'davidj');
