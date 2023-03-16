<?php

$ROOT = new Controller;

$VIDEO = $var['VIDEO'] ?? null;

?>

<div class="content">

    <div class="top-title"> <?= LANG[''] ?? "Modifier la vidéo" ?> </div>

    <form action="" method="post" enctype="multipart/form-data">

        <label for=""> <?= LANG['UPLOAD_VIDEO'] ?? "Charger la vidéo" ?> </label>
        <input type="file"  name="VIDEO" id="" ><br>

        <label for=""> <?= LANG[''] ?? "Ou le lien du serveur" ?> </label>
        <input type="text" value="<?= $VIDEO['SOURCE_LINK'] ?? "" ?>" name="SOURCE_LINK" id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Lien" ?>"><br>

        <label for=""> <?= LANG[''] ?? "Ou le lien de l'iframe" ?> </label>
        <input type="text" value="<?= $VIDEO['IFRAME_LINK'] ?? "" ?>" name="IFRAME_LINK" id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Lien" ?>"><br>

        <?php foreach(LANG_LIST as $l){ ?>
        <textarea name="DESCRIP_<?= $l['LANG'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Description ( ".($l['LANG'] ?? "" )."  )" ?>"></textarea><br>
        <?php } ?>
        <!-- <textarea name="DESCRIP" value="<?= $VIDEO['DESCRIP'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= $VIDEO['DESCRIP'] ?? "" ?>" ></textarea><br> -->

        <label for=""> <?= LANG[''] ?? "Signaler un avertissement de -18 ans" ?> </label>
        <select name="WARNING" id="">
            <option value="false" <?= !empty($VIDEO['WARNING']) && $VIDEO['WARNING'] == "false" ? "selected" : "" ?> > Non </option>
            <option value="true" <?= !empty($VIDEO['WARNING']) && $VIDEO['WARNING'] == "true" ? "selected" : "" ?> > Oui </option>
        </select>

        <br><br>
        <button type="submit"> <?= LANG['UPDATE'] ?? "Mettre a jour" ?> </button>

    </form>


</div>