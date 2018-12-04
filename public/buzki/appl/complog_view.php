<?php

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
<TITLE>complog</TITLE>
	<meta name=\"robots\" content=\"index, follow\">
	<META HTTP-EQUIV=\"content-type\" CONTENT=\"text/html; charset=iso-8859-2\">
	<meta http-equiv=\"Content-Language\" content=\"pl\">
	<meta http-equiv=\"pragma\" content=\"no-cache\">
	<base target=\"_self\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/main.css\">
	<script language='JavaScript' src='./lalamido/lib/simplecalendar.js' type='text/javascript'></script>


</HEAD>
<BODY>
<CENTER>
<TABLE class='title_table'>
<TR><TD><B>Historia logowania do Intranetu</B></TD></TR>
</TABLE>
";

//edytowanie w tabeli


	
	
	if ((!$xmblevel) or ($xmblevel<$admin_level)) {
		echo "<BR><H2><FONT color=red>Aby korzystac z aplikacji, musisz byc zalogowany w intranecie, z odpowiednim poziomem uprawnien!</FONT></H2>";
	} 
else {
		

	

	echo "

	
	<TABLE><TR><TD class='body_table'>
	";

	if (!$action or $action)
	{
		
				echo "	

					<FORM action='$PHP_SELF' method='post' name='frmWysz'>
	
					<TABLE cellspacing='0' cellpadding='0' border='0'>
					<TR>
						<TD>
							numer telefonu: </TD>
						<TD>
							<INPUT type='text' name='new_extension' class='normal' size='20' value='$new_extension'>
						</TD>
					</TR>
					<TR>
						<TD>
							login (IB / intranet): </TD>
						<TD>
							<INPUT type='text' name='new_login' class='normal' size='20' value='$new_login'>
						</TD>
					</TR>
					<TR>
						<TD>
							nazwa komputera: </TD>
						<TD>
							<INPUT type='text' name='new_computer' class='normal' size='20' value='$new_computer'>
						</TD>
					</TR>

					<TR>
						<TD>
							poczatek imienia (tylko male litery): </TD>
						<TD>
							<INPUT type='text' name='new_f_name' class='normal' size='20' value='$new_f_name'>
						</TD>
					</TR>

					<TR>
						<TD>
							poczatek nazwiska (tylko male litery): </TD>
						<TD>
							<INPUT type='text' name='new_s_name' class='normal' size='20' value='$new_s_name'>
						</TD>
					</TR>
						<TR><TD></TD><TD>
							<INPUT type=hidden name=action value=stat></INPUT>
							<INPUT type=submit name=but_stat value='Wyswietl historie'></INPUT>
						</TD>
					</TR>

					</TABLE>
					
					</FORM>
					
					
		
	";
	}
	if ($action=='stat')
	{
				
				$i=0;
				echo "
					<TABLE>
										
				";
						$yemp='';
						if ($new_extension)
							{
								$temp = $temp." AND (extension = '$new_extension')";
							}
						if ($new_login)
							{
								$temp = $temp." AND (IB_ID = '$new_login')";
							}

						if ($new_computer)
							{
								$new_computer=strtolower($new_computer);
								$temp = $temp." AND (LOWER(computer) = '$new_computer')";
							}
						if ($new_f_name)
							{
								$f_name=strtolower($f_name);
								$temp = $temp." AND (LOWER(f_name) LIKE '$new_f_name%')";
							}
						if ($new_s_name)
							{
								$s_name=strtolower($s_name);
								$temp = $temp." AND (LOWER(s_name) LIKE '$new_s_name%')";
							}
						
						if ($temp)
							{
								$temp=" WHERE ".substr($temp, 4);
							}

						
						$query1 = $db->query("SELECT TOP 50 extension, computer, picktime, user_id, f_name, s_name, IB_ID, OB_ID FROM view_complog$temp");
//echo "SELECT TOP 50 extension, computer, picktime, user_id, f_name, s_name, IB_ID, OB_ID FROM view_complog$temp";
						while($member = $db->fetch_array($query1)) 
							{
							$i=$i+1;
							
					      		if ($i==1)
								{
								echo "
								<TR>
								<TD bgcolor=#eeeeee align=center><B>czas</B></TD>
								<TD bgcolor=#eeeeee align=center><B>tel</B></TD>
								<TD bgcolor=#eeeeee align=center><B>komputer</B></TD>
								<TD bgcolor=#eeeeee align=center><B>user_id</B></TD>
								<TD bgcolor=#eeeeee align=center><B>imie i nazwisko</B></TD>
								<TD bgcolor=#eeeeee align=center><B>IB</B></TD>
								<TD bgcolor=#eeeeee align=center><B>OB</B></TD>
								</TR>
								";
								}

				
							$extension=$member['extension'];
							$computer=$member['computer'];
							$picktime=$member['picktime'];
							$user_id=$member['user_id'];
							$f_name=$member['f_name'];
							$s_name=$member['s_name'];
							$ib=$member['IB_ID'];
							$ob=$member['OB_ID'];

					      		echo "
								<TR>
								<TD bgcolor=#eeeeee align=center>$picktime</TD>
								<TD bgcolor=#eeeeee align=center>$extension</TD>
								<TD bgcolor=#eeeeee align=center>$computer</TD>
								<TD bgcolor=#eeeeee align=center>$user_id</TD>
								<TD bgcolor=#eeeeee align=center>$f_name $s_name</TD>
								<TD bgcolor=#eeeeee align=center>$ib</TD>
								<TD bgcolor=#eeeeee align=center>$ob</TD>
								</TR>

							";
					    		}
						if (!$i) echo '<CENTER><H2><BR><I>Nie znaleziono zadnych rekordow</I></H2></CENTER><BR>';
					
				echo "
						</TABLE>
												
				";

	}

echo "
	</TD></TR>
	</TABLE>
	</CENTER>
";

}

end_html();
?>