<?

include_once __DIR__ . "/../lib/Database.class.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_COOKIE['session_token'])) {

    $connection = Database::getConnection();

    $token = $_COOKIE['session_token'] ?? null;
    $token = $connection->real_escape_string($token);

    if ($token) {
        $query = "DELETE FROM sessions WHERE token = '$token' ";
        $result = $connection->query($query);

        if ($result) {
            setcookie('session_token', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            header("Location: login.php");
            exit;
        } else {
            echo "Logout failed.";
        }
    }
}
