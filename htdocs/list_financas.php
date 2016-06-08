<?php
    include('inc/inc.configdb.php');

    $balance = 0;
    $Query = mysql_query("Select * from data where cpf = '02355500099' order by datetime desc") or die(mysql_error());
    while($result = mysql_fetch_array($Query)){
        if($result['type'] == 0){
            $balance = $balance + $result['value'];
        }else{
            $balance = $balance - $result['value'];
        }

     }


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
            <!-- Brand and toggle get grouped for better mobile display -->
           
             <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="dashboard.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="list_financas.php"><i class="fa fa-fw fa-bar-chart-o"></i> Suas Finanças</a>
                    </li>
                    <li>
                        <a href="relatorios.php"><i class="fa fa-fw fa-table"></i> Relatórios</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Suas Finanças 
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Finanças
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                 <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Resumo</h3>
                            </div>
                            <div class="panel-body">
                                Saldo Atual: R$ <?php echo number_format($balance,2,',','.');?><br>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Categoria</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $Query = mysql_query("Select * from data, category where cpf = '02355500099' and data.idCategory = category.idCategory order by datetime desc") or die(mysql_error());
                                        while($result = mysql_fetch_array($Query)){
                                            
                                            echo ' <tr class="';
                                            if($result['type'] == 0) echo 'success';
                                            else echo 'danger';
                                            echo '">
                                                <td>'.utf8_encode($result['title']).'</td>
                                                <td>'.utf8_encode($result['name']).'</td>
                                                <td>R$ '.number_format($result['value'],2,',','.').'</td>
                                                </tr>';

                                        }
                                        
                                    ?>
                                
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

               

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
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
