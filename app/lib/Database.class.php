<?
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

class Database
{

    public static $connection = null;


    public static function getConnection()
    {

        if (self::$connection == null) {

            $MYSQL_SERVERNAME = $_ENV["MYSQL_SERVERNAME"];
            $MYSQL_USER = $_ENV["MYSQL_USER"];
            $MYSQL_PASSWORD = $_ENV["MYSQL_PASSWORD"];
            $MYSQL_DATABASE = $_ENV["MYSQL_DATABASE"];


            $connection = new mysqli($MYSQL_SERVERNAME, $MYSQL_USER, $MYSQL_PASSWORD, $MYSQL_DATABASE);

            if ($connection->connect_error) {
                die("Database connection error.");
            } else {
                self::$connection = $connection;
                return self::$connection;
            }
        } else {
            return self::$connection;
        }
    }
}
