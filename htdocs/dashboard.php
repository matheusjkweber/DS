<?php
    require_once('classes/classe.php');
    require_once('inc/inc.sessao.php');
    require_once('inc/inc.configdb.php');
    require_once('inc/functions.php');
    $user = $_SESSION['user'];
    error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema Financeiro</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div style="float: right">
                <p class="small" style="padding-top: 20px; padding-right: 20px; color: gray"> Olá, <?php echo $user->get_name();?>.</p>
            </div>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="dashboard.php"><i class="fa fa-fw fa-bar-chart-o"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="revenues.php"><i class="fa fa-smile-o" aria-hidden="true"></i> Receitas</a>
                    </li>
                    <li>
                        <a href="costs.php">-<i class="fa fa-usd" aria-hidden="true"></i> Despesas</a>
                    </li>
                    
                    <li>
                        <a href="edit_user.php"><i class="fa fa-user" aria-hidden="true"></i> Editar perfil</a>
                    </li>

                    <?php
                        if($_SESSION['is_admin']==true){
                            echo '<li>
                                <a href="admin.php"><i class="fa fa-user-md" aria-hidden="true"></i> Admin</a>
                            </li>';
                        }
                    ?>
                    <li>
                        <a href="https://github.com/matheusjkweber/DS/raw/master/OperationsApp.zip" target="_blank"><i class="fa fa-user" aria-hidden="true"></i> Baixar Sistema Desktop</a>
                    </li>

                    <li>
                        <a href="exec.php?action=logout"><i class="fa fa-user" aria-hidden="true"></i> Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

      <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row m-b-10">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard 
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row m-b-10">
                    <div class="col-lg-12">
                        <p>Você pode ver dados até o dia: <?php echo $user->last_day();?> </p>
                    </div>
                </div>
                <div class="row m-b-20" id="date">
                    <div class="col-md-10 col-md-offset-2" style="margin-left: 111px;">
                        <form action="dashboard.php" id="form" method="post">
                            <i class="fa fa-calendar fa-lg" aria-hidden="true" style="float:left;margin-right:5px;margin-top:5px;"></i>
                            <font style="float:left;margin-right:5px;margin-top:5px;">de</font> 
                            <input type="text" id="datepicker-from" name="from" style="float:left;margin-right:5px;width:95px;"  value="<?php echo antiSQLInjection($_POST['from']);?>"> 
                            <font style="float:left;margin-right:5px;margin-top:5px;">até</font> 
                            <input type="text" value="<?php echo antiSQLInjection($_POST['to']);?>" id="datepicker-to" name="to" style="float:left;margin-right:5px;width:95px;">
                            <font style="float:left;margin-right:5px;margin-top:5px;">por</font> 
                            <select class="form-control" name="type" id="granularity" data-style="btn-default small" style="float:left;width:155px;margin-right:5px;">
                                    <option value="2" <?php if(antiSQLInjection($_POST['type']) == 2) echo 'selected="selected"';?>> Receita/Despesa </option>
                                    <option value="3" <?php if(antiSQLInjection($_POST['type']) == 3) echo 'selected="selected"';?>> Receita </option>
                                    <option value="1" <?php if(antiSQLInjection($_POST['type']) == 1) echo 'selected="selected"';?>> Despesa </option>
                                    
                                </select>
                            <i class="fa fa-map-marker fa-lg" aria-hidden="true" style="float:left;margin-right:5px;margin-top:5px;"></i>
                            <select id="inputState" class="form-control" name="state" data-style="btn-default tiny" style="float:left;width:200px;margin-right:5px;">
                                    <?php print_states(antiSQLInjection($_POST['state']));?>
                                </select>
                            <font style="float:left;margin-right:5px;margin-top:5px;">em</font>  
                            <select id="inputCity" class="form-control" name="city" data-style="btn-default medium" style="float:left;width:200px;margin-right:5px;">
                                    <?php

                                        if(!isset($_POST['city'])){
                                           echo '<option> Selecione um Estado</option>'; 
                                        } 
                                        else print_cities(antiSQLInjection($_POST['state']),antiSQLInjection($_POST['city']));
                                    ?>
                                </select>
                                


                            <button type="button" id="filter" class="btn btn-secondary btn-sm">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> R$ por Categoria</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-bar-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <!-- <script src="js/plugins/morris/morris-data.js"></script> -->

    <script src="js/moment.min.js"></script>

    <script src="js/pikaday.js"></script>

    <script>
        $(document).ready(function(){
            $('#filter').click(function(){
             $('#form').submit();
            });
            $('#inputState').change(function(){
                $('#inputCity').load('ajax/cities.php?idState='+$('#inputState').val());
            });

            $('#inputCity').change(function(){
                $('#inputDistrict').load('ajax/districts.php?idCity='+$('#inputCity').val());
            });
        });
    </script>
    <script type="text/javascript">
        $(function(){
            Morris.Bar({
                element: 'morris-bar-chart',
                <?php
                    if(!isset($_POST['type'])){
                        $type = 2;
                    }else $type = antiSQLInjection($_POST['type']);
                    $user->print_bar_chart_data(antiSQLInjection($_POST['from']),antiSQLInjection($_POST['to']),$type,antiSQLInjection($_POST['city']));
                ?>
                xkey: 'device',
                ykeys: ['outros', 'você'],
                labels: ['Outros', 'Você'],
                barRatio: 0.4,
                xLabelAngle: 35,
                hideHover: 'auto',
                resize: true
            });
        })

        var pickerTo = new Pikaday({ field: document.getElementById('datepicker-to'),
                               position: "bottom-right",
                               reposition: false,
                               format: "YYYY-MM-DD",
                               i18n: {
                                    previousMonth : 'Mês Anterior',
                                    nextMonth     : 'Próximo Mês',
                                    months        : ['Janeiro','Fevereiro','March','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                                    weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                                    weekdaysShort : ['Dom','Seg','Ter','Qua','Qui','Sex','Sab']
                                }
                             });

        var pickerFrom = new Pikaday({ field: document.getElementById('datepicker-from'),
                               position: "bottom-right",
                               reposition: false,
                               format: "YYYY-MM-DD",
                               i18n: {
                                    previousMonth : 'Mês Anterior',
                                    nextMonth     : 'Próximo Mês',
                                    months        : ['Janeiro','Fevereiro','March','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                                    weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                                    weekdaysShort : ['Dom','Seg','Ter','Qua','Qui','Sex','Sab']
                                }
                             });


        $("button#filter").click(function(){
            var initialDate = $("#datepicker-from").val().toString();
            var finalDate   = $("#datepicker-to").val().toString();
            var granularity = $("#granularity").val();
            var city        = $("#city").val();
            var state       = $("#state").val();

            console.info(initialDate);
            console.info(finalDate);
            console.info(granularity);
            console.info(city);
            console.info(state);
        })
    </script>

</body>

</html>

