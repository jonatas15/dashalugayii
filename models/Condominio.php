<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "condominio".
 *
 * @property integer $id
 * @property string $nome
 * @property string $slug
 * @property string $url
 * @property string $observacoes
 * @property integer $id_imobiliarias
 *
 * @property Imobiliarias $idImobiliarias
 */
class Condominio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'condominio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'url', 'id_imobiliarias'], 'required'],
            [['observacoes'], 'string'],
            [['id_imobiliarias'], 'integer'],
            [['nome', 'slug'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 255],
            [['id_imobiliarias'], 'exist', 'skipOnError' => true, 'targetClass' => Imobiliarias::className(), 'targetAttribute' => ['id_imobiliarias' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'slug' => 'Slug',
            'url' => 'Url',
            'observacoes' => 'Observacoes',
            'id_imobiliarias' => 'Id Imobiliarias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdImobiliarias()
    {
        return $this->hasOne(Imobiliarias::className(), ['id' => 'id_imobiliarias']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdImoveis()
    {
        return $this->hasMany(Imoveisexternos::className(), ['condominio' => 'nome']);
    }
}
