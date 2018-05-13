<?php
// List of classes needed for this class
require_once "Initialize.php";

Class Stagiaires extends Initialize
{

	public $result;

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
		$this->result["headTitle"] = "Stagiaires";
		$this->result["libJs"][0] = "owl.carousel";
		$this->result["libJs"][1] = "send_mail";
		$this->result["libJs"][2] = "select_session";

		$this->getFormation();

	} // end of private function main()

	private function getStudent(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire.sql";

		$this->result["liste_stagiaires"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(
				'id_session' => $this->id_session
				),
				0
		);
	}
	private function getFormation(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire_formation.sql";

		$this->result["liste_formation"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(),
			0
		);
	}

	private function getSession(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire_session.sql";

		$this->result["liste_session"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(
				'id_formation' => $this->id_formation
			),
			0
		);		
	}
}

?>
