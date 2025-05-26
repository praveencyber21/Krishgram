<?

include_once __DIR__ . "/../lib/Database.class.php";
class User
{

    public static function signup($username, $email, $password, $confirm_password)
    {

        $connection = Database::getConnection();

        $password = md5($password);
        $query = "INSERT INTO users (user_name, email, password) VALUES ('$username', '$email', '$password')";
        $result = $connection->query($query);
        return $result;
    }
}
