/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 8.0.35-0ubuntu0.22.04.1 : Database - entrego
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`entrego` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `entrego`;

/*Table structure for table `education` */

DROP TABLE IF EXISTS `education`;

CREATE TABLE `education` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `education` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `job_applications` */

DROP TABLE IF EXISTS `job_applications`;

CREATE TABLE `job_applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_applications` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `man_powers` */

DROP TABLE IF EXISTS `man_powers`;

CREATE TABLE `man_powers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `requested_by` int unsigned NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsibilities` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualifications` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `benefits` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vacancies` int unsigned NOT NULL,
  `job_nature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` date NOT NULL,
  `required_experience` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `approved_by` tinyint(1) DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `quiz_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `man_powers` */

insert  into `man_powers`(`id`,`requested_by`,`job_title`,`job_group`,`description`,`responsibilities`,`qualifications`,`benefits`,`vacancies`,`job_nature`,`location`,`expires_at`,`required_experience`,`department`,`active`,`approved_by`,`approved_on`,`created_at`,`updated_at`,`deleted_at`,`quiz_id`) values (1,1,'IT Assistant','IT','Job Description\r\nJob Description\r\nJob Description','ResponsibilitiesResponsibilitiesResponsibilities','Qualifications\r\nQualifications\r\nQualifications','BenefitsBenefitsBenefits\r\nffasdfas',1,'FULL_TIME','DAVAO','2024-11-12','FRESH','IT_DEPT',1,NULL,NULL,'2023-10-10 14:50:04','2023-11-02 06:49:07',NULL,1),(2,1,'IT Engineer','IT','Blank','Blank','Blank','Blank',1,'FULL_TIME','NCR','2023-10-10','JUNIOR','IT_DEPT',1,NULL,NULL,'2023-11-01 10:23:47','2023-11-01 10:37:35',NULL,1),(3,1,'Web Developer','IT','create and maintain websites.','Responsible for the site\'s technical aspects, such as its performance and capacity, which are measures of a website\'s speed and how much traffic the site can handle. In addition, web developers may create content for the site.','qwe','qwe',1,'PART_TIME','NCR','2024-01-09','JUNIOR','IT_DEPT',0,NULL,NULL,'2023-11-09 05:20:31','2023-11-09 05:20:31',NULL,1);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_10_04_125606_create_work_histories_table',1),(6,'2023_10_04_125824_create_education_table',1),(7,'2023_10_05_063056_create_man_powers_table',1),(8,'2023_10_05_145049_add_soft_deletes_on_users_and_man_powers_table',1),(9,'2023_10_06_050702_create_quizzes_table',1),(10,'2023_10_06_050710_create_user_quizzes_table',1),(11,'2023_10_06_051236_create_quiz_questions__table',1),(12,'2023_10_06_125351_create_personal_assessments_table',1),(13,'2023_10_07_044812_create_user_personal_assessments_table',1),(14,'2023_10_08_093653_add_quiz_id_to_manpowers_table',1),(15,'2023_10_08_100029_create_job_applications_table',1),(16,'2023_10_08_133734_create_user_job_applications_table',1),(17,'2023_10_08_152249_add_zoom_link_to_user_job_applications_table',1),(18,'2023_10_09_061941_create_user_quiz_answers_table',1),(19,'2023_10_09_143447_add_user_quiz_id_to_user_quiz_answers_table',1),(20,'2023_10_09_155013_add_is_passed_column_to_user_quizzes_table',1),(21,'2023_10_10_014221_add_uuid_to_users_table',1),(22,'2023_10_10_014753_add_has_cv_to_users_table',1),(23,'2023_10_11_070103_create_requirements_table',2),(24,'2023_10_11_070414_create_user_requirements_table',2),(25,'2023_10_11_144515_add_timer_to_quiz_table',2),(26,'2023_10_11_151043_add_timer_to_user_quizzes_table',2),(27,'2023_10_12_121708_add_has_finished_assessment_column_to_users_table',2),(28,'2023_10_16_082936_add_user_id_to_work_histories_table',2),(29,'2023_11_02_063419_add_interview_date_time_in_user_job_applications_table',3),(30,'2023_11_06_125916_add_is_archived_to_users_table',4),(31,'2023_11_06_135404_create_jobs_table',4);

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

insert  into `password_reset_tokens`(`email`,`token`,`created_at`) values ('rosalina.estacio@jru.edu','$2y$10$i9S7aSkHsxdxRDBKnUyB.eTY5tVqdpv2/HV54ijX.IbDi.gHMaRgy','2023-11-03 16:00:30');

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `personal_assessments` */

DROP TABLE IF EXISTS `personal_assessments`;

CREATE TABLE `personal_assessments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `position` int unsigned NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reversed` tinyint(1) NOT NULL,
  `trait` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_assessments` */

insert  into `personal_assessments`(`id`,`position`,`question`,`reversed`,`trait`) values (1,1,'Is talkative',0,'E'),(2,2,'Tends to find fault with others',1,'A'),(3,3,' Does a thorough job',0,'C'),(4,4,'Is depressed, blue',0,'N'),(5,5,'Is original, comes up with new ideas',0,'O'),(6,6,'Is reserved ',1,'E'),(7,7,'Is helpful and unselfish with others',0,'A'),(8,8,'Can be somewhat careless',1,'C'),(9,9,'Is relaxed, handles stress well',1,'N'),(10,10,'Is curious about many different things',0,'O'),(11,11,'Is full of energy',0,'E'),(12,12,'Starts quarrels with others',1,'A'),(13,13,'Is a reliable worker',0,'C'),(14,14,'Can be tense',0,'N'),(15,15,'Is ingenious, a deep thinker',0,'O'),(16,16,'Generates a lot of enthusiasm',0,'E'),(17,17,'Has a forgiving nature',0,'A'),(18,18,'Tends to be disorganized',1,'C'),(19,19,'Worries a lot',0,'N'),(20,20,'Has an active imagination',0,'O'),(21,21,'Tends to be quiet',1,'E'),(22,22,'Is generally trusting',0,'A'),(23,23,'Tends to be lazy',1,'C'),(24,24,'Is emotionally stable, not easily upset',1,'N'),(25,25,'Is inventive',0,'O'),(26,26,'Has an assertive personality',0,'E'),(27,27,'Can be cold and aloof',1,'A'),(28,28,'Perseveres until the task is finished',0,'C'),(29,29,'Can be moody',0,'C'),(30,30,'Values artistic, aesthetic experiences',0,'O'),(31,31,'Is sometimes shy, inhibited',1,'E'),(32,32,'Is considerate and kind to almost everyone',0,'A'),(33,33,'Does things efficiently',0,'C'),(34,34,'Remains calm in tense situations',1,'N'),(35,35,'Prefers work that is routine',1,'O'),(36,36,'Is outgoing, sociable',0,'E'),(37,37,'Is sometimes rude to others',1,'A'),(38,38,'Makes plans and follows through with them',0,'C'),(39,39,'Gets nervous easily',0,'N'),(40,40,'Likes to reflect, play with ideas',0,'O'),(41,41,'Has few artistic interests',1,'O'),(42,42,'Likes to cooperate with others',0,'A'),(43,43,'Is easily distracted',1,'C'),(44,44,'Is sophisticated in art, music, or literature',0,'O');

/*Table structure for table `quiz_questions` */

DROP TABLE IF EXISTS `quiz_questions`;

CREATE TABLE `quiz_questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` int unsigned NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `choice_d` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quiz_questions` */

insert  into `quiz_questions`(`id`,`quiz_id`,`question`,`choice_a`,`choice_b`,`choice_c`,`choice_d`,`answer`,`created_at`,`updated_at`) values (1,1,'What 1+1?','5','6','2','4','choice_c',NULL,NULL),(2,1,'What is what?','Ano','Ewan','Di ko sure','Test','choice_a',NULL,NULL),(3,1,'Question #3','aaa','bbb','ccc','dddxxx','choice_d',NULL,NULL),(4,1,'Question #4???','four','three','two','one','choice_a',NULL,NULL),(5,1,'Last question','Tapos na','Next pa','Di ko sure','Wala','choice_a',NULL,NULL);

/*Table structure for table `quizzes` */

DROP TABLE IF EXISTS `quizzes`;

CREATE TABLE `quizzes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int unsigned NOT NULL,
  `has_passing_rate` tinyint(1) NOT NULL,
  `passing_rate` double unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `has_timer` tinyint(1) NOT NULL DEFAULT '0',
  `time_in_seconds` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quizzes` */

insert  into `quizzes`(`id`,`name`,`description`,`job_group`,`created_by`,`has_passing_rate`,`passing_rate`,`deleted_at`,`created_at`,`updated_at`,`has_timer`,`time_in_seconds`) values (1,'Quiz #1','Description.... blah blah','Information Technology',1,1,60,NULL,'2023-10-10 14:46:26','2023-10-10 14:47:04',0,NULL);

/*Table structure for table `requirements` */

DROP TABLE IF EXISTS `requirements`;

CREATE TABLE `requirements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `requirements` */

/*Table structure for table `user_job_applications` */

DROP TABLE IF EXISTS `user_job_applications`;

CREATE TABLE `user_job_applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `man_power_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `rejected_by` int unsigned DEFAULT NULL,
  `accepted_by` int unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applied_at` datetime NOT NULL,
  `interview_sent_at` datetime DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `rejected_reason` text COLLATE utf8mb4_unicode_ci,
  `accepted_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci,
  `interview_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_job_applications` */

insert  into `user_job_applications`(`id`,`man_power_id`,`user_id`,`rejected_by`,`accepted_by`,`status`,`applied_at`,`interview_sent_at`,`rejected_at`,`accepted_at`,`rejected_reason`,`accepted_reason`,`created_at`,`updated_at`,`link`,`interview_date`) values (8,2,6,NULL,NULL,'INTERVIEW_SENT','2023-11-08 11:39:07',NULL,NULL,NULL,NULL,NULL,'2023-11-08 11:39:07','2023-11-09 05:27:10','https://www.google.com/','2023-11-16 05:00:00'),(9,1,6,NULL,NULL,'INTERVIEW_SENT','2023-11-08 11:57:36',NULL,NULL,NULL,NULL,NULL,'2023-11-08 11:57:36','2023-11-10 17:04:48','https://mail.google.com/mail/u/2/#inbox','2023-11-13 17:30:00');

/*Table structure for table `user_personal_assessments` */

DROP TABLE IF EXISTS `user_personal_assessments`;

CREATE TABLE `user_personal_assessments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_question_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extraversion_score` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extraversion_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extraversion_percentage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agreeableness_score` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agreeableness_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agreeableness_percentage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conscientiousness_score` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conscientiousness_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conscientiousness_percentage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `neuroticism_score` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `neuroticism_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `neuroticism_percentage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `openness_score` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `openness_total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `openness_percentage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=749 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_personal_assessments` */

insert  into `user_personal_assessments`(`id`,`personal_question_id`,`user_id`,`answer`,`extraversion_score`,`extraversion_total`,`extraversion_percentage`,`agreeableness_score`,`agreeableness_total`,`agreeableness_percentage`,`conscientiousness_score`,`conscientiousness_total`,`conscientiousness_percentage`,`neuroticism_score`,`neuroticism_total`,`neuroticism_percentage`,`openness_score`,`openness_total`,`openness_percentage`,`batch_id`,`created_at`,`updated_at`) values (1,1,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(2,2,5,'1','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(3,3,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(4,4,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(5,5,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(6,6,5,'1','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(7,7,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(8,8,5,'2','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(9,9,5,'1','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(10,10,5,'3','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(11,11,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(12,12,5,'1','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(13,13,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(14,14,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(15,15,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(16,16,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(17,17,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(18,18,5,'2','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(19,19,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(20,20,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(21,21,5,'1','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(22,22,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(23,23,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(24,24,5,'2','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(25,25,5,'3','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(26,26,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(27,27,5,'2','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(28,28,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(29,29,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(30,30,5,'3','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(31,31,5,'2','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(32,32,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(33,33,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(34,34,5,'3','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(35,35,5,'1','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(36,36,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(37,37,5,'1','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(38,38,5,'3','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(39,39,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(40,40,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(41,41,5,'3','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(42,42,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(43,43,5,'4','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(44,44,5,'5','27','40','68','29','45','64','39','50','78','25','35','71','35','50','70','417224F4-C97A-446F-B78B-3DABC9F71B4B','2023-10-10 14:56:21','2023-10-20 08:07:31'),(45,1,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(46,2,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(47,3,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(48,4,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(49,5,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(50,6,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(51,7,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(52,8,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(53,9,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(54,10,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(55,11,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(56,12,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(57,13,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(58,14,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(59,15,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(60,16,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(61,17,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(62,18,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(63,19,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(64,20,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(65,21,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(66,22,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(67,23,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(68,24,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(69,25,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(70,26,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(71,27,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(72,28,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(73,29,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(74,30,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(75,31,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(76,32,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(77,33,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(78,34,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(79,35,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(80,36,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(81,37,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(82,38,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(83,39,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(84,40,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(85,41,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(86,42,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(87,43,6,'1','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(88,44,6,'5','28','40','70','29','45','64','34','50','68','23','35','66','42','50','84','E8F24EC4-8E3A-4614-99EE-69E78B258D10','2023-10-11 11:26:36','2023-10-20 08:07:46'),(89,1,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(90,2,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(91,3,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(92,4,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(93,5,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(94,6,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(95,7,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(96,8,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(97,9,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(98,10,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(99,11,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(100,12,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(101,13,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(102,14,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(103,15,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(104,16,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(105,17,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(106,18,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(107,19,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(108,20,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(109,21,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(110,22,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(111,23,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(112,24,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(113,25,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(114,26,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(115,27,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(116,28,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(117,29,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(118,30,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(119,31,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(120,32,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(121,33,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(122,34,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(123,35,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(124,36,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(125,37,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(126,38,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(127,39,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(128,40,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(129,41,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(130,42,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(131,43,7,'5','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(132,44,7,'1','20','40','50','25','45','56','26','50','52','19','35','54','18','50','36','6538280C-0425-4BF6-B859-F4F83BC90ECC','2023-10-11 11:34:25','2023-10-20 08:07:59'),(221,1,8,'5','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(222,2,8,'3','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(223,3,8,'2','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(224,4,8,'3','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(225,5,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(226,6,8,'1','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(227,7,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(228,8,8,'1','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(229,9,8,'1','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(230,10,8,'2','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(231,11,8,'5','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(232,12,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(233,13,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(234,14,8,'3','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(235,15,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(236,16,8,'5','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(237,17,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(238,18,8,'3','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(239,19,8,'2','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(240,20,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(241,21,8,'1','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(242,22,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(243,23,8,'3','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(244,24,8,'2','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(245,25,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(246,26,8,'5','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(247,27,8,'2','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(248,28,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(249,29,8,'3','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(250,30,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(251,31,8,'1','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(252,32,8,'3','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(253,33,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(254,34,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(255,35,8,'2','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(256,36,8,'5','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(257,37,8,'2','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(258,38,8,'3','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(259,39,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(260,40,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(261,41,8,'3','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(262,42,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(263,43,8,'2','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(264,44,8,'4','28','40','70','30','45','67','29','50','58','19','35','54','35','50','70','1F9DA930-327B-437A-825D-FCF887D64C42','2023-10-19 14:12:23','2023-10-20 08:08:12'),(617,1,9,'4','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(618,2,9,'2','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(619,3,9,'3','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(620,4,9,'2','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(621,5,9,'4','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(622,6,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(623,7,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(624,8,9,'3','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(625,9,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(626,10,9,'4','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(627,11,9,'4','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(628,12,9,'2','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(629,13,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(630,14,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(631,15,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(632,16,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(633,17,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(634,18,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(635,19,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(636,20,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(637,21,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(638,22,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(639,23,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(640,24,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(641,25,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(642,26,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(643,27,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(644,28,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(645,29,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(646,30,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(647,31,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(648,32,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(649,33,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(650,34,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(651,35,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(652,36,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(653,37,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(654,38,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(655,39,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(656,40,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(657,41,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(658,42,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(659,43,9,'1','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(660,44,9,'5','26','40','65','27','45','60','34','50','68','20','35','57','40','50','80','E2311F71-9A20-4D16-A0A2-5375195F1292','2023-10-21 08:08:48','2023-10-21 08:08:48'),(661,1,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(662,2,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(663,3,10,'5','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(664,4,10,'2','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(665,5,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(666,6,10,'2','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(667,7,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(668,8,10,'2','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(669,9,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(670,10,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(671,11,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(672,12,10,'5','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(673,13,10,'5','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(674,14,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(675,15,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(676,16,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(677,17,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(678,18,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(679,19,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(680,20,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(681,21,10,'2','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(682,22,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(683,23,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(684,24,10,'2','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(685,25,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(686,26,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(687,27,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(688,28,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(689,29,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(690,30,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(691,31,10,'2','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(692,32,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(693,33,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(694,34,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(695,35,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(696,36,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(697,37,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(698,38,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(699,39,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(700,40,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(701,41,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(702,42,10,'4','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(703,43,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(704,44,10,'3','23','40','58','34','45','76','37','50','74','21','35','60','36','50','72','0D204DC0-C0FE-4F78-BFFE-59673F5F4CBE','2023-11-03 15:54:48','2023-11-03 15:54:48'),(705,1,3,'3','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(706,2,3,'3','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(707,3,3,'3','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(708,4,3,'4','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(709,5,3,'4','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(710,6,3,'1','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(711,7,3,'4','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(712,8,3,'2','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(713,9,3,'2','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(714,10,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(715,11,3,'4','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(716,12,3,'2','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(717,13,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(718,14,3,'4','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(719,15,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(720,16,3,'4','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(721,17,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(722,18,3,'1','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(723,19,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(724,20,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(725,21,3,'2','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(726,22,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(727,23,3,'2','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(728,24,3,'1','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(729,25,3,'4','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(730,26,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(731,27,3,'1','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(732,28,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(733,29,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(734,30,3,'4','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(735,31,3,'1','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(736,32,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(737,33,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(738,34,3,'1','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(739,35,3,'2','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(740,36,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(741,37,3,'1','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(742,38,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(743,39,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(744,40,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(745,41,3,'1','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(746,42,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(747,43,3,'1','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43'),(748,44,3,'5','25','40','63','31','45','69','34','50','68','22','35','63','40','50','80','687EA2B4-D7AB-41D3-A354-05F2443A3360','2023-11-06 06:19:43','2023-11-06 06:19:43');

/*Table structure for table `user_quiz_answers` */

DROP TABLE IF EXISTS `user_quiz_answers`;

CREATE TABLE `user_quiz_answers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_quiz_id` int unsigned NOT NULL,
  `quiz_question_id` int unsigned NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_quiz_answers` */

insert  into `user_quiz_answers`(`id`,`user_quiz_id`,`quiz_question_id`,`answer`,`is_correct`,`created_at`,`updated_at`) values (1,1,1,'choice_c',1,'2023-10-10 15:02:05','2023-10-10 15:02:05'),(2,1,2,'choice_a',1,'2023-10-10 15:02:05','2023-10-10 15:02:05'),(3,1,3,'choice_d',1,'2023-10-10 15:02:05','2023-10-10 15:02:05'),(4,1,4,'choice_a',1,'2023-10-10 15:02:05','2023-10-10 15:02:05'),(5,1,5,'choice_d',0,'2023-10-10 15:02:05','2023-10-10 15:02:05'),(6,2,1,'choice_c',1,'2023-11-03 15:56:47','2023-11-03 15:56:47'),(7,2,2,'choice_b',0,'2023-11-03 15:56:47','2023-11-03 15:56:47'),(8,2,3,'choice_a',0,'2023-11-03 15:56:47','2023-11-03 15:56:47'),(9,2,4,'choice_c',0,'2023-11-03 15:56:47','2023-11-03 15:56:47'),(10,2,5,'choice_a',1,'2023-11-03 15:56:47','2023-11-03 15:56:47'),(11,3,1,'choice_c',1,'2023-11-03 15:56:59','2023-11-03 15:56:59'),(12,3,2,'choice_b',0,'2023-11-03 15:56:59','2023-11-03 15:56:59'),(13,3,3,'choice_a',0,'2023-11-03 15:56:59','2023-11-03 15:56:59'),(14,3,4,'choice_c',0,'2023-11-03 15:56:59','2023-11-03 15:56:59'),(15,3,5,'choice_a',1,'2023-11-03 15:56:59','2023-11-03 15:56:59'),(16,4,1,'choice_c',1,'2023-11-06 06:21:01','2023-11-06 06:21:01'),(17,4,2,'choice_c',0,'2023-11-06 06:21:01','2023-11-06 06:21:01'),(18,4,3,'choice_d',1,'2023-11-06 06:21:01','2023-11-06 06:21:01'),(19,4,4,'choice_b',0,'2023-11-06 06:21:01','2023-11-06 06:21:01'),(20,4,5,'choice_a',1,'2023-11-06 06:21:01','2023-11-06 06:21:01'),(21,5,1,'NONE',0,'2023-11-06 06:48:19','2023-11-06 06:48:19'),(22,5,2,'NONE',0,'2023-11-06 06:48:19','2023-11-06 06:48:19'),(23,5,3,'NONE',0,'2023-11-06 06:48:19','2023-11-06 06:48:19'),(24,5,4,'NONE',0,'2023-11-06 06:48:19','2023-11-06 06:48:19'),(25,5,5,'NONE',0,'2023-11-06 06:48:19','2023-11-06 06:48:19'),(26,6,1,'NONE',0,'2023-11-06 06:48:58','2023-11-06 06:48:58'),(27,6,2,'NONE',0,'2023-11-06 06:48:58','2023-11-06 06:48:58'),(28,6,3,'NONE',0,'2023-11-06 06:48:58','2023-11-06 06:48:58'),(29,6,4,'NONE',0,'2023-11-06 06:48:58','2023-11-06 06:48:58'),(30,6,5,'NONE',0,'2023-11-06 06:48:58','2023-11-06 06:48:58');

/*Table structure for table `user_quizzes` */

DROP TABLE IF EXISTS `user_quizzes`;

CREATE TABLE `user_quizzes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int unsigned NOT NULL,
  `score` int unsigned NOT NULL,
  `percentage` int unsigned NOT NULL,
  `is_passed` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_quizzes` */

insert  into `user_quizzes`(`id`,`application_id`,`score`,`percentage`,`is_passed`,`created_at`,`updated_at`,`start_datetime`,`end_datetime`,`status`) values (1,1,4,80,1,'2023-10-10 15:02:05','2023-10-10 15:02:05',NULL,NULL,NULL),(2,5,2,40,0,'2023-11-03 15:56:47','2023-11-03 15:56:47','2023-11-03 15:56:20','2023-11-03 15:56:47',NULL),(3,5,2,40,0,'2023-11-03 15:56:59','2023-11-03 15:56:59','2023-11-03 15:56:32','2023-11-03 15:56:59',NULL),(4,6,3,60,1,'2023-11-06 06:21:01','2023-11-06 06:21:01','2023-11-06 06:20:47','2023-11-06 06:21:01',NULL),(5,7,0,0,0,'2023-11-06 06:48:19','2023-11-06 06:48:19','2023-11-06 06:48:19','2023-11-06 06:48:19',NULL),(6,7,0,0,0,'2023-11-06 06:48:58','2023-11-06 06:48:58','2023-11-06 06:48:34','2023-11-06 06:48:58',NULL);

/*Table structure for table `user_requirements` */

DROP TABLE IF EXISTS `user_requirements`;

CREATE TABLE `user_requirements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `requirement_id` int unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_requirements` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `street` text COLLATE utf8mb4_unicode_ci,
  `landmark` text COLLATE utf8mb4_unicode_ci,
  `city` text COLLATE utf8mb4_unicode_ci,
  `barangay` text COLLATE utf8mb4_unicode_ci,
  `zip_code` text COLLATE utf8mb4_unicode_ci,
  `country` text COLLATE utf8mb4_unicode_ci,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_finished_profile` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci,
  `languages` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cv_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_cv` tinyint(1) NOT NULL DEFAULT '0',
  `has_finished_asessment` tinyint(1) NOT NULL DEFAULT '0',
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  `archived_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`email_verified_at`,`first_name`,`last_name`,`middle_name`,`gender`,`contact_number`,`birthday`,`street`,`landmark`,`city`,`barangay`,`zip_code`,`country`,`role`,`has_finished_profile`,`password`,`skills`,`languages`,`remember_token`,`created_at`,`updated_at`,`deleted_at`,`uuid`,`cv_name`,`has_cv`,`has_finished_asessment`,`is_archived`,`archived_at`) values (1,'admin@thesis.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ADMINISTRATOR',0,'$2y$10$OZ.qfOjt6ToFDtE1i/avmOXa0q481MOpE2zpQn2sLCtGFK1E6sGoS',NULL,NULL,'X3N8xZGcvXMrjESF5uuGbDJE4GVlXd5dObBphVghNjiX9X3gh5m6VcZRGeDR','2023-10-10 08:33:57','2023-10-10 08:33:57',NULL,'869D4DCA-2887-4BFF-9397-868B2D243589',NULL,0,0,0,NULL),(2,'p1@test.com',NULL,'Matthew','Yarte','Middle Name','Male','09194412244','1990-01-01','Street','Landmark','City','Brgy','Zip Code',NULL,'APPLICANT',1,'$2y$10$mW8GNGOr0H645vDkuzbBjOwgViyhVP8AypFPQXm7TyPGYEts4EdRy','SkillsSkillsSkillsSkills','Languages\r\nLanguages\r\nLanguages\r\nLanguages',NULL,'2023-10-10 08:34:11','2023-10-11 03:17:04',NULL,'BBBD9B3F-1E11-41E8-9C51-F57714883E91','BBBD9B3F-1E11-41E8-9C51-F57714883E91.doc',1,0,0,NULL),(3,'angeloyarte@gmail.com',NULL,'Mika','Yarte','angelo','Male','+639958606492','2002-05-23','East rembo','Buting','Makati city','East Rembo','1216',NULL,'APPLICANT',1,'$2y$10$nLtz7yvvT1tc52FvycHDQOI.mmL6MZVqgNoXTKovDfQsmG2vE3ngm',NULL,NULL,'XLal17X3twoAVAFVyCp7ardDZGpHtqea3t2cBFbwpT2QHszT9XL9hynwuRXq','2023-10-10 14:30:38','2023-11-06 06:50:39',NULL,'75752E93-3679-4B86-8B03-302E530DE313',NULL,0,1,0,NULL),(4,'lauronharvs@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'APPLICANT',0,'$2y$10$S.ipyigjmFJsEtahVyU5C.ODVnXMZoyHFbVlu9t1MIrx05lCWTU2q',NULL,NULL,NULL,'2023-10-10 14:33:23','2023-10-10 14:33:23',NULL,'5C8F8A64-76F8-46F9-B4CC-AB715573A148',NULL,0,0,1,'2023-02-23 21:37:32'),(5,'p2@test.com',NULL,'Person2','Person2LName','Person2MName','Male','09191234567','1990-01-01','Street','Landmark','City','Brgy','Zip Code',NULL,'APPLICANT',1,'$2y$10$OZ.qfOjt6ToFDtE1i/avmOXa0q481MOpE2zpQn2sLCtGFK1E6sGoS','SkillsSkillsSkillsSkills','LanguagesLanguagesLanguages',NULL,'2023-10-10 14:52:04','2023-10-10 14:53:50',NULL,'A05227BA-3CF7-4054-9373-5F1DD94A3018','A05227BA-3CF7-4054-9373-5F1DD94A3018.doc',1,0,1,'2023-05-16 21:37:32'),(6,'shakdartgroup@gmail.com',NULL,'Matthew','Pimentel','Jaymie','Male','09064665798','1990-12-12','123','123','123','123','123',NULL,'APPLICANT',1,'$2y$10$sygfhgB2Yimt7SqHiVvsGu0cmZemoic5j988agHfbBIU1.4iUoV2u',NULL,NULL,'qbAn5xd1JP9ZNJ9NdTr01do46vzybBJzorfnL5SxqnCZjsjO2Dimr1ZkwKgd','2023-10-11 11:21:10','2023-11-10 16:01:41',NULL,'0A7FB4F8-F258-4D43-875B-78D2605AD4F1','0A7FB4F8-F258-4D43-875B-78D2605AD4F1.docx',1,0,0,NULL),(7,'thesisentrego@gmail.com',NULL,'qwe','qwe','qwe','Male','09661234555','2000-12-22','123','123','123','123','123',NULL,'APPLICANT',1,'$2y$10$ht6tnJelYJFScOHkcaDSpO/M5igXxzj6mnOsUOro.GWjznA3ZX87G',NULL,NULL,NULL,'2023-10-11 11:31:28','2023-10-11 11:32:41',NULL,'1FE9974F-363A-4696-8F89-D60C323F7D34','1FE9974F-363A-4696-8F89-D60C323F7D34.pdf',1,0,0,NULL),(8,'chauncey.gabriell@free2ducks.com',NULL,'John','Doe','Middle Name','Male','09621476773','1990-10-17','639621476773','639621476773','639621476773','639621476773','639621476773',NULL,'APPLICANT',1,'$2y$10$okyb1QUev085lg2m/ZQzUuv2.Sg7bbZQQCU2k42SdRtt99JEWeqgW','639621476773639621476773','639621476773639621476773639621476773',NULL,'2023-10-19 13:08:43','2023-10-19 14:16:45',NULL,'A688292A-28EE-45AE-9231-45768C7F2460','A688292A-28EE-45AE-9231-45768C7F2460.docx',1,1,0,NULL),(9,'lauronharvey3@gmail.com',NULL,'Harvey','Lauron','Bataan','Male','09287513094','1998-03-03','2-B Gen Luna St.','Vista Mall','Taguig City','Calzalda','1603',NULL,'APPLICANT',1,'$2y$10$ajMOHcIqViOtoE3npZSqjOV6z90cTe81pMoxgNcEdWwyCpzr49vr6',NULL,NULL,NULL,'2023-10-21 07:36:19','2023-10-21 08:08:48',NULL,'3175094B-15F8-4B88-961E-8E5FAF441A5E','',0,1,1,'2023-04-28 21:37:32'),(10,'rosalina.estacio@jru.edu',NULL,'sally','estacio','R','Female','12345678','2001-01-01','X','X','Mandaluyong','X','1551',NULL,'APPLICANT',1,'$2y$10$yN5bghQRvfoVQ71ZOVS7aOloiKjMUNlQj/cFLRpBm9h9VeVy7Wbfi',NULL,NULL,NULL,'2023-11-03 15:46:40','2023-11-03 15:54:48',NULL,'550047C1-1543-4DCC-8D58-440BA6E18166','',0,1,1,'2023-04-29 21:37:32'),(11,'harvslauron9@gmail.com',NULL,'Harvey1','Lauron','Bataan1','Male','09265275966','1998-03-03','Gen Luna','Shell','Taguig','Ususan','1603',NULL,'APPLICANT',1,'$2y$10$57czQiBE.ga2JRlIf6VoUubOeXzFa7jZ3Fw2Zqs/vjl32Li4UjjIO',NULL,NULL,NULL,'2023-11-08 11:23:45','2023-11-08 11:27:42',NULL,'F22C276E-E618-4641-B1AE-7758E38A05C7','',0,0,0,NULL),(12,'randallmira73@gmail.com',NULL,'Randall Antoine','Mira','Peralta','Male','09999109899','2002-07-24','1021 Taniman Ave. NAPICO Manggahan Pasig City','House','Pasig','Manggahan','1611',NULL,'APPLICANT',1,'$2y$10$fPJrbGb0TfW.TrLlOMwObe4snbB.IJQLyYPCik2WtxymOWcBMKUoS',NULL,NULL,NULL,'2023-11-08 11:39:47','2023-11-08 11:40:31',NULL,'B6CAF2DB-1761-48B2-BA7F-B25A7F69DC69','',0,0,0,NULL),(13,'justinetindugan09@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'APPLICANT',0,'$2y$10$b1UoFm9l/hP8MPt/3WNG2u4zsI.cdkxK.bXG4UEyUy4opLRHu4Cle',NULL,NULL,'26J1aEj7attuya4yI9ZMg9vVI6Hnsm8rutipHm2qlUgU3O9lSMnYQedARUsT','2023-11-09 12:26:27','2023-11-09 12:26:27',NULL,'002B7928-114C-44C9-B6BC-E5ED593B5729','',0,0,0,NULL);

/*Table structure for table `work_histories` */

DROP TABLE IF EXISTS `work_histories`;

CREATE TABLE `work_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accomplishments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `work_histories` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
