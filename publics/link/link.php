<?php 

$page = HT_ACCESS == false ? "?page=" : ""; if(HT_ACCESS == true) $page = $page.LROOT; else $page = LROOT.$page;
$links =  
[
    "MAIN" => LROOT,

    //  FOOTER
    //--------------------------------------

    "REPORT" => $page."report",
    "SERVICE_CLIENT" => $page."assistance",
    "FAQ" => $page."faq",
    "HOW_IT_WORK" => $page."explain",
    "NEWSLETTER" => $page."newsletter",

    "WHO_ARE_WE" => $page."who",
    "OUR_PARTNERS" => $page."our_partners",
    "TERMS" => $page."terms",
    "PRIVACY" => $page."privacy",
    "CONTACT_US" => $page."contact",

    "ADMIN/CONTACT" => $page."admin/contact",
    "ADMIN/VISITOR" => $page."admin/visitor",

    "DARK_MODE" => $page."mode", 
    "PUB_SPACE" => $page."pubs",
    "GAME" => $page."game",
    "GAME_SNAKE" => $page."game/snake",

    //  OTHER
    //--------------------------------------

    "SUGGESTIONS" => $page."suggestion",
    "CATEGORIE" => $page."search",
    "WATCH" => $page."watch",
    "EMBED" => $page."embed",
    "ANIME" => $page."anime",
    "ADD_VIDEO" => $page."manager/video",
    "DELETE_ANIME" => $page."manager/delete_anime",
    "DELETE_VIDEO" => $page."manager/delete_video",
    "UPDATE_ANIME" => $page."manager/update_anime",
    "UPDATE_VIDEO" => $page."manager/update_video",
    "CHARACTERS" => $page."manager/characters",
    "UPDATE_CHARACTERS" => $page."manager/update_characters",
    "DELETE_CHARACTERS" => $page."manager/delete_characters",
    "DELETE_COMMENTS" => $page."manager/delete_comment",
    "UPDATE_COMMENTS" => $page."manager/update_comment",

    "CHANGE_LANG" => $page."ch_lang",
    "SEARCH" => $page."search",

    //  CUSTOMER
    //--------------------------------------
    "CUSTOMER_ACCOUNT" => $page."account",
    "CREATE_ACCOUNT" => $page."account/register",
    "CUSTOMER_CONNEXION" => $page."account/login",
    "CUSTOMER_DECONNEXION" => $page."account/logout",

];

?>