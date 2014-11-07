<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $titre_fr
 * @property string $titre_en
 * @property integer $actif
 * @property integer $position
 *
 * @property Rubrique[] $rubriques
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'titre_fr', 'titre_en', 'actif'], 'required'],
            [['id', 'actif', 'position'], 'integer'],
            [['titre_fr', 'titre_en'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titre_fr' => 'Titre Fr',
            'titre_en' => 'Titre En',
            'actif' => 'Actif',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubriques()
    {
        return $this->hasMany(Rubrique::className(), ['menu_id' => 'id']);
    }
}
