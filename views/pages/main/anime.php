
<?php

$ROOT = new Controller;

$ANIME_INFO = $var['ANIME'] ?? null;
$EPISODE = $var['VIDEO'] ?? null;
$COMMENTS = $var['COMMENTS'] ?? null;

$PUBS = $var['PUBS'] ?? null;
$PUBS_EXT = $var['PUBS_EXT'] ?? null;
$PUBS_LIMIT = $var['PUBS_LIMIT'] ?? 8;
$CHARACTERS = $var['PERSO'] ?? null;


?>

<div class="content">

<div class="body">

<h1 class="top-title sp"> <?= str_replace('<ap>',"'", $ANIME_INFO['FULL_NAME'] ?? "Titre" ) ?> </h1>

<div class="box_info">

    <div class="img"> 
        <img src="<?= LFOLDER_ANIME_POSTER ?? "" ?><?= !empty($ANIME_INFO['POSTER']) ? $ANIME_INFO['POSTER'] : "default.png" ?>" alt="">
        <!-- <div class="vf"> <?= $ANIME_INFO['VERSION'] ?? "VOSTFR" ?> </div>  -->
        <!-- <div class="more"> <span> <?= LANG['SEE_MORE'] ?? "Voir plus..." ?> </span> </div> -->
    </div>

    <!-- <div class="info">

        <div class="line"> <span class="tit" > <?= LANG['ORIGINAL_NAME'] ?? "Nom original" ?> </span>  <span class="right"> <?= str_replace('<ap>',"'", $ANIME_INFO['ORIGINAL_NAME'] ?? "Nom d'origine" ) ?> </span> </div>
        <div class="line"> <span class="tit" > <?= LANG['GLOBAL_NAME'] ?? "Nom officielle" ?> </span>  <span class="right"> <?= str_replace('<ap>',"'", $ANIME_INFO['FULL_NAME'] ?? "" ) ?> </span> </div>
        <div class="line"> <span class="tit" > <?= LANG['STATUS'] ?? "STATUS" ?> </span>  <span class="right"> <?= $ANIME_INFO['STATUSS'] == '0' ? LANG['ON_COURSE'] ?? "En cours" : LANG['FINISH'] ??  'Terminé' ?> </span> </div>
        <div class="line"> <span class="tit" > <?= LANG['STUDIO'] ?? "Studio" ?> </span>  <span class="right sp"> <?= $ANIME_INFO['STUDIO'] ?? "" ?> </span> </div>
        <div class="line"> <span class="tit" > <?= LANG['OUT_DATE'] ?? "Date de sortie" ?> </span>  <span class="right"> <?= str_replace('<ap>',"'", $ANIME_INFO['OUT_DATE'] ?? "" ) ?> </span> </div>
        <div class="line"> <span class="tit" > <?= LANG['GENRE'] ?? "Genre" ?> </span>  <span class="right"> <?= str_replace('<ap>',"'", $ANIME_INFO['GENRE'] ?? "" ) ?> </span> </div>
        <div class="line"> <span class="tit" > <?= LANG['VERSION'] ?? "Version" ?> </span>  <span class="right"> <?= $ANIME_INFO['VERSIONS'] ?? ""  ?> </span> </div>
        <div class="line"> <span class="tit" > <?= LANG['TRAILER'] ?? "Trailer" ?> </span>  <a href="<?= $ANIME_INFO['TRAILER'] ?? "" ?>" target="_blank" class="right"> <?= str_replace('<ap>',"'", $ANIME_INFO['TRAILER'] ?? "" ) ?> </a> </div>


    </div> -->

    <div class="over">

    <table>
        <tr>
            <th> <?= LANG['ORIGINAL_NAME'] ?? "Nom original" ?> </th>
            <td> <?= str_replace('<ap>',"'", $ANIME_INFO['ORIGINAL_NAME'] ?? "Nom d'origine" ) ?> </td>
        </tr>
        
        <!-- <tr>
            <th> <?= LANG['GLOBAL_NAME'] ?? "Nom officielle" ?> </th>
            <td> <?= str_replace('<ap>',"'", $ANIME_INFO['FULL_NAME'] ?? "" ) ?> </td>
        </tr> -->

        <?php if(!empty($ANIME_INFO['ROMANJI'])){ ?>
        <tr>
            <th> <?= LANG['ROMANJI'] ?? "Romanji" ?> </th>
            <td> <?= str_replace('<ap>',"'", $ANIME_INFO['ROMANJI'] ?? "" ) ?> </td>
        </tr>
        <?php } ?>

        <tr>
            <th> <?= LANG['STATUS'] ?? "STATUS" ?> </th>
            <td class="sp"> <?= $ANIME_INFO['STATUSS'] == '0' ? LANG['ON_COURSE'] ?? "En cours" : LANG['FINISH'] ??  'Terminé' ?> </td>
        </tr>

        <tr>
            <th> <?= LANG['STUDIO'] ?? "Studio" ?> </th>
            <td> <?= str_replace('<ap>',"'", $ANIME_INFO['STUDIO'] ?? "" )?> </td>
        </tr>

        <tr>
            <th> <?= LANG['OUT_DATE'] ?? "Date de sortie" ?> </th>
            <td> <?= str_replace('<ap>',"'", $ANIME_INFO['OUT_DATE'] ?? "" ) ?> </td>
        </tr>

        <tr>
            <th> <?= LANG['GENRE'] ?? "Genre" ?> </th>
            <td> <?= str_replace('<ap>',"'", $ANIME_INFO['GENRE'] ?? "" ) ?> </td>
        </tr>

        <tr>
            <th> <?= LANG['VERSION'] ?? "Version" ?> </th>
            <td> <?= str_replace('<ap>',"'", $ANIME_INFO['VERSIONS'] ?? "" )  ?> </td>
        </tr>

        <tr>
            <th> <?= LANG['TOTAL_VIEWS'] ?? "Total des vues" ?> </th>
            <td class=""> <?php if( !empty( $ANIME_INFO['VIEWS']) ){ $VIEW = str_split($ANIME_INFO['VIEWS']); if($ANIME_INFO['VIEWS'] < 1000){ echo $ANIME_INFO['VIEWS'];}else if($ANIME_INFO['VIEWS'] >= 1000 && $ANIME_INFO['VIEWS'] < 1000000){ array_pop($VIEW);array_pop($VIEW);array_pop($VIEW); echo join("",$VIEW)." k"; }else if($ANIME_INFO['VIEWS'] >= 1000000){ array_pop($VIEW);array_pop($VIEW);array_pop($VIEW);array_pop($VIEW);array_pop($VIEW);array_pop($VIEW); echo join("",$VIEW)." M"; } }else{ echo "1"; }  ?> <?php if(!empty($ANIME_INFO['VIEWS'])){ echo $ANIME_INFO['VIEWS'] == 1 ? LANG['VIEW'] ?? "vue" : LANG['VIEWS'] ?? "vues" ;}else{ echo LANG['VIEW'] ?? "vue"; }  ?> </td>
        </tr>

    </table>

    </div>

</div>

<div class="top-title bottom"> <?= LANG['SYNOPSIS'] ?? "Synopsis" ?> </div>

<div class="descrip"> <?= str_replace("<ap>","'", $ANIME_INFO['SYNOPSIS_'.LANG_SYSTEM] ?? $ANIME_INFO['SYNOPSIS_'.DEFAULT_LANG] ?? "Description"); ?> </div>

<?php if(!empty($CHARACTERS)){ ?>

<div onselectstart="return false" class="top-title bottom"> <svg onclick="switchDisplayCharacter('.characters_2','.characters');" class="<?= LANG_DIR == 'ltr' ? 'right' :'left'; ?>" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/></svg> <span> <?= LANG['LIST_PERSO'] ?? "Personnages principaux" ?> </span> </div>

<div onselectstart="return false" class="characters">

<?php foreach($CHARACTERS as $C){ ?>

    <div class="c">
        <div class="im"> <img src="<?= LFOLDER_ANIME_CHARACTERS ?? "" ?><?= !empty($C['PHOTO']) ? $C['PHOTO'] : "default.png" ?>" alt=""> </div>
        <div class="n"> <?= !empty($C['SPECIAL']) && $C['SPECIAL'] == 'true' ? '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16"><path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.6l3-4zm11.386 3.785-1.806-2.41-.776 2.413 2.582-.003zm-3.633.004.961-2.989H4.186l.963 2.995 5.704-.006zM5.47 5.495 8 13.366l2.532-7.876-5.062.005zm-1.371-.999-.78-2.422-1.818 2.425 2.598-.003zM1.499 5.5l5.113 6.817-2.192-6.82L1.5 5.5zm7.889 6.817 5.123-6.83-2.928.002-2.195 6.828z"/></svg>' : "" ?> <span> <?= $C['NAMES'] ?? "Nom" ?> </span> </div>
    </div>

<?php } ?>

</div>

<!-- <div onselectstart="return false" class="characters_2 none"> -->

<?php// foreach($CHARACTERS as $C){ ?>

    <!-- <div class="c">
        <div class="im"> <img src="<?= LFOLDER_ANIME_CHARACTERS ?? "" ?><?= !empty($C['PHOTO']) ? $C['PHOTO'] : "default.png" ?>" alt=""> </div>
        <div class="n"> <?= !empty($C['SPECIAL']) && $C['SPECIAL'] == 'true' ? '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16"><path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.6l3-4zm11.386 3.785-1.806-2.41-.776 2.413 2.582-.003zm-3.633.004.961-2.989H4.186l.963 2.995 5.704-.006zM5.47 5.495 8 13.366l2.532-7.876-5.062.005zm-1.371-.999-.78-2.422-1.818 2.425 2.598-.003zM1.499 5.5l5.113 6.817-2.192-6.82L1.5 5.5zm7.889 6.817 5.123-6.83-2.928.002-2.195 6.828z"/></svg>' : "" ?> <span> <?= $C['NAMES'] ?? "Nom" ?> </span> </div>
    </div> -->

<?php //} ?>

<!-- </div> -->

<?php } ?>


<div onselectstart="return false" class="top-title bottom"> <svg onclick="switchDisplay('.list','.list2');" class="<?= LANG_DIR == 'ltr' ? 'right' :'left'; ?>" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/></svg> <span> <?= LANG['EPISODE_LIST'] ?? "Listes des épisodes" ?> </span>   </div>


<?php if(!empty($EPISODE) && 1==0){ ?>

<div onselectstart="return false" class="list2 none">

<?php foreach($EPISODE as $E){ $odate = array_slice( explode('/', $E['PUBLISH_DATE']) ,1); $acdate = array_slice( explode("/", $ROOT->actual_date()) ,1); ?>

    <a class="itm <?= $E['PUBLISH_DATE'] == $ROOT->actual_date() || ( $odate[2] == $acdate[2] && $odate[1] == $acdate[1] && abs($odate[0] - $acdate[0]) <=1 ) ? 'active' : ''; ?>" href="<?= LINK['WATCH'] ?? "" ?>/<?= !empty($E['LINK']) ? $E['LINK'] : $E['ID'] ?>" class="item">
    <div class="im "> <span>  <?= $E['EPISODE'] < 10 ? '0'.$E['EPISODE'] : $E['EPISODE'] ?> </span> </div>
    <span class="imb <?= $E['PUBLISH_DATE'] == $ROOT->actual_date() || ( $odate[2] == $acdate[2] && $odate[1] == $acdate[1] && abs($odate[0] - $acdate[0]) <=1 ) ? 'active' : ''; ?>"> <?= $ROOT->datetime_compare($E['PUBLISH_DATETIME'] ?? "") ?? "" ?> </span> 
    </a>

<?php } ?>

</div>

<?php } else{ ?>

<!-- <div class="empty"> <span> <?= LANG['WAITING_FOR'] ?? "En attente" ?>... </span> </div> -->

<?php } ?>



<?php if(!empty($EPISODE)){ ?>

    <div onselectstart="return false" class="list ">

    <?php foreach($EPISODE as $E){ ?>

        <a href="<?= LINK['WATCH'] ?? "" ?>/<?= !empty($E['LINK']) ? $E['LINK'] : $E['ID'] ?>" class="item"> <?= LANG['EPISODE'] ?? "Episode" ?> - <?= $E['EPISODE'] < 10 ? '0'.$E['EPISODE'] : $E['EPISODE'] ?>  <span class="<?= LANG_DIR == 'ltr' ? 'l' :'left'; ?>"> <?= $ROOT->datetime_compare($E['PUBLISH_DATETIME'] ?? "") ?? "" ?> </span> </a>

    <?php } ?>

    </div>

<?php } else{ ?>

    <div class="empty"> <span> <?= LANG['WAITING_FOR'] ?? "En attente" ?>... </span> </div>

<?php } ?>


<div class="top-title bottom"> <span class="spe"> <?= !empty($COMMENTS) ? count($COMMENTS) : 0; ?> </span> <span> <?= LANG['COMMENTS'] ?? "Commentaire(s)" ?> </span> </div>

<?php if(!empty($COMMENTS)){ ?>
<div class="comments item">

    <?php $i=1; foreach($COMMENTS as $C){ if(!empty($C['VISIBLE']) && $C['VISIBLE'] == 'true'){ $i = $i > 6 ? 1 : $i; ?>
        <div class="c">
            <div class="img">
                <img src="<?= LFOLDER_ANIME_COMMENT ?? "" ?><?php if($C['SPECIAL'] == 'true'){ echo 'icon.png'; }else{ echo $C['GENRE'] == '0' ? 'man_'.$i.'.png' : 'wife_'.$i.'.png';} ?>" alt=""> 
                <?= $C['SPECIAL'] != 'true' ? join('',file(FOLDER_IMAGES_COUNTRIES.(strtolower($C['COUNTRY'] ?? 'US')).'.svg')) : ""; ?>
            </div>
            <div class="info">
                <div class="name"> <?= str_replace('<ap>',"'", $C['FULL_NAME'] ?? "" ) ?> <?php if($C['SPECIAL'] == 'true'){ ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16"><path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/></svg> <?php }  ?> </div>
                <div class="msg"> <?= str_replace('<ap>',"'", $C['MESSAGES'] ?? "" ) ?> </div>
                <div class="time"> <?= $ROOT->datetime_compare($C['DATETIMES'] ?? "12/12/12/12/2022") ?> </div>
            </div>
        </div>
    <?php $i++; } } ?>
</div>
<?php }else{ ?>

    <div class="empty"> <span> <?= LANG['NOT_YET'] ?? "Aucun pour l'instant" ?>... </span> </div>

<?php } ?>

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
    // var countDis=0;
    // function switchDisplay(l2,l1)
    // {
    //     var list2 = document.querySelector(l2);
    //     var list1 = document.querySelector(l1);

    //     if(countDis == 0){
    //     list2.style.display = "flex";
    //     list1.style.display = "none";
    //     countDis=1;
    //     }else{
    //     list2.style.display = "none";
    //     list1.style.display = "block";
    //     countDis=0;
    //     }
    // }

    // var countDisCharacter=0;
    // function switchDisplayCharacter(l2,l1)
    // {
    //     var list2 = document.querySelector(l2);
    //     var list1 = document.querySelector(l1);

    //     if(countDisCharacter == 0){
    //     list2.style.display = "block";
    //     list1.style.display = "none";
    //     countDisCharacter=1;
    //     }else{
    //     list2.style.display = "none";
    //     list1.style.display = "flex";
    //     countDisCharacter=0;
    //     }
    // }

    // var t = document.querySelector('.list');
    // var t2 = document.querySelector('.characters_2');

    // t.style.display = 'none';
    // t2.style.display = 'none';
</script>