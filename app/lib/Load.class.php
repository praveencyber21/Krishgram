<?

class Template
{

    public static function load($file)
    {

        include_once __DIR__ . "/../_template/_" . $file . ".php";
    }
}
