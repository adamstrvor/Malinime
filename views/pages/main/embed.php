<?php

$request_time = $var['request_time'] ?? 1;

$VIDEO_INFO = $var['VIDEO'] ?? null;

if(!empty($VIDEO_INFO)){
$VIDEO_TITLE = str_replace('<ap>',"'", ($VIDEO_INFO['ANIME_NAME'] ?? "Titre"));//.' - '.($VIDEO_INFO['EPISODE'] < 10 ? '0'.$VIDEO_INFO['EPISODE'] : $VIDEO_INFO['EPISODE']) ); // .' - '.($VIDEO_INFO['ANIME_VERSION'] ?? "Version")
// $VIDEO_TITLE = null;
$VIDEO_TYPE = $VIDEO_INFO['TYPES'] ?? "video/mp4";
$VIDEO_DESC = str_replace('<ap>',"'", ($VIDEO_INFO['DESCRIP_'.LANG_SYSTEM] ?? $VIDEO_INFO['DESCRIP_'.DEFAULT_LANG] ?? (LANG['EPISODE'] ?? "Episode").' - '. ($VIDEO_INFO['EPISODE'] < 10 ? '0'.$VIDEO_INFO['EPISODE'] : $VIDEO_INFO['EPISODE']) ) );
}
else
{
    $VIDEO_TITLE = LANG['VIDEO_NOTFOUND'] ?? "Video introuvable";
    $VIDEO_TYPE = "video/mp4";
    $VIDEO_DESC = LANG['REMOVE_OR_NOT_EXIST'] ?? "La vidéo est soit inexistante a soit été rétirée";
}

if(!empty($VIDEO_INFO['SOURCE_LINK']))
{
    $SELECTED_SOURCE = $var['SELECTED_SOURCE'] ?? 0;
    $SOURCE = explode('|',$VIDEO_INFO['SOURCE_LINK']) ;
    $VIDEO_LOCATION = $SOURCE[$SELECTED_SOURCE];
}
else
$VIDEO_LOCATION = LFOLDER_ANIME_VIDEO.($VIDEO_INFO['LOCATIONS'] ?? "default.mp4");

ob_start();
$subtitle[] =['time'=>'10','duration'=>"7",'status'=>'none','text'=> ( LANG['PUT_FULL_SCREEN'] ?? "appuyer la touche ' f ' pour le plein écran " )." !"];
$subtitle[] =['time'=>'20','duration'=>"10",'status'=>'none','text'=> ( LANG['PUT_SETTING'] ?? "appuyer la touche ' s ' pour les paramètres " )." !"];
if(empty($VIDEO_INFO['SUBTITLE']))
$VIDEO_SUBTITLE = $subtitle;
else
$VIDEO_SUBTITLE = json_decode( $VIDEO_INFO['SUBTITLE'] ?? "");
ob_get_clean();

$CURRENT_TIME = $var['currentTime'] ?? null;
$PASSWORD_STATE = $var['password_state'] ?? null;
$TRY = $var['try'] ?? null;

?>

<!-- //////////////////////////////////////////////////////  -->

<div class="empty" id="EMPTY">

<div class="svg"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video-off-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.961 12.365a1.99 1.99 0 0 0 .522-1.103l3.11 1.382A1 1 0 0 0 16 11.731V4.269a1 1 0 0 0-1.406-.913l-3.111 1.382A2 2 0 0 0 9.5 3H4.272l6.69 9.365zm-10.114-9A2.001 2.001 0 0 0 0 5v6a2 2 0 0 0 2 2h5.728L.847 3.366zm9.746 11.925-10-14 .814-.58 10 14-.814.58z"/></svg> </div>

<div class="title"> <?= $LANG['VIDEO_NOT_FOUNDED'] ?? "Vidéo introuvale" ?> </div>

<div class="subtitle"> <?= $LANG['VIDEO_NOT_FOUND_INFO'] ?? "La vidéo est soit inexistante ou été rétiré de la plateforme" ?> </div>

</div>

<div onselectstart="return false" class="content" id="CONTENT">

<!-- FLOU TOP -->

    <!-- <div class="flou-top hide-show"></div> -->

<!-- VIDEO CONTAINER -->

    <!-- <div class="video"> -->
        <video width="auto" height="auto" id="VIDEO" poster="<?= LFOLDER_ANIME_POSTER ?? "" ?><?= $VIDEO_INFO['ANIME_POSTER'] ?? "" ?>" >

            <source src="<?= !empty($VIDEO_INFO['WARNING']) && $VIDEO_INFO['WARNING'] == 'true' && empty($PASSWORD_STATE) ? $VIDEO_LOCATION ?? "" : $VIDEO_LOCATION ?? "" ?>" type="<?= $VIDEO_TYPE ?? "" ?>" >
            
            <?= $LANG['YOUR_NAV_DONT_SUPPORT'] ?? "Votre navigateur ne supporte pas ce type de video" ?>.

        </video>
    <!-- </div> -->

<!-- ACIONS CONTAINER -->

    <div class="actions hide-show" id="ACTIONS">

        <div class="progress" id="PROGRESS_BAR">
            <div class="progress1" id="PROGRESS_HOVER"></div>
            <div class="progress2" id="PROGRESS_BUFFERED"></div>
            <div class="progress3" id="PROGRESS_BAR_CURRENT"> <span class="head"></span> </div>
            <input type="range" name="" oninput="moveProgress();" value="0" min="0" max="100" id="PROGRESS_CURRENT">

            <div class="subtitles"> <div class="text" id="SUBTITLES"></div> </div>

            <div class="overview" id="OVERVIEW">
                    <video preload="auto" width="auto" height="auto" id="VIDEO_OVERVIEW">

                        <source src="<?= !empty($VIDEO_INFO['WARNING']) && $VIDEO_INFO['WARNING'] == 'true' && empty($PASSWORD_STATE) ? $VIDEO_LOCATION ?? "" : $VIDEO_LOCATION ?? "" ?>" id="OVERVIEW_VIDEO_SOURCE" type="<?= $VIDEO_TYPE ?? "" ?>" >
                        
                        <?= $LANG['YOUR_NAV_DONT_SUPPORT'] ?? "Votre navigateur ne supporte pas ce type de video" ?>.

                    </video>
                    <div class="timer" id="OV_TIME"> <span class="sp">00:00</span> / <span>00:00</span> </div>
            </div>
        </div>

        <div class="options" id="OPTIONS">

            <div class="button left" onclick="playPause();"> 
                <span id="PLAY"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16"><path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/></svg> </span>
                <span id="PAUSE"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pause-fill" viewBox="0 0 16 16"><path d="M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5zm5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5z"/></svg> </span> 
            </div>

            <div class="button left" id="BACK"><span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/><path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/></svg> </span> </div>
            
            <div class="time left"> <span id="TIME" class="sp">00:00</span> / <span id="DURATION">00:00</span> </div>


            <div class="button left" id="VOLUME_BUTTON"> 
                <span id="VOLUME_HIGH"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-volume-up-fill" viewBox="0 0 16 16"><path d="M11.536 14.01A8.473 8.473 0 0 0 14.026 8a8.473 8.473 0 0 0-2.49-6.01l-.708.707A7.476 7.476 0 0 1 13.025 8c0 2.071-.84 3.946-2.197 5.303l.708.707z"/><path d="M10.121 12.596A6.48 6.48 0 0 0 12.025 8a6.48 6.48 0 0 0-1.904-4.596l-.707.707A5.483 5.483 0 0 1 11.025 8a5.483 5.483 0 0 1-1.61 3.89l.706.706z"/><path d="M8.707 11.182A4.486 4.486 0 0 0 10.025 8a4.486 4.486 0 0 0-1.318-3.182L8 5.525A3.489 3.489 0 0 1 9.025 8 3.49 3.49 0 0 1 8 10.475l.707.707zM6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06z"/></svg> </span> 
                <span id="VOLUME_MIDDLE"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-volume-down-fill" viewBox="0 0 16 16"><path d="M9 4a.5.5 0 0 0-.812-.39L5.825 5.5H3.5A.5.5 0 0 0 3 6v4a.5.5 0 0 0 .5.5h2.325l2.363 1.89A.5.5 0 0 0 9 12V4zm3.025 4a4.486 4.486 0 0 1-1.318 3.182L10 10.475A3.489 3.489 0 0 0 11.025 8 3.49 3.49 0 0 0 10 5.525l.707-.707A4.486 4.486 0 0 1 12.025 8z"/></svg> </span>
                <span id="VOLUME_MUTE"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-volume-mute-fill" viewBox="0 0 16 16"><path d="M6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06zm7.137 2.096a.5.5 0 0 1 0 .708L12.207 8l1.647 1.646a.5.5 0 0 1-.708.708L11.5 8.707l-1.646 1.647a.5.5 0 0 1-.708-.708L10.793 8 9.146 6.354a.5.5 0 1 1 .708-.708L11.5 7.293l1.646-1.647a.5.5 0 0 1 .708 0z"/></svg> </span>
            </div>

            <div class="volume " id="VOLUME_CONTAINER" >
            <!-- <span class="head"></span> -->
            <div class="volume3" id="VOLUME_BAR"> <span class="head"></span> </div> 
            <input type="range" name="" oninput="moveVolume();" value="100" min="0" max="100" id="VOLUME_CURRENT">
            </div>

            <div class=" button right" id="SETTING_BUTTON" onclick="openSetting();"> <span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sliders" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z"/></svg> </div>

            <div class="button right" id="PICTURE_IN_PICTURE_BUTTON" onclick="openPictureInPicture();" > <span > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pip-fill" viewBox="0 0 16 16"><path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm7 6h5a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-5a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5z"/></svg> </span> </div>

            <div class="button right" onclick="switchFullScreen();"> 
                <span id="FULLSCREEN"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fullscreen" viewBox="0 0 16 16"><path d="M1.5 1a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4A1.5 1.5 0 0 1 1.5 0h4a.5.5 0 0 1 0 1h-4zM10 .5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 16 1.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zM.5 10a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 0 14.5v-4a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v4a1.5 1.5 0 0 1-1.5 1.5h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5z"/></svg> </span>
                <span id="EXIT_FULLSCREEN"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fullscreen-exit" viewBox="0 0 16 16"><path d="M5.5 0a.5.5 0 0 1 .5.5v4A1.5 1.5 0 0 1 4.5 6h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5zm5 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 10 4.5v-4a.5.5 0 0 1 .5-.5zM0 10.5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 6 11.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zm10 1a1.5 1.5 0 0 1 1.5-1.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4z"/></svg> </span>
            </div>

        </div>

        <div class="flou-bottom"></div>
        
    </div>
    
    <!-- FLOU BOTTOM -->
    

    <div id="VIDEO_MASK" class="box trans" >  </div>  <!--   <div class="loading"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/></svg> </div>  -->

    <div onclick="playPause();" class="box" id="START_BOX"> <?php if(!empty($VIDEO_TITLE) && !empty($VIDEO_DESC)){ ?>  <div class="info"> <div class="title_"> <?= $VIDEO_TITLE ?? "En pause" ?> </div> <div class="desc"> <?= $VIDEO_DESC ?? "" ?> </div> </div> <?php }else{ ?> <div class="loading"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/></svg> </div> <?php } ?> </div>  <!--   <div class="loading"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/></svg> </div>  -->

    <div onclick="playPause();" class="box trans" id="LOADING_BOX"> <div class="loading bounce"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wifi-2" viewBox="0 0 16 16"><path d="M13.229 8.271c.216-.216.194-.578-.063-.745A9.456 9.456 0 0 0 8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065A8.46 8.46 0 0 1 8 7a8.46 8.46 0 0 1 4.577 1.336c.205.132.48.108.652-.065zm-2.183 2.183c.226-.226.185-.605-.1-.75A6.473 6.473 0 0 0 8 9c-1.06 0-2.062.254-2.946.704-.285.145-.326.524-.1.75l.015.015c.16.16.408.19.611.09A5.478 5.478 0 0 1 8 10c.868 0 1.69.201 2.42.56.203.1.45.07.611-.091l.015-.015zM9.06 12.44c.196-.196.198-.52-.04-.66A1.99 1.99 0 0 0 8 11.5a1.99 1.99 0 0 0-1.02.28c-.238.14-.236.464-.04.66l.706.706a.5.5 0 0 0 .708 0l.707-.707z"/></svg> </div> </div>

    <div onclick="playPause();" class="box" id="IDLE_BOX">  <canvas id="canvas" width="640" height="480" class="none"></canvas> <div class="loading"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wifi-off" viewBox="0 0 16 16"><path d="M10.706 3.294A12.545 12.545 0 0 0 8 3C5.259 3 2.723 3.882.663 5.379a.485.485 0 0 0-.048.736.518.518 0 0 0 .668.05A11.448 11.448 0 0 1 8 4c.63 0 1.249.05 1.852.148l.854-.854zM8 6c-1.905 0-3.68.56-5.166 1.526a.48.48 0 0 0-.063.745.525.525 0 0 0 .652.065 8.448 8.448 0 0 1 3.51-1.27L8 6zm2.596 1.404.785-.785c.63.24 1.227.545 1.785.907a.482.482 0 0 1 .063.745.525.525 0 0 1-.652.065 8.462 8.462 0 0 0-1.98-.932zM8 10l.933-.933a6.455 6.455 0 0 1 2.013.637c.285.145.326.524.1.75l-.015.015a.532.532 0 0 1-.611.09A5.478 5.478 0 0 0 8 10zm4.905-4.905.747-.747c.59.3 1.153.645 1.685 1.03a.485.485 0 0 1 .047.737.518.518 0 0 1-.668.05 11.493 11.493 0 0 0-1.811-1.07zM9.02 11.78c.238.14.236.464.04.66l-.707.706a.5.5 0 0 1-.707 0l-.707-.707c-.195-.195-.197-.518.04-.66A1.99 1.99 0 0 1 8 11.5c.374 0 .723.102 1.021.28zm4.355-9.905a.53.53 0 0 1 .75.75l-10.75 10.75a.53.53 0 0 1-.75-.75l10.75-10.75z"/></svg> </div> </div>  <!--  <div class="title"> <?= $LANG['CONNEXT_ERROR'] ?? "Connexion interompu" ?> ! </div>    -->

    <div onclick="" class="box notrans" id="INIT_BOX"> <div class="loading bounce"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.5a.5.5 0 0 1 1 0V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.354 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V11h-1v3.293l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/></svg> </div> </div>  <!--  <div class="title"> <?= $LANG['WAITING'] ?? "Veuillez patientez" ?>... </div>  -->


    <div class="box" id="PARAMS"> 
        <div class="params"> 
        <!-- <div onclick="openSetting();" class="exit"> <?= $LANG['FERMER'] ?? "Fermer" ?> </div> -->

            <h3 onclick="openSetting();" class="title"> <?= $LANG['PARAMS'] ?? "Paramètres"; ?> </h3>

            <div class="items">

            <div class="item">
            
                <div class="title2"> <?= $LANG['SPEED'] ?? "Vitesse de lecture" ?> </div>
                <form action="" id="#SPEED_FORM">
                    <p> <input type="radio" onclick="changeRate(this);" name="SPEED" value="0.5" id="dssdwrr"> <label for="dssdwrr">x0.5</label> </p>
                    <p> <input type="radio" onclick="changeRate(this);" name="SPEED" value="0.75" id="dssdwrrrrttt"> <label for="dssdwrrrrttt">x0.75</label> </p>
                    <p> <input type="radio" onclick="changeRate(this);" name="SPEED" value="1" id="dsdsdsd" checked> <label for="dsdsdsd"> <?= $LANG['NORMAL'] ?? "Normal" ?> </label>  </p>
                    <p> <input type="radio" onclick="changeRate(this);" name="SPEED" value="1.25" id="dssdwrrrrtt12t"> <label for="dssdwrrrrtt12t">x1.25</label> </p>
                    <p> <input type="radio" onclick="changeRate(this);" name="SPEED" value="1.50" id="dssdwrrrrtt234t"> <label for="dssdwrrrrtt234t">x1.50</label> </p>
                    <p> <input type="radio" onclick="changeRate(this);" name="SPEED" value="2" id="dssdwrrrrt435tt"> <label for="dssdwrrrrt435tt">x2</label> </p>
                </form>
            </div>

            <div class="item">
                <div class="title2"> <?= $LANG['SCREEN'] ?? "Ecran" ?> </div>
                <form action="" id="#QUALITY_FORM">
                <p> <input type="radio" onclick="changeQuality(this);" name="QUALITY" value="0" id="dssdwrr45" checked> <label for="dssdwrr45">Auto</label> </p>
                <p> <input type="radio" onclick="changeQuality(this);" name="QUALITY" value="1" id="dssdwrr4" > <label for="dssdwrr4">40%</label> </p>
                <p> <input type="radio" onclick="changeQuality(this);" name="QUALITY" value="2" id="dssdwrr5"> <label for="dssdwrr5">60%</label> </p>
                <p> <input type="radio" onclick="changeQuality(this);" name="QUALITY" value="3" id="dssdwrr6"> <label for="dssdwrr6">80%</label> </p>
                <p> <input type="radio" onclick="changeQuality(this);" name="QUALITY" value="4" id="dssdwrr64"> <label for="dssdwrr64">100%</label> </p>
                </form>
            </div>

            <div class="item">
                <div class="title2"> <?= $LANG['SUBSTITLES'] ?? "Sous-titres" ?> </div>
                <form action="" >
                <p> <input type="radio" onclick="changeSubtitles(this);" name="SUBTITLES" value="0" id="dssdwrr4533" checked> <label for="dssdwrr4533">Activé</label> </p>
                <p> <input type="radio" onclick="changeSubtitles(this);" name="SUBTITLES" value="1" id="dssdwrr444" > <label for="dssdwrr444">Désactivé</label> </p>
                </form>
            </div>
            
            </div>

        </div> 
    </div>


    <div class="LOGO" id="LOGO"> <img src="<?= LFOLDER_ICON ?? "" ?>(64x64).png" alt=""> </div>

    <?php if( !empty($VIDEO_INFO['WARNING']) && $VIDEO_INFO['WARNING'] == 'true' && empty($PASSWORD_STATE) ){ ?>

    <div class="ALERT">
    
    <div class="svg"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-octagon-fill" viewBox="0 0 16 16"><path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg> </div>

    <div class="title"> <?= LANG['WARNING'] ?? "Avertissement" ?> !</div>

    <div class="desc"> <?= LANG['DISCLAMER'] ?? "Cette vidéo est fortement déconseillé aux (- 18 ans) " ?> </div>
    <br>
    <?php if(!empty($TRY)) { ?>
            <div class="bad" id="BAD"> <?= LANG['WRONG_PASS'] ?? "Mot de passe incorrect !" ?> </div><br>
        <?php } ?>
    <form action="" method="post" class="none" id="WARNING">
        <input type="password" class="<?= !empty($TRY) ? "bad" : "" ?>" name="PASSWORD" id="" onkeyup="input_text(this)" placeholder="<?= LANG['PASSWORD'] ?? "Password" ?>" >
        <button type="submit" class="button" onclick=""> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg> <span> <?= LANG['LOOK'] ?? "Regarder" ?> </span> </button>
        <!-- this.parentNode.style.display = 'none'; -->
    </form>

    <button type="submit" class="button" onclick="this.parentNode.style.display = 'none'; var item = document.querySelector('#WARNING'); item.style.display = 'block'; var bad = document.querySelector('#BAD'); bad.style.display = 'none'; "> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5z"/></svg> <span> <?= LANG['LOOK_MEME'] ?? "Regarder" ?> </span> </button>
    <br><br>

    </div>
    <?php } ?>

    <div class="ALERT none" id="NO_VIDEO">
    
    <div class="svg"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video-off-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.961 12.365a1.99 1.99 0 0 0 .522-1.103l3.11 1.382A1 1 0 0 0 16 11.731V4.269a1 1 0 0 0-1.406-.913l-3.111 1.382A2 2 0 0 0 9.5 3H4.272l6.69 9.365zm-10.114-9A2.001 2.001 0 0 0 0 5v6a2 2 0 0 0 2 2h5.728L.847 3.366zm9.746 11.925-10-14 .814-.58 10 14-.814.58z"/></svg> </div>

    <div class="title"> <?= LANG['VIDEO_NOT_FOUNDED'] ?? "Vidéo introuvale" ?> !</div>

    <div class="desc"> <?= LANG['VIDEO_NOT_FOUND_INFO'] ?? "La vidéo est soit inexistante ou été rétiré de la plateforme" ?> </div><br>

    <div class="button" onclick="retry_load();"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/><path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/></svg>  <span> <?= LANG['RETRY'] ?? "RETRY" ?> </span> </div>

    <br><br>

    </div>


    <div class="ALERT none" id="NO_ACCESS">
    
    <div class="svg"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-octagon-fill" viewBox="0 0 16 16"><path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg> </div>

    <div class="title"> <?= LANG['NO_ACCESS'] ?? "Accès interdit !" ?> </div>

    <div class="desc"> <?= LANG['NO_ACCESS_INFO'] ?? "Vous avez été bani du site car vous avez tentez une certaine action détecter par le serveur" ?> </div><br>

    <br><br>

    </div>

    <div class="flou-bottom hide-show"></div>

</div>

<!-- //////////////////////////////////////////////////////  -->


<script>



</script>



<script>


// ITEM

var logo = document.querySelector("#LOGO") ;
logo.style.display = 'none';

var content = document.querySelector("#CONTENT") ;
var empty = document.querySelector("#EMPTY") ;
empty.style.display = 'none';

var loading = document.querySelector("#LOADING_BOX") ;
loading.style.display = 'none';

var init = document.querySelector("#INIT_BOX") ;
init.style.display = 'flex';

var idle = document.querySelector("#IDLE_BOX") ;
idle.style.display = 'none';

var start = document.querySelector("#START_BOX") ;
start.style.display = 'none';

var overview = document.querySelector("#OVERVIEW") ;
overview.style.display = 'none';

var video_mask = document.querySelector("#VIDEO_MASK") ;

var no_video = document.querySelector("#NO_VIDEO") ;
no_video.style.display = 'none';

var no_access = document.querySelector("#NO_ACCESS") ;
no_access.style.display = 'none';

var overview_video = document.querySelector("#VIDEO_OVERVIEW") ;
overview_video.style.display = 'none';
var overview_video_source = document.querySelector("#OVERVIEW_VIDEO_SOURCE") ;

var mobile_width = 800;

var overview_time = document.querySelector("#OV_TIME") ;
// overview_time.style.display = 'none';

var params = document.querySelector("#PARAMS") ;
params.style.display = 'none';

var picture_button = document.querySelector("#PICTURE_IN_PICTURE_BUTTON") ;

var subtitles = document.querySelector("#SUBTITLES") ;

var subtitles_text = content.clientWidth > mobile_width ? <?= json_encode( $VIDEO_SUBTITLE ?? null ); ?> : null;

var subtitles_state = 0; // MEAN ACTIVED

var options = document.querySelector("#OPTIONS") ;


var actions = document.querySelector("#ACTIONS") ;
actions.style.opacity = 0;
var play = document.querySelector("#PLAY") ;
var pause = document.querySelector("#PAUSE") ;
var volume_button = document.querySelector("#VOLUME_BUTTON") ;
var volume_high = document.querySelector("#VOLUME_HIGH") ;
var volume_middle = document.querySelector("#VOLUME_MIDDLE") ;
var volume_mute = document.querySelector("#VOLUME_MUTE") ;
var fullscreen = document.querySelector("#FULLSCREEN") ;
var exit_fullscreen = document.querySelector("#EXIT_FULLSCREEN") ;
var back = document.querySelector("#BACK") ;

if(content.clientWidth < mobile_width){ volume_button.style.display = 'none'; back.style.display = 'none';}

var video = document.querySelector("#VIDEO") ;
var progress_current = document.querySelector("#PROGRESS_CURRENT") ;
var progress_hover = document.querySelector("#PROGRESS_HOVER") ;
var progress_bar = document.querySelector("#PROGRESS_BAR") ;
var progress_buffered = document.querySelector("#PROGRESS_BUFFERED") ;
var progress_bar_current = document.querySelector("#PROGRESS_BAR_CURRENT") ;
var volume_container = document.querySelector("#VOLUME_CONTAINER") ;
var volume_bar = document.querySelector("#VOLUME_BAR") ;
var volume_current = document.querySelector("#VOLUME_CURRENT") ;
var currentTime = document.querySelector("#TIME") ;
var duration = document.querySelector("#DURATION") ;
var setting_button = document.querySelector("#SETTING_BUTTON") ;

var onetime = 0;
var onetime_overview=0;
var fullscreen_requested = false;
var activity_autorized=true;

window.addEventListener('DOMContentLoaded',function(){

video.addEventListener('timeupdate', setMyTime);
window.addEventListener("keydown",keyPush);
// start.style.display = 'flex';
actions.style.display = 'block';
video.style.display = 'block';
video.load();
video.controls = false;
overview_video.controls = false ;
video.volume = 0;
// check_video_2();

// closeActions();
video_mask.style.cursor = 'default';
<?php if( !empty($VIDEO_INFO['WARNING']) && $VIDEO_INFO['WARNING'] == 'true' && empty($PASSWORD_STATE) ){ ?>
setTimeout(no_video_found,50000);
<?php }else{ ?>
setTimeout(no_video_found,50000);
<?php } ?>

if( document.referrer && (document.referrer).includes("<?= strtolower(SITE_NAME) ?>") == false ){ closeLector(); }
// alert(document.referrer);
// alert("<?= strtolower(SITE_NAME) ?>");
// alert((document.referrer).includes("<?= strtolower(SITE_NAME) ?>"));

});

video.addEventListener("loadstart",function(){
    video.controls = false;
    overview_video.controls = false ;
    video.removeAttribute('controls');
    overview_video.removeAttribute('controls') ;
});

video.addEventListener("durationchange",function(){
    getDuration();
});

video.addEventListener("canplay",function(){
    // alert(st);
    video.controls = false;
    overview_video.controls = false ;
    video.removeAttribute('controls');
    overview_video.removeAttribute('controls') ;
    loading.style.display = 'none';
    idle.style.display = 'none';
    init.style.display = 'none';
    if(onetime == 0){
    video.currentTime = <?= !empty($CURRENT_TIME) ? $CURRENT_TIME : 'video.duration / 3' ?> ;
    video.volume = 0;
    <?php if(!empty($CURRENT_TIME)){ ?>
        video.volume =1;
        video_play();
        video_mask.style.cursor = 'default';
        start.style.display = 'flex';
    <?php } ?>
    }
    check_video();
    if(onetime == 0)
    {

    start.style.display = 'flex';
    displayActions();
    progress_current.value = 0;
    progress_bar_current.style.width = 0 + "%"; 
    }

});

function retry_load()
{
    no_video.style.display = 'none';
    video.load();
    setTimeout(no_video_found,50000);
}

function no_video_found()
{
    if(video.networkState == 3 || video.networkState == 0 )
    no_video.style.display = 'flex';
    else
    no_video.style.display = 'none';
}

function closeLector()
{
    no_access.style.display = 'flex';
    content.style.display = 'none';
    document.body.removeChild(video);
    document.body.removeChild(overview_video);
}

//  PICTURE IN PICTURE
////////////////////////////////////////////////

// picture_button.addEventListener("click",openPictureInPicture);
var switch_picture_picture=0;
//-----------------------------------
function openPictureInPicture()
{
    // if(switch_picture_picture == 0){
    // video.requestPictureInPicture()
    // .then((pictureInPictureWindow) => {
    //   pictureInPictureWindow.addEventListener("resize", () => onPipWindowResize(), false);
    // });
    // switch_picture_picture=1;
    // }
    // else{

    //     switch_picture_picture=0;
    // }

        if (document.pictureInPictureElement) {
          document.exitPictureInPicture()
            .then(() => console.log("Document Exited from Picture-in-Picture mode"))
            .catch((err) => console.error(err))
        } else {
          video.requestPictureInPicture();
        }
      
}
//-----------------------------------


var tmp_volume,timeout,timein,nowork;

//  CHECK VIDEO STATE
////////////////////////////////////////////////

//-----------------------------------//-----------------------------------
var tmp_time = 0,paused_actionned=false,paused_actionned_0=false,paused_actionned_1=false;
var stagned=false;

//-----------------------------------
function check_video()
{
// clearTimeout(tmp_time);

var buff = video.buffered.end(0);

var slide = buff / video.duration ;
slide = slide * 100;
progress_buffered.style.width = slide+"%";

// NETWORK_NO_SOURCE
//-----------------------------------
if(video.networkState == 3)
{
    video_pause();
    empty.style.display = 'flex';
    content.style.display = 'none';
}
else
{
    empty.style.display = 'none';
    content.style.display = 'flex';
}

// NETWORK_IDLE
//-----------------------------------
// if(video.networkState == 1 && buff < video.currentTime )
// {
//     loading.style.display = 'none';
//     init.style.display = 'none';
//     idle.style.display = 'flex';
//     video_pause();
//     paused_actionned_1=true;
//     start.style.display = 'none';
// }
// else
// {
//     idle.style.display = 'none';
//     if( onetime > 0 && paused_actionned_1 == true ){ start.style.display = 'none'; }
//     paused_actionned_1=false;
// }

// NETWORK_EMPTY
//-----------------------------------
if(video.networkState == 0 && buff < video.currentTime )
{
    loading.style.display = 'none';
    idle.style.display = 'none';
    init.style.display = 'flex';
    video_pause();
    paused_actionned_0=true;
    start.style.display = 'none';
    video.controls = false;
    overview_video.controls = false ;
    video.removeAttribute('controls');
    overview_video.removeAttribute('controls') ;
}
else
{
    init.style.display = 'none';
    if( onetime > 0 && paused_actionned_0 == true ){ start.style.display = 'none'; }
    paused_actionned_0=false;
}


// NETWORK_LOADING
//-----------------------------------
if(video.networkState == 2 && buff < video.currentTime)
{
    init.style.display = 'none';
    idle.style.display = 'none';
    if(onetime > 0)
    loading.style.display = 'flex';
    // video_pause();
    // paused_actionned=true;
    start.style.display = 'none';
    stagned=true;
    video.controls = false;
    overview_video.controls = false ;
    video.removeAttribute('controls');
    overview_video.removeAttribute('controls') ;

}
else
{
    loading.style.display = 'none';
    if( onetime > 0 && paused_actionned == true ){ video_play();start.style.display = 'none';}
    paused_actionned=false;
    stagned=false;
    if( onetime > 0 && video.paused == false)
    start.style.display = 'none';
}

}

//  PARAMS
////////////////////////////////////////////////
// setting_button.addEventListener('click',openSetting);
//-----------------------------------
function openSetting()
{
    // alert(st);
    var st = params.style.display == "" ? "none" : params.style.display;
    if(st == 'none'){
    params.style.display = 'flex';
    displayActions();
    // activity_autorized=false;
    }else{
    params.style.display = 'none';
    // activity_autorized=true;
    // noactivity();
    }

}
//-----------------------------------
function changeRate(obj)
{
    video.playbackRate = (isNaN(obj.value) == false) ? obj.value : 1;
}
//-----------------------------------
function changeQuality(obj)
{
    var val = obj.value;

    switch(val)
    {
        case '0': video.style.width = 'auto' ; break;
        case '1': video.style.width = '40%' ; break;
        case '2': video.style.width = '65%' ; break;
        case '3': video.style.width = '80%' ; break;
        case '4': video.style.width = '100%' ; break;
    }
    // alert( (video.clientWidth) );
    // alert( 65 * (content.clientWidth/100) );
}
//-----------------------------------
function changeSubtitles(obj,hide=null)
{
    var val = hide != null ? hide : obj.value;

    switch(val)
    {
        case '0': subtitles_state=0 ;subtitles.style.display = 'block'; break;
        case '1': subtitles_state=1 ;subtitles.style.display = 'none'; break;
    }
}


//  ACTIONS
////////////////////////////////////////////////
function displayActions()
{
    video_mask.style.cursor = 'default';
    actions.style.opacity = 1;
    actions.style.bottom = '-5px';
    // if(isNaN (timein) == false)
    // clearTimeout(timein);
    // if(video.paused == false){
    // timein = setTimeout(function(){ actions.style.opacity = 0;actions.style.bottom = '-100px'; },3000);
    // }else{
        // clearTimeout(timein);    
    // }
}
function displayActions_2()
{
    video_mask.style.cursor = 'default';
    actions.style.opacity = 1;
    actions.style.bottom = '-' + (actions.clientHeight - 15) + 'px';

}
//-----------------------------------
function closeActions()
{
    actions.style.opacity = 1;
    actions.style.bottom = '-' + (actions.clientHeight + 6) + 'px';
    video_mask.style.cursor = 'none';

    // if(timein != null)
    // clearTimeout(timein);
    // if(video.paused == false)
    // timein = setTimeout(function(){ actions.style.opacity = 0;actions.style.bottom = '-100px'; },3000);
}

function closeActions_2()
{
    actions.style.opacity = 1;
    actions.style.bottom = '-' + (actions.clientHeight - 10) + 'px';
    video_mask.style.cursor = 'none';

    // if(timein != null)
    // clearTimeout(timein);
    // if(video.paused == false)
    // timein = setTimeout(function(){ actions.style.opacity = 0;actions.style.bottom = '-100px'; },3000);
}
//-----------------------------------

// window.addEventListener("mousemove",function(){
//     displayActions();
//     closeActions();
// });
var timeout_noactivity=0;

window.addEventListener("mouseleave",function(event){
    closeActions();
});

window.addEventListener("click",function(event){
    video.style.display = 'block';
    video.controls = false;
    overview_video.controls = false;
    video.removeAttribute("controls");
    overview_video.removeAttribute("controls");
});
window.addEventListener("mousemove",function(event){

    if(content.clientWidth > mobile_width)
    noactivity();
    video.style.display = 'block';
    video.removeAttribute("controls");
    overview_video.removeAttribute("controls");

});

video_mask.addEventListener('dblclick',function(){
    // switchFullScreen();
});

function noactivity()
{
    // if( ( content.clientHeight - event.clientY ) < (actions.clientHeight + 170))
    // displayActions();
    // else if(video.paused == false)
    // closeActions();

    if(onetime > 0 && video.paused ==  false && activity_autorized == true){
    
    displayActions();
    this.clearTimeout(timeout_noactivity);
    if(video.paused == false)
    timeout_noactivity = this.setTimeout(function(){ if(video.paused == false) closeActions(); },3000);
    }

    // actions.addEventListener("mouseover",function(){ this.clearTimeout(timeout_noactivity);displayActions(); });
}

var cpt_click=0;
video_mask.addEventListener("click",function(event){

    video.style.display = 'block';

    if(content.clientWidth > mobile_width)
    playPause();
    else if( cpt_click == 0 )
    {
        displayActions();
        cpt_click=1;
    }
    else
    {
        closeActions_2();
        cpt_click=0;
    }

    video.removeAttribute("controls");
    overview_video.removeAttribute("controls");
    video.style.display = 'block';
    
});

// actions.addEventListener("mouseleave",function(){
//     closeActions();
// });

//  PLAY / PAUSE
////////////////////////////////////////////////
function closeControls(){
if(fullscreen_requested == false) closeFullscreen();

video.controls = false;
overview_video.controls = false ;
video.removeAttribute('controls');
overview_video.removeAttribute('controls') ;
}
// play.addEventListener('click',video_play);
// pause.addEventListener('click',video_pause);
var timeout_activity_autorized=0;
//-----------------------------------
function video_play()
{
    video.controls = false;
    overview_video.controls = false ;
    video.removeAttribute('controls');
    overview_video.removeAttribute('controls') ;

    // activity_autorized=false;
    if(onetime == 0) video.currentTime = <?= !empty($CURRENT_TIME) ? $CURRENT_TIME : '0' ?>;
    play.style.display = 'none';
    pause.style.display = 'inline-block';
    pause.style.width = '25px';
    pause.style.height = '25px';
    start.style.display = 'none';
    video.onplay = closeControls();
    video.onplaying = closeControls();
    video.play();
    // if(content.clientWidth < mobile_width){ openPictureInPicture(); }
    video.onplay = closeControls();
    video.onplaying = closeControls();
    if(onetime == 0){ video.volume = 1; }
    // closeActions();
    // loading.style.display = 'none';
    // idle.style.display = 'none';
    // init.style.display = 'none';

    this.clearTimeout(timeout_activity_autorized);
    timeout_activity_autorized = setTimeout(function(){activity_autorized=true;noactivity();},500);

    // noactivity();

    if(onetime < 2){ getDuration();logo.style.display = 'block'; }
    onetime++;

    // if(content.clientWidth < mobile_width){ openPictureInPicture(); }

}
//-----------------------------------
function video_pause()
{
    video.pause();
    play.style.display = 'inline-block';
    play.style.width = '25px';
    play.style.height = '25px';
    pause.style.display = 'none';
    start.style.display = 'flex';
    if(onetime == 0 || content.clientWidth >= mobile_width)
    displayActions();
    else
    displayActions();
    // if(content.clientWidth < mobile_width){ openPictureInPicture(); }
    video.controls = false;
    overview_video.controls = false ;
    video.removeAttribute('controls');
    overview_video.removeAttribute('controls') ;

    if(stagned == true)
    {
        start.style.display = 'none';
    }

}
//-----------------------------------
function playPause()
{
    video.controls = false;
    overview_video.controls = false ;
    video.removeAttribute('controls');
    overview_video.removeAttribute('controls') ;
    video.onplay = closeControls();
    video.onplaying = closeControls();

    if(video.paused == true){ video_play(); changeSubtitles(null,0); }
    else{ video_pause(); changeSubtitles(null,1); }

    video.onplay = closeControls();
    video.onplaying = closeControls();
    video.controls = false;
    overview_video.controls = false ;
    video.removeAttribute('controls');
    overview_video.removeAttribute('controls') ;

    // if(onetime < 5) getDuration();

}
//-----------------------------------
function getSnapShots()
{

  var canvas=document.querySelector('canvas');
  var context=canvas.getContext('2d');
  var w,h,ratio;

  //add loadedmetadata which will helps to identify video attributes

  video.addEventListener('loadedmetadata', function() {
    ratio = video.videoWidth/video.videoHeight;
    w = video.videoWidth-100;
    h = parseInt(w/ratio,10);
    canvas.width = w;
    canvas.height = h;
    video.addEventListener('canplay',snap);
  },false);

  function snap() {
    context.fillRect(0,0,w,h);
    context.drawImage(video,0,0,w,h);
	var img_data = canvas.toDataURL('image/jpg');
    console.log(img_data);
  }

}

//  VOLUME
////////////////////////////////////////////////

volume_button.addEventListener('click',toggleVolume);
volume_button.addEventListener('mousemove',displayVolume);
volume_container.addEventListener('mousemove',displayVolume);
var timeout_volume;
function displayVolume()
{
    if(content.clientWidth < mobile_width)
    {
        volume_container.style.display = 'none';
        // volume_container.style.display = 'inline-block';
        // clearTimeout(timeout_volume);
        // timeout_volume = setTimeout(function(){volume_container.style.display = 'none';},4000);
    }
    else
    {
        volume_container.style.display = 'inline-block';
    }

}
//-----------------------------------
function moveVolumeRange()
{
    volume_current.value = video.volume * 100;
    volume_bar.style.width = volume_current.value + "%";
}
//-----------------------------------
function moveVolume(event)
{
    var val = volume_current.value / volume_current.max;
    video.volume = val;
    volume_bar.style.width = volume_current.value + "%";
    volumeIcon();
}

//-----------------------------------
function toggleVolume()
{
    if(video.volume != 0)
    tmp_volume = video.volume;

    if(video.volume != 0 )
    {
        video.volume = 0;
        volumeIcon();
    }
    else
    {
        video.volume = tmp_volume;

        volumeIcon();
    }
}
//-----------------------------------
function volumeUp()
{
    if(video.volume < 1) video.volume = video.volume + 0.1;
    volumeIcon();
}
//-----------------------------------
function volumeDown()
{
    if(video.volume >= 0.1) video.volume = video.volume - 0.1; 
    volumeIcon();
}
//-----------------------------------
function volumeIcon()
{
    if(video.volume > 0.7 ) 
    {
        volume_mute.style.display = 'none';
        volume_middle.style.display = 'none';
        volume_high.style.display = 'inline-block';
        volume_high.style.width = '25px';
        volume_high.style.height = '25px';
    }
    else if(video.volume > 0.1 )
    {
        volume_mute.style.display = 'none';
        volume_middle.style.display = 'inline-block';
        volume_middle.style.width = '25px';
        volume_middle.style.height = '25px';
        volume_high.style.display = 'none';
    }
    else 
    {
        volume_mute.style.display = 'inline-block';
        volume_mute.style.width = '25px';
        volume_mute.style.height = '25px';
        volume_middle.style.display = 'none';
        volume_high.style.display = 'none';
    }
    moveVolumeRange();
}

//  SET TIME
////////////////////////////////////////////////
function setMyTime()
{

if(onetime == 0){ start.style.display = 'flex';return 0;}

var hours = Math.floor(video.currentTime / 3600);
var minutes = Math.floor(video.currentTime / 60);
var seconds = Math.floor(video.currentTime);
while(minutes > 59){minutes = minutes - 60;}
while(seconds > 59){seconds = seconds - 60;}
var hourValue;
var minuteValue;
var secondValue;
hourValue = (hours < 10) ? '0' + hours : hours;
minuteValue = (minutes < 10) ? '0' + minutes : minutes;
secondValue = (seconds < 10) ? '0' + seconds : seconds;
var videoCurrentTime;
// if(hourValue == 0){videoCurrentTime = minuteValue+":"+secondValue;}
// else{videoCurrentTime = hourValue+":"+minuteValue+":"+secondValue;}
// currentTime.innerHTML = videoCurrentTime;

if(hourValue == 0){videoCurrentTime = minuteValue+":"+secondValue;}
else{videoCurrentTime = hourValue+":"+minuteValue+":"+secondValue;}
if(isNaN(secondValue) == false ){currentTime.innerHTML = videoCurrentTime;}else{currentTime.innerHTML = "00:00";}

var slide = video.currentTime /  video.duration ;
slide = slide * 100;
// progress_bar_current.style.width = slide +"%";// transition: 0.2s;
progress_current.value = slide;

var val = progress_current.value / progress_current.max;
progress_bar_current.style.width = (val * 100) + "%"; 

if( video.currentTime == video.duration || progress_current.value == 0 ){start.style.display = 'flex';}

check_video();

video.style.display = 'block';
video.controls = false;
overview_video.controls = false ;
video.removeAttribute('controls');
overview_video.removeAttribute('controls') ;

// if(onetime < 5) getDuration();

if( subtitles_text != null && subtitles_state == 0){
 
 var i=0,test=false;
 
 for( i in subtitles_text)
 {
     if( Math.floor(video.currentTime) >= subtitles_text[i]['time'] && Math.floor(video.currentTime) <= parseInt(subtitles_text[i]['time']) + parseInt(subtitles_text[i]['duration'])  ) // && subtitles_text[i]['time'] >= Math.floor(video.currentTime) - 5 
     {
         subtitles.style.display = 'inline-block';
         var info = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>';
         if(subtitles_text[i]['status'] == 'info')
         subtitles.innerHTML = info + " <span> " + subtitles_text[i]['text'] + " </span> ";
         else
         subtitles.innerHTML = subtitles_text[i]['text'];
         test=true;
         break;
     }
 }
 
 if(test == false)
 {
     subtitles.innerHTML = "";
     subtitles.style.display = 'none';
 }
 
 }

}
//-----------------------------------
function getDuration()
{
    var hours = Math.floor(video.duration / 3600);
    var minutes = Math.floor(video.duration / 60);
    var seconds = Math.floor(video.duration);
    while(minutes > 59){minutes = minutes - 60;}
    while(seconds > 59){seconds = seconds - 60;}
    var hourValue;
    var minuteValue;
    var secondValue;
    if (hours < 10) {hourValue = '0' + hours;}else{hourValue = hours;}
    if (minutes < 10) {minuteValue = '0' + minutes;}else{minuteValue = minutes;}
    if (seconds < 10) {secondValue = '0' + seconds;}else{secondValue = seconds;}
    var videoDuration;
    if(hourValue == 0){videoDuration = minuteValue+":"+secondValue;}
    else{videoDuration = hourValue+":"+minuteValue+":"+secondValue;}
    if(isNaN(secondValue) == false ){duration.innerHTML = videoDuration;}else{duration.innerHTML = "00:00";}
    return videoDuration;
}

//  PROGRESS BAR
////////////////////////////////////////////////

// progress_bar.addEventListener("click",changeState);

// function changeState(event)
// {
//     var at = (event.clientX)/progress_bar.clientWidth;
//     video.currentTime = (at * video.duration);
// }
//-----------------------------------
function moveProgress(event)
{
    // video_pause();
    var val = progress_current.value / progress_current.max;
    video.currentTime = val * video.duration;
    progress_bar_current.style.width = (val * 100) + "%"; 
    if(video.paused == false) start.style.display = 'none';

    var buff = video.buffered.end(0);

    if(video.networkState == 2 && buff < video.currentTime)
    {
        start.style.display = 'none';
    }

}

//  VIDEO OVERVIEW
////////////////////////////////////////////////

progress_bar.addEventListener("mousemove",getOverview);
// overview.addEventListener('mousemove',getOverview);

progress_bar.addEventListener("mouseleave",closeOverview);
overview.addEventListener("mousemove",closeOverview);
// options.addEventListener("mouseover",closeOverview);
//-----------------------------------
function getOverview(event)
{

var marge = Math.abs(content.clientWidth - progress_bar.clientWidth)/2;
var at = Math.abs(event.clientX - marge)/ (progress_bar.clientWidth );
var timee = (at * video.duration);
progress_hover.style.width = (at * 100) + "%"; 
// timee = timee.toFixed(3);
overview_video.volume=0;
overview_video.currentTime = timee;
overview_video.play();
overview_video.pause();
if(overview_video.networkState != 3 && content.clientWidth >= mobile_width  )
{
overview_video.style.display = 'block';
}
else
{
    overview_video.style.display = 'none';    
}

if(event.clientX - (overview.clientWidth/2) < 0){ overview.style.left = 0; } else if(event.clientX + (overview.clientWidth/2) > progress_bar.clientWidth){ overview.style.left = (progress_bar.clientWidth - (overview.clientWidth) ) + 'px'; }else{ overview.style.left = ( event.clientX - (overview.clientWidth/2) ) + 'px'; }

var hours = Math.floor(timee / 3600);
var minutes = Math.floor(timee / 60);
var seconds = Math.floor(timee);

while(minutes > 59){minutes = minutes - 60;}
while(seconds > 59){seconds = seconds - 60;}

var hourValue;
var minuteValue;
var secondValue;

hourValue = (hours < 10) ? '0' + hours : hours;
minuteValue = (minutes < 10) ? '0' + minutes : minutes;
secondValue = (seconds < 10) ? '0' + seconds : seconds;

var videoCurrentTime;
// if(hourValue == 0){videoCurrentTime = minuteValue+":"+secondValue;}
// else{videoCurrentTime = hourValue+":"+minuteValue+":"+secondValue;}

if(hourValue == 0){videoCurrentTime = minuteValue+":"+secondValue;}
else{videoCurrentTime = hourValue+":"+minuteValue+":"+secondValue;}
if(isNaN(secondValue) == false ){overview_time.innerHTML = videoCurrentTime;}else{overview_time.innerHTML = "00:00";}

overview.style.display = 'block';
overview.style.opacity = 1;



// overview_video.src = video.currentSrc;
// overview_video.src = video.currentSrc;

}
//-----------------------------------
function closeOverview()
{
    overview.style.display = 'none';
    overview.style.opacity = 0;
    progress_hover.style.width =0;
}

//  FULLSCREEN / EXIT FULLSCREEN
////////////////////////////////////////////////

// fullscreen.addEventListener("click",openFullscreen);
// exit_fullscreen.addEventListener("click",closeFullscreen);

var tmp_screen=0;

function openFullscreen() 
{
  if (document.documentElement.requestFullscreen) {
    document.documentElement.requestFullscreen();fullscreen.style.display='none';exit_fullscreen.style.display='inline';
  } else if (document.documentElement.webkitRequestFullscreen ) { /* Safari */
    document.documentElement.webkitRequestFullscreen();fullscreen.style.display='none';exit_fullscreen.style.display='inline';
  } else if (document.documentElement.msRequestFullscreen) { /* IE11 */
    document.documentElement.msRequestFullscreen();fullscreen.style.display='none';exit_fullscreen.style.display='inline';
  } else if( document.documentElement.webkitEnterFullscreen ){
    document.documentElement.webkitEnterFullscreen();fullscreen.style.display='none';exit_fullscreen.style.display='inline';
  }

  fullscreen_requested = true;
  tmp_screen=1;
}
//-----------------------------------
function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();fullscreen.style.display='inline';exit_fullscreen.style.display='none';
  } else if (document.webkitExitFullscreen) { /* Safari */
    document.webkitExitFullscreen();fullscreen.style.display='inline';exit_fullscreen.style.display='none';
  } else if (document.msExitFullscreen) { /* IE11 */
    document.msExitFullscreen();fullscreen.style.display='inline';exit_fullscreen.style.display='none';
  }

  fullscreen_requested = false;
  tmp_screen=0;
}

function switchFullScreen()
{
    if(tmp_screen == 0)
    {
        openFullscreen();
        tmp_screen=1;
    }
    else
    {
        closeFullscreen();
        tmp_screen=0;
    }
}

//  BACK NEXT / NEXT
////////////////////////////////////////////////

back.addEventListener('click',undoBwd);

function undoBwd()
{
    if(video.currentTime > 5){video.currentTime = video.currentTime - 5 ;}
}
//-----------------------------------
function redoFwd()
{
    if(video.currentTime < (video.duration - 5)){video.currentTime = video.currentTime + 5 ;}
}

//  KEYBOARD EVENT LISTENNER
////////////////////////////////////////////////

function keyPush(evt)
{

  switch(evt.keyCode) {
    case 32:
        playPause();
        break;
    case 37:
        undoBwd();;noactivity();
        break;
        case 38:
          volumeUp();noactivity();
          break;
    case 39:
        redoFwd();;noactivity();
        break;
    case 40:
          volumeDown();noactivity(); // bas 
          break;
    case 27:
        closeFullscreen(); 
          break;
}

switch(evt.key)
{
    case 'm' :toggleVolume();;noactivity();break;
    case 'p' : openPictureInPicture();break;
    case 's' : openSetting();break;
    case 'f' : switchFullScreen();break;
    case 'Escape' : closeFullscreen();break;
}

}


</script>