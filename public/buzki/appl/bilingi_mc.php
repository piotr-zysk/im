<?php
$user_id1=475; //Maciej Cichecki
$user_id2=72; //Agnieszka Gradowska
$admin_level=90;

	if (($action=='stat') and ($new_datapocz))
	{
		setcookie("datapocz", $new_datapocz);
		setcookie("datakon", $new_datakon);

		$datapocz=$new_datapocz;
		$datakon=$new_datakon;
	}



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



//poczatek strony
echo "
<HTML><HEAD>
<TITLE>Mc Biling</TITLE>
	<meta name=\"robots\" content=\"index, follow\">
	<META HTTP-EQUIV=\"content-type\" CONTENT=\"text/html; charset=iso-8859-2\">
	<meta http-equiv=\"Content-Language\" content=\"pl\">
	<meta http-equiv=\"pragma\" content=\"no-cache\">
	<base target=\"_self\">
	<link rel=\"stylesheet\" type=\"text/css\" href='css/main3.css'>

	<link rel=\"stylesheet\" type=\"text/css\" href=\"lalamido/css/calendar.css\">
	<script language='JavaScript' src='./lalamido/lib/simplecalendar.js' type='text/javascript'></script>


</HEAD>
<BODY>
<CENTER>
<TABLE class='title_table'>
<TR><TD><B>Przegladarka Bilingów</B></TD></TR>
</TABLE>
";

//edytowanie w tabeli


	
	
	if (((!$xmblevel) or ($xmblevel<$admin_level)) and ($xmbid<>$user_id1) and ($xmbid<>$user_id2)) {
		echo "<BR><H2><FONT color=red>Aby korzystac z aplikacji, musisz byc zalogowany w intranecie, z odpowiednim poziomem uprawnien!</FONT></H2>";
	} 
else {
		

	

	echo "

	
	<TABLE><TR><TD class='body_table'>
	";

	if ($action=='save')

	{
		$name=corpol($name);
		$adres=corpol($adres);

		$query1 = $db->query("UPDATE callregistry_2line_bilingi SET cust_id='$cust_id', nr_tel='$nr_tel', name='$name', adres='$adres', wybor='$wybor', okres='$okres' WHERE id=$id");

		echo "Zamiany zostaly zapisane<BR>";
		$action='';
	}

	if (!$action)
	{
		
				echo "	

					<FORM action='$PHP_SELF' method='post' name='frmWysz'>
	

					<TABLE cellspacing='0' cellpadding='0' border='0'>
					<TR>
						<TD>
							poczatkowa data: </TD><TD width=10>
						</TD>
						<TD>
							<INPUT type='text' name='new_datapocz' class='normal' size='20' value='$datapocz'>
						</TD>
						<TD>
							<a href=\"javascript: void(0);\" onmouseover=\"if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;\" onmouseout=\"if (timeoutDelay) calendarTimeout();window.status='';\" onclick=\"g_Calendar.show(event,'frmWysz.new_datapocz',false,'yyyy-mm-dd'); return false;\"><img src=\"./gfx/calendar.gif\" name=\"imgCalendar\" border=\"0\" alt=\"\"></a>
						</TD>
					</TR>
	
					<TR>
						<TD>
							koncowa data: </TD><TD width=10>
						</TD>
						<TD>
							<INPUT type='text' name='new_datakon' class='normal' size='20' value='$datakon'>
						</TD>
						<TD>
							<a href=\"javascript: void(0);\" onmouseover=\"if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;\" onmouseout=\"if (timeoutDelay) calendarTimeout();window.status='';\" onclick=\"g_Calendar.show(event,'frmWysz.new_datakon',false,'yyyy-mm-dd'); return false;\"><img src=\"./gfx/calendar.gif\" name=\"imgCalendar\" border=\"0\" alt=\"\"></a>
						</TD>
					</TR>

					<TR>
						<TD>
							poczatek numeru telefonu: </TD><TD width=10>
						</TD>
						<TD>
							<INPUT type='text' name='new_tel' class='normal' size='20' value='$new_tel'>
						</TD>
						<TD>

						</TD>
					</TR>

					<TR>
						<TD>
							poczatek numeru faktury: </TD><TD width=10>
						</TD>
						<TD>
							<INPUT type='text' name='new_fak' class='normal' size='20' value='$new_fak'>
						</TD>
						<TD>

						</TD>
					</TR>


					</TABLE>
					<BR>
					<INPUT type=hidden name=action value=stat></INPUT>
					<INPUT type=submit name=but_stat value='Wyswietl Liste'></INPUT>
					
					</FORM>
					
					
		
	";
	}
	elseif ($action=='stat')
	{
				
				$i=0;
				echo "
					<TABLE>
										
				";
						if (($new_tel) and ($new_fak))
							{
								$temp = " AND (nr_tel LIKE '$new_tel%') AND (okres LIKE '$new_fak%')";
							}
						elseif ($new_tel)
							{
								$temp = " AND (nr_tel LIKE '$new_tel%')";
							}
						elseif ($new_fak)
							{
								$temp = " AND (okres LIKE '$new_fak%')";
							}
						else $temp='';
						
						$query1 = $db->query("SELECT id, cust_id, nr_tel, name, adres, wybor, okres, data, czas, oper FROM callregistry_2line_bilingi WHERE ((data>='$new_datapocz') And (data<='$new_datakon')$temp) ORDER BY wybor");

						while($member = $db->fetch_array($query1)) 
							{
							$i=$i+1;
							
					      		if ($i==1)
								{
								echo "
								<TR>
								<TD bgcolor=#eeeeee align=center><B>cust_id</B></TD>
								<TD bgcolor=#eeeeee align=center><B>nr_tel</B></TD>
								<TD bgcolor=#eeeeee align=center><B>name</B></TD>
								<TD bgcolor=#eeeeee align=center><B>adres</B></TD>
								<TD bgcolor=#eeeeee align=center><B>wybor</B></TD>
								<TD bgcolor=#eeeeee align=center><B>faktura</B></TD>
								<TD bgcolor=#eeeeee align=center><B>data</B></TD>
								<TD bgcolor=#eeeeee align=center><B>czas</B></TD>
								<TD bgcolor=#eeeeee align=center><B>oper</B></TD>
								</TR>
								";
								}

				
							$new_cust_id=$member['cust_id'];
							$new_nr_tel=$member['nr_tel'];
							$new_name=$member['name'];
							$new_adres=$member['adres'];
							$new_wybor=$member['wybor'];
							$new_okres=$member['okres'];
							$new_data=$member['data'];
							$new_czas=$member['czas'];
							$new_oper=$member['oper'];
							$new_id=$member['id'];

							$new_name=corpol_rev($new_name);
							$new_adres=corpol_rev($new_adres);

					      		echo "
								<TR>
								<TD bgcolor=#eeeeee align=center><A href=$PHP_SELF?action=edit&id=$new_id>$new_cust_id</A></TD>
								<TD bgcolor=#eeeeee align=center><A href=$PHP_SELF?action=edit&id=$new_id>$new_nr_tel</A></TD>
								<TD bgcolor=#eeeeee align=center><A href=$PHP_SELF?action=edit&id=$new_id>$new_name</A></TD>
								<TD bgcolor=#eeeeee align=center><A href=$PHP_SELF?action=edit&id=$new_id>$new_adres</A></TD>
								<TD bgcolor=#eeeeee align=center><A href=$PHP_SELF?action=edit&id=$new_id>$new_wybor</A></TD>
								<TD bgcolor=#eeeeee align=center><A href=$PHP_SELF?action=edit&id=$new_id>$new_okres</A></TD>
								<TD bgcolor=#eeeeee align=center><A href=$PHP_SELF?action=edit&id=$new_id>$new_data</A></TD>
								<TD bgcolor=#eeeeee align=center><A href=$PHP_SELF?action=edit&id=$new_id>$new_czas</A></TD>
								<TD bgcolor=#eeeeee align=center><A href=$PHP_SELF?action=edit&id=$new_id>$new_oper</A></TD>
								</TR>

							";
					    		}
						if (!$i) echo '<BR><I>Nie znaleziono zadnych rekordow</I><BR>';
					
				echo "
						</TABLE>
						<H2><A href=$PHP_SELF> <<< powrot <<< </A></H2>
						
				";

	}
	elseif ($action=='edit')
	{
		$query1 = $db->query("SELECT id, cust_id, nr_tel, name, adres, wybor, okres, data, czas, oper FROM callregistry_2line_bilingi WHERE id=$id");

		while($member = $db->fetch_array($query1)) 
				{
				$new_cust_id=$member['cust_id'];
				$new_nr_tel=$member['nr_tel'];
				$new_name=$member['name'];
				$new_adres=$member['adres'];
				$new_wybor=$member['wybor'];
				$new_okres=$member['okres'];
				$new_data=$member['data'];
				$new_czas=$member['czas'];
				$new_oper=$member['oper'];
				$new_id=$member['id'];

				$new_name=corpol_rev($new_name);
				$new_adres=corpol_rev($new_adres);

				echo "
					<FORM action='$PHP_SELF' method='post' name='frmedit'>
					<TABLE>
					<TR><TD>Customer ID</TD><TD><INPUT type=text name=cust_id value=\"$new_cust_id\" size=50></TD><TR>
					<TR><TD>Nr telefonu</TD><TD><INPUT type=text name=nr_tel value=\"$new_nr_tel\" size=50></TD><TR>
					<TR><TD>Imie i nazwisko</TD><TD><INPUT type=text name=name value=\"$new_name\" size=50></TD><TR>
					<TR><TD>Adres</TD><TD><INPUT type=text name=adres value=\"$new_adres\" size=50></TD><TR>
					<TR><TD>Wybor</TD><TD><INPUT type=text name=wybor value=\"$new_wybor\" size=50></TD><TR>
					<TR><TD>Faktura</TD><TD><INPUT type=text name=okres value=\"$new_okres\" size=50></TD><TR>
					<TR><TD>Data</TD><TD>$new_data</TD><TR>
					<TR><TD>Czas</TD><TD>$new_czas</TD><TR>
					<TR><TD>Operator</TD><TD>$new_oper</TD><TR>
					<TR><TD bgcolor=#ddddff align=center>
						<H2><A href=$PHP_SELF> <<< powrot <<< </A></H2>
						</TD><TD>
						<INPUT type=hidden name=action value=save>
						<INPUT type=hidden name=id value=$new_id>
						<INPUT type=submit value='Zapisz zmiany'></INPUT>
					</TD></TR>
					</TABLE>
					</FORM>
				";
				}
			

	}

echo "
	</TD></TR>
	<TR></TD><TD>
	<p class='podpis'>by TWW Poland</p>
	</TD></TR></TABLE>
	</CENTER>
";

}

end_html();
?>