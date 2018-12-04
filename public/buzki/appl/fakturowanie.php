<?php
include "../../lib/tww.inc";

start_html('#eeeeff','css/main.css','Fakturowanie w Tele2');

//checkpoint
if ($stage==1)
{
$blad=check_if_exists($r[cust_id],$blad,'Musisz wpisac ID klienta');
$blad=check_if_exists($r[nr_tel],$blad,'Musisz wpisac nr telefonu');
$blad=check_if_exists($r[fak],$blad,'Musisz wybrac rodzaj fakturowania');
}

echo "<center>";

if (!$blad) $stage=$stage+1;
	else echo "<font color=red><B>$blad</B></font><HR>";

if (($xmbid) and (!$stage)) $stage=1;
elseif (!$xmbid)
	{
	echo '<BR><B>Aplikacja zostala uruchomiona w nieprawidlowy sposob</B>';
	exit;
	}


if ($stage==1)
{
echo "
	<form method=\"post\" action=\"$PHP_SELF\" name=\"stage2\">
	<table>
		<tr><td>Customer Number (SV): </td><td><input type=\"text\" name=\"r[cust_id]\" size=\"20\" value=\"".$r[cust_id]."\"></td></tr>
		<tr><td>Nr telefonu:</td><td><input type=\"text\" name=\"r[nr_tel]\" size=\"20\" value=\"".$r[nr_tel]."\"></td></tr>
		
		<TR><TD colspan=2>
		<INPUT TYPE=\"radio\" NAME=\"r[fak]\" VALUE=\"10\"><font color=black>faktura co miesiac (10pln)</font><BR>
		<INPUT TYPE=\"radio\" NAME=\"r[fak]\" VALUE=\"30\"><font color=black>faktura po 30,50pln</font>
		</TD></TR>
		
		
		</TABLE>
		<INPUT TYPE=\"hidden\" NAME=\"stage\" VALUE=\"$stage\"></input>
		<INPUT type=\"submit\" value=\"zapisz\">
		</FORM></center>	
";
}


elseif ($stage==2)
{
	mssql_connect("trpool2","sa","trpool2");
	mssql_select_db("intranet");
	
	$r[data]=strftime("%Y-%m-%d");
	$r[czas]=strftime("%H:%M:%S");
	$r[oper_id]=$xmbid;
	
	$db->insert("callregistry_fakturowanie",$r);
	
	
	echo "<HR>Dane zostaly zapisane<HR><br>";
	?>
	<a href="?action=forma">OK</a>
	  <script>
	  function redirect()
	  {
	  window.location.replace("?oper=<?php=@$oper?>");
	  }
	  setTimeout("redirect();", 1000);
	  </script>
	<?php
}



end_html();
?>