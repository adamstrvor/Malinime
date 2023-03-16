
<?php

$ROOT = new Controller;

$LIST = $var['ANIMES'] ?? null;
$VIDEO = $var['VIDEOS'] ?? null;

?>


<div class="content">

<div class="top-title"> <?= LANG['ADD_ANIME'] ?? "Ajouter un nouvelle anime" ?> </div>

<form action="" method="post" enctype="multipart/form-data">

    <label for=""> <?= LANG['UPLOAD_IMAGE'] ?? "Charger l'image" ?> </label>
    <input type="file" name="POSTER" id="" required><br>

    <input type="text" name="FULL_NAME" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Nom officielle" ?>"><br>
    <input type="text" name="ORIGINAL_NAME" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Nom original" ?>"><br>
    <input type="text" name="ROMANJI" id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Romanji" ?>"><br>
    <?php foreach(LANG_LIST as $l){ ?>
    <textarea name="SYNOPSIS_<?= $l['LANG'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Synopsis ( ".($l['LANG'] ?? "" )."  )" ?>"></textarea><br>
    <?php } ?>

    <label for=""> <?= LANG['STATUS'] ?? "Status" ?> </label>
    <select name="STATUS" id="">
        <option value="0" selected> <?= LANG[''] ?? "En cours" ?> </option>
        <option value="1" > <?= LANG[''] ?? "Terminé" ?> </option>
    </select>
    <input type="text" name="STUDIO" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Studio" ?>"><br>
    <input type="text" name="TRAILER" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Lien du Trailer" ?>"><br>
    <input type="text" name="OUT_DATE" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Date de sortie" ?>"><br>
    <input type="text" name="GENRE" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Genres" ?>"><br>

    <label for=""> <?= LANG['VERSION'] ?? "Version" ?> </label>
    <select name="VERSION" id="">
        <option value="VOSTFR" selected> <?= LANG[''] ?? "VOSTFR" ?> </option>
        <option value="VF" > <?= LANG[''] ?? "VF" ?> </option>
    </select>

    <br><br>
    <button type="submit"> <?= LANG['SEND'] ?? "Envoyer" ?> </button>

</form>

<div class="top-title"> <?= LANG['BEST_SELECT'] ?? "Les meilleures sélections" ?> </div>

<?php if(!empty($LIST)){ ?>


<div class="items">

    <?php foreach($LIST as $ITEM){ ?>

    <?php if(!empty($VIDEO)){ foreach($VIDEO as $V){ if($V['ANIME_ID'] == $ITEM['ID']){ $OWN_VIDEO[] = $V;$EPISODE[] = $V['EPISODE']; } } } ?>

    <div class="item" >

        <a href="<?= LINK['ADD_VIDEO'] ?? "" ?>/<?= $ITEM['ID'] ?? "" ?>" class="img ">
            <img src="<?= LFOLDER_ANIME_POSTER ?? "" ?><?= !empty($ITEM['POSTER']) ? $ITEM['POSTER'] : "default.png" ?>" alt="">
            <div class="vf"> <?= $ITEM['VERSIONS'] ?? "VOSTFR" ?> </div>
            <div class="more"> <span> <?= LANG['SEE_MORE'] ?? "Voir plus..." ?> </span> </div>
        </a>

        <div class="info">

        <div class="title"> <?= $ITEM["FULL_NAME"] ?? "Titre" ?> </div>

        <div class="link">
            
        <?php if(!empty($OWN_VIDEO) && !empty($EPISODE)){ foreach($OWN_VIDEO as $OWN){ if($OWN['EPISODE'] == min($EPISODE) || $OWN['EPISODE'] == max($EPISODE) ){ ?>

        <a href="<?= LINK['WATCH'] ?? "" ?>/<?= $OWN['ID'] ?? "" ?>" class="sp <?= $OWN['PUBLISH_DATE'] == $ROOT->actual_date() ? 'red' : ''; ?>" > <?= $OWN['EPISODE'] ?? "" ?> </a> 
        <span class="time"> <?= $ROOT->datetime_compare($OWN['PUBLISH_DATETIME'] ?? "") ?? "" ?> </span><br>

        <?php } } } $OWN_VIDEO = null;$EPISODE=null; ?>

        </div>

        <a href="<?= LINK['DELETE_ANIME'] ?? "" ?>/<?= $ITEM['ID'] ?? "" ?>" class="red" onclick="var test = confirm('Voulez-vous supprimer cet anime ?'); if(test == false){ event.preventDefault() ;exit;} " > <?= LANG[''] ?? "Supprimer" ?> </a>

        </div>

        </div>

    <?php } ?> 

</div>

<?php }else{ ?>

<div class="empty"> <span> <?= LANG['WAITING_FOR'] ?? "En attente" ?>... </span> </div>

<?php } ?>


</div>