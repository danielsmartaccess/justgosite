<?php session_start();
$security = isset($_SESSION['ativa']) ? TRUE : header("location: login.php");
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - Usuários</title>
</head>
<body>

<?php if ($security) { ?>

    <h1>Painel Administrativo do site</h1>
    <h3>Bem Vindo, <?php echo $_SESSION['nome']; ?></h3>
    <h2>Gerenciador de Usuários</h2>

    <nav>
        <div>
            <a href="index.php">Painel</a>
            <a href="users.php">Gerenciar Usuários</a>
            <a href="logout.php">Sair</a>
        </div>
    </nav>

<?php 
$tabela = "usuarios";
$order = "nome";
$usuarios = buscall($connect, $tabela, 1, $order);
inserirusers($connect);

?>

<form action="" method="post">
    <fieldset>
        <legend>Inserir Usuários</legend>
        <input type="text" name="nome" placeholder="Nome">
        <input type="email" name="email" placeholder="E-mail">
        <input type="password" name="senha" placeholder="Senha">
        <input type="password" name="repetesenha" placeholder="Confirme sua senha">
        <input type="submit" name="cadastrar" value="Cadasrar">
    </fieldset>
</form>

    <div class="Conteiner">
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Dados Cadastro</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><?php echo $usuario['data_cadastro']; ?></td>
                    </tr>


                    <?php endforeach;?>
                    
            
            </tbody>
        </table>
    </div>
<?php  } ?>

</body>
</html>