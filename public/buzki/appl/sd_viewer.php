<HTML>
<HEAD><TITLE>TWW</TITLE>
<meta name="robots" content="index, follow">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1257">
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="pragma" content="no-cache">
<base target="_self">
<link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<BODY bgcolor=#eeeeee>

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



	echo'
		<center>
		<form method="get">
		<TABLE WIDTH=100%><TR><TD bgcolor=#dddddd align=left><b><font color=blue>Project Admin Viewer (lista administratorow baz wiedzy)</font></b></TD></TR></TABLE><hr>
		<TABLE>
		<tr><td>Wybierz projekt (baze wiedzy): </td><td>
		<select name="grupa" onChange=window.location="?grupa="+this.options[this.selectedIndex].value;>
	';   
	
	
	$query1 = $db->query("SELECT SkillGroup_id, Nazwa, count(*) AS ilosc FROM view_skillgroup_admins GROUP BY SkillGroup_id, Nazwa");
		    while($member1 = $db->fetch_array($query1)) {
		      
			$grupa_id=$member1['SkillGroup_id'];
			$grupa_opis=$member1['Nazwa'];
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
		<INPUT type=submit value=\"WYSWIETL\">
		</td></tr>
		</TABLE>
		</form>";

	if ($grupa)
	{
		echo '<CENTER><TABLE><TR><TD>';

		$x=0;
		$query1 = $db->query("SELECT f_name, s_name, user_id FROM view_skillgroup_admins WHERE SkillGroup_id=$grupa ORDER BY s_name");
		    while($member1 = $db->fetch_array($query1)) {
		      
			$f_name=$member1['f_name'];
			$s_name=$member1['s_name'];
			$x=$x+1;

			echo "$x. $f_name $s_name<BR>";
		       
		    }

		echo "</TD></TR></TABLE>
		<TABLE width=100%><TR><TD bgcolor=#dddddd align=center>
		</TD></TR></TABLE>
		</CENTER>";

	}
	


?>
</BODY></HTML>