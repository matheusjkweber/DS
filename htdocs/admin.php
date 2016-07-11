<?php
    require_once('classes/classe.php');
    require_once('inc/inc.sessao.php');
    require_once('inc/inc.configdb.php');

    if($_SESSION['is_admin']!=true){
        echo '<script>
        alert("Você não tem permissão para acessar essa página.");
        location.href="index.php";</script>';
        die();
    }
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
                    <li>
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
                            echo '<li class="active">
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
            <!-- /.navbar-collapse -->
        </nav>

       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row m-b-10">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row m-b-20" id="date">
                    <div class="col-md-6 col-md-offset-4">
                         <form action="admin.php" id="form" method="post">
                            procurar por <input type="text" name="name" id="user-mail" placeholder="e-mail">

                        <button type="button" id="filter" class="btn btn-secondary btn-sm">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>CPF</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php
                                        if(!empty($_POST['name']) && isset($_POST['name'])){
                                            $Query = mysql_query("Select * from user where cpf <> '$user->get_cpf()' and name like '%".antiSQLInjection($_POST['name'])."%' order by name asc") or die(mysql_error());
                                        }else $Query = mysql_query("Select * from user where cpf <> '$user->get_cpf()' order by name asc") or die(mysql_error());
                                        while($a = mysql_fetch_array($Query)){
                                            echo '<tr>
                                        <td>'.$a['cpf'].'</td>
                                        <td>'.utf8_encode($a['name']).'</td>
                                        <td>'.utf8_encode($a['email']).'</td>
                                        <td style="text-align: center">
                                            <a href="exec.php?action=del_user&id='.$a['cpf'].'">
                                                <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>';
                                        }
                                        ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script>
        $(document).ready(function(){
            $('#filter').click(function(){
                $('#form').submit();
            });
        });
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
