<?php
// List of classes needed for this class
require_once "Initialize.php";
require_once "Crypting.php";

/**
 * Class ForgotPasswordChange
 */
class ForgotPasswordChange extends Initialize
{
	/**
	 * @var array
	 */
	public $result;
	/**
	 * @var
	 */
	private $id_utilisateur;

	/**
	 * ForgotPasswordChange constructor.
	 */
	public function __construct()
	{
		// Call Parent Constructor
		parent::__construct();

		// init variables result
		$this->result = [
				"success" => 0,
				"unvalid_request" => 0,
				"unvalid_password" => 0,
				"not_match_passwords" => 0
		];

		// execute main function
		$this->main();
	}

	/**
	 *
	 */
	public function __destruct()
	{
		parent::__destruct();
	}

	/**
	 *
	 */
	private function main()
	{
		$sNewPassword = $this->VARS_HTML["mdp_utilisateur"];
		$sConfirmPassword = $this->VARS_HTML["mdp_confirm"];
		$sPasswordKey = $this->VARS_HTML["cle_mdp_oublie"];

		$bPasswordMatchConfirm = $this->compare_password($sNewPassword, $sConfirmPassword);
		$bPasswordMatchRegex = $this->validate_password($sNewPassword);
		$bValidPassword = $bPasswordMatchConfirm && $bPasswordMatchRegex;

		if ($bValidPassword) {
			$bValidRequest = $this->verify_request($sPasswordKey);
			if ($bValidRequest) {
				$bUpdate = $this->update_password($sNewPassword);
				if ($bUpdate) {
					$bDelRequest = $this->delete_request($sPasswordKey);
					if ($bDelRequest) {
						$this->result["success"] = 1;
					}
				}
			}
		}

		echo json_encode($this->result);
	} // end of private function main()

	/**
	 * @param $sNewPassword string the new password send by the user
	 * @return bool
	 */
	private function validate_password($sNewPassword)
	{
		$regex = "/" . $this->GLOBALS_INI["PATTERN"]["PASSWORD"] . "/";
		if (preg_match($regex, $sNewPassword)) {
			return true;
		} else {
			$this->result["unvalid_password"] = 1;
			return false;
		}
	}

	/**
	 * @param $sNewPassword string the new password send by the user
	 * @param $sConfirmPassword string the confirmation of the password
	 * @return bool
	 */
	private function compare_password($sNewPassword, $sConfirmPassword)
	{
		if ($sNewPassword === $sConfirmPassword) {
			return true;
		} else {
			$this->result["not_match_passwords"] = 1;
			return false;
		}
	}

	/**
	 * @param $sPasswordKey string the key to authenticate the request
	 * @return bool
	 */
	private function verify_request($sPasswordKey)
	{
		$sPathSQL = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "global_select_change_password_key.sql";
		$req = $this->obj_bdd->getSelectDatas($sPathSQL, ["cle_mdp_oublie" => $sPasswordKey], true);
		if ($req) {
			$this->id_utilisateur = $req[0]["id_utilisateur"];
			return true;
		} else {
			$this->result["unvalid_request"] = 1;
			return false;
		}
	}

	/**
	 * @param $sNewPassword string the new password send by the user
	 * @return bool
	 */
	private function update_password($sNewPassword)
	{
		$sPathSQL = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "global_update_password.sql";
		$sPasswordEncrypted = new Crypting($this->GLOBALS_INI["CRYPTING"]["DEFAULT_KEY"], $sNewPassword);
		$req = $this->obj_bdd->treatDatas($sPathSQL, [
				"mdp_utilisateur" => $sPasswordEncrypted->key,
				"id_utilisateur" => $this->id_utilisateur
		]);
		if ($req) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param $sPasswordKey string the key to authenticate the request
	 * @return bool
	 */
	private function delete_request($sPasswordKey)
	{
		$sPathSQL = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "global_delete_password_key.sql";
		$req = $this->obj_bdd->treatDatas($sPathSQL, ["cle_mdp_oublie" => $sPasswordKey]);
		if ($req) {
			return true;
		} else {
			return false;
		}
	}

}