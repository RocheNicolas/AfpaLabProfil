<?php
// List of classes needed for this class
require_once "Initialize.php";
require_once "Crypting.php";

Class Connexion extends Initialize
{

	public $result;
	private $aUserData;
	private $error;
	
	public function __construct()
	{
		// SESSION
		 session_start();
		// Call Parent Constructor
		parent::__construct();

		// init variables result
		$this->result = [
				"success" => 0,
				"unvalid_mail" => 0,
				"connection_fail" => 0
		];

		// execute main function
		$this->main();
	}

	public function __destruct()
	{
		parent::__destruct();
	}

	private function main()
	{
		$sLoginMail = $this->VARS_HTML["login_mail"];
		$sLoginPassword = $this->VARS_HTML["login_password"];
		$bCookie = $this->VARS_HTML["remember_me"];

		$bValidMail = filter_var($sLoginMail,FILTER_VALIDATE_EMAIL);
		$sEncryptedPassword = $this->encrypt_password($sLoginPassword);
		
		if($bValidMail) {
			$bValidConnect = $this->validate_connection($sLoginMail, $sEncryptedPassword);
			if ($bValidConnect) {
				$this->set_session_vars();
				if ($bCookie) {
					$this->set_connection_cookie();
				}
				$this->result["success"] = 1;
			} else {
				$this->result["connection_fail"] = 1;
			}
		} else {
			$this->result["unvalid_mail"] = 1;
		}

		echo json_encode($this->result);
	} // end of private function main()
	
	private function encrypt_password($sLoginPassword) {
		$oCrypting = new Crypting($this->GLOBALS_INI["CRYPTING"]["DEFAULT_KEY"],$sLoginPassword);
		return $oCrypting->key;
	}
	
	private function validate_connection($sLoginMail, $sEncryptedPassword) {
		$sPathSQL = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "global_select_connection.sql";
		$this->aUserData = $this->obj_bdd->getSelectDatas($sPathSQL, [
				"mdp_utilisateur" => $sEncryptedPassword,
				"courriel_utilisateur" => $sLoginMail 
			]);
		if ($this->aUserData) {
			return true;
		} else {
			return false;
		}
	}
	
	private function set_session_vars() {
		$_SESSION['cle_utilisateur'] = $this->aUserData[0]['cle_utilisateur'];
		$_SESSION['pseudo_utilisateur'] = $this->aUserData[0]['pseudo_utilisateur'];
		$_SESSION['courriel_utilisateur'] = $this->aUserData[0]['courriel_utilisateur'];
		$_SESSION['mdp_utilisateur'] = $this->aUserData[0]['mdp_utilisateur'];
		$_SESSION['niveau_utilisateur'] = $this->aUserData[0]['id_niveau'];
	}
	
	private function set_connection_cookie() {
		setcookie('courriel_utilisateur',$this->aUserData[0]['courriel_utilisateur'],time()+365*24*3600,null,null,false,true);       // time = temps d'expiration (pour 1 an)
		setcookie('mdp_utilisateur',$this->aUserData[0]['mdp_utilisateur'],time()+365*24*3600,null,null,false,true);       // time = temps d'expiration (pour 1 an)
	}
}

?>
