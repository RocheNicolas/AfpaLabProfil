<?php
// List of classes needed for this class
require_once "Initialize.php";

Class UpdateRS extends Initialize
{

	public $result;
	private $id_utilisateur;
	private $aRS;

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
		$this->aRS = [];
		$this->explodeListRS();
		$this->deleteRS();
		$this->insertRS();
		echo json_encode($this->result);

	} // end of private function main()

	private function explodeListRS(){
		$aExplode = explode("/",$this->VARS_HTML["rs"]);
		foreach ($aExplode as $key => $value) {
			if($aExplode[$key] === ""){
				unset($aExplode[$key]);
			}else{
				$this->aRS[$key] = explode(",", $aExplode[$key]);	
			}
		}
	}

	private function deleteRS(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "delete_rs_stagiaire.sql";
		$this->obj_bdd->treatDatas(
			$spathSQLSelect,
			array(
				"id_utilisateur" => $this->id_utilisateur,
			),
			0
		);
	}

	private function insertRS(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "insert_stagiaire_rs.sql";
	
		foreach ($this->aRS as $key => $value) {
			$this->obj_bdd->treatDatas(
				$spathSQLSelect,
				array(
					"id_utilisateur" => $this->id_utilisateur,
					"id_reseau_social" => $this->aRS[$key][0],
					"url_reseau_social" => $this->aRS[$key][1]
				 ),
				0
			);
		}
	}

}

?>