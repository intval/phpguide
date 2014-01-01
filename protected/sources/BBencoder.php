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
        $this->string =  preg_replace_callback('#\[php\](.*)\[\/php\]#simU',   array($this, 'cutphpcode'), $this->string);

        $this->string =  preg_replace_callback('#\[code=('.implode('|', self::$geshiLanguages).')\](.*)\[\/code\]#simU',   array($this, 'cutcode'), $this->string); //

        // cuts out html blocks
        if($this->allow_html)
        {
        	$this->string =  preg_replace_callback('#\[html\](.*)\[\/html\]#simU', array($this,'cuthtml'), $this->string);
        }
    }
    
    private function cuthtml($arr)
    {
    	$r = rand().'{ax;jfi{html}}';
    	$this->cuts[$r] = trim($arr[1]);
    	return $r;
    }

    private function cutphpcode($arr)
    {
        array_splice($arr, 1, 0, ['php']);
        return $this->cutcode($arr);
    }

    private function cutcode($arr)
    {
    	$r = rand().'{ax;jfi{code}}';
    	$this->cuts[$r] = $this->colorCodeWithGeshi(trim($arr[2]), $arr[1]);
    	return $r;
    }
    
    private function colorCodeWithGeshi($code, $language = 'php')
    {
    	if(is_null(self::$geshiInstance))
    	{
    		self::$geshiInstance = new GeSHi();
            self::$geshiInstance->set_header_type(GESHI_HEADER_DIV);
    		self::$geshiInstance->enable_classes();
    		self::$geshiInstance->enable_keyword_links(false);
    		self::$geshiInstance->set_encoding('utf-8');
    		self::$geshiInstance->set_overall_class('codeblock');
    		self::$geshiInstance->set_tab_width(2);
    	}

        self::$geshiInstance->set_language($language);
        self::$geshiInstance->set_source($code);
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
            '#\[youtube\].*?v\=([a-z0-9\-_]+)&?.*?\[/youtube\]#i',
            '#(^|\s)@([A-Za-z0-9א-ת\.\-_]+)($|\s)#ui'
        ) ;

        $rep = Array
        (
            '<strong>\\1</strong>',
            '<em>\\1</em>',
            '<span class="underline">\\1</span>',
            '<s>\\1</s>',
            '<h2>\\1</h2>',
            '<h3>\\1</h3>',
            '<h4>\\1</h4>',
            '<span dir="ltr">\\1</span>',
            '<span class="dirleft">\\1</span>',
            '<a href="\\1\\2">\\3</a>',
            '<img src="/static/images/pixel.gif" alt="'.htmlSpecialChars($this->page_title, ENT_QUOTES | ENT_HTML5 | ENT_SUBSTITUTE).'" title="\\2" class="content-image-float\\1"/>',
            '<span style="color:\\1;">\\2</span>',
            '<iframe width="480" height="390" src="http://www.youtube.com/embed/\\1?rel=0" frameborder="0" allowfullscreen></iframe>',
            '\\1<a href="/users/\\2">@\\2</a>\\3',
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
     */
    public function fix_lazyload_src()
    {
        static $pattern =
        [
            '#src="/static/images/pixel\.gif" alt="(.*)" (.*)title="(.*)"#Uui',
            '#class="content-image-float(left|right)"#'
        ];

        static $replacement = ['src="\\3" alt="\\1" title="\\1" \\2', 'style="float:\\1"'];
        return preg_replace($pattern, $replacement, $this->string);
    }


    public static function autoLtr($str)
    {
        static $pattern = "#([a-z\$]+[a-z\$_\-\&\s\(\)\{\}\"\';]+[a-z\$\&\(\)\{\}\"\';]+)#ium";
        static $replacement = '<span dir="ltr">\1</span>';
        return preg_replace($pattern, $replacement, $str);
    }



    private static $geshiLanguages = array (
        0 => '4cs',
        1 => '6502acme',
        2 => '6502kickass',
        3 => '6502tasm',
        4 => '68000devpac',
        5 => 'abap',
        6 => 'actionscript',
        7 => 'actionscript3',
        8 => 'ada',
        9 => 'algol68',
        10 => 'apache',
        11 => 'applescript',
        12 => 'sources',
        13 => 'arm',
        14 => 'asm',
        15 => 'asp',
        16 => 'asymptote',
        17 => 'autoconf',
        18 => 'autohotkey',
        19 => 'autoit',
        20 => 'avisynth',
        21 => 'awk',
        22 => 'bascomavr',
        23 => 'bash',
        24 => 'basic4gl',
        25 => 'bf',
        26 => 'bibtex',
        27 => 'blitzbasic',
        28 => 'bnf',
        29 => 'boo',
        30 => 'c',
        31 => 'loadrunner',
        32 => 'mac',
        33 => 'caddcl',
        34 => 'cadlisp',
        35 => 'cfdg',
        36 => 'cfm',
        37 => 'chaiscript',
        38 => 'cil',
        39 => 'clojure',
        40 => 'cmake',
        41 => 'cobol',
        42 => 'coffeescript',
        43 => 'qt',
        44 => 'cpp',
        45 => 'csharp',
        46 => 'css',
        47 => 'cuesheet',
        48 => 'd',
        49 => 'dcl',
        50 => 'dcpu16',
        51 => 'dcs',
        52 => 'delphi',
        53 => 'diff',
        54 => 'div',
        55 => 'dos',
        56 => 'dot',
        57 => 'e',
        58 => 'ecmascript',
        59 => 'eiffel',
        60 => 'email',
        61 => 'epc',
        62 => 'erlang',
        63 => 'euphoria',
        64 => 'f1',
        65 => 'falcon',
        66 => 'fo',
        67 => 'fortran',
        68 => 'freebasic',
        69 => 'freeswitch',
        70 => 'fsharp',
        71 => 'gambas',
        72 => 'gdb',
        73 => 'genero',
        74 => 'genie',
        75 => 'gettext',
        76 => 'glsl',
        77 => 'gml',
        78 => 'gnuplot',
        79 => 'go',
        80 => 'groovy',
        81 => 'gwbasic',
        82 => 'haskell',
        83 => 'haxe',
        84 => 'hicest',
        85 => 'hq9plus',
        86 => 'html4strict',
        87 => 'html5',
        88 => 'icon',
        89 => 'idl',
        90 => 'ini',
        91 => 'inno',
        92 => 'intercal',
        93 => 'io',
        94 => 'j',
        95 => 'java',
        96 => 'java5',
        97 => 'javascript',
        98 => 'jquery',
        99 => 'kixtart',
        100 => 'klonec',
        101 => 'klonecpp',
        102 => 'latex',
        103 => 'lb',
        104 => 'ldif',
        105 => 'lisp',
        106 => 'llvm',
        107 => 'locobasic',
        108 => 'logtalk',
        109 => 'lolcode',
        110 => 'lotusformulas',
        111 => 'lotusscript',
        112 => 'lscript',
        113 => 'lsl2',
        114 => 'lua',
        115 => 'm68k',
        116 => 'magiksf',
        117 => 'make',
        118 => 'mapbasic',
        119 => 'matlab',
        120 => 'mirc',
        121 => 'mmix',
        122 => 'modula2',
        123 => 'modula3',
        124 => 'mpasm',
        125 => 'mxml',
        126 => 'mysql',
        127 => 'nagios',
        128 => 'netrexx',
        129 => 'newlisp',
        130 => 'nsis',
        131 => 'oberon2',
        132 => 'objc',
        133 => 'objeck',
        134 => 'brief',
        135 => 'ocaml',
        136 => 'octave',
        137 => 'oobas',
        138 => 'oorexx',
        139 => 'oracle11',
        140 => 'oracle8',
        141 => 'oxygene',
        142 => 'oz',
        143 => 'parasail',
        144 => 'parigp',
        145 => 'pascal',
        146 => 'pcre',
        147 => 'per',
        148 => 'perl',
        149 => 'perl6',
        150 => 'pf',
        151 => 'brief',
        152 => 'php',
        153 => 'pic16',
        154 => 'pike',
        155 => 'pixelbender',
        156 => 'pli',
        157 => 'plsql',
        158 => 'postgresql',
        159 => 'povray',
        160 => 'powerbuilder',
        161 => 'powershell',
        162 => 'proftpd',
        163 => 'progress',
        164 => 'prolog',
        165 => 'properties',
        166 => 'providex',
        167 => 'purebasic',
        168 => 'pycon',
        169 => 'pys60',
        170 => 'python',
        171 => 'q',
        172 => 'qbasic',
        173 => 'rails',
        174 => 'rebol',
        175 => 'reg',
        176 => 'rexx',
        177 => 'robots',
        178 => 'rpmspec',
        179 => 'rsplus',
        180 => 'ruby',
        181 => 'sas',
        182 => 'scala',
        183 => 'scheme',
        184 => 'scilab',
        185 => 'sdlbasic',
        186 => 'smalltalk',
        187 => 'smarty',
        188 => 'spark',
        189 => 'sparql',
        190 => 'sql',
        191 => 'stonescript',
        192 => 'systemverilog',
        193 => 'tcl',
        194 => 'teraterm',
        195 => 'text',
        196 => 'thinbasic',
        197 => 'tsql',
        198 => 'twig',
        199 => 'typoscript',
        200 => 'unicon',
        201 => 'upc',
        202 => 'urbi',
        203 => 'uscript',
        204 => 'vala',
        205 => 'vb',
        206 => 'vbnet',
        207 => 'vedit',
        208 => 'verilog',
        209 => 'vhdl',
        210 => 'vim',
        211 => 'visualfoxpro',
        212 => 'visualprolog',
        213 => 'whitespace',
        214 => 'whois',
        215 => 'winbatch',
        216 => 'xbasic',
        217 => 'xml',
        218 => 'conf',
        219 => 'xpp',
        220 => 'yaml',
        221 => 'z80',
        222 => 'zxbasic',
    );

}
