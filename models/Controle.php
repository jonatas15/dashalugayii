<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "controle".
 *
 * @property integer $idcontrole
 * @property string $acao_feita
 * @property string $detalhes_acao
 * @property integer $permuta_id
 * @property integer $cadastrador
 * @property string $data_cadastro
 * @property integer $atualizador
 * @property string $data_alteracao
 * @property string $mais_infos
 *
 * @property ImovelPermuta $permuta
 * @property Usuario $cadastrador0
 * @property Usuario $atualizador0
 */
class Controle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'controle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['acao_feita'], 'required'],
            [['acao_feita', 'detalhes_acao'], 'string'],
            [['permuta_id', 'cadastrador', 'atualizador'], 'integer'],
            [['data_cadastro', 'data_alteracao'], 'safe'],
            [['mais_infos'], 'string', 'max' => 255],
            [['permuta_id'], 'exist', 'skipOnError' => true, 'targetClass' => ImovelPermuta::className(), 'targetAttribute' => ['permuta_id' => 'idimovel_permuta']],
            [['cadastrador'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['cadastrador' => 'id']],
            [['atualizador'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['atualizador' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcontrole' => 'Id',
            'acao_feita' => 'Tipo de ação',
            'detalhes_acao' => 'Detalhes da ação',
            'permuta_id' => 'Permuta',
            'cadastrador' => 'Cadastrador',
            'data_cadastro' => 'Cadastrado em',
            'atualizador' => 'Atualizador',
            'data_alteracao' => 'Data de alteração',
            'mais_infos' => 'Mais Informações',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermuta()
    {
        return $this->hasOne(ImovelPermuta::className(), ['idimovel_permuta' => 'permuta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCadastrador0()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'cadastrador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtualizador0()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'atualizador']);
    }
}
