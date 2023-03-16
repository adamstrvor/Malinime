
<?php

$ROOT = new Controller;

$request_time = $var['request_time'] ?? 1;

$LIST = $var['ANIMES'] ?? null;
$VIDEO = $var['VIDEOS'] ?? null;

$WORD = $var['WORD'] ?? "Mot";

$LIMIT = $var['LIMIT'] ??  12;
$PAGE_INDEX = $var['PAGE_INDEX'] ?? 1;
$PAGE_SIZE = $var['PAGE_SIZE'] ?? 1;
$LIMIT_PAGE_BUTTON = 3;

$PUBS = $var['PUBS'] ?? null;
$PUBS_EXT = $var['PUBS_EXT'] ?? null;
$PUBS_LIMIT = $var['PUBS_LIMIT'] ?? 8;

?>


<div class="content">

<div class="body">

<?php if($request_time <= 10 ){ ?>

    <div class="infooo"> <?= LANG['INFO_SEARCH'] ?? "Vous pouvez recherchez les animes selon: la version Vostfr ou vf , le genre ex: Action...Drame, ou encore le Studio de production ex: Mappa, ou simplement selon le nom du héros " ?>  </div>

<?php } ?>

<h1 class="top-title"> <?= LANG['RESULTS_FOR'] ?? "Résultats pour " ?> <div class="sp"> " <?= $WORD ?? "" ?> " </div> </h1>

<?php if(!empty($LIST)){ ?>


<div class="items">

    <?php $i=1; foreach($LIST as $ITEM){ if($i <= $LIMIT){ $i++; ?>

    <?php if(!empty($VIDEO)){ foreach($VIDEO as $V){ if($V['ANIME_ID'] == $ITEM['ID']){ $OWN_VIDEO[] = $V;$EPISODE[] = $V['EPISODE']; } } } ?>

    <div class="item" >

        <a href="<?= LINK['ANIME'] ?? "" ?>/<?= !empty($ITEM['LINK']) ? $ITEM['LINK'] : $ITEM['ID'] ?? "" ?>" class="img ">
            <img src="<?= LFOLDER_ANIME_POSTER ?? "" ?><?= !empty($ITEM['POSTER']) ? $ITEM['POSTER'] : "default.png" ?>" alt="">
            <div class="vf <?= $ITEM['VERSIONS'] == 'VF' ? "" : "" ?>"> <?= $ITEM['VERSIONS'] ?? "VOSTFR" ?> </div>
            <div class="more"> <span> <?= LANG['SEE_MORE'] ?? "Voir plus..." ?> </span> </div>
        </a>

        <div class="info">

        <div class="title"> <?= substr( str_replace('<ap>',"'", $ITEM["FULL_NAME"] ?? "Titre") ,0,50) ?> </div>

        <div class="desc"> <?= substr( str_replace("<ap>","'", $ITEM['SYNOPSIS_'.LANG_SYSTEM] ?? $ITEM['SYNOPSIS_'.DEFAULT_LANG] ?? "Description") ,0,150).' ... '; ?> </div>

        <!-- <div class="link">
            
        <?php if(!empty($OWN_VIDEO) && !empty($EPISODE)){ foreach($OWN_VIDEO as $OWN){ if($OWN['EPISODE'] == max($EPISODE) -1 || $OWN['EPISODE'] == max($EPISODE) ){ $odate = array_slice( explode('/', $OWN['PUBLISH_DATE']) ,1); $acdate = array_slice( explode("/", $ROOT->actual_date()) ,1); ?>

        <a href="<?= LINK['WATCH'] ?? "" ?>/<?= !empty($OWN['LINK']) ? $OWN['LINK'] : $OWN['ID'] ?>" class="sp <?= $OWN['PUBLISH_DATE'] == $ROOT->actual_date() || ( $odate[2] == $acdate[2] && $odate[1] == $acdate[1] && abs($odate[0] - $acdate[0]) <=1 ) ? 'red' : ''; ?>" > <?= $OWN['EPISODE'] < 10 ? '0'.$OWN['EPISODE'] : $OWN['EPISODE'] ?> </a>
        <span class="time"> <?= $ROOT->datetime_compare($OWN['PUBLISH_DATETIME'] ?? "") ?? "" ?> </span><br>

        <?php } } } $OWN_VIDEO = null;$EPISODE=null; ?>

        </div> -->

        </div>

        </div>

    <?php } } ?> 

</div>

<?php }else{ ?>

<div class="empty"> <span> <?= LANG['NO_RESULT'] ?? "Aucun résultats" ?>... </span> </div>

<?php } ?>


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
    <input type="hidden" name="page" value="<?= PAGE ?>" >
</form>


</div>


<div class="partner">
<div class="tit"> <?= LANG['ADS'] ?? "Publicité" ?> </div><br>
<div class="cont">
<?php if(!empty($PUBS)){ foreach($PUBS as $p){ ?>
<a href="<?= $p['LINK'] ?? "" ?>" class="img"> 
    <img src="<?= LFOLDER_ANIME_PUBS ?? "" ?><?= $p['IMAGES'] ?? "" ?>" alt=""> 
    <div class="more"> <span> <?= LANG['SEE_MORE'] ?? "Voir plus..." ?> </span> </div>
</a>
<?php } } ?>

<?php if(!empty($PUBS_EXT)){ $t= array(); $i=0;$j=0; while( $i < count($PUBS_EXT) && $i < $PUBS_LIMIT){ $j = rand(0,count($PUBS_EXT) -1); if( empty($t) || in_array($j,$t) == false ){ ?>
<?= $PUBS_EXT[$j] ?? "" ?>
<?php $t[] = $j; $i++; } } } ?>
</div>

</div>



</div>

<script>


function changePage(obj)
{
    var page = document.querySelector('#PAGE_SELECT');
    page.value = obj.outerText;
    page.form.submit();
}


</script>