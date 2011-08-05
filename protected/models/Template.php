<?php

/**
 * This is the model class for table "Templates".
 *
 * The followings are the available columns in table 'Templates':
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property integer $views
 * @property integer $downloads
 */
class Template extends CActiveRecord
{

        /**
	 * Returns the static model of the specified AR class.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Templates';
	}

        
        
        private function getNextOrPrevId($dir)
        {
            $command = Yii::app()->db->createCommand("SELECT `id` FROM `templates` WHERE `id` $dir {$this->id} ORDER BY `id` ASC LIMIT 1");
            return $command->queryScalar();
        }

        
        public function getNextId()
        {
            return $this->getNextOrPrevId('>');
        }
        
        public function getPrevId()
        {
            return $this->getNextOrPrevId('<');
        }
        
}


