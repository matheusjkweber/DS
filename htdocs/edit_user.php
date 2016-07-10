<?php
    require_once('classes/classe.php');
    require_once('inc/inc.sessao.php');
    require_once('inc/inc.configdb.php');
    require_once('inc/functions.php');
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
            <!-- /.navbar-collapse -->
        </nav>

       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Editar Perfil
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div id="form" class="row">
                    <div class="col-md-5">
                        <form action="exec.php" method="post">
                          <input type="hidden" name="action" value="edit_user">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 form-control-label">Nome</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="inputName" placeholder="Nome" value="<?php echo utf8_encode($user->get_name());?>" required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputMail" class="col-sm-2 form-control-label">Email</label>
                            <div class="col-sm-8">
                              <input type="email" class="form-control" name="email" id="inputMail" placeholder="E-mail" value="<?php echo utf8_encode($user->get_email());?>" readonly required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputMail" class="col-sm-2 form-control-label">CPF</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="cpf" id="inputMail" placeholder="CPF" value="<?php echo utf8_encode($user->get_name());?>" readonly required>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputMail" class="col-sm-2 form-control-label">Sexo</label>
                            <div class="col-sm-8">
                              <select name="gender" class="form-control" required>
                                <?php 
                                if($user->get_gender()=='M') echo '
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>';
                                else echo '<option value="F">Feminino</option><option value="M">Masculino</option>';
                                ?>
                            </select>
                            </div>
                          </div>

                           <div class="form-group row">
                            <label for="inputMail" class="col-sm-2 form-control-label">CEP</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="cep" id="inputMail" placeholder="CEP" value="<?php echo utf8_encode($user->get_zipcode());?>" required>
                            </div>
                          </div>

                           <div class="form-group row">
                            <label for="inputState" class="col-sm-2 form-control-label">Estado</label>
                            <div class="col-sm-8">
                              <select class="form-control" name="state" id="inputState" required>
                                <?php print_states($user->get_idState());?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputCity" class="col-sm-2 form-control-label">Cidade</label>
                            <div class="col-sm-8">
                              <select class="form-control" name ="city" id="inputCity" required>
                                    <?php print_cities($user->get_idState(),$user->get_idCity());?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="inputCity" class="col-sm-2 form-control-label">Bairro</label>
                            <div class="col-sm-8">
                              <select class="form-control" name ="district" id="inputDistrict" required>
                                    <?php print_districts($user->get_idCity(),$user->get_idDistrict());?>
                              </select>
                            </div>
                          </div>
                         
                          <div class="form-group row">
                            <div class="col-sm-offset-2 col-sm-8">
                                <input type="submit" class="btn btn-secondary" value="Alterar">
                            </div>
                          </div>
                    </form>
                    </div>
                </div>
               

            </div>

            <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Alterar Senha
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div id="form" class="row">
                    <div class="col-md-5">
                        <form action="exec.php" method="post">
                          <input type="hidden" name="action" value="change_password">
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 form-control-label">Senha Atual</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="pass" id="inputName"  required>
                            </div>
                          </div>

                           <div class="form-group row">
                            <label for="inputName" class="col-sm-2 form-control-label">Nova Senha</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="pass1" id="inputName"  required>
                            </div>
                          </div>
                           <div class="form-group row">
                            <label for="inputName" class="col-sm-2 form-control-label">Repita a Nova Senha</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="pass2" id="inputName"  required>
                            </div>
                          </div>
                         
                          <div class="form-group row">
                            <div class="col-sm-offset-2 col-sm-8">
                                <input type="submit" class="btn btn-secondary" value="Alterar">
                            </div>
                          </div>
                    </form>
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
    <script>
        $(document).ready(function(){
            $('.send_form').click(function(){
                $('#email_1').val($('#email').val());
                $('#pass_1').val($('#pass').val());
                $('#form1').submit();
            });
            $('#inputState').change(function(){
                $('#inputCity').load('ajax/cities.php?idState='+$('#inputState').val());
            });

            $('#inputCity').change(function(){
                $('#inputDistrict').load('ajax/districts.php?idCity='+$('#inputCity').val());
            });
        });
    </script>
</body>

</html>
