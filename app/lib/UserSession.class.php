<?

include_once __DIR__ . "/../lib/Database.class.php";
include_once __DIR__ . "/../lib/User.class.php";

class UserSession
{
    private $email;
    private $password;
    private $connection;


    public function authenticate($email, $password)
    {

        $this->email = $email;
        $this->password = $password;

        $this->connection = Database::getConnection();

        $user = new User();
        $user_id = $user->login($this->email, $this->password);

        if ($user_id != false) {

            $ip = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $token = md5(rand(0, 9999999) . $ip . $user_agent . time());

            $query = "INSERT INTO sessions (user_id, token, ip, user_agent) VALUES ('$user_id', '$token', '$ip', '$user_agent')";
            $result = $this->connection->query($query);
            print_r($result);

            if ($result) {
                setcookie('session_token', $token, [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
                return $token;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
