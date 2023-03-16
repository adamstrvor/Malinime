<?php

//***************
//  ERROR TEMPLATE
//***************

// TEMPLATE VARIABLES
//------------------------------------------

    $template = $var['template'] ?? "error";
    $title = $var['title'] ?? LANG[''] ?? " Erreur  ";
    $initial_scale = $var['initial_scale'] ?? '0.8';
    $scalable = $var['scalable'] ?? 'no';
    $description = $var['description'] ?? LANG[''] ?? " Page d'erreurs ";
    $keywords = $var['keywords'] ?? LANG[''] ?? "";

    $GLOBAL_NOTIF = $var['global_notif'] ?? $_COOKIE[SESSION]['GLOBAL_NOTIF'] ?? null;
    $_COOKIE[SESSION]['GLOBAL_NOTIF'] = null;
    $ERROR = $var['error'] ?? $_COOKIE[SESSION]["ERROR"] ?? null;
    $_COOKIE[SESSION]["ERROR"] = null;

    $css_folder = $var['css_folder'] ?? 'main/index';
    $js_folder = $var['js_folder'] ?? 'main/index';

    ob_start();
    if(IS_NAVIGATOR == true)
    {
    setcookie(SESSION,json_encode($_COOKIE[SESSION] ?? null), COOKIE_TIME,COOKIE_PATH,SITE_HOST_NAME,COOKIE_SECURE,COOKIE_HTTP_ONLY);
    }
    ob_get_clean();

?>

<!-- /////////////////////////////////////////////////////////////////////// -->


<!DOCTYPE html>
<html lang="<?= LANG_SYSTEM ?? "fr" ?>" >
<head>
    <meta charset="UTF-8">
    <title> <?= SITE_NAME ?? "Baterenako"; ?> <?= ' | '.$title ?> </title>
    <meta name="viewport" content="initial-scale=<?= $initial_scale ?? '0.8';  ?>,width=device-width,user-scalable=<?=  $scalable ?? 'no'; ?>" >
    <meta name="description" content="<?=  $description; ?>" >
    <meta name="keywords" content="<?=  $keywords; ?>">

    <?php include_once(FOLDER_DATA.'meta.php'); ?>
    <?php include_once(FOLDER_DATA.'link.php'); ?>
    <?php $partials = scandir(FOLDER_CSS_PARTIALS.$template.'/');foreach($partials as $p){ if(str_split($p)[0] != '.'){ ?> <link rel="stylesheet" <?php if(str_split($p)[0] == 'm' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RSM ?? '700px';?>)" <?php }else if(str_split($p)[0] == 't' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RST ?? '1000px';?>)" <?php } ?> type="text/css" href="<?= LFOLDER_CSS_PARTIALS.$template.'/'.$p; ?>"> <?php } } ?>
    <?php $css = scandir(FOLDER_CSS_PAGES.$css_folder.'/');foreach($css as $p){ if(str_split($p)[0] != '.'){ ?> <link rel="stylesheet" <?php if(str_split($p)[0] == 'm' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RSM ?? '700px';?>)" <?php }else if(str_split($p)[0] == 't' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RST ?? '1000px';?>)" <?php } ?> type="text/css" href="<?= LFOLDER_CSS_PAGES.$css_folder.'/'.$p; ?>"> <?php } } ?>
    <?php include_once(FOLDER_DATA.'script.php'); ?>
    <?php $js = scandir(FOLDER_JS_PAGES.$js_folder.'/');foreach($js as $p){ if(str_split($p)[0] != '.'){ ?> <script src="<?= LFOLDER_JS_PAGES.$js_folder.'/'.$p; ?>"></script> <?php } } ?>
    
</head>
<body onselectstart="return false;" dir="<?= LANG_DIR ?? "ltr"; ?>" >

<script>

    var r = document.querySelector(":root");

    // var rs = getComputedStyle(r);
    // alert("The value of --blue is: " + rs.getPropertyValue('--blue'));

    r.style.setProperty('--color-theme','<?= !empty($_COOKIE[SESSION]['DARK_MODE']) && $_COOKIE[SESSION]['DARK_MODE'] == 'black' ? 'white' : 'black' ; ?>');
    r.style.setProperty('--color-theme-bg','<?= !empty($_COOKIE[SESSION]['DARK_MODE']) && $_COOKIE[SESSION]['DARK_MODE'] == 'black' ? 'black' : 'white' ; ;?>');

</script>

<header>


    <div class="desktop">

        <a href="<?= LINK['MAIN'] ?? "" ?>" class="logo"> <img src="<?= LFOLDER_LOGO ?? "" ;?>logo.png" alt="logo"> </a>

    </div>

    <!-- ....................................................  -->

    <div class="mobile">

    </div>

</header>

<!-- ************************************************************** -->
<div class="body">
<?= $view ?? null ?>
</div>
<!-- ************************************************************** -->

<footer>

    </div>

    <address> © <?= COPYRIGHT_YEAR ?? "2023" ;?> <?= LANG['COPYRIGHT'] ?? "Tous les droits sont réservés !" ?> - <a href="<?= POWERED_BY_LINK ?? "" ?>" target="_blank"> <?= LANG["POWERED_BY"] ?? "Desgined by" ?> <?= POWERED_BY ?? "Adams" ?> </a> </address>

</footer>

</body>
</html>