<?php

class EventsController extends PHPGController
{
    protected function beforeAction($action)
    {
        $this->mainNavSelectedItem = MainNavBarWidget::EVENTS;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->render('eventsList');
    }
} 