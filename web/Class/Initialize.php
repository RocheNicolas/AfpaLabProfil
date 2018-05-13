<?php

// List of classes needed for this class
require_once "Configuration.php";
require_once "Db.php";
require_once "Form.php";


/**
 * Class Initialize Main class of the framework
 */
Class Initialize
{
	/**
	 * @var Db instance of the Db class
	 */
	protected $obj_bdd;
	/**
	 * @var Configuration instance of the Configuration class
	 */
	private $obj_conf;
	/**
	 * @var array|bool contains the config.ini parse or false if config.ini isn't found
	 */
	public $GLOBALS_INI;
	/**
	 * @var Form instance of the Form class
	 */
	private $obj_form;
	/**
	 * @var array contains all the $_GET and $_POST var
	 */
	public $VARS_HTML = ["headTitle" => "AfpaLab"];

	/**
	 * Initialize constructor.
	 */
	public function __construct()
	{
		// session_start();
		// Instance of Config
		$this->obj_conf = new Configuration();
		$this->GLOBALS_INI = $this->obj_conf->getGlobalsINI();

		// Instance of BDD
		$this->obj_bdd = new Db($this->GLOBALS_INI["DATABASE"]["DB_HOST"],
				$this->GLOBALS_INI["DATABASE"]["DB_LOGIN"],
				$this->GLOBALS_INI["DATABASE"]["DB_PSW"],
				$this->GLOBALS_INI["DATABASE"]["DB_NAME"]);

		// Instance of Form
		$this->obj_form = new Form();
		$this->VARS_HTML = $this->obj_form->getFormsAndSessionsVariables();
	}

	/**
	 *
	 */
	public function __destruct()
	{
		// destroy Instance of Conf
		unset($this->obj_conf);
		// destroy Instance of Form
		unset($this->obj_form);
		// disconnect of BDD
		// destroy Instance of BDD
		unset($this->obj_bdd);
	}
}
