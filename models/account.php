<?php

//******************************************
//  ACCOUNT
//******************************************

class _Account extends Model
{
    function check_user($id)
    {
        try
        {
            $ids= $this->select("SELECT * FROM USERS");

            foreach($ids as $i)
            {
                if($i['ID'] == $id) return true;
            }

            return false;

        }
        catch(Exception $e)
        {
            return false;
        }
    }
    //----------------------
    function check_connection($username,$password)
    {
        try
        {
            $ids= $this->select("SELECT * FROM USERS");

            foreach($ids as $i)
            {
                if($i['USERNAME'] == $username && password_verify($password,$i['USER_PASSWORD']) ) return true;
            }

            return false;

        }
        catch(Exception $e)
        {
            return false;
        }
    }
    //----------------------
    function add_user($t)
    {
        try
        {
            $root = new Controller;
            $date = $root->actual_date();
            $time = $root->actual_datetime();
            
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    //----------------------
    function get_user($id)
    {
        try
        {
            return $this->select("SELECT * FROM USERS WHERE ID = '$id'  ")[0] ?? null;

        }
        catch(Exception $e)
        {
            return null;
        }
    }
}