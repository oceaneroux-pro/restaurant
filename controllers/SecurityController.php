<?php

namespace controllers;

class SecurityController
{
    public function is_connect()
    {
        if(isset($_SESSION['client']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function isAdmin()
    {
        if(isset($_SESSION['admin']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }  
    
}