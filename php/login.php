<?php require_once "functions.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">   
    <title>Formulário de Acesso ao site</title>
</head>
<body>
    <form action="" method="post">
    <div id="corpo-formulario">
        
        <h1>LOGIN!</h1>

            
            <input type="email" name="email" placeholder="Informe seu E-mail" required>

            <input type="password" name="senha" placeholder="Senha" require>

            <input type="submit" name="acessar" value="ACESSAR" require>
        
        
    </div>
    </form>
    
    <?php 
if (isset($_POST['acessar'])) {
    login($connect);
}
?>

</body>
</html>