-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2025 at 08:11 PM
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
-- Database: `sportnet`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `login_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `login_count`) VALUES
(1, 'admin@gmail.com', 'admin@123', 6);

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `id` int(11) NOT NULL,
  `current_club` varchar(255) DEFAULT NULL,
  `player` varchar(255) DEFAULT NULL,
  `offer_club` varchar(255) DEFAULT NULL,
  `current_amount` varchar(255) DEFAULT NULL,
  `offer_amount` varchar(255) DEFAULT NULL,
  `user_status` varchar(50) NOT NULL DEFAULT 'nothing',
  `club_status` varchar(50) NOT NULL DEFAULT '--'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`id`, `current_club`, `player`, `offer_club`, `current_amount`, `offer_amount`, `user_status`, `club_status`) VALUES
(25, '4', '2', 'ameer@gmail.com', '5000', '10000', 'nothing', '--');

-- --------------------------------------------------------

--
-- Table structure for table `club`
--

CREATE TABLE `club` (
  `club_id` int(50) NOT NULL,
  `club_name` varchar(50) NOT NULL,
  `club_type` varchar(50) NOT NULL,
  `Man_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `district` varchar(20) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `about` text NOT NULL DEFAULT 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum suscipit odio itaque. Aliquid non debitis quidem repudiandae distinctio iure, ut reiciendis voluptates fugiat atque earum, illum et quod iusto dolores?',
  `password` varchar(100) NOT NULL,
  `login_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`club_id`, `club_name`, `club_type`, `Man_name`, `email`, `mobile`, `district`, `logo`, `about`, `password`, `login_count`) VALUES
(3, 'Samanaya club', 'football', 'paiko Das', 'ameer@gmail.com', '1234567898', 'Malappuram', 'fb.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum suscipit odio itaque. Aliquid non debitis quidem repudiandae distinctio iure, ut reiciendis voluptates fugiat atque earum, illum et quod iusto dolores', '$2y$10$QqygJDKYYeB5ly2SIyphJuBxQa80eHVK3pg41n.aSMlA81QS9wz9W', 11),
(4, 'Bhaavana', 'football', 'Paiko P', 'paikodas@gmail.com', '1234567898', 'Malappuram', 'fb.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum suscipit odio itaque. Aliquid non debitis quidem repudiandae distinctio iure, ut reiciendis voluptates fugiat atque earum, illum et quod iusto dolores\r\n', '$2y$10$qo28cZ8G8bblsR7FFH9ONuG2pQIFuE6O//scx05VC9aUxOvopwNDm', 38),
(5, 'golden', 'football', 'Paiko', 'club@gmail.com', '1234567898', 'Malappuram', 'fb.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum suscipit odio itaque. Aliquid non debitis quidem repudiandae distinctio iure, ut reiciendis voluptates fugiat atque earum, illum et quod iusto dolores\r\n', '12ab#', 0),
(6, 'club1', 'cricket', 'Das', 'club@gmail.com', '1234567898', 'Malappuram', 'fb.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum suscipit odio itaque. Aliquid non debitis quidem repudiandae distinctio iure, ut reiciendis voluptates fugiat atque earum, illum et quod iusto dolores\r\n', '12ab#', 0),
(7, 'club2', 'cricket', 'Das', 'club@gmail.com', '1234567898', 'Malappuram', 'fb.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum suscipit odio itaque. Aliquid non debitis quidem repudiandae distinctio iure, ut reiciendis voluptates fugiat atque earum, illum et quod iusto dolores\r\n', '12ab#', 0);

-- --------------------------------------------------------

--
-- Table structure for table `clubuser`
--

CREATE TABLE `clubuser` (
  `id` int(30) NOT NULL,
  `club_id` int(30) NOT NULL,
  `sport_type` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `number` varchar(20) NOT NULL,
  `amount` varchar(100) NOT NULL DEFAULT '00',
  `add_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clubuser`
--

INSERT INTO `clubuser` (`id`, `club_id`, `sport_type`, `email`, `position`, `number`, `amount`, `add_date`) VALUES
(7, 4, 'football', 'joyal@gmail.com', 'midfielder', '13', '6500', '0000-00-00'),
(10, 4, 'football', 'lailausaf2000@gmail.com', 'goalkeeper', '45', '6009', '0000-00-00'),
(12, 4, 'football', 'saha@gmail.com', 'forward', '11', '80009', '0000-00-00'),
(18, 3, 'football', 'saai@gmail.com', 'goalkeeper', '45', '1000', '2024-10-17'),
(20, 3, 'football', 'hajis@gmail.com', 'goalkeeper', '5', '6000', '2024-10-17');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'paiko Das', 'paikodas@gmail.com', 'this is the first message\r\n', '2024-08-15 07:22:17');

-- --------------------------------------------------------

--
-- Table structure for table `diets`
--

CREATE TABLE `diets` (
  `id` int(11) NOT NULL,
  `sport_item` varchar(50) NOT NULL,
  `age_group` varchar(20) NOT NULL,
  `diet_plan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diets`
--

INSERT INTO `diets` (`id`, `sport_item`, `age_group`, `diet_plan`) VALUES
(1, 'Football', '18-25', 'High protein, moderate carbs, hydration with electrolytes, Whole grains, lean meats, vegetables.'),
(2, 'Football', '26-35', 'Balanced protein and carbs, Low-fat dairy, whole grains, lean protein, hydration with water and electrolytes.'),
(3, 'Football', '36-45', 'Moderate protein, lower carbs, Focus on fiber-rich vegetables, Hydration with water, Moderate portion control.'),
(4, 'Football', '46-60', 'Low-calorie, high-fiber diet, Focus on lean proteins, Healthy fats like olive oil, Hydration with water.'),
(5, 'Cricket', '18-25', 'High carbs for energy, moderate protein, lean meats, whole grains, vegetables, plenty of water.'),
(6, 'Cricket', '26-35', 'Balanced diet with more focus on carbs, Whole grains, fruits, vegetables, moderate protein, hydration.'),
(7, 'Cricket', '36-45', 'Moderate carbs, focus on fiber, Whole grains, lean protein, hydration with water.'),
(8, 'Cricket', '46-60', 'Low carbs, high fiber, Lean meats, vegetables, hydration with water.'),
(9, 'Volleyball', '18-25', 'High protein, moderate carbs, lean meats, vegetables, whole grains, hydration with water and electrolytes.'),
(10, 'Volleyball', '26-35', 'Balanced protein and carbs, more focus on vegetables and lean protein, hydration with water.'),
(11, 'Volleyball', '36-45', 'Moderate protein, low carbs, more vegetables and fiber, hydration with water.'),
(12, 'Volleyball', '46-60', 'Low-fat, high-fiber diet, Focus on lean protein, more vegetables, hydration with water.'),
(13, 'Basketball', '18-25', 'High protein, high carbs, lean meats, whole grains, fruits and vegetables, hydration with electrolytes.'),
(14, 'Basketball', '26-35', 'Balanced protein and carbs, more focus on fruits, vegetables, hydration with water.'),
(15, 'Basketball', '36-45', 'Moderate protein, low carbs, focus on vegetables, hydration with water.'),
(16, 'Basketball', '46-60', 'Low-calorie, high-fiber diet, lean proteins, hydration with water.'),
(17, 'Kabaddi', '18-25', 'High protein, moderate carbs, fiber-rich vegetables, lean meats, hydration with electrolytes.'),
(18, 'Kabaddi', '26-35', 'Balanced protein and carbs, vegetables, whole grains, hydration with water.'),
(19, 'Kabaddi', '36-45', 'Moderate protein, low carbs, more vegetables, hydration with water.'),
(20, 'Kabaddi', '46-60', 'Low-calorie, high-fiber diet, lean proteins, hydration with water.'),
(21, 'Kho-Kho', '18-25', 'High protein, moderate carbs, vegetables, lean meats, whole grains, hydration with water.'),
(22, 'Kho-Kho', '26-35', 'Balanced protein and carbs, more vegetables and fiber, hydration with water.'),
(23, 'Kho-Kho', '36-45', 'Moderate protein, lower carbs, fiber-rich vegetables, hydration with water.'),
(24, 'Kho-Kho', '46-60', 'Low-calorie, high-fiber diet, lean proteins, hydration with water.'),
(25, 'Tennis', '18-25', 'High protein, moderate carbs, lean meats, vegetables, whole grains, hydration with water and electrolytes.'),
(26, 'Tennis', '26-35', 'Balanced protein and carbs, more focus on vegetables, hydration with water.'),
(27, 'Tennis', '36-45', 'Moderate protein, low carbs, focus on vegetables, hydration with water.'),
(28, 'Tennis', '46-60', 'Low-fat, high-fiber diet, lean proteins, hydration with water.'),
(29, 'Badminton', '18-25', 'High protein, moderate carbs, lean meats, vegetables, whole grains, hydration with water and electrolytes.'),
(30, 'Badminton', '26-35', 'Balanced protein and carbs, vegetables, whole grains, hydration with water.'),
(31, 'Badminton', '36-45', 'Moderate protein, low carbs, more vegetables, hydration with water.'),
(32, 'Badminton', '46-60', 'Low-calorie, high-fiber diet, lean proteins, hydration with water.');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(10) NOT NULL,
  `club_name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `image` varchar(200) NOT NULL,
  `event_date` date NOT NULL,
  `sports` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `club_name`, `type`, `image`, `event_date`, `sports`) VALUES
(10, 'Bhaavana', 'tournament', 'kabbadi_main.jpg', '5555-05-05', 'football'),
(13, 'Bhaavana', 'event', 'fpp1.jpg', '2004-02-11', 'football'),
(15, 'Bhaavana', 'recruitment', 'fpp3.jpg', '2025-11-09', 'football'),
(16, 'Bhaavana', 'recruitment', 'fpp4.jpeg', '2004-02-27', 'football'),
(18, 'Bhaavana', 'event', 'fpp1.jpg', '2025-09-12', 'football'),
(19, 'Bhaavana', 'tournament', 'fpp5.jpeg', '2027-02-05', 'football'),
(20, 'Bhaavana', 'tournament', 'fpp5.jpeg', '2027-08-08', 'football'),
(22, 'Bhaavana', 'tournament', 'fpp2.jpg', '2029-12-12', 'football'),
(23, 'Bhaavana', 'tournament', 'fpp2.jpg', '2029-12-12', 'football'),
(24, 'Bhaavana', 'event', 'fpp3.jpg', '2035-08-09', 'football'),
(25, 'Bhaavana', 'event', 'fpp3.jpg', '2035-08-09', 'football'),
(26, 'Bhaavana', 'tournament', 'fpp5.jpeg', '2025-11-03', 'football'),
(27, 'Bhaavana', 'recruitment', 'logo.jpeg', '2045-02-01', 'football'),
(28, 'Bhaavana', 'event', 'kabbadi.jpg', '2036-02-22', 'football'),
(29, 'Bhaavana', 'event', 'fpp2.jpg', '2045-04-02', 'football'),
(30, 'Bhaavana', 'tournament', 'fpp1.jpg', '2036-02-12', 'football'),
(31, 'Bhaavana', 'tournament', 'fpp3.jpg', '2045-02-22', 'football'),
(32, 'Bhaavana', 'tournament', 'fpp5.jpeg', '2036-02-22', 'football'),
(33, 'Bhaavana', 'tournament', 'fpp2.jpg', '2025-02-12', 'football');

-- --------------------------------------------------------

--
-- Table structure for table `player_history`
--

CREATE TABLE `player_history` (
  `id` int(100) NOT NULL,
  `player_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `club` varchar(100) NOT NULL,
  `jersy_no` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_history`
--

INSERT INTO `player_history` (`id`, `player_id`, `name`, `club`, `jersy_no`, `position`, `amount`, `date`) VALUES
(33, '19', 'sharath', 'ameer@gmail.com', '11', 'forward', '12000', '2024-10-04'),
(34, '12', 'saha', 'paikodas@gmail.com', '11', 'forward', '00', '0000-00-00'),
(35, '19', 'sharath', 'paikodas@gmail.com', '11', 'forward', '8888', '2024-10-04'),
(36, '12', 'saha', 'ameer@gmail.com', '11', 'forward', '6000', '0000-00-00'),
(38, '19', 'sharath', 'ameer@gmail.com', '20', 'defender', '0', '2024-10-17'),
(39, '19', 'sharath', 'ameer@gmail.com', '45', 'goalkeeper', '1000', '2024-10-17'),
(40, '5', 'sijah mohammed', 'paikodas@gmail.com', '20', 'goalkeeper', '0', '2024-10-17'),
(41, '5', 'sijah mohammed', 'paikodas@gmail.com', '5', 'goalkeeper', '100', '2024-10-17'),
(42, '5', 'sijah mohammed', 'paikodas@gmail.com', '5', 'goalkeeper', '100', '2024-10-17');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `sp_id` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`sp_id`, `name`, `image`) VALUES
(6, 'football', 'fb.jpg'),
(7, 'cricket', 'cricket.jpg'),
(9, 'kabbadi', 'kabbadi_main.jpg'),
(18, 'Basketball', 'bask.avif'),
(23, 'vollyball', 'valley.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `district` varchar(100) NOT NULL,
  `age` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `login_count` int(11) DEFAULT 0,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `mobile`, `district`, `age`, `password`, `image`, `login_count`, `country`) VALUES
(2, 'nnn', 'abc@gmail.com', '434556666', 'mmmmmm', '34', '455', 'fb.jpg', 0, ''),
(5, 'sijah mohammed', 'hajis@gmail.com', '9447657067', 'Thiruvananthapuram', '20', '$2y$10$TfBd8sEljdqW47XhYEgTiuYS1EojWZ2X7fx7Ftv8jDj6vggci4g1e', 'main.jpg', 6, ''),
(9, 'joyal', 'joyal@gmail.com', '1234567898', 'Idukki', '21', '$2y$10$0gg8cDYBoZ75Y6dV9xB8zOKBaWk4H0KTuGejnwKb6LC86ztVT79UO', 'fb.jpg', 0, ''),
(12, 'saha', 'saha@gmail.com', '1234567898', 'Malappuram', '23', '$2y$10$E732VA4bZSwI.9vDb1jeDeBu4biEXPkE7IORot8z.cDo3PhOhdP2e', 'player6.jpeg', 1, ''),
(13, 'anu', 'lailausaf2000@gmail.com', '1234567898', 'Malappuram', '89', '$2y$10$OvvrORHySYOnme3u3rfa4eFHbZakYzSEcnrA5kWgm5ajKNRWaQaGm', 'player3.jpg', 0, ''),
(19, 'sharath', 'saai@gmail.com', '1234567898', 'Malappuram', '25', '$2y$10$fkfzG74/r5KlMYXR.yDfhuR5hO0.1Q/6xjl669E2bFlqstVnXIISy', 'player1.jpeg', 15, ''),
(20, 'Ansari', 'ansarinazeer@gmail.com', '5678645779', '', '25', '$2y$10$nI8R5OJC7QoWhEyvyLX3xOqzMmwNXEvoA5/Vj5kFoOlMvEUJcePp2', 'player7.jpeg', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `id` int(11) NOT NULL,
  `sport_item` varchar(50) NOT NULL,
  `age_group` varchar(20) NOT NULL,
  `workout_plan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`id`, `sport_item`, `age_group`, `workout_plan`) VALUES
(5, 'Football', '18-25', 'Strength training 3x/week, Agility drills, Endurance runs 3x/week, Sprint intervals 2x/week, Ball control drills.'),
(6, 'Football', '26-35', 'Low-impact cardio 3x/week, Strength training focusing on endurance, Flexibility exercises, Agility and ball control drills.'),
(7, 'Football', '36-45', 'Light cardio 3x/week, Strength training 2x/week, Flexibility and stretching, Balance training, Ball control.'),
(8, 'Football', '46-60', 'Walking or light jogging 3x/week, Strength training with lighter weights, Stretching exercises for flexibility, Light ball control.'),
(9, 'Cricket', '18-25', 'Endurance running, Sprint training, Strength training focusing on legs and arms, Fielding drills, Batting and bowling practice.'),
(10, 'Cricket', '26-35', 'Low-impact cardio, Strength training with moderate weights, Flexibility exercises, Fielding and batting drills.'),
(11, 'Cricket', '36-45', 'Light jogging, Strength training with lighter weights, Flexibility and stretching, Fielding practice.'),
(12, 'Cricket', '46-60', 'Walking or brisk walking, Light strength training, Flexibility exercises, Batting drills with minimal impact.'),
(13, 'Volleyball', '18-25', 'Jumping drills, Plyometric training, Strength exercises for core and legs, Cardiovascular exercises, Team practice sessions.'),
(14, 'Volleyball', '26-35', 'Moderate strength training, Low-impact cardio, Flexibility exercises, Jumping drills with reduced intensity.'),
(15, 'Volleyball', '36-45', 'Light cardio, Flexibility training, Core strengthening exercises, Light jumping and agility drills.'),
(16, 'Volleyball', '46-60', 'Walking or light cardio, Stretching for flexibility, Light core exercises, Mild jumping drills.'),
(17, 'Basketball', '18-25', 'Shooting drills, Strength training for upper body, Agility and sprint training, Cardiovascular conditioning, Team drills.'),
(18, 'Basketball', '26-35', 'Strength training with moderate intensity, Low-impact cardio, Flexibility exercises, Shooting and dribbling drills.'),
(19, 'Basketball', '36-45', 'Light strength training, Low-intensity cardio, Balance and flexibility exercises, Shooting drills.'),
(20, 'Basketball', '46-60', 'Walking or light jogging, Stretching exercises for flexibility, Light shooting and dribbling practice.'),
(21, 'Kabaddi', '18-25', 'Strength training 3x/week, Sprint training, Endurance runs 3x/week, Wrestling drills, Balance and agility training.'),
(22, 'Kabaddi', '26-35', 'Low-impact cardio, Strength training focusing on core and legs, Flexibility exercises, Agility and balance drills.'),
(23, 'Kabaddi', '36-45', 'Light cardio, Core and leg strengthening, Flexibility and balance exercises, Light agility training.'),
(24, 'Kabaddi', '46-60', 'Walking or light jogging, Flexibility exercises, Core strength training, Balance training.'),
(25, 'Kho-Kho', '18-25', 'Agility drills, Sprint training, Strength exercises for legs and core, Cardiovascular conditioning, Team coordination practice.'),
(26, 'Kho-Kho', '26-35', 'Moderate agility drills, Low-impact cardio, Core strengthening exercises, Flexibility training.'),
(27, 'Kho-Kho', '36-45', 'Light cardio, Flexibility exercises, Balance training, Light agility drills.'),
(28, 'Kho-Kho', '46-60', 'Walking or light cardio, Stretching and balance exercises, Light agility and flexibility exercises.'),
(29, 'Tennis', '18-25', 'Strength training for upper body, Endurance cardio 3x/week, Sprint intervals 2x/week, Flexibility and balance training, Court practice.'),
(30, 'Tennis', '26-35', 'Low-impact cardio, Strength training for endurance, Flexibility exercises, Court practice with moderate intensity.'),
(31, 'Tennis', '36-45', 'Light cardio, Flexibility and balance exercises, Strength training with lighter weights, Court practice with reduced intensity.'),
(32, 'Tennis', '46-60', 'Walking or light jogging, Flexibility and stretching exercises, Light court practice.'),
(33, 'Badminton', '18-25', 'Sprint drills, Strength training for legs and arms, Cardiovascular conditioning, Agility and reflex training, Court practice.'),
(34, 'Badminton', '26-35', 'Moderate strength training, Low-impact cardio, Flexibility and balance exercises, Court practice.'),
(35, 'Badminton', '36-45', 'Light cardio, Flexibility and balance exercises, Core strengthening, Court practice with reduced intensity.'),
(36, 'Badminton', '46-60', 'Walking or light jogging, Stretching for flexibility, Light court practice with minimal impact.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`club_id`);

--
-- Indexes for table `clubuser`
--
ALTER TABLE `clubuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diets`
--
ALTER TABLE `diets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `player_history`
--
ALTER TABLE `player_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `club`
--
ALTER TABLE `club`
  MODIFY `club_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `clubuser`
--
ALTER TABLE `clubuser`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `diets`
--
ALTER TABLE `diets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `player_history`
--
ALTER TABLE `player_history`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `sp_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
