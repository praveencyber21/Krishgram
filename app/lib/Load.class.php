<?
include_once __DIR__ . "/User.class.php";
include_once __DIR__ . "/UserSession.class.php";
include_once __DIR__ . "/MagicMethods.class.php";

session_start();
class Template
{

    public static function load($file)
    {

        include_once __DIR__ . "/../_template/_" . $file . ".php";
    }
}
