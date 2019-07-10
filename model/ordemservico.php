<?php

class ordemservico
{
    private $nomecliente = null;

    private $veiculo = null;

    private $placa = null;

    private $data = null;

    private $mecanico = null;

    private $servico = null;

    private $tabela = 'ordemservico';

    public function setCampo($_prCampo, $_prValue)
    {
        $this->$_prCampo = $_prValue;
    }

    public function getCampo($_prCampo)
    {
        return $this->$_prCampo;
    }

    /**
     * Leonardo Thomaz
     * 04/05/2019
     *
     * Metodo Utilizado para captar os dados da classe informada, para desta forma ser utilizado para formar um insert
     * genérico
     *
     * @return array contendo em cada posição o name do atributo da classe
     */
    function GetClassVars()
    {
        return array_keys(get_class_vars(get_class($this))); // $this
    }

}