<?php

//******************************************
//  MAIN       
//******************************************

$ROOT = new Controller;
$ROOT->load_model('main');

class Game extends Controller
{
    // MAIN
    //------------------------------------------
    function main($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'game/index';
        $var = array();
        $var['css_folder'] = 'game/index';

        $_COOKIE[SESSION]['request_main_game'] = ($_COOKIE[SESSION]['request_main_game'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_main_game'] ?? 1 ;

        $var['title'] = LANG['GAME_SPACE'] ?? "Espace de jeux";




        $this->render($view,$var);
    }

    // SNAKE
    //------------------------------------------
    function snake($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'game/snake';
        $var = array();
        $var['css_folder'] = 'game/snake';

        $_COOKIE[SESSION]['request_main_game_snake'] = ($_COOKIE[SESSION]['request_main_game_snake'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_main_game_snake'] ?? 1 ;

        $var['title'] = LANG['SNAKE_GAME'] ?? "Jeux de serpent";
        $var['page'] = 'EMBED';




        $this->render($view,$var);
    }

}