<?php require_once "functions.php";
if (isset($_POST['acessar'])) {
    login($connect);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Acesso ao site</title>
</head>
<body>
    <form action="" method="post">
        <fieldset>
            <legend>Painel de Login</legend>
            <input type="email" name="email" placeholder="E-mail" required>

            <input type="password" name="senha" placeholder="Senha" require>

            <input type="submit" name="acessar" placeholder="Acessar" require>
        
        </fieldset>
    </form>

    

</body>
</html>