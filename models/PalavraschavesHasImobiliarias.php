<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "palavraschaves_has_imobiliarias".
 *
 * @property integer $palavraschaves_id
 * @property integer $imobiliarias_id
 *
 * @property Imobiliarias $imobiliarias
 * @property Palavraschaves $palavraschaves
 */
class PalavraschavesHasImobiliarias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'palavraschaves_has_imobiliarias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['palavraschaves_id', 'imobiliarias_id'], 'required'],
            [['palavraschaves_id', 'imobiliarias_id'], 'integer'],
            [['imobiliarias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Imobiliarias::className(), 'targetAttribute' => ['imobiliarias_id' => 'id']],
            [['palavraschaves_id'], 'exist', 'skipOnError' => true, 'targetClass' => Palavraschaves::className(), 'targetAttribute' => ['palavraschaves_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'palavraschaves_id' => 'Palavraschaves ID',
            'imobiliarias_id' => 'Imobiliarias ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImobiliarias()
    {
        return $this->hasOne(Imobiliarias::className(), ['id' => 'imobiliarias_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPalavraschaves()
    {
        return $this->hasOne(Palavraschaves::className(), ['id' => 'palavraschaves_id']);
    }
}
