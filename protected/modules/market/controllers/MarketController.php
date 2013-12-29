<?php

class MarketController extends \PHPGController
{
    protected function beforeAction($action)
    {
        $this->mainNavSelectedItem = MainNavBarWidget::MARKET;
        return parent::beforeAction($action);
    }

	public function actionIndex()
	{
		$this->render('index');
	}
}