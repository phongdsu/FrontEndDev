<?php
// ------------------------------------------------------
// Allow for massive processing
// ------------------------------------------------------
ini_set('max_execution_time',600);
ini_set('memory_limit','1024M');
// ------------------------------------------------------
// Set whether this is a non index.php page
// (i.e, lives in the _engine/php directory)
// ------------------------------------------------------
$booProjectCall = true;
// ------------------------------------------------------
// Include config file
// ------------------------------------------------------
require_once('_engine/config.php');
// ------------------------------------------------------
// Include the main controller file
// ------------------------------------------------------
require_once('../core/_engine/php/init/_controller.php');
// ------------------------------------------------------
// Set whether this is a tool page or not
// Load appropriate _engine page
// ------------------------------------------------------
if(isset($_GET['tool'])) {
//  ------------------------------------------------------
//  Set to tool page
//  ------------------------------------------------------
    $booIsTool = true;
//  ------------------------------------------------------
//  Detect which tool
//  ------------------------------------------------------
    $strTool = $_GET['tool'];
//  ------------------------------------------------------
//  Get/set page
//  ------------------------------------------------------
    $strPage = 'home';
    $strView = '';
    if(isset($_GET['page'])) {
        $strPage = $_GET['page'];
    }
    if(isset($_GET['view'])) {
        $strView = $_GET['view'];
    } 
//  ------------------------------------------------------
//  Check for management type
//  ------------------------------------------------------
    $strManageType = '';
    if(isset($_GET['mtype'])) {
        $strManageType = $_GET['mtype'];
    }
//  ------------------------------------------------------
//  Set redirect instructions based on page type
//  ------------------------------------------------------
    switch($strTool) {
        case 'admin':
            if(!isset($_SESSION['booAdminLoggedIn']) || !$_SESSION['booAdminLoggedIn']) {
                $strRedirectPath = './?login';
                if(isset($_SESSION['booLoggedIn']) && $_SESSION['booLoggedIn']) {
                    $strRedirectPath = './';
                }
                header('location: '.$strRedirectPath);
            }
            break;
        default:
            if(!isset($_SESSION['booSomeoneLoggedIn'])) {
                header('location: ./?login');
            }
            else if(isset($_SESSION['booSomeoneLoggedIn']) && $_SESSION['strUserRole'] == 'Client' && $strTool != 'edit-profile') {
                header('location: ./');
            }
            break;
    }  
//  ------------------------------------------------------
//  Include header
//  ------------------------------------------------------
    require_once('../core/_engine/php/_includes/tools_header.php');
//  ------------------------------------------------------
//  Get home page
//  ------------------------------------------------------
    require_once('../core/_engine/php/'.$strTool.'/pages/'.$strPage.'.php');
//  ------------------------------------------------------
//  Include header
//  ------------------------------------------------------
    require_once('../core/_engine/php/_includes/tools_footer.php');    
}
else {
//  ------------------------------------------------------
//  Set to non tool page
//  ------------------------------------------------------
    $booIsTool = false;
//  ------------------------------------------------------
//  Check for logout page or 
//  ------------------------------------------------------
    if(isset($_GET['login'])) {
//      ------------------------------------------------------
//      Include html
//      ------------------------------------------------------
        require_once('../core/_engine/php/_includes/project_login.php');
    }
    else {
//      ------------------------------------------------------
//      Capture all data files
//      ------------------------------------------------------
        $arrDataFiles = glob('_engine/data/*.php');
//      ------------------------------------------------------
//      Include html
//      ------------------------------------------------------
        require_once('../core/_engine/php/_includes/project_index.php');
    }
}
?>
