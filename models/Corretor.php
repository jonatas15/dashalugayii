<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "corretor".
 *
 * @property int $idcorretor
 * @property string $nome
 * @property string|null $observacoes
 * @property string|null $foto
 * @property string|null $cor
 * @property int|null $usuario_id
 * @property string|null $telefone
 * @property string|null $historico 
 *
 * @property Clientes[] $clientes
 * @property Usuario $usuario
 * @property CorretorHasLead[] $corretorHasLeads 
 * @property Lead[] $leads 
 * @property SloAgenda[] $sloAgendas
 * @property Visita[] $visitas
 */
class Corretor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'corretor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['observacoes', 'historico'], 'string'],
            [['usuario_id'], 'integer'],
            [['nome', 'foto'], 'string', 'max' => 245],
            [['cor'], 'string', 'max' => 45],
            [['telefone'], 'string', 'max' => 20],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idcorretor' => 'Idcorretor',
            'nome' => 'Nome',
            'observacoes' => 'Observações',
            'foto' => 'Foto',
            'cor' => 'Cor',
            'usuario_id' => 'Usuario ID',
            'telefone' => 'Telefone',
            'historico' => 'Historico'
        ];
    }

    /**
     * Gets query for [[Clientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Clientes::className(), ['corretor' => 'idcorretor']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }

    /**
     * Gets query for [[SloAgendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSloAgendas()
    {
        return $this->hasMany(SloAgenda::className(), ['corretor_idcorretor' => 'idcorretor']);
    }

    /**
     * Gets query for [[Visitas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisitas()
    {
        return $this->hasMany(Visita::className(), ['id_corretor' => 'idcorretor']);
    }

   /**
    * Gets query for [[CorretorHasLeads]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getCorretorHasLeads() 
   { 
       return $this->hasMany(CorretorHasLead::className(), ['corretor_idcorretor' => 'idcorretor']); 
   } 
 
   /** 
    * Gets query for [[Leads]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getLeads() 
   { 
       return $this->hasMany(Lead::className(), ['id' => 'lead_id'])->viaTable('corretor_has_lead', ['corretor_idcorretor' => 'idcorretor']); 
   } 
}
