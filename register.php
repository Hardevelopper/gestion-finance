<?php
@include'config_db.php';


if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $email = strtolower($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = md5($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $folder_uploaded_image = "uploaded_images/".$image;

    $select = $conn->prepare("SELECT * FROM users WHERE username = ? || email = ? AND password = ?");
    $select->execute([$username, $email, $cpass]);

    if(!empty($username) && !empty($email) && !empty($cpass) && !empty($image)){

        if($pass != $cpass){

            $message[] = "Confirm password is not match!";
        }else{

            $rowCount = $select->rowCount();

            if(!$rowCount > 0){
                
                $insert = $conn->prepare("INSERT INTO users(username, email, password, image) VALUES(?, ?, ?, ?)");
                $insert->execute([$username, $email, $cpass, $image]);

                if($insert == true){

                if($image_size > 2000000){

                    $message[] = "  Account creating successfully! \n 
                                    image size is large, add it once connected
                                ";

                                header("Location: login.php");
                }else{

                    move_uploaded_file($image_tmp_name, $folder_uploaded_image);
                    $message[] = "Account creating successfully!";

                    header("Location: login.php");

                }  
                };

            }else{
                $message[] = "Account already existed !";
            }
        }

    }else{
        $message[] = "All imput are required !";
    }

}


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
    <title>Register</title>

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
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Nom d'utilisateur</label>
                                    <input class="au-input au-input--full" type="text" name="username" placeholder="Nom d'utilisateur">
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="E-mail">
                                </div>
                                <div class="form-group">
                                    <label>Mot de passe</label>
                                    <input class="au-input au-input--full" type="password" name="pass" placeholder="Mot de passe">
                                </div>
                                <div class="form-group">
                                    <label>Confirmer mot de passe</label>
                                    <input class="au-input au-input--full" type="password" name="cpass" placeholder="Confirm mot de passe">
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input class="au-input au-input--full" type="file" name="image">
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="submit">Enregistrer</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Déja un compte?
                                    <a href="login.php">Connexion</a>
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