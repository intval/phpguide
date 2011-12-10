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
        private $_articlesAuthor;
        
	/** Show edit form */
	public function actionIndex()
	{
            // Set's class' members to hold the editted article or instances of new one
            $this->load_current_article();
            
            $view_data = array
            (
                'article'  => $this->_articlesModel,
                'plain'  => $this->_plainModel,
                'author' => $this->_articlesAuthor,
                'editting_id'   => $this->_articlesModel->id,
                'categories'    => $this->_articlesCategories,
                'allCategories' => self::tranform_categories_key_value( Category::model()->findAll() )
            );

            $this->addscripts('http://cdn.jquerytools.org/1.2.5/full/jquery.tools.min.js', 'bbcode', 'ui', 'addpage');
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
                $curuser = User::get_current_user();

                // Either such article wasn't found, or teh user doesnt have enough privileges for editing it
                if( $article === null || ($article->author_id != $curuser->id_member && !$curuser->is_blog_admin ) )
                {
                   throw new CHttpException(404);
                }
                else
                {
                    $this->_articlesModel       = & $article;
                    $this->_plainModel          = & $article->plain;
                    $this->_articlesAuthor      = & $article->author;
                    $this->_articlesCategories  =   $article->categories;
                }
            }
            else
            {
                $this->_articlesModel       = new Article;
                $this->_plainModel          = new ArticlePlainText();
                $this->_articlesCategories  = new Category();
                $this->_articlesAuthor      = User::get_current_user();
            }
        }



        
        public function actionSave()
        {
            if(!isset($_POST['Article'], $_POST['Article']['categories'], $_POST['ArticlePlainText']))
            {
                $this->actionIndex();
                return;
            }
            
            // Get editor's info
            $curuser = User::get_current_user();

            // fails if id is not defined, or filter wouldnt validate, or id = 0
            $id = filter_input(INPUT_POST, 'edit', FILTER_VALIDATE_INT);


            if( !$id )
            {
                // Create new instances
                $article        = new Article();
                $articlePlain   = new ArticlePlainText();
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
                if ( $article->author_id != $curuser->id_member && !$curuser->is_blog_admin )
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
            $article->url = preg_replace("/[^a-z0-9_\s".'א-ת'."]/ui", '', $article->title);
            $article->html_content = bbcodes::bbcode($articlePlain->plain_content, $article->title);
            $article->html_desc_paragraph = bbcodes::bbcode($articlePlain->plain_description, $article->title);
            $article->pub_date = new CDbExpression('NOW()');


            // Automatically approve admins posts
            $article->approved = User::get_current_user()->is_blog_admin;

            // If this is a new post. An edited post would have it's original author
            if( is_null($article->author_id ))
            {
                $article->author_id  = $curuser->id_member;
            }


            $trans = Yii::app()->db->beginTransaction();
            try
            {

                // Remember the real persons name. Dont care that much if it fails
                if(!empty($_POST['Author']['full_name']) && empty($curuser->full_name ))
                {
                    $curuser->full_name = $_POST['Author']['full_name'];
                    $curuser->save();
                }

                $article->saveWithRelated('categories');
                $articlePlain->id = $article->id;
                
                // Since this one is MyISAM - transactions wouldnt affect it
                // therefore it's the last to be touched
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
                throw new Exception('Failed to save data, proly because of repeating PK in plainblog tbl');
            }

        }


        private function show_form_on_failure(&$article, &$plain)
        {
            $this->_articlesAuthor =  $article->author;
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
                $article->author = User::get_current_user();
                
                if($articlePlain->validate() && $article->validate())
                {
                    $article->html_content = bbcodes::bbcode($articlePlain->plain_content, $article->title);
                    $article->html_desc_paragraph = bbcodes::bbcode($articlePlain->plain_description, $article->title);
                    $article->pub_date = new DateTime();
                    
                    $this->addscripts('ui');
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
