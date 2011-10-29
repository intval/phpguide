<?php

Class bbcodes
{

    /**
     * Parses bbcodes in string. 
     * @param string $string the string to parse
     * @param string $page_title used as alt in img tags
     * @return string htmlSpecialChars escaped html code 
     * @todo Refactor this allowhtml/page_title shit
     */
    public static function bbcode($string, $page_title, $allow_html = false)
    {

        $string =  preg_replace_callback('#\[php\](.*)\[\/php\]#simU',   array('bbcodes', 'cutcode'), $string);  
        
        
        if($allow_html) 
        {
            $string =  preg_replace_callback('#\[html\](.*)\[\/html\]#simU', array('bbcodes','cuthtml'), $string); 
        }

        // The easy part
        $string = str_replace
        (
            Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[s]','[/s]','[h1]',
            '[/h1]','[h2]','[/h2]','[h3]','[/h3]','[ltr]','[/ltr]',
            '[left]','[/left]'),

            Array('<strong>','</strong>','<em>','</em>','<span class="underline">','</span>','<s>','</s>','<h3>',
            '</h3>','<h4>','</h4>','<h5>','</h5>','<span dir="ltr">','</span>',
            '<span class="dirleft">','</span>'),

            e($string) //htmlspecialchars it
        );


        $string = strtr($string, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />'));
        $string = self::put_code_back($string);



        $patterns = Array
        (
            '/\[url\="?(.*?)"?\](.*?)\[\/url\]/i', 
            '/\[img\s?(left|right)?\](.*?)\[\/img\]/i',
            '@\[color=([a-z0-9#]+)\](.*)\[/color\]@iU', 
            '#\[youtube\].*?v\=([a-z0-9\-_]+)&?.*?\[/youtube\]#i'
        ) ;

        $rep = Array
        (
            '<a href="\\1">\\2</a>', 
            '<img src="/static/images/pixel.gif" alt="'.$page_title.'" title="\\2" class="content-image-float\\1"/>',
            '<span style="color:\\1;">\\2</span>',
            '<iframe width="480" height="390" src="http://www.youtube.com/embed/\\1?rel=0" frameborder="0" allowfullscreen></iframe>'
        );

        return trim(preg_replace($patterns, $rep, $string));
    }






    private static function geshime($code)
    {
        static $geshi;
        if( is_null($geshi))  
        {
            $geshi = new GeSHi($code, 'php');
            $geshi->set_header_type(GESHI_HEADER_DIV);
            $geshi->enable_classes();
            $geshi->enable_keyword_links(false);
            $geshi->set_encoding('utf-8');
            $geshi->set_overall_class('codeblock');
            $geshi->set_tab_width(2);
        }
        else $geshi->set_source($code);
        return $geshi->parse_code();
    }

    
    private static function cuthtml($arr)
    {
        global $codes;  
        $r = rand().'{ax;jfi{html}}';

        $codes[$r] = trim($arr[1]); 
        return $r;
    }

    private static function cutcode($arr)
    {
        global $codes;  
        $r = rand().'{ax;jfi{code}}';

        $codes[$r] = self::geshime(trim($arr[1])); 
        return $r;
    }

    private static function put_code_back($val)
    {
        global $codes; if( sizeof($codes) === 0) return $val;
        return str_replace(array_keys($codes), $codes, $val);
    }

    function store_replace($x)
    { 
            global $fold; 
            $fold = $x[1]; 
            return 'axf(80i,0SBSotjw';
    }



    /**
     * bbcode sets images to be <img src='somealttext' title='http://image.url'>
     * This function puts everything back (for rss use basically);
     * @param string $html the html requiring transformation
     * @ 
     */
    public static function fix_lazyload_src($html)
    {
        static $pattern = array 
        (
            '#src="/static/images/pixel\.gif" alt="(.*)" (.*)title="(.*)"#Uui',
            '#class="content-image-float(left|right)"#'
        );

        static $replacement = array('src="\\3" alt="\\1" title="\\1" \\2', 'style="float:\\1"');
        return preg_replace($pattern, $replacement, $html);
    }




}