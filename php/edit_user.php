<?php session_start();
$security = isset($_SESSION['ativa']) ? TRUE : header("location: login.php");
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
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
?>
    <?php if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $usuario = buscaone($connect, "usuarios", $id);
        autalizarUser($connect);
    ?>
        <h2>Editando o usuário <?php echo $_GET['nome'] ?></h2>
        
    <?php } ?>

<form action="" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Editar Usuário</legend>
        <input value="<?php echo $usuario['id']; ?>" type="hidden" name="id">
        <input value="<?php echo $usuario['nome']; ?>" type="text" name="nome" placeholder="Nome">
        <input value="<?php echo $usuario['email']; ?>" type="email" name="email" placeholder="E-mail">
        <input type="password" name="senha" placeholder="Senha">
        <input type="password" name="repetesenha" placeholder="Confirme sua senha">
        <input value="<?php echo $usuario['data_cadastro']; ?>" type="date" name="data_cadastro" >
        <input type="file" name="imagem" accept="image/*" class="form-control">
        <input type="submit" name="atualizar" value="Cadastrar">
    </fieldset>
</form>


<?php  } ?>

</body>
</html>