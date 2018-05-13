<?php
// List of classes needed for this class
require_once "Initialize.php";

Class Profil extends Initialize
{

	public $result;
	private $id_utilisateur;

	public function __construct()
	{
		// SESSION
		 session_start();
		// Call Parent Constructor
		parent::__construct();

		// init variables result
		$this->result = [];

		// execute main function
		$this->main();
	}

	public function __destruct()
	{
		parent::__destruct();
	}

	private function main()
	{
		$this->result["headTitle"] = "Profil";
		$this->result["libJs"][0] = "update_profil";
		$this->id_utilisateur = 61;
		$this->selectDataStagiaire();
		$this->selectRS();
		$this->selectRSStagiaire();
		$this->selectTechno();
		$this->selectTechnoStagiaire();
		// echo "<pre>";
		// var_dump($this->result["data_stagiaire_techno"]);
		// echo "</pre>";
	} // end of private function main()

	private function selectDataStagiaire(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire_profil.sql";

		$this->result["data_stagiaire"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(),
			0
		);
	}

	private function selectRSStagiaire(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire_profil_rs.sql";

		$this->result["data_stagiaire_rs"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(),
			0
		);
	}

	private function selectTechnoStagiaire(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire_techno.sql";
		$this->result["data_stagiaire_techno"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(
				"id_utilisateur" => $this->id_utilisateur),
			0
		);
	}

	private function selectRS(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_rs.sql";

		$this->result["rs"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(),
			0
		);			
	}
	
	private function selectTechno(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_techno.sql";

		$this->result["techno"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(),
			0
		);			
	}		
}

?>
