<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historico".
 *
 * @property integer $id
 * @property integer $categoria
 * @property string $atividade
 * @property string $descricao
 * @property string $data
 * @property integer $id_referencia
 */
class Historico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'historico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoria', 'atividade', 'descricao', 'data', 'id_referencia'], 'required'],
            [['categoria', 'id_referencia'], 'integer'],
            [['descricao'], 'string'],
            [['data'], 'safe'],
            [['atividade'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoria' => 'Categoria',
            'atividade' => 'Atividade',
            'descricao' => 'Descricao',
            'data' => 'Data',
            'id_referencia' => 'Id Referencia',
        ];
    }

    public function getProponente()
    {
        return $this->hasOne(SloPretendente::className(), ['id' => 'id_referencia']);
    }
}
