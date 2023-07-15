<?php

// exibir mensagens de erros no PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_PARSE);

// local de armazenamento de arquivos de uploads
$system_url  = 'https://github.com/SamirInstantData/PublicScripts';


// prepara a saida com uma mensagem de erro, caso ocorra alguma coisa
$output = ['status' => 'ERRO', 'message' => 'Nenhum comando.'];

// Estabelece a conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto_flutter";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

switch ($_REQUEST['service']) {

    case "check_login":

        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];

        // Executa a consulta para verificar se o email e a senha existem na base de dados
        $sql = "SELECT * FROM Tbl_Users WHERE Nome = '$email' AND Pass = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Usuário encontrado, retornamos os dados do usuário
            $row = $result->fetch_assoc();
            $output['status'] = 'OK';
            $output['message'] = 'Sucesso!';
            $output['id'] = $row['ID'];
            $output['name'] = $row['Nome'];
        } else {
            // Usuário não encontrado, enviamos um erro para a saída
            $output['message'] = 'Usuário ou senha incorretos!';
        }

        break;
}

$conn->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($output);
?>
