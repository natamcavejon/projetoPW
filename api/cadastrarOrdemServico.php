<?php
header('Content-Type: application/json');

require_once('../controller/DBConect.php');
require_once('../model/ordemservico.php');
require_once('../controller/DBUtils.php');

insertData();

function returnSelect($_prCracha)
{
    $user = new mecanico();
    $dbutil = new DBUtils();
    // Separa o Select em partes para não ficar uma linha muito extensa.
    $campos = ' u.id_usuario';
    $condicao = sprintf("u.cracha = %s", $dbutil->paraTexto($_prCracha));
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
    $dbutil = new DBUtils();
    $ordemservico = new ordemservico();
    $ordemservico->setCampo('nomecliente', $dbutil->paraTexto($_POST['nome']));
    $ordemservico->setCampo('veiculo', $dbutil->paraTexto($_POST['sobrenome']));
    $ordemservico->setCampo('placa', $dbutil->paraTexto($_POST['cracha']));
    $ordemservico->setCampo('data', $dbutil->paraTexto(MD5($_POST['senha'])));
    $ordemservico->setCampo('mecanico', $dbutil->paraTexto(MD5($_POST['senha'])));
    $ordemservico->setCampo('servico', $dbutil->paraTexto(MD5($_POST['senha'])));
    $sql = $dbutil->Insert($ordemservico);
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
}



