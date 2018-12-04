<HTML>
<HEAD>
<title>konwerter date2timestamp</title>
</HEAD>
<BODY>

<FORM method="POST" action="d2t.php" name="frmd2t">
Podaj date w formacie RRRR-MM-DD: <INPUT name="date" type="text" value="<?php echo $_POST[date]; ?>"> <INPUT type="submit" name="convert" value="convert">
</FORM>

<P>
<?php
if($_POST[convert]!="") {
  $timestamp = strtotime($_POST[date] . " 00:00:00");
  echo "Wynik: " . $timestamp;
}

?>
</P>

</BODY>
</HTML>