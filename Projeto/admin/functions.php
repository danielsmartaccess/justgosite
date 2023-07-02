<?php 

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "just_go";

//Conexão com o BD
$connect = mysqli_connect( $host, $db_user, $db_pass, $db_name );

function login($connect){
    if (isset($_POST['acessar']) AND !empty($_POST['email']) AND !empty($_POST['senha'])) {

        $email =  filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

        $senha = sha1($_POST['senha']);

        $query = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha' ";
        
        $executar = mysqli_query($connect, $query);

        $return = mysqli_fetch_assoc($executar);

        if (!empty($return['email'])) {
            session_start();
            $_SESSION['nome'] = $return['nome'];
            $_SESSION['id'] = $return['id'];
            $_SESSION['ativa'] = TRUE;
            header("location: index.php");

        }else{
            echo "Usuário ou senha não encontrados";
        }
        
    }

}
//Função para deslogar o usuário

function logout(){
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");
}

//Buscar apenas um resultado no BD, com base no ID
function buscaone($connect, $tabela, $id){

    $query = "SELECT * FROM $tabela WHERE id =". (int) $id;
    $execute = mysqli_query($connect, $query);
    $result = mysqli_fetch_assoc($execute);
    return $result;
}

//Busca todos os resultados no BD, com base no WHERE
function buscall($connect, $tabela, $where = 1, $order = ""){
    if (!empty($order)) {
        $order = "ORDER BY $order";
    }

    $query = "SELECT * FROM $tabela WHERE $where $order";
    $execute = mysqli_query($connect, $query);
    $results = mysqli_fetch_all($execute, MYSQLI_ASSOC);
    return $results;
}

//Função para inserir usuários

function inserirusers($connect){

    if (isset($_POST['cadastrar']) AND !empty($_POST['email']) AND 
        !empty($_POST['senha'])) {
        $erros = array();
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $nome = mysqli_real_escape_string($connect, $_POST['nome']);
        $senha = sha1($_POST['senha']);

        if ($_POST['senha'] != $_POST['repetesenha']) {
            $erros[] = "Senhas não conferem!";
            
        }
        $queryEmail = "SELECT email FROM usuarios WHERE email = '$email' ";
        $buscaEmail = mysqli_query($connect, $queryEmail);
        $verificar = mysqli_num_rows($buscaEmail);

// Verifica se já existe um e-mail

        if (!empty($verificar)) {
            $erros[] = "E-mail já cadastrado!";
        }

        if (empty($erros)) {

//Inserir o usuário no BD

            $query = "INSERT INTO usuarios (nome, email, senha, data_cadastro)
            VALUES ('nome', '$email', '$senha', NOW()) ";

            $executar = mysqli_query($connect, $query);
            if ($executar) {
                echo "Usuário Cadastrado com sucesso!";

            }else{
                echo "Erro ao inserir Usuário";
            }

        }else{
            foreach ($erros as $erro) {
                echo "<p>$erro</p>";
            }
        }

    }

}

