<?
include_once __DIR__ . "/../lib/Load.class.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $user = new User();

    $username = $_POST["user_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $error = '';
    $success = '';
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password != $confirm_password) {
        $error = "Password do not match.";
    } else {
        $result = $user->signup($username, $email, $password, $confirm_password);
        if ($result === true) {
            $success = "Signup successful";
        } else {
            $error = "Signup failed";
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
    <link rel="stylesheet" href="assets/css/signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />


</head>


<body>


    <? Template::load("signup"); ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>

    <?php header("Location: login.php");
    endif; ?>



</body>

</html>