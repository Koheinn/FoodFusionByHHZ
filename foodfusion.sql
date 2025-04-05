-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: foodfusion
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `RecipeID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `CommentText` text NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`CommentID`),
  KEY `RecipeID` (`RecipeID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipes` (`RecipeID`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,2,2,'This is really\" great! Thanks for best dinner recipe ?','2025-03-31 11:56:10'),(2,1,2,'Wow, I like that! ?','2025-03-31 11:57:03'),(3,1,1,'Thank you Phoenix ?','2025-03-31 12:28:40'),(4,2,1,'Thanks for supporting me?','2025-03-31 12:29:32'),(5,1,2,'U welcome ❤️','2025-04-04 07:11:43'),(6,2,2,'It\'s a duty of a foodie lover ?','2025-04-04 07:13:03');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactmessages`
--

DROP TABLE IF EXISTS `contactmessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactmessages` (
  `MessageID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Subject` varchar(255) DEFAULT NULL,
  `Message` text NOT NULL,
  `SentAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`MessageID`),
  KEY `fk_contactmessages_userid` (`UserID`),
  CONSTRAINT `fk_contactmessages_userid` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactmessages`
--

LOCK TABLES `contactmessages` WRITE;
/*!40000 ALTER TABLE `contactmessages` DISABLE KEYS */;
INSERT INTO `contactmessages` VALUES (1,1,'Heinn Htet Zan','heinn2004@gmail.com','Partnership Proposal with FoodFusion Culinary Platform','Dear FoodFusion Team,\r\n\r\nI hope this message finds you well. My name is Heinn Htet Zan, and I am a business professional with a keen interest in the culinary industry. I am reaching out to explore potential collaboration opportunities that could be mutually beneficial.\r\n\r\nFoodFusion’s dedication to sharing innovative recipes and culinary trends aligns perfectly with my vision to enhance the gastronomic experience. I believe a partnership could open new avenues for growth, brand visibility, and community engagement.\r\n\r\nI would love to schedule a meeting at your convenience to discuss potential collaborations and how we can work together to create exciting culinary experiences.\r\n\r\nThank you for your time, and I look forward to your response.\r\n\r\nBest regards,\r\nHeinn Htet Zan\r\nCEO at Yummy Foodie Industry\r\nPhone Number - 0985683342','2025-03-31 13:20:38'),(2,1,'Alice','alice@gmail.com','scmsdcnksndcjdiiew','jdlcndjnicldiwedjewndwe','2025-04-01 12:52:53'),(3,1,'Bob','bob@gmail.com','Recipe Request','I want to know recipe tips and tricks to cook Mohingar.','2025-04-03 04:29:31');
/*!40000 ALTER TABLE `contactmessages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipeingredients`
--

DROP TABLE IF EXISTS `recipeingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recipeingredients` (
  `IngredientID` int(11) NOT NULL AUTO_INCREMENT,
  `RecipeID` int(11) DEFAULT NULL,
  `IngredientName` varchar(100) NOT NULL,
  `Quantity` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`IngredientID`),
  KEY `RecipeID` (`RecipeID`),
  CONSTRAINT `recipeingredients_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipes` (`RecipeID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipeingredients`
--

LOCK TABLES `recipeingredients` WRITE;
/*!40000 ALTER TABLE `recipeingredients` DISABLE KEYS */;
INSERT INTO `recipeingredients` VALUES (1,1,'Lasagna Noodles','12 pieces'),(2,1,'Ground Beef','500g'),(3,1,'Ricotta Cheese','2 cups'),(4,1,'Mozzarella Cheese','2 cups'),(5,1,'Parmesan Cheese','1/2 cup'),(6,1,'Marinara Sauce','3 cups'),(7,1,'Egg','1 large'),(8,1,'Garlic','2 cloves'),(9,1,'Italian Seasoning','1 tbsp'),(10,1,'Salt','To taste'),(11,1,'Black Pepper','To taste'),(12,2,'Fresh Strawberries','1 ½ cups'),(13,2,'All-Purpose Flour','1 cup'),(14,2,'Granulated Sugar','1 cup'),(15,2,'Baking Powder','1 tsp'),(16,2,'Salt','1/4 tsp'),(17,2,'Milk','1/2 cup'),(18,2,'Unsalted Butter','1/4 cup'),(19,2,'Vanilla Extract','1 tsp'),(20,2,'Lemon Juice','1 tbsp'),(21,2,'Sugar (for topping)','1 tbsp');
/*!40000 ALTER TABLE `recipeingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recipes` (
  `RecipeID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `CuisineType` varchar(50) DEFAULT NULL,
  `DietaryPreferences` varchar(100) DEFAULT NULL,
  `Difficulty` enum('Easy','Medium','Hard') DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `CookingTips` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`RecipeID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipes`
--

LOCK TABLES `recipes` WRITE;
/*!40000 ALTER TABLE `recipes` DISABLE KEYS */;
INSERT INTO `recipes` VALUES (1,1,'? Lasagna Rolls Recipe','Lasagna Rolls are a delicious twist on the classic lasagna, featuring rolled pasta sheets stuffed with a rich meat and cheese filling, smothered in marinara sauce, and topped with gooey melted cheese.\r\n✅ Step 1: Cook the Lasagna Noodles\r\nBring a large pot of salted water to a boil.\r\n\r\nCook lasagna noodles according to package instructions until al dente.\r\n\r\nDrain and lay the noodles flat on a baking sheet to prevent sticking.\r\n\r\n✅ Step 2: Prepare the Meat Filling\r\nIn a skillet over medium heat, cook ground beef until browned.\r\n\r\nAdd minced garlic and cook until fragrant (about 1 minute).\r\n\r\nSeason with Italian seasoning, salt, and pepper. Remove from heat and let it cool slightly.\r\n\r\n✅ Step 3: Make the Cheese Mixture\r\nIn a large mixing bowl, combine ricotta cheese, egg, 1 cup of mozzarella, 1/4 cup of Parmesan, and a pinch of salt and pepper.\r\n\r\nAdd the cooled meat mixture and stir until well combined.\r\n\r\n✅ Step 4: Assemble the Lasagna Rolls\r\nPreheat oven to 375°F (190°C).\r\n\r\nSpread 1 cup of marinara sauce evenly on the bottom of a baking dish.\r\n\r\nLay each lasagna noodle flat on a clean surface.\r\n\r\nSpread a generous amount of the filling mixture onto each noodle, leaving a small border.\r\n\r\nRoll the noodles tightly and place them seam-side down in the baking dish.\r\n\r\n✅ Step 5: Add Sauce and Cheese\r\nPour the remaining marinara sauce over the rolls.\r\n\r\nSprinkle extra mozzarella and Parmesan cheese on top.\r\n\r\n✅ Step 6: Bake\r\nCover the baking dish with foil and bake for 25 minutes.\r\n\r\nRemove the foil and bake for an additional 10 minutes, or until cheese is melted and bubbly.\r\n\r\nLet rest for 5 minutes before serving.\r\n\r\n? Serving Suggestions:\r\nServe hot, garnished with fresh parsley or basil. Pair with garlic bread and a green salad for a complete meal.','Italian','High-Protein','Medium','uploads/recipe_67ea81137d22a.jpg','Use freshly grated cheese for better melting and flavor.\r\n\r\nAvoid overfilling the noodles to prevent messy rolls.\r\n\r\nLet the rolls cool slightly before serving to hold their shape.','2025-03-31 11:48:35'),(2,1,'? Strawberry Spoon Cake Recipe','There’s something magical about the aroma of freshly baked cake wafting through the kitchen—especially when it’s a Strawberry Spoon Cake. This delightful dessert combines the juicy sweetness of ripe strawberries with the comforting warmth of a homemade cake. It’s a perfect treat for any occasion—whether you’re hosting a summer gathering, indulging in a cozy evening, or simply satisfying a sweet craving.\r\n\r\nThis Strawberry Spoon Cake is a fuss-free recipe that requires minimal effort but delivers maximum flavor. The batter comes together in minutes, and the strawberries melt into a jammy, luscious layer as the cake bakes to golden perfection. The best part? You can serve it warm straight from the baking dish—no slicing needed—just grab a spoon and dig in!\r\n\r\n? Instructions\r\n✅ Step 1: Prepare the Strawberries\r\nPreheat your oven to 350°F (175°C).\r\n\r\nIn a bowl, toss the sliced strawberries with lemon juice and set aside.\r\n\r\n✅ Step 2: Make the Batter\r\nIn a mixing bowl, whisk together flour, sugar, baking powder, and salt.\r\n\r\nAdd milk, melted butter, and vanilla extract. Stir until smooth.\r\n\r\nPour the batter into a greased baking dish.\r\n\r\n✅ Step 3: Add the Strawberries\r\nEvenly spoon the strawberry mixture over the batter.\r\n\r\nSprinkle 1 tablespoon of sugar over the top for a crispy crust.\r\n\r\n✅ Step 4: Bake to Perfection\r\nBake in the preheated oven for 35-40 minutes, or until the cake is golden brown and a toothpick inserted into the cake (not the fruit) comes out clean.\r\n\r\nLet the cake cool slightly before serving.\r\n\r\n? Serving Suggestions\r\nEnjoy the Strawberry Spoon Cake warm with a scoop of vanilla ice cream or a dollop of whipped cream. The sweetness of the strawberries blends perfectly with the buttery, tender cake, creating a heavenly bite every time!','American','Vegetarian','Easy','uploads/recipe_67ea824a24371.jpg','Use fresh, ripe strawberries for the best flavor.\r\n\r\nSubstitute strawberries with mixed berries for a vibrant twist.\r\n\r\nDrizzle some honey or maple syrup for extra sweetness.\r\n\r\nFor a tangy flavor, add a splash of lemon zest to the batter.','2025-03-31 11:53:46');
/*!40000 ALTER TABLE `recipes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `FailedLoginAttempts` int(11) DEFAULT 0,
  `LockoutTime` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Heinn','Htet','heinn2004@gmail.com','$2y$10$N1Q4.HYlItk7E8n2jemSguhON7uTDbhEuQRKWUe4UtLcOLUot6af.',0,NULL),(2,'Phoenix','Zan','Phoenix123@gmail.com','$2y$10$1yriPz3c4unPueyrvzzOF.DrQxiDs8YqIxMKC40P954q5KFYbB19u',0,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-05 16:05:39
