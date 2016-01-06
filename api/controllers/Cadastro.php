<?php

require_once '../Models/ASPNETUser.php';
require_once '../db.php';

class Cadastro
{
    public function authorize()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SERVER['Authorization']) && isset($_SESSION['synctoken'])) {
            return $_SESSION['synctoken'] == $_SERVER['Authorization'];
        } else {
            return false;
        }
    }

    /**
     * @url POST /cadastro/Criar
     * @noAuth
     */
    public function CriarCadastro($data)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $usuario = $data->usuario;
        $senha = $data->senha;
        $cpf = $data->cpf;

        $user = ASPNETUser::GetUserByName($usuario);
        if (empty($user)) {
            $db = DB::getInstance();
            $pessoa = $db->DtoPessoa->findOne(array('CPF' => $cpf));
            if (!empty($pessoa)) {
                return array(false, 'Já existe um usuario com este CPF');
            } else {
                ASPNETUser::CreateUser($usuario, $senha);
                $user = ASPNETUser::GetUserByName($usuario);

                $max = $db->DtoPessoa->find()->sort(array('Codigo' => -1))->next()['Codigo'] + 1;

                $p = array(
                  'EmailVerificado' => false,
                  'CadastroVerificado' => false,
                  'NaoAssociado' => false,
                  'Codigo' => $max,
                  'Nome' => $usuario,
                  'Sobrenome' => '',
                  'CPF' => $cpf,
                  'RG' => '',
                  'TituloEleitoral' => '',
                  'DataNascimento' => new MongoDate(),
                  'Email' => $usuario,
                  'Telefone' => '',
                  'Logradouro' => '',
                  'LogradouroNumero' => '',
                  'Complemento' => '',
                  'Bairro' => '',
                  'Cidade' => '',
                  'CEP' => '',
                  'UserId' => mgid_to_string($user['_id']), );

                $db->DtoPessoa->insert($p);

                return array(true, 'Usuario criado com sucesso.');
            }
        } else {
            return array(false, 'Já existe um usuario com este email');
        }
    }
}
