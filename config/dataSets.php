<?php

/**
 * Initialize the datasets
 * 
 * This is a very important file. In addition to setting the memory limit so that the datasets
 * can be loaded, it initializes some common features of all datasets, and defines the
 * datasets themselves. The functions that are called here are defined in the DataSet class.
 * 
 * @package CPWFTargetingOutscaling
 * @subpackage Config
 * @author Eric Kemp-Benedict (eric.kemp-benedict@sei-international.org)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @copyright 2012-2015 Stockholm Environment Institute and Challenge Program on Water and Food
 */
ini_set('memory_limit', '256M');

require_once 'class/DataSet/DataSet.php';

/**
 * Initialize datasets
 * 
 * <p>This can be used to set up most server-specific and dataset-specific variables.
 *    The passed array is documented more fully in the DataSet class. Typical elements
 *    include:</p>
 * <ul>
 * <li>Default locale (not used, and probably should get rid of it: don't want to switch languages abruptly)</li>
 * <li>Resolutions: An array of values to use as the second parameter in a call to ST_SimplifyPreserveTopology(table,resolution)</li>
 * <li>Variables to display: An array have the form LABEL => COLUMN, where the label is displayed by index.js and the column refers to the data table</li>
 * </ul>
 * 
 */
function dataSets_init() {
    DataSet::xdsl_path(dirname(__FILE__) . '/xdsl/');
    DataSet::set_db_info(Constants::db_info());
    DataSet::generic_info(array(
        'schema' => 'generic',
        'inference_function' => 'smile_infer'
    ));
}

function getProjectList() {
    DataSet::set_db_info(Constants::db_info());
    $dbcon = DataSet::connect();

    $queryGetProjects = $dbcon->prepare('SELECT * FROM "generic"."project" ORDER BY "display_name"');
    $queryGetProjects->execute() or die('QUERY ERROR');

    $projectList = $queryGetProjects->fetchAll();

    $tempArray = array();

    if ($_SESSION['lang'] == 'en_EN') {
        $displayName = 'display_name';
        $shortDescriptionName = 'short_description';
        $descriptionName = 'description';
        $bayesNetwork = 'bayes_network';
    } else {
        $displayName = 'display_name_fr';
        $shortDescriptionName = 'short_description_fr';
        $descriptionName = 'description_fr';
        $bayesNetwork = 'bayes_network_fr';
    }

    $queryGetTechonologys = $dbcon->prepare('SELECT * FROM "generic"."technology" WHERE "project_id"=:project_id');

    $queryGetInstitutes = $dbcon->prepare('SELECT * FROM "generic"."institute" WHERE id in (SELECT "institute_id" FROM "generic"."project_institute" WHERE "project_id"=:project_id)');
    foreach ($projectList as $project) {
        $queryGetTechonologys->execute(array(':project_id' => $project['id'])) or die('QUERY ERROR');
        $tempTechnologyList = array();
        foreach ($queryGetTechonologys->fetchAll() as $technology) {
            $tempTechnologyList[] = array(
                'id' => $technology['id'],
                'display_name' => $technology[$displayName],
                'bayes_network' => $technology[$bayesNetwork],
            );
        }
        $queryGetInstitutes->execute(array(':project_id' => $project['id'])) or die('QUERY ERROR');
        $tempInstituteList = array();
        foreach ($queryGetInstitutes->fetchAll() as $institute) {
            $tempInstituteList[] = array(
                'name' => $institute['institute_name'],
                'logo' => $institute['logo'],
                'link' => $institute['link'],
            );
        }

        $tempArray[] = array(
            'id' => $project['id'],
            'display_name' => $project[$displayName],
            'short_description' => $project[$shortDescriptionName],
            'description' => $project[$descriptionName],
            'center_lat' => $project['center_lat'],
            'center_lon' => $project['center_lon'],
            'technology_list' => $tempTechnologyList,
            'screenshot' => $project['screenshot'],
            'institute_list' => $tempInstituteList
        );
    }
    return $tempArray;
}
