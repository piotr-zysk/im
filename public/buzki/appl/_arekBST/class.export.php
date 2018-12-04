<?php
/*
Automatyzacja procesu eksportu danych do pliku.
*/
class export {
  private $headers;
  private $data;
  
  /*
  params:
  $data_array - tabela z danymi
  */
  public function __construct($data_array) {
    $this->headers = $data_array[0];
    $this->data = array();
    $counter = count($data_array);
    for ($i=1; $i<$counter;$i++) {
	  $this->data[] = $data_array[$i];
	}
  }
  
  /*
  params:
  -none-
  */
  public function show_array() {
    $return = '<table rules="all" style="border-collapse: collapse;"><tr>';
	foreach ($this->headers as $head) {
	  $return .= '<td>'.$head.'</td>';
	}
	$return .= '</tr>';
	foreach ($this->data as $row) {
	  $return .= '<tr>';
	  foreach ($row as $data) {
	    $return .= '<td>'.$data.'</td>';
	  }
	  $return .= '</tr>';
	}
	$return .= '</table>';
    return $return;
  }
  
  /*
  params:
  $path - folder w ktorym zostanie zapisany plik
  $file - nazwa pliku
  */
  public function export($path,$file) {
    if (!is_dir($path)) {
	  mkdir($path);
	}
	foreach ($this->headers as $head) {
	  $return .= $head.';';
	}
	foreach ($this->data as $row) {
	  $return .= "\n";
	  foreach ($row as $data) {
	    $return .= $data.';';
	  }
	}
	
    $filename = $path.'/'.$file.'.csv';
    $file=fopen($filename, "w+");
    fwrite($file, $return);
    fclose($file);
    echo('<iframe width=0 height=0 src="'.$filename.'"></iframe><a href="'.$filename.'">Pobierz plik</a>');
    return true;
  }
}

$test_data = array(
	array(1,2,3,4,5,6,7,8,9,0),
	array(11,22,33,44,55,66,77,88,99,00),
	array(1,2,3,4,5,6,7,8,9,0)	
);

$export = new export($test_data);
$export->export('temp','search');

?>