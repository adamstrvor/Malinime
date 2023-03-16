<div class="content">

    <div class="top-title"> <?= LANG['PRIVACY'] ?? "Confidentialités" ?> </div><br>

    <div class="text">

    <?= LANG['USER_DATA'] ?? "Les données utilisateurs collectés par le site malinime.com et ses tiers sont sans conséquences puissent qu'elles ne contiennent pas d'éléments compromettant pour l'utilisateur en question  " ?><br>
    <span> <?= LANG['DATA_ARE'] ?? "Ces données sont entre autre:" ?> </span>
    <ul>
        <li> <?= LANG['LOCAL_AREA_DATA'] ?? "Données de géolocalisation" ?> </li>
        <li> <?= LANG['SITE_DATA_USE'] ?? "Données d'utilisations du site" ?> </li>
        <li> <?= LANG['ETC'] ?? "Etc..." ?> </li>

    </ul>

    <br>
    <?= LANG['FOR_MORE_INFO'] ?? "Pour toute informations supplementaires vous êtes prier de bien vouloir contactez les administrateurs du site à l'adresse suivante:" ?>
    <br><br>

    <a href="mailto:<?= SITE_EMAIL ?? "" ?>"> <?= SITE_EMAIL ?? "" ?> </a>


    </div>

</div>