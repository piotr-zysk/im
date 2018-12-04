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

	$sql = "
		SELECT
			ci.agent,
			tua.IB_ID + ' ' + tua.f_name + ' ' + tua.s_name AS CSR,
			Round(ci.wynik_1_17/100,0) AS ocena,
			ci.wynik_slownie,
			ci.przedstawienie,
			ci.komunikacja,
			ci.profesjonalizm,
			ci.control,
			ci.idcheck,
			ci.clarify,
			ci.knowledge,
			ci.offer,
			ci.listening,
			ci.transfer,
			ci.dataentry,
			ci.adjustment,
			ci.notes,
			ci.lookup
		FROM czekerstww_ib AS ci INNER JOIN tab_users_all AS tua ON ci.agent = tua.id
		WHERE data >= '2007-11-01'
		ORDER BY agent ASC";
	$dane = $db->select($sql);
	
	
	# przygotowanie tabeli agentow
	$size_of_dane = sizeof($dane);
	$agents = array();
	$j = 0;
	for ($i = 0; $i < $size_of_dane; $i++) {
	  	# dane agenta
		$agents[$j]['CSR'] = $dane[$i]['CSR'];
		
		# puste kratki
		$agents[$j]['TL'] = '';
		$agents[$j]['employed'] = '';
		$agents[$j]['will work next month'] = '';
		$agents[$j]['accpeted work time'] = '';
		
		# ilosc ocenionych rozmowy
		$agents[$j]['evaluated calls'] += 1;
		
		# najwyzsza ocena
		if ($dane[$i]['ocena'] > $agents[$j]['max grade']) {
			$agents[$j]['max grade'] = $dane[$i]['ocena'];
		}
		
		# najnizsza ocena
		if ($dane[$i]['ocena'] < $agents[$j]['min grade']) {
			$agents[$j]['min grade'] = $dane[$i]['ocena'];
		}
		
		# najwysza - najnizsza ocena
		$agents[$j]['max grade - min grade'] = $agents[$j]['max grade'] - $agents[$j]['min grade'];
		
		# srednia ocena
		if ($dane[$i]['agent'] == $dane[$i + 1]['agent']) {
			$agents[$j]['average grade'] += $dane[$i]['ocena'];
		} else {
			$agents[$j]['average grade'] = Round(($agents[$j]['average grade'] / $agents[$j]['evaluated calls']),0);
		}
		
		# ilosci opisowe wynikow
		switch ($dane[$i]['wynik_slownie']) {
			case 'Good':
				$agents[$j]['good'] += 1;
				break;
			case 'Acceptable':
				$agents[$j]['acceptable'] += 1;
				break;
			case 'Unacceptable':
				$agents[$j]['unacceptable'] += 1;
				break;
			default:
				break;
		}
		
		# % of good
		$agents[$j]['% good'] = Round(($agents[$j]['good'] / $agents[$j]['evaluated calls']),2);
		
		# introduction:
		switch ($dane[$i]['przedstawienie']) {
			case '1':
				$agents[$j]['Introduction']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Introduction']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Introduction'] = Round(100 * ($agents[$j]['Introduction']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Introduction']['n/a'])),0).'%';
		}
		
		# communication / report:
		switch ($dane[$i]['komunikacja']) {
			case '1':
				$agents[$j]['Communication / report']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Communication / report']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Communication / report'] = Round(100 * ($agents[$j]['Communication / report']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Communication / report']['n/a'])),0).'%';
		}
		
		# professionalizm
		switch ($dane[$i]['profesjonalizm']) {
			case '1':
				$agents[$j]['Professionalism']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Professionalism']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Professionalism'] = Round(100 * ($agents[$j]['Professionalism']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Professionalism']['n/a'])),0).'%';
		}
		
		# call control
		switch ($dane[$i]['control']) {
			case '1':
				$agents[$j]['Call control']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Call control']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Call control'] = Round(100 * ($agents[$j]['Call control']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Call control']['n/a'])),0).'%';
		}
		
		# id check
		switch ($dane[$i]['idcheck']) {
			case '1':
				$agents[$j]['ID check']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['ID check']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['ID check'] = Round(100 * ($agents[$j]['ID check']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['ID check']['n/a'])),0).'%';
		}
		
		# clarify
		switch ($dane[$i]['clarify']) {
			case '1':
				$agents[$j]['Clarify']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Clarify']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Clarify'] = Round(100 * ($agents[$j]['Clarify']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Clarify']['n/a'])),0).'%';
		}
		
		# knowledge / script
		switch ($dane[$i]['knowledge']) {
			case '1':
				$agents[$j]['Product/Script knowledge and accuracy']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Product/Script knowledge and accuracy']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Product/Script knowledge and accuracy'] = Round(100 * ($agents[$j]['Product/Script knowledge and accuracy']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Product/Script knowledge and accuracy']['n/a'])),0).'%';
		}
		
		# sales
		switch ($dane[$i]['offer']) {
			case '1':
				$agents[$j]['Up/cross selling']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Up/cross selling']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Up/cross selling'] = Round(100 * ($agents[$j]['Up/cross selling']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Up/cross selling']['n/a'])),0).'%';
		}
		
		# active listening
		switch ($dane[$i]['listening']) {
			case '1':
				$agents[$j]['Active listening']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Active listening']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Active listening'] = Round(100 * ($agents[$j]['Active listening']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Active listening']['n/a'])),0).'%';
		}
		
		# exit
		switch ($dane[$i]['transfer']) {
			case '1':
				$agents[$j]['Exit']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Exit']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Exit'] = Round(100 * ($agents[$j]['Exit']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Exit']['n/a'])),0).'%';
		}
		
		# data entry
		switch ($dane[$i]['dataentry']) {
			case '1':
				$agents[$j]['Data entry']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Data entry']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Data entry'] = Round(100 * ($agents[$j]['Data entry']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Data entry']['n/a'])),0).'%';
		}
		
		# adjustment / reason code
		switch ($dane[$i]['adjustment']) {
			case '1':
				$agents[$j]['Adjustment / Reason code']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Adjustment / Reason code']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Adjustment / Reason code'] = Round(100 * ($agents[$j]['Adjustment / Reason code']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Adjustment / Reason code']['n/a'])),0).'%';
		}
		
		# manual notes
		switch ($dane[$i]['notes']) {
			case '1':
				$agents[$j]['Manual notes']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Manual notes']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Manual notes'] = Round(100 * ($agents[$j]['Manual notes']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Manual notes']['n/a'])),0).'%';
		}
		
		# look up
		switch ($dane[$i]['lookup']) {
			case '1':
				$agents[$j]['Look up']['points'] += 1;
				break;
			case 'N/A':
				$agents[$j]['Look up']['n/a'] += 1;
				break;
			default:
				break;
		}
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$agents[$j]['Look up'] = Round(100 * ($agents[$j]['Look up']['points'] / ($agents[$j]['evaluated calls'] - $agents[$j]['Look up']['n/a'])),0).'%';
		}
		
		# przy zmianie agenta dodaje do j 1
		if ($dane[$i]['agent'] != $dane[$i + 1]['agent']) {
			$j += 1;
		}
	}
	
	# przygotowanie tabeli raportu
	$size_of_agents = sizeof($agents);
	for ($i = 0; $i < $size_of_agents; $i++) {
		$report_grzegorz[$i]['CSR'] = $agents[$i]['CSR'];
		$report_grzegorz[$i]['TL'] = $agents[$i]['TL'];
		$report_grzegorz[$i]['employed'] = $agents[$i]['employed'];
		$report_grzegorz[$i]['will work next month'] = $agents[$i]['will work next month'];
		$report_grzegorz[$i]['accpeted work time'] = $agents[$i]['accpeted work time'];
		$report_grzegorz[$i]['evaluated calls'] = $agents[$i]['evaluated calls'];
		$report_grzegorz[$i]['max grade'] = $agents[$i]['max grade'];
		$report_grzegorz[$i]['min grade'] = $agents[$i]['min grade'];
		$report_grzegorz[$i]['max grade - min grade'] = $agents[$i]['max grade - min grade'];
		$report_grzegorz[$i]['average grade'] = $agents[$i]['average grade'];
		$report_grzegorz[$i]['good'] = $agents[$i]['good'];
		$report_grzegorz[$i]['acceptable'] = $agents[$i]['acceptable'];
		$report_grzegorz[$i]['unacceptable'] = $agents[$i]['unacceptable'];
		$report_grzegorz[$i]['% good'] = $agents[$i]['% good'];
		$report_grzegorz[$i]['Introduction'] = $agents[$i]['Introduction'];
		$report_grzegorz[$i]['Communication / report'] = $agents[$i]['Communication / report'];
		$report_grzegorz[$i]['Professionalism'] = $agents[$i]['Professionalism'];
		$report_grzegorz[$i]['Call control'] = $agents[$i]['Call control'];
		$report_grzegorz[$i]['ID check'] = $agents[$i]['ID check'];
		$report_grzegorz[$i]['Clarify'] = $agents[$i]['Clarify'];
		$report_grzegorz[$i]['Product/Script knowledge and accuracy'] = $agents[$i]['Product/Script knowledge and accuracy'];
		$report_grzegorz[$i]['Up/cross selling'] = $agents[$i]['Up/cross selling'];
		$report_grzegorz[$i]['Active listening'] = $agents[$i]['Active listening'];
		$report_grzegorz[$i]['Exit'] = $agents[$i]['Exit'];
		$report_grzegorz[$i]['Data entry'] = $agents[$i]['Data entry'];
		$report_grzegorz[$i]['Adjustment / Reason code'] = $agents[$i]['Adjustment / Reason code'];
		$report_grzegorz[$i]['Manual notes'] = $agents[$i]['Manual notes'];
		$report_grzegorz[$i]['Look up'] = $agents[$i]['Look up'];
	}
	
	print_r($report_grzegorz);
	
?>