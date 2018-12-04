<?php

$query_przejscie = $db->select("SELECT oper_id, oper, nr_tel, produkt
								FROM callregistry_promo 
								WHERE id=$temp_id 
								");

$query_przejscie_match = $db->select("SELECT nazwa_przejscia, poziom_przejscia FROM sales_przejscia_temp WHERE nazwa_przejscia = '".$query_przejscie[0][produkt]."'");

if( count($query_przejscie_match) > 0 ){
  
  	if( $query_przejscie_match[0][poziom_przejscia] == 3 ){
	    $id_gr = '568';
	    $dispo_gr = 'WLR na WLR 2 lub 5 godzin';
	    $artykul_gr = 'CC PRZEJSCIE Other';
	}

  	if( $query_przejscie_match[0][poziom_przejscia] == 4 ){
	    $id_gr = '566';
	    $dispo_gr = 'WLR na WLR 20 godzin';
	    $artykul_gr = 'CC PRZEJSCIE DWiW';	    
	}

  	if( $query_przejscie_match[0][poziom_przejscia] == 5 ){
	    $id_gr = '567';
	    $dispo_gr = 'WLR na WLR 40 godzin';
	    $artykul_gr = 'CC PRZEJSCIE NS';	    
	}

  	if( $query_przejscie_match[0][poziom_przejscia] == 6 ){
	    $id_gr = '609';
	    $dispo_gr = 'WLR na WLR 20 godzin Promo';
	    $artykul_gr = 'CC PRZEJSCIE DWiW Promo';	   
	}
  
		$ins_GR = "INSERT INTO sales_all(id_gr, produkt, data_sale, agent_id, agent_IB, nr_tel, article_wbt)
					VALUES(".$id_gr.", '".$dispo_gr."', '".date("Y-m-d")."', ".$query_przejscie[0][oper_id].", ".$query_przejscie[0][oper].", '0".trim($query_przejscie[0][nr_tel])."', '".$artykul_gr."')";
		
		$db->query($ins_GR);

}

?>