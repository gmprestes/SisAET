
function AuxiliosAssociadoCtrl($scope, $http, $routeParams) {

  var id = $routeParams.Id;

  $scope.auxilio = new Object();
  $scope.arquivosSemestre = [];
  $scope.semestre = new Object();
  $scope.semestres = [];
  $scope.instituicoes = [];

  $scope.tipoComprovanteSemestre = 'matricula';

  $scope.resetarSenha = function() {
    if (confirm("Clique em OK se deseja realmente resetar a senha. A senha será então alterada para 12345678. Oriente o usuario a alterar sua senha no primeiro acesso !!!")) {
      $http({
        method: 'GET',
        contentType: 'application/json; charset=utf-8',
        dataType: "json",
        headers: {
          'Authorization': _token,
        },
        url: '/api/login/ForcarAlterarSenha/' + id
      }).success(function(data, status) {
        alert(data);
      }).error(function(data, status) {
        console.log(data);
      });
    }
  }

  $scope.initSemestres = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      headers: {
        'Authorization': _token,
      },
      url: '/api/semestre/GetSemestresAssociado/' + id
    }).success(function(data, status) {
      console.log(data);
      $scope.semestres = data;
      $scope.auxilio.SemestreId = data[0]._id;
      $scope.getInstituicoes();
      $scope.getSemestre();
      $scope.getAuxilio();

      // chamado dentro do getAuxilio();
      //$scope.getArquivos();
    });
  }

  $scope.tipoComprovanteSemestreChange = function() {
    $('#fileUploadArquivosSemestre').fileupload({
      url: _baseURL + '/ajaxarquivos/savearquivosemestreassociado?semestreid=' + $scope.auxilio.SemestreId + '&' + $scope.tipoComprovanteSemestre + '&pessoaid=' + _id,
      dataType: 'json',
      pasteZone: null,
      done: function(e, data) {
        if (data.result == true) {
          $scope.getArquivosSemestre();
          $('#spanMsgSucessoFile').fadeIn(1500).delay(5000).fadeOut(500);
        } else
          alert(data.result);
      },
    });
  }

  $scope.getSemestre = function() {
    var httpRequest = $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      headers: {
        'Authorization': _token,
      },
      url: '/api/semestre/Get/' + $scope.auxilio.SemestreId
    }).success(function(data, status) {
      $scope.semestre = data;

      $scope.novaDisciplina();

      $('#btnSalvarDisciplina').hide();
      $('#detalheDisciplina').hide();
      $('#btnNovaDisciplina').show();
      $('#listDisciplinas').show();
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
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      headers: {
        'Authorization': _token,
      },
      url: '/api/auxilio/GetAuxilio/' + $scope.auxilio.SemestreId + '/' + id
    }).success(function(data, status) {
      $scope.auxilio = data;

      $scope.getArquivosSemestre();
      $scope.tipoComprovanteChange();
    });
  }

  $scope.getArquivosSemestre = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      headers: {
        'Authorization': _token,
      },
      url: '/api/arquivo/GetAllFilesSemestre/' + $scope.auxilio._id + '/' + id
    }).success(function(data, status) {
      $scope.arquivosSemestre = data;
    });
  }

  $scope.changeSemestre = function() {
    $scope.getSemestre();
    $scope.getAuxilio();
    //$scope.getArquivosSemestre();
  }

  $scope.salvarSemestre = function() {
    $("#bntSalvar").prop("disabled", true);
    $("#bntSalvar").val("Salvando...");
    $http({
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
    }).success(function(data, status) {});
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

  $scope.initSemestres();
}
//******************************* ASSOCIADOS LIST **********************************//

function AssociadosListCtrl($scope, $http) {
  $scope.nome = '';
  $scope.somenteDocsPendentes = '';

  $scope.associados = [];

  $scope.init = function() {

    var nome = $.cookie("nomeListAssociado");
    if (typeof nome != 'undefined')
      $scope.nome = nome;

    var docs = $.cookie("somenteDocsPendentesListAssociado");
    if (typeof docs != 'undefined')
      $scope.somenteDocsPendentes = docs == 'true';

    var auxilio = $.cookie("AuxilioNaoConcedidoListAssociado");
    if (typeof docs != 'undefined')
      $scope.auxilioNaoConcedido = auxilio == 'true';

    $http({
      method: 'POST',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/pessoa/GetList',
      headers: {
        'Authorization': _token,
      },
      data: {
        nome: $scope.nome,
        docspendentes: $scope.somenteDocsPendentes,
        auxilionaoconcedido: $scope.somenteDocsPendentes
      }
    }).success(function(data, status) {
      console.log("Buscou associados");
      $scope.associados = data;

      $('#tableAssociados').paginartable({
        tamPagina: 20
      });
    }).error(function(data, status) {
      console.log("Erro associados");
      console.log(data);
    });
  }

  $scope.editItem = function(id) {
    window.location = "#/associados/edit/" + id;
  }

  $scope.init();

  $scope.filtrar = function() {

    $('#btnFiltrar').text("Filtrando...");
    $('#btnFiltrar').prop("disabled", true);

    $.cookie("nomeListAssociado", $scope.nome);
    $.cookie("somenteDocsPendentesListAssociado", $scope.somenteDocsPendentes);
    $.cookie("AuxilioNaoConcedidoListAssociado", $scope.auxilioNaoConcedido);

    $http({
      method: 'POST',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/pessoa/GetList',
      headers: {
        'Authorization': _token,
      },
      data: {
        nome: $scope.nome,
        docspendentes: $scope.somenteDocsPendentes,
        auxilionaoconcedido: $scope.somenteDocsPendentes
      }
    }).success(function(data, status) {
      console.log("Buscou associados");
      $scope.associados = data;

      $('#tableAssociados').paginartable({
        tamPagina: 20
      });

      $('#btnFiltrar').text("Filtrar");
      $('#btnFiltrar').prop("disabled", false);
    }).error(function(data, status) {
      console.log("Erro associados");
      console.log(data);
    });

  }
}

function AssociadosEditCtrl($scope, $http, $routeParams) {

  var id = $routeParams.Id;

  $scope.tipoComprovante = 'identidade';
  $scope.pessoa = new Object();
  $scope.arquivos = [];

  $scope.init = function() {
    var httpRequest = $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/pessoa/GetById/' + id,
      headers: {
        'Authorization': _token,
      },
    }).success(function(data, status) {
      $scope.pessoa = data;
      $scope.tipoComprovanteChange();
      $scope.buscaArquivos();

    });
  }

  $scope.salvar = function() {
    $("#bntSalvar").prop("disabled", true);
    $("#bntSalvar").val("Salvando...");
    var httpRequest = $http({
      method: 'POST',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/pessoa/Save',
      data: {
        pessoa: $scope.pessoa
      },
      headers: {
        'Authorization': _token,
      },
    }).success(function(data, status) {

      $scope.salvarSemestre();

      $("#bntSalvar").prop("disabled", false);
      $("#bntSalvar").val("Salvar");
      $("#msgSucesso").fadeIn(1500).delay(3000).fadeOut(500);
    });
  }

  $scope.buscaArquivos = function() {
    $http({
      method: 'GET',
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      headers: {
        'Authorization': _token,
      },
      url: '/api/arquivo/GetAllFilesPessoa/' + $scope.pessoa._id
    }).success(function(data, status) {
      $scope.arquivos = data;
    });
  }

  $scope.tipoComprovanteChange = function() {
    $('#fileUploadArquivos').fileupload({
      url: _baseURL + '/ajaxarquivos/savearquivoassociado?tipo=' + $scope.tipoComprovante + '&id=' + $scope.pessoa.Id,
      dataType: 'json',
      pasteZone: null,
      done: function(e, data) {
        if (data.result == true) {
          $scope.buscaArquivos();
          $('#spanMsgSucessoFile').fadeIn(1500).delay(5000).fadeOut(500);
        } else
          alert(data.result);
      },
    });
  }

  $scope.baixarArquivo = function(id) {
    var url = '/arquivo/get/' + id;
    downloadFile(guid(), url);
  }

  $scope.saveArquivo = function(item) {
    var httpRequest = $http({
      method: 'POST',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      data: {
        arquivo: item
      },
      headers: {
        'Authorization': _token,
      },
      url: '/api/arquivo/Save'
    }).success(function(data, status) {
      if (data != "true") {
        console.log(typeof data);
        alert("Não foi possivel salvar esta alteração. Possivelmente o arquivo não existe mais");
      } else {
        $scope.buscaArquivos();
        $scope.getArquivosSemestre();
      }
    }).error(function(data, status) {
      console.log(data);
    });

  }

  $scope.init();

  AuxiliosAssociadoCtrl($scope, $http, $routeParams);
}
