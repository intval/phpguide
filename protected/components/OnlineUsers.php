<?php

class OnlineUsers extends CWidget
{
    public function run()
    {
        $criteria = new CDbCriteria([
            'select' => 'login, last_visit',
            'condition' => 'last_visit > DATE_SUB(NOW(), INTERVAL 10 MINUTE)',
            'order' => 'last_visit DESC'
        ]);

        $onlineUsers = User::model()->findAll($criteria);

        if(sizeof($onlineUsers) > 0)
            $this->render('OnlineUsers', array('users' => $onlineUsers));
    }
}