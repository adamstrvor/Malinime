<?php

$ERROR = $var['error'] ?? null;

?>

<div class="background">
    <img src="<?= LFOLDER_ANIME_PUBS ?? "" ?>default.jpg" alt="">
</div>

<div class="content" onselectstart="return false;">

    <form action="" method="post" enctype="multipart/form-data">

       <a href="<?= LINK['MAIN'] ?? "" ?>" class="img"> <img src="<?= LFOLDER_LOGO ?? "" ?>logo.png" alt=""> </a>

        <?php if(!empty($ERROR)){ echo '<div class="error"> '.$ERROR.' </div>'; }else{ ?>
        <div class="info"> <?= LANG['PUBS_INFO'] ?? "Bonjour et bienvenue sur l'espace publicitaire.<br> Pour la promotion de vos produits, veuillez remplir votre demande ! " ?> </div>
        <?php } ?>

        <label for=""> <?= LANG['BRAND_ICON'] ?? "Icon de la marque" ?> </label>
        <input type="file" name="BRAND_ICON" required id="">

        <label for=""> <?= LANG['BRAND_NAME'] ?? "Nom de la marque" ?> </label>
        <input type="text" name="BRAND_NAME" onkeyup="input_text(this)" required id="">

        <label for=""> <?= LANG['BRAND_SLOGAN'] ?? "Slogan de la marque" ?> </label>
        <textarea name="BRAND_SLOGAN" onkeyup="input_text(this)" required id=""></textarea>

        <label for=""> <?= LANG[''] ?? "Contact de la marque ( Email ou Portable ) ?" ?> </label>
        <input type="text" name="BRAND_CONTACT" onkeyup="input_text(this)" required id="">

        <label for=""> <?= LANG['BRAND_NAME'] ?? "Pack de durée de la publicité" ?> </label>

        <select name="BRAND_PUB_TIME" id="">
            <option value="1"> <?= LANG[''] ?? "1 Semaine" ?></option>
            <option value="4"> <?= LANG[''] ?? "1 Mois" ?></option>
            <option value="12"> <?= LANG[''] ?? "3 Mois" ?></option>
        </select>

        <label for=""> <?= LANG['BRAND_PUB_ICON'] ?? "Inserez l'image à promouvoir" ?> </label>
        <input type="file" name="BRAND_PUB_ICON" required id="">

        <label for=""> <?= LANG[''] ?? "Disposez vous d'une page ou d'un site ?" ?> </label>
        <input type="text" name="BRAND_SITE" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Le lien vers votre site ou page facebook...etc"; ?>" id="">

        <br><br>

        <input type="checkbox" name="RIGHT" id="dfdsaf"> <label for="dfdsaf" class="inline"> <?= LANG[''] ?? "Veuillez acceptez nos" ?> <a href=""> <?= LANG['TERMS'] ?? "condition d'utilisation" ?> </a> <?= LANG[''] ?? "pour continuer." ?> </label>

        <br><br>

        <button type="submit"> <?= LANG['SEND_ASK'] ?? "Envoyez ma demande"; ?> </button>


    </form>

</div>