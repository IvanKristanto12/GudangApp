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
            <h1>Gudang App</h1>
        </div>';
    }

    public static function CreateFooter()
    {
        echo '
        <footer class="w3-container w3-theme-d2 w3-padding w3-display-bottommiddle" style=" width:100%; height:2%";>
        </footer>';
    }

    protected static function CreateHTML($head,$body){
        echo'
        <!DOCTYPE html>
        <html lang="en">
        '.$head.$body.
        '</html>';
    }

}
