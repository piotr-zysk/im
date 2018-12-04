<?php

include("../../lib/tww.inc");
//include("../inc/functions.php");
//skad przybywam i gdzie jestem
$url=$_SERVER['QUERY_STRING'];
$url_from_caly=$_SERVER['HTTP_REFERER'];
$url_from_pociety=explode("?", $url_from_caly);
$url_from=$url_from_pociety[1];
//print("aktualny: $url<br>przychodze z: $url_from");



$query_data = $db->select("SELECT cust_id, nr_tel, (nazwisko+' '+imie) as klient, opis, data FROM callregistry_zglosz_agent WHERE (cust_id='".$_GET[search_data]."') OR (nr_tel='".$_GET[search_data]."')");

echo "
<table>
	<tr>
		<td width='10%'>Nr tel</td>
		<td width='10%'>ID</td>
		<td width='10%'>Klient</td>	
		<td width='60%'>Opis</td>
		<td width='10%'>Data</td>					
	</tr>";
	
	for($i=0;$i<count($query_data);$i++){
		echo "
			<tr>
				<td width='10%'>".$query_data[$i][nr_tel]."</td>
				<td width='10%'>".$query_data[$i][cust_id]."</td>
				<td width='10%'>".$query_data[$i][klient]."</td>	
				<td width='60%'>".$query_data[$i][opis]."</td>
				<td width='10%'>".$query_data[$i][data]."</td>					
			</tr>";		
	}
	
echo"	
</table>

";

?>