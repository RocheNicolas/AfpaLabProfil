<?php
// List of classes needed for this class
require_once "Initialize.php";

Class UpdateInfo extends Initialize
{

	public $result;
	private $id_utilisateur;
	private $visibility;
	private $last_name;
	private $first_name;
	private $url_site;
	private $description;

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
		$this->visibility = trim(htmlspecialchars($this->VARS_HTML["visibility"]));
		$this->last_name = trim(htmlspecialchars($this->VARS_HTML["last_name"]));
		$this->first_name =trim(htmlspecialchars($this->VARS_HTML["first_name"]));
		$this->url_site = trim(htmlspecialchars($this->VARS_HTML["url_site"]));
		$this->description = trim(htmlspecialchars($this->VARS_HTML["description"]));

		$this->updateInfo();

		echo json_encode($this->result);
	} // end of private function main()

	

	private function updateInfo(){
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "update_stagiaire_info.sql";
	
		
		$this->obj_bdd->treatDatas(
			$spathSQLSelect,
			array(
				"id_utilisateur" => $this->id_utilisateur,
				"active_utilisateur" => $this->visibility,
				"nom_utilisateur" => $this->last_name,
				"prenom_utilisateur" => $this->first_name,
				"site_utilisateur" => $this->url_site,
				"description_utilisateur" => $this->description,
				),
				0
			);
		
	}

}

?>