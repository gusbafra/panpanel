<?php
/**
 * 
 * PANEL CLASSES
 * STATUS: WORKING 
 * TYPE: LIBRARY
 * COMPLETED_AT: 26/09/23
 * VERSION: 0.0.0 
 * UP_TO_DATE: 10/07/23
 * 
 */


class currentUser
{
    private $id;
    public $datapack;

}

class EJS
{
    private $id;
    public $datapack;

}

class db
{
    private $instance;

    private $password;

    public $id;

    private $prohibitedStatements = ["DELETE", "DROP", "TRUNCATE"];

    function __construct(object $pdo, string $pass, int $id)
    {
        $this->instance = $pdo;
        $this->password = $pass;
        $this->id = $id;
    }
    /**
    Set unallowed SQL statements.

    @param $statement: Array or Statement(string) to block.
    @return true on success, error and false on failure. 
    **/
    public function setProhibitedStatements($statement)
    {
        try {
            $this->prohibitedStatements = $statement;
            return true;
        }catch(Exception $e){
            echo $e;
            return false;
        }
        
    }
    private function preventSql($statement) /* SQL ENTRY VALIDATION */
    {
        $prevent = $this->prohibitedStatements;
        switch ($prevent) {

            case null:
            case '':
            case 'default':

                $prohibitedStatements = ["DELETE", "DROP", "TRUNCATE"];
                foreach ($prohibitedStatements as $key) {
                    if (str_contains($statement, $key)) {
                        return false;
                    } else {
                        return true;
                    }
                }
                break;

            default:
                if (is_array($prevent)) {
                    foreach ($prevent as $key) {
                        if (str_contains($statement, $key)) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                } else {
                    if (str_contains($statement, $prevent)) {
                        return false;
                    } else {
                        return true;
                    }
                }
                break;

        }
    }

    /**
    Performs an SQL query and returns it's values.

    @param $query: SQL query to execute.
    @param $return: Type of result fetching.
    @param $pass: Database password.
    @return string: Resulting fetched lines.
    **/
    function query(string $query, string $return, string $pass)
    {

        if ($this->preventSql($query) || !str_contains(strtolower($query), 'SELECT')) {
            return false;
        }

        if (password_verify($this->password, $pass)) {

            $dbPDO = $this->instance;

            try {
                $dbPDO->query($query);
                switch ($return) {
                    case 'FETCH':
                        $result = $dbPDO->fetch();
                        break;

                    case 'FETCHALL':
                        $result = $dbPDO->fetchAll();
                        break;

                    default:
                        $result = null;
                        break;

                }
            } catch (PDOException $e) {

                return 'ERROR:' . $e;

            }

            if (isset($result) && $result !== null) {
                return $result;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }


}