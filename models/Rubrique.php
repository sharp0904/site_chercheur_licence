<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rubrique".
 *
 * @property integer $id
 * @property string $date_creation 
 * @property string $date_modification 
 * @property string $content_fr
 * @property string $content_en
 * @property integer $menu_id
 *
 * @property Menu $menu
 */
class Rubrique extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rubrique';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_creation', 'date_modification'], 'required'],
            [['date_creation', 'date_modification'], 'safe'],
            [['content_fr', 'content_en'], 'string'],
            [['menu_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_creation' => 'Date Creation',
            'date_modification' => 'Date Modification',
            'content_fr' => 'Content Fr',
            'content_en' => 'Content En',
            'menu_id' => 'Menu ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }
    
	public function relations()
	{
		return array(
		'menu'    =>  array(self::BELONGS_TO,'Menu','menu_id'),
		);
	}
    

}
