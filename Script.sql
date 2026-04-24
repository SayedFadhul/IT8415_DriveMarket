-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 22, 2026 at 12:49 AM
-- Server version: 8.0.45-0ubuntu0.24.04.1
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drivemarket`
--

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `sp_GetCarsByCreator` (IN `p_creator_id` INT)   SELECT title, brand, model, car_year, price, status, created_at
FROM dbProj_cars
WHERE creator_id = p_creator_id
ORDER BY created_at DESC$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `dbProj_appointments`
--

CREATE TABLE `dbProj_appointments` (
  `appointment_id` int NOT NULL,
  `car_id` int NOT NULL,
  `user_id` int NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbProj_appointments`
--

INSERT INTO `dbProj_appointments` (`appointment_id`, `car_id`, `user_id`, `appointment_date`, `appointment_time`, `notes`, `created_at`) VALUES
(1, 22, 3, '2026-05-05', '10:30:00', 'Looking forward to testing the car and checking its overall condition.', '2026-05-01 10:15:00'),
(2, 23, 3, '2026-05-12', '12:00:00', 'Interested in a test drive before making any final offer.', '2026-05-03 14:20:00'),
(3, 20, 4, '2026-05-05', '16:00:00', 'I would like to review the car and discuss the details during the visit.', '2026-05-01 10:15:00'),
(4, 21, 4, '2026-05-12', '17:30:00', 'I want to inspect the interior and performance during the appointment.', '2026-05-03 14:20:00'),
(5, 17, 5, '2026-05-05', '09:00:00', 'Interested in checking the car condition and comfort before deciding.', '2026-05-01 10:15:00'),
(6, 18, 5, '2026-05-12', '10:30:00', 'Please confirm the appointment. I am interested in a proper test drive.', '2026-05-03 14:20:00'),
(7, 44, 6, '2026-05-05', '12:00:00', 'This appointment is for checking the car and confirming its condition.', '2026-05-01 10:15:00'),
(8, 14, 6, '2026-05-12', '12:00:00', 'This appointment is for checking the car and confirming its condition.', '2026-05-03 14:20:00'),
(9, 42, 7, '2026-05-05', '17:30:00', 'I would like to evaluate the car personally before moving forward.', '2026-05-01 10:15:00'),
(10, 12, 7, '2026-05-12', '17:30:00', 'I would like to evaluate the car personally before moving forward.', '2026-05-03 14:20:00'),
(11, 39, 8, '2026-05-05', '10:30:00', 'I want to inspect the interior and performance during the appointment.', '2026-05-01 10:15:00'),
(12, 9, 8, '2026-05-12', '10:30:00', 'I want to inspect the interior and performance during the appointment.', '2026-05-03 14:20:00'),
(13, 6, 9, '2026-05-05', '14:00:00', 'Please confirm the appointment. I am interested in a proper test drive.', '2026-05-01 10:15:00'),
(14, 37, 9, '2026-05-12', '16:00:00', 'Looking forward to testing the car and checking its overall condition.', '2026-05-03 14:20:00'),
(15, 3, 10, '2026-05-05', '17:30:00', 'I would like to inspect the car and take a short test drive.', '2026-05-01 10:15:00'),
(16, 34, 10, '2026-05-12', '09:00:00', 'I want to see the car in person and test the driving feel.', '2026-05-03 14:20:00'),
(17, 31, 11, '2026-05-05', '12:00:00', 'I am interested in this car and would like a scheduled test drive.', '2026-05-01 10:15:00'),
(18, 32, 11, '2026-05-12', '14:00:00', 'Interested in checking the car condition and comfort before deciding.', '2026-05-03 14:20:00'),
(19, 28, 12, '2026-05-05', '16:00:00', 'Please reserve this slot for a viewing and short road test.', '2026-05-01 10:15:00'),
(20, 29, 12, '2026-05-12', '17:30:00', 'This appointment is for checking the car and confirming its condition.', '2026-05-03 14:20:00'),
(21, 25, 13, '2026-05-05', '09:00:00', 'Looking forward to testing the car and checking its overall condition.', '2026-05-01 10:15:00'),
(22, 26, 13, '2026-05-12', '10:30:00', 'Interested in a test drive before making any final offer.', '2026-05-03 14:20:00'),
(23, 23, 14, '2026-05-05', '14:00:00', 'I would like to review the car and discuss the details during the visit.', '2026-05-01 10:15:00'),
(24, 24, 14, '2026-05-12', '16:00:00', 'I want to inspect the interior and performance during the appointment.', '2026-05-03 14:20:00'),
(25, 20, 15, '2026-05-05', '17:30:00', 'Interested in checking the car condition and comfort before deciding.', '2026-05-01 10:15:00'),
(26, 21, 15, '2026-05-12', '09:00:00', 'Please confirm the appointment. I am interested in a proper test drive.', '2026-05-03 14:20:00'),
(27, 17, 16, '2026-05-05', '10:30:00', 'This appointment is for checking the car and confirming its condition.', '2026-05-01 10:15:00'),
(28, 18, 16, '2026-05-12', '12:00:00', 'I would like to inspect the car and take a short test drive.', '2026-05-03 14:20:00'),
(29, 45, 17, '2026-05-05', '16:00:00', 'I would like to evaluate the car personally before moving forward.', '2026-05-01 10:15:00'),
(30, 15, 17, '2026-05-12', '16:00:00', 'I would like to evaluate the car personally before moving forward.', '2026-05-03 14:20:00'),
(31, 42, 18, '2026-05-05', '09:00:00', 'I want to inspect the interior and performance during the appointment.', '2026-05-01 10:15:00'),
(32, 12, 18, '2026-05-12', '09:00:00', 'I want to inspect the interior and performance during the appointment.', '2026-05-03 14:20:00'),
(33, 39, 19, '2026-05-05', '12:00:00', 'Please confirm the appointment. I am interested in a proper test drive.', '2026-05-01 10:15:00'),
(34, 9, 19, '2026-05-12', '12:00:00', 'Please confirm the appointment. I am interested in a proper test drive.', '2026-05-03 14:20:00'),
(35, 6, 20, '2026-05-05', '16:00:00', 'I would like to inspect the car and take a short test drive.', '2026-05-01 10:15:00'),
(36, 37, 20, '2026-05-12', '17:30:00', 'I want to see the car in person and test the driving feel.', '2026-05-03 14:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `dbProj_cars`
--

CREATE TABLE `dbProj_cars` (
  `car_id` int NOT NULL,
  `creator_id` int NOT NULL,
  `title` varchar(150) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `full_description` text NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `car_year` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','removed') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbProj_cars`
--

INSERT INTO `dbProj_cars` (`car_id`, `creator_id`, `title`, `short_description`, `full_description`, `brand`, `model`, `car_year`, `price`, `image`, `status`, `created_at`) VALUES
(2, 3, 'Toyota Camry 2021', 'Reliable midsize sedan with smooth ride and fuel efficiency.', 'A practical and comfortable sedan, the Toyota Camry 2021 offers a refined cabin, strong fuel economy, and a dependable driving experience for daily commuting and family use.', 'Toyota', 'Camry', 2021, 9800.00, 'https://media.drive.com.au/obj/tx_q:50,rs:auto:1920:1080:1/driveau/upload/cms/uploads/h3opzjkcuohuob7n1nix', 'published', '2026-01-05 09:10:00'),
(3, 3, 'Honda Civic 2020', 'Compact sedan known for efficiency and balanced performance.', 'The Honda Civic 2020 is a popular compact car with excellent fuel economy, comfortable seating, and a modern design suitable for city and highway driving.', 'Honda', 'Civic', 2020, 7600.00, 'https://am-s3-bucket-assets.s3.eu-west-2.amazonaws.com/silverstone/prod/lot_images/large/REC14085-1/REC14085-1_1.jpg.webp?dummy=1776137961', 'published', '2026-01-07 11:25:00'),
(4, 3, 'Nissan Altima 2019', 'Spacious sedan with modern technology features.', 'The Nissan Altima 2019 provides a roomy interior, advanced safety features, and a comfortable suspension setup for everyday practicality.', 'Nissan', 'Altima', 2019, 6800.00, 'https://i.insider.com/5c33e10bbd7730235a627a22?width=1200&format=jpeg', 'published', '2026-01-09 14:40:00'),
(5, 3, 'Mazda 6 2021', 'Stylish sedan with premium feel and sharp handling.', 'The Mazda 6 2021 stands out with elegant styling, strong road manners, and an upscale interior that feels more premium than many competitors.', 'Mazda', '6', 2021, 10200.00, 'https://argusmazda.com/wp-content/uploads/2020/09/Mazda6-2021.jpg', 'published', '2026-01-12 10:15:00'),
(6, 3, 'Hyundai Elantra 2022', 'Modern compact sedan with bold design and value.', 'The Hyundai Elantra 2022 offers a fresh design, efficient engine options, and useful technology features at an affordable ownership cost.', 'Hyundai', 'Elantra', 2022, 8400.00, 'https://di-uploads-pod27.dealerinspire.com/hileyhyundaioffortworth/uploads/2021/11/2022-elantra-cn7-0210_16-9.jpg', 'published', '2026-01-14 16:05:00'),
(7, 4, 'Kia K5 2023', 'Sporty midsize sedan with attractive styling.', 'The Kia K5 2023 combines sleek looks, practical interior space, and modern infotainment features, making it a strong midsize sedan option.', 'Kia', 'K5', 2023, 11800.00, 'https://di-uploads-pod38.dealerinspire.com/cowboykia/uploads/2022/09/19137_2023_K5.jpg', 'published', '2026-01-18 12:30:00'),
(8, 4, 'Ford Fusion 2018', 'Comfortable sedan with solid road presence.', 'The Ford Fusion 2018 provides a balanced ride, roomy seating, and a straightforward dashboard layout for practical everyday driving.', 'Ford', 'Fusion', 2018, 5900.00, 'https://storage.googleapis.com/bitmoto/dealers/all/images/vehicles/ford/fusion/fusion3.jpg', 'published', '2026-01-20 09:50:00'),
(9, 4, 'Chevrolet Malibu 2020', 'Family sedan with smooth ride comfort.', 'The Chevrolet Malibu 2020 is a practical family sedan offering comfortable seats, decent trunk space, and a calm highway driving experience.', 'Chevrolet', 'Malibu', 2020, 7000.00, 'https://hips.hearstapps.com/hmg-prod/images/2019-chevrolet-malibu-rs-117-1568289288.jpg?crop=0.830xw:0.678xh;0.0913xw,0.202xh&resize=1200:*\r\n', 'published', '2026-01-22 15:20:00'),
(10, 4, 'Volkswagen Passat 2019', 'European sedan with spacious cabin and comfort.', 'The Volkswagen Passat 2019 offers a mature design, comfortable front and rear seating, and a composed ride suitable for long trips.', 'Volkswagen', 'Passat', 2019, 6600.00, 'https://assets.adac.de/image/upload/v1/Autodatenbank/Fahrzeugbilder/im05764-1-vw-passat.jpg', 'published', '2026-01-25 13:10:00'),
(11, 4, 'Subaru Legacy 2021', 'All-wheel-drive sedan with dependable usability.', 'The Subaru Legacy 2021 is a safe and practical sedan with standard all-wheel drive, good visibility, and confident year-round performance.', 'Subaru', 'Legacy', 2021, 9300.00, 'https://hips.hearstapps.com/hmg-prod/images/2021-subaru-legacy-mmp-1-1598294632.jpg', 'published', '2026-01-28 17:45:00'),
(12, 5, 'Mercedes-Benz C200 2020', 'Luxury compact sedan with refined interior.', 'The Mercedes-Benz C200 2020 provides premium cabin materials, advanced comfort, and a smooth luxury-oriented driving experience.', 'Mercedes-Benz', 'C200', 2020, 15500.00, 'https://cdn05.carsforsale.com/00b754975b80fd585ffce676b3cc7d7a6d/800x600/2020-mercedes-benz-c-class-c-300-4dr-sedan.jpg', 'published', '2026-02-02 08:55:00'),
(13, 5, 'BMW 320i 2019', 'Luxury sedan with sporty handling and premium features.', 'The BMW 320i 2019 blends responsive handling with premium interior appointments, making it a strong entry-luxury sedan choice.', 'BMW', '320i', 2019, 14200.00, 'https://www.thecarexpert.co.uk/wp-content/uploads/2019/04/BMW-3-Series-saloon-2022-facelift-2133x1200-cropped.jpeg', 'published', '2026-02-04 10:35:00'),
(14, 5, 'Audi A4 2021', 'Elegant executive sedan with modern technology.', 'The Audi A4 2021 offers a refined interior, clean styling, advanced infotainment, and a composed ride suited for premium buyers.', 'Audi', 'A4', 2021, 16800.00, 'https://images.lifestyleasia.com/wp-content/uploads/sites/7/2021/02/09014228/2021-Audi-A4-Front-scaled-1.jpg?tr=w-1200,h-900', 'published', '2026-02-06 14:15:00'),
(15, 5, 'Lexus ES 2022', 'Comfort-focused luxury sedan with smooth performance.', 'The Lexus ES 2022 emphasizes comfort, quiet cabin quality, and long-term reliability for buyers wanting relaxed premium travel.', 'Lexus', 'ES', 2022, 18200.00, 'https://autonxt.net/wp-content/uploads/2022/07/2022-Lexus-ES-300-h-F-SPORT14.jpg', 'published', '2026-02-09 11:40:00'),
(16, 5, 'Genesis G70 2023', 'Premium sports sedan with strong value and style.', 'The Genesis G70 2023 combines athletic driving manners, upscale materials, and a standout design in the compact luxury segment.', 'Genesis', 'G70', 2023, 19600.00, 'https://hips.hearstapps.com/hmg-prod/images/2022-genesis-g70-3p3t-awd-133-1629990925.jpg?crop=0.670xw:0.501xh;0.199xw,0.307xh&resize=1200:*', 'published', '2026-02-11 16:25:00'),
(17, 6, 'Tesla Model 3 2022', 'Electric sedan with strong range and tech focus.', 'The Tesla Model 3 2022 is a modern electric sedan known for quick acceleration, minimalistic interior design, and strong charging support.', 'Tesla', 'Model 3', 2022, 21000.00, 'https://media.carsandbids.com/cdn-cgi/image/width=2080,quality=70/39ba75f9b610a05237adc3ca976891cd48f5832c/photos/rMWzqY2a-_x32kNQhPd/edit/vwNiU.jpg?t=173214511280', 'published', '2026-02-13 09:05:00'),
(18, 6, 'Toyota RAV4 2021', 'Popular compact SUV with practicality and efficiency.', 'The Toyota RAV4 2021 offers a spacious cabin, reliable performance, and a versatile design that suits family and daily driving needs.', 'Toyota', 'RAV4', 2021, 11200.00, 'https://clients.contology.com/Client/__Blank-Templates__/Trim-Page-Template/2021/Toyota/RAV4_Hybrid/images/Image11.jpg', 'published', '2026-02-16 12:20:00'),
(19, 6, 'Honda CR-V 2020', 'Comfortable SUV with roomy interior and practicality.', 'The Honda CR-V 2020 is a highly practical compact SUV with generous cargo space, comfortable seating, and smooth road manners.', 'Honda', 'CR-V', 2020, 9800.00, 'https://hips.hearstapps.com/hmg-prod/images/2020-honda-cr-v-hybrid-drive-109-1584417693.jpg', 'published', '2026-02-18 15:55:00'),
(20, 6, 'Mazda CX-5 2022', 'Stylish crossover with premium cabin feel.', 'The Mazda CX-5 2022 stands out for its upscale interior, elegant styling, and sharp handling compared with many mainstream rivals.', 'Mazda', 'CX-5', 2022, 12500.00, 'https://www.cnet.com/a/img/resize/08422a7b2c0d987c971346f8947073ce3cbca848/hub/2022/04/26/c488cccd-9e66-4beb-968d-e856ed8802d1/ogi-2022-mazda-cx-5-turbo-awd-02.jpg?auto=webp&fit=crop&height=900&width=1200', 'published', '2026-02-21 13:35:00'),
(21, 6, 'Hyundai Tucson 2023', 'Modern SUV with bold look and useful features.', 'The Hyundai Tucson 2023 offers distinctive styling, generous tech features, and everyday practicality in the compact SUV segment.', 'Hyundai', 'Tucson', 2023, 12900.00, 'https://dealerimages.dealereprocess.com/image/upload/2878455', 'published', '2026-02-24 10:45:00'),
(22, 7, 'Kia Sportage 2022', 'Feature-rich SUV with comfortable everyday usability.', 'The Kia Sportage 2022 combines modern styling, practical cabin space, and user-friendly technology for daily family use.', 'Kia', 'Sportage', 2022, 11600.00, 'https://hips.hearstapps.com/hmg-prod/images/2022-kia-sportage-mmp-1-1620150507.jpg?crop=0.928xw:0.782xh;0.0561xw,0.146xh&resize=2048:*', 'published', '2026-03-01 09:30:00'),
(23, 7, 'Nissan X-Trail 2021', 'Versatile SUV with family-friendly practicality.', 'The Nissan X-Trail 2021 offers easy driving manners, comfortable seating, and good utility for buyers needing a practical crossover.', 'Nissan', 'X-Trail', 2021, 10100.00, 'https://www.exhaustnotes.com.au/wp-content/uploads/2021/06/2995.jpg', 'published', '2026-03-03 11:15:00'),
(24, 7, 'Ford Escape 2020', 'Compact SUV with smooth ride and efficient engine.', 'The Ford Escape 2020 provides a comfortable ride, easy maneuverability, and good everyday usability for city and suburban drivers.', 'Ford', 'Escape', 2020, 8700.00, 'https://hips.hearstapps.com/hmg-prod/images/ford-escape-hybrid-v-toyota-rav4-hybrid-113-1574394071.jpg?crop=0.444xw:0.408xh;0.103xw,0.442xh&resize=2048:*', 'published', '2026-03-05 14:50:00'),
(25, 7, 'Chevrolet Equinox 2019', 'Practical SUV with good interior space and comfort.', 'The Chevrolet Equinox 2019 is a practical crossover offering decent cargo room, comfortable seats, and a straightforward cabin layout.', 'Chevrolet', 'Equinox', 2019, 7300.00, 'https://www.mcgrathautoblog.com/wp-content/uploads/2019/08/19-equinox-feature.jpg', 'published', '2026-03-08 16:10:00'),
(26, 7, 'Jeep Grand Cherokee 2022', 'Well-known SUV with strong road presence and comfort.', 'The Jeep Grand Cherokee 2022 offers a strong design, upscale interior options, and comfortable cruising ability for daily and long-distance use.', 'Jeep', 'Grand Cherokee', 2022, 16400.00, 'https://hips.hearstapps.com/hmg-prod/images/2022-jeep-grand-cherokee-summit-reserve-4xe-114-1632861119.jpg?crop=0.888xw:0.748xh;0.0369xw,0.252xh&resize=2048:*', 'published', '2026-03-10 10:00:00'),
(27, 8, 'Toyota Corolla 2023', 'Efficient compact sedan with trusted reliability.', 'The Toyota Corolla 2023 is a dependable compact sedan with strong fuel economy, easy controls, and a comfortable ride for daily commuting.', 'Toyota', 'Corolla', 2023, 8900.00, 'https://d3s8goeblmpptu.cloudfront.net/mrp/toyota/2023/corolla/2023-toyota-corolla_landing-2.jpg', 'published', '2026-03-12 12:40:00'),
(28, 8, 'Honda Accord 2022', 'Midsize sedan with spacious cabin and smooth driving.', 'The Honda Accord 2022 is a refined midsize sedan offering generous interior room, excellent road comfort, and modern safety technology.', 'Honda', 'Accord', 2022, 11300.00, 'https://cdn.motor1.com/images/mgl/0e4v8n/s1/2022-honda-accord-sport-exterior.jpg', 'published', '2026-03-15 15:05:00'),
(29, 8, 'Nissan Sentra 2021', 'Compact sedan with stylish shape and comfort.', 'The Nissan Sentra 2021 combines a fresh design, comfortable front seats, and good value for drivers seeking affordable transportation.', 'Nissan', 'Sentra', 2021, 6900.00, 'https://static.overfuel.com/photos/508/229419/image-1.webp', 'published', '2026-03-17 09:20:00'),
(30, 8, 'Hyundai Sonata 2023', 'Stylish sedan with strong feature value.', 'The Hyundai Sonata 2023 offers striking exterior styling, useful tech features, and comfortable road behavior for everyday ownership.', 'Hyundai', 'Sonata', 2023, 11900.00, 'https://i.gaw.to/vehicles/photos/40/33/403308-2023-hyundai-sonata.jpg?1024x640', 'published', '2026-03-19 13:55:00'),
(31, 8, 'Kia Rio 2020', 'Affordable compact car with easy city usability.', 'The Kia Rio 2020 is a budget-friendly compact option with light controls, good efficiency, and low running costs.', 'Kia', 'Rio', 2020, 5400.00, 'https://hips.hearstapps.com/hmg-prod/images/2020-kia-rio-mmp-1-1567615682.jpg?crop=1.00xw:0.881xh;0,0.109xh&resize=2048:*', 'published', '2026-03-22 17:25:00'),
(32, 9, 'BMW X5 2021', 'Luxury SUV with premium cabin and powerful presence.', 'The BMW X5 2021 delivers a premium interior, strong performance, and high-end technology in a practical luxury SUV package.', 'BMW', 'X5', 2021, 22800.00, 'https://cdn.prod.website-files.com/5b4a3b3971d099f78f362505/66cf6c6c8c03f384aafc1d83_2025%20BMW%20X5%20M%20Competition.webp', 'published', '2026-04-01 08:40:00'),
(33, 9, 'Mercedes-Benz GLC 2022', 'Upscale compact SUV with refined comfort.', 'The Mercedes-Benz GLC 2022 offers premium materials, smooth performance, and a sophisticated cabin for luxury SUV buyers.', 'Mercedes-Benz', 'GLC', 2022, 21400.00, 'https://parkers-images.bauersecure.com/wp-images/176724/d663237.jpg', 'published', '2026-04-03 11:10:00'),
(34, 9, 'Audi Q5 2021', 'Refined premium SUV with clean design and comfort.', 'The Audi Q5 2021 combines elegant styling, advanced cabin technology, and strong comfort for premium crossover buyers.', 'Audi', 'Q5', 2021, 20500.00, 'https://hips.hearstapps.com/hmg-prod/images/2021-audi-q5-mmp-1-1616682622.jpg?crop=1.00xw:0.748xh;0,0.156xh&resize=1200:*', 'published', '2026-04-05 14:25:00'),
(35, 9, 'Lexus RX 2023', 'Luxury SUV focused on comfort and reliability.', 'The Lexus RX 2023 emphasizes refinement, a quiet cabin, and long-term reliability in the midsize luxury SUV class.', 'Lexus', 'RX', 2023, 23900.00, 'https://hips.hearstapps.com/hmg-prod/images/2023-lexus-rx-350-premium-nightfall-107-660af2a24f6f0.jpg?crop=0.694xw:0.587xh;0.244xw,0.293xh&resize=2048:*', 'published', '2026-04-07 16:45:00'),
(36, 9, 'Range Rover Evoque 2020', 'Luxury compact SUV with iconic styling.', 'The Range Rover Evoque 2020 offers distinctive design, premium cabin touches, and an upscale feel in a compact luxury SUV.', 'Land Rover', 'Range Rover Evoque', 2020, 18900.00, 'https://www.cnet.com/a/img/resize/681c737786fef67f59b190c720c9e1fa99854e16/hub/2019/03/31/745af4ff-c268-405c-836e-6206fe65c929/2020-land-rover-evoque-7.jpg?auto=webp&precrop=3234,2157,x2238,y1285&width=1200', 'published', '2026-04-09 10:35:00'),
(37, 3, 'Toyota Land Cruiser 2023', 'Large SUV famous for comfort, status, and durability.', 'The Toyota Land Cruiser 2023 is a full-size SUV known for strong road presence, premium comfort, and excellent long-term durability.', 'Toyota', 'Land Cruiser', 2023, 32500.00, 'https://espaillatmotors.com/website/wp-content/uploads/2025/01/16a550ae-db7a-4959-b9b4-91265109e33d.jpg', 'published', '2026-04-11 12:15:00'),
(38, 4, 'Porsche Cayenne 2022', 'Performance luxury SUV with premium finish.', 'The Porsche Cayenne 2022 blends strong performance, luxurious interior quality, and a sporty character in a premium SUV format.', 'Porsche', 'Cayenne', 2022, 29800.00, 'https://images.pistonheads.com/nimg/45709/mceu_13307544821653066086965.jpg', 'published', '2026-04-13 15:30:00'),
(39, 5, 'Toyota Hilux 2022', 'Famous pickup known for durability and utility.', 'The Toyota Hilux 2022 is a dependable pickup offering strong durability, practical cargo ability, and broad popularity in many markets.', 'Toyota', 'Hilux', 2022, 15400.00, 'https://images.ctfassets.net/3xid768u5joa/3YNI1Suu9fLPP5dDUy02qg/e8e05c0dad2b5c154369410475504a38/hilux-front-view.jpeg', 'published', '2026-04-15 09:45:00'),
(40, 6, 'Ford F-150 2021', 'Popular full-size pickup with strong versatility.', 'The Ford F-150 2021 is one of the best-known pickups, offering strong capability, cabin comfort, and broad everyday usefulness.', 'Ford', 'F-150', 2021, 17600.00, 'https://a57.foxnews.com/static.foxnews.com/foxnews.com/content/uploads/2020/06/1200/675/f1504.jpg?ve=1&tl=1', 'published', '2026-04-17 13:20:00'),
(41, 7, 'Chevrolet Tahoe 2021', 'Full-size SUV with space, comfort, and road presence.', 'The Chevrolet Tahoe 2021 is a large SUV that offers generous passenger room, strong highway comfort, and practical family utility.', 'Chevrolet', 'Tahoe', 2021, 21200.00, 'https://cdn.jdpower.com/JDPA_2021%20Chevrolet%20Tahoe%20Z71%20Shadow%20Gray%20Front%20View.jpg', 'published', '2026-04-19 17:10:00'),
(42, 8, 'Mitsubishi Pajero 2020', 'Well-known SUV with strong reputation and comfort.', 'The Mitsubishi Pajero 2020 is a recognizable SUV with practical space, comfortable seating, and durable everyday usability.', 'Mitsubishi', 'Pajero', 2020, 13600.00, 'https://i0.wp.com/practicalmotoring.com.au/wp-content/uploads/2019/07/image177154_b.jpg?fit=1417%2C944&ssl=1', 'published', '2026-04-20 08:55:00'),
(43, 9, 'Toyota Prius 2021', 'Efficient hybrid hatchback for economical driving.', 'The Toyota Prius 2021 is a famous hybrid known for excellent fuel efficiency, practical cabin design, and low running costs.', 'Toyota', 'Prius', 2021, 9100.00, 'https://www.sansoneauto.com/static/dealer-19645/Hyundai/2021-toyota-prius-prime-driving-front-3qtr.jpg', 'published', '2026-04-20 10:25:00'),
(44, 3, 'Volkswagen Golf GTI 2020', 'Sporty hatchback with practical everyday appeal.', 'The Volkswagen Golf GTI 2020 combines sharp handling, hatchback practicality, and strong popularity among driving enthusiasts.', 'Volkswagen', 'Golf GTI', 2020, 12700.00, 'https://hips.hearstapps.com/hmg-prod/images/2020-volkswagen-golf-gti-mmp-1-1565810908.jpg?crop=0.820xw:0.690xh;0.0894xw,0.204xh&resize=1200:*', 'published', '2026-04-20 12:40:00'),
(45, 4, 'Subaru Outback 2022', 'Adventure-ready wagon with comfort and usability.', 'The Subaru Outback 2022 offers wagon practicality, standard all-wheel drive, and a comfortable ride suited for varied daily needs.', 'Subaru', 'Outback', 2022, 13200.00, 'https://hips.hearstapps.com/hmg-prod/images/2022-subaru-outback-wilderness-107-1617043965.jpg?crop=0.707xw:0.596xh;0.218xw,0.101xh&resize=2048:*', 'published', '2026-04-20 14:15:00'),
(46, 3, 'Peugeot 3008 2023', 'Modern crossover with European styling and practicality.', 'The Peugeot 3008 2023 offers bold exterior design, a distinctive cabin layout, and practical crossover space for daily driving.', 'Peugeot', '3008', 2023, 12100.00, 'https://newautofzco.com/wp-content/uploads/2024/05/PEUGEOT-3008-GT-N-PE-GT-1.6-23-2023-Black-Red-01-876x535.jpg', 'published', '2026-04-20 16:05:00'),
(47, 8, 'Skoda Superb 2021', 'Large sedan with comfort, space, and value.', 'The Skoda Superb 2021 offers a spacious interior, comfortable ride, and practical executive-sedan value for long-distance use.', 'Skoda', 'Superb', 2021, 9700.00, 'https://media.drive.com.au/obj/tx_rs:auto:1920:1080:1/driveau/upload/cms/uploads/j7li05ffsvbljnymghkp', 'draft', '2026-04-21 09:20:00'),
(48, 9, 'Volvo XC60 2022', 'Premium SUV with safety focus and elegant design.', 'The Volvo XC60 2022 combines premium comfort, advanced safety reputation, and understated Scandinavian styling in a midsize SUV.', 'Volvo', 'XC60', 2022, 20800.00, 'https://smartcdn.gprod.postmedia.digital/driving/wp-content/uploads/2021/12/Volvo-XC60-2022-10.jpg', 'draft', '2026-04-21 11:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `dbProj_comments`
--

CREATE TABLE `dbProj_comments` (
  `comment_id` int NOT NULL,
  `car_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbProj_comments`
--

INSERT INTO `dbProj_comments` (`comment_id`, `car_id`, `user_id`, `comment_text`, `created_at`) VALUES
(10, 2, 17, 'A solid listing with useful information.', '2026-01-06 15:10:00'),
(11, 2, 18, 'One of the better listings I have seen so far.', '2026-01-07 17:10:00'),
(12, 2, 10, 'Good option for someone looking for reliability.', '2026-01-08 11:10:00'),
(13, 2, 19, 'Clean post and the car seems like a good buy.', '2026-01-09 09:10:00'),
(14, 2, 11, 'A solid listing with useful information.', '2026-01-10 13:10:00'),
(15, 3, 17, 'Very clean car and the details look great.', '2026-01-08 18:25:00'),
(16, 3, 18, 'The price seems fair compared to similar cars.', '2026-01-09 20:25:00'),
(17, 3, 10, 'The specs and condition make this car attractive.', '2026-01-10 14:25:00'),
(18, 3, 19, 'This one has a strong value for the model year.', '2026-01-11 12:25:00'),
(19, 3, 11, 'Very clean car and the details look great.', '2026-01-12 16:25:00'),
(20, 3, 20, 'The interior and features sound impressive.', '2026-01-13 14:25:00'),
(21, 4, 16, 'I like the design and overall presentation of this car.', '2026-01-10 20:40:00'),
(22, 4, 17, 'The description is clear and helpful.', '2026-01-11 22:40:00'),
(23, 4, 18, 'This car looks well maintained and worth checking.', '2026-01-12 14:40:00'),
(24, 5, 16, 'A solid listing with useful information.', '2026-01-13 17:15:00'),
(25, 5, 17, 'One of the better listings I have seen so far.', '2026-01-14 19:15:00'),
(26, 5, 18, 'Clean post and the car seems like a good buy.', '2026-01-15 11:15:00'),
(27, 5, 10, 'A solid listing with useful information.', '2026-01-16 15:15:00'),
(28, 6, 15, 'The specs and condition make this car attractive.', '2026-01-15 22:05:00'),
(29, 6, 16, 'Very clean car and the details look great.', '2026-01-17 00:05:00'),
(30, 6, 17, 'The price seems fair compared to similar cars.', '2026-01-17 16:05:00'),
(31, 6, 18, 'This one has a strong value for the model year.', '2026-01-18 18:05:00'),
(32, 6, 10, 'Very clean car and the details look great.', '2026-01-19 22:05:00'),
(33, 7, 15, 'I like the design and overall presentation of this car.', '2026-01-19 19:30:00'),
(34, 7, 16, 'The description is clear and helpful.', '2026-01-20 21:30:00'),
(35, 7, 17, 'This car looks well maintained and worth checking.', '2026-01-21 13:30:00'),
(36, 7, 18, 'Looks like a smooth and comfortable car for everyday use.', '2026-01-22 15:30:00'),
(37, 7, 10, 'The description is clear and helpful.', '2026-01-23 19:30:00'),
(38, 7, 19, 'This would be a nice option for city and highway driving.', '2026-01-24 17:30:00'),
(39, 8, 14, 'Good option for someone looking for reliability.', '2026-01-21 15:50:00'),
(40, 8, 15, 'A solid listing with useful information.', '2026-01-22 17:50:00'),
(41, 8, 16, 'One of the better listings I have seen so far.', '2026-01-23 09:50:00'),
(42, 9, 14, 'The specs and condition make this car attractive.', '2026-01-23 22:20:00'),
(43, 9, 15, 'Very clean car and the details look great.', '2026-01-25 00:20:00'),
(44, 9, 16, 'The price seems fair compared to similar cars.', '2026-01-25 16:20:00'),
(45, 9, 17, 'This one has a strong value for the model year.', '2026-01-26 18:20:00'),
(46, 10, 14, 'I like the design and overall presentation of this car.', '2026-01-26 21:10:00'),
(47, 10, 15, 'The description is clear and helpful.', '2026-01-27 13:10:00'),
(48, 10, 16, 'This car looks well maintained and worth checking.', '2026-01-28 15:10:00'),
(49, 10, 17, 'Looks like a smooth and comfortable car for everyday use.', '2026-01-29 17:10:00'),
(50, 10, 18, 'This would be a nice option for city and highway driving.', '2026-01-30 19:10:00'),
(51, 11, 13, 'Good option for someone looking for reliability.', '2026-01-30 00:45:00'),
(52, 11, 14, 'A solid listing with useful information.', '2026-01-31 02:45:00'),
(53, 11, 15, 'One of the better listings I have seen so far.', '2026-01-31 18:45:00'),
(54, 11, 16, 'Clean post and the car seems like a good buy.', '2026-02-01 20:45:00'),
(55, 11, 17, 'Nice listing, the condition looks really good.', '2026-02-02 22:45:00'),
(56, 11, 18, 'Looks comfortable and suitable for family use.', '2026-02-04 00:45:00'),
(57, 12, 13, 'The specs and condition make this car attractive.', '2026-02-03 16:55:00'),
(58, 12, 14, 'Very clean car and the details look great.', '2026-02-04 08:55:00'),
(59, 12, 15, 'The price seems fair compared to similar cars.', '2026-02-05 10:55:00'),
(60, 13, 12, 'This looks like a practical choice for daily driving.', '2026-02-05 17:35:00'),
(61, 13, 13, 'I like the design and overall presentation of this car.', '2026-02-06 19:35:00'),
(62, 13, 14, 'The description is clear and helpful.', '2026-02-07 11:35:00'),
(63, 13, 15, 'This car looks well maintained and worth checking.', '2026-02-08 13:35:00'),
(64, 14, 12, 'Good option for someone looking for reliability.', '2026-02-07 22:15:00'),
(65, 14, 13, 'A solid listing with useful information.', '2026-02-08 14:15:00'),
(66, 14, 14, 'One of the better listings I have seen so far.', '2026-02-09 16:15:00'),
(67, 14, 15, 'Clean post and the car seems like a good buy.', '2026-02-10 18:15:00'),
(68, 14, 16, 'Nice listing, the condition looks really good.', '2026-02-11 20:15:00'),
(69, 15, 11, 'I like this model, especially at this price point.', '2026-02-10 18:40:00'),
(70, 15, 20, 'The price seems fair compared to similar cars.', '2026-02-11 16:40:00'),
(71, 15, 12, 'The specs and condition make this car attractive.', '2026-02-12 20:40:00'),
(72, 15, 13, 'Very clean car and the details look great.', '2026-02-13 12:40:00'),
(73, 15, 14, 'The price seems fair compared to similar cars.', '2026-02-14 14:40:00'),
(74, 15, 15, 'This one has a strong value for the model year.', '2026-02-15 16:40:00'),
(75, 16, 11, 'This looks like a practical choice for daily driving.', '2026-02-13 00:25:00'),
(76, 16, 20, 'This car looks well maintained and worth checking.', '2026-02-13 22:25:00'),
(77, 16, 12, 'I like the design and overall presentation of this car.', '2026-02-14 16:25:00'),
(78, 17, 10, 'Looks comfortable and suitable for family use.', '2026-02-14 16:05:00'),
(79, 17, 19, 'One of the better listings I have seen so far.', '2026-02-15 14:05:00'),
(80, 17, 11, 'Good option for someone looking for reliability.', '2026-02-16 18:05:00'),
(81, 17, 20, 'Clean post and the car seems like a good buy.', '2026-02-17 16:05:00'),
(82, 18, 10, 'I like this model, especially at this price point.', '2026-02-17 20:20:00'),
(83, 18, 19, 'The price seems fair compared to similar cars.', '2026-02-18 18:20:00'),
(84, 18, 11, 'The specs and condition make this car attractive.', '2026-02-19 12:20:00'),
(85, 18, 20, 'This one has a strong value for the model year.', '2026-02-20 20:20:00'),
(86, 18, 12, 'Very clean car and the details look great.', '2026-02-21 14:20:00'),
(87, 19, 18, 'The description is clear and helpful.', '2026-02-19 20:55:00'),
(88, 19, 10, 'This looks like a practical choice for daily driving.', '2026-02-21 00:55:00'),
(89, 19, 19, 'This car looks well maintained and worth checking.', '2026-02-21 22:55:00'),
(90, 19, 11, 'I like the design and overall presentation of this car.', '2026-02-22 16:55:00'),
(91, 19, 20, 'Looks like a smooth and comfortable car for everyday use.', '2026-02-24 00:55:00'),
(92, 19, 12, 'The description is clear and helpful.', '2026-02-24 18:55:00'),
(93, 20, 18, 'One of the better listings I have seen so far.', '2026-02-22 19:35:00'),
(94, 20, 10, 'Good option for someone looking for reliability.', '2026-02-23 13:35:00'),
(95, 20, 19, 'Clean post and the car seems like a good buy.', '2026-02-24 21:35:00'),
(96, 21, 17, 'Very clean car and the details look great.', '2026-02-25 15:45:00'),
(97, 21, 18, 'The price seems fair compared to similar cars.', '2026-02-26 17:45:00'),
(98, 21, 10, 'The specs and condition make this car attractive.', '2026-02-27 11:45:00'),
(99, 21, 19, 'This one has a strong value for the model year.', '2026-02-28 19:45:00'),
(100, 22, 17, 'The description is clear and helpful.', '2026-03-02 15:30:00'),
(101, 22, 18, 'This car looks well maintained and worth checking.', '2026-03-03 17:30:00'),
(102, 22, 10, 'I like the design and overall presentation of this car.', '2026-03-04 11:30:00'),
(103, 22, 19, 'Looks like a smooth and comfortable car for everyday use.', '2026-03-05 09:30:00'),
(104, 22, 11, 'The description is clear and helpful.', '2026-03-06 13:30:00'),
(105, 23, 16, 'A solid listing with useful information.', '2026-03-04 16:15:00'),
(106, 23, 17, 'One of the better listings I have seen so far.', '2026-03-05 18:15:00'),
(107, 23, 18, 'Clean post and the car seems like a good buy.', '2026-03-06 20:15:00'),
(108, 23, 10, 'A solid listing with useful information.', '2026-03-07 14:15:00'),
(109, 23, 19, 'Nice listing, the condition looks really good.', '2026-03-08 12:15:00'),
(110, 23, 11, 'One of the better listings I have seen so far.', '2026-03-09 16:15:00'),
(111, 24, 16, 'Very clean car and the details look great.', '2026-03-06 20:50:00'),
(112, 24, 17, 'The price seems fair compared to similar cars.', '2026-03-07 22:50:00'),
(113, 24, 18, 'This one has a strong value for the model year.', '2026-03-08 14:50:00'),
(114, 25, 16, 'The description is clear and helpful.', '2026-03-09 23:10:00'),
(115, 25, 17, 'This car looks well maintained and worth checking.', '2026-03-11 01:10:00'),
(116, 25, 18, 'Looks like a smooth and comfortable car for everyday use.', '2026-03-11 17:10:00'),
(117, 25, 10, 'The description is clear and helpful.', '2026-03-12 21:10:00'),
(118, 26, 15, 'A solid listing with useful information.', '2026-03-11 16:00:00'),
(119, 26, 16, 'One of the better listings I have seen so far.', '2026-03-12 18:00:00'),
(120, 26, 17, 'Clean post and the car seems like a good buy.', '2026-03-13 10:00:00'),
(121, 26, 18, 'Nice listing, the condition looks really good.', '2026-03-14 12:00:00'),
(122, 26, 10, 'One of the better listings I have seen so far.', '2026-03-15 16:00:00'),
(123, 27, 15, 'Very clean car and the details look great.', '2026-03-13 19:40:00'),
(124, 27, 16, 'The price seems fair compared to similar cars.', '2026-03-14 21:40:00'),
(125, 27, 17, 'This one has a strong value for the model year.', '2026-03-15 13:40:00'),
(126, 27, 18, 'The interior and features sound impressive.', '2026-03-16 15:40:00'),
(127, 27, 10, 'The price seems fair compared to similar cars.', '2026-03-17 19:40:00'),
(128, 27, 19, 'I like this model, especially at this price point.', '2026-03-18 17:40:00'),
(129, 28, 14, 'I like the design and overall presentation of this car.', '2026-03-16 21:05:00'),
(130, 28, 15, 'The description is clear and helpful.', '2026-03-17 23:05:00'),
(131, 28, 16, 'This car looks well maintained and worth checking.', '2026-03-18 15:05:00'),
(132, 29, 14, 'A solid listing with useful information.', '2026-03-18 16:20:00'),
(133, 29, 15, 'One of the better listings I have seen so far.', '2026-03-19 18:20:00'),
(134, 29, 16, 'Clean post and the car seems like a good buy.', '2026-03-20 10:20:00'),
(135, 29, 17, 'Nice listing, the condition looks really good.', '2026-03-21 12:20:00'),
(136, 30, 13, 'The specs and condition make this car attractive.', '2026-03-20 19:55:00'),
(137, 30, 14, 'Very clean car and the details look great.', '2026-03-21 21:55:00'),
(138, 30, 15, 'The price seems fair compared to similar cars.', '2026-03-22 13:55:00'),
(139, 30, 16, 'This one has a strong value for the model year.', '2026-03-23 15:55:00'),
(140, 30, 17, 'The interior and features sound impressive.', '2026-03-24 17:55:00'),
(141, 31, 13, 'I like the design and overall presentation of this car.', '2026-03-24 00:25:00'),
(142, 31, 14, 'The description is clear and helpful.', '2026-03-25 02:25:00'),
(143, 31, 15, 'This car looks well maintained and worth checking.', '2026-03-25 18:25:00'),
(144, 31, 16, 'Looks like a smooth and comfortable car for everyday use.', '2026-03-26 20:25:00'),
(145, 31, 17, 'This would be a nice option for city and highway driving.', '2026-03-27 22:25:00'),
(146, 31, 18, 'This looks like a practical choice for daily driving.', '2026-03-29 00:25:00'),
(147, 32, 12, 'Good option for someone looking for reliability.', '2026-04-02 14:40:00'),
(148, 32, 13, 'A solid listing with useful information.', '2026-04-03 16:40:00'),
(149, 32, 14, 'One of the better listings I have seen so far.', '2026-04-04 08:40:00'),
(150, 33, 12, 'The specs and condition make this car attractive.', '2026-04-04 18:10:00'),
(151, 33, 13, 'Very clean car and the details look great.', '2026-04-05 20:10:00'),
(152, 33, 14, 'The price seems fair compared to similar cars.', '2026-04-06 12:10:00'),
(153, 33, 15, 'This one has a strong value for the model year.', '2026-04-07 14:10:00'),
(154, 34, 11, 'This looks like a practical choice for daily driving.', '2026-04-06 20:25:00'),
(155, 34, 20, 'This car looks well maintained and worth checking.', '2026-04-07 18:25:00'),
(156, 34, 12, 'I like the design and overall presentation of this car.', '2026-04-08 22:25:00'),
(157, 34, 13, 'The description is clear and helpful.', '2026-04-09 14:25:00'),
(158, 34, 14, 'This car looks well maintained and worth checking.', '2026-04-10 16:25:00'),
(159, 35, 11, 'Good option for someone looking for reliability.', '2026-04-08 23:45:00'),
(160, 35, 20, 'Clean post and the car seems like a good buy.', '2026-04-09 21:45:00'),
(161, 35, 12, 'A solid listing with useful information.', '2026-04-11 01:45:00'),
(162, 35, 13, 'One of the better listings I have seen so far.', '2026-04-11 17:45:00'),
(163, 35, 14, 'Clean post and the car seems like a good buy.', '2026-04-12 19:45:00'),
(164, 35, 15, 'Nice listing, the condition looks really good.', '2026-04-13 21:45:00'),
(165, 36, 19, 'The price seems fair compared to similar cars.', '2026-04-10 14:35:00'),
(166, 36, 11, 'The specs and condition make this car attractive.', '2026-04-11 18:35:00'),
(167, 36, 20, 'This one has a strong value for the model year.', '2026-04-12 16:35:00'),
(168, 37, 10, 'This looks like a practical choice for daily driving.', '2026-04-12 19:15:00'),
(169, 37, 19, 'This car looks well maintained and worth checking.', '2026-04-13 17:15:00'),
(170, 37, 11, 'I like the design and overall presentation of this car.', '2026-04-14 21:15:00'),
(171, 37, 20, 'Looks like a smooth and comfortable car for everyday use.', '2026-04-15 19:15:00'),
(172, 38, 18, 'One of the better listings I have seen so far.', '2026-04-14 19:30:00'),
(173, 38, 10, 'Good option for someone looking for reliability.', '2026-04-15 23:30:00'),
(174, 38, 19, 'Clean post and the car seems like a good buy.', '2026-04-16 21:30:00'),
(175, 38, 11, 'A solid listing with useful information.', '2026-04-17 15:30:00'),
(176, 38, 20, 'Nice listing, the condition looks really good.', '2026-04-18 23:30:00'),
(177, 39, 18, 'The price seems fair compared to similar cars.', '2026-04-16 14:45:00'),
(178, 39, 10, 'The specs and condition make this car attractive.', '2026-04-17 18:45:00'),
(179, 39, 19, 'This one has a strong value for the model year.', '2026-04-18 16:45:00'),
(180, 39, 11, 'Very clean car and the details look great.', '2026-04-19 10:45:00'),
(181, 39, 20, 'The interior and features sound impressive.', '2026-04-20 18:45:00'),
(182, 39, 12, 'The price seems fair compared to similar cars.', '2026-04-21 12:45:00'),
(183, 40, 18, 'This car looks well maintained and worth checking.', '2026-04-18 19:20:00'),
(184, 40, 10, 'I like the design and overall presentation of this car.', '2026-04-19 13:20:00'),
(185, 40, 19, 'Looks like a smooth and comfortable car for everyday use.', '2026-04-20 21:20:00'),
(186, 41, 17, 'One of the better listings I have seen so far.', '2026-04-20 22:10:00'),
(187, 41, 18, 'Clean post and the car seems like a good buy.', '2026-04-22 00:10:00'),
(188, 41, 10, 'A solid listing with useful information.', '2026-04-22 18:10:00'),
(189, 41, 19, 'Nice listing, the condition looks really good.', '2026-04-24 02:10:00'),
(190, 42, 17, 'The price seems fair compared to similar cars.', '2026-04-21 14:55:00'),
(191, 42, 18, 'This one has a strong value for the model year.', '2026-04-22 16:55:00'),
(192, 42, 10, 'Very clean car and the details look great.', '2026-04-23 10:55:00'),
(193, 42, 19, 'The interior and features sound impressive.', '2026-04-24 08:55:00'),
(194, 42, 11, 'The price seems fair compared to similar cars.', '2026-04-25 12:55:00'),
(195, 43, 16, 'The description is clear and helpful.', '2026-04-21 15:25:00'),
(196, 43, 17, 'This car looks well maintained and worth checking.', '2026-04-22 17:25:00'),
(197, 43, 18, 'Looks like a smooth and comfortable car for everyday use.', '2026-04-23 19:25:00'),
(198, 43, 10, 'The description is clear and helpful.', '2026-04-24 13:25:00'),
(199, 43, 19, 'This would be a nice option for city and highway driving.', '2026-04-25 11:25:00'),
(200, 43, 11, 'This car looks well maintained and worth checking.', '2026-04-26 15:25:00'),
(201, 44, 16, 'One of the better listings I have seen so far.', '2026-04-21 18:40:00'),
(202, 44, 17, 'Clean post and the car seems like a good buy.', '2026-04-22 20:40:00'),
(203, 44, 18, 'Nice listing, the condition looks really good.', '2026-04-23 12:40:00'),
(204, 45, 15, 'Very clean car and the details look great.', '2026-04-21 19:15:00'),
(205, 45, 16, 'The price seems fair compared to similar cars.', '2026-04-22 21:15:00'),
(206, 45, 17, 'This one has a strong value for the model year.', '2026-04-23 23:15:00'),
(207, 45, 18, 'The interior and features sound impressive.', '2026-04-24 15:15:00'),
(208, 46, 15, 'The description is clear and helpful.', '2026-04-21 22:05:00'),
(209, 46, 16, 'This car looks well maintained and worth checking.', '2026-04-23 00:05:00'),
(210, 46, 17, 'Looks like a smooth and comfortable car for everyday use.', '2026-04-23 16:05:00'),
(211, 46, 18, 'This would be a nice option for city and highway driving.', '2026-04-24 18:05:00'),
(212, 46, 10, 'This car looks well maintained and worth checking.', '2026-04-25 22:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `dbProj_offers`
--

CREATE TABLE `dbProj_offers` (
  `offer_id` int NOT NULL,
  `car_id` int NOT NULL,
  `user_id` int NOT NULL,
  `offer_amount` decimal(10,2) NOT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbProj_offers`
--

INSERT INTO `dbProj_offers` (`offer_id`, `car_id`, `user_id`, `offer_amount`, `message`, `created_at`) VALUES
(2, 2, 11, 8820.00, 'The car looks great and I would like to negotiate at this amount.', '2026-01-10 17:10:00'),
(3, 2, 17, 9212.00, 'I am interested in this car and would like to make a serious offer.', '2026-01-11 17:10:00'),
(4, 2, 12, 9408.00, 'I believe this is a fair offer based on the model and condition.', '2026-01-12 11:10:00'),
(5, 2, 18, 8036.00, 'I like the condition and features. Let me know if this works for you.', '2026-01-13 11:10:00'),
(6, 3, 11, 6232.00, 'I would be happy to inspect the car if the offer is suitable.', '2026-01-12 11:25:00'),
(7, 3, 17, 6688.00, 'I would like to move forward quickly if you accept this offer.', '2026-01-13 11:25:00'),
(8, 4, 10, 5984.00, 'I am interested in this car and would like to make a serious offer.', '2026-01-14 21:40:00'),
(9, 4, 16, 6256.00, 'The listing is impressive, and I would like to submit this offer.', '2026-01-15 21:40:00'),
(10, 4, 11, 6392.00, 'I like the condition and features. Let me know if this works for you.', '2026-01-16 15:40:00'),
(11, 5, 10, 9996.00, 'I would like to move forward quickly if you accept this offer.', '2026-01-17 18:15:00'),
(12, 5, 16, 8670.00, 'I am ready to proceed if the offer is acceptable.', '2026-01-18 18:15:00'),
(13, 5, 11, 8976.00, 'I am interested and available to discuss the next steps.', '2026-01-19 12:15:00'),
(14, 5, 17, 9384.00, 'Please review my offer. I am genuinely interested.', '2026-01-20 12:15:00'),
(15, 6, 15, 7560.00, 'This car matches what I am looking for. Kindly consider my offer.', '2026-01-19 22:05:00'),
(16, 6, 10, 7728.00, 'Please consider this amount. I think it is fair for both sides.', '2026-01-20 16:05:00'),
(17, 7, 15, 9676.00, 'I am interested in purchasing this car and would like you to review my offer.', '2026-01-23 19:30:00'),
(18, 7, 10, 10030.00, 'Please review my offer. I am genuinely interested.', '2026-01-24 13:30:00'),
(19, 7, 16, 10620.00, 'This looks like a good car. Please consider my offer.', '2026-01-25 13:30:00'),
(20, 8, 14, 5192.00, 'The car looks great and I would like to negotiate at this amount.', '2026-01-25 14:50:00'),
(21, 8, 20, 5428.00, 'I am interested in this car and would like to make a serious offer.', '2026-01-26 14:50:00'),
(22, 8, 15, 5546.00, 'I believe this is a fair offer based on the model and condition.', '2026-01-27 17:50:00'),
(23, 8, 10, 5664.00, 'The listing is impressive, and I would like to submit this offer.', '2026-01-28 11:50:00'),
(24, 9, 19, 6720.00, 'Please review my offer. I am genuinely interested.', '2026-01-27 18:20:00'),
(25, 9, 14, 6860.00, 'I would be happy to inspect the car if the offer is suitable.', '2026-01-28 21:20:00'),
(26, 10, 13, 5610.00, 'I am interested in this car and would like to make a serious offer.', '2026-01-30 17:10:00'),
(27, 10, 19, 5940.00, 'The listing is impressive, and I would like to submit this offer.', '2026-01-31 17:10:00'),
(28, 10, 14, 6072.00, 'I like the condition and features. Let me know if this works for you.', '2026-02-01 20:10:00'),
(29, 11, 12, 8370.00, 'Please review my offer. I am genuinely interested.', '2026-02-02 19:45:00'),
(30, 11, 18, 8742.00, 'This looks like a good car. Please consider my offer.', '2026-02-03 19:45:00'),
(31, 11, 13, 8928.00, 'I would like to move forward quickly if you accept this offer.', '2026-02-04 22:45:00'),
(32, 11, 19, 7626.00, 'I am ready to proceed if the offer is acceptable.', '2026-02-05 22:45:00'),
(33, 12, 12, 12710.00, 'The listing is impressive, and I would like to submit this offer.', '2026-02-07 11:55:00'),
(34, 12, 18, 13640.00, 'This car matches what I am looking for. Kindly consider my offer.', '2026-02-08 11:55:00'),
(35, 13, 11, 12496.00, 'This looks like a good car. Please consider my offer.', '2026-02-09 11:35:00'),
(36, 13, 17, 13064.00, 'I am serious about buying and would appreciate your consideration.', '2026-02-10 11:35:00'),
(37, 13, 12, 13348.00, 'I am ready to proceed if the offer is acceptable.', '2026-02-11 14:35:00'),
(38, 14, 11, 16464.00, 'This car matches what I am looking for. Kindly consider my offer.', '2026-02-11 16:15:00'),
(39, 14, 17, 14280.00, 'The car looks great and I would like to negotiate at this amount.', '2026-02-12 16:15:00'),
(40, 14, 12, 14784.00, 'This seems like a strong option for me. Please let me know your response.', '2026-02-13 19:15:00'),
(41, 14, 18, 15456.00, 'I believe this is a fair offer based on the model and condition.', '2026-02-14 19:15:00'),
(42, 15, 10, 15470.00, 'I am serious about buying and would appreciate your consideration.', '2026-02-14 11:40:00'),
(43, 15, 16, 16380.00, 'I am interested and available to discuss the next steps.', '2026-02-15 11:40:00'),
(44, 16, 10, 18816.00, 'The car looks great and I would like to negotiate at this amount.', '2026-02-16 17:25:00'),
(45, 16, 16, 16072.00, 'I am interested in this car and would like to make a serious offer.', '2026-02-17 17:25:00'),
(46, 16, 11, 16660.00, 'I believe this is a fair offer based on the model and condition.', '2026-02-18 20:25:00'),
(47, 17, 15, 18480.00, 'Please review my offer. I am genuinely interested.', '2026-02-18 17:05:00'),
(48, 17, 10, 18900.00, 'I would be happy to inspect the car if the offer is suitable.', '2026-02-19 11:05:00'),
(49, 17, 16, 19740.00, 'I would like to move forward quickly if you accept this offer.', '2026-02-20 11:05:00'),
(50, 17, 11, 20160.00, 'I am serious about buying and would appreciate your consideration.', '2026-02-21 14:05:00'),
(51, 18, 15, 10976.00, 'The listing is impressive, and I would like to submit this offer.', '2026-02-21 12:20:00'),
(52, 18, 10, 9184.00, 'I like the condition and features. Let me know if this works for you.', '2026-02-22 15:20:00'),
(53, 19, 14, 8330.00, 'This looks like a good car. Please consider my offer.', '2026-02-23 22:55:00'),
(54, 19, 20, 8820.00, 'I am serious about buying and would appreciate your consideration.', '2026-02-24 22:55:00'),
(55, 19, 15, 9016.00, 'I am ready to proceed if the offer is acceptable.', '2026-02-25 16:55:00'),
(56, 20, 14, 12000.00, 'This car matches what I am looking for. Kindly consider my offer.', '2026-02-26 21:35:00'),
(57, 20, 20, 10250.00, 'The car looks great and I would like to negotiate at this amount.', '2026-02-27 21:35:00'),
(58, 20, 15, 10625.00, 'This seems like a strong option for me. Please let me know your response.', '2026-02-28 15:35:00'),
(59, 20, 10, 11000.00, 'I am interested in this car and would like to make a serious offer.', '2026-03-01 18:35:00'),
(60, 21, 13, 10578.00, 'I am serious about buying and would appreciate your consideration.', '2026-03-01 16:45:00'),
(61, 21, 19, 11352.00, 'I am interested and available to discuss the next steps.', '2026-03-02 16:45:00'),
(62, 22, 13, 10904.00, 'The car looks great and I would like to negotiate at this amount.', '2026-03-06 16:30:00'),
(63, 22, 19, 11368.00, 'I am interested in this car and would like to make a serious offer.', '2026-03-07 16:30:00'),
(64, 22, 14, 9512.00, 'I believe this is a fair offer based on the model and condition.', '2026-03-08 10:30:00'),
(65, 23, 12, 9898.00, 'I am interested and available to discuss the next steps.', '2026-03-08 16:15:00'),
(66, 23, 18, 8585.00, 'Please review my offer. I am genuinely interested.', '2026-03-09 16:15:00'),
(67, 23, 13, 8888.00, 'I would be happy to inspect the car if the offer is suitable.', '2026-03-10 19:15:00'),
(68, 23, 19, 9292.00, 'I would like to move forward quickly if you accept this offer.', '2026-03-11 19:15:00'),
(69, 24, 17, 7830.00, 'This seems like a strong option for me. Please let me know your response.', '2026-03-10 17:50:00'),
(70, 24, 12, 8004.00, 'I am interested in this car and would like to make a serious offer.', '2026-03-11 20:50:00'),
(71, 25, 11, 7008.00, 'Please review my offer. I am genuinely interested.', '2026-03-13 20:10:00'),
(72, 25, 17, 5986.00, 'This looks like a good car. Please consider my offer.', '2026-03-14 20:10:00'),
(73, 25, 12, 6205.00, 'I would like to move forward quickly if you accept this offer.', '2026-03-15 23:10:00'),
(74, 26, 10, 13448.00, 'This seems like a strong option for me. Please let me know your response.', '2026-03-15 12:00:00'),
(75, 26, 16, 14432.00, 'I believe this is a fair offer based on the model and condition.', '2026-03-16 12:00:00'),
(76, 26, 11, 14760.00, 'The listing is impressive, and I would like to submit this offer.', '2026-03-17 15:00:00'),
(77, 26, 17, 15416.00, 'This car matches what I am looking for. Kindly consider my offer.', '2026-03-18 15:00:00'),
(78, 27, 10, 8366.00, 'This looks like a good car. Please consider my offer.', '2026-03-17 15:40:00'),
(79, 27, 16, 8722.00, 'I am serious about buying and would appreciate your consideration.', '2026-03-18 15:40:00'),
(80, 28, 15, 9605.00, 'I like the condition and features. Let me know if this works for you.', '2026-03-20 16:05:00'),
(81, 28, 10, 9944.00, 'This car matches what I am looking for. Kindly consider my offer.', '2026-03-21 19:05:00'),
(82, 28, 16, 10396.00, 'The car looks great and I would like to negotiate at this amount.', '2026-03-22 19:05:00'),
(83, 29, 15, 6624.00, 'I am interested and available to discuss the next steps.', '2026-03-22 11:20:00'),
(84, 29, 10, 6762.00, 'I am interested in purchasing this car and would like you to review my offer.', '2026-03-23 14:20:00'),
(85, 29, 16, 5865.00, 'I would be happy to inspect the car if the offer is suitable.', '2026-03-24 14:20:00'),
(86, 29, 11, 6072.00, 'This looks like a good car. Please consider my offer.', '2026-03-25 17:20:00'),
(87, 30, 14, 9758.00, 'Please consider this amount. I think it is fair for both sides.', '2026-03-24 13:55:00'),
(88, 30, 20, 10472.00, 'This seems like a strong option for me. Please let me know your response.', '2026-03-25 13:55:00'),
(89, 31, 14, 5076.00, 'Please review my offer. I am genuinely interested.', '2026-03-27 18:25:00'),
(90, 31, 20, 5292.00, 'This looks like a good car. Please consider my offer.', '2026-03-28 18:25:00'),
(91, 31, 15, 4428.00, 'I would like to move forward quickly if you accept this offer.', '2026-03-29 21:25:00'),
(92, 32, 13, 22344.00, 'This seems like a strong option for me. Please let me know your response.', '2026-04-06 16:40:00'),
(93, 32, 19, 19380.00, 'I believe this is a fair offer based on the model and condition.', '2026-04-07 16:40:00'),
(94, 32, 14, 20064.00, 'The listing is impressive, and I would like to submit this offer.', '2026-04-08 10:40:00'),
(95, 32, 20, 20976.00, 'This car matches what I am looking for. Kindly consider my offer.', '2026-04-09 10:40:00'),
(96, 33, 13, 19688.00, 'This looks like a good car. Please consider my offer.', '2026-04-08 11:10:00'),
(97, 33, 19, 20544.00, 'I am serious about buying and would appreciate your consideration.', '2026-04-09 11:10:00'),
(98, 34, 12, 19680.00, 'I believe this is a fair offer based on the model and condition.', '2026-04-10 21:25:00'),
(99, 34, 18, 16810.00, 'I like the condition and features. Let me know if this works for you.', '2026-04-11 21:25:00'),
(100, 34, 13, 17425.00, 'This car matches what I am looking for. Kindly consider my offer.', '2026-04-12 15:25:00'),
(101, 35, 12, 21510.00, 'I am serious about buying and would appreciate your consideration.', '2026-04-13 00:45:00'),
(102, 35, 18, 22466.00, 'I am interested and available to discuss the next steps.', '2026-04-14 00:45:00'),
(103, 35, 13, 22944.00, 'I am interested in purchasing this car and would like you to review my offer.', '2026-04-14 18:45:00'),
(104, 35, 19, 19598.00, 'I would be happy to inspect the car if the offer is suitable.', '2026-04-15 18:45:00'),
(105, 36, 11, 17766.00, 'I like the condition and features. Let me know if this works for you.', '2026-04-14 16:35:00'),
(106, 36, 17, 18522.00, 'Please consider this amount. I think it is fair for both sides.', '2026-04-15 16:35:00'),
(107, 37, 11, 28600.00, 'I am interested and available to discuss the next steps.', '2026-04-16 19:15:00'),
(108, 37, 17, 29900.00, 'Please review my offer. I am genuinely interested.', '2026-04-17 19:15:00'),
(109, 37, 12, 30550.00, 'I would be happy to inspect the car if the offer is suitable.', '2026-04-18 13:15:00'),
(110, 38, 10, 27416.00, 'Please consider this amount. I think it is fair for both sides.', '2026-04-18 20:30:00'),
(111, 38, 16, 28608.00, 'This seems like a strong option for me. Please let me know your response.', '2026-04-19 20:30:00'),
(112, 38, 11, 29204.00, 'I am interested in this car and would like to make a serious offer.', '2026-04-20 23:30:00'),
(113, 38, 17, 25330.00, 'The listing is impressive, and I would like to submit this offer.', '2026-04-21 23:30:00'),
(114, 39, 15, 12628.00, 'I am interested in purchasing this car and would like you to review my offer.', '2026-04-20 12:45:00'),
(115, 39, 10, 13090.00, 'Please review my offer. I am genuinely interested.', '2026-04-21 15:45:00'),
(116, 40, 15, 16544.00, 'I believe this is a fair offer based on the model and condition.', '2026-04-22 17:20:00'),
(117, 40, 10, 16896.00, 'The listing is impressive, and I would like to submit this offer.', '2026-04-23 20:20:00'),
(118, 40, 16, 14432.00, 'This car matches what I am looking for. Kindly consider my offer.', '2026-04-24 20:20:00'),
(119, 41, 14, 20776.00, 'I would be happy to inspect the car if the offer is suitable.', '2026-04-24 19:10:00'),
(120, 41, 20, 18020.00, 'I would like to move forward quickly if you accept this offer.', '2026-04-25 19:10:00'),
(121, 41, 15, 18656.00, 'I am serious about buying and would appreciate your consideration.', '2026-04-26 22:10:00'),
(122, 41, 10, 19080.00, 'I am ready to proceed if the offer is acceptable.', '2026-04-28 01:10:00'),
(123, 42, 14, 12512.00, 'I like the condition and features. Let me know if this works for you.', '2026-04-25 11:55:00'),
(124, 42, 20, 13056.00, 'Please consider this amount. I think it is fair for both sides.', '2026-04-26 11:55:00'),
(125, 43, 13, 8736.00, 'I would like to move forward quickly if you accept this offer.', '2026-04-25 11:25:00'),
(126, 43, 19, 7462.00, 'I am ready to proceed if the offer is acceptable.', '2026-04-26 11:25:00'),
(127, 43, 14, 7735.00, 'I am interested and available to discuss the next steps.', '2026-04-27 14:25:00'),
(128, 44, 13, 11430.00, 'Please consider this amount. I think it is fair for both sides.', '2026-04-25 14:40:00'),
(129, 44, 19, 11938.00, 'This seems like a strong option for me. Please let me know your response.', '2026-04-26 14:40:00'),
(130, 44, 14, 12192.00, 'I am interested in this car and would like to make a serious offer.', '2026-04-27 17:40:00'),
(131, 44, 20, 10414.00, 'The listing is impressive, and I would like to submit this offer.', '2026-04-28 17:40:00'),
(132, 45, 12, 12408.00, 'I am ready to proceed if the offer is acceptable.', '2026-04-25 14:15:00'),
(133, 45, 18, 12936.00, 'I am interested in purchasing this car and would like you to review my offer.', '2026-04-26 14:15:00'),
(134, 46, 12, 10648.00, 'This seems like a strong option for me. Please let me know your response.', '2026-04-25 17:05:00'),
(135, 46, 18, 11132.00, 'I believe this is a fair offer based on the model and condition.', '2026-04-26 17:05:00'),
(136, 46, 13, 11374.00, 'The listing is impressive, and I would like to submit this offer.', '2026-04-27 20:05:00');

--
-- Triggers `dbProj_offers`
--
DELIMITER $$
CREATE TRIGGER `trg_prevent_duplicate_offer` BEFORE INSERT ON `dbProj_offers` FOR EACH ROW BEGIN
    IF EXISTS (
        SELECT 1
        FROM dbProj_offers
        WHERE car_id = NEW.car_id
          AND user_id = NEW.user_id
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'User has already made an offer on this car.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `dbProj_ratings`
--

CREATE TABLE `dbProj_ratings` (
  `rating_id` int NOT NULL,
  `car_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating_value` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `dbProj_ratings`
--

INSERT INTO `dbProj_ratings` (`rating_id`, `car_id`, `user_id`, `rating_value`, `created_at`) VALUES
(2, 2, 14, 5, '2026-01-06 09:10:00'),
(3, 2, 7, 5, '2026-01-07 15:10:00'),
(4, 2, 15, 5, '2026-01-08 11:10:00'),
(5, 2, 8, 5, '2026-01-09 17:10:00'),
(6, 2, 1, 5, '2026-01-10 13:10:00'),
(9, 3, 6, 5, '2026-01-08 16:25:00'),
(10, 3, 14, 5, '2026-01-09 12:25:00'),
(11, 3, 7, 5, '2026-01-10 18:25:00'),
(12, 3, 15, 5, '2026-01-11 14:25:00'),
(13, 3, 8, 5, '2026-01-12 20:25:00'),
(17, 4, 13, 1, '2026-01-10 14:40:00'),
(18, 4, 6, 1, '2026-01-11 20:40:00'),
(19, 4, 14, 5, '2026-01-12 16:40:00'),
(20, 4, 7, 5, '2026-01-13 22:40:00'),
(21, 4, 15, 4, '2026-01-14 18:40:00'),
(22, 4, 8, 4, '2026-01-15 14:40:00'),
(23, 4, 1, 4, '2026-01-16 20:40:00'),
(24, 4, 16, 3, '2026-01-17 20:40:00'),
(25, 4, 9, 4, '2026-01-18 16:40:00'),
(26, 5, 5, 5, '2026-01-13 15:15:00'),
(27, 5, 20, 4, '2026-01-14 15:15:00'),
(28, 5, 13, 4, '2026-01-15 11:15:00'),
(29, 5, 6, 4, '2026-01-16 17:15:00'),
(30, 5, 14, 4, '2026-01-17 13:15:00'),
(31, 5, 7, 4, '2026-01-18 19:15:00'),
(32, 5, 15, 3, '2026-01-19 15:15:00'),
(33, 5, 8, 3, '2026-01-20 11:15:00'),
(34, 5, 1, 3, '2026-01-21 17:15:00'),
(35, 5, 16, 2, '2026-01-22 17:15:00'),
(36, 6, 12, 4, '2026-01-15 16:05:00'),
(37, 6, 5, 4, '2026-01-16 22:05:00'),
(38, 6, 20, 3, '2026-01-17 22:05:00'),
(39, 6, 13, 3, '2026-01-18 18:05:00'),
(40, 6, 6, 3, '2026-01-20 00:05:00'),
(41, 6, 14, 3, '2026-01-20 20:05:00'),
(42, 6, 7, 3, '2026-01-21 16:05:00'),
(43, 6, 15, 2, '2026-01-22 22:05:00'),
(44, 6, 8, 2, '2026-01-23 18:05:00'),
(45, 6, 1, 2, '2026-01-25 00:05:00'),
(46, 6, 16, 1, '2026-01-26 00:05:00'),
(47, 7, 19, 3, '2026-01-19 17:30:00'),
(48, 7, 12, 3, '2026-01-20 13:30:00'),
(49, 7, 5, 3, '2026-01-21 19:30:00'),
(50, 7, 20, 2, '2026-01-22 19:30:00'),
(51, 7, 13, 2, '2026-01-23 15:30:00'),
(52, 7, 6, 2, '2026-01-24 21:30:00'),
(53, 7, 14, 1, '2026-01-25 17:30:00'),
(54, 7, 7, 2, '2026-01-26 13:30:00'),
(55, 7, 15, 5, '2026-01-27 19:30:00'),
(56, 7, 8, 1, '2026-01-28 15:30:00'),
(57, 7, 1, 1, '2026-01-29 21:30:00'),
(58, 7, 16, 4, '2026-01-30 21:30:00'),
(59, 8, 11, 2, '2026-01-21 09:50:00'),
(60, 8, 19, 1, '2026-01-22 15:50:00'),
(61, 8, 12, 2, '2026-01-23 11:50:00'),
(62, 8, 5, 2, '2026-01-24 17:50:00'),
(63, 8, 20, 5, '2026-01-25 17:50:00'),
(64, 8, 13, 1, '2026-01-26 13:50:00'),
(65, 8, 6, 1, '2026-01-27 09:50:00'),
(66, 8, 14, 5, '2026-01-28 15:50:00'),
(67, 8, 7, 5, '2026-01-29 11:50:00'),
(68, 8, 15, 4, '2026-01-30 17:50:00'),
(69, 8, 8, 4, '2026-01-31 13:50:00'),
(70, 8, 1, 4, '2026-02-01 09:50:00'),
(71, 8, 16, 3, '2026-02-02 09:50:00'),
(72, 9, 3, 2, '2026-01-23 20:20:00'),
(73, 9, 18, 1, '2026-01-24 20:20:00'),
(74, 9, 11, 1, '2026-01-25 16:20:00'),
(75, 9, 19, 5, '2026-01-26 22:20:00'),
(76, 9, 12, 5, '2026-01-27 18:20:00'),
(77, 9, 5, 5, '2026-01-29 00:20:00'),
(78, 9, 20, 4, '2026-01-30 00:20:00'),
(79, 9, 13, 4, '2026-01-30 20:20:00'),
(80, 9, 6, 4, '2026-01-31 16:20:00'),
(81, 9, 14, 4, '2026-02-01 22:20:00'),
(82, 9, 7, 4, '2026-02-02 18:20:00'),
(83, 9, 15, 3, '2026-02-04 00:20:00'),
(84, 9, 8, 3, '2026-02-04 20:20:00'),
(85, 9, 1, 3, '2026-02-05 16:20:00'),
(86, 10, 17, 5, '2026-01-26 17:10:00'),
(87, 10, 10, 5, '2026-01-27 13:10:00'),
(88, 10, 3, 1, '2026-01-28 19:10:00'),
(89, 10, 18, 4, '2026-01-29 19:10:00'),
(90, 10, 11, 4, '2026-01-30 15:10:00'),
(91, 10, 19, 4, '2026-01-31 21:10:00'),
(92, 10, 12, 4, '2026-02-01 17:10:00'),
(93, 10, 5, 4, '2026-02-02 13:10:00'),
(94, 10, 20, 3, '2026-02-03 13:10:00'),
(95, 10, 13, 3, '2026-02-04 19:10:00'),
(96, 10, 6, 3, '2026-02-05 15:10:00'),
(97, 10, 14, 3, '2026-02-06 21:10:00'),
(98, 10, 7, 3, '2026-02-07 17:10:00'),
(99, 10, 15, 2, '2026-02-08 13:10:00'),
(100, 10, 8, 2, '2026-02-09 19:10:00'),
(101, 11, 9, 5, '2026-01-30 02:45:00'),
(102, 11, 2, 5, '2026-01-30 22:45:00'),
(103, 11, 17, 4, '2026-01-31 22:45:00'),
(104, 11, 10, 4, '2026-02-01 18:45:00'),
(105, 11, 3, 4, '2026-02-03 00:45:00'),
(106, 12, 1, 4, '2026-02-03 12:55:00'),
(107, 12, 16, 3, '2026-02-04 12:55:00'),
(108, 12, 9, 4, '2026-02-05 08:55:00'),
(109, 12, 2, 4, '2026-02-06 14:55:00'),
(110, 12, 17, 3, '2026-02-07 14:55:00'),
(111, 12, 10, 3, '2026-02-08 10:55:00'),
(112, 13, 8, 3, '2026-02-05 19:35:00'),
(113, 13, 1, 3, '2026-02-06 15:35:00'),
(114, 13, 16, 2, '2026-02-07 15:35:00'),
(115, 13, 9, 3, '2026-02-08 11:35:00'),
(116, 13, 2, 3, '2026-02-09 17:35:00'),
(117, 13, 17, 2, '2026-02-10 17:35:00'),
(118, 13, 10, 2, '2026-02-11 13:35:00'),
(119, 14, 15, 2, '2026-02-07 18:15:00'),
(120, 14, 8, 2, '2026-02-08 14:15:00'),
(121, 14, 1, 2, '2026-02-09 20:15:00'),
(122, 14, 16, 1, '2026-02-10 20:15:00'),
(123, 14, 9, 1, '2026-02-11 16:15:00'),
(124, 14, 2, 2, '2026-02-12 22:15:00'),
(125, 14, 17, 5, '2026-02-13 22:15:00'),
(126, 14, 10, 5, '2026-02-14 18:15:00'),
(127, 15, 7, 2, '2026-02-10 20:40:00'),
(128, 15, 15, 5, '2026-02-11 16:40:00'),
(129, 15, 8, 1, '2026-02-12 12:40:00'),
(130, 15, 1, 1, '2026-02-13 18:40:00'),
(131, 15, 16, 4, '2026-02-14 18:40:00'),
(132, 15, 9, 5, '2026-02-15 14:40:00'),
(133, 15, 2, 5, '2026-02-16 20:40:00'),
(134, 15, 17, 4, '2026-02-17 20:40:00'),
(135, 15, 10, 4, '2026-02-18 16:40:00'),
(136, 16, 14, 5, '2026-02-12 20:25:00'),
(137, 16, 7, 5, '2026-02-13 16:25:00'),
(138, 16, 15, 4, '2026-02-14 22:25:00'),
(139, 16, 8, 4, '2026-02-15 18:25:00'),
(140, 16, 1, 4, '2026-02-17 00:25:00'),
(141, 16, 16, 3, '2026-02-18 00:25:00'),
(142, 16, 9, 4, '2026-02-18 20:25:00'),
(143, 16, 2, 4, '2026-02-19 16:25:00'),
(144, 16, 17, 3, '2026-02-20 16:25:00'),
(145, 16, 10, 3, '2026-02-21 22:25:00'),
(146, 17, 14, 4, '2026-02-14 14:05:00'),
(147, 17, 7, 4, '2026-02-15 10:05:00'),
(148, 17, 15, 3, '2026-02-16 16:05:00'),
(149, 17, 8, 3, '2026-02-17 12:05:00'),
(150, 17, 1, 3, '2026-02-18 18:05:00'),
(151, 17, 16, 2, '2026-02-19 18:05:00'),
(152, 17, 9, 3, '2026-02-20 14:05:00'),
(153, 17, 2, 3, '2026-02-21 10:05:00'),
(154, 17, 17, 2, '2026-02-22 10:05:00'),
(155, 17, 10, 2, '2026-02-23 16:05:00'),
(156, 17, 3, 2, '2026-02-24 12:05:00'),
(157, 18, 13, 3, '2026-02-17 16:20:00'),
(158, 18, 14, 3, '2026-02-18 18:20:00'),
(159, 18, 7, 3, '2026-02-19 14:20:00'),
(160, 18, 15, 2, '2026-02-20 20:20:00'),
(161, 18, 8, 2, '2026-02-21 16:20:00'),
(162, 18, 1, 2, '2026-02-22 12:20:00'),
(163, 18, 16, 1, '2026-02-23 12:20:00'),
(164, 18, 9, 1, '2026-02-24 18:20:00'),
(165, 18, 2, 2, '2026-02-25 14:20:00'),
(166, 18, 17, 5, '2026-02-26 14:20:00'),
(167, 18, 10, 5, '2026-02-27 20:20:00'),
(168, 18, 3, 1, '2026-02-28 16:20:00'),
(169, 19, 5, 3, '2026-02-20 00:55:00'),
(170, 19, 20, 2, '2026-02-21 00:55:00'),
(171, 19, 13, 2, '2026-02-21 20:55:00'),
(172, 19, 14, 1, '2026-02-22 22:55:00'),
(173, 19, 7, 2, '2026-02-23 18:55:00'),
(174, 19, 15, 5, '2026-02-25 00:55:00'),
(175, 19, 8, 1, '2026-02-25 20:55:00'),
(176, 19, 1, 1, '2026-02-26 16:55:00'),
(177, 19, 16, 4, '2026-02-27 16:55:00'),
(178, 19, 9, 5, '2026-02-28 22:55:00'),
(179, 19, 2, 5, '2026-03-01 18:55:00'),
(180, 19, 17, 4, '2026-03-02 18:55:00'),
(181, 19, 10, 4, '2026-03-04 00:55:00'),
(182, 20, 12, 2, '2026-02-22 17:35:00'),
(183, 20, 5, 2, '2026-02-23 13:35:00'),
(184, 20, 20, 5, '2026-02-24 13:35:00'),
(185, 20, 13, 1, '2026-02-25 19:35:00'),
(186, 20, 14, 5, '2026-02-26 21:35:00'),
(187, 20, 7, 5, '2026-02-27 17:35:00'),
(188, 20, 15, 4, '2026-02-28 13:35:00'),
(189, 20, 8, 4, '2026-03-01 19:35:00'),
(190, 20, 1, 4, '2026-03-02 15:35:00'),
(191, 20, 16, 3, '2026-03-03 15:35:00'),
(192, 20, 9, 4, '2026-03-04 21:35:00'),
(193, 20, 2, 4, '2026-03-05 17:35:00'),
(194, 20, 17, 3, '2026-03-06 17:35:00'),
(195, 20, 10, 3, '2026-03-07 13:35:00'),
(196, 21, 4, 1, '2026-02-25 19:45:00'),
(197, 21, 19, 5, '2026-02-26 19:45:00'),
(198, 21, 12, 5, '2026-02-27 15:45:00'),
(199, 21, 5, 5, '2026-02-28 11:45:00'),
(200, 21, 20, 4, '2026-03-01 11:45:00'),
(201, 21, 13, 4, '2026-03-02 17:45:00'),
(202, 21, 14, 4, '2026-03-03 19:45:00'),
(203, 21, 7, 4, '2026-03-04 15:45:00'),
(204, 21, 15, 3, '2026-03-05 11:45:00'),
(205, 21, 8, 3, '2026-03-06 17:45:00'),
(206, 21, 1, 3, '2026-03-07 13:45:00'),
(207, 21, 16, 2, '2026-03-08 13:45:00'),
(208, 21, 9, 3, '2026-03-09 19:45:00'),
(209, 21, 2, 3, '2026-03-10 15:45:00'),
(210, 21, 17, 2, '2026-03-11 15:45:00'),
(211, 22, 18, 4, '2026-03-02 17:30:00'),
(212, 22, 11, 4, '2026-03-03 13:30:00'),
(213, 22, 4, 5, '2026-03-04 09:30:00'),
(214, 22, 19, 4, '2026-03-05 09:30:00'),
(215, 22, 12, 4, '2026-03-06 15:30:00'),
(216, 23, 10, 4, '2026-03-04 14:15:00'),
(217, 23, 3, 4, '2026-03-05 20:15:00'),
(218, 23, 18, 3, '2026-03-06 20:15:00'),
(219, 23, 11, 3, '2026-03-07 16:15:00'),
(220, 23, 4, 4, '2026-03-08 12:15:00'),
(221, 23, 19, 3, '2026-03-09 12:15:00'),
(222, 24, 2, 4, '2026-03-06 22:50:00'),
(223, 24, 17, 3, '2026-03-07 22:50:00'),
(224, 24, 10, 3, '2026-03-08 18:50:00'),
(225, 24, 3, 3, '2026-03-09 14:50:00'),
(226, 24, 18, 2, '2026-03-10 14:50:00'),
(227, 24, 11, 2, '2026-03-11 20:50:00'),
(228, 24, 4, 3, '2026-03-12 16:50:00'),
(229, 25, 9, 3, '2026-03-09 19:10:00'),
(230, 25, 2, 3, '2026-03-11 01:10:00'),
(231, 25, 17, 2, '2026-03-12 01:10:00'),
(232, 25, 10, 2, '2026-03-12 21:10:00'),
(233, 25, 3, 2, '2026-03-13 17:10:00'),
(234, 25, 18, 1, '2026-03-14 17:10:00'),
(235, 25, 11, 1, '2026-03-15 23:10:00'),
(236, 25, 4, 1, '2026-03-16 19:10:00'),
(237, 26, 1, 2, '2026-03-11 18:00:00'),
(238, 26, 16, 1, '2026-03-12 18:00:00'),
(239, 26, 9, 1, '2026-03-13 14:00:00'),
(240, 26, 2, 2, '2026-03-14 10:00:00'),
(241, 26, 17, 5, '2026-03-15 10:00:00'),
(242, 26, 10, 5, '2026-03-16 16:00:00'),
(243, 26, 3, 1, '2026-03-17 12:00:00'),
(244, 26, 18, 4, '2026-03-18 12:00:00'),
(245, 26, 11, 4, '2026-03-19 18:00:00'),
(246, 27, 1, 1, '2026-03-13 21:40:00'),
(247, 27, 16, 4, '2026-03-14 21:40:00'),
(248, 27, 9, 5, '2026-03-15 17:40:00'),
(249, 27, 2, 5, '2026-03-16 13:40:00'),
(250, 27, 17, 4, '2026-03-17 13:40:00'),
(251, 27, 10, 4, '2026-03-18 19:40:00'),
(252, 27, 3, 4, '2026-03-19 15:40:00'),
(253, 27, 18, 3, '2026-03-20 15:40:00'),
(254, 27, 11, 3, '2026-03-21 21:40:00'),
(255, 27, 4, 4, '2026-03-22 17:40:00'),
(256, 28, 15, 4, '2026-03-16 23:05:00'),
(257, 28, 1, 4, '2026-03-17 15:05:00'),
(258, 28, 16, 3, '2026-03-18 15:05:00'),
(259, 28, 9, 4, '2026-03-19 21:05:00'),
(260, 28, 2, 4, '2026-03-20 17:05:00'),
(261, 28, 17, 3, '2026-03-21 17:05:00'),
(262, 28, 10, 3, '2026-03-22 23:05:00'),
(263, 28, 3, 3, '2026-03-23 19:05:00'),
(264, 28, 18, 2, '2026-03-24 19:05:00'),
(265, 28, 11, 2, '2026-03-25 15:05:00'),
(266, 28, 4, 3, '2026-03-26 21:05:00'),
(267, 29, 7, 4, '2026-03-18 12:20:00'),
(268, 29, 15, 3, '2026-03-19 18:20:00'),
(269, 29, 1, 3, '2026-03-20 10:20:00'),
(270, 29, 16, 2, '2026-03-21 10:20:00'),
(271, 29, 9, 3, '2026-03-22 16:20:00'),
(272, 29, 2, 3, '2026-03-23 12:20:00'),
(273, 29, 17, 2, '2026-03-24 12:20:00'),
(274, 29, 10, 2, '2026-03-25 18:20:00'),
(275, 29, 3, 2, '2026-03-26 14:20:00'),
(276, 29, 18, 1, '2026-03-27 14:20:00'),
(277, 29, 11, 1, '2026-03-28 10:20:00'),
(278, 29, 4, 1, '2026-03-29 16:20:00'),
(279, 30, 14, 3, '2026-03-20 21:55:00'),
(280, 30, 7, 3, '2026-03-21 17:55:00'),
(281, 30, 15, 2, '2026-03-22 13:55:00'),
(282, 30, 1, 2, '2026-03-23 15:55:00'),
(283, 30, 16, 1, '2026-03-24 15:55:00'),
(284, 30, 9, 1, '2026-03-25 21:55:00'),
(285, 30, 2, 2, '2026-03-26 17:55:00'),
(286, 30, 17, 5, '2026-03-27 17:55:00'),
(287, 30, 10, 5, '2026-03-28 13:55:00'),
(288, 30, 3, 1, '2026-03-29 19:55:00'),
(289, 30, 18, 4, '2026-03-30 19:55:00'),
(290, 30, 11, 4, '2026-03-31 15:55:00'),
(291, 30, 4, 5, '2026-04-01 21:55:00'),
(292, 31, 6, 2, '2026-03-23 20:25:00'),
(293, 31, 14, 1, '2026-03-25 02:25:00'),
(294, 31, 7, 2, '2026-03-25 22:25:00'),
(295, 31, 15, 5, '2026-03-26 18:25:00'),
(296, 31, 1, 1, '2026-03-27 20:25:00'),
(297, 31, 16, 4, '2026-03-28 20:25:00'),
(298, 31, 9, 5, '2026-03-30 02:25:00'),
(299, 31, 2, 5, '2026-03-30 22:25:00'),
(300, 31, 17, 4, '2026-03-31 22:25:00'),
(301, 31, 10, 4, '2026-04-01 18:25:00'),
(302, 31, 3, 4, '2026-04-03 00:25:00'),
(303, 31, 18, 3, '2026-04-04 00:25:00'),
(304, 31, 11, 3, '2026-04-04 20:25:00'),
(305, 31, 4, 4, '2026-04-06 02:25:00'),
(306, 32, 13, 1, '2026-04-02 16:40:00'),
(307, 32, 6, 1, '2026-04-03 12:40:00'),
(308, 32, 14, 5, '2026-04-04 08:40:00'),
(309, 32, 7, 5, '2026-04-05 14:40:00'),
(310, 32, 15, 4, '2026-04-06 10:40:00'),
(311, 32, 8, 4, '2026-04-07 16:40:00'),
(312, 32, 1, 4, '2026-04-08 12:40:00'),
(313, 32, 16, 3, '2026-04-09 12:40:00'),
(314, 32, 2, 4, '2026-04-10 14:40:00'),
(315, 32, 17, 3, '2026-04-11 14:40:00'),
(316, 32, 10, 3, '2026-04-12 10:40:00'),
(317, 32, 3, 3, '2026-04-13 16:40:00'),
(318, 32, 18, 2, '2026-04-14 16:40:00'),
(319, 32, 11, 2, '2026-04-15 12:40:00'),
(320, 32, 4, 3, '2026-04-16 08:40:00'),
(321, 33, 5, 5, '2026-04-04 14:10:00'),
(322, 33, 20, 4, '2026-04-05 14:10:00'),
(323, 33, 13, 4, '2026-04-06 20:10:00'),
(324, 33, 6, 4, '2026-04-07 16:10:00'),
(325, 33, 14, 4, '2026-04-08 12:10:00'),
(326, 34, 19, 4, '2026-04-06 16:25:00'),
(327, 34, 12, 4, '2026-04-07 22:25:00'),
(328, 34, 5, 4, '2026-04-08 18:25:00'),
(329, 34, 20, 3, '2026-04-09 18:25:00'),
(330, 34, 13, 3, '2026-04-10 14:25:00'),
(331, 34, 6, 3, '2026-04-11 20:25:00'),
(332, 35, 11, 3, '2026-04-08 23:45:00'),
(333, 35, 4, 4, '2026-04-09 19:45:00'),
(334, 35, 19, 3, '2026-04-10 19:45:00'),
(335, 35, 12, 3, '2026-04-12 01:45:00'),
(336, 35, 5, 3, '2026-04-12 21:45:00'),
(337, 35, 20, 2, '2026-04-13 21:45:00'),
(338, 35, 13, 2, '2026-04-14 17:45:00'),
(339, 36, 3, 3, '2026-04-10 12:35:00'),
(340, 36, 18, 2, '2026-04-11 12:35:00'),
(341, 36, 11, 2, '2026-04-12 18:35:00'),
(342, 36, 4, 3, '2026-04-13 14:35:00'),
(343, 36, 19, 1, '2026-04-14 14:35:00'),
(344, 36, 12, 2, '2026-04-15 10:35:00'),
(345, 36, 5, 2, '2026-04-16 16:35:00'),
(346, 36, 20, 5, '2026-04-17 16:35:00'),
(347, 37, 10, 2, '2026-04-12 19:15:00'),
(348, 37, 18, 1, '2026-04-13 15:15:00'),
(349, 37, 11, 1, '2026-04-14 21:15:00'),
(350, 37, 4, 1, '2026-04-15 17:15:00'),
(351, 37, 19, 5, '2026-04-16 17:15:00'),
(352, 37, 12, 5, '2026-04-17 13:15:00'),
(353, 37, 5, 5, '2026-04-18 19:15:00'),
(354, 37, 20, 4, '2026-04-19 19:15:00'),
(355, 37, 13, 4, '2026-04-20 15:15:00'),
(356, 38, 2, 2, '2026-04-14 17:30:00'),
(357, 38, 17, 5, '2026-04-15 17:30:00'),
(358, 38, 10, 5, '2026-04-16 23:30:00'),
(359, 38, 3, 1, '2026-04-17 19:30:00'),
(360, 38, 18, 4, '2026-04-18 19:30:00'),
(361, 38, 11, 4, '2026-04-19 15:30:00'),
(362, 38, 19, 4, '2026-04-20 21:30:00'),
(363, 38, 12, 4, '2026-04-21 17:30:00'),
(364, 38, 5, 4, '2026-04-22 23:30:00'),
(365, 38, 20, 3, '2026-04-23 23:30:00'),
(366, 39, 9, 5, '2026-04-16 16:45:00'),
(367, 39, 2, 5, '2026-04-17 12:45:00'),
(368, 39, 17, 4, '2026-04-18 12:45:00'),
(369, 39, 10, 4, '2026-04-19 18:45:00'),
(370, 39, 3, 4, '2026-04-20 14:45:00'),
(371, 39, 18, 3, '2026-04-21 14:45:00'),
(372, 39, 11, 3, '2026-04-22 10:45:00'),
(373, 39, 4, 4, '2026-04-23 16:45:00'),
(374, 39, 19, 3, '2026-04-24 16:45:00'),
(375, 39, 12, 3, '2026-04-25 12:45:00'),
(376, 39, 20, 2, '2026-04-26 18:45:00'),
(377, 40, 1, 4, '2026-04-18 15:20:00'),
(378, 40, 16, 3, '2026-04-19 15:20:00'),
(379, 40, 9, 4, '2026-04-20 21:20:00'),
(380, 40, 2, 4, '2026-04-21 17:20:00'),
(381, 40, 17, 3, '2026-04-22 17:20:00'),
(382, 40, 10, 3, '2026-04-23 13:20:00'),
(383, 40, 3, 3, '2026-04-24 19:20:00'),
(384, 40, 18, 2, '2026-04-25 19:20:00'),
(385, 40, 11, 2, '2026-04-26 15:20:00'),
(386, 40, 4, 3, '2026-04-27 21:20:00'),
(387, 40, 19, 1, '2026-04-28 21:20:00'),
(388, 40, 12, 2, '2026-04-29 17:20:00'),
(389, 41, 8, 3, '2026-04-21 00:10:00'),
(390, 41, 1, 3, '2026-04-21 20:10:00'),
(391, 41, 16, 2, '2026-04-22 20:10:00'),
(392, 41, 9, 3, '2026-04-24 02:10:00'),
(393, 41, 2, 3, '2026-04-24 22:10:00'),
(394, 41, 17, 2, '2026-04-25 22:10:00'),
(395, 41, 10, 2, '2026-04-26 18:10:00'),
(396, 41, 3, 2, '2026-04-28 00:10:00'),
(397, 41, 18, 1, '2026-04-29 00:10:00'),
(398, 41, 11, 1, '2026-04-29 20:10:00'),
(399, 41, 4, 1, '2026-05-01 02:10:00'),
(400, 41, 19, 5, '2026-05-02 02:10:00'),
(401, 41, 12, 5, '2026-05-02 22:10:00'),
(402, 42, 15, 2, '2026-04-21 10:55:00'),
(403, 42, 1, 2, '2026-04-22 12:55:00'),
(404, 42, 16, 1, '2026-04-23 12:55:00'),
(405, 42, 9, 1, '2026-04-24 08:55:00'),
(406, 42, 2, 2, '2026-04-25 14:55:00'),
(407, 42, 17, 5, '2026-04-26 14:55:00'),
(408, 42, 10, 5, '2026-04-27 10:55:00'),
(409, 42, 3, 1, '2026-04-28 16:55:00'),
(410, 42, 18, 4, '2026-04-29 16:55:00'),
(411, 42, 11, 4, '2026-04-30 12:55:00'),
(412, 42, 4, 5, '2026-05-01 08:55:00'),
(413, 42, 19, 4, '2026-05-02 08:55:00'),
(414, 42, 12, 4, '2026-05-03 14:55:00'),
(415, 42, 5, 4, '2026-05-04 10:55:00'),
(416, 43, 7, 2, '2026-04-21 17:25:00'),
(417, 43, 15, 5, '2026-04-22 13:25:00'),
(418, 43, 8, 1, '2026-04-23 19:25:00'),
(419, 43, 1, 1, '2026-04-24 15:25:00'),
(420, 43, 16, 4, '2026-04-25 15:25:00'),
(421, 43, 2, 5, '2026-04-26 17:25:00'),
(422, 43, 17, 4, '2026-04-27 17:25:00'),
(423, 43, 10, 4, '2026-04-28 13:25:00'),
(424, 43, 3, 4, '2026-04-29 19:25:00'),
(425, 43, 18, 3, '2026-04-30 19:25:00'),
(426, 43, 11, 3, '2026-05-01 15:25:00'),
(427, 43, 4, 4, '2026-05-02 11:25:00'),
(428, 43, 19, 3, '2026-05-03 11:25:00'),
(429, 43, 12, 3, '2026-05-04 17:25:00'),
(430, 43, 5, 3, '2026-05-05 13:25:00'),
(431, 44, 14, 5, '2026-04-21 14:40:00'),
(432, 44, 7, 5, '2026-04-22 20:40:00'),
(433, 44, 15, 4, '2026-04-23 16:40:00'),
(434, 44, 8, 4, '2026-04-24 12:40:00'),
(435, 44, 1, 4, '2026-04-25 18:40:00'),
(436, 45, 6, 4, '2026-04-21 21:15:00'),
(437, 45, 14, 4, '2026-04-22 17:15:00'),
(438, 45, 7, 4, '2026-04-23 23:15:00'),
(439, 45, 15, 3, '2026-04-24 19:15:00'),
(440, 45, 8, 3, '2026-04-25 15:15:00'),
(441, 45, 1, 3, '2026-04-26 21:15:00'),
(442, 46, 20, 3, '2026-04-21 22:05:00'),
(443, 46, 13, 3, '2026-04-22 18:05:00'),
(444, 46, 6, 3, '2026-04-24 00:05:00'),
(445, 46, 14, 3, '2026-04-24 20:05:00'),
(446, 46, 7, 3, '2026-04-25 16:05:00'),
(447, 46, 15, 2, '2026-04-26 22:05:00'),
(448, 46, 8, 2, '2026-04-27 18:05:00');

--
-- Triggers `dbProj_ratings`
--
DELIMITER $$
CREATE TRIGGER `trg_prevent_duplicate_rating` BEFORE INSERT ON `dbProj_ratings` FOR EACH ROW BEGIN
    IF EXISTS (
        SELECT 1
        FROM dbProj_ratings
        WHERE car_id = NEW.car_id
          AND user_id = NEW.user_id
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'User has already rated this car.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `dbProj_users`
--

CREATE TABLE `dbProj_users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('viewer','creator','admin') DEFAULT 'viewer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbProj_users`
--

INSERT INTO `dbProj_users` (`user_id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Ahmed', 'ahmed@admin.com', '$2y$10$uBdUz5faKdebdBmYU5hxHOwTR3.vXD3dRXYQvpBV60RuJpqSBHW6y', 'admin', '2026-04-21 15:54:20'),
(2, 'Sara', 'sara@admin.com', '$2y$10$e8BgYzfzSkYpm8rQRSRuUuAMg615KSiDRoASk9.rp3B6E8ImV3udO', 'admin', '2026-04-21 15:54:36'),
(3, 'Ali', 'ali@creator.com', '$2y$10$SXFlvkn4WDUaU.0v5hgeduUHBhtOsPFAWqrGk4L9VW4mfRBKnYyeq', 'creator', '2026-04-21 15:56:05'),
(4, 'Fatima', 'fatima@creator.com', '$2y$10$jo5sWNa2JZGOJqrSCKjsE.2ZOjcmCvtep8MSZlD/a91ClLfuLN5Ci', 'creator', '2026-04-21 15:56:19'),
(5, 'Omar', 'omar@creator.com', '$2y$10$LXVXsAyCv5cqxwk0nDqhve1Lv0m4MzOS6KAjITODioJQHjsgE7/H.', 'creator', '2026-04-21 15:56:31'),
(6, 'Layla', 'layla@creator.com', '$2y$10$ZX.WNs7LpPcOmCF3k9w2IeFBG9CLppiFy33cW3V6T77X.jOQEAMzG', 'creator', '2026-04-21 15:56:41'),
(7, 'Hassan', 'hassan@creator.com', '$2y$10$PuYIc2Or1EW1slWgXAX5SOgdLQdY4v06KOftMCb0J1XsXQSI5dIGi', 'creator', '2026-04-21 15:56:52'),
(8, 'Noura', 'noura@creator.com', '$2y$10$RGVb13w4i/MBV9/MF7FEHumxnjJDnz5GJRIrbDWtIEDdkq.B7rC/S', 'creator', '2026-04-21 15:57:01'),
(9, 'Yousef', 'yousef@creator.com', '$2y$10$y4qyPwH2iiO0U7U7HW2xlu2ELm8AZh5Prh9QkLz6CxLEu78t6mua2', 'creator', '2026-04-21 15:57:14'),
(10, 'Noor', 'noor@viewer.com', '$2y$10$GE3T/ekdtl5gMeI1QqPut.qZeeSxlCNZsJANT4QHqUrZ70lqCad0K', 'viewer', '2026-04-21 15:57:56'),
(11, 'Mariam', 'mariam@viewer.com', '$2y$10$mi9pUpHRnoXz9rF7D19NqunY9..Kv4zI5uIVViYebWUNSN.KvfIIO', 'viewer', '2026-04-21 15:58:11'),
(12, 'Khalid', 'khalid@viewer.com', '$2y$10$Q7fcHxD8Y1PKE1VcplwnvejIo8rDZxbPMbCCg72hkx34IwfdTcQnu', 'viewer', '2026-04-21 15:58:20'),
(13, 'Reem', 'reem@viewer.com', '$2y$10$vYtJDFBFbLL9KQZbKGnyV.xjzqohn9kfpnbJp/uPKNoGAOFHxwwey', 'viewer', '2026-04-21 15:58:30'),
(14, 'Salman', 'salman@viewer.com', '$2y$10$NJagdfvFPhvR/laPCB7.me1TVS27sGwZHBKXp2d1LamZM4kxyf/Xi', 'viewer', '2026-04-21 15:58:40'),
(15, 'Zainab', 'zainab@viewer.com', '$2y$10$571zkkjJx1Unn2Ptzb7msuH5.52N8qdC9hOJ82WvYhNh7fXXqEDei', 'viewer', '2026-04-21 15:58:50'),
(16, 'Majed', 'majed@viewer.com', '$2y$10$5Co7FO0ZXULU2Xsu5kHxZOQg6ivZOt7vqcrbeGcoODriR6u3eGu02', 'viewer', '2026-04-21 15:59:01'),
(17, 'Huda', 'huda@viewer.com', '$2y$10$xyzE/bI.Xce9pWB4WccZAOTDOC/T2k1lWxKxGvSo0JxW7Gb05QzkK', 'viewer', '2026-04-21 15:59:10'),
(18, 'Tariq', 'tariq@viewer.com', '$2y$10$BxYRTwzFMNnwwXDihlKineV8qBgteTkwEgJS2WrBDaEt0iR49Xxoa', 'viewer', '2026-04-21 15:59:26'),
(19, 'Dana', 'dana@viewer.com', '$2y$10$fGYrkmsJdcuzKCYpOWVoM.ksHkvcrUghUXWoiH4i7QP5nxbFoJTk2', 'viewer', '2026-04-21 15:59:36'),
(20, 'Ibrahim', 'ibrahim@viewer.com', '$2y$10$RLtIp.twpVrNIBBQ9jXeXOR58qhDJMDpmTqbqhhGfS9ZEYl8ZwzYG', 'viewer', '2026-04-21 15:59:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbProj_appointments`
--
ALTER TABLE `dbProj_appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dbProj_cars`
--
ALTER TABLE `dbProj_cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_creator_id` (`creator_id`);
ALTER TABLE `dbProj_cars` ADD FULLTEXT KEY `title` (`title`,`short_description`);

--
-- Indexes for table `dbProj_comments`
--
ALTER TABLE `dbProj_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dbProj_offers`
--
ALTER TABLE `dbProj_offers`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dbProj_ratings`
--
ALTER TABLE `dbProj_ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD UNIQUE KEY `unique_user_car_rating` (`car_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dbProj_users`
--
ALTER TABLE `dbProj_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbProj_appointments`
--
ALTER TABLE `dbProj_appointments`
  MODIFY `appointment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `dbProj_cars`
--
ALTER TABLE `dbProj_cars`
  MODIFY `car_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `dbProj_comments`
--
ALTER TABLE `dbProj_comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `dbProj_offers`
--
ALTER TABLE `dbProj_offers`
  MODIFY `offer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `dbProj_ratings`
--
ALTER TABLE `dbProj_ratings`
  MODIFY `rating_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbProj_users`
--
ALTER TABLE `dbProj_users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dbProj_appointments`
--
ALTER TABLE `dbProj_appointments`
  ADD CONSTRAINT `dbProj_appointments_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `dbProj_cars` (`car_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dbProj_appointments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dbProj_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `dbProj_cars`
--
ALTER TABLE `dbProj_cars`
  ADD CONSTRAINT `dbProj_cars_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `dbProj_users` (`user_id`);

--
-- Constraints for table `dbProj_comments`
--
ALTER TABLE `dbProj_comments`
  ADD CONSTRAINT `dbProj_comments_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `dbProj_cars` (`car_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dbProj_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dbProj_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `dbProj_offers`
--
ALTER TABLE `dbProj_offers`
  ADD CONSTRAINT `dbProj_offers_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `dbProj_cars` (`car_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dbProj_offers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dbProj_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `dbProj_ratings`
--
ALTER TABLE `dbProj_ratings`
  ADD CONSTRAINT `dbProj_ratings_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `dbProj_cars` (`car_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dbProj_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dbProj_users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
