<?php

/*
 * @property Article $_articlesModel
 * @property Plain $_plainModel
 * @property array $_articlesCategories
 * @property User  $_articlesAuthor
 */
class AddController extends Controller
{

        public $vars;

        private $_articlesModel;
        private $_plainModel;
        private $_articlesCategories;
   
        
        
        
	/** Show edit form */
	public function actionIndex()
	{
            
            // Set's class' members to hold the editted article or instances of new one
            $this->load_current_article();
            
            $view_data = array
            (
                'article'  => $this->_articlesModel,
                'plain'  => $this->_plainModel,
                'editting_id'   => $this->_articlesModel->id,
                'categories'    => $this->_articlesCategories,
                'is_editor_admin'        => !Yii::app()->user->isGuest && Yii::app()->user->is_admin, 
                'allCategories' => self::tranform_categories_key_value( Category::model()->findAll() )
            );

            $this->pageTitle = $this->description = 'הוספת מדריך לימוד PHP חדש';
            $this->keywords = 'חדש, לימוד, PHP'; 
            
            $this->addscripts( 'bbcode', 'addpage');
            $this->render('//article/AddForm',$view_data);
        }
        

        /**
         * Validates request[edit] and finds out whether
         * any post being editted or new post being generated
         * @return void
         */
        private function load_current_article()
        {

            // Assuming the data has been already loaded
            if( !empty($this->_articlesModel) )
            {
                return;
            }


            if(($id = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT)) > 1)
            {
                $article = Article::model()->with('plain', 'author', 'categories')->findByPk($id);
                $curuser = Yii::app()->user;
                
                // Either such article wasn't found, or teh user doesnt have enough privileges for editing it
                if( $article === null || Yii::app()->user->isguest || ($article->author_id != $curuser->id && !$curuser->is_admin ) )
                {
                   throw new CHttpException(404);
                }
                else
                {
                    $this->_articlesModel       = & $article;
                    $this->_plainModel          = & $article->plain;
                    $this->_articlesCategories  =   $article->categories;
                }
            }
            else
            {
                $this->_articlesModel       = new Article;
                $this->_plainModel          = new ArticlePlainText();
                $this->_articlesCategories  = new Category();
            }
        }



        
        public function actionSave()
        {
        	if(Yii::app()->user->isguest)
        	{
        		echo 'רק משתמשים רשומים יכולים לכתוב ולערוך מדריכים';
        		return;
        	}
        	
            if(!isset($_POST['Article'], $_POST['Article']['categories'], $_POST['ArticlePlainText']))
            {
                $this->actionIndex();
                return;
            }
            
            // Get editor's info
            $curuser = Yii::app()->user;

            // fails if id is not defined, or filter wouldnt validate, or id = 0
            $id = filter_input(INPUT_POST, 'edit', FILTER_VALIDATE_INT);

            /**
             * Indicates whether this record we are currently manipulating on is a new record or editted existing one
             * @var bool
             */
            $isNew = false;

            if( !$id )
            {
                // Create new instances
                $article        = new Article();
                $articlePlain   = new ArticlePlainText();
                $isNew =true;
            }
            else
            {
                // Editting inexisting post?
                if( null === ($article = Article::model()->findByPk($id)) )
                {
                    throw new CHttpException(404);
                }

                // Editting post without plain text ?
                if( null === ($articlePlain = ArticlePlainText::model()->findByPk($id)))
                {
                    throw new CHttpException(404);
                }

                // Dont have privileges for editting posts ?
                if (Yii::app()->user->isguest || (  $article->author_id != $curuser->id && !$curuser->is_admin ))
                {
                    throw new CHttpException(404, 'Insuffient privileges');
                }
            }
            


            // Assign post data
            $article      ->attributes  =  $_POST['Article'];
            $articlePlain ->attributes  =  $_POST['ArticlePlainText'];
            $article      ->categories  =  $_POST['Article']['categories'];


            // Check the data obbeys the validation rules
            if(!$articlePlain->validate() || !$article->validate())
            {
                $this->show_form_on_failure($article, $articlePlain);
                return;
            }


            
            // Prepare some custom field values
            
            $contentBBencoder = new BBencoder($articlePlain->plain_content, $article->title, !$curuser->isguest && $curuser->is_admin);
            $descriptionBBencoder = new BBencoder($articlePlain->plain_description, $article->title, !$curuser->isguest && $curuser->is_admin);
            
            $article->html_content = $contentBBencoder->GetParsedHtml();
            $article->html_desc_paragraph = $descriptionBBencoder->GetParsedHtml();
            
            if( $isNew )
            {
                $article->author_id  = $curuser->id;
                $article->pub_date = new SDateTime();
                
                // Automatically approve admins posts
                $article->approved = !$curuser->isguest && $curuser->is_admin;
                
                // seo url based on title
                $article->url = preg_replace("/[^a-z0-9_\s".'א-ת'."]/ui", '', $article->title);
                
            }
            
			
            if( $isNew || isset($_POST['change_permalink']))
			{
				// seo url based on title
				$article->url = preg_replace("/[^a-z0-9_\s".'א-ת'."]/ui", '', $article->title);
			}
            
            

            $trans = Yii::app()->db->beginTransaction();
            try
            {

                $article->saveWithRelated('categories');
                $articlePlain->id = $article->id;
                
                // Since this one is MyISAM - transactions wouldnt affect it
                // therefore it's the first to take save attempt on
                if(!$articlePlain->save())
                {
                    throw new Exception("Couldnt save article's plain represantation");
                }

                $trans->commit();
                $this->redirect( bu(urlencode($article->url) . '.htm') );
            }
            catch (Exception $e)
            {
                $trans->rollback();
                throw new Exception('Failed to save data, proly because of repeating PK in plainblog tbl', 0, $e);
            }

        }


        private function show_form_on_failure(&$article, &$plain)
        {
            $this->_articlesModel  = & $article;
            $this->_plainModel     = & $plain;
            $this->_articlesCategories =  $article->categories;

            $this->actionIndex();
        }


        public function actionPreview()
        {
           
            if(isset($_POST['Article'], $_POST['ArticlePlainText']))
            {
                $article        = new Article();
                $articlePlain   = new ArticlePlainText();
                    
                // Assign post data
                $article      ->attributes  =  $_POST['Article'];
                $articlePlain ->attributes  =  $_POST['ArticlePlainText'];
                $article -> author = Yii::app()->user->isguest ? User::model()->findByPk(7) : Yii::app()->user;
                
                if($articlePlain->validate() && $article->validate())
                {

                    $contentBBencoder = new BBencoder($articlePlain->plain_content, $article->title, !Yii::app()->user->isguest && Yii::app()->user->is_admin);
                    $descriptionBBencoder = new BBencoder($articlePlain->plain_description, $article->title, !Yii::app()->user->isguest && Yii::app()->user->is_admin);

                    $article->html_content = $contentBBencoder->GetParsedHtml();
                    $article->html_desc_paragraph = $descriptionBBencoder -> GetParsedHtml();
                    $article->pub_date = new SDateTime();
                    

                    $this->render('//article/index', array('article' => &$article));
                }
                else
                {
                    $this->show_form_on_failure($article, $articlePlain);
                }
                
            }
            else 
            {
                throw new CHttpException(500, 'No post data provided');
            }
        }



        /**
         * This function converts array(cat_id => 1, name => hi) into array(1 => hi)
         * @param array $list
         * @return array
         */
        private static function tranform_categories_key_value(array $list)
        {
            $result = array();

            for($i = 0, $l = sizeof($list); $i < $l; $i++)
            {
                $result[ $list[$i]['cat_id'] ] = $list[$i]['name'] ;
            }

            return $result;
        }

}
