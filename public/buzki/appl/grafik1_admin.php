<HTML>
<HEAD><TITLE>TWW</TITLE>
<meta name="robots" content="index, follow">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1257">
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="pragma" content="no-cache">
<base target="_self">
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<BODY bgcolor=#ffffff>

<?php

include "../../lib/config.php";
$pconnect = 0;

class dbstuff {
        var $querynum = 0;


              function is_uploaded_file($filename) {
                  if (!$tmp_file = get_cfg_var('upload_tmp_dir')) {
                      $tmp_file = dirname(tempnam('', ''));
                  }
                  $tmp_file .= '/' . basename($filename);
                  /* User might have trailing slash in php.ini... */
                  return (ereg_replace('/+', '/', $tmp_file) == $filename);
              }


        function connect($dbhost=dbhost, $dbuser, $dbpw, $dbname, $pconnect=0) {
                if($pconnect) {
                        mssql_pconnect($dbhost, $dbuser, $dbpw);
                } else {
                        mssql_connect($dbhost, $dbuser, $dbpw);
                }
                mssql_select_db($dbname);
        }

        function fetch_array($query) {
                $query = mssql_fetch_array($query);
                return $query;
        }

        function query($sql) {
                $query = mssql_query($sql) or die("Blad SQL: $sql");
                $this->querynum++;
                return $query;
        }

        function result($query, $row) {
                $query = mssql_result($query, $row);
                return $query;
        }

        function num_rows($query) {
                $query = mssql_num_rows($query);
                return $query;
        }

        function insert_id() {
                $id = mssql_insert_id();
                return $id;
        }

        function fetch_row($query) {
                $query = mssql_fetch_row($query);
                return $query;
        }
}


$db = new dbstuff;
$tempcache = "";
$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);

$count=0;


if (!$month)
{

	echo'
		<center>
		<form method="get">
		<b><font color=blue>Wybierz okres</font></b><br><br>
		<TABLE>
		<tr><td>Miesiac:</td><td>
		<select name="month" onChange=window.location="?month="+this.options[this.selectedIndex].value;>
	';   
	$xxx=0;

	$query1 = $db->query("SELECT miesiac, rok, data_od FROM grafik_view GROUP BY miesiac, rok, data_od ORDER BY rok DESC,miesiac DESC");
		    while($member1 = $db->fetch_array($query1)) {
		      	$xxx=$xxx+1;
			$d1=$member1['data_od'];
			$d1='"'.$d1.'"';
		
			echo "
		       <option value=".$d1.">".$member1['rok']."-".$member1['miesiac']."</option>";
		    }
		
	
	echo "
		</select>
		<INPUT type=submit value=\"WYSWIETL\">
		</td></tr>
		</TABLE>
		</form>";

	
	if ($xxx==0) echo '<HR><B>Nie odnaleziono zadnych godzin pracy w Twoim grafiku.</B><HR>';

		echo '
		</center>';
}
elseif (!$all)
{

	$today=strftime("%Y-%m-%d");

	$query1 = $db->query("SELECT pracodawca FROM grafik_view WHERE data_od='$month'");
	while($member1 = $db->fetch_array($query1))
	{
	$pracodawca=$member1['pracodawca'];
	}

	echo '<center>';
	echo "<B>$xmbf_name $xmbs_name</B> <I>(zatrudnienie: <B>$pracodawca</B>)</I><HR>";

	echo '<TABLE><TR>';

	//$xmbid=1;
	$query1 = $db->query("SELECT * FROM grafik_view WHERE data_od='$month'");
	

	if ($member1 = $db->fetch_array($query1))
	{
		$$id=$member1['id'];
		$data_od=$member1['data_od'];
		$rok=$member1['rok'];
		$miesiac=$member1['miesiac'];
		if ($miesiac<10) $miesiac='0'.$miesiac;
		$ilosc_dni=$member1['ilosc_dni'];
		
		
		echo '<TD><TABLE BORDER=0><TR><TD align=center><B>dzien</B></TD></TR>';
	
		for ($i=1;$i<=$ilosc_dni;$i=$i+1)
		{
			
		$ii=$i;
		if ($i<10) $ii='0'.$ii;

		$dzien=$rok.'-'.$miesiac.'-'.$ii;
	
		$od=$i.'od';
		$do=$i.'do';
		$prz=$i.'prz';

		
	
		$czas_od=$member1["$od"];
		$czas_do=$member1["$do"];
		$czas_prz=$member1["$prz"];
	
		if ($dzien==$today)
			{
			$kolor1='#ccccff';
			$kolor2='#aaaadd';
			}
		else
			{
			$kolor1='#eeeeee';
			$kolor2='#cccccc';
			}


		echo "<TR><TD bgcolor=$kolor1 align=center><A href='$PHP_SELF?day=$i&all=tak&month=$month'><font color=#555555><B>$dzien<B></FONT></A></TD></TR>";
	
		}
		echo '</TABLE></TD>';
	}

	echo '</TR></TABLE></center><HR>';


	echo'
		<center>
		<form method="get">
		<TABLE>
		<tr><td>Nowy Miesiac:</td><td>
		<select name="month" onChange=window.location="?month="+this.options[this.selectedIndex].value;>
	';   
	$xxx=0;

	$query1 = $db->query("SELECT miesiac, rok, data_od FROM grafik_view GROUP BY miesiac, rok, data_od ORDER BY rok DESC,miesiac DESC");
		    while($member1 = $db->fetch_array($query1)) {
		      	$xxx=$xxx+1;
			$d1=$member1['data_od'];
			$d1='"'.$d1.'"';
		
			echo "
		       <option value=".$d1.">".$member1['rok']."-".$member1['miesiac']."</option>";
		    }
		
	
	echo "
		</select>
		<INPUT type=submit value=\"WYSWIETL\">
		</td></tr>
		</TABLE>
		</form>";

	
	if ($xxx==0) echo '<HR><B>Nie odnaleziono zadnych godzin pracy w Twoim grafiku.</B><HR>';

		echo '
		</center>';

}
elseif($grupa)
{

	$today=strftime("%Y-%m-%d");

	$query1 = $db->query("SELECT pracodawca FROM grafik_view WHERE data_od='$month'");
	while($member1 = $db->fetch_array($query1))
	{
	$pracodawca=$member1['pracodawca'];
	}

	echo '<center>';
	echo '<HR>';

	


	//$xmbid=1;
	$query1 = $db->query("SELECT * FROM grafik_grupy_view WHERE data_od='$month' AND grupa='$grupa' ORDER BY nazwisko");
	

	while ($member1 = $db->fetch_array($query1))
	{
		$data_od=$member1['data_od'];
		$rok=$member1['rok'];
		$miesiac=$member1['miesiac'];
		if ($miesiac<10) $miesiac='0'.$miesiac;
		$ilosc_dni=$member1['ilosc_dni'];
		$nazwisko=$member1['nazwisko'];
		$imie=$member1['imie'];
		$id=$member1['id'];		




		if ($dzien==$today)
			{
			$kolor1='#ccccff';
			$kolor2='#aaaadd';
			}
		else
			{
			$kolor1='#eeeeee';
			$kolor2='#cccccc';
			}
		


				if (!$y)
				{
				echo '<TABLE><TR><TD></TD>';
			
				for ($i=$day;(($i<=$day+7) and ($i<=$ilosc_dni));$i=$i+1)
					{
						
					$ii=$i;
					if ($i<10) $ii='0'.$ii;
			
					$dzien=$rok.'-'.$miesiac.'-'.$ii;
				
								
					if ($dzien==$today)
						{
						$kolor1='#ccccff';
						$kolor2='#aaaadd';
						}
					else
						{
						$kolor1='#eeeeee';
						$kolor2='#cccccc';
						}
			
			
					echo "<TD bgcolor=$kolor1 align=center><NOBR>$dzien</NOBR></TD>";
				
					}
				echo "</TR>";
				$y=1;
				}

		if ($dzien==$today)
			{
			$kolor1='#ccccff';
			$kolor2='#aaaadd';
			}
		else
			{
			$kolor1='#eeeeee';
			$kolor2='#cccccc';
			}

		echo "<TR><TD align=center bgcolor=$kolor1>$imie $nazwisko</TD>";
	
		for ($i=$day;(($i<=$day+7) and ($i<=$ilosc_dni));$i=$i+1)
		{
			
		$ii=$i;
		if ($i<10) $ii='0'.$ii;

		$dzien=$rok.'-'.$miesiac.'-'.$ii;
	
		$od=$i.'od';
		$do=$i.'do';
		$prz=$i.'prz';

		
	
		$czas_od=$member1["$od"];
		$czas_do=$member1["$do"];
		$czas_prz=$member1["$prz"];
	
		if (($dzien==$today) or ($id==$xmbid))
			{
			$kolor1='#ccccff';
			$kolor2='#aaaadd';
			}
		else
			{
			$kolor1='#eeeeee';
			$kolor2='#cccccc';
			}


		echo "<TD bgcolor=$kolor2 align=center><B><NOBR>$czas_od - $czas_do</NOBR></B></TD>";
	
		}
		echo '</TR>';
	}


	echo'
		<center>
		<form method="get">
		<TABLE>
		<tr><td>Wybierz grupe: </td><td>
		<select name="grupa">
	';   
	
	
	$query1 = $db->query("SELECT IDNazwaGrupy, NazwaGrupy, count(*) AS ilosc FROM view_group_members GROUP BY IDNazwaGrupy, NazwaGrupy");
		    while($member1 = $db->fetch_array($query1)) {
		      
			$grupa_id=$member1['IDNazwaGrupy'];
			$grupa_opis=$member1['NazwaGrupy'];
			$grupa_ilosc=$member1['ilosc'];

			if ($grupa_id==$grupa) 
				{
				$c='SELECTED';
				$nazwa=$grupa_opis;
				}
			else $c='';
		
			echo "
		       <option value=".$grupa_id." $c>".$grupa_opis." (".$grupa_ilosc." osob)</option>";
		    }
		
	
	echo "
		</select>
		<INPUT type=hidden name=\"day\" value=\"$day\">
		<INPUT type=hidden name=\"all\" value=\"tak\">
		<INPUT type=hidden name=\"month\" value=\"$month\">
		<INPUT type=submit value=\"WYSWIETL\">
		</td></tr>
		</TABLE>
		</form>";


	echo '</TABLE></center><HR>';


	echo'
		<center>
		<form method="get">
		<TABLE>
		<tr><td>Nowy Miesiac:</td><td>
		<select name="month" onChange=window.location="?month="+this.options[this.selectedIndex].value;>
	';   
	$xxx=0;

	$query1 = $db->query("SELECT miesiac, rok, data_od FROM grafik_view GROUP BY miesiac, rok, data_od ORDER BY rok DESC,miesiac DESC");
		    while($member1 = $db->fetch_array($query1)) {
		      	$xxx=$xxx+1;
			$d1=$member1['data_od'];
			$d1='"'.$d1.'"';
		
			echo "
		       <option value=".$d1.">".$member1['rok']."-".$member1['miesiac']."</option>";
		    }
		
	
	echo "
		</select>
		<INPUT type=submit value=\"WYSWIETL\">
		</td></tr>
		</TABLE>
		</form>";

	
	if ($xxx==0) echo '<HR><B>Nie odnaleziono zadnych godzin pracy w Twoim grafiku.</B><HR>';

		echo '
		</center>';

}
else
{

	$today=strftime("%Y-%m-%d");

	$query1 = $db->query("SELECT pracodawca FROM grafik_view WHERE data_od='$month'");
	while($member1 = $db->fetch_array($query1))
	{
	$pracodawca=$member1['pracodawca'];
	}

	echo '<center>';
	echo '<HR>';

	


	//$xmbid=1;
	$query1 = $db->query("SELECT * FROM grafik_view WHERE data_od='$month' ORDER BY nazwisko");
	

	while ($member1 = $db->fetch_array($query1))
	{
		$data_od=$member1['data_od'];
		$rok=$member1['rok'];
		$miesiac=$member1['miesiac'];
		if ($miesiac<10) $miesiac='0'.$miesiac;
		$ilosc_dni=$member1['ilosc_dni'];
		$nazwisko=$member1['nazwisko'];
		$imie=$member1['imie'];
		$id=$member1['id'];		




		if ($dzien==$today)
			{
			$kolor1='#ccccff';
			$kolor2='#aaaadd';
			}
		else
			{
			$kolor1='#eeeeee';
			$kolor2='#cccccc';
			}
		


				if (!$y)
				{
				echo '<TABLE><TR><TD></TD>';
			
				for ($i=$day;(($i<=$day+7) and ($i<=$ilosc_dni));$i=$i+1)
					{
						
					$ii=$i;
					if ($i<10) $ii='0'.$ii;
			
					$dzien=$rok.'-'.$miesiac.'-'.$ii;
				
								
					if ($dzien==$today)
						{
						$kolor1='#ccccff';
						$kolor2='#aaaadd';
						}
					else
						{
						$kolor1='#eeeeee';
						$kolor2='#cccccc';
						}
			
			
					echo "<TD bgcolor=$kolor1 align=center><NOBR>$dzien</NOBR></TD>";
				
					}
				echo "</TR>";
				$y=1;
				}

		if (($dzien==$today) or ($id==$xmbid))
			{
			$kolor1='#ccccff';
			$kolor2='#aaaadd';
			}
		else
			{
			$kolor1='#eeeeee';
			$kolor2='#cccccc';
			}

		echo "<TR><TD align=center bgcolor=$kolor1>$imie $nazwisko</TD>";
	
		for ($i=$day;(($i<=$day+7) and ($i<=$ilosc_dni));$i=$i+1)
		{
			
		$ii=$i;
		if ($i<10) $ii='0'.$ii;

		$dzien=$rok.'-'.$miesiac.'-'.$ii;
	
		$od=$i.'od';
		$do=$i.'do';
		$prz=$i.'prz';

		
	
		$czas_od=$member1["$od"];
		$czas_do=$member1["$do"];
		$czas_prz=$member1["$prz"];
	
		if (($dzien==$today) or ($id==$xmbid))
			{
			$kolor1='#ccccff';
			$kolor2='#aaaadd';
			}
		else
			{
			$kolor1='#eeeeee';
			$kolor2='#cccccc';
			}


		echo "<TD bgcolor=$kolor2 align=center><B><NOBR>$czas_od - $czas_do</NOBR></B></TD>";
	
		}
		echo '</TR>';
	}


	echo'
		<center>
		<form method="get">
		<TABLE>
		<tr><td>Wybierz grupe: </td><td>
		<select name="grupa">
	';   
	
	
	$query1 = $db->query("SELECT IDNazwaGrupy, NazwaGrupy, count(*) AS ilosc FROM view_group_members GROUP BY IDNazwaGrupy, NazwaGrupy");
		    while($member1 = $db->fetch_array($query1)) {
		      
			$grupa_id=$member1['IDNazwaGrupy'];
			$grupa_opis=$member1['NazwaGrupy'];
			$grupa_ilosc=$member1['ilosc'];

			if ($grupa_id==$grupa) 
				{
				$c='SELECTED';
				$nazwa=$grupa_opis;
				}
			else $c='';
		
			echo "
		       <option value=".$grupa_id." $c>".$grupa_opis." (".$grupa_ilosc." osob)</option>";
		    }
		
	
	echo "
		</select>
		<INPUT type=hidden name=\"day\" value=\"$day\">
		<INPUT type=hidden name=\"all\" value=\"tak\">
		<INPUT type=hidden name=\"month\" value=\"$month\">
		<INPUT type=submit value=\"WYSWIETL\">
		</td></tr>
		</TABLE>
		</form>";


	echo '</TABLE></center><HR>';


	echo'
		<center>
		<form method="get" onChange=window.location="?month="+this.options[this.selectedIndex].value;>
		<TABLE>
		<tr><td>Nowy Miesiac:</td><td>
		<select name="month">
	';   
	$xxx=0;

	$query1 = $db->query("SELECT miesiac, rok, data_od FROM grafik_view GROUP BY miesiac, rok, data_od ORDER BY rok DESC,miesiac DESC");
		    while($member1 = $db->fetch_array($query1)) {
		      	$xxx=$xxx+1;
			$d1=$member1['data_od'];
			$d1='"'.$d1.'"';
		
			echo "
		       <option value=".$d1.">".$member1['rok']."-".$member1['miesiac']."</option>";
		    }
		
	
	echo "
		</select>

		<INPUT type=submit value=\"WYSWIETL\">
		</td></tr>
		</TABLE>
		</form>";

	
	if ($xxx==0) echo '<HR><B>Nie odnaleziono zadnych godzin pracy w Twoim grafiku.</B><HR>';

		echo '
		</center>';

}


?>
</BODY></HTML>