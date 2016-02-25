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
                            <li class="dropdown active">  
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
                            <h2  id="documentation" class="fixed-top-anchor"><?php echo _('TAGMI documentation'); ?></h2>
                        </div>
                        <p>
                            <a href="document/TAGMI_User_Guide.pdf" target="_blank"><?php echo _('User Manual'); ?></a> 
                            (pdf, 409KB) : <?php echo _('Brief introduction to Bayes networks and the background to the tool, 
followed by a step-by-step description of how to use the tool and what the various components mean.'); ?>
                        </p>
                        <p>
                            <a href="document/TAGMI_Glossary.pdf" target="_blank"> <?php echo _('Glossary (Available in English)'); ?></a> (pdf, 418KB)
                        </p>
                        <p>
                            <a href="document/TAGMI_Technical_Information_Brief.pdf" target="_blank"><?php echo _('Technical Document'); ?></a> (pdf, 800KB) :
                            <?php echo _('Details of the technical components of the tool, including parameters of the Bayes network (Available in English)'); ?>
                        </p>
                        <p>
                            <?php echo _('Meta-data'); ?> 
                            (<a href="document/Volta_Metadata.pdf" target="_blank"><?php echo _('Volta basin'); ?></a>,
                            <a href="document/Botswana_Metadata.pdf" target="_blank"><?php echo _('Botswana'); ?></a>,
                            <a href="document/Mozambique_Metadata.pdf" target="_blank"><?php echo _('Mozambique'); ?></a>,
                            <a href="document/SouthAfrica_Metadata.pdf" target="_blank"><?php echo _('South Africa'); ?></a>,
                            <a href="document/Zimbabwe_Metadata.pdf" target="_blank"><?php echo _('Zimbabwe'); ?></a>) 
                            (pdf, 1.3MB) :
                            <?php echo _('Details of data layers used in the tool (Available in English)'); ?>
                        </p>
                    </section>
                    <section>
                        <div class="page-header">
                            <h2  id="project-outputs" class="fixed-top-anchor"><?php echo _('Project outputs'); ?></h2>
                        </div>
                        <p>
                            <?php echo _('TAGMI Fact Sheet'); ?> 
                            (<a href='document/TAGMI Fact Sheet.pdf' target='_blank'><?php echo _('English'); ?></a>, 
                            <a href='document/TAGMI Fact Sheet (FR).pdf' target='_blank'><?php echo _('French'); ?></a>) 
                            (pdf, 536KB) :
                            <?php
                            echo _("1 page outline of the TAGMI tool's aim, principles and functionality");
                            ?>
                        </p>
                        <p>
                            <?php echo _('TAGMI Information Brief'); ?> 
                            (<a href='document/TAGMI brief.pdf' target='_blank'><?php echo _('Volta - English'); ?></a>, 
                            <a href='document/TAGMI brief (FR).pdf' target='_blank'><?php echo _('Volta - French'); ?></a>,
                            <a href='document/TAGMI Information brief Limpopo.pdf' target='_blank'><?php echo _('Limpopo'); ?></a>) 
                            (pdf, 1.3MB) :
                            <?php
                            echo _("4 page introduction to the TAGMI tool’s rationale, development and use");
                            ?>
                        </p>
                        <p>
                            <?php echo _('TAGMI model networks - Limpopo'); ?> 
                            (<a href='document/TAGMI Bayes Network Model Results_Limpopo.pdf' target='_blank'><?php echo _('English'); ?></a>) 
                            (pdf, 55KB) :
                            <?php
                            echo _("images of the Bayesian networks for each technology in the Limpopo Basin");
                            ?>
                        </p>
                        <p>
                            <?php echo _('TAGMI model networks - Volta'); ?> 
                            (<a href='document/TAGMI Bayes Network Model Results_Volta.pdf' target='_blank'><?php echo _('English'); ?></a>, 
                            <a href='document/TAGMI Bayes Network Model Results_Volta_fre.pdf' target='_blank'><?php echo _('French'); ?></a>) 
                            (pdf, 1.3MB) :
                            <?php
                            echo _("images of the Bayesian networks for each technology in the Volta Basin");
                            ?>
                        </p>
                    </section>
                    <section>
                        <div class="page-header">
                            <h2  id="bayes-reference" class="fixed-top-anchor"><?php echo _('Bayes References'); ?></h2>
                        </div>
                        <p>
                            <?php echo _("Kemp-Benedict, E. (2010) Converting qualitative assessments to quantitative assumptions: 
Bayes' rule and the pundit's wager. Technological Forecasting and Social Change 77(1): 167-171"); ?> (pdf, 266KB) 
                            <?php echo _('Also available at'); ?>: <a href='http://www.sei-international.org/publications?pid=1372'>http://www.sei-international.org/publications?pid=1372</a>
                        </p>
                        <p>
                            <a href='document/Kemp-Benedict et al 2009.pdf' target='_blank'><?php echo _('Eric Kemp-Benedict, Sukaina Bharwani, Elnora de la Rosa, 
Chayanis Krittasudthacheewa, Nilufar Matin (2009). Assessing Water-related Poverty Using 
the Sustainable Livelihoods Framework, SEI Working Paper'); ?></a> (pdf, 1.38MB) 
                            <?php echo _('Also available at'); ?>: <a href='http://www.sei-international.org/publications?pid=1456'>http://www.sei-international.org/publications?pid=1456</a>
                        </p>
                        <p>
                            <a href='document/Kemp-Benedict 2008.pdf' target='_blank'><?php echo _("Kemp-Benedict, E. (2008) Elicitation 
Techniques for Bayesian Network Models. SEI Working Paper WP-US-0804"); ?></a> (pdf, 165KB) 
                            <?php echo _('Also available at'); ?>: <a href='http://www.sei-international.org/publications?pid=1102'>http://www.sei-international.org/publications?pid=1102</a>
                        </p>
                        <p>
                            <a href='http://nora.nerc.ac.uk/3300/1/MERITGuidelinesplusApp.pdf' target='_blank'><?php echo _('MERIT. (2005). Guidelines for the Use of Bayesian 
Networks as a Participatory Tool for Water Resource Management: Based on the Results of 
the MERIT Project. Wallingford, UK: Centre for Ecology and Hydrology for the Management 
of the Environment and Resources using Integrated Techniques (MERIT) Project'); ?></a>  (pdf,6.36MB)
                        </p>
                        <p>
                            <?php echo _('Diez, F.J. and Druzdzel, M.J. (2007) Canonical 
Probabilistic Models for Knowledge Engineering Technical Report CISIAD-06-01. 
Version 0.9 (April 28, 2007).'); ?> (pdf, 418KB) 
                            <?php echo _('Available at'); ?>: <a href='http://www.ia.uned.es/~fjdiez/papers/canonical.pdf'>http://www.ia.uned.es/~fjdiez/papers/canonical.pdf</a>
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
