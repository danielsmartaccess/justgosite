```crie o código php para login e senha
```
// Path: login.php
<?php
session_start();    // Inicia a sessão
include('conexao.php');    // Inclui o arquivo de conexão   de login    
$login = $_POST['login'];    // Recebe o login digitado pelo usuário    
$senha = $_POST['senha'];    // Recebe a senha digitada pelo usuário
// Verifica se o usuário existe no banco de dados
$sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'";
$result = mysqli_query($conexao, $sql);
// Se o usuário existir no banco de dados a sessão será criada
if(mysqli_num_rows($result) > 0){
    $_SESSION['login'] = $login;
    $_SESSION['senha'] = $senha;
    header('location:home.php');
}else{
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:index.php');
}
?>
```
// Path: home.php
```
<?php
session_start();    // Inicia a sessão
if(!isset($_SESSION['login']) || !isset($_SESSION['senha'])){    // Se não existir sessão iniciada retorna para o login
    header('location:index.php');
}
?>
```
// Path: logout.php
```
<?php
session_start();    // Inicia a sessão
unset($_SESSION['login']);    // Destrói a sessão limpando todos os valores salvos
unset($_SESSION['senha']);
header('location:index.php');    // Redireciona o usuário para o login
?>
```
// Path: index.php
```
<?php
session_start();    // Inicia a sessão
if(isset($_SESSION['login']) && isset($_SESSION['senha'])){    // Se existir sessão iniciada redireciona para a home
    header('location:home.php');
}
?>
```
// Path: conexao.php
```
<?php
$conexao = mysqli_connect('localhost', 'root', '', 'login');    // Conecta-se ao banco de dados
?>
```
// Path: home.php
```
<?php
session_start();    // Inicia a sessão
if(!isset($_SESSION['login']) || !isset($_SESSION['senha'])){    // Se não existir sessão iniciada retorna para o login
    header('location:index.php');
}
?>
```


    

