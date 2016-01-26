<?php

require_once 'db.php';

$db = DB::getInstance();

$newline = "\r\n";

//*******  Headers
$csv = 'Codigo;';
$csv .= 'Email;';
$csv .= 'Nome;';
$csv .= 'CPF;';
$csv .= 'RG;';

$csv .= 'Segunda Ida;';
$csv .= 'Segunda Volta;';
$csv .= 'Terca Ida;';
$csv .= 'Terca Volta;';
$csv .= 'Quarta Ida;';
$csv .= 'Quarta Volta;';
$csv .= 'Quinta Ida;';
$csv .= 'Quinta Volta;';
$csv .= 'Sexta Ida;';
$csv .= 'Sexta Volta;';

$csv .= 'Curso;';
$csv .= 'Instituicao;';
$csv .= 'N Matricula';
$csv .= $newline;

//******** FIM Headers

$itens = $db->DtoAuxilio->find(array('SemestreId'=>$params[0]));

//echo print_r(iterator_to_array($itens));
//exit;

foreach ($itens as $doc) {

              //try
                //{

                    $instituicao = null;
try {
  $instituicao = $db->DtoInstituicao->findOne(array("_id" => new MongoId($doc['InstituicaoId'])));
} catch (Exception $e) {

}

                    $pessoa = $db->DtoPessoa->findOne(array("UserId" => $doc['UserId']));

                    if (!empty($pessoa))
                    {
                                              //var auxilio = this._helpers.dbAcess._repositoryAuxilio.GetSingle(q => q.SemestreId == id && q.UserId == iten.UserId);

                        $segIda = 'Nao';
                        $segVolta = 'Nao';
                        $tercaIda = 'Nao';
                        $tercaVolta = 'Nao';
                        $quartaIda = 'Nao';
                        $quartaVolta = 'Nao';
                        $quintaIda = 'Nao';
                        $quintaVolta = 'Nao';
                        $sextaIda = 'Nao';
                        $sextaVolta = 'Nao';

                        if (!empty($doc['Disciplinas']))
                            foreach ($doc['Disciplinas'] as $dic)
                            {



                              if($dic['Turno'] != "Noite")
                              continue;

                              $ead = isset($dic['EAD'])?$dic['EAD']:false;

                                if ($dic['TransporteIda'])
                                {
                                    if ("Nao" == $segIda && $dic['DiasSemana'][0])
                                        $segIda = $ead ? "EAD" : "Sim";

                                    if ("Nao" == $tercaIda && $dic['DiasSemana'][1])
                                        $tercaIda = $ead ? "EAD" : "Sim";

                                    if ("Nao" == $quartaIda && $dic['DiasSemana'][2])
                                        $quartaIda = $ead ? "EAD" : "Sim";

                                    if ("Nao" == $quintaIda && $dic['DiasSemana'][3])
                                        $quintaIda = $ead ? "EAD" : "Sim";

                                    if ("Nao" == $sextaIda && $dic['DiasSemana'][4])
                                        $sextaIda = $ead ? "EAD" : "Sim";
                                }

                                if ($dic['TransporteVolta'])
                                {
                                    if ("Nao" == $segVolta && $dic['DiasSemana'][0])
                                        $segVolta = $ead ? "EAD" : "Sim";

                                    if ("Nao" == $tercaVolta && $dic['DiasSemana'][1])
                                        $tercaVolta = $ead ? "EAD" : "Sim";

                                    if ("Nao" == $quartaVolta && $dic['DiasSemana'][2])
                                        $quartaVolta = $ead ? "EAD" : "Sim";

                                    if ("Nao" == $quintaVolta && $dic['DiasSemana'][3])
                                        $quintaVolta = $ead ? "EAD" : "Sim";

                                    if ("Nao" == $sextaVolta && $dic['DiasSemana'][4])
                                        $sextaVolta = $ead ? "EAD" : "Sim";
                                }
                            }

                          $csv .=  $pessoa["Codigo"] . ';';
                          $csv .=  $pessoa['Email'] . ';';
                          $csv .=  $pessoa["Nome"] . " " . $pessoa['Sobrenome'] . ';';
                          $csv .=  $pessoa['CPF'] . ';';
                          $csv .=  (empty($pessoa['RG'])?"Nao informado":$pessoa['RG']) . ';';
                          $csv .=  $segIda . ';';
                          $csv .=  $segVolta . ';';
                          $csv .=  $tercaIda . ';';
                          $csv .=  $tercaVolta . ';';
                          $csv .=  $quartaIda . ';';
                          $csv .=  $quartaVolta . ';';
                          $csv .=  $quintaIda . ';';
                          $csv .=  $quintaVolta . ';';
                          $csv .=  $sextaIda . ';';
                          $csv .=  $sextaVolta . ';';
                          $csv .=  (empty($doc['Curso']) ? "Nao informado" : $doc['Curso']) . ';';
                          $csv .=  (empty($instituicao) ? "Nao informado" : $instituicao['Nome']) . ';';
                          $csv .=  isset($doc['NumMatricula'])?(empty($doc['NumMatricula']) ? $doc['NumMatricula'] : ""):"";
                          $csv .= $newline;
                    }
                //}
                //catch(Exception $ex)
                //{
                //}
            }



header('Content-Encoding: UTF-8');
header('Pragma: public'); // required
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false); // required for certain browsers
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=\"reportAlunos.csv\"");
echo "\xEF\xBB\xBF";
header('Content-Transfer-Encoding: binary');
print chr(255) . chr(254) . mb_convert_encoding($csv, 'UTF-16LE', 'UTF-8');
//print $csv;
exit;
//header("Content-Length: ".$size);
