<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lead".
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $descricao
 * @property string|null $data
 *
 * @property CorretorHasLead[] $corretorHasLeads
 * @property Corretor[] $corretorIdcorretors
 */
class Lead extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['descricao'], 'string'],
            [['data'], 'safe'],
            [['titulo'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'descricao' => 'Descrição',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[CorretorHasLeads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorretorHasLeads()
    {
        return $this->hasMany(CorretorHasLead::className(), ['lead_id' => 'id']);
    }

    /**
     * Gets query for [[CorretorIdcorretors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorretorIdcorretors()
    {
        return $this->hasMany(Corretor::className(), ['idcorretor' => 'corretor_idcorretor'])->viaTable('corretor_has_lead', ['lead_id' => 'id']);
    }
}
