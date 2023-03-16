<?php


?>

<div class="content">

    <div class="top-title"> <?= LANG['CONTACT_US'] ?? "Contacttez-nous" ?> </div><br>

    <form action="" method="post">

    <label for=""> <?= LANG['WHAT_FULL_NAME'] ?? "Quelle est votre nom complet" ?> ? </label>
    <input type="text" name="FULL_NAME" required id="" onkeyup="input_text(this)" placeholder="<?= LANG['YOUR_FULL_NAME'] ?? "Votre nom complet" ?>"><br>

    <label for=""> <?= LANG['YOUR_MOTIF'] ?? "Quelle est votre motif" ?> ? </label>
    <input type="text" name="MOTIF" required id="" onkeyup="input_text(this)" placeholder="<?= LANG['YOUR_MOTIVE'] ?? "Votre motif" ?>"><br>

    <label for=""> <?= LANG['YOUR_MESSAGE'] ?? "Votre message" ?> </label>
    <textarea name="MESSAGES" id="" cols="30" rows="10" placeholder="<?= LANG['MESSAGE'] ?? "Message" ?>"></textarea>

    <br><br>
    <button> <?= LANG['SEND'] ?? "Envoyez" ?> </button>

    <br>
    <p> 
    <?= LANG['FOR_MORE_INFO'] ?? "Pour toute informations supplementaires vous êtes prier de bien vouloir contactez les administrateurs du site à l'adresse suivante:" ?>
    <br><br>

    <a href="mailto:<?= SITE_EMAIL ?? "" ?>"> <?= SITE_EMAIL ?? "" ?> </a> </p>

    </form>

</div>