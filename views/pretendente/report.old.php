<?php
	$pessoais = \app\models\SloInfospessoais::find()->where(['pretendente_id' => $id])->one();
	$profissionais = \app\models\SloInfosprofissionais::find()->where(['pretendente_id' => $id])->one();
	$documentais = \app\models\SloContratodocumento::find()->where(['slo_pretendente_id' => $id])->one();
	$ref_bancarias = \app\models\SloRefbancaria::find()->where(['slo_pretendente_id' => $id])->one();
	$mora_atual = \app\models\SloMoratual::find()->where(['slo_pretendente_id' => $id])->one();
	
	$conjuge = \app\models\SloConjuje::find()->where(['pretendente_id' => $id])->one();
	$conj_pessoais = \app\models\SloInfospessoais::find()->where(['conjuje_id' => $conjuge->id])->one();
	$conj_profissionais = \app\models\SloInfosprofissionais::find()->where(['conjuje_id' => $conjuge->id])->one();
	
	
	$retorno  = '<br><br>';
	$retorno .= "<table border='0' width='1000'>";
	$retorno .= '<tr>';
	$retorno .= '<th colspan="3">';
	$retorno .= '<h3>Informações Pessoais</h3><hr>';
	$retorno .= '</th>';
	$retorno .= '</tr>';
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Nome:</strong><br> '.$pessoais->nome.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>CPF:</strong><br> '.$this->context->format_cpf($pessoais->cpf).'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Data de Nascimento:</strong><br> '.date('d/m/Y',strtotime($pessoais->data_nascimento)).'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Emancipado:</strong><br> '.
	($pessoais->emancipado ? 'Sim' : 'Não').'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Telefone Residencial:</strong><br> '.
	$this->context->format_telefone($pessoais->fone_residencial).'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Celular:</strong><br> '.
	$this->context->format_telefone($pessoais->celular).'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	// $retorno .= '<td >';
	// $retorno .= '<h4 class="lb-info"><strong>Pode arcar financeiramente?</strong><br> '.
	// ($pessoais->possui_renda ? 'Sim' : 'Não').'</h4>';
	// $retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Irá residir no Imóvel?</strong><br> '.
	($pessoais->vai_morar ? 'Sim' : 'Não').'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Gênero:</strong><br> '.
	($pessoais->genero == 'M' ? 'Masculino' : 'Feminino').'</h4>';
	$retorno .= "</td>";
	
	$retorno .= '<td >';
	$retorno .= '<h4 class="lb-info"><strong>Estado Civil:</strong><br> '.
	$pessoais->estado_civil.'</h4>';
	$retorno .= "</td>";
	
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------

	$retorno .= '<td  colspan="1">';
	$retorno .= '<h4 class="lb-info"><strong>Nacionalidade:</strong><br> '.
	$pessoais->nacionalidade.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td  colspan="1">';
	$retorno .= '<h4 class="lb-info"><strong>Nº de Dependentes:</strong><br> '.
	$pessoais->numero_dependentes.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Nome da Mãe</strong><br> '.
	$pessoais->nome_mae.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
	
	if ($pessoais->nacionalidade == 'extrangeiro'):
		$retorno .= '<tr>';
		$retorno .= '<td colspan="3">';
		$retorno .= '<h4 class="lb-info"><strong>Se extrangeiro, há quanto tempo no país?</strong><br> '.
		$pessoais->extrangeiro_temponopais.'</h4>';
		$retorno .= "</td>";
		$retorno .= '</tr>';
	endif;

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------

	$retorno .= '<td >';
	$retorno .= '<h4 class="lb-info"><strong>Nome do Pai:</strong><br> '.
	$pessoais->nome_pai.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
	
	$retorno .= '<tr>';
	$retorno .= '<td colspan="3">';
	$retorno .= '<h4 class="lb-info"><strong>Email para contato: </strong>'.
	'<a href="mailto:'.$pessoais->email.'">'.$pessoais->email.'</a>'.'</h4>';
	$retorno .= '</td>';
	$retorno .= '</tr>';

	$retorno .= "</table>";

	$retorno .= '<br><br>';
	$retorno .= "<table border='0' width='1000'>";
	$retorno .= '<tr>';
	$retorno .= '<th colspan="3">';
	$retorno .= '<h3>Informações Profissionais</h3><hr>';
	$retorno .= '</th>';
	$retorno .= '</tr>';
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Nome da Empresa:</strong><br> '.$profissionais->empresa.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Telefone para contato:</strong><br> '.$this->context->format_telefone($profissionais->fone).'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Data de Admissão:</strong><br> '.date('d/m/Y',strtotime($profissionais->data_admissao)).'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Profissão:</strong><br> '.$profissionais->profissao.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Vínculo Empregatício:</strong><br> '.$profissionais->vinculo_empregaticio.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .="<tr>";
	$retorno .= '<td colspan="3">';
	$retorno .= '<h4 class="lb-info"><strong>Possui renda para arcar financeiramente com a Locação:</strong><br> '.($profissionais->possui_renda==1?'Sim':'Não').'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .="<tr>";
	$retorno .= '<th colspan="3">';
	$retorno .= '<h4 class="lb-info"><hr><strong>Emprego Anterior:</strong>'.'</h4>';
	$retorno .= "</th>";
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Empresa:</strong><br> '.$profissionais->empganterior_empresa.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Telefone:</strong><br> '.$profissionais->empganterior_fone.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Endereço:</strong><br> '.$profissionais->empganterior_endereco.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Número:</strong><br> '.$profissionais->empganterior_end_numero.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Complemento:</strong><br> '.$profissionais->empganterior_end_complemento.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>CEP:</strong><br> '.$profissionais->empganterior_end_cep.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Bairro:</strong><br> '.$profissionais->empganterior_end_bairro.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Cidade:</strong><br> '.$profissionais->empganterior_end_cidade.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Estado:</strong><br> '.$profissionais->empganterior_end_estado.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= "</table>";

	$retorno .= '<br><br>';
	$retorno .= "<table border='0' width='1000'>";
	$retorno .= '<tr>';
	$retorno .= '<th colspan="5">';
	$retorno .= '<h3>Documentação</h3><hr>';
	$retorno .= '</th>';
	$retorno .= '</tr>';
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Tipo de Documento:</strong><br> '.$documentais->tipo_documento.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Número:</strong><br> '.$documentais->numero.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Órgão Expedidor:</strong><br> '.$documentais->orgao_expedidor.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Data de Expedição:</strong><br> '.date('d/m/Y',strtotime($documentais->data_expedicao)).'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Endereço:</strong><br> '.$documentais->endereco.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
	$retorno .= "</table>";

	$retorno .= '<br><br>';
	$retorno .= "<table border='0' width='1000'>";
	$retorno .= '<tr>';
	$retorno .= '<th colspan="4">';
	$retorno .= '<h3>Dados Bancários</h3><hr>';
	$retorno .= '</th>';
	$retorno .= '</tr>';
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Nome da Empresa:</strong><br> '.$ref_bancarias->nome_banco.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Agência:</strong><br> '.$ref_bancarias->agencia.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Conta Corrente:</strong><br> '.$ref_bancarias->conta_corrente.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Cliente desde:</strong><br> '.date('d/m/Y',strtotime($ref_bancarias->cliente_desde)).'</h4>';
	$retorno .= "</td>";

	$retorno .= '</tr>';
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Gerente:</strong><br> '.$ref_bancarias->gerente.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Telefone:</strong><br> '.$this->context->format_telefone($ref_bancarias->telefone).'</h4>';
	$retorno .= "</td>";
	
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
	$retorno .= "</table>";

	
	$retorno .= "<pagebreak />";
	###############################################################################################################
	# ----------------------------------------------------------------------------------------------------------- #
	########################### 			   OUTRAS INFORMAÇÕES				###################################
	# ----------------------------------------------------------------------------------------------------------- #
	###############################################################################################################


	$retorno .= '<br><br>';
	$retorno .= "<table border='0' width='1000'>";
	$retorno .= '<tr>';
	$retorno .= '<th colspan="4">';
	$retorno .= '<h3>Onde mora atualmente</h3><hr>';
	$retorno .= '</th>';
	$retorno .= '</tr>';
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	
	$retorno .= '<td colspan="2">';
	$retorno .= '<h4 class="lb-info"><strong>Endereço:</strong><br> '.$mora_atual->endereco.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Número:</strong><br> '.$mora_atual->numero.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Complemento:</strong><br> '.$mora_atual->complemento.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; # Fim da Linha ----------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha ---------------------------------------------------------
	
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Cep:</strong><br> '.$mora_atual->cep.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Bairro:</strong><br> '.$mora_atual->bairro.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Cidade:</strong><br> '.$mora_atual->cidade.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Estado:</strong><br> '.$mora_atual->uf.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; # Fim da Linha ----------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha ---------------------------------------------------------
	
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Residência Atual:</strong><br> '.$mora_atual->residencia_atual.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Em nome de:</strong><br> '.$mora_atual->em_nome_de.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Tempo na Residência:</strong><br> '.$mora_atual->tempo_residencia.'</h4>';
	$retorno .= "</td>";

	if ($mora_atual->residencia_atual == 'Alugada') {
		$retorno .= '<tr>'; #INÍCIO da Linha -----------------------------------------------------
		$retorno .= '<td colspan="2">';
		$retorno .= '<h4 class="lb-info"><strong>Nome do Locador/Proprietário/Imobiliária:</strong><br> '.$mora_atual->locador_nome.'</h4>';
		$retorno .= "</td>";
		$retorno .= '<td colspan="2">';
		$retorno .= '<h4 class="lb-info"><strong>Telefone do Locador:</strong><br> '.$mora_atual->locador_fone.'</h4>';
		$retorno .= "</td>";
		$retorno .= "</tr>"; # Fim da Linha ------------------------------------------------------
	}

	$retorno .= "</tr>"; # Fim da Linha ----------------------------------------------------------
	$retorno .="<tr>";
	$retorno .= '<th colspan="4">';
	$retorno .= '<h4 class="lb-info"><hr><strong>Gastos Residenciais:</strong>'.'</h4>';
	$retorno .= "</th>";
	$retorno .= "</tr>"; #FIM da Linha -----------------------------------------------------------
	
	$retorno .= '<tr>'; #INÍCIO da Linha ---------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Gasto Atual - Água:</strong><br> '.$mora_atual->gastoatual_agua.'</h4>';
	$retorno .= "</td>";
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Gasto Atual - Água:</strong><br> '.$mora_atual->gastoatual_luz.'</h4>';
	$retorno .= "</td>";
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Gasto Atual - Água:</strong><br> '.$mora_atual->gastoatual_gas.'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; # Fim da Linha ----------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha ---------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Possui outros imóveis alugados?</strong><br> '.
				($mora_atual->outros_imoveis_alugados?'Sim':'Não').'</h4>';
	$retorno .= "</td>";
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Há bens financiados ou empréstimos?</strong><br> '.
				($mora_atual->bens_financiados_emprestimos?'Sim':'Não').'</h4>';
	$retorno .= "</td>";
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Possui dependentes com doenças Crônicas?</strong><br> '.
				($mora_atual->dependente_com_doenca?'Sim':'Não').'</h4>';
	$retorno .= "</td>";
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Há dependentes estudantes?</strong><br> '.
				($mora_atual->dependentes_estudantes?'Sim':'Não').'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; # Fim da Linha ----------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha ---------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Valor do aluguel + encargos:</strong><br> '.
				($mora_atual->outros_ia_aluguel_encargos).'</h4>';
	$retorno .= "</td>";
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Bem e a prestação mensal</strong><br> '.
				($mora_atual->bens_fe_nome_valor).'</h4>';
	$retorno .= "</td>";
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Gastos com farmácia/saúde</strong><br> '.
				($mora_atual->dependente_doente_infos).'</h4>';
	$retorno .= "</td>";
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Gastos com educação:</strong><br> '.
				($mora_atual->dependentes_estudantes_info).'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; # Fim da Linha ----------------------------------------------------------


	$retorno .= "</table>";


	###############################################################################################################
	# ----------------------------------------------------------------------------------------------------------- #
	########################### 					CÔNJUGE						###################################
	# ----------------------------------------------------------------------------------------------------------- #
	###############################################################################################################

	$retorno .= "<br>";

	$retorno .= '<h3>Cônjuge</h3><hr>';

	$retorno .= "<table border='0' width='1000'>";
	$retorno .= '<tr>';
	$retorno .= '<th colspan="3">';
	$retorno .= '<h3>Informações Pessoais do Cônjuge</h3><hr>';
	$retorno .= '</th>';
	$retorno .= '</tr>';
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Nome:</strong><br> '.$conj_pessoais->nome.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>CPF:</strong><br> '.$this->context->format_cpf($conj_pessoais->cpf).'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Data de Nascimento:</strong><br> '.date('d/m/Y',strtotime($conj_pessoais->data_nascimento)).'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Emancipado:</strong><br> '.
	($conj_pessoais->emancipado ? 'Sim' : 'Não').'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Telefone Residencial:</strong><br> '.
	$this->context->format_telefone($conj_pessoais->fone_residencial).'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Celular:</strong><br> '.
	$this->context->format_telefone($conj_pessoais->celular).'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Irá residir no Imóvel?</strong><br> '.
	($conj_pessoais->vai_morar ? 'Sim' : 'Não').'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Gênero:</strong><br> '.
	($conj_pessoais->genero == 'M' ? 'Masculino' : 'Feminino').'</h4>';
	$retorno .= "</td>";
	
	$retorno .= '<td >';
	$retorno .= '<h4 class="lb-info"><strong>Estado Civil:</strong><br> '.
	$conj_pessoais->estado_civil.'</h4>';
	$retorno .= "</td>";
	
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------

	$retorno .= '<td  colspan="1">';
	$retorno .= '<h4 class="lb-info"><strong>Nacionalidade:</strong><br> '.
	$conj_pessoais->nacionalidade.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td  colspan="1">';
	$retorno .= '<h4 class="lb-info"><strong>Nº de Dependentes:</strong><br> '.
	$conj_pessoais->numero_dependentes.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Nome da Mãe</strong><br> '.
	$conj_pessoais->nome_mae.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
	
	if ($pessoais->nacionalidade == 'extrangeiro'):
		$retorno .= '<tr>';
		$retorno .= '<td colspan="3">';
		$retorno .= '<h4 class="lb-info"><strong>Se extrangeiro, há quanto tempo no país?</strong><br> '.
		$conj_pessoais->extrangeiro_temponopais.'</h4>';
		$retorno .= "</td>";
		$retorno .= '</tr>';
	endif;

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------

	$retorno .= '<td >';
	$retorno .= '<h4 class="lb-info"><strong>Nome do Pai:</strong><br> '.
	$conj_pessoais->nome_pai.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
	
	$retorno .= '<tr>';
	$retorno .= '<td colspan="3">';
	$retorno .= '<h4 class="lb-info"><strong>Email para contato: </strong>'.
	'<a href="mailto:'.$conj_pessoais->email.'">'.$conj_pessoais->email.'</a>'.'</h4>';
	$retorno .= '</td>';
	$retorno .= '</tr>';

	$retorno .= "</table>";

	$retorno .= '<br><br>';
	$retorno .= "<table border='0' width='1000'>";
	$retorno .= '<tr>';
	$retorno .= '<th colspan="3">';
	$retorno .= '<h3>Informações Profissionais do Cônjuge</h3><hr>';
	$retorno .= '</th>';
	$retorno .= '</tr>';
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Nome da Empresa:</strong><br> '.$conj_profissionais->empresa.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Telefone para contato:</strong><br> '.$this->context->format_telefone($conj_profissionais->fone).'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Data de Admissão:</strong><br> '.date('d/m/Y',strtotime($conj_profissionais->data_admissao)).'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Profissão:</strong><br> '.$conj_profissionais->profissao.'</h4>';
	$retorno .= "</td>";

	$retorno .= '<td>';
	$retorno .= '<h4 class="lb-info"><strong>Vínculo Empregatício:</strong><br> '.$conj_profissionais->vinculo_empregaticio.'</h4>';
	$retorno .= "</td>";

	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .="<tr>";
	$retorno .= '<td colspan="3">';
	$retorno .= '<h4 class="lb-info"><strong>Possui renda para arcar financeiramente com a Locação:</strong><br> '.($conj_profissionais->possui_renda==1?'Sim':'Não').'</h4>';
	$retorno .= "</td>";
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------

	$retorno .= "</table>";

	###############################################################################################################
	# ----------------------------------------------------------------------------------------------------------- #
	##################################				 MORADORES					###################################
	# ----------------------------------------------------------------------------------------------------------- #
	###############################################################################################################
	$retorno .= "<pagebreak />";
	$retorno .= "<br>";

	$retorno .= "<table border='0' width='1000'>";
	$retorno .= '<tr>';
	$retorno .= '<th colspan="4">';
	$retorno .= '<h3>Ocupantes do Imóvel</h3>';
	$retorno .= '</th>';
	$retorno .= '</tr>';
	

	$ocupante = app\models\SloOcupante::find()->where(['slo_pretendente_id' => $id])->all();
    if (count($ocupante) > 0) {
        foreach ($ocupante as $row) {

        	$retorno .= '<tr>';
        	$retorno .= '<td colspan="4">';
        	$retorno .= '<hr><h4 class="lb-info"><strong>Nome:</strong><br> '.$row->nome.'</h4><br>';
        	$retorno .= '</td>';
        	$retorno .= '</tr>';
 
        	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
			
			$retorno .= '<td>'.'<h4 class="lb-info"><strong>Sexo:</strong><br> '.($row->sexo=='M'?'Masculino':'Feminino').'</h4>'."</td>";
			$retorno .= '<td>'.'<h4 class="lb-info"><strong>CPF:</strong><br> '.$this->context->format_cpf($row->cpf).'</h4>'."</td>";
			$retorno .= '<td>'.'<h4 class="lb-info"><strong>Tipo de Documento:</strong><br> '.$row->tipo_documento.'</h4>'."</td>";
			$retorno .= '<td>'.'<h4 class="lb-info"><strong>Número do Documento:</strong><br> '.$row->numero_documento.'</h4>'."</td>";	

			$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------

			$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
			
			$retorno .= '<td>'.'<h4 class="lb-info"><strong>Data de Expedição:</strong><br> '.date('d/m/Y',strtotime($row->data_expedicao)).'</h4>'."</td>";
			$retorno .= '<td>'.'<h4 class="lb-info"><strong>Órgão Expedidor:</strong><br> '.$row->orgao_expedidor.'</h4>'."</td>";
			$retorno .= '<td>'.'<h4 class="lb-info"><strong>Data de Nascimento:</strong><br> '.date('d/m/Y',strtotime($row->data_nascimento)).'</h4>'."</td>";
			
			$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------


		}
    }
	$retorno .= "</table>";	

	/*

	//Frente do Documento
	$extencao = substr($documentais->frente_documento, strpos($documentais->frente_documento, ".") + 1);
    $retVal = ($extencao == 'pdf') ? 'min-height: 500px;' : '' ;
    $ext = '';
    if ($extencao == 'pdf'){
    	// $retorno .= '<img src="'.Yii::$app->homeUrl.'pretendente/imagempdf?id='.$model->id.'" /><br>';
    	$ext = ' (PDF): Abrir em nova Janela';
    	$retorno .= '<br><a href="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_frentdoc_'.$documentais->frente_documento.'" target="_blank">Frente do Documento'.$ext.'</a>';
    }else{
    	$retorno .= '<br>Frente do Documento:';
    	$retorno .= '<img src="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_frentdoc_'.$documentais->frente_documento.'" />';
    }

	//Verso do Documento
	$extencao = substr($documentais->verso_documento, strpos($documentais->verso_documento, ".") + 1);
    $retVal = ($extencao == 'pdf') ? 'min-height: 500px;' : '' ;
    $ext = '';
    if ($extencao == 'pdf'){
    	// $retorno .= '<img src="'.Yii::$app->homeUrl.'pretendente/imagempdf?id='.$model->id.'" /><br>';
    	$ext = ' (PDF): Abrir em nova Janela';
    	$retorno .= '<hr><a href="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_versodoc_'.$documentais->verso_documento.'" target="_blank">Verso do Documento'.$ext.'</a>';
    }else{
    	$retorno .= '<hr>Verso do Documento:';
    	$retorno .= '<img src="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_versodoc_'.$documentais->verso_documento.'" />';
    }

    //Selfie com o Documento
	$extencao = substr($documentais->selfie_com_documento, strpos($documentais->selfie_com_documento, ".") + 1);
    $retVal = ($extencao == 'pdf') ? 'min-height: 500px;' : '' ;
    $ext = '';
    if ($extencao == 'pdf'){
    	// $retorno .= '<img src="'.Yii::$app->homeUrl.'pretendente/imagempdf?id='.$model->id.'" /><br>';
    	$ext = ' (PDF): Abrir em nova Janela';
    	$retorno .= '<hr><a href="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_versodoc_'.$documentais->selfie_com_documento.'" target="_blank">Selfie com o Documento'.$ext.'</a>';
    }else{
    	$retorno .= '<hr>Selfie com o Documento:';
    	$retorno .= '<img src="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_selfidoc_'.$documentais->selfie_com_documento.'" />';
    }
	
	*/

	echo $retorno;