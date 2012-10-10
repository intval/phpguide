<?php
/**
 * BBEncoder - class that parses bbcodens into html
 *
 * @package    phpguide
 * @subpackage core
 * @author     Alex Raskin (Alex@phpguide.co.il)
 * @copyright  (C) 2012 Alex Raskin
 * @license    BSD Licence as stated in Readme.md
 *
 */

Class BBencoder
{

	private $string;
	private $page_title;
	private $allow_html;
	
	private $cuts = array();
	private static $geshiInstance = null;
	private $hadEncoded = false;
	
	/**
	 * @param string $string - input to parse bbcodes in
	 * @param string $page_title - the title of the page this html gonna be used on (acts as 'alt' for images)
	 * @param bool $allow_html - should allow [html][/html] tags in code ?
	 */
	public function __construct($string, $page_title = '', $allow_html = false)
	{
		$this->string = $string;
		$this->allow_html = $allow_html;
		$this->page_title = $page_title;
	}
	
    /**
     * Parses bbcodes in string. 
     * @return string htmlSpecialChars escaped html code 
     */
    public function GetParsedHtml()
    {
    	if(!$this->hadEncoded) $this->parseBBcode();
        return $this->string;
    }
    
    private function parseBBcode()
    {
    	$this->CutCodeAndHtml();
    	$this->EscapeString();
    	$this->SubstituteBBTags();
    	$this->TranslateLineBreaks();
    	$this->PutCodeAndHtmlBack();
    }
    
    
    private function CutCodeAndHtml()
    {
        // cuts out code blocks
        $this->string =  preg_replace_callback('#\[php\](.*)\[\/php\]#simU',   array($this, 'cutcode'), $this->string);
        
        // cuts out html blocks
        if($this->allow_html)
        	$string =  preg_replace_callback('#\[html\](.*)\[\/html\]#simU', array($this,'cuthtml'), $this->string);
    }
    
    private function cuthtml($arr)
    {
    	$r = rand().'{ax;jfi{html}}';
    	$this->cuts[$r] = trim($arr[1]);
    	return $r;
    }
    
    private function cutcode($arr)
    {
    	$r = rand().'{ax;jfi{code}}';
    	$this->cuts[$r] = $this->colorCodeWithGeshi(trim($arr[1]));
    	return $r;
    }
    
    private function colorCodeWithGeshi($code)
    {
    	if(is_null(self::$geshiInstance))
    	{
    		self::$geshiInstance = new GeSHi($code, 'php');
    		self::$geshiInstance->set_header_type(GESHI_HEADER_DIV);
    		self::$geshiInstance->enable_classes();
    		self::$geshiInstance->enable_keyword_links(false);
    		self::$geshiInstance->set_encoding('utf-8');
    		self::$geshiInstance->set_overall_class('codeblock');
    		self::$geshiInstance->set_tab_width(2);
    	}
    	else self::$geshiInstance->set_source($code);
    	return self::$geshiInstance->parse_code();
    }
    
    
    private function EscapeString()
    {
        $this->string = e(trim($this->string));
    }   
    
    private function SubstituteBBTags()
    {
    
        $patterns = Array
        (
            '/\[b\](.*?)\[\/b\]/ims', 
            '/\[i\](.*?)\[\/i\]/ims', 
            '/\[u\](.*?)\[\/u\]/ims', 
            '/\[s\](.*?)\[\/s\]/ims', 
            '/\[h1\](.*?)\[\/h1\]/ims', 
            '/\[h2\](.*?)\[\/h2\]/ims', 
            '/\[h3\](.*?)\[\/h3\]/ims', 
            '/\[ltr\](.*?)\[\/ltr\]/ims', 
            '@\[left\](.*?)\[/left\]@ims', 
            '/\[url\=(https?:\/\/)([^\]]*)\](.*?)\[\/url\]/i',
            '/\[img\s?(left|right)?\](.*?)\[\/img\]/i',
            '@\[color=([a-z0-9#]+)\](.*)\[/color\]@iUms', 
            '#\[youtube\].*?v\=([a-z0-9\-_]+)&?.*?\[/youtube\]#i'
        ) ;

        $rep = Array
        (
            '<strong>\\1</strong>',
            '<em>\\1</em>',
            '<span class="underline">\\1</span>',
            '<s>\\1</s>',
            '<h3>\\1</h3>',
            '<h4>\\1</h4>',
            '<h5>\\1</h5>',
            '<span dir="ltr">\\1</span>',
            '<span class="dirleft">\\1</span>',
            '<a href="\\1\\2">\\3</a>',
            '<img src="/static/images/pixel.gif" alt="'.e($this->page_title).'" title="\\2" class="content-image-float\\1"/>',
            '<span style="color:\\1;">\\2</span>',
            '<iframe width="480" height="390" src="http://www.youtube.com/embed/\\1?rel=0" frameborder="0" allowfullscreen></iframe>'
        );

        
        $this->string = preg_replace($patterns, $rep, $this->string);
    }
        

    private function TranslateLineBreaks()
    {
        $this->string = strtr($this->string, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />'));
    }
    
    private function PutCodeAndHtmlBack() 
    {
        if( sizeof($this->cuts) > 0)
        {
        	$this->string = str_replace(array_keys($this->cuts), $this->cuts, $this->string);
        }
    }





    /**
     * bbcode sets images to be <img src='somealttext' title='http://image.url'>
     * This function puts everything back (for rss use basically);
     * @param string $html the html requiring transformation
     * @ 
     */
    public static function fix_lazyload_src()
    {
        static $pattern = array 
        (
            '#src="/static/images/pixel\.gif" alt="(.*)" (.*)title="(.*)"#Uui',
            '#class="content-image-float(left|right)"#'
        );

        static $replacement = array('src="\\3" alt="\\1" title="\\1" \\2', 'style="float:\\1"');
        return preg_replace($pattern, $replacement, $this->string);
    }




}