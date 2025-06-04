<?
include_once __DIR__ . "/../lib/Load.class.php";

$error = '';
$success = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $result = $user->login($email, $password);
        if ($result === false) {
            $error = "Login failed.";
        } else {
            $success = "Login successful.";
            header("Location: home.php");
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krishgram</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>


<body>


    <? if ($_SESSION["is_logedin"]) {
        echo "<div class='alert alert-info'>Already logged in.</div>";
    } else {
        Template::load("login");
    }

    ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>


</body>

</html>