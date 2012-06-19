<?php

/**
 * This is the model class for table "users_info".
 *
 * The followings are the available columns in table 'users_info':
 * @property string $uid
 * @property string $name
 * @property string $gender
 * @property string $birthdate
 * @property string $city
 * @property string $site
 * @property string $about
 *
 * The followings are the available model relations:
 * @property Users $u
 */
class UsersInfo extends DTActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsersInfo the static model class
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
		return 'users_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, name', 'required'),
			array('uid', 'length', 'max'=>20),
			array('name', 'length', 'max'=>25),
			array('gender', 'length', 'max'=>6),
			array('city', 'length', 'max'=>40),
			array('site', 'length', 'max'=>255),
			array('birthdate, about', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, name, gender, birthdate, city, site, about', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'name' => 'Name',
			'gender' => 'Gender',
			'birthdate' => 'Birthdate',
			'city' => 'City',
			'site' => 'Site',
			'about' => 'About',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('about',$this->about,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}