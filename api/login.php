<?php
header('Content-Type: application/json');

require_once('../controller/DBConect.php');
require_once('../model/mecanico.php');
require_once('../controller/DBUtils.php');

authUser();

function authUser()
{
    $con = new DBConect();
    $con->Conectar();
    $db = $con->getConexao();
    $mecanico = new mecanico();
    $dbUtl = new DBUtils();

    // params
    $mecanico->setCampo("email", $dbUtl->paraTexto($_GET['email']));
    $mecanico->setCampo("senha", $dbUtl->paraTexto(MD5($_GET['senha'])));

    $query = sprintf("SELECT * FROM %s WHERE Email = %s AND Senha = %s",
        $mecanico->getCampo("tabela"),
        $mecanico->getCampo("email"),
        $mecanico->getCampo("senha")
    );

    $result = mysqli_query($db, $query);
    $response = mysqli_fetch_assoc($result);

    if ($result->num_rows > 0) {
        // start a session
        session_start();

        // initialize session variables
        $_SESSION['user'] = $response;

        echo json_encode(array(
            'success' => true,
            'message' => 'Acesso permitido, as credenciais são validas',
            'data' => $response
        ));
    } else {
        echo json_encode(array(
            'status' => 401,
            'success' => false,
            'message' => 'E-mail ou senha inválidos',
            'error' => mysqli_error($db)
        ));

        http_response_code(401);
    }

    exit();
}
