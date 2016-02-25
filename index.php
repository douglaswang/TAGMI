<?php
/**
 * Index file
 * 
 * This is the home page (front page) of the CPWF Targeting AGwater Management Interventions, prepared for
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
        <link href="./css/index.css" rel="stylesheet">
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
                            <li class="active"><a  href="index.php"><?php echo _('Home'); ?></a></li>
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
                    <h1><?php echo _('Targeting AGwater Management Interventions'); ?></h1>
                    <p><img id="awm-banner" alt="AWM banner" src="img/banner.png"/></p>
                </div>
            </div>
            <div class="row">
                <div class="span12">
                    <p><?php
                        echo _(<<<STRING
The <b>Targeting AGwater Management Interventions (TAGMI)</b> 
is a decision support tool that facilitates targeting and scaling-out of three different 
Agricultural Water Management (AWM) technologies in the Limpopo and the Volta River Basins. 
This online tool displays the output of a Bayesian network model that assesses the influence 
of social and bio-physical factors on the likelihood of success of implementing different 
<a href="about.php#awm-technologies">AWM technologies</a>. The Bayesian network model 
was developed iteratively, in collaboration with local researchers and experts, 
and merges knowledge pools from technical experts to local agriculture extension agents 
(<a href="about.php#consulation-process">read more about the consultation process</a>).
STRING
                        );
                        ?></p>
                    <p>
                        <?php
                        echo _(<<<STRING
<b>TAGMI</b> displays spatially explicit 
model results at the district scale, based on available data, to determine which 
districts may be better suited than others for a particular technological intervention 
in Volta and Limpopo Basin countries. TAGMI helps to answer the question: <i>will an 
intervention successfully applied in one location have a reasonable chance of success at other locations?</i> 
The answer, provided with a measurable degree of certainty, suggests a way forward for scaling-out AWM interventions.
STRING
                        );
                        ?>
                    </p>
                    <p>
                        <?php
                        echo _(<<<STRING
<b>TAGMI Assesses the Likelihood of Success</b>. 
The tool models the relationship between social and bio-physical factors and successful 
implementation and long-term adoption of agricultural water management technologies. 
It is intended for non-technological expert users who want to know which parts of the 
river basins have conditions suitable for successful implementation of a planned AWM 
intervention. For more detailed information about using the tool see the <a href='document/TAGMI_User_Guide.pdf' target='_blank'>User Manual</a>.
STRING
                        );
                        ?>
                    </p>
                    <p>
                        <?php
                        echo _(<<<STRING
<b>It is Science Based</b>. Taking social 
and human resources into account reflects the fact that there are further enabling 
conditions required beyond the purely bio-physical conditions that dictate whether 
or not a technology is appropriate for introduction. The conceptual framework for the
Bayes model is informed by the Sustainable Livelihoods Framework (<a href='http://www.ennonline.net/resources/667' target='_blank'>DFID 1999</a>). For 
more detailed information about the Bayes model behind the tool see the 
<a href='document/TAGMI_Technical_Information_Brief.pdf' target='_blank'>Model Technical Documentation</a>
STRING
                        );
                        ?>
                    </p>
                    <p>
                        <?php
                        echo _(<<<STRING
<b>It is Evidence Based</b>. The Bayesian network 
model makes use of available data on key characteristics in a systematic way to 
suggest the likelihood of success of an intervention. It estimates how different 
contextual factors interact to influence success. This model and tool are based 
on the premise that, while absolute certainty is unobtainable, degrees of certainty 
are both obtainable and useful when using the available information in a systematic way.
STRING
                        );
                        ?>
                    </p>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="span12">
                    <p>
                        <?php
                        echo _(<<<STRING
This tool was developed as part of the 3-year CGIAR Challenge Program on Water 
and Food's Volta and Limpopo Basin Development Challenges (2011-2013) 
(<a href='about.php'>About</a>), for:
STRING
                        );
                        ?>
                    <ul>
                        <li><?php echo _("Volta Basin: Soil and Water Conservation, Small reservoirs, Smallscale irrigation"); ?></li>
                        <li><?php echo _("Limpopo Basin: Conservation agriculture, Small reservoirs, Smallscale irrigation"); ?></li>
                    </ul>
                    <?php echo _("Further developments to the tool:"); ?>
                    <ul>
                        <li><?php
                            echo _(<<<STRING
Upper East Region, Ghana: Small petrol pumps - as part of the project 
"Enhancing uptake and socio-economic benefits of shallow groundwater irrigation 
in the White Volta Basin" (Research into Use), funded by CPWF, Challenge Program 
of Water and Food (2013)
STRING
                            );
                            ?></li>
                        <li><?php
                            echo _(<<<STRING
White Volta Basin: Drip irrigation, Small electric pumps (GH), Small petrol/ diesel pumps (BF) 
– as part of the project "Targeting investments in Groundwater irrigation in the White Volta Basin", 
funded by the CGIAR Water, Land and Ecosystems program (2014-2015)
STRING
                            );
                            ?></li>
                        <li><?php
                            echo _(<<<STRING
Niger Basin: Smallscale irrigation – part of the project "Managing water and food 
systems in the Volta - Niger basins", within the project "WLE in Africa", 
funded EC/IFAD and the CGIAR Water, Land and Ecosystems program (2014-2016)
STRING
                            );
                            ?></li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
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
                                <ul class="thumbnails">
                                    <li class="span16">
                                        <a href="http://wle.cgiar.org/" class="thumbnail" target="_blank">
                                            <img alt="CGIAR Research Program on Water, Land and Ecosystems (WLE)" src="img/logos/WLE_Research_progNW.jpg"/>
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
                                <ul class="thumbnails">
                                    <li class="span6">
                                        <a href="http://www.ideburkinafaso.org/" class="thumbnail" target="_blank">
                                            <img alt="International Development Enterprises (iDE) - Burkina Faso" src="img/logos/logoiDE_BF.png"/>
                                        </a>   
                                    </li>
                                    <li class="span6">
                                        <a href="http://ideghana.org/" class="thumbnail" target="_blank">
                                            <img alt="International Development Enterprises (iDE) - Ghana" src="img/logos/logoiDE_GH.PNG"/>
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
        <script type="text/javascript" src="./js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="./js/bootstrap.js"></script>
        <script type="text/javascript" src="./js/jquery-ui-1.10.0.custom.js"></script>
        <script type="text/javascript" src="./js/jquery.blockui/jquery.blockui.js"></script>
        <script type="text/javascript" src="./js/common.js"></script>
    </body>

</html>
