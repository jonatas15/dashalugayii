<?php
	use yii\helpers\Html;
	use yii\widgets\DetailView;
	use yii\bootstrap\Modal;

	$this->title = "Proposta: ".$proposta->codigo_imovel.' ('.$proposta->tipo.')';
?>
<h3 class="titulofixo">
		<span class="float-feft">
				<img src="<?=Yii::$app->homeUrl.'icones/logo_site.png'?>" width="30" />
		</span>
		<?= Html::encode($this->title) ?>
</h3>
<div class="slo-proposta-create col-md-12" style="margin-top: 100px">
	
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;">
		<label style="text-transform: uppercase;">Concluído, seus dados foram salvos com sucesso</label>
		<?php 
	        yii\bootstrap\Modal::begin([
	            'header' => '<h3>Resumo dos Dados Cadastrados</h3>',
	            // 'size' => 'modal-lg',
	            'toggleButton' => [
	                'label' => 'Visualizar resumo',
	                'class' => 'btn btn-success',
	                'style' => '',
	            ],
	        ]);
	    ?>
			<div class="col-md-12">
				<?php 
					$pessoais = app\models\SloInfospessoais::find()->where(['pretendente_id' => $pretendente->id])->one();
					if(count($pessoais) > 0){
						echo "<div class='col-md-12'>";
						echo "<h4>Informações Pessoais</h4>";
						echo  DetailView::widget([
				            'model' => $pessoais,
				            'attributes' => [
				                'nome',
				                'cpf',
				                'email',
				            ],
			        	]);
			        	echo "</div>";
					}
		        ?>
		        <?php 
					$pessoais = app\models\SloInfosprofissionais::find()->where(['pretendente_id' => $pretendente->id])->one();
					if(count($pessoais) > 0){
						echo "<div class='col-md-12'>";
						echo "<h4>Informações Profissionais</h4>";
						echo  DetailView::widget([
				            'model' => $pessoais,
				            'attributes' => [
				                'empresa',
				                'profissao',
				                'vinculo_empregaticio',
				            ],
			        	]);
			        	echo "</div>";
					}
		        ?>
		        <?php 
					$pessoais = app\models\SloContratodocumento::find()->where(['slo_pretendente_id' => $pretendente->id])->one();
					if(count($pessoais) > 0){
						echo "<div class='col-md-6'>";
						echo "<h4>Documentação</h4>";
						echo  DetailView::widget([
				            'model' => $pessoais,
				            'attributes' => [
				                'tipo_documento',
				            ],
			        	]);
			        	echo "</div>";
			        	echo "<div class='col-md-6'>";
			        	echo '<embed style="width:100%;height:100%" type="" src="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$pessoais->id.'_frentdoc_'.$pessoais->frente_documento.'"></embed>';
			        	echo "</div>";
					}
		        ?>
			</div>
			<div class="clearfix"></div>
		<?php yii\bootstrap\Modal::end(); ?>
		<br>
		<br>
		<a href="https://www.cafeinteligencia.com.br/locacao" class="btn btn-success" style="font-weight: bolder; font-size: 20px">
			<img src="<?=Yii::$app->homeUrl.'icones/logo_site.png'?>" width="30" />
			Voltar para os Imóveis 
		</a>
	</div>
	<div class="col-md-4"></div>
</div>