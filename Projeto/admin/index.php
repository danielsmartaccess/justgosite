<?php session_start();
$security = isset($_SESSION['ativa']) ? TRUE : header("location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>
</head>
<body>

<?php if ($security) { ?>

    <h1>Painel Administrativo do site</h1>
    <h3>Beom Vindo, <?php echo $_SESSION['nome']; ?></h3>
    <a href="logout.php">Sair</a>

<?php  } ?>

</body>
</html>