<?php

/**
 * This is the model class for table "blog_categories".
 *
 * The followings are the available columns in table 'blog_categories':
 * @property string $cat_id
 * @property string $name
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
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
		return 'blog_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cat_id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'articles' => array(self::MANY_MANY, 'Article', 'blog_post2cat(catid, postid)')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cat_id' => 'Cat',
			'name' => 'Name',
		);
	}

	
        public function byTimeDesc()
        {
            
            $this->getDbCriteria()->mergeWith( array(
                'order' => 'pub_date DESC'
            ));
            
            return $this;
        }
}