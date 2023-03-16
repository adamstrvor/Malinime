<?php

$ROOT = new Controller;
$CHARACTERS = $var['PERSO'] ?? null;

?>

<div class="content">

    <div class="top-title"> <?= LANG[''] ?? "Ajouter un character à cet anime " ?> </div>

    <form action="" method="post" enctype="multipart/form-data">

        <label for=""> <?= LANG['UPLOAD_VIDEO'] ?? "Charger l'image" ?> </label>
        <input type="file" required name="PHOTO" id="" ><br>

        <label for=""> <?= LANG[''] ?? "Nom du character" ?> </label>
        <input type="text" value="" name="NAMES" id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Lien" ?>"><br>
        <label for=""> <?= LANG[''] ?? "Special ?" ?> </label>
        <input type="checkbox" name="SPECIAL" value="true" id=""><br>

        <?php foreach(LANG_LIST as $l){ ?>
        <textarea name="DESCRIP_<?= $l['LANG'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Description ( ".($l['LANG'] ?? "" )."  )" ?>"></textarea><br>
        <?php } ?>
        <!-- <textarea name="DESCRIP" value="<?= $VIDEO['DESCRIP'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= $VIDEO['DESCRIP'] ?? "" ?>" ></textarea><br> -->

        <br><br>
        <button type="submit"> <?= LANG[''] ?? "Enregistrer" ?> </button>

    </form>

<?php if(!empty($CHARACTERS)){ ?>

<div class="list">

<?php foreach($CHARACTERS as $C){ ?>

    <a href="<?= LINK['UPDATE_CHARACTERS'] ?? "" ?>/<?= $C['ID'] ?>" class="item"  > <?= $C['NAMES'] ?? "" ?>  <span class="l">  </span> </a>
    <a href="<?= LINK['DELETE_CHARACTERS'] ?? "" ?>/<?= $C['ID'] ?>" class="item red" onclick="var test = confirm('Voulez-vous supprimer cette video ?'); if(test == false){ event.preventDefault() ;exit;} "  > <?= $C['NAMES'] ?? "" ?>  <span class="l">  </span> </a>

<?php } ?>

</div>

<?php } ?>


</div>