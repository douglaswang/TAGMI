<!DOCTYPE html>
<?php
/**
 * Main file
 * 
 * This is the main file of the CPWF Targeting AGwater Management Interventions, prepared for
 * the Challenge Program on Water and Food by the Stockholm Environment Institute.
 * 
 * @package CPWFTargetingOutscaling
 * @subpackage UI
 * @author Eric Kemp-Benedict (eric.kemp-benedict@sei-international.org)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @copyright 2012-2015 Stockholm Environment Institute and Challenge Program on Water and Food
 */
require_once 'config/config.php';

$projectList = getProjectList();

$selectedProject = $projectList[0]['id'];
$selectedTechnologyList = $projectList[0]['technology_list'];
$centerLat = $projectList[0]['center_lat'];
$centerLon = $projectList[0]['center_lon'];
foreach ($projectList as $project) {
    if (isset($_GET['p_id']) && $_GET['p_id'] == $project['id']) {
        $selectedProject = $_GET['p_id'];
        $selectedTechnologyList = $project['technology_list'];
        $centerLat = $project['center_lat'];
        $centerLon = $project['center_lon'];
        break;
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo _('Targeting AGwater Management Interventions'); ?></title>
        <link href="./css/bootstrap.css" rel="stylesheet">
        <link href="./css/ui-lightness/jquery-ui.css" rel="stylesheet">
        <link href="./css/ui-lightness/jquery.ui.theme.css" rel="stylesheet">
        <link href="./css/common.css" rel="stylesheet">
        <style type="text/css">
            div#map-div{
                height: 600px;
            }
            @media (max-width: 979px) {
                div#map-div{
                    height: 400px;
                }
                table#legend-table{
                    font-size: 9px;
                }
            }
            #map-div img{
                max-width: none;
            }
            div.ui-dialog{
                z-index: 9999;
            }
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
                            <li class="dropdown active">  
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

        <div class="container-fluid">
            <div class="row-fluid" style="margin-top: 10px;">
                <div class="span3" >
                    <div class="row-fluid">
                        <div class='span12'>
                            <div class="well">
                                <p><?php echo _('User tips'); ?></p>
                                <ul>
                                    <li><?php echo _("Choose a <a id='tooltip-technology' 
href='#' data-toggle='tooltip' title='<b>Conservation Agriculture</b> is an approach to 
managing agro-ecological systems. It is designed to enable sustainable and profitable 
agriculture while improving farmers&#39; livelihoods.<br/>
<b>Small scale irrigation</b> systems 
are developed, owned or managed by individual farmers.<br/>
<b>Small reservoirs</b> are earthen or cement dams that are less than 7.5 meters 
high. They provide significant opportunities for soil and water conservation, drought 
proofing and for developing small-scale, community-based irrigation schemes.<br/><br/>
Time and data do not allow TAGMI to model ­all AWM technologies nor does it assume 
that those modeled are the most critical technologies. The three selected are meant 
to represent the spectrum from rainfed to irrigated; as well as from community-level 
technology (storage), to more individual farm-level technologies (soil-water conservation 
and certain irrigation technologies):<br/>
1. Conservation Agriculture (Soil and Water Conservation technologies, Rainfed)<br/>
2. Small scale irrigation (Individual irrigation technologies)<br/>
3. Small Reservoirs (Storage technologies, community irrigation from stored water)'>technology</a> 
and display resolution, then click <b>RUN</b> for the map to display the modelled 
likelihood of success of a project implementing the chosen technology."); ?> </li>
                                    <li><?php echo _('If the map is slow to load, reduce the resolution.'); ?></li>
                                    <li><?php echo _('Basin outline shown in red.'); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="checklist-div" class="row-fluid">
                        <div class='span12 well'>
                            <form id="formControl">
                                <label for="pId"><?php echo _('Country / Project:'); ?></label>
                                <select id="pId" class='input-block-level' name="pId">
                                    <?php foreach ($projectList as $project): ?>
                                        <option value='<?php echo $project['id']; ?>' <?php echo $selectedProject == $project['id'] ? 'selected' : '' ?>><?php echo $project['display_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="tId"><?php echo _("Technology:"); ?></label>
                                <select id="tId" class='input-block-level' name="tId">
                                    <?php foreach ($selectedTechnologyList as $technology): ?>
                                        <option value="<?php echo $technology['id']; ?>" data-network="<?php echo $technology['bayes_network']; ?>"><?php echo $technology['display_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label for="resolution"><?php echo _('Resolution:'); ?></label>
                                <select id="resolution" name="resolution" class="span12">
                                    <option value="high"><?php echo _("High (slower download)"); ?></option>
                                    <option value="med" selected="selected"><?php echo _("Medium"); ?></option>
                                    <option value="low"><?php echo _("Low (faster download)"); ?></option>
                                </select>
                                <p><?php echo _('Key: L - Low, M - Medium, H -High'); ?></p>
                                <table class="table table-bordered" id="legend-table">
                                    <tbody>
                                        <tr>
                                            <td colspan="3"><?php echo _("Probability of success"); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _("L"); ?></td>
                                            <td><?php echo _("M"); ?></td>
                                            <td><?php echo _("H"); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="strength-related-cell" style="background-color: #87CEFA">&nbsp;</td>
                                            <td class="strength-related-cell" style="background-color: #1E90FF">&nbsp;</td>
                                            <td class="strength-related-cell" style="background-color: #0000CD">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><?php echo _('Strength of evidence is <b>LOW</b>'); ?> <a id='tooltip-strength-of-evidence' href="#" data-toggle="tooltip" title="<?php echo _("This reflects an assessment 
of the quality of the data underlying the model’s result. For example, 
if data is old, or available at a coarser geographic coverage or scale 
of analysis than the model is at (district-level), the evidence base for 
the result is weak, and the strength of evidence will be LOW. Low strength 
of evidence can also reflect an uncertainty in how well the data used is related 
to the concept it describes.  Alternatively, if the data is recent, 
consistently representative across the country, at district level and 
highly relevant for all factors in the model, the evidence base for the 
result is strong and the strength of evidence will be HIGH."); ?>"><?php echo _('Why?'); ?></a></p>

                                <div class="btn-group" style="float: right;">
                                    <button type="button" class="btn btn-primary" id="btn-run-calculation"><?php echo _('Run'); ?></button>
                                    <button class="btn dropdown-toggle btn-primary" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" id="btn-table-result"><?php echo _('View results in table'); ?></a></li>
                                        <li><a href="#" id="btn-download-result"><?php echo _('Download results'); ?></a></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="span9">
                    <div class="row-fluid">
                        <div id="map-div">
                        </div>
                    </div>
                    <br/>
                    <div class="row-fluid">
                        <div class="span12 well">
                            <div class="row-fluid">
                                <div class="span12 ">
                                    <h4><?php echo _('Attributes to display'); ?></h4>
                                    <p><?php echo _('Tick the boxes below to display the selected information for each district when clicking on the map'); ?></p>
                                    <div class="row-fluid" id="div-field-to-dispaly">
                                        <label class="checkbox span2">
                                            <input type="checkbox" id="field-total-population" value="tot_pop" checked="checked"/>
                                            <?php echo _('Total population'); ?>
                                        </label>
                                        <label class="checkbox span3">
                                            <input type="checkbox" id="field-mean-annual-rainfall" value="MAR"/>
                                            <?php echo _('Mean annual rainfall (mm)'); ?>
                                        </label>
                                        <label class="checkbox span3">
                                            <input type="checkbox" id="field-land-use" value="cropland"/>
                                            <?php echo _('Total cropland area (ha)'); ?>
                                        </label>
                                        <label class="checkbox span2">
                                            <input type="checkbox" id="field-poverty-level" value="poverty"/>
                                            <?php echo _('Poverty level (%)'); ?>
                                        </label>
                                        <label class="checkbox span2">
                                            <input type="checkbox" id="field-food-security" value="food_sec"/>
                                            <?php echo _('Food security (%)'); ?>
                                        </label>
                                        <label class="checkbox hidden">
                                            <input type="checkbox" id="field-district" value="District" checked="checked"/>
                                            <?php echo _('District'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12 ">
                                    <form id="formModelModification">
                                        <h4><?php echo _('Model customisation'); ?></h4>
                                        <div class="row-fluid" id="div-model-modification">
                                            <div class="row-fluid">
                                                <div class="span12 ">
                                                    <p>
                                                        <label class="checkbox inline">
                                                            <input type="checkbox" id="field-include-modification" value="1" name="includeModification"/>
                                                            <?php echo _('Include following model customisation in calculation.'); ?> 
                                                        </label> 
                                                        <button class="btn btn-mini" type="button" id="btn-reset"><?php echo _('Reset to default settings'); ?></button>
                                                    </p>
                                                </div>
                                            </div>
                                            <ul class="nav nav-tabs">
                                                <li  class="active"><a href="#modification-capital" data-toggle="tab"><?php echo _('Capital'); ?></a></li>
                                                <li><a href="#modification-factor" data-toggle="tab"><?php echo _('Factor'); ?></a></li>
                                                <li style="display:none;"><a href="#modification-data" data-toggle="tab"><?php echo _('Data'); ?></a></li>
                                                <li><a href="#modification-image" data-toggle="tab"><?php echo _('Bayesian network image'); ?></a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="modification-capital">
                                                    <table id="tableModificationCapital" class="table table-bordered table-striped">

                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="modification-factor">
                                                    <table id="tableModificationFactor" class="table table-bordered table-striped">

                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="modification-data" style="display:none;">
                                                    <table id="tableModificationData" class="table table-bordered table-striped">

                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="modification-image">
                                                    <p><a href="#" target="_blank"><img src=""/></a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <ul class="thumbnails">
                            <li class="span3">
                                <div class='row-fluid'>
                                    <ul class="thumbnails">
                                        <li class="span12">
                                            <a href="http://waterandfood.org/" class="thumbnail" target="_blank">
                                                <img alt="CPWF logo" src="img/cpwf.png"/>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="thumbnails">
                                        <li class="span6">
                                            <a href="http://waterandfood.org/basins/volta/" class="thumbnail" target="_blank">
                                                <img alt="Volta logo" src="img/volta.png"/>
                                            </a>
                                        </li>
                                        <li class="span6">
                                            <a href="http://waterandfood.org/basins/limpopo-2/" class="thumbnail" target="_blank">
                                                <img alt="Limpopo logo" src="img/limpopo.png"/>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="span3">
                                <div class='row-fluid'>
                                    <ul class="thumbnails">
                                        <li class="span12">
                                            <a href="http://www.sei-international.org/" class="thumbnail" target="_blank">
                                                <img alt="SEI logo" src="img/sei.png"/>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="thumbnails">
                                        <li class="span12">
                                            <a href="http://hikm.ihe.nl/waternet" class="thumbnail" target="_blank">
                                                <img alt="WATERNET logo" src="img/waternet.jpg"/>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="span3">
                                <div class='row-fluid'>
                                    <ul class="thumbnails">
                                        <li class="span6">
                                            <a href="http://www.csir-water.com/" class="thumbnail" target="_blank">
                                                <img alt="CSIR logo" src="img/csir.jpg"/>
                                            </a>
                                        </li>
                                        <li class="span6">
                                            <a href="http://www.univ-ouaga.bf/" class="thumbnail" target="_blank">
                                                <img alt="University of Ouagadougou logo" src="img/uni_ouaga.jpg"/>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="thumbnails">
                                        <li class="span6">
                                            <a href="http://www.iwmi.cgiar.org/" class="thumbnail" target="_blank">
                                                <img alt="IWMI logo" src="img/iwmi.jpg"/>
                                            </a>
                                        </li>

                                        <li class="span6">
                                            <a href="http://www.wits.ac.za/" class="thumbnail" target="_blank">
                                                <img alt="University of the Witwatersrand logo" src="img/uni_wits.png"/>
                                            </a>  
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="span3">
                                <div class='row-fluid'>
                                    <ul class="thumbnails">
                                        <li class="span6">
                                            <a href="http://www.knust.edu.gh/" class="thumbnail" target="_blank">
                                                <img alt="KNUST logo" src="img/knust.jpg"/>
                                            </a>   
                                        </li>
                                        <li class="span6">
                                            <a href="http://www.inera.bf/" class="thumbnail" target="_blank">
                                                <img alt="INERA logo" src="img/inera.jpg"/>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <p><?php echo _('&copy; 2012 - 2013 Stockholm Environment Institute and Challenge Program on Water and Food') ?></p>
                </div>
            </footer>
        </div>
        <script type="text/javascript" src="./js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="./js/bootstrap.js"></script>
        <script type="text/javascript" src="./js/jquery-ui-1.10.0.custom.js"></script>
        <script type="text/javascript" src="./js/OpenLayers/OpenLayers.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDJRpVhyBq_zgKnGaEPQSn3aYiK1okuYX8&v=3"></script>
        <script type="text/javascript" src="./js/proj4js-combined.js"></script>
        <script type="text/javascript" src="./js/jquery.blockui/jquery.blockui.js"></script>
        <script type="text/javascript" src="./js/qjax/jquery.qjax.min.js"></script>
        <script type="text/javascript" src="./js/common.js"></script>
        <script type="text/javascript" src="./js/tool.js"></script>
        <script type="text/javascript">
            var map, layerSwitcher, layerList = new Array(), dialog, mouseClickPosition = new Array(), mapCenterLat, mapCenterLon, currentLanguage, resultCache = null;

            mapCenterLat = <?php echo $centerLat; ?>;
            mapCenterLon = <?php echo $centerLon; ?>;

            currentLanguage = '<?php echo $_SESSION['lang'] == 'en_EN' ? 'en_EN' : 'fr_FR'; ?>';


            $(document).ready(function () {
                init();
            });
        </script>
    </body>

</html>
