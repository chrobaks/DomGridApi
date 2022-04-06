<?php
/**
 * Database Class PDOHandler
 * --------------------------------------------------------------
 * 
 */

 class PDOHandler 
 {
    private static $instance;
    private $error;
    public $DB;

    public function __construct () 
    {
        $this->error = [];

        try {
            $host =  "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
            // Set Instance & attributes
            $this->DB = new PDO( $host, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8' COLLATE utf8_unicode_ci") );
            $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e)
        {
            if (!empty($e->getMessage())) {
                $this->error[] = $e->getMessage();
                print_r( $e );
            }
        }
    }

    public static function get_instance(){
        if( ! isset(self::$instance)){self::$instance = new PDOHandler();}

        return self::$instance;
    }

    public function getError ()
    {
        return $this->error;
    }
 }
