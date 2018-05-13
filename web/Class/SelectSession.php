<?php
// List of classes needed for this class
require_once "Initialize.php";

Class SelectSession extends Initialize
{

	public $result;
	private $id_formation;

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
		$this->id_formation = $this->VARS_HTML["id_formation"];
		$this->getSession();
		echo json_encode($this->result);
	} // end of private function main()


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
