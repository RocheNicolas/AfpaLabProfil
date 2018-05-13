<?php
// List of classes needed for this class
require_once "Initialize.php";

Class UpdateEmail extends Initialize
{

	public $result;
	private $id_utilisateur;
	private $new_email;
	private  $confirm_email;

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
		$this->new_email = $this->VARS_HTML["new_email"];
		$this->confirm_email = $this->VARS_HTML["confirm_email"];

		$this->compareEmail();
		$this->verifyEmail();

		if($this->verifyEmail() === true && $this->compareEmail() === true){
			$this->updateEmail();	
		}
		echo json_encode($this->result);
	} // end of private function main()

	private function compareEmail(){
		if ($this->new_email != $this->new_email) {
			$this->result["error"] = "Veuillez saisir deux adresses identiques.";
			return false;
		}else{
			return true;
		}
	}

	private function verifyEmail(){
		if(preg_match( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $this->new_email)){
			return true;
		}else{
			$this->result["error"] = "L'adresse n'est pas au bon format.";
			return false;
		}
	}

	private function updateEmail(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "update_stagiaire_email.sql";
	
		
		$this->obj_bdd->treatDatas(
			$spathSQLSelect,
			array(
				"id_utilisateur" => $this->id_utilisateur,
				"new_email" => $this->new_email,
				),
				0
			);
		
	}

}

?>