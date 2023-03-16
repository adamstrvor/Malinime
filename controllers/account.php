<?php

//******************************************
//  MAIN       
//******************************************

$ROOT = new Controller;
$ROOT->load_model('account');

class Account extends Controller
{
    function main($params=null)
    {
        $this->login($params);
        $ROOT = new Controller;
        $MODEL = new _Account;
        $view = 'account/index';
        $var = array();

        $_COOKIE[SESSION]['request_account_main'] = ($_COOKIE[SESSION]['request_account_main'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_account_main'] ?? 1 ;
        $var['css_folder'] = 'account/index';
        $var['title'] = LANG['YOUR_ACCOUNT'] ?? "Votre compte";



        $this->render($view,$var);
    }
    //---------------------------------------
    function login($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Account;
        $view = 'account/login';
        $var = array();

        if(!empty($_COOKIE[COOKIE_CUSTOMER_ID]) && $MODEL->check_user($_COOKIE[COOKIE_CUSTOMER_ID]) )
        {
            return true;
        }

        $_COOKIE[SESSION]['request_account_login'] = ($_COOKIE[SESSION]['request_account_login'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_account_login'] ?? 1 ;
        $var['css_folder'] = 'account/login';
        $var['title'] = LANG['SE_CONNECTER'] ?? "Se connecter";

        if(!empty($_POST['USERNAME']) && !empty($_POST['USER_PASSWORD']))
        {

        }


        $this->render($view,$var);die();
    }
    //---------------------------------------
    function register($params=null)
    {
        $ROOT = new Controller;
        $MODEL = new _Account;
        $view = 'account/register';
        $var = array();

        $_COOKIE[SESSION]['request_account_register'] = ($_COOKIE[SESSION]['request_account_register'] ?? 0) + 1;$this->save();

        $var['request_time'] = $_COOKIE[SESSION]['request_account_register'] ?? 1 ;
        $var['css_folder'] = 'account/register';
        $var['title'] = LANG['CREATE_ACCOUNT'] ?? "Créer mon compte";



        $this->render($view,$var);
    }
}