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
    

