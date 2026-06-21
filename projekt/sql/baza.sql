-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 07:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `debate_news`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(32) NOT NULL,
  `prezime` varchar(32) NOT NULL,
  `korisnicko_ime` varchar(32) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razina` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(1, 'Ana', 'Administratorović', 'admin', '$2y$10$otl.ynvnTfXAHm8/euecou1PouXuFOmgKAyMV2m/ojIUtt3QT6a5e', 1),
(2, 'Ivan', 'Ivić', 'ivan', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` varchar(32) NOT NULL,
  `naslov` varchar(64) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(64) NOT NULL,
  `kategorija` varchar(64) NOT NULL,
  `arhiva` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(1, '15.06.2026.', 'Tornados dejan danos en casas del sur de Estados Unidos', 'Por Andres Rodriguez', 'Tornado je prouzročio veliku štetu u stambenim područjima na jugu SAD-a. Mještani su zatečeni jačinom nevremena koje je pogodilo regiju u kasnim večernjim satima.', 'tornado.jpg', 'mundo', 0),
(2, '15.06.2026.', 'Boeing reconoce defectos en software del simulador del 737 MAX', 'Por AFP', 'Tvrtka Boeing priznala je nedostatke u softveru simulatora za model 737 MAX, što je ponovno otvorilo pitanja o sigurnosti zrakoplova.', 'boeing.jpg', 'mundo', 0),
(3, '14.06.2026.', 'Mujer logra increible transformacion al bajar mas de 200 kilos', 'Por Carmen Villegas', 'Nevjerojatna priča o transformaciji žene koja je nakon višegodišnjeg napora izgubila više od 200 kilograma i promijenila svoj život.', 'transformacion.jpg', 'mundo', 0),
(4, '14.06.2026.', 'Joven que le sacaron su bebe en Chicago miraba fotos cuando fue ', 'Por El Debate', 'Tragičan slučaj potresao je lokalnu zajednicu u Chicagu nakon što je mlada žena ubijena u svom domu.', 'asesinato.jpg', 'mundo', 0),
(5, '18.05.2026.', 'Tigres vs Monterrey, minuto a minuto semifinales Liga MX', 'Medio tiempo, Tigres vence 1-0 a Monterrey con un gol de Pizarro', 'Tigres recibe al Monterrey con una espina clavada y una desventaja de un gol que al momento lo tiene fuera de su sexta final en los ultimos 10 torneos.\n\nDespues de perder 1-0 ante Rayados en su visita al Estadio BBVA Bancomer, Tigres llega herido y con la esperanza y motivacion de darle la vuelta a las semifinales en su estadio ante su gente.\n\nLos Felinos estuvieron escasos de posibilidades en el primer encuentro y no pudieron anotar el valioso gol de visitante que le daria una gran ventaja al cerrar en el Estadio Universitario.', 'tigres.jpg', 'deporte', 0),
(6, '13.06.2026.', 'Maria del Rosario Espinoza, comparte amargo adios a los mundiale', 'Por Andres Rodriguez', 'Poznata taekwondo natjecateljica objavila je svoj odlazak iz svjetske konkurencije nakon dugogodišnje karijere.', 'taekwondo.jpg', 'deporte', 0),
(7, '12.06.2026.', 'Yo decido en mi equipo, si no me marcharia, dice Zidane', 'Por Cornelio Figueroa', 'Trener je u izjavi za medije naglasio da sam odlučuje o sastavu svog tima te da bi inače napustio klub.', 'zidane.jpg', 'deporte', 0),
(8, '11.06.2026.', 'Lyon vence al Barcelona y gana su cuarta Champions femenil conse', 'Por EFE', 'Klub je osvojio svoj četvrti uzastopni naslov u Ligi prvakinja nakon pobjede u finalu protiv Barcelone.', 'lyon.jpg', 'deporte', 0),
(9, '21.06.2026.', 'BROJ PI', '100 znamenki broja pi', '3.14159265358979323846264338327950288419716939937510582097494459230781640628620899862883421170679', 'WhatsApp Image 2025-11-09 at 13.27.57_e3dbf212.jpg', 'mundo', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
