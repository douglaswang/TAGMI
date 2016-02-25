<?php
/**
 * Overview page
 * 
 * This is the overview page for existing projects.
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
                    <div class="page-header">
                        <h2><?php echo _('Overview'); ?></h2>
                    </div>
                    <ul>
                        <?php foreach ($projectList as $project): ?>
                            <li><a href="#project-<?php echo $project['id']; ?>"><?php echo $project['display_name']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php foreach ($projectList as $project): ?>
                        <section>
                            <h3 id="project-<?php echo $project['id']; ?>"><a href="tool.php?p_id=<?php echo $project['id']; ?>"><?php echo $project['display_name']; ?></a></h3>
                            <div class="row">
                                <div class="span9">
                                    <?php echo nl2br($project['description']); ?>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <ul class="thumbnails">
                                        <?php foreach ($project['institute_list'] as $institute): ?>
                                            <li class="span2">
                                                <a href="<?php echo $institute['link']; ?>" class="thumbnail">
                                                    <img src="img/logos/<?php echo $institute['logo']; ?>"/>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="span3">
                                    <a href="tool.php?p_id=<?php echo $project['id']; ?>">
                                        <img src="img/screenshots/<?php echo $project['screenshot'] ?>"/>
                                    </a>
                                </div>
                            </div>
                            <hr/>
                        </section>
                    <?php endforeach; ?>
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
