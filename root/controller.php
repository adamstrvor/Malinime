<?php

//******************************************
//  MAIN       
//******************************************

class Controller
{
    // LOAD CONTROLLER
    //------------------------------------------
    function load_controller($con)
    {
        if(file_exists(FOLDER_CONTROLLERS.$con.'.php'))
        require_once(FOLDER_CONTROLLERS.$con.'.php');
    }

    // LOAD MODEL
    //------------------------------------------
    function load_model($mod)
    {
        if(file_exists(FOLDER_MODELS.$mod.'.php'))
        require_once(FOLDER_MODELS.$mod.'.php');
    }

    // SAVE
    //------------------------------------------
    function save()
    {
        ob_start();
        if(IS_NAVIGATOR == true)
        {
        setcookie(SESSION,json_encode($_COOKIE[SESSION] ?? null), COOKIE_TIME,COOKIE_PATH,SITE_HOST_NAME,COOKIE_SECURE,COOKIE_HTTP_ONLY);
        }
        ob_get_clean();
    }

    //  LINKS
    //------------------------------------------
    function link($exact=null)
    {
        require(FOLDER_LINK);

        return !empty($exact) ? $links[strtoupper($exact)] : $links;
    }

    // RENDER
    //------------------------------------------
    function render($view,$var=array(),$template='main')
    {
        try
        {
        ob_start();
        extract($var);
        $var['template'] = $template;
        require_once(FOLDER_VIEWS_PAGES.$view.'.php');
        $view = ob_get_clean();
        require_once(FOLDER_VIEWS_TEMPLATES.$template.'.php');
        }
        catch(Exception $e)
        {
            throw New Exception("ROOT-CONTROLLER: function render <br>".$e->getMessage());
        }
    }

    //  LANG LIST
    //------------------------------------------

    function lang_list()
    {
        $all_lang = scandir(FOLDER_LANG);

        $result = array();

        foreach($all_lang as $a)
        {
            if(str_split($a)[0] != '.')
            {
                $ss = str_replace('.php','',$a);
                $result[] = ["LANG"=>$ss,"LANG_STRING"=>LANG_STRING[$ss] ?? $ss] ;
            }
        }

        return $result ?? null;
    }

    //  CHANGE LANGUAGE
    //------------------------------------------
    function ch_lang()
    {
        if(!empty($_POST['TO_LANG']) && !empty($_POST['SRC_LANG']))
        {
            $_POST['TO_LANG'] = str_replace(' ','',$_POST['TO_LANG']);
            $_POST['SRC_LANG'] = str_replace(' ','',$_POST['SRC_LANG']);
            $src = LANG_STRING[ $_POST['SRC_LANG'] ?? "fr" ] ?? LANG_STRING['fr'];
            $to = LANG_STRING[ $_POST['TO_LANG'] ?? "en" ] ?? LANG_STRING['en'];

            setcookie(COOKIE_USER_LANG,htmlspecialchars( strip_tags( $_POST['TO_LANG'] ) ), COOKIE_TIME,COOKIE_PATH,SITE_HOST_NAME,COOKIE_SECURE,COOKIE_HTTP_ONLY);
            $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=>"$src  ->  $to  ✅"];
            $this->save();
        }
        header("Location: ". $_SERVER['HTTP_REFERER'] ?? LINK['main']);
        
    }

    //  TAUX
    //------------------------------------------
    function taux($source='EUR',$destination='USD',$special = false)
    {
        try
        {
        return null;

        
        ob_start();

        if($special == false)
        {
            if(empty($_COOKIE[SESSION]['TAUX']))
            {
                $_COOKIE[SESSION]['TAUX'] = json_decode(file_get_contents("https://api.apilayer.com/exchangerates_data/latest?apikey=GwS84nNE8478wjQ0I5rpDJ4Bh0utwPYW")??"",true);$this->save();
            }
            $result = $_COOKIE[SESSION]['TAUX'];
        }
        else
        {
            $result  = $_COOKIE[SESSION]['TAUX'][$source] ;//json_decode(file_get_contents("https://api.apilayer.com/exchangerates_data/latest?base=$source&symbols=$destination&apikey=GwS84nNE8478wjQ0I5rpDJ4Bh0utwPYW")??"",true);
        }

        $v= ob_get_clean();
        return $result ?? null;//['SRC'=>$source,'DEST'=>$destination,'RATES'=> 

        }
        catch(Exception $e)
        {
            return null;
        }

    }

    //  TRANSLATE
    //------------------------------------------
    function translate($text,$dest='en',$src=null)
    {
        try
        {
            ob_start();
            $curl = curl_init();
 
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/language_translation/translate?target=$dest".(!empty($src) ? '&source='.$src : ""),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: GwS84nNE8478wjQ0I5rpDJ4Bh0utwPYW"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$text
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            ob_get_clean();

            return json_decode($response,true)['translations'][0]['translation'] ?? null;

            // $result = json_decode(file_get_contents("https://api.apilayer.com/language_translation/translate?target=$dest&source=fr&data=$text&apikey=GwS84nNE8478wjQ0I5rpDJ4Bh0utwPYW"),true);
            // return $result['translations']['translation'] ?? null;
        }
        catch(Exception $e)
        {
            return null;
        }
    }

    //  SEND SMS
    //------------------------------------------

    function sms($title="",$message="",$dest_prfix="+223",$dest="77214689")
    {
        ob_start();
        $details = json_decode(file_get_contents("https://bulksms.ma/developer/sms/send?token=knYtg8Ujtnn8IyIdYGgbnlyUd&tel=0644286569&message=service%20de%20Baterenako&shortcode=Baterenako&Paiements"),true);
        $v=ob_get_clean();
        return $details['success'] ?? null;
    }

    //  LANG
    //------------------------------------------
    function get_lang($lang,$default)
    {
        if(file_exists(FOLDER_LANG.$lang.'.php'))
        {
            define('LANG_SYSTEM',$lang);
            if($lang == 'ar') define("LANG_DIR","rtl"); else define("LANG_DIR","ltr");
            require_once(FOLDER_LANG.$lang.'.php');
            return $lang;
        }
        else if(file_exists(FOLDER_LANG.$default.'.php'))
        {
            define('LANG_SYSTEM',$default);
            if($lang == 'ar') define("LANG_DIR","rtl"); else define("LANG_DIR","ltr");
            require_once(FOLDER_LANG.$default.'.php');
            return $lang ;
        }
        else
        {
            return [''];
        }

    }

    //  ACTUAL DATE
    //------------------------------------------

    function actual_date()
    {
        $d = getdate();
        return $ac_date =  $d['wday'].'/'.$d['mday'].'/'.$d['mon'].'/'.$d['year'];       
    }

    //  ACTUAL DATE
    //------------------------------------------

    function actual_date_string()
    {
        $d = getdate();
        $w['fr'] = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        $m['fr'] = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
        $w['en'] = ['Sundy','Monday','Thusday','Wednesday','Thursday','Friday','Saturday'];
        $m['en'] = ['January','Febuary','March','April','May','June','July','Augûst','September','October','November','Décember'];
        return $ac_date =  ($w[LANG_SYSTEM][$d['wday']] ).' '.$d['mday'].' '.($m[LANG_SYSTEM][$d['mon']-1] ).' '.$d['year'];       
    }

    //  ACTUAL DATE
    //------------------------------------------

    function date_to_string($d="6/6/8/2022")
    {
        $d = explode('/',$d);
        $w['fr'] = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        $m['fr'] = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

        $w['en'] = ['Sundy','Monday','Thusday','Wednesday','Thursday','Friday','Saturday'];
        $m['en'] = ['January','Febuary','March','April','May','June','July','Augûst','September','October','November','Décember'];

        $weekday = ($w[LANG_SYSTEM][abs($d[0])]);
        
        $monthday = $d[1];
        $month = ($m[LANG_SYSTEM][abs($d[2]-1)]);
        $year = $d[3];

        return $ac_date =  $weekday.' '.$monthday.' '.$month.' '.$year;       
    }

    //  DATE COMPARE
    //------------------------------------------
    
    function date_compare($d)
    {
        $dd = explode("/",$this->actual_date());
        $d = explode("/",$d);
        $jour = abs( $dd[1] - $d[1] );
        $mois = abs( $dd[2] - $d[2] );
        $ann = abs( $dd[3] - $d[3] );

        if($ann == 0)
        {
            if($mois == 0)
            {
                if($jour == 0)
                {
                    return " Aujourd'hui ";   
                }
                else{ return ($jour == 1) ? " Hier" : " il y a $jour jours "; }
            }
            else{ return " Il y a $mois mois "; }
        }
        else{ return ($ann == 1) ? " il y a $ann an " : " il y a $ann ans "; }
 
    }

    //  ACTUAL DATETIME
    //------------------------------------------

    function actual_datetime()
    {
        $d = getdate();
        return $ac_date =  $d['minutes'].'/'.$d['hours'].'/'.$d['mday'].'/'.$d['mon'].'/'.$d['year'];       
    }

    //  DATETIME COMPARE
    //------------------------------------------

    function datetime_compare($d)
    {
        $dd = explode("/",$this->actual_datetime());
        $d = explode("/",$d);
        $minute = abs( $dd[0] - $d[0] );
        $hour = abs( $dd[1] - $d[1] );
        $jour = abs( $dd[2] - $d[2] );
        $mois = abs( $dd[3] - $d[3] );
        $ann = abs( $dd[4] - $d[4] );

        $min = $dd[0] + abs( $d[0] -60 );
        $h = $dd[1] + abs( $d[1] -24 );
        $j = $dd[2] + abs( $d[2] - 31);
        $m = $dd[3] + abs( $d[3] - 12);

        $now['fr'] = "À l'instant !";
        $now['en'] = "Now !";
        $now['ja'] = "ちょうど今 !";
        $now['ko'] = "방금 !";
        $now['ar'] = "حالياً !";
        $now['bm'] = 'Sisan dɔrɔn !';

        $weekday['fr'] = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        $weekday['en'] = ['Sundy','Monday','Thusday','Wednesday','Thursday','Friday','Saturday'];

        if($ann == 0  )  // || ( $ann == 1 && $m <= 12 )
        {
            if($mois == 0  )  // || ($mois == 1 && $j <= 31 )
            {
                if($jour == 0  ) // || ($jour == 1 && $h <= 23 )
                {
                    if($hour == 0 ) // || ($hour == 1 && $minute <= 60)
                    {
                        if($minute == 0)
                        {
                            return $now[LANG_SYSTEM] ?? "À l'instant !";
                        }
                        else{ if(LANG_SYSTEM == 'bm'){ return  "A bɛ miniti ".$minute. " bɔ" ; } else if(LANG_SYSTEM == 'ar'){  if($minute <= 2 ){return   " دقيقة ".$minute." منذ" ;}else if($minute <= 10 ){return   " دقائق ".$minute." منذ" ;  } else{return   " دقيقة ".$minute." منذ" ;  } } else if(LANG_SYSTEM == 'ko'){ return  $minute ." 분 전 "; } else if(LANG_SYSTEM == 'ja'){ return  $minute ." 分前 "; } else if(LANG_SYSTEM == 'en'){ return $minute == 1 ? $minute. " minute ago " : $minute ." minutes ago"; } else{ return ($minute == 1 ) ? " il y a $minute minute " : " il y a $minute minutes "; } }
                    }
                    else
                    { 
                        if($hour == 1 && $min <=59 )
                        {
                            if(LANG_SYSTEM == 'bm'){ return  "A bɛ miniti ".$min. " bɔ" ; } else if(LANG_SYSTEM == 'ar'){  if($min <= 2 ){return   " دقيقة ".$min." منذ"   ;}else if($min <= 10 ){return   " دقائق ".$min." منذ" ;  } else{return   " دقيقة ".$min." منذ" ;  } } else if(LANG_SYSTEM == 'ko'){ return $min. " 분 전 " ; } else if(LANG_SYSTEM == 'ja'){ return $min. " 分前 " ; } else if(LANG_SYSTEM == 'en'){ return ( $min == 1 ) ? $min. " minute ago " : $min ." minutes ago" ; } else{ return ($min == 1 ) ? " il y a $min minute " : " il y a $min minutes ";  } ;
                        }
                        else
                        {
                            if(LANG_SYSTEM == 'bm'){ return "A bɛ sanga ".$hour ." bɔ " ; } else if(LANG_SYSTEM == 'ar'){ if($hour == 2){ return " ساعاتين " ; } else { return " ساعة ".$hour." قبل" ; } } else if(LANG_SYSTEM == 'ko'){ return $hour ." 시간 전 " ; } else if(LANG_SYSTEM == 'ja'){ return $hour ." 時間前 " ; } else if(LANG_SYSTEM == 'en'){ return ( $hour == 1 ) ? $hour." hour ago " : $hour ." hours ago" ; } else { return ($hour == 1 ) ? " il y a $hour heure " : " il y a $hour heures "; } 
                        }
                    }
                }
                else
                {   if($jour == 1 && $h <=23 )
                    {
                        if(LANG_SYSTEM == 'bm'){ return "A bɛ sanga ".$h ." bɔ " ; } else if(LANG_SYSTEM == 'ar'){ if($h == 2){ return " ساعاتين " ; } else { return " ساعة ".$h." قبل" ; } } else if(LANG_SYSTEM == 'ko'){ return  $h ." 시간 전  "; } else if(LANG_SYSTEM == 'ja'){ return  $h ." 時間前 "; } else if(LANG_SYSTEM == 'en'){ return ( $h == 1 ) ? $h." hour ago " : $h ." hours ago"; } else{ return ($h == 1 ) ? " il y a $h heure " : " il y a $h heures ";}
                    }
                    else
                    {
                        if(LANG_SYSTEM == 'bm'){ return ($jour > 7) ? "dɔgɔkoun ".floor($jour / 7) :  "A bɛ tile ". $jour . " bɔ " ; } else if(LANG_SYSTEM == 'ar'){ if($jour == 2 || $jour == 3 ){ return " أيام ".$jour." منذ"; } else{ return  " يوم ".$jour." منذ" ;} } else if(LANG_SYSTEM == 'ko'){ return  $jour . " 일 전 " ; } else if(LANG_SYSTEM == 'ja'){ return  $jour . " 日前 " ; } else if(LANG_SYSTEM == 'en'){ return ( $jour > 7 ) ? ( ($jour / 7) < 2 ? floor($jour / 7)." week ago" :floor($jour / 7)." weeks ago") : ( ( $jour == 1 ) ? $jour." day ago" : $jour . " days ago" ) ; } else{ return ($jour > 7) ? ( ($jour / 7) < 2 ? "Il y a ". floor($jour / 7). " semaine" : "Il y a ". floor($jour / 7 ). " semaines"  ) : ( ($jour == 1 ) ? " il y a $jour jour " : " il y a $jour jours " ) ;} ; 
                    }
                }
            }
            else
            { 
                if($mois == 1 && $j <=31 )
                {
                    if(LANG_SYSTEM == 'bm'){ return ($j > 7) ? "dɔgɔkoun ".floor($j / 7) :  "A bɛ tile ". $j . " bɔ " ; } else if(LANG_SYSTEM == 'ar'){ if($j == 2 || $jour == 3 ){ return " أيام ".$j." منذ"; } else{ return  " يوم ".$j." منذ" ;} } else if(LANG_SYSTEM == 'ko'){ return  $j . " 일 전 " ; } else if(LANG_SYSTEM == 'ja'){ return  $j . " 日前 " ; } else if(LANG_SYSTEM == 'en'){ return ( $j > 7 ) ? ( ($j / 7) < 2 ? floor($j / 7)." week ago" :floor($j / 7)." weeks ago") : ( ( $j == 1 ) ? $j." day ago" : $j . " days ago" ) ; } else{ return ($j > 7) ? ( ($j / 7) < 2 ? "Il y a ". floor($j / 7). " semaine" : "Il y a ". floor($j / 7 ). " semaines"  ) : ( ($j == 1 ) ? " il y a $j jour " : " il y a $j jours " ) ;} ; 
                }
                else
                {
                    if(LANG_SYSTEM == 'bm'){ return "A bɛ kalo ". $mois . " bɔ " ; } else if(LANG_SYSTEM == 'ar'){ if( $mois == 3 ){ return " شهر ".$mois." منذ"; }else{ return " شهر ".$mois." منذ"; } }else if(LANG_SYSTEM == 'ko'){ return $mois . " 개월 전 " ; } else if(LANG_SYSTEM == 'ja'){ return $mois . " ヶ月前 " ; } else if(LANG_SYSTEM == 'en'){ return ( $mois == 1 ) ? $mois." month ago" : $mois . " months ago" ; } else{ return " il y a $mois mois " ;} 
                }
            }
        }
        else
        { 
            if($ann == 1 && $m <=12 )
            {
                if($m == 1 && $j <= 31)
                {
                    if($j == 1 && $h <= 23)
                    {
                        if(LANG_SYSTEM == 'bm'){ return "A bɛ sanga ".$h ." bɔ " ; } else if(LANG_SYSTEM == 'ar'){ if($h == 2){ return " ساعاتين " ; } else { return " ساعة ".$h." قبل" ; } } else if(LANG_SYSTEM == 'ko'){ return  $h ." 시간 전  "; } else if(LANG_SYSTEM == 'ja'){ return  $h ." 時間前 "; } else if(LANG_SYSTEM == 'en'){ return ( $h == 1 ) ? $h." hour ago " : $h ." hours ago"; } else{ return ($h == 1 ) ? " il y a $h heure " : " il y a $h heures ";}
                    }
                    else
                    {
                        if(LANG_SYSTEM == 'bm'){ return ($j > 7) ? "dɔgɔkoun ".floor($j / 7) :  "A bɛ tile ". $j . " bɔ " ; } else if(LANG_SYSTEM == 'ar'){ if($j == 2 || $j == 3 ){ return " أيام ".$j." منذ"; } else{ return  " يوم ".$j." منذ" ;} } else if(LANG_SYSTEM == 'ko'){ return  $j . " 일 전 " ; } else if(LANG_SYSTEM == 'ja'){ return  $j . " 日前 " ; } else if(LANG_SYSTEM == 'en'){ return ( $j > 7 ) ? ( ($j / 7) < 2 ? floor($j / 7)." week ago" :floor($j / 7)." weeks ago") : ( ( $j == 1 ) ? $j." day ago" : $j . " days ago" ) ; } else{ return ($j > 7 ) ? ( ($j / 7) < 2 ? "Il y a ". floor($j / 7). " semaine" : "Il y a ". floor($j / 7 ). " semaines"  ) : ( ($j == 1 ) ? " il y a $j jour " : " il y a $j jours " ) ;} ; 
                    }
                }
                else
                {
                    if(LANG_SYSTEM == 'bm'){ return "A bɛ kalo ". $m . " bɔ " ; } else if(LANG_SYSTEM == 'ar'){ if( $m == 3 ){ return " شهر ".$m." منذ"; }else{ return " شهر ".$m." منذ"; } }else if(LANG_SYSTEM == 'ko'){ return $m . " 개월 전 " ; } else if(LANG_SYSTEM == 'ja'){ return $m . " ヶ月前 " ; } else if(LANG_SYSTEM == 'en'){ return ( $m == 1 ) ? $m." month ago" : $m . " months ago" ; } else{ return " il y a $m mois " ;} 
                }
            }
            else
            {
                if(LANG_SYSTEM == 'bm'){ return "A bɛ san ". $ann . " bɔ " ; } else if(LANG_SYSTEM == 'ar'){ if( $ann == 2 ){ return " سنتان ".$ann." قبل"; }else{ return " سنة ".$ann." قبل"; } }else if(LANG_SYSTEM == 'ko'){ return $ann . " 년 전 " ; } else if(LANG_SYSTEM == 'ja'){ return  $ann." 年前 "; } else if(LANG_SYSTEM == 'en'){ return ( $ann == 1 ) ? $ann." year ago" : $ann . " years ago" ; } else{ return  ($ann == 1 ? " il y a $ann an " : " il y a $ann ans ") ;} 
            }
        }
 
    }

    //  COUNTRY _INFO
    //------------------------------------------

    function country_info($exact=null)
    {
        $ip =  $_SERVER['REMOTE_ADDR'] ?? "";//196.64.252.231
        ob_start();
        $country = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));
        $code =  $country->country ?? 'MA';  // !empty($exact) ? $exact :
        $city = $country->city ?? "Fès";
        $region = $country->region ?? "";
        $localisation = $country->loc ?? "0.0,0.0";
        $hostname = $country->hostname ?? "";
        $timezone = $country->timezone ?? "";
        $org = $country->org ?? "";
        $devise = (json_decode(file_get_contents("http://country.io/currency.json"),true))[$code];
        $name = (json_decode(file_get_contents("http://country.io/names.json"),true))[$code];
        $capital = (json_decode(file_get_contents("http://country.io/capital.json"),true))[$code];
        $phone_code = (json_decode(file_get_contents("http://country.io/phone.json"),true))[$code];
        ob_get_clean();
        return ["DEVISE"=>$devise,"COUNTRY"=>$code,"COUNTRY_PHONE"=>$phone_code,"COUNTRY_NAME"=>$name,"COUNTRY_CAPITAL"=>$capital,"CITY"=>$city,'REGION'=>$region,'LOCALISATION'=>$localisation,'TIMEZONE'=>$timezone,'HOSTNAME'=>$hostname,'ORG'=>$org] ?? null;
    }

    //  ALL DEVISE
    //------------------------------------------

    function all_devise()
    {
        ob_start();
        $c = (json_decode(file_get_contents("http://country.io/currency.json"),true)) ?? null;
        ob_get_clean();
        return $c ?? [];
    }

    //  ALL PHONE
    //------------------------------------------

    function all_phone()
    {
        ob_start();
        $phone = (json_decode(file_get_contents("http://country.io/phone.json"),true)) ?? null;
        $all = array();
        foreach($phone as $p )
        {
            if(is_numeric($p))
            {
                $all[] = $p;
            }
        }
        sort($all);
        $all = array_unique($all);
        ob_get_clean();
        return $all ?? [];
    }

    //  ALL CAPITAL
    //------------------------------------------

    function all_capital()
    {
        ob_start();
        $c = (json_decode(file_get_contents("http://country.io/capital.json"),true)) ?? null;
        ob_get_clean();
        return $c ?? [];
    }

    //  ALL NAMES
    //------------------------------------------

    function all_name()
    {
        ob_start();
        $c = (json_decode(file_get_contents("http://country.io/names.json"),true)) ?? null;
        ob_get_clean();
        return $c ?? [];
    }

}

?>