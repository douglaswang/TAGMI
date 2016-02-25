<?php

/**
 * Return data from a POST command as gzipped JSON
 * 
 * This is called by index.js. It provides gzipped JSON with two elements:
 * 1) an array of additional variables to display; 2) a GeoJSON feature
 * collection.
 * 
 * @package CPWFTargetingOutscaling
 * @subpackage Server
 * @author Eric Kemp-Benedict (eric.kemp-benedict@sei-international.org)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @copyright 2012-2015 Stockholm Environment Institute and Challenge Program on Water and Food
 * @todo remove anything related to checklist
 */
require_once 'config/config.php';

/**
 * A function that wraps the beahvior of the getData.php file
 * 
 * Finds information about the dataset requested in the POST command, and
 * generates a map at the resolution specified in the POST command. It also
 * passes in the gzipped JSON an array holding the dataset-specific additional
 * variables.
 * 
 */
function generateJSON($pId, $tId, $resolution_code, $includeModification, $modification) {

    $dbcon = DataSet::connect();

    //get country
    $queryGetProject = $dbcon->prepare('SELECT * FROM "generic"."project" WHERE "id"=:pId');
    $queryGetProject->execute(array(':pId' => $pId)) or die('Query error');

    if (count($queryGetProject->rowCount()) != 1) {
        die('ERROR: cannot find record');
    }
    $project = $queryGetProject->fetch();
    $schemaName = $project['schema_name'];
    $resLow = $project['res_low'];
    $resMedium = $project['res_medium'];
    $resHigh = $project['res_high'];


    //get display field
    $queryGetDisplayAttributes = $dbcon->prepare('SELECT * FROM "generic"."display_attribute" WHERE "project_id"=:pId');
    $queryGetDisplayAttributes->execute(array(':pId' => $pId)) or die('Query error');
    $toDisplayList = array();
    if ($_SESSION['lang'] == 'en_EN') {
        $displayName = 'display_name';
        $descriptionName = 'description';
    } else {
        $displayName = 'display_name_fr';
        $descriptionName = 'description_fr';
    }
    foreach ($queryGetDisplayAttributes->fetchAll() as $displayAttribute) {
        $toDisplayList[$displayAttribute[$displayName]] = $displayAttribute['attribute_name'];
    }

    //get technology
    $queryGetTechnology = $dbcon->prepare('SELECT * FROM "generic"."technology" WHERE "id"=:tId');
    $queryGetTechnology->execute(array(':tId' => $tId)) or die('Query error');

    if (count($queryGetTechnology->rowCount()) != 1) {
        die('ERROR: cannot find record');
    }
    $technology = $queryGetTechnology->fetch();

    $dataSet = new DataSet($schemaName, $technology['xdsl_file_name'], array(
        'resolutions' => array(
            'high' => $resHigh,
            'med' => $resMedium,
            'low' => $resLow
        ),
        'to_display' => $toDisplayList
            )
    );

    try {
        $resolution = null;
        if (!is_null($resolution_code)) {
            $resolutions = $dataSet->prop('resolutions');
            if (!is_null($resolutions) && isset($resolutions[$resolution_code])) {
                $resolution = $resolutions[$resolution_code];
            }
        }
        if (is_null($resolution)) {
            $resolution = 10000; // This should make most maps rather chunky, but at least it shouldn't choke
        }


        //need modify the model file
        if ($includeModification) {
            $newModelFile = modifyModelFile($dataSet, $tId, $modification);
            $dataSet->prop('xdsl', $newModelFile);
        }


        $query_get_data = $dataSet->get_data(null, $resolution);
        $display_vars = $dataSet->get_display_vars();

        while ($item = $query_get_data->fetch(PDO::FETCH_ASSOC)) {

            $geom = json_decode($item[$dataSet->prop('geom_col')]);

            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    break;
                case JSON_ERROR_DEPTH:
                    die(' - Maximum stack depth exceeded');
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    die(' - Underflow or the modes mismatch');
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    die(' - Unexpected control character found');
                    break;
                case JSON_ERROR_SYNTAX:
                    die(' - Syntax error, malformed JSON');
                    break;
                case JSON_ERROR_UTF8:
                    die(' - Malformed UTF-8 characters, possibly incorrectly encoded');
                    break;
                default:
                    die(' - Unknown error');
                    break;
            }

            $properties = array(
                "id" => $item[$dataSet->prop('gid_col')],
                "result" => $item[$dataSet->prop('result_col')],
            );
            foreach ($display_vars as $var) {
                $properties[$var] = $item[$var];
            }

            $featureList[] = array(
                "type" => "Feature",
                "geometry" => $geom,
                "properties" => $properties
            );
        }

        $data = array(
            "display" => $display_vars,
            "geojson" => array(
                "type" => "FeatureCollection",
                "features" => $featureList
            )
        );
        ob_start('ob_gzhandler');
        echo json_encode($data);

        ob_end_flush();
    } catch (DataSetException $e) {
        die(var_dump($e->getMessage()));
    }
}

function modifyModelFile(DataSet $dataSet, $tId, $modification) {
    $xdslPath = $dataSet->get_xdsl_path();
    $xml = simplexml_load_file($xdslPath);

    $dbconn = DataSet::get_connection();

    $schemaName = $dataSet->prop('schema');

    $queryGetPrior = $dbconn->prepare(<<<QUERY
SELECT "prior" FROM "$schemaName"."d_prior"
WHERE "indicator"=:indicator ORDER BY "state"
QUERY
    );

    $queryGetParentWeight = $dbconn->prepare(<<<QUERY
SELECT "weight" FROM "$schemaName"."parents_table_fact_indic"
WHERE "parent"=:parent AND "indicator"=:indicator AND "technology_id"=:tId
ORDER BY "state" DESC
QUERY
    );

    //create temporary capital parent table
    $tempCapitalTable = uniqid('temp_');
    $queryCreateCapitalTempTable = $dbconn->prepare(<<<QUERY
SELECT * INTO TEMPORARY "$tempCapitalTable"
FROM "$schemaName"."parents_table_fact_capital"
WHERE "technology_id"=:tId
QUERY
    );
    $queryCreateCapitalTempTable->execute(array(':tId' => $tId));

    $queryUpdateCapitalWeight = $dbconn->prepare(<<<QUERY
UPDATE "$tempCapitalTable" SET "weight"=:weight WHERE "parent"=:parent AND "state"=:state
QUERY
    );

    $queryGetTempCapitalWeight = $dbconn->prepare(<<<QUERY
SELECT "weight" FROM "$tempCapitalTable" 
WHERE "parent"=:parent AND "capital"=:capital ORDER BY "state" DESC
QUERY
    );

    $base = 4;
    foreach ($modification as $key => $node) {
        if (substr($key, 0, 2) == 'D_') {
            //data node
            foreach ($xml->nodes->children() as $child) {//search match node in model file
                if ($child['id'] == $key) {
                    //found a match
                    //user's weighting
                    if ($node == 3) {
                        $userWeightList = array(-1, 0, 1);
                    } else if ($node == 2) {
                        $userWeightList = array(-0.7, 0, 0.7);
                    } else if ($node == 1) {
                        $userWeightList = array(-0.3, 0, 0.3);
                    } else if ($node == -1) {
                        $userWeightList = array(0.3, 0, -0.3);
                    } else if ($node == -2) {
                        $userWeightList = array(0.7, 0, -0.7);
                    } else if ($node == -3) {
                        $userWeightList = array(1, 0, -1);
                    }

                    //get node prior value
                    $queryGetPrior->execute(array(
                                ':indicator' => $key
                            )) or die('query error');
                    If ($queryGetPrior->rowCount() > 0) {
                        $priorList = $queryGetPrior->fetchAll();
                    } else {
                        $priorList = array(
                            array('prior' => 0.333333),
                            array('prior' => 0.333333),
                            array('prior' => 0.333333)
                        );
                    }

                    //get parent field
                    if ($child->parents != null) {
                        $parentWeightList = array();
                        //check how many parents
                        $parentString = $child->parents;
                        $parents = explode(" ", $parentString);
                        //for each parent, get positive and negative weight
                        foreach ($parents as $parent) {
                            $queryGetParentWeight->execute(array(
                                        ':parent' => $parent,
                                        ':indicator' => $key,
                                        ':tId' => $tId
                                    )) or die('query error');
                            $parentWeightList[] = $queryGetParentWeight->fetchAll();
                            if ($queryGetParentWeight->rowCount() == 0)
                                echo $parent . ' - ' . $key . 'A';
                        }

                        $propString = '';

                        for ($index = 0; $index <= pow(2, count($parents)) - 1; $index++) {
                            $tempProbList = array();
                            for ($status = 0; $status < 3; $status++) {
                                $tempParentWeightSum = 0;
                                foreach ($parents as $parentIndex => $parent) {
                                    $pOrN = ($index & pow(2, count($parents) - $parentIndex - 1)) > 0 ? 1 : 0;
                                    $tempParentWeightSum+= $parentWeightList[$parentIndex][$pOrN]['weight'];
                                }
                                $tempProbList[] = $priorList[$status]['prior'] * pow($base, $userWeightList[$status] * $tempParentWeightSum);
                            }

                            for ($status = 0; $status < 3; $status++) {
                                $propString.= $tempProbList[$status] / array_sum($tempProbList) . ' ';
                            }
                        }

                        $propString = trim($propString);

                        //update node
                        $child->probabilities = $propString;
                    } else {
                        die('cannot find parent node');
                    }
                }
            }
        } else if (substr($key, 0, 2) == 'I_') {
            //assume I node can be parent of only one C node
            //update capital_factor table
            $queryUpdateCapitalWeight->execute(array(
                        ':weight' => $node,
                        ':parent' => $key,
                        ':state' => 1
                    )) or die('query error');
            $queryUpdateCapitalWeight->execute(array(
                        ':weight' => -1 * $node,
                        ':parent' => $key,
                        ':state' => 0
                    )) or die('query error');
        } else if (substr($key, 0, 4) == 'PFC_') {
            if ($node == 4) {
                $value = pow(0.01, (1 / 6));
            } else if ($node == 3) {
                $value = pow(0.25, (1 / 6));
            } else if ($node == 2) {
                $value = pow(0.5, (1 / 6));
            } else if ($node == 1) {
                $value = pow(0.75, (1 / 6));
            } else if ($node == 0) {
                $value = pow(0.95, (1 / 6));
            }
            foreach ($xml->nodes->children() as $child) {//search match node in model file
                if ($child['id'] == $key) {
                    $child->probabilities = '1 0 ' . $value . ' ' . (1 - $value);
                }
            }
        }
    }

    //re-calculate all C nodes
    foreach ($xml->nodes->children() as $child) {
        if (substr($child['id'], 0, 2) == 'C_') {
            //get parent field
            if ($child->parents != null) {
                $parentWeightList = array();
                //check how many parents
                $parentString = $child->parents;
                $parents = explode(" ", $parentString);
                //for each parent, get positive and negative weight
                foreach ($parents as $parent) {
                    $queryGetTempCapitalWeight->execute(array(
                                ':parent' => $parent,
                                ':capital' => $child['id']
                            )) or die('query error');
                    $parentWeightList[] = $queryGetTempCapitalWeight->fetchAll();
                    if ($queryGetTempCapitalWeight->rowCount() == 0)
                        echo $parent . ' - ' . $child['id'] . 'B';
                }

                $propString = '';

                for ($index = 0; $index <= pow(2, count($parents)) - 1; $index++) {
                    $tempProbList = array();
                    for ($status = 0; $status < 2; $status++) {
                        $tempParentWeightSum = 0;
                        foreach ($parents as $parentIndex => $parent) {
                            $pOrN = ($index & pow(2, count($parents) - $parentIndex - 1)) > 0 ? 1 : 0;
                            $tempParentWeightSum+= $parentWeightList[$parentIndex][$pOrN]['weight'];
                        }
                        $tempProbList[] = 0.5 * pow($base, ($status == 0 ? 1 : -1) * $tempParentWeightSum);
                    }

                    for ($status = 0; $status < 2; $status++) {
                        $propString.= $tempProbList[$status] / array_sum($tempProbList) . ' ';
                    }
                }

                $propString = trim($propString);

                //update node
                $child->probabilities = $propString;
            } else {
                die('cannot find parent node');
            }
        }
    }

    $exportFileName = 'temp/' . uniqid() . '.xdsl';
    $xml->asXml($exportFileName);
    return '../../' . $exportFileName; //return new xdls file location
}

dataSets_init();


$pId = $_POST['pId'];
$tId = $_POST['tId'];
$resolution_code = $_POST['resolution'];
$includeModification = isset($_POST['includeModification']) && $_POST['includeModification'] == '1';
$modification = $_POST['modification'];
generateJSON($pId, $tId, $resolution_code, $includeModification, $modification);
?>
