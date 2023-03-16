
<?php

$request_time = $var['request_time'] ?? 1;

$g[] = ['GAME_NAME'=>"Snake game",'VERSIONS'=>"v.1.0",'PHOTO'=>"snake.png"];
$GAME = $var['GAME'] ?? $g;

?>

<div class="content">

    <div class="top-title"> <?= LANG['GAME_SPACE'] ?? "Espace de jeux" ?> </div>

    <?php if(!empty($GAME)){ ?>
        <div class="items">
        
        <?php foreach($GAME as $G){ ?>

        <a href="<?= LINK['GAME_SNAKE'] ?? "" ?>" class="item">
            <div class="img"> <img src="<?= LFOLDER_GAME ?? "" ?><?= $G['PHOTO'] ?? "" ?>" alt=""> </div>
            <div class="name"> <?= $G['GAME_NAME'] ?? "Game name" ?> - <?= $G['VERSIONS'] ?? "version" ?> </div>
        </a>
        
        <?php } ?>
        
    </div>
    <?php } ?>


</div>