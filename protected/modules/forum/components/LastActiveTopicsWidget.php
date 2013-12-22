<?php

class LastActiveTopicsWidget extends PHPGWidget
{
    public $count = 7;

    public function run()
    {
        $this->renderPartial('forum.views.qna.homeQnaList' ,
            [
                'showCategory' => true,
                'qnas' =>  QnaQuestion::model()->findAll(['limit' => $this->count])
            ]
        );
    }
} 