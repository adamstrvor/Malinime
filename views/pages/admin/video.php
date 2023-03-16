<?php

$ROOT = new Controller;

$EPISODE = $var['ALL_VIDEO'] ?? null;

?>

<div class="content">

    <div class="top-title"> <?= LANG['ADD_VIDEO'] ?? "Ajouter une nouvelle vidéo" ?> </div>

    <form action="" method="post" enctype="multipart/form-data">

        <label for=""> <?= LANG['UPLOAD_VIDEO'] ?? "Charger la vidéo" ?> </label>
        <input type="file"  name="VIDEO" id="" ><br>

        <label for=""> <?= LANG[''] ?? "Ou le lien du serveur" ?> </label>
        <input type="text" name="SOURCE_LINK" id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Lien" ?>"><br>

        <label for=""> <?= LANG[''] ?? "Ou le lien de l'iframe" ?> </label>
        <input type="text" name="IFRAME_LINK" id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Lien" ?>"><br>

        <?php foreach(LANG_LIST as $l){ ?>
        <textarea name="DESCRIP_<?= $l['LANG'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Description ( ".($l['LANG'] ?? "" )."  )" ?>"></textarea><br>
        <?php } ?>
        <!-- <textarea name="DESCRIP" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Description de la video" ?>" ></textarea><br> -->

        <input type="number" name="EPISODE" required id="" onkeyup="input_number(this)" placeholder="<?= LANG[''] ?? "Episode" ?>"><br>

        <label for=""> <?= LANG[''] ?? "Signaler un avertissement de -18 ans" ?> </label>
        <select name="WARNING" id="">
            <option value="false"> Non </option>
            <option value="true"> Oui </option>
        </select>

        <br><br>
        <button type="submit"> <?= LANG['SEND'] ?? "Envoyer" ?> </button>

    </form>



<?php if(!empty($EPISODE)){ ?>

<div class="list">

<?php foreach($EPISODE as $E){ ?>

    <a href="<?= LINK['DELETE_VIDEO'] ?? "" ?>/<?= $E['ID'] ?>" class="item" onclick="var test = confirm('Voulez-vous supprimer cette video ?'); if(test == false){ event.preventDefault() ;exit;} "  > <?= str_replace('<ap>',"'", $E['ANIME_NAME'] ?? "Titre" ) ?> - <?= $E['EPISODE'] < 10 ? '0'.$E['EPISODE'] : $E['EPISODE'] ?> - <?= $E['ANIME_VERSION'] ?? "Version" ?>  <span class="l">  </span> </a>

<?php } ?>

</div>

<?php } ?>

</div>