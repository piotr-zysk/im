
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>T2- Zgloszenia problemow na infolinii</TITLE>
<meta name="robots" content="index, follow">
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-2">
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="pragma" content="no-cache">
<base target="_self">
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<BODY bgcolor=#bbbbff>

<?php






function corpol($tekst)
{
$tekst=str_replace('&#261;','š',$tekst);
$tekst=str_replace('&#324;','ń',$tekst);
$tekst=str_replace('&#281;','ę',$tekst);
$tekst=str_replace('&#263;','ć',$tekst);
$tekst=str_replace('&#347;','',$tekst);
$tekst=str_replace('&#322;','ł',$tekst);
$tekst=str_replace('&#378;','',$tekst);
$tekst=str_replace('&#380;','ż',$tekst);
$tekst=str_replace('&#260;','Ľ',$tekst);
$tekst=str_replace('&#323;','Ń',$tekst);
$tekst=str_replace('&#280;','Ę',$tekst);
$tekst=str_replace('&#262;','Ć',$tekst);
$tekst=str_replace('&#346;','',$tekst);
$tekst=str_replace('&#321;','Ł',$tekst);
$tekst=str_replace('&#377;','',$tekst);
$tekst=str_replace('&#379;','Ż',$tekst);

return $tekst;
}







if (@$oper==""){
echo '



';
}


/// Checkpoint

if ($stage==1)
{
if (!$sugestia) $blad=$blad.'Musisz wpisac sugestie<BR>';
}

if (!$blad) $stage=$stage+1;




if (($stage==2) and (!$inf)) $action="save";



/// Stage1

if (($oper) and ($stage==1))
{

echo "
<Table width=100%>
<TR>
<TD>
</td><td>
</TD>
<TD align=right>
<font color=\"gray\">agent: $oper / $stage</font>
</TD>
</TR>
</Table>
<form method=\"post\" action=\"$PHP_SELF\">

<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"forma\"></input>
<INPUT TYPE=\"hidden\" NAME=\"oper\" VALUE=\"$oper\"></input>
<INPUT TYPE=\"hidden\" NAME=\"stage\" VALUE=\"$stage\"></input>

<center><H1><font color=\"red\">sugestie dla TELE2</font></H1>
";

if ($blad) echo "<B><font color=red>$blad</font></B><HR>";

echo "
</center>


<TABLE>
<tr><td>Twoja sugestia:</td><td><textarea wrap=hard name=\"sugestia\" cols=100 rows=4></textarea></td></tr>
</TABLE>

<Center><INPUT TYPE=\"SUBMIT\" Value=\"ZAPISZ DANE\"></Center>


</FORM>

";
}




if (@$action=="save") 
{

include "../../lib/config.php";

mssql_connect($dbhost,$dbuser,$dbpw);
mssql_select_db($dbname);


$data=strftime("%Y-%m-%d");
$czas=strftime("%H:%M:%S");

$sugestia=corpol($sugestia);

$query = mssql_query("INSERT INTO callregistry_sugestie (sugestia, oper, oper_id, data, czas) VALUES ('$sugestia', '$oper', '$xmbid', '$data', '$czas')")
or die("INSERT INTO callregistry_sugestie (sugestia, oper, oper_id, data, czas) VALUES ('$sugestia', '$oper', '$xmbid', '$data', '$czas')");


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



?>
</BODY>
</HTML>