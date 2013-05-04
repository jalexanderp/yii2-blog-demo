<?php
namespace app\models;
use \yii\db\Expression;

class Post extends \yii\db\ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'posts';
	}

	/**
	 * @return array primary key of the table
	 **/	 
	public static function primaryKey()
	{
		return array('id');
	}

	public function rules()
	{
		return array(
			array('title, content', 'required'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'created' => 'Created',
			'updated' => 'Updated',
		);
	}

	public function beforeSave($insert)
	{

		if ($this->isNewRecord)
		{
			$this->created = new Expression('NOW()');
			$command = static::getDb()->createCommand("select max(id) as id from posts")->queryAll();
			$this->id = $command[0]['id'] + 1;
		}

		$this->updated = new Expression('NOW()');
		return parent::beforeSave($insert);
	}
}