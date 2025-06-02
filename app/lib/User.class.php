<?

include_once __DIR__ . "/../lib/Database.class.php";
class User
{

    /**
     * Registers a new user by inserting their username, email, and password
     * into the database.
     * 
     * @param string @username
     * @param string @email
     * @param string @password      Password hashed before storing 
     * @return bool|mysqli_result   Returns the result of the query (success or failure).
     */
    public static function signup($username, $email, $password, $confirm_password)
    {

        $connection = Database::getConnection();

        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            return false;
        }


        $query = "INSERT INTO users (user_name, email, password) VALUES ('$username', '$email', '$hashed_password')";
        $result = $connection->query($query);
        return $result;
    }

    /**
     * Authenticates a user by verifying the username/email and password.
     * 
     * @param string @username
     * @param string @email
     * @param string @password      Password hashed before storing 
     * @return bool|mysqli_result   Returns the result of the query (success or failure).
     */
    public static function login($email, $password)
    {

        $connection = Database::getConnection();

        $query = "SELECT password FROM users WHERE email='$email'";
        $result = $connection->query($query);

        if ($result->num_rows >= 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
