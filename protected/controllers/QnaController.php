<?php

class QnaController extends Controller
{
    
    public function actionIndex()
    {
        $this->addscripts('ui'); 
        $this->render('index' ,array
            (
            'articles' => Article::model()->newest()->findAll(),
            'wallPosts' => WallPost::model()->findAll(),
            'qnas' => QnaQuestion::model()->with('author')->findAll()
            ) );
    }
    
    public function actionNew()
    {
        if(isset($_POST['QnaQuestion']))
        {
            $model = new QnaQuestion();
            $model->attributes = $_POST['QnaQuestion'];

            $model->authorid = User::get_current_user()->id_member;
            
            $model->html_text = bbcodes::bbcode($model->bb_text, $model->subject);

            if( $model->validate() )
            {
                $model->save();
                $this->renderPartial('//qna/qnaHomeItem', array('qna' => &$model));
            }
            else
            {
                echo 'err::Invalid attributes?' , var_dump($model->getErrors());
            }
        }
    }


    public function actionView($id)
    {
        $qna = QnaQuestion::model()->findByPk($id);

        if($qna)
        {
            $qna->views++;
            $this->render('//qna/viewQna', array('qna' => &$qna));
            $qna->save();
        }
        else
        {
            throw new CHttpException(404, "aww");
        }
    }

}