<script language='javascript'>
function zlicz(ile) {
	var suma = 0;
	var suma1 = 0;
	var wart = 0;
	var wart1 = 0;
	var suma2 = 0;
	var wart2 = 0;
	var test1 = 0; 
	var testa1 = 0; 
	var test2 = 0;
	var testa2 = 0;

	for(var i = 1; i <= ile; i++) {
		if(document.frmListaBaz.elements["check" + i].checked) {
			wart = parseInt(document.frmListaBaz.elements["rek" + i].value);
			suma += wart;
			wart1 = parseInt(document.frmListaBaz.elements["reks" + i].value);
			suma1 += wart1;
			wart2 = parseInt(document.frmListaBaz.elements["reksi" + i].value);
			if (test1==0) {
			 test1 = (parseInt(document.frmListaBaz.elements["rek" + i].value) - parseInt(document.frmListaBaz.elements["reks" + i].value))*wart2; 
			 testa1 = parseInt(document.frmListaBaz.elements["rek" + i].value) - parseInt(document.frmListaBaz.elements["reks" + i].value);
			} else {
			 test2 = (parseInt(document.frmListaBaz.elements["rek" + i].value) - parseInt(document.frmListaBaz.elements["reks" + i].value))*wart2;
			 testa2 = parseInt(document.frmListaBaz.elements["rek" + i].value) - parseInt(document.frmListaBaz.elements["reks" + i].value);
			}
		}		
	}
	document.frmListaBaz.rmRek.value = suma;
	document.frmListaBaz.rmRek2.value = suma;
	document.frmListaBaz.rmStart.value = suma1;
	document.frmListaBaz.rmStart2.value = suma1;
	if (test1 != 0 && test2 != 0) {
	  suma2 = Math.round(((test1+test2)/(testa1+testa2)))/100;
	}
	if (suma != 0) {
	  document.frmListaBaz.rmProc.value = Math.round(((suma1/suma)*100)*100)/100;
	  document.frmListaBaz.rmProc2.value = Math.round(((suma1/suma)*100)*100)/100;
	} else {
	  document.frmListaBaz.rmProc.value = 0;
	  document.frmListaBaz.rmProc2.value = 0;
	}
	return suma;
}
function changestate(checkid) {
  var kolor;
  if(document.frmListaBaz.elements["check"+checkid].checked) {
    document.frmListaBaz.elements["check"+checkid].checked = false;
  } else {
    document.frmListaBaz.elements["check"+checkid].checked = true;
  }
  return 1;
}

</script>
<?php

include("../../../lib/tww.inc");
set_time_limit(0);
  $data_aktual=date("Y-m-d");
  $sql="SELECT b.kamp_code, k.shortname, b.kamp_id, b.liczba_lad, b.id, b.plandata_start, b.plandata_stop, b.nazwa_pliku ";
  $sql.="FROM ba_bazy b, ba_kampanie k, ba_miesiace m ";
  $sql.="WHERE b.kamp_code=k.code AND m.idMies=b.miesiac";
  $sql.=" AND b.plandata_start >= '2008-10-01' AND b.plandata_stop <> '' AND b.plandata_stop <> '1970-01-01' AND b.data_zam>'2008-10-01' ORDER BY k.shortname, b.plandata_start, b.kamp_id ASC";
  $data = $db->select($sql);
  $dbname = "easy";
  $dbuser = "sa";
  $dbpw = "";
  $dbhost = "172.19.72.11";
  $dbget = new dbstuff;
  $dbget->connect($dbhost, $dbuser, $dbpw, $dbname);
  echo('
  <form name="frmListaBaz">
  <table style="font-family: tahoma; font-size: 10px;">
   <tr>
    <td>Zaladowanych</td>
    <td>Wystarowanych</td>
    <td>% wystartowanych</td>
   </tr>
   <tr>
    <td><input type="text" name="rmRek" value="0" size="8" readonly/></td>
    <td><input type="text" name="rmStart" value="0" size="8" readonly/></td>
    <td><input type="text" name="rmProc" value="0" size="3" readonly/></td>
   </tr>
   </table>
    <table style="border: 1px solid #000000; border-collapse: collapse; width: 100%;" rules="all" cellpadding=2>
	 <tr style="font-size: 10px; font-family: tahoma;">
	  <td></td>
	  <td><b>kampania</b></td>
	  <td><b>kamp_id</b></td>
	  <td style="width: 100px;"><b>nazwa pliku</b></td>
	  <td style="width: 100px;"><b>daty</b></td>
	  <td style="width: 125px;"><b>pozostalo</b></td>
	  <td><b>dodzwanialnosc</b></td>
	 </tr>
  ');
  $liczlicznik=0;
  $liczba_baz = count($data);
  $dodzwanialnosc_vc = array();
  for ($counter =0; $counter<count($data); $counter++) {
    $baza = $data[$counter];
    $liczlicznik++;
    $tabSpr = 'ct_'.str_replace(' ','',$baza[1]);
    
/**********************************************************/


$dispos[]="";

if($tabSpr=="ct_t2_acflup_1") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_PROV_1") {
	$dispos[0]="Sale";
	$dispos[1]="sale1";
	$dispos[2]="ref_to_talk";
}

if($tabSpr=="ct_T2_Disaster_1") {
	$dispos[0]="Sale";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_PROV_2") {
	$dispos[0]="Sale";
	$dispos[1]="sale1";
}

if($tabSpr=="ct_T2_follow_promo") {
	$dispos[0]="sale_adsl";
	$dispos[1]="sale_wlr_adsl";
	$dispos[2]="sale_wlr_adsl_promo";
	$dispos[3]="sale_wlr";
	$dispos[4]="refusal";
	$dispos[5]="fp_sale_adsl";
	$dispos[6]="fp_sale_wlr_adsl";
	$dispos[7]="fp_sale_wlr_adsl_promo";
	$dispos[8]="fp_sale_wlr";
	
	$zm[0]="wrong_number";
	$zm[1]="gone";
}

if($tabSpr=="ct_T2_follow_cc_1") {
	$dispos[0]="fc_sale_adsl";
	$dispos[1]="fc_sale_wlr_adsl";
	$dispos[2]="fc_sale_wlr_adsl_promo";
	$dispos[3]="fc_sale_wlr";
	$dispos[4]="refusal";
	
	$zm[0]="wrong_number";
	$zm[1]="gone";
}

if($tabSpr=="ct_T2_upsell_1") {
	$dispos[0]="up1_sale";
	$dispos[1]="up1_refusal";
	$dispos[2]="up1_ref_to_talk";
	$dispos[3]="up1_biznes";
	$dispos[4]="up1_not_target";
	$dispos[5]="up1_sale_wlr";
	$dispos[6]="up1_sale_wlr_adsl";
	$dispos[7]="up1_sale_wlr_adsl_promo";
	$dispos[8]="up1_sale_adsl";
	$dispos[9]="up1_sale_adsl_promo";
		
	$zm[0]="up1_gone";
	$zm[1]="up1_wrong_number";
}

if($tabSpr=="ct_T2_upsell_2") {
	$dispos[0]="up2_sale";
	$dispos[1]="up2_refusal";
	$dispos[2]="up2_ref_to_talk";
	$dispos[3]="up2_biznes";
	$dispos[4]="up2_not_target";
	$dispos[5]="up2_sale_cps";
	$dispos[6]="up2_sale_cps_adsl";
	$dispos[7]="up2_sale_cps_adsl_promo";
	$dispos[8]="up2_sale_wlr";
	$dispos[9]="up2_sale_wlr_adsl";
	$dispos[10]="up2_sale_wlr_adsl_promo";
	$dispos[11]="up2_sale_adsl";
	$dispos[12]="up2_sale_adsl_promo";

	$zm[0]="up2_gone";
	$zm[1]="up2_wrong_number";
}

if($tabSpr=="ct_T2_upsell_3") {
	$dispos[0]="up3_sale";
	$dispos[1]="up3_refusal";
	$dispos[2]="up3_ref_to_talk";
	$dispos[3]="up3_biznes";
	$dispos[4]="up3_not_target";
	$dispos[5]="up3_sale_cps";
	$dispos[6]="up3_sale_cps_adsl";
	$dispos[7]="up3_sale_cps_adsl_promo";
	$dispos[8]="up3_sale_wlr";
	$dispos[9]="up3_sale_wlr_adsl";
	$dispos[10]="up3_sale_wlr_adsl_promo";
	$dispos[11]="up3_sale_adsl";
	$dispos[12]="up3_sale_adsl_promo";
	
	$zm[0]="up3_gone";
	$zm[1]="up3_wrong_number";
}

if($tabSpr=="ct_T2_upsell_4") {
	$dispos[0]="up4_sale";
	$dispos[1]="up4_refusal";
	$dispos[2]="up4_ref_to_talk";
	$dispos[3]="up4_biznes";
	$dispos[4]="up4_not_target";
	$dispos[5]="up4_sale_wlr";
	$dispos[6]="up4_sale_wlr_adsl";
	$dispos[7]="up4_sale_wlr_adsl_promo";
	$dispos[8]="up4_sale_adsl";
	$dispos[9]="up4_sale_adsl_promo";
	
	$zm[0]="up4_gone";
	$zm[1]="up4_wrong_number";
}

if($tabSpr=="ct_T2_upsell_ADSL") {

	$dispos[0]="sale";
	$dispos[1]="refusal";
	$dispos[2]="ref_to_talk";
	$dispos[3]="biznes";
	$dispos[4]="not_target";
	$dispos[5]="ua1_refusal";
	$dispos[6]="ua1_sale_adsl";
	$dispos[7]="ua1_sale_adsl_promo";
	$dispos[8]="ua1_sale_wlr";
	$dispos[9]="ua1_sale_wlr_adsl";
	$dispos[10]="ua1_sale_wlr_adsl_promo";
	
	$zm[0]="wrong_number";
	$zm[1]="ua1_wrong_number";

}

if($tabSpr=="ct_T2_VC_ADSL") {

	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";

}

if($tabSpr=="ct_T2_ADSL_Info_1") {

	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";

}

if($tabSpr=="ct_T2_ADSL_Info_2") {

	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";

}

if($tabSpr=="ct_T2_ADSL_Info_3") {

	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";

}

if($tabSpr=="ct_T2_zlep_1") {
	$dispos[0]="zp1_tak";
	$dispos[1]="zp1_nie";
	$dispos[2]="zp1_ref_to_talk";
}

if($tabSpr=="ct_T2_WC1") {
	$dispos[0]="wc1_mistake";
	$dispos[1]="wc1_ok";
	$dispos[2]="wc1_ref_to_talk";
	$dispos[3]="wc1_unreachable";
	$dispos[4]="wc1_ref_to_talk_rez";
}

if($tabSpr=="ct_T2_VC1") {
	$dispos[0]="vc1_ok";
	$dispos[1]="vc1_rez";
}

if($tabSpr=="ct_T2_VC2") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
}

if($tabSpr=="ct_T2_WC2") {
	$dispos[0]="wc2_ok";
	$dispos[1]="wc2_rez";
}

if($tabSpr=="ct_T2_rezygnacje") {
	$dispos[0]="re1_ok";
	$dispos[1]="re1_rezygnuje";
}

if($tabSpr=="ct_T2_npp_1") {
	$dispos[0]="np1_ok";
	$dispos[1]="np1_ref_to_talk";
}

if($tabSpr=="ct_T2_flup_1") {
	$dispos[0]="fu1_nie";
	$dispos[1]="fu1_tak";
	$dispos[2]="fu1_has";
	$dispos[3]="fu1_ref_to_talk";
}

if($tabSpr=="ct_T2_flupdd_1") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
}

if($tabSpr=="ct_T2_first_in_1") {
	$dispos[0]="tf1_ok";
	
	$zm[0]="tf1_wrong_number";
}

if($tabSpr=="ct_T2_first_in_2") {
	$dispos[0]="tf2_ok";
	
	$zm[0]="tf2_wrong_number";
}

if($tabSpr=="ct_T2_dialup2") {
	$dispos[0]="du1_refusal";
	$dispos[1]="du1_sale";
}

if($tabSpr=="ct_T2_credit_1") {
	$dispos[0]="tc1_paid";
	$dispos[1]="tc1_will_pay";
	$dispos[2]="tc1_dont_pay";
}

if($tabSpr=="ct_T2_credit_2") {
	$dispos[0]="tc2_paid";
	$dispos[1]="tc2_will_pay";
	$dispos[2]="tc2_dont_pay";
}

if($tabSpr=="ct_t2_antichurn_1") {
	$dispos[0]="an1_sale";
	$dispos[1]="an1_refusal";
	$dispos[2]="an1_ref_to_talk";
	$dispos[3]="Sale";
	$dispos[4]="sale1";
	$dispos[5]="sale2";
	$dispos[6]="sale3";
	$dispos[7]="sale4";
	$dispos[8]="sale5";
	$dispos[9]="refusal";
	$dispos[10]="ref_to_talk";

	$zm[0]="an1_gone";
	$zm[1]="an1_wrong_number";
	$zm[2]="gone";
	$zm[3]="wrong_number";
}

if($tabSpr=="ct_T2_antichurn_2") {
	$dispos[0]="an2_sale";
	$dispos[1]="an2_refusal";
	$dispos[2]="an2_ref_to_talk";
	$dispos[3]="Sale";
	$dispos[4]="sale1";
	$dispos[5]="sale2";
	$dispos[6]="sale3";
	$dispos[7]="sale4";
	$dispos[8]="sale5";
	$dispos[9]="refusal";
	$dispos[10]="ref_to_talk";

	$zm[0]="an2_gone";
	$zm[1]="an2_wrong_number";
	$zm[2]="gone";
	$zm[3]="wrong_number";
}

if($tabSpr=="ct_T2_antichurn_3") {
	$dispos[0]="an3_sale";
	$dispos[1]="an3_refusal";
	$dispos[2]="an3_ref_to_talk";
	$dispos[3]="Sale";
	$dispos[4]="sale1";
	$dispos[5]="sale2";
	$dispos[6]="sale3";
	$dispos[7]="sale4";
	$dispos[8]="sale5";
	$dispos[9]="refusal";
	$dispos[10]="ref_to_talk";

	$zm[0]="an3_gone";
	$zm[1]="an3_wrong_number";
	$zm[2]="gone";
	$zm[3]="wrong_number";
}

if($tabSpr=="ct_T2_antichurn_4") {
	$dispos[0]="an4_sale";
	$dispos[1]="an4_refusal";
	$dispos[2]="an4_ref_to_talk";
	$dispos[3]="Sale";
	$dispos[4]="sale1";
	$dispos[5]="sale2";
	$dispos[6]="sale3";
	$dispos[7]="sale4";
	$dispos[8]="sale5";
	$dispos[9]="refusal";
	$dispos[10]="ref_to_talk";

	$zm[0]="an4_gone";
	$zm[1]="an4_wrong_number";
	$zm[2]="gone";
	$zm[3]="wrong_number";
}

if($tabSpr=="ct_T2_antichurn_5") {
	$dispos[0]="an5_sale";
	$dispos[1]="an5_refusal";
	$dispos[2]="an5_ref_to_talk";
	$dispos[3]="Sale";
	$dispos[4]="sale1";
	$dispos[5]="sale2";
	$dispos[6]="sale3";
	$dispos[7]="sale4";
	$dispos[8]="sale5";
	$dispos[9]="refusal";
	$dispos[10]="ref_to_talk";

	$zm[0]="an5_gone";
	$zm[1]="an5_wrong_number";
	$zm[2]="gone";
	$zm[3]="wrong_number";
}

if($tabSpr=="ct_T2_info_1") {
	$dispos[0]="ti1_ok";
}

if($tabSpr=="ct_T2_info_2") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_T2_TP_1") {
	$dispos[0]="Sale";
}

if($tabSpr=="ct_T2_SF_1") {

	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_T2_GK_1") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_Play2") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}


if($tabSpr=="ct_Max") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_Gazeta") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_T2_follow_ADSL") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_P4_prepaid") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_T2_upsell_stu") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_T2_ankieta_pow") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}

if($tabSpr=="ct_P4_3G") {
	$dispos[0]="Sale";
	$dispos[1]="refusal";
	
	$zm[0]="wrong_number";
}
/**********************************************************/    
    
    $sqlS = "SELECT COUNT(*) AS started FROM ct_$baza[1] INNER JOIN contact ON ct_$baza[1].easycode = contact.code WHERE ct_$baza[1].ct_kamp_id = '$baza[2]' AND (contact.status = 0 OR contact.status = 1 OR contact.status = 15 OR contact.status = 16)";
    $results = $dbget->select($sqlS);
    $started=$results[0][started];
    $sql="SELECT COUNT(*) AS Ilosc FROM ct_$baza[1], call_type, data_transaction, data_context WHERE data_transaction.data_context = data_context.code AND call_type.code = data_transaction.call_type AND ct_$baza[1].easycode = data_context.contact AND (ct_$baza[1].ct_kamp_id = '$baza[2]') AND (call_type.name = '$dispos[0]'";
  for($i=1; $i<count($dispos); $i++) {
	$sql.=" OR call_type.name = '$dispos[$i]'";
  }
$sql.=") ";
    $test = $dbget->select($sql);
    $test = $test[0];
    
    echo('
	<tr style="font-size: 10px; font-family: verdana;"  onmouseover=\'this.style.backgroundColor="#DDD"\' onmouseout=\'this.style.backgroundColor=""\' >
	 <td>
	  <input type="hidden" value="'.$baza[3].'" name="rek'.$liczlicznik.'" />
	  <input type="hidden" value="'.$started.'" name="reks'.$liczlicznik.'" />
	  <input type="hidden" value="'.(round(($test[0]/$baza[3] *100 ),2)*100).'" name="reksi'.$liczlicznik.'" />
	  <input type="checkbox" name="check'.$liczlicznik.'" value="1" onClick=zlicz('.$liczba_baz.')>
	 </td>
	 <td onclick="changestate('.$liczlicznik.'); zlicz('.$liczba_baz.');">'.$baza[1].'</td>
	 <td><a href="http://trpool09/intranet2/appl/lalamido/lalamido.php?show=frmEdit&edit_id='.$baza[4].'&kampaniaTXT=&kampidTXT=&wybor=subPrzet&datalad=&datazak=&plandatastart=&plandatastop=&details=&zakres1==&zakres2==&zakres3==&zakres4==&miesiacR=0" target="_blank">'.$baza[2].'</a></td>
	 <td onclick="changestate('.$liczlicznik.'); zlicz('.$liczba_baz.');">'.$baza[7].'</td>
	 <td style="text-align: right;" onclick="changestate('.$liczlicznik.'); zlicz('.$liczba_baz.');">start: '.substr($baza[5],0,10).'<br/>koniec: '.substr($baza[6],0,10).'</td>
	 <td onclick="changestate('.$liczlicznik.'); zlicz('.$liczba_baz.');">'.$started.' z '.$baza[3].'</td>
	 <td><a href="#" onclick="window.open(\'inc/dodzwanialnosc.php?kamp='.$baza[2].'&tab=ct_'.$baza[1].'&ileRek='.$baza[3].'&kamp_name='.$baza[1].'\',\'dodzwanialnosc\',\'status=no,width=500,height=560,left=20,top=20\');">'.round(($test[0]/$baza[3] *100 ),2).'%</a></td>
	 </tr>'); 
	 if (strlen($baza[2]) <= 6 && substr($baza[2],0,2)!='va') { 	 
//	 if (preg_match("/[a-zA-Z]{1}+[_]{1}+[a-zA-Z]{1}+[0-9]{3}$/i",$baza[2])) { 
	 	$dodzwanialnosc_vc[substr($baza[6],0,10)][$baza[2]]['left'] = $started;
	 	$dodzwanialnosc_vc[substr($baza[6],0,10)][$baza[2]]['all'] = $baza[3];
	 	$dodzwanialnosc_vc[substr($baza[6],0,10)][$baza[2]]['dodzw'] = round(($test[0]/$baza[3] *100 ),2);
	 	$dodzwanialnosc_vc[substr($baza[6],0,10)][$baza[2]]['kampid'] = '<a href="http://trpool09/intranet2/appl/lalamido/lalamido.php?show=frmEdit&edit_id='.$baza[4].'&kampaniaTXT=&kampidTXT=&wybor=subPrzet&datalad=&datazak=&plandatastart=&plandatastop=&details=&zakres1==&zakres2==&zakres3==&zakres4==&miesiacR=0" target="_blank">'.$baza[2].'</a>';
	 	$dodzwanialnosc_vc[substr($baza[6],0,10)][$baza[2]]['kampid2'] = $baza[2];
	 	$dodzwanialnosc_vc[substr($baza[6],0,10)][$baza[2]]['deadline'] = substr($baza[6],0,10);
	} 
  }
  echo('</table>
  <table style="font-family: tahoma; font-size: 10px;">
   <tr>
    <td>Zaladowanych</td>
    <td>Wystarowanych</td>
    <td>% wystartowanych</td>
   </tr>
   <tr>
    <td><input type="text" name="rmRek2" value="0" size="8" readonly/></td>
    <td><input type="text" name="rmStart2" value="0" size="8" readonly/></td>
    <td><input type="text" name="rmProc2" value="0" size="3" readonly/></td>
   </tr>
   </table>
  </form>');
  echo('
  <table  style="border: 1px solid #000000; border-collapse: collapse; width: 80%; margin: auto;" rules="all">
   <tr style="font-family: tahoma; font-size: 11px;">
    <td colspan="3" style="text-align: center; font-weight: bold;">Dodzwanialnosc VC</td>
   </tr>
   <tr style="font-family: tahoma; font-size: 11px;">
    <td><b>Deadline</b></td>
    <td><b>Kampanie</b></td>
    <td><b>Dodzwanialnosc</b></td>
   </tr>
  ');
  foreach($dodzwanialnosc_vc as $deadline) {
    $ok =0;
    $all = 0;
    $lista = array(
	1 => '',
	2 => '',
	3 => '',
	4 => '',
	5 => '',
	6 => '',
	);
    $timeline = '';
    foreach($deadline as $database) {
      if (substr($database['kampid2'],0,1) == 'w' && substr($database['kampid2'],2,1) == 'd') { $lista[1] = $database['kampid2']; }
      if (substr($database['kampid2'],0,1) == 'w' && substr($database['kampid2'],2,1) == 't') { $lista[2] = $database['kampid2']; }
      if (substr($database['kampid2'],0,1) == 'i' && substr($database['kampid2'],2,1) == 'd') { $lista[3] = $database['kampid2']; }
      if (substr($database['kampid2'],0,1) == 'i' && substr($database['kampid2'],2,1) == 't') { $lista[4] = $database['kampid2']; }
      if (substr($database['kampid2'],0,1) == 'd') { $lista[5] = $database['kampid2']; }
      if (substr($database['kampid2'],0,1) == 'v') { $lista[6] = $database['kampid2']; }
	  $ok += (($database['all'] - $database['left'])*$database['dodzw']);
	  $all += ($database['all']- $database['left']);
	  $timeline = $database['deadline'];
	}
	  
	echo('
	 <tr style="font-family: tahoma; font-size: 11px;" onmouseover=\'this.style.backgroundColor="#DDD"\' onmouseout=\'this.style.backgroundColor=""\' >
	  <td>'.$timeline.'</td>
	  <td style="width: 320px;"><div style="width: 75px; display: inline;">'.$lista[1].$lista[5].'</div><div style="width: 50px; display: inline;">'.$lista[2].$lista[6].'</div><div style="width: 50px; display: inline;">'.$lista[3].'</div><div style="width: 50px; display: inline;">'.$lista[4].'</div></td>
	  <td>'.round(($ok/$all),2).'%</td>
	 </tr>
	');
  }
  echo('</table><br/>');
//

// http://trpool09/intranet2/appl/lalamido/lalamido.php?show=frmEdit&edit_id=5941&kampaniaTXT=&kampidTXT=&wybor=subPrzet&datalad=&datazak=&plandatastart=&plandatastop=&details=&zakres1==&zakres2==&zakres3==&zakres4==&miesiacR=0
?>