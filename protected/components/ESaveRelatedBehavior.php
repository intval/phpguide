<?php
/**
 * ESaveRelatedBehavior class file.
 *
 * @author Stephan Lüderitz
 * @link http://www.yiiframework.com/extension/esaverelatedbehavior/
 * @link http://www.luderitz.de
 * @version 1.3
 */

/*
 * The ESaveRelatedBehavior enables ActiveRecord models to save HAS_MANY relational
 * active records and MANY_MANY relations along with the main model.
 * It provides two new methods:
 *  - saveWithRelated - saves the model and all specified related models, returns false if any model has not been saved
 *  - saveRelated - saves the specified related models only and returns false if any model has not been saved
 *
 * Features:
 * - handles many_many and has_many relations
 * - fills has_many relations with validated objects
 * - allows selection of scenario for has_many relations
 * - processes everything within a transaction
 * - relations can be set with data arrays or object arrays
 * - only specified relations are saved
 * - massive assignment works, since data is set on relation directly
 * - adds 2 methods to activeRecord, no use of beforeSave/afterSave,
 *   therefore the behavior can be added to all activeRecord classes,
 *   it will only do its work when the new methods are called
 * - uses standard SQL
 * - NO HANDLING OF COMPOSITE KEYS yet
 *
 * Requirements:
 * Yii Framework 1.1.0 or later
 *
 * Usage:
 * Extract the release file under 'protected/components'
 * Add the following code to your models:
 * public function behaviors(){
 * 		return array('ESaveRelatedBehavior' => array(
 *          'class' => 'application.components.ESaveRelatedBehavior')
 *      );
 * }
 *
 * MANY_MANY relations
 * -------------------
 * When a MANY_MANY relation is defined in the relations() function,
 * instances of the foreign model can be related while saving the model.
 *
 * Example:
 *
 * post model defines many_many relation with categories:
 * 'categories'=>array(self::MANY_MANY, 'category', 'post_category(post_id, category_id)')
 *
 * To add new rows to the m:n table (post_category) do:
 * $post = new post();
 * $post->categories = category::model()->findAll();
 * $post->saveWithRelated('categories');
 * This saves the new post and updates the m:n table with every category.
 *
 * The typical usage to assign data send from a checkBoxList is
 * $post->categories = array(1, 2, 3);
 * $post->saveWithRelated('categories');
 *
 * So you can either pass an array of objects
 * or an array of the primary keys of the foreign table.
 *
 * You can also pass a single object or a single primary key:
 * $post->categories = category::model()->findByPk(1);
 * $post->categories = 1;
 * $post->saveWithRelated('categories');
 *
 * If you are saving several relations you would do:
 * $post->saveWithRelated( array('relation1', 'relation2') );
 *
 * If saving was not successful, then $post->categories will return the data that was set
 * If saving was successful, then the relation will return the related models.
 *
 * When updating a model then all entries in the m:n table for this model are first deleted.
 * (Howto prevent deletion see section "advanced usage")
 *
 * HAS_MANY relations
 * -------------------
 * When a HAS_MANY relation is defined in the relations() function,
 * instances of the foreign model can be added while saving the model.
 *
 * Example:
 *
 * author model defines has_many relation with posts:
 * 'posts'=>array(self::HAS_MANY, 'post', 'author_post(author_id, post_id)')
 *
 * To save a new author along with 2 posts you can now do:
 * $author = new author();
 * $author->posts = array(new post(), new post());
 * $author->saveWithRelated('posts');
 * This saves the new author together with two (empty) posts.
 *
 * The typical usage though would be to assign data send from a tabular form
 * Each array entry represents the data for one post
 * $author->posts = array(
 *    array(
 *        'title' => 'My first post',
 *        'content' => 'This is my first post.'
 *    ),
 *    array(
 *        'title' => 'My second post',
 *        'content' => 'This is my second post.'
 *    )
 * );
 * $author->saveWithRelated('posts');
 *
 * So similar to many_many relations you can either pass an array of objects
 * or an array of data that represents the related objects.
 *
 * You can also pass a single object:
 * $author->posts = new post();
 * $author->saveWithRelated('posts');
 *
 * If you are saving several relations you would do:
 * $author->saveWithRelated( array('relation1', 'relation2') );
 *
 * If saving was not successful, then $author->posts will return
 * an array of validated post models which can be used to display
 * the tabular input form along with validation messages
 * If saving was successful, then the relation will return the related models.
 *
 * When updating a model then all records related to this model are first deleted.
 * (Howto prevent deletion see section "advanced usage")
 *
 * You can also specify the scenario to be used for the insertion of the related models:
 * $model->saveWithRelated( array('relationName1' => array('scenario' => 'special')));
 *
 * Advanced usage
 * --------------
 * To save the related data only do:
 * $model->saveRelated( array('relationName1','relationName2') );
 *
 * If you do not want to delete existing related records before insertion do
 * $model->saveWithRelated( array('relationName1' => array('append' => true)));
 * You will have to make sure that the new records are not dublicates of
 * existing records, the behavior does not handle that
 *
 */
class ESaveRelatedBehavior extends CActiveRecordBehavior
{
	/**
	 * Saves the model and the specified relations
	 * @param mixed $relations the relations to be saved. This can be either a string
	 * for a single relation or an array of strings for multiple relations.
	 * If the relation name is used as index with 'append' as value (relationName => 'append')
	 * then existing records will not be deleted before inserting
	 * @return boolean weather saving was successful
	 */
	public function saveWithRelated($relations)
	{
		return $this->saveR($relations, true);
	}

	/**
	 * Saves the specified relations only
	 * @param mixed $relations the relations to be saved. This can be either a string
	 * for a single relation or an array of strings for multiple relations.
	 * If the relation name is used as index with 'append' as value (relationName => 'append')
	 * then existing records will not be deleted before inserting
	 * @return boolean weather saving was successful
	 */
	public function saveRelated($relations)
	{
	    if ($this->owner->isNewRecord) {
	        throw new CException("Function saveRelated() cannot be used for new objects, use saveWithRelated instead.");
	    }
        return $this->saveR($relations, false);
	}

	/**
	 * Saves the model and/or specified relations
	 * @param mixed $relations the relations to be saved
	 * @param boolean $saveModel weather to save the model or not
	 * @return boolean weather saving was successful
	 */
	protected function saveR($relations, $saveModel)
	{
	    $result = true; $t = false;
		if (!Yii::app()->db->currentTransaction) { // only start transaction if none is running already
		    $t = Yii::app()->db->beginTransaction();
		}
		if ($saveModel && !$this->owner->save()) { // save owner model if saveWithRelated was called
		    $result = false;
		}
		foreach ((array)$relations as $key => $relationName) { // loop through all relations that should be saved
		    $append = (!is_numeric($key) && @$relationName['append']); // check if records should be appended
		    $scenario = (!is_numeric($key) && @$relationName['scenario']) ? $relationName['scenario'] : null; // get scenario if specified (only for has_many relations)
		    if(!is_numeric($key)) { // the relationName is the key when further options (like append) where set
		        $relationName = $key;
		    }
      	    $relation = $this->owner->getActiveRelation($relationName); // get relation information
            $data = $this->owner->$relationName; // get the data that was set for this relation, if no data was set, $data will contain the current related records
            $data = is_object($data) ? array($data) : (array)$data; // make sure data is an array
            $commandBuilder = $this->owner->getCommandBuilder();

            // Handle many_many relations, this check has to be done first, since CManyManyRelation extends CHasManyRelation
            // The owner also needs to successfully saved, so that the foreign key can be determined
    		if ($relation instanceof CManyManyRelation && !$this->owner->isNewRecord) {
    			if (preg_match( // extract infos about mn linking table
    			    '/^\s*\{{0,2}\s*(.+?)\s*\}{0,2}\s*\(\s*(.+)\s*,\s*(.+)\s*\)\s*$/s',
    			    $relation->foreignKey, $matches
    			)) {
    			    $info = array(
    			        'mnTable' => $matches[1],
    			        'mnFk1' => $matches[2],
    			        'mnFk2' => $matches[3]
    			    );
    			} else {
    			    throw new CException("Unable to get table and foreign key information from MANY_MANY relation definition (".$relation->foreignKey.")");
    			}
                $model = new $relation->className;
                $possibleModels = $model->findAll(new CDbCriteria(array( // find all models, that can be related (used to make sure only existing records are linked)
                    'index' => $model->getMetaData()->tableSchema->primaryKey
                )));
                if (!$append) {
                    $criteria = new CDbCriteria;
                    $criteria->compare($info['mnFk1'], $this->owner->primaryKey);
                    $commandBuilder->createDeleteCommand($info['mnTable'], $criteria)->execute(); // delete current links to related model
                }
                $hasMnTableClass = @class_exists($info['mnTable']);
                foreach($data as $id) {
                    if (is_object($id)) { // get id if object was given
                        $id = $id->primaryKey;
                    }
                    if (array_key_exists($id, $possibleModels)) { // only add if related model exists
                        if ($hasMnTableClass) { // use class for inserting records into mn linking table if it exists
                            $obj = new $info['mnTable'];
                            $obj->attributes = array(
                                $info['mnFk1'] => $this->owner->primaryKey,
                                $info['mnFk2'] => $id
                            );
                            if (!$obj->save()) {
                                $result = false;
                            }
                        } else { // otherwise make and execute insert command
            			    $commandBuilder->createInsertCommand(
            			        $info['mnTable'],
            			        array(
            			            $info['mnFk1'] => $this->owner->primaryKey,
            			            $info['mnFk2'] => $id
            			        )
            			    )->execute();
                        }
                        unset($possibleModels[$id]); // this makes sure that id will not be inserted twice if submitted data attempts to do so.
                    }
                }
                if ($result) {
                    unset($this->owner->$relationName); // saving was successful, clear the relation, so accessing it will return the related records
                }

            } elseif ($relation instanceof CHasManyRelation) { // Handle has_many relations
    		    if (!$append) {
    		        $class = $relation->className;
			$model1 = call_user_func(array($class, 'model'));
    		        $model1->deleteAllByAttributes(array(  // delete current related models
    		            $relation->foreignKey => $this->owner->primaryKey
    		        ));
    		    }
                $dataProcessed = array();
    			foreach ($data as $key => $value) {
                    $obj = new $relation->className;
                    $obj->scenario = $scenario ? $scenario : $obj->scenario;
                    $obj->attributes = is_object($value) ? $value->attributes : $value;
                    $obj->{$relation->foreignKey} = $this->owner->primaryKey;
    				if ( (!$this->owner->isNewRecord && !$obj->save()) || ($this->owner->isNewRecord && !$obj->validate()) ) { // save related record if parent was saved, otherwise only validate it to prevent insertion without foreign key
    				    $result = false;
    				}
                    $dataProcessed[$key] = $obj;
    			}
    			$this->owner->$relationName = $dataProcessed; // set array of related records so it can be retrieved through the relation
            }
		}
        if ($t && $result) {
            $t->commit(); // commit on success if transaction was started in this behavior
        }
		if ($t && !$result) {
		    $t->rollback(); // rollback on errors if transaction was started in this behavior
		}
		return $result;
	}
}