<?php
    require_once('config.php'); if (empty($_SESSION['key'])) { header('location:./'); }
    unset($_SESSION['folder']);
    $mn = '10b';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $cfg['titulo']; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Data table -->
        <link href="css/datatables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- javascript desabilitado -->
        <noscript><div class="script-less"><p><?php echo $cfg['noscript']; ?></p></div></noscript>

        <!-- header logo: style can be found in header.less -->
        <header class="header"><?php include_once('header.php'); ?></header>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas"><?php include_once('leftside.php'); ?></aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Rela&ccedil;&atilde;o dos cadastramentos <small class="pull-right lead response"></small></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-info">
                                <!--<div class="box-header">
                                    <h3 class="box-title">Rela&ccedil;&atilde;o dos contribuintes</h3>
                                </div>-->
                                <div class="box-body table-responsive">
                                    <?php
                                        include_once('conexao.php');

                                        $sql = "SELECT idcadastramento,protocolo_idprotocolo,alvara,data_alvara,habitese,data_habitese,parecer,monitor FROM cadastramento WHERE monitor = 'O' ORDER BY idcadastramento,parecer DESC";
                                        $res = mysql_query($sql);
                                        $ret = mysql_num_rows($res);

                                            if($ret != 0) {
                                                $pycadastramento = md5('idcadastramento');
                                                $modal = '';

                                                echo'
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Protocolo</th>
                                                            <th>Inscri&ccedil;&atilde;o</th>
                                                            <th>Requerente</th>
                                                            <th>Alvar&aacute;</th>
                                                            <th>Data do alvar&aacute;</th>
                                                            <th>Habite-se</th>
                                                            <th>Data do habite-se</th>
                                                            <th>Parecer</th>
                                                            <th style="width: 30px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';

                                                        while($lin = mysql_fetch_object($res)) {
                                                            //invertendo a data 00/00/0000
                                                            $ano = substr($lin->data_alvara,0,4);
                                                            $mes = substr($lin->data_alvara,5,2);
                                                            $dia = substr($lin->data_alvara,8);
                                                            $lin->data_alvara = $dia."/".$mes."/".$ano;

                                                            //invertendo a data 00/00/0000
                                                            $ano = substr($lin->data_habitese,0,4);
                                                            $mes = substr($lin->data_habitese,5,2);
                                                            $dia = substr($lin->data_habitese,8);
                                                            $lin->data_habitese = $dia."/".$mes."/".$ano;

                                                            //verificando a situacao
                                                            if($lin->parecer == 'Aprovado') {
                                                                $lin->parecer = '<span class="label label-success">'.$lin->parecer.'</span>';
                                                            }

                                                            if($lin->parecer == 'Com pendências') {
                                                                #$lin[7] = '<span class="label label-warning">'.$lin[7].'</span>';
                                                                $lin->parecer = '<span class="label label-warning">Pendente</span>';
                                                            }

                                                            //buscando a inscricao, o protocolo e o requerente
                                                            $sql2 = "SELECT imovel.inscricao,protocolo.codigo,requerimento.requerente FROM cadastramento,protocolo,requerimento,imovel WHERE cadastramento.protocolo_idprotocolo = protocolo.idprotocolo AND protocolo.requerimento_idrequerimento = requerimento.idrequerimento AND requerimento.imovel_idimovel = imovel.idimovel AND protocolo.idprotocolo = ".$lin->protocolo_idprotocolo."";
                                                            $res2 = mysql_query($sql2);
                                                            $ret2 = mysql_num_rows($res2);

                                                                if($ret2 != 0) {
                                                                    $lin2 = mysql_fetch_object($res2);
                                                                    $inscricao = $lin2->inscricao;
                                                                    $protocolo = $lin2->codigo;
                                                                    $requerente = $lin2->requerente;
                                                                }
                                                                else {
                                                                    $inscricao = 'Inscri&ccedil;&atilde;o inv&aacute;lida';
                                                                    $protocolo = 'Protocolo inv&aacute;lido';
                                                                    $requerente = 'Requerente inv&aacute;lido';
                                                                }

                                                            echo'
                                                            <tr>
                                                                <td>'.$protocolo.'</td>
                                                                <td>'.$inscricao.'</td>
                                                                <td>'.$requerente.'</td>
                                                                <td>'.$lin->alvara.'</td>
                                                                <td>'.$lin->data_alvara.'</td>
                                                                <td>'.$lin->habitese.'</td>
                                                                <td>'.$lin->data_habitese.'</td>
                                                                <td>'.$lin->parecer.'</td>
                                                                <td>
                                                                    <!--<a data-toggle="modal" data-target="#dados-cadastramento-'.$lin->idcadastramento.'" class="tt" title="Ver os dados do cadastramento" href="dadosCadastramento.php?'.$pycadastramento.'='.$lin->idcadastramento.'"><i class="fa fa-bars"></i></a>-->
                                                                    <a class="tt" title="Editar os dados do cadastramento" href="editaCadastramento.php?'.$pycadastramento.'='.$lin->idcadastramento.'"><i class="fa fa-pencil"></i></a>
                                                                    <a class="delcad tt" id="del-'.$lin->idcadastramento.'" title="Excluir o cadastramento" href="#"><i class="fa fa-trash-o"></i></a>
                                                                </td>
                                                            </tr>';

                                                            $modal .= '
                                                            <!-- Modal dados -->
                                                            <div class="modal fade" id="dados-cadastramento-'.$lin->idcadastramento.'" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content"></div>
                                                                </div>
                                                            </div>';

                                                            unset($sql2,$res2,$ret2,$lin2,$inscricao,$protocolo,$requerente,$ano,$mes,$dia);
                                                        }

                                                    echo'
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Protocolo</th>
                                                            <th>Inscri&ccedil;&atilde;o</th>
                                                            <th>Requerente</th>
                                                            <th>Alvar&aacute;</th>
                                                            <th>Data do alvar&aacute;</th>
                                                            <th>Habite-se</th>
                                                            <th>Data do habite-se</th>
                                                            <th>Parecer</th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>';
                                            }
                                            else {
                                                $zero = 1;

                                                echo'<br>
                                                <div class="alert alert-info alert-dismissable">
                                                    <i class="fa fa-info"></i>
                                                    <b>Aviso!</b> Nenhum cadastramento foi feito ainda. <a href="novoCadastramento.php">Novo cadastramento</a>
                                                </div>';
                                            }

                                        mysql_close($conexao);
                                        unset($conexao,$charset,$sql,$res,$ret,$lin,$pycadastramento);
                                    ?>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                    <?php echo $modal; unset($modal); ?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Data table -->
        <script src="js/datatables.min.js" type="text/javascript"></script>
        <script src="js/datatables.bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/app.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function() {
                /* TABLE */

                $(".table").dataTable({ "column": 9,"order": [[0,'desc'],[1,'asc']],stateSave: true });

                /* TOOLTIP */

                $(".tt").tooltip();

                /* ALERT */
                <?php if(!empty($zero)) { ?> $(".alert").show(); <?php } unset($zero); ?>
            });
        </script>
    </body>
</html>
