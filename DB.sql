-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2012 at 01:07 PM
-- Server version: 5.5.18
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `test`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=141 ;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `url`, `image`, `html_desc_paragraph`, `html_content`, `pub_date`, `keywords`, `description`, `approved`, `author_id`) VALUES
(17, 'mvc: מפרידים html מ-php', 'mvc_מפרידים_html_מ_php', 'http://ncdn.phpguide.co.il/blogimages/mvc.jpg', 'כל מערכת מורכבת משלושה חלקים: הנתונים, העיצוב שבו הם מוצגים<br />והמנגן של התזמורת, זה שמחליט איזה נתונים ובאיזה עיצוב להציג.', 'יש משהו קטן ומעצבן שהורס כל קוד והוא דווקא ה-html. בגללו נגרמים סירבולים מיותרים של סוגריים מסולסלות, פתיחות וסירות תגי php והרבה קטעים בלתי קשורים מפריעים לעין והבנת הקוד.<br /><br />בפוסט הזה אני רוצה להכיר לכם את ההפרדה בין php לבין כל מה שמסביבו.  נראה איך אנחנו מפיקים את המרב מתבנית העיצוב Model-Viewer-Controller ומה זה הדינוזאור הזה בכלל.<br /><br /><br /><h3> מה זה MVC: Model Viewer Controller ?</h3><br /><br />		בואו נסתכל רגע על התוכנה שלנו ונפשט אותה מעת. <br /><br />		אנחנו צריכים לקבל נתון מהלקוח, לעשות איתו משהו ולהציג תוצאה כלשהי בתוך עיצוב כלשהו. למשל, כדי להציג את העמוד הספציפי הזה, הסקריפט היה צריך לקבל מאיתנו את שם העמוד המבוקש, לשלוף את תוכנו מהמסד ולהציג אותו בעיצוב של האתר.<br /><br />		מה היה קורה אילו היינו מבקשים עמוד אחר? הסקריפט היה צריך לקבל את שם העמוד, לשלוף תוכן שונה הפעם, אבל להציג באותו עיצוב. ואם הייתם מבצעים חיפוש באתר, הפעם היה נכנס לפעולה סריפט אחר שעושה חיפוש במסד, אבל עדיין מציג הכל באותו עיצוב.<br /><br /><br />העיצוב הקבוע הוא המודל — תבנית בה מוצגים הנתונים. המודל זהה לרוב העמודים באתר לכן נוציא אותו החוצה מהסקריפט עצמו לקובץ נפרד. דוגמה?<br /><br />	<h3>שעון ה-MVC שלנו</h3><h5>model: תבנית הצגה</h5><br /><br />		בואו נבנה סקריפט שמציג את השעה בתוך תבנית עיצוב קבוע.<br />		את התבנית שלנו באופן קבוע ירכיבו שני אלמנטים. ברכת שלום למשתמש והשעה עצמה.<br />		עמוד שלנו נראה קבוע ואפשר להוציא המודל שלו לקובץ html נפרד שיראה בערך ככה:<br /><br />	<div class="php codeblock"><span class="sy0">&lt;</span>html<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;</span>body bgcolor<span class="sy0">=</span><span class="st0">&quot;green&quot;</span><span class="sy0">&gt;</span><br />\n<br />\nHi Mr<span class="sy0">.</span> Neo<span class="sy0">&lt;</span>br<span class="sy0">/&gt;</span><br />\nThe <span class="kw3">current</span> <span class="kw3">time</span> is<span class="sy0">:</span> <span class="nu8">01</span><span class="sy0">:</span><span class="nu0">37</span><br />\n<br />\n<span class="sy0">&lt;/</span>body<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;/</span>html<span class="sy0">&gt;</span></div><br /><br />	<h5>controller: מה השעה אדוני המבקר</h5><br /><br />		הקונטרולר (בקר בעברית) אחראי על הפעולות והתוכן שאנחנו צריכים. לדוגמה האתר שלנו פשוט מציג את השעה — אזי המטרה של הקונטרולר היא לחשב את השעה. כאן בעצם נמצא הסקריפט הפועל שיש להפריד מה-html . הקוד שעושה את העבודה שלנו.<br /><br />	<div class="php codeblock"><span class="kw2">&lt;?php</span> <br />\n<br />\n<span class="co1">// יוצרים את התוכן</span><br />\n<span class="re0">$time</span> <span class="sy0">=</span> <span class="kw3">date</span><span class="br0">&#40;</span><span class="st0">&quot;H:i&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="re0">$name</span> <span class="sy0">=</span> <span class="st0">&quot;Mr. Neo&quot;</span><span class="sy0">;</span></div><br /><br />	<h5>Viewer: מציג את הכל ביחד</h5><br /><br />		החלק אחרון של המשוואה מחבר את כל החלקים ביחד. כאן נכנס סקריפט נוסף לפעולה האחראי על הצגת התוצאה. תכירו, מר viewer .<br /><br />		המטרה שלו, היא להכניס את התוכן שיצר הקונטרולר במקום המיועד לו במודל. כדי להקל עליו בפעולתו, אנחנו נשנה מאט את מבנה המודל בצוראה הבאה:<br /><br /><div class="php codeblock"><span class="sy0">&lt;</span>html<span class="sy0">&gt;</span><br />\n<br />\n<span class="sy0">&lt;</span>body bgcolor<span class="sy0">=</span><span class="st0">&quot;green&quot;</span><span class="sy0">&gt;</span><br />\n<br />\nHi <span class="br0">&#123;</span><span class="br0">&#123;</span> name <span class="br0">&#125;</span><span class="br0">&#125;</span><span class="sy0">.&lt;</span>br<span class="sy0">/&gt;</span><br />\nThe <span class="kw3">current</span> <span class="kw3">time</span> is<span class="sy0">:</span> <span class="br0">&#123;</span><span class="br0">&#123;</span> <span class="kw3">time</span> <span class="br0">&#125;</span><span class="br0">&#125;</span><br />\n<br />\n<span class="sy0">&lt;/</span>body<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;/</span>html<span class="sy0">&gt;</span></div><br /><br />			עכשיו כל מה שעלינו לעשות, זה להגיד ל-viewer שלנו לקחת את הנתונים שיצר הקונטרולר ולהציב אותם במקום המתאים במודל באמצעות החלפת מחרוזות פשוטה באופן הבא:<br /><br /><div class="php codeblock"><span class="kw2">&lt;?php</span> <br />\n<span class="re0">$output</span> <span class="sy0">=</span> <span class="kw3">str_replace</span><br />\n<span class="br0">&#40;</span><br />\n&nbsp; &nbsp; <span class="kw3">Array</span><span class="br0">&#40;</span> <span class="st0">&quot;{{ name }}&quot;</span><span class="sy0">,</span> <span class="st0">&quot;{{ time }}&quot;</span> <span class="br0">&#41;</span><span class="sy0">,</span> <br />\n&nbsp; &nbsp; <span class="kw3">Array</span><span class="br0">&#40;</span><span class="re0">$name</span> <span class="sy0">,</span> <span class="re0">$time</span><span class="br0">&#41;</span><span class="sy0">,</span> <br />\n&nbsp; &nbsp; <span class="re0">$model</span><br />\n<span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br />	<h3>שלושת חלקי ה-MVC יחדיו</h3><br />controller - index.php<br /><div class="php codeblock"><span class="kw2">&lt;?php</span> <br />\n<br />\n<span class="co1">// יוצרים את התוכן</span><br />\n<span class="re0">$time</span> <span class="sy0">=</span> <span class="kw3">date</span><span class="br0">&#40;</span><span class="st0">&quot;d/m/y H:i:s&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span> <br />\n<span class="re0">$name</span> <span class="sy0">=</span> <span class="st0">&quot;אליהו הנביא&quot;</span><span class="sy0">;</span></div><br />	<br />viewer.php	<br /><div class="php codeblock"><span class="re0">$output</span> <span class="sy0">=</span> <span class="kw3">str_replace</span><br />\n<span class="br0">&#40;</span><br />\n&nbsp; &nbsp; <span class="kw3">Array</span><span class="br0">&#40;</span> <span class="st0">&quot;{{ name }}&quot;</span><span class="sy0">,</span> <span class="st0">&quot;{{ time }}&quot;</span> <span class="br0">&#41;</span><span class="sy0">,</span> <br />\n&nbsp; &nbsp; <span class="kw3">Array</span><span class="br0">&#40;</span><span class="re0">$name</span> <span class="sy0">,</span> <span class="re0">$time</span><span class="br0">&#41;</span><span class="sy0">,</span> <br />\n&nbsp; &nbsp; <span class="re0">$model</span><br />\n<span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br />model.htm<br /><div class="php codeblock"><span class="sy0">&lt;</span>html<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;</span>body bgcolor<span class="sy0">=</span><span class="st0">&quot;green&quot;</span><span class="sy0">&gt;</span><br />\n<br />\nHi <span class="br0">&#123;</span><span class="br0">&#123;</span> name <span class="br0">&#125;</span><span class="br0">&#125;</span><span class="sy0">.</span> <span class="sy0">&lt;</span>br<span class="sy0">/&gt;</span><br />\nThe <span class="kw3">current</span> <span class="kw3">time</span> is<span class="sy0">:</span> <span class="br0">&#123;</span><span class="br0">&#123;</span> <span class="kw3">time</span> <span class="br0">&#125;</span><span class="br0">&#125;</span><br />\n<br />\n<span class="sy0">&lt;/</span>body<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;/</span>html<span class="sy0">&gt;</span></div><br /><br />לרוב ישמש ה-controller כנקודת כניסה לסקריפט. בפניה אליו ייצור ה-controller את התוכן המתאים לאותו עמוד ויגרום ל-viewer להכניס אותו ל-model המתאים.<br /><br /><h4>מסדרים הכל ביחד</h4><br />		כאשר אנחנו פונים לindex.php הוא יוצר את התוכן. עכשיו עלינו לקרוא ל-viewer כדי שיציב את הערכים החדשים בדוגמנית (model) שלנו. נעשה include לקובץ ה-viewer שלנו. אבל לפני שהוא מבצע את העבודה שלו, עלינו להגדיר לו את משתנה הmodel. זה מה שיצא:<br /><br /><div class="php codeblock"><span class="kw2">&lt;?php</span><br />\n<span class="re0">$time</span> <span class="sy0">=</span> <span class="kw3">date</span><span class="br0">&#40;</span><span class="st0">&quot;d/m/y H:i:s&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="re0">$name</span> <span class="sy0">=</span> <span class="kw3">rand</span><span class="br0">&#40;</span><span class="nu0">1</span><span class="sy0">,</span><span class="nu0">100</span><span class="br0">&#41;</span> <span class="sy0">;</span> <span class="co1">//o</span><br />\n<br />\n<span class="co1">// הכנסת המודל למשתנה </span><br />\n<span class="re0">$model</span> <span class="sy0">=</span> <span class="kw3">file_get_contents</span><span class="br0">&#40;</span><span class="st_h">''model.htm''</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<br />\n<span class="co1">// קריא ל- viewer</span><br />\n<span class="kw1">include</span> <span class="st_h">''viewer.php''</span><span class="sy0">;</span><br />\n<br />\n<span class="co1">// הצגת הפלט</span><br />\n<span class="kw1">echo</span> <span class="re0">$output</span><span class="sy0">;</span></div><br />נסו להפעיל את הקוד הזה ולהבין את אופן פעולתו.<br /><br />	<h3>מערכת mvc יותר מתקדמת</h3><br /><br />כדי שהמערכת תהיה רחבה יותר ותתאים לשלל עמודים שונים, נרצה לבנות viewer משוכלל יותר, שיידע לעבוד עם כל תבנית וכל משתנה שיועבר אליו.<br /> נשכתב מעט את ה-viewer הזה כדי שלא יהיה תלוי בקונטרולר ובמשתנים שבו.<br /><br /><em>האות A בהערות נמצאת שם ליישור הקוד לשמאל ולא מסמלתדבר</em><br /><div class="php codeblock"><span class="kw2">&lt;?php</span><br />\n<span class="kw2">function</span> viewer<span class="br0">&#40;</span> <span class="re0">$params</span><span class="sy0">,</span> <span class="re0">$model</span> <span class="br0">&#41;</span><br />\n<span class="br0">&#123;</span><br />\n&nbsp; &nbsp; <span class="co1">// A נבדוק שקובץ עם התבנית קיים וניתן לקריאה</span><br />\n&nbsp; &nbsp; <span class="kw1">if</span><span class="br0">&#40;</span><span class="sy0">!</span><span class="kw3">file_exists</span><span class="br0">&#40;</span><span class="re0">$model</span><span class="br0">&#41;</span> <span class="sy0">||</span> <span class="sy0">!</span><span class="kw3">is_readable</span><span class="br0">&#40;</span><span class="re0">$model</span><span class="br0">&#41;</span><span class="br0">&#41;</span> <br />\n&nbsp; &nbsp; <span class="br0">&#123;</span><br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="kw1">echo</span> <span class="st0">&quot;Error: failed to load the template <span class="es4">$model</span>&quot;</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="kw1">return</span> <span class="kw4">false</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; <span class="br0">&#125;</span><br />\n<br />\n&nbsp; &nbsp; <span class="co1">// A אם כן - נתען אותו לזכרון</span><br />\n&nbsp; &nbsp; <span class="re0">$model</span> <span class="sy0">=</span> <span class="kw3">file_get_contents</span><span class="br0">&#40;</span><span class="re0">$model</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n&nbsp; &nbsp;<br />\n&nbsp; &nbsp; <span class="co1">// A נקבל את רשימת שמות המשתנים</span><br />\n&nbsp; &nbsp; <span class="re0">$keys</span> <span class="sy0">=</span> <span class="kw3">array_keys</span><span class="br0">&#40;</span><span class="re0">$params</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; <br />\n&nbsp; &nbsp; <span class="co1">// A נוסיף לכל אחד מהם את סימון המשתנה שלנו</span><br />\n&nbsp; &nbsp; <span class="kw1">for</span><span class="br0">&#40;</span> <span class="re0">$i</span> <span class="sy0">=</span> <span class="nu0">0</span><span class="sy0">;</span> <span class="re0">$i</span> <span class="sy0">&lt;</span> <span class="kw3">sizeof</span><span class="br0">&#40;</span><span class="re0">$keys</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="re0">$i</span><span class="sy0">++</span><span class="br0">&#41;</span> <br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="re0">$keys</span><span class="br0">&#91;</span><span class="re0">$i</span><span class="br0">&#93;</span> <span class="sy0">=</span> <span class="st_h">''{{ ''</span><span class="sy0">.</span><span class="re0">$keys</span><span class="br0">&#91;</span><span class="re0">$i</span><span class="br0">&#93;</span><span class="sy0">.</span><span class="st_h">'' }}''</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; <br />\n&nbsp; &nbsp; <span class="co1">// A נבצע את ההצבה של המשתנים במודל</span><br />\n&nbsp; &nbsp; <span class="kw1">return</span> <span class="kw3">str_replace</span><span class="br0">&#40;</span> <span class="re0">$keys</span><span class="sy0">,</span> <span class="re0">$params</span><span class="sy0">,</span> <span class="re0">$model</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="br0">&#125;</span></div><br /><br />		עכשיו אנחנו יכולים להשתמש בו גם עם קונטרולרים ומודלים אחרים.<br />יהיה עלינו רק לרשום את שמות המשתנים בתבנית באותו אופן (בתוך זוג סוגריים מסולסלות) ולדאוג שהבקר של אותו עמוד הכן ייצור את המשתנים הללו.<br /><div class="php codeblock"><span class="kw2">&lt;?php</span><br />\n<br />\n<span class="co1">//A יוצרים את התוכן</span><br />\n<span class="re0">$data</span> <span class="sy0">=</span> <span class="kw3">Array</span><span class="br0">&#40;</span> <span class="st_h">''time''</span> <span class="sy0">=&gt;</span> &nbsp;<span class="kw3">date</span><span class="br0">&#40;</span><span class="st0">&quot;d/m/y H:i:s&quot;</span><span class="br0">&#41;</span> <span class="sy0">,</span> &nbsp;<span class="st_h">''name''</span> <span class="sy0">=&gt;</span><span class="st0">&quot;אליהו הנביא&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<br />\n<span class="co1">//A מחברים את הviewer</span><br />\n<span class="kw1">include</span> <span class="st_h">''viewer.php''</span><span class="sy0">;</span><br />\n<br />\n<span class="co1">// A מדפיסים את התוצאה</span><br />\n<span class="kw1">echo</span> viewer <span class="br0">&#40;</span> <span class="re0">$data</span><span class="sy0">,</span> <span class="st_h">''model.htm''</span> <span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br />		אבל מה קורה אם אנחנו רוצים עוד אפשרויות? מה אם אנחנו רוצים להציג בלוקים שלמים של תוכן תלוי במשתנה? מה אם אנחנו רוצים להצי תוכן כלשהו בלולאה ועדיין להשאיר את ה-html מחוץ לקוד ה-php .<br /><br />		במקרים האלה אנחנו נצטרך לפתח viewer חזק יותר, עם יותר אפשרויות שיודע לענות ליותר דרישות. אבל במקום שנבזבז את הזמן שלנו על זה, למה שלא נשתמש במשהו מוכן? בכתבה הבאה אני יספר לכם על <a href="http://twig-project.org">Twig-project</a> , ה-template engine שיצר והציג את העמוד הזה.', '2010-09-30 20:28:30', 'php mvc, mvc, php', 'מפרידים בין html ל-php באמצעות דפוס ה-mvc', 1, 1),
(20, 'UTF-8: קידוד וסימני שאלה', 'UTF_8_קידוד_וסימני_שאלה', 'http://cdn.instructables.com/FNV/Q7RA/FDYPTDBD/FNVQ7RAFDYPTDBD.SQUARE.jpg', 'אם הופיעו לכם סימני שאלה וציורים סיניים במקום עברית העמוד, פנו למדריך הזה לעזרה וטפלו במושג שנקרא קידוד אחת ולתמיד.', 'מה, הוא מטומטם? למה הוא מציג לי סימני שאלה וג&#039;יבריש במקום עברית?<br />הסיבה לסימני השאלה האלה תמונה במילה לא ברורה ושמה קידוד. קידוד, הוא האופן שבו שומר המחשב אצלו את תווי הטקסט שמהם מורכבת המחרוזת. אבל לפעמים, הוא לא כל כך מצליח.<br /><br /><br /><h3>מה לי ולקידוד?</h3><br />הרבה מאוד שפות מדוברות מסביב לכדור הארץ וכמעט כל אחת מהן מוצאת את עצמה על גבי מסכי המחשב. בכל שפה אותיות שונות, נראות שונה, נכתבות שונה ויוצרות בעיות שמירה שונות.<br /><br />בעבר שמרו כל תו (אות) כbyte אחד בזכרון. מכיוון שכל byte היה מורכב משמונה bitים, היו סה&quot;כ 255 אותיות שהמחשב ידע לעבוד איתם. כאן להיסטוריה נכנסה המצאה גאונית שנקראה - קידוד. קידוד היה אוסף של 255 אותיות שאיתו המחשב היה עובד. <br /><br />בקידוד אחד את 255 התווים האלה תפסו אנגלית, רוסית וספרות. (cp1251)<br />קידוד אחר היה מורכב מ255 תווים שהיו לאנגלית, צרפתית וספרות. (cp1252)<br />קידוד שלישי היה אנגלית, עברית וספרות.  (cp1255)<br /><br />כל הבעיות מתחילות אם יש לנו מחרוזת שמורכבת מכמה שפות או אם הקידוד הנבחר לא מכיל את אותיות השפה שאיתה אנו עובדים. אז מה, אי אפשר לעבוד בשני שפות?<br /><br /><h3>UTF-8</h3><br />זהו קידוד שמורכב הפעם מיותר מbyte אחד לתו (בין 1 ל4 בייתים), מה שמרחיב את כמות התווים שהוא מסוגל לשמור. הקידוד מסוגל לשמור תווים של הרבה מאוד שפות והוא בדיוק מה, שאנחנו צריכים.<br /><br /><h4>להגדיר קידוד בחמישה מקומות</h4><br /><h5>1. בקובץ שאיתו אנחנו עובדים</h5><br />כאן נכנס לפעולה העורך טקסט שלנו. בכל עורך טקסט אפשר להגדיר את קידוד הקובץ או בחלון ההגדרות או בחלון השמירה. בnotepad זה <a href="http://habreffect.ru/files/3ab/b63ed7fc1/screen.png">נראה ככה</a>.<br /><br /><h5>2. ליידע את הדפדפן והשרת באיזו שפה הם מדברים</h5><br />כאן יהיה עלינו להוסיף שני שורות קוד.<br />הראשונה היא תג מתה שיש לשים בתוך דף ה-html עבור הדפדפן<br />והשניה היא השורה הראשונה שאמורה להימצא בקוד שלכם תמיד. מתוך הרגל.<br /><br /><div class="php codeblock"><span class="kw2">&lt;?php</span> <span class="kw3">header</span><span class="br0">&#40;</span><span class="st_h">''Content-Type: text/html; charset=utf-8''</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="sy1">?&gt;</span><br />\n&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;</div><br /><br /><br /><h5>3. ליידע את המסד וphp באיזו שפה הם מדברים</h5><br />כאן יהיה עלינו להגדיר את קידוד ההתחברות אל מסד הנתונים, כדי שהתעבורה בין תוכנת מסד הנתונים והסקריפט שלכם לא תאבד לכם אותיות באמצע.<br /><br /><div class="php codeblock"><span class="kw2">&lt;?php</span> <br />\n<span class="re0">$db</span> <span class="sy0">=</span> <span class="kw3">mysql_connect</span><span class="br0">&#40;</span><span class="st_h">''localhost''</span><span class="sy0">,</span><span class="st_h">''1''</span><span class="sy0">,</span><span class="st_h">''2''</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="kw3">mysql_select_db</span><span class="br0">&#40;</span><span class="st_h">''mydb''</span><span class="sy0">,</span><span class="re0">$db</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="kw3">mysql_query</span><span class="br0">&#40;</span><span class="st0">&quot;SET NAMES ''utf8''&quot;</span><span class="sy0">,</span><span class="re0">$db</span><span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br /><h5>4. לדאוג שהמסד שומר נתונים בקידוד נכון.</h5><br />כאשר אנחנו יוצרים טבלה יש לנו אפשרות להגדיר את הקידוד של כל שדה בטבלה בנפרד. הקידוד שאנחנו רוצים נקרא utf8_general_ci . יש לבחור בו בעת היצירה והוא ידאג לתקינות הנתונים שלנו לצמיתות.<br /><br /><img src="/static/images/pixel.gif" alt="UTF-8: קידוד וסימני שאלה" title="http://habreffect.ru/files/de9/f28752886/untitled1.png" class="content-image-float"/><br /><br /><br /><br />זהו זה. בעיית הקידוד נפתרה.<br />יכול להיות שלאחר מעבר ל utf-8 תתקלו <a href="http://phpguide.co.il/b19/Can_not_send_session_cookie_-_headers_already_sent">בבעית ה headers already sent by</a> .', '2010-10-07 12:03:15', 'עברית, סימני שאלה, מסד, utf8, utf-8', 'פתרון בעיית קידוד, סימני שאלה ושליפה בעברית ממסד על ידי שימוש ב utf-8', 1, 1),
(39, 'בדיקת עומס לאתר', 'בדיקת_עומס_לאתר', 'http://ncdn.phpguide.co.il/blogimages/loadimpact.jpg', 'השירות http://loadimpact.com מאפשר לכם לראות איך התנהג ויגיב האתר שלכם עם עד 50 גולשים ב זמנית. בואו לבדוק את האתר שלכם.', '<img src="/static/images/pixel.gif" alt="בדיקת עומס לאתר" title="http://habreffect.ru/files/f47/5da1a83fe/loadimpact.png" class="content-image-float"/><br /><br />האם האתר עומד בלחצים?<br />קבוצת <a href="http://loadimpact.com/">Load Impact</a> השיקה שירות חדש המאפשר לבדוק זמן תגובה של השרת תוך דימוי של 50 גולשים במקביל לאתר שלכם. הגרף למעלה מתאר את זמן התגובה של phpguide.co.il<br /><br /><br />לשירות שני מסלולים.<br /><a href="http://loadimpact.com">החינמי</a> - עד 50 גולשים.<br />בתשלום - 9$ עד 250 גולשים, בדיקות קיבולת מרביות, בדיקות לאורך זמן <a href="http://loadimpact.com/products.php?basic">ועוד</a>.', '2010-12-11 19:25:43', 'עומס אתר, בדיקת עומס', 'השירות http://loadimpact.com מאפשר לכם לראות איך התנהג ויגיב האתר שלכם עם עד 50 גולשים ב זמנית.', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`cat_id`, `name`) VALUES
(6, 'JS צד לקוח'),
(3, 'mysql'),
(7, 'אבטחה'),
(1, 'ביצועים ואופטימיזציה'),
(11, 'כלים שימושיים'),
(2, 'מבנה הסקריפט'),
(12, 'נושאים כלליים'),
(10, 'פתרונות נפוצים'),
(9, 'רשת ופרוטוקולים'),
(4, 'שליחת אימייל ב-PHP'),
(5, 'שרתים apache wamp'),
(8, 'תמונות וגרפיקה');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=421 ;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`cid`, `blogid`, `date`, `postingip`, `author`, `text`, `approved`) VALUES
(18, 20, '2011-03-03 15:10:25', '', 'אלכסנדר רסקין', 'במידה ו set names לא עזר ובכל זאת נשלפים סימני שאלה מהמסד — אפשר לנסות את הקוד הבא: \n\nmysql_query("set character_set_client=''utf8''");\nmysql_query("set character_set_results=''utf8''");\nmysql_query("set collation_connection=''utf8''");\nx\n\nאם הפעולה הזו עדיין לא תעזור, כנראה שהנתונים הוכנסו בעבר למסד באופן לא תקין (בקידוד פגום) ונשמרו שם כך. יש צורך להזין את הנתונים האלו מחדש כאשר השדות והקידוד מוגדרים נכון - שוב.', 1),
(132, 17, '2011-05-19 17:52:05', '', 'מתן', 'תודה רבה אלכס, חיפשתי מדריך לזה פעם, מזל שיש את האתר שלך :)', 1),
(170, 17, '2011-06-04 14:09:33', '', 'אוראל', 'תודה רבה! מדריך מובן מאוד. אהבתי אותו.', 1),
(274, 20, '2011-06-27 20:57:28', '', 'lulzsec', 'במקום כל מה שכתבת אפשר בהחלט להסתדר עם פונקציה אחת -  mysql_set_charset.', 1),
(275, 20, '2011-06-27 21:27:41', '', 'אלכסנדר רסקין', 'מה ש mysql_set_charset עושה זה בדיוק את שאילתת ה set names (שהיא עצמה עושה את כל מה ששלושת השאילתות האלה עושות) לכן לרוב אין בהם צורך.\r\n\r\nקרו מקרים שלי זה לא הפסיק מסיבות לא ברורות בלי שלושת השאילתות האחרונות באופן מפורש. אין לי הסבר למה, יש לי רק את הפתרון. יכול להיות שזהו באג של גרסאות ישנות.', 1),
(405, 16, '2011-09-13 14:57:31', '127.0.0.1', 'intval', 'test', 1);

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

--
-- Dumping data for table `blog_plain`
--

INSERT INTO `blog_plain` (`id`, `plain_description`, `plain_content`) VALUES
(17, 'כל מערכת מורכבת משלושה חלקים: הנתונים, העיצוב שבו הם מוצגים\r\nוהמנגן של התזמורת, זה שמחליט איזה נתונים ובאיזה עיצוב להציג.', 'יש משהו קטן ומעצבן שהורס כל קוד והוא דווקא ה-html. בגללו נגרמים סירבולים מיותרים של סוגריים מסולסלות, פתיחות וסירות תגי php והרבה קטעים בלתי קשורים מפריעים לעין והבנת הקוד.\r\n\r\nבפוסט הזה אני רוצה להכיר לכם את ההפרדה בין php לבין כל מה שמסביבו.  נראה איך אנחנו מפיקים את המרב מתבנית העיצוב Model-Viewer-Controller ומה זה הדינוזאור הזה בכלל.\r\n\r\n\r\n[h1] מה זה MVC: Model Viewer Controller ?[/h1]\r\n\r\n		בואו נסתכל רגע על התוכנה שלנו ונפשט אותה מעת. \r\n\r\n		אנחנו צריכים לקבל נתון מהלקוח, לעשות איתו משהו ולהציג תוצאה כלשהי בתוך עיצוב כלשהו. למשל, כדי להציג את העמוד הספציפי הזה, הסקריפט היה צריך לקבל מאיתנו את שם העמוד המבוקש, לשלוף את תוכנו מהמסד ולהציג אותו בעיצוב של האתר.\r\n\r\n		מה היה קורה אילו היינו מבקשים עמוד אחר? הסקריפט היה צריך לקבל את שם העמוד, לשלוף תוכן שונה הפעם, אבל להציג באותו עיצוב. ואם הייתם מבצעים חיפוש באתר, הפעם היה נכנס לפעולה סריפט אחר שעושה חיפוש במסד, אבל עדיין מציג הכל באותו עיצוב.\r\n\r\n\r\nהעיצוב הקבוע הוא המודל — תבנית בה מוצגים הנתונים. המודל זהה לרוב העמודים באתר לכן נוציא אותו החוצה מהסקריפט עצמו לקובץ נפרד. דוגמה?\r\n\r\n	[h1]שעון ה-MVC שלנו[/h1][h3]model: תבנית הצגה[/h3]\r\n\r\n		בואו נבנה סקריפט שמציג את השעה בתוך תבנית עיצוב קבוע.\r\n		את התבנית שלנו באופן קבוע ירכיבו שני אלמנטים. ברכת שלום למשתמש והשעה עצמה.\r\n		עמוד שלנו נראה קבוע ואפשר להוציא המודל שלו לקובץ html נפרד שיראה בערך ככה:\r\n\r\n	[php]<html>\r\n<body bgcolor="green">\r\n\r\nHi Mr. Neo<br/>\r\nThe current time is: 01:37\r\n\r\n</body>\r\n</html>\r\n\r\n[/php]\r\n\r\n	[h3]controller: מה השעה אדוני המבקר[/h3]\r\n\r\n		הקונטרולר (בקר בעברית) אחראי על הפעולות והתוכן שאנחנו צריכים. לדוגמה האתר שלנו פשוט מציג את השעה — אזי המטרה של הקונטרולר היא לחשב את השעה. כאן בעצם נמצא הסקריפט הפועל שיש להפריד מה-html . הקוד שעושה את העבודה שלנו.\r\n\r\n	[php]<?php \r\n\r\n// יוצרים את התוכן\r\n$time = date("H:i");\r\n$name = "Mr. Neo";\r\n[/php]\r\n\r\n	[h3]Viewer: מציג את הכל ביחד[/h3]\r\n\r\n		החלק אחרון של המשוואה מחבר את כל החלקים ביחד. כאן נכנס סקריפט נוסף לפעולה האחראי על הצגת התוצאה. תכירו, מר viewer .\r\n\r\n		המטרה שלו, היא להכניס את התוכן שיצר הקונטרולר במקום המיועד לו במודל. כדי להקל עליו בפעולתו, אנחנו נשנה מאט את מבנה המודל בצוראה הבאה:\r\n\r\n[php]<html>\r\n\r\n<body bgcolor="green">\r\n\r\nHi {{ name }}.<br/>\r\nThe current time is: {{ time }}\r\n\r\n</body>\r\n</html>\r\n\r\n[/php]\r\n\r\n			עכשיו כל מה שעלינו לעשות, זה להגיד ל-viewer שלנו לקחת את הנתונים שיצר הקונטרולר ולהציב אותם במקום המתאים במודל באמצעות החלפת מחרוזות פשוטה באופן הבא:\r\n\r\n[php]<?php \r\n$output = str_replace\r\n(\r\n    Array( "{{ name }}", "{{ time }}" ), \r\n    Array($name , $time), \r\n    $model\r\n);\r\n[/php]\r\n\r\n	[h1]שלושת חלקי ה-MVC יחדיו[/h1]\r\ncontroller - index.php\r\n[php]<?php \r\n\r\n// יוצרים את התוכן\r\n$time = date("d/m/y H:i:s"); \r\n$name = "אליהו הנביא"; \r\n[/php]\r\n	\r\nviewer.php	\r\n[php]\r\n$output = str_replace\r\n(\r\n    Array( "{{ name }}", "{{ time }}" ), \r\n    Array($name , $time), \r\n    $model\r\n);\r\n[/php]\r\n\r\nmodel.htm\r\n[php]\r\n<html>\r\n<body bgcolor="green">\r\n\r\nHi {{ name }}. <br/>\r\nThe current time is: {{ time }}\r\n\r\n</body>\r\n</html>\r\n[/php]\r\n\r\nלרוב ישמש ה-controller כנקודת כניסה לסקריפט. בפניה אליו ייצור ה-controller את התוכן המתאים לאותו עמוד ויגרום ל-viewer להכניס אותו ל-model המתאים.\r\n\r\n[h2]מסדרים הכל ביחד[/h2]\r\n		כאשר אנחנו פונים לindex.php הוא יוצר את התוכן. עכשיו עלינו לקרוא ל-viewer כדי שיציב את הערכים החדשים בדוגמנית (model) שלנו. נעשה include לקובץ ה-viewer שלנו. אבל לפני שהוא מבצע את העבודה שלו, עלינו להגדיר לו את משתנה הmodel. זה מה שיצא:\r\n\r\n[php]<?php\r\n$time = date("d/m/y H:i:s");\r\n$name = rand(1,100) ; //o\r\n\r\n// הכנסת המודל למשתנה \r\n$model = file_get_contents(''model.htm'');\r\n\r\n// קריא ל- viewer\r\ninclude ''viewer.php'';\r\n\r\n// הצגת הפלט\r\necho $output;\r\n[/php]\r\nנסו להפעיל את הקוד הזה ולהבין את אופן פעולתו.\r\n\r\n	[h1]מערכת mvc יותר מתקדמת[/h1]\r\n\r\nכדי שהמערכת תהיה רחבה יותר ותתאים לשלל עמודים שונים, נרצה לבנות viewer משוכלל יותר, שיידע לעבוד עם כל תבנית וכל משתנה שיועבר אליו.\r\n נשכתב מעט את ה-viewer הזה כדי שלא יהיה תלוי בקונטרולר ובמשתנים שבו.\r\n\r\n[i]האות A בהערות נמצאת שם ליישור הקוד לשמאל ולא מסמלתדבר[/i]\r\n[php]<?php\r\nfunction viewer( $params, $model )\r\n{\r\n    // A נבדוק שקובץ עם התבנית קיים וניתן לקריאה\r\n    if(!file_exists($model) || !is_readable($model)) \r\n    {\r\n        echo "Error: failed to load the template $model";\r\n        return false;\r\n    }\r\n\r\n    // A אם כן - נתען אותו לזכרון\r\n    $model = file_get_contents($model);\r\n   \r\n    // A נקבל את רשימת שמות המשתנים\r\n    $keys = array_keys($params);\r\n    \r\n    // A נוסיף לכל אחד מהם את סימון המשתנה שלנו\r\n    for( $i = 0; $i < sizeof($keys); $i++) \r\n        $keys[$i] = ''{{ ''.$keys[$i].'' }}'';\r\n    \r\n    // A נבצע את ההצבה של המשתנים במודל\r\n    return str_replace( $keys, $params, $model);\r\n}\r\n[/php]\r\n\r\n		עכשיו אנחנו יכולים להשתמש בו גם עם קונטרולרים ומודלים אחרים.\r\nיהיה עלינו רק לרשום את שמות המשתנים בתבנית באותו אופן (בתוך זוג סוגריים מסולסלות) ולדאוג שהבקר של אותו עמוד הכן ייצור את המשתנים הללו.\r\n[php]<?php\r\n\r\n//A יוצרים את התוכן\r\n$data = Array( ''time'' =>  date("d/m/y H:i:s") ,  ''name'' =>"אליהו הנביא");\r\n\r\n//A מחברים את הviewer\r\ninclude ''viewer.php'';\r\n\r\n// A מדפיסים את התוצאה\r\necho viewer ( $data, ''model.htm'' );\r\n[/php]\r\n\r\n		אבל מה קורה אם אנחנו רוצים עוד אפשרויות? מה אם אנחנו רוצים להציג בלוקים שלמים של תוכן תלוי במשתנה? מה אם אנחנו רוצים להצי תוכן כלשהו בלולאה ועדיין להשאיר את ה-html מחוץ לקוד ה-php .\r\n\r\n		במקרים האלה אנחנו נצטרך לפתח viewer חזק יותר, עם יותר אפשרויות שיודע לענות ליותר דרישות. אבל במקום שנבזבז את הזמן שלנו על זה, למה שלא נשתמש במשהו מוכן? בכתבה הבאה אני יספר לכם על [url=http://twig-project.org]Twig-project[/url] , ה-template engine שיצר והציג את העמוד הזה.'),
(39, 'השירות http://loadimpact.com מאפשר לכם לראות איך התנהג ויגיב האתר שלכם עם עד 50 גולשים ב זמנית. בואו לבדוק את האתר שלכם.', '[img]http://habreffect.ru/files/f47/5da1a83fe/loadimpact.png[/img]\r\n\r\nהאם האתר עומד בלחצים?\r\nקבוצת [url=http://loadimpact.com/]Load Impact[/url] השיקה שירות חדש המאפשר לבדוק זמן תגובה של השרת תוך דימוי של 50 גולשים במקביל לאתר שלכם. הגרף למעלה מתאר את זמן התגובה של phpguide.co.il\r\n\r\n\r\nלשירות שני מסלולים.\r\n[url=http://loadimpact.com]החינמי[/url] - עד 50 גולשים.\r\nבתשלום - 9$ עד 250 גולשים, בדיקות קיבולת מרביות, בדיקות לאורך זמן [url=http://loadimpact.com/products.php?basic]ועוד[/url].'),
(20, 'אם הופיעו לכם סימני שאלה וציורים סיניים במקום עברית העמוד, פנו למדריך הזה לעזרה וטפלו במושג שנקרא קידוד אחת ולתמיד.', 'מה, הוא מטומטם? למה הוא מציג לי סימני שאלה וג''יבריש במקום עברית?\r\nהסיבה לסימני השאלה האלה תמונה במילה לא ברורה ושמה קידוד. קידוד, הוא האופן שבו שומר המחשב אצלו את תווי הטקסט שמהם מורכבת המחרוזת. אבל לפעמים, הוא לא כל כך מצליח.\r\n\r\n\r\n[h1]מה לי ולקידוד?[/h1]\r\nהרבה מאוד שפות מדוברות מסביב לכדור הארץ וכמעט כל אחת מהן מוצאת את עצמה על גבי מסכי המחשב. בכל שפה אותיות שונות, נראות שונה, נכתבות שונה ויוצרות בעיות שמירה שונות.\r\n\r\nבעבר שמרו כל תו (אות) כbyte אחד בזכרון. מכיוון שכל byte היה מורכב משמונה bitים, היו סה"כ 255 אותיות שהמחשב ידע לעבוד איתם. כאן להיסטוריה נכנסה המצאה גאונית שנקראה - קידוד. קידוד היה אוסף של 255 אותיות שאיתו המחשב היה עובד. \r\n\r\nבקידוד אחד את 255 התווים האלה תפסו אנגלית, רוסית וספרות. (cp1251)\r\nקידוד אחר היה מורכב מ255 תווים שהיו לאנגלית, צרפתית וספרות. (cp1252)\r\nקידוד שלישי היה אנגלית, עברית וספרות.  (cp1255)\r\n\r\nכל הבעיות מתחילות אם יש לנו מחרוזת שמורכבת מכמה שפות או אם הקידוד הנבחר לא מכיל את אותיות השפה שאיתה אנו עובדים. אז מה, אי אפשר לעבוד בשני שפות?\r\n\r\n[h1]UTF-8[/h1]\r\nזהו קידוד שמורכב הפעם מיותר מbyte אחד לתו (בין 1 ל4 בייתים), מה שמרחיב את כמות התווים שהוא מסוגל לשמור. הקידוד מסוגל לשמור תווים של הרבה מאוד שפות והוא בדיוק מה, שאנחנו צריכים.\r\n\r\n[h2]להגדיר קידוד בחמישה מקומות[/h2]\r\n[h3]1. בקובץ שאיתו אנחנו עובדים[/h3]\r\nכאן נכנס לפעולה העורך טקסט שלנו. בכל עורך טקסט אפשר להגדיר את קידוד הקובץ או בחלון ההגדרות או בחלון השמירה. בnotepad זה [url=http://habreffect.ru/files/3ab/b63ed7fc1/screen.png]נראה ככה[/url].\r\n\r\n[h3]2. ליידע את הדפדפן והשרת באיזו שפה הם מדברים[/h3]\r\nכאן יהיה עלינו להוסיף שני שורות קוד.\r\nהראשונה היא תג מתה שיש לשים בתוך דף ה-html עבור הדפדפן\r\nוהשניה היא השורה הראשונה שאמורה להימצא בקוד שלכם תמיד. מתוך הרגל.\r\n\r\n[php]<?php header(''Content-Type: text/html; charset=utf-8''); ?>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8">\r\n[/php]\r\n\r\n\r\n[h3]3. ליידע את המסד וphp באיזו שפה הם מדברים[/h3]\r\nכאן יהיה עלינו להגדיר את קידוד ההתחברות אל מסד הנתונים, כדי שהתעבורה בין תוכנת מסד הנתונים והסקריפט שלכם לא תאבד לכם אותיות באמצע.\r\n\r\n[php]<?php \r\n$db = mysql_connect(''localhost'',''1'',''2'');\r\nmysql_select_db(''mydb'',$db);\r\nmysql_query("SET NAMES ''utf8''",$db);\r\n[/php]\r\n\r\n[h3]4. לדאוג שהמסד שומר נתונים בקידוד נכון.[/h3]\r\nכאשר אנחנו יוצרים טבלה יש לנו אפשרות להגדיר את הקידוד של כל שדה בטבלה בנפרד. הקידוד שאנחנו רוצים נקרא utf8_general_ci . יש לבחור בו בעת היצירה והוא ידאג לתקינות הנתונים שלנו לצמיתות.\r\n\r\n[img]http://habreffect.ru/files/de9/f28752886/untitled1.png[/img]\r\n\r\n\r\n\r\nזהו זה. בעיית הקידוד נפתרה.\r\nיכול להיות שלאחר מעבר ל utf-8 תתקלו [url=http://phpguide.co.il/b19/Can_not_send_session_cookie_-_headers_already_sent]בבעית ה headers already sent by[/url] .');

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

--
-- Dumping data for table `blog_post2cat`
--

INSERT INTO `blog_post2cat` (`postid`, `catid`) VALUES
(39, 1),
(17, 2),
(20, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `code_tinyurl`
--

INSERT INTO `code_tinyurl` (`id`, `code`, `checksum`) VALUES
(7, 'echo "hey";', '5d0e5ccbd91fc0c3b98512b85f4130ec');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`qid`),
  KEY `authorid` (`authorid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `qna_questions`
--

INSERT INTO `qna_questions` (`qid`, `subject`, `bb_text`, `html_text`, `authorid`, `time`, `status`, `views`, `answers`) VALUES
(1, 'איך עושים איזה שטות?', 'הכנתי מערכת תגובות קטנה , הכל טוב חוץ מאיזה פסקה קטנה עם פקודה של SQL ששם הבעיה .\r\nאף אחד לא מצליח להגיד לי מה הבעיה ובעצם לתקן אותי , אני פניתי לכאן עם הרבה תקוות שמשהוא יפתור\r\nאת הבעיה , תודה רבה לכל העוזרים .\r\nהנה הקוד המלא:\r\nhttp://pastebin.com/MYivdh01\r\n\r\nהנה שורות הקוד שיש בהם בעיה :\r\n[php]\r\nmysql_query("INSERT INTO ''account'' (''Name'')\r\n   VALUES (''".mysql_real_escape_string($_POST[''Name''])."'')");\r\n\r\n   $name = mysql_query("SELECT * FROM  account WHERE  id =     \r\n''".mysql_real_escape_string($_POST[''id''])."''");\r\n\r\n   $client_name = mysql_fetch_assoc($name);\r\n[/php]\r\n\r\nאשמח אם תגידו לי במה [b]שגית[/b]י , תודה רבה.\r\n', 'הכנתי מערכת תגובות קטנה , הכל טוב חוץ מאיזה פסקה קטנה עם פקודה של SQL ששם הבעיה .<br />אף אחד לא מצליח להגיד לי מה הבעיה ובעצם לתקן אותי , אני פניתי לכאן עם הרבה תקוות שמשהוא יפתור<br />את הבעיה , תודה רבה לכל העוזרים .<br />הנה הקוד המלא:<br />http://pastebin.com/MYivdh01<br /><br />הנה שורות הקוד שיש בהם בעיה :<br /><div class="php codeblock"><span class="kw3">mysql_query</span><span class="br0">&#40;</span><span class="st0">&quot;INSERT INTO ''account'' (''Name'')<br />\n&nbsp; &nbsp;VALUES (''&quot;</span><span class="sy0">.</span><span class="kw3">mysql_real_escape_string</span><span class="br0">&#40;</span><span class="re0">$_POST</span><span class="br0">&#91;</span><span class="st_h">''Name''</span><span class="br0">&#93;</span><span class="br0">&#41;</span><span class="sy0">.</span><span class="st0">&quot;'')&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<br />\n&nbsp; &nbsp;<span class="re0">$name</span> <span class="sy0">=</span> <span class="kw3">mysql_query</span><span class="br0">&#40;</span><span class="st0">&quot;SELECT * FROM &nbsp;account WHERE &nbsp;id = &nbsp; &nbsp; <br />\n''&quot;</span><span class="sy0">.</span><span class="kw3">mysql_real_escape_string</span><span class="br0">&#40;</span><span class="re0">$_POST</span><span class="br0">&#91;</span><span class="st_h">''id''</span><span class="br0">&#93;</span><span class="br0">&#41;</span><span class="sy0">.</span><span class="st0">&quot;''&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<br />\n&nbsp; &nbsp;<span class="re0">$client_name</span> <span class="sy0">=</span> <span class="kw3">mysql_fetch_assoc</span><span class="br0">&#40;</span><span class="re0">$name</span><span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br />אשמח אם תגידו לי במה <strong>שגית</strong>י , תודה רבה.<br />', 1, '2011-10-22 14:45:07', 'active', 65, 0);

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
  `last_login` timestamp NULL DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=390 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `real_name`, `last_login`, `reg_date`, `ip`, `email`, `password`, `salt`, `fbid`, `googleid`, `twitterid`, `points`, `is_admin`) VALUES
(1, 'admin', 'adminus zeus', '2012-01-06 09:45:22', '2011-03-18 10:16:51', '127.0.0.1', 'admin@127.0.0.1', '$2a$06$abcabcabcabcabcabcabcO67uPHzHvftukncfCrskwpUd3yffAJKq', 'abcabcabcabcabcabcabca', '', '', NULL, 0, 1);

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
  ADD CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`blogid`) REFERENCES `intva109_phpbook`.`blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_post2cat`
--
ALTER TABLE `blog_post2cat`
  ADD CONSTRAINT `blog_post2cat_ibfk_2` FOREIGN KEY (`catid`) REFERENCES `blog_categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog_post2cat_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `qna_answers`
--
ALTER TABLE `qna_answers`
  ADD CONSTRAINT `qna_answers_ibfk_2` FOREIGN KEY (`authorid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `qna_answers_ibfk_1` FOREIGN KEY (`qid`) REFERENCES `qna_questions` (`qid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `qna_questions`
--
ALTER TABLE `qna_questions`
  ADD CONSTRAINT `qna_questions_ibfk_1` FOREIGN KEY (`authorid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
