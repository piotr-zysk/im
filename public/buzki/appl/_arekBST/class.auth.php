<?php
/*
Klasa ulatwia autoryzacje uzytkownikow na podstawie danych zawartych w tabeli tab_users_all

Umozliwia walidacje na podstawie:

xlevel
xmbid

*/
class auth {
  private $xmbid;
  private $fname;
  private $sname;
  private $level;
  private $idsite;
  private $site;
  private $disabled;
  private $db;
  
  /*
  params:
  $xmbid - id uzytkownika w tabeli tab_users_all
  $db_handle - uchwyt do bazy danych, standardowo $db
  */
  public function __construct($xmbid,$db_handle) {
  	if (!is_numeric($xmbid)) {
	    die('auth_error');
	    return false;
	} else {
	  $this->xmbid = $xmbid;
	  $this->db = $db_handle;
	  $this->get_user_data();
	  return true;
	}
  }
  
  /*
  funkcja pobiera dane z intranetu i zapisuje je. Automatycznie wywolywana przy tworzeniu obiektu.
  */
  private function get_user_data() {
  	if ($query = $this->db->select('SELECT tab_users_all.f_name, tab_users_all.s_name, tab_users_all.xlevel, tab_users_all.IDsite, site.site_name, tab_users_all.disabled FROM tab_users_all JOIN site ON tab_users_all.IDsite = site.id WHERE tab_users_all.id = '.$this->xmbid.';')) {
		$this->fname = $query[0]['f_name'];
		$this->sname = $query[0]['s_name'];
		$this->level = $query[0]['xlevel'];
		$this->idsite = $query[0]['IDsite'];    
		$this->site = $query[0]['site_name'];    
		$this->disabled = $query[0]['disabled'];
		return true;
	} else {
	  return false;
	}	
  }
  
  /*
  Funkcja zwraca dane uzytkownika w postaci tablicy asocjacyjnej.
  */
  public function show_user_data() {
  	$array = array(
	  'f_name' => $this->fname,
	  's_name' => $this->sname,
	  'xlevel' => $this->level,
	  'site' => $this->site,
	  'idsite' => $this->idsite,
	  'disabled' => $this->disabled
	  );
	  return $array;
  }
  
  /*
  Sprawdza czy id oddzialu jest zgodne z tym przekazanym do funkcji
  
  params:
  $req_site_id - id oddzialu
  */
  public function check_site_id($req_site_id) {
    if ($this->idsite == $req_site_id) {
	  return true;
	} else {
	  return false;
	}
  }
  
  /* 
  sprawdza czy uzytkownik jest aktywny w intranecie
  */
  public function is_active() {
    if ($this->disabled != 1) {
	  return true;
	} else {
	  return false;
	}
  }

  /*
  Porownuje poziom agenta z tym przekazanym do funkcji. 
  params:
  $req_level - minimalna wartosc, ktora potrzebuje uzytkownik aby ogladac dana strone
  */
  public function check_level($req_level) {
    if ($this->level >= $req_level && $this->is_active()) {
	  return true;
	} else {
	  return false;
	}
  }
  
  /*
  Zwraca tekstowy odpowiednik posiadanego przez uzytkownika poziomu.
  */
  public function show_level() {
  	switch ($this->level) {
	    case 0: $return = 'guest'; break;
	    case 10: $return = 'CSR messenger read only'; break;
	    case 11: $return = 'CSR default'; break;
	    case 20: $return = 'TL default'; break;
	    case 30: $return = 'TL + quality test score'; break;
	    case 40: $return = 'TL + quality test admin	'; break;
	    case 70: $return = 'BM/adm'; break;
	    case 90: $return = 'IT/BST'; break;
	    default: $return = 'Unknown level'; break;
	}
	return $return;
  }
  
  /*
  Tworzy napis zawierajacy:
  $imie $nazwisko [$tekstowy_level], oddzial $nazwa_oddzialu
  */
  public function create_label() {
  	$return = $this->fname.' '.$this->sname.' ['.$this->show_level().'], oddzial '.$this->site;
  	return $return;
  }
  
  /*
  weryfikuje dostep porownujac posiadany przez uzytkownika $xmbid z przekazana do funkcji tablica
  params:
  $array_of_xmbids - tablica z zapisanymi xmbid osob z uprawnieniami do przegladania danej strony.
  */
  public function check_access($array_of_xmbids) {
  	if (in_array($this->xmbid,$array_of_xmbids) && $this->is_active()) {
	    return true;
	} else {
	  return false;
	}
  }
}
/*
example of use:

include("../../../lib/tww.inc");
$auth = new auth($xmbid,$db);
print_r($auth->create_label());


*/
?>