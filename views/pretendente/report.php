<?php
	$pessoais = \app\models\SloInfospessoais::find()->where(['pretendente_id' => $id])->one();
	$proposta = \app\models\SloProposta::find()->where(['id' => $proposta_id])->one();


	$profissionais = \app\models\SloInfosprofissionais::find()->where(['pretendente_id' => $id])->one();
	$documentais = \app\models\SloContratodocumento::find()->where(['slo_pretendente_id' => $id])->one();
	$ref_bancarias = \app\models\SloRefbancaria::find()->where(['slo_pretendente_id' => $id])->one();
	$mora_atual = \app\models\SloMoratual::find()->where(['slo_pretendente_id' => $id])->one();
	
	$conjuge = \app\models\SloConjuje::find()->where(['pretendente_id' => $id])->one();
	$conj_pessoais = \app\models\SloInfospessoais::find()->where(['conjuje_id' => $conjuge->id])->one();
	$conj_profissionais = \app\models\SloInfosprofissionais::find()->where(['conjuje_id' => $conjuge->id])->one();
	
	function linha($cols, $title, $val) {
		$retorno  = '<td colspan="'.$cols.'">';
		$retorno .= '<h4 class="lb-info"><strong>'.$title.':</strong><br> '.$val.'</h4>';
		$retorno .= "</td>";
		return $retorno;
	}
	
	$retorno  = '<br><br>';
	$retorno .= "<table border='1' width='1000' cellpadding='10'>";
	$retorno .= '<tr>';
	$retorno .= '<th colspan="4" style="background-color: lightgray">';
	$retorno .= '<h3>DADOS DO(A) PRETENDENTE</h3>';
	$retorno .= '</th>';
	$retorno .= '</tr>';
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	
	$retorno .= linha( 3, 'Nome', $pessoais->nome);
	$retorno .= linha( 1, 'CPF', $this->context->format_cpf($pessoais->cpf));

	$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	
	$retorno .= linha( 1, 'Tipo de Documento', $documentais->tipo_documento);
	$retorno .= linha( 1, 'Número', $documentais->numero);
	$retorno .= linha( 1, 'Órgão Expedidor', $documentais->orgao_expedidor);
	$retorno .= linha( 1, 'Data de Expedição', date('d/m/Y',strtotime($documentais->data_expedicao)));
	$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
	##################################################################################################################
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
	
	if ($pessoais->nacionalidade == 'extrangeiro'):
		$retorno .= linha( 1, 'Se extrangeiro, há quanto tempo no país?', $pessoais->extrangeiro_temponopais);
	else:
		$retorno .= linha( 1, 'Nacionalidade', $pessoais->nacionalidade);
	endif;
	$retorno .= linha( 1, 'Emancipado', ($pessoais->emancipado ? 'Sim' : 'Não'));
	$retorno .= linha( 1, 'Data de Nascimento', date('d/m/Y',strtotime($pessoais->data_nascimento)));
	$retorno .= linha( 1, 'Gênero', ($pessoais->genero == 'M' ? 'Masculino' : 'Feminino'));
	
	
	$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
	##################################################################################################################
	
	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------

	$retorno .= linha( 1, 'Nº de Dependentes', $pessoais->numero_dependentes);
	$retorno .= linha( 1, 'Email para contato', $pessoais->email);
	$retorno .= linha( 1, 'Telefone Residencial', $this->context->format_telefone($pessoais->fone_residencial));
	$retorno .= linha( 1, 'Telefone Celular', $this->context->format_telefone($pessoais->celular));
	
	$retorno .= "</tr>";

	##################################################################################################################
	$retorno .= '<tr>';

	$retorno .= linha( 1, 'Irá residir no Imóvel', ($pessoais->vai_morar ? 'Sim' : 'Não'));
	$retorno .= linha( 2, 'Possui renda pra arcar com a Locação', ($profissionais->possui_renda ? 'Sim' : 'Não'));
	$retorno .= linha( 1, 'Estado Civil', $pessoais->estado_civil);
	
	$retorno .= "</tr>";
	##################################################################################################################
	if ($conj_pessoais->nome !=''):
		$retorno .= '<tr><td colspan="4" style="background-color: lightgray"><center>INFORMAÇÕES PESSOAIS DO CÔNJUGE</center></td></tr>';
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		
		$retorno .= linha( 3, 'Nome Do Cônjuge', $conj_pessoais->nome);
		$retorno .= linha( 1, 'CPF', $this->context->format_cpf($conj_pessoais->cpf));

		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
		/*
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		
		$retorno .= linha( 1, 'Tipo de Documento', $documentais->tipo_documento);
		$retorno .= linha( 1, 'Número', $documentais->numero);
		$retorno .= linha( 1, 'Órgão Expedidor', $documentais->orgao_expedidor);
		$retorno .= linha( 1, 'Data de Expedição', date('d/m/Y',strtotime($documentais->data_expedicao)));
		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
		*/
		##################################################################################################################
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		if ($pessoais->nacionalidade == 'extrangeiro'):
			$retorno .= linha( 1, 'Se extrangeiro, há quanto tempo no país?', $conj_pessoais->extrangeiro_temponopais);
		else:
			$retorno .= linha( 1, 'Nacionalidade', $conj_pessoais->nacionalidade);
		endif;
		$retorno .= linha( 1, 'Emancipado', ($conj_pessoais->emancipado ? 'Sim' : 'Não'));
		$retorno .= linha( 1, 'Data de Nascimento', date('d/m/Y',strtotime($conj_pessoais->data_nascimento)));
		$retorno .= linha( 1, 'Gênero', ($conj_pessoais->genero == 'M' ? 'Masculino' : 'Feminino'));
		
		
		$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
		##################################################################################################################
		
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------

		$retorno .= linha( 1, 'Nº de Dependentes', $conj_pessoais->numero_dependentes);
		$retorno .= linha( 1, 'Email para contato', $conj_pessoais->email);
		$retorno .= linha( 1, 'Telefone Residencial', $this->context->format_telefone($conj_pessoais->fone_residencial));
		$retorno .= linha( 1, 'Telefone Celular', $this->context->format_telefone($conj_pessoais->celular));
		
		$retorno .= "</tr>";

		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 1, 'Irá residir no Imóvel', ($conj_pessoais->vai_morar ? 'Sim' : 'Não'));
		$retorno .= linha( 1, 'Possui renda pra arcar com a Locação', ($conj_profissionais->possui_renda ? 'Sim' : 'Não'));
		$retorno .= linha( 1, 'Estado Civil', $conj_pessoais->estado_civil);
		$retorno .= linha( 1, 'Compõe Renda', ($conj_profissionais->compoe_renda ? 'Sim' : 'Não'));
		
		$retorno .= "</tr>";
	endif;
	##################################################################################################################
	if ($mora_atual->residencia_atual != ''):
		$retorno .= '<tr><td colspan="4" style="background-color: lightgray"><center>ONDE O PRETENDENTE MORA ATUALMENTE</center></td></tr>';
		$retorno .= '<tr>';

		$retorno .= linha( 2, 'Residência Atual', $mora_atual->residencia_atual);
		$retorno .= linha( 2, 'Tempo na Residência Atual', $mora_atual->tempo_residencia);

		$retorno .= "</tr>";
		if ($mora_atual->residencia_atual == 'Alugada') {
			$retorno .= '<tr>'; #INÍCIO da Linha -----------------------------------------------------
			$retorno .= linha( 2, 'Nome do Locador/Proprietário/Imobiliária', $mora_atual->locador_nome);
			$retorno .= linha( 2, 'Telefone do Locador', $mora_atual->locador_fone);
			$retorno .= "</tr>"; # Fim da Linha ------------------------------------------------------
		}
		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 1, 'Em nome de', $mora_atual->em_nome_de);
		$retorno .= linha( 1, 'Arca com Aluguel', ($mora_atual->paga_aluguel ? 'Sim' : 'Não'));
		$retorno .= linha( 1, 'Endereço', $mora_atual->endereco);
		$retorno .= linha( 1, 'Número', $mora_atual->numero);

		$retorno .= "</tr>";
		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 1, 'CEP', $mora_atual->cep);
		$retorno .= linha( 1, 'Bairro', $mora_atual->bairro);
		$retorno .= linha( 1, 'Cidade', $mora_atual->cidade);
		$retorno .= linha( 1, 'Estado', $mora_atual->uf);

		$retorno .= "</tr>";
	endif;
	##################################################################################################################
	
	if ($profissionais->empresa != ''):
		$retorno .= '<tr><td colspan="4" style="background-color: lightgray"><center>ONDE O PRETENDENTE TRABALHA</center></td></tr>';
		$retorno .= '<tr>';

		$retorno .= linha( 2, 'Nome da Empresa', $profissionais->empresa);
		$retorno .= linha( 1, 'Data de Admissão', date('d/m/Y',strtotime($profissionais->data_admissao)));
		$retorno .= linha( 1, 'Telefone', $this->context->format_telefone($profissionais->fone));

		$retorno .= "</tr>";
		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 2, 'Profissão', $profissionais->profissao);
		$retorno .= linha( 1, 'Vínculo Empregatício', $profissionais->vinculo_empregaticio);
		$retorno .= linha( 1, 'CNPJ', $this->context->format_cnpj($profissionais->cnpj));

		$retorno .= "</tr>";
		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 1, 'Salário', $this->context->format_real($profissionais->salario));
		$retorno .= linha( 1, 'Outros Rendimentos', $this->context->format_real($profissionais->outros_rendimentos));
		$retorno .= linha( 2, 'Total de rendimentos', $this->context->format_real($profissionais->total_rendimentos));

		$retorno .= "</tr>";
		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 3, 'Empresa do emprego anterior', $profissionais->empganterior_empresa);
		$retorno .= linha( 1, 'Telefone', $profissionais->empganterior_fone);

		$retorno .= "</tr>";
		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 1, 'Período trabalhado', $profissionais->empganterior_periodo);
		$retorno .= linha( 2, 'Endereço', $profissionais->empganterior_endereco);
		$retorno .= linha( 1, 'Número', $profissionais->empganterior_end_numero);

		$retorno .= "</tr>";
		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 1, 'Complemento', $profissionais->empganterior_end_complemento);
		$retorno .= linha( 1, 'CEP', $profissionais->empganterior_end_cep);
		$retorno .= linha( 1, 'Bairro', $profissionais->empganterior_end_bairro);
		$retorno .= linha( 1, 'Cidade - UF', $profissionais->empganterior_end_cidade.' - '.$profissionais->empganterior_end_estado);

		$retorno .= "</tr>";
	endif;
	##################################################################################################################
	if ($conj_profissionais->empresa != ''):
		$retorno .= '<tr><td colspan="4" style="background-color: lightgray"><center>ONDE O CÔNJUGE TRABALHA</center></td></tr>';
		$retorno .= '<tr>';

		$retorno .= linha( 2, 'Nome da Empresa', $conj_profissionais->empresa);
		$retorno .= linha( 1, 'Data de Admissão', date('d/m/Y',strtotime($conj_profissionais->data_admissao)));
		$retorno .= linha( 1, 'Telefone', $this->context->format_telefone($conj_profissionais->fone));

		$retorno .= "</tr>";
		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 2, 'Profissão', $conj_profissionais->profissao);
		$retorno .= linha( 1, 'Vínculo Empregatício', $conj_profissionais->vinculo_empregaticio);
		$retorno .= linha( 1, 'CNPJ', $this->context->format_cnpj($conj_profissionais->cnpj));

		$retorno .= "</tr>";
		##################################################################################################################
		$retorno .= '<tr>';

		$retorno .= linha( 1, 'Salário', $this->context->format_real($conj_profissionais->salario));
		$retorno .= linha( 1, 'Outros Rendimentos', $this->context->format_real($conj_profissionais->outros_rendimentos));
		$retorno .= linha( 2, 'Total de rendimentos', $this->context->format_real($conj_profissionais->total_rendimentos));

		$retorno .= "</tr>";
	endif;

	$retorno .= "</table>";
	
	##################################################################################################################
	########################			INFORMAÇÕES BANCÁRIAS					######################################
	##################################################################################################################


	if ($ref_bancarias->nome_banco != ""):

		$retorno .= '<br><br>';
		$retorno .= "<table border='0' width='1000'>";
		$retorno .= '<tr>';
		$retorno .= '<th colspan="4" style="background-color: lightgray">';
		$retorno .= '<h3>Dados Bancários</h3>';
		$retorno .= '</th>';
		$retorno .= '</tr>';
		
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		
		$retorno .= linha( 1, 'Banco', $ref_bancarias->nome_banco);
		$retorno .= linha( 1, 'Agência', $ref_bancarias->agencia);
		$retorno .= linha( 1, 'Conta Corrente', $ref_bancarias->conta_corrente);
		$retorno .= linha( 1, 'Cliente desde', date('d/m/Y',strtotime($ref_bancarias->cliente_desde)));

		$retorno .= '</tr>';
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------

		$retorno .= linha( 3, 'Gerente', $ref_bancarias->gerente);
		$retorno .= linha( 1, 'Telefone', $this->context->format_telefone($ref_bancarias->telefone));
		
		$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------
		$retorno .= "</table>";
	endif;
	
	###############################################################################################################
	# ----------------------------------------------------------------------------------------------------------- #
	########################### 			   OUTRAS INFORMAÇÕES				###################################
	# ----------------------------------------------------------------------------------------------------------- #
	###############################################################################################################

	/***** OUTRAS INFORMAÇÕES DE ONDE MORA ATUALMENTE???
		$retorno .= "<pagebreak />";

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

	*/
	###############################################################################################################
	# ----------------------------------------------------------------------------------------------------------- #
	##################################				 MORADORES					###################################
	# ----------------------------------------------------------------------------------------------------------- #
	###############################################################################################################
	// $retorno .= "<pagebreak />";
	if($proposta->tipo_imovel != ''):
		$retorno .= "<br>";
		$retorno .= "<br>";
		$retorno .= "<br>";

		$retorno .= "<table border='0' width='1000'>";
		$retorno .= '<tr>';
		$retorno .= '<th colspan="4" style="background-color: lightgray">';
		$retorno .= '<h3>IMÓVEL QUE ESTA SENDO ALUGADO</h3>';
		$retorno .= '</th>';
		$retorno .= '</tr>';
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		$retorno .= linha( 1, 'Tipo do Imóvel',$proposta->tipo_imovel);
		$retorno .= linha( 3, 'Motivo da Locação',$proposta->motivo_locacao);
		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		$retorno .= linha( 3, 'Endereço',$proposta->endereco);
		$retorno .= linha( 1, 'Número',$proposta->numero);
		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		$retorno .= linha( 1, 'Complemento',$proposta->complemento);
		$retorno .= linha( 1, 'Bairro',$proposta->bairro);
		$retorno .= linha( 1, 'Cidade',$proposta->cidade);
		$retorno .= linha( 1, 'Estado',$proposta->estado);
		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		$retorno .= linha( 2, 'Aluguel',$this->context->format_real($proposta->aluguel));
		$retorno .= linha( 1, 'Iptu',$this->context->format_real($proposta->iptu));
		$retorno .= linha( 1, 'Comdomínio',$this->context->format_real($proposta->condominio));
		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		$retorno .= linha( 1, 'Água',$this->context->format_real($proposta->agua));
		$retorno .= linha( 1, 'Luz',$this->context->format_real($proposta->luz));
		$retorno .= linha( 1, 'Gás Encanado',$this->context->format_real($proposta->gas_encanado));
		$retorno .= linha( 1, 'Total',$this->context->format_real($proposta->total));
		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
		$retorno .= '<tr><td colspan="4" style="background-color: lightgray; padding: 10px;">
						<center>ATIVIDADE COMERCIAL NO IMÓVEL ALUGADO</center></td></tr>';
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		$retorno .= linha( 3, 'Empresa',$proposta->atvc_empresa);
		$retorno .= linha( 1, 'CNPJ',$this->context->format_cnpj($proposta->atvc_cnpj));
		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		$retorno .= linha( 3, 'Nome Comercial Fantasia',$proposta->atvc_nome_fantasia);
		$retorno .= linha( 1, 'Atividade',$proposta->atvc_atividade);
		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------
		$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
		$retorno .= linha( 1, 'Data de Constituição',date('d/m/Y',strtotime($proposta->atvc_data_constituicao)));
		$retorno .= linha( 2, 'Contato', $proposta->atvc_contato);
		$retorno .= linha( 1, 'Telefone', $this->context->format_telefone($proposta->atvc_telefone));
		$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------

		$retorno .= '</table>';
	endif;

	###############################################################################################################
	# ----------------------------------------------------------------------------------------------------------- #
	##################################				 MORADORES					###################################
	# ----------------------------------------------------------------------------------------------------------- #
	###############################################################################################################
	

	$ocupante = app\models\SloOcupante::find()->where(['slo_pretendente_id' => $id])->all();
    if (count($ocupante) > 0) {
		$retorno .= "<br>";

		$retorno .= "<table border='0' width='1000'>";
		$retorno .= '<tr>';
		$retorno .= '<th colspan="4" style="background-color: lightgray">';
		$retorno .= '<h3>RESIDENTES NO IMÓVEL LOCADO MAIORES DE 18 ANOS</h3>';
		$retorno .= '</th>';
		$retorno .= '</tr>';
        foreach ($ocupante as $row) {

        	$retorno .= '<tr>';
        	$retorno .= '<td colspan="4">';
        	$retorno .= '<h4 class="lb-info"><strong>Nome:</strong><br> '.$row->nome.'</h4><br>';
        	$retorno .= '</td>';
        	$retorno .= '</tr>';
 
        	$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------

			$retorno .= linha( 1, 'Sexo',($row->sexo=='M'?'Masculino':'Feminino'));
			$retorno .= linha( 1, 'CPF',$this->context->format_cpf($row->cpf));
			$retorno .= linha( 1, 'Tipo de Documento',$row->tipo_documento);
			$retorno .= linha( 1, 'Número do Documento',$row->numero_documento);	

			$retorno .= "</tr>"; #FIM da Linha ----------------------------------------------------------

			$retorno .= '<tr>'; #INÍCIO da Linha --------------------------------------------------------
			
			$retorno .= linha( 1, 'Data de Expedição',date('d/m/Y',strtotime($row->data_expedicao)));
			$retorno .= linha( 1, 'Órgão Expedidor',$row->orgao_expedidor);
			$retorno .= linha( 1, 'Data de Nascimento',date('d/m/Y',strtotime($row->data_nascimento)));
			
			$retorno .= "</tr>"; #FIM da Linha --------------------------------------------------------


		}
		$retorno .= "</table>";	
    }

	echo $retorno;