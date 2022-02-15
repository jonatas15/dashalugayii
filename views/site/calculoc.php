<?php 
	use yii\helpers\Html;
	use kartik\number\NumberControl;
	echo NumberControl::widget([
		'language' => 'pt_BR',
	    'name' => 'normal-decimal',
	    'id' => 'normal-decimal',
	    'value' => 43829.39,
	    'maskedInputOptions' => [
	        'groupSeparator' => '.',
	        'radixPoint' => ','
	    ],
	]);

?>
<style type="text/css">
	.col-md-3{
		padding: 2%;
	}
</style>
<?php $form = \yii\widgets\ActiveForm::begin([
    // 'id' => 'my-form-id',
    // 'action' => 'save-url',
    // 'enableAjaxValidation' => true,
    // 'validationUrl' => 'validation-rul',
]); ?>
<div class="col-md-12">
	<div class="col-md-3">
		<div class="form-group row">
		 	<label for="example-number-input" class="col-2 col-form-label">Aluguel Líquido</label>
		  	<div class="col-10 input-group">
			  	<span class="input-group-addon">R$</span>    
			    <input class="form-control" type="number" value="0" id="aluguel_liquido">
		  	</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group row">
		  <label for="example-number-input" class="col-2 col-form-label">Aluguel Bruto</label>
		  <div class="col-10 input-group">
			<span class="input-group-addon">R$</span> 
		    <input class="form-control" type="number" value="0" id="aluguel_bruto">
		  </div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group row">
		  <label for="example-number-input" class="col-2 col-form-label">Condomínio</label>
		  <div class="col-10 input-group">
			<span class="input-group-addon">R$</span> 
		    <input class="form-control" type="number" value="0" id="condominio">
		  </div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group row">
		  	<label for="example-number-input" class="col-2 col-form-label">IPTU/Mês</label>
		  	<div class="col-10 input-group">
				<span class="input-group-addon">R$</span> 
		    	<input class="form-control" type="number" value="0" id="iptu_mes">
		  	</div>
		</div>
	</div>

	<div class="col-md-12">
		<span style="font-style: oblique;"> * Use tecla 'enter' para executar cálculos</span>
		<br />
		<br />
	</div>

	<div class="col-md-12 clearfix"></div>
	<div class="col-md-12">
		<div class="col-md-4">
			<label>Aluguel com 10%:</label>
			<span id="aluguel_10"></span>
		<br>
			<label>Total (Base Seguro):</label>
			<span id="total_base_seguro"></span>
		</div>
		<div class="col-md-4">
			<label>Seguro Mensal:</label>
			<span id="seguro_mensal"></span>
		<br>
			<label>Apurado:</label>
			<span id="apurado"></span>
		</div>
		<div class="col-md-4">
			<label>Diferença de Locação:</label>
			<span id="diferenca_locacao"></span>
		<br>
			<label>Valor final de Locação:</label>
			<span id="valor_final_locacao"></span>
		</div>
	</div>
</div>

<?php $form->end(); ?>
<!-- <script type="text/javascript">
	$(document).ready(function(){
		$('#teste').on('blur', function(){
			alert('saiu do campo');
		});
	});
</script> -->
<?php
$this->registerJS('
	var aluguel_10 = 0,
		total_base_seguro = 0,
		seguro_mensal = 0,
		apurado = 0,
		diferenca_locacao = 0,
		valor_final_locacao = 0;

	
	function addCommas(nStr)
	{
	    nStr += \'\';
	    x = nStr.split(\'.\');
	    x1 = x[0];
	    x2 = x.length > 1 ? \',\' + x[1] : \'\';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, \'$1\' + \'.\' + \'$2\');
	    }
	    return x1 + x2;
	}

	function executa_a_parada(){

		if($("#aluguel_liquido").val() != "")	aluguel_liquido = $("#aluguel_liquido").val();
		if($("#aluguel_bruto").val() != "")		aluguel_bruto   = $("#aluguel_bruto").val();
		if($("#condominio").val() != "")		condominio 		= $("#condominio").val();
		if($("#iptu_mes").val() != "")			iptu_mes 		= $("#iptu_mes").val();

		if(aluguel_liquido == "")aluguel_liquido = 0;
		if(aluguel_bruto   == "")aluguel_bruto = 0;  
		if(condominio 	   == "")condominio = 0;
		if(iptu_mes 	   == "")iptu_mes = 0;

		aluguel_liquido = parseFloat(aluguel_liquido);
		aluguel_bruto   = parseFloat(aluguel_bruto);
		condominio 		= parseFloat(condominio);
		iptu_mes 		= parseFloat(iptu_mes);

		console.log("aluguel_liquido = "+aluguel_liquido+" || aluguel_bruto   = "+aluguel_bruto+" || condominio = "+condominio+" ||	iptu_mes = "+iptu_mes+" ||");

		if(aluguel_liquido > 0){
			aluguel_10 = aluguel_liquido/0.9;
		}else{
			aluguel_10 = aluguel_bruto;
		}

		total_base_seguro = aluguel_10 + iptu_mes + condominio;
		seguro_mensal = (total_base_seguro*(80/100))/11;
		apurado = (aluguel_10 * (3/100)) + ((aluguel_10 - (aluguel_10*(10/100)))*(5/100));
		diferenca_locacao = seguro_mensal - apurado;
		valor_final_locacao = aluguel_10 + diferenca_locacao;

		$("#aluguel_10").html("R$ "+addCommas(aluguel_10.toFixed(2)));
		$("#total_base_seguro").html("R$ "+addCommas(total_base_seguro.toFixed(2)));
		$("#seguro_mensal").html("R$ "+addCommas(seguro_mensal.toFixed(2)));
		$("#apurado").html("R$ "+addCommas(apurado.toFixed(2)));
		$("#diferenca_locacao").html("R$ "+addCommas(diferenca_locacao.toFixed(2)));
		$("#valor_final_locacao").html("R$ "+addCommas(valor_final_locacao.toFixed(2)));


		if(aluguel_liquido > 0){$("#aluguel_liquido").val(aluguel_liquido);}
		if(aluguel_bruto > 0){$("#aluguel_bruto").val(aluguel_bruto);}
		if(condominio > 0){$("#condominio").val(condominio);}
		if(iptu_mes > 0){$("#iptu_mes").val(iptu_mes);}
	}

	$(document).ready(function(){

		var aluguel_liquido = $("#aluguel_liquido").val();
		var aluguel_bruto   = $("#aluguel_bruto").val();
		var condominio 		= $("#condominio").val();
		var iptu_mes 		= $("#iptu_mes").val();
		
		$("input").focus(function(){
			
			if($(this).val() == "" || $(this).val() == "0"){
				aluguel_liquido = $("#aluguel_liquido").val();
				aluguel_bruto   = $("#aluguel_bruto").val();
				condominio 		= $("#condominio").val();
				iptu_mes 		= $("#iptu_mes").val();

				$(this).val("");
			}

		});
		
		$("input").bind("blur keyup", function(e){
			if (e.type === "blur" || e.keyCode === 13){
				
				executa_a_parada();

			}

		});

		$("input").keydown( function(e) {
	        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	        if(key == 13) {
	            e.preventDefault();
	            var inputs = $(this).closest("form").find(":input");
	            inputs.eq( inputs.index(this)+ 1 ).focus();
	            console.log("tecla: "+inputs.index(this));
	        	executa_a_parada();
	        }
	    });

	});
');
?>