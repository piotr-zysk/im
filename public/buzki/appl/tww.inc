<?php

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


        function connect($dbhost="localhost", $dbuser, $dbpw, $dbname) {
                mssql_connect($dbhost, $dbuser, $dbpw);
                mssql_select_db($dbname);
        }

        function fetch_array($query) {
                $query = mssql_fetch_array($query);
                return $query;
        }

        function query($sql) {
                $query = mssql_query($sql) or die(mysql_error());
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



function corpol($tekst)
{
$tekst=str_replace('&#261;','π',$tekst);
$tekst=str_replace('&#324;','Ò',$tekst);
$tekst=str_replace('&#281;','Í',$tekst);
$tekst=str_replace('&#263;','Ê',$tekst);
$tekst=str_replace('&#347;','ú',$tekst);
$tekst=str_replace('&#322;','≥',$tekst);
$tekst=str_replace('&#378;','ü',$tekst);
$tekst=str_replace('&#380;','ø',$tekst);
$tekst=str_replace('&#260;','•',$tekst);
$tekst=str_replace('&#323;','—',$tekst);
$tekst=str_replace('&#280;',' ',$tekst);
$tekst=str_replace('&#262;','∆',$tekst);
$tekst=str_replace('&#346;','å',$tekst);
$tekst=str_replace('&#321;','£',$tekst);
$tekst=str_replace('&#377;','è',$tekst);
$tekst=str_replace('&#379;','Ø',$tekst);

return $tekst;
}


function check_level($priv_level)
{

if ((!$xmbid) or ($xmbid < $priv_level))
{
echo '
<B>Nie jestes zalogowany/a w Intranecie lub nie masz uprawnien do korzystania z aplikacji</B>
<BR><BR>
Jezeli nie jestes zalogowany/a w Intranecie, zaloguj sie i uruchom aplikacje jeszcze raz.
<BR>
Jezeli jestes zalogowany/a w Intranecie i uwazasz, ze powinienes miec mozliwosc skorzystania z aplikacji, powiadom administratra
';
exit;
}

return 'OK';
}


function check_if_exists($input_value,$error_value,$error_comment)
{
if (!$input_value) $error_value=$error_value.$error_comment.'!!!<BR>';
}

return 'OK';
}


function start_html($bg_color,$css_link,$appl_title)
{
echo '	<HTML><HEAD><TITLE>'.$appl_title.'</TITLE>
	<meta name="robots" content="index, follow">
	<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-2">
	<meta http-equiv="Content-Language" content="pl">
	<meta http-equiv="pragma" content="no-cache">
	<base target="_self">
	<link rel="stylesheet" type="text/css" href="'.$css_link.'">
	</head>
	<BODY bgcolor='.$bg_color.'>
';
return 'OK';
}

function end_html()
{
echo '</BODY></HTML>';
return 'OK';
}

include "../../lib/config.php";


$db = new dbstuff;
$tempcache = "";
$db->connect($dbhost, $dbuser, $dbpw, $dbname, 0);

?>