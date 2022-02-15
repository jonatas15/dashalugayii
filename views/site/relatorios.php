<style>
	table {
	    border-collapse: collapse;
	    width: 100%;
	}

	th, td {
	    text-align: left;
	    padding: 8px;
	}

	tr:nth-child(even) {background-color: #f2f2f2;}
</style>
<?php 
// use ruskid\csvimporter\CSVImporter;
// use ruskid\csvimporter\CSVReader;
// $importer = new CSVImporter;

// //Will read CSV file
// $importer->setData(new CSVReader([
//     'filename' => 'http://localhost/arquivos/cliques_endereco.csv',
//     'fgetcsvOptions' => [
//         'delimiter' => ';'
//     ]
// ]));

$row = 1;
$this->title = 'Cliques nos endereços de imóveis';
?>
<h3>Cliques nos endereços dos imóveis no site:</h3>
<hr>
<?php
if (($handle = fopen("https://www.cafeinteligencia.com.br/arquivos/cliques_endereco.csv", "r")) !== FALSE) {
	echo "<table>";
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        // echo "<p> $num campos na linha $row: <br /></p>\n";
        echo "<tr>";
        for ($c=0; $c < $num; $c++) {
    		if ($row == 1) {
				echo "<th>".$data[$c] . "</th>";
        	}else{
				if ($c == 0) {
					echo "<td><img src='".$data[$c] . "' width='75'></td>";	
				}elseif($c == 1){
					$_0 = '';
					if(strlen($data[$c]) == 3){
						$_0 = '0';
					}
					echo "<td><a href='https://www.cafeinteligencia.com.br/imovel/".$_0. $data[$c] . "' target='_blanck' >PIN - ".$_0. $data[$c] . "</a></td>";	
				}else{
					echo "<td>".$data[$c] . "</td>";	
				}
			}
			
        }
		echo "<tr>";
		/*
		$vernomapa = new app\models\Vernomapa;
		
		$vernomapa->thumb = $data[0]; 
		$vernomapa->codigo = $data[1]; 
		$vernomapa->logradouro = $data[2];
		$vernomapa->bairro = $data[3]; 
		$vernomapa->cidade = $data[4];
		$vernomapa->contrato = $data[5];
		$vernomapa->valor_venda = $data[6];
		$vernomapa->valor_locacao = $data[7];
		$vernomapa->data = $data[8];
		$vernomapa->ip = $data[9];

		$vernomapa->save();
		*/
        $row++;
    }
    echo "</table>";
    fclose($handle);
}

?>