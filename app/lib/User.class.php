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

    public function signup($username, $email, $password, $confirm_password)
    {

        $connection = Database::getConnection();

        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            return false;
        }

        $query = "INSERT INTO users (user_name, email, password_hash) VALUES ('$username', '$email', '$hashed_password')";
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

    public function login($email, $password)
    {
        $connection = Database::getConnection();

        $query = "SELECT password_hash, user_name, user_id FROM users WHERE email='$email' OR user_name='$email' ";
        $result = $connection->query($query);

        if ($result->num_rows >= 1) {

            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password_hash'])) {
                return $row['user_id'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function post($post_url, $content)
    {

        $user = new User();
        $magic = new MagicMethods();

        $user_id = $magic->getUserId();

        $connection = Database::getConnection();

        $query = "INSERT INTO posts (user_id, image_url, caption) VALUES ('$user_id', '$post_url', '$content')";
        $result = $connection->query($query);
        if ($result) {
            echo "Posted successfully.";
        } else {
            echo "Post failed.";
        }
    }
}
