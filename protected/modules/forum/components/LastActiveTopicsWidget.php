<?php

class LastActiveTopicsWidget extends CWidget
{
    public $count = 7;

    public function run()
    {
        $this->render('forum.views.qna.homeQnaList' ,['qnas' =>  QnaQuestion::model()->findAll(['limit' => $this->count])]);
    }
} 