<?php
include "../../lib/tww.inc";

start_html('#ffeeee','css/main.css','TWW Access Card Manager');
check_level(70,$xmblevel);



echo "
<form method=\"post\" action=\"$PHP_SELF\">
<INPUT type=\"hidden\" name=\"action\" value=\"find\">
<TABLE>
<tr><td>Imie:</td><td><input type=\"text\" name=\"fname\" size=\"30\" value=\"$fname\"></td></tr>
<tr><td>Nazwisko:</td><td><input type=\"text\" name=\"sname\" size=\"30\" value=\"$sname\"></td></tr>
<tr><td>Login IB:</td><td><input type=\"text\" name=\"iblogin\" size=\"5\" value=\"$iblogin\"></td></tr>
<tr><td>Nr karty dostepu:</td><td><input type=\"text\" name=\"accesscard\" size=\"5\" value=\"$accesscard\"></td></tr>
</TABLE>
<INPUT TYPE=\"SUBMIT\" Value=\"WYSZUKAJ\">
";


if ($action=='find')
{
		echo '<HR><TABLE><TR>
			<TD align=center>imie i nazwisko</TD>
			<TD align=center>login IB</TD>
			<TD align=center><B>nr karty dostepu</B></TD>
			<TD align=center>status</TD>
			<TD></TD></TR>';

		$s_fname=strtolower($fname);
		$s_sname=strtolower($sname);
		$where='';
		if ($iblogin) $where="AND IB_ID=$iblogin";
		if ($accesscard) $where=$where." AND access_card=$accesscard";
		
		//echo "SELECT f_name, s_name, IB_ID, access_card, disabled FROM tab_users_all WHERE LOWER(f_name) like '%$s_fname%' AND LOWER(s_name) like '%$s_sname%' $where ORDER BY s_name";

		$query = $db->query("SELECT id, f_name, s_name, IB_ID, access_card, disabled FROM tab_users_all WHERE LOWER(f_name) like '%$s_fname%' AND LOWER(s_name) like '%$s_sname%' $where ORDER BY s_name");
		while ($member = $db->fetch_array($query))
			{
			$f_name = $member['f_name'];
			$s_name=$member['s_name'];
			$IB_ID=$member['IB_ID'];
			$access_card=$member['access_card'];
			$disabled=$member['disabled'];
			$id=$member['id'];
			if ($disabled==1) $disabled='nie pracuje';
			else $disabled='pracuje';
			
			echo "<TR><TD align=center bgcolor=#ddddff>$f_name $s_name</TD>
				<TD align=center bgcolor=#ddddff>$IB_ID</TD>
				<TD align=center bgcolor=#ddddff>$access_card</TD>
				<TD align=center bgcolor=#ddddff>$disabled</TD>
				<TD><A href=\"$PHP_SELF?action=edit&id=$id\"><- edytuj</A></TD>
				</TR>
			";	
			
			}
		echo '</TABLE>';
}
elseif ($action=='edit')
{
		$query = $db->query("SELECT f_name, s_name, IB_ID, access_card, disabled FROM tab_users_all WHERE id=$id");
		while ($member = $db->fetch_array($query))
			{
			$f_name = $member['f_name'];
			$s_name=$member['s_name'];
			$IB_ID=$member['IB_ID'];
			$access_card=$member['access_card'];
			$disabled=$member['disabled'];
			if ($disabled==1) $disabled='nie pracuje';
			else $disabled='pracuje';
			
			echo "
				<HR>
				<form method=\"post\" action=\"$PHP_SELF\">
				<INPUT type=\"hidden\" name=\"action\" value=\"save\">
				<INPUT type=\"hidden\" name=\"id\" value=\"$id\">
				<TABLE>
				<TR><TD align=right>Imie i nazwisko:</TD><TD>$f_name $s_name</TD></TR>
				<TR><TD align=right>Login IB:</TD><TD>$IB_ID</TD></TR>
				<TR><TD align=right>Status:</TD><TD>$disabled</TD></TR>
				<TR><TD align=right>Nr karty dostepu:</TD><TD><input type=\"text\" name=\"access_card\" size=\"5\" value=\"$access_card\"></TD></TR>
				</TABLE>
				<INPUT TYPE=\"SUBMIT\" Value=\"ZAKTUALIZUJ\">
				</form>
			";
			}
}
elseif ($action=='save')
{
$query = $db->query("UPDATE tab_users_all SET access_card=$access_card WHERE id=$id");
echo '<HR>Numer karty zostal zaktualizowany w bazie danych.';
}



end_html();
?>