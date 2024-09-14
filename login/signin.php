<?php  
require_once ('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');
session_start();

//Signin Form Validation
$emailerror="";
$passworderror="";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email= $_POST['email'];
    $password= $_POST['password'];

    if(empty($email)){
      $emailerror= "Required";
    } else{
      $email= trim(htmlspecialchars($email));
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailerror= "Must be an email format which includes '@'.";
      }
    }
    if(empty($password)){
      $passworderror= "Required";
    } else{
      $password= trim(htmlspecialchars($password));
      if(!preg_match("/^[a-zA-Z0-9]+$/", $password)){
        $passworderror= "Password must only contain characters or numbers.";
      }
      if(strlen($password) < 6){
        $passworderror= "Password must be longer than six characters.";
      }
    }
    if(empty($emailerror) && empty($passworderror)){
      $conn = getDatabaseConnection();
      $query = $conn->prepare("SELECT * FROM users WHERE Email = :Email");
      $query->bindParam(':Email', $email);
      $result = $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      $conn = NULL;
    
      if($email == $result['Email'] && password_verify($password, $result['Password'])){
        $_SESSION['useremail'] = $result['Email'];
        $_SESSION['userpass'] = $result['Password'];
        $_SESSION['user_name'] = $result['First_Name'].' '.$result['Last_Name'];
        $_SESSION['user_role'] = $result['Role'];
        $_SESSION['user_status'] = $result['Status'];
        $_SESSION['userID'] = $result['User_ID'];

        // User Page Accessibility
        if($_SESSION['user_role'] == 'Admin' && $_SESSION['user_status'] == 'Active'){
          header("Location: http://localhost/RecipeSharing_WebApp/admin/dashboard.php"); // Redirect to the Admin page
          exit();
        } elseif($_SESSION['user_role'] == 'Baker' && $_SESSION['user_status'] == 'Active'){
          header("Location: http://localhost/RecipeSharing_WebApp/baker/dashboard2.php"); // Redirect to the Baker page
          exit();
        } elseif($_SESSION['user_status'] == 'Deactivated'){
          $_SESSION['message_login'] = "Your account has been deactivated.";
          $_SESSION['input_email'] = $email;
          $_SESSION['input_password'] = $password;
          header("Location: http://localhost/RecipeSharing_WebApp/login/signin.php");
          exit();
        }
      } else{
        $_SESSION['message_login'] = "Your account is not registered.";
        $_SESSION['input_email'] = $email;
        $_SESSION['input_password'] = $password;
        header("Location: http://localhost/RecipeSharing_WebApp/login/signin.php");
        exit();
      }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SimpleSweets Recipe Sharing Application</title>
  <link rel="icon" type="image/jpg" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/cookielogo.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Pacifico&family=Russo+One&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/style.css">
  <style type="text/css">
  body{
    background-size: cover;
    background-repeat: no-repeat;
    background-image: url("http://localhost/RecipeSharing_WebApp/assets/dist/img/cake1.jpg") !important;
    position: relative; 
    background-size: cover;
    background-position: center;    
    background-attachment: fixed;
  }
  body:before{
    content:'';
    position: fixed;
    width: 100%;
    top:0px;
    bottom: 0px;
    left: 0px;
    right: 0px;
    background-color: rgba(0,0,0,0.6);
  }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box w-50">
  <!-- /.login-logo -->
  <div class="card bg-dark">
    <div class="card-header d-flex justify-content-center align-items-center" style="background: linear-gradient(140deg,  #fda41f, #e79821, #5562d8, #5562d8); box-shadow: 0px 1px 10px rgb(37, 37, 37);">
        <h1 style="font-family: Pacifico; color: #683f19;" class="brand-text pr-2">SimpleSweets</h1>
        <img src="http://localhost/RecipeSharing_WebApp/assets/dist/img/cookielogo.png" class="img-circle rotate-in-center" style="width: 55px">
    </div>
    <div class="card-body">
      <div>
        <?php if(isset($_SESSION['message_login'])){
          echo'<div id="messageAlert" class="alert bg-danger alert-dismissible fade show d-flex justify-content-center text-center" style="border-color: #494949 !important; padding: .1rem; border: 2px solid; border-radius: 5px; line-height: 40px; font-weight: bold; text-align: center;"  role="alert">'.$_SESSION['message_login'].'<button type="button" class="btn-close mx-2 " style="background-color: transparent; border: 0; color:white; font-size:25px; padding-left: 5px;" data-bs-dismiss="alert" aria-label="Close">&times</button
          </div>';
          unset($_SESSION['message_login']);
        }?>
      </div>
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="" method="post">
      <label>Email</label><label class="text-sm bg-danger ml-2 px-2 rounded-pill" for="inputError"><?php if(!empty($emailerror)) echo'<i class="far fa-times-circle"></i> '.$emailerror.'';?></label>
        <div class="input-group mb-3">
          <input type="text" name="email" value="<?php if(isset($email)){ echo $email; } elseif(isset($_SESSION['input_email'])){ echo $_SESSION['input_email']; } ?>" class="form-control bg-dark" placeholder="Enter your email">
          <div class="input-group-append">
            <div class="input-group-text bg-gray">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <label>Password</label><label class="text-sm bg-danger ml-2 px-2 rounded-pill" for="inputError"><?php if(!empty($passworderror)) echo'<i class="far fa-times-circle"></i> '.$passworderror.'';?></label>
        <div class="input-group mb-3">
          <input type="password" name="password" value="<?php if(isset($password)){ echo $password; } elseif(isset($_SESSION['input_password'])){ echo $_SESSION['input_password']; } ?>" class="form-control bg-dark" placeholder="Enter your password"  id="password">
          <div class="input-group-append">
            <div class="input-group-text bg-gray">
              <span class="bi-eye-slash-fill" id="togglePassword"></span>
            </div>
          </div>
        </div>
        <div class="text-center mt-4 mb-3 pt-5">
          <button type="submit" name="submit" class="btn bg-orange btn-block py-2"><h5><b>Login</b></h5></button>
        </div>
        <p class="mb-1">
        <a href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/rcp_homepage.php" class="text-warning"><small>← Back to homepage</small></a>
        </p>
      </form>
      <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', function(){
        const type = password.getAttribute('type') === 'password'?'text':'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye-fill');
        this.classList.toggle('bi-eye-slash-fill');
        });
      </script>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- jQuery -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="http://localhost/RecipeSharing_WebApp/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="http://localhost/RecipeSharing_WebApp/assets/dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<?php
unset($_SESSION['input_email']);
unset($_SESSION['input_password']);
?>
</body>
</html>
