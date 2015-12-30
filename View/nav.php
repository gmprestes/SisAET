
                <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0" ng-controller="MasterCtrl">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="/">Sistema AET</a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class="nav navbar-top-links navbar-right">

                        <li class="divider"></li>
                        <li style="padding-top: 15px;">
                            <b>Olá {{ username }}</b>
                        </li>
                        <li class="divider"></li>
                    </ul>
                    <!-- /.navbar-top-links -->
                    <div class="navbar-default navbar-static-side" role="navigation">
                        <div class="sidebar-collapse">
                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="#/meuperfil"><i class="fa fa-user fa-fw"></i>Meus Dados</a>
                                </li>
                                <li>
                                    <a href="#/auxilio"><i class="fa fa-book fa-fw"></i>Meus Auxílios</a>
                                </li>
                                <li ng-show="isAdmin">
                                    <a href="#/semestres/list"><i class="fa fa-calendar fa-fw"></i>Cad Semestres</a>
                                </li>
                                <li ng-show="isAdmin">
                                    <a href="#/instituicoes/list"><i class="fa fa-tags fa-fw"></i>Cad Instituicões</a>
                                </li>
                                <li ng-show="isAdmin">
                                    <a href="#/associado/list"><i class="fa fa-tags fa-fw"></i>Associados</a>
                                </li>
                                 <li ng-show="isAdmin">
                                    <a href="#/relatorios"><i class="fa fa-tags fa-fw"></i>Relatorios</a>
                                </li>
                                <li>
                                    <a href="/alterarsenha"><i class="fa fa-gear fa-fw"></i>Alterar Senha</a>
                                </li>
                                <li>
                                    <a href="#" ng-click="logout()"><i class="fa fa-sign-out fa-fw"></i>Sair</a>
                                </li>
                            </ul>
                            <!-- /#side-menu -->
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                </nav>
