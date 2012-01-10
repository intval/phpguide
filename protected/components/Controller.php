<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();

        /**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
        /**
         * Facebook microformats data, used to help facebook get an idea what is this page about
         * @var array $facebook
         */
        protected $facebook = array
        (
            'image' => '',            // set after getting host
            'current_page_url' => '', // set at runtime, when request's url is known
            'site_name' => 'מדריך לימוד PHP — phpguide.co.il',
            'admins' => '100001276887326',
            'app_id' => '188852921151034',
            'type' => 'blog'
        );
        
        /**
         * Used to populate meta tags and title
         * @var array $vars
         */
        public $vars = array
        (
                'title'=>'מדריכי לימוד PHP', 
                'keywords'=>'מדריך, לימוד, PHP', 
                'page_author'=>'אלכסנדר רסקין', 
                'description'=>'מדריכים, כתבות, פרסומים, מאמרים ולימוד שיעורי PHP, Apache, Mysql', 
        );
        
        /**
         * This is the action to handle external exceptions.
         */
        public function actionError()
        {
            if(false !== ($error=Yii::app()->errorHandler->error))
            {
                if(Yii::app()->request->isAjaxRequest)
                    echo $error['message'];
                else
                    $this->render('//error', $error);
            }
        }
        
        
        /**
         * Registers client script from URL and adds it to lateload
         * Takes the scripts from static/scripts/___.js folder, automatically appending file extension
         * @param args $script list of arguments, each argument should be a different script
         * @example $this->addscript('ui') results in <script src='static/scripts/ui.js'>
         * @example $this->addscript('ui', 'bbcode', 'http://jquery.com/jquery.js');
         */
        protected function addscripts($scripts)
        {
            foreach (func_get_args() as $url)
            {
                if (mb_substr($url, 0, 7) != "http://")
                {
                    $url = bu("static/scripts/$url.js");
                }
                Yii::app()->clientScript->registerScriptFile($url, CClientScript::POS_END);
            }
        }
        
        /**
         * You are not supposed to call this method directly, i guess
         * @param type $id
         * @param type $module 
         */
        public function __construct($id, $module = null)
        {

            if(!isset($_SERVER["HTTP_USER_AGENT"]) || stristr($_SERVER["HTTP_USER_AGENT"],'facebook') === FALSE)
            {
                // should display microformats metadata only to facebook client
                $this->facebook = null;
            }
            else
            {
                // nginx access apache via internal communications, therefore REQUEST_URI
                // is missing. But nginx kindly pushes that value into another server var.
                $this->facebook['current_page_url'] = 'http://' . $_SERVER['HTTP_HOST'] . (isset($_SERVER["REDIRECT_URL"]) ? $_SERVER["REDIRECT_URL"] : $_SERVER["REQUEST_URI"]);
                $this->facebook['image'] = 'http://' . $_SERVER['HTTP_HOST'] . '/static/images/logo.jpg';
            }
			$this->pageTitle = $this->vars['title'];
			Yii::app()->clientScript->coreScriptPosition = CClientScript::POS_END;
            parent::__construct($id, $module);
        }
        
}



