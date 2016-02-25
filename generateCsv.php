<?php

/**
 * Generate result as CSV file, result will be supply by the browser (resultCache).
 * And return the location of the file (file name)
 * 
 * @package CPWFTargetingOutscaling
 * @subpackage Server
 * @author Douglas Wang (douglas.wang@sei-international.org)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @copyright 2012-2015 Stockholm Environment Institute and Challenge Program on Water and Food
 */
if (isset($_POST['result'])) {
    $result = $_POST['result'];

    $fileName = uniqid();
    $file = 'temp/' . $fileName;
    $fp = fopen($file, 'w');

    foreach ($result as $row) {
        fputcsv($fp, $row);
    }

    fclose($fp);

    echo json_encode(array(
        'file' => $fileName
    ));
} else {
    die('ERROR: Result set is empty.');
}
?>
