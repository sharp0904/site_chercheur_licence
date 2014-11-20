<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categorie".
 *
 * @property integer $ID
 * @property string $name_fr
 * @property string $name_en
 *
 * @property Publication[] $publications
 */
class Categorie extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorie';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_fr', 'name_en'], 'required'],
            [['name_fr', 'name_en'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'name_fr' => 'Name Fr',
            'name_en' => 'Name En',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublications()
    {
        return $this->hasMany(Publication::className(), ['categorie_id' => 'ID']);
    }
}
