<?php
require(dirname(__FILE__).'/../sources/global_functions.php');
return CMap::mergeArray(
		require(dirname(__FILE__).'/config.php'),
		array(
				'components'=>array(
						'fixture'=>array(
								'class'=>'system.test.CDbFixtureManager',
						),
						'db' => array()
				),
		)
);
