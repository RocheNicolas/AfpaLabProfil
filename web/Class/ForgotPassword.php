<?php
// List of classes needed for this class
require_once "Initialize.php";

/**
 * Class ForgotPassword
 */
class ForgotPassword extends Initialize
{
	/**
	 * @var array
	 */
	public $result;

	/**
	 * ForgotPassword constructor.
	 */
	public function __construct()
	{
		// Call Parent Constructor
		parent::__construct();

		// init variables result
		$this->result = [];

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
	 * get the right js file to treat forgot password page
	 */
	private function main()
	{
		$this->result["headTitle"] = "Mot de passe oublié";
		$this->result["libJs"] = ["forgot_password"];
	} // end of private function main()
}