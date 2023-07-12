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
    <h3>Bem vindo, <?php echo $_SESSION['nome']; ?></h3>
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

if (isset($_GET['id'])) { ?>
    <h2>Tem certeza que deseja deletar o usuário <?php 
    echo $_GET['nome']; ?>?</h2>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
        <input type="submit" name="deletar" value="Deletar">
    </form>

<?php } ?>
<?php
    if (isset($_POST['deletar'])) {
        if ( $_SESSION['id'] != $_POST['id']) {        
            deletar($connect, "usuarios", $_POST['id']);
        }else{
            echo "Você não tem permissão para executar esta solicitação!";
        }
    }
    
?>

<form action="" method="post" enctype="multipart/form-data"> 
    <fieldset>
        <legend>Inserir Usuários</legend>
        <input type="text" name="nome" placeholder="Nome">
        <input type="email" name="email" placeholder="E-mail">
        <input type="password" name="senha" placeholder="Senha">
        <input type="password" name="repetesenha" placeholder="Confirme sua senha">
        <input type="file" name="imagem" accept="image/*" class="form-control">
        <input type="submit" name="cadastrar" value="Cadasrar">
    </fieldset>
</form>

    <div class="Conteiner">
        <table>
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Dados Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td>
                            <?php  if (!empty($usuario['imagem'])) {?>
                            <img width="100px" src="images/uploads/<?php echo $usuario['imagem']; ?>" >
                            <?php }    ?>
                        </td>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><?php echo $usuario['data_cadastro']; ?></td>
                        <td>
                            <a href="users.php?id=<?php echo $usuario['id']; 
                            ?>&nome=<?php echo $usuario['nome']; ?>">Excluir</a>
                            |
                            <a href="edit_user.php?id=<?php echo $usuario['id']; 
                            ?>&nome=<?php echo $usuario['nome']; ?>">Atualizar</a>

                        </td>
                    </tr>


                    <?php endforeach;?>
                    
            
            </tbody>
        </table>
    </div>
<?php  } ?>

</body>
</html>