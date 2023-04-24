<?php

//******************************************
//  MAIN       
//******************************************

class _Main extends Model
{

    // PUBS
    ////////////////////////////////
    function pubs($t){

        $root = new Controller;
        $date = $root->actual_date();
        $time = $root->actual_datetime();

        try{

            $id = $this->new_id("PUBS","ID",'hjh');

            $brand_name = $t['BRAND_NAME'];
            $brand_slogan = $t['BRAND_SLOGAN'];
            $brand_pub_time = $t['BRAND_PUB_TIME'];
            $brand_site = $t['BRAND_SITE'];
            $brand_contact = $t['BRAND_CONTACT'];

            $brand_icon = $this->upload_single_file('BRAND_ICON',10000000,'jpg,jpeg,png',FOLDER_ANIME_BRAND,$id);
            $brand_icon_name = $test['FILENAME'];

            $pub_icon = $this->upload_single_file('BRAND_ICON',10000000,'jpg,jpeg,png',FOLDER_ANIME_PUBS,$id);
            $pub_icon_name = $test['FILENAME'];

            if( $brand_icon['STATE'] && $pub_icon['STATE'])
            {
                this->execute("INSERT INTO PUBS (ID,DATES,DATETIMES,BRAND_NAME,BRAND_SLOGAN,BRAND_PUB_TIME,BRAND_ICON,BRAND_PUB_ICON,BRAND_SITE,BRAND_CONTACT,BRAND_VISIBLE) VALUES('$id','$date','$time','$brand_name','$brand_slogan','$brand_pub_time','$brand_icon_name','$pub_icon_name','$brand_site','$brand_contact','false'); ");
                return true;
            }
            else{
                if(!empty($brand_icon['ERROR'])) $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $brand_icon['ERROR'] ];
                if(!empty($pub_icon['ERROR'])) $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $pub_icon['ERROR'] ];
                $root->save();
            }


        }
        catch(Exception $e)
        {
            return false;
        }

    }

    function get_all_pubs()
    {
        try{
            return $this->select("SELECT * FROM PUBS");
        }
        catch(Exception $e){
            return null;
        }
    }

    // VIEWS
    ////////////////////////////////
    function add_views($id,$aid)
    {
        try
        {
            try{
                $view = $this->select("SELECT VIEWS FROM VIDEOS WHERE ID = '$id' OR LINK = '$id' ")[0];
                $view_v = empty($view) ? 1 : $view['VIEWS'] + 1;
                $view_anime = $this->select("SELECT VIEWS FROM ANIMES WHERE ID = '$aid' OR LINK = '$aid' ");
                $this->execute("UPDATE VIDEOS SET VIEWS=$view_v WHERE ID = '$id' OR LINK = '$id' ");

                $view_s = $this->select("SELECT VIEWS FROM VIDEOS WHERE ANIME_ID = '$aid' ");
    
                $som = 0;

                foreach($view_s as $v)
                {
                    $som+= $v['VIEWS'] ;
                }

                $this->execute("UPDATE ANIMES SET VIEWS=$som WHERE ID = '$aid' OR LINK = '$aid' ");

                // print_r($view_s);die();
                // echo $som;die();

                return true;
            }
            catch(Exception $e)
            {
                $this->execute("ALTER TABLE VIDEOS ADD VIEWS INT");
                $this->execute("ALTER TABLE ANIMES ADD VIEWS INT");
                $this->execute("UPDATE VIDEOS SET VIEWS=1 WHERE ID = '$id' OR LINK = '$id' ");

                $view_s = $this->select("SELECT VIEWS FROM VIDEOS WHERE ANIME_ID = '$aid' ");
                
                $som = array_sum($view_s);

                $this->execute("UPDATE ANIMES SET VIEWS=$som WHERE ID = '$aid' OR LINK = '$aid' ");

                // echo $e->getMessage();die();
                return true;
            }

            return false;
        }
        catch(Exception $e)
        {
            // echo $e->getMessage();die();
            return false;
        }
    }

    // CHARACTERS
    ////////////////////////////////
    function check_characters($id)
    {
        try
        {
            $res = $this->select("SELECT * FROM CHARACTERS WHERE ID = '$id' ");
            return !empty($res) ? true : false;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    // -----------------------------
    function add_characters($t)
    {
        try
        {
            $root = new Controller;
            $date = $root->actual_date();
            $time = $root->actual_datetime();
            $te = time();
            $id = $this->new_id("CHARACTERS","ID",'hjh');
            $name = $t['NAMES'];
            $special = $t['SPECIAL'];
            $anime_id = $t['ANIME_ID'];

            $test = $this->upload_single_file('PHOTO',10000000,'jpg,jpeg,png',FOLDER_ANIME_CHARACTERS,$id);
            $image = $test['FILENAME'];

            if($test['STATE'])
            {

                $this->execute("INSERT INTO CHARACTERS (ID,ANIME_ID,NAMES,PHOTO,DATES,DATETIMES,SPECIAL) VALUES('$id','$anime_id','$name','$image','$date','$time','$special') ");
                foreach(LANG_LIST as $l){
                    try
                    {
                       $tmp = $this->select("SELECT DESCRIP_".$l['LANG']." FROM CHARACTERS WHERE ID = '$id' OR ANIME_ID = '$id' ");
                       $synop = $t['DESCRIP_'.$l['LANG']];
                       $this->execute("UPDATE CHARACTERS SET DESCRIP_".$l['LANG']."= '$synop' WHERE ID = '$id' OR ANIME_ID = '$id' ");
                    }
                    catch(Exception $e)
                    {
                        $this->execute("ALTER TABLE CHARACTERS ADD DESCRIP_".$l['LANG']." TEXT ;");
                        $synop = $t['DESCRIP_'.$l['LANG']];
                        $this->execute("UPDATE CHARACTERS SET DESCRIP_".$l['LANG']."= '$synop' WHERE ID = '$id' OR ANIME_ID = '$id' ");
                    }
                }

                return true;
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR'] ];
                if(!empty($test['ERROR_SYSTEM'])) $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR_SYSTEM'] ];
                $root->save();
            }

            return false;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    // -----------------------------
    function update_characters($t)
    {
        try
        {
    
            $root = new Controller;
            $name = $t['NAMES'];
            $special = $t['SPECIAL'];
            $id = $t['ID'];

            $test = $this->upload_single_file('PHOTO',10000000,'jpg,jpeg,png',FOLDER_ANIME_CHARACTERS,$id);
            $image = $test['FILENAME'];

                $this->execute("UPDATE CHARACTERS SET NAMES='$name', SPECIAL='$special' WHERE ID = '$id' ");

                foreach(LANG_LIST as $l){
                    try
                    {
                       $tmp = $this->select("SELECT DESCRIP_".$l['LANG']." FROM CHARACTERS WHERE ID = '$id' ");
                       $synop = $t['DESCRIP_'.$l['LANG']];
                       $this->execute("UPDATE CHARACTERS SET DESCRIP_".$l['LANG']."= '$synop' WHERE ID = '$id' ");
                    }
                    catch(Exception $e)
                    {
                        $this->execute("ALTER TABLE CHARACTERS ADD DESCRIP_".$l['LANG']." TEXT ;");
                        $synop = $t['DESCRIP_'.$l['LANG']];
                        $this->execute("UPDATE CHARACTERS SET DESCRIP_".$l['LANG']."= '$synop' WHERE ID = '$id' ");
                    }
                }

                return true;

                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR'] ];
                if(!empty($test['ERROR_SYSTEM'])) $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR_SYSTEM'] ];
                $root->save();

            return false;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    // -----------------------------
    function get_characters($clause,$record=false)
    {
        try
        {
            $r = $this->select("SELECT * FROM CHARACTERS ".( !empty($clause) ? $clause : '' ));
            $ans = $record == true ? $r[0] : $r;
            return $ans;

            return null;
            
        }
        catch(Exception $e)
        {
            return null;
        }
    }
    // -----------------------------
    function delete_characters($id)
    {
        try
        {
            return $this->select("DELETE FROM CHARACTERS WHERE ID = '$id'  ");

            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }


    // CONTACT
    ////////////////////////////////
    function add_contact($t)
    {
        try
        {
            $root = new Controller;
            $date = $root->actual_date();
            $time = $root->actual_datetime();
            $te = time();
            $id = $this->new_id("CONTACT","ID",'number',true);

            // print_r($t);die();

            $full_name = $t['FULL_NAME'];
            $motif = $t['MOTIF'];
            $message = $t['MESSAGES'];

            if(!empty($full_name) && !empty($motif) && !empty($message)){
            $LANG = explode('-', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0] ?? "Inconnue";
            $GEO = "( ".USER_COUNTRY." ) ".USER_COUNTRY_NAME." , ".USER_CITY;
            $DEVISE = USER_DEVISE;
            $PHONE = USER_COUNTRY_PHONE;
            $IP = $_SERVER['REMOTE_ADDR'];

            $pos = strpos( $_SERVER['HTTP_USER_AGENT'],'(');
            $AGENT = explode(' ', strtoupper( substr($_SERVER['HTTP_USER_AGENT'],$pos) ) ) [0];

            if( str_contains( $AGENT,"MACINTOSH")  )
            $OS = "macOS";
            else if( str_contains( $AGENT,"IPHONE")  )
            $OS = "iPhone";
            else if( str_contains( $AGENT,"ANDROID")  )
            $OS = "Android";
            else if( str_contains( $AGENT,"WINDOWS")  )
            $OS = "Windows";
            else if( str_contains( $AGENT,"LINUX")  )
            $OS = "Linux";
            else if( str_contains( $AGENT,"CHROME")  )
            $OS = "chromeOS";
            else
            $OS = "Inconnue";


            $this->execute("INSERT INTO CONTACT (ID,FULL_NAME,MOTIF,MESSAGES,DATES,DATETIMES,SEC_TIME,IP,LANG,GEO,DEVISE,PHONE,OS) VALUES('$id','$full_name','$motif','$message','$date','$time','$te','$IP','$LANG','$GEO','$DEVISE','$PHONE','$OS') ");

            return true;
            }
            else
            {
                return false;
            }

        }
        catch(Exception $e)
        {
            return false;
        }
    }
    // -----------------------------
    function delete_contact($id)
    {
        try
        {
            $this->execute("DELETE FROM CONTACT WHERE ID = '$id' ");
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    // -----------------------------
    function get_contact()
    {
        try
        {
            return $this->select("SELECT * FROM CONTACT ORDER BY SEC_TIME DESC") ?? null;
        }
        catch(Exception $e)
        {
            return null;
        }
    }

    // SUGGESTIONS
    ////////////////////////////////
    function add_suggestion($msg)
    {
        try
        {
            $root = new Controller;
            $date = $root->actual_date();
            $time = $root->actual_datetime();
            $id = $this->new_id("SUGGESTION","ID",'number',true);
            $this->execute("INSERT INTO SUGGESTION (ID,MESSAGES,DATES,DATETIMES) VALUES($id,'$msg','$date','$time') ");
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    // -----------------------------
    function delete_suggestion($id)
    {
        try
        {
            $this->execute("DELETE FROM SUGGESTION WHERE ID = '$id' ");
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    // -----------------------------
    function get_suggestion($id)
    {
        try
        {
            return $this->select("SELECT * FROM SUGGESTION ");
        }
        catch(Exception $e)
        {
            return null;
        }
    }

    // ANIMES
    ////////////////////////////////
    function check_anime($id)
    {
        try
        {
            $res = $this->select("SELECT * FROM ANIMES WHERE ID = '$id' OR LINK = '$id' ");
            return !empty($res) ? true : false;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    // -----------------------------
    function add_anime($t)
    {
        try
        {
            $sp = "<ap>";
    
            $full_name = str_replace("'",$sp, $t['FULL_NAME'] );
            $link = join('-', explode(' ',strtolower( trim( $full_name ))) );
            $original_name = str_replace("'",$sp, $t['ORIGINAL_NAME'] ) ;
            // $synopsis = str_replace("'",$sp,$t['SYNOPSIS'] );
            $romanji = $t['ROMANJI'] ?? "";
            $studio = str_replace("'",$sp,$t['STUDIO'] );
            $trailer = str_replace("'",$sp,$t['TRAILER'] );
            $out_date = str_replace("'",$sp,$t['OUT_DATE'] );
            $genre = str_replace("'",$sp,$t['GENRE'] );
            $version = str_replace("'",$sp,$t['VERSION'] );
            $special = $t['SPECIAL'] ?? 'false';
            $status = $t['STATUS'] ?? '0';
            $id = $this->new_id('ANIMES','ID','nf',12);
            $root = new Controller;
            $date = $root->actual_date();
            $time = $root->actual_datetime();
            $timestamp = time();

            

            $test = $this->upload_single_file('POSTER',10000000,'jpg,jpeg,png',FOLDER_ANIME_POSTER,$id);
            $image = $test['FILENAME'];

            if($test['STATE'])
            {
                $this->execute("INSERT INTO ANIMES (POSTER,ID,DATES,DATETIMES,FULL_NAME,ORIGINAL_NAME,STUDIO,TRAILER,OUT_DATE,GENRE,VERSIONS,LAST_UPDATE,STATUSS,LINK,ROMANJI) VALUES('$image','$id','$date','$time','$full_name','$original_name','$studio','$trailer','$out_date','$genre','$version','$timestamp','$status','$link','$romanji')");
                foreach(LANG_LIST as $l){
                    try
                    {
                       $tmp = $this->select("SELECT SYNOPSIS_".$l['LANG']." FROM ANIMES WHERE ID = '$id' OR LINK = '$id' ");
                       $synop = str_replace("'","<ap>", $t['SYNOPSIS_'.$l['LANG']] );
                       $this->execute("UPDATE ANIMES SET SYNOPSIS_".$l['LANG']."= '$synop' WHERE ID = '$id' OR LINK = '$id' ");
                    }
                    catch(Exception $e)
                    {
                        $this->execute("ALTER TABLE ANIMES ADD SYNOPSIS_".$l['LANG']." TEXT ;");
                        $synop = str_replace("'","<ap>", $t['SYNOPSIS_'.$l['LANG']] );
                        $this->execute("UPDATE ANIMES SET SYNOPSIS_".$l['LANG']."= '$synop' WHERE ID = '$id' OR LINK = '$id' ");
                    }
                }

                return true;
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR'] ];
                if(!empty($test['ERROR_SYSTEM'])) $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR_SYSTEM'] ];
                $root->save();
            }

            // print_r($test);

            // exit();

            return false;
        }
        catch(Exception $e)
        {
            // echo $e->getMessage();
            // exit();
            return false;
        }
    }
    // -----------------------------
    function update_anime($t)
    {
        try
        {
            $sp = "<ap>";
    
            $full_name = str_replace("'",$sp, $t['FULL_NAME'] );
            $link = join('-', explode(' ',strtolower($full_name)) );
            $original_name = str_replace("'",$sp, $t['ORIGINAL_NAME'] ) ;
            // $synopsis = is_array($t['SYNOPSIS']) ? $t['SYNOPSIS'] : str_replace("'",$sp,$t['SYNOPSIS']) ;
            $romanji = $t['ROMANJI'] ?? "";
            $studio = str_replace("'",$sp,$t['STUDIO'] );
            $trailer = str_replace("'",$sp,$t['TRAILER'] );
            $out_date = str_replace("'",$sp,$t['OUT_DATE'] );
            $genre = str_replace("'",$sp,$t['GENRE'] );
            $version = str_replace("'",$sp,$t['VERSION'] );
            $special = $t['SPECIAL'] ?? 'false';
            $status = $t['STATUS'] ?? '0';
            $id = $t['ID'];
            $root = new Controller;

            foreach(LANG_LIST as $l){
                try
                {
                   $tmp = $this->select("SELECT SYNOPSIS_".$l['LANG']." FROM ANIMES WHERE ID = '$id' OR LINK = '$id' ");
                   $synop = str_replace("'","<ap>", $t['SYNOPSIS_'.$l['LANG']] );
                   if(!empty($synop) && $synop != " " && trim($synop) != "")
                   $this->execute("UPDATE ANIMES SET SYNOPSIS_".$l['LANG']."= '$synop' WHERE ID = '$id' OR LINK = '$id' ");
                }
                catch(Exception $e)
                {
                    $this->execute("ALTER TABLE ANIMES ADD SYNOPSIS_".$l['LANG']." TEXT ;");
                    $synop = str_replace("'","<ap>", $t['SYNOPSIS_'.$l['LANG']] );
                    $this->execute("UPDATE ANIMES SET SYNOPSIS_".$l['LANG']."= '$synop' WHERE ID = '$id' OR LINK = '$id' ");
                }
            }

            $test = $this->upload_single_file('POSTER',10000000,'jpg,jpeg,png',FOLDER_ANIME_POSTER,$id);
            // $image = $test['FILENAME'];

            $this->execute("UPDATE ANIMES SET LINK='$link', FULL_NAME='$full_name', SPECIAL='$special', ORIGINAL_NAME='$original_name', STUDIO='$studio',TRAILER='$trailer',OUT_DATE='$out_date',GENRE='$genre',VERSIONS='$version',STATUSS='$status', ROMANJI='$romanji' WHERE ID = '$id' OR LINK = '$id' ");
            $this->execute("UPDATE VIDEOS SET ANIME_NAME='$full_name', ANIME_VERSION='$version' WHERE ANIME_ID = '$id' OR LINK = '$id' ");


            if(!empty($test['ERROR'])) $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR'] ];
            if(!empty($test['ERROR_SYSTEM'])) $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR_SYSTEM'] ];
            $root->save();
            return true;

            // print_r($test);

            // exit();

            return false;
        }
        catch(Exception $e)
        {
            // echo $e->getMessage();
            // exit();
            return false;
        }
    }
    // -----------------------------
    function get_anime($clause,$record=false)
    {
        try
        {
            $r = $this->select("SELECT * FROM ANIMES ".( !empty($clause) ? $clause : '' ));
            $ans = $record == true ? $r[0] : $r;
            return $ans;

            return null;
            
        }
        catch(Exception $e)
        {
            return null;
        }
    }
    // -----------------------------
    function delete_anime($id)
    {
        try
        {

            $img = $this->select("SELECT POSTER FROM ANIMES WHERE ID = '$id' OR LINK = '$id' ")[0][0];
            unlink(FOLDER_ANIME_POSTER.$img);

            $source = $this->select("SELECT LOCATIONS FROM VIDEOS WHERE ANIME_ID = '$id' OR LINK = '$id' ");
            if(!empty($source))
            {
                foreach($source as $s)
                {
                    unlink(FOLDER_ANIME_VIDEO.$s[0]);
                }
            }

            $this->execute("DELETE FROM ANIMES WHERE ID = '$id' OR LINK = '$id' ");
            $this->execute("DELETE FROM VIDEOS WHERE ANIME_ID = '$id' OR LINK = '$id' ");
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    // VIDEO
    ////////////////////////////////
    function check_video($id)
    {
        try
        {
            $res = $this->select("SELECT * FROM VIDEOS WHERE ID = '$id' OR LINK = '$id' ");
            return !empty($res) ? true : false;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    //---------------------------
    function add_video($t)
    {
        try
        {
            $episode = $t['EPISODE'] ;
            $anime_name = $t['ANIME_NAME'] ;
            $anime_id = $t['ANIME_ID'];
            $anime_version = $t['ANIME_VERSION'] ;
            $link = join('-', explode(' ',strtolower( trim( $anime_name ))) ).'-'.$episode.'-'.(strtolower($anime_version));
            // echo $link."<br>";
            // $descrip = str_replace("'","<ap>", $t['DESCRIP'] );
            $source_link = $t['SOURCE_LINK'] ?? "";
            $iframe_link = $t['IFRAME_LINK'] ?? "";
            $warning = $t['WARNING'] ?? "false";
            $id = $this->new_id("VIDEOS",'ID','nf',10);
            $root = new Controller;
            $publish_date = $root->actual_date();
            $publish_datetime = $root->actual_datetime();
            $timestamp = time();

            $EpTest = $this->select("SELECT * FROM VIDEOS WHERE ANIME_ID = '$anime_id' AND EPISODE = '$episode' ");

            if(!empty($EpTest)) return false;

            if(empty($source_link) && empty($iframe_link))
            {
                $test = $this->upload_single_file('VIDEO',150000000,'mp4',FOLDER_ANIME_VIDEO,$id);
                $type = $test['TYPE'];
                $location = $test['FILENAME'];

                if($test['STATE'] == true)
                {
                    $this->execute("INSERT INTO VIDEOS (ID,PUBLISH_DATE,PUBLISH_DATETIME,EPISODE,ANIME_ID,ANIME_NAME,ANIME_VERSION,TYPES,LOCATIONS,WARNING,LINK) VALUES('$id','$publish_date','$publish_datetime','$episode','$anime_id','$anime_name','$anime_version','$type','$location','$warning','$link') ");
                    $this->execute("UPDATE ANIMES SET LAST_UPDATE='$timestamp' WHERE ID = '$anime_id' OR LINK = '$id' ");

                    foreach(LANG_LIST as $l){
                        try
                        {
                           $tmp = $this->select("SELECT DESCRIP_".$l['LANG']." FROM VIDEOS WHERE ID = '$id' OR LINK = '$id' ");
                           $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                           $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                        }
                        catch(Exception $e)
                        {
                            $this->execute("ALTER TABLE VIDEOS ADD DESCRIP_".$l['LANG']." TEXT ;");
                            $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                            $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                        }
                    }
                    return true;
                }
                else
                {
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR'] ];
                    if(!empty($test['ERROR_SYSTEM'])) $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR_SYSTEM'] ];
                    $root->save();
                }

            }
            else
            {
                $this->execute("INSERT INTO VIDEOS (ID,PUBLISH_DATE,PUBLISH_DATETIME,EPISODE,ANIME_ID,ANIME_NAME,ANIME_VERSION,SOURCE_LINK,WARNING,LINK,IFRAME_LINK) VALUES('$id','$publish_date','$publish_datetime','$episode','$anime_id','$anime_name','$anime_version','$source_link','$warning','$link','$iframe_link') ");
                $this->execute("UPDATE ANIMES SET LAST_UPDATE='$timestamp' WHERE ID = '$anime_id' OR LINK = '$id' ");
                foreach(LANG_LIST as $l){
                    try
                    {
                       $tmp = $this->select("SELECT DESCRIP_".$l['LANG']." FROM VIDEOS WHERE ID = '$id' OR LINK = '$id' ");
                       $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                       $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                    }
                    catch(Exception $e)
                    {
                        $this->execute("ALTER TABLE VIDEOS ADD DESCRIP_".$l['LANG']." TEXT ;");
                        $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                        $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                    }
                }
                return true;
            }

            // die();

            return false;
        }
        catch(Exception $e)
        {
            // echo $e->getMessage();die();
            return false;
        }
    }
    // -----------------------------
    function update_video($t)
    {
        try
        {

            // $descrip = str_replace("'","<ap>", $t['DESCRIP'] ?? "");
            $source_link = $t['SOURCE_LINK'] ?? "";
            $iframe_link = $t['IFRAME_LINK'] ?? "";
            $warning = $t['WARNING'] ?? "false";
            $id = $t['ID'];
            $root = new Controller;

            // $publish_date = $root->actual_date();
            // $publish_datetime = $root->actual_datetime();
            // $timestamp = time();

            if(empty($source_link) && empty($iframe_link))
            {
                $test = $this->upload_single_file('VIDEO',150000000,'mp4',FOLDER_ANIME_VIDEO,$id);
                $type = $test['TYPE'];
                $location = $test['FILENAME'];

                if($test['STATE'] == true)
                {
                    $this->execute("UPDATE VIDEOS SET WARNING='$warning', TYPES='$type',LOCATIONS='$location' WHERE ID = '$id' OR LINK = '$id' ");
                    foreach(LANG_LIST as $l){
                        try
                        {
                           $tmp = $this->select("SELECT DESCRIP_".$l['LANG']." FROM VIDEOS WHERE ID = '$id' OR LINK = '$id' ");
                           $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                           if(!empty($synop) && $synop != " " && trim($synop) != "" && str_replace(" ","",$synop) != "" )
                           $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                        }
                        catch(Exception $e)
                        {
                            $this->execute("ALTER TABLE VIDEOS ADD DESCRIP_".$l['LANG']." TEXT ;");
                            $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                            $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                        }
                    }
                    return true;
                }
                else
                {
                    $this->execute("UPDATE VIDEOS SET WARNING='$warning' WHERE ID = '$id' OR LINK = '$id' ");
                    foreach(LANG_LIST as $l){
                        try
                        {
                           $tmp = $this->select("SELECT DESCRIP_".$l['LANG']." FROM VIDEOS WHERE ID = '$id' OR LINK = '$id' ");
                           $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                           if(!empty($synop) && $synop != " " && trim($synop) != "" && str_replace(" ","",$synop) != "" )
                           $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                        }
                        catch(Exception $e)
                        {
                            $this->execute("ALTER TABLE VIDEOS ADD DESCRIP_".$l['LANG']." TEXT ;");
                            $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                            $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                        }
                    }
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR'] ];
                    if(!empty($test['ERROR_SYSTEM'])) $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> $test['ERROR_SYSTEM'] ];
                    $root->save();
                    return true;
                }

            }
            else
            {
                $this->execute("UPDATE VIDEOS SET WARNING='$warning', SOURCE_LINK='$source_link', IFRAME_LINK='$iframe_link' WHERE ID = '$id' OR LINK = '$id' ");
                foreach(LANG_LIST as $l){
                    try
                    {
                       $tmp = $this->select("SELECT DESCRIP_".$l['LANG']." FROM VIDEOS WHERE ID = '$id' OR LINK = '$id' ");
                       $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                       if(!empty($synop) && $synop != " " && trim($synop) != "" && str_replace(" ","",$synop) != "" )
                       $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                    }
                    catch(Exception $e)
                    {
                        $this->execute("ALTER TABLE VIDEOS ADD DESCRIP_".$l['LANG']." TEXT ;");
                        $synop = str_replace("'","<ap>", $t['DESCRIP_'.$l['LANG']] );
                        $this->execute("UPDATE VIDEOS SET DESCRIP_".$l['LANG']."='$synop' WHERE ID = '$id' OR LINK = '$id' ");
                    }
                }
                return true;
            }


            return false;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    // -----------------------------
    function get_video($clause,$record=false)
    {
        try
        {
            $r = $this->select("SELECT * FROM VIDEOS ".( !empty($clause) ? $clause : '' ));
            $ans = $record == true ? $r[0] : $r;
            return $ans;

            return null;
            
        }
        catch(Exception $e)
        {
            return null;
        }
    }
    // -----------------------------
    function delete_video($id)
    {
        try
        {
            $source = $this->select("SELECT LOCATIONS FROM VIDEOS WHERE ID = '$id' OR LINK = '$id' ")[0][0];
            if(!empty($source))
            unlink(FOLDER_ANIME_VIDEO.$source);

            $this->execute("DELETE FROM VIDEOS WHERE ID = '$id' OR LINK = '$id' ");
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    // COMMENTS
    ////////////////////////////////
    function add_comment($t)
    {
        try
        {
            $sp = "<ap>";
    
            $video = $t['VIDEO_ID'];
            $anime = $t['ANIME_ID'];
            $msg = str_replace("'",$sp, $t['MESSAGES'] );
            $name = str_replace("'",$sp, $t['NAME'] );
            $genre = $t['GENRE'];
            $country = $t['COUNTRY'];
            $special = $t['SPECIAL'] ?? 'false';
            $id = $this->new_id('COMMENTS','ID','numbero',11);
            $root = new Controller;
            $date = $root->actual_date();
            $time = $root->actual_datetime();

            $this->execute("INSERT INTO COMMENTS (ID,VIDEO_ID,ANIME_ID,DATES,DATETIMES,FULL_NAME,GENRE,COUNTRY,MESSAGES,SPECIAL,VISIBLE) VALUES('$id','$video','$anime','$date','$time','$name','$genre','$country','$msg','$special','true')");

            return true;
            
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    ////////////////////////////////
    function get_comment($clause)
    {
        try
        {
            return $this->select("SELECT * FROM COMMENTS ".( !empty($clause) ? $clause : '' ));

            return null;
            
        }
        catch(Exception $e)
        {
            return null;
        }
    }

    ////////////////////////////////
    function delete_comment($clause=null)
    {
        try
        {
            $this->execute("DELETE FROM COMMENTS ".( !empty($clause) ? $clause : '' ));

            return true;
            
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    ////////////////////////////////
    function update_comment($id)
    {
        try
        {
            $this->execute("UPDATE COMMENTS SET VISIBLE='true' WHERE ID = '$id' ");

            return true;
            
        }
        catch(Exception $e)
        {
            return false;
        }
    }

}