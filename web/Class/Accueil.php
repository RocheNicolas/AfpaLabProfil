<?php
// List of classes needed for this class
require_once "Initialize.php";

Class Accueil extends Initialize
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
		$this->result["headTitle"] = "Accueil AfpaLab";
	} // end of private function main()
}

?>
