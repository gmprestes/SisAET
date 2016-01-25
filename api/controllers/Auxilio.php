<?php

require_once '../db.php';

class Auxilio
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
     * @url GET /auxilio/GetAuxilio/$idSemestre/$idUser
     */
    public function GetAuxilio($idSemestre, $idUser)
    {
        if (!empty($idUser) && $idUser != 'undefined') {
            $db = DB::getInstance();
            $pessoa = $db->DtoPessoa->findOne(array('_id' => str_to_mongoid($idUser)));

            $auxilio = $db->DtoAuxilio->findOne(array('SemestreId' => $idSemestre, 'UserId' => $pessoa['UserId']));
            if (!empty($auxilio)) {
                $auxilio['_id'] = mgid_to_string($auxilio['_id']);
                $auxilio['DataDoPedido'] = mgdt_to_string($auxilio['DataDoPedido']);
                $auxilio['DataConcessao'] = mgdt_to_string($auxilio['DataConcessao']);
                //$auxilio['DataInicio'] = mgdt_to_string($auxilio['DataInicio']);
                //$auxilio['DataTermino'] = mgdt_to_string($auxilio['DataTermino']);

                for ($i = 0; $i < sizeof($auxilio['Disciplinas']); ++$i) {
                    $auxilio['Disciplinas'][$i]['DataInicio'] = mgdt_to_string($auxilio['Disciplinas'][$i]['DataInicio']);
                    $auxilio['Disciplinas'][$i]['DataTermino'] = mgdt_to_string($auxilio['Disciplinas'][$i]['DataTermino']);
                }
            } else {
                $auxilio = array(

                  'Concedido' => false,
                  'SemestreId' => $id,
                  'InstituicaoId' => '',
                  'UserId' => $_SESSION['userid'],
                  'Curso' => '',
                  'Observacoes' => '',
                  'DataDoPedido' => new MongoDate(),
                  'DataConcessao' => new MongoDate(),
                  'Disciplinas' => array(),
                  'Turno' => 'Noite',
                  'TransporteIda' => true,
                  'TransporteVolta' => true,
                  'DataInicio' => new MongoDate(),
                  'DataTermino' => new MongoDate(),
                  'DatasEncontrosPresenciais' => [],
                  'Observacoes' => '',
              );

                $db->DtoAuxilio->insert($auxilio);
                $auxilio['_id'] = mgid_to_string($auxilio['_id']);
                $auxilio['DataDoPedido'] = mgdt_to_string($auxilio['DataDoPedido']);
                $auxilio['DataConcessao'] = mgdt_to_string($auxilio['DataConcessao']);
                //$auxilio['DataInicio'] = mgdt_to_string($auxilio['DataInicio']);
                //$auxilio['DataTermino'] = mgdt_to_string($auxilio['DataTermino']);
            }

            return $auxilio;
        }
    }

    /**
     * @url GET /auxilio/Get/$id
     */
    public function Get($id)
    {
        if (!empty($id) && $id != 'undefined') {
            $db = DB::getInstance();
            $auxilio = $db->DtoAuxilio->findOne(array('SemestreId' => $id, 'UserId' => $_SESSION['userid']));
            if (!empty($auxilio)) {
                $auxilio['_id'] = mgid_to_string($auxilio['_id']);
                $auxilio['DataDoPedido'] = mgdt_to_string($auxilio['DataDoPedido']);
                $auxilio['DataConcessao'] = mgdt_to_string($auxilio['DataConcessao']);
                //$auxilio['DataInicio'] = mgdt_to_string($auxilio['DataInicio']);
                //$auxilio['DataTermino'] = mgdt_to_string($auxilio['DataTermino']);

                for ($i = 0; $i < sizeof($auxilio['Disciplinas']); ++$i) {
                    $auxilio['Disciplinas'][$i]['DataInicio'] = mgdt_to_string($auxilio['Disciplinas'][$i]['DataInicio']);
                    $auxilio['Disciplinas'][$i]['DataTermino'] = mgdt_to_string($auxilio['Disciplinas'][$i]['DataTermino']);
                }
            } else {
                $auxilio = array(

                  'Concedido' => false,
                  'SemestreId' => $id,
                  'InstituicaoId' => '',
                  'UserId' => $_SESSION['userid'],
                  'Curso' => '',
                  'Observacoes' => '',
                  'DataDoPedido' => new MongoDate(),
                  'DataConcessao' => new MongoDate(),
                  'Disciplinas' => array(),
                  'Turno' => 'Noite',
                  'TransporteIda' => true,
                  'TransporteVolta' => true,
                  'DataInicio' => new MongoDate(),
                  'DataTermino' => new MongoDate(),
                  'DatasEncontrosPresenciais' => [],
                  'Observacoes' => '',
              );

                $db->DtoAuxilio->insert($auxilio);
                $auxilio['_id'] = mgid_to_string($auxilio['_id']);
                $auxilio['DataDoPedido'] = mgdt_to_string($auxilio['DataDoPedido']);
                $auxilio['DataConcessao'] = mgdt_to_string($auxilio['DataConcessao']);
                //$auxilio['DataInicio'] = mgdt_to_string($auxilio['DataInicio']);
                //$auxilio['DataTermino'] = mgdt_to_string($auxilio['DataTermino']);
            }

            return $auxilio;
        }
    }
    /**
     * @url POST /auxilio/Save
     */
    public function Save($data)
    {
        $auxilio = $data->auxilio;

        $auxilio->_id = new MongoId($auxilio->_id);
        //$auxilio->DataInicio = new MongoDate(str_to_datetime($auxilio->DataInicio));
        //$auxilio->DataTermino = new MongoDate(str_to_datetime($auxilio->DataTermino));
        $auxilio->DataDoPedido = new MongoDate(str_to_datetime($auxilio->DataDoPedido));
        $auxilio->DataConcessao = new MongoDate(str_to_datetime($auxilio->DataConcessao));

        for ($i = 0; $i < sizeof($auxilio->Disciplinas); ++$i) {
            $auxilio->Disciplinas[$i]->DataInicio = new MongoDate(str_to_datetime($auxilio->Disciplinas[$i]->DataInicio));
            $auxilio->Disciplinas[$i]->DataTermino = new MongoDate(str_to_datetime($auxilio->Disciplinas[$i]->DataTermino));
        }

        $db = DB::getInstance();
        $db->DtoAuxilio->update(array('_id' => $auxilio->_id), $auxilio);

        return 'Salvo com sucesso';
    }
}
