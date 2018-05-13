<?php
// List of classes needed for this class
require_once "Initialize.php";
require_once "Crypting.php";

/**
 * Class ForgotPasswordSendMail
 */
class ForgotPasswordSendMail extends Initialize
{
	/**
	 * @var array
	 */
	public $result;
	/**
	 * @var string contains the user firstname and lastname concatenation
	 */
	private $sUserName;

	/**
	 * ForgotPasswordSendMail constructor.
	 */
	public function __construct()
	{
		// Call Parent Constructor
		parent::__construct();

		// init variables result
		$this->result = [
				"success" => 0,
				"unknow_mail" => 0,
				"previous_request" => 0
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
		$id_utilisateur = $this->verify_mail();
		if ($id_utilisateur) {
			$bPreviousRequest = $this->verify_previous_request($id_utilisateur);
			if (!$bPreviousRequest) {
				$cle_mdp_oublie = $this->generate_key();
				$bInsertRequest = $this->insert_password_request($id_utilisateur, $cle_mdp_oublie);
				if ($bInsertRequest) {
					$this->send_mail($cle_mdp_oublie);
					$this->result["success"] = 1;
				}
			} else {
				$this->result["previous_request"] = 1;
			}
		} else {
			$this->result["unknow_mail"] = 1;
		}

		echo json_encode($this->result);
	} // end of private function main()

	/**
	 * @return int|bool the user id if the mail exist or false
	 */
	private function verify_mail()
	{
		$sPathSQL = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "global_select_user_forgot_password.sql";
		$mail = $this->VARS_HTML["courriel_utilisateur"];
		$req = $this->obj_bdd->getSelectDatas($sPathSQL, ["courriel_utilisateur" => $mail], true);
		if ($req) {
			$this->sUserName = $req[0]["prenom_utilisateur"] . " " . $req[0]["nom_utilisateur"];
			return $req[0]["id_utilisateur"];
		} else {
			return false;
		}
	}

	/**
	 * @param $id_utilisateur int the user id
	 * @return bool
	 */
	private function verify_previous_request($id_utilisateur)
	{
		$sPathSQL = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "global_select_previous_request_password.sql";
		$req = $this->obj_bdd->getSelectDatas($sPathSQL, ["id_utilisateur" => $id_utilisateur], true);
		if ($req) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return string the encrypted key for the request authentication
	 */
	private function generate_key()
	{
		$oCrypting = new Crypting($this->GLOBALS_INI["CRYPTING"]["DEFAULT_KEY"], $this->VARS_HTML["courriel_utilisateur"], true);
		$cle_mdp_oublie = $oCrypting->key;
		$regex = "/[ %#;\/?:@=&	{}|\"^,~\\[\]`'<>+-]/";
		$cle_mdp_oublie = preg_replace($regex, "", $cle_mdp_oublie);
		return $cle_mdp_oublie;
	}

	/**
	 * @param $id_utilisateur int the user id
	 * @param $cle_mdp_oublie string the encrypted key for the request authentication
	 * @return bool
	 */
	private function insert_password_request($id_utilisateur, $cle_mdp_oublie)
	{
		$sPathSQL = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "global_insert_password_key.sql";
		$req = $this->obj_bdd->treatDatas($sPathSQL, [
				"id_utilisateur" => $id_utilisateur,
				"cle_mdp_oublie" => $cle_mdp_oublie
		]);
		if ($req) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @param $cle_mdp_oublie string the encrypted key for the request authentication
	 */
	private function send_mail($cle_mdp_oublie)
	{
		$sMailRecipient = $this->VARS_HTML["courriel_utilisateur"];
		$sMailAdmin = "";

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $sMailAdmin)) {
			$new_line = "\r\n";
		} else {
			$new_line = "\n";
		}

		$sMessageContent = "Bonjour " . $this->sUserName . "," . $new_line . $new_line;
		$sMessageContent .= "Vous avez fait une demande de réinitialisation de mot de passe sur le site AfpaLab.com, si vous êtes l'auteur de cette demande vous pouvez suivre le lien ci-dessous pour la finaliser:" . $new_line . $new_line;
		$sMessageContent .= $_SERVER["SERVER_NAME"] . "/route.php?page=forgotPassword&clemail=" . $cle_mdp_oublie . $new_line . $new_line;
		$sMessageContent .= "Cordialement," . $new_line;
		$sMessageContent .= "L'équipe AfpaLab" . $new_line;

		//===== Set Message Content
		$message_txt = $sMessageContent;
		$message_html = "<html><head></head><body>" . $sMessageContent . "</body></html>";
		//==========

		//=====Boundary Création
		$boundary = "-----=" . md5(rand());
		//==========

		//=====Set subject.
		$sujet = "Réinitialisation du mot de passe - AfpaLab";
		//=========

		//=====Header Creation.
		$header = "From: \"Admin\" <" . $sMailAdmin . ">" . $new_line;
		$header .= "Reply-to: \"Utilisateur\" <" . $sMailRecipient . ">" . $new_line;
		$header .= "MIME-Version: 1.0" . $new_line;
		$header .= "Content-Type: multipart/alternative;" . $new_line . " boundary=\"$boundary\"" . $new_line;
		//==========

		//=====Message Creation.
		$message = $new_line . "--" . $boundary . $new_line;
		//=====Set text type TEXT
		$message .= "Content-Type: text/plain; charset=\"utf-8\"" . $new_line;
		$message .= "Content-Transfer-Encoding: 8bit" . $new_line;
		$message .= $new_line . $message_txt . $new_line;
		//==========
		$message .= $new_line . "--" . $boundary . $new_line;
		//=====Set text type HTML
		$message .= "Content-Type: text/html; charset=\"utf-8\"" . $new_line;
		$message .= "Content-Transfer-Encoding: 8bit" . $new_line;
		$message .= $new_line . $message_html . $new_line;
		//==========
		$message .= $new_line . "--" . $boundary . "--" . $new_line;
		$message .= $new_line . "--" . $boundary . "--" . $new_line;
		//==========

		//=====Send Email.
		mail($this->VARS_HTML["courriel_utilisateur"], $sujet, $message, $header);
		//==========
	}
}
