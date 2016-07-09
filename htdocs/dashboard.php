<?php
    require_once('classes/classe.php');
    require_once('inc/inc.sessao.php');
    require_once('inc/inc.configdb.php');
    $user = $_SESSION['user'];
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
                        <a href="dashboard.html"><i class="fa fa-fw fa-bar-chart-o"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="revenues.html"><i class="fa fa-smile-o" aria-hidden="true"></i> Receitas</a>
                    </li>
                    <li>
                        <a href="costs.html">-<i class="fa fa-usd" aria-hidden="true"></i> Despesas</a>
                    </li>
                    
                    <li>
                        <a href="edit_user.html"><i class="fa fa-user" aria-hidden="true"></i> Editar perfil</a>
                    </li>

                    <?php
                        if($_SESSION['is_admin']==true){
                            echo '<li>
                                <a href="admin.html"><i class="fa fa-user-md" aria-hidden="true"></i> Admin</a>
                            </li>';
                        }
                    ?>
                    <li>
                        <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Baixar Sistema Desktop</a>
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

                <div class="row m-b-20" id="date">
                    <div class="col-md-6 col-md-offset-4">
                        de <input type="text" id="datepicker-from"> até <input type="text" id="datepicker-to">

                        <button type="button" id="filter" class="btn btn-secondary btn-sm">
                            <i class="fa fa-filter" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Suas Finanças</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-bar-chart"></div>
                                <div class="text-right">
                                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
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

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <!-- <script src="js/plugins/morris/morris-data.js"></script> -->

    <script src="js/moment.min.js"></script>

    <script src="js/pikaday.js"></script>

    <script type="text/javascript">
        $(function(){
            Morris.Bar({
                element: 'morris-bar-chart',
                data: [{
                    device: 'iPhone',
                    geekbench: 136
                }, {
                    device: 'iPhone 3G',
                    geekbench: 137
                }, {
                    device: 'iPhone 3GS',
                    geekbench: 275
                }, {
                    device: 'iPhone 4',
                    geekbench: 380
                }, {
                    device: 'iPhone 4S',
                    geekbench: 655
                }, {
                    device: 'iPhone 5',
                    geekbench: 1571
                }],
                xkey: 'device',
                ykeys: ['geekbench'],
                labels: ['Geekbench'],
                barRatio: 0.4,
                xLabelAngle: 35,
                hideHover: 'auto',
                resize: true
            });
        })

        var pickerTo = new Pikaday({ field: document.getElementById('datepicker-to'),
                               position: "bottom-right",
                               reposition: false,
                               format: "DD/MM/YY",
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
                               format: "DD/MM/YY",
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
        })
    </script>

</body>

</html>


