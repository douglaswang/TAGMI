<?php
/**
 * Documentation file
 * 
 * This is the documentation page of the CPWF Targeting AGwater Management Interventions, prepared for
 * the Challenge Program on Water and Food by the Stockholm Environment Institute.
 * 
 * @package CPWFTargetingOutscaling
 * @subpackage UI
 * @author Douglas Wang (douglas.wang@sei-international.org)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @copyright 2012-2015 Stockholm Environment Institute and Challenge Program on Water and Food
 */
require_once 'config/config.php';

$projectList = getProjectList();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8">
        <title><?php echo _('Targeting AGwater Management Interventions'); ?></title>
        <link href="./css/bootstrap.css" rel="stylesheet">
        <link href="./css/ui-lightness/jquery-ui.css" rel="stylesheet">
        <link href="./css/ui-lightness/jquery.ui.theme.css" rel="stylesheet">
        <link href="./css/common.css" rel="stylesheet">
        <style type="text/css">
        </style>
        <script type="text/javascript" src="./js/ga.js"></script>
    </head>
    <body>
        <div class="navbar navbar-fixed-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="index.php"><?php echo _('TAGMI'); ?></a>
                    <div class="nav-collapse">
                        <ul class="nav">
                            <li><a  href="index.php"><?php echo _('Home'); ?></a></li>
                            <li class="dropdown">  
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo _('Tool'); ?>
                                    <b class="caret"></b>
                                </a>  
                                <ul class="dropdown-menu">
                                    <li><a href="overview.php"><?php echo _("Overview"); ?></a></li>
                                    <li role="presentation" class="divider"></li>
                                    <?php foreach ($projectList as $project): ?>
                                        <li><a href="tool.php?p_id=<?php echo $project['id']; ?>"><?php echo $project['display_name']; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li class="dropdown">  
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo _('Documentation'); ?>
                                    <b class="caret"></b>
                                </a>  
                                <ul class="dropdown-menu">
                                    <li><a href="documentation.php#documentation"><?php echo _('TAGMI documentation'); ?></a></li>
                                    <li><a href="documentation.php#project-outputs"><?php echo _('Project outputs'); ?></a></li>
                                    <li><a href="documentation.php#bayes-reference"><?php echo _('Bayes References'); ?></a></li>
                                </ul>
                            </li>
                            <li class="dropdown">  
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo _('About'); ?>
                                    <b class="caret"></b>
                                </a>  
                                <ul class="dropdown-menu">
                                    <li><a href="about.php"><?php echo _('TAGMI Creation'); ?></a></li>
                                    <li><a href="about.php#subsequent-tagmi-applications"><?php echo _('Subsequent TAGMI Applications'); ?></a></li>
                                    <li><a href="about.php#bayesian-network-modeling"><?php echo _('Bayesian Network Modeling'); ?></a></li>
                                    <li><a href="about.php#basins"><?php echo _('The Basins'); ?></a></li>
                                    <li><a href="about.php#licence"><?php echo _('Licence'); ?></a></li>
                                </ul>
                            </li>
                            <li>
                                <a  href="mailto:tagmi@sei-international.org" title="<?php echo _('For all your comments, feedbacks and questions are welcome!'); ?>">
                                    <?php echo _('Contact Us'); ?>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav pull-right">
                            <li><a><?php echo _('Language:'); ?></a></li>
                            <?php if ($_SESSION['lang'] != 'en_EN'): ?><li><a href="?lang=en_EN"><img src="img/United_Kingdom.png" alt="English" width="32" height="21"></a></li><?php endif; ?>
                            <?php if ($_SESSION['lang'] != 'fr_FR'): ?><li><a href="?lang=fr_FR"><img src="img/France.png" alt="French" width="32" height="21"></a></li><?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="span12">
                    <section>
                        <div class="page-header">
                            <h2>Map of smallscale irrigation areas, Burkina Faso</h2>
                        </div>
                        <p>
                            This work has been carried out as part of the project 
                            'Managing Food and Water Systems in the Volta-Niger Basins' 
                            within the 'WLE in Africa' project, which has been funded 
                            by IFAD and the CGIAR Water Land and Ecosystems programme.
                        </p>
                        <p>
                            This map of smallscale irrigated area has been produced from 
                            Landsat 8 remote sensing images at 30m resolution, using a 
                            rapid low-data intensity and relatively cost-effective classification approach. 
                            The NDVI was calculated and classified by NDVI intensity to capture the 
                            brightest vegetation (assumed to be irrigated) within a 1.5km buffer from surface water.
                        </p>
                        <p>
                            The landcover classification and verification is based on >1400 groundtruthing 
                            points along a route from Kaya to Bobo-Dioulasso including Leo, and from 
                            Koudougou to Koupela and Fada N'Gourma.
                        </p>
                        <p>
                            The groundtruthing data, methods and draft irrigation maps 
                            are available here for viewing and download, under the Creative 
                            <a href="http://creativecommons.org/">Commons Attribution licence</a>.
                        </p>
                        <p>
                            <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">
                                <img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png" /></a><br />
                            <span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Dataset" property="dct:title" rel="dct:type">
                                Map of smallscale irrigated areas of Burkina Faso</span> by 
                            <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.sei-international.org/" property="cc:attributionName" rel="cc:attributionURL">
                                Mathieu Chaix-Bar, Stockholm Environment Institute</a> is licensed under a 
                            <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.
                        </p>
                    </section>

                    <section>
                        <div class="page-header">
                            <h2>Groundtruthing fieldwork data and methods</h2>
                        </div>
                        <p>
                            <a href="document/output/Groundtruthing_data/Irrigation map - Fieldwork procedure for collecting groundtruthing points.pdf">Fieldwork protocol</a> (PDF)
                        </p>
                        <p>
                            <a href="document/output/Groundtruthing_data/Groundtruthing_points_MasterForm_v3.xls">Groundtruthing points</a> (XLSX)
                        </p>
                        <p>
                            <a href="document/output/Groundtruthing_data/GPSPoints.zip">GPS points</a> (KML)
                        </p>
                        <p>
                            <a href="document/output/Groundtruthing_data/Groundtruthing photographs instructions.pdf">Groundtruthing photographs – instructions to view</a> (PDF)
                        </p>
                        <p>
                            <a href="https://goo.gl/photos/kDcHf23M3wwarmeJ7">Groundtruthing photographs</a> (Picasa)
                        </p>
                    </section>

                    <section>
                        <div class="page-header">
                            <h2>Irrigation map and methods</h2>
                        </div>
                        <p>
                            <a href="document/output/Remote sensing/Irrigation map - Image processing procedures for identifying irrigated areas.pdf">Method – remote sensing processing</a> (PDF)
                        </p>
                        <p>
                            <a href="document/output/Remote sensing/Irrigation map - Accuracy Assessment Procedure for identifying irrigated areas.pdf">Method – accuracy assessment</a> (PDF)
                        </p>
                        <p>
                            <a href="document/output/Remote sensing/PresentationRS_GTP.pdf">Presentation with excerpts and information, by Mathieu Chaix-Bar</a> (PDF)
                        </p>
                        <p>
                            <a href="document/output/Remote sensing/Irrigation map - calculated extent.pdf">Irrigated area extent and accuracy assessment</a> (PDF)
                        </p>
                        <p>
                            <a href="document/output/KML_Files_Irrig_maps_GTPs.zip">Irrigation map for Google Earth</a> (KML)
                        </p>
                        <p>
                            <a href="document/output/Remote sensing/IrrigatedAreaMapsShapefiles.zip">Irrigation map for GIS</a> (SHAPEFILE)
                        </p>
                        <p><b>Different settings have been used for the current maps, to balance the inclusion of riverine vegetation and permanent orchards:</b></p>
                        <p>
                            L8_IrrigArea_ge035 
                            (<a href="document/output/Remote sensing/L8_IrrigArea_ge035.pdf">PDF</a>, 
                            <a href="document/output/Remote sensing/L8_IrrigArea_ge035.png">PNG</a>) - includes all landcover with NDVI higher than 0.35
                        </p>
                        <p>
                            L8_IrrigArea_ge040 
                            (<a href="document/output/Remote sensing/L8_IrrigArea_ge040_vf.pdf">PDF</a>, 
                            <a href="document/output/Remote sensing/L8_IrrigArea_ge040_vf.png">PNG</a>) - includes all landcover with NDVI higher than 0.40
                        </p>
                        <p>
                            L8_IrrigArea_ge045 
                            (<a href="document/output/Remote sensing/L8_IrrigArea_ge045.pdf">PDF</a>, 
                            <a href="document/output/Remote sensing/L8_IrrigArea_ge045.png">PNG</a>) - includes all landcover with NDVI higher than 0.45
                        </p>
                        <p>
                            L8_IrrigArea_SD_ge008 
                            (<a href="document/output/Remote sensing/L8_IrrigArea_SD_ge008.pdf">PDF</a>, 
                            <a href="document/output/Remote sensing/L8_IrrigArea_SD_ge008.png">PNG</a>) 
                            - all landcover with NDVI higher than 0.30 AND recording a standard deviation higher than 0.08 during the period mid Dec - mid Feb
                        </p>
                        <p>
                            L8_IrrigArea_SD_ge009 
                            (<a href="document/output/Remote sensing/L8_IrrigArea_SD_ge009.pdf">PDF</a>, 
                            <a href="document/output/Remote sensing/L8_IrrigArea_SD_ge009.png">PNG</a>) 
                            - all landcover with NDVI higher than 0.30 AND recording a standard deviation higher than 0.09 during the period mid Dec - mid Feb
                        </p>
                        <p>
                            L8_IrrigArea_SD_ge010 
                            (<a href="document/output/Remote sensing/L8_IrrigArea_SD_ge01.pdf">PDF</a>, 
                            <a href="document/output/Remote sensing/L8_IrrigArea_SD_ge01.png">PNG</a>) 
                            - all landcover with NDVI higher than 0.30 AND recording a standard deviation higher than 0.1 during the period mid Dec - mid Feb
                        </p>
                    </section>
                </div>
            </div>
        </div>
        <hr/>
        <footer class="footer">
            <div class="container-fluid">
                <p><?php echo _('&copy; 2012 - 2013 Stockholm Environment Institute and Challenge Program on Water and Food') ?></p>
            </div>
        </footer>
        <script type="text/javascript" src="./js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="./js/bootstrap.js"></script>
        <script type="text/javascript" src="./js/jquery-ui-1.10.0.custom.js"></script>
        <script type="text/javascript" src="./js/jquery.blockui/jquery.blockui.js"></script>
    </body>
</html>
