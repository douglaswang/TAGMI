<?php

/**
 * Download result as CSV file, result will be supply by the browser (resultCache).
 * 
 * @package CPWFTargetingOutscaling
 * @subpackage Server
 * @author Douglas Wang (douglas.wang@sei-international.org)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @copyright 2012-2015 Stockholm Environment Institute and Challenge Program on Water and Food
 */
if (isset($_GET['fileName'])) {
    $fileName = $_GET['fileName'];

    header('Content-Type: application/csv');
    header("Content-Disposition: attachment; filename=result.csv");
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    readfile('temp/' . $fileName);
} else {
    die('ERROR: Result set is empty.');
}
?>
