<link rel="canonical" href="<?= HT_ACCESS == false ? "?page=" : ""  ?><?= empty(PAGE) ? '/' : PAGE ?>">
<!-- [ ICON ]============================================================== -->
<link rel="shortcut icon" type="image/png" href="<?= LFOLDER_ICON; ?>icon_.png"/>
<link rel="apple-touch-icon" type="image/png" sizes="57x57" href="<?= LFOLDER_ICON; ?>apple-touch-icon-57x57_.png">
<link rel="apple-touch-icon" type="image/png" sizes="60x60" href="<?= LFOLDER_ICON; ?>apple-touch-icon-60x60_.png">
<link rel="apple-touch-icon" type="image/png" sizes="76x76" href="<?= LFOLDER_ICON; ?>apple-touch-icon-76x76_.png">
<link rel="apple-touch-icon" type="image/png" sizes="72x72" href="<?= LFOLDER_ICON; ?>apple-touch-icon-72x72_.png">
<link rel="apple-touch-icon" type="image/png" sizes="114x114" href="<?= LFOLDER_ICON; ?>apple-touch-icon-114x114_.png">
<link rel="apple-touch-icon" type="image/png" sizes="120x120" href="<?= LFOLDER_ICON; ?>apple-touch-icon-120x120_.png">
<link rel="apple-touch-icon" type="image/png" sizes="144x144" href="<?= LFOLDER_ICON; ?>apple-touch-icon-144x144_.png">
<link rel="apple-touch-icon" type="image/png" sizes="152x152" href="<?= LFOLDER_ICON; ?>apple-touch-icon-152x152_.png">
<link rel="apple-touch-icon" type="image/png" sizes="180x180" href="<?= LFOLDER_ICON; ?>apple-touch-icon-180x180_.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= LFOLDER_ICON; ?>(16x16)_.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= LFOLDER_ICON; ?>(32x32)_.png">
<link rel="icon" type="image/png" sizes="64x64" href="<?= LFOLDER_ICON; ?>(64x64)_.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?= LFOLDER_ICON; ?>(96x96)_.png">
<link rel="icon" type="image/png" sizes="160x160" href="<?= LFOLDER_ICON; ?>(160x160)_.png">
<link rel="icon" type="image/png" sizes="196x196" href="<?= LFOLDER_ICON; ?>(196x196)_.png">
<!-- [ STYLESHEET ]============================================================== -->
<?php
$properties = scandir(FOLDER_BASICS);
foreach($properties as $p) { if(str_split($p)[0] != '.'){ ?> <link rel="stylesheet" <?php if(str_split($p)[0] == 'm' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RSM ?? '700px';?>)" <?php }else if(str_split($p)[0] == 't' && str_split($p)[1] == '_'){ ?> media="screen and (max-width:<?= RST ?? '1000px';?>)" <?php } ?> href="<?= LFOLDER_BASICS.$p ?? ""; ?>"> <?php }}
?>
<!-- [ MANIFEST ]============================================================== -->
<link rel="manifest" href="<?= LROOT ?>manifest.json" >
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
<link href='https://fonts.googleapis.com/css?family=Aldrich' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Archivo Narrow' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Armata' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Black Ops One' rel='stylesheet'>