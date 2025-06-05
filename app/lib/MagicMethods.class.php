<?

include_once __DIR__ . "/../lib/Database.class.php";


class MagicMethods
{

    public function __call($name, $arguments)
    {
        $connection = Database::getConnection();

        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));

        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));

        $table = $arguments['table'] ?? null;
        $column = $arguments['column'] ?? null;
        $value = $arguments['value'] ?? null;
        $token = $_COOKIE['session_token'];


        if (substr($name, 0, 3) === 'set') {
            if ($property === 'user_id') {
                $user_id = $arguments[0];
                $query = "UPDATE $table SET $property = $value WHERE $column = $user_id";
            }
            $query = "UPDATE $table SET $property = $value WHERE $column = $user_id";
            $result = $connection->query($query);

            if ($result->num_rows >= 1) {
                $row = $result->fetch_assoc();
                return $row[$property];
            } else {
                return false;
            }
        } elseif (substr($name, 0, 3) === 'get') {
            if ($property === 'user_id') {

                $query = "SELECT user_id FROM sessions WHERE token = '$token' AND active = 1 LIMIT 1";

                $result = $connection->query($query);
                if ($result->num_rows >= 1) {
                    $row = $result->fetch_assoc();
                    return $row[$property];
                } else {
                    return false;
                }
            }
            $query = "SELECT $property FROM $table WHERE $property=$property";
            $result = $connection->query($query);

            if ($result->num_rows >= 1) {
                $row = $result->fetch_assoc();
                return $row[$property];
            } else {
                return false;
            }
        } else {
            throw new Exception("MagicMethods::__call() -> $name: No such method found");
        }
    }
}
