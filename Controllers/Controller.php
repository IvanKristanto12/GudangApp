<?php

class Controller extends Database
{

    public static $db;

    public static function initializeDB(){
        self::$db = new Database();
    }
    
    public static function CreateView($viewName)
    {
        self::initializeDB();
        require_once("./Views/$viewName.php");
    }

    public static function SubmitForm($formHandler){
        self::initializeDB();
        require_once("./Controllers/FormHandler/$formHandler.php");
    }

    public static function CreateHeader()
    {
        echo '

        <div class="w3-container w3-theme-d2" style="width:100%;">
            <h1 style="display:inline">Gudang App</h1>
            <div style="display:inline; float:right" class="w3-center   ">
                <h6 style="display:inline;">'.$_COOKIE["username"].'</h6>
                <form action="authLogin" method="POST">
                <button name="logout" style="display:inline;" class="">Log Out</button>
                </form>
            </div>
        </div>';
    }

    public static function CreateFooter()
    {
        // echo '
        // <div class="w3-container w3-theme-d2  w3-display-bottommiddle" style=" width:100%; height:2%";>
        // </div>';
    }

    protected static function CreateHTML($head,$body){
        echo'
        <!DOCTYPE html>
        <html lang="en">
        '.$head.$body.
        '</html>';
    }

}
