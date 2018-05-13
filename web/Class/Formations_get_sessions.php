<?php
// List of classes needed for this class
require_once "Initialize.php";

Class Formations_get_sessions extends Initialize
{

    public $result;
    private $id_formation;

    public function __construct()
    {
        // SESSION
        session_start();
        // Call Parent Constructor
        parent::__construct();

        // init variables result
        $this->result = [];

        // execute main function
        $this->main();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    private function main()
    {
        $this->id_formation = $this->VARS_HTML["id_formation"];
        $this->getSession();
        $this->getTechno();
        $this->getProjet();
        echo json_encode($this->result);
    }


    private function getSession(){
        $spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "formations_get_sessions.sql";

        $this->result["liste_session"] = $this->obj_bdd->getSelectDatas(
            $spathSQLSelect,
            array(
                'id_formation' => $this->id_formation
            ),
            0
        );
    }

    private function getTechno(){
        $spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "formations_get_technos.sql";

        $this->result["liste_techno"] = $this->obj_bdd->getSelectDatas(
            $spathSQLSelect,
            array(
                'id_formation' => $this->id_formation
            ),
            0
        );
    }

    private function getProjet(){
        $spathSQLSelect = $this->GLOBALS_INI["PATHS"]["PATH_HOME"] . $this->GLOBALS_INI["PATHS"]["PATH_MODEL"] . "formations_get_projects.sql";

        $this->result["liste_projet"] = $this->obj_bdd->getSelectDatas(
            $spathSQLSelect,
            array(
                'id_formation' => $this->id_formation
            ),
            0
        );
    }

}
