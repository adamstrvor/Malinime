
<?php

$ROOT = new Controller;

$request_time = $var['request_time'] ?? 1;

$VIDEO_INFO = $var['VIDEO'] ?? null;
if(!empty($VIDEO_INFO)){
$ALL_VIDEO = $var['ALL_VIDEO'] ?? null;
$COMMENTS = $var['COMMENTS'] ?? null;
$ANIME = $var['ANIME'] ?? null;

$i=0;
foreach($ALL_VIDEO as $V){ if($V['EPISODE'] == ($VIDEO_INFO['EPISODE'] - 1) ){ $PREC = !empty($V['LINK']) ? $V['LINK'] : $V['ID']; break; } }
foreach($ALL_VIDEO as $V){ if($V['EPISODE'] == ($VIDEO_INFO['EPISODE'] + 1) ){ $SUIV = !empty($V['LINK']) ? $V['LINK'] : $V['ID']; break; } }

// VIDEO INFOS

$VIDEO_TITLE = ($VIDEO_INFO['ANIME_NAME'] ?? "Titre").' - '.($VIDEO_INFO['EPISODE'] < 10 ? '0'.$VIDEO_INFO['EPISODE'] : $VIDEO_INFO['EPISODE']);//.' - '.( strtoupper( $VIDEO_INFO['ANIME_VERSION'] ?? "Version") );
$VIDEO_TYPE = $VIDEO_INFO['TYPE'] ?? "video/mp4";
$VIDEO_DESC = ($VIDEO_INFO['DESCRIP'] ?? "Description");
$VIDEO_LOCATION = LFOLDER_ANIME_VIDEO.($VIDEO_INFO['LOCATION'] ?? "kulosa.mp4");

if(!empty($VIDEO_INFO['IFRAME_LINK']) && $VIDEO_INFO['IFRAME_LINK'] != ""  )
{
    $SELECTED_SOURCE = $var['SELECTED_SOURCE'] ?? 0;
    $IFRAME = explode('|',$VIDEO_INFO['IFRAME_LINK']) ;
    $SRC = $IFRAME[$SELECTED_SOURCE];
}
else if(!empty($VIDEO_INFO['SOURCE_LINK']))
{
    $SELECTED_SOURCE = $var['SELECTED_SOURCE'] ?? 0;
    $SOURCE = explode('|',$VIDEO_INFO['SOURCE_LINK']) ;
}

}

$PUBS = $var['PUBS'] ?? null;
$PUBS_EXT = $var['PUBS_EXT'] ?? null;
$PUBS_LIMIT = $var['PUBS_LIMIT'] ?? 8;

?>








<?php if(empty($VIDEO_INFO)){ ?>

<div class="empty">

<div class="svg"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video-off-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.961 12.365a1.99 1.99 0 0 0 .522-1.103l3.11 1.382A1 1 0 0 0 16 11.731V4.269a1 1 0 0 0-1.406-.913l-3.111 1.382A2 2 0 0 0 9.5 3H4.272l6.69 9.365zm-10.114-9A2.001 2.001 0 0 0 0 5v6a2 2 0 0 0 2 2h5.728L.847 3.366zm9.746 11.925-10-14 .814-.58 10 14-.814.58z"/></svg> </div>

<div class="title"> <?= $LANG['VIDEO_NOT_FOUNDED'] ?? "Vidéo introuvale" ?> </div>

<div class="subtitle"> <?= $LANG['VIDEO_NOT_FOUND_INFO'] ?? "La vidéo est soit inexistante ou été rétiré de la plateforme" ?> </div>

<!-- <a href="<?= $_SERVER['HTTP_REFERER'] ?? "" ?>"> <?= $LANG['RETRY'] ?? "Réessayer" ?> </a> -->

</div>

<?php }else{ ?>

    <div class="content_g">

    <div class="body">

<?php if($request_time <= 1){ ?>

<!-- <div class="infooo"> <?= LANG['INFO_WATCH'] ?? ' Pour une utilisation efficace nous suggerons aux utilisateurs d\'utiliser un <b> Pc </b> pour plus de performance .' ?> </div> -->

<?php } ?>

    <h1 class="top-title nounder "> <a href="<?= LINK['ANIME'] ?? "" ?>/<?= !empty($ANIME['LINK']) ? $ANIME['LINK'] ?? "" :$ANIME['ID'] ?? "" ?>"> <?= str_replace('<ap>',"'", $VIDEO_TITLE ?? "" )  ?> </a> <span class="vf"> <?= $VIDEO_INFO['ANIME_VERSION'] ?? "Version" ?> </span> <span class="view"> <?= $ROOT->datetime_compare($VIDEO_INFO['PUBLISH_DATETIME']); ?> </span>  </h1>

    <iframe id="IFRAME" src="<?= !empty($SRC) ? $SRC : (LINK['EMBED'] ?? "").'/'.( !empty($VIDEO_INFO['LINK']) ? $VIDEO_INFO['LINK'] ?? "" :$VIDEO_INFO['ID'] ?? "").'/'.(($SELECTED_SOURCE ?? 0) + 1) ; ?>" width="100%" height="500px" scrolling="no" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" frameborder="0"></iframe>
    
    <form action="" method="post" class="episode">

        <?php if( !empty($PREC) ){ ?> <span class="button next" onclick="window.location.replace('<?= (LINK['WATCH'] ?? '').'/'.($PREC ); ?>');"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/><path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg> <?= ""//LANG['PRECED'] ?? "Précédent"; ?> </span> <?php } ?>

        <div class="inline">
        <?php if(!empty($IFRAME)){ ?>
            <select name="s" id="" onchange="var val = this.value;window.location.replace('<?= (LINK['WATCH'] ?? '').'/'.( !empty($VIDEO_INFO['LINK']) ? $VIDEO_INFO['LINK'] : $VIDEO_INFO['ID']).'/'; ?>'+(parseInt(val) +1)); ">
            <?php $i=0; foreach($IFRAME as $S){ ?>
                <option value="<?= $i ?>" <?= $i == $SELECTED_SOURCE ? "selected" : '' ?> > <?= ( LANG['CHANNEL'] ?? 'Chaîne').' '.($i+1) ?> </option>
            <?php $i++; } ?>
            </select>
        <?php }  ?>

        <?php if(!empty($SOURCE)){ ?>
            <select name="s" id="" onchange="var val = this.value;window.location.replace('<?= (LINK['WATCH'] ?? '').'/'.( !empty($VIDEO_INFO['LINK']) ? $VIDEO_INFO['LINK'] : $VIDEO_INFO['ID']).'/'; ?>'+(parseInt(val) +1)); ">
            <?php $i=0; foreach($SOURCE as $S){ ?>
                <option value="<?= $i ?>" <?= $i == $SELECTED_SOURCE ? "selected" : '' ?> > <?= ( LANG['CHANNEL'] ?? 'Chaîne').' '.($i+1) ?> </option>
            <?php $i++; } ?>
            </select>
        <?php }  ?>

        <select name="e" id="EPISODEW" onchange="var val = this.value;window.location.replace('<?= (LINK['WATCH'] ?? '').'/'; ?>'+(val));">
            <?php if(!empty($ALL_VIDEO)){ foreach($ALL_VIDEO as $E){ ?>
                <option value="<?= !empty($E['LINK']) ? $E['LINK'] : $E['ID'] ?>" <?= $VIDEO_INFO['EPISODE'] == $E['EPISODE'] ? 'selected' : ''; ?>> <?= $E['EPISODE'] < 10 ? '0'.$E['EPISODE'] : $E['EPISODE'] ?> </option>
            <?php } }?>
        </select>
        </div>

        <?php if( !empty($SUIV) ){ ?> <span class="button next" onclick="window.location.replace('<?= (LINK['WATCH'] ?? '').'/'.($SUIV ); ?>');"> <?= "";//LANG['NEXT'] ?? "Suivant"; ?> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/><path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/></svg> </span> <?php } ?>

    </form>
<?php //!empty($VIDEO_INFO['SOURCE_LINK']) ? $SOURCE[0] : ?>

<br>
    <div class="top-title bottom between">  <span> <?= (!empty($COMMENTS) ? count($COMMENTS) : 0).' '.(LANG['COMMENTS'] ?? "Commentaire(s)") ?> </span> <span class="view"> <?php if( !empty( $VIDEO_INFO['VIEWS']) ){ $VIEW = str_split($VIDEO_INFO['VIEWS']); if($VIDEO_INFO['VIEWS'] < 1000){ echo $VIDEO_INFO['VIEWS'];}else if($VIDEO_INFO['VIEWS'] >= 1000 && $VIDEO_INFO['VIEWS'] < 1000000){ array_pop($VIEW);array_pop($VIEW);array_pop($VIEW); echo join("",$VIEW)." k"; }else if($VIDEO_INFO['VIEWS'] >= 1000000){ array_pop($VIEW);array_pop($VIEW);array_pop($VIEW);array_pop($VIEW);array_pop($VIEW);array_pop($VIEW); echo join("",$VIEW)." M"; } }else{ echo "1"; }  ?> <?php if(!empty($VIDEO_INFO['VIEWS'])){ echo $VIDEO_INFO['VIEWS'] == 1 ? LANG['VIEW'] ?? "vue" : LANG['VIEWS'] ?? "vues" ;}else{ echo LANG['VIEW'] ?? "vue"; }  ?> </span> </div> <!-- class="spe" -->

    <div class="flex">

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
                    <div class="time"> <?= ""// $C['SPECIAL'] != 'true' ? join('',file(FOLDER_IMAGES_COUNTRIES.(strtolower($C['COUNTRY'] ?? 'US')).'.svg')) : ""; ?> <span> <?= $C['SPECIAL'] != 'true' ? ( COUNTRIES[($C['COUNTRY'] ?? 'US')] ?? ($C['COUNTRY'] ?? 'US') ). " - " : ""  ?> </span> <span> <?= $ROOT->datetime_compare($C['DATETIMES'] ?? "12/12/12/12/2022") ?> </span> </div>
                </div>
            </div>
        <?php $i++;} } ?>
    </div>
    <?php } ?>

    <form action="" method="post" class="item">

        <label for=""> <?= LANG['ASK_YOUR_MIND'] ?? "Qu'avez-vous penser de cet épisode" ?> ? </label><br>

        <!-- <label for=""> <?= LANG['COMMENTS'] ?? "Commentaires" ?> </label><br> -->
        <textarea name="MESSAGES" required id="" cols="30" rows="10" placeholder="<?= LANG['YOUR_COMMENT'] ?? "Vos commentaires" ?>"></textarea><br>

        <!-- <label for=""> <?= LANG['NAME'] ?? "Nom" ?> </label><br> -->
        <input type="text" name="NAME" required id="" placeholder="<?= LANG['YOUR_FULL_NAME'] ?? "Votre nom complet" ?>"><br>

        <!-- <label for=""> <?= LANG['GENRE'] ?? "Genre" ?> </label><br> -->
        <select name="GENRE" id="" required>
            <option value="0" selected> <?= LANG['MAN'] ?? "Homme" ?> </option>
            <option value="1"> <?= LANG['WOMAN'] ?? "Femme" ?> </option>
        </select>

        <!-- <label for=""> <?= LANG['YOUR_COUNTRY'] ?? "Votre pays" ?> </label><br> -->
        <select name="COUNTRY" id="" required class="none">
            <option value="" disabled></option>
            <?php foreach(COUNTRIES as $c => $n){ ?>
                <option value="<?= $c ?>" <?= USER_COUNTRY == $c ? 'selected' : ''; ?> > <?= $n ?> </option>
            <?php } ?>
        </select>

        <!-- <p> <input type="checkbox" name="SPECIAL" value="true" id=""> <span> <?= LANG['CERTIFIED'] ?? "Certifié" ?> </span> </p> -->

        <br><br><br>


        <button type="submit"> <?= LANG['PUBLISH'] ?? "Publier" ?> </button>


    </form>

    </div>




    </div>


    <div class="partner">
    <div class="tit"> <?= LANG['ADS'] ?? "Publicité" ?> </div><br>
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


<?php } ?>




<?php if(!empty($SOURCE)){ ?>

    <script>

// var iframe = document.querySelector('iframe');
  
//   Array.from(iframe.contentWindow.document.getElementsByTagName("img")).forEach(function (e) {
//         if (!e.src.includes(window.location.host)) {
//             e.remove();
//         }
//     });    
    
//     Array.from(iframe.contentWindow.document.getElementsByTagName("div")).forEach(function (e) {
//         var ex = ['ad','ads','pubs','advertising','blocker','site'];
//         for( i in ex)
//         {
//             if ( (e.className).includes(ex[i]) ) {
//                 e.remove();
//             }
//         }
//     });

    </script>

<?php } ?>






