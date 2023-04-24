
<?php

$ANIME = $var['ANIME'] ?? null;

?>

<div class="content">

<div class="top-title"> <?= LANG[''] ?? "Modifier l' anime" ?> </div>

<form action="" method="post" enctype="multipart/form-data">

    <p> <img src="<?= LFOLDER_ANIME_POSTER ?? "" ?>/<?= $ANIME['POSTER'] ?? "" ?>" width="100px" height="auto" alt=""></p>

    <label for=""> <?= LANG[''] ?? "Changer l'image" ?> </label>
    <input type="file" name="POSTER" id="" ><br>

    <label for="">Est-ce une MASTERCALSS</label>
    <input type="checkbox" name="SPECIAL" value="true" id=""><br>

    <input type="text" name="FULL_NAME" value="<?= $ANIME['FULL_NAME'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Nom officielle" ?>"><br>
    <input type="text" name="ORIGINAL_NAME" value="<?= $ANIME['ORIGINAL_NAME'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Nom original" ?>"><br>
    <input type="text" name="ROMANJI" value="<?= $ANIME['ROMANJI'] ?? "" ?>" id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Romanji" ?>"><br>
    <?php foreach(LANG_LIST as $l){ ?>
    <textarea name="SYNOPSIS_<?= $l['LANG'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Synopsis ( ".($l['LANG'] ?? "" )."  )" ?>"></textarea><br>
    <?php } ?>

    <label for=""> <?= LANG['STATUS'] ?? "Status" ?> </label>
    <select name="STATUS" id="">
        <option value="0" <?= "0" == ($ANIME['STATUSS'] ?? "") ? "selected" : ""; ?>> <?= LANG[''] ?? "En cours" ?> </option>
        <option value="1" <?= "1" == ($ANIME['STATUSS'] ?? "") ? "selected" : ""; ?> > <?= LANG[''] ?? "Terminé" ?> </option>
    </select>
    <input type="text" name="STUDIO" value="<?= $ANIME['STUDIO'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Studio" ?>"><br>
    <input type="text" name="TRAILER" value="<?= $ANIME['TRAILER'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Lien du Trailer" ?>"><br>
    <input type="text" name="OUT_DATE" value="<?= $ANIME['OUT_DATE'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Date de sortie" ?>"><br>
    <input type="text" name="GENRE" value="<?= $ANIME['GENRE'] ?? "" ?>" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Genres" ?>"><br>

    <label for=""> <?= LANG['VERSION'] ?? "Version" ?> </label>
    <select name="VERSION" id="">
        <option value="VOSTFR"  <?= "VOSTFR" == ($ANIME['VERSIONS'] ?? "") ? "selected" : ""; ?> > <?= LANG[''] ?? "VOSTFR" ?> </option>
        <option value="VF" <?= "VF" == ($ANIME['VERSIONS'] ?? "") ? "selected" : ""; ?> > <?= LANG[''] ?? "VF" ?> </option>
    </select>

    <br><br>
    <button type="submit"> <?= LANG['UPDATE'] ?? "Mettre à jour" ?> </button>

</form>

</div>