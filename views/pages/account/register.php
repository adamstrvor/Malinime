<?php

$ERROR = $var['error'] ?? null;
$USER_INFO = $var['USER'] ?? null;

?>


<div class="content">

    <div class="top-title"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg> <span> <?= LANG['CREATE_ACCOUNT'] ?? "Créer mon compte" ?> </span> </div>

    <form method="post" action="" enctype="multipart/form-data" class="info">

    <?php if(!empty($ERROR)){ ?> <div class="error"> <?= $ERROR ?? "" ?> </div><br> <?php } ?>
        <div class="title"> <?= LANG['CREATE_AVATAR'] ?? "Créer votre avatar" ?> </div>
        <img id="APERCUS" onclick="var photo = document.querySelector('#PHOTO');photo.click(); " src="<?= LFOLDER_USERS.($USER_INFO['PHOTO'] ?? "default.jpg") ?>" alt="">
        <input type="file" name="PHOTO" id="PHOTO" onchange="profil_changed(this,'#APERCUS');">

        <div class="title"> <?= LANG['USERNAME'] ?? "Nom d'utilisateur" ?> </div>
        <input type="text" name="USERNAME"  onkeyup="input_text(this)" placeholder="" required >

        <div class="title"> <?= LANG['NEW_PASSWORD'] ?? "Nouveau mot de passe" ?> </div>
        <input type="password" name="USER_PASSWORD" placeholder="" onkeyup="input_text(this)" required>

        <div class="title"> <?= LANG['YOUR_FULL_NAME'] ?? "Votre nom complet" ?> </div>
        <input type="text" name="USER_FULLNAME" value="<?= $USER_INFO['USER_FULLNAME'] ?? "" ?>" onkeyup="input_text(this)" required >

        <div class="title"> <?= LANG['YOUR_BIO'] ?? "Votre Bio" ?> </div>
        <input type="text" name="USER_BIO" value="<?= $USER_INFO['USER_BIO'] ?? "" ?>" onkeyup="input_text(this)" required>


        <div class="title"> <?= LANG['GENRE'] ?? "Genre" ?> </div>
        <select name="GENRE" id="">
            <option value="<?= !empty($USER_INFO['GENRE']) ? $USER_INFO['GENRE'] : '0' ?>" <?= !empty($USER_INFO['GENRE']) && $USER_INFO['GENRE'] == '0' ? 'selected' : '' ?> > <?=  LANG['MALE'] ?? "Homme" ?> </option>
            <option value="<?= !empty($USER_INFO['GENRE']) ? $USER_INFO['GENRE'] : '1' ?>" <?= !empty($USER_INFO['GENRE']) && $USER_INFO['GENRE'] == '0' ? '' : 'selected' ?> > <?= LANG['FEMALE'] ?? "Femme" ?> </option>
        </select>

<br><br>
        <button type="submit"> <?= LANG['CREATE_ACCOUNT'] ?? "Créer un compte" ?> </button>

        <br><br>

        <a href="<?= LINK['CUSTOMER_CONNEXION'] ?? "" ?>"> <?= LANG['SE_CONNECTER'] ?? "Se connecter" ?> </a>

    </form>

</div>