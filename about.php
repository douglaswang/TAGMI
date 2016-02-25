<?php
/**
 * About file
 * 
 * This is the about page of the CPWF Targeting AGwater Management Interventions, prepared for
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
            #left-nav .icon-chevron-right,#left-nav .icon-chevron-down {
                float:right;
                margin-right:-6px;
                margin-top:2px;
                opacity:0.25;
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
                            <li class="dropdown active">  
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
                <div id="left-nav" class="span3">
                    <ul class="nav nav-list affix">
                        <li>
                            <a href="#tagmi-creation">
                                <i class="icon-chevron-right"></i>
                                <?php echo _('TAGMI Creation'); ?>
                            </a>
                            <ul  class="nav nav-list hide">
                                <li>
                                    <b><?php echo _('Initial TAGMI Project'); ?></b>
                                    <ul class="nav nav-list">
                                        <li>
                                            <a href="#basin-challenge"><?php echo _('CPWF Basin Development Challenges'); ?></a>
                                        </li>
                                        <li>
                                            <a href="#targeting-scaling-out"><?php echo _('V1 and L1 Targeting and scaling out'); ?></a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <b><?php echo _('Consultation process'); ?></b>
                                    <ul class="nav nav-list">
                                        <li>
                                            <a href="#success-and-failure"><?php echo _('Success and failure of AWM interventions'); ?></a>
                                        </li>
                                        <li>
                                            <a href="#detailed-narrative"><?php echo _('Detailed narratives of successful AWM interventions'); ?></a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#project-team"><?php echo _('Project Team'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#subsequent-tagmi-applications">
                                <i class="icon-chevron-right"></i>
                                <?php echo _('Subsequent TAGMI Applications'); ?>
                            </a>
                            <ul  class="nav nav-list hide">
                                <li>
                                    <a href="#ghana-upper-east-region"><?php echo _('CPWF Upper East Region, Ghana'); ?></a>
                                </li>
                                <li>
                                    <a href="#white-volta-basin"><?php echo _('WLE White Volta Basin'); ?></a>
                                </li>
                                <li>
                                    <a href="#niger-basin"><?php echo _('WLE Niger in the Niger Basin'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#bayesian-network-modeling">
                                <?php echo _('Bayesian Network Modeling'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="#basins">
                                <i class="icon-chevron-right"></i>
                                <?php echo _('The Basins'); ?>
                            </a>
                            <ul  class="nav nav-list hide">
                                <li>
                                    <a href="#volta-basin"><?php echo _('Volta Basin'); ?></a>
                                </li>
                                <li>
                                    <a href="#limpopo-basin"><?php echo _('Limpopo Basin'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#awm-technologies">
                                <i class="icon-chevron-right"></i>
                                <?php echo _('The AWM Technologies'); ?>
                            </a>
                            <ul  class="nav nav-list hide">
                                <li>
                                    <a href="#ca"><?php echo _('Conservation Agriculture'); ?></a>
                                </li>
                                <li>
                                    <a href="#irrig"><?php echo _('Small-Scale Irrigation'); ?></a>
                                </li>
                                <li>
                                    <a href="#dams"><?php echo _('Small Reservoirs'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#licence"><?php echo _('Licence'); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="span9">
                    <section>
                        <div class="page-header">
                            <h2  id="tagmi-creation" class="fixed-top-anchor"><?php echo _('TAGMI Creation'); ?></h2>
                        </div>
                        <h3><?php echo _('Initial TAGMI Project'); ?></h3>
                        <h4 id="basin-challenge" class="fixed-top-anchor"><?php echo _('The Challenge Programme for Water and Food Basin Development Challenges'); ?></h4>
                        <p><?php
                            echo _(<<<STRING
Since its 2002 launch, the CGIAR Challenge Program on Water and Food 
(<a href="http://waterandfood.org/" target="_blank">CPWF</a>) 
has become a comprehensive global research effort on water and food. More than 10 years 
of CPWF research includes 100+ research-for-development projects and the involvement 
of 400+ partners in international river basins. More than 1.5 billion people live 
in CPWF basins, amongst whom half of the poorest people on Earth.  In <a href="http://waterandfood.org/phase-1-results-update/" target="_blank">Phase 1</a>
(2002-2007), projects focussed on discovering successful water-related strategies for improving food 
security and reducing poverty. CPWF Phase 2 builds on prior work, and is organised into 
integrated research programmes involving 5+ projects and partners to address Basin-specific Development Challenges (BDC):
STRING
                            );
                            ?></p>
                        <div class="row-fluid">
                            <div class="span6 well">
                                <h4 style="text-align: center"><?php echo _('Volta BDC'); ?></h4>
                                <p><?php
                                    echo _(<<<STRING
Strengthen integrated management of rainwater and small reservoirs so that they can be
used equitably and for multiple purposes (<a href="http://waterandfood.org/basins/volta/" target="_blank">http://waterandfood.org/basins/volta/</a>)
STRING
                                    );
                                    ?></p>
                                <p><b><?php echo _('V1 Targeting and scaling out'); ?></b></p>
                                <p><?php echo _('V2 Management of rainwater for crop livestock and agroecosystems'); ?></p>
                                <p><?php echo _('V3 Management of small reservoirs'); ?></p>
                                <p><?php echo _('V4 Governance of rainwater and small reservoirs'); ?>/p>
                                <p><?php echo _('V5 Coordination and enabling change'); ?></p>
                            </div>
                            <div class="span6 well">
                                <h4 style="text-align: center"><?php echo _('Limpopo BDC'); ?></h4>
                                <p><?php echo _('To improve smallholder productivity and livelihoods and reduce livelihood risk
through integrated water resource management (<a href="http://waterandfood.org/basins/limpopo-2/" target="_blank">http://waterandfood.org/basins/limpopo-2/</a>)'); ?></p>
                                <p><b><?php echo _('L1 Targeting and scaling out'); ?></b></p>
                                <p><?php echo _('L2 Small-scale infrastructure'); ?></p>
                                <p><?php echo _('L3 Farm systems and risk management'); ?></p>
                                <p><?php echo _('L4 Water governance'); ?>/p>
                                <p><?php echo _('L5 Learning for innovation and adaptive management'); ?></p>
                            </div>
                        </div>
                        <h4 id="targeting-scaling-out" class="fixed-top-anchor"><?php echo _('V1 and L1 Targeting and scaling out'); ?></h4>
                        <p>
                            <?php
                            echo _(<<<STRING
Numerous pilot studies and case studies in the 
<b>Volta Basin</b> have evaluated practices, methods, and tools that could prove 
beneficial to others, both within the basin and outside of it. However, the question 
whether an intervention successfully applied in one location has a reasonable chance of 
success at any other location remains extremely difficult to answer. A consistent finding 
in pilot studies is that detailed characteristics of the study location – economic, 
biophysical, institutional, and cultural –all have essential roles in the eventual 
success or failure of achieving a successful land and water management outcomes. 
For out-scaling of initiatives it is impractical to collect detailed information at 
every potential site where an agricultural land and water management (AWM) intervention 
might be introduced. This project starts with the premise that, while certainty is unobtainable, 
degrees of certainty are both obtainable, using available information in a systematic way, and useful.
STRING
                            );
                            ?>
                        </p>
                        <p>
                            <?php
                            echo _(<<<STRING
Despite hosting some of the most developed sub Saharan countries, 
a majority of rural smallholder farmers in the <b>Limpopo basin</b> still live in poverty. 
The challenge of low and highly variable rainfall together with inadequate technology transfers, 
inadequate policy and investment context all act to disable successful transitions out of poverty. 
The CPWF Phase I identified several opportunities to manage rainfall in more efficient and productive 
manners at field to basin scales. The challenge of successful targeting and scaling out is still a key 
research and development area to contribute towards the Limpopo development challenges with opportunities 
to enable transformations of rural livelihoods at a greater scale.
STRING
                            );
                            ?>
                        </p>

                        <p>
                            <?php
                            echo _(<<<STRING
The CPWF Project V1 and L1 projects have thus 
developed this web-based "decision support" targeting and scaling out tool to map 
the likelihood that a given AWM intervention will be successful in given locations. 
The tool is aimed at non-expert users who could use it to identify likely sites 
where introducing AWM interventions for smallholder farming systems are likely to succeed.
STRING
                            );
                            ?>
                        </p>
                        <h3><?php echo _('Consultation process'); ?></h3>
                        <p><?php
                            echo _(<<<STRING
As the convening institution, the Stockholm Environment Institute, 
with partners, led the development of TAGMI through a series of national and local consultations in 
Ghana, Burkina Faso, and with representatives of all four basin countries attending meetings 
in Zimbabwe and South Africa in 2011 and 2012. The first consultation in 2011 was aimed at 
identifying successful AWM cases in the country and region and identifying factors and 
contexts that contributed and/or hindered outscaling of AWM technologies based on known 
examples of successful and unsuccessful outscaling in the respective basin. In the second 
consultation, which took place in 2012, the aim was to get feedback on the model. Local 
partners and stakeholders discussed the relations between factors and indicators, and 
the importance to the likelihood of success of an AWM intervention. The Bayesian Network Model, 
which informs the web-tool’s map display output, is a combination of local, national and regional 
datasets with the expert input of our Basin project partners. The final engagements in the 
region as part of this project took place in July and August 2013.
STRING
                            );
                            ?></p>

                        <h4 id="success-and-failure" class="fixed-top-anchor"><?php echo _('Success and failure of AWM interventions'); ?></h4>
                        <p>
                            <?php
                            echo _(<<<STRING
Experts identified a range of technologies from rainfed 
to full irrigation. However, there was no obvious pattern of success or failure of interventions 
across this AWM technology gradient. Both rainfed and full irrigation interventions were 
referred to as successful or failed depending on the context.
STRING
                            );
                            ?>
                        </p>
                        <p>
                            <?php
                            echo _(<<<STRING
An analysis of the criteria used to identify the success or 
failure of an intervention showed that in all four countries the success of AWM cases was 
especially due to factors not related to natural, physical, human, social, or financial 
aspects. More important for the success or failure of an intervention were factors related 
to project implementation, process and participation.
STRING
                            );
                            ?>
                        </p>

                        <h4 id="detailed-narrative" class="fixed-top-anchor"><?php echo _('Detailed narratives of successful AWM interventions '); ?></h4>
                        <p><img alt="Consultation process" src="img/consultation-process.png"/></p>
                        <p><?php
                            echo _(<<<STRING
In addition to these three rounds of consultation, 
the project partners Waternet, Witwatersrand University, INERA and SARI collected more detailed 
information about successful AWM interventions in their respective countries. They used 
a methodology that combines maps and participation in focus groups (Participatory GIS) 
to collect a narrative of project implementation and enabling factors that had resulted 
in a successful AWM intervention. Stakeholders at district level participated in these 
events and their stories were complemented by community level narratives. 
STRING
                            );
                            ?></p>

                        <h3 id="project-team" class="fixed-top-anchor"><?php echo _('The Project Team'); ?></h3>
                        <p>
                            <?php
                            echo _(<<<STRING
<a href='mailto:j.barron@cgiar.org'>Dr Jennie Barron</a> 
is the Theme Leader for Sustainable Agricultural Water Management at the 
<a href=''>International Water Management Institute</a> and affiliated to 
<a href='http://www.stockholmresilience.org/contactus/staff/barron.5.3ebb718712ed6075a6780005576.html' target='_blank'>Stockholm Resilience Centre</a>. 
Her research is focussed on agriculture, water management and ecosystem services in the field to meso-scale landscapes for food production, 
livelihood improvements and agro-ecosystems sustainability. During the initial TAGMI project, Dr. Barron was the 
theme leader of Managing Environmental Systems at 
<a href="http://www.sei-international.org/staff?staffid=16">the Stockholm Environment Institute (SEI)</a>. 
SEI was the institutional coordinator for the V1 and L1 projects.
The project was carried out in close collaboration with the other CPWF BDC projects (V2-V5 and L2-L5) 
with the support of the respective BDC Leaders : Olufunke Cofie (Volta) and Amy Sullivan (Limpopo).
STRING
                            );
                            ?>
                        </p>
                        <h4 id="volta-partners" class="fixed-top-anchor"><?php echo _('Volta Basin Research Partners'); ?></h4>
                        <p>
                            <a href="http://www.inera.bf/" target="_blank"><?php echo _('Institut National de l’Environnement et de Recherches Agricoles (INERA)'); ?></a>; 
                            <a href="http://www.knust.edu.gh/" target="_blank"><?php echo _('Civil Engineering Dept. of the Kwame Nkrumah University of Science and Technology (KNUST)'); ?></a>;
                            <a href="http://www.csir-water.com/" target="_blank"><?php echo _('Savanna Agricultural Research Institute of the Council for Scientific and Industrial Research, Ghana (CSIR-SARI)'); ?></a>; 
                            <a href="http://www.univ-ouaga.bf/" target="_blank"><?php echo _('Département de Géographie de l’Université de Ouagadougou'); ?></a>
                        </p>
                        <h4 id="limpopo-partners" class="fixed-top-anchor"><?php echo _('Limpopo Basin Research Partners'); ?></h4>
                        <p>
                            <a href="http://hikm.ihe.nl/waternet/" target="_blank"><?php echo _('WaterNet'); ?></a>; 
                            <a href="http://www.wits.ac.za/" target="_blank"><?php echo _('University of Witwatersrand'); ?></a>; 
                            <a href="http://www.iwmi.cgiar.org/" target="_blank"><?php echo _('International Water Management Institute-South Africa'); ?></a>
                        </p>
                    </section>

                    <section>
                        <div class="page-header">
                            <h2  id="subsequent-tagmi-applications" class="fixed-top-anchor"><?php echo _('Subsequent TAGMI Applications'); ?></h2>
                        </div>
                        <div class="row-fluid">
                            <h3 id="ghana-upper-east-region" class="fixed-top-anchor"><?php echo _('CPWF Upper East Region, Ghana'); ?></h3>
                            <h4>
                                <a href="http://westafrica.iwmi.cgiar.org/show-projects/?C=572">
                                    <?php echo _('Enhancing uptake and socio-economic benefits of shallow groundwater irrigation in the White Volta Basin  (January 01, 2012 - April 30, 2014)'); ?>
                                </a>
                            </h4>
                            <p><?php echo _('Project Leader: Pamela Katic'); ?></p>
                            <p><?php
                                echo _(<<<STRING
The project continued the research carried out in the CPWF Phase 1 project 65 
('Shallow groundwater irrigation in the White Volta Basin') in the Atankuidi 
catchment of Upper East Region, Ghana. This project explored the potential for 
greater use of groundwater irrigation in the White Volta Basin. The specific 
objectives of the project were: to identify and, where possible introduce affordable 
technologies adapted to local conditions, to improve the understanding of the economics 
of current and potential crop enterprises, to explore interventions that help address 
the marketing challenges faced by shallow groundwater irrigation practitioners, and investigate 
ways of fostering and accelerating uptake and adoption of groundwater irrigation in other areas of the White 
Volta Basin. To achieve these objectives, the project implemented several research-into-use activities, 
which were grouped into three interrelated and mutually reinforcing work packages:
STRING
                                );
                                ?>
                            </p>
                            <ul>
                                <li><?php echo _('Evaluation of existing irrigation methods and alternative technologies to improve the efficiency of shallow groundwater utilization;'); ?></li>
                                <li><?php echo _('Improving profitability and market access: A value-chain analysis; and'); ?></li>
                                <li><?php echo _('Improving uptake and out-scaling of shallow groundwater irrigation technologies and management practices.'); ?></li>
                            </ul>

                            <p><?php echo _('The project was led by the International Water Management Institute (IWMI) and funded by the CGIAR CPWF program and IWMI.'); ?></p>
                            <p><?php echo _('Location: Upper East Region, Ghana'); ?></p>
                            <p><?php echo _('Technologies: Small Petrol Pumps'); ?></p>
                            <p><?php
                                echo _(<<<STRING
Project partners: 
<a href="http://ideghana.org/">International Development Enterprises</a>, University of Development Studies, 
<a href="http://sei-international.org/">Stockholm Environment Institute</a>.
STRING
                                );
                                ?></p>



                            <h3 id="white-volta-basin" class="fixed-top-anchor"><?php echo _('WLE White Volta Basin'); ?></h3>
                            <h4>
                                <a href="http://westafrica.iwmi.cgiar.org/show-projects/?C=738">
                                    <?php echo _('Targeting investments in Groundwater irrigation in the White Volta Basin (May 01, 2014 - June 30, 2015)'); ?>
                                </a>
                            </h4>
                            <p><?php echo _('Project Leader: Pamela Katic (P.Katic@cgiar.org)'); ?></p>
                            <p><?php
                                echo _(<<<STRING
The project served to test and expand the applicability of the Bayesian-based decision tool 
TAGMI (developed by SEI as part of CPWF-V1). TAGMI provided recommendations for scaling-up the 
adoption of a specific irrigation technology. The project carried out specific ground-truthing 
and expansion of the TAGMI model adapted to petrol pumps for shallow groundwater irrigation (CPWF-RiU project) by: 
STRING
                                );
                                ?></p>
                            <ul>
                                <li><?php echo _('verifying the results of the model with field observations and expert opinions.'); ?></li>
                                <li><?php echo _('re-assessing the model structure (Are the lines and relationships accurate? What should change?) and data sources (Are there others to include? What organizations have the data?)'); ?></li>
                                <li><?php echo _('exploring avenues for model refinement through additional data sources and spatial disaggregation'); ?></li>
                                <li><?php echo _('exploring the potential of the model to other pumping and groundwater application technologies'); ?></li>
                                <li><?php echo _('exploring the relevance and data requirements of expanding the model to other areas in the wider Volta/Niger Basin.'); ?></li>
                            </ul>
                            <p><?php echo _('The project was led by the International Water Management Institute (IWMI) and funded by the CGIAR Water, Land and Ecosystems program.'); ?></p>
                            <p><?php echo _('Location: Districts of Burkina Faso and Ghana that fall within the White Volta basin'); ?></p>
                            <p><?php echo _('Technologies: Drip irrigation (both), small petrol/ diesel pumps (Burkina Faso) and small electric pumps (Ghana)'); ?></p>
                            <p><?php echo _('Key team members: Pamela Katic, Joanne Morris, Mathieu Chaix-Bar, Kalifa Dembele, Euloge Kabore, Anna Minkah'); ?></p>
                            <p><?php
                                echo _(<<<STRING
Project partners: 
<a href="http://ideghana.org/">International Development Enterprises (Ghana)</a>, 
<a href="http://www.ideburkinafaso.org/">International Development Enterprises (Burkina Faso)</a>, 
<a href="http://sei-international.org/">Stockholm Environment Institute</a>.
STRING
                                );
                                ?></p>
                            <h3 id="niger-basin" class="fixed-top-anchor"><?php echo _('WLE Niger in the Niger Basin'); ?></h3>
                            <h4>
                                <?php echo _('Managing water and food systems in the Volta - Niger basins (January 01, 2014 - December 31, 2016)'); ?>
                            </h4>
                            <p><?php echo _('Project Leader: O. Cofie, (O.COFIE@CGIAR.ORG)'); ?></p>
                            <p><?php
                                echo _(<<<STRING
The improvement of TAGMI and development of a TAGMI tool for smallscale irrigation in 
Niger was one component of the larger project. Extensive groundtruthing of landuse 
around small reservoirs was carried out in December 2014, to support the development 
of an improved map of smallscale irrigation in Burkina Faso, to serve as a validation 
method for the original small-scale irrigation TAGMI tool developed under the CPWF V1 project.
STRING
                                );
                                ?></p>
                            <p><?php
                                echo _(<<<STRING
The larger project sought to build and expand on earlier work carried out in the 
CPWF Volta from 2010-2013. It aimed at improving the management of water for sustainable 
food production at local and sub-basin levels. The project would produce outputs of: 
1) Innovation and learning, including publication of special journal edition and policy briefs. 
2) Consolidated knowledge of the historical evolution and resilience of small reservoirs in West Africa documented as a book 
3) Recommendations on optimizing the use of small reservoirs for multiple purposes. 
4) Recommendations for improving water governance options at watershed level. 
5) Improved decision support tool for better targeting investments in agricultural water management interventions (TAGMI). The project was led by the International Water Management Institute (IWMI), and funded by EC/IFAD and the CGIAR Water, Land and Ecosystems program.
STRING
                                );
                                ?></p>
                            <p><?php echo _('Location of new TAGMI application(s): Districts of Niger that fall within the Niger basin'); ?></p>
                            <p><?php echo _('Technologies: Small Scale Irrigation (initial draft)'); ?></p>
                            <p><?php echo _('Key team members (in the TAGMI development): Joanne Morris, Mathieu Chaix-Bar'); ?></p>
                            <p><?php
                            echo _(<<<STRING
Project partners: 
<a href="http://ur-green.cirad.fr/">CIRAD-UPR GREEN</a>, 
<a href="https://en.ird.fr/">Institut de recherche pour le développement (IRD)</a>, 
<a href="http://www.ilri.org/westafrica">International Livestock Research Institute (ILRI)</a>, 
<a href="https://www.knust.edu.gh/">Kwame Nkrumah University of Science and Technology (KNUST)</a>, 
<a href="http://sei-international.org/">Stockholm Environment Institute</a>, 
<a href="http://www.uu.nl/en">University of Utrecht</a>, 
Volta Basin Development Foundation (VBDF)
STRING
                            );
                            ?></p>
                        </div>
                    </section>

                    <section>
                        <div class="page-header">
                            <h2  id="bayesian-network-modeling" class="fixed-top-anchor"><?php echo _('Bayesian Network Modeling'); ?></h2>
                        </div>
                        <div class="row-fluid">
                            <img alt="Bayesian Network" src="img/bayes-network.png" style="float:right;width: 50%;height: auto;"/>
                            <p>
                                <?php
                                echo _(<<<STRING
The Bayesian Model calculates a desired outcome, 
<b>'Success'</b>, which is the likelihood that an AWM technology introduced in a target 
community will still be in use 2 years after the intervention project has ended. 
Based on participants' discussions, and using the DFID Sustainable Livelihood Framework 
(DFID, 1999), 'Success' is conditional on adequate levels of 5 <b>capitals</b>: Human, 
Social, Financial, Physical and Natural. Water resources are included as a separate 6<sup>th</sup> 
capital given its centrality to AWM. Each <b>capital</b> comprises 2-4 key <b>factors</b> 
(e.g. Human capital is a combination of <b>Labour availability</b>, <b>Skills</b>, and <b>Health</b>). 
Each <b>factor</b> is described by 1-3 <b>data variables</b>, which are the foundation of the model 
(e.g. <b>Labour availability</b> is indicated by the relative size of the <b>working age population</b> 
and the <b>gender ratio</b> in the population).
STRING
                                );
                                ?>
                            </p>
                            <p>
                                <?php
                                echo _(<<<STRING
The <b>linking arrows</b> convey the conditional probabilities 
of how each node in the network influences the presence of the next node. The model 
calculates the probability that the <b>factor</b> is present given knowledge about 
the state of its <b>data variable</b> (high, medium or low), then the probability 
that the <b>capital</b> is present given the calculated state of its <b>factors</b>, then the 
probability that <b>Success</b> is present given the calculated state of all <b>capitals</b>. 
A similar application of Bayesian network modelling to analyse the likelihood of 
water poverty is explained in detail in <a href='http://www.sei-international.org/publications?pid=1456' target='_blank'>Kemp-Benedict et al. (2009)</a>.
STRING
                                );
                                ?>
                            </p>
                        </div>
                    </section>

                    <section>
                        <div class="page-header">
                            <h2  id="basins" class="fixed-top-anchor"><?php echo _('The Basins'); ?></h2>
                        </div>
                        <div class="row-fluid">
                            <div class="span9">
                                <h4 id="volta-basin" class="fixed-top-anchor"><?php echo _('The Volta Basin'); ?></h4>
                                <p>
                                    <?php
                                    echo _(<<<STRING
The Volta Basin has a surface area of 407,000 km<sup>2</sup>, 
covering parts of Burkina Faso, Ghana, Benin, Cote d'Ivoire, Mali and Togo. The TAGMI for the Volta Basin 
covers Northern Ghana and Burkina Faso, which collectively represent 85% of the basin. 
The basin's farmers, some of the poorest in the world, generally rely on rainfed agriculture. 
Annual average rainfall distribution ranges from 2000mm in the south to 500mm in the north. 
Potential evaporation rates range from 1500 mm in the south to over 2500 mm in the north, 
meaning that less than 10% of rainfall is available for river flow (<a href='http://www.glowa-volta.de/volta_basin.html' target='_blank'>GLOWA 2013</a>). 
Even when rainfall is adequate for cropping, its uneven distribution leads to a high risk of crop loss; 
moreover, the lack of incentives means a situation where farmers are reluctant to 
invest in agriculture and water management. Climate change is making already variable 
rainfall less reliable. Farmers must have access to reliable water supplies. Small reservoirs, 
locally maintained and requiring no recurrent energy input are a sustainable supply option (<a href='http://waterandfood.org/basins/volta/' target='_blank'>CPWF 2013</a>). 
The most significant hydrological features is Lake Volta, created post-construction of the Akosombo Dam for hydropower, 
which is the second largest man-made lake in the world. The dam also generates hydroelectricity, ~80% of 
Ghana's power production, and hosts an important small-scale fishery industry (<a href='http://awm-solutions.iwmi.org/?reload' target='_blank'>AgWater Solutions 2012</a>).
STRING
                                    );
                                    ?>
                                </p>
                            </div>
                            <div class="span3">
                                <img alt="basin image" src="img/volta.gif"/>
                            </div>
                        </div>
                        <br/>
                        <div class="row-fluid">
                            <div class="span3">
                                <img alt="basin image" src="img/limpopo.jpg"/>
                            </div>
                            <div class="span9">
                                <h4 id="limpopo-basin" class="fixed-top-anchor"><?php echo _('The Limpopo Basin'); ?></h4>
                                <p>
                                    <?php
                                    echo _(<<<STRING
The Limpopo Basin has a surface area 408 000 km<sup>2</sup>, 
covering parts of Botswana, South Africa, Zimbabwe and Mozambique*.  The basin supports more than 
14 million people in areas of Botswana, Mozambique, South Africa and Zimbabwe. Rainfall is 
highly variable with little run-off available in many parts of the basin to produce 
crops and livestock (<a href='http://waterandfood.org/basins/limpopo-2/' target='_blank'>CPWF 2013</a>). 
Annual average rainfall distribution ranges from 200 mm to 1200 mm, with an average of 530 mm per annum. 
Potential evaporation ranges from 800 mm to 2400 mm per annum. The Limpopo basin is a relatively dry basin 
with most of the water in the highly productive areas already used for irrigation. 
Irrigated agricultural covers 244 000 ha, with the potential for a further 122 000 ha 
in selected sub-catchments. Dryland or rain-fed agriculture includes crop production (234 000 ha), 
pastures (1 780 000 ha) and forestry (455 000 ha) (<a href='http://www.arc.agric.za/limpopo/profile.htm' target='_blank'>ARC 2013</a>). 
Prolonged dry spells are common, making rainfed farming in many areas difficult, while occasional high rainfall events result in uncontrolled 
flooding (<a href='http://waterandfood.org/basins/limpopo-2/' target='_blank'>CPWF 2013</a>).
STRING
                                    );
                                    ?>
                                </p>
                                <p><?php
                                    echo _(<<<STRING
* While TAGMI for the Limpopo Basin covers all countries, 
it is primarily driven by available data and learning events undertaken in Zimbabwe and South Africa. 
Data for Mozambique and Botswana are derived from publicly available global data sets.
STRING
                                    );
                                    ?></p>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div class="page-header">
                            <h2  id="awm-technologies" class="fixed-top-anchor"><?php echo _('The AWM Technologies'); ?></h2>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                <img alt="CA image" src="img/ca.jpg"/>
                            </div>
                            <div class="span9">
                                <h4 id="ca" class="fixed-top-anchor"><?php echo _('Conservation Agriculture'); ?></h4>
                                <p>
                                    <?php
                                    echo _(<<<STRING
Conservation Agriculture (CA) is an approach to managing 
agro-ecological systems. It is designed to enable sustainable and profitable agriculture while 
improving farmers' livelihoods. It is governed by three CA principles: 1) continuous and minimal soil disturbance, 
2) permanent (organic) soil cover and 3) crop diversification and rotation. CA is scalable, 
its principles universally applicable to all agircultural agricultural landscapes but its 
adoption is arguably most urgently required by smallholder farmers. Introducing CA requires 
that farmers accept a change in their existing crop management system, employ technologies 
that help manage cover crops, and adopt a new way of thinking with respect to weed management 
and livestock/cropping interactions. <a href='http://www.fao.org/ag/ca/' target='_blank'>More info from the FAO</a>
STRING
                                    );
                                    ?>
                                </p>
                            </div>
                        </div>
                        <br/>
                        <div class="row-fluid">
                            <div class="span9">
                                <h4 id="irrig" class="fixed-top-anchor"><?php echo _('Small scale irrigation'); ?></h4>
                                <p>
                                    <?php
                                    echo _(<<<STRING
These are irrigation systems that 
are developed, owned or managed by individual farmers. They buy or rent irrigation equipment 
and draw water from nearby sources without depending on public agencies or Water Users' 
Associations, for example. In many African countries the smallholder private irrigation 
sector is more important than public irrigation in terms of the number of farmers involved 
and the value of the production. <a href='http://awm-solutions.iwmi.org/small-private.aspx' target='_blank'>More info from IWMI</a>
STRING
                                    );
                                    ?>
                                </p>
                            </div>
                            <div class="span3">
                                <img alt="tapping-groundwater image" src="img/irrig.jpg"/>
                            </div>
                        </div>
                        <br/>
                        <div class="row-fluid">
                            <div class="span4">
                                <img alt="SA image" src="img/sa.png"/>
                            </div>
                            <div class="span8">
                                <h4 id="dams" class="fixed-top-anchor"><?php echo _('Small Reservoirs'); ?></h4>
                                <p>
                                    <?php
                                    echo _(<<<STRING
In most of Sub-Saharan Africa, small reservoirs 
are earthen or cement dams that are less than 7.5 meters high. They provide significant 
opportunities for soil and water conservation, drought proofing and for developing small-scale, 
community-based irrigation schemes. A well-designed reservoir can support multiple water uses 
from livestock watering, fisheries, domestic and small business water use to brick making and handicraft activities. 
<a href='http://awm-solutions.iwmi.org/small-reservoirs.aspx' target='_blank'>More info from IWMI</a>
STRING
                                    );
                                    ?>
                                </p>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div class="page-header">
                            <h2  id="licence" class="fixed-top-anchor"><?php echo _('Licence'); ?></h2>
                        </div>
                        <p>
<?php echo _("This is open source software, released under the <a href='http://www.apache.org/licenses/LICENSE-2.0' target='_blank'>Apache License v. 2.0</a>."); ?>
                        </p>
                        <p>
                            <?php
                            echo _(<<<STRING
The data used in the tool are all sourced from the public domain. Please 
refer to the <a href="documentation.php">metadata</a> for details of the relevant copyright notices.
STRING
                            );
                            ?>
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
        <script type="text/javascript" src="./js/common.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('div#left-nav>ul>li').hover(function () {
                    $(this).find('ul').show();
                    $(this).find('i').removeClass('icon-chevron-right');
                    $(this).find('i').addClass('icon-chevron-down');
                }, function () {
                    $(this).find('ul').hide();
                    $(this).find('i').removeClass('icon-chevron-down');
                    $(this).find('i').addClass('icon-chevron-right');
                })
            });
        </script>
    </body>
</html>
