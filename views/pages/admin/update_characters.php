<?php

$ROOT = new Controller;
$CHARACTERS = $var['PERSO'] ?? null;

?>

<div class="content">

    <div class="top-title"> <?= LANG[''] ?? "Ajouter un character à cet anime " ?> </div>

    <form action="" method="post" enctype="multipart/form-data">

    <p> <img src="<?= LFOLDER_ANIME_CHARACTERS ?? "" ?>/<?= $ANIME['PHOTO'] ?? "" ?>" width="100px" height="auto" alt=""></p>

        <label for=""> <?= LANG['UPLOAD_VIDEO'] ?? "Charger l'image" ?> </label>
        <input type="file"  name="PHOTO" id="" ><br>

        <label for=""> <?= LANG[''] ?? "Nom du character" ?> </label>
        <input type="text" value="<?= $CHARACTERS['NAMES'] ?? "" ?>" name="NAMES" id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Lien" ?>"><br>

        <label for=""> <?= LANG[''] ?? "Special ?" ?> </label>
        <input type="checkbox" name="SPECIAL" value="true" id=""><br>

        <?php foreach(LANG_LIST as $l){ ?>
        <textarea name="DESCRIP_<?= $l['LANG'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Description ( ".($l['LANG'] ?? "" )."  )" ?>"></textarea><br>
        <?php } ?>
        <!-- <textarea name="DESCRIP" value="<?= $VIDEO['DESCRIP'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= $VIDEO['DESCRIP'] ?? "" ?>" ></textarea><br> -->

        <br><br>
        <button type="submit"> <?= LANG[''] ?? "Enregistrer" ?> </button>

    </form>


</div>