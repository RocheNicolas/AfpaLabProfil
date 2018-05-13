<?php
// List of classes needed for this class
require_once "Initialize.php";

Class SelectStagiaire extends Initialize
{

	public $result;
	private $id_session;

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
		$this->id_session = $this->VARS_HTML["id_session"];
		$this->getStudent();
		echo json_encode($this->result);		
	} // end of private function main()

	private function getStudent(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire.sql";

		$this->result["liste_stagiaire"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(
				'id_session' => $this->id_session
				),
				0
		);
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire_techno_carousel.sql";

		$this->result["liste_techno"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(
				'id_session' => $this->id_session
				),
				0
		);
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire_rs.sql";

		$this->result["liste_rs"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(
				'id_session' => $this->id_session
				),
				0
		);
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire_doc.sql";

		$this->result["liste_doc"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(
				'id_session' => $this->id_session
				),
				0
		);
	}
}

?>
