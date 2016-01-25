﻿
function AuxiliosCtrl($scope, $http) {

  $scope.auxilio = new Object();
  $scope.arquivos = [];
  $scope.semestre = new Object();
  $scope.semestres = [];
  $scope.instituicoes = [];
  $scope.pessoa = new Object();

  $scope.tipoComprovante = 'matricula';

  $scope.init = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/semestre/GetSemestresUser',
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      console.log("Buscou semestres");
      $scope.semestres = data;
      $scope.auxilio.SemestreId = data[0]._id;

      $scope.getInstituicoes();
      $scope.getPessoa();
      $scope.getSemestre();
      $scope.getAuxilio();

      // chamado dentro do getAuxilio();
      //$scope.getArquivos();


    });
  }

  $scope.tipoComprovanteChange = function() {
    $('#fileUploadArquivosAuxilio').fileupload({
      url: '/arquivo/save/' + $scope.tipoComprovante + '/' + $scope.auxilio._id,
      dataType: 'json',
      pasteZone: null,
      done: function(e, data) {
        console.log(data.result);
        if (data.result == true) {
          $scope.getArquivos();
          $('#spanMsgSucessoFile').fadeIn(1500).delay(5000).fadeOut(500);
        } else
          alert(data.result);
      },
      error: function(e, data) {
        console.log(e.responseText);
        console.log(data.result);
      }
    });
  }

  $scope.getSemestre = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/semestre/Get/' + $scope.auxilio.SemestreId,
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      $scope.semestre = data;

      $scope.novaDisciplina();

      $('#btnSalvarDisciplina').hide();
      $('#detalheDisciplina').hide();
      $('#btnNovaDisciplina').show();
      $('#listDisciplinas').show();
    });
  }

  $scope.getPessoa = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/pessoa/Get',
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      console.log("Buscou pessoa");
      $scope.pessoa = data;
    });
  }

  $scope.getInstituicoes = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/instituicao/GetAllAtivos',
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      console.log("Buscou instituicoes");
      $scope.instituicoes = data;
      $scope.auxilio.InstituicaoId = data[0]._id;
    });
  }

  $scope.getAuxilio = function() {
    console.log($scope.auxilio.SemestreId);
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/auxilio/Get/' + $scope.auxilio.SemestreId,
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      console.log("Buscou auxilio");
      $scope.auxilio = data;
      $scope.getArquivos();
      $scope.tipoComprovanteChange();
    });
  }

  $scope.getArquivos = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      headers: {
        'Authorization': _token,
      },
      url: '/api/arquivo/GetAllFilesSemestre/' + $scope.auxilio._id
    }).success(function(data, status) {
      console.log("Buscou arquivos semestre");
      $scope.arquivos = data;
    });
  }

  $scope.changeSemestre = function() {
    $scope.getSemestre();
    $scope.getAuxilio();
    $scope.getArquivos();
  }

  $scope.salvar = function() {
    $("#bntSalvar").prop("disabled", true);
    $("#bntSalvar").val("Salvando...");
    var httpRequest = $http({
      method: 'POST',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/auxilio/Save',
      headers: {
        'Authorization': _token,
      },
      data: {
        auxilio: $scope.auxilio
      }
    }).success(function(data, status) {
      console.log("Salvou");
      console.log(data);

      $("#bntSalvar").prop("disabled", false);
      $("#bntSalvar").val("Salvar");
      $("#msgSucesso").fadeIn(1500).delay(3000).fadeOut(500);
    });
  }

  // DISCIPLINAS

  $scope.editDisciplina = function(item) {
    if (item == null)
      $scope.novaDisciplina();
    else
      $scope.disciplina = item;

    $('#btnNovaDisciplina').hide();
    $('#btnSalvarDisciplina').show();
    $('#btnVoltarDisciplina').show();

    $('#detalheDisciplina').show();
    $('#listDisciplinas').hide();



  }

  $scope.novaDisciplina = function() {
    $scope.disciplina = new Object();
    $scope.disciplina.DiasSemana = [false, false, false, false, false, false, false];
    $scope.disciplina.Nome = '';
    $scope.disciplina.DataInicio = $scope.semestre.DataInicio;
    $scope.disciplina.DataTermino = $scope.semestre.DataTermino;
    $scope.disciplina.Turno = 'Noite';
    $scope.disciplina.Observacoes = '';
    $scope.disciplina.TransporteIda = true;
    $scope.disciplina.TransporteVolta = true;
    $scope.disciplina.newItem = true;

  }

  $scope.saveDisciplina = function() {
    if ($scope.auxilio.Disciplinas == null) {
      $scope.auxilio.Disciplinas = [];
    }

    if (stringIsNullOrEmpty($scope.disciplina.Nome)) {
      alert("Um nome para a disciplina deve ser informado.");
      return;
    } else if (stringIsNullOrEmpty($scope.disciplina.DataInicio) || $scope.disciplina.DataInicio.length != 10) {
      alert("Uma data de inicio valida deve ser informada.");
      return;
    } else if (stringIsNullOrEmpty($scope.disciplina.DataTermino || $scope.disciplina.DataTermino.length != 10)) {
      alert("Uma data de término valida deve ser informada.");
      return;
    } else if (!($scope.disciplina.DiasSemana[0] || $scope.disciplina.DiasSemana[1] || $scope.disciplina.DiasSemana[2] || $scope.disciplina.DiasSemana[3] || $scope.disciplina.DiasSemana[4] || $scope.disciplina.DiasSemana[5])) {
      console.log($scope.disciplina.DiasSemana);
      alert("Ao informar uma disciplina ao menos um dia de aula deve ser informado.");
      return;
    }

    if ($scope.disciplina.newItem) {
      $scope.disciplina.newItem = false;
      $scope.auxilio.Disciplinas.unshift($scope.disciplina);
    }

    $('#btnSalvarDisciplina').hide();
    $('#btnVoltarDisciplina').hide();
    $('#detalheDisciplina').hide();
    $('#btnNovaDisciplina').show();
    $('#listDisciplinas').show();
  }

  $scope.voltarDisciplina = function() {

    $('#btnSalvarDisciplina').hide();
    $('#btnVoltarDisciplina').hide();
    $('#detalheDisciplina').hide();
    $('#btnNovaDisciplina').show();
    $('#listDisciplinas').show();
  }

  $scope.excluirDisciplina = function(item) {

    for (var i = 0, tamanho = $scope.auxilio.Disciplinas.length; i < tamanho; i++)
      if ($scope.auxilio.Disciplinas[i] == item)
        $scope.auxilio.Disciplinas.remove(i);
  }

  $scope.baixarArquivo = function(id) {
    var url = '/arquivo/get/' + id;
    downloadFile(guid(), url);
  }

  $scope.init();
}
