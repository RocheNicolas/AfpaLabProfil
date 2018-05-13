<?php
// List of classes needed for this class
require_once "Initialize.php";

Class Ressources extends Initialize
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
		$this->result["headTitle"] = "Ressources";
		$this->get_list_technologie();
	} // end of private function main()

	private function get_list_technologie() {
		$sPathSQL = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "ressource_select_technologie.sql";
		$this->result += ["liste_technologie" => $this->obj_bdd->getSelectDatas($sPathSQL, null, 0)];
	}
}
