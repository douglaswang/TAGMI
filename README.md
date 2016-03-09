# TAGMI
An interactive interface for a spatially explicit Bayesian Belief Network tool: http://iwmi-tagmi.cloudapp.net/index.php
## About
This repository contains the code for the user interface, and fetching data from PostGIS in order to display the results spatially explicitly. 

It was developed originally as part of the CGIAR Challenge Program for Water and Food (CPWF) V1 and L1 ['Targeting and Scaling out'](http://www.sei-international.org/tagmi-targeting-agwater-management-interventions) project in [Limpopo](http://waterandfood.org/basins/limpopo-2/) and [Volta](http://volta.waterandfood.org) Basins. Further improvements to the interface were made under the IWMI projects "Enhancing uptake and socio-economic benefits of shallow groundwater irrigation in the White Volta Basin" (Research into Use), and "Targeting investments in Groundwater irrigation in the White Volta Basin". (learn more [here](http://www.sei-international.org/publications?pid=2771))

Comments and questions: tagmi@sei-international.org
## TAGMI tool
Each application of the TAGMI tool to a new geographical location has a separate page hosted on the website. The upper right panel of the tool pages of the website contain the result of the spatially explicit Bayesian Belief network model run.
A location may have several technologies configured for it.
### Tool page
For each technology (chosen on the left panel of the tool page), the model as compiled by the stakeholders and researchers appears. In the modification pane below the result map, one can view an image of the Bayesian Network (Bayesian Network image tab) and the settings used by the model for the relationships between capital and success (Capital tab), factor and capital (Factor tab) and data and factor (Data tab).
### Changing technology
When another technology is chosen from the drop-down menu on the left panel, the compiled model for that location and technology is called from the database and run.

### Making changes to the settings
When the Model Customisation pane is engaged (by ticking the box ‘Include following model customisation in calculation’, the interface builds a new model network by calculating CPTs using the values in the customisation pane and saves a new version in the /temp folder when the customisation is run. The user can therefore see what relationships were used by the stakeholders and researchers, and change them to suit his/her perception. 

**Capitals** can be Essential or Important (allows user to distinguish 1 or 2 capitals as particularly relevant above the others)

**Factors** can have 5 levels of weight modifying their calculated probability: Essential – Very Important – Important – Somewhat important – not significant (allows user to qualify how important factors are in relation to each other – some might not be as important as others and therefore their probability as calculated from the data nodes is not completely taken into account, whereas those marked as Essential are completely taken into account).

**Data** can have a Positive or Negative relationship to the factor (i.e. high data is likely to mean high factor vs high data is likely to mean low data); and the relationship can have 3 levels of strength: Very strong - Strong – Weak. (Allows user to describe roughly how the data represents the factor; the level of detail in the modification allowed here is likely to increase in further code updates).

The default model is in /config.
## 

