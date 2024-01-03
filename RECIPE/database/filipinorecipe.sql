-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2024 at 09:20 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filipinorecipe`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ingredients` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `description`, `image_path`, `username`, `created_at`, `ingredients`) VALUES
(7, 'Chicken Tinola Recipe', 'Chicken Tinola is a Filipino soup dish. It involves cooking chicken pieces in ginger broth. It is a popular cold weather dish. I always feel warm and cozy every time I eat it. This Filipino Chicken Soup is best enjoyed with fish sauce as dipping sauce, and a cup of warm white rice.', 'uploads/Chicken-Tinola-Recipe.jpg', 'jmagno', '2023-12-30 00:48:12', 'Ingredients\r\n1 whole chicken cut into serving pieces\r\n36 ounces rice washing\r\n1/2 piece green papaya cut into wedges\r\n1 tablespoon garlic minced\r\n1 piece onion chopped\r\n1 thumb ginger cut into strips\r\n2 tablespoon fish sauce\r\n1 cup Hot pepper leaves\r\n3 tablespoons fish sauce\r\n1/4 teaspoon ground black pepper'),
(8, 'Pinakbet Tagalog', 'Pinakbet Tagalog is a Filipino vegetable dish. It is composed of a variety of vegetables and it also has a protein component. I made use of lechon kawali or crispy deep-fried pork belly for this recipe. This recipe is a variation of the popular Pinakbet Ilocano.', 'uploads/pakkebt.jpg', 'jmagno', '2023-12-30 12:35:37', '1 lb lechon kawali sliced\r\n1 piece Knorr Shrimp Cube\r\n12 pieces sitaw cut into 2 inch length\r\n1/2 piece kalabasa cubed\r\n12 pieces okra\r\n1 piece Chinese eggplant sliced\r\n1 piece ampalaya sliced\r\n1 piece kamote cubed (optional)\r\n2 pieces tomato cubed\r\n2 thumbs ginger crushed (optional)\r\n1 piece onion chopped\r\n4 cloves garlic crushed\r\n2 teaspoons bagoong alamang\r\n2 ½ cups water\r\n3 tablespoons cooking oil\r\n¼ teaspoon ground black pepper'),
(10, 'Adobo sa Luyang Dilaw Recipe', 'This dish uses the rich flavors of chicken combined with the peppery spiced flavor of turmeric and ginger, giving the overall dish its unique flavor.', 'uploads/Adobo sa Luyang Dilaw Recipe.jpg', 'admin', '2023-12-31 01:50:24', '3 tbsp oil for frying\r\n½ kg chicken, cut into serving-pcs.\r\n1 2-inch pc luyang dilaw (turmeric), sliced thinly\r\n1 2-inch pc ginger, sliced thinly\r\n1 head garlic, crushed\r\n1 pc bay leaf\r\n1 pc Knorr chicken cube\r\n½ cup vinegar\r\n1 ½ cups water'),
(11, 'Adobong Puti Recipe', 'This Filipino Classic dish uses the rich taste of pork marinated in the flavorful taste of Knorr Liquid Seasoning mixed with vinegar and spices.', 'uploads/puti.jpg', 'admin', '2023-12-31 01:53:34', '500 grams pork liempo, adobo cut (spareribs can also be used)\r\n5 tbsp Knorr Liquid Seasoning\r\n1 tsp crushed black peppercorn\r\n1 whole head of garlic, crushed\r\n2 cups vinegar very good quality (from Ilocos)\r\n½ pc Knorr Pork Cube diluted in 1 cup water'),
(12, 'Sinigang', 'Sinigang is a sour soup native to the Philippines. This recipe uses pork as the main ingredient. Other proteins and seafood can also be used. Beef, shrimp, fish are commonly used to cook sinigang. The chicken version, on the other hand, is called sinampalukang manok.', 'uploads/Sinigang-na-Baboy-Recipe-Panlasang-Pinoy.jpg', 'Jorge', '2023-12-31 08:42:07', '2 lbs pork belly or buto-buto\r\n1 bunch spinach or kang-kong\r\n3 tablespoons fish sauce\r\n12 pieces string beans sitaw, cut in 2 inch length\r\n2 pieces tomato quartered\r\n3 pieces chili or banana pepper\r\n▢1 tablespoons cooking oil\r\n2 quarts water\r\n1 piece onion sliced\r\n2 pieces taro gabi, quartered\r\n1 pack sinigang mix good for 2 liters water'),
(13, 'Lechon', 'Paksiw is a term associated to a dish that is cooked with vinegar and garlic. Lechon Paksiw is a Filipino pork dish made from leftover roast pig which is known as “Lechon”. Aside from using roast pig, leftover Lechon kawali can also be used.', 'uploads/lechon-paksiw-5-1-500x500.jpg', 'Jorge', '2023-12-31 08:44:54', '4 lbs. leftover Lechon or Lechon kawali\r\n3 cups Lechon sauce here is the link to our homemade authentic Lechon sauce recipe\r\n2 cups beef stock\r\n6 cloves garlic crushed\r\n2 large onions chopped\r\n1 teaspoon whole peppercorn\r\n8 pieces dried bay leaves\r\n1/2 cup soy sauce\r\n3/4 cups vinegar\r\n3/4 cups sugar\r\nsalt to taste\r\n'),
(14, 'Kare Kare', 'Kare Kare is a traditional Filipino stew complimented with a thick savory peanut sauce. The commonly used meats for this dish are ox tail, tripe, and pork leg; on some occasions goat and chicken meat are also used. Besides the peanuts, this dish depends on the shrimp paste (on the side) in order to be fully enjoyed.', 'uploads/af78558684736b541f41416b652b5eed_MMS_K_0102_1900px_944_531.jpg', 'Jorge', '2023-12-31 08:47:14', '3 lbs oxtail cut in 2 inch slices you an also use tripe or beef slices\r\n1 piece small banana flower bud sliced\r\n1 bundle pechay or bok choy\r\n1 bundle string beans cut into 2 inch slices\r\n4 pieces eggplants sliced\r\n1 cup ground peanuts\r\n1/2 cup peanut butter\r\n1/2 cup shrimp paste\r\n34 Ounces water about 1 Liter\r\n1/2 cup annatto seeds soaked in a cup of water\r\n1/2 cup toasted ground rice\r\n1 tbsp garlic minced\r\n1 piece onion chopped\r\nsalt and pepper'),
(15, 'Pancit', 'Pancit Bihon or Pancit Guisado is a Filipino noodle dish and is a staple second to rice.  This was brought by the chinese and was localized since then. This Pancit Bihon Recipe uses “Bihon” or rice sticks mixed with pork, chicken, and vegetables.', 'uploads/Pancit-Bihon-Recipe-Panlasang-Pinoy.jpg', 'Jorge', '2023-12-31 08:49:38', '1 lb pancit bihon Rice Noodles\r\n1/2 lb. pork cut into small thin slices\r\n1/2 lb. chicken cooked, deboned, and cut into thin slices\r\n1/8 lb. snow peas\r\n1 cup carrot\r\n1/2 small cabbage chopped\r\n1 cup celery leaves chopped finely\r\n1 onion chopped\r\n1/2 tbsp garlic minced\r\n1 chicken cube\r\n5 tbsp soy sauce\r\n3 to 4 cups water'),
(16, 'Crispy Pata', 'Crispy Pata or crispy pork leg is a popular Filipino pork dish. This dish can be eaten as a main dish along with rice and atcharang papaya. People also consume it as beer food or pulutan. It is best when dipped in a spicy vinegar mixture. ', 'uploads/b91749_ecb6d6fb27fa4dc7a5fc1e1598ecbf08~mv2.webp', 'Jorge', '2023-12-31 09:41:41', '\r\n1 piece whole pig leg cleaned\r\n6 pieces dried bay leaves\r\n2 tablespoons whole peppercorn\r\n4 pieces star anise optional\r\n6 teaspoons salt\r\n2 teaspoons ground black pepper\r\n2 teaspoons garlic powder\r\n12 cups water\r\n6 cups cooking oil\r\n'),
(17, 'Kinilaw', 'Kinilaw is considered an appetizer much like Latin America’s ceviche or seviche (you can think of it as the Filipino version of ceviche). In fact, there are a lot of ceviche variants from all over the world but this version from the Philippines is something that you must try.', 'uploads/kilawin-recipe-kinilaw-ingredients-filipino-cuisine-appetizer-pulutan.jpg', 'Jorge', '2023-12-31 09:44:57', '500 grams fresh yellowfin tuna fillet, cut into cubes (see *Note 1)\r\n3/4 cup vinegar (for washing)\r\n1/3 cup vinegar (or spiced vinegar if you have one)\r\n1 red onion, chopped\r\n2 tablespoons of ginger, sliced into fine strips or small cubes\r\n4 tablespoons of Filipino calamansi (you can also use lime or lemon as a substitute)\r\nSalt and freshly ground black pepper to taste\r\n» Garnishes\r\n3 pieces Thai chili or bird’s eye chili, chopped (optional)\r\n1 tablespoon of sugar (optional)\r\n1 tomato, diced (optional)');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_reviews`
--

CREATE TABLE `recipe_reviews` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_reviews`
--

INSERT INTO `recipe_reviews` (`id`, `recipe_id`, `user_name`, `rating`, `comment`) VALUES
(1, 7, '', 5, 'wow'),
(2, 7, '', 5, 'ansarap'),
(3, 12, '', 5, 'wow palong palo');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'jmagno', '$2y$10$sSIHcdaLAWAgqO8MRfYE4OG6jp/ooNkax1xBCaFQe0oSundwzi7aS'),
(2, 'admin', '$2y$10$zo81hBmLOdfNdrr4IQyGYuSI.cMB8GMwTDL6/f7KYccFAjK/t.xtK'),
(3, 'Jorge', '$2y$10$KhQXZlCtNLgkVjcpp.wXfumcqjrV4mkJRnHCgnXcqgsMkqDJyUhcG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe_reviews`
--
ALTER TABLE `recipe_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `recipe_reviews`
--
ALTER TABLE `recipe_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipe_reviews`
--
ALTER TABLE `recipe_reviews`
  ADD CONSTRAINT `recipe_reviews_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
