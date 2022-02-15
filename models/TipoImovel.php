<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_imovel".
 *
 * @property integer $idtipo_imovel
 * @property string $tipo
 *
 * @property ImovelPermuta[] $imovelPermutas
 */
class TipoImovel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_imovel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo'], 'required'],
            [['tipo'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtipo_imovel' => 'Idtipo Imovel',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImovelPermutas()
    {
        return $this->hasMany(ImovelPermuta::className(), ['tipo_imovel' => 'idtipo_imovel']);
    }
}
