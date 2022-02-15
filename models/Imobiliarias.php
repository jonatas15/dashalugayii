<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imobiliarias".
 *
 * @property integer $id
 * @property string $url
 * @property string $nome
 * @property string $sitemap
 * @property string $data_cadastro
 * @property string $data_alteracao
 *
 * @property Imoveisexternos[] $imoveisexternos
 * @property PalavraschavesHasImobiliarias[] $palavraschavesHasImobiliarias
 * @property Palavraschaves[] $palavraschaves
 */
class Imobiliarias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imobiliarias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'nome', 'sitemap'], 'required'],
            [['data_cadastro', 'data_alteracao'], 'safe'],
            [['url', 'sitemap'], 'string', 'max' => 255],
            [['nome'], 'string', 'max' => 145],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'nome' => 'Nome',
            'sitemap' => 'Sitemap',
            'data_cadastro' => 'Data Cadastro',
            'data_alteracao' => 'Data Alteracao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImoveisexternos()
    {
        return $this->hasMany(Imoveisexternos::className(), ['imobiliarias_id' => 'id']);
    }
    public function getCondominio()
    {
        return $this->hasMany(Condominio::className(), ['id_imobiliarias' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPalavraschavesHasImobiliarias()
    {
        return $this->hasMany(PalavraschavesHasImobiliarias::className(), ['imobiliarias_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPalavraschaves()
    {
        return $this->hasMany(Palavraschaves::className(), ['id' => 'palavraschaves_id'])->viaTable('palavraschaves_has_imobiliarias', ['imobiliarias_id' => 'id']);
    }
}
