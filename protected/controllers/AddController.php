<?php

/*
 * @Todo add preview
 */
class AddController extends Controller
{

        public $vars;
        
	/** Show edit form */
	public function actionIndex()
	{                          
            if(($id = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT)) !== null)
            {
                $article = Article::model()->with('plain', 'author')->findByPk($id);
                $curuser = User::get_current_user();
                
                // Either such article wasn't found, or teh user doesnt have enough privileges for editing it
                if( $article === null || ($article->author_id != $curuser->id_member && !$curuser->is_blog_admin ) )
                {
                   throw new CHttpException(404);
                }
                else
                {
                    $plain  = & $article->plain;
                    $author = & $article->author;
                }
            }
            else
            {
                $article = new Article;
                $plain = new ArticlePlainText();
                $author = User::get_current_user();
            }
            
            $this->addscripts( 'bbcode', 'ui', 'addpage');
            
            $view_data = array
            (
                'model'=>$article, 
                'plain' => $plain, 
                'author' => $author, 
                'editting_id' => $id !== null ? '?edit='. $id :    ''
            );
            $this->render('//article/AddForm',$view_data);
        }
        
        
        
        
        public function actionSave()
        {
            if(isset($_POST['Article'], $_POST['ArticlePlainText']))
            {
                $curuser = User::get_current_user();
                
                // fails if id is not defined, or filter fails, or id = 0
                if( $id = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT) )
                {
                    if(    null === ($article = Article::model()->findByPk($id))  ||
                           null === ($articlePlain = ArticlePlainText::model()->findByPk($id)) ||
                           ($article->author_id != $curuser->id_member && !$curuser->is_blog_admin )
                      )
                    {
                        throw new CHttpException(404);
                    }
                }
                else
                {
                    $article        = new Article();
                    $articlePlain   = new ArticlePlainText();
                }
                
                
                // Assign post data
                $article      ->attributes  =  $_POST['Article'];
                $articlePlain ->attributes  =  $_POST['ArticlePlainText'];
                        
                if($articlePlain->validate() && $article->validate())
                {
                    $article->url = preg_replace("/[^א-תa-z_]/ui", '', $article->title);
                    $article->html_content = bbcodes::bbcode($articlePlain->plain_content, $article->title);
                    $article->html_desc_paragraph = bbcodes::bbcode($articlePlain->plain_description, $article->title);
                    $article->pub_date = new CDbExpression('NOW()');
                    
                    // Automatically approve admins posts
                    $article->approved = User::get_current_user()->is_blog_admin;
                    
                    if( is_null($article->author_id )) 
                    {
                        $article->author_id  = $curuser->id_member;
                    }
                    
                    if(!empty($_POST['Author']['full_name']) && empty(User::get_current_user()->full_name ))
                    {
                        $curuser->full_name = $_POST['Author']['full_name'];
                        $curuser->save();
                    }
                    
                    $article->save();
                    $articlePlain->id = $article->id;
                    $articlePlain->save();
                    return;
                }
                else
                {
                    echo self::show_errors($article) , self::show_errors($articlePlain);
                }
            }
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
                
                if($articlePlain->validate() && $article->validate())
                {
 
                    $article->html_content = bbcodes::bbcode($articlePlain->plain_content, $article->title);
                    $article->html_desc_paragraph = bbcodes::bbcode($articlePlain->plain_description, $article->title);
                    $article->pub_date = new DateTime();
                    $article->author = User::get_current_user();
                    
                    $this->addscripts('ui');
                    $this->render('//article/index', array('article' => &$article));
                }
                else
                {
                    echo self::show_errors($article) , self::show_errors($articlePlain);
                }
                
            }
            else 
            {
                throw new CHttpException(500, 'No post data provided');
            }
        }
	
        /**
         * Iterates over the list of model validation errors returning them as string
         * @param CActiveRecord $model
         * @return string
         */
        private static function show_errors(CActiveRecord $model)
        {
            $out = '';
            foreach( $model->getErrors() as $field_errors)
            {
               $out .= implode('<br/>', $field_errors) . '<br/>';
            }
            return $out;
        }
}
