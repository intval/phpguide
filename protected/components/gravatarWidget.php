<?php
/**
 * @package Yii Framework < http://yiiframework.com >
 * @subpackage Widgets
 * @author Vadim Gabriel , http://vadimg.com/ < vadimg88@gmail.com >
 * @copyright 
 * 
 * 
 * Installation Instructions:
 * --------------------------
 * 
 * 1. Download the extension
 * 2. Unzip the file contents
 * 3. Upload the VGGravatarWidget.php file to the extensions folder located under WebRoot/protected/extensions
 * 4. Read Usage Instructions.
 * 
 * 
 * Requirements:
 * -------------
 * 
 * * This should work on all Yii versions (That has widgets working in them), But was tested on version 1.0.9 & 1.1.x .
 * 
 * 
 * Usage:
 * ---------------
 * Inside your view file just paste the following code:
 * 
 * $this->widget('application.extensions.VGGravatarWidget', 
 * 			    											array(
 *																  'email' => 'myemail@mydomain.com', // email to display the gravatar belonging to it
 *																  'hashed' => false, // if the email provided above is already md5 hashed then set this property to true, defaults to false
 *																  'default' => 'http://www.mysite.com/default_gravatar_image.jpg', // if an email is not associated with a gravatar this image will be displayed,
 * 																																   // by default this is omitted so the Blue Gravatar icon will be displayed you can also set this to
 * 																																   // "identicon" "monsterid" and "wavatar" which are default gravatar icons
 *																  'size' => 50, // the gravatar icon size in px defaults to 40
 * 																  'rating' => 'PG', // the Gravatar ratings, Can be G, PG, R, X, Defaults to G
 * 																  'htmlOptions' => array( 'alt' => 'Gravatar Icon' ), // Html options that will be appended to the image tag
 * 															));
 * 
 * 
 * 
 * 
 * 
 */
class GravatarWidget extends CWidget
{
	/**
	 * @var string - Email we will use to generate the Gravatar Image  
	 */
	public $email = '';
	
	/**
	 * @var boolean - set this to true if the email is already md5 hashed
	 */
	public $hashed = false;
	
        
        /**
         * When true returns the gravatar url, without the image tag
         * @var bool $linkOnly
         */
        public $linkOnly = false;
        
	/**
	 * @var string - Enter the default image displayed if the 
	 * Email provided to display the Gravatar does not have one.
	 * There are "special" values that you may pass to this parameter which produce dynamic default images. 
	 * These are "identicon" "monsterid" and "wavatar". 
	 * If omitted we will serve up our default image, the blue G. 
	 * A new parameter, 404, has been added to allow the return of an HTTP 404 error instead of any 
	 * image or redirect if an image cannot be found for the specified email address. 
	 * 
	 */
	public $default = '';
	
	/**
	 * @var int - Gravatar Size in px, Defaults to 40px
	 */
	public $size = 40;
	
	/**
	 * @var string - the Gravatar default rating
	 * Can be G, PG, R, X
	 *
	 * G rated gravatar is suitable for display on all websites with any audience type.
 	 *
	 * PG rated gravatars may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
	 *
	 * R rated gravatars may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
	 *
	 * X rated gravatars may contain hardcore sexual imagery or extremely disturbing violence.
	 *
	 */
	public $rating = 'G';
	
	/**
	 * @var array - any HTML options that will be passed to the IMG tag
	 */
	public $htmlOptions = array();
	
	/**
	 * Gravatar Url
	 */
	const GRAVATAR_URL = 'http://www.gravatar.com/avatar/';
	
	/**
	 * @var string - the final constructed URL
	 */
	protected $url = '';
	
	/**
	 * @var array - url params
	 */
	protected $params = array();
	
	/**
	 * Widget Constructor
	 */
	public function init()
	{	
		// Email
		$this->url .= $this->hashed ? strtolower( $this->email ) . '?' : md5( strtolower( $this->email ) ) . '?';
		
		// Size
		$this->params['s'] = (int) $this->size;
		
		// Rating
		$this->params['r'] = $this->rating;
		
		// Default
		if( $this->default != '' )
		{
			$this->params['d'] = $this->default;
		}
		
                if ('' === $this->email)
                {
                    $this->params['d'] = 'mm'; 
                    // mm = mystery man, according to http://en.gravatar.com/site/implement/images/
                }
                
		$array = array();
		foreach( $this->params as $key => $value )
		{
			$array[] = $key . '=' . $value;
		}
		
		$this->url .= implode('&', $array);
	}
	
	/**
	 * Run Widget and display
	 */
	public function run()
	{
            $url = self::GRAVATAR_URL . $this->url;
            $alt = isset($this->htmlOptions['alt']) ? $this->htmlOptions['alt'] : 'avatar';
            
            if($this->linkOnly) echo $url;
            else echo CHtml::image($url, $alt, $this->htmlOptions);
	}
	
}