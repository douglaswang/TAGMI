<?php

/**
 * Return data from a GET command as JSON
 * 
 * This is called by tool.js. It provides gzipped JSON representation of available model customisation
 * 
 * @package CPWFTargetingOutscaling
 * @subpackage Server
 * @author Douglas Wang (douglas.wang@york.ac.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @copyright 2012-2015 Stockholm Environment Institute and Challenge Program on Water and Food
 */
require_once 'config/config.php';

DataSet::set_db_info(Constants::db_info());
$dbcon = DataSet::connect();

$pId = $_GET['pId'];
$tId = $_GET['tId'];

//get country
$queryGetProject = $dbcon->prepare('SELECT * FROM "generic"."project" WHERE "id"=:pId');
$queryGetProject->execute(array(':pId' => $pId)) or die('Query error');

if (count($queryGetProject->rowCount()) != 1) {
    die('ERROR: cannot find record');
}
$project = $queryGetProject->fetch();

$schemaName = $project['schema_name'];


$query = <<<QUERY
SELECT t2."node", t2."description", t2."description_fr", t1."default_value" AS "default",
    t3."parent", t4."description" AS "parent_description", t4."description_fr" as "parent_description_fr", t1."sortby"
FROM "$schemaName"."nodes" AS t1 LEFT JOIN "generic"."nodes" AS t2
ON t1."node_id"=t2."id" LEFT JOIN "$schemaName"."parents_table_fact_indic" AS t3 
ON t2."node"=t3."indicator" AND t3."display"=true AND t3."technology_id"=:tId
LEFT JOIN "generic"."nodes" AS t4 ON t3."parent"=t4."node"
WHERE t2."node" NOT like 'I_%' AND t1."display"=true AND t1."default_value" IS NOT NULL AND t1."technology_id"=:tId
UNION
SELECT t6."node", t6."description", t6."description_fr", t5."default_value" AS "default",
    t7."parent", t8."description" AS "parent_description", t8."description_fr" as "parent_description_fr", t5."sortby"
FROM "$schemaName"."nodes" AS t5 LEFT JOIN "generic"."nodes" AS t6
ON t5."node_id"=t6."id" LEFT JOIN "$schemaName"."parents_table_fact_capital" AS t7 
ON t6."node"=t7."parent" AND t7."technology_id"=:tId
LEFT JOIN "generic"."nodes" AS t8 ON t7."capital"=t8."node"
WHERE t6."node" like 'I_%' AND t5."display"=true AND t5."default_value" IS NOT NULL AND t5."technology_id"=:tId
ORDER by sortby
QUERY;

$query = $dbcon->prepare($query);
$query->execute(array(':tId' => $tId)) or die(var_dump($query->errorInfo()));

$data = array();
foreach ($query->fetchAll() as $row) {
    $data[] = array(
        'node' => $row['node'],
        'description' => $row['description'],
        'description_fr' => $row['description_fr'],
        'default' => $row['default'],
        'parent' => $row['parent'],
        'parent_description' => $row['parent_description'],
        'parent_description_fr' => $row['parent_description_fr'],
    );
}

echo json_encode($data);
?>