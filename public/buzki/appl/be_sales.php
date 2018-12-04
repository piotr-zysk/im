<?php

$query_przejscie = $db->select("SELECT oper_id, oper, nr_tel, produkt
								FROM callregistry_promo 
								WHERE id=$temp_id 
								");

$query_przejscie_match = $db->select("SELECT nazwa_przejscia, poziom_przejscia FROM sales_przejscia_temp WHERE nazwa_przejscia = '".$query_przejscie[0][produkt]."'");

if( count($query_przejscie_match) > 0 ){
  
  	if( $query_przejscie_match[0][poziom_przejscia] == 0 ){
	    $id = '250';
	    $prod_gr = 'CC WLR Przejscie';
	}

  	if( $query_przejscie_match[0][poziom_przejscia] == 1 ){
	    $id = '251';
	    $prod_gr = 'CC WLR Przejscie DWiW';
	}

  	if( $query_przejscie_match[0][poziom_przejscia] == 2 ){
	    $id = '252';
	    $prod_gr = 'CC WLR Przejscie NS';
	} 

  	if( $query_przejscie_match[0][poziom_przejscia] == 3 ){
	    $id = '308';
	    $prod_gr = 'WLR na WLR 2 lub 5 godzin';
	}

  	if( $query_przejscie_match[0][poziom_przejscia] == 4 ){
	    $id = '307';
	    $prod_gr = 'WLR na WLR 20 godzin';
	}

  	if( $query_przejscie_match[0][poziom_przejscia] == 5 ){
	    $id = '306';
	    $prod_gr = 'WLR na WLR 40 godzin';
	}
  
	$query_insert_przejscie = $db->query("
							INSERT INTO sales_all(id_gr, produkt, data_sale, agent_id, agent_IB, nr_tel)
								VALUES(".$id.", '".$prod_gr."', '".date("Y-m-d")."', ".$query_przejscie[0][oper_id].", ".$query_przejscie[0][oper].",
									'".$query_przejscie[0][nr_tel]."')
								");

}

?>