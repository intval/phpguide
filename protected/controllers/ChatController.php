<?php

class ChatController extends Controller
{
    public $layout = '//layouts/withoutSidebar';

    public function actionChat()
    {
        // Path to the chat directory:
        define('AJAX_CHAT_PATH', realpath(Yii::app()->basePath.'/../ajaxchat/').'/');

        // Include custom libraries and initialization code:
        require(AJAX_CHAT_PATH.'lib/custom.php');

        // Include Class libraries:
        require(AJAX_CHAT_PATH.'lib/classes.php');

        // Run
        new CustomAJAXChat();
    }


    public function actionIndex()
    {
        $this->render('index');
    }


    public static function count_online_members()
    {
        return Yii::app()->db->createCommand("SELECT COUNT(*) FROM ajax_chat_online
            WHERE dateTime > DATE_SUB(NOW(), INTERVAL 3 MINUTE)")->queryScalar();
    }

}
