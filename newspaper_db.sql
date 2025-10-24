-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2025 at 02:20 PM
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
-- Database: `newspaper_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(2083) NOT NULL,
  `category` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `image_url`, `category`, `created_at`) VALUES
(1, 'Historic Padma Bridge Connects Regions, Boosts Economy', 'The Padma Bridge, a monumental feat of engineering, has officially opened, connecting the southwestern districts of Bangladesh with the capital, Dhaka. This bridge is expected to dramatically reduce travel time and spur economic growth across the region, creating new opportunities for trade and development. The project, funded entirely by the Bangladesh government, stands as a symbol of national pride and self-reliance.', 'https://i.postimg.cc/NfL1S4jQ/padma-brigde-mughal-kingdom.jpg', 'local-news', '2025-10-19 02:25:10'),
(2, 'Rajshahi University Launches New Tech Incubation Center', 'Rajshahi University has inaugurated a state-of-the-art technology incubation center aimed at fostering innovation and entrepreneurship among students. The center will provide resources, mentorship, and funding opportunities for startups in fields like AI, software development, and agricultural technology. This initiative is expected to position Rajshahi as a growing hub for tech talent in the country.', 'https://placehold.co/800x600/D1C4E9/333?text=RU+Tech+Center', 'technology', '2025-10-17 21:10:00'),
(3, 'Rajshahi Royals Clinch Victory in Tense Final Match', 'The Rajshahi Royals have won the national cricket league championship in a thrilling final match that went down to the last over. A spectacular performance by the team\'s star batsman secured the victory against their long-time rivals. Fans erupted in celebration across the city, marking a historic win for the local team.', 'https://placehold.co/800x600/C8E6C9/333?text=Cricket+Win', 'sports', '2025-10-19 08:15:30'),
(4, 'Mango Exports from Rajshahi See Record Growth This Season', 'This year\'s mango season has been exceptionally successful for farmers in the Rajshahi division, with exports hitting a new record high. Favorable weather conditions and improved supply chain management have allowed the famed local mangoes to reach new international markets, significantly boosting the local economy and providing better returns for the growers.', 'https://placehold.co/800x600/FFECB3/333?text=Mango+Exports', 'business', '2025-10-16 18:45:00'),
(5, 'Government Announces Plan for New Digital Infrastructure in Northern Bangladesh', 'The government has unveiled a comprehensive plan to upgrade digital infrastructure across northern Bangladesh, including Rajshahi. The project aims to provide high-speed internet access to rural areas, establish new data centers, and promote digital literacy. This move is part of a broader strategy to create a more inclusive digital economy.', 'https://placehold.co/800x600/B2EBF2/333?text=Digital+Infra', 'technology', '2025-10-15 16:00:00'),
(6, 'Rajshahi Shilpakala Academy Hosts Annual Cultural Festival', 'The Rajshahi Shilpakala Academy has kicked off its annual week-long cultural festival, showcasing a vibrant array of traditional music, dance, and theatre. Artists from across the division are participating, drawing large crowds and celebrating the rich heritage of the region.', 'https://placehold.co/600x400/7c3aed/ffffff?text=Culture+Fest', 'Culture', '2025-10-19 16:12:00'),
(7, 'Mega Concert Rocks Rajshahi University Campus', 'Thousands of music lovers gathered at the Rajshahi University stadium for a spectacular concert featuring some of the nation\'s top rock bands. The event, organized by the student union, was a resounding success, with attendees enjoying an electrifying night of music and entertainment.', 'https://placehold.co/600x400/db2777/ffffff?text=Concert', 'Entertainment', '2025-10-19 16:12:00'),
(8, 'New Public Health Initiative Launched to Combat Dengue Fever', 'With monsoon season approaching, the Rajshahi City Corporation has launched a new public health initiative aimed at raising awareness and preventing the spread of dengue fever. The campaign includes door-to-door inspections and distribution of informational leaflets.', 'https://placehold.co/600x400/16a34a/ffffff?text=Health+Campaign', 'Health', '2025-10-19 16:12:00'),
(9, 'Bangladesh Strengthens Trade Ties with Southeast Asian Nations', 'In a significant diplomatic move, Bangladesh has signed several new trade agreements with key Southeast Asian nations, aiming to boost exports and foster greater economic cooperation. The deals are expected to open new markets for textiles and agricultural products.', 'https://placehold.co/600x400/0891b2/ffffff?text=International+Trade', 'International', '2025-10-19 16:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','moderator') NOT NULL DEFAULT 'moderator',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$taO7Ree0YEV/.l4sHnEeLuhJq8T0/nxGQcLU.T8DaPoSyOnLNwxJC', 'admin', '2025-10-23 12:08:01'),
(2, 'moderator', '$2y$10$CrijGK0rBpIVIoqrEszQxOLW6Q5CwIe53eH6RUPZpNrDFsi8zpWZC', 'moderator', '2025-10-23 12:08:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
