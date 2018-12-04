<?php
//naglowek
echo "
<CENTER>
<BR><B class='Big'>Wczytywanie pliku z banku</B><BR><BR>
</CENTER>
";

if($wczytaj) {
	if($bankFile) {
		//kopiowanie pliku na serwer
		move_uploaded_file("$bankFile", "./tmp/$bankFile_name");
		//czytanie pliku
		$lines = file("./tmp/$bankFile_name"); 
		echo "<P class='Small'>";
		echo "<TABLE border=0 cellspacing=0 cellpadding=2>";
		array_shift($lines);
		array_pop($lines);
		
		$ileRek=count($lines);
		//liczniki ok i blad
		$okCount=0;
		$badCount=0;		

		foreach ($lines as $line_num => $line) {  
     			$lineTab = explode(",", $line);

			//przetwarzamy id
			$id="19" . substr($lineTab[0], 1);

			//potrzebne zmienne
			$stBank=intval($lineTab[6]);
			$stTWW=5;
			$idPakiet="";
			$idKlient="";
			$dataHistoria=date("Y-m-d H:i");
			$operID=$xmbid;
			if($stBank==1) $stTWW=4; //zmiana statusu TWW na ok, jezeli przeszlo przez bank ok

			//pobieramy id wpisu -> tylko klienci ze statusem wyslano pismo do banku (3)
			$sql="SELECT d.id, d.idKlient FROM DDpakiety d WHERE d.idKlient='$id' AND statusTWW='3'";
			$query = $db->query($sql);
			while ($member = $db->fetch_array($query)) {
				$idPakiet=$member['id'];
				$idKlient=$member['idKlient'];
			}
			
			if($idPakiet=="") {
				echo "
				<TR class='Small'>
				<TD width='50'></TD>
				<TD>Linia #<b>{$line_num}</b> : </TD><TD>
				<B class='wyr'>BLAD!</B>
				</TD></TR>
				";
				$badCount++;
			} else {
				//update DDpakiety
				$qry=$db->query("UPDATE DDpakiety SET statusTWW='$stTWW', statusBank='$stBank' WHERE id='$idPakiet'");
				//update DDhistoria
				$qry=$db->query("INSERT INTO DDhistoria(dataHistoria,idPakietu,idKlient,operID,statusTWW,statusBank) VALUES('$dataHistoria','$idPakiet','$idKlient','$operID','$stTWW','$stBank')");
				$okCount++;
			}
			
		}
		echo "</TABLE>";
		echo "</P>";

		echo "
		<TABLE cellspacing=0 cellpadding=2 border=0>
		<TR>
		<TD width='50'></TD>
		<TD class='Norm'><B>OK!</B>&nbsp;&nbsp; Wczytalem plik o nazwie <I>$bankFile_name</I>.</TD>
		</TR>
		<TR>
		<TD width='50'></TD>
		<TD class='Norm'>
			Rekordow w pliku: $ileRek<BR>
			Rekordow wczytanych prawidlowo: $okCount<BR>
			Rekordow wczytanych blednie: $badCount<BR>
		</TD>
		</TR>
		<TR>
		<TD width='50'></TD>
		<TD><A href='dede.php?show=bankRead' class='Small'>&lt Powrot</A></TD>
		</TR>
		</TABLE>
		";
	} else {
		echo "
		<TABLE cellspacing=0 cellpadding=2 border=0>
		<TR>
		<TD width='50'></TD>
		<TD class='NormWyr'><B>BLAD!</B>&nbsp;&nbsp; Nie podales pliku do wczytania!</TD>
		</TR>
		<TR>
		<TD width='50'></TD>
		<TD><A href='dede.php?show=bankRead' class='Small'>&lt Powrot</A></TD>
		</TR>
		</TABLE>
";
	}
	
} else {

	//formularz do wczytywania pliku

	echo "
	<TABLE cellspacing=0 cellpadding=2 border=0>
	<FORM name='frmBankFile' enctype='multipart/form-data' action='dede.php?show=bankRead' method='POST'>
	<TR>
	<TD width='50'></TD>
	<TD colspan='3' class='Small'>Wskaz lokalizacje pliku</TD>
	</TR>
	<TR>
	<TD></TD>
	<TD class='Small'>Plik</TD>
	<TD><INPUT type='file' name='bankFile' size='50'></TD>
	<TD><INPUT type='submit' name='wczytaj' value='WCZYTAJ'></TD>
	</TR>
	</FORM>
	</TABLE>
	";
}

?>