<style>
	h1	{font-family: sans-serif; font-size: 14pt; color: "#333399"}
	td.title {font-family: verdana, sans-serif; font-weight:bold; font-size: 10pt}
	td.content {font-family: verdana, sans-serif; font-weight:normal; font-size: 8pt; background:"#e9e9e9"}
	.label {font-family: verdana; font-size: 10pt}
	.comment {font-family: arial; font-size: 10pt; color: red}
</style>
<?php
	// laduj pliki
	include("../../../lib/tww.inc");

	// sprawdz czy zalogowany
	if (!isset($_COOKIE['xmbid'])) {
	  	die('Zeby korzystac z aplikacji, musisz byc zalogowany w intranecie mistrzu.');
	}
	
	// sprawdz czy bst
	if (!($_COOKIE['xmblevel'] >= 90)) {
		die('Tylko mistrz moze korzystac z tej aplikacji!');
	}

	// wyswietl tytul strony
	echo '<h1>Credit Control Batch</h1>';
	
	$created = date('Y-m-d');
	$month = substr($created, 2, 2).substr($created, 5, 2);

	if ($_POST['Submit'] == 'Generuj') {
		
		$kampid = $_POST['kampid'];
		if ($kampid == '') {
			die('Nie podales parametrow dla bazy chuju.');
		}


		// pobieranie z bazy danych klienta;
		$tabData = array();
		$tabData = $db->select("SELECT Customer_Number, SumOfAmount, Nr_telefonu, NODE_NAME, ADDRESS_LINE_1, CITY, POST_CODE FROM credit_control_batch GROUP BY Customer_Number, SumOfAmount, Nr_telefonu, NODE_NAME, ADDRESS_LINE_1, CITY, POST_CODE");

		// jezeli nie ma wynikow, przerwij dzialanie aplikacji
		$tabDataLeads = sizeof($tabData);
		if ($tabDataLeads < 1) {
			die('Tabela na trpoolu nie jest uzupelniona danymi');
		}
		echo 'Liczba rekordów: '.$tabDataLeads.'<br>';
	
		// pobieranie z bazy faktur
		$invoices = $db->select("SELECT COUNT(*) AS ilosc FROM credit_control_batch");
		$invoices = $invoices[0]['ilosc'];
		
				
		// jezeli nie ma faktur, przerwij dzialanie aplikacji
		if ($invoices < 1) {
			die('To dziwne, ale brakuje faktur w bazie danych');
		}
		echo 'Liczba faktur: '.$invoices.'<br>';
	
		// doklej dane faktury do bazy oraz generowanie zawartosc pliku textowego
		
		$file_content = '';
		
				
		for ($i = 0; $i < $tabDataLeads; $i++) {
	
			$tabInvoice = $db->select("SELECT Invoice_Number, Payment_Due_Date, Amount_Overdue FROM credit_control_batch WHERE Customer_Number = '".$tabData[$i]['Customer_Number']."' ORDER BY Payment_Due_Date ASC");
			for ($j = 0; $j < sizeof($tabInvoice); $j++) {
				$tabData[$i]['Invoice_Description'] .= $tabInvoice[$j]['Invoice_Number'].' ('.$tabInvoice[$j]['Payment_Due_Date'].' '.$tabInvoice[$j]['Amount_Overdue'].'), ';
				
			}

			// przygotowanie danych do pliku
		
			$tabData[$i]['Invoice_Description'] = substr($tabData[$i]['Invoice_Description'], 0, strlen($tabData[$i]['Invoice_Description']) - 2);
			$phonenumber = '01061'.substr($tabData[$i]['Nr_telefonu'], 2, 9);
			
			if (substr_count($tabData[$i]['NODE_NAME'], '.') > 0) {
				$lastname = '';
				$company = $tabData[$i]['NODE_NAME'];
				$filter = '1';
				$custtype = 'biznes';
			} else {
				$lastname = $tabData[$i]['NODE_NAME'];
				$company = '';
				$filter = '3';
				$custtype = 'private';
			}
			
			$file_content .= $lastname.'|'.$company.'|'.$tabData[$i]['ADDRESS_LINE_1'].'|'.$tabData[$i]['CITY'].'|'.$tabData[$i]['POST_CODE'].'|'.$tabData[$i]['Invoice_Description'].'|'.$phonenumber.'|'.$tabData[$i]['Customer_Number'].'|'.$tabData[$i]['SumOfAmount'].'|'.$kampid.'|'.'1'.'|'.$created.'|'.$custtype.'|'.$filter.'|'.$month.'|'."\n";
		}
		
		
		// zapisanie danych do pliku
		$file = fopen('credit_result_batch2.csv', 'w');
		fwrite($file, $file_content);
		fclose($file);

		echo '<iframe src="credit_result_batch2.csv" width="0px" height="0px"></iframe>';
	} else {
		echo '
			<form method="post">
				kampid:&nbsp;<input type="text" name="kampid"><br>
				<input type="submit" name="Submit" value="Generuj">
			</form>';
	}
?>