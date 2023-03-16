<?php

//*****************
//  MODEL ROOT
//*****************

class Model
{
    private $db_connexion;

    //  CONNEXION
    //------------------------------------------
    function connect_db()
    {
        try
        {
            $this->db_connexion = new PDO(DB_CONNECTION.":host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME,DB_USERNAME,DB_PASSWORD);
            // $this->db_connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->db_connexion;
        }
        catch(PDOException $e)
        {
            throw New Exception("DB CONNECTION: ".$e->getMessage());
        }
    }

    //  SELECT
    //------------------------------------------
    function select($request,$type=null)
    {
        try
        {
            if(!isset($type))
                return $this->connect_db()->query($request)->fetchAll();
            else if($type == 'record')
                return $this->connect_db()->query($request)->fetch();
            else if($type == 'column')
                return $this->connect_db()->query($request)->fetchColumn();
            else if($type == 'object')
                return $this->connect_db()->query($request)->fetchObject();
            else
                return $this->connect_db()->query($request)->fetchAll();
        }
        catch(PDOException $e)
        {
            throw New Exception("DB SELECT: ".$e->getMessage());
        }
    }

    //  EXECUTE
    //------------------------------------------
    function execute($request)
    {
        try
        {
            return $this->connect_db()->exec($request);
        }
        catch(PDOException $e)
        {
            throw New Exception("DB EXCECUTE: ".$e->getMessage());
        }
    }

    //  GET ALL
    //------------------------------------------
    function get_all($db)
    {
        try
        {
            $this->select("SELECT * FROM ".$db) ?? null;
        }
        catch(PDOException $e)
        {
            return null;
        }
    }

    //  GET ALL
    //------------------------------------------
    function get_only($db,$clause,$record=false)
    {
        try
        {
            $this->select("SELECT * FROM ".$db." WHERE ".$clause, $record == true ? 'record' : null) ?? null;
        }
        catch(PDOException $e)
        {
            return null;
        }
    }

    //  DELETE ALL
    //------------------------------------------
    function delete_all($db)
    {
        try
        {
            $this->execute("DELETE FROM ".$db);
            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
    }

    //  DELETE ALL
    //------------------------------------------
    function delete_only($db,$clause)
    {
        try
        {
            $this->execute("DELETE FROM ".$db." WHERE ".$clause);
            return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
    }

    //  ID GENERATOR
    //------------------------------------------
    function keyGenerator($size =20)
    {
        $cpt=0;
        $id= array();
        $i=0;$cpt=0;
        $tab = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        while( $cpt <  $size){
            $i = floor( rand(0,count($tab) -1));
            $id[] = $tab[$i];
            $cpt++;
        };
        return join("",$id);
    }

    //  NUMBER GENERATOR
    //------------------------------------------
    function numberGenerator($size =10)
    {
        $cpt=0;
        $id= array();
        $i=0;$cpt=0;
        $tab = ['0','1','2','3','4','5','6','7','8','9'];
        while( $cpt <  $size){
            $i = floor( rand(0,count($tab) -1));
            $id[] = $tab[$i];
            $cpt++;
        };
        return join("",$id);
    }

    //  NEW ID
    //------------------------------------------
    function new_id($db,$id_name='ID',$type='number',$taille=10,$increment=false)
    {
        try
        {
            if(!empty($db))
            {
                if($increment == false)
                {
                    $ids = $this->select("SELECT ".$id_name." FROM ".$db);
                    $new_id = $type == 'number' ? $this->numberGenerator($taille) : $this->keyGenerator($taille) ;

                    if(count($ids) > 0)
                    {
                        $i=0;
                        while($i < count($ids))
                        {
                            if($ids[$i][$id_name] == $new_id)
                            {
                                $new_id = $type == 'number' ? $this->numberGenerator($taille) : $this->keyGenerator($taille) ;
                                $i=0;
                            }
                            else
                            $i++;
                        }
                    }

                    return $new_id;
                }
                else
                {
                    $id = $this->select("SELECT MAX(".$id_name.") FROM ".$db)[0][0];

                    if(is_numeric($id) && !empty($id))
                    {
                        $new = $id + 1;
                        return $new;
                    }
                    else if(empty($id))
                    {
                        return 1;
                    }
                    else
                    {
                        return null;
                    }

                }
            }
            else
            {
                return null;
            }
        }
        catch(Exception $e)
        {
            return null;
        }
    }

    //  UPLOAD SINGLE FILE
    //------------------------------------------
    function upload_single_file($name='file',$maxsize=6000000,$accept_type='jpg,jpeg,png,pdf',$dest=LFOLDER_FILES,$filename='file')
    {
        try
        {
        ob_start();
        $OK=false;
        $error="";
        if( !empty($_FILES[$name]) && $_FILES[$name]['error'] == 0 )
        {
            if ($_FILES[$name]['size'] <= $maxsize)
            {
            $fileInfo = pathinfo($_FILES[$name]['name']);
            $type = $_FILES[$name]['type'];
            $extension = $fileInfo['extension'];
            $allowedExtensions = explode(',',$accept_type);
            if (in_array($extension, $allowedExtensions))
            {
                $send = move_uploaded_file($_FILES[$name]['tmp_name'], $dest.$filename.'.'.$extension );
                if($send){$OK=true; }else{$OK=false;$error = LANG['FILE_NOT_MOVE'] ?? "Le fichier n'a pas été envoyée";}
            }
            else{$OK=false;$error = LANG['FILE_EXTENSION_ERROR'] ?? "Extension du fichier non autorisé !";}
            }
            else{$OK=false;$error = LANG['FILE_SIZE_UNAUTHORIZED'] ?? "Taille autorisée du fichier dépsassé ! ";}
        }
        else{$OK=false;$error = LANG['FILE_SEND_ERROR'] ?? "Erreur lors de l'envoie du fichier !";}

        // echo $error;
        // exit();

        return ['STATE'=>$OK,'FILENAME'=>$filename.'.'.($extension ?? ""),"ERROR"=>$error,"ERROR_SYSTEM"=>ob_get_clean()];
        }
        catch(Exception $e)
        {
            return ['STATE'=>false,'FILENAME'=>$filename.'.'.($extension ?? ""),"ERROR"=>$error,"ERROR_SYSTEM"=>ob_get_clean(),'TYPE'=>$type];    
        }

    }

    //  UPLOAD MULTIPLE FILE
    //------------------------------------------
    function upload_multiple_file($name='file',$maxsize=6000000,$accept_type='jpg,jpeg,png,pdf',$dest=LFOLDER_FILES,$filename=[])
    {
    
        $i=0;
        $result = array();

        while($i < count($_FILES[$name]['name']))
        {
        ob_start();
        if( !empty($_FILES[$name][$i]) && $_FILES[$name]['error'][$i] == 0 )
        {
            if ($_FILES[$name]['size'][$i] <= $maxsize)
            {
            $fileInfo = pathinfo($_FILES[$name]['name'][$i]);
            $extension = $fileInfo['extension'];
            $allowedExtensions = explode(',',$accept_type);
            if (in_array($extension, $allowedExtensions))
            {
                $send = move_uploaded_file($_FILES[$name]['tmp_name'][$i], $dest.$filename[$i].'.'.$extension );
                if($send){$OK=true;$result[] = ['STATE'=>$OK,'FILENAME'=>$filename[$i].'.'.$extension,"ERROR"=>"","ERROR_SYSTEM"=>ob_get_clean()]; }else{$OK=false;$result[] = ['STATE'=>$OK,'FILENAME'=>$filename[$i].'.'.$extension,"ERROR"=>(LANG['FILE_NOT_MOVE'] ?? "Le fichier n'a pas été envoyé"),"ERROR_SYSTEM"=>ob_get_clean()];}
            }
            else{$OK=false;$result[] = ['STATE'=>$OK,'FILENAME'=>$filename[$i].'.'.$extension,"ERROR"=>(LANG['FILE_EXTENSION_ERROR'] ?? "L'extension du fichier n'est pas autorisée"),"ERROR_SYSTEM"=>ob_get_clean()];}
            }
            else{$OK=false;$result[] = ['STATE'=>$OK,'FILENAME'=>$filename[$i].'.',"ERROR"=>(LANG['FILE_SIZE_UNAUTHORIZED'] ?? "La taille du fichier est trop grande"),"ERROR_SYSTEM"=>ob_get_clean()];}
        }
        else{$OK=false;$result[] = ['STATE'=>$OK,'FILENAME'=>$filename[$i].'.',"ERROR"=>(LANG['FILE_SEND_ERROR'] ?? "Erreur d'envoie du fichier"),"ERROR_SYSTEM"=>ob_get_clean()];}

        ob_get_clean();
        $i++;
        }

        return $result;
    }

    //  ADD_REQUEST
    //------------------------------------------
    function add_request($PAGE)
    {
        $blocked=false;
        try
        {

            if(explode('/',$PAGE)[0] == 'admin' || !empty($_COOKIE[SESSION]['ADMIN_ID']) || $PAGE == 'mode') return true;

            $root = new Controller;

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
            $OS = $AGENT;

            $URL = $_SERVER['REQUEST_URI'];
            $LANG = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : "Inconnue";
            $GEO = "( ".USER_COUNTRY." ) ".USER_COUNTRY_NAME." , ".USER_CITY . " , ". USER_REGION;
            $TIMEZONE = USER_TIMEZONE;
            $LOC = USER_LOCALISATION;
            $HOST= USER_HOSTNAME;
            $ORG = USER_ORG;
            $DEVISE = USER_DEVISE;
            $PHONE = USER_COUNTRY_PHONE;
            $IP = $_SERVER['REMOTE_ADDR'];
            $DATES = $root->actual_date();
            $DATETIMES = $root->actual_datetime();
            $time= time();

            $block = $this->select("SELECT * FROM CLIENT_REQUEST WHERE IP = '$IP' AND BLOCKED = 'true' ");

            if(!empty($block)){ $blocked=true;throw New Exception("403"); }

            $test = $this->select("SELECT * FROM CLIENT_REQUEST WHERE IP = '$IP' ");  //  AND OS = '$OS' AND URLS = '$URL'

            if(!empty($test))
            {
                $this->execute("UPDATE CLIENT_REQUEST SET ORG='$ORG', TIMEZONES='$TIMEZONE', LOC='$LOC', OS='$OS', URLS='$URL', GEO='$GEO', DEVISE='$DEVISE', LANG='$LANG', PHONE='$PHONE', PAGES='$PAGE', SEC_TIME='$time',REQUEST_TIME=REQUEST_TIME+1, DATES='$DATES', DATETIMES='$DATETIMES' WHERE IP = '$IP' ");
            }
            else
            {
                $this->execute("INSERT INTO CLIENT_REQUEST (IP,OS,PAGES,DATES,DATETIMES,URLS,LANG,GEO,DEVISE,PHONE,REQUEST_TIME,SEC_TIME,TIMEZONES,ORG,LOC) VALUES('$IP','$OS','$PAGE','$DATES','$DATETIMES','$URL','$LANG','$GEO','$DEVISE','$PHONE',1,'$time','$TIMEZONE','$ORG','$LOC') ");
            }


            return true;
        }
        catch(Exception $e)
        {
            if($blocked == true){ throw New Exception("403");die();}

            return false;
        }
    }

    //  ADD_REQUEST
    //------------------------------------------
    function get_request($clause)
    {
        try
        {
            return $this->select("SELECT * FROM CLIENT_REQUEST ".$clause) ?? null;
        }
        catch(Exception $e)
        {
            return null;
        }
    }

    //  DELETE_REQUEST
    //------------------------------------------
    function delete_request($clause)
    {
        try
        {
            $this->select("DELETE FROM CLIENT_REQUEST ".$clause);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    //  BLOCK_REQUEST
    //------------------------------------------
    function block_request($id)
    {
        try
        {
            $test = $this->select("SELECT * FROM CLIENT_REQUEST WHERE IP = '$id' ");
            if(!empty($test))
            {
                $test = $test[0];
                $test = !empty($test['BLOCKED']) ? $test['BLOCKED'] : 'false';
                if($test == 'true')
                {
                    $this->execute("UPDATE CLIENT_REQUEST SET BLOCKED='false' WHERE IP = '$id'  ");
                }
                else
                {
                    $this->execute("UPDATE CLIENT_REQUEST SET BLOCKED='true' WHERE IP = '$id'  ");
                }

            }

            // die();

            return true;
        }
        catch(Exception $e)
        {
            // echo $e->getMessage();die();
            return false;
        }
    }
}