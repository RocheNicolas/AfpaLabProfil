<?php

/**
 * Class RouteurView call and generate an instance of the class request in VARS_HTML["page"]
 */
Class RouteurView
{
	/**
	 * RouteurView constructor.
	 */
	public function __construct()
	{
		// Class dynamic
		if ((isset($_GET["page"])) && ($_GET["page"] != "")) {
			$sMyClass = $_GET["page"];
		} else {
			if ((isset($_POST["page"])) && ($_POST["page"] != "")) {
				$sMyClass = $_POST["page"];
			} else {
				$sMyClass = "accueil";
			}
		}

		error_log("sMyClass = " . $sMyClass);
		// require the specific module
		require_once "Class/" . ucfirst($sMyClass) . ".php";

		// Instance of the specific module
		$sMyClass = ucfirst($sMyClass);
		$obj_main = new $sMyClass();

		// Prepare and send view
		$page_to_load = "route";
		if ((isset($obj_main->VARS_HTML["bJSON"])) && ($obj_main->VARS_HTML["bJSON"] == 1)) {
			$page_to_load = "empty";
		}
		error_log("page_to_load = " . $page_to_load);
		require_once $obj_main->GLOBALS_INI['PATHS']['PATH_HOME'] . $obj_main->GLOBALS_INI['PATHS']['PATH_VIEW'] . $page_to_load . ".html";

		unset($obj_main);
	}
}
