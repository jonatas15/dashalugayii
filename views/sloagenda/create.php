<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SloAgenda */


?>
<div class="slo-agenda-create">

    <?= $this->render('_form', [
        'model' => $model,
        'turno' => $turno,
        'data1' => $data1,
        'i' => $i,
    ]) ?>

</div>
