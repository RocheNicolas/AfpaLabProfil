<?php
// List of classes needed for this class
require_once "Initialize.php";

Class UpdateTechno extends Initialize
{

	public $result;
	private $id_utilisateur;
	private $aTechno;

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
		$this->id_utilisateur = $this->VARS_HTML["id_utilisateur"];
		$this->aTechno = [];
		$this->explodeListTechno();
		$this->deleteTechno();
		$this->insertTechno();
		echo json_encode($this->result);
	} // end of private function main()

	private function explodeListTechno(){
		$aExplode = explode("/",$this->VARS_HTML["techno"]);
		foreach ($aExplode as $key => $value) {
			$this->aTechno[$key] = explode(",", $aExplode[$key]);
			if($this->aTechno[$key][0] === ""){
				unset($this->aTechno[$key]);
			}
		}
	}

	private function deleteTechno(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "delete_stagiaire_techno.sql";
		$this->obj_bdd->treatDatas(
			$spathSQLSelect,
			array(
				"id_utilisateur" => $this->id_utilisateur,
			),
			0
		);
	}

	private function insertTechno(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "insert_stagiaire_techno.sql";
	
		foreach ($this->aTechno as $key => $value) {
			$this->obj_bdd->treatDatas(
				$spathSQLSelect,
				array(
					"id_utilisateur" => $this->id_utilisateur,
					"id_technologie" => $this->aTechno[$key][1]
				 ),
				0
			);
		}
	}

}

?>