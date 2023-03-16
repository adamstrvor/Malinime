<?php

$ERROR = $var['error'] ?? null;
$USER_INFO = $var['USER'] ?? null;

?>


<div class="content">

    <div class="top-title"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg> <span> <?= LANG['SE_CONNECTER'] ?? "Connexion" ?> </span> </div>

    <form method="post" action="" class="info">

    <?php if(!empty($ERROR)){ ?> <div class="error"> <?= $ERROR ?? "" ?> </div><br> <?php } ?>

        <div class="title"> <?= LANG['USERNAME'] ?? "Nom d'utilisateur" ?> </div>
        <input type="text" name="USERNAME" placeholder="" onkeyup="input_text(this)" required >

        <div class="title"> <?= LANG['PASSWORD'] ?? "Mot de passe" ?> </div>
        <input type="password" name="USER_PASSWORD" placeholder="" onkeyup="input_text(this)" required >

<br><br>
        <button type="submit"> <?= LANG['SE_CONNECTER'] ?? "Se connecter" ?> </button>

        <br><br>

        <a href="<?= LINK['CREATE_ACCOUNT'] ?? "" ?>"> <?= LANG['CREATE_ACCOUNT'] ?? "Créer mon compte" ?> </a>

    </form>

</div>