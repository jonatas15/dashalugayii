<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imovel_permuta".
 *
 * @property integer $idimovel_permuta
 * @property string $codigo
 * @property integer $dormitorios
 * @property integer $garagens
 * @property double $area_privativa
 * @property double $area_total
 * @property string $bairros
 * @property integer $elevador
 * @property integer $sacada
 * @property string $valor_maximo
 * @property string $valor_minimo
 * @property integer $tipo_imovel
 * @property string $tipo
 * @property string $observacoes 
 *
 * @property Controle[] $controles 
 * @property Usuariopermutas[] $usuariopermutas 

 * @property TipoImovel $tipoImovel
 */
class ImovelPermuta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imovel_permuta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo','tipo'], 'required'],
            [['dormitorios', 'garagens', 'elevador', 'sacada', 'tipo_imovel'], 'integer'],
            [['area_privativa', 'area_total', 'valor_maximo', 'valor_minimo'], 'number'],
            // [['bairros', 'tipo'], 'string'],
            [['observacoes'], 'string'],
            [['codigo'], 'string', 'max' => 10],
            [['tipo_imovel'], 'exist', 'skipOnError' => true, 'targetClass' => TipoImovel::className(), 'targetAttribute' => ['tipo_imovel' => 'idtipo_imovel']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idimovel_permuta' => 'Id',
            'codigo' => 'Código',
            'dormitorios' => 'Dormitórios',
            'garagens' => 'Garagens',
            'area_privativa' => 'Área Privativa',
            'area_total' => 'Área total',
            'bairros' => 'Bairros',
            'elevador' => 'Elevador',
            'sacada' => 'Sacada',
            'valor_maximo' => 'Valor máximo',
            'valor_minimo' => 'Valor mínimo',
            'tipo_imovel' => 'Tipo Imovel',
            'tipo' => 'Tipo do imóvel',
            'observacoes' => 'Observações', 
        ];
    }
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getControles() { 
        return $this->hasMany(Controle::className(), ['permuta_id' => 'idimovel_permuta']); 
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoImovel() {
        return $this->hasOne(TipoImovel::className(), ['idtipo_imovel' => 'tipo_imovel']);
    }
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getUsuariopermutas() { 
        return $this->hasMany(Usuariopermutas::className(), ['permuta' => 'idimovel_permuta']); 
    } 
 
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getUsuarios() { 
       return $this->hasMany(Usuario::className(), ['id' => 'usuario'])->viaTable('usuariopermutas', ['permuta' => 'idimovel_permuta']); 
    } 
}
