<?php
global $templatePath;
$templatePath = dirname( __FILE__ );

// require basic functions
require_once $templatePath.'/inc/default-theme-settings.php';

// require init style / scripts
require_once $templatePath.'/inc/init_styles_scripts.php';

// require add theme functions
require_once $templatePath.'/inc/additional-functions.php';

// require acf option page
require_once $templatePath.'/inc/init_acf_optionpage.php';

// init cpt file
require_once $templatePath.'/inc/init_application_cpt.php';

// require ajax contact form
require_once $templatePath.'/inc/ajax-contact-form.php';

// require ajax serach for Blog
require_once $templatePath.'/inc/ajax-search_posts.php';

// elementor custom breadcrumbs widget
require_once $templatePath.'/inc/elementor-widgets/elementor-widget_breadcrumbs.php';

// elementor custom posts widget
require_once $templatePath.'/inc/elementor-widgets/elementor-widget_posts.php';

// elementor custom slider widget
require_once $templatePath.'/inc/elementor-widgets/elementor-widget_primaryslider.php';

// elementor downloadelem widget
require_once $templatePath.'/inc/elementor-widgets/elementor-widget_download.php';

// elementor custom fileselect control
require_once $templatePath.'/inc/elementor-widgets/elementor-control_fileselect.php';

// elementor custom specialnav control
require_once $templatePath.'/inc/elementor-widgets/elementor-widget_specnav.php';

// elementor special table widget
require_once $templatePath.'/inc/elementor-widgets/elementor-widget_specialtable.php';

// elementor two column text block widget
require_once $templatePath.'/inc/elementor-widgets/elementor-widget_twocolumn.php';

// elementor linlinline widget
require_once $templatePath.'/inc/elementor-widgets/elementor-widget_links.php';

// elementor chart element
require_once $templatePath.'/inc/elementor-widgets/elementor-widget_specialchart.php';


