+-------------------------+------------------------------------------------------------+------+-----+---------+----------------+
| Field                   | Type                                                       | Null | Key | Default | Extra          |
+-------------------------+------------------------------------------------------------+------+-----+---------+----------------+
| id                      | int(11)                                                    | NO   | PRI | <null>  | auto_increment |
| tipo                    | enum('express','personalizada','Credpago','Seguro Fiança') | NO   |     | <null>  |                |
| prazo_responder         | varchar(45)                                                | YES  |     | <null>  |                |
| proprietario            | varchar(45)                                                | YES  |     | <null>  |                |
| proprietario_info       | text                                                       | YES  |     | <null>  |                |
| codigo_imovel           | varchar(5)                                                 | YES  |     | <null>  |                |
| imovel_info             | text                                                       | YES  |     | <null>  |                |
| imovel_valores          | varchar(245)                                               | YES  |     | <null>  |                |
| opcoes                  | enum('0','1','2','3')                                      | YES  |     | <null>  |                |
| usuario_id              | int(11)                                                    | YES  | MUL | <null>  |                |
| tipo_imovel             | varchar(255)                                               | YES  |     | <null>  |                |
| motivo_locacao          | text                                                       | YES  |     | <null>  |                |
| endereco                | varchar(255)                                               | YES  |     | <null>  |                |
| complemento             | varchar(25)                                                | YES  |     | <null>  |                |
| bairro                  | varchar(255)                                               | YES  |     | <null>  |                |
| cidade                  | varchar(255)                                               | YES  |     | <null>  |                |
| estado                  | varchar(255)                                               | YES  |     | <null>  |                |
| cep                     | varchar(10)                                                | YES  |     | <null>  |                |
| dormitorios             | int(2)                                                     | YES  |     | <null>  |                |
| aluguel                 | int(11)                                                    | YES  |     | <null>  |                |
| iptu                    | int(11)                                                    | YES  |     | <null>  |                |
| condominio              | int(11)                                                    | YES  |     | <null>  |                |
| agua                    | int(11)                                                    | YES  |     | <null>  |                |
| luz                     | int(11)                                                    | YES  |     | <null>  |                |
| gas_encanado            | int(11)                                                    | YES  |     | <null>  |                |
| total                   | int(11)                                                    | YES  |     | <null>  |                |
| numero                  | int(11)                                                    | YES  |     | <null>  |                |
| atvc_empresa            | varchar(100)                                               | YES  |     | <null>  |                |
| atvc_cnpj               | varchar(20)                                                | YES  |     | <null>  |                |
| atvc_nome_fantasia      | varchar(150)                                               | YES  |     | <null>  |                |
| atvc_atividade          | varchar(200)                                               | YES  |     | <null>  |                |
| atvc_data_constituicao  | varchar(45)                                                | YES  |     | <null>  |                |
| atvc_contato            | varchar(255)                                               | YES  |     | <null>  |                |
| atvc_telefone           | varchar(10)                                                | YES  |     | <null>  |                |
| data_inicio             | datetime                                                   | NO   |     | <null>  |                |
| id_slogica              | varchar(45)                                                | YES  |     | <null>  |                |
| etapa_andamento         | int(11)                                                    | YES  |     | 2       |                |
| codigo                  | varchar(100)                                               | YES  |     | <null>  |                |
| nome                    | varchar(245)                                               | YES  |     | <null>  |                |
| data_nascimento         | date                                                       | YES  |     | <null>  |                |
| cpf                     | varchar(15)                                                | YES  |     | <null>  |                |
| telefone                | varchar(15)                                                | YES  |     | <null>  |                |
| email                   | varchar(245)                                               | YES  |     | <null>  |                |
| documento_tipo          | varchar(145)                                               | YES  |     | <null>  |                |
| documento_numero        | varchar(20)                                                | YES  |     | <null>  |                |
| documento_orgao_emissor | varchar(10)                                                | YES  |     | <null>  |                |
| documento_data_emissao  | date                                                       | YES  |     | <null>  |                |
| nacionalidade           | varchar(50)                                                | YES  |     | <null>  |                |
| telefone_residencial    | varchar(15)                                                | YES  |     | <null>  |                |
| telefone_celular        | varchar(15)                                                | YES  |     | <null>  |                |
| profissao               | varchar(200)                                               | YES  |     | <null>  |                |
| vinculo_empregaticio    | varchar(145)                                               | YES  |     | <null>  |                |
| data_admissao           | date                                                       | YES  |     | <null>  |                |
| renda                   | varchar(100)                                               | YES  |     | <null>  |                |
| naoLocalizado           | varchar(245)                                               | YES  |     | <null>  |                |
| estado_civil            | varchar(20)                                                | YES  |     | <null>  |                |
| condicao_do_imovel      | varchar(245)                                               | YES  |     | <null>  |                |
| conj_nome               | varchar(245)                                               | YES  |     | <null>  |                |
| conj_email              | varchar(245)                                               | YES  |     | <null>  |                |
| conj_cpf                | varchar(15)                                                | YES  |     | <null>  |                |
| conj_documento_tipo     | varchar(145)                                               | YES  |     | <null>  |                |
| conj_documento_numero   | varchar(20)                                                | YES  |     | <null>  |                |
| conj_nacionalidade      | varchar(50)                                                | YES  |     | <null>  |                |
| conj_data_nascimento    | date                                                       | YES  |     | <null>  |                |
| conj_telefone_celular   | varchar(15)                                                | YES  |     | <null>  |                |
| conj_profissao          | varchar(245)                                               | YES  |     | <null>  |                |
| conj_renda              | varchar(100)                                               | YES  |     | <null>  |                |
| conj_num_dependentes    | int(11)                                                    | YES  |     | <null>  |                |
| conj_frente             | text                                                       | YES  |     | <null>  |                |
| conj_verso              | text                                                       | YES  |     | <null>  |                |
| frente                  | text                                                       | YES  |     | <null>  |                |
| verso                   | text                                                       | YES  |     | <null>  |                |
| proponentes             | text                                                       | YES  |     | <null>  |                |
+-------------------------+------------------------------------------------------------+------+-----+---------+----------------+