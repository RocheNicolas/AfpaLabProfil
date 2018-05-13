<?php
// List of classes needed for this class
require_once "Initialize.php";

Class MailManager extends Initialize
{

	public $result;
	private $name;
	private $email_sender;
	private $subject;
	private $content;
	private $email_delivery;
	private $id_delivery;

	public function __construct()
	{
		// SESSION
		 session_start();
		// Call Parent Constructor
		parent::__construct();

		// init variables result
		$this->result = [];
		$this->name = $this->VARS_HTML["name"];
		$this->email_sender = $this->VARS_HTML["email_sender"];
		$this->subject = $this->VARS_HTML["subject"];
		$this->content = $this->VARS_HTML["content"];
		$this->id_delivery = $this->VARS_HTML["id"];

		// execute main function
		$this->main();
	}

	public function __destruct()
	{
		parent::__destruct();
	}

	public function verifyEmail(){
		if(preg_match( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $this->email_sender)){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * [Get the delivery adress in DB]
	 * @return [string] [email adress]
	 */
	private function getDeliveryEmail() {
		$spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "select_delivery_email.sql";
	
		$this->result["liste_emails"] = $this->obj_bdd->getSelectDatas(
			$spathSQLSelect,
			array(
				'id_utilisateur' => $this->id_delivery
			), 
			0
		);
		
		$this->email_delivery= $this->result["liste_emails"][0]["courriel_utilisateur"];
	}

	/**
	 * Send mail with posted datas
	 **/

	public function sendEmail(){

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $this->email_sender)){
			$new_line = "\r\n";
		}else{
			$new_line = "\n";
		}

		//===== Set Message Content
		$message_txt = $this->content;
		$message_html = "<html><head></head><body>".$this->content."</body></html>";
		//==========

		//=====Boundary Création
		$boundary = "-----=".md5(rand());
		//==========

		//=====Set subject.
		$sujet = $this->subject;
		//=========

		//=====Header Creation.
		$header = "From: \"".$this->name."\"<".$this->email_sender.">".$new_line;
		$header.= "Reply-to: \"Admin\" <".$this->email_delivery.">".$new_line;
		$header.= "MIME-Version: 1.0".$new_line;
		$header.= "Content-Type: multipart/alternative;".$new_line." boundary=\"$boundary\"".$new_line;
		//==========

		//=====Message Creation.
		$message = $new_line."--".$boundary.$new_line;
		//=====Set text type TEXT
		$message.= "Content-Type: text/plain; charset=\"utf-8\"".$new_line;
		$message.= "Content-Transfer-Encoding: 8bit".$new_line;
		$message.= $new_line.$message_txt.$new_line;
		//==========
		$message.= $new_line."--".$boundary.$new_line;
		//=====Set text type HTML
		$message.= "Content-Type: text/html; charset=\"utf-8\"".$new_line;
		$message.= "Content-Transfer-Encoding: 8bit".$new_line;
		$message.= $new_line.$message_html.$new_line;
		//==========
		$message.= $new_line."--".$boundary."--".$new_line;
		$message.= $new_line."--".$boundary."--".$new_line;
		//==========

		//=====Send Email.
		mail($this->email_delivery,$sujet,$message,$header);
	//==========
	}

	/**
	 * Call needed functions to check datas, get email_delivery and send email.
	 * @return [json array]
	 */
	public function main(){
		
		// Display an error message if there is at least one empty field
		if(!isset($this->name)||!isset($this->email_sender)||!isset($this->subject)||!isset($this->content)){

			$result[0] = array(
				'error' => 0, 
				'texte' => "Veuillez remplir tous les champs"
				);
		 
		 }else{
		 	$this->verifyEmail();
		 }

		 // If all fields are complete...
		if(!empty($_POST)){
			error_log("verifyEmail = " . $this->verifyEmail() );

			// Check for email error...
			if($this->verifyEmail()===false){
				$result[0] = array(
						'error' => 0, 
						'texte' =>  "Adresse courriel invalide."	
					);

			// Else check again for empty field
			}else if(empty($this->name) || empty($this->email_sender) || empty($this->subject) ||empty($this->content)){

				$result[0] = array(
						'error' => 0, 
						'texte' =>  "Veuillez remplir tous les champs."	
					);

			}else{

				$this->getDeliveryEmail();

				error_log("email_delivery = " . $this->email_delivery );
		
				if (!empty($this->email_delivery)) {
					
					$this->sendEmail();
					$result = array(
						'error' => 0, 
						'texte' => "Le message a bien été envoyé."
					);
				
				}else{
					$result = array(
						'error' => 1,
						'texte' =>  "Erreur lors de l'envoi du message."	
					);
					
				}
			}		
		}	
		echo json_encode($result);
	}
}

?>
