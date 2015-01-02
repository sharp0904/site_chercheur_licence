<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "publication".
 *
 * @property integer $ID
 * @property string $reference
 * @property string $auteurs
 * @property string $titre
 * @property string $date
 * @property string $journal
 * @property string $volume
 * @property string $number
 * @property string $pages
 * @property string $note
 * @property string $abstract
 * @property string $keywords
 * @property string $series
 * @property string $localite
 * @property string $publisher
 * @property string $editor
 * @property string $pdf
 * @property string $date_display
 * @property integer $categorie_id
 *
 * @property Categorie $categorie
 */
class Publication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'publication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference', 'auteurs', 'titre', 'categorie_id'], 'required'],

            [['reference', 'auteurs', 'titre', 'journal', 'volume', 'number', 'pages', 'note', 'abstract', 'keywords', 'series', 'localite', 'publisher', 'editor',  'date_display'], 'string'],
            [['pdf'], 'file', 'extensions'=>'pdf'],
            [['date'], 'safe'],
			[['date'], 'date', 'format'=>'yyyy-M-d'],
            [['categorie_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'reference' => 'Reference',
            'auteurs' => 'Auteurs',
            'titre' => 'Titre',
            'date' => 'Date',
            'journal' => 'Journal',
            'volume' => 'Volume',
            'number' => 'Number',
            'pages' => 'Pages',
            'note' => 'Note',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords',
            'series' => 'Series',
            'localite' => 'Localite',
            'publisher' => 'Publisher',
            'editor' => 'Editor',
            'pdf' => 'Pdf',
            'date_display' => 'Date Display',
            'categorie_id' => 'Categorie ID',
        ];
    }

   public static function getLabels()
    {
        return [
            'ID' => 'ID',
            'reference' => 'Reference',
            'auteurs' => 'Auteurs',
            'titre' => 'Titre',
            'date' => 'Date',
            'journal' => 'Journal',
            'volume' => 'Volume',
            'number' => 'Number',
            'pages' => 'Pages',
            'note' => 'Note',
            'abstract' => 'Abstract',
            'keywords' => 'Keywords',
            'series' => 'Series',
            'localite' => 'Localite',
            'publisher' => 'Publisher',
            'editor' => 'Editor',
            'pdf' => 'Pdf',
            'date_display' => 'Date Display',
            'categorie_id' => 'Categorie ID',
        ];
    }
}
