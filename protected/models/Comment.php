<?php

/**
 * This is the model class for table "blog_comments".
 *
 * The followings are the available columns in table 'blog_comments':
 * @property string $cid
 * @property integer $blogid
 * @property string $date
 * @property string $author
 * @property string $text
 * @property integer $approved
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Comment the static model class
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
		return 'blog_comments';
	}

        
        
        
        
        public function rules()
        {
            return array
            (
                array('text, blogid', 'required'),
                array('blogid', 'numerical', 'min' => 0)
            );
        }
}