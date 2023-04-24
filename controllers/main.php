<?php

//******************************************
//  MAIN       
//******************************************

$ROOT = new Controller;
$ROOT->load_model('main');

class Main extends Controller
{

    // SUGGESTION
    //------------------------------------------
    function suggestion($params=null)
    {
        $MODEL = new _Main;

        if(!empty($_POST['MESSAGES']))
        {
            $msg = htmlspecialchars( strip_tags( $_POST['MESSAGES'] ) ) ;

            if($MODEL->add_suggestion($msg))
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG['THANKS'] ?? "Nous avons bien réçus. Merci pour votre contribution !" ).' !' ];$this->save();
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie" ).' !' ];$this->save();
            }
        }
        else
        {
            $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie" ).' !' ];$this->save();
        }

        header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));
    }

    //  TELEGRAM
    //---------------------------------
    function telegram($params=null)
    {
        echo file_get_contents("https://t.me/malinime");die();
    }

    // PUBS
    //------------------------------------------
    function pubs($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'main/pubs';
        $var = array();
        $var['css_folder'] = 'main/pubs';

        $_COOKIE[SESSION]['request_pubs'] = ($_COOKIE[SESSION]['request_pubs'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_pubs'] ?? 1 ;

        $var['title'] = LANG[''] ?? "Espace publicitaire";

        $var['page'] = "EMBED";

        if(!empty($_POST)){
            
            if(!empty($_POST['BRAND_NAME']) && !empty($_POST['BRAND_SLOGAN'] && !empty($_POST['BRAND_PUB_TIME'])) && !empty($_FILES['BRAND_ICON']) && !empty($_FILES['BRAND_PUB_ICON']) )
            {
                $t['BRAND_NAME'] = htmlspecialchars( strip_tags( $_POST['BRAND_NAME'] ?? "" ) );
                $t['BRAND_SLOGAN'] = htmlspecialchars( strip_tags( $_POST['BRAND_SLOGAN'] ?? "" ) ); 
                $t['BRAND_PUB_TIME'] = htmlspecialchars( strip_tags( $_POST['BRAND_PUB_TIME'] ?? "" ) );
                $t['BRAND_SITE'] = htmlspecialchars( strip_tags( $_POST['BRAND_SITE'] ?? "" ) );
                $t['BRAND_CONTACT'] = htmlspecialchars( strip_tags( $_POST['BRAND_CONTACT'] ?? "" ) );

                if($MODEL->add_pubs($t)){
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG['THANKS'] ?? "Nous avons bien réçus. Merci pour votre contribution !" ).' !' ];$this->save();
                    header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));
                    exit();
                }
                else{
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie" ).' !' ];$this->save();
                    header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));
                }

            }
            else{
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG[''] ?? "Veuillez remplir les champs réquis !").' !' ];$this->save();
                header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));
            }
        }

        $this->render($view,$var);
    }

    // MAIN
    //------------------------------------------
    function main($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'main/index';
        $var = array();

        $_COOKIE[SESSION]['request_main'] = ($_COOKIE[SESSION]['request_main'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_main'] ?? 1 ;

        if( !empty($_REQUEST['v']) && $_REQUEST['v'] == 'vf' )
        {
            $ANIMES = $MODEL->get_anime(" WHERE VERSIONS = 'VF' ".(!empty($_REQUEST['sp']) && $_REQUEST['sp'] == 'true' ? "&& SPECIAL = 'true'" :  "")." ORDER BY LAST_UPDATE DESC");
        }
        else if( !empty($_REQUEST['v']) && $_REQUEST['v'] == 'vostfr' )
        {
            $ANIMES = $MODEL->get_anime(" WHERE VERSIONS = 'VOSTFR' ".(!empty($_REQUEST['sp']) && $_REQUEST['sp'] == 'true' ? "&& SPECIAL = 'true'" :  "")." ORDER BY LAST_UPDATE DESC");
        }
        else
        $ANIMES = $MODEL->get_anime((!empty($_REQUEST['sp']) && $_REQUEST['sp'] == 'true' ? "WHERE SPECIAL = 'true'" :  "")." ORDER BY LAST_UPDATE DESC");

        $var['ALL'] = $ANIMES;
        
        $var['ANIMES'] = $ANIMES;

        // if(empty($var['ANIMES'])) $var['ANIMES'] = $ANIMES;


        // if(empty($_REQUEST['p']))
        // $var['LAST_ANIMES']=null;
        $var['VIDEOS'] = $MODEL->get_video(" ORDER BY EPISODE DESC");

        $var['LIMIT'] = 24;
        $var['PAGE_SIZE'] = !empty($var['ANIMES']) ? ( count($var['ANIMES']) - $var['LIMIT'] <= 0 ? 1 : ceil(count($var['ANIMES']) / $var['LIMIT']) ) : 1; ;
        $var['PAGE_INDEX'] = $_REQUEST['p'] ?? 1;
        $var['PAGE_INDEX'] = $var['PAGE_INDEX'] > $var['PAGE_SIZE'] ? 1 : $var['PAGE_INDEX'];

        if($var['PAGE_INDEX'] > 1)
        {
            $var['ANIMES'] = array_slice($var['ANIMES'], $var['LIMIT'] * ($var['PAGE_INDEX'] -1 )) ;
        }

        $var['PUBS'] = $MODEL->get_all_pubs();

        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Coque-Anime-iPhone-Cartoon-Promax/dp/B09KHGF8CS?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=21QVF0Q1JHK9&keywords=one%2Bpiece%2Bgear%2B4&qid=1670079072&sprefix=one%2Bpiece%2Bgear%2B%2Caps%2C213&sr=8-23&th=1&linkCode=li2&tag=malinime-21&linkId=764a63ad9c2510c9841326477a7422ea&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09KHGF8CS&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09KHGF8CS" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Punch-Saison-2-Coffret-%C3%89dition-Collector/dp/B08CM666XK?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=1LQTXXZNVXI88&keywords=one+punch+man&qid=1670078997&sprefix=one+punch+man%2Caps%2C175&sr=8-39&linkCode=li2&tag=malinime-21&linkId=127dc7d7b25c7d47acddf3cee08825bc&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08CM666XK&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08CM666XK" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Figurine-Figure-Action-Version-engrenage/dp/B0B14W9CZ8?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=375771d6894ba1d35a74166f88178cca&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B0B14W9CZ8&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B0B14W9CZ8" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/FREEGUN-Calecon-Microfibre-Marron-Turquoise/dp/B099X7C9D1?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=70736655a9bd2ffb58555b5bc2decdc3&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B099X7C9D1&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B099X7C9D1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/ABYstyle-ONE-PIECE-Lampe-Skull/dp/B08Z3TJHVS?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=087e3599efdd50945e261b998b048581&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08Z3TJHVS&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08Z3TJHVS" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Akatsuki-Costume-Bandeau-Collier-adultes/dp/B097RJFQT2?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-8&linkCode=li2&tag=malinime-21&linkId=2c0b3ce156a5c170264518ac408a863d&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B097RJFQT2&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B097RJFQT2" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Masque-Akatsuki-Cosplay-Halloween-Costume/dp/B09XXJBG76?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-9&linkCode=li2&tag=malinime-21&linkId=4a7a3aea7c4b144c35e6f83926fcebeb&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09XXJBG76&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09XXJBG76" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Hiraith-Accessoire-Accessoires-Akatsuki-Plastique/dp/B09NW3PZ5Q?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-22&linkCode=li2&tag=malinime-21&linkId=4314db60e0b99c559611d8d9c79d1268&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09NW3PZ5Q&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09NW3PZ5Q" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/AOGD-D%C3%A9guisement-Halloween-V%C3%AAtements-Accessoires/dp/B09MRXGD67?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-21&th=1&linkCode=li2&tag=malinime-21&linkId=f200d7c8b826d1e444bf8bfe4fc0ede9&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09MRXGD67&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09MRXGD67" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';

        $this->render($view,$var);
    }

    // ANIME
    //------------------------------------------
    function search($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'main/search';
        $var = array();

        $_COOKIE[SESSION]['request_search'] = ($_COOKIE[SESSION]['request_search'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_search'] ?? 1 ;
        $var['css_folder'] = 'main/search';
        // $var['js_folder'] = 'main/search';

        if(!empty($_REQUEST['q']))
        $_COOKIE[SESSION]['SEARCH'] = $_REQUEST['q'] ?? "";

        $var['WORD'] = $word = str_replace('+',' ', str_replace('-',' ', $_REQUEST['q'] ?? $_COOKIE[SESSION]['SEARCH'] ?? "" ) );
        $var['title'] = (LANG['SEARCH'] ?? "Recherche").' - '.$var['WORD'];
        $var['description'] = (LANG['EMPTY_SEARCH_DESC'] ?? "Rechercher tous vos animes préféré en un seul click ... ");
        
        $ANIMES = $MODEL->get_anime("");

        if(!empty($word))
        {
            $word = strtolower( htmlspecialchars( strip_tags( $word ) ) );

            $WA = explode(' ',$word);

            foreach($WA as $w) 
            {

                foreach($ANIMES as $A)
                {
                    // $name = explode(' ',$A['FULL_NAME']);
                    // foreach($name as $n)
                    // {
                    if( str_contains( strtolower( $A['FULL_NAME'] ),$w) || str_contains( strtolower( $A['GENRE'] ),$w) || str_contains( strtolower($A['STUDIO'] ),$w) || str_contains( strtolower($A['VERSIONS'] ),$w) || str_contains( strtolower($A['SYNOPSIS'] ),$w) || str_contains( strtolower($A['ROMANJI'] ),$w) )
                    {
                        $test = false;
                        if(!empty($var['ANIMES'])){ foreach($var['ANIMES'] as $a){ if($a['ID'] == $A['ID']){ $test = true;break;} } }
                        if($test == false)
                        $var['ANIMES'][] = $A;
                    }
                }
            }


        }

        // if(empty($var['ANIMES'])) $var['ANIMES'] = $ANIMES;

        $var['VIDEOS'] = $MODEL->get_video("");

        $var['LIMIT'] = 24;
        $var['PAGE_SIZE'] = !empty($var['ANIMES']) ? ( count($var['ANIMES']) - $var['LIMIT'] <= 0 ? 1 : ceil(count($var['ANIMES']) / $var['LIMIT']) ) : 1; ;
        $var['PAGE_INDEX'] = $_REQUEST['p'] ?? 1;
        $var['PAGE_INDEX'] = $var['PAGE_INDEX'] > $var['PAGE_SIZE'] ? 1 : $var['PAGE_INDEX'];

        if($var['PAGE_INDEX'] > 1)
        {
            $var['ANIMES'] = array_slice($var['ANIMES'], $var['LIMIT'] * ($var['PAGE_INDEX'] -1 )) ;
        }

        
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/OLIPHEE-Amoureux-Japonais-Sweater-Diff%C3%A9rents/dp/B08V4TXMTD?pd_rd_w=WnhwH&content-id=amzn1.sym.404dde96-e3b5-4d3b-8534-4a1e05315731&pf_rd_p=404dde96-e3b5-4d3b-8534-4a1e05315731&pf_rd_r=AM4BH16EWED1CTVXMCX9&pd_rd_wg=nIxJg&pd_rd_r=966bd94a-1e2d-44f4-a5f1-58eae95e3217&pd_rd_i=B091GQY9GN&psc=1&linkCode=li2&tag=malinime-21&linkId=ab0070f0f6f02a6659d3fc5ce9fd2281&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08V4TXMTD&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08V4TXMTD" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/xiemushop-Capuche-Akatsuki-Decontracte-Sweat-Shirt/dp/B07WHY6LDX?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-32&linkCode=li2&tag=malinime-21&linkId=594ae4ebfb3a139d4833057aeacb574b&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B07WHY6LDX&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B07WHY6LDX" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Coque-Anime-iPhone-Cartoon-Promax/dp/B09KHGF8CS?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=21QVF0Q1JHK9&keywords=one%2Bpiece%2Bgear%2B4&qid=1670079072&sprefix=one%2Bpiece%2Bgear%2B%2Caps%2C213&sr=8-23&th=1&linkCode=li2&tag=malinime-21&linkId=764a63ad9c2510c9841326477a7422ea&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09KHGF8CS&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09KHGF8CS" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Punch-Saison-2-Coffret-%C3%89dition-Collector/dp/B08CM666XK?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=1LQTXXZNVXI88&keywords=one+punch+man&qid=1670078997&sprefix=one+punch+man%2Caps%2C175&sr=8-39&linkCode=li2&tag=malinime-21&linkId=127dc7d7b25c7d47acddf3cee08825bc&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08CM666XK&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08CM666XK" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Figurine-Figure-Action-Version-engrenage/dp/B0B14W9CZ8?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=375771d6894ba1d35a74166f88178cca&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B0B14W9CZ8&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B0B14W9CZ8" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/FREEGUN-Calecon-Microfibre-Marron-Turquoise/dp/B099X7C9D1?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=70736655a9bd2ffb58555b5bc2decdc3&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B099X7C9D1&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B099X7C9D1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/ABYstyle-ONE-PIECE-Lampe-Skull/dp/B08Z3TJHVS?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=087e3599efdd50945e261b998b048581&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08Z3TJHVS&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08Z3TJHVS" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Akatsuki-Costume-Bandeau-Collier-adultes/dp/B097RJFQT2?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-8&linkCode=li2&tag=malinime-21&linkId=2c0b3ce156a5c170264518ac408a863d&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B097RJFQT2&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B097RJFQT2" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Masque-Akatsuki-Cosplay-Halloween-Costume/dp/B09XXJBG76?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-9&linkCode=li2&tag=malinime-21&linkId=4a7a3aea7c4b144c35e6f83926fcebeb&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09XXJBG76&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09XXJBG76" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Hiraith-Accessoire-Accessoires-Akatsuki-Plastique/dp/B09NW3PZ5Q?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-22&linkCode=li2&tag=malinime-21&linkId=4314db60e0b99c559611d8d9c79d1268&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09NW3PZ5Q&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09NW3PZ5Q" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/AOGD-D%C3%A9guisement-Halloween-V%C3%AAtements-Accessoires/dp/B09MRXGD67?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-21&th=1&linkCode=li2&tag=malinime-21&linkId=f200d7c8b826d1e444bf8bfe4fc0ede9&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09MRXGD67&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09MRXGD67" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';


        $this->render($view,$var);
    }

    // ANIME
    //------------------------------------------
    function anime($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'main/anime';
        $var = array();

        $_COOKIE[SESSION]['request_anime'] = ($_COOKIE[SESSION]['request_anime'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_anime'] ?? 1 ;
        $var['css_folder'] = 'main/anime';
        // $var['js_folder'] = 'main/anime';


        if(!empty($params[0]))
        {
            $id = htmlspecialchars( strip_tags( $params[0] ) );
            $var['ANIME'] = $MODEL->get_anime(" WHERE ID = '$id' OR LINK = '$id' ",true) ;
            // $var['ANIME'] = ['POSTER'=>"one.jpg",'SYNOPSIS'=>'ddasd asdsa dasd sadas dadads ','ORIGINAL_NAME'=>'Shiejs jsieea','STATUS'=>'0','STUDIO'=>'MAPPA','TRAILER'=>'https://youtube.com','OUT_DATE'=>'12/12/2022','GENRE'=>'Slice of life',"FULL_NAME"=>"One piece ",'ID'=>'1','LAST_UPDATE'=>$ROOT->actual_datetime(),'SPECIAL'=>true,'VERSIONS'=>"VF"];

            if(!empty($var['ANIME']) )
            {
                $id = $var['ANIME']['ID'];
                $var['title'] = str_replace("<ap>","'", $var['ANIME']['FULL_NAME']) ;//. ' - '. SITE_NAME;
                $var['VIDEO'] = $MODEL->get_video(" WHERE ANIME_ID = '$id' ORDER BY EPISODE DESC ");
                $var['COMMENTS'] = $MODEL->get_comment("WHERE ANIME_ID = '$id' ");
                $var['description'] = $var['ANIME']['SYNOPSIS_'.LANG_SYSTEM] ?? ( (LANG['LOOK'] ?? "Regarder").' '.$var['title'].' '.(LANG['FOR_FREE'] ?? "gratuitement") ) ;
                $var['PERSO'] = $MODEL->get_characters("WHERE ANIME_ID = '$id' ORDER BY SPECIAL DESC ");

                // $var['COMMENTS'][] = ['FULL_NAME'=>'Adama','COUNTRY'=>'MA','GENRE'=>'0','MESSAGES'=>"J'aime cet anime",'DATETIMES'=>$ROOT->actual_datetime(),'SPECIAL'=>'true'];
                // $var['COMMENTS'][] = ['FULL_NAME'=>'Adama','COUNTRY'=>'MA','GENRE'=>'1','MESSAGES'=>"J'aime cet anime",'DATETIMES'=>$ROOT->actual_datetime(),'SPECIAL'=>'true'];
                // $var['COMMENTS'][] = ['FULL_NAME'=>'Adama','COUNTRY'=>'MA','GENRE'=>'1','MESSAGES'=>"J'aime cet anime",'DATETIMES'=>$ROOT->actual_datetime(),'SPECIAL'=>'true'];

                // $var['VIDEO'][] = ['ID'=>'1','EPISODE'=>'01','ANIME_ID'=>'1','ANIME_NAME'=>'One piece','PUBLISH_DATETIME'=>$ROOT->actual_datetime(),'PUBLISH_DATE'=>$ROOT->actual_date(),"ANIME_VERSION"=>"VF"];
                // $var['VIDEO'][] = ['ID'=>'1','EPISODE'=>'02','ANIME_ID'=>'1','ANIME_NAME'=>'One piece','PUBLISH_DATETIME'=>$ROOT->actual_datetime(),'PUBLISH_DATE'=>'12/12/12/12/2022',"ANIME_VERSION"=>"VF"];
                // $var['VIDEO'][] = ['ID'=>'2','EPISODE'=>'02','ANIME_ID'=>'2','ANIME_NAME'=>'One piece','PUBLISH_DATETIME'=>$ROOT->actual_datetime(),'PUBLISH_DATE'=>$ROOT->actual_date(),"ANIME_VERSION"=>"VF"];
                // $var['VIDEO'][] = ['ID'=>'3','EPISODE'=>'03','ANIME_ID'=>'3','ANIME_NAME'=>'One piece','PUBLISH_DATETIME'=>$ROOT->actual_datetime(),'PUBLISH_DATE'=>$ROOT->actual_date(),"ANIME_VERSION"=>"VF"];
                // $var['VIDEO'][] = ['ID'=>'4','EPISODE'=>'04','ANIME_ID'=>'4','ANIME_NAME'=>'One piece','PUBLISH_DATETIME'=>$ROOT->actual_datetime(),'PUBLISH_DATE'=>$ROOT->actual_date(),"ANIME_VERSION"=>"VF"];
                // $var['VIDEO'][] = ['ID'=>'5','EPISODE'=>'05','ANIME_ID'=>'5','ANIME_NAME'=>'One piece','PUBLISH_DATETIME'=>$ROOT->actual_datetime(),'PUBLISH_DATE'=>$ROOT->actual_date(),"ANIME_VERSION"=>"VF"];
                // $var['VIDEO'][] = ['ID'=>'6','EPISODE'=>'06','ANIME_ID'=>'6','ANIME_NAME'=>'One piece','PUBLISH_DATETIME'=>$ROOT->actual_datetime(),'PUBLISH_DATE'=>$ROOT->actual_date(),"ANIME_VERSION"=>"VF"];
            }
            else
            {
                header("Location: ". $this->link('MAIN'));exit();
            }
        }
        else
        {
            header("Location: ". $this->link('MAIN'));exit();
        }


        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/OLIPHEE-Amoureux-Japonais-Sweater-Diff%C3%A9rents/dp/B08V4TXMTD?pd_rd_w=WnhwH&content-id=amzn1.sym.404dde96-e3b5-4d3b-8534-4a1e05315731&pf_rd_p=404dde96-e3b5-4d3b-8534-4a1e05315731&pf_rd_r=AM4BH16EWED1CTVXMCX9&pd_rd_wg=nIxJg&pd_rd_r=966bd94a-1e2d-44f4-a5f1-58eae95e3217&pd_rd_i=B091GQY9GN&psc=1&linkCode=li2&tag=malinime-21&linkId=ab0070f0f6f02a6659d3fc5ce9fd2281&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08V4TXMTD&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08V4TXMTD" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/xiemushop-Capuche-Akatsuki-Decontracte-Sweat-Shirt/dp/B07WHY6LDX?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-32&linkCode=li2&tag=malinime-21&linkId=594ae4ebfb3a139d4833057aeacb574b&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B07WHY6LDX&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B07WHY6LDX" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Coque-Anime-iPhone-Cartoon-Promax/dp/B09KHGF8CS?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=21QVF0Q1JHK9&keywords=one%2Bpiece%2Bgear%2B4&qid=1670079072&sprefix=one%2Bpiece%2Bgear%2B%2Caps%2C213&sr=8-23&th=1&linkCode=li2&tag=malinime-21&linkId=764a63ad9c2510c9841326477a7422ea&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09KHGF8CS&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09KHGF8CS" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Punch-Saison-2-Coffret-%C3%89dition-Collector/dp/B08CM666XK?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=1LQTXXZNVXI88&keywords=one+punch+man&qid=1670078997&sprefix=one+punch+man%2Caps%2C175&sr=8-39&linkCode=li2&tag=malinime-21&linkId=127dc7d7b25c7d47acddf3cee08825bc&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08CM666XK&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08CM666XK" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Figurine-Figure-Action-Version-engrenage/dp/B0B14W9CZ8?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=375771d6894ba1d35a74166f88178cca&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B0B14W9CZ8&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B0B14W9CZ8" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/FREEGUN-Calecon-Microfibre-Marron-Turquoise/dp/B099X7C9D1?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=70736655a9bd2ffb58555b5bc2decdc3&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B099X7C9D1&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B099X7C9D1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/ABYstyle-ONE-PIECE-Lampe-Skull/dp/B08Z3TJHVS?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=087e3599efdd50945e261b998b048581&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08Z3TJHVS&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08Z3TJHVS" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Akatsuki-Costume-Bandeau-Collier-adultes/dp/B097RJFQT2?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-8&linkCode=li2&tag=malinime-21&linkId=2c0b3ce156a5c170264518ac408a863d&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B097RJFQT2&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B097RJFQT2" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Masque-Akatsuki-Cosplay-Halloween-Costume/dp/B09XXJBG76?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-9&linkCode=li2&tag=malinime-21&linkId=4a7a3aea7c4b144c35e6f83926fcebeb&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09XXJBG76&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09XXJBG76" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Hiraith-Accessoire-Accessoires-Akatsuki-Plastique/dp/B09NW3PZ5Q?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-22&linkCode=li2&tag=malinime-21&linkId=4314db60e0b99c559611d8d9c79d1268&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09NW3PZ5Q&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09NW3PZ5Q" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/AOGD-D%C3%A9guisement-Halloween-V%C3%AAtements-Accessoires/dp/B09MRXGD67?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-21&th=1&linkCode=li2&tag=malinime-21&linkId=f200d7c8b826d1e444bf8bfe4fc0ede9&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09MRXGD67&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09MRXGD67" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';


        $this->render($view,$var);
    }

    // WATCH
    //------------------------------------------
    function watch($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'main/watch';
        $var = array();

        $_COOKIE[SESSION]['request_watch'] = ($_COOKIE[SESSION]['request_watch'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_watch'] ?? 1 ;
        $var['css_folder'] = 'main/watch';
        $var['page'] = 'WATCH';
        // $var['js_folder'] = 'main/watch';


        if(!empty($params[0]))
        {

            $id = htmlspecialchars( strip_tags( $params[0] ) );
            $var['VIDEO'] = $MODEL->get_video( " WHERE ID = '$id' OR LINK = '$id' ");

            // $var['VIDEO'] = ['ID'=>'1222','EPISODE'=>'02','ANIME_NAME'=>"One piece",'ANIME_ID'=>'5','DESCRIP'=>'asdsa asd','TYPES'=>'video/mp4','LOCATIONS'=>'kulosa.mp4','ANIME_VERSION'=>'VOSTFR','PUBLISH_DATETIME'=>$ROOT->actual_datetime()];

            if(!empty($var['VIDEO'])){

            $var['VIDEO'] = $MODEL->get_video( " WHERE ID = '$id' OR LINK = '$id' " ,true);
            
            $aid = $var['VIDEO']['ANIME_ID'];
            $anime = $MODEL->get_anime( " WHERE ID = '$aid' " ,true);
            $var['VIDEO']['ANIME_NAME'] = $anime['FULL_NAME'];
            $var['ANIME'] = $anime;

            if($var['VIDEO']['SOURCE_LINK']){
            $size = count( explode('|',$var['VIDEO']['SOURCE_LINK']) ) ;
            $var['SELECTED_SOURCE'] = !empty($params[1]) && is_numeric($params[1]) && $params[1] <= $size ? abs($params[1] -1) : $_REQUEST['s'] ??  0;
            }

            $var['title'] = ($var['VIDEO']['ANIME_NAME'] ?? "").' - '.($var['VIDEO']['EPISODE'] < 10 ? '0'.$var['VIDEO']['EPISODE'] : $var['VIDEO']['EPISODE']).' - '.($var['VIDEO']['ANIME_VERSION']) ;//. ' - '. SITE_NAME;
            $var['description'] = (LANG['LOOK'] ?? "Regarder").' '.$var['title'].' '.(LANG['FOR_FREE'] ?? "gratuitement");

            $anime_id = $var['VIDEO']['ANIME_ID'];
            $var['ALL_VIDEO'] = $MODEL->get_video(" WHERE ANIME_ID = '$anime_id' ORDER BY EPISODE ");

            // $MODEL->add_views($id,$aid);



            if(!empty($_POST['MESSAGES']) && !empty($_POST['NAME']) && !empty($_POST['COUNTRY']) )
            {
                $t['VIDEO_ID'] = $var['VIDEO']['ID'];
                $t['ANIME_ID'] = $var['VIDEO']['ANIME_ID'];
                $t['MESSAGES'] = htmlspecialchars( strip_tags( $_POST['MESSAGES'] ) );
                $t['NAME'] = htmlspecialchars( strip_tags( $_POST['NAME'] ) );
                $t['COUNTRY'] = htmlspecialchars( strip_tags( $_POST['COUNTRY'] ) );
                $t['GENRE'] = htmlspecialchars( strip_tags( $_POST['GENRE'] ?? '0' ) );
                $t['SPECIAL'] = htmlspecialchars( strip_tags( $_POST['SPECIAL'] ?? 'false' ) ) ;

                if($MODEL->add_comment($t))
                {
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG['YOU_COMMENT_JUST'] ?? "Vous venez juste de commenter cet épisode" ).' !' ];$this->save();
                }
                else
                {
                    $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie").' !' ];$this->save();
                }

                header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));exit();
            }

            $id = $var['VIDEO']['ID'];
            $var['COMMENTS'] = $MODEL->get_comment("WHERE VIDEO_ID = '$id' ORDER BY SPECIAL ASC ");
            // $var['COMMENTS'][] = ['FULL_NAME'=>'Adama','COUNTRY'=>'MA','GENRE'=>'0','MESSAGES'=>"J'aime cet anime",'DATETIMES'=>$ROOT->actual_datetime(),'SPECIAL'=>'true'];

            }

        }


    
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Vocha-V%C3%AAtements-Narutos-Capuche-Akatsuki/dp/B09FLHL7DN?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-28&linkCode=li2&tag=malinime-21&linkId=8ae0a8c69eca39ede8fd0dfe80282eb4&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09FLHL7DN&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09FLHL7DN" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/OLIPHEE-Amoureux-Japonais-Sweater-Diff%C3%A9rents/dp/B08V4TXMTD?pd_rd_w=WnhwH&content-id=amzn1.sym.404dde96-e3b5-4d3b-8534-4a1e05315731&pf_rd_p=404dde96-e3b5-4d3b-8534-4a1e05315731&pf_rd_r=AM4BH16EWED1CTVXMCX9&pd_rd_wg=nIxJg&pd_rd_r=966bd94a-1e2d-44f4-a5f1-58eae95e3217&pd_rd_i=B091GQY9GN&psc=1&linkCode=li2&tag=malinime-21&linkId=ab0070f0f6f02a6659d3fc5ce9fd2281&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08V4TXMTD&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08V4TXMTD" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/xiemushop-Capuche-Akatsuki-Decontracte-Sweat-Shirt/dp/B07WHY6LDX?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-32&linkCode=li2&tag=malinime-21&linkId=594ae4ebfb3a139d4833057aeacb574b&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B07WHY6LDX&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B07WHY6LDX" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Coque-Anime-iPhone-Cartoon-Promax/dp/B09KHGF8CS?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=21QVF0Q1JHK9&keywords=one%2Bpiece%2Bgear%2B4&qid=1670079072&sprefix=one%2Bpiece%2Bgear%2B%2Caps%2C213&sr=8-23&th=1&linkCode=li2&tag=malinime-21&linkId=764a63ad9c2510c9841326477a7422ea&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09KHGF8CS&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09KHGF8CS" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Punch-Saison-2-Coffret-%C3%89dition-Collector/dp/B08CM666XK?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=1LQTXXZNVXI88&keywords=one+punch+man&qid=1670078997&sprefix=one+punch+man%2Caps%2C175&sr=8-39&linkCode=li2&tag=malinime-21&linkId=127dc7d7b25c7d47acddf3cee08825bc&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08CM666XK&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08CM666XK" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Figurine-Figure-Action-Version-engrenage/dp/B0B14W9CZ8?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=375771d6894ba1d35a74166f88178cca&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B0B14W9CZ8&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B0B14W9CZ8" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/FREEGUN-Calecon-Microfibre-Marron-Turquoise/dp/B099X7C9D1?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=70736655a9bd2ffb58555b5bc2decdc3&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B099X7C9D1&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B099X7C9D1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/ABYstyle-ONE-PIECE-Lampe-Skull/dp/B08Z3TJHVS?_encoding=UTF8&pd_rd_w=Q8FJv&content-id=amzn1.sym.d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_p=d01040f0-2953-47b0-8f72-922a5679b397&pf_rd_r=9D9M3KPPW2AYPNDTC18H&pd_rd_wg=sBgPG&pd_rd_r=511f0db7-a216-4d66-b68e-1d87a7b0faf4&linkCode=li2&tag=malinime-21&linkId=087e3599efdd50945e261b998b048581&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B08Z3TJHVS&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B08Z3TJHVS" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Akatsuki-Costume-Bandeau-Collier-adultes/dp/B097RJFQT2?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-8&linkCode=li2&tag=malinime-21&linkId=2c0b3ce156a5c170264518ac408a863d&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B097RJFQT2&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B097RJFQT2" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Masque-Akatsuki-Cosplay-Halloween-Costume/dp/B09XXJBG76?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-9&linkCode=li2&tag=malinime-21&linkId=4a7a3aea7c4b144c35e6f83926fcebeb&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09XXJBG76&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09XXJBG76" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/Hiraith-Accessoire-Accessoires-Akatsuki-Plastique/dp/B09NW3PZ5Q?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-22&linkCode=li2&tag=malinime-21&linkId=4314db60e0b99c559611d8d9c79d1268&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09NW3PZ5Q&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09NW3PZ5Q" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
        $var['PUBS_EXT'][] = '<a href="https://www.amazon.fr/AOGD-D%C3%A9guisement-Halloween-V%C3%AAtements-Accessoires/dp/B09MRXGD67?__mk_fr_FR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=TQQNBSQF6V0L&keywords=akatsuki&qid=1670079256&sprefix=akatsuki%2Caps%2C210&sr=8-21&th=1&linkCode=li2&tag=malinime-21&linkId=f200d7c8b826d1e444bf8bfe4fc0ede9&language=fr_FR&ref_=as_li_ss_il" target="_blank"><img border="0" src="//ws-eu.amazon-adsystem.com/widgets/q?_encoding=UTF8&ASIN=B09MRXGD67&Format=_SL160_&ID=AsinImage&MarketPlace=FR&ServiceVersion=20070822&WS=1&tag=malinime-21&language=fr_FR" ></a><img src="https://ir-fr.amazon-adsystem.com/e/ir?t=malinime-21&language=fr_FR&l=li2&o=8&a=B09MRXGD67" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';


        $this->render($view,$var);
    }

    // EMBED
    //------------------------------------------
    function embed($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'main/embed';
        $var = array();
        $var['robots'] = 'noindex,nofollow';

        $_COOKIE[SESSION]['request_embed'] = ($_COOKIE[SESSION]['request_embed'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_embed'] ?? 1 ;
        $var['css_folder'] = 'main/embed';
        $var['js_folder'] = 'main/embed';
        $var['page'] = 'EMBED';

        $var['currentTime'] = $_COOKIE[SESSION]['VIDEO_CURRENT_TIME'] ?? null;
        $_COOKIE[SESSION]['VIDEO_CURRENT_TIME'] = "";
        $this->save();

        // $subtitle = array();
        $subtitle[] =['time'=>'2','text'=> ( LANG['PUT_FULL_SCREEN'] ?? "appuyer la touche ' f ' pour le plein écran " )." !"];
        $subtitle[] =['time'=>'7','text'=> ( LANG['PUT_SETTING'] ?? "appuyer la touche ' s ' pour les paramètres " )." !"];
        $id = htmlspecialchars( strip_tags( $params[0] ) );

        if(!empty($params[0]))
        {

            $var['VIDEO'] = $MODEL->get_video( " WHERE ID = '$id' OR LINK = '$id' ");
            if(!empty($var['VIDEO'])){

            $var['VIDEO'] = $MODEL->get_video( " WHERE ID = '$id' OR LINK = '$id' " ,true);
            $aid = $var['VIDEO']['ANIME_ID'];
            $anime = $MODEL->get_anime( " WHERE ID = '$aid' " ,true);
            $var['VIDEO']['ANIME_NAME'] = $anime['FULL_NAME'];
            $var['VIDEO']['ANIME_POSTER'] = $anime['POSTER'] ?? "";
            $var['title'] = ($var['VIDEO']['ANIME_NAME'] ?? "").' - '.($var['VIDEO']['EPISODE'] < 10 ? '0'.$var['VIDEO']['EPISODE'] : $var['VIDEO']['EPISODE']).' - '.($var['VIDEO']['ANIME_VERSION']) ;//. ' - '. SITE_NAME;
            $var['description'] = (LANG['LOOK'] ?? "Regarder").' '.$var['title'].' '.(LANG['FOR_FREE'] ?? "gratuitement");

            if($var['VIDEO']['SOURCE_LINK']){
                $size = count( explode('|',$var['VIDEO']['SOURCE_LINK']) ) ;
                $var['SELECTED_SOURCE'] = !empty($params[1]) && is_numeric($params[1]) && $params[1] <= $size ? abs($params[1] -1) : $_REQUEST['s'] ??  0;
            }

            $MODEL->add_views($id,$aid);

            if(!empty($_POST['PASSWORD']) && $_POST['PASSWORD'] == "malinime+18" ){
                $var['password_state'] = 'true';
            }
            else if(!empty($_POST['PASSWORD']) ){
                $var['try'] = 'false';
            }


            }

            // if(empty($var['VIDEO']))
            // {
            //     header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));exit();
            // }
        }
        else
        {
            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));exit();
        }


        $this->render($view,$var);
    }

    // DARK MODE
    //------------------------------------------
    function mode($params=null)
    {
        if( empty($_COOKIE[SESSION]['DARK_MODE_SETTED']) && !empty($params[0]) && is_numeric($params[0]) )
        {
            // if( ($params[0] >= 20 && $params[0] <= 23 ) || ($params[0] >=0 && $params[0] < 9) )
            // $_COOKIE[SESSION]['DARK_MODE'] =  'white' ;
            // else
            // $_COOKIE[SESSION]['DARK_MODE'] =  'black' ;

            $_COOKIE[SESSION]['DARK_MODE'] =  'black' ;

            $_COOKIE[SESSION]['DARK_MODE_SETTED'] = 'true';
        }
        else{

            $_COOKIE[SESSION]['DARK_MODE'] =  $_COOKIE[SESSION]['DARK_MODE'] == 'black' ? 'white' : 'black' ; 
            $_COOKIE[SESSION]['DARK_MODE_SETTED'] = 'true';

        }

        if( !empty($_GET['vid']) && is_numeric($_GET['vid'])){
        $_COOKIE[SESSION]['VIDEO_CURRENT_TIME'] = $_GET['vid'] ?? "";
        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG['RESTART_THERE'] ?? "Votre vidéo va continuer "). " ✅ "];
        }
        else{
        $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG['MODE_CHANGED'] ?? "Mode changé"). " ✅"];
        }

        $this->save();

        header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));
    }



    // TERMS
    //------------------------------------------
    function terms($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'main/terms';
        $var = array();
        $var['robots'] = 'noindex,nofollow';

        $_COOKIE[SESSION]['request_terms'] = ($_COOKIE[SESSION]['request_terms'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_terms'] ?? 1 ;
        $var['css_folder'] = 'main/terms';
        $var['title'] = (LANG['TERMS'] ?? "Conditions d'utilisation"). ' - '. SITE_NAME;


        $this->render($view,$var);   
    }

    // PRIVACY
    //------------------------------------------
    function privacy($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'main/privacy';

        $var = array();
        $var['robots'] = 'noindex,nofollow';

        $_COOKIE[SESSION]['request_privacy'] = ($_COOKIE[SESSION]['request_privacy'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_privacy'] ?? 1 ;
        $var['css_folder'] = 'main/privacy';
        $var['title'] = (LANG['PRIVACY'] ?? "Confidentialités"). ' - '. SITE_NAME;
        

        $this->render($view,$var);   
    }

    // CONTACT
    //------------------------------------------
    function contact($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Main;
        $view = 'main/contact';
        $var = array();
        $var['robots'] = 'noindex,nofollow';
 
        $_COOKIE[SESSION]['request_contact'] = ($_COOKIE[SESSION]['request_contact'] ?? 0) + 1;$this->save();

        if(!empty($_POST['FULL_NAME']) && !empty($_POST['MOTIF']) && !empty($_POST['MESSAGES']))
        {
            $t['FULL_NAME'] = htmlspecialchars( strip_tags( $_POST['FULL_NAME'] ) );
            $t['MOTIF'] = htmlspecialchars( strip_tags( $_POST['MOTIF'] ) );
            $t['MESSAGES'] = htmlspecialchars( strip_tags( $_POST['MESSAGES'] ) );

            if($MODEL->add_contact($t))
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'good','msg'=> (LANG['THANKS'] ?? "Nous avons bien réçus. Merci pour votre contribution " ).' !' ];$this->save();
            }
            else
            {
                $_COOKIE[SESSION]['GLOBAL_NOTIF'][] = ['class'=>'bad','msg'=> (LANG['ERROR_SEND'] ?? "Erreur d'envoie" ).' !' ];$this->save();
            }
            
            header("Location: ".$_SERVER['HTTP_REFERER'] ?? $this->link('MAIN'));die();
        }

        $var['request_time'] = $_COOKIE[SESSION]['request_contact'] ?? 1 ;
        $var['css_folder'] = 'main/contact';
        $var['title'] = (LANG['CONTACT_US'] ?? "Contactez-nous"). ' - '. SITE_NAME;
        

        $this->render($view,$var);   
    }

}