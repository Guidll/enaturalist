
--
-- Banco de Dados: `googlemaps`
--
CREATE DATABASE  `googlemaps` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `markers`
--

CREATE TABLE IF NOT EXISTS `googlemaps`.`markers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `address` varchar(80) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `markers`
--

INSERT INTO `googlemaps`.`markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES
(1, 'Pan Africa Market', '1521 1st Ave, Seattle, WA',-23.53036550000043, -46.368918431794036, 'restaurant'),
(2, 'Buddha Thai & Bar', '2222 2nd Ave, Seattle, WA', -23.53036550000043, -46.368918431794036, 'bar'),
(3, 'The Melting Pot', '14 Mercer St, Seattle, WA', -23.53036550000043, -46.368918431794036, 'restaurant'),
(4, 'Ipanema Grill', '1225 1st Ave, Seattle, WA', -23.53036550000043, -46.368918431794036, 'restaurant'),
(5, 'Sake House', '2230 1st Ave, Seattle, WA', -23.53036550000043, -46.368918431794036, 'bar'),
(6, 'Crab Pot', '1301 Alaskan Way, Seattle, WA', -23.53036550000043, -46.368918431794036, 'restaurant'),
(7, 'Mama''s Mexican Kitchen', '2234 2nd Ave, Seattle, WA', -23.53036550000043, -46.368918431794036, 'bar'),
(8, 'Wingdome', '1416 E Olive Way, Seattle, WA', -23.53036550000043, -46.368918431794036, 'bar'),
(9, 'Piroshky Piroshky', '1908 Pike pl, Seattle, WA', -23.53036550000043, -46.368918431794036, 'restaurant');