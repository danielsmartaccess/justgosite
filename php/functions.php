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
            ?>
            <div class="msg-erro">Usuário ou senha não encontrados!
            </div>
            <style>
                .msg-erro{
                
                    
                    margin: 10px auto;
                    padding: 15px;
                    text-align: center;
                    font-weight: bold;
                    font-size: 25px;


                }
            </style>
            <?php
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
        $imagem = !empty($_FILES['imagem']['name']) ? $_FILES['imagem']['name'] : "";
        if (!empty($imagem)) {
            $caminho = "images/uploads/";
            $imagem = fotoperfil($caminho);
        }
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

            $query = "INSERT INTO usuarios (nome, email, senha, imagem, data_cadastro)
            VALUES ('$nome', '$email', '$senha', '$imagem', NOW()) ";

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

//Deletar algum dado

function deletar($connect, $tabela, $id){
    if (!empty($id)){
        $query = "DELETE FROM $tabela WHERE id =". (int) $id;
        $executar = mysqli_query($connect, $query);
        if ($executar) {
            echo "Dado deletado com sucesso!";
        }else{
            echo "Erro ao deletar!";
        }
    }
}

// Alterar os dados no BD

function autalizarUser($connect) {
    if (isset($_POST['atualizar']) AND !empty($_POST['email'])) {
        $erros = array();
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $nome = mysqli_real_escape_string($connect, $_POST['nome']);
        $senha = "";
        $data = mysqli_real_escape_string($connect, $_POST['data_cadastro']);
        $imagem = !empty($_FILES['imagem']['name']) ? $_FILES['imagem']['name'] : "";
        if (!empty($imagem)) {
            $caminho = "images/uploads/";
            $imagem = fotoperfil($caminho);
        }

        if (empty($data)) {
            $erros[] = "Preencha a data de cadastro";
        }
        if (empty($email)) {
            $erros[] = "Preencha seu e-mail";
        }
        if (strlen($nome) < 3) {
            $erros[] = "Preencha seu nome completo";
        }
        if (!empty($_POST['senha'])){
            if ($_POST['senha'] == $_POST['repetesenha']) {
                $senha = sha1($_POST['senha']);
            }else{
                $erros[] = "Senhas não conferem!";
            }
        }
        $queryemailAtual = "SELECT email FROM usuarios WHERE id = $id ";
        $buscaemailAtual = mysqli_query($connect, $queryemailAtual);
        $retornoEmail = mysqli_fetch_assoc($buscaemailAtual);
        
        $queryEmail = "SELECT email FROM usuarios WHERE email = '$email' AND email <> '". $retornoEmail['email']."'";
        $buscaEmail = mysqli_query($connect, $queryEmail);
        $verificar = mysqli_num_rows($buscaEmail);

        if (!empty($verificar)) {
            $erros[] = "E-mail já cadastrado!";
        }
        if (empty($erros)){
            if (!empty($senha)) {            
                $query = "UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senha', imagem = '$imagem', data_cadastro = '$data' WHERE id =". (int) $id; 
            }else{
                $query = "UPDATE usuarios SET nome = '$nome', email = '$email', imagem = '$imagem', data_cadastro = '$data' WHERE id =". (int) $id; 
            }
            $executar = mysqli_query($connect, $query);
            if ($executar) {
                echo "Usuário atualizado com sucesso!";
            }else{
                echo "Erro ao atualizar Usuário";
            }
        }else{
            foreach ($erros as $erro) {
                echo "<p>$erro</p>";
            }
        }
    }
}

//Upload foto de perfil

function fotoperfil($caminho){

    if (!empty($_FILES['imagem']['name'])) {
        $nomeImagem = $_FILES['imagem']['name'];
        $tipo = $_FILES['imagem']['type'];
        $nomeTemporario = $_FILES['imagem']['tmp_name'];
        $tamanho = $_FILES['imagem']['size'];
        $erros = array();
        $tamanhoMaximo = 1024 * 1024 * 5; //5MB
        
        if ($tamanho > $tamanhoMaximo) {
            $erros[] = "Seu arquivo excede o tamanho máximo<br>";
        } 
        $arquivosPermitidos = ["png", "jpg", "jpeg"];
        $extensao = pathinfo($nomeImagem, PATHINFO_EXTENSION);
        
        if (!in_array($extensao, $arquivosPermitidos)) {
            $erros[] = "Arquivo não permitido!<br>";
        }
        $typesPermitidos = ["image/png", "image/jpg", "image/jpeg"];
        
        if (!in_array($tipo, $typesPermitidos)) {
            $erros[] = "Tipo de arquivo não permitido.<br>";
        }

        if (!empty($erros)) {
            foreach ($erros as $erro) {
                echo $erro;
            }   
            return FALSE;
        }else {
            $hoje = date("d-m-Y_h-1");
            $novoNome = $hoje."-".$nomeImagem;
            if (move_uploaded_file($nomeTemporario, $caminho.$novoNome)) {
                return $novoNome;

            }else{
                return FALSE;
            }

        }

    }

}
