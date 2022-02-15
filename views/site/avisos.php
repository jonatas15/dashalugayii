<?php
    use yii\bootstrap\Alert;
    use yii\helpers\Html;

    $condicao = [
        'atividade' => 'Atualização do Cliente'
    ];

    if($idreferencia !== '') {
        $condicao = [
            'atividade' => 'Atualização do Cliente',
            'id_referencia' => $idreferencia
        ];
    } else {
        $condicao = [
            'atividade' => 'Atualização do Cliente'
        ];
    }

    $historico = app\models\Historico::find()->where($condicao)->orderBy(['data'=>SORT_DESC])->all();

    $javisto = app\models\Userhistvisto::find()->where([
        'usuario_id' => Yii::$app->user->identity->id,
    ])->all();
    $idsvistos = [];
    foreach($javisto as $r) {
        array_push($idsvistos, $r->historico_id);
    }

    foreach ($historico as $key => $row) {
        if(!in_array($row->id, $idsvistos)):

            Alert::begin([
                'options' => [
                    'class' => 'alert-warning',
                    'id' => 'aviso-'.$row->id
                ],
            ]);
            $row_data = date('d/m/Y - H:i:s', strtotime($row->data ));
            echo "<!-- Item --> 
            <div class='tracking-date'>{$row_data}</div>
            <div class='tracking-content'>
                <strong class='title'>{$row->atividade}: {$row->proponente->sloInfospessoais->nome}</strong>
                <p class='description''>
                {$row->descricao}
                <br>
                <a href='".Yii::$app->homeUrl.'proposta/update?id='.$row->proponente->proposta->id."' class=''>Ver Mais</a>
                </p>
            </div>";
            echo Html::a('<i class="fa fa-check"></i> Marcar como Lida', '#', [
                'title' => 'Marcar como Lida esta Mensagem',
                'class' => 'btn btn-success float-right',
                'style' => 'text-decoration: none !important;margin-top: -25px',
                'onclick'=> "
                        $.ajax({
                            type: 'POST',
                            cache: false,
                            url: 'avisolido?id={$row->id}',
                            success: function(response) {
                                $('#aviso-{$row->id}').remove();
                            }
                        });
                        return false;",
            ]);
            Alert::end();

        endif;
    }