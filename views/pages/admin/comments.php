<?php

$ROOT = new Controller;

$COMMENTS = $var['COMMENTS'] ?? null;

?>

<div class="content">

   
<div class="over">
    <table>
        <thead>
            <th> <?= LANG[''] ?? "Actions" ?> </th>
            <th> <?= LANG[''] ?? "Visible" ?> </th>
            <th> <?= LANG[''] ?? "Name" ?> </th>
            <th> <?= LANG[''] ?? "Comment" ?> </th>
            <th> <?= LANG[''] ?? "Gender" ?> </th>
            <th> <?= LANG[''] ?? "Country" ?> </th>
            <th> <?= LANG[''] ?? "Publish" ?> </th>
            <th> <?= LANG[''] ?? "Watch" ?> </th>
            <th> <?= LANG[''] ?? "Anime" ?> </th>
        </thead>

        <tbody>
            <?php if(!empty($COMMENTS)){ foreach($COMMENTS as $C){ ?>

            <tr>
                <td> <a class="sp" href="<?= LINK['DELETE_COMMENTS'] ?? "" ?>/<?= $C['ID'] ?? ""?>"> <?= LANG[''] ?? "Supprimer" ?> </a> </td>
                <td class="<?= !empty($C['VISIBLE']) && $C['VISIBLE'] == 'true' ? 'green' : '' ?>" > <a href="<?= LINK['UPDATE_COMMENTS'] ?? "" ?>/<?= $C['ID'] ?? ""?>"> <?= !empty($C['VISIBLE']) && $C['VISIBLE'] == 'true' ? LANG[''] ?? "Oui" : LANG[''] ?? "Non" ?> </a> </td>
                <td> <?= $C['FULL_NAME'] ?? "" ?> </td>
                <td> <?= $C['MESSAGES'] ?? "" ?> </td>
                <td> <?= $C['GENRE'] == 0 ? LANG['MALE'] ?? 'Homme' : LANG['FEMALE'] ?? "Femme" ?> </td>
                <td class="country"> <span> (<?= $C['COUNTRY'] ?? "" ?>) </span> <?= file_exists(FOLDER_IMAGES_COUNTRIES.(strtolower($C['COUNTRY'] ?? "ml")).'.svg') ? join('',file(FOLDER_IMAGES_COUNTRIES.(strtolower($C['COUNTRY'] ?? "ml")).'.svg')) : ""; ?> </td>
                <td class=" green"> <?= $ROOT->datetime_compare($C['DATETIMES'] ?? "") ?> </td>
                <td> <a target="_blank" href="<?= LINK['WATCH'] ?? "" ?>/<?= $C['VIDEO_ID'] ?? ""?>"> <?= LANG[''] ?? "Watch" ?> </a> </td>
                <td> <a target="_blank" href="<?= LINK['ANIME'] ?? "" ?>/<?= $C['ANIME_ID'] ?? ""?>"> <?= LANG[''] ?? "Anime" ?> </a> </td>
            </tr>

            <?php  } }else{ ?>
                <tr>
                <td colspan="6" class="sp"> <?= LANG[''] ?? "No user(s)" ?> </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>




</div>