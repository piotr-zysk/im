<HTML>
<HEAD><TITLE>TWW</TITLE>
<meta name="robots" content="index, follow">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1257">
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="pragma" content="no-cache">
<base target="_self">
<link rel="stylesheet" type="text/css" href="../css/main.css">
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



	echo'
		<center>
		<form method="get">
		<TABLE WIDTH=100%><TR><TD bgcolor=#dddddd align=left><b><font color=blue>UserGroup Viewer</font></b></TD></TR></TABLE><hr>
		<TABLE>
		<tr><td>Wybierz grupe: </td><td>
		<select name="grupa" onChange=window.location="?grupa="+this.options[this.selectedIndex].value;>
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
		<INPUT type=submit value=\"WYSWIETL\">
		</td></tr>
		</TABLE>
		</form>";

	if ($grupa)
	{
		echo '<CENTER><TABLE><TR><TD>';

		$x=0;
		$query1 = $db->query("SELECT f_name, s_name, IDPracownika FROM view_group_members WHERE IDNazwaGrupy=$grupa ORDER BY s_name");
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
	

	if ($action=='edit')
	{
		
		echo '<CENTER><form method="post" action="'.$PHP_SELF.'"><TABLE><TR><TD align=center><INPUT type=text NAME=nazwa VALUE="'.$nazwa.'"><BR><SELECT SIZE=30 NAME="lista" MULTIPLE>';

		$query1 = $db->query("SELECT f_name, s_name, id FROM tab_users ORDER BY s_name");
		    while($member1 = $db->fetch_array($query1)) {
		      
			$p_id=$member1['id'];
			$f_name=$member1['f_name'];
			$s_name=$member1['s_name'];

			$query2 = $db->query("SELECT IDPracownika FROM view_group_members WHERE IDNazwaGrupy=$grupa AND IDPracownika=$p_id");
			if ($member2 = $db->fetch_array($query2)) $c='SELECTED';
			else $c='';

			echo "<OPTION value=$p_id $c>$f_name $s_name</OPTION>";
		       
		    }

		echo "</SELECT></TD></TR></TABLE>
		<INPUT type=submit value=\"ZAPISZ\">
		<INPUT type=hidden name=\"grupa\" value=\"3\">
		<INPUT type=hidden name=\"action\" value=\"save\">
		</FORM>
		</CENTER>";


	}
	elseif ($action=='save')
	{
		$x=0;
		if ($y=$lista) 
			{
			echo "$y<BR>";
			$x=$x+1;
			}
	}

?>
</BODY></HTML>