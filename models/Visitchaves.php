<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visitchaves".
 *
 * @property int $id
 * @property int $usuario_id
 * @property string $nome
 * @property string|null $nome_cliente
 * @property string $tipovisitante
 * @property string $codigo_imovel
 * @property string $dthr_retirada
 * @property string|null $dthr_entrega
 * @property string $data_visita
 * @property string|null $hora_visita
 * @property string|null $feedbacks
 * @property string|null $mensagem
 * @property string|null $num_disparo
 * @property int|null $convertido_venda
 *
 * @property Usuario $usuario
 */
class Visitchaves extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visitchaves';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'nome', 'tipovisitante', 'codigo_imovel', 'dthr_retirada', 'data_visita'], 'required'],
            [['usuario_id', 'convertido_venda', 'botconversaid', 'msg_enviada'], 'integer'],
            [['tipovisitante', 'feedbacks', 'mensagem'], 'string'],
            [['dthr_retirada', 'dthr_entrega', 'data_visita', 'hora_visita'], 'safe'],
            [['nome', 'nome_cliente'], 'string', 'max' => 200],
            [['codigo_imovel', 'num_disparo'], 'string', 'max' => 15],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'nome' => 'Corretor | Visitante',
            'nome_cliente' => 'Proprietário',
            'tipovisitante' => 'Visitante é',
            'codigo_imovel' => 'Codigo Imovel',
            'dthr_retirada' => 'Dthr Retirada',
            'dthr_entrega' => 'Dthr Entrega',
            'data_visita' => 'Data Visita',
            'hora_visita' => 'Hora Visita',
            'feedbacks' => 'Feedbacks',
            'mensagem' => 'Mensagem',
            'num_disparo' => 'Num Disparo',
            'convertido_venda' => 'Convertido Venda',
        ];
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
}
