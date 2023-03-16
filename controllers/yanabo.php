<?php

//******************************************
//  MAIN       
//******************************************

$ROOT = new Controller;
$ROOT->load_model('main');

class Yanabo extends Controller
{

    function test($params=null)
    {
        // echo $_SERVER['SCRIPT_FILENAME']."<br>".$_SERVER['DOCUMENT_ROOT']."<br>ROOT: ".ROOT."<br>LROOT: ".LROOT."<br>SERVER_NAME: ".$_SERVER['SERVER_NAME'];exit();
    // preg_match_all('/src=".*"/', file_get_contents('https://streamtape.com/e/Je0O1QXx8MCjXOm'), $results);

// print_r($results);

$content = file_get_contents('https://www.youtube.com/watch?v=Go1v3va_8KE');
$start = strpos($content,'<video');
$end = strpos($content,"</video>");

$content = substr($content,$start,abs($end- $start));
echo $content;

$start = strpos($content,'src="');
$content_new = substr( $content,abs($start + 5));
$end = strpos( $content_new,'"');

echo substr($content_new,0,abs($end ));



    }

    // LOGIN
    //------------------------------------------
    function login()
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/login';
        $var = array();

        // echo $_SERVER['HTTP_REFERER'] ?? $this->link("MAIN");

        $_COOKIE[SESSION]['request_login'] = ($_COOKIE[SESSION]['request_login'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_login'] ?? 1 ;
        $var['css_folder'] = 'admin/login';

        $admin = 'aChamp23ZidW';
        $pass = 'prSe76oanime';

        // if($var['request_time'] > 200){ $_COOKIE[SESSION]['request_login']=0;  $_COOKIE[SESSION]['ADMIN'] = null;$this->save();}

        if(!empty($_COOKIE[SESSION]['ADMIN']) && $_COOKIE[SESSION]['ADMIN'] == $admin ) //&& $_COOKIE[SESSION]['ADMIN'] == $admin
        {
            return true;
        }

        if( !empty($_POST['USER']) && !empty( $_POST['PASSWORD'] ) )
        {
            $user = htmlspecialchars( strip_tags( $_POST['USER'] ) );
            $password = htmlspecialchars( strip_tags( $_POST['PASSWORD'] ) );

            if($user == $admin && $password == $pass )
            {
                $_COOKIE[SESSION]['ADMIN'] = $admin;
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Connexion avec succès" ).' !' ];$this->save();
                return true;
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG[''] ?? "Erreur de connexion").' !' ];$this->save();
            }
        }

        $this->render($view,$var);die();
    }

    // MAIN
    //------------------------------------------
    function contact($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/contact';
        $var = array();

        $this->login();

        $_COOKIE[SESSION]['request_contact'] = ($_COOKIE[SESSION]['request_contact'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_contact'] ?? 1 ;
        $var['css_folder'] = 'admin/contact';

        $time = $MODEL->get_contact();

        $WAY = htmlspecialchars( !empty($params[1]) ? $params[1] : "" );
        $id = htmlspecialchars( !empty($params[2]) ? $params[2] : "0" );

        if($WAY == "delete")
        {
            if($MODEL->delete_contact($id))
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Contact supprimer avec succès" ).' !' ];$this->save();
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
            }

            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));die();
        }

        foreach($time as $t)
        {
            $tt[] = $t['SEC_TIME'];
        }

        $t = time() - 86400 * 7;
        if( !empty($tt) && min($tt) < $t )
        $MODEL->execute("DELETE FROM CONTACT WHERE SEC_TIME < '$t' ");

        $var['CONTACT'] = $MODEL->get_contact();
        $var['title'] = "( ".( !empty($var['CONTACT']) ? count($var['CONTACT']) : '0')." ) Messages";


        $this->render($view,$var);die();

    }
    // VISITOR
    //------------------------------------------
    function visitor($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/visitor';
        $var = array();

        $this->login();

        $_COOKIE[SESSION]['request_visitor'] = ($_COOKIE[SESSION]['request_visitor'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_visitor'] ?? 1 ;
        $var['css_folder'] = 'admin/visitor';

        $WAY = htmlspecialchars( !empty($params[1]) ? $params[1] : "" );
        $id = htmlspecialchars( !empty($params[2]) ? $params[2] : "0" );

        if($WAY == "delete")
        {
            if($MODEL->delete_request(" WHERE IP = '$id' "))
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Contact supprimer avec succès" ).' !' ];$this->save();
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
            }

            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));die();
        }
        else if($WAY == "block")
        {
            if($MODEL->block_request($id))
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Appliquer avec succès" ).' !' ];$this->save();
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
            }

            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));die();
        }

        $time = $MODEL->get_request(" ORDER BY SEC_TIME DESC");

        foreach($time as $t)
        {
            $tt[] = $t['SEC_TIME'];
        }

        $t = time() - 86400 * 1;
        if( !empty($tt) && min($tt) < $t )
        $MODEL->delete_request(" WHERE SEC_TIME < '$t' ");

        $var['USERS'] = $MODEL->get_request(" ORDER BY SEC_TIME DESC");
        $var['title'] = "( ".( !empty($var['USERS']) ? count($var['USERS']) : '0')." ) Visiteurs";
        // $var['USERS'][] = ['OS'=>"Iphone","DATES"=>"12/11/2022","DATETIMES"=>$ROOT->actual_datetime(),"IP"=>"123.23.43.55","PAGE"=>"","URLS"=>"https://malinime.com","LANG"=>"fr-fr","GEO"=>"Morocco , Fes","DEVISE"=>"DH", "PHONE" => "212"];


        $this->render($view,$var);die();

    }

    // MAIN
    //------------------------------------------
    function main($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/index';
        $var = array();
        $var['title'] = "Ajouter un anime";

        $this->login();

        $_COOKIE[SESSION]['request_admin'] = ($_COOKIE[SESSION]['request_admin'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_admin'] ?? 1 ;
        $var['css_folder'] = 'admin/index';
        $var['ANIMES'] = $MODEL->get_anime("");
        $var['VIDEOS'] = $MODEL->get_video("");

        // $test['fr'] = utf8_encode( "C'est bei ! créer" );
        // $test['en'] = utf8_encode("C'est bei ! créer à");
        // $test['ko'] = "C'est bei ! créer";
        
        // $tesAR = json_encode($test);
        // print_r(json_decode($tesAR,true));


        if(!empty($_POST))
        {
            foreach(LANG_LIST as $l){
                $t['SYNOPSIS_'.$l['LANG']] = str_replace("'","<ap>", strip_tags( $_POST['SYNOPSIS_'.$l['LANG']] ?? "" ,"<br><b>" ) );
            }

            $t['FULL_NAME'] = htmlspecialchars( strip_tags( $_POST['FULL_NAME'] ?? "" ) );
            $t['ORIGINAL_NAME'] = htmlspecialchars( strip_tags( $_POST['ORIGINAL_NAME'] ?? "" ) );
            $t['ROMANJI'] = htmlspecialchars( strip_tags( $_POST['ROMANJI'] ?? "" ) );
            $t['SYNOPSIS'] = json_encode($lang ?? "");
            $t['STUDIO'] = htmlspecialchars( strip_tags( $_POST['STUDIO'] ?? "" ) );
            $t['TRAILER'] = htmlspecialchars( strip_tags( $_POST['TRAILER'] ?? "" ) );
            $t['OUT_DATE'] = htmlspecialchars( strip_tags( $_POST['OUT_DATE'] ?? "" ) );
            $t['GENRE'] = htmlspecialchars( strip_tags( $_POST['GENRE'] ?? "" ) );
            $t['STATUS'] = htmlspecialchars( strip_tags( $_POST['STATUS'] ?? "0" ) );
            $t['VERSION'] = htmlspecialchars( strip_tags( $_POST['VERSION'] ?? "" ) );

            if($MODEL->add_anime($t))
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Anime ajouter avec succès" ).' !' ];$this->save();
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
            }

            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();

        }


        $this->render($view,$var);

    }

    // UPDATE ANIME
    //------------------------------------------
    function update_anime($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/update_anime';
        $var = array();

        $this->login();

        $_COOKIE[SESSION]['request_update_anime'] = ($_COOKIE[SESSION]['request_update_anime'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_update_anime'] ?? 1 ;
        $var['css_folder'] = 'admin/update_anime';

        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        // echo $id;die();


        if( !empty($id) && $MODEL->check_anime($id))
        {

            // echo "CHECKED";
            $var['ANIME'] = $MODEL->get_anime(" WHERE ID = '$id' OR LINK = '$id' ",true) ;
            $var['title'] = $var['ANIME']['FULL_NAME'];

            if(!empty($_POST))
            {
                foreach(LANG_LIST as $l){
                    $t['SYNOPSIS_'.$l['LANG']] = str_replace("'","<ap>", strip_tags( $_POST['SYNOPSIS_'.$l['LANG']] ?? "" ,"<br><b>" ) );
                }

                // echo $lang[LANG_SYSTEM]."<br>";

                $t['ID'] = $id;
                $t['FULL_NAME'] = htmlspecialchars( strip_tags( $_POST['FULL_NAME'] ?? "" ) );
                $t['ORIGINAL_NAME'] = htmlspecialchars( strip_tags( $_POST['ORIGINAL_NAME'] ?? "" ) );
                $t['ROMANJI'] = htmlspecialchars( strip_tags( $_POST['ROMANJI'] ?? "" ) );

                $t['STUDIO'] = htmlspecialchars( strip_tags( $_POST['STUDIO'] ?? "" ) );
                $t['TRAILER'] = htmlspecialchars( strip_tags( $_POST['TRAILER'] ?? "" ) );
                $t['OUT_DATE'] = htmlspecialchars( strip_tags( $_POST['OUT_DATE'] ?? "" ) );
                $t['GENRE'] = htmlspecialchars( strip_tags( $_POST['GENRE'] ?? "" ) );
                $t['STATUS'] = htmlspecialchars( strip_tags( $_POST['STATUS'] ?? "0" ) );
                $t['VERSION'] = htmlspecialchars( strip_tags( $_POST['VERSION'] ?? "" ) );

           

                if($MODEL->update_anime($t))
                {
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Anime mise à jour avec succès" ).' !' ];$this->save();
                }
                else
                {
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
                }

                header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();

            }

        }
        else
        {
            $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG[''] ?? "Erreur d'envoie").' !' ];$this->save();
            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
        }

        $this->render($view,$var);

    }

    // VIDEOS
    //------------------------------------------
    function video($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/video';
        $var = array();

        $this->login();

        $_COOKIE[SESSION]['request_video'] = ($_COOKIE[SESSION]['request_video'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_video'] ?? 1 ;
        $var['css_folder'] = 'admin/video';

        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        if(!empty($id))
        {
            if($MODEL->check_anime($id))
            {
                $anime = $MODEL->get_anime(" WHERE ID = '$id' OR LINK = '$id' ",true);
                $var['title'] = $anime['FULL_NAME'];
                $id = $anime['ID'];
                $var['ALL_VIDEO'] = $MODEL->get_video(" WHERE ANIME_ID = '$id' ORDER BY EPISODE ");

                if(!empty($_REQUEST['EPISODE']))
                {
                    foreach(LANG_LIST as $l){
                        $t['DESCRIP_'.$l['LANG']] = str_replace("'","<ap>", strip_tags( $_POST['DESCRIP_'.$l['LANG']] ?? "" ,"<br><b>" ) );
                    }
                    $t['EPISODE'] = htmlspecialchars( strip_tags( $_REQUEST['EPISODE'] ?? "" ) );
                    $t['ANIME_NAME'] = $anime['FULL_NAME'];
                    $t['ANIME_ID'] = $id;
                    // $t['DESCRIP'] = strip_tags( $_REQUEST['DESCRIP'] ?? "" ,"<br><b>") ;
                    $t['ANIME_VERSION'] = $anime['VERSIONS'];
                    $t['SOURCE_LINK'] = htmlspecialchars( strip_tags( $_REQUEST['SOURCE_LINK'] ?? "" ) );
                    $t['IFRAME_LINK'] = htmlspecialchars( strip_tags( $_REQUEST['IFRAME_LINK'] ?? "" ) );
                    $t['WARNING'] = htmlspecialchars( strip_tags( $_REQUEST['WARNING'] ?? "false" ) );
 
                    if($MODEL->add_video($t))
                    {
                        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Video ajouter avec succès" ).' !' ];$this->save();
                    }
                    else
                    {
                        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
                    }

                    header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
                }
            }
            else
            {
                header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
            }
        }
        else
        {
            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
        }

        $this->render($view,$var);
    }

    // UPDATE VIDEOS
    //------------------------------------------
    function update_video($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/update_video';
        $var = array();

        $this->login();

        $_COOKIE[SESSION]['request_update_video'] = ($_COOKIE[SESSION]['request_update_video'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_update_video'] ?? 1 ;
        $var['css_folder'] = 'admin/update_video';

        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        if(!empty($id))
        {
            if($MODEL->check_video($id))
            {

                $var['VIDEO'] = $MODEL->get_video(" WHERE ID = '$id' OR LINK = '$id' ",true);
                $aid = $var['VIDEO']['ANIME_ID'];
                $anime = $MODEL->get_anime( " WHERE ID = '$aid' " ,true);
                $var['VIDEO']['ANIME_NAME'] = $anime['FULL_NAME'];
                $var['title'] = ($var['VIDEO']['ANIME_NAME'] ?? "").' - '.($var['VIDEO']['EPISODE'] < 10 ? '0'.$var['VIDEO']['EPISODE'] : $var['VIDEO']['EPISODE']).' - '.($var['VIDEO']['ANIME_VERSION']);

                // print_r($var['VIDEO']);
            //    echo ($var['VIDEO']['DESCRIP_'.LANG_SYSTEM] ?? $var['VIDEO']['DESCRIP_'.DEFAULT_LANG]);

                if(!empty($_REQUEST['DESCRIP_'.DEFAULT_LANG]) || !empty($_REQUEST['SOURCE_LINK']) )
                {
                    $t['ID'] = $id;
                    foreach(LANG_LIST as $l){
                        $t['DESCRIP_'.$l['LANG']] = str_replace("'","<ap>", strip_tags( $_POST['DESCRIP_'.$l['LANG']] ?? "" ,"<br><b>" ) );
                    }
                    // $t['DESCRIP'] = strip_tags( $_REQUEST['DESCRIP'] ?? "" ,"<br><b>") ;
                    $t['SOURCE_LINK'] = htmlspecialchars( strip_tags( $_REQUEST['SOURCE_LINK'] ?? "" ) );
                    $t['IFRAME_LINK'] = htmlspecialchars( strip_tags( $_REQUEST['IFRAME_LINK'] ?? "" ) );
                    $t['WARNING'] = htmlspecialchars( strip_tags( $_REQUEST['WARNING'] ?? "false" ) );

                    if($MODEL->update_video($t))
                    {
                        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Video modifié avec succès" ).' !' ];$this->save();
                    }
                    else
                    {
                        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
                    }

                    header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
                }
            }
            else
            {
                header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
            }
        }
        else
        {
            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
        }

        $this->render($view,$var);
    }

    // DELETE ANIME
    //------------------------------------------
    function delete_anime($params=null)
    {
        $this->login();

        $MODEL = new _Main;
        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        if(!empty($id))
        {
            if($MODEL->check_anime($id))
            {
                if($MODEL->delete_anime($id))
                {
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Anime supprimer avec succès" ).' !' ];$this->save();
                }
                else
                {
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur de suppression").' !' ];$this->save();
                }
            }
        }
        header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
    }

    // DELETE VIDEOS
    //------------------------------------------
    function delete_video($params=null)
    {
        $this->login();
        
        $MODEL = new _Main;
        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        if(!empty($id))
        {
            if($MODEL->delete_video($id))
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Video supprimer avec succès" ).' !' ];$this->save();
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur de suppression").' !' ];$this->save();
            }
        }
        header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
    }

    // ADD CHARACTERS
    //------------------------------------------
    function characters($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/characters';
        $var = array();

        $this->login();

        $var['css_folder'] = 'admin/characters';

        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        if(!empty($id))
        {
            if($MODEL->check_anime($id))
            {
                $anime = $MODEL->get_anime(" WHERE ID = '$id' OR LINK = '$id' ",true);
                $id = $anime['ID'];
                $var['PERSO'] = $MODEL->get_characters(" WHERE ANIME_ID = '$id' ");

                if(!empty($_POST))
                {
                    foreach(LANG_LIST as $l){
                        $t['DESCRIP_'.$l['LANG']] = str_replace("'","<ap>", strip_tags( $_POST['DESCRIP_'.$l['LANG']] ?? "" ,"<br><b>" ) );
                    }
                    $t['NAMES'] = htmlspecialchars( strip_tags( $_REQUEST['NAMES'] ?? "" ) );
                    $t['SPECIAL'] = htmlspecialchars( strip_tags( $_REQUEST['SPECIAL'] ?? "false" ) );
                    $t['ANIME_ID'] = $id;
 
                    if($MODEL->add_characters($t))
                    {
                        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Characters ajouter avec succès" ).' !' ];$this->save();
                    }
                    else
                    {
                        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
                    }

                    header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();

                }

            }
            else
            {
                header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
            }

        }
        else
        {
            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
        }


        $this->render($view,$var);
    }

    // ADD CHARACTERS
    //------------------------------------------
    function update_characters($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/update_characters';
        $var = array();

        $this->login();

        $var['css_folder'] = 'admin/update_characters';

        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        if(!empty($id))
        {
            if($MODEL->check_characters($id))
            {
                $var['PERSO'] = $MODEL->get_characters(" WHERE ID = '$id' ",true);

                if(!empty($_POST))
                {
                    foreach(LANG_LIST as $l){
                        $t['DESCRIP_'.$l['LANG']] = str_replace("'","<ap>", strip_tags( $_POST['DESCRIP_'.$l['LANG']] ?? "" ,"<br><b>" ) );
                    }
                    $t['NAMES'] = htmlspecialchars( strip_tags( $_REQUEST['NAMES'] ?? "" ) );
                    $t['SPECIAL'] = htmlspecialchars( strip_tags( $_REQUEST['SPECIAL'] ?? "false" ) );
                    $t['ID'] = $id;
 
                    if($MODEL->update_characters($t))
                    {
                        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Characters mise à jour avec succès" ).' !' ];$this->save();
                    }
                    else
                    {
                        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
                    }

                    header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();

                }

            }
            else
            {
                header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
            }

        }
        else
        {
            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
        }


        $this->render($view,$var);
    }

    // ADD CHARACTERS
    //------------------------------------------
    function delete_characters($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        if(!empty($id))
        {
            if($MODEL->check_characters($id))
            {
                if($MODEL->delete_characters($id))
                {
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Characters supprimer avec succès" ).' !' ];$this->save();
                }
                else
                {
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
                }

                header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
            }
            else
            {
                header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
            }

        }
        else
        {
            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();
        }
    }

    // ADD CHARACTERS
    //------------------------------------------
    function comments($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'admin/comments';
        $var = array();

        $this->login();

        $var['css_folder'] = 'admin/comments';

        $var['COMMENTS'] = $MODEL->get_comment("");

        $this->render($view,$var);

    }

    // ADD CHARACTERS
    //------------------------------------------
    function delete_comment($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        if(!empty($id))
        {
            if($MODEL->delete_comment(" WHERE ID = '$id' OR ANIME_ID = '$id' OR VIDEO_ID = '$id' ") )
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Commentaire(s) supprimer avec succès" ).' !' ];$this->save();
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
            }

            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();

        }
    }

    // ADD CHARACTERS
    //------------------------------------------
    function update_comment($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $id = htmlspecialchars( strip_tags( $params[1] ?? 0 ) );

        if(!empty($id))
        {
            if($MODEL->update_comment($id) )
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG[''] ?? "Commentaire(s) mise à avec succès" ).' !' ];$this->save();
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
            }

            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link("MAIN"));exit();

        }
    }

    
}