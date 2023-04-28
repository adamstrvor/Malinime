
<?php

$ROOT = new Controller;

$request_time = $var['request_time'] ?? 1;

$ALL = $var['ALL'] ?? null;
$LIST = $var['ANIMES'] ?? null;
$VIDEO = $var['VIDEOS'] ?? null;

$LIMIT = $var['LIMIT'] ??  12;
$PAGE_INDEX = $var['PAGE_INDEX'] ?? 1;
$PAGE_SIZE = $var['PAGE_SIZE'] ?? 1;
$LIMIT_PAGE_BUTTON = 3;

$PUBS = $var['PUBS'] ?? null;
$PUBS_EXT = $var['PUBS_EXT'] ?? null;
$PUBS_LIMIT = $var['PUBS_LIMIT'] ?? 8;

$B[] = ['B_IMAGE'=>"0.png",'B_LINK'=>""];
$B[] = ['B_IMAGE'=>"1.png",'B_LINK'=>""];
$B[] = ['B_IMAGE'=>"7.jpg",'B_LINK'=>""];
$B[] = ['B_IMAGE'=>"8.jpg",'B_LINK'=>""];
$B[] = ['B_IMAGE'=>"11.jpg",'B_LINK'=>""];
$B[] = ['B_IMAGE'=>"17.jpg",'B_LINK'=>""];
$B[] = ['B_IMAGE'=>"20.jpg",'B_LINK'=>""];
$B[] = ['B_IMAGE'=>"3.png",'B_LINK'=>""];
$B[] = ['B_IMAGE'=>"6.jpg",'B_LINK'=>""];
$BRANDING = $var['BRANDING'] ?? $B;


?>



<div class="content">

<div class="body">

<?php if($request_time <= 5){ ?>

    <div class="infooo"> <?= LANG['WELCOME'] ?? ' Découvrez les meilleurs des séries animés gratuitement en ligne ! ' ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-router-fill" viewBox="0 0 16 16"><path d="M5.525 3.025a3.5 3.5 0 0 1 4.95 0 .5.5 0 1 0 .707-.707 4.5 4.5 0 0 0-6.364 0 .5.5 0 0 0 .707.707Z"/><path d="M6.94 4.44a1.5 1.5 0 0 1 2.12 0 .5.5 0 0 0 .708-.708 2.5 2.5 0 0 0-3.536 0 .5.5 0 0 0 .707.707Z"/><path d="M2.974 2.342a.5.5 0 1 0-.948.316L3.806 8H1.5A1.5 1.5 0 0 0 0 9.5v2A1.5 1.5 0 0 0 1.5 13H2a.5.5 0 0 0 .5.5h2A.5.5 0 0 0 5 13h6a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5h.5a1.5 1.5 0 0 0 1.5-1.5v-2A1.5 1.5 0 0 0 14.5 8h-2.306l1.78-5.342a.5.5 0 1 0-.948-.316L11.14 8H4.86L2.974 2.342ZM2.5 11a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1Zm4.5-.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2.5.5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1Zm1.5-.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Z"/><path d="M8.5 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"/></svg> </div>

<?php }else if($request_time <= 8){ ?>

    <div class="infooo"> 
        <?= LANG[''] ?? "Bientôt de nouveaux épisodes pour cette saison !" ?>
    </div>

<?php } ?>
<!-- 
<div class="new-season">
    <div class="title"> <?= LANG[''] ?? "Bientôt de nouveaux animes pour cette saison !" ?> </div>
</div> -->

<?php $VERSION = $_GET['v'] ?? "all"; $MASTERCLASS = $_GET['sp'] ?? ""; ?>

<form action="" method="get" id="UPDATEANIME" >
<div class="top-title sp between"> <span class="tit"> <?= $PAGE_INDEX > 1 ? ( 'PAGE').' '. $PAGE_INDEX.' / '.$PAGE_SIZE : LANG['TRIER'] ?? "TRIER" ?> </span> <div class="option"> <span class="<?= $VERSION == 'all' ? 'sp' : ''; ?>"  onclick=" var trier = document.querySelector('#TRIERANIME'); trier.value = 'all';  var updt = document.querySelector('#UPDATEANIME'); updt.submit(); " > <?= LANG['ALL'] ?? "TOUS" ?> </span>  <span class="<?= $VERSION == 'vf' ? 'sp' : ''; ?>"  onclick="var trier = document.querySelector('#TRIERANIME'); trier.value = 'vf';  var updt = document.querySelector('#UPDATEANIME'); updt.submit(); " > <?= LANG['VF'] ?? "VF" ?> </span> <span class="<?= $VERSION == 'vostfr' ? 'sp' : ''; ?>"  onclick="var trier = document.querySelector('#TRIERANIME'); trier.value = 'vostfr';  var updt = document.querySelector('#UPDATEANIME'); updt.submit(); " > <?= LANG['VOSTFR'] ?? "VOSTFR" ?> </span>  <span class="sp2 <?= $MASTERCLASS == 'true' ? 'sp2ac' : ''; ?>"  onclick=" var trier = document.querySelector('#TRIERANIME_MASTERCLASS'); trier.value = 'true';  var updt = document.querySelector('#UPDATEANIME'); updt.submit(); " > <?= LANG['MASTERCLASS'] ?? "MASTERCLASS" ?> </span>  </div> </div>

<input type="hidden" name="p" value="<?= $PAGE_INDEX ?>" id="PAGE_SELECT">
<input type="hidden" id="TRIERANIME" name="v" value="<?= $VERSION ?? ""; ?>">
<input type="hidden" id="TRIERANIME_MASTERCLASS" name="sp" value="">
</form>

<?php if($PAGE_INDEX == 1 && 1==0){ ?>
<div class="branding">

<?php if(!empty($LIST) ){ foreach($LIST as $ITEM){ if( !empty($ITEM['SPECIAL']) && $ITEM['SPECIAL'] == 'true' ){ ?>

<div class="info brand">
    <div class="img"> <img src="<?= LFOLDER_ANIME_POSTER ?? "" ?><?= $ITEM['POSTER'] ?? "" ?>" alt=""> </div>
    <div class="box">
        <div class="title"><?= substr( str_replace('<ap>',"'", $ITEM["FULL_NAME"] ?? "Titre"),0,50).( strlen($ITEM["FULL_NAME"] ?? "Titre") > 50 ? "..." : ""); ?></div>
        <div class="vf"> <?= $ITEM['VERSIONS'] ?? "" ?> </div>
        <div class="desc"> <?= substr( str_replace("<ap>","'", $ITEM['SYNOPSIS_'.LANG_SYSTEM] ?? $ITEM['SYNOPSIS_'.DEFAULT_LANG] ?? "Description"),0,200)."..."; ?> </div>
    </div>
</div>

<?php }}}else if(!empty($BRANDING)){ foreach($BRANDING as $b){ ?>

    <div class="img brand"> <img src="<?= LFOLDER_ANIME_BRANDING ?? "" ?><?= $b['B_IMAGE'] ?? "" ?>" alt=""> </div>

    <?php }} ?>

<div class="mask">ss</div>
<span id="PREV" onclick="prev();clearInterval(timeoutInterval);" class="prev hover"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16"><path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/></svg> </span>
<span id="NEXT" onclick="next();clearInterval(timeoutInterval);" class="next hover"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16"><path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/></svg> </span>

<!-- <span class="link hover INSTALL_ON_BROWSER"><?= LANG['INSTALL'] ?? "Installer" ?>...</span> -->


    <!-- <?php $dir = scandir(FOLDER_ANIME_BRANDING); sort($dir); if(!empty($dir)){ foreach($dir as $d){ if( str_split($d)[0] != '.' ){ ?>

    <div class="img brand"> <img src="<?= LFOLDER_ANIME_BRANDING ?? "" ?><?= $d ?? "" ?>" alt=""> </div>

    <?php }}}?> -->

</div>

<!-- <div class="top-title sp"> <?= LANG['BEST_SELECT'] ?? "Les meilleures sélections" ?> </div> -->

<?php }else if($PAGE_INDEX > 1){ ?>


<!-- <div class="top-title"> <?= LANG['PAGE'] ?? "Page" ?> <?= $PAGE_INDEX ?? 1 ; ?>  / <?= $PAGE_SIZE ?? 1; ?> </div> -->

<?php } ?>


<?php if(!empty($LIST)){ ?> 

<div class="items">

    <?php $i=1; foreach($LIST as $ITEM){ if($i <= $LIMIT){ $i++; ?>

    <?php if(!empty($VIDEO)){ foreach($VIDEO as $V){ if($V['ANIME_ID'] == $ITEM['ID']){ $OWN_VIDEO[] = $V;$EPISODE[] = $V['EPISODE']; } } } ?>

    <div class="item" >

        <a href="<?= LINK['ANIME'] ?? "" ?>/<?= str_replace('<ap>',"'", !empty($ITEM['LINK']) ? $ITEM['LINK'] : $ITEM['ID'] ?? "" ); ?>" class="img ">
            <img src="<?= LFOLDER_ANIME_POSTER ?? "" ?><?= !empty($ITEM['POSTER']) ? $ITEM['POSTER'] : "default.png" ?>" alt="">
            <div class="vf <?= $ITEM['VERSIONS'] == 'VF' ? "" : "" ?>"> <?= $ITEM['VERSIONS'] ?? "VOSTFR" ?> </div>
            <div class="more"> <span> <?= LANG['SEE_MORE'] ?? "Voir plus..." ?> </span> </div>
        </a>

        <div class="info">

        <a href="<?= LINK['ANIME'] ?? "" ?>/<?= str_replace('<ap>',"'", !empty($ITEM['LINK']) ? $ITEM['LINK'] : $ITEM['ID'] ?? "" ); ?>" class="title"> <?= substr( str_replace('<ap>',"'", $ITEM["FULL_NAME"] ?? "Titre") ,0,50) ?> </a>

        <div class="link">
            
        <?php if(!empty($OWN_VIDEO) && !empty($EPISODE)){ foreach($OWN_VIDEO as $OWN){ if($OWN['EPISODE'] == max($EPISODE) -1 || $OWN['EPISODE'] == max($EPISODE) ){ $odate = array_slice( explode('/', $OWN['PUBLISH_DATE']) ,1); $acdate = array_slice( explode("/", $ROOT->actual_date()) ,1); ?>

        <a href="<?= LINK['WATCH'] ?? "" ?>/<?= !empty($OWN['LINK']) ? $OWN['LINK'] : $OWN['ID'] ?>" class="sp <?= $OWN['PUBLISH_DATE'] == $ROOT->actual_date() || ( $odate[2] == $acdate[2] && $odate[1] == $acdate[1] && abs($odate[0] - $acdate[0]) <=1 ) ? 'red' : ''; ?>" > <?= $OWN['EPISODE'] < 10 ? '0'.$OWN['EPISODE'] : $OWN['EPISODE'] ?> </a>
        <span class="time"> <?= $ROOT->datetime_compare($OWN['PUBLISH_DATETIME'] ?? "") ?? "" ?> </span><br>

        <?php } } } $OWN_VIDEO = null;$EPISODE=null; ?>

        <?php $odate = array_slice( explode('/', $ITEM['DATES']) ,1) ; $acdate = array_slice( explode("/", $ROOT->actual_date()) ,1); if( $ITEM['DATES'] == $ROOT->actual_date() || ( $odate[2] == $acdate[2] && $odate[1] == $acdate[1] && abs($odate[0] - $acdate[0]) <=1 )  ){ echo '<span class="new"> '.(LANG['NEW'] ?? "NOUVEAU").' </span>' ;} ?>
        <?= !empty($ITEM['SPECIAL']) && $ITEM['SPECIAL'] == 'true' ? ' <span class="sp2"> MASTERCLASS </span>' : "" ?>

        </div>

        </div>

        </div>

    <?php } } ?> 

</div>

<?php }else{ ?>

<div class="empty"> <span> <?= LANG['WAITING_FOR'] ?? "En attente" ?>... </span> </div>

<?php } ?>

<br>

<form action="" method="get" class="page2">

<?php if($PAGE_INDEX -1 > 0 ){ ?> <div class="btn" onclick="changePage(this,<?= $PAGE_INDEX -1 ?>)" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/><path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg> </div> <?php } ?>

<div class="txt"> <?= LANG['PAGE'] ?? "Page" ?> <span class=""> <?= $PAGE_INDEX ?? 1 ; ?> </span>  / <?= $PAGE_SIZE ?? 1; ?> </div>

<?php if($PAGE_INDEX +1 <= $PAGE_SIZE){ ?> <div class="btn" onclick="changePage(this,<?= $PAGE_INDEX +1 ?>)" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/><path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/></svg> </div> <?php } ?>

<input type="hidden" name="p" value="<?= $PAGE_INDEX ?>" id="PAGE_SELECT">

</form>

<!--

<form action="" method="get" class="page">

<div class="p active2 "> <?= LANG['PAGE'] ?? "Page" ?> <?= $PAGE_INDEX ?? 1 ; ?>  / <?= $PAGE_SIZE ?? 1; ?> </div>

    <div class="pcont">
    <?php $i= 1; if($PAGE_SIZE <= 12){ while($i <= $PAGE_SIZE){ ?>

    <div class="p <?= $i == $PAGE_INDEX ? 'active' : ''; ?>" <?php if($i != $PAGE_INDEX){ ?> onclick="changePage(this);" <?php } ?> > <?= $i ?> </div>

    <?php $i++; } }else{ ?>
        
    <div class="p <?= $PAGE_INDEX == 1 ? 'active' : ''; ?>" > 1 </div>

        <?php $i= 2; while( $i > 1  && $i < $PAGE_SIZE){ ?>

        <?php if($i <= $LIMIT_PAGE_BUTTON ){ ?>

        <div class="p <?= $PAGE_INDEX == $i ? 'active' : ''; ?>" <?php if($i != $PAGE_INDEX){ ?> onclick="changePage(this);" <?php } ?> > <?= $i ?> </div>
        <?= ($i == $LIMIT_PAGE_BUTTON && $PAGE_INDEX == $LIMIT_PAGE_BUTTON && $i +1 < $PAGE_SIZE - $LIMIT_PAGE_BUTTON) ? '<div class="p" onclick="changePage(this);"> '.($i+1).' </div>' : ''; ?>
        <?= ($i == $LIMIT_PAGE_BUTTON && $PAGE_INDEX == $LIMIT_PAGE_BUTTON && $i +2 < $PAGE_SIZE - $LIMIT_PAGE_BUTTON) ? '<div class="p" onclick="changePage(this);"> '.($i+2).' </div>' : ''; ?>

        <?= ($i == $LIMIT_PAGE_BUTTON && $PAGE_INDEX > $LIMIT_PAGE_BUTTON * 2) || ($i == $LIMIT_PAGE_BUTTON && $PAGE_INDEX <= $LIMIT_PAGE_BUTTON) ? '<div class="p" onclick="changePage(this);"> ... </div>' : ''; ?>

        <?php }else if($PAGE_INDEX == $i){ ?>

            <?= $i - 2 > $LIMIT_PAGE_BUTTON ? '<div class="p " onclick="changePage(this);"> '.($i-2).' </div>' : ''; ?>
            <?= $i - 1 > $LIMIT_PAGE_BUTTON ? '<div class="p " onclick="changePage(this);"> '.($i-1).' </div>' : ''; ?>
            <div class="p active" onclick="changePage(this);"> <?= $i ?> </div>
            <?= $i +1 < $PAGE_SIZE - $LIMIT_PAGE_BUTTON ? '<div class="p" onclick="changePage(this);"> '.($i+1).' </div> ' : ''; ?>
            <?= $i +2 < $PAGE_SIZE - $LIMIT_PAGE_BUTTON ? '<div class="p" onclick="changePage(this);"> '.($i+2).' </div> <div class="p"> ... </div>' : ''; ?>

        <?php }else if( $i > $PAGE_INDEX  && $i > $PAGE_SIZE - $LIMIT_PAGE_BUTTON ){ ?>

            <div class="p" onclick="changePage(this);"> <?= $i ?> </div>

        <?php } ?>

    <?php $i++; } ?>

    <div class="p <?= $PAGE_INDEX == $PAGE_SIZE ? 'active' : ''; ?>" onclick="changePage(this);"> <?= $PAGE_SIZE ?> </div>

    <?php } ?>

    </div>


    <input type="hidden" name="p" value="<?= $PAGE_INDEX ?>" id="PAGE_SELECT">
</form>

        -->


<section class="all">
    <h3 class="top-title" > <?= LANG[''] ?? "Contribution" ?> </h3>
    <div class="lien">
        <a href="https://fr.tipeee.com/malinime-streaming" target="_blank"> <?= LANG[''] ?? "Soutenir la plateforme de streaming"  ?> </a>
    </div>
</section>


 <?php if(!empty($ALL) && 1==0){ ?>

<section class="all">

<h3 class="top-title" >  <?= LANG['TAGS'] ?? "Tags" ?> </h3>

<div class="lien">
<?php $i=0; foreach($ALL as $A){ if( $i < 7){ ?>

    <a href="<?= LINK['ANIME'] ?? "" ?>/<?= !empty($A['LINK']) ? $A['LINK'] : $A['ID'] ?? "" ?>"> <?= $A['FULL_NAME'] ?? "" ?> </a>

<?php $i++; } } ?>

</div>

</section>
<?php } ?> 



</div>


<div class="partner">
<div class="tit"> <?= LANG['ADS'] ?? "Publicité" ?> </div><br>
<div class="cont">
<?php if(!empty($PUBS)){ $i=0;$j=0; while($i < count($PUBS) && $i < $PUBS_LIMIT){ $j = rand(0,count($PUBS_EXT) -1); if( empty($t) || in_array($j,$t) == false ){ if($PUBS[$j]['BRAND_VISIBLE'] == 'true'){ ?>
<a href="<?= $PUBS[$j]['BRAND_SITE'] ?? "" ?>" class="img"> 
    <img src="<?= LFOLDER_ANIME_PUBS ?? "" ?><?= $PUBS[$j]['BRAND_PUB_ICON'] ?? "" ?>" alt=""> 
    <div class="more"> <span> <?= LANG['SEE_MORE'] ?? "Voir plus..." ?> </span> </div>
</a>
<?php $t[] = $j;$i++; } } } } ?>

<?php if(!empty($PUBS_EXT)){ $t= array(); $i=0;$j=0; while( $i < count($PUBS_EXT) && $i < $PUBS_LIMIT){ $j = rand(0,count($PUBS_EXT) -1); if( empty($t) || in_array($j,$t) == false ){ ?>
<?= $PUBS_EXT[$j] ?? "" ?>
<?php $t[] = $j;$i++; } } } ?>
</div>

</div>

</div>

<script>


function changePage(obj,val=null)
{
    var page = document.querySelector('#PAGE_SELECT');
    if(val==null)
    page.value = obj.outerText;
    else
    page.value = val;
    page.form.submit();
}

var brand = document.querySelectorAll(".brand");
var index = 0;

brand[index].style.opacity = 1;



var timeoutInterval = setInterval(next,3000);

function next()
{
    brand[index].style.opacity = 0;
    setTimeout(display,100);
}

function prev()
{
    brand[index].style.opacity = 0;
    setTimeout(closeB,100);
}

var mask = document.querySelector(".branding");

function display(){ brand[index].style.display = 'none';index++; if(index > brand.length - 1) index=0;brand[index].style.opacity = 0;brand[index].style.display = 'flex';brand[index].style.opacity = 1; }
function closeB(){ brand[index].style.display = 'none';index--; if(index < 0) index=brand.length - 1;brand[index].style.opacity = 0;brand[index].style.display = 'flex';brand[index].style.opacity = 1; }

var hover = document.querySelectorAll(".hover");


hover[0].style.opacity = 0;
hover[1].style.opacity = 0;

mask.onmousemove = function(){
    hover[0].style.opacity = 1;
    hover[1].style.opacity = 1;
};

mask.onmouseleave = function(){
    hover[0].style.opacity = 0;
    hover[1].style.opacity = 0;
};

</script>