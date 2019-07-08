<?php
header('Content-Type: application/json');

require_once('../controller/DBConect.php');
require_once('../model/mecanico.php');
require_once('../controller/DBUtils.php');

insertData();

function returnSelect($_prEmail)
{
    $user = new mecanico();
    $dbutil = new DBUtils();
    // Separa o Select em partes para não ficar uma linha muito extensa.
    $campos = ' u.id_usuario';
    $condicao = sprintf("u.email = %s", $dbutil->paraTexto($_prEmail));
    $sql = sprintf("SELECT %s FROM %s AS u WHERE %s",
        $campos,
        $user->getCampo('tabela'),
        $condicao
    );
    return $sql;
}

function insertData()
{
    $con = new DBConect();
    $con->Conectar();
    $db = $con->getConexao();
    $mecanico = new mecanico();
    $dbutil = new DBUtils();
    $sqlSelect = returnSelect($_POST['cracha']);
    $result = mysqli_query($db, $sqlSelect);
    $cadastrar = true;
    while ($row = mysqli_fetch_assoc($result)) {
        $cadastrar = false;
    }
    if ($cadastrar) {
        $mecanico->setCampo('nome', $dbutil->paraTexto($_POST['nome']));
        $mecanico->setCampo('sobrenome', $dbutil->paraTexto($_POST['sobrenome']));
        $mecanico->setCampo('cracha', $dbutil->paraTexto($_POST['cracha']));
        $mecanico->setCampo('senha', $dbutil->paraTexto(MD5($_POST['senha'])));
        $sql = $dbutil->Insert($mecanico);
        if (mysqli_query($db, $sql)) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Registro inserido com sucesso!'
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Falha ao inserir registro, por favor tente novamente!',
                'error' => mysqli_error($db)
            ));
        }
    } else {
        echo json_encode(array(
            'success' => true,
            'message' => 'Email já existente em nossos registros!'
        ));
    }
}



