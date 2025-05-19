<?

class User
{

    public static function signup($username, $email, $password, $confirm_password)
    {

        $connection = Database::getConnection();

        if ($password == $confirm_password) {
        }
    }
}
