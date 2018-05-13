<?php
// List of classes needed for this class
require_once "Initialize.php";

Class Formations extends Initialize
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
		$this->result["headTitle"] = "Formations";
        $this->result["libJs"][0] = "owl.carousel";
		$this->result["libJs"][1] = "send_mail";
        $this->result["libJs"][2] = "page_formation";

        $this->getFormation();

	} // end of private function main()


    private function getFormation(){
        $spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_stagiaire_formation.sql";

        $this->result["liste_formation"] = $this->obj_bdd->getSelectDatas(
            $spathSQLSelect,
            array(),
            0
        );
    }
}

?>
