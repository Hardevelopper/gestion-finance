<?php

@include'config_db.php';
session_start();

if(isset($_POST['submit'])){

    $email = strtolower($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select = $conn->prepare("SELECT * FROM users 
                            WHERE(email = ? && password = ?)");

    $select->execute([$email, $pass]);

    $rowCount = $select->rowCount();

    if(!empty($email) && !empty($pass)){

        if($rowCount > 0){

            $fetch_users = $select->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_role'] = $fetch_users['user_role'];

            if($_SESSION['user_role'] === 'dev'){

                $_SESSION['id'] = $fetch_users['id'];
                header("Location: dashboard_dev.php");

            }elseif($_SESSION['user_role'] === 'admin'){

                $_SESSION['id'] = $fetch_users['id'];
                header("Location: dashboard_admin.php");

            }elseif($_SESSION['user_role'] === 'user'){

                $_SESSION['id'] = $fetch_users['id'];
                header("Location: user_page.php");
            }
        }else{

            $message[] = "E-mail ou mot de passe incorrete";
        }
    }else{

        $message[] = "All input are required";
    }

};


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <link rel="shortcut icon" href="images/head.png">

    <!-- Title Page-->
    <title>Login</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <h2>Gestion finance</h2>
                        </div>

                        <?php
                        
                        if(isset($message)){

                            foreach($message as $message){

                                echo '<div class="message">'. $message .'</div>';
                            }
                        }
                        
                        ?>
                        <div class="login-form">
                            <form method="post">
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="E-mail">
                                </div>
                                <div class="form-group">
                                    <label>Mot de passe</label>
                                    <input class="au-input au-input--full" type="password" name="pass" placeholder="Mot de passe">
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">Se souvenire
                                    </label>
                                    <label>
                                        <a href="">Mot de passe oublier?</a>
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="submit">Inscription</button>
                            </form>
                            <div class="register-link">
                                <p>
                                   Pas encore de compte?
                                    <a href="register.php">Inscrivez vous</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->