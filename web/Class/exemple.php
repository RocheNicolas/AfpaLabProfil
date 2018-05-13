<?php

// List of classes needed for this class
require_once "initialize.php";

Class Exemple extends Initialize	{
	
	public $aOfAllMyResults;
	private $aOfResExist;

	public function __construct()	{
		// Call Parent Constructor
		parent::__construct();

		// init variables aOfAllMyResults
		$this->aOfAllMyResults= [];

		// execute main function
		$this->main();
	}

	public function __destruct()	{
		// Call Parent Constructor
		parent::__destruct();
	}

	private function checkIfDatasExists() {
		// check if datas already inserted
		$spathSQLSelect = $this->GLOBALS_INI["PATH_HOME"] . $this->GLOBALS_INI["PATH_MODEL"] . "select_etape_donnee.sql";
		$this->aOfResExist = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(
				'id_etape' => $_POST['id_etape'], 
				'id_dossier' => $_POST['id_dossier'], 
				'valeur_donnee' => $_POST['valeur_donnee'], 
				'nom_donnee' => $_POST['nom_donnee']
			), 
			0
		);
	}
	
	private function updateDatasDonnee() {
		// update donnee
		$spathSQLUpdate = $this->GLOBALS_INI["PATH_HOME"] . $this->GLOBALS_INI["PATH_MODEL"] . "update_etape_donnee.sql";
		$this->result["updateDatasDonnee"] = $this->obj_bdd->treatDatas(
			$spathSQLUpdate,
			array(
				'id_etape' => $_POST['id_etape'], 
				'id_dossier' => $_POST['id_dossier'], 
				'valeur_donnee' => $_POST['valeur_donnee'], 
				'nom_donnee' => $_POST['nom_donnee']
			)
		);
	}
	
	private function insertDatasDonnee() {
		// insert donnee
		$spathSQLInsert = $this->GLOBALS_INI["PATH_HOME"] . $this->GLOBALS_INI["PATH_MODEL"] . "insert_etape_donnee.sql";
		$this->result["insertDatasDonnee"] = $this->obj_bdd->treatDatas(
			$spathSQLInsert,
			array(
				'id_etape' => $_POST['id_etape'], 
				'id_dossier' => $_POST['id_dossier'], 
				'valeur_donnee' => $_POST['valeur_donnee'], 
				'nom_donnee' => $_POST['nom_donnee']
			)
		);
		$this->result["id_donnee"]= $this->obj_bdd->getLastInsertId();
	}

	private function main() {
		// check if datas already inserted
		$this->checkIfDatasExists();
		if (count($this->aOfResExist) > 0)	{
			// update donnee
			$this->updateDatasDonnee();
		}  else  {
			// insert donnee
			$this->insertDatasDonnee();
		}
	} // end of private function main()
}

?>
