<?php
use yii\helpers\Html;
use app\models\SloProposta;
use yii\bootstrap\Modal;
use yii\bootstrap\Collapse;

$proposta = SloProposta::find()->where(['id'=>$proposta_id])->one();
$this->title = "Proposta: ".$proposta->codigo_imovel.' ('.$proposta->tipo.')';
?>
<style>
.a_disabled {
	pointer-events: none;
  	cursor: default;
  	text-decoration: none;
  	color: black;
}
li {
	border-bottom: 1px solid lightgray;
}
</style>
<h3 class="titulofixo" title="<?= Html::encode($this->title) ?>">
	<span class="float-feft">
			<img src="<?=Yii::$app->homeUrl.'icones/logo_site.png'?>" class="logo_banner" />
	</span>
	Formulário de Cadastro
</h3>
<div class="slo-proposta-create col-md-12" style="margin-top: 75px;">
	<?php

		$principal = app\models\SloPretendente::findOne($pretendente_id);

		//Pretendente, Informações e Documentação
		$infopessoal_pretendente 		= app\models\SloInfosPessoais::find()->where(['pretendente_id'=>$pretendente_id])->one();
		$documentacao_pretendente 		= app\models\SloContratodocumento::find()->where(['slo_pretendente_id'=>$pretendente_id])->one();
		$infoprofissional_pretendente 	= app\models\SloInfosprofissionais::find()->where(['pretendente_id'=>$pretendente_id])->one();
		$refbancarias_pretendente 		= app\models\SloRefbancaria::find()->where(['slo_pretendente_id'=>$pretendente_id])->one();
		$moratualmente_pretendente 		= app\models\SloMoratual::find()->where(['slo_pretendente_id'=>$pretendente_id])->one();
		//Cônjuje, informações

		$conjuje = app\models\SloConjuje::find()->where(['pretendente_id'=>$pretendente_id])->one();

		$infopessoal_conjuje = app\models\SloInfosPessoais::find()->where(['conjuje_id'=>$conjuje->id])->andWhere(['not', ['conjuje_id' => null]])->one();
		$infoprofissional_conjuje = app\models\SloInfosprofissionais::find()->where(['conjuje_id'=>$conjuje->id])->andWhere(['not', ['conjuje_id' => null]])->one();
		//Ocupante:
		$ocupante = app\models\SloOcupante::find()->where(['slo_pretendente_id'=>$pretendente_id])->one();

		$valorform = (int)$form;
		$anterior = $valorform - 1;
		$proximo = $valorform + 1;

		if ($anterior < 9) { $_0 = '00'; } else { $_0 = '0'; }
		if ($proximo < 9) { $_0p = '00'; } else { $_0p = '0'; }

		$str_anterior = $_0.$anterior;
		$str_proximo = $_0p.$proximo;

		if($valorform < 5){
			$id_id = $model->id;
		}else{
			$id_id = $model2->id;
		}
	?>

	<div class="col-md-12 clearfix"><br></div>
	<div class="col-md-3">
		<div class="menu-desktop">

			<?php

				$_porcent = 0;
				$_se_casado = 0;
				$_se_casado_mais_um = 0;

				if($infopessoal_pretendente->estado_civil == 'casado') {
					$_unidade = 8.3;
					$_total_etapas = 12;
					$_se_casado = 3;
					$_se_casado_mais_um = 2;
				} else {
					$_unidade = 12.5;
					$_total_etapas = 8;
					$_se_casado = 0;
					$_se_casado_mais_um = 0;
				}

				use yii\bootstrap\NavBar;
				use yii\bootstrap\Nav;

				NavBar::begin(['brandLabel' => false]);
				echo Nav::widget([
					'encodeLabels' => false,
					'items' => [
						[
							'label'=>'<h5><strong>PRETENDENTE:</strong></h5>',
							'url'=>''
						],
						'<br>',
						[
							'label' => ($infopessoal_pretendente->estado_civil?'<i class="fas fa-check-square"></i> ':'').'1 - Dados Pessoais',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=001'."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['001'])?true:false),
						],
						[
							'label' => ($infopessoal_pretendente->nacionalidade?'<i class="fas fa-check-square"></i> ':'').'1.2 - Dados Pessoais',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=003'."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['003'])?true:false),
						],
						[
							'label' => ($documentacao_pretendente->tipo_documento?'<i class="fas fa-check-square"></i> ':'').'2 - Documentação',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=005'."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['005'])?true:false),
							'linkOptions' => ['class'=>($documentacao_pretendente->id?'':'a_disabled')],
							//'visible' => ($infopessoal_pretendente->id and $documentacao_pretendente->id) != ''?true:false
						],
						[
							'label' => ($documentacao_pretendente->outros_comprovantes?'<i class="fas fa-check-square"></i> ':'').'2.1 - Comprovantes',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=006'."&iddoc=".$documentacao_pretendente->id."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['006'])?true:false),
							'linkOptions' => ['class'=>($documentacao_pretendente->id?'':'a_disabled')],
							//'visible' => ($infopessoal_pretendente->id and $documentacao_pretendente->id) != ''?true:false
						],
						[
							'label' => ($infoprofissional_pretendente->id?'<i class="fas fa-check-square"></i> ':'').'3 - Informações Profissionais',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=007'."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['007','008'])?true:false),
							'linkOptions' => ['class'=>($infoprofissional_pretendente->id?'':'a_disabled')],
							//'visible' => ($infopessoal_pretendente->id != '' and $infoprofissional_pretendente->id != '')?true:false
						],
						[
							'label' => ($infopessoal_conjuje->id?'<i class="fas fa-check-square"></i> ':'').'4 - Cônjuge: Dados Pessoais',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=009&iddoc='.$infopessoal_conjuje->id."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['009'])?true:false),
							'linkOptions' => ['class'=>(($infopessoal_pretendente->estado_civil == 'casado')?'':'a_disabled')],
							'visible' => ($infopessoal_pretendente->estado_civil == 'casado')?true:false
						],
						[
							'label' => ($infopessoal_conjuje->nacionalidade?'<i class="fas fa-check-square"></i> ':'').'4.2 - Cônjuge: Dados Pessoais',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=010&iddoc='.$infopessoal_conjuje->id."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['010'])?true:false),
							'linkOptions' => ['class'=>(($infopessoal_conjuje->id)?'':'a_disabled')],
							'visible' => ($infopessoal_pretendente->estado_civil == 'casado')?true:false
						],
						[
							'label' =>  ($infoprofissional_conjuje->empresa?'<i class="fas fa-check-square"></i> ':'').'5 - Cônjuge: Informações Profissionais',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=013&iddoc='.$infopessoal_conjuje->id."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['013','014'])?true:false),
							'linkOptions' => ['class'=>(($infopessoal_conjuje->id)?'':'a_disabled')],
							'visible' => ($infopessoal_pretendente->estado_civil == 'casado')?true:false
						],
						[
							'label' =>  ($refbancarias_pretendente->nome_banco?'<i class="fas fa-check-square"></i> ':'').(4 + $_se_casado_mais_um).' - Referências Bancárias',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=015&iddoc='.$refbancarias_pretendente->id."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['015'])?true:false),
							'linkOptions' => ['class'=>($refbancarias_pretendente->id?'':'a_disabled')],
							//'visible' => ($infopessoal_pretendente->id!='' and $refbancarias_pretendente!='')?true:false
						],
						[
							'label' =>  ($moratualmente_pretendente->id?'<i class="fas fa-check-square"></i> ':'').(5 + $_se_casado_mais_um).' - Onde mora atualmente',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=016&iddoc='.$moratualmente_pretendente->id."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['016','017','018'])?true:false),
							'linkOptions' => ['class'=>($moratualmente_pretendente->id?'':'a_disabled')],
							//'visible' => ($infopessoal_pretendente->id!='' and $moratualmente_pretendente!='')?true:false
						],
						[
							'label' => '<i class="fas fa-plus"></i> '.'Cadastrar Ocupantes',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=019&iddoc='.$ocupante->id."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['019'])?true:false),
							'linkOptions' => ['class'=>($moratualmente_pretendente->id?'':'a_disabled')],
							//'visible' => ($infopessoal_pretendente->id!='' and $ocupante->id != '')?true:false
						],
						[
							'label' => '<i class="fas fa-plus"></i> '.'Cadastrar Fiadores/Proponentes',
							'url' => ['/proposta/pretendente001?id='.$infopessoal_pretendente->id.'&form=020&iddoc='.$ocupante->id."&pretendente_id=$pretendente_id&proposta_id=$proposta_id"],
							'active' => (in_array($form, ['020'])?true:false),
							'linkOptions' => ['class'=>($moratualmente_pretendente->id?'':'a_disabled')],
							//'visible' => ($infopessoal_pretendente->id!='' and $ocupante->id != '')?true:false
						],
					],
					'options' => [
						'class' => 'nav-pills nav-stacked'
					],
				]);
				NavBar::end();
			?>
		</div>
	</div>
	<div class="col-md-6">
		<?php if(in_array($form, ['001','002','003','004','005','006'])): ?>
			<div class="col-md-12" style="
				background-color: var(--cor-bg-fundo);
				padding: 1%;
			">
				<div class="col-md-12" style="color: white; font-style: italic; font-weight: bolder;text-align: center !important;">
					Documentos necessários para comprovação de renda. Veja antes de continuar o cadastro
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="col-md-4"></div>
				<div class="col-md-4" style="text-align: center;">

						<?php
					        yii\bootstrap\Modal::begin([
					            'header' => '<h3>Sobre a Documentação Necessária</h3>',
					            'size' => 'modal-lg',
					            'toggleButton' => [
					                'label' => 'Visualizar',
					                'class' => 'btn btn-primary',
					                'style' => 'background-color: white; color: var(--cor-bg-fundo); border: 1px solid white; font-weight: bolder; font-size: 15px; width: 100%;
					                    box-shadow: 5px 5px gray;',
					            ],
					        ]);
				        ?>
				        <div class="col-md-12" style="text-align: left;">
				            <div class="col-md-6">
				                <strong>PARA TODOS OS CASOS:</strong>
				                <ul>
				                    <li>RG E CPF;</li>
				                    <li>
				                        Somente nos casos em que o locatário já reside em imóvel alugado:
				                        <br>03 últimos recibos de aluguel, acompanhados
				                        <br>da cópia do contrato de locação do atual imóvel;
				                    </li>
				                    <li>Imposto de Renda na íntegra, inclusive com página de protocolo;</li>
				                </ul>
				                <strong>Funcionário Registrado:</strong>
				                <ul>
				                    <li>03 últimos recibos de pagamentos;</li>
				                    <li>Cópia da Carteira Profissional (folha de identificação,
				                        registro de trabalho e última atualização salarial). Se o pretendente
				                        for recentemente admitido (menos de 6 meses), apresentar
				                        cópia do vínculo empregatício anterior;
				                    </li>
				                </ul>
				                <strong>Funcionário Público (Estatutário):</strong>
				                <ul>
				                    <li>03 últimos recibos de pagamentos;</li>
				                </ul>
				                <strong>Funcionário Público (CLT):</strong>
				                <ul>
				                    <li>03 últimos recibos de pagamentos;</li>
				                    <li>
				                        Cópia da Carteira Profissional (folha de identificação,
				                        registro de trabalho e última atualização salarial);
				                    </li>
				                </ul>
				                <strong>Micro-empresário:</strong>
				                <ul>
				                    <li>Contrato Social ou declaração de firma individual;</li>
				                    <li>Imposto de Renda na íntegra, inclusive com página de protocolo;</li>
				                    <li>Extratos bancários completos dos últimos 03 meses;</li>
				                </ul>
				            </div>
				            <div class="col-md-6">

				                <strong>Profissional Liberal / Autônomo</strong>
				                <ul>
				                    <li>Imposto de Renda na íntegra, inclusive com
				                    página de protocolo;</li>
				                    <li>Extratos bancários completos dos últimos 03
				                    meses;</li>
				                </ul>
				                <strong>Aposentado:</strong>
				                <ul>
				                    <li>03 últimos recibos de pagamentos;</li>
				                    <li>Extrato trimestral do INSS;</li>
				                </ul>
				                <h3>Outras Situações:</h3>
				                <strong>Renda Proveniente de Aluguéis:</strong>
				                <ul>
				                    <li>Documento de propriedade do imóvel (cópia
				                     do IPTU ou escritura do imóvel);</li>
				                    <li>Contrato de locação;</li>
				                    <li>Extratos bancários completos dos últimos 03
				                    meses que comprovem o recebimento dos
				                    aluguéis;</li>
				                </ul>
				                <strong>Renda Proveniente de Pensão Alimentícia:</strong>
				                <ul>
				                    <li>Sentença judicial acompanhada dos 03 últimos
				                    recibos de pensão;</li>
				                    <li></li>
				                </ul>
				            </div>
				            <hr>
				            <div class="col-md-12 clearfix"><br></div>
				        </div>
			        <p><sub>OBS: Eventualmente outros documentos poderão ser solicitados para confirmar os dados constantes da Ficha Cadastral ou com o objetivo de comprovar o
			                rendimento declarado pelo pretendente.</sub></p>
			        <?php
			        yii\bootstrap\Modal::end();
			        ?>
				</div>
				<div class="col-md-4"></div>
			</div>
		<?php endif; ?>
		<div class="clearfix"></div>
		<br>
		<?php
			/*switch ($form) {
				//Primeira parte dos formulários:
				case '003': $_porcent = $porcent + 1*$_unidade;	break; #Infos Pessoais 2
				case '005': $_porcent = $porcent + 2*$_unidade;	break; #Infos Documentais 1
				case '006': $_porcent = $porcent + 3*$_unidade;	break; #Infos Documentais 2
				case '007': $_porcent = $porcent + 4*$_unidade;	break; #Infos Profissionais
				//Registro do Cônjuge
				case '009': $_porcent = $porcent + 5*$_unidade;	break; #Cônjuge Infos Pessoais 1
				case '010': $_porcent = $porcent + 6*$_unidade;	break; #Cônjuge Infos Pessoais 2
				case '013': $_porcent = $porcent + 7*$_unidade;	break; #Cônjuge Infos Profissionais
				//Segunda Parte dos Formulários
				case '015': $_porcent = $porcent + (5+$_se_casado) * $_unidade;	break; #Infos Bancárias
				case '016': $_porcent = $porcent + (6+$_se_casado) * $_unidade;	break; #Infos Moratual 1
				case '017': $_porcent = $porcent + (7+$_se_casado) * $_unidade;	break; #Infos Moratual 2
				case '018': $_porcent = $porcent + (8+$_se_casado) * $_unidade;	break; #Infos Moratual 3
				//Encerramento: registros de Ocupantes
				case '019': $_porcent = 100;	break;

				default: $_porcent = 0; break;
			}*/
		?>
		<!-- <div class="progress">
			<div class="progress-bar bg-success" role="progressbar" style="width: <?=$_porcent?>%" aria-valuenow="<?=$_porcent?>" aria-valuemin="0" aria-valuemax="100"><?=$_porcent?> % </div>
		</div> -->
		<?php
		use yii\bootstrap\Alert;
		if(Yii::$app->session->hasFlash('success')){
			echo Alert::widget([
				'options' => [
					'class' => 'alert-info',
				],
				'body' => Yii::$app->session->getFlash('success'),
			]);
		}
			//echo Yii::$app->session->getFlash('success');
		?>
		<?= $this->render('_form'.$form, [
				'model' => $model,
				'model2' => $model2,
				'modelproposta' => $modelproposta,
				'conjuge' => $conjuge,
				'pretendente_id' => $pretendente_id,
				'proposta_id' => $proposta_id,
				'se_casado' => $_se_casado_mais_um,
		]) ?>

	</div>
	<div class="clearfix aparece-mobile"></div>
	<?php if ($form == '019') : ?>
		<div class="col-md-3 div-ocupantes">
			<?php
				echo "<h4 class='titulo' style='text-align:center'><strong>Ocupantes Cadastrados</strong></h4><hr>";
				// echo "<ol>";
				echo "<div class='col-md-12'>";
				echo "<table style='width: 100%;'>";
				foreach ($principal->sloOcupantes as $row) {
					echo "<tr>";
					echo "<td style='padding:1%'>";
					Modal::begin([
						'header' => '<h4 class="titulo">Editar Informações</h4><h5 class="titulo">'.$row->nome.'</h5>',
						'toggleButton' => [
							'label' => '<i class="fas fa-home float-left"></i>'.$row->nome,
							'class' => 'btn btn-primary',
							'style' => 'width:100%;text-transform:capitalize;'
						],
					]);

					$model_desse_ocupante = app\models\SloOcupante::find()->where([
						'id'=>$row->id,
					])->one();

					echo $this->render('_form_ocupante', [
						'model' => $model_desse_ocupante,
						'conjuge' => $conjuge,
						'pretendente_id' => $pretendente_id,
						'proposta_id' => $proposta_id,
						'ocupante_id' => $row->id,
					]);

					Modal::end();
					echo "</td>";
					echo "<td>";
					//echo '<a href="'.'" class="btn" style="color:gray" title="Excluir Ocupante"><i class="fas fa-remove"></i></a>';
					echo Html::a('<i class="fas fa-remove"></i>', ['delete_ocupante', 'id' => $row->id], [
						'class' => 'btn btn-warning float-left',
						'style' => '',
						'data' => [
							'confirm' => "Tens certeza que deseja excluir esse Ocupante?",
							'method' => 'post',
						],
					]);
					echo "</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</div>";
				echo "<div class='col-md-12 clearfix' style='height:5px'></div>";
				// echo "</ol>";

			?>
		</div>
	<?php endif; ?>
	<?php if ($form == '020') : ?>
		<div class="col-md-3 div-ocupantes">
			<?php
				echo "<h4 class='titulo' style='text-align:center'><strong>Ocupantes Cadastrados</strong></h4><hr>";
				// echo "<ol>";
				echo "<div class='col-md-12'>";
				echo "<table style='width: 100%;'>";

				foreach ($principal->sloFiadors as $row) {
						echo "<tr>";
						echo "<td style='padding:1%'>";
						Modal::begin([
							'header' => '<h4 class="titulo">Editar Informações</h4><h5 class="titulo">'.$row->sloInfospessoais->nome.'</h5>',
							'size' => 'modal-lg',
							'toggleButton' => [
								'label' => '<i class="fas fa-home float-left"></i>'.$row->sloInfospessoais->nome,
								'class' => 'btn btn-primary',
								'style' => 'width:100%; text-transform:capitalize;'
							],
						]);

						// echo '<br>'.$row->sloInfospessoais->nome;
						// echo '<br>'.$row->sloInfospessoais->cpf;
						// echo '<br>'.$row->sloInfospessoais->data_nascimento;
						// echo '<hr>';
						// echo '<br>'.$row->tipo_documento;
						// echo '<br>'.$row->numero;
						// echo '<hr>';
						// echo '<br>'.$row->sloInfosprofissionais->empresa;
						// echo '<br>'.$row->sloInfosprofissionais->profissao;
						// echo '<hr>';
						// echo '<br>'.$row->sloFiadorconjuges->sloInfospessoais->nome;
						// echo '<br>'.$row->sloFiadorconjuges->sloInfospessoais->cpf;
						// echo '<br>'.$row->sloFiadorconjuges->sloInfospessoais->data_nascimento;

						echo $this->render('_form_fiador', [
							'model' => $row,
							'pretendente_id' => $pretendente_id,
							'proposta_id' => $proposta_id,
							'id' => $row->id,
						]);

						Modal::end();
						echo "</td>";
						echo "<td>";

						echo Html::a('<i class="fas fa-remove"></i>', ['delete_fiador', 'id' => $row->id], [
							'class' => 'btn btn-warning float-left',
							'style' => '',
							'data' => [
								'confirm' => "Tens certeza que deseja excluir esse Ocupante?",
								'method'  => 'post',
							],
						]);
						echo "</td>";
						echo "</tr>";
				}
				echo "</table>";
				echo "</div>";
				echo "<div class='col-md-12 clearfix' style='height:5px'></div>";

			?>
		</div>
	<?php endif; ?>
</div>
<?php
	if ($form == '020'):
		echo '<div class="clearfix"></div>';
		echo "<div class='col-md-12' style=''>";
			echo "<br><br><br>";
			echo "<div class='col-md-4'></div>";
			echo "<div class='col-md-4'>";
			echo '<a
								id="botao-final-dos-forms"
								class="btn btn-primary btn-destaque"
								style="font-weight: bolder; width:100%; font-size: 18px; text-transform: uppercase"
								href="'.Yii::$app->homeUrl.'proposta/concluido?proposta_id='.$proposta_id.'&pretendente_id='.$pretendente_id.'"
						>
						Encerrar os Registros
				</a>';
			echo "</div>";
			echo "<div class='col-md-4'></div>";
		echo "</div>";
	endif;
	$this->registerJS('
		$("input").css("text-align","left");
		$("#botao-final-dos-forms").on("click", function(){
				valor_final_fiador = $("input[name=\'tipofiador\']:checked").val();
				$.ajax({
						type: "POST",
						url:"pretfiador",
						data:{
								val: valor_final_fiador,
								id: '.$pretendente_id.'
						},
						success: function(data){
								console.log("sucesso");
						}
				})
		});
	');
?>
<style type="text/css">
	#chat-msg {
		background-color: var(--cor-bg-elementos);
		position: fixed;
	    right: 5px;
	    bottom: 0;
	    padding: 10px;
	    border-top-left-radius: 10px;
	    border-top-right-radius: 10px;
	}
	#chat-msg label{
		width: 100%;
	    background: ghostwhite;
	    text-align: center;
	    padding: 5px;
	    margin-bottom: 0;
	    /*border-top-left-radius: 10px;
	    border-top-right-radius: 10px;*/
	}
	#chat-msg textarea{
		width: 100% !important;
    	border: 5px solid !important;
    	border-color: ghostwhite !important;
    	text-transform: none !important;
    	/*border-bottom-left-radius: 10px;
	    border-bottom-right-radius: 10px;*/
	}
	#chat-msg a:hover, #chat-msg a:focus {
	    color: var(--cor-bg-fundo) !important;
	    text-decoration: none !important;
	    text-decoration: bolder !important;
	    font-weight: bolder;
	}
	#chat-msg .panel-heading {
		text-align: center !important;
		background-color: var(--cor-bg-elementos) !important;
		/*border-color: var(--cor-bg-fundo) !important;*/
		color: white !important;
	}
	#chat-msg .btn-success {
	    color: gray;
	    background-color: lightgray;
	    border-color: lightgray;
	}
	#chat-msg .glyphicon-remove-circle {
		font-size: 25px !important;
    	color: red !important;
	}
	#historico-div {
		overflow-y: auto;
		height: 200px;
		border: 5px solid ghostwhite;
		border-top-left-radius: 10px;
		background-color: ghostwhite;
	}
	.balao-1 {
        background-color: var(--cor-bg-elementos);
        margin: 5px;
        padding: 10px;
        border-radius: 10px;
        width: 80%;
        float: right;
        color: white;
        font-style: italic;
        padding-top: 20px;
    }
    .balao-2 {
        background-color: var(--cor-bg-fundo);
        margin: 5px;
        padding: 10px;
        padding-top: 20px;
        border-radius: 10px;
        width: 80%;
        float: left;
        color: white;
        font-style: italic;
    }
    .data-msg{
        float: left;
        position: relative;
        top: -7px;
    }
    #botao-close-chat {
    	position: absolute;
	    right: 3%;
	    top: 3%;
    }
</style>
<?php
	echo "<div class='col-md-3 float-right' style='' id='chat-msg'>";
	$mensagem = new app\models\Mensagem;

	$conversa = app\models\Mensagem::find()->where([
		'slo_pretendente_id'=>$pretendente_id
	])->orderBy(['data' => SORT_ASC])->all();

	$historico = '<div id="historico-div" class="col-md-12">';
	if (count($conversa) > 0) {
		$historico .= '';
		foreach ($conversa as $row) {
			$balao = ($row->usuario_id != '') ? '2' : '1' ;

            $historico .= '<div class="col-md-12 balao-'.$balao.'">';
            // $historico .= '<sup>'.$row->usuario->nome.': '.'</sup>';
            $historico .= '<sup class="data-msg">'.$row->data.'</sup>';
            $historico .= '<span>'.$row->texto.'</span>';
            $historico .= '</div>';
            $historico .= '<div class="clearfix"></div>';
		}
		$historico .= '<hr>';
	}
	$historico .= '</div>';

	echo Collapse::widget([
        'items' => [
            [
                'label' => 'FALE CONOSCO',
                'content' => $historico.$this->render('/mensagem/_form', [
				        'model' => $mensagem,
				        'pretendente_id' => $pretendente_id,
				        'ativo' => 'cliente'
				    ]),

			]
		]
	]);
    echo "</div>";
    $this->registerJS('
    	$(".comment-form").on(\'beforeSubmit\', function () {
            var data = $(this).serializeArray();
            var url = $(this).attr(\'action\');
            $.ajax({
                url: url,
                type: \'post\',
                dataType: \'json\',
                data: data,
                beforeSend: function(){
					$("#bota-submit-nisso").html("Enviando...");
				},
				success: function(data){
					setInterval(function(){ $("#bota-submit-nisso").html("Enviar") },1000);
				}
            })
            .done(function(response) {
                if (response.data.success == true) {
                    console.log("Wow you commented");
                    $("#mensagem-texto").val("");
                    $("#historico-div").html(response.data.message);
                    var objDiv = document.getElementById("historico-div");
					objDiv.scrollTop = objDiv.scrollHeight;
                }
            })
            .fail(function() {
                console.log("error");
            });
            return false;
        });
        setInterval(function(){
            var formulario = $(".comment-form");
            // var data = formulario.serializeArray();
            var url = "'.Yii::$app->homeUrl.'mensagem/ajaxcommentadmin";
            $.ajax({
                url: url,
                type: \'post\',
                // dataType: \'json\',
                data: {
                    "pretendente_id" : "'.$pretendente_id.'",
                    "ativo" : ""
                }
            })
            .done(function(response) {
                if (response.data.success == true) {
                    $("#historico-div").html(response.data.message);
                    // var objDiv = document.getElementById("historico-div");
                    // objDiv.scrollTop = objDiv.scrollHeight;
                }
            })
            .fail(function() {
                console.log("error");
            });
        }, 5000);

		// Add botão fechar
		// $(".panel-heading").append(\'<a class="btn btn-danger float-right" id="botao-close-chat">x</a>\');
		// $("#botao-close-chat").on("click", function(){$(\'.collapse\').collapse()});
		$(\'a[data-toggle="collapse"]\').html("<span class=\'float-left\'>FALE CONOSCO</span> <span class=\'float-right toggle-icon glyphicon glyphicon-menu-down\'></span>");
        $(\'a[data-toggle="collapse"]\').click(function () {
            $(this).find(\'span.toggle-icon\').toggleClass(\'glyphicon-remove-circle glyphicon-menu-down\');
        });
        $(\'a[data-toggle="collapse"]\').append("<div class=\'clearfix\'></div>");
	');
    // USAR ID DO PRETENTENDE PRA IDENTIFICAR A RESPOSTA DO USUÁRIO ADMIN DO SISTEMA
?>
