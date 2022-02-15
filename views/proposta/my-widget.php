<?php
ob_start();
use kartik\widgets\DatePicker;
echo DatePicker::widget([
  'language'=>'pt',
  'name' => 'Proposta[data_nascimento]',
  'type' => DatePicker::TYPE_COMPONENT_PREPEND,
  'value' => '',
  'pluginOptions' => [
      'autoclose'=>true,
      'format' => 'dd-mm-yyyy'
  ]
]);

?>
