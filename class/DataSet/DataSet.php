<?php

/**
 * Class for managing datasets
 * 
 * This is the file that provides the core of the behavior for the application.
 * The class encapsulates the details of working with the datasets, which
 * are in a PostGIS database.
 * 
 * @package CPWFTargetingOutscaling
 * @subpackage Server
 * @author Eric Kemp-Benedict (eric.kemp-benedict@sei-international.org)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @copyright 2012-2013 Stockholm Environment Institute and Challenge Program on Water and Food
 */

/**
 * Define a custom exception class
 */
class DataSetException extends Exception {
    
}

/**
 * Provide an interface to datasets, and maintain a list of datasets
 *
 */
class DataSet {

    //--------------------------------------------
    //
    // Class properties
    //
    //--------------------------------------------
    /**
     * Fully qualified path to the collection of GeNIe Bayesian network files (.xdsl format)
     * @static
     */
    private static $xdsl_path = '';

    /**
     * Pointer to the current database connection (or null)
     * @static
     */
    private static $dbconn = null;

    /**
     * Array of database information
     * 
     * Has elements "dbname", "user", "pwd", "host"
     * 
     * @static
     */
    private static $db_info = array();

    /**
     * Information about where "generic" information is stored in the PostGIS database
     * 
     * Has elements "schema" and "inference_function"
     * 
     * @static
     */
    private static $generic_info = array();

    /**
     * Default values for variable instances--can be overridden when the dataset is defined
     * @static
     */
    private static $instance_defaults = array(
        'default_locale' => 'en_EN',
        'resolutions' => array(
            'low' => 0.1,
            'med' => 1.0,
            'high' => 5.0
        ),
        'gid_col' => 'gid',
        'geom_col' => 'geom',
        'meta_table' => 'meta',
        'bayes_table' => 'bayes_variables',
        'success_node' => 'success',
        'success_value' => 'yes'
    );

    //--------------------------------------------
    //
    // Class methods
    //
    //--------------------------------------------

    /**
     * Connect to the database, optionally passing db parameters
     * 
     * @param array $new_dbinfo
     * @return PDO
     * @throws DataSetException 
     */
    public static function connect($new_dbinfo = NULL) {
        if (!is_null($new_dbinfo)) {
            self::$db_info = $new_dbinfo;
        }

        $db = self::$db_info;

        $pdo_string = sprintf("pgsql:dbname=%s;user=%s;password=%s;host=%s", $db['dbname'], $db['user'], $db['pwd'], $db['host']);
        try {
            $dbconn_try = new PDO($pdo_string);
            self::$dbconn = $dbconn_try;
        } catch (PDOException $e) {
            self::$dbconn = null;
            throw new DataSetException($e->getMessage());
        }
        return self::$dbconn;
    }

    /**
     * Set the default database connection information
     * 
     * @param array $new_dbinfo 
     */
    public static function set_db_info($new_dbinfo) {
        self::$db_info = $new_dbinfo;
    }

    /**
     * Get or set the information about where "generic" settings are in the database
     * 
     * @param array $new_generic_info
     * @return array
     */
    public static function generic_info($new_generic_info = null) {
        if (!is_null($new_generic_info)) {
            self::$generic_info = $new_generic_info;
        }
        return self::$generic_info;
    }

    /**
     * Reconnect the database
     * 
     * @return object Database connection object or null if none defined
     */
    public static function reconnect() {
        self::disconnect();
        $info = self::$db_info;
        if (isset($info['dbname'])) {
            return self::connect();
        } else {
            return null;
        }
    }

    /**
     * A convenience function: set the database object to null
     */
    public static function disconnect() {
        self::$dbconn = null;
    }

    /**
     * Get the current database connection, if set
     * 
     * @return object
     * @throws DataSetException 
     */
    public static function get_connection() {
        $db = self::$dbconn;
        // If this isn't null or isn't active (so the no-op SELECT below returns throws an error) try to reconnect, otherwise die
        if (!$db || $db->exec('SELECT 1;') === false) {
            // Maybe we lost the connection
            $db = self::reconnect();
            if (!$db) {
                throw new DataSetException('Database connection does not exist');
            }
        }
        return $db;
    }

    /**
     * Get array of dataset-specific variables to make available on the map
     * 
     * @return array 
     */
    public function get_display_vars() {
        $info = $this->get_dataset_info();
        if (isset($info['to_display'])) {
            return $info['to_display'];
        } else {
            return array();
        }
    }

    /**
     * Return an array with the "properties" array of each dataset
     * 
     * @return array
     */
    public function get_dataset_info() {
        return $this->props;
    }

    /**
     * Get or set the default locale
     * 
     * These are specified as language_LOCATION, as in "en_EN", "en_US", "fr_FR", etc.
     * 
     * @param string $new_default
     * @return string 
     */
    public static function default_locale($new_default = null) {
        if ($new_default) {
            self::$default_locale = $new_default;
        }
        return self::$default_locale;
    }

    /**
     * Get or set the xdsl path
     * 
     * @param string $new_xdsl_path
     * @return string 
     */
    public static function xdsl_path($new_xdsl_path = null) {
        if ($new_xdsl_path) {
            self::$xdsl_path = $new_xdsl_path;
        }
        return self::$xdsl_path;
    }

    /**
     * Execute a query for the PostGIS database
     * 
     * @param string $sql The string to query
     * @return object Executed PDO query object
     * @throws DataSetException 
     */
    private static function exec_query($sql) {
        $db = self::get_connection();
        $prep_query = $db->prepare($sql);
        $result = $prep_query->execute();
        if ($result === false) {
            throw new DataSetException(var_dump($prep_query->errorInfo()));
        }
        return $prep_query;
    }

    /**
     * Get the contents of the "meta" table for the active dataset from the PostGIS database
     * 
     * @param string $table Name of the meta table (normally default to null)
     * @return array
     * @throws DataSetException 
     */
    public static function get_meta($table = null) {
        if (!$table) {
            $ds = self::active_dataset();
            $table = $ds->prop('schema') . '.' . $ds->prop('meta_table');
        }
        try {
            $meta = self::exec_query('SELECT * FROM ' . $table);
        } catch (PDOException $e) {
            throw new DataSetException($e->getMessage());
        }

        return $meta->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Return result of running the Bayes inference function on the dataset
     * 
     * @param array $set_val_array checklist to update user defined value
     * @param float $resolution Second parameter in a call to ST_SimplifyPreserveTopology(table,resolution)<
     * @return object PDO query object
     * @throws DataSetException 
     * @todo remove anything related to checklist
     */
    public function get_data($set_val_array = null, $resolution = null) {
        if (!$resolution) {
            $resolution = $this->resolution();
        }

        // Get the fully qualified table name
        $table = $this->prop('schema') . '.' . $this->prop('bayes_table');
        /// $schema = $this->prop('schema');
        $generic_schema = self::$generic_info['schema'];
        $smile_func = self::$generic_info['inference_function'];
        $xdsl_path = $this->get_xdsl_path();
        $gid = $this->prop('gid_col');
        $geom = $this->prop('geom_col');
        $success_node = $this->prop('success_node');
        $success_value = $this->prop('success_value');
        $result = $this->prop('result_col');

        $tmp_table = uniqid('temp_');

        try {
            self::exec_query('SELECT * INTO TEMPORARY ' . $tmp_table . ' FROM ' . $table);

            if ($set_val_array) {
                $set_key_array = array();
                $set_list = array();

                foreach ($set_val_array as $key => $val) {
                    $new_key = ':' . $key;
                    $set_list[] = $key . '=' . $new_key;
                    $set_key_array[$new_key] = $val;
                }
                self::exec_query('UPDATE ' . $tmp_table . ' SET ' . implode(',', $set_list) . ';', $set_key_array);
            }

            $other_var_string = '';
            foreach ($this->prop('to_display') as $var) {
                $other_var_string .= $tmp_table . '."' . $var . '",';
            }

            $query = <<<QUERY
SELECT $other_var_string $tmp_table.$gid,
    ST_AsGeoJSON(ST_Transform(ST_SimplifyPreserveTopology($tmp_table.$geom,$resolution), 4326)) AS $geom,
    $generic_schema.$smile_func('$xdsl_path', '$success_node', '$success_value', $tmp_table) AS $result
FROM $tmp_table;
QUERY;

            return self::exec_query($query);
        } catch (PDOException $e) {
            throw new DataSetException($e->getMessage());
        }
    }

    /**
     * Dataset-specific properties
     * 
     * @var array 
     */
    private $props = array();

    /**
     * Constructor
     * 
     * @param string $schema The schema within the database that holds this dataset
     * @param string $xdsl Name of the GeNIe Bayesian network model file, in .xdsl format (no path)
     * @param array $other_props Properties to override defaults
     */
    function __construct($schema, $xdsl, $other_props) {
        $this->props = array(
            'schema' => $schema,
            'xdsl' => $xdsl
        );

        self::connect();
        if (isset($other_props['meta_table'])) {
            $meta_table = $other_props['meta_table'];
        } else {
            $meta_table = self::$instance_defaults['meta_table'];
        }
        $meta = self::get_meta($schema . '.' . $meta_table);

        $this->props['iso2'] = $meta['iso2'];
        $this->props['center_ll'] = $meta['center_lon'] . ',' . $meta['center_lat'];
        $this->props['name'] = $meta['name'];
        self::disconnect();

        // Set to defaults
        foreach (self::$instance_defaults as $key => $val) {
            $this->props[$key] = $val;
        }

        // Potentially override defaults
        foreach ($other_props as $key => $val) {
            $this->props[$key] = $val;
        }

        // These hold the same value, differentiated for semantic reasons
        $this->props['result_col'] = $this->props['success_node'];
    }

    /**
     * Get or set a specific property array element
     * 
     * @param string $prop The property to query (e.g., 'schema')
     * @param mixed $new The new value for the property, if setting
     * @return mixed Value of the property 
     */
    public function prop($prop, $new = null) {
        if ($new) {
            $this->props[$prop] = $new;
        }
        if (isset($this->props[$prop])) {
            return $this->props[$prop];
        } else {
            return null;
        }
    }

    /**
     * Return the fully qualified path to the current GeNIe Bayesian network file, in .xdsl format
     * 
     * @return string Fully qualified path
     * @throws DataSetException 
     */
    public function get_xdsl_path() {
        // Need to make sure there is one and only one slash between the path and the filename
        $fname = rtrim(self::$xdsl_path, '/') . '/' . ltrim($this->props['xdsl'], '/');
        if (file_exists($fname)) {
            return $fname;
        }

        // Not found, try with an extension
        $fname = rtrim($fname, '.') . '.xdsl';
        if (file_exists($fname)) {
            return $fname;
        }

        throw new DataSetException('File "' . $this->props['xdsl'] . '" does not exist on path "' . self::$xdsl_path . '"');
    }

}

?>
