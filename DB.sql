

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `ajax_chat_bans` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ajax_chat_bans`
--


-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_invitations`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_invitations` (
  `userID` int(11) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ajax_chat_invitations`
--


-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_messages`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `text` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=52 ;



CREATE TABLE IF NOT EXISTS `ajax_chat_online` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



----------------------------------------------------------------
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
  `author_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`),
  FULLTEXT KEY `html_desc_paragraph` (`html_desc_paragraph`,`html_content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `url`, `image`, `html_desc_paragraph`, `html_content`, `pub_date`, `keywords`, `description`, `approved`, `author_id`) VALUES
(16, 'כמה טיפים בביצועים', 'כמה_טיפים_בביצועים', 'http://image.become.com/imageserver/s7/992938407-75-75-5-32/the-carrera-slot-car-race-set.jpg', 'מה יותר מהיר, serialize או json_encode,  לבדוק שהקובץ קיים או פשוט לעשות require_once ועוד כמה טיפים של איזה קוד עובד יותר מהר', 'הכללתי ברשימה הקצרה רק דברים שמפתיעים מתכנתים מתחילים ולא כללתי דברים<br />	ברורים מאליו כמו שימוש בגרש יחידה במקום גרשיים כפולות למחרוזות ודומיהן.<br />	אני מקווה שמישהו יצא מכאן עם משהו חדש.<br /><br /><br />התוצאות ומסקנות נשענות על בסיס של ניסויים בכמה גרסאות php<br />5.2.6 debian lenny, 5.3.2 של ubuntu, ו 5.2.14 של dotdeb.<br />אולי על פלאטפורמות אחרות יש הבדלים.<br /><br /><br /><h4>file_get_contents</h4><br /><br />הפונקציה הנחמדה הזו משתמשת <a href="http://en.wikipedia.org/wiki/Mmap">במיפוי זיכרון</a> מה שמביא לגידול בולט בביצועים, באיחוד בקבצים גדולים. המשמעות היא ש:<br /><div class="php codeblock"><span class="kw3">simplexml_load_string</span> <span class="br0">&#40;</span><span class="kw3">file_get_contents</span> <span class="br0">&#40;</span><span class="st_h">''file.xml''</span><span class="br0">&#41;</span><span class="br0">&#41;</span><span class="sy0">;</span></div><br />עובד יותר מהר מ:<br /><div class="php codeblock"><span class="kw3">simplexml_load_file</span><span class="br0">&#40;</span><span class="st_h">''file.xml''</span><span class="br0">&#41;</span><span class="sy0">;</span></div><br />נראה כי הפונקציה simplexml_load_file מתבססת על fopen / fread קונבנציאונאלי, מה שמוביל להבדל במהירות.<br /><br />נ.ב. עדיף להישתמש בזה לא רק בפונקציות של xml , הרי גם פונקציות אחרות יאיצו כתוצאה.לדוגמא, אם אתם מנסים לקרוא קובץ ולהפריד אותו לפי שורות לתוך מערך, אזי עדיף להחליף את file() ב<br /><div class="php codeblock"><span class="kw3">explode</span><span class="br0">&#40;</span>PHP_EOL<span class="sy0">,</span> <span class="kw3">file_get_contents</span><span class="br0">&#40;</span><span class="st_h">''file.xml''</span><span class="br0">&#41;</span><span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br /><h4><span dir="ltr">()count</span> ו <span dir="ltr">()sizeof</span></h4><br /><span dir="ltr">sizeof</span> היא כינוי(פסאודונים) לפונקציה <span dir="ltr">count</span> אך משום מה היא עובדת מהר יותר.<br /><br /><br /><br /><h4>שגיאות ו <span dir="ltr">notices</span></h4><br />להרשות לאפליקציה לזרוק <span dir="ltr">notice</span> הוא אחד המנהגים הגרועים ביותר בעולם התכנות. אפליקציה טובה יודעת להתמודד עם שגיאות בעצמה.<br />אבל אם אתם לא מוכנים לקבל על עצמכם את החשיבות במניעת שגיאות, פשוט דעו לכם<br />שהזמן הדרוש לphp להתמודד עם שגיאה גדול מהזמן שיקח לכם לרוץ על מערך עם 30 אלמנטים ולהגדיל כל אחד מהאלמנטים שלו באחד.<br />אגב השימוש ב <strong>@ היא קטסטרופה</strong> כדרך למניעת שגיאות.<br /><br />כן והיא גם הרבה יותר איטית מהוספה של בדיקה האם המשתנה קיים למשל.<br /><br /><br /><br /><br /><h4>foreach</h4><br /><br />בכל מאמר על ביצועים דואגים לומר את הדברים הכי גרועים על <span dir="ltr">foreach</span><br />למרות שבפועל לא הכל כל כך רע. הרבה פעמים מבנים שאנשים מנסים לכתוב כתחליף, דוגמאת:<br /><br /><div class="php codeblock"><span class="kw1">while</span> <span class="br0">&#40;</span><span class="kw3">list</span><span class="br0">&#40;</span><span class="re0">$key</span><span class="sy0">,</span> <span class="re0">$value</span><span class="br0">&#41;</span> <span class="sy0">=</span> <span class="kw3">each</span><span class="br0">&#40;</span><span class="re0">$item</span><span class="br0">&#41;</span><span class="br0">&#41;</span></div><br />פועלים הרבה יותר לאט וגרוע בכ-30 -40 אחוז.<br />אך עדיין שימו לב, אם יש באפשרותכם להשתמש ב <span dir="ltr">for</span> אזי הוא יהיה עדיף על <span dir="ltr">foreach</span><br /><br /><br /><br /><h4>JSON vs XML</h4><br />אוסיף כאן רק שאחרי מעבר לקבצי json לשמירת הגדרות במקום xml הרווחתי 20%-30% בביצועים. <span dir="ltr">json</span> נעים לעין, איאררכי ומהיר.<br /><span dir="ltr">json_decode</span> עובדת יותר מהר עם פרמטר אחד (כאשר יוצרת אובייקט ולא מערך)<br /><br /><br /><br /><h4><span dir="ltr">mb_ereg</span> vs <span dir="ltr">preg_match</span></h4><br />ביטויים רגולריים בדרך כלל משתמשים במנוע ה-<span dir="ltr"><a href="http://en.wikipedia.org/wiki/POSIX">posix</a></span> .כדי לקרוא ולפענח מחרוזות. מנוע ה-posix ידוע באיטיות שלו, לכן<br />מנוע <span dir="ltr"><a href="http://en.wikipedia.org/wiki/Oniguruma">oniguruma</a></span> שבו משתמשת <span dir="ltr">mb_ereg</span> לרוב יהיו בחירה טובה יותר לחייפ הרגולריים שלכםץ<br />בערך בשניים מתוך שלושה מקרים <span dir="ltr">mb_ereg</span> יעקוף בביצועים את <span dir="ltr">preg_match</span><br /><br /><br /><br /><br /><h4>file_exists &amp; include</h4><br />אם אתם לא בטוחים שהקובץ קיים (<span dir="ltr">autoload__</span> למשל) תועילו לעצמכם לבדוק האם הקובץ קיים לפני שאתם עושים לו אינקלוד.<br />עוד בקשר לאינקלוד: משום מה, לשמור במערך את שמות הקבצים שכבר הוספו יותר אפפקטיבי מלהשתמש ב <span dir="ltr">include_once</span> ולא באמת ברור לי למה.<br />(כל האמור תקף גם ל<span dir="ltr">require</span>)<br /><br /><br /><br /><h4>Static vars</h4><br />הדרך הטובה והבטוחה לשמור נתונים בשדה הרעיה הגלובאלי היא בתוך משתנים סטאטיים של מחלקה כלשהי. כייון שהם סטאטיים php יודעת לנהל אותם הרבה יותר טוב מכל משתנה במחלקה או לא במחלקה שהוא. שימו לב, לרוב השימוש בקבועים <span dir="ltr">constants</span> הוא איטי נורא, לכן עדיף להימנע מכך במידת האפשר.<br /><br /><br /><br /><h4>כמה המלצות לסיום</h4><br />תציגו לעצמכם את זמן הפעולה של סקריפט במילישניות. עם שינוי כזה בקנה המידה<br />רואים את ההבדל בין &quot;התבצע ב0.1 שניות&quot; לאומת &quot;התבצע ב100 מילישניות&quot; .<br />גם קריא יותר וגם יעלה לכם את המוטיבציה לשפר עוד קצת.<br /><br /><br />מאוד חשוב לאסוף מידע לא רק אודות הביצוע של הסקריפט כולו אלה גם של חלקים נפרדים שלו: גרעין, אינטרפייס, רנדרינג, ועוד את הפרופיילר שלי קינפגתי (בשרת הבדיקות) לזרוק שגיאה כאשר קטע כלשהו לוקח זמן רב מדי מהצפוי:<br /><span dir="ltr"> &quot;Attention!: 30% of the time taken for mysql connection&quot;</span><br /><br /><br /><br /><em>כל המסקנות נלקחו מבדיקות במערכת שלי ויכול להיות שתתקלו בתוצאות שונות אצלכם.</em>', '2010-09-23 20:04:10', 'ביצועים, טיפים, מהירות, php, file_get_contents, count, sizeof, notice, שגיאות, לולאות, xml, json, ביטויים רולריים', 'איזה קוד מהיר יותר — טיפים בביצועים', 1, 1),
(17, 'mvc: מפרידים html מ-php', 'mvc_מפרידים_html_מ_php', 'http://ncdn.phpguide.co.il/blogimages/mvc.jpg', 'כל מערכת מורכבת משלושה חלקים: הנתונים, העיצוב שבו הם מוצגים<br />והמנגן של התזמורת, זה שמחליט איזה נתונים ובאיזה עיצוב להציג.', 'יש משהו קטן ומעצבן שהורס כל קוד והוא דווקא ה-html. בגללו נגרמים סירבולים מיותרים של סוגריים מסולסלות, פתיחות וסירות תגי php והרבה קטעים בלתי קשורים מפריעים לעין והבנת הקוד.<br /><br />בפוסט הזה אני רוצה להכיר לכם את ההפרדה בין php לבין כל מה שמסביבו.  נראה איך אנחנו מפיקים את המרב מתבנית העיצוב Model-Viewer-Controller ומה זה הדינוזאור הזה בכלל.<br /><br /><br /><h3> מה זה MVC: Model Viewer Controller ?</h3><br /><br />		בואו נסתכל רגע על התוכנה שלנו ונפשט אותה מעת. <br /><br />		אנחנו צריכים לקבל נתון מהלקוח, לעשות איתו משהו ולהציג תוצאה כלשהי בתוך עיצוב כלשהו. למשל, כדי להציג את העמוד הספציפי הזה, הסקריפט היה צריך לקבל מאיתנו את שם העמוד המבוקש, לשלוף את תוכנו מהמסד ולהציג אותו בעיצוב של האתר.<br /><br />		מה היה קורה אילו היינו מבקשים עמוד אחר? הסקריפט היה צריך לקבל את שם העמוד, לשלוף תוכן שונה הפעם, אבל להציג באותו עיצוב. ואם הייתם מבצעים חיפוש באתר, הפעם היה נכנס לפעולה סריפט אחר שעושה חיפוש במסד, אבל עדיין מציג הכל באותו עיצוב.<br /><br /><br />העיצוב הקבוע הוא המודל — תבנית בה מוצגים הנתונים. המודל זהה לרוב העמודים באתר לכן נוציא אותו החוצה מהסקריפט עצמו לקובץ נפרד. דוגמה?<br /><br />	<h3>שעון ה-MVC שלנו</h3><h5>model: תבנית הצגה</h5><br /><br />		בואו נבנה סקריפט שמציג את השעה בתוך תבנית עיצוב קבוע.<br />		את התבנית שלנו באופן קבוע ירכיבו שני אלמנטים. ברכת שלום למשתמש והשעה עצמה.<br />		עמוד שלנו נראה קבוע ואפשר להוציא המודל שלו לקובץ html נפרד שיראה בערך ככה:<br /><br />	<div class="php codeblock"><span class="sy0">&lt;</span>html<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;</span>body bgcolor<span class="sy0">=</span><span class="st0">&quot;green&quot;</span><span class="sy0">&gt;</span><br />\n<br />\nHi Mr<span class="sy0">.</span> Neo<span class="sy0">&lt;</span>br<span class="sy0">/&gt;</span><br />\nThe <span class="kw3">current</span> <span class="kw3">time</span> is<span class="sy0">:</span> <span class="nu8">01</span><span class="sy0">:</span><span class="nu0">37</span><br />\n<br />\n<span class="sy0">&lt;/</span>body<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;/</span>html<span class="sy0">&gt;</span></div><br /><br />	<h5>controller: מה השעה אדוני המבקר</h5><br /><br />		הקונטרולר (בקר בעברית) אחראי על הפעולות והתוכן שאנחנו צריכים. לדוגמה האתר שלנו פשוט מציג את השעה — אזי המטרה של הקונטרולר היא לחשב את השעה. כאן בעצם נמצא הסקריפט הפועל שיש להפריד מה-html . הקוד שעושה את העבודה שלנו.<br /><br />	<div class="php codeblock"><span class="kw2">&lt;?php</span> <br />\n<br />\n<span class="co1">// יוצרים את התוכן</span><br />\n<span class="re0">$time</span> <span class="sy0">=</span> <span class="kw3">date</span><span class="br0">&#40;</span><span class="st0">&quot;H:i&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="re0">$name</span> <span class="sy0">=</span> <span class="st0">&quot;Mr. Neo&quot;</span><span class="sy0">;</span></div><br /><br />	<h5>Viewer: מציג את הכל ביחד</h5><br /><br />		החלק אחרון של המשוואה מחבר את כל החלקים ביחד. כאן נכנס סקריפט נוסף לפעולה האחראי על הצגת התוצאה. תכירו, מר viewer .<br /><br />		המטרה שלו, היא להכניס את התוכן שיצר הקונטרולר במקום המיועד לו במודל. כדי להקל עליו בפעולתו, אנחנו נשנה מאט את מבנה המודל בצוראה הבאה:<br /><br /><div class="php codeblock"><span class="sy0">&lt;</span>html<span class="sy0">&gt;</span><br />\n<br />\n<span class="sy0">&lt;</span>body bgcolor<span class="sy0">=</span><span class="st0">&quot;green&quot;</span><span class="sy0">&gt;</span><br />\n<br />\nHi <span class="br0">&#123;</span><span class="br0">&#123;</span> name <span class="br0">&#125;</span><span class="br0">&#125;</span><span class="sy0">.&lt;</span>br<span class="sy0">/&gt;</span><br />\nThe <span class="kw3">current</span> <span class="kw3">time</span> is<span class="sy0">:</span> <span class="br0">&#123;</span><span class="br0">&#123;</span> <span class="kw3">time</span> <span class="br0">&#125;</span><span class="br0">&#125;</span><br />\n<br />\n<span class="sy0">&lt;/</span>body<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;/</span>html<span class="sy0">&gt;</span></div><br /><br />			עכשיו כל מה שעלינו לעשות, זה להגיד ל-viewer שלנו לקחת את הנתונים שיצר הקונטרולר ולהציב אותם במקום המתאים במודל באמצעות החלפת מחרוזות פשוטה באופן הבא:<br /><br /><div class="php codeblock"><span class="kw2">&lt;?php</span> <br />\n<span class="re0">$output</span> <span class="sy0">=</span> <span class="kw3">str_replace</span><br />\n<span class="br0">&#40;</span><br />\n&nbsp; &nbsp; <span class="kw3">Array</span><span class="br0">&#40;</span> <span class="st0">&quot;{{ name }}&quot;</span><span class="sy0">,</span> <span class="st0">&quot;{{ time }}&quot;</span> <span class="br0">&#41;</span><span class="sy0">,</span> <br />\n&nbsp; &nbsp; <span class="kw3">Array</span><span class="br0">&#40;</span><span class="re0">$name</span> <span class="sy0">,</span> <span class="re0">$time</span><span class="br0">&#41;</span><span class="sy0">,</span> <br />\n&nbsp; &nbsp; <span class="re0">$model</span><br />\n<span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br />	<h3>שלושת חלקי ה-MVC יחדיו</h3><br />controller - index.php<br /><div class="php codeblock"><span class="kw2">&lt;?php</span> <br />\n<br />\n<span class="co1">// יוצרים את התוכן</span><br />\n<span class="re0">$time</span> <span class="sy0">=</span> <span class="kw3">date</span><span class="br0">&#40;</span><span class="st0">&quot;d/m/y H:i:s&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span> <br />\n<span class="re0">$name</span> <span class="sy0">=</span> <span class="st0">&quot;אליהו הנביא&quot;</span><span class="sy0">;</span></div><br />	<br />viewer.php	<br /><div class="php codeblock"><span class="re0">$output</span> <span class="sy0">=</span> <span class="kw3">str_replace</span><br />\n<span class="br0">&#40;</span><br />\n&nbsp; &nbsp; <span class="kw3">Array</span><span class="br0">&#40;</span> <span class="st0">&quot;{{ name }}&quot;</span><span class="sy0">,</span> <span class="st0">&quot;{{ time }}&quot;</span> <span class="br0">&#41;</span><span class="sy0">,</span> <br />\n&nbsp; &nbsp; <span class="kw3">Array</span><span class="br0">&#40;</span><span class="re0">$name</span> <span class="sy0">,</span> <span class="re0">$time</span><span class="br0">&#41;</span><span class="sy0">,</span> <br />\n&nbsp; &nbsp; <span class="re0">$model</span><br />\n<span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br />model.htm<br /><div class="php codeblock"><span class="sy0">&lt;</span>html<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;</span>body bgcolor<span class="sy0">=</span><span class="st0">&quot;green&quot;</span><span class="sy0">&gt;</span><br />\n<br />\nHi <span class="br0">&#123;</span><span class="br0">&#123;</span> name <span class="br0">&#125;</span><span class="br0">&#125;</span><span class="sy0">.</span> <span class="sy0">&lt;</span>br<span class="sy0">/&gt;</span><br />\nThe <span class="kw3">current</span> <span class="kw3">time</span> is<span class="sy0">:</span> <span class="br0">&#123;</span><span class="br0">&#123;</span> <span class="kw3">time</span> <span class="br0">&#125;</span><span class="br0">&#125;</span><br />\n<br />\n<span class="sy0">&lt;/</span>body<span class="sy0">&gt;</span><br />\n<span class="sy0">&lt;/</span>html<span class="sy0">&gt;</span></div><br /><br />לרוב ישמש ה-controller כנקודת כניסה לסקריפט. בפניה אליו ייצור ה-controller את התוכן המתאים לאותו עמוד ויגרום ל-viewer להכניס אותו ל-model המתאים.<br /><br /><h4>מסדרים הכל ביחד</h4><br />		כאשר אנחנו פונים לindex.php הוא יוצר את התוכן. עכשיו עלינו לקרוא ל-viewer כדי שיציב את הערכים החדשים בדוגמנית (model) שלנו. נעשה include לקובץ ה-viewer שלנו. אבל לפני שהוא מבצע את העבודה שלו, עלינו להגדיר לו את משתנה הmodel. זה מה שיצא:<br /><br /><div class="php codeblock"><span class="kw2">&lt;?php</span><br />\n<span class="re0">$time</span> <span class="sy0">=</span> <span class="kw3">date</span><span class="br0">&#40;</span><span class="st0">&quot;d/m/y H:i:s&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="re0">$name</span> <span class="sy0">=</span> <span class="kw3">rand</span><span class="br0">&#40;</span><span class="nu0">1</span><span class="sy0">,</span><span class="nu0">100</span><span class="br0">&#41;</span> <span class="sy0">;</span> <span class="co1">//o</span><br />\n<br />\n<span class="co1">// הכנסת המודל למשתנה </span><br />\n<span class="re0">$model</span> <span class="sy0">=</span> <span class="kw3">file_get_contents</span><span class="br0">&#40;</span><span class="st_h">''model.htm''</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<br />\n<span class="co1">// קריא ל- viewer</span><br />\n<span class="kw1">include</span> <span class="st_h">''viewer.php''</span><span class="sy0">;</span><br />\n<br />\n<span class="co1">// הצגת הפלט</span><br />\n<span class="kw1">echo</span> <span class="re0">$output</span><span class="sy0">;</span></div><br />נסו להפעיל את הקוד הזה ולהבין את אופן פעולתו.<br /><br />	<h3>מערכת mvc יותר מתקדמת</h3><br /><br />כדי שהמערכת תהיה רחבה יותר ותתאים לשלל עמודים שונים, נרצה לבנות viewer משוכלל יותר, שיידע לעבוד עם כל תבנית וכל משתנה שיועבר אליו.<br /> נשכתב מעט את ה-viewer הזה כדי שלא יהיה תלוי בקונטרולר ובמשתנים שבו.<br /><br /><em>האות A בהערות נמצאת שם ליישור הקוד לשמאל ולא מסמלתדבר</em><br /><div class="php codeblock"><span class="kw2">&lt;?php</span><br />\n<span class="kw2">function</span> viewer<span class="br0">&#40;</span> <span class="re0">$params</span><span class="sy0">,</span> <span class="re0">$model</span> <span class="br0">&#41;</span><br />\n<span class="br0">&#123;</span><br />\n&nbsp; &nbsp; <span class="co1">// A נבדוק שקובץ עם התבנית קיים וניתן לקריאה</span><br />\n&nbsp; &nbsp; <span class="kw1">if</span><span class="br0">&#40;</span><span class="sy0">!</span><span class="kw3">file_exists</span><span class="br0">&#40;</span><span class="re0">$model</span><span class="br0">&#41;</span> <span class="sy0">||</span> <span class="sy0">!</span><span class="kw3">is_readable</span><span class="br0">&#40;</span><span class="re0">$model</span><span class="br0">&#41;</span><span class="br0">&#41;</span> <br />\n&nbsp; &nbsp; <span class="br0">&#123;</span><br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="kw1">echo</span> <span class="st0">&quot;Error: failed to load the template <span class="es4">$model</span>&quot;</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="kw1">return</span> <span class="kw4">false</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; <span class="br0">&#125;</span><br />\n<br />\n&nbsp; &nbsp; <span class="co1">// A אם כן - נתען אותו לזכרון</span><br />\n&nbsp; &nbsp; <span class="re0">$model</span> <span class="sy0">=</span> <span class="kw3">file_get_contents</span><span class="br0">&#40;</span><span class="re0">$model</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n&nbsp; &nbsp;<br />\n&nbsp; &nbsp; <span class="co1">// A נקבל את רשימת שמות המשתנים</span><br />\n&nbsp; &nbsp; <span class="re0">$keys</span> <span class="sy0">=</span> <span class="kw3">array_keys</span><span class="br0">&#40;</span><span class="re0">$params</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; <br />\n&nbsp; &nbsp; <span class="co1">// A נוסיף לכל אחד מהם את סימון המשתנה שלנו</span><br />\n&nbsp; &nbsp; <span class="kw1">for</span><span class="br0">&#40;</span> <span class="re0">$i</span> <span class="sy0">=</span> <span class="nu0">0</span><span class="sy0">;</span> <span class="re0">$i</span> <span class="sy0">&lt;</span> <span class="kw3">sizeof</span><span class="br0">&#40;</span><span class="re0">$keys</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="re0">$i</span><span class="sy0">++</span><span class="br0">&#41;</span> <br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="re0">$keys</span><span class="br0">&#91;</span><span class="re0">$i</span><span class="br0">&#93;</span> <span class="sy0">=</span> <span class="st_h">''{{ ''</span><span class="sy0">.</span><span class="re0">$keys</span><span class="br0">&#91;</span><span class="re0">$i</span><span class="br0">&#93;</span><span class="sy0">.</span><span class="st_h">'' }}''</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; <br />\n&nbsp; &nbsp; <span class="co1">// A נבצע את ההצבה של המשתנים במודל</span><br />\n&nbsp; &nbsp; <span class="kw1">return</span> <span class="kw3">str_replace</span><span class="br0">&#40;</span> <span class="re0">$keys</span><span class="sy0">,</span> <span class="re0">$params</span><span class="sy0">,</span> <span class="re0">$model</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="br0">&#125;</span></div><br /><br />		עכשיו אנחנו יכולים להשתמש בו גם עם קונטרולרים ומודלים אחרים.<br />יהיה עלינו רק לרשום את שמות המשתנים בתבנית באותו אופן (בתוך זוג סוגריים מסולסלות) ולדאוג שהבקר של אותו עמוד הכן ייצור את המשתנים הללו.<br /><div class="php codeblock"><span class="kw2">&lt;?php</span><br />\n<br />\n<span class="co1">//A יוצרים את התוכן</span><br />\n<span class="re0">$data</span> <span class="sy0">=</span> <span class="kw3">Array</span><span class="br0">&#40;</span> <span class="st_h">''time''</span> <span class="sy0">=&gt;</span> &nbsp;<span class="kw3">date</span><span class="br0">&#40;</span><span class="st0">&quot;d/m/y H:i:s&quot;</span><span class="br0">&#41;</span> <span class="sy0">,</span> &nbsp;<span class="st_h">''name''</span> <span class="sy0">=&gt;</span><span class="st0">&quot;אליהו הנביא&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<br />\n<span class="co1">//A מחברים את הviewer</span><br />\n<span class="kw1">include</span> <span class="st_h">''viewer.php''</span><span class="sy0">;</span><br />\n<br />\n<span class="co1">// A מדפיסים את התוצאה</span><br />\n<span class="kw1">echo</span> viewer <span class="br0">&#40;</span> <span class="re0">$data</span><span class="sy0">,</span> <span class="st_h">''model.htm''</span> <span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br />		אבל מה קורה אם אנחנו רוצים עוד אפשרויות? מה אם אנחנו רוצים להציג בלוקים שלמים של תוכן תלוי במשתנה? מה אם אנחנו רוצים להצי תוכן כלשהו בלולאה ועדיין להשאיר את ה-html מחוץ לקוד ה-php .<br /><br />		במקרים האלה אנחנו נצטרך לפתח viewer חזק יותר, עם יותר אפשרויות שיודע לענות ליותר דרישות. אבל במקום שנבזבז את הזמן שלנו על זה, למה שלא נשתמש במשהו מוכן? בכתבה הבאה אני יספר לכם על <a href="http://twig-project.org">Twig-project</a> , ה-template engine שיצר והציג את העמוד הזה.', '2010-10-01 00:28:30', 'php mvc, mvc, php', 'מפרידים בין html ל-php באמצעות דפוס ה-mvc', 1, 1),
(39, 'בדיקת עומס לאתר', 'בדיקת_עומס_לאתר', 'http://ncdn.phpguide.co.il/blogimages/loadimpact.jpg', 'השירות http://loadimpact.com מאפשר לכם לראות איך התנהג ויגיב האתר שלכם עם עד 50 גולשים ב זמנית. בואו לבדוק את האתר שלכם.', '<img src="/static/images/pixel.gif" alt="בדיקת עומס לאתר" title="http://habreffect.ru/files/f47/5da1a83fe/loadimpact.png" class="content-image-float"/><br /><br />האם האתר עומד בלחצים?<br />קבוצת <a href="http://loadimpact.com/">Load Impact</a> השיקה שירות חדש המאפשר לבדוק זמן תגובה של השרת תוך דימוי של 50 גולשים במקביל לאתר שלכם. הגרף למעלה מתאר את זמן התגובה של phpguide.co.il<br /><br /><br />לשירות שני מסלולים.<br /><a href="http://loadimpact.com">החינמי</a> - עד 50 גולשים.<br />בתשלום - 9$ עד 250 גולשים, בדיקות קיבולת מרביות, בדיקות לאורך זמן <a href="http://loadimpact.com/products.php?basic">ועוד</a>.', '2010-12-11 22:25:43', 'עומס אתר, בדיקת עומס', 'השירות http://loadimpact.com מאפשר לכם לראות איך התנהג ויגיב האתר שלכם עם עד 50 גולשים ב זמנית.', 1, 1),
(20, 'UTF-8: קידוד וסימני שאלה', 'UTF_8_קידוד_וסימני_שאלה', 'http://cdn.instructables.com/FNV/Q7RA/FDYPTDBD/FNVQ7RAFDYPTDBD.SQUARE.jpg', 'אם הופיעו לכם סימני שאלה וציורים סיניים במקום עברית העמוד, פנו למדריך הזה לעזרה וטפלו במושג שנקרא קידוד אחת ולתמיד.', 'מה, הוא מטומטם? למה הוא מציג לי סימני שאלה וג&#039;יבריש במקום עברית?<br />הסיבה לסימני השאלה האלה תמונה במילה לא ברורה ושמה קידוד. קידוד, הוא האופן שבו שומר המחשב אצלו את תווי הטקסט שמהם מורכבת המחרוזת. אבל לפעמים, הוא לא כל כך מצליח.<br /><br /><br /><h3>מה לי ולקידוד?</h3><br />הרבה מאוד שפות מדוברות מסביב לכדור הארץ וכמעט כל אחת מהן מוצאת את עצמה על גבי מסכי המחשב. בכל שפה אותיות שונות, נראות שונה, נכתבות שונה ויוצרות בעיות שמירה שונות.<br /><br />בעבר שמרו כל תו (אות) כbyte אחד בזכרון. מכיוון שכל byte היה מורכב משמונה bitים, היו סה&quot;כ 255 אותיות שהמחשב ידע לעבוד איתם. כאן להיסטוריה נכנסה המצאה גאונית שנקראה - קידוד. קידוד היה אוסף של 255 אותיות שאיתו המחשב היה עובד. <br /><br />בקידוד אחד את 255 התווים האלה תפסו אנגלית, רוסית וספרות. (cp1251)<br />קידוד אחר היה מורכב מ255 תווים שהיו לאנגלית, צרפתית וספרות. (cp1252)<br />קידוד שלישי היה אנגלית, עברית וספרות.  (cp1255)<br /><br />כל הבעיות מתחילות אם יש לנו מחרוזת שמורכבת מכמה שפות או אם הקידוד הנבחר לא מכיל את אותיות השפה שאיתה אנו עובדים. אז מה, אי אפשר לעבוד בשני שפות?<br /><br /><h3>UTF-8</h3><br />זהו קידוד שמורכב הפעם מיותר מbyte אחד לתו (בין 1 ל4 בייתים), מה שמרחיב את כמות התווים שהוא מסוגל לשמור. הקידוד מסוגל לשמור תווים של הרבה מאוד שפות והוא בדיוק מה, שאנחנו צריכים.<br /><br /><h4>להגדיר קידוד בחמישה מקומות</h4><br /><h5>1. בקובץ שאיתו אנחנו עובדים</h5><br />כאן נכנס לפעולה העורך טקסט שלנו. בכל עורך טקסט אפשר להגדיר את קידוד הקובץ או בחלון ההגדרות או בחלון השמירה. בnotepad זה <a href="http://habreffect.ru/files/3ab/b63ed7fc1/screen.png">נראה ככה</a>.<br /><br /><h5>2. ליידע את הדפדפן והשרת באיזו שפה הם מדברים</h5><br />כאן יהיה עלינו להוסיף שני שורות קוד.<br />הראשונה היא תג מתה שיש לשים בתוך דף ה-html עבור הדפדפן<br />והשניה היא השורה הראשונה שאמורה להימצא בקוד שלכם תמיד. מתוך הרגל.<br /><br /><div class="php codeblock"><span class="kw2">&lt;?php</span> <span class="kw3">header</span><span class="br0">&#40;</span><span class="st_h">''Content-Type: text/html; charset=utf-8''</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="sy1">?&gt;</span><br />\n&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;</div><br /><br /><br /><h5>3. ליידע את המסד וphp באיזו שפה הם מדברים</h5><br />כאן יהיה עלינו להגדיר את קידוד ההתחברות אל מסד הנתונים, כדי שהתעבורה בין תוכנת מסד הנתונים והסקריפט שלכם לא תאבד לכם אותיות באמצע.<br /><br /><div class="php codeblock"><span class="kw2">&lt;?php</span> <br />\n<span class="re0">$db</span> <span class="sy0">=</span> <span class="kw3">mysql_connect</span><span class="br0">&#40;</span><span class="st_h">''localhost''</span><span class="sy0">,</span><span class="st_h">''1''</span><span class="sy0">,</span><span class="st_h">''2''</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="kw3">mysql_select_db</span><span class="br0">&#40;</span><span class="st_h">''mydb''</span><span class="sy0">,</span><span class="re0">$db</span><span class="br0">&#41;</span><span class="sy0">;</span><br />\n<span class="kw3">mysql_query</span><span class="br0">&#40;</span><span class="st0">&quot;SET NAMES ''utf8''&quot;</span><span class="sy0">,</span><span class="re0">$db</span><span class="br0">&#41;</span><span class="sy0">;</span></div><br /><br /><h5>4. לדאוג שהמסד שומר נתונים בקידוד נכון.</h5><br />כאשר אנחנו יוצרים טבלה יש לנו אפשרות להגדיר את הקידוד של כל שדה בטבלה בנפרד. הקידוד שאנחנו רוצים נקרא utf8_general_ci . יש לבחור בו בעת היצירה והוא ידאג לתקינות הנתונים שלנו לצמיתות.<br /><br /><img src="/static/images/pixel.gif" alt="UTF-8: קידוד וסימני שאלה" title="http://habreffect.ru/files/de9/f28752886/untitled1.png" class="content-image-float"/><br /><br /><br /><br />זהו זה. בעיית הקידוד נפתרה.<br />יכול להיות שלאחר מעבר ל utf-8 תתקלו <a href="http://phpguide.co.il/b19/Can_not_send_session_cookie_-_headers_already_sent">בבעית ה headers already sent by</a> .', '2010-10-07 16:03:15', 'עברית, סימני שאלה, מסד, utf8, utf-8', 'פתרון בעיית קידוד, סימני שאלה ושליפה בעברית ממסד על ידי שימוש ב utf-8', 1, 1),
(19, 'Can not send session cookie - headers already sent', 'Can_not_send_session_cookie_headers_already_sent', 'http://ncdn.phpguide.co.il/blogimages/headers_sent.jpg', 'בשל השכיחות הגוברת של המחלה הזו, אני חושב שיש צורך במדריך קטן לטיפול בה. ובכן, תרופה מס&#039; 1 - זה כמובן Google , אבל למי שהתעצל לחפש או לא רצה להתעמק בדיונים ארוכים - תזכורת קטנה בשבילכם.', '<div class="php codeblock">Cannot send session cookie <span class="sy0">-</span> headers already sent by <br />\n<span class="br0">&#40;</span>output started at script1<span class="sy0">.</span>php<span class="sy0">:</span><span class="nu0">1</span><span class="br0">&#41;</span> in script2<span class="sy0">.</span>php on line <span class="nu0">2</span></div><br /><br />	אני מצאתי מילון (מקווה שאתם לפחות למדתם אנגלית בבית ספר יותר טוב ממני) ותרגמתי את המשפט ככה:<br /><br /><h5>		לא יכול לשלוח את הסשן קוקי - כותרים כבר נשלחו עלי ידי הפלט שהתחיל ב..</h5><br />	פה אנחנו צריכים להכיר קצת את מבנה התקשורת ברשת. כאשר דפדפן ושרת מדברים אחד עם השני, הם שולחים אחד לשני מכתבים. כמו כל מכתב, המכתב הזה מורכב מראש מכתב, עם כתובת השולח, כתובת המען, לוגו של החברה, תאריך ועוד. כמו כן גם יש את גוף המכתב, שמכיל את כל הhtml עצמו שעל הדפדפן יש להציג.<br />	כל cookie (גם סשן קוקי)&amp;nbsp; נשלח בראש המכתב ולא בתוכן המכתב. כלומר תחילה על php לייצר את ראש המכתב headers ולאחריו כבר לייצר את כל ה-html שאנחנו צריכים. ברגע שאנחנו מייצרים את ה-html, הפלט הראשון שלנו, אוטומטית php חושבת שסיימנו לייצר את ראש המכתב, כותבת אותו על דף וממשיכה לכתוב את התוכן.<br />	אין לנו אפשרות להוסיף עוד לראש המכתב אחרי שכבר התחלנו לכתוב את התוכן. לא השארנו מקום.<br /><br /><h3>		קודם header אחרי זה תוכן</h3><br />	השגיאה שלנו אומרת שבשורה 2 של סקריפט2 אנחנו מנסים לשלוח header כלשהו. אבל, עוד בשורה1 של סקריפט אחד התחיל הפלט וphp חתמה את חלקת הheaderים. מה שעלינו לעשות הוא להעביר את הפלט אחרי יצירת הקוקי.<br />	פלט יכול להיות echo כלשהו, חתיכת טקסט שמופיע בתחילת הקובץ מחוץ לתגי הphp, סימן רווח לפני התג הראשון או byte order mark עליו אספר בהמשך. כל שעלינו לעשות, הוא לנטרל את הפלט ולדאוג לheaderים להישלח לפני הפלט. בואו ננסה ביחד<br /><br /><br /><div class="php codeblock">&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; <br />\n&quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;<br />\n&lt;html xmlns=&quot;http://www.w3.org/1999/xhtml&quot;&gt;<br />\n&lt;head&gt;<br />\n&nbsp; &nbsp; &lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot; /&gt;<br />\n&nbsp; &nbsp; &lt;title&gt;Cannot send session cookie - headers already sent&lt;/title&gt;<br />\n&lt;/head&gt;<br />\n&lt;body&gt;<br />\n<span class="kw2">&lt;?php</span><br />\n&nbsp; &nbsp; <span class="kw3">session_start</span><span class="br0">&#40;</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="co1">// Sending header</span><br />\n<br />\n&nbsp; &nbsp; <span class="kw1">if</span><span class="br0">&#40;</span> <span class="re0">$_GET</span><span class="br0">&#91;</span><span class="st_h">''password''</span><span class="br0">&#93;</span> <span class="sy0">==</span> <span class="st_h">''1234''</span> <span class="br0">&#41;</span><br />\n&nbsp; &nbsp; <span class="br0">&#123;</span><br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="kw1">echo</span> <span class="st_h">''Correct password''</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="kw3">setcookie</span><span class="br0">&#40;</span><span class="st0">&quot;loggedin&quot;</span><span class="sy0">,</span><span class="st_h">''true''</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="co1">// Sending header</span><br />\n&nbsp; &nbsp; <span class="br0">&#125;</span><br />\n&nbsp; &nbsp; <span class="kw1">else</span><br />\n&nbsp; &nbsp; <span class="br0">&#123;</span><br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="kw1">echo</span> <span class="st_h">''Incorrect password''</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; &nbsp; &nbsp; <span class="kw3">setcookie</span><span class="br0">&#40;</span><span class="st0">&quot;loggedin&quot;</span><span class="sy0">,</span><span class="st_h">''false''</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="co1">// Sending header</span><br />\n&nbsp; &nbsp; <span class="br0">&#125;</span><br />\n<span class="sy1">?&gt;</span><br />\n&lt;/body&gt;<br />\n&lt;/html&gt;</div><br /><br /><br />	בדוגמה הזו יש לנו שלוש מקומות שבהם נוצר header. אבל, לפני שהם בכלל נוצרים מופיע לנו הרבה פלט שמועבר ללקוח כפי שהו, עוד לפני שphp בכלל מגיע לקוד. אנחנו צריכים להעביר את כל הקוד שיוצר headerים לראש העמוד, אבל את הפלט נרצה להשאיר בתוך הbody באמצע העמוד. יש רעיונות?<br /><br /><br /><div class="php codeblock"><span class="kw2">&lt;?php</span><br />\n<br />\n<span class="kw3">session_start</span><span class="br0">&#40;</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="co1">// sending header</span><br />\n<br />\n<span class="kw1">if</span><span class="br0">&#40;</span> <span class="re0">$_GET</span><span class="br0">&#91;</span><span class="st_h">''password''</span><span class="br0">&#93;</span> <span class="sy0">==</span> <span class="st_h">''1234''</span> <span class="br0">&#41;</span><br />\n<span class="br0">&#123;</span><br />\n&nbsp; &nbsp; <span class="re0">$output</span> <span class="sy0">=</span> <span class="st_h">''Correct password''</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; <span class="kw3">setcookie</span><span class="br0">&#40;</span><span class="st0">&quot;loggedin&quot;</span><span class="sy0">,</span><span class="st_h">''true''</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="co1">// sending header</span><br />\n<span class="br0">&#125;</span><br />\n<span class="kw1">else</span><br />\n<span class="br0">&#123;</span><br />\n&nbsp; &nbsp; <span class="re0">$output</span> <span class="sy0">=</span> <span class="st_h">''Incorrect password''</span><span class="sy0">;</span><br />\n&nbsp; &nbsp; <span class="kw3">setcookie</span><span class="br0">&#40;</span><span class="st0">&quot;loggedin&quot;</span><span class="sy0">,</span><span class="st_h">''false''</span><span class="br0">&#41;</span><span class="sy0">;</span> <span class="co1">// sending header</span><br />\n<span class="br0">&#125;</span><br />\n&nbsp; &nbsp; <br />\n<span class="sy1">?&gt;</span>&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; <br />\n&quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;<br />\n&lt;html xmlns=&quot;http://www.w3.org/1999/xhtml&quot;&gt;<br />\n&lt;head&gt;<br />\n&nbsp; &nbsp; &lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot; /&gt;<br />\n&nbsp; &nbsp; &lt;title&gt;Cannot send session cookie - headers already sent&lt;/title&gt;<br />\n&lt;/head&gt;<br />\n&lt;body&gt;<br />\n<span class="kw2">&lt;?php</span> <span class="kw1">echo</span> <span class="re0">$output</span><span class="sy0">;</span> <span class="sy1">?&gt;</span><br />\n&lt;/body&gt;<br />\n&lt;/html&gt;</div><br />	<br />כל הheaderים יווצרו לפני כל פלט שהוא וההודעה שלנו תופיעה בדיוק איפו שרצינו.<br /><h3>		Byte Order Mark או מה אם אין לי שום פלט לפני?</h3><br />	בעולם המחשבים של היום קיימים קידודים שונים. קידוד הוא האופן שבו תווים נשמרים במחשב. יש קידודים, שבהם כל תו תופס בדיוק byte אחד, דוגמאת windows-1255. כמות התווים השונים שיש בקידוד הזה היא מאוד מוגבלת. מחרוזת בקידוד הזה יכולה להכיל רק תווים מקבוצת תווים מסוימת. במקרה הזה אלו הם אותיות השפה העברית, השפה האנגלית, מספרים ועוד מעט תווים אחרים.<br />	ואם נרצה לכתוב טקסט בשפה אחרת, שהקידוד הזה לא מכיר דרך לשמור ולייצג? כאן אנחנו נתקלים במובלות של הקידוד הזה. במקרה הזה נעבור לשימוש בקידוד שמכיל תווים מהשפה שבה אנחנו משתמשים. אבל גם הקידוד ההוא יכלול רק את אותה שפה ואנגלית.<br /><h4>		utf-8 הוא קידוד שמכיל תווים של הרבה שפות.</h4><br />	לאומת זאת, הקידוד הזה מורכב מזוג של שני בייתים לייצוג של כל תו. לקידוד הזה יש אח יותר גדול utf-16 (שלנו אין בו שימוש). גם הוא מורכב משני בייתים לתו, אבל לאומת utf-8 אין לו אחידות בנוגע לסדר הבייתים בתו. מעבדים מסוימיים שומרים את הביית השני לפני הביית הראשון, מה שיוצר בלבול כאשר אותו קובץ מגיע למחשב עם מעבד אחר. הפתרון שהומצע היה לכתוב בתחילת הקובץ תו מיוחד שיסמל את סדר הבייטים. שמו של התו הזה, כפי שניחשתם נכון הוא byte order mark<br />	משום מה, הרבה עורכים, וביניהם notepad, דוחפים את ה-byte order mark גם לקבצים ששמורים בקידוד הutf-8, למרות שאין לו שום קשר למקום. התו הזה לא מוצג על ידי עורכי טקסט, אך מבחינת מפענח הphp הוא קיים שם ומועבר כפלט לדפדפן.<br /><h5>		יש לכבות את הbyte order mark בעורך טקסט שלכם על מנת לפטור את הבעיה.</h5><br />	ואני מקווה שבעית הhedearים לא תחזור אליכם שוב.', '2010-10-01 15:00:46', 'headers sent, output started, שגיאה, headers already sent, session cookie', 'הסבר ופתרון לתקלהCan not send session cookie - headers already sent', 1, 1);





CREATE TABLE IF NOT EXISTS `blog_categories` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`cat_id`, `name`) VALUES
(1, 'ביצועים ואופטימיזציה'),
(2, 'מבנה הסקריפט'),
(3, 'mysql');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blogid` mediumint(8) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `author` varchar(25) NOT NULL,
  `text` text NOT NULL,
  `approved` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `date` (`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=396 ;

--
-- Dumping data for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_plain` (
  `id` mediumint(9) NOT NULL,
  `plain_description` text NOT NULL,
  `plain_content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_plain`
--

INSERT INTO `blog_plain` (`id`, `plain_description`, `plain_content`) VALUES
(16, 'מה יותר מהיר, serialize או json_encode,  לבדוק שהקובץ קיים או פשוט לעשות require_once ועוד כמה טיפים של איזה קוד עובד יותר מהר', 'הכללתי ברשימה הקצרה רק דברים שמפתיעים מתכנתים מתחילים ולא כללתי דברים\r\n	ברורים מאליו כמו שימוש בגרש יחידה במקום גרשיים כפולות למחרוזות ודומיהן.\r\n	אני מקווה שמישהו יצא מכאן עם משהו חדש.\r\n\r\n\r\nהתוצאות ומסקנות נשענות על בסיס של ניסויים בכמה גרסאות php\r\n5.2.6 debian lenny, 5.3.2 של ubuntu, ו 5.2.14 של dotdeb.\r\nאולי על פלאטפורמות אחרות יש הבדלים.\r\n\r\n\r\n[h2]file_get_contents[/h2]\r\n\r\nהפונקציה הנחמדה הזו משתמשת [url=http://en.wikipedia.org/wiki/Mmap]במיפוי זיכרון[/url] מה שמביא לגידול בולט בביצועים, באיחוד בקבצים גדולים. המשמעות היא ש:\r\n[php]simplexml_load_string (file_get_contents (''file.xml''));[/php]\r\nעובד יותר מהר מ:\r\n[php]simplexml_load_file(''file.xml'');[/php]\r\nנראה כי הפונקציה simplexml_load_file מתבססת על fopen / fread קונבנציאונאלי, מה שמוביל להבדל במהירות.\r\n\r\nנ.ב. עדיף להישתמש בזה לא רק בפונקציות של xml , הרי גם פונקציות אחרות יאיצו כתוצאה.לדוגמא, אם אתם מנסים לקרוא קובץ ולהפריד אותו לפי שורות לתוך מערך, אזי עדיף להחליף את file() ב\r\n[php]explode(PHP_EOL, file_get_contents(''file.xml''));[/php]\r\n\r\n[h2][ltr]()count[/ltr] ו [ltr]()sizeof[/ltr][/h2]\r\n[ltr]sizeof[/ltr] היא כינוי(פסאודונים) לפונקציה [ltr]count[/ltr] אך משום מה היא עובדת מהר יותר.\r\n\r\n\r\n\r\n[h2]שגיאות ו [ltr]notices[/ltr][/h2]\r\nלהרשות לאפליקציה לזרוק [ltr]notice[/ltr] הוא אחד המנהגים הגרועים ביותר בעולם התכנות. אפליקציה טובה יודעת להתמודד עם שגיאות בעצמה.\r\nאבל אם אתם לא מוכנים לקבל על עצמכם את החשיבות במניעת שגיאות, פשוט דעו לכם\r\nשהזמן הדרוש לphp להתמודד עם שגיאה גדול מהזמן שיקח לכם לרוץ על מערך עם 30 אלמנטים ולהגדיל כל אחד מהאלמנטים שלו באחד.\r\nאגב השימוש ב [b]@ היא קטסטרופה[/b] כדרך למניעת שגיאות.\r\n\r\nכן והיא גם הרבה יותר איטית מהוספה של בדיקה האם המשתנה קיים למשל.\r\n\r\n\r\n\r\n\r\n[h2]foreach[/h2]\r\n\r\nבכל מאמר על ביצועים דואגים לומר את הדברים הכי גרועים על [ltr]foreach[/ltr]\r\nלמרות שבפועל לא הכל כל כך רע. הרבה פעמים מבנים שאנשים מנסים לכתוב כתחליף, דוגמאת:\r\n\r\n[php] while (list($key, $value) = each($item))[/php]\r\nפועלים הרבה יותר לאט וגרוע בכ-30 -40 אחוז.\r\nאך עדיין שימו לב, אם יש באפשרותכם להשתמש ב [ltr]for[/ltr] אזי הוא יהיה עדיף על [ltr]foreach[/ltr]\r\n\r\n\r\n\r\n[h2]JSON vs XML[/h2]\r\nאוסיף כאן רק שאחרי מעבר לקבצי json לשמירת הגדרות במקום xml הרווחתי 20%-30% בביצועים. [ltr]json[/ltr] נעים לעין, איאררכי ומהיר.\r\n[ltr]json_decode[/ltr] עובדת יותר מהר עם פרמטר אחד (כאשר יוצרת אובייקט ולא מערך)\r\n\r\n\r\n\r\n[h2][ltr]mb_ereg[/ltr] vs [ltr]preg_match[/ltr][/h2]\r\nביטויים רגולריים בדרך כלל משתמשים במנוע ה-[ltr][url=http://en.wikipedia.org/wiki/POSIX]posix[/url][/ltr] .כדי לקרוא ולפענח מחרוזות. מנוע ה-posix ידוע באיטיות שלו, לכן\r\nמנוע [ltr][url=http://en.wikipedia.org/wiki/Oniguruma]oniguruma[/url][/ltr] שבו משתמשת [ltr]mb_ereg[/ltr] לרוב יהיו בחירה טובה יותר לחייפ הרגולריים שלכםץ\r\nבערך בשניים מתוך שלושה מקרים [ltr]mb_ereg[/ltr] יעקוף בביצועים את [ltr]preg_match[/ltr]\r\n\r\n\r\n\r\n\r\n[h2]file_exists & include[/h2]\r\nאם אתם לא בטוחים שהקובץ קיים ([ltr]autoload__[/ltr] למשל) תועילו לעצמכם לבדוק האם הקובץ קיים לפני שאתם עושים לו אינקלוד.\r\nעוד בקשר לאינקלוד: משום מה, לשמור במערך את שמות הקבצים שכבר הוספו יותר אפפקטיבי מלהשתמש ב [ltr]include_once[/ltr] ולא באמת ברור לי למה.\r\n(כל האמור תקף גם ל[ltr]require[/ltr])\r\n\r\n\r\n\r\n[h2]Static vars[/h2]\r\nהדרך הטובה והבטוחה לשמור נתונים בשדה הרעיה הגלובאלי היא בתוך משתנים סטאטיים של מחלקה כלשהי. כייון שהם סטאטיים php יודעת לנהל אותם הרבה יותר טוב מכל משתנה במחלקה או לא במחלקה שהוא. שימו לב, לרוב השימוש בקבועים [ltr]constants[/ltr] הוא איטי נורא, לכן עדיף להימנע מכך במידת האפשר.\r\n\r\n\r\n\r\n[h2]כמה המלצות לסיום[/h2]\r\nתציגו לעצמכם את זמן הפעולה של סקריפט במילישניות. עם שינוי כזה בקנה המידה\r\nרואים את ההבדל בין "התבצע ב0.1 שניות" לאומת "התבצע ב100 מילישניות" .\r\nגם קריא יותר וגם יעלה לכם את המוטיבציה לשפר עוד קצת.\r\n\r\n\r\nמאוד חשוב לאסוף מידע לא רק אודות הביצוע של הסקריפט כולו אלה גם של חלקים נפרדים שלו: גרעין, אינטרפייס, רנדרינג, ועוד את הפרופיילר שלי קינפגתי (בשרת הבדיקות) לזרוק שגיאה כאשר קטע כלשהו לוקח זמן רב מדי מהצפוי:\r\n[ltr] "Attention!: 30% of the time taken for mysql connection"[/ltr]\r\n\r\n\r\n\r\n[i]כל המסקנות נלקחו מבדיקות במערכת שלי ויכול להיות שתתקלו בתוצאות שונות אצלכם.[/i]'),
(17, 'כל מערכת מורכבת משלושה חלקים: הנתונים, העיצוב שבו הם מוצגים\r\nוהמנגן של התזמורת, זה שמחליט איזה נתונים ובאיזה עיצוב להציג.', 'יש משהו קטן ומעצבן שהורס כל קוד והוא דווקא ה-html. בגללו נגרמים סירבולים מיותרים של סוגריים מסולסלות, פתיחות וסירות תגי php והרבה קטעים בלתי קשורים מפריעים לעין והבנת הקוד.\r\n\r\nבפוסט הזה אני רוצה להכיר לכם את ההפרדה בין php לבין כל מה שמסביבו.  נראה איך אנחנו מפיקים את המרב מתבנית העיצוב Model-Viewer-Controller ומה זה הדינוזאור הזה בכלל.\r\n\r\n\r\n[h1] מה זה MVC: Model Viewer Controller ?[/h1]\r\n\r\n		בואו נסתכל רגע על התוכנה שלנו ונפשט אותה מעת. \r\n\r\n		אנחנו צריכים לקבל נתון מהלקוח, לעשות איתו משהו ולהציג תוצאה כלשהי בתוך עיצוב כלשהו. למשל, כדי להציג את העמוד הספציפי הזה, הסקריפט היה צריך לקבל מאיתנו את שם העמוד המבוקש, לשלוף את תוכנו מהמסד ולהציג אותו בעיצוב של האתר.\r\n\r\n		מה היה קורה אילו היינו מבקשים עמוד אחר? הסקריפט היה צריך לקבל את שם העמוד, לשלוף תוכן שונה הפעם, אבל להציג באותו עיצוב. ואם הייתם מבצעים חיפוש באתר, הפעם היה נכנס לפעולה סריפט אחר שעושה חיפוש במסד, אבל עדיין מציג הכל באותו עיצוב.\r\n\r\n\r\nהעיצוב הקבוע הוא המודל — תבנית בה מוצגים הנתונים. המודל זהה לרוב העמודים באתר לכן נוציא אותו החוצה מהסקריפט עצמו לקובץ נפרד. דוגמה?\r\n\r\n	[h1]שעון ה-MVC שלנו[/h1][h3]model: תבנית הצגה[/h3]\r\n\r\n		בואו נבנה סקריפט שמציג את השעה בתוך תבנית עיצוב קבוע.\r\n		את התבנית שלנו באופן קבוע ירכיבו שני אלמנטים. ברכת שלום למשתמש והשעה עצמה.\r\n		עמוד שלנו נראה קבוע ואפשר להוציא המודל שלו לקובץ html נפרד שיראה בערך ככה:\r\n\r\n	[php]<html>\r\n<body bgcolor="green">\r\n\r\nHi Mr. Neo<br/>\r\nThe current time is: 01:37\r\n\r\n</body>\r\n</html>\r\n\r\n[/php]\r\n\r\n	[h3]controller: מה השעה אדוני המבקר[/h3]\r\n\r\n		הקונטרולר (בקר בעברית) אחראי על הפעולות והתוכן שאנחנו צריכים. לדוגמה האתר שלנו פשוט מציג את השעה — אזי המטרה של הקונטרולר היא לחשב את השעה. כאן בעצם נמצא הסקריפט הפועל שיש להפריד מה-html . הקוד שעושה את העבודה שלנו.\r\n\r\n	[php]<?php \r\n\r\n// יוצרים את התוכן\r\n$time = date("H:i");\r\n$name = "Mr. Neo";\r\n[/php]\r\n\r\n	[h3]Viewer: מציג את הכל ביחד[/h3]\r\n\r\n		החלק אחרון של המשוואה מחבר את כל החלקים ביחד. כאן נכנס סקריפט נוסף לפעולה האחראי על הצגת התוצאה. תכירו, מר viewer .\r\n\r\n		המטרה שלו, היא להכניס את התוכן שיצר הקונטרולר במקום המיועד לו במודל. כדי להקל עליו בפעולתו, אנחנו נשנה מאט את מבנה המודל בצוראה הבאה:\r\n\r\n[php]<html>\r\n\r\n<body bgcolor="green">\r\n\r\nHi {{ name }}.<br/>\r\nThe current time is: {{ time }}\r\n\r\n</body>\r\n</html>\r\n\r\n[/php]\r\n\r\n			עכשיו כל מה שעלינו לעשות, זה להגיד ל-viewer שלנו לקחת את הנתונים שיצר הקונטרולר ולהציב אותם במקום המתאים במודל באמצעות החלפת מחרוזות פשוטה באופן הבא:\r\n\r\n[php]<?php \r\n$output = str_replace\r\n(\r\n    Array( "{{ name }}", "{{ time }}" ), \r\n    Array($name , $time), \r\n    $model\r\n);\r\n[/php]\r\n\r\n	[h1]שלושת חלקי ה-MVC יחדיו[/h1]\r\ncontroller - index.php\r\n[php]<?php \r\n\r\n// יוצרים את התוכן\r\n$time = date("d/m/y H:i:s"); \r\n$name = "אליהו הנביא"; \r\n[/php]\r\n	\r\nviewer.php	\r\n[php]\r\n$output = str_replace\r\n(\r\n    Array( "{{ name }}", "{{ time }}" ), \r\n    Array($name , $time), \r\n    $model\r\n);\r\n[/php]\r\n\r\nmodel.htm\r\n[php]\r\n<html>\r\n<body bgcolor="green">\r\n\r\nHi {{ name }}. <br/>\r\nThe current time is: {{ time }}\r\n\r\n</body>\r\n</html>\r\n[/php]\r\n\r\nלרוב ישמש ה-controller כנקודת כניסה לסקריפט. בפניה אליו ייצור ה-controller את התוכן המתאים לאותו עמוד ויגרום ל-viewer להכניס אותו ל-model המתאים.\r\n\r\n[h2]מסדרים הכל ביחד[/h2]\r\n		כאשר אנחנו פונים לindex.php הוא יוצר את התוכן. עכשיו עלינו לקרוא ל-viewer כדי שיציב את הערכים החדשים בדוגמנית (model) שלנו. נעשה include לקובץ ה-viewer שלנו. אבל לפני שהוא מבצע את העבודה שלו, עלינו להגדיר לו את משתנה הmodel. זה מה שיצא:\r\n\r\n[php]<?php\r\n$time = date("d/m/y H:i:s");\r\n$name = rand(1,100) ; //o\r\n\r\n// הכנסת המודל למשתנה \r\n$model = file_get_contents(''model.htm'');\r\n\r\n// קריא ל- viewer\r\ninclude ''viewer.php'';\r\n\r\n// הצגת הפלט\r\necho $output;\r\n[/php]\r\nנסו להפעיל את הקוד הזה ולהבין את אופן פעולתו.\r\n\r\n	[h1]מערכת mvc יותר מתקדמת[/h1]\r\n\r\nכדי שהמערכת תהיה רחבה יותר ותתאים לשלל עמודים שונים, נרצה לבנות viewer משוכלל יותר, שיידע לעבוד עם כל תבנית וכל משתנה שיועבר אליו.\r\n נשכתב מעט את ה-viewer הזה כדי שלא יהיה תלוי בקונטרולר ובמשתנים שבו.\r\n\r\n[i]האות A בהערות נמצאת שם ליישור הקוד לשמאל ולא מסמלתדבר[/i]\r\n[php]<?php\r\nfunction viewer( $params, $model )\r\n{\r\n    // A נבדוק שקובץ עם התבנית קיים וניתן לקריאה\r\n    if(!file_exists($model) || !is_readable($model)) \r\n    {\r\n        echo "Error: failed to load the template $model";\r\n        return false;\r\n    }\r\n\r\n    // A אם כן - נתען אותו לזכרון\r\n    $model = file_get_contents($model);\r\n   \r\n    // A נקבל את רשימת שמות המשתנים\r\n    $keys = array_keys($params);\r\n    \r\n    // A נוסיף לכל אחד מהם את סימון המשתנה שלנו\r\n    for( $i = 0; $i < sizeof($keys); $i++) \r\n        $keys[$i] = ''{{ ''.$keys[$i].'' }}'';\r\n    \r\n    // A נבצע את ההצבה של המשתנים במודל\r\n    return str_replace( $keys, $params, $model);\r\n}\r\n[/php]\r\n\r\n		עכשיו אנחנו יכולים להשתמש בו גם עם קונטרולרים ומודלים אחרים.\r\nיהיה עלינו רק לרשום את שמות המשתנים בתבנית באותו אופן (בתוך זוג סוגריים מסולסלות) ולדאוג שהבקר של אותו עמוד הכן ייצור את המשתנים הללו.\r\n[php]<?php\r\n\r\n//A יוצרים את התוכן\r\n$data = Array( ''time'' =>  date("d/m/y H:i:s") ,  ''name'' =>"אליהו הנביא");\r\n\r\n//A מחברים את הviewer\r\ninclude ''viewer.php'';\r\n\r\n// A מדפיסים את התוצאה\r\necho viewer ( $data, ''model.htm'' );\r\n[/php]\r\n\r\n		אבל מה קורה אם אנחנו רוצים עוד אפשרויות? מה אם אנחנו רוצים להציג בלוקים שלמים של תוכן תלוי במשתנה? מה אם אנחנו רוצים להצי תוכן כלשהו בלולאה ועדיין להשאיר את ה-html מחוץ לקוד ה-php .\r\n\r\n		במקרים האלה אנחנו נצטרך לפתח viewer חזק יותר, עם יותר אפשרויות שיודע לענות ליותר דרישות. אבל במקום שנבזבז את הזמן שלנו על זה, למה שלא נשתמש במשהו מוכן? בכתבה הבאה אני יספר לכם על [url=http://twig-project.org]Twig-project[/url] , ה-template engine שיצר והציג את העמוד הזה.'),
(39, 'השירות http://loadimpact.com מאפשר לכם לראות איך התנהג ויגיב האתר שלכם עם עד 50 גולשים ב זמנית. בואו לבדוק את האתר שלכם.', '[img]http://habreffect.ru/files/f47/5da1a83fe/loadimpact.png[/img]\r\n\r\nהאם האתר עומד בלחצים?\r\nקבוצת [url=http://loadimpact.com/]Load Impact[/url] השיקה שירות חדש המאפשר לבדוק זמן תגובה של השרת תוך דימוי של 50 גולשים במקביל לאתר שלכם. הגרף למעלה מתאר את זמן התגובה של phpguide.co.il\r\n\r\n\r\nלשירות שני מסלולים.\r\n[url=http://loadimpact.com]החינמי[/url] - עד 50 גולשים.\r\nבתשלום - 9$ עד 250 גולשים, בדיקות קיבולת מרביות, בדיקות לאורך זמן [url=http://loadimpact.com/products.php?basic]ועוד[/url].'),
(20, 'אם הופיעו לכם סימני שאלה וציורים סיניים במקום עברית העמוד, פנו למדריך הזה לעזרה וטפלו במושג שנקרא קידוד אחת ולתמיד.', 'מה, הוא מטומטם? למה הוא מציג לי סימני שאלה וג''יבריש במקום עברית?\r\nהסיבה לסימני השאלה האלה תמונה במילה לא ברורה ושמה קידוד. קידוד, הוא האופן שבו שומר המחשב אצלו את תווי הטקסט שמהם מורכבת המחרוזת. אבל לפעמים, הוא לא כל כך מצליח.\r\n\r\n\r\n[h1]מה לי ולקידוד?[/h1]\r\nהרבה מאוד שפות מדוברות מסביב לכדור הארץ וכמעט כל אחת מהן מוצאת את עצמה על גבי מסכי המחשב. בכל שפה אותיות שונות, נראות שונה, נכתבות שונה ויוצרות בעיות שמירה שונות.\r\n\r\nבעבר שמרו כל תו (אות) כbyte אחד בזכרון. מכיוון שכל byte היה מורכב משמונה bitים, היו סה"כ 255 אותיות שהמחשב ידע לעבוד איתם. כאן להיסטוריה נכנסה המצאה גאונית שנקראה - קידוד. קידוד היה אוסף של 255 אותיות שאיתו המחשב היה עובד. \r\n\r\nבקידוד אחד את 255 התווים האלה תפסו אנגלית, רוסית וספרות. (cp1251)\r\nקידוד אחר היה מורכב מ255 תווים שהיו לאנגלית, צרפתית וספרות. (cp1252)\r\nקידוד שלישי היה אנגלית, עברית וספרות.  (cp1255)\r\n\r\nכל הבעיות מתחילות אם יש לנו מחרוזת שמורכבת מכמה שפות או אם הקידוד הנבחר לא מכיל את אותיות השפה שאיתה אנו עובדים. אז מה, אי אפשר לעבוד בשני שפות?\r\n\r\n[h1]UTF-8[/h1]\r\nזהו קידוד שמורכב הפעם מיותר מbyte אחד לתו (בין 1 ל4 בייתים), מה שמרחיב את כמות התווים שהוא מסוגל לשמור. הקידוד מסוגל לשמור תווים של הרבה מאוד שפות והוא בדיוק מה, שאנחנו צריכים.\r\n\r\n[h2]להגדיר קידוד בחמישה מקומות[/h2]\r\n[h3]1. בקובץ שאיתו אנחנו עובדים[/h3]\r\nכאן נכנס לפעולה העורך טקסט שלנו. בכל עורך טקסט אפשר להגדיר את קידוד הקובץ או בחלון ההגדרות או בחלון השמירה. בnotepad זה [url=http://habreffect.ru/files/3ab/b63ed7fc1/screen.png]נראה ככה[/url].\r\n\r\n[h3]2. ליידע את הדפדפן והשרת באיזו שפה הם מדברים[/h3]\r\nכאן יהיה עלינו להוסיף שני שורות קוד.\r\nהראשונה היא תג מתה שיש לשים בתוך דף ה-html עבור הדפדפן\r\nוהשניה היא השורה הראשונה שאמורה להימצא בקוד שלכם תמיד. מתוך הרגל.\r\n\r\n[php]<?php header(''Content-Type: text/html; charset=utf-8''); ?>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8">\r\n[/php]\r\n\r\n\r\n[h3]3. ליידע את המסד וphp באיזו שפה הם מדברים[/h3]\r\nכאן יהיה עלינו להגדיר את קידוד ההתחברות אל מסד הנתונים, כדי שהתעבורה בין תוכנת מסד הנתונים והסקריפט שלכם לא תאבד לכם אותיות באמצע.\r\n\r\n[php]<?php \r\n$db = mysql_connect(''localhost'',''1'',''2'');\r\nmysql_select_db(''mydb'',$db);\r\nmysql_query("SET NAMES ''utf8''",$db);\r\n[/php]\r\n\r\n[h3]4. לדאוג שהמסד שומר נתונים בקידוד נכון.[/h3]\r\nכאשר אנחנו יוצרים טבלה יש לנו אפשרות להגדיר את הקידוד של כל שדה בטבלה בנפרד. הקידוד שאנחנו רוצים נקרא utf8_general_ci . יש לבחור בו בעת היצירה והוא ידאג לתקינות הנתונים שלנו לצמיתות.\r\n\r\n[img]http://habreffect.ru/files/de9/f28752886/untitled1.png[/img]\r\n\r\n\r\n\r\nזהו זה. בעיית הקידוד נפתרה.\r\nיכול להיות שלאחר מעבר ל utf-8 תתקלו [url=http://phpguide.co.il/b19/Can_not_send_session_cookie_-_headers_already_sent]בבעית ה headers already sent by[/url] .'),
(19, 'בשל השכיחות הגוברת של המחלה הזו, אני חושב שיש צורך במדריך קטן לטיפול בה. ובכן, תרופה מס'' 1 - זה כמובן Google , אבל למי שהתעצל לחפש או לא רצה להתעמק בדיונים ארוכים - תזכורת קטנה בשבילכם.', '[php]Cannot send session cookie - headers already sent by \r\n(output started at script1.php:1) in script2.php on line 2[/php]\r\n\r\n	אני מצאתי מילון (מקווה שאתם לפחות למדתם אנגלית בבית ספר יותר טוב ממני) ותרגמתי את המשפט ככה:\r\n\r\n[h3]		לא יכול לשלוח את הסשן קוקי - כותרים כבר נשלחו עלי ידי הפלט שהתחיל ב..[/h3]\r\n	פה אנחנו צריכים להכיר קצת את מבנה התקשורת ברשת. כאשר דפדפן ושרת מדברים אחד עם השני, הם שולחים אחד לשני מכתבים. כמו כל מכתב, המכתב הזה מורכב מראש מכתב, עם כתובת השולח, כתובת המען, לוגו של החברה, תאריך ועוד. כמו כן גם יש את גוף המכתב, שמכיל את כל הhtml עצמו שעל הדפדפן יש להציג.\r\n	כל cookie (גם סשן קוקי)&nbsp; נשלח בראש המכתב ולא בתוכן המכתב. כלומר תחילה על php לייצר את ראש המכתב headers ולאחריו כבר לייצר את כל ה-html שאנחנו צריכים. ברגע שאנחנו מייצרים את ה-html, הפלט הראשון שלנו, אוטומטית php חושבת שסיימנו לייצר את ראש המכתב, כותבת אותו על דף וממשיכה לכתוב את התוכן.\r\n	אין לנו אפשרות להוסיף עוד לראש המכתב אחרי שכבר התחלנו לכתוב את התוכן. לא השארנו מקום.\r\n\r\n[h1]		קודם header אחרי זה תוכן[/h1]\r\n	השגיאה שלנו אומרת שבשורה 2 של סקריפט2 אנחנו מנסים לשלוח header כלשהו. אבל, עוד בשורה1 של סקריפט אחד התחיל הפלט וphp חתמה את חלקת הheaderים. מה שעלינו לעשות הוא להעביר את הפלט אחרי יצירת הקוקי.\r\n	פלט יכול להיות echo כלשהו, חתיכת טקסט שמופיע בתחילת הקובץ מחוץ לתגי הphp, סימן רווח לפני התג הראשון או byte order mark עליו אספר בהמשך. כל שעלינו לעשות, הוא לנטרל את הפלט ולדאוג לheaderים להישלח לפני הפלט. בואו ננסה ביחד\r\n\r\n\r\n[php]<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" \r\n"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n    <title>Cannot send session cookie - headers already sent</title>\r\n</head>\r\n<body>\r\n<?php\r\n    session_start(); // Sending header\r\n\r\n    if( $_GET[''password''] == ''1234'' )\r\n    {\r\n        echo ''Correct password'';\r\n        setcookie("loggedin",''true''); // Sending header\r\n    }\r\n    else\r\n    {\r\n        echo ''Incorrect password'';\r\n        setcookie("loggedin",''false''); // Sending header\r\n    }\r\n?>\r\n</body>\r\n</html>[/php]\r\n\r\n\r\n	בדוגמה הזו יש לנו שלוש מקומות שבהם נוצר header. אבל, לפני שהם בכלל נוצרים מופיע לנו הרבה פלט שמועבר ללקוח כפי שהו, עוד לפני שphp בכלל מגיע לקוד. אנחנו צריכים להעביר את כל הקוד שיוצר headerים לראש העמוד, אבל את הפלט נרצה להשאיר בתוך הbody באמצע העמוד. יש רעיונות?\r\n\r\n\r\n[php]<?php\r\n\r\nsession_start(); // sending header\r\n\r\nif( $_GET[''password''] == ''1234'' )\r\n{\r\n    $output = ''Correct password'';\r\n    setcookie("loggedin",''true''); // sending header\r\n}\r\nelse\r\n{\r\n    $output = ''Incorrect password'';\r\n    setcookie("loggedin",''false''); // sending header\r\n}\r\n    \r\n?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" \r\n"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n    <title>Cannot send session cookie - headers already sent</title>\r\n</head>\r\n<body>\r\n<?php echo $output; ?>\r\n</body>\r\n</html>\r\n[/php]\r\n	\r\nכל הheaderים יווצרו לפני כל פלט שהוא וההודעה שלנו תופיעה בדיוק איפו שרצינו.\r\n[h1]		Byte Order Mark או מה אם אין לי שום פלט לפני?[/h1]\r\n	בעולם המחשבים של היום קיימים קידודים שונים. קידוד הוא האופן שבו תווים נשמרים במחשב. יש קידודים, שבהם כל תו תופס בדיוק byte אחד, דוגמאת windows-1255. כמות התווים השונים שיש בקידוד הזה היא מאוד מוגבלת. מחרוזת בקידוד הזה יכולה להכיל רק תווים מקבוצת תווים מסוימת. במקרה הזה אלו הם אותיות השפה העברית, השפה האנגלית, מספרים ועוד מעט תווים אחרים.\r\n	ואם נרצה לכתוב טקסט בשפה אחרת, שהקידוד הזה לא מכיר דרך לשמור ולייצג? כאן אנחנו נתקלים במובלות של הקידוד הזה. במקרה הזה נעבור לשימוש בקידוד שמכיל תווים מהשפה שבה אנחנו משתמשים. אבל גם הקידוד ההוא יכלול רק את אותה שפה ואנגלית.\r\n[h2]		utf-8 הוא קידוד שמכיל תווים של הרבה שפות.[/h2]\r\n	לאומת זאת, הקידוד הזה מורכב מזוג של שני בייתים לייצוג של כל תו. לקידוד הזה יש אח יותר גדול utf-16 (שלנו אין בו שימוש). גם הוא מורכב משני בייתים לתו, אבל לאומת utf-8 אין לו אחידות בנוגע לסדר הבייתים בתו. מעבדים מסוימיים שומרים את הביית השני לפני הביית הראשון, מה שיוצר בלבול כאשר אותו קובץ מגיע למחשב עם מעבד אחר. הפתרון שהומצע היה לכתוב בתחילת הקובץ תו מיוחד שיסמל את סדר הבייטים. שמו של התו הזה, כפי שניחשתם נכון הוא byte order mark\r\n	משום מה, הרבה עורכים, וביניהם notepad, דוחפים את ה-byte order mark גם לקבצים ששמורים בקידוד הutf-8, למרות שאין לו שום קשר למקום. התו הזה לא מוצג על ידי עורכי טקסט, אך מבחינת מפענח הphp הוא קיים שם ומועבר כפלט לדפדפן.\r\n[h3]		יש לכבות את הbyte order mark בעורך טקסט שלכם על מנת לפטור את הבעיה.[/h3]\r\n	ואני מקווה שבעית הhedearים לא תחזור אליכם שוב.');
-- --------------------------------------------------------

--
-- Table structure for table `blog_post2cat`
--

CREATE TABLE IF NOT EXISTS `blog_post2cat` (
  `postid` smallint(5) unsigned NOT NULL,
  `catid` smallint(5) unsigned NOT NULL,
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_post2cat`
--

INSERT INTO `blog_post2cat` (`postid`, `catid`) VALUES
(16, 1),
(39, 1),
(17, 2),
(19, 3),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `code_tinyurl`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `views` smallint(5) unsigned NOT NULL DEFAULT '0',
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `filename`, `views`, `downloads`) VALUES
(1, 'WhiteLove', 'WhiteLove', 57, 4),
(2, 'fruit site', 'templatemo_206_fruit_site', 82, 4),
(3, 'light gray', 'templatemo_207_light_gray', 62, 2),
(4, 'global', 'templatemo_208_global', 92, 17),
(5, 'simple blue', 'templatemo_210_simple_blue', 76, 5),
(6, 'education', 'templatemo_213_education', 50, 5),
(7, 'shoe store', 'templatemo_215_shoe_store', 56, 5),
(8, 'greeny', 'templatemo_218_greeny', 68, 15),
(9, 'wall', 'templatemo_221_wall', 45, 4),
(10, 'corporate', 'templatemo_222_corporate', 65, 16),
(11, 'wedding store', 'templatemo_224_wedding_store', 42, 5),
(12, 'light space', 'templatemo_229_light_space', 46, 5),
(13, 'general', 'templatemo_231_general', 42, 3),
(14, 'portfolio', 'templatemo_234_portfolio', 42, 3),
(15, 'business', 'templatemo_235_business', 37, 4),
(16, 'extreme', 'templatemo_237_extreme', 33, 3),
(17, 'pro teal', 'templatemo_239_pro_teal', 32, 3),
(18, 'multi layer', 'templatemo_241_multi_layer', 45, 4),
(19, 'web design', 'templatemo_243_web_design', 42, 4),
(20, 'club', 'templatemo_246_club', 38, 3),
(21, 'world', 'templatemo_248_world', 29, 6),
(22, 'eye candy', 'templatemo_253_eye_candy', 25, 3),
(23, 'black fox', 'templatemo_256_black_fox', 35, 3),
(24, 'yellow cafe', 'templatemo_259_yellow_cafe', 19, 4),
(25, 'urban city', 'templatemo_263_urban_city', 29, 2),
(26, 'light house', 'templatemo_265_light_house', 24, 2),
(27, 'pineapple', 'templatemo_269_pineapple', 28, 3),
(28, 'holiday', 'templatemo_270_holiday', 44, 3),
(29, 'christmas night', 'templatemo_272_christmas_night', 45, 4),
(30, 'christmas red', 'templatemo_273_christmas_red', 30, 3),
(31, 'orange', 'templatemo_274_orange', 39, 3),
(32, 'connection', 'templatemo_275_connection', 44, 4),
(33, 'cafe bakery', 'templatemo_278_cafe_bakery', 43, 2),
(34, 'family', 'templatemo_279_family', 35, 3),
(35, 'chrome', 'templatemo_281_chrome', 80, 12);

-- --------------------------------------------------------

--
-- Table structure for table `unauth`
--

CREATE TABLE IF NOT EXISTS `unauth` (
  `ip` varchar(15) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `ip` (`ip`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unauth`
--

INSERT INTO `unauth` (`ip`, `time`) VALUES
('127.0.0.1', '2011-07-17 00:18:34'),
('127.0.0.1', '2011-07-17 00:18:42');

-- --------------------------------------------------------

--
-- Table structure for table `zzsmf_members`
--

CREATE TABLE IF NOT EXISTS `zzsmf_members` (
  `id_member` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `member_name` varchar(80) NOT NULL DEFAULT '',
  `date_registered` int(10) unsigned NOT NULL DEFAULT '0',
  `posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `id_group` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lngfile` varchar(255) NOT NULL DEFAULT '',
  `last_login` int(10) unsigned NOT NULL DEFAULT '0',
  `real_name` varchar(255) NOT NULL DEFAULT '',
  `instant_messages` smallint(5) NOT NULL DEFAULT '0',
  `unread_messages` smallint(5) NOT NULL DEFAULT '0',
  `new_pm` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `buddy_list` text NOT NULL,
  `pm_ignore_list` varchar(255) NOT NULL DEFAULT '',
  `pm_prefs` mediumint(8) NOT NULL DEFAULT '0',
  `mod_prefs` varchar(20) NOT NULL DEFAULT '',
  `message_labels` text NOT NULL,
  `passwd` varchar(64) NOT NULL DEFAULT '',
  `openid_uri` text NOT NULL,
  `email_address` varchar(255) NOT NULL DEFAULT '',
  `personal_text` varchar(255) NOT NULL DEFAULT '',
  `gender` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `birthdate` date NOT NULL DEFAULT '0001-01-01',
  `website_title` varchar(255) NOT NULL DEFAULT '',
  `website_url` varchar(255) NOT NULL DEFAULT '',
  `location` varchar(255) NOT NULL DEFAULT '',
  `icq` varchar(255) NOT NULL DEFAULT '',
  `aim` varchar(255) NOT NULL DEFAULT '',
  `yim` varchar(32) NOT NULL DEFAULT '',
  `msn` varchar(255) NOT NULL DEFAULT '',
  `hide_email` tinyint(4) NOT NULL DEFAULT '0',
  `show_online` tinyint(4) NOT NULL DEFAULT '1',
  `time_format` varchar(80) NOT NULL DEFAULT '',
  `signature` text NOT NULL,
  `time_offset` float NOT NULL DEFAULT '0',
  `avatar` varchar(255) NOT NULL DEFAULT 'http://ncdn.phpguide.co.il/noavatar.jpg',
  `pm_email_notify` tinyint(4) NOT NULL DEFAULT '0',
  `karma_bad` smallint(5) unsigned NOT NULL DEFAULT '0',
  `karma_good` smallint(5) unsigned NOT NULL DEFAULT '0',
  `usertitle` varchar(255) NOT NULL DEFAULT '',
  `notify_announcements` tinyint(4) NOT NULL DEFAULT '1',
  `notify_regularity` tinyint(4) NOT NULL DEFAULT '1',
  `notify_send_body` tinyint(4) NOT NULL DEFAULT '0',
  `notify_types` tinyint(4) NOT NULL DEFAULT '2',
  `member_ip` varchar(255) NOT NULL DEFAULT '',
  `member_ip2` varchar(255) NOT NULL DEFAULT '',
  `secret_question` varchar(255) NOT NULL DEFAULT '',
  `secret_answer` varchar(64) NOT NULL DEFAULT '',
  `id_theme` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `is_activated` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `validation_code` varchar(10) NOT NULL DEFAULT '',
  `id_msg_last_visit` int(10) unsigned NOT NULL DEFAULT '0',
  `additional_groups` varchar(255) NOT NULL DEFAULT '',
  `smiley_set` varchar(48) NOT NULL DEFAULT '',
  `id_post_group` smallint(5) unsigned NOT NULL DEFAULT '0',
  `total_time_logged_in` int(10) unsigned NOT NULL DEFAULT '0',
  `password_salt` varchar(255) NOT NULL DEFAULT '',
  `ignore_boards` text NOT NULL,
  `warning` tinyint(4) NOT NULL DEFAULT '0',
  `passwd_flood` varchar(12) NOT NULL DEFAULT '',
  `pm_receive_from` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `is_registered` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `full_name` varchar(50) DEFAULT NULL,
  `is_blog_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `last_site_visit` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_member`),
  UNIQUE KEY `member_name_2` (`member_name`),
  KEY `member_name` (`member_name`),
  KEY `real_name` (`real_name`),
  KEY `date_registered` (`date_registered`),
  KEY `id_group` (`id_group`),
  KEY `birthdate` (`birthdate`),
  KEY `posts` (`posts`),
  KEY `last_login` (`last_login`),
  KEY `lngfile` (`lngfile`(30)),
  KEY `id_post_group` (`id_post_group`),
  KEY `warning` (`warning`),
  KEY `total_time_logged_in` (`total_time_logged_in`),
  KEY `id_theme` (`id_theme`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=403 ;

--
-- Dumping data for table `zzsmf_members`
--

INSERT INTO `zzsmf_members` (`id_member`, `member_name`, `date_registered`, `posts`, `id_group`, `lngfile`, `last_login`, `real_name`, `instant_messages`, `unread_messages`, `new_pm`, `buddy_list`, `pm_ignore_list`, `pm_prefs`, `mod_prefs`, `message_labels`, `passwd`, `openid_uri`, `email_address`, `personal_text`, `gender`, `birthdate`, `website_title`, `website_url`, `location`, `icq`, `aim`, `yim`, `msn`, `hide_email`, `show_online`, `time_format`, `signature`, `time_offset`, `avatar`, `pm_email_notify`, `karma_bad`, `karma_good`, `usertitle`, `notify_announcements`, `notify_regularity`, `notify_send_body`, `notify_types`, `member_ip`, `member_ip2`, `secret_question`, `secret_answer`, `id_theme`, `is_activated`, `validation_code`, `id_msg_last_visit`, `additional_groups`, `smiley_set`, `id_post_group`, `total_time_logged_in`, `password_salt`, `ignore_boards`, `warning`, `passwd_flood`, `pm_receive_from`, `is_registered`, `full_name`, `is_blog_admin`, `last_site_visit`) VALUES
(1, 'admin', 1300443411, 636, 1, 'hebrew-utf8', 1311436449, 'admin', 46, 0, 0, '', '', 1, '', '', 'dd94709528bb1c83d08f3088d4043f4742891f4f', '', 'email@phpguide.co.il', '', 1, '1900-01-01', '', '', 'ישראל', '', '', '', '', 0, 1, '', '', 0, '', 1, 0, 0, '', 1, 1, 0, 2, '127.0.0.1', '127.0.0.1', '', '', 3, 1, '', 1752, '', '', 8, 60, 'abcd', '', 0, '', 1, 1, 'שם משתמש', 1, 0);
-- --------------------------------------------------------

--
-- Table structure for table `zzsmf_themes`
--

CREATE TABLE IF NOT EXISTS `zzsmf_themes` (
  `id_member` mediumint(8) NOT NULL DEFAULT '0',
  `id_theme` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `variable` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`id_theme`,`id_member`,`variable`(30)),
  KEY `id_member` (`id_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zzsmf_themes`
--

INSERT INTO `zzsmf_themes` (`id_member`, `id_theme`, `variable`, `value`) VALUES
(1, 1, 'cust_37', 'ניתן לשינוי בטבלת zzsmf_themes');



CREATE TABLE IF NOT EXISTS `zzsmf_messages` (
  `id_msg` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_topic` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `id_board` smallint(5) unsigned NOT NULL DEFAULT '0',
  `poster_time` int(10) unsigned NOT NULL DEFAULT '0',
  `id_member` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `id_msg_modified` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `poster_name` varchar(255) NOT NULL DEFAULT '',
  `poster_email` varchar(255) NOT NULL DEFAULT '',
  `poster_ip` varchar(255) NOT NULL DEFAULT '',
  `smileys_enabled` tinyint(4) NOT NULL DEFAULT '1',
  `modified_time` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_name` varchar(255) NOT NULL DEFAULT '',
  `body` mediumtext NOT NULL,
  `icon` varchar(16) NOT NULL DEFAULT 'xx',
  `approved` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_msg`),
  UNIQUE KEY `topic` (`id_topic`,`id_msg`),
  UNIQUE KEY `id_board` (`id_board`,`id_msg`),
  UNIQUE KEY `id_member` (`id_member`,`id_msg`),
  KEY `approved` (`approved`),
  KEY `ip_index` (`poster_ip`(15),`id_topic`),
  KEY `participation` (`id_member`,`id_topic`),
  KEY `show_posts` (`id_member`,`id_board`),
  KEY `id_topic` (`id_topic`),
  KEY `id_member_msg` (`id_member`,`approved`,`id_msg`),
  KEY `current_topic` (`id_topic`,`id_msg`,`id_member`,`approved`),
  KEY `related_ip` (`id_member`,`poster_ip`,`id_msg`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `zzsmf_topics`
--

CREATE TABLE IF NOT EXISTS `zzsmf_topics` (
  `id_topic` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `is_sticky` tinyint(4) NOT NULL DEFAULT '0',
  `id_board` smallint(5) unsigned NOT NULL DEFAULT '0',
  `id_first_msg` int(10) unsigned NOT NULL DEFAULT '0',
  `id_last_msg` int(10) unsigned NOT NULL DEFAULT '0',
  `id_member_started` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `id_member_updated` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `id_poll` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `id_previous_board` smallint(5) NOT NULL DEFAULT '0',
  `id_previous_topic` mediumint(8) NOT NULL DEFAULT '0',
  `num_replies` int(10) unsigned NOT NULL DEFAULT '0',
  `num_views` int(10) unsigned NOT NULL DEFAULT '0',
  `locked` tinyint(4) NOT NULL DEFAULT '0',
  `unapproved_posts` smallint(5) NOT NULL DEFAULT '0',
  `approved` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_topic`),
  UNIQUE KEY `last_message` (`id_last_msg`,`id_board`),
  UNIQUE KEY `first_message` (`id_first_msg`,`id_board`),
  UNIQUE KEY `poll` (`id_poll`,`id_topic`),
  KEY `is_sticky` (`is_sticky`),
  KEY `approved` (`approved`),
  KEY `id_board` (`id_board`),
  KEY `member_started` (`id_member_started`,`id_board`),
  KEY `last_message_sticky` (`id_board`,`is_sticky`,`id_last_msg`),
  KEY `board_news` (`id_board`,`id_first_msg`),
  KEY `id_last_msg` (`id_last_msg`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;