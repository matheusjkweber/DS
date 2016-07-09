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
    <link href="js/modal/jquery.modal.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.js"></script>
    <script src="js/modal/jquery.modal.js" type="text/javascript" charset="utf-8"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .login{
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            float: inherit;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('.send_form').click(function(){
                $('#email_1').val($('#email').val());
                $('#pass_1').val($('#pass').val());
                $('#form').submit();
            });
        });
    </script>
</head>

<body>
    <div class="row">
        <div class="col-lg-4 text-center login">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form role="form" id="form" action="exec.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="recovery_password">
                        <input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
                        <input type="hidden" name="token" value="<?php echo $_GET['token'];?>">
                        <div class="form-group">
                            <label>Nova Senha</label>
                            <input class="form-control" type="password" name="pass" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <label>Repita a Nova Senha</label>
                            <input class="form-control" type="password" name="pass1" placeholder="Senha" required>
                        </div>

                        <div class="form-group">
                             <input type="submit" value="Enviar" class="btn btn-default send_form">
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
