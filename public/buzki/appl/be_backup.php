<?php
include("../../lib/tww.inc");

//skad przybywam i gdzie jestem
$url=$_SERVER['QUERY_STRING'];
$url_from_caly=$_SERVER['HTTP_REFERER'];
$url_from_pociety=explode("?", $url_from_caly);
$url_from=$url_from_pociety[1];
//print("aktualny: $url<br>przychodze z: $url_from");

//poziom uprawnien
$xmbid=$_COOKIE["xmbid"];
$xmblevel=$_COOKIE["xmblevel"];

function uprawnienia() {
	$pozMin=90;
	$xmbid=$_COOKIE["xmbid"];
	$xmblevel=$_COOKIE["xmblevel"];
	if($xmblevel>=$pozMin) {
		return 1;
	} else if($xmbid==81) {
		return 2;
	} else {
		return 0;
	}
}

//pobranie winlogin
$query = $db->query("SELECT winlogin FROM tab_users WHERE id='$xmbid'");
while ($member = $db->fetch_array($query))
	{
	$winlogin = $member['winlogin'];
	}

//poczatek strony
echo "
<HTML><HEAD>
<TITLE>Statusy BE</TITLE>
	<meta name=\"robots\" content=\"index, follow\">
	<META HTTP-EQUIV=\"content-type\" CONTENT=\"text/html; charset=iso-8859-2\">
	<meta http-equiv=\"Content-Language\" content=\"pl\">
	<meta http-equiv=\"pragma\" content=\"no-cache\">
	<base target=\"_self\">
	<link rel=\"stylesheet\" type=\"text/css\" href='lalamido/css/main2.css'>

	<link rel=\"stylesheet\" type=\"text/css\" href=\"lalamido/css/calendar.css\">
	<script language='JavaScript' src='./lalamido/lib/simplecalendar.js' type='text/javascript'></script>


</HEAD>
<BODY>
<CENTER>
<TABLE class='title_table'>
<TR><TD><IMG src='graph/be2.jpg' width=950 height=150></TD></TR>
</TABLE>
";

//edytowanie w tabeli


	echo "
	<TABLE><TR><TD class='body_table'>
	";
	
	if($winlogin=="") {
		echo "Aby kozystac z aplikacji, musisz byc zalogowany w intranecie!";
	} else {
		
		echo "
			<TABLE>
			<TR><TD align=left>		
	
					<FORM action='$PHP_SELF' method='post' name='frmWysz'>
		
					<TABLE>
					<TR>
					<TD>
						produkt: </TD><TD width=10>
					</TD>
					<td>
						<select name=\"produkt\" size=12>
					";
						$query1 = $db->query("SELECT distinct produkt FROM callregistry_promo WHERE produkt IS NOT NULL ORDER BY produkt");
					    	
						while($member = $db->fetch_array($query1)) 
							{
					      		echo "<option value=".$member['produkt'].">".$member['produkt']."</option>";
					    		}
					
					 	echo "
						</select>
					</td>
		
					<TD>
						wybor: </TD><TD width=10>
					</TD>
					<td>
						<select name=\"wybor\" size=12>
					";
						$query1 = $db->query("SELECT distinct wybor FROM callregistry_promo WHERE wybor IS NOT NULL ORDER BY wybor");
					    	
						while($member = $db->fetch_array($query1)) 
							{
					      		echo "<option value=".$member['wybor'].">".$member['wybor']."</option>";
					    		}
					
					 	echo "
						</select>
					</td>
	
					<TD>
						zrodlo: </TD><TD width=10>
					</TD>
					<td>
						<select name=\"zrodlo\" size=12>
					";
						$query1 = $db->query("SELECT distinct source FROM callregistry_promo WHERE source IS NOT NULL ORDER BY source");
					    	
						while($member = $db->fetch_array($query1)) 
							{
					      		echo "<option value=".$member['source'].">".$member['source']."</option>";
					    		}
					
					 	echo "
						</select>
					</td>
	
					</TR>
	
					</TABLE>
	

					
					
			</TD><TD></TD></TR>
			</TABLE>
		";
	
		
	
	}
	echo "
	</TD></TR></TABLE>
	
	<TABLE><TR><TD class='body_table'>
	
					<TABLE cellspacing='0' cellpadding='0' border='0'>
					<TR>
						<TD>
							poczatkowa data: </TD><TD width=10>
						</TD>
						<TD>
							<INPUT type='text' name='datapocz' class='normal' size='15' value='$datapocz'>
						</TD>
						<TD>
							<a href=\"javascript: void(0);\" onmouseover=\"if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;\" onmouseout=\"if (timeoutDelay) calendarTimeout();window.status='';\" onclick=\"g_Calendar.show(event,'frmWysz.datapocz',false,'yyyy-mm-dd'); return false;\"><img src=\"./gfx/calendar.gif\" name=\"imgCalendar\" border=\"0\" alt=\"\"></a>
						</TD>
					</TR>
	
					<TR>
						<TD>
							koncowa data: </TD><TD width=10>
						</TD>
						<TD>
							<INPUT type='text' name='datakon' class='normal' size='15' value='$datakon'>
						</TD>
						<TD>
							<a href=\"javascript: void(0);\" onmouseover=\"if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;\" onmouseout=\"if (timeoutDelay) calendarTimeout();window.status='';\" onclick=\"g_Calendar.show(event,'frmWysz.datakon',false,'yyyy-mm-dd'); return false;\"><img src=\"./gfx/calendar.gif\" name=\"imgCalendar\" border=\"0\" alt=\"\"></a>
						</TD>
					</TR>
					</TABLE>
	
					<INPUT type=submit name=but_stat value='Zestawienie - ilosci bez BE'></INPUT>
					<INPUT type=submit name=but_stat value='Wyswietl rekordy do wprowadzenia statusow BE'></INPUT>
					</FORM>
	
	</TD></TR>
	<TR></TD><TD>
	<p class='podpis'>by TWW</p>
	</TD></TR></TABLE>
	</CENTER>
";
end_html();
?>