<?php

//***************
//  MAIN TEMPLATE
//***************

// TEMPLATE VARIABLES
//------------------------------------------

    $REQUEST_TIME = $var['request_time'] ?? REQUEST_TIME;
    $template = $var['template'] ?? "main";
    $title = $var['title'] ?? (LANG["HEAD_SLOGAN"] ?? " Regardez vos animes préféré en streaming  ");
    $initial_scale = $var['initial_scale'] ?? '0.8';
    $scalable = $var['scalable'] ?? 'no';
    $robots = $var['robots'] ?? "index,follow";
    $description = $var['description'] ?? (LANG["HEAD_DESCRIPTION"] ?? " Bienvenue sur ".SITE_NAME." ! </span><br> Découvrez le meilleur des séries animées gratuitement en streaming : One piece, Naruto, Bleach....") ;
    $keywords = $var['keywords'] ?? (LANG["HEAD_KEYWORDS"] ?? "anime,streaming,one piece,anime-sama,naruto,boruto,voiranime,netflix,crunchy roll,japan,japon,animation,series,film,vostfr,vf");

    $GLOBAL_NOTIF = $var['global_notif'] ?? $_COOKIE[SESSION]['GLOBAL_NOTIF'] ?? null;
    $_COOKIE[SESSION]['GLOBAL_NOTIF'] = null;
    $ERROR_FORM = $var['error_form'] ?? $_COOKIE[SESSION]["ERROR_FORM"] ?? null;
    $_COOKIE[SESSION]['ERROR_FORM'] = null;
    if(empty($_COOKIE[SESSION]['DARK_MODE'])){ $_COOKIE[SESSION]['DARK_MODE'] = "white"; }

    $css_folder = $var['css_folder'] ?? 'main/index';
    $js_folder = $var['js_folder'] ?? 'main/index';
    $PAGE = $var['page'] ?? "index";
    $PLATFORM = $var['platform'] ?? "CUSTOMER";

    $CURRENT_TIME = $var['currentTime'] ?? null;

    $CONNECTED = $var['connected'] ?? false;
    $USER = $var['user'] ?? null;

    $ROOT = new Controller;
    $MODEL = new Model;
    
// GLOBAL INFO
//------------------------------------------

    $all_anime = $MODEL->select("SELECT * FROM ANIMES");
    $i=0;
    if(!empty($all_anime)){
    foreach($all_anime as $a)
    {
        $var['suggestion'][] = strtolower( $a['FULL_NAME'] ?? "" );
        $i++;
    }
    foreach($all_anime as $a)
    {
        $var['suggestion'][] = strtolower( $a['ROMANJI'] ?? "" );
        $i++;
    }
    }

    // print_r($var['suggestion']);

    $SUGGESTION = $var['suggestion'] ?? ['one piece','naruto','hunter','kuroko','kuroko\'s basket','basket','basketball','ecchi','romance','drame','sport','aventure','supernaturelle'];
    $description = $description.' '.join(" , ",$SUGGESTION);
    $keywords = join(",",$SUGGESTION).','.$keywords;

// SAVE
//------------------------------------------

    ob_start();
    if(IS_NAVIGATOR == true)
    {
    setcookie(SESSION,json_encode($_COOKIE[SESSION] ?? null), COOKIE_TIME,COOKIE_PATH,SITE_HOST_NAME,COOKIE_SECURE,COOKIE_HTTP_ONLY);
    }
    ob_get_clean();

?>

<!-- /////////////////////////// -->


<!DOCTYPE html>
<html lang="<?= LANG_SYSTEM ?? "fr" ?>" >
<head>
    <meta charset="UTF-8">
    <title> <?= empty($var['title']) ? (SITE_NAME ?? "Malinime").' - ' : "" ?> <?= $title ?> </title>
    <meta name="viewport" content="initial-scale=<?= $initial_scale ?? '0.8';  ?>,width=device-width,user-scalable=<?=  $scalable ?? 'no'; ?>" >
    <meta name="description" content="<?=  $description ?? ""; ?>" >
    <meta name="keywords" content="<?=  $keywords ?? ""; ?>" >
    <meta name="robots" content="<?=  $robots ?? ""; ?>" >

    <?php include_once(FOLDER_DATA.'meta.php'); ?>
    <?php include_once(FOLDER_DATA.'link.php'); ?>
    <?php $partials = scandir(FOLDER_CSS_PARTIALS.$template.'/');foreach($partials as $p){ if(str_split($p)[0] != '.'){ ?> <link rel="stylesheet" <?php if(str_split($p)[0] == 'm' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RSM ?? '700px';?>)" <?php }else if(str_split($p)[0] == 't' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RST ?? '1000px';?>)" <?php } ?> type="text/css" href="<?= LFOLDER_CSS_PARTIALS.$template.'/'.$p; ?>"> <?php } } ?>
    <?php $css = scandir(FOLDER_CSS_PAGES.$css_folder.'/');foreach($css as $p){ if(str_split($p)[0] != '.'){ ?> <link rel="stylesheet" <?php if(str_split($p)[0] == 'm' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RSM ?? '700px';?>)" <?php }else if(str_split($p)[0] == 't' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RST ?? '1000px';?>)" <?php } ?> type="text/css" href="<?= LFOLDER_CSS_PAGES.$css_folder.'/'.$p; ?>"> <?php } } ?>
    <?php include_once(FOLDER_DATA.'script.php'); ?>
    <?php $js = scandir(FOLDER_JS_PAGES.$js_folder.'/');foreach($js as $p){ if(str_split($p)[0] != '.'){ ?> <script src="<?= LFOLDER_JS_PAGES.$js_folder.'/'.$p; ?>"></script> <?php } } ?>

    <script type="application/ld+json">
    {
      "@context": "https://malinime.com",
      "@type": "WebSite",
      "name" : "<?= LANG['SEARCH_ANIME'] ?? "Recherchez vos ainmes...." ?>",
      "description" : "<?= LANG['HEAD_DESCRIPTION'] ?? " Découvrez tout plein de nouveau series One piece , Demon Slayer, Bleach " ?>",
      "url": "https://malinime.com",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "https://malinime.com/?page=search&q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    
</head>

<body dir="<?= LANG_DIR ?? "ltr" ?>">


<script>

    const d = new Date();
    var h = d.getHours();

    <?php if(empty($_COOKIE[SESSION]['DARK_MODE_SETTED'])){ ?>

    var r = document.querySelector(":root");


    if( (h >= 20 && h <= 23 ) || (h >=0 && h < 9) )
    {
        // r.style.setProperty('--color-theme','white');
        // r.style.setProperty('--color-theme-bg','black');

        r.style.setProperty('--color-theme','black');
        r.style.setProperty('--color-theme-bg','white');
    }
    else
    {
        r.style.setProperty('--color-theme','black');
        r.style.setProperty('--color-theme-bg','white');
    }

    // r.style.setProperty('--color-special','<?= $_COOKIE[SESSION]['DARK_MODE'] == 'black' ? 'orange' : 'rgb(53, 105, 201)' ; ?>');

    <?php }else{ ?>

    var r = document.querySelector(":root");

    // var rs = getComputedStyle(r);
    // alert("The value of --blue is: " + rs.getPropertyValue('--blue')); #3d3d3d #212121 #2c2c2c

    r.style.setProperty('--color-theme','<?= $_COOKIE[SESSION]['DARK_MODE'] == 'black' ? 'white' : 'black' ; ?>');
    r.style.setProperty('--color-theme-bg','<?= $_COOKIE[SESSION]['DARK_MODE'] == 'black' ? 'black' : 'white' ; ;?>');
    // r.style.setProperty('--color-special','<?= $_COOKIE[SESSION]['DARK_MODE'] == 'black' ? 'orange' : 'rgb(53, 105, 201)' ; ?>');

    <?php } ?>



</script>


<!-- <a href="<?= LINK['PANNEAUX'] ?? ""; ?>" target="_blank" class="panneaux"> <img src="<?= LFOLDER_IMAGES_PANNEAUX ?? ""; ?>0.gif" alt=""> </a> -->

<?php if($PAGE != 'EMBED'){ ?>

<header>

    <div class="GLOBAL_WAITING">
        <div class="logo"> <img src="<?= LFOLDER_ICON ?? '' ; ?>(96x96)_.png" alt=""> </div>
        <!-- <div class="msg"> <?= LANG['WAITING'] ?? "Veuillez patientez" ?>... </div> -->
        <!-- <div class="loading"> <span></span> </div> -->
    </div>

    <?php if(!empty($GLOBAL_NOTIF)){ ?>
    <div class="GLOBAL_NOTIF"  >
    <?php foreach($GLOBAL_NOTIF as $g){ ?>
        <span class="<?= $g['class'] ?? "" ;?>" onclick="this.style.display='none';" > <?= $g['msg'] ?? "" ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/></svg> </span>
    <?php } ?>
    </div>
    <?php } ?>

    <!-- ................................................................................  -->

    <div class="desktop">

        <a href="<?= LINK['MAIN'] ?? "" ?>" class="logo"> <img src="<?= LFOLDER_LOGO ?? '' ; ?><?= $_COOKIE[SESSION]['DARK_MODE'] == 'black' ? 'logo.png' : 'logo.png' ; ?>" alt=""> </a>

        <form action="<?= LINK['SEARCH'] ?? "" ?>" method="get" class="search_bar">
        <input type="hidden" name="page" value="search">
        <input type="search" name="q" <?php if(!empty($var['WORD'])){ ?> value="<?= $var['WORD'] ?? ""; ?>" <?php } ?> onfocus="display_suggestion(this,'#suggestion')" onkeyup="display_suggestion(this,'#suggestion')" onblur="close_suggestion('#suggestion')" placeholder="<?= LANG['SEARCH_ANIME'] ?? "Recherchez les animes" ?>..." required id="">
        <button type="submit"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg> </button>
        <div class="suggestion" id="suggestion" >

        </div>
        </form>

        <!-- <div class="categorie"> -->

        <div class="button" onclick="box_display('#categorie');"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid-fill" viewBox="0 0 16 16"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/></svg> 

        <div class="user-options cat" id="categorie">
            <div class="title"> <?= LANG['CATEGORIES'] ?? "Categories" ?> </div>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=romance"> <?= LANG['ROMANCE'] ?? "Romances" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=aventure"> <?= LANG['ADVENTURE'] ?? "Aventures" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=action"> <?= LANG['ACTION'] ?? "Actions" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=drame"> <?= LANG['DRAMES'] ?? "Drames" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=ecchi"> <?= LANG['ECCHI'] ?? "Ecchi" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=horreur"> <?= LANG['HORROR'] ?? "Horreur" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=fantasy"> <?= LANG['FANTASY'] ?? "Fantasy" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=sport"> <?= LANG['SPORT'] ?? "Sport" ?> </a>
        </div>

        </div>

        <!-- <div class="button mode" onclick="open_waiting();setTimeout(dark_mode,500);" >  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16"><path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/><path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/></svg> </div> -->

        <!-- </div> -->

        <div class="options">
        
            <div class="user" onclick="box_display('#userOptions');">
                <div class="img"> <img src="<?= (LFOLDER_IMAGES_ITEMS ?? "")."user.jpg" ;?>" alt=""> </div>
            </div>

            <div class="user-options" id="userOptions">
                <div class="title"> <?= LANG['SETTING'] ?? "Paramètres" ?> </div>

                <!-- <a href="<?= LINK['CUSTOMER_ACCOUNT'] ?? "" ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg> <?= LANG['YOUR_ACCOUNT'] ?? "Votre compte" ?> </a> -->
                <a href="" class="mode" onclick="<?= $PAGE == 'WATCH' ? "" : "open_waiting();"; ?> setTimeout(dark_mode,500);event.preventDefault();exit();" >  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16"><path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/><path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/></svg> <?= LANG['MODE_SWITCH'] ?? "Changer de thème" ?> </a>
                <!-- <a href="" class="mode" onclick="event.preventDefault();open_waiting();changeDark();setTimeout(close_waiting,2000);" >  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16"><path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/><path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/></svg> <?= LANG['MODE_SWITCH'] ?? "Changer de thème" ?> </a> -->
                <?php if($CONNECTED == true){ ?>
                <a href="<?= LINK['CUSTOMER_DECONNEXION'] ?? "" ;?>" class="red" onclick="var test= confirm('Confirmez-vous vouloir vous déconnecter ? '); if(test == false){ event.preventDefault(); }" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16"><path d="M7.5 1v7h1V1h-1z"/><path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/></svg> <?= LANG['SE_DECONNECTER'] ?? "Se déconnecter" ?> </a>
                <?php } ?>
            </div>


        </div>

    </div>

    <!-- ................................................................................  -->

    <div class="mobile">

    <div class="menu-button " onclick="menu_display('#menu_account');"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/></svg> </div>

    <a href="<?= LINK['MAIN'] ?? "" ;?>" class="logo" > <img src="<?= LFOLDER_LOGO ?? '' ; ?><?= $_COOKIE[SESSION]['DARK_MODE'] == 'black' ? 'logo.png' : 'logo.png' ; ?>" alt=""> </a>

    <div class="menu-button no-border" onclick="menu_display('#search_box',true);"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg> </div>
    
    <!-- <div class="menu-button mode no-border" onclick="open_waiting();setTimeout(dark_mode,500);" >  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16"><path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/><path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/></svg> </div> -->


    <!-- // -->

    <div class="search-box" id="search_box">
        
        <div>

        <div class="exit" onclick="menu_close('#search_box',true);" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/></svg> <?= LANG['BACK'] ?? "Retour" ?> </div>

        <form action="<?= LINK['SEARCH'] ?? "" ?>" method="post" class="search">
        <!-- onblur="close_suggestion('#m_suggestion')" -->
            <input type="hidden" name="page" value="search">
            <input type="search" name="q" <?php if(!empty($var['WORD'])){ ?> value="<?= $var['WORD'] ?? ""; ?>" <?php } ?> onfocus="display_suggestion(this,'#m_suggestion')" onkeyup="display_suggestion(this,'#m_suggestion')" placeholder="<?= LANG['SEARCH_ANIME'] ?? "Recherchez les animes" ?>" required id="">
            <button type="submit"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg> </button>
        </form>
        <div class="m_suggestion" id="m_suggestion" >
            
        </div>

        <div class="suggestion_empty"> 
            <div class="svg"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eyeglasses" viewBox="0 0 16 16"><path d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A1.993 1.993 0 0 0 8 6c-.532 0-1.016.208-1.375.547zM14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg> </div>
            <div class="title"> <?= LANG['SEARCH_ENGINE'] ?? "Moteur de recherche" ?> </div>
            <p> <?= LANG['EMPTY_SEARCH_DESC'] ?? "Rechercher tous vos animes préféré en un seul click ... " ?> </p> 
        </div>

        </div>
        
    </div>

    <!-- // -->

    <div class="menu" id="menu_account" >

    <div>
    <div class="exit" onclick="menu_close('#menu_account');" > <?= LANG['BACK'] ?? "Retour" ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/></svg> </div>

        <div class="title"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-wide" viewBox="0 0 16 16"><path d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434L8.932.727zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z"/></svg> <?= LANG['SETTING'] ?? "Paramètres" ?> </div>

        <?php if($CONNECTED == true){ ?>

        <div class="user">
            <div class="img"> <img src="<?= (LFOLDER_IMAGES_ITEMS ?? "")."user.jpg" ;?>" alt=""> </div>
            <span class="name"> <?= "Traore Adama Seydou "; ?> </span>
        </div>

        <?php } ?>
        
        <ul>
            <!-- <a href="<?= LINK['CUSTOMER_ACCOUNT'] ?? "" ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg> <?= LANG['YOUR_ACCOUNT'] ?? "Votre compte" ?> </a> -->
            <a href="" class="mode" onclick="<?= $PAGE == 'WATCH' ? "" : "open_waiting();"; ?> setTimeout(dark_mode,500);event.preventDefault();exit();" >  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16"><path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/><path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/></svg> <?= LANG['MODE_SWITCH'] ?? "Changer de mode" ?> </a>
            <!-- <a href="" class="mode" onclick="event.preventDefault();open_waiting();changeDark();setTimeout(close_waiting,2000);" >  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16"><path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/><path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/></svg> <?= LANG['MODE_SWITCH'] ?? "Changer de thème" ?> </a> -->

            <?php if($CONNECTED == true){ ?>
            <a href="<?= LINK['CUSTOMER_DECONNEXION'] ?? "" ;?>" class="red" onclick="var test= confirm('Confirmez-vous vouloir vous déconnecter ? '); if(test == false){ event.preventDefault(); }" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16"><path d="M7.5 1v7h1V1h-1z"/><path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/></svg> <?= LANG['SE_DECONNECTER'] ?? "Se déconnecter" ?> </a>
            <?php } ?>
        </ul>

        <div class="title">  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/></svg> <?= LANG['ALL_CATEGORIES'] ?? "Toutes les categories" ?> </div>

        <ul>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=romance"> <?= LANG['ROMANCE'] ?? "Romances" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=aventure"> <?= LANG['ADVENTURE'] ?? "Aventures" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=action"> <?= LANG['ACTION'] ?? "Actions" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=drame"> <?= LANG['DRAMES'] ?? "Drames" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=ecchi"> <?= LANG['ECCHI'] ?? "Ecchi" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=horreur"> <?= LANG['HORROR'] ?? "Horreur" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=fantasy"> <?= LANG['FANTASY'] ?? "Fantasy" ?> </a>
            <a href="<?= LINK['CATEGORIE'] ?? "" ;?><?= HT_ACCESS == true ? '?' : '&' ?>q=sport"> <?= LANG['SPORT'] ?? "Sport" ?> </a>
        </ul>

        <?php if($CONNECTED == true){ ?>

        <!-- <div class="title"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plug" viewBox="0 0 16 16"><path d="M6 0a.5.5 0 0 1 .5.5V3h3V.5a.5.5 0 0 1 1 0V3h1a.5.5 0 0 1 .5.5v3A3.5 3.5 0 0 1 8.5 10c-.002.434-.01.845-.04 1.22-.041.514-.126 1.003-.317 1.424a2.083 2.083 0 0 1-.97 1.028C6.725 13.9 6.169 14 5.5 14c-.998 0-1.61.33-1.974.718A1.922 1.922 0 0 0 3 16H2c0-.616.232-1.367.797-1.968C3.374 13.42 4.261 13 5.5 13c.581 0 .962-.088 1.218-.219.241-.123.4-.3.514-.55.121-.266.193-.621.23-1.09.027-.34.035-.718.037-1.141A3.5 3.5 0 0 1 4 6.5v-3a.5.5 0 0 1 .5-.5h1V.5A.5.5 0 0 1 6 0zM5 4v2.5A2.5 2.5 0 0 0 7.5 9h1A2.5 2.5 0 0 0 11 6.5V4H5z"/></svg> <?= LANG['DECONNEXION'] ?? "Déconnexion" ?> </div>

        <ul>
            <a href="<?= LINK['CUSTOMER_DECONNEXION'] ?? "" ;?>" class="red" onclick="var test= confirm('Confirmez-vous vouloir vous déconnecter ? '); if(test == false){ event.preventDefault(); }" > <?= LANG['SE_DECONNECTER'] ?? "Se déconnecter" ?> </a>
        </ul> -->

        <?php } ?>

        <div class="title">  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16"><path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/></svg> <?= LANG['LANGUAGE'] ?? "Langue" ?> </div>

        <form action="<?= LINK['CHANGE_LANG'] ?? "" ;?>" method="post" class="lang">
            <input type="hidden" name="SRC_LANG" value="<?= USER_LANG ?? "" ;?>">

                <select name="TO_LANG" onchange="open_waiting();setTimeout(this.form.submit(),500);" id="eeee">
                    <?php foreach(LANG_LIST as $lang){ ?> <option value="<?= $lang['LANG'] ?? "" ?>" <?= $lang['LANG'] == USER_LANG ? "selected disabled" : "" ;?> > <?= $lang['LANG_STRING'] ?? "" ?> </option> <?php } ?>
                </select>
        </form>

        <br>

        </div>
    </div>

    <!-- // -->

    

</header>

<!-- ********************************************************************************* -->
<div class="body">

<?php } ?>

<?= $view ?? "Not displayed" ;?>

<?php if($PAGE != 'EMBED'){ ?>

</div>
<!-- ********************************************************************************* -->

<footer>

    <!-- ................................................................................  -->

    <div class="desktop">

    <form action="<?= LINK['SUGGESTIONS'] ?? "" ?>" method="post" class="newsletter" onsubmit="return validate(this);">
        <label for=""> <?= LANG['ASK_SUGGESTION'] ?? "Avez-vous des suggestions pour la plateforme de streaming " ?> ?</label><br><br>
        <input type="text" name="MESSAGES" required id="" onkeyup="input_email(this)" placeholder="<?= LANG['YOUR_SUGGESS'] ?? "Vos suggestions" ?>">
        <div class="mobile"> <br> </div>
        <button type="submit"> <?= LANG['SEND'] ?? "Envoyez" ?> </button>
    </form>

    <div class="options">

        <section>
            <h3> <?= LANG["PROPOS"] ?? "À propos" ?> </h3>
            <div class="underline"></div>
            <ul>
                <li> <a href="<?= LINK['CONTACT_US'] ?? "" ?>"> <?= LANG['CONTACT_US'] ?? "Contactez-nous" ?> </a> </li>
                <li> <a href="<?= LINK['PUB_SPACE'] ?? "" ?>"> <?= LANG['PUB_SPACE'] ?? "Espace publicitaire" ?> </a> </li>
                <li> <a href="<?= LINK['TERMS'] ?? "" ?>"> <?= LANG['TERMS'] ?? "Conditions d'utilisations" ?> </a> </li>
                <li> <a href="<?= LINK['PRIVACY'] ?? "" ?>"> <?= LANG['PRIVACY'] ?? "Confidentialités" ?> </a> </li>
            </ul>
        </section>

        <section>
            <h3> <?= LANG["FOLLOW_US"] ?? "Suivez-nous" ?> </h3>
            <div class="underline"></div>
            <ul>
                <li><a href="<?= SITE_YOUTUBE ?? ""; ?>" target="_blank" class="youtube" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16"><path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/></svg> YouTube</a></li>
                <li><a href="<?= SITE_TWITTER ?? ""; ?>" target="_blank" class="twitter"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16"><path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/></svg> Twitter</a></li>
                <li><a href="<?= SITE_INSTA ?? "" ; ?>" target="_blank" class="insta"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16"><path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/></svg> Instagram</a></li>
            </ul>
        </section>

    </div>

    <form action="<?= LINK['CHANGE_LANG'] ?? "" ;?>" method="post" class="newsletter">
        <input type="hidden" name="SRC_LANG" value="<?= USER_LANG ?? "" ;?>">

        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16"><path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/></svg>
        <select name="TO_LANG" onchange="open_waiting();setTimeout(this.form.submit(),500);" >
                 <?php foreach(LANG_LIST as $lang){ ?> <option value="<?= $lang['LANG'] ?? "" ?>" <?= $lang['LANG'] == USER_LANG ? "selected disabled" : "" ;?> > <?= $lang['LANG_STRING'] ?? "" ?> </option> <?php }  ?>
        </select>

    </form>

    </div>

    
    <!-- ................................................................................  -->
    
    <address> <div class="pays"> <?= join('',file(FOLDER_IMAGES_COUNTRIES.(strtolower(USER_COUNTRY)).'.svg')) ?? ""; ?> </div> © <?= COPYRIGHT_YEAR ?? "2023" ;?> <?= LANG['COPYRIGHT'] ?? "Tous les droits sont réservés !" ?> - <a href="<?= POWERED_BY_LINK ?? "" ?>" target="_blank"> <?= LANG["POWERED_BY"] ?? "Desgined by" ?> <?= POWERED_BY ?? "Adams" ?> </a> </address>
    
    <!-- ................................................................................  -->

    <div class="mobile">
        <br>
    </div>
    

</footer>

<?php } ?>

</body>
</html>

<?php if($PAGE != 'EMBED'){ ?>

<script>

window.addEventListener("DOMContentLoaded",function(){

    var waiting = document.querySelector(".GLOBAL_WAITING");

    // alert(" <?= $REQUEST_TIME ?>");

    <?php if( !empty($CURRENT_TIME) || $REQUEST_TIME > 2000 ){ ?>

    waiting.style.opacity = 0;
    waiting.style.display = 'none';

    <?php }else if($REQUEST_TIME > 1 ){ ?>

    setTimeout(function(){waiting.style.opacity = 0;},1000);
    setTimeout(function(){waiting.style.display = 'none';},2000);

    <?php }else{ ?>

    var imgs = document.images;
    var counter = 0,i=0;

    // while(i < imgs.length)
    // {
    //     if(document.images[i].complete)
    //     {
    //         i++;
    //     }
    //     // else
    //     // {
    //     //     i=0;
    //     // }
    //     // alert(i);
    // }

    setTimeout(function(){waiting.style.opacity = 0;},5000);
    setTimeout(function(){waiting.style.display = 'none';},6000);

    <?php } ?>


});

function dark_mode()
{
    const d = new Date();
    var h = d.getHours();   
    <?php if($PAGE == 'WATCH'){ ?>
    var iframe = document.querySelector('iframe');
    var video = iframe.contentWindow.document.querySelector('video');
    window.location.replace("<?= LINK['DARK_MODE'] ?? ""; ?>/"+h+"<?= HT_ACCESS == true ? "?" : "&" ?>vid="+video.currentTime);
    <?php }else{ ?>
    window.location.replace("<?= LINK['DARK_MODE'] ?? ""; ?>/"+h);
    <?php } ?>

}

function display_suggestion(obj,sug)
{
    var suggestion = document.querySelector(sug);
    try{var empty = document.querySelector('.suggestion_empty');}catch{var empty = null;}
    suggestion.style.display = 'block';
    var value = (obj.value);
    var motcle = <?= json_encode($SUGGESTION); ?>;

    var tab = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ','0','1','2','3','4','5','6','7','8','9'];
    var stre = value.toLowerCase();
    var str = stre.split("");

    var test=0;
    for(i in str ){ for(y in tab){ if(str[i] == tab[y] ){test++;} } }
    if(str.length != test){obj.value = "";}

    while (suggestion.hasChildNodes()) {suggestion.removeChild(suggestion.firstChild);}

    var motInserer = "";
    var input = stre.split(" ");
    for(i in input){ for(y in motcle){if( input[i] !="" && (motcle[y].toLowerCase()).includes(input[i]) ){var link = document.createElement("A");link.setAttribute("href",'<?= LINK['SEARCH'] ?? ""; ?><?= HT_ACCESS == true ? '/' : '&q=' ; ?>'+ ((motcle[y].replace(/<b>/gi,"")).split(" ")).join("-") );link.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>' + motcle[y];    
    suggestion.appendChild(link); } } }
    
    if((empty != null && value == "") || suggestion.hasChildNodes() == false ){empty.style.display = 'flex';}else{empty.style.display = 'none';}
}

function close_suggestion(obj)
{
    var suggestion = document.querySelector(obj);
    setTimeout(function(){suggestion.style.display = 'none';},500);
}

</script>

<?php } ?>