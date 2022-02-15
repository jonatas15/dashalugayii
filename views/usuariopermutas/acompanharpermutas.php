<?php
    //Podcast: 43:00
    use kartik\widgets\SwitchInput;
    use app\models\ImovelPermuta as Permuta;
?>
<h3>Ativar atualização de permutas compatíveis</h3>
<hr>
<?php

    $permutas = Permuta::find()->all();
    foreach ($permutas as $row) {
        
        echo '<div class="col-md-3">';
        echo '<div class="col-md-12">';
        echo '<a href="'.Yii::$app->homeUrl.'imovelpermuta/view?id='.$row['idimovel_permuta'].'" target="blanck" class="btn btn-info" style="margin:2%;width:100%">';
        echo '<div class="col-md-6">';
        
        echo '</div>';
        echo '<div class="col-md-12">';
        echo '<strong style="font-size:16px">Código: PIN - '.$row['codigo'].'</strong><br>';
        echo 'Tipo: '.$row['tipo'].'<br>';
        
        echo 'Valor: '.'R$ ' . number_format($row['valor_maximo'], 2, ',', '.').'<br>';
        echo '<label alt="dormitórios" title="dormitórios" style="padding:3px"><span class="glyphicon glyphicon-bed"></span> '.$row['dormitorios'].'</label>';
        echo '<label alt="garagens" title="garagens" style="padding:3px"><span class="glyphicon glyphicon-th"></span> '.$row['garagens'].'</label>';
        if ($row['elevador'] != 0) {
            echo '<label alt="elevador" title="elevador" style="padding:3px"><span class="glyphicon glyphicon-collapse-up"></span></label>';
        }
        if ($row['sacada'] != 0) {
            echo '<label alt="sacada" title="sacada" style="padding:3px"><span class="glyphicon glyphicon-modal-window"></span></label>';
        }
        echo '<br>';
        echo '<label alt="área" title="área" style="padding:3px"><span class="glyphicon glyphicon-fullscreen"></span> Área: '.($row['area_privativa']!=''?$row['area_privativa']:$row['area_total']).'</label>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        echo '<div class="col-md-12">';
        echo SwitchInput::widget([
            'name'=>'status_41',
            'pluginOptions'=>[
                'handleWidth'=>92,
                'onText'=>'Ativo',
                'offText'=>'Inativo'
            ]
        ]);
        echo '</div>';
        echo '</div>';

    }
?>