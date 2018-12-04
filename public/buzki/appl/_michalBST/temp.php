<?php
	$report_go = $_POST['report_go'];
	if ($report_go == 'Show') {
	  
		if (($start_date == '') || ($end_date == '')) {
			echo '<div id="error_message">Wybierz date poczatku i konca.</div>';
			$error = true;
		} else {
			$datyZl=date2int($start_date);
			$datyZakrTab=explode("-",$datyZl);
			$start_date = $datyZakrTab[0];
			
			$datyZl2=date2int($end_date);
			$datyZakrTab2=explode("-",$datyZl2);
			$end_date = $datyZakrTab2[1];
		
			switch ($report_type) {
				case '1':
					$sql = '';
					break;
				case '2':
					if ($report_taks == '') {
						echo '<div id="error_message">Wybierz task.</div>';
						$error = true;
					} else {
						$sql = '';
					}
					break;
				case '3':
					if ($report_agent == '') {
						echo '<div id="error_message">Wybierz agenta.</div>';
						$error = true;
					} else {
						$sql = '';
					}
					break;
				default:
					echo '<div id="error_message">Wybierz rodzaj raportu.</div>';
					$error = true;
					break;					
			}
			if ($error == false) {
				$report_data = $db->select($sql);
			}
		}
	}

?>