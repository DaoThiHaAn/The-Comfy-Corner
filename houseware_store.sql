-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 05:49 PM
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
-- Database: `houseware_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(2, 'bathroom'),
(3, 'bedroom'),
(1, 'kitchen'),
(4, 'livingroom'),
(5, 'outdoor');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(10000) DEFAULT NULL,
  `price` float NOT NULL,
  `category_id` int(2) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `category_id`, `image`) VALUES
('bar1', 'Bathroom Mirror', NULL, 1000000, 2, 'bathroom-mirror.jpg'),
('bar2', 'Blue Bathroom Mug', NULL, 30000, 2, 'bathroom-mug.jpg'),
('bar3', 'Wooden Clothe Hanger', 'Key Feature\r\n- Size: Approximately 17.5 inches wide – ideal for coats, shirts, and dresses.\r\n- Premium Solid Wood – Durable and long-lasting with a polished, elegant look.\r\n- Notched Shoulders – Designed to securely hold dresses, tops, and garments with straps.\r\n- Strong Chrome Hook – 360° swivel for easy access and hanging convenience.\r\n- Pant Bar Included – Ideal for trousers, scarves, or ties, ensuring a neat wardrobe.', 15000, 2, 'clothe-hanger.jpg'),
('br1', 'Zigzag Floor Lamp', 'Brighten up your space with our Zigzag Floor Lamp—a perfect blend of modern design and functionality! With its sleek, eye-catching zigzag frame, this lamp adds a stylish statement to any room while providing optimal lighting. Crafted from premium materials, it’s durable, space-saving, and ideal for living rooms, bedrooms, or offices. Upgrade your décor with this contemporary masterpiece.\r\nHeight: 60 inches (152 cm), Base Width: 10 inches (25 cm)', 550000, 3, 'zigzag-floor-lamp.jpg'),
('br10', 'Medium Wardrobe', ' Size:\r\n- Width: 48 inches (122 cm)\r\n- Height: 72 inches (183 cm)\r\n- Depth: 20 inches (51 cm)\r\n\r\nFeatures:\r\n- Spacious Compartments – Store clothes, shoes & more effortlessly.\r\n- Durable Wooden / Metal Frame – Built to last.\r\n- Sliding or Hinged Doors – Choose your style.\r\n- Modern & Classic Finishes – Matches any décor.', 6000000, 3, 'medium-wardrobe.jpg'),
('br11', 'Big-sized Wooden Wardrobe', 'Need more space for your clothes and accessories? Our big-sized wardrobe offers the perfect combination of style, durability, and functionality to keep your room organized and clutter-free!\r\n\r\nSize:\r\n- Width: 72 inches (183 cm)\r\n- Height: 80 inches (203 cm)\r\n- Depth: 24 inches (61 cm)\r\n\r\nFeatures:\r\n- Spacious Storage – Multiple compartments, shelves, and hanging space.\r\n- Premium-quality Wood / Metal – Sturdy and long-lasting.\r\n- Sliding or Hinged Doors – Choose your style.\r\n- Modern & Elegant Finishes – Complements any décor.', 15000000, 3, 'big-wardrobe.jpg'),
('br12', 'White Wardrobe With Mirror', 'Upgrade your bedroom with a sleek and spacious white wardrobe with a built-in mirror! Designed for both storage and elegance, this wardrobe keeps your space organized while adding a touch of modern sophistication.\r\n\r\nSize: 72” W × 80” H × 24” D\r\n\r\nFeatures:\r\n- Full-Length Mirror – Perfect for dressing up with ease.\r\n- Spacious Storage – Multiple shelves, drawers & hanging space.\r\n- Modern White Finish – Brightens up any room.\r\n- Durable & Sturdy – High-quality wood for long-lasting use.\r\n- Sliding or Hinged Doors – Choose the style that suits you best.', 17000000, 3, 'white-wardrobe.jpg'),
('br13', 'Wooden Bed', 'Experience the perfect blend of simplicity and strength with our Simple Wooden Bed! Crafted from high-quality solid wood, this bed frame adds a natural and cozy touch to any bedroom while ensuring long-lasting durability.', 8000000, 3, 'wooden-bed.jpg'),
('br2', 'Adjustable Floor Lamp', 'Enhance your home with our Adjustable Floor Lamp, designed for ultimate versatility and style! Whether you\'re reading, working, or relaxing, this lamp provides customizable lighting to suit your needs.\r\n\r\nKey Features:\r\nAdjustable Height & Angle – Easily modify the lamp’s height (50-70 inches / 127-178 cm) and direction for perfect lighting\r\nSpace-Saving & Sleek – A modern, minimalist design that fits any room\r\nSturdy & Durable – Made from high-quality metal and a stable base for long-lasting use\r\nMultiple Light Modes – Choose from warm, neutral, or cool lighting to match your mood\r\nPerfect for living rooms, bedrooms, offices, or study areas!', 600000, 3, 'adjustable-floor-lamp.jpg'),
('br3', 'Combo Makeup Vanity Dressing Table and Chair', 'Upgrade your beauty routine with our stylish makeup table, designed for efficient storage and organization. Featuring spacious drawers, compartments, and a sleek mirror, it\'s perfect for keeping your cosmetics, skincare, and accessories neatly arranged. Ideal for any vanity setup, this table adds a touch of elegance and convenience to your daily routine. Shop now for the perfect blend of style and functionality!', 5600000, 3, 'makeup-table.jpg'),
('br4', 'Colorful Dream Catcher', 'Bring positive vibes and vibrant colors into your space with a beautifully handcrafted colorful dream catcher! Let its intricate web catch bad dreams while allowing good ones to flow through, filling your nights with peace and inspiration.', 300000, 3, 'dream-catcher.jpg'),
('br5', 'Name Board', ' Available Sizes:\r\nSmall: 8\" x 4\" (Perfect for desks & small spaces)\r\nMedium: 12\" x 6\" (Great for doors & walls)\r\nLarge: 18\" x 8\" (Bold statement piece!)', 20000, 3, 'name-board.jpg'),
('br6', 'Portable Night Lamp', 'Providing cozy light for your sleeping!', 100000, 3, 'night-lamp.jpg'),
('br7', 'Wooden Tall Dresser', 'Space-Saving: Tall design fits in small rooms.\r\nDurable & Stylish: Crafted from high-quality wood (oak, walnut, pine, etc.).\r\nAmple Storage: Multiple deep drawers for easy organization.\r\nTimeless Appeal: Classic or modern wood finishes to match any interior.', 3500000, 3, 'tall-dresser.jpg'),
('br8', 'Wooden Drawer', NULL, 1000000, 3, 'drawer.jpg'),
('br9', 'White Wooden Nightstand', NULL, 900000, 3, 'nightstand.jpg'),
('kc1', 'Pink Silicone Kitchenware Set', 'Premium Silicone Kitchenware Set – The Ultimate Cooking Companion!\r\n\r\nUpgrade your kitchen with our complete silicone kitchenware set, designed for durability, convenience, and style. Made from high-quality, food-grade silicone, this set ensures safe and effortless cooking while protecting your cookware from scratches.\r\n\r\nWhat’s Included?\r\nVariety of Utensils – Spatulas, ladles, slotted spoons, turners, tongs, whisk, and more!\r\nHeat-Resistant & Non-Stick – Withstands high temperatures without melting or warping.\r\nSoft & Flexible – Gentle on non-stick cookware, preventing scratches and damage.\r\nErgonomic Handles – Comfortable grip for effortless cooking.\r\nEasy to Clean & Hygienic – Dishwasher-safe, stain-resistant, and odor-free.\r\nStylish & Modern Design – Perfect for any kitchen aesthetic.\r\n\r\nWhether you\'re a home chef or a cooking enthusiast, this silicone kitchenware set is a must-have for easy, mess-free, and enjoyable cooking. Get yours today and elevate your kitchen experience!', 500000, 1, 'silicone-kitchenware.jpg'),
('kc2', 'ELectricity Pressure Cooker', 'Premium Pressure Cooker – Fast, Safe, and Efficient Cooking!\r\nCook your favorite meals up to 70% faster with our high-quality pressure cooker! Designed for convenience, safety, and efficiency, this kitchen essential locks in flavor and nutrients while reducing cooking time.\r\n\r\nKey Features:\r\n- Durable Stainless Steel/Aluminum Body – Ensures long-lasting performance and even heat distribution. Multiple Safety Mechanisms – Equipped with a secure locking lid, pressure release valve, and gasket seal for worry-free cooking.\r\n- Fast & Energy-Efficient – Cooks beans, meats, rice, soups, and more in a fraction of the time.\r\n- Retains Nutrients & Flavor – Sealed cooking preserves vitamins and enhances taste.\r\n- Compatible with Multiple Stovetops – Works on gas, electric, and induction cooktops.\r\n- Easy to Use & Clean – Simple operation with a sturdy handle and dishwasher-safe components.\r\n\r\nMake meal prep quicker and healthier with this versatile pressure cooker—perfect for busy kitchens and home chefs!', 700000, 1, 'pressure-cooker.png'),
('kc3', 'Electricity Rice Cooker', 'Key Features:\r\n- Automatic Cooking & Keep-Warm Function – No more overcooked or burnt rice!\r\n- Non-Stick Inner Pot – Easy to clean and prevents rice from sticking.\r\n- One-Touch Operation – Simple and hassle-free cooking experience.\r\n- Versatile Use – Cook rice, quinoa, porridge, and even steam vegetables.\r\n- Compact & Stylish Design – Perfect for any kitchen size.\r\n- Energy-Efficient & Safe – Uses minimal electricity while ensuring safety features like overheat protection.', 850000, 1, 'rice-cooker.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
