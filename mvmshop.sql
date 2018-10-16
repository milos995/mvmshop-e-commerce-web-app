-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2018 at 11:55 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvmshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Pierre Cardin'),
(2, 'Adidas'),
(6, 'Nike'),
(7, 'Lee Cooper'),
(8, 'Everlast'),
(9, 'Under Armour'),
(10, 'Lonsdale'),
(11, 'Slazenger'),
(12, 'Firetrap'),
(13, 'Puma'),
(14, 'Tapout'),
(15, 'Golddigga'),
(16, 'NORDBLANC');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `ordered` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `ordered`, `shipped`) VALUES
(1, '[{\"id\":\"2\",\"size\":\"S\",\"quantity\":4},{\"id\":\"1\",\"size\":\"28\",\"quantity\":\"1\"}]', '2018-02-19 13:24:37', 0, 0),
(3, '[{\"id\":\"1\",\"size\":\"28\",\"quantity\":\"1\"},{\"id\":\"2\",\"size\":\"M\",\"quantity\":\"2\"}]', '2018-02-19 15:20:59', 1, 1),
(4, '[{\"id\":\"3\",\"size\":\"S\",\"quantity\":\"1\"},{\"id\":\"1\",\"size\":\"36\",\"quantity\":\"2\"}]', '2018-02-20 11:48:12', 1, 0),
(5, '[{\"id\":\"2\",\"size\":\"S\",\"quantity\":\"1\"},{\"id\":\"1\",\"size\":\"32\",\"quantity\":\"2\"}]', '2018-02-20 11:56:19', 1, 0),
(6, '[{\"id\":\"4\",\"size\":\"XS\",\"quantity\":\"1\"},{\"id\":\"5\",\"size\":\"XL\",\"quantity\":\"2\"}]', '2018-02-20 12:37:34', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Muskarci', 0),
(2, 'Zene', 0),
(3, 'Majice', 1),
(4, 'Pantalone', 1),
(5, 'Jakne', 1),
(6, 'Trenerke', 1),
(7, 'Majice', 2),
(8, 'Pantalone', 2),
(9, 'Jakne', 2),
(10, 'Trenerke', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cart_id`, `full_name`, `email`, `phone`, `street`, `city`, `zip_code`, `sub_total`, `description`, `order_date`) VALUES
(1, 3, 'Milos Mastilovic', 'milosh_995@yahoo.com', '643771185', 'Vladimira Mitrovica 110 A1', 'Belgrade', '11000', '12772.00', '3 proizvoda od MVM shop-a.', '2018-01-21 11:25:18'),
(7, 4, 'Milos Mastilovic', 'milosh_995@yahoo.com', '643771185', 'Vladimira Mitrovica 110 A1', 'Belgrade', '11000', '20000.00', '3 proizvoda od MVM shop-a.', '2018-01-21 11:48:18'),
(8, 5, 'Milos Mastilovic', 'milosh_995@yahoo.com', '643771185', 'Vladimira Mitrovica 110 A1', 'Belgrade', '11000', '12494.00', '3 proizvoda od MVM shop-a.', '2018-01-21 11:56:25'),
(9, 6, 'Milos Mastilovic', 'milosh_995@yahoo.com', '643771185', 'Vladimira Mitrovica 110 A1', 'Belgrade', '11000', '11328.00', '3 proizvoda od MVM shop-a.', '2018-01-21 12:37:53');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`) VALUES
(1, 'Pierre Cardin Mens Jeans', '4072.00', '5090.00', 1, '4', '/mvmshop/img/products/1.jpg', 'These Pierre Cardin Web Belt Mens Jeans offer a straight fit that is ideal for an everyday style that can be worn with any outfit. The jeans feature a zip fly and a button fastening and come with a branded belt with adjustable sizes for a comfortable fit. Four open pockets to the front and the back offer storage for personal belongings.', 1, '30:5,32:2,34:10,36:3'),
(2, 'Adidas 3 Stripes Polo Shirt', '4350.00', '5430.00', 2, '3', '/mvmshop/img/products/2.jpg', 'Get an iconic casual appearance with the adidas 3 Stripes Logo Polo Shirt, crafted from a soft cotton pique with a two button placket, regular fold down collar and short sleeves with ribbed cuffs in a regular fit. Completed with familiar three stripe branding to the shoulders and arms with a printed adidas logo to the chest.', 1, 'S:19,M:4,L:2,XL:12'),
(3, 'Nike Dry Jacket Ld74', '11856.00', '14820.00', 6, '9', '/mvmshop/img/products/d965aafec4577d1312594aa6c3463ba3.jpg', 'The ladies Nike Dry Jacket is the finishing touch to the perfect tennis outfit. Featuring dri-fit technology, this long sleeve jacket has a full zip fastening, a breathable lining and a recognisable finish with the Nike Swoosh. ', 1, 'XS:5,S:15,M:3,L:10'),
(4, 'Lee Cooper Fashion T Shirt', '1552.00', '1940.00', 7, '7', '/mvmshop/img/products/b7a28e65d73c021f79def3b5a228b3bb.jpg', 'This Lee Cooper Fashion T Shirt is crafted with short sleeves and a crew neck. It is a lightweight construction that is regular fitting for a simple but stylish look. This t shirt is a block colour design with a printed motif to the front. This look is complete with Lee Cooper branding.', 0, 'XS:6,S:9,L:15,XL:26'),
(5, 'Lee Cooper Padded Jacket', '4888.00', '6110.00', 7, '5', '/mvmshop/img/products/d31266d965039eedd8d8426dd5f1807b.jpg', 'The Lee Cooper Mixed Fabric Padded Jacket provides a great casual wear, featuring a padded gilet style body with sweatshirt-like sleeves and hood, two snap fastening pockets and embroidered Lee Cooper logo to finish.', 1, 'L:15,XL:23,XXL:5'),
(8, 'Pierre Cardin C Printed Tee S81', '1598.00', '2130.00', 1, '3', '/mvmshop/img/products/584b8a737153d527f341158bc5a5bbec.jpg', 'Add a new addition to your wardrobe with this Pierre Cardin Printed T Shirt - its lightweight construction is styled with a crew neck and short sleeves combination for that classic everyday look. A large printed motif is located to the front of the chest and features Pierre Cardin branding for that instant brand recognition. ', 0, 'S:5,M:15,L:23,XL:2,XXL:5'),
(9, 'Under Armour Sportstyle Logo TShirt Mens', '4328.00', '5770.00', 9, '3', '/mvmshop/img/products/26c66f06470960a60fcf84325c7dfe8d.jpg', 'This Under Armour Sportstyle Logo T-Shirt is a great everyday style that can also be worn whilst exercising thanks to the HeatGear technology moisture wicking fabric that pulls sweat away from your body. The t-shirt is a crew neck style with short sleeves and is finished with a large Under Armour logo to the front for instant brand recognition.', 1, 'S:24,M:4,L:2,XL:6,XXL:13'),
(10, 'Lonsdale Yard Stripe Polo Shirt Mens', '1568.00', '2090.00', 10, '3', '/mvmshop/img/products/6694a81ff8a5d02a75f3e0e951e35ee6.jpg', 'Get a comfortable and stylish look with the Lonsdale Yard Stripe Polo Shirt, designed with a three button placket, fold down collar, short sleeves with ribbed cuffs and bold stripe design. The polo is cut to a regular fit and completed with a sleek Lonsdale branding tab to the chest. ', 0, 'S:2,XL:8,XXL:5,XXXL:7'),
(11, 'Slazenger Plain Polo Shirt Mens', '1950.00', '2600.00', 11, '3', '/mvmshop/img/products/a604e7be3ff097cc9d2e5804106cbb77.jpg', 'This Slazenger Plain Polo shirt is a basic style that is sure to look great with any outfit. The polo features a regular collar and short sleeves with a three button placket for a comfortable fit. The top is finished with split sides and an embroidered Slazenger logo for an instantly recognisable branded look.', 0, 'S:5,M:15,L:12'),
(12, 'Lee Cooper Regular Jeans Mens', '1955.00', '2607.00', 7, '4', '/mvmshop/img/products/d62e84ae41c8a7ea51a74289743527d5.jpg', 'The Lee Cooper Regular Jeans has been constructed with a classic 5 pocket design and Lee Cooper branding for a great look, whilst the button fly and waist provides an improved fit. ', 0, '36:5,38:12'),
(13, 'Firetrap Blackseal Navy Mens Jeans', '8827.00', '11770.00', 12, '4', '/mvmshop/img/products/b0092f9d6e15076a122dea9051cf8124.jpg', 'Enjoy a truly premium wear in these truly stylish Navy Men&#039;s Jeans by Firetrap Blackseal, crafted with a triple button fastening fly and single button fastening waist, in a classic five open pocket design and a slim fit. A Firetrap Blackseal branding badge sits to the back of the waist. ', 1, '28:12,30:24,32:4,34:5'),
(14, 'Firetrap Skinny Mens Jeans', '5887.00', '7850.00', 12, '4', '/mvmshop/img/products/333870e1702f8a046d5390cc3cd7c9c4.jpg', 'Keep things simple with this incredible range of men&rsquo;s slim fit jeans great for wearing every day. Treat yourself to a new pair of jeans from our collection to update your wardrobe. Why not also have a browse through our sweats and hoodies too!', 0, '28:2,34:5,36:12,38:13'),
(15, 'Slazenger Golf Pin Striped Trousers Mens', '1950.00', '2600.00', 11, '4', '/mvmshop/img/products/3c0781dae3d2f351e27670a5c2128fca.jpg', 'The Slazenger Golf Pin Striped Trousers benefit from a standard fit and classic pin striped design, whilst the buttoned waist and zipped fly with rubberised trim allows for a secure and comfortable fit and the multiple pockets provide plenty of storage for those essentials. ', 0, '30:2,34:5,40:2'),
(16, 'Everlast Knit Sleeve Jacket Mens', '4328.00', '5770.00', 8, '5', '/mvmshop/img/products/3ae75fb5aab5fc888a98dc63087aaa46.jpg', 'The Everlast Knit Sleeve Jacket features lightweight synthetic padding to the body, complete with contrasting knitted textile sleeves featuring ribbed cuffs.', 0, 'S:2,M:5,L:3'),
(17, 'Lee Cooper C PadKnt CamoJkt Sn81', '3817.00', '5090.00', 7, '5', '/mvmshop/img/products/7e1b46fc32e0a372e521981b694c2eea.jpg', 'Lee Cooper Padded Camo Jacket Mens', 1, 'M:21,XL:5,XXL:13'),
(18, 'Nike AV15 Filled Jacket Mens', '13875.00', '18500.00', 2, '5', '/mvmshop/img/products/039dde367104a1f276b636305a34b1ae.jpg', 'This Nike AV15 Filled Jacket offers warmth when the coldness strikes outside - made up of a EVOdown thermal insulation to promote a warm feeling which locks on your body heat and prevents the cold creeping in. Its quilted design is styled with long sleeve with panelled detail and elasticated wrist cuffs and a full length zipped fastening with a high neck collar and chin guard for a personalised, comfortable fit perfect to for you. This jacket is designed with two large zipped pockets and a printed Nike Swoosh to one side of the chest for instant brand recognition', 0, 'S:23,M:13,L:5,XL:9'),
(19, 'Everlast Premium Closed Hem Jogging Bottoms', '3540.00', '4720.00', 8, '6', '/mvmshop/img/products/26e59a94333f24733841e137423e6936.jpg', 'Everlast Premium Closed Hem Jogging Bottoms Mens Enjoy casual style in the Everlast Premium Closed Hem Jogging Bottoms, crafted with a wide elasticated waistband with external drawstring and closed hems, plus three zip fastening pockets, one being to the back of the waist. Mesh panelling sits to the side of each leg and a fleece lining sits to the inner. Colour contrasting panelling and accenting sits with Everlast branding to complete the look.', 1, 'S:5,L:14'),
(20, 'Puma Evo Training Tracksuit Bottoms Mens', '6158.00', '8210.00', 13, '6', '/mvmshop/img/products/dcd244d0e1334b8ad4450a9017c82c06.jpg', 'Get the most out of your training sessions with these Mens Puma Evo Training Tracksuit Bottoms which have a drawstring fastening and elasticated waist for a secure fit that is comfortable, whilst the dryCELL technology wicks sweat to ensure you remain dry so you can focus on your performance. These tracksuit bottoms also benefit from having two pockets so you can carry everything you need and the zipped hems allow you to get an adjustable fit to tailor the fit to your needs. ', 0, 'S:2,L:10,XL:9'),
(21, 'Tapout Jog Pant Snr73', '3675.00', '4900.00', 14, '6', '/mvmshop/img/products/f1edc75e038794347c893ff4ef0ea4a7.jpg', 'These Mens Tapout Jog Pants have been crafted with a drawstring fastening with an elasticated waist for a secure and comfortable fit, whilst the fleece lining offers great comfort whilst retaining warmth. These sweat pants are completed with Tapout branding located on the thigh and the two pockets allow you to carry all you need. ', 1, 'S:5,M:13,L:15,XL:2'),
(22, 'Lonsdale Essential Joggers Mens', '2993.00', '3990.00', 10, '6', '/mvmshop/img/products/9b154dcef47727deb9241525b6fbc793.jpg', 'These Lonsdale Essential Joggers are designed with a jersey outer and a soft fleece lining to promote a casual feel that is warm but yet comfortable. A elasticated waistband is teamed with a drawstring tie fastening and elasticated ankle cuffs to allow for a secure fitting at all times. These joggers are constructed with padded panelling to the knees and two front and back pockets to complete the style. A Lonsdale logo is situated to the left hip to offer a complete look. ', 0, 'S:1,M:5,L:15'),
(23, 'Pierre Cardin Track Jogging Bottoms Mens', '3540.00', '4720.00', 1, '6', '/mvmshop/img/products/277b83a674254444404a951366791e8d.jpg', 'This Pierre Cardin Track Jogging Bottoms are designed with a soft and comfortable fabric with stretch for a closer fit, featuring an elasticated waistband, drawstring fastening and ankle cuffs, three open pockets and completed with a stylish taped stripe design down the sides of the legs plus subtle embroidered Pierre Cardin branding.', 0, 'M:15,XL:8,XXL:10'),
(24, 'Lonsdale Logo T Shirt Ladies', '1252.00', '1670.00', 10, '7', '/mvmshop/img/products/33a96e5a8d768a06beaed1501445c91f.jpg', 'Enjoy style in this Lonsdale Logo T Shirt colour contrasting crew neck and short sleeves, in a regular and lightweight fit, with large metallic Lonsdale branding across the chest. ', 0, 'XS:5,XL:15,XXL:5'),
(25, 'Firetrap Check Shell Top', '3540.00', '4720.00', 12, '7', '/mvmshop/img/products/09eea5e7a555d338a4b8864477112400.jpg', 'The Firetrap Check Shell Top Ladies is a lightweight top ideal for wearing during the summer months and will help keep you cool whilst looking bang on trend. The top features crew neck collar with button fastening on the back for a comfortable fit. The check design features on the whole of the top for an eye catching design and ensures you stand out this summer. ', 1, 'XS:8,S:10,M:12'),
(26, 'Firetrap Cross V Neck Camisole Top Ladies', '2092.00', '2790.00', 12, '7', '/mvmshop/img/products/7669fdcc2d582b935ada1c508345bdf3.jpg', 'Find the ideal wear for dressing up or dressing down in this Firetrap Cross V Neck Camisole Top, crafted with a V neck and in a sleeveless design, with a cross over feature point to the back. A Firetrap branding tab sits at the front hem. \r\n', 0, 'XS:8,M:12,L:14,XL:16'),
(27, 'Puma N01 Logo Tank Lds 73', '1890.00', '2520.00', 13, '7', '/mvmshop/img/products/d92be5dc64ff0293e9aab7f5ef202833.jpg', 'This Ladies Puma N01 Logo Tank Top has been crafted with a scoped neck, whilst the sleeves design ensures great ventilation and the classic Puma branding completes the great look. \r\n', 1, 'XS:8,S:5,M:6,XL:14'),
(28, 'Firetrap Naomi Vanessa Jeans Ladies', '8025.00', '10700.00', 12, '8', '/mvmshop/img/products/dbd3052f8756acf89dd329c5791f9a27.jpg', 'Enjoy a style statement in these Firetrap Naomi Vanessa Jeans, crafted a in soft, flexible denim, with a a zip fastening fly and button fastening waist, in a classic five open pocket design and a right-on-trend washed effect and destroyed patches, as a skinny wear. \r\n', 1, 'M:5,L:15'),
(29, 'Golddigga AOP Jeggings Ladies', '1950.00', '2600.00', 15, '8', '/mvmshop/img/products/417cdba875571b6c974b928bed9ca959.jpg', 'The Ladies Golddigga AOP Jeggings have been crafted with an all over print design coupled with an elasticated design and button fastening waistband that makes them perfect for everyday wear, completed with the Golddigga branding. ', 0, 'XS:15,S:3,M:16'),
(30, 'Golddigga Three Quarter Jean Jeggings Ladies', '1950.00', '2600.00', 15, '8', '/mvmshop/img/products/4364c83bfef955dffaa51629ac6f4a3a.jpg', 'Enjoy comfortable fashion in these Golddigga 3/4 Jean Jeggings, crafted in a cropped length with a zip fastening fly and single button fastening waist, with two faux front pockets and two open back pockets and an all over stretch. ', 0, 'XXS:15,XS:5,M:16'),
(31, 'Nike Jean Style Golf Pants Womens', '4072.00', '5430.00', 6, '8', '/mvmshop/img/products/e0b7e2298b4c969d9ba05c98fb045026.jpg', 'These Nike Jean Style Golf Pants are a bootleg style with a lightweight fabric construction. The zip fly and double button fastening ensures a comfortable fit with belt loops if you wish to add a belt for style and a more secure fit. The Dri-Fit technology that the trousers feature pulls sweat away from the skin, keeping you dry and comfortable when your body heats up on the course. Four pockets and instantly recognisable Nike branding finishes off the design of the trousers. ', 0, 'XS:16,S:2,M:5'),
(32, 'Slazenger Winter Golf Trousers Ladies', '3675.00', '4900.00', 11, '8', '/mvmshop/img/products/753ad227a0814be48273d900753c6867.jpg', 'Be warm and comfortable when hitting the course in colder weather with the Slazenger Winter Golf Trousers, which include a button fastening waistband, zip fly, four pockets and are completed with Slazenger branding. ', 1, 'XXS:16,XS:5,M:4,L:13'),
(33, 'Everlast Bubble Bomber Jacket Ladies', '3917.00', '5222.00', 8, '9', '/mvmshop/img/products/65b642022582e0c4ae9242d84387df68.jpg', 'Turn heads for all of the right reasons in the Everlast Bubble Bomber Jacket, designed with full zip fastening to a high neck, full length sleeves and two hidden zip fastening hand pockets. The bubble padding sits in a stunning metallic finish, with Everlast branding to the trims to complete the look. ', 0, 'S:5,L:13'),
(34, 'Winter feather jacket women NORDBLANC Purpote', '11700.00', '15600.00', 16, '9', '/mvmshop/img/products/f1aac14e0645a8a66eff52fc79a1a497.jpg', 'Women&acute;s winter down jacket is padded with a lot of high quality down. Thanks to the down padding and light material it is very adaptable and pleasant. Even it is heavy padded, it is still very lightweight. ', 1, 'M:15,L:5'),
(35, 'Lee Cooper Ladies Bubble Jacket', '4072.00', '5430.00', 7, '9', '/mvmshop/img/products/4620074f921710e04fa7e6880222ade7.jpg', 'This Lee Cooper Ladies Bubble Jacket features a two zip fasten to allow extra insulation throughout the winter months, it has two zip pockets on the outer to assure security for your belongings. The jacket is lined with fur to provide warmth and it has elasticated wrist cuffs to make sure the jacket is comfortable and keep air in. The jacket has a padded look which makes it fashionable and is the perfect winter look. ', 0, 'XS:5,S:15'),
(36, 'Lee Cooper Slim Joggers Ladies', '1740.00', '2320.00', 7, '10', '/mvmshop/img/products/22c665278155f886b6689ce39b57629b.jpg', 'These Lee Cooper Slim Joggers are made up of a jersey outer and brushed fleece lining combination to promote a comfortable feel that is ideal for lazy days lounging. Its wide elasticated waistband is coupled up with a drawstring fastening and closed hem cuffs for a secure fitting. Its block coloured design is complete with two open pockets and a small Lee Cooper logo to one of the legs. ', 0, 'XS:15,S:5,L:3'),
(37, 'Everlast Large Logo Closed Hem Pants Ladies', '2647.00', '3530.00', 8, '10', '/mvmshop/img/products/3e3ca101615d9d8225b60ad66cb08274.jpg', 'Perfect for casual days are these Everlast Large Logo Closed Hem Pants - designed with a jersey construction that features a soft fleece lining for that added comfort and warmth. Its tapered designed is coupled up with closed hem cuffs and a wide elasticated waistband and two open front pockets and singular back pocket. Everlast branding is located to one of the legs to complete the overall look. ', 1, 'XS:13,S:5,L:15'),
(38, 'adidas ClimaLite Three Quarter Tights Ladies', '4072.00', '5430.00', 2, '10', '/mvmshop/img/products/62b4b81c9694a6b52713a197e56714ca.jpg', 'The adidas ladies tights are ideal for working out, training or sports, featuring a 3/4 construction for a cool feel coupled with a stretch fabric for a close fit and an elasticated waistband for a secure feel even during intense activity. These ladies fitness tights benefit from ClimaLite that actively wicks away sweat and moisture from the body to leave you feeling dry and cool all through your workout, finished with the classic adidas branding. ', 0, 'XS:6,M:15'),
(39, 'Puma Essential Three Quarter Tights Ladies', '3817.00', '5090.00', 13, '10', '/mvmshop/img/products/052dece8eff0b5bf136dca11d19cbbcc.jpg', 'Be sure to get a great workout in these Puma Essential Three Quarter Tights with their dry cell technology allowing you to keep comfortable and dry during your workout. ', 0, 'XS:15,S:7,M:12'),
(40, 'Nike Dry Graphic Training Capris Ladies', '4555.00', '5940.00', 6, '10', '/mvmshop/img/products/19fde86c56f6ac08465ebc3343e49806.jpg', 'Train in style in these Nike Dry Graphic Training Capris, crafted as a cropped fit, with a wide elasticated waistband and Dri-Fit technology for a sweat wicking wear. A large colour contrasting printed Nike Swoosh sits to one calf, with a smaller Swoosh to the waistband. \r\n', 1, 'S:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Milos Mastilovic', 'milos@gmail.com', '$2y$10$wm.XmgTvlgqGHiC7LNkQQek2q2HNRHuM3wNRv1VGrZTPx6BJX9qk6', '2018-01-19 13:41:21', '2018-01-21 17:06:52', 'admin,editor'),
(4, 'Luka Milovanovic', 'luka@gmail.com', '$2y$10$iX.gnEuO/v2Z5TJ9D4OVn.BmHafSw/FUlZhnKMGCQI4h8Qt9anVvC', '2018-01-21 17:07:22', '2018-01-21 17:08:21', 'admin,editor'),
(5, 'Djordje Vukicevic', 'djole@gmail.com', '$2y$10$aMdUg4yA/9yJwRmdBrD0/.q7jCMCDT3OE102.P.viPcCDrBaBgmYq', '2018-01-21 17:07:55', '2018-01-21 17:08:07', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
