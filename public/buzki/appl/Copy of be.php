<?php
$leads_on_page=10; //ilosc rekordow wyswietlana na stronie
$min_level=10; //minimalny poziom uprawnien


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
<TITLE>Statusy BE</TITLE>
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
<TR><TD><IMG src='graph/be2.jpg' width=950 height=150></TD></TR>
</TABLE>
";

//edytowanie w tabeli


	
	
	if((!$xmblevel) or ($xmblevel<$min_level)) {
		echo "<BR><H2><FONT color=red>Aby korzystac z aplikacji, musisz byc zalogowany w intranecie, z odpowiednim poziomem uprawnien!</FONT></H2>";
	} 
else {
		

	

	echo "

	
	<TABLE><TR><TD class='body_table'>
	";

	if (!$action)
	{
		$query = $db->query("UPDATE callregistry_promo SET in_use = NULL WHERE in_use=$xmbid");
		$result=mssql_query("SELECT @@ROWCOUNT");
		list($x) = mssql_fetch_row($result);
		if ($x>0) echo "<font color=red>Odblokowano $x rekordow zablokowanych na Twoim loginie</font><BR>";
		
				$query1 = $db->query("SELECT count(*) as ilosc FROM callregistry_promo_log WHERE DATEPART(yy,status_time) = DATEPART(yy,GETDATE()) AND DATEPART(mm,status_time) = DATEPART(mm,GETDATE()) AND DATEPART(dd,status_time) = DATEPART(dd,GETDATE()) AND status_oper_id = $xmbid");
				if ($member = $db->fetch_array($query1))
					$temp=$member['ilosc'];
				
			
				echo "
					<TABLE class=table_log><TR><TD bgcolor=#aaaaff>Wprowadziles dzis do tej pory $temp statusow BE</TD></TR></TABLE><BR>
						

					<FORM action='$PHP_SELF' method='post' name='frmWysz'>
	

					<TABLE cellspacing='0' cellpadding='0' border='0'>
					<TR>
						<TD>
							poczatkowa data: </TD><TD width=10>
						</TD>
						<TD>
							<INPUT type='text' name='new_datapocz' class='normal' size='15' value='$datapocz'>
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
							<INPUT type='text' name='new_datakon' class='normal' size='15' value='$datakon'>
						</TD>
						<TD>
							<a href=\"javascript: void(0);\" onmouseover=\"if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;\" onmouseout=\"if (timeoutDelay) calendarTimeout();window.status='';\" onclick=\"g_Calendar.show(event,'frmWysz.new_datakon',false,'yyyy-mm-dd'); return false;\"><img src=\"./gfx/calendar.gif\" name=\"imgCalendar\" border=\"0\" alt=\"\"></a>
						</TD>
					</TR>

					<TR>
						<TD>
							wyswietl rekordy, gdzie: </TD><TD width=10>
						</TD>
						<TD>
							<SELECT NAME=\"status_typ\">
							<OPTION value=\"\"> brak statusu BE
							<OPTION value=\"za\"> Klient zablokowany
							</SELECT>
						</TD>
						<TD>

						</TD>
					</TR>

					</TABLE>
					<BR>
					<INPUT type=hidden name=action value=stat></INPUT>
					<INPUT type=submit name=but_stat value='Zestawienie - ilosci bez BE'></INPUT>
					
					</FORM>
					
					<TABLE class=table_log>
					<TR><TD align=left>
					Podstawowe zasady (<font color=red>przeczytaj koniecznie zanim zaczniesz korzystac z aplikacji</font> !!!) :<BR>
					1. Nalezy wybrac zakres dat, kliknac przycisk, kliknac wybrana kategorie aktywacji i dla wybranych rekordow wybrac odpowiedni status BE<BR>
					2. Aby wprowadzic statusy do systemu nalezy kliknac przycisk ZAPISZ STATUSY<BR>
					3. Aby wyjsc z okna edycji statusow mozna jedynie wcisnac przycisk ZAPISZ STATUSY albo kliknac na link \"<<< POWROT DO WYBORU KATEGORII <<<\".
					Kazda inna operacja jest zabroniona. Nie mozna korzystac z przycisku Back w przegladarce internetowej. Niedozwolone jest rowniez zamykanie przegladarki podczas edycji statusow.<BR>
					4. Jezeli z jakichkolwiek przyczyn zasady z punktu 3. zostana naruszone, nalezy ponownie na tym samym loginie do Intranetu otworzyc aplikacje. (ponowne otwarcie aplikacji odblokuje zablokowane rekordy).<BR>
					5. Litera <font color=red><B>W</B></font> po numerze telefonu oznacza, ze usluge nalezy aktywowac nie tylko na wpisany numer lecz na wszystkie posiadane przez klienta numery telefonu.
					</TD></TR>
					</TABLE>
	";
	}
	elseif ($action=='stat')
	{
				
				if ($cb=='true')
				$query = $db->query("UPDATE callregistry_promo SET in_use = NULL WHERE in_use=$xmbid");
				
			
				echo "
					<TABLE>
					<TR>
					
					<td>
						
				";
						if (!$status_typ)
							{
								$status_filtr="(status_be IS NULL OR status_be = '')";
							}
						else
							{
								$status_filtr="status_be='za'";
								$comstat='zablokowani klienci - ';
							}

						$i=0;
						$query1 = $db->query("SELECT produkt, wybor, count(*) as ilosc FROM callregistry_promo WHERE data >= '$datapocz' AND data <= '$datakon' AND $status_filtr AND Left(wybor,1)='a' GROUP BY produkt, wybor ORDER BY wybor, produkt");
					    	
						while($member = $db->fetch_array($query1)) 
							{
							$i=$i+1;
							$new_produkt=$member['produkt'];
							$new_wybor=$member['wybor'];
							$new_ilosc=$member['ilosc'];

					      		echo "<A HREF=$PHP_SELF?action=edit&status_typ=$status_typ&lead_id=".$new_produkt."|".$new_wybor.">".$i.". ".$new_wybor." - ".$new_produkt." - $comstat<B>".$new_ilosc."</B> sztuk </A><BR>";
					    		}
						if (!$i) echo '<BR><I>Brak rekordow do edycji statusow</I><BR>';
					
				echo "
						
					<BR><BR>
					<CENTER>
					<TABLE class=table_log><TR><TD bgcolor=#ffaaaa><A href=$PHP_SELF><B> <<< POWROT DO WYBORU DAT <<< </B></A></TD></TR></TABLE>
					</CENTER>

					</td>
					</TR></TABLE>
				";

	}
	elseif ($action=='edit')
	{

				if ($cb=='true')
				$query = $db->query("UPDATE callregistry_promo SET in_use = NULL WHERE in_use=$xmbid");

				if ($leadcount>0)
				{
					$data=strftime("%Y-%m-%d %H:%M:%S");
					$i=1;
					while ($id[$i])
					{
						if (($status[$i]) AND ($edytuj[$i]))
						{
							$temp_id=$id[$i];
							$temp_status=$status[$i];
							$temp_produkt=$new_produkt[$i];
							$temp_cust_id=$new_cust_id[$i];
							$temp_name=corpol($new_name[$i]);
							$temp_kod=$new_kod[$i];
							$temp_miasto=corpol($new_miasto[$i]);
							$temp_ulica=corpol($new_ulica[$i]);
							$temp_nr_tel=$new_nr_tel[$i];
							$temp_firma=corpol($new_firma[$i]);

							$query = $db->query("INSERT INTO callregistry_promo_log (lead_id, status_time, status, status_oper_id) VALUES ($temp_id, '$data', '$temp_status', $xmbid)");
							$query2 = $db->query("UPDATE callregistry_promo SET firma = '$temp_firma', produkt = '$temp_produkt', cust_id = '$temp_cust_id', name = '$temp_name', kod = '$temp_kod', miasto = '$temp_miasto', ulica = '$temp_ulica', nr_tel = '$temp_nr_tel', be_update = 1, in_use = NULL, status_oper_id = $xmbid, status_be = '$temp_status', status_date = '$data' WHERE id=$temp_id");
						}
						elseif ($status[$i])
						{
							$temp_id=$id[$i];
							$temp_status=$status[$i];
							$query = $db->query("INSERT INTO callregistry_promo_log (lead_id, status_time, status, status_oper_id) VALUES ($temp_id, '$data', '$temp_status', $xmbid)");
							$query2 = $db->query("UPDATE callregistry_promo SET in_use = NULL, status_oper_id = $xmbid, status_be = '$temp_status', status_date = '$data' WHERE id=$temp_id");
						}
						elseif ($edytuj[$i])
						{
							$temp_id=$id[$i];
							$temp_status=$status[$i];
							$temp_produkt=$new_produkt[$i];
							$temp_cust_id=$new_cust_id[$i];
							$temp_name=corpol($new_name[$i]);
							$temp_kod=$new_kod[$i];
							$temp_miasto=corpol($new_miasto[$i]);
							$temp_ulica=corpol($new_ulica[$i]);
							$temp_nr_tel=$new_nr_tel[$i];
							$temp_firma=corpol($new_firma[$i]);

							$query2 = $db->query("UPDATE callregistry_promo SET firma = '$temp_firma', produkt = '$temp_produkt', cust_id = '$temp_cust_id', name = '$temp_name', kod = '$temp_kod', miasto = '$temp_miasto', ulica = '$temp_ulica', nr_tel = '$temp_nr_tel', be_update = 1, in_use = NULL WHERE id=$temp_id");
						}

					
						$i=$i+1;
					}
				}

				
				if (!$page) $page=0;

				$parametr=explode("|",$lead_id);
				$produkt=$parametr[0];
				$wybor=$parametr[1];
							
				$leadcount=0;


						if (!$status_typ)
							{
								$status_filtr="(status_be IS NULL OR status_be = '')";
							}
						else
							{
								$status_filtr="status_be='za'";
								$comstat=' - zablokowani klienci';
							}



				echo "

					<TABLE>
					<TR>
					
					<td align=center>
					<H3><font color=navy>$wybor - <B>$produkt</B>$comstat</font></H3><BR>
					
					<FORM action='$PHP_SELF' method='post' name='frmSave'>
					<INPUT type=hidden name=action value=\"edit\">
					<INPUT type=hidden name=lead_id value=\"$produkt|$wybor\">
					<TABLE class=table_log>

						
				";


						$query1 = $db->query("SELECT id, source, cust_id, nr_tel, all_tel, name, firma, ulica, kod, miasto, oper_id, data, czas as ilosc FROM callregistry_promo WHERE data >= '$datapocz' AND data <= '$datakon' AND $status_filtr AND produkt='$produkt' AND wybor='$wybor' ORDER BY cust_id, data, czas");
						$row_count = $db->num_rows($query1);					    	

						$index=0;
						while(($member = $db->fetch_array($query1)) AND ($leads_on_page > $leadcount)) 
							{
							$new_id=$member['id'];
							$index=$index+1;
							if ($index > ($page * $leads_on_page))
								{
								$query2 = $db->query("UPDATE callregistry_promo SET in_use=$xmbid WHERE id=$new_id AND (in_use IS NULL or in_use = 0)");
								$success=$db->rows_affected();
								
								if ($success) 						
									{
									$leadcount=$leadcount+1;
									$id[$leadcount]=$new_id;
		
									$new_cust_id=$member['cust_id'];
									$new_nr_tel=$member['nr_tel'];
									$new_all_tel=$member['all_tel'];
									$new_name=corpol_rev($member['name']);
									$new_firma=corpol_rev($member['firma']);
									$new_ulica=corpol_rev($member['ulica']);
									$new_kod=$member['kod'];
									$new_miasto=corpol_rev($member['miasto']);
									$new_oper_id=$member['oper_id'];
									$new_data=$member['data'];
									$new_czas=$member['czas'];
									$new_source=$member['source'];
		
							      		echo "
											<TR>
											<TD>$index</TD>
											<TD bgcolor=#000000><INPUT type=checkbox name=\"edytuj[$leadcount]\"><font color=red><B> - ZMIANA DANYCH</B></font></TD>
											<TD colspan=2 bgcolor=#000000>
												<SELECT NAME=\"new_produkt[$leadcount]\">
		
									";
			
											$query2 = $db->query("SELECT produkt FROM view_promo_produkt");
											while($member2 = $db->fetch_array($query2)) 
												{
												$new_produkt=$member2['produkt'];
												if ($new_produkt==$produkt) $temp='SELECTED'; else $temp='';
												echo "<OPTION value=\"$new_produkt\" $temp> $new_produkt";
												}
									echo "
												
												</SELECT> 
											</TD>
											<TD bgcolor=#ffffff></TD>
											</TR>
											
											<TR>
											
											<TD colspan=2><INPUT type='text' name='new_name[$leadcount]' size='40' value='$new_name'></TD>
											<TD bgcolor=#ffffff><I>\{$new_source $new_data}</I></TD>
											<TD bgcolor=#e9e9ff>cust_id:<INPUT type='text' name='new_cust_id[$leadcount]' size='10' value='$new_cust_id'></TD>
											<TD rowspan=3 bgcolor=#443355>
												<INPUT type=hidden name=\"id[$leadcount]\" value=\"$new_id\">
												<SELECT NAME=\"status[$leadcount]\">
														<OPTION value=\"\"> brak nowego statusu BE
									";
			
											$query2 = $db->query("SELECT status_id, status FROM callregistry_promo_status");
											while($member2 = $db->fetch_array($query2)) 
												{
												$new_status_id=$member2['status_id'];
												$new_status=$member2['status'];
												echo "<OPTION value=\"$new_status_id\"> $new_status";
												}
									echo "
												
												</SELECT> 
											</TD>											
											</TR>
											<TR>
											<TD colspan=3 align=center bgcolor=#dddddd>firma:<INPUT type='text' name='new_firma[$leadcount]' size='50' value='$new_firma'></TD>
											<TD align=center bgcolor=#e0e0f6>tel:<INPUT type='text' name='new_nr_tel[$leadcount]' size='10' value='$new_nr_tel'><font color=red><B> $new_all_tel</B></font></TD>
											<TR>
											<TR>
											<TD colspan=4 align=center bgcolor=#ccccee><INPUT type='text' name='new_kod[$leadcount]' size='4' value='$new_kod'><INPUT type='text' name='new_miasto[$leadcount]' size='36' value='$new_miasto'><INPUT type='text' name='new_ulica[$leadcount]' size='36' value='$new_ulica'></TD>
											</TR>
										
											<TR>

											<TD>
									
									";
									}
								}
							
					    		}
						echo "
							</TABLE><BR>
						";

						if ($leadcount>0)
							echo "<INPUT type=submit name=go_next value='ZAPISZ STATUSY I ZMIANY'></INPUT>";

						echo "
							<INPUT type=hidden name=page value=\"$page\">
							<INPUT type=hidden name=status_typ value=\"$status_typ\">
							<INPUT type=hidden name=leadcount value=\"$leadcount\">
							</FORM>							
						";

						if ($leadcount < $leads_on_page)
							{
								echo "
									Nie ma wiecej wolnych rekordow w wybranej kategorii.<BR><BR>
								";
					
							}
					
				
				echo "										
					<TABLE class=table_log><TR>
				";
				
				if ($page>0)
				{
					$temp_page=$page-1;
					echo "<TD bgcolor=#aaaaff><A HREF=$PHP_SELF?action=edit&status_typ=$status_typ&cb=true&lead_id=".$produkt."|".$wybor."&page=$temp_page><B> < poprzednia strona </B></A></TD>";
				}
				
				$temp_page=$page+1;
				$last_page=ceil($row_count/$leads_on_page);
				echo"<TD> strona $temp_page z $last_page </TD>";
				
				if (($page+1) < $last_page)
				{
					$temp_page=$page+1;
					echo "<TD bgcolor=#aaaaff><A HREF=$PHP_SELF?action=edit&status_typ=$status_typ&cb=true&lead_id=".$produkt."|".$wybor."&page=$temp_page><B> nastepna strona > </B></A></TD>";
				}


				echo "
					</TR></TABLE><BR>
					<TABLE class=table_log><TR><TD bgcolor=#ffaaaa><A href=$PHP_SELF?action=stat&status_typ=$status_typ&datapocz=$datapocz&datakon=$datakon&cb=true><B> <<< POWROT DO WYBORU KATEGORII <<< </B></A></TD></TR></TABLE>
					</td>
					</TR></TABLE>
				";

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