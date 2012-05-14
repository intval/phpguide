-- phpMyAdmin SQL Dump


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";




--
-- Database: `phpguide`
--

DROP FUNCTION IF EXISTS `pointsToAddAfterBlogUpdate`;
DROP PROCEDURE IF EXISTS `pointsToAddAfterBlogUpdate`;
DELIMITER $$
--
-- Functions
--

CREATE PROCEDURE `pointsToAddAfterBlogUpdate`(IN oldApprovalStatus TINYINT, IN newApprovalStatus TINYINT, OUT pointsToChange INT) DETERMINISTIC NO SQL SQL SECURITY INVOKER
BEGIN



	DECLARE r INT(10);

        

        IF oldApprovalStatus = newApprovalStatus THEN SET r = 0;

        ELSEIF oldApprovalStatus > 0 AND newApprovalStatus = 0 THEN SET r = -20;

        ELSE SET r = 20;

        END IF;

        

        SET pointsToChange = r;



  END$$

DELIMITER ;


-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `url` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `html_desc_paragraph` text NOT NULL,
  `html_content` text NOT NULL,
  `pub_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keywords` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  `approved` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `author_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Triggers `blog`
--
DROP TRIGGER IF EXISTS `blog_ondelete`;
DELIMITER //
CREATE TRIGGER `blog_ondelete` AFTER DELETE ON `blog`
 FOR EACH ROW BEGIN

	IF OLD.approved > 0 THEN BEGIN

        	DECLARE pointsAddition INT(10);

			CALL pointsToAddAfterBlogUpdate( OLD.approved, 0 , pointsAddition);

        	UPDATE users SET points = points + pointsAddition WHERE id = OLD.author_id;

        END; END IF;

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `blog_oninsert`;
DELIMITER //
CREATE TRIGGER `blog_oninsert` AFTER INSERT ON `blog`
 FOR EACH ROW BEGIN

	DECLARE pointsAddition INT(10);

		CALL pointsToAddAfterBlogUpdate( 0, NEW.approved,  pointsAddition);

        IF pointsAddition != 0 THEN BEGIN

        	UPDATE users SET points = points + pointsAddition WHERE id = NEW.author_id;

        END; END IF;

        

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `blog_onupdate`;
DELIMITER //
CREATE TRIGGER `blog_onupdate` AFTER UPDATE ON `blog`
 FOR EACH ROW BEGIN

	DECLARE pointsAddition INT(10);

	SET pointsAddition = pointsToAddAfterBlogUpdate( OLD.approved, NEW.approved );

        IF pointsAddition != 0 THEN BEGIN

        	UPDATE users SET points = points + pointsAddition WHERE id = NEW.author_id;

        END; END IF;

        

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blogid` smallint(5) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `postingip` varchar(15) NOT NULL,
  `author` varchar(25) NOT NULL,
  `text` text NOT NULL,
  `approved` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `date` (`date`),
  KEY `postingip` (`postingip`),
  KEY `blogid` (`blogid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_likes`
--

CREATE TABLE IF NOT EXISTS `blog_likes` (
  `ip` varchar(32) NOT NULL,
  `postid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `like` tinyint(1) DEFAULT NULL COMMENT 'Either 1 or -1',
  PRIMARY KEY (`ip`,`postid`),
  KEY `blogid2blogs` (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_plain`
--

CREATE TABLE IF NOT EXISTS `blog_plain` (
  `id` mediumint(9) NOT NULL,
  `plain_description` text NOT NULL,
  `plain_content` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `plain_content` (`plain_content`,`plain_description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blog_post2cat`
--

CREATE TABLE IF NOT EXISTS `blog_post2cat` (
  `postid` smallint(5) unsigned NOT NULL,
  `catid` int(10) unsigned NOT NULL,
  KEY `catid` (`catid`),
  KEY `postid` (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `code_tinyurl`
--

CREATE TABLE IF NOT EXISTS `code_tinyurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `checksum` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `password_recovery`
--

CREATE TABLE IF NOT EXISTS `password_recovery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned DEFAULT NULL,
  `key` varchar(20) NOT NULL,
  `validity` datetime NOT NULL,
  `ip` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user2users` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `qna_answers`
--

CREATE TABLE IF NOT EXISTS `qna_answers` (
  `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `authorid` bigint(20) unsigned NOT NULL,
  `qid` bigint(20) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bb_text` text,
  `html_text` text NOT NULL,
  PRIMARY KEY (`aid`),
  KEY `authorid` (`authorid`),
  KEY `qid` (`qid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Triggers `qna_answers`
--
DROP TRIGGER IF EXISTS `qna_answers_ondelete`;
DELIMITER //
CREATE TRIGGER `qna_answers_ondelete` AFTER DELETE ON `qna_answers`
 FOR EACH ROW BEGIN

			UPDATE qna_questions SET answers = answers -1, last_activity = 

		 	COALESCE((SELECT MAX(time) FROM qna_answers WHERE qna_answers.qid = OLD.qid), qna_questions.time)

			WHERE qna_questions.qid = OLD.qid;

                        UPDATE users SET points = points - 1 WHERE id = OLD.authorid;

		END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `qna_answers_oninsert`;
DELIMITER //
CREATE TRIGGER `qna_answers_oninsert` AFTER INSERT ON `qna_answers`
 FOR EACH ROW BEGIN

		UPDATE qna_questions SET answers = answers +1, last_activity = NOW() WHERE qna_questions.qid = NEW.qid;

                UPDATE users SET points = points + 1 WHERE id = NEW.authorid;

		END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `qna_questions`
--

CREATE TABLE IF NOT EXISTS `qna_questions` (
  `qid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `bb_text` text NOT NULL,
  `html_text` text,
  `authorid` bigint(20) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','locked','hidden') NOT NULL DEFAULT 'active',
  `views` smallint(6) unsigned DEFAULT '0',
  `answers` smallint(6) unsigned DEFAULT '0',
  `last_activity` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`qid`),
  KEY `authorid` (`authorid`),
  KEY `iLast_answer_time` (`last_activity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Triggers `qna_questions`
--
DROP TRIGGER IF EXISTS `qna_question_ondelete`;
DELIMITER //
CREATE TRIGGER `qna_question_ondelete` AFTER DELETE ON `qna_questions`
 FOR EACH ROW BEGIN

	update users set points = points - 2 where id = OLD.authorid;

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `qna_question_oninsert`;
DELIMITER //
CREATE TRIGGER `qna_question_oninsert` AFTER INSERT ON `qna_questions`
 FOR EACH ROW BEGIN

	UPDATE users SET points = points + 1 WHERE id = NEW.authorid;

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `unauth`
--

CREATE TABLE IF NOT EXISTS `unauth` (
  `ip` varchar(15) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `ip` (`ip`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(64) NOT NULL COMMENT 'Display name',
  `real_name` varchar(64) DEFAULT NULL,
  `last_visit` timestamp NULL DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT NULL,
  `ip` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(22) NOT NULL,
  `fbid` varchar(30) DEFAULT NULL,
  `googleid` varchar(100) DEFAULT NULL,
  `twitterid` varchar(30) DEFAULT NULL,
  `points` smallint(11) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`blogid`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_likes`
--
ALTER TABLE `blog_likes`
  ADD CONSTRAINT `blogid2blogs` FOREIGN KEY (`postid`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_post2cat`
--
ALTER TABLE `blog_post2cat`
  ADD CONSTRAINT `blog_post2cat_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_post2cat_ibfk_2` FOREIGN KEY (`catid`) REFERENCES `blog_categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_recovery`
--
ALTER TABLE `password_recovery`
  ADD CONSTRAINT `user2users` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `qna_answers`
--
ALTER TABLE `qna_answers`
  ADD CONSTRAINT `qna_answers_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `qna_questions` (`qid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `qna_answers_ibfk_2` FOREIGN KEY (`authorid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `qna_questions`
--
ALTER TABLE `qna_questions`
  ADD CONSTRAINT `qna_questions_ibfk_1` FOREIGN KEY (`authorid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



  
  
  
  

INSERT INTO `blog_categories` (`cat_id`, `name`) VALUES
(6, 'JS צד לקוח'),
(3, 'mysql'),
(7, 'אבטחה'),
(1, 'ביצועים ואופטימיזציה'),
(11, 'כלים שימושיים'),
(14, 'כנסים והרצאות'),
(2, 'מבנה הסקריפט'),
(13, 'מדריכי YII'),
(12, 'נושאים כלליים'),
(10, 'פתרונות נפוצים'),
(9, 'רשת ופרוטוקולים'),
(4, 'שליחת אימייל ב-PHP'),
(5, 'שרתים apache wamp'),
(8, 'תמונות וגרפיקה');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `real_name`, `last_visit`, `reg_date`, `ip`, `email`, `password`, `salt`, `fbid`, `googleid`, `twitterid`, `points`, `is_admin`) VALUES
(1, 'admin', 'Julius Administratorus', '1970-01-01 00:00:01', '1970-01-01 00:00:01', '127.0.0.1', 'admin@localhost', '$2a$06$abcabcabcabcabcabcabcO67uPHzHvftukncfCrskwpUd3yffAJKq', 'abcabcabcabcabcabcabca', NULL, NULL, NULL, 0, 1);
  