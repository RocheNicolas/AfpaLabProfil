<?php

/**
 * Class Db Class for the connection to the DB
 */
Class Db	{

	/**
	 * @var mysqli contain the database handle
	 */
	private $hbdd;

	/**
	 * Db constructor.
	 * @param $host string database host name
	 * @param $login string database username
	 * @param $psw string user password
	 * @param $name string database name
	 */
	public function __construct($host, $login, $psw, $name)	{
		// Connection to DB : SERVEUR / LOGIN / PASSWORD / NOM_BDD
		$this->hbdd= mysqli_connect($host, $login, $psw, $name);
	}

	/**
	 *
	 */
	public function __destruct()	{
		mysqli_close($this->hbdd);
	}

	/**
	 * @return int the last insert id
	 */
	public function getLastInsertId()	{
		return $this->hbdd->insert_id;
	}

	/**
	 * @param $spathSQL string the sql file, which contain the request, path
	 * @param $data array associative contains the data and the key to place them in the request
	 * @param $bForJS bool escape caracter for JS use
	 * @return array contain all the selected data
	 */
	public function getSelectDatas($spathSQL, $data=array(), $bForJS)	{
		// content of SQL file
		$sql= file_get_contents($spathSQL);

		// replace variables @variable from sql by values of the same variables'name
		foreach ($data as $key => $value) {
			$value= str_replace("'", "__SIMPLEQUOT__", $value);
			$value= str_replace('"', '__DOUBLEQUOT__', $value);
			$value= str_replace(";", "__POINTVIRGULE__", $value);
			$value= str_replace('__APOSTROPHE__', '"', $value);
			$sql = str_replace('@'.$key, $value, $sql);
			//error_log("key = " . $key . " | " . "value= " . $value. " | " . "sql = " . $sql);
		}
		
		error_log("getSelectDatas = " . str_replace("\n", " ", str_replace("\r", " ", str_replace("\t", " ", $sql) ) ) );
		// Execute la requete
		$results_db= $this->hbdd->query($sql);

		$resultat= [];
		while ($ligne = mysqli_fetch_array($results_db, MYSQLI_ASSOC)) {
			$new_ligne= [];
			foreach ($ligne as $key => $value) {
				//error_log("getSelectDatas DETAILS = " . $key . " => " . $value);
				if ((isset($bForJS)) && ($bForJS == 1))	{
					$value= str_replace("__SIMPLEQUOT__", "'", $value);
					$value= str_replace('__DOUBLEQUOT__', '\"', $value);
					$value= str_replace("__POINTVIRGULE__", ";", $value);
				}  else  {
					$value= str_replace("__SIMPLEQUOT__", "'", $value);
					$value= str_replace('__DOUBLEQUOT__', '"', $value);
					$value= str_replace("__POINTVIRGULE__", ";", $value);
				}
				$new_ligne[$key]= $value;
			}
			$resultat[]= $new_ligne;
		}

		return $resultat;
	}

	/**
	 * @param $spathSQL string the sql file, which contain the request, path
	 * @param $data array associative contains the data and the key to place them in the request
	 * @return bool|mysqli_result the result of the treatement
	 */
	public function treatDatas($spathSQL, $data=array())	{
		// content of SQL file
		$sql= file_get_contents($spathSQL);

		// replace variables @variable from sql by values of the same variables'name
		foreach ($data as $key => $value) {
			$value= str_replace("'", "__SIMPLEQUOT__", $value);
			$value= str_replace('"', '__DOUBLEQUOT__', $value);
			$value= str_replace(";", "__POINTVIRGULE__", $value);
			$value= str_replace('__APOSTROPHE__', '"', $value);
			$sql= str_replace('@'.$key, $value, $sql);
		}

		error_log("treatDatas = " . str_replace("\n", " ", str_replace("\r", " ", str_replace("\t", " ", $sql) ) ) );
		// Execute la requete
		$results_db= $this->hbdd->query($sql);

		return $results_db;
	}

}
