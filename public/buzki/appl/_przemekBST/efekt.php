<?php

	function date2int($date) {
		$dateTab=explode("-",$date);
		$dataRet=mktime (00,00,00,$dateTab[1],$dateTab[2],$dateTab[0]);
		$dataRet2=mktime (23,59,59,$dateTab[1],$dateTab[2],$dateTab[0]);
		return $dataRet . "-" . $dataRet2;
	}

	// laduj pliki
	include("../../../lib/tww.inc");

	// sprawdz czy zalogowany
	if (!isset($_COOKIE['xmbid'])) {
	  	die('Zeby korzystac z aplikacji, musisz byc zalogowany w intranecie.');
	}
	
	// sprawdz czy bst
	if (!($_COOKIE['xmblevel'] >= 20)) {
		die('Nie masz uprawnien aby korzystac z tej aplikacji!');
	}
	
  	$error = false;
		
	# sprawdzenie wartosci z formularza
	$report_type = $_POST['report_type'];
	$report_task = $_POST['report_task'];
	$report_agent = $_POST['report_agent'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	
?>
<html>

<head>
	<title>Raporty z efektywnosci</title>
	<style>
	
	body {font-size: 1em; font-family: verdana;}
	.label {font-size: .8em; color: #444444;}
	#error_message {font-size: .6em; font-weight: bold; color: #990022;}
	#report_header {font-size: .8em; font-weight: bold; color: #220099;}
	#report_body table {font-size: .6em; line-height: 1.2em; border-style: solid; border-width: 1px;}
	#report_body table tr {border-style: solid; border-width: 1px;}
	#report_body table tr td {border-style: solid; border-width: 1px;}
	#comment {font-size: .6em; color: #777777;}
	
	
	</style>
	<link rel="stylesheet" type="text/css" href="inc/calendar.css">
	<script language='JavaScript' src='simplecalendar.js' type='text/javascript'></script>
	<script language="javascript">
	
		function blockList() {
			var r_type = document.main_form.report_type.value;
			var r_task = document.main_form.report_task;
			var r_agent = document.main_form.report_agent;
			
			if (r_type == '1') {
				r_task.disabled = true;
				r_agent.disabled = true;
			}
			if (r_type == '2') {
				r_task.disabled = false;
				r_agent.disabled = true;
			}
			if (r_type == '3') {
				r_task.disabled = true;
				r_agent.disabled = false;
			}
		}
	
	</script>
</head>

<body>

<form method="post" action="efekt.php" name="main_form">

<span class="label">Data Od:</span><input type="text" name="start_date" value="<?php echo $start_date; ?>" readonly="readonly" />
<a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'main_form.start_date',false,'yyyy-mm-dd'); return false;"><img src="gfx/calendar.gif" name="imgCalendar" border="0" alt=""></a>
<span class="label">Data Do:</span><input type="text" name="end_date" value="<?php echo $end_date; ?>" readonly="readonly" />
<a href="javascript: void(0);" onmouseover="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onmouseout="if (timeoutDelay) calendarTimeout();window.status='';" onclick="g_Calendar.show(event,'main_form.end_date',false,'yyyy-mm-dd'); return false;"><img src="gfx/calendar.gif" name="imgCalendar" border="0" alt=""></a>

<div id="comment">
<p>
<br />
<b><font color = 'red'>Witaj Kubo, jak sie dzis czujesz??????</font></b><br />
Po wybraniu daty prosze wybrac rodzaj raportu.<br />
Dla niektorych raportow nalezy rowniez wybrac agenta lub task.<br />
Po dokonaniu wyboru nalezy nacisnac przycisk Show.<br />
Ten tekst jest tylko po to, zeby rodzaj raportow nie zaslanial pojawiajacego sie kalendarzyka.<br />
</p>
</div>

<span class="label">Rodzaj raportu:</span>
<br />
<select name="report_type" onchange="blockList();">
	<option value="1"<?php echo ($report_type == '1') ? ' selected="selected"' : ''; ?>>Czas spedzony na taskach</option>
	<option value="2"<?php echo ($report_type == '2') ? ' selected="selected"' : ''; ?>>Czas spedzony na wybranym tasku / agent</option>
	<option value="3"<?php echo ($report_type == '3') ? ' selected="selected"' : ''; ?>>Czas spedzony na taskach / wybrany agent</option>
</select>
<br /><br />

<span class="label">Task (optymalnie):</span>
<br />
<select name="report_task"<?php echo ($report_type != '2') ? ' disabled="disabled"' : '';?>>
	<option value="">Wybierz Task</option>
	<?php
		$taski = $db->select("select Id_operacji, Operacja from Efektywnosc21Operacje where Efektywnosc21Operacje.finansowy = 'Optimal Telecom'");
		$taski_qnt = sizeof($taski);
		for ($i = 0; $i < $taski_qnt; $i++) {
			echo '<option value="'.$taski[$i]['Id_operacji'].'"';
			echo ($report_task == $taski[$i]['Id_operacji']) ? ' selected="selected"': '';
			echo '>'.$taski[$i]['Operacja'].'</option>';
		}
	?>
</select>
<br /><br />

<span class="label">Agent (optymalnie):</span>
<br />
<select name="report_agent"<?php echo ($report_type != '3') ? ' disabled="disabled"' : '';?>>
	<option value="">Wybierz Agenta</option>
	<?php	
		$agenci = $db->select("
			SELECT tab_users_all.id, (f_name + ' ' + s_name) AS agent_name
			FROM Efektywnosc21Log
				INNER JOIN Efektywnosc21Operacje ON Efektywnosc21Log.czynnosc = Efektywnosc21Operacje.Id_operacji
				INNER JOIN tab_users_all ON Efektywnosc21Log.agent = tab_users_all.id
			WHERE Efektywnosc21Operacje.finansowy = 'Optimal Telecom'
			GROUP BY tab_users_all.id, (f_name + ' ' + s_name)
			ORDER BY (f_name + ' ' + s_name)");	
		$agenci_qnt = sizeof($agenci);
		for ($i = 0; $i < $agenci_qnt; $i++) {
			echo '<option value="'.$agenci[$i]['id'].'"';
			echo ($report_agent == $agenci[$i]['id']) ? ' selected="selected"': '';
			echo '>'.$agenci[$i]['agent_name'].'</option>';
		}
	?>
</select>
<br /><br />

<input type="submit" name="report_go" value="Show" />
&nbsp;
<input type="button" name="reset" value="Reset" onclick="document.location = 'efekt.php';">
</form>

<?php
	$report_go = $_POST['report_go'];
	if ($report_go == 'Show') {
	  
		if (($start_date == '') || ($end_date == '')) {
			echo '<div id="error_message">Wybierz date poczatku i konca.</div>';
			$error = true;
		} else {
			
			$report_okres = $start_date.' / '.$end_date;
		  
			$datyZl=date2int($start_date);
			$datyZakrTab=explode("-",$datyZl);
			$start_date = $datyZakrTab[0];
			
			$datyZl2=date2int($end_date);
			$datyZakrTab2=explode("-",$datyZl2);
			$end_date = $datyZakrTab2[1];
		
			switch ($report_type) {
				case '1':
					$sql = "
	SELECT Efektywnosc21Operacje.Operacja as item, Sum(Efektywnosc21Log.ilosc) AS quantity, Sum(Efektywnosc21Log.czas) AS total_time
	FROM Efektywnosc21Log 
		INNER JOIN Efektywnosc21Operacje ON Efektywnosc21Log.czynnosc = Efektywnosc21Operacje.Id_operacji
	WHERE Efektywnosc21Log.start_czas >= $start_date And Efektywnosc21Log.start_czas < $end_date AND Efektywnosc21Operacje.finansowy = 'Optimal Telecom'
	GROUP BY Efektywnosc21Operacje.Operacja
	ORDER BY Efektywnosc21Operacje.Operacja";
					$report_header = 'Raport z czasow na taskach ('.$report_okres.')';
					break;
				case '2':
					if ($report_task == '') {
						echo '<div id="error_message">Wybierz task.</div>';
						$error = true;
					} else {
						$sql = "
	SELECT (f_name + ' ' + s_name) AS item, Sum(Efektywnosc21Log.ilosc) AS quantity, Sum(Efektywnosc21Log.czas) AS total_time
	FROM Efektywnosc21Log
		INNER JOIN tab_users_all ON Efektywnosc21Log.agent = tab_users_all.id
	WHERE Efektywnosc21Log.start_czas >= $start_date And Efektywnosc21Log.start_czas < $end_date And Efektywnosc21Log.czynnosc = $report_task
	GROUP BY tab_users_all.id, (f_name + ' ' + s_name)";
						$report_header = 'Raport z czasow na wybranym tasku ('.$report_okres.')';
					}
					break;
				case '3':
					if ($report_agent == '') {
						echo '<div id="error_message">Wybierz agenta.</div>';
						$error = true;
					} else {
						$sql = "
SELECT Efektywnosc21Operacje.Operacja as item, Sum(Efektywnosc21Log.ilosc) AS quantity, Sum(Efektywnosc21Log.czas) AS total_time
FROM Efektywnosc21Log
	INNER JOIN tab_users_all ON Efektywnosc21Log.agent = tab_users_all.id
	INNER JOIN Efektywnosc21Operacje ON Efektywnosc21Log.czynnosc = Efektywnosc21Operacje.Id_operacji
WHERE tab_users_all.id = $report_agent And Efektywnosc21Log.start_czas >= $start_date And Efektywnosc21Log.start_czas < $end_date AND Efektywnosc21Operacje.finansowy = 'Optimal Telecom'
GROUP BY Efektywnosc21Operacje.Operacja;";
						$report_header = 'Raport z czasow na taskach dla agenta ('.$report_okres.')';
					}
					break;
				default:
					echo '<div id="error_message">Wybierz rodzaj raportu.</div>';
					$error = true;
					break;					
			}
			if ($error == false) {
				$report_data = $db->select($sql);
				echo '
					<div id="report_header">'.$report_header.'</div><br />
					<div id="report_body">
					<table border="1">
						<tr>
							<td width="300px"><b>Opis</b></td>
							<td><b>Ilosc</b></td>
							<td><b>Czas (h)</b></td>
							<td><b>Sredni Czas (m)</b></td>
						</tr>';
				$report_qnt = sizeof($report_data);
				for ($i = 0; $i < $report_qnt; $i++) {
					echo '
						<tr>
							<td>'.$report_data[$i]['item'].'</td>
							<td>'.$report_data[$i]['quantity'].'</td>
							<td>'.@round(($report_data[$i]['total_time'] / 3600), 2).'</td>
							<td>'.@round((($report_data[$i]['total_time'] / $report_data[$i]['quantity']) / 60), 2).'</td>
						</tr>';
				}
				echo '</table></div>';
			}
		}
	}

?>

</body>
</html>