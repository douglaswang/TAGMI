<?php

/**
 * Return data from a POST command as gzipped JSON
 * 
 * This is called by tool.js. It provides gzipped JSON representation of basin outline.
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

$pId = isset($_POST['pId']) ? $_POST['pId'] : 1;

$queryGetOutline = $dbcon->prepare("SELECT basin_outline FROM generic.project WHERE id=:pId");

$queryGetOutline->execute(array(':pId' => $pId));

if ($queryGetOutline->rowCount() < 1) {
    die('ERROR: cannot find record');
}

$tempRecord = $queryGetOutline->fetch();
$basinName = $tempRecord['basin_outline'];

$query = <<<QUERY
SELECT gid,ST_AsGeoJSON(ST_Transform(geom, 4326)) AS geom
FROM generic.$basinName
QUERY;

$query = $dbcon->prepare($query);
$query->execute();


while ($item = $query->fetch(PDO::FETCH_ASSOC)) {
    $dataList[] = array(
        "type" => "Feature",
        "geometry" => json_decode($item['geom']),
        "properties" => array(
            "gid" => $item['gid'],
        )
    );
}

//wrap the reslut set into FeatureCollection
$data = array(
    "type" => "FeatureCollection",
    "features" => $dataList
);
header('Content-type: application/json');

//apply simple compression to output json. normal: 360KB per layer, after compressed: 100KB per layer
//test with FireFox, IE9, Chrome, Safari, no side-effect found yet.
//ob_gzhandler() requires the zlib extension. 
//http://www.php.net/manual/en/ref.zlib.php
ini_set('zlib.output_compression', 'Off'); //not sure why the zlib.output_compression is set to ture, but in the php.ini, this show off
ob_start('ob_gzhandler');

echo json_encode($data);
ob_end_flush();
