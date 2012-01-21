<?php

/**
 * DTActiveRecord - active record with datetime column support
 * Automatically converts all timestamp/datetime columns into SDateTime instance on fetching
 * and vice versa on saving.
 * 
 * This class exists because Yii doesn't support php 5.3 to the moment. 
 * The better implementation would be to extend yii core classes, but that is not something 
 * i'm willing to do for a public-code project.
 * Later the days, when yii2 is out, we could just remove this class and everything will be working properly
 * 
 * @author Alex Raskin <Alex@phpguide.co.il>
 * @version 1
 */

class DTActiveRecord extends CActiveRecord
{
	/**
	 * List of columns that are of datetime or timestamp type for *ALL MODELS* !!
	 * ie: $list_of_datetime_columns[User] = array('reg_date' , 'last_login');
	 * @var array
	 */
	private static $list_of_datetime_columns = null;

	
	/*
	protected function beforeSave()
	{
		return $this->convert_DateTime_into_strings() && parent::beforeSave();
	}
	*/
	protected function afterFind()
	{
		return $this->convert_datetime_fields_into_DateTime() && parent::afterFind();
	}
	/*
	protected function afterSave()
	{
		return $this->convert_datetime_fields_into_DateTime() && parent::afterSave();
	}
	*/
	/**
	 * Iterates over list of datetime columns of the current object and converts them into DateTime instances
	 */
	private function convert_datetime_fields_into_DateTime()
	{
		foreach( $this->datetime_columns() as $column)
		{
			if(null !== $this->{$column}) $this->{$column} = new SDateTime($this->{$column});
		}
		return true;
	}
	
	/**
	 * Iterates over list of columens and converts those that are DateTime instances into string for sql query uses 
	 * /
	
	private function convert_DateTime_into_strings()
	{
		foreach( $this->datetime_columns() as $column)
		{
			if($this->{$column} instanceof SDateTime) $this->{$column} = $this->{$column}->format('Y-m-d H:i:s');
		}
		return true;
	}
	*/
	
	/**
	 * Returns list of columns which are datetime/timestamp type. Generates it if none stored in cache
	 * @return SplFixedArray
	 */
	public function datetime_columns()
	{
		$className = get_class($this);
		
		if(!isset(self::$list_of_datetime_columns[$className]))
		{
			self::$list_of_datetime_columns[$className] = $this->generate_list_of_datettime_columns();
		}
		
		return self::$list_of_datetime_columns[$className]; 
	}
	
	/**
	 * Scans db schema and returs list of columns which are of datetime/timestamp type
	 * @return SplFixedArray
	 */
	private function generate_list_of_datettime_columns()
	{
		$className = get_class($this);
		$dtColumns = array();
		
		foreach ($this->getMetaData()->columns as $column)
		{
			if('timestamp' === $column->dbType || 'datetime' === $column->dbType)
			{
				array_push($dtColumns, $column->name);
			}
		}
		return SplFixedArray::fromArray($dtColumns);
	}
	
}