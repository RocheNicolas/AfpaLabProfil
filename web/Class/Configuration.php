<?php 
Class Configuration	{
	public function getGlobalsINI() {
//		$DOCUMENT_ROOT= $_SERVER{'DOCUMENT_ROOT'};
		$DOCUMENT_ROOT= $_SERVER['DOCUMENT_ROOT'];
		$aOfPaths= explode("/", $DOCUMENT_ROOT);
		for ($i=count($aOfPaths)-1; $i>0; $i--)	{
			$DOCUMENT_ROOT= str_replace($aOfPaths[$i], "", $DOCUMENT_ROOT);
			$DOCUMENT_ROOT= str_replace("//", "/", $DOCUMENT_ROOT);
			if (is_file($DOCUMENT_ROOT . "files/config.ini"))	{
				return parse_ini_file($DOCUMENT_ROOT . "files/config.ini", true);
			}  else if (is_file($DOCUMENT_ROOT . "files/config_dev.ini"))	{
				return parse_ini_file($DOCUMENT_ROOT . "files/config_dev.ini", true);
			}
		}
	}
}

?>
