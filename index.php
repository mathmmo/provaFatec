<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Matheus Oliveira">
    <title>Applicação PHP & AngularJS</title>
    <!-- JS, Angular and JQuery files used to run the dataTable plugin -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/angular-datatables.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Bootstrap and dataTable stylisheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
  </head>
  <body ng-app="crudApp" ng-controller="crudController">
    <div class="row">
      <div class="col-md-6 offset-md-3 text-center ">
        <h1 class="h3 mb-3 font-weight-normal">Método de Leitura, Adição, Alteração e Deleção</h1>
        <small class="text-muted">Usando PHP, AngularJS, dataTable Library e Bootstrap </small>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="container" ng-init="fetchData()">
          <div class="alert alert-success alert-dismissible" ng-show="success" >
            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
            {{successMessage}}
          </div>
          <div align="right">
            <button type="button" name="searchButton" ng-click="searchData()" class="btn btn-info">Pesquisar</button>
          </div>
          <div class="table-responsive" style="overflow-x: unset;">
            <table datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Cidade</th>
                  <th>campoMontanha</th>
                  <th>praia</th>
                  <th>noiteDiversao</th>
                  <th>cultural</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="roteiro in roteirosData">
                  <td>{{roteiro.cidade}}</td>
                  <td>{{roteiro.campoMontanha}}</td>
                  <td>{{roteiro.praia}}</td>
                  <td>{{roteiro.noiteDiversao}}</td>
                  <td>{{roteiro.cultural}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<div class="modal fade" tabindex="-1" role="dialog" id="crudmodal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" ng-submit="submitForm()">
        <div class="modal-header">
          <h4 class="modal-title">{{modalTitle}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger alert-dismissible" ng-show="error" >
            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
            {{errorMessage}}
          </div>
          <div class="form-group">
            <label for="cliente">Nome do Cliente</label>
            <input type="text" name="cliente" ng-model="cliente" class="form-control" />
          </div>
          <div class="form-group">
            <label> Informe abaixo as NOTAS (de 1 a 10) sobre o perfil do cliente: </label>
          </div>
          <div class="form-group">
            <label for="noiteDiversao">Noite e Diversão</label>
            <input type="text" name="noiteDiversao" ng-model="noiteDiversao" class="form-control" />
          </div>
          <div class="form-group">
            <label for="campoMontanha"> Campo e Montanha</label>
            <input type="text" name="campoMontanha" ng-model="campoMontanha" class="form-control" />
          </div>
          <div class="form-group">
            <label for="praia">Praia</label>
            <input type="text" name="praia" ng-model="praia" class="form-control" />
          </div>
          <div class="form-group">
            <label for="cultural">Cultural</label>
            <input type="text" name="cultural" ng-model="cultural" class="form-control" />
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="hiddenId" value="{{hiddenId}}" />
          <input type="submit" name="submitButton" id="submitButton" class="btn btn-info" value="{{submitButton}}" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  var app = angular.module('crudApp', ['datatables']);
  app.controller('crudController', function($scope, $http){

    $scope.success = false;
    $scope.error = false;

    $scope.fetchData = function(){
      $http.get('fetch_data.php').success(function(data){
        $scope.roteirosData = data;
      });
    }

    $scope.openModal = function(){
      var modalPopup = angular.element('#crudmodal');
      modalPopup.modal('show');
    }

    $scope.closeModal = function(){
      var modalPopup = angular.element('#crudmodal');
      modalPopup.modal('hide');
    }

    $scope.searchData = function(){
      $scope.modalTitle = 'Colsultar';
      $scope.submitButton = 'Consultar';
      $scope.openModal();
    }

    $scope.formData = {};

    $scope.submitForm = function(){

      alert (parseInt($scope.campoMontanha) + 1);
      return null;
      if($scope.cliente == undefined){
        return validateForm();
      }
      if($scope.campoMontanha == undefined  || parseInt($scope.campoMontanha) > 10 || parseInt($scope.campoMontanha)<0){
        return validateForm();
      }
      if($scope.praia == undefined){
        return validateForm();
      }
      if($scope.noiteDiversao == undefined){
        return validateForm();
      }
      if($scope.cultural == undefined){
        return validateForm();
      }
      function validateForm(){
        alert ('Existem campos vazios no seu formulário.');
        return null;
      }
      $http({
        method:"POST",
        url:"consult.php",
        data:{
          'cliente'        : $scope.cliente,
          'campoMontanha' : $scope.campoMontanha,
          'praia'         : $scope.praia,
          'noiteDiversao' : $scope.noiteDiversao,
          'cultural'      : $scope.cultural
        }
      }).success(function(data){
        if(data.error != ''){
          $scope.success = false;
          $scope.error = true;
          $scope.errorMessage = data.error;
        }else{
          $scope.success = true;
          $scope.error = false;
          $scope.successMessage = data.message;
          $scope.formData = {};
          $scope.closeModal();
          $scope.fetchData();
        }
      });
    }
  });

</script>