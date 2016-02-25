<?php

/**
 * Configuration master file
 * 
 * @package CPWFTargetingOutscaling
 * @subpackage Config
 * @author Eric Kemp-Benedict (eric.kemp-benedict@sei-international.org)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @copyright 2012-2013 Stockholm Environment Institute and Challenge Program on Water and Food
 */

/**
 * Constants class
 * 
 * This is a small class, and is only one of several definitions and commands
 * in the configuration file. Its purpose is to encapsulate constants
 * used elswehere, without polluting the global namespace.
 *  
 */
class Constants {

    private static $config = array(
        "db" => array(
            "local" => array(
                "dbname" => "tagmi",
                "user" => "pgadmin",
                "pwd" => "noodle*ringo",
                "host" => "localhost"
            ),
            "remote" => array(
                "dbname" => "tagmi",
                "user" => "pgadmin",
                "pwd" => "noodle*ringo",
                "host" => "localhost"
            )
        )
    );

    /**
     * Return database connection information
     * 
     * @return array
     */
    public static function db_info() {
        if ($_SERVER['SERVER_NAME'] == 'local-test-server') {
            return self::$config['db']['local'];
        } else {
            return self::$config['db']['remote'];
        }
    }

}

/*
 * Error reporting
 */
ini_set('log_errors', 1);
if (isset($_GET['debug']) && $_GET['debug'] == 'yes') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);
}

/*
 * Load other config files
 */
require_once 'i18n.php';
require_once 'dataSets.php';
//require_once 'checklist.php';


/**
 * Start PHP session
 */
if (!session_start()) {
    die('Error: cannot start PHP session.');
}
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
if (!isset($_SESSION['lang'])) {//default language English
    $_SESSION['lang'] = 'en_EN';
}
/*
 * I18N locale
 */
i18n_init($_SESSION['lang']);
?>
