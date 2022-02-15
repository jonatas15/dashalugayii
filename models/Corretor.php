<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "corretor".
 *
 * @property integer $idcorretor
 * @property string $nome
 * @property string $observacoes
 * @property string $foto
 * @property string $cor
 * @property integer $usuario_id
 *
 * @property Usuario $usuario
 * @property SloAgenda[] $sloAgendas
 * @property Visita[] $visitas
 */
class Corretor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'corretor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['observacoes'], 'string'],
            [['usuario_id'], 'integer'],
            [['nome', 'foto'], 'string', 'max' => 245],
            [['cor'], 'string', 'max' => 45],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcorretor' => 'Idcorretor',
            'nome' => 'Nome',
            'observacoes' => 'Observacoes',
            'foto' => 'Foto',
            'cor' => 'Cor',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSloAgendas()
    {
        return $this->hasMany(SloAgenda::className(), ['corretor_idcorretor' => 'idcorretor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitas()
    {
        return $this->hasMany(Visita::className(), ['id_corretor' => 'idcorretor']);
    }
}
