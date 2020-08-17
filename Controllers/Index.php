<?php

    class Index extends Controller{

        public static function test(){
            echo "blablabla";
            $user = self::$db->executeQuery("test",[""]);
            echo $user[0]["Id_User"]." hahaha";
            // phpinfo();
        }
    }
