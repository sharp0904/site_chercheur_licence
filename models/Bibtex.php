<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for Bibtex.
 */
class Bibtex extends Model
{
	
	public $Bibtex;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['Bibtex'], 'required', ],
            [['Bibtex'], 'file', 'extensions'=>'bib', ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Bibtex' => 'Bibtex',
        ];
    }

}
