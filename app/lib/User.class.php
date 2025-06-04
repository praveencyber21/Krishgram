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

        $query = "SELECT password_hash, user_name FROM users WHERE email='$email' OR user_name='$email' ";
        $result = $connection->query($query);

        if ($result->num_rows >= 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password_hash'])) {
                $_SESSION['user_name'] = $row['user_name'];
                $user = new User();
                $user_id = $user->getUserID($_SESSION['user_name']);
                print_r($user_id);
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function __call($name, $arguments)
    {
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));

        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));

        // echo $property;

        // if (substr($name, 0, 3) === "set") {
        //     echo "Set method";
        // } elseif (substr($name, 0, 3) === "get") {
        //     echo "Get method";
        // }
        $connection = Database::getConnection();

        $query = "SELECT $property FROM users WHERE user_name='$arguments[0]'";
        $result = $connection->query($query);

        if ($result->num_rows >= 1) {
            $row = $result->fetch_assoc();
            return $row['user_id'];
        }
    }

    public function post($post_url, $content)
    {

        $user = new User();
        $user_id = $user->getUserId($_SESSION['user_name']);

        $connection = Database::getConnection();

        $query = "INSERT INTO posts ( image_url, caption) VALUES ( '$post_url', '$content')";
        $result = $connection->query($query);
        print_r($result);
        if ($result) {
            echo "Posted successfully.";
        } else {
            echo "Post failed.";
        }
    }
}
