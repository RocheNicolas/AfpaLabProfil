<?php
	require_once 'Stagiaires.php';

	class MailManager extends Initialize{

		private $name;
		private $email_sender;
		private $subject;
		private $content;
		private $email_delivery;
		private $id_delivery;
		public $aResult;

		public function __construct($name, $email_sender, $subject, $content){

		}

		/**
		 * Verify email format
		 * @return boolean
		 **/
		
		public function verifyEmail(){
			if(preg_match( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $this->email_sender)){
				return true;
			}
		}
		/**
		 * [Get the delivery adress in DB]
		 * @return [string] [email adress]
		 */
		private function getDeliveryEmail() {
			$spathSQLSelect = $this->GLOBALS_INI["PATH_HOME"] . $this->GLOBALS_INI["PATH_MODEL"] . "select_delivery_email.sql";
		
			$this->email_delivery = $this->obj_bdd->getSelectDatas(
				$spathSQLSelect,
				array('id' => $_POST['id']), 
				0
			);
		}

		/**
		 * Send mail with posted datas
		 **/

		public function sendEmail(){
			$email_delivery = "contact_form@yopmail.com";

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
			$header = "From: \"".$this->name."\"<".$this->email.">".$new_line;
			$header.= "Reply-to: \"Admin\" <".$email_delivery.">".$new_line;
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
			mail($email_delivery,$sujet,$message,$header);
		//==========
		}

		/**
		 * Call needed functions to check datas, get email_delivery and send email.
		 * @return [json array]
		 */
		public function main(){
			
			// Display an error message if there is at least one empty field
			if(!isset($this->name)||!isset($this->email_sender)||!isset($this->subject)||!isset($this->content)){

				$array_res[0] = array(
					'error' => 0, 
					'texte' => "Veuillez remplir tous les champs"
					);
			 
			 }else{
			 	$this->verifyEmail();
			 }

			 // If all fields are complete...
			if(!empty($_POST)){
				
				// Check for email error...
				if($this->verifyEmail()===false){
					
					$aResult["error"] = "Adresse courriel invalide.";	

				// Else check again for empty field
				}else if(empty($this->name) || empty($this->email_sender) || empty($this->subject) ||empty($this->content)){

					$aResult["error"] = "Veuillez remplir tous les champs";	

				}else{
			
					$this->getDeliveryEmail();
			
					if ($this->getDeliveryEmail()===true) {
			
						$this->sendEmail();
						$array_res[0] = array(
							'error' => 0, 
							'texte' => "Le message a bien été envoyé."
						);
					
					}else{
						$array_res[0] = array(
							'error' => 0, 
							'texte' =>  "Erreur lors de l'envoi du message."	
						);
						
					}
				}		
			}	
			echo json_encode($array_res);
		}
	}
?>