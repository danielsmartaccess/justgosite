<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Painel Administrativo</h1>
    <nav>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Usuários</a></li>
            <li><a href="#">Configurações</a></li>
            <li><a href="#">Sair</a></li>
        </ul>
    </nav>
</header>

<main>
    <?php if ($security) { ?>
        <section>
            <h2>Painel Administrativo do site</h2>
            <h3>Bem-vindo, <?php echo $_SESSION['nome']; ?></h3>
            <nav>
                <div>
                    <a href="index.php">Painel</a>
                    <a href="users.php">Gerenciar Usuários</a>
                    <a href="logout.php">Sair</a>
                </div>
            </nav>
        </section>
    <?php } ?>

    <section>
        <h2>Visão geral</h2>
        <p>Bem-vindo ao painel administrativo!</p>
    </section>

    <section>
        <h2>Usuários</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td>
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
                </tr>
                <!-- Outros registros de usuários aqui -->
            </tbody>
        </table>
    </section>

    <section>
        <h2>Configurações</h2>
        <form>
            <label for="site-name">Nome do Site:</label>
            <input type="text" id="site-name" name="site-name" value="Meu Site">

            <label for="site-description">Descrição:</label>
            <textarea id="site-description" name="site-description">Bem-vindo ao meu site!</textarea>

            <button>Salvar</button>
        </form>
    </section>
</main>

<footer>
    <p>© 2023. Todos os direitos reservados.</p>
</footer>

</body>
</html>
Certifique-se de ter o arquivo styles.css no mesmo diretório que o arquivo HTML e que esteja vinculado corretamente para aplicar os estilos definidos.






