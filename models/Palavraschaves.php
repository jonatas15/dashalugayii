<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "palavraschaves".
 *
 * @property integer $id
 * @property string $valor_imovel
 * @property string $garagens
 * @property string $banheiros
 *
 * @property PalavraschavesHasImobiliarias[] $palavraschavesHasImobiliarias
 * @property Imobiliarias[] $imobiliarias
 */
class Palavraschaves extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'palavraschaves';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor_imovel', 'garagens', 'banheiros'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_imovel' => 'Valor Imovel',
            'garagens' => 'Garagens',
            'banheiros' => 'Banheiros',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPalavraschavesHasImobiliarias()
    {
        return $this->hasMany(PalavraschavesHasImobiliarias::className(), ['palavraschaves_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImobiliarias()
    {
        return $this->hasMany(Imobiliarias::className(), ['id' => 'imobiliarias_id'])->viaTable('palavraschaves_has_imobiliarias', ['palavraschaves_id' => 'id']);
    }
}
