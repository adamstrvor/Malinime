<?php

$ERROR = $var['error'] ?? null;
$USER_INFO = $var['USER'] ?? ['USERNAME'=>"adams","USER_FULLNAME"=>"Traore adama","USER_BIO"=>"I'm adams gang !","PHOTO"=>"default.jpg","GENRE"=>"0"];

?>


<div class="content">

    <div class="top-title"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg> <span> <?= LANG['YOUR_ACCOUNT'] ?? "Votre compte" ?> </span> </div>

    <form method="post" action="" enctype="multipart/form-data" class="info">

    <?php if(!empty($ERROR)){ ?> <div class="error"> <?= $ERROR ?? "" ?> </div><br> <?php } ?>
    
        <div class="title"> <?= LANG['UPDATE_AVATAR'] ?? "Modifier votre avatar" ?> </div>
        <img id="APERCUS" onclick="var photo = document.querySelector('#PHOTO');photo.click(); " src="<?= LFOLDER_USERS.($USER_INFO['PHOTO'] ?? "default.jpg") ?>" alt="">
        <input type="file" name="PHOTO" class="none" id="PHOTO" onchange="profil_changed(this,'#APERCUS');">

        <div class="title"> <?= LANG['USERNAME'] ?? "Nom d'utilisateur" ?> </div>
        <input type="text" name="USERNAME" value="@<?= $USER_INFO['USERNAME'] ?? "" ?>" onkeyup="input_text(this)" required >

        <div class="title"> <?= LANG['YOUR_FULL_NAME'] ?? "Votre nom complet" ?> </div>
        <input type="text" name="USER_FULLNAME" value="<?= $USER_INFO['USER_FULLNAME'] ?? "" ?>" onkeyup="input_text(this)" required >

        <div class="title"> <?= LANG['YOUR_BIO'] ?? "Votre Bio" ?> </div>
        <input type="text" name="USER_BIO" value="<?= $USER_INFO['USER_BIO'] ?? "" ?>" onkeyup="input_text(this)" required>

        <div class="title"> <?= LANG['GENRE'] ?? "Genre" ?> </div>
        <select name="GENRE" id="">
            <option value="<?= $USER_INFO['GENRE'] ?>" <?= $USER_INFO['GENRE'] == '0' ? 'selected' : '' ?> > <?=  LANG['MALE'] ?? "Homme" ?> </option>
            <option value="<?= $USER_INFO['GENRE'] ?>" <?= $USER_INFO['GENRE'] == '0' ? '' : 'selected' ?> > <?= LANG['FEMALE'] ?? "Femme" ?> </option>
        </select>

<br><br>
        <button type="submit"> <?= LANG['UPDATE'] ?? "Mettre à jour" ?> </button>

    </form>

</div>