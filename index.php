<?php

//******************************************
//  SMOKING       
//******************************************

// foreach($_SERVER as $sv => $v)
// {
//     echo $sv." ===> ".$v."<br>";
// }

// if($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'http' && str_contains($_SERVER['SERVER_NAME'],'malinime.com') ){
//     $url = str_replace('http','https' ,$_SERVER['SCRIPT_URI'] ?? "");
//     // echo $url;
//     header("Location: ".$url);exit();die();
// }

define("HT_ACCESS",false);

if(in_array("Mozilla",explode("/",$_SERVER['HTTP_USER_AGENT'] ?? array() ))) define("IS_NAVIGATOR",true); else define("IS_NAVIGATOR",false); 

//  FILE SYSTEM
//------------------------------------------


define('SERVER_ROOT',str_replace('index.php','',str_replace("//",'/', $_SERVER['DOCUMENT_ROOT'])));
define('LSERVER_ROOT', str_replace($_SERVER['DOCUMENT_ROOT'],'/',SERVER_ROOT) );
define('ROOT',str_replace('index.php','',str_replace("//",'/', $_SERVER['SCRIPT_FILENAME'])));
define('LROOT', str_replace("//",'/', str_replace('index.php','',str_replace("//",'/', str_replace('malinime.com','', str_replace($_SERVER['DOCUMENT_ROOT'],'/',ROOT) ) ) ) ) );
// echo $_SERVER['SCRIPT_FILENAME']."<br>".$_SERVER['DOCUMENT_ROOT']."<br>ROOT: ".ROOT."<br>LROOT: ".LROOT;exit();

//  LANG
define('FOLDER_LANG',ROOT.'publics/lang/');
define('LFOLDER_LANG',LROOT.'publics/lang/');
define('FOLDER_LINK',ROOT.'publics/link/link.php');
define('LFOLDER_LINK',LROOT.'publics/link/link.php');
//  ROOT
define('FOLDER_ROOT',ROOT.'root/');
define('LFOLDER_ROOT',LROOT.'root/');
//  MODELS
define('FOLDER_MODELS',ROOT.'models/');
define('LFOLDER_MODELS',LROOT.'models/');
//  CONTROLLERS
define('FOLDER_CONTROLLERS',ROOT.'controllers/');
define('LFOLDER_CONTROLLERS',LROOT.'controllers/');
//  VIEWS
define('FOLDER_VIEWS',ROOT.'views/');
define('FOLDER_VIEWS_PAGES',ROOT.'views/pages/');
define('FOLDER_VIEWS_TEMPLATES',ROOT.'views/templates/');
//  PUBLICS
define('FOLDER_PUBLICS',ROOT.'publics/');
define('LFOLDER_PUBLICS',LROOT.'publics/');
//  CSS
define('FOLDER_CSS',ROOT.'publics/css/');
define('LFOLDER_CSS',LROOT.'publics/css/');
define('FOLDER_BASICS',ROOT.'publics/css/basics/');
define('LFOLDER_BASICS',LROOT.'publics/css/basics/');
define('FOLDER_CSS_PARTIALS',ROOT.'publics/css/partials/');
define('LFOLDER_CSS_PARTIALS',LROOT.'publics/css/partials/');
define('FOLDER_CSS_PAGES',ROOT.'publics/css/pages/');
define('LFOLDER_CSS_PAGES',LROOT.'publics/css/pages/');
//  JS
define('FOLDER_JS',ROOT.'publics/js/');
define('LFOLDER_JS',LROOT.'publics/js/');
define('FOLDER_JS_PARTIALS',ROOT.'publics/js/partials/');
define('LFOLDER_JS_PARTIALS',LROOT.'publics/js/partials/');
define('FOLDER_JS_PAGES',ROOT.'publics/js/pages/');
define('LFOLDER_JS_PAGES',LROOT.'publics/js/pages/');
//  DATA
define('FOLDER_DATA',ROOT.'publics/res/data/');
define('LFOLDER_DATA',LROOT.'publics/res/data/');
//  FILES
define('FOLDER_FILES',ROOT.'publics/res/files/');
define('LFOLDER_FILES',LROOT.'publics/res/files/');
//  RESSOURCES
define('FOLDER_RESSOURCES',ROOT.'publics/res/');
define('LFOLDER_RESSOURCES',LROOT.'publics/res/');
define('FOLDER_RESSOURCES_IMAGES',ROOT.'publics/res/images/');
define('LFOLDER_RESSOURCES_IMAGES',LROOT.'publics/res/images/');
define('FOLDER_RESSOURCES_VIDEOS',ROOT.'publics/res/videos/');
define('LFOLDER_RESSOURCES_VIDEOS',LROOT.'publics/res/videos/');
define('FOLDER_IMAGES_COUNTRIES',ROOT.'publics/res/images/countries/');
define('LFOLDER_IMAGES_COUNTRIES',LROOT.'publics/res/images/countries/');
define('FOLDER_IMAGES_ITEMS',ROOT.'publics/res/images/items/');
define('LFOLDER_IMAGES_ITEMS',LROOT.'publics/res/images/items/');
define('FOLDER_IMAGES_POSTER',ROOT.'publics/res/images/poster/');
define('LFOLDER_IMAGES_POSTER',LROOT.'publics/res/images/poster/');
define('FOLDER_IMAGES_PRODUCT',ROOT.'publics/res/images/product/');
define('LFOLDER_IMAGES_PRODUCT',LROOT.'publics/res/images/product/');
define('FOLDER_IMAGES_PANNEAUX',ROOT.'publics/res/images/panneaux/');
define('LFOLDER_IMAGES_PANNEAUX',LROOT.'publics/res/images/panneaux/');
//  LOGO & ICON
define('FOLDER_LOGO',ROOT.'publics/res/logo/v1/');
define('LFOLDER_LOGO',LROOT.'publics/res/logo/v1/');
define('FOLDER_ICON',ROOT.'publics/res/icon/v1/');
define('LFOLDER_ICON',LROOT.'publics/res/icon/v1/');
// CUTOMER
define('FOLDER_CUSTOMER_IMAGE',ROOT.'publics/res/images/customers/');
define('LFOLDER_CUSTOMER_IMAGE',LROOT.'publics/res/images/customers/');
// SELLER
define('FOLDER_ANIME_POSTER',ROOT.'publics/res/images/anime/poster/');
define('LFOLDER_ANIME_POSTER',LROOT.'publics/res/images/anime/poster/');

define('FOLDER_ANIME_CHARACTERS',ROOT.'publics/res/images/anime/characters/');
define('LFOLDER_ANIME_CHARACTERS',LROOT.'publics/res/images/anime/characters/');

define('FOLDER_ANIME_COMMENT',ROOT.'publics/res/images/anime/comment/');
define('LFOLDER_ANIME_COMMENT',LROOT.'publics/res/images/anime/comment/');

define('FOLDER_ANIME_VIDEO',ROOT.'publics/res/images/anime/video/');
define('LFOLDER_ANIME_VIDEO',LROOT.'publics/res/images/anime/video/');

define('FOLDER_ANIME_SRC',ROOT.'publics/res/src/');
define('LFOLDER_ANIME_SRC',LROOT.'publics/res/src/');

define('FOLDER_ANIME_PUBS',ROOT.'publics/res/images/anime/pubs/');
define('LFOLDER_ANIME_PUBS',LROOT.'publics/res/images/anime/pubs/');

define('FOLDER_ANIME_BRANDING',ROOT.'publics/res/images/anime/branding/');
define('LFOLDER_ANIME_BRANDING',LROOT.'publics/res/images/anime/branding/');

define('FOLDER_ANIME_SOURCE',ROOT.'publics/res/src/');
define('LFOLDER_ANIME_SOURCE',LROOT.'publics/res/src/');

define('FOLDER_GAME',ROOT.'publics/res/images/game/');
define('LFOLDER_GAME',LROOT.'publics/res/images/game/');

define('FOLDER_USERS',ROOT.'publics/res/images/users/');
define('LFOLDER_USERS',LROOT.'publics/res/images/users/');

//  WEB SYSTEM INFO
//------------------------------------------

define('SITE_NAME','Malinime');
define('SITE_PHONE','+212644286569');
define('SITE_EMAIL','contact@malinime.com');

define('SITE_WHATSAPP','https://api.whatsapp.com/send?phone=');
define('SITE_YOUTUBE','https://www.youtube.com/@malinime');
define('SITE_FACEBOOK','https://facebook.com/malinime');
define('SITE_TIKTOK','https://tiktok.com/@malinime1');
define('SITE_INSTA','https://instagram.com/malinime1');
define('SITE_TWITTER','https://twitter.com/malinime1');
define('SITE_HOST_NAME',$_SERVER['SERVER_NAME'] ?? 'localhost');
define("SITE_HTTP_HOST",($_SERVER['REQUEST_SCHEME'] ?? "")."://".(SITE_HOST_NAME));
$date = getdate();
define('COPYRIGHT_YEAR',$date['year'] ?? '2022');
define('POWERED_BY','Adams');
define('POWERED_BY_LINK',''); // https://twitter.com/adamstrvor
define('RST','1000px');
define('RSM','900px');

//  DATABASE SYSTEM INFO
//------------------------------------------

define('DB_CONNECTION','mysql');
define('DB_HOST',str_contains($_SERVER['SERVER_NAME'] ?? "none",'malinime.com') ? '185.98.131.177' : "localhost");
define('DB_NAME',str_contains($_SERVER['SERVER_NAME'] ?? "none",'malinime.com') ? 'bater1757071_166zsh' : "MALINIMES"); // SCHOOL
define('DB_PORT',"3306");
define('DB_USERNAME',str_contains($_SERVER['SERVER_NAME'] ?? "none",'malinime.com') ? 'bater1757071_166zsh' : "root");// bater1757071
define('DB_PASSWORD',str_contains($_SERVER['SERVER_NAME'] ?? "none",'malinime.com') ? "Agd13Gdf\$hd4F" : "Maliba2002$");// j1t9tk1kA$

//  MAIL SYSTEM INFO
//------------------------------------------

define('MAIL_MAILER','smtp');
define('MAIL_HOST','mailhog');
define('MAIL_PORT','1025');
define('MAIL_USERNAME','');
define('MAIL_PASSWORD','');
define('MAIL_ENCRYPTION','');
define('MAIL_FROM_ADDRESS','service@smoking.com');
define('MAIL_FROM_NAME',SITE_NAME);

//  COOKIE INFO
//------------------------------------------

define('COOKIE_TIME', time() + 86400 * 30);
define('COOKIE_LOG_TIME_LONG', time() +  86400 * 365);
define('COOKIE_PATH','/');
define('COOKIE_SECURE',false);
define('COOKIE_HTTP_ONLY',false);
define('SESSION','VS');
//  USER COOKIES
define('COOKIE_REQUEST_TIME','RT');
define("COOKIE_USER_COUNTRY","UC");
define("COOKIE_USER_DEVISE","UD");
define("COOKIE_USER_LANG","UL");
define("COOKIE_CUSTOMER_ID","CI");


try
{
    // INITIALISATION
    //------------------------------------------
    
    require_once(FOLDER_ROOT.'model.php');
    require_once(FOLDER_ROOT.'controller.php');
    $root = new Controller();
    $model = new Model();

    // echo $root->translate('Bonjour','en','fr');exit();
    
    //  GLOBAL OBJECT
    //------------------------------------------

    $_COOKIE[SESSION] = json_decode($_COOKIE[SESSION] ?? "{}",true) ?? array();
    define("LINK",$root->link());
    define("DEFAULT_LANG",'fr');
    define("LANG",$root->get_lang( $_COOKIE[COOKIE_USER_LANG] ?? explode('-',$_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? "fr")[0],DEFAULT_LANG));
    define("LANG_STRING",['ar'=>"العربية",'fr'=>"Français",'en'=>"English",'ko'=>"한국인","ja"=>"日本",'bm'=>"Bambara"]);
    define("LANG_LIST",$root->lang_list());
    define("COUNTRIES",$root->all_name());
    define("CAPITALS",$root->all_capital());
    define("DEVISES",$root->all_devise());
    define("PHONE_CODES",$root->all_phone());

    //  USER INFO
    //------------------------------------------
    
    define('REQUEST_TIME',$_COOKIE[COOKIE_REQUEST_TIME] ?? 1);
    define('USER_INFO',$root->country_info($_COOKIE[COOKIE_USER_COUNTRY] ?? null) ?? null);
    define('USER_LANG', LANG_SYSTEM);
    define('USER_DEVISE', USER_INFO['DEVISE'] ?? "MAD");
    define('USER_COUNTRY', USER_INFO['COUNTRY'] ?? "MA");
    define('USER_COUNTRY_NAME', USER_INFO['COUNTRY_NAME'] ?? "MA");
    define('USER_CITY', USER_INFO['CITY'] ?? "Fès");
    define('USER_REGION', USER_INFO['REGION'] ?? "");
    define('USER_LOCALISATION', USER_INFO['LOCALISATION'] ?? "");
    define('USER_TIMEZONE', USER_INFO['TIMEZONE'] ?? "");
    define('USER_HOSTNAME', USER_INFO['HOSTNAME'] ?? "");
    define('USER_ORG', USER_INFO['ORG'] ?? "");
    define('USER_COUNTRY_PHONE', USER_INFO['COUNTRY_PHONE'] ?? "212");
    define("TRANSLATE_DEVISE",['XOF'=>'FCFA','MAD'=>'DH']);

    if(IS_NAVIGATOR == true)
    {
        setcookie(COOKIE_REQUEST_TIME,($_COOKIE[COOKIE_REQUEST_TIME] ?? 0) + 1,COOKIE_TIME,COOKIE_PATH,SITE_HOST_NAME,COOKIE_SECURE,COOKIE_HTTP_ONLY);

        if(empty($_COOKIE[COOKIE_USER_LANG]))
        setcookie(COOKIE_USER_LANG,USER_LANG,COOKIE_TIME,COOKIE_PATH,SITE_HOST_NAME,COOKIE_SECURE,COOKIE_HTTP_ONLY);

        if(empty($_COOKIE[COOKIE_USER_COUNTRY]))
        setcookie(COOKIE_USER_COUNTRY,USER_COUNTRY,COOKIE_TIME,COOKIE_PATH,SITE_HOST_NAME,COOKIE_SECURE,COOKIE_HTTP_ONLY);
    }
    else
    {

    }
    
    // ob_start();

    // REQUEST
    //------------------------------------------
    ob_start();
    $request = $_GET['page'] ?? "";
    define("PAGE",$request);
    $request_body = explode('/',$request);
    $module = !empty($request_body[0]) ? $request_body[0] : 'main';
    $page = !empty($request_body[1]) ? $request_body[1] : 'main';
    $params = array_slice($request_body,1);

    if(HT_ACCESS == true);
    {
        $pos = strpos($_SERVER['REQUEST_URI'] ?? "",'?') ;
        $get_string = str_replace('?','&', substr($_SERVER['REQUEST_URI'],$pos + 1) );
        $get = explode('&',$get_string);
        foreach($get as $g)
        {
            $tmp = explode('=',$g);
            $_GET["$tmp[0]"] = $tmp[1] ?? "";
            $_REQUEST["$tmp[0]"] = $tmp[1] ?? "";
        }
    }

    ob_get_clean();

    $model->add_request($request);

    // print_r($request_body);

    // ROUTING
    //------------------------------------------

    if(file_exists(FOLDER_CONTROLLERS.$module.'.php') && $module != 'main')
    {
        $root->load_controller($module);
        if(class_exists(ucfirst($module)) && method_exists($module,$page))
        {
            $con = new $module();
            $con->$page($params);
        }
        else
        throw New Exception("404");
    }
    else
    {
        $root->load_controller('main');
        $main = new Main();
        
        if(method_exists($main,$module))
        {
            $main->$module($params);
        }
        else
            throw New Exception("404");
    }

    //ob_get_clean();
    
}
catch(Exception $e)
{
    // ROUTING ERROR
    //------------------------------------------

    $code = $e->getMessage();
    $root = new controller;
    if($code == '404')
    {
    $view = 'error/404';
    $var['css_folder'] = 'error/404';
    $var['title'] = ' Page introuvable ';
    http_response_code(404);
    }
    else if($code == '403')
    {
    $view = 'error/403';  
    $var['css_folder'] = 'error/403';
    $var['title'] = ' Accès interdit ! ';  
    http_response_code(403);
    }
    else
    {
    $view = 'error/index';  
    $var['css_folder'] = 'error/index';
    $var['title'] = ' Une erreur est survenue ';  
    }
    $var['message'] = $code;

    $root->render($view,$var,'error');

}

?>