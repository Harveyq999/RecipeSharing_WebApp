<?php
  session_start();
  require_once('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');

  if (!isset($_SESSION['useremail']) && !isset($_SESSION['userpass'])){
    // Not logged in or not an admin
    header("Location: http://localhost/RecipeSharing_WebApp/login/signin.php");
    exit();
  }

  $f_error="";
  $l_error="";
  $gender_error="";
  $role_error="";
  $emailerror="";
  $passworderror="";
  $gender= "h";
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){
    $fname= $_POST['fname'];
    $lname= $_POST['lname'];
    $gender= $_POST['gender'];
    $email= $_POST['email'];
    $role= $_POST['role'];
    $password= $_POST['password'];

    //User Form Validation
    if(empty($fname)){
      $f_error= "Required";
    } else{
      $fname= trim(htmlspecialchars($fname));
      if(!preg_match("/^(?![0-9]+$).+$/", $fname)){
        $f_error= "Must contain at least one or more letter.";
      }
    }
    if(empty($lname)){
      $l_error= "Required";
    } else{
      $lname= trim(htmlspecialchars($lname));
      if(!preg_match("/^(?![0-9]+$).+$/", $lname)){
        $l_error= "Must contain at least one or more letter.";
      }
    }
    if($gender == 'h'){
      $gender_error= "Required";
    } else{
      $gender= trim(htmlspecialchars($gender));
    }
    if(empty($email)){
      $emailerror= "Required";
    } else{
      $email= trim(htmlspecialchars($email));
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailerror= "Must be an email format which includes '@'.";
      }
    }
    if(empty($role)){
      $role_error= "Required";
    } else{
      $role= trim(htmlspecialchars($role));
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

    if(empty($f_error) && empty($l_error) && empty($gender_error) && empty($role_error) && empty($emailerror) && empty($passworderror)){
      insertdata($fname, $lname, $gender, $email, $role, $password);
      header("Location: http://localhost/RecipeSharing_WebApp/admin/index.php");
      exit();
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
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php require('C:\xampp\htdocs\RecipeSharing_WebApp\navbar.php'); ?>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-dark">
    <!-- Brand Logo -->
    <?php require('C:\xampp\htdocs\RecipeSharing_WebApp\headlogo_sidebar.php'); ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="http://localhost/RecipeSharing_WebApp/assets/dist/img/Idpic.png" class="img-circle img-fluid img-bordered-sm" style="width: 60px;" alt="User Image" >
        </div>
        <div class="info">
        <h5 class="text-wrap"><b><?php echo $_SESSION['user_name']; ?></b></h5>
        <form action="" method="post">
        <h6 class="m-0"><a href="http://localhost/RecipeSharing_WebApp/admin/updateprofile.php?user_id=<?php echo htmlentities($_SESSION['userID']); ?>" class="link h7 mr-1" title="Edit Profile"><i class="bi bi-person-lines-fill h5 border rounded px-1"></i></a><span class="badge border border-secondary text-uppercase" style="vertical-align: top; color:#a07b4a"> <?php echo htmlentities($_SESSION['user_role']); ?></span></h6>
        </form>
      </div>
    </div>
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
              <li class="nav-item">
                <a href="http://localhost/RecipeSharing_WebApp/admin/dashboard.php" class="nav-link">
                <i class="nav-icon bi bi-columns-gap"></i>
                  <p>Dashboard</p>
                </a>
              </li>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active bg-orange">
            <i class="nav-icon bi bi-person-circle" style= "font-size: 20px;"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="http://localhost/RecipeSharing_WebApp/admin/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="http://localhost/RecipeSharing_WebApp/admin/add_user.php" class="nav-link active bg-gray">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon bi bi-journals"></i>
                  <p>Bake Recipe Categories
                  <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="http://localhost/RecipeSharing_WebApp/admin/rcp_category.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                        <p>Manage Categories</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="http://localhost/RecipeSharing_WebApp/admin/add_category.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="http://localhost/RecipeSharing_WebApp/admin/archive_category.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Archived Categories</p>
                    </a>
                  </li>
               </ul>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-gradient-dark">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php" class="text-warning">Home</a></li>
              <li class="breadcrumb-item"><a href="index.php" class="text-warning">Manage Users</a></li>
              <li class="breadcrumb-item active text-white-50">Add User</li>
            </ol>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-auto">
            <h1><b>Add User</b></h1>
            <span>Fill out the form to add a user to the platform.</span>
          </div>
        </div>
        <hr class="bg-gray pt-1 mt-2 mb-2">
      </div><!-- /.container-fluid -->
    </section>

<!-- --------------------------------FORM START----------------------------------------->
    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row p-0 justify-content-center">
          <!-- left column -->
          <div class="col-lg-8">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header bg-dark d-inline-flex align-items-center">
                <h4 class="my-0">User Details</h4>
                <a href="http://localhost/RecipeSharing_WebApp/admin/index.php" class="btn ml-auto">
                  <i class="bi bi-arrow-return-left h5"></i>
                </a>
              </div>
              <!-- /.card-header -->
              <form action="" method="post">
                <div class="card-body text-dark">
                  <div class="form-group">
                    <label >First Name</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($f_error)) echo'<i class="far fa-times-circle"></i> '.$f_error.'';?></label>
                    <input type="text" class="form-control <?php if(!empty($f_error))echo 'border-danger';?>" name="fname" value="<?php if(isset($fname)) echo $fname;?>" placeholder="Enter first name">
                  </div>
                  <div class="form-group">
                    <label >Last Name</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($l_error)) echo'<i class="far fa-times-circle"></i> '.$l_error.'';?></label>
                    <input type="text" class="form-control <?php if(!empty($l_error))echo 'border-danger';?>" name="lname" value="<?php if(isset($lname)) echo $lname;?>" placeholder="Enter last name">
                  </div>
                  <div class="form-group">
                    <label>Gender</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($gender_error)) echo'<i class="far fa-times-circle"></i> '.$gender_error.'';?></label><br>
                    <input type="hidden" name="gender" value="h">
                    <label style="font-weight: normal;"><input type="radio" name="gender" value="Male" <?php if (isset($gender) && $gender == 'Male') echo 'checked'; ?>> Male</label><br>
                    <label style="font-weight: normal;"><input type="radio" name="gender" value="Female" <?php if (isset($gender) && $gender == 'Female') echo 'checked'; ?>> Female</label>
                  </div>
                  <div class="form-group">
                    <label>Email address</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($emailerror)) echo'<i class="far fa-times-circle"></i> '.$emailerror.'';?></label>
                    <input type="text" class="form-control <?php if(!empty($emailerror))echo 'border-danger';?>" name="email" value="<?php if(isset($email)) echo $email;?>" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                        <label>Role</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($role_error)) echo'<i class="far fa-times-circle"></i> '.$role_error.'';?></label>
                        <select class="custom-select" style="width: 100%;" name="role">
                          <option class="h6 bg-dark" value="Baker">Baker</option>
                          <option class="h6 bg-dark" value="Admin">Admin</option>
                        </select>
                  </div>
                  <label>Password</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($passworderror)) echo'<i class="far fa-times-circle"></i> '.$passworderror.'';?></label>
                  <div class="input-group">
                    <input type="password" class="form-control <?php if(!empty($passworderror))echo 'border-danger';?>" name="password" value="<?php if(isset($password)) echo $password;?>" id="password" placeholder="Password">
                    <span class="input-group-text">
                        <i class="bi bi-eye-slash text-dark" style="font-weight:bolder;" id="togglePassword" style="cursor: pointer;"></i>
                    </span>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" style= text-align:center;>
                  <button type="submit" name="save" value="submit" class="btn btn-success col-3" >Add</button>
                  <button type="reset" class="btn btn-outline-danger col-3" >Cancel</button>
                </div>
              </form>
              <script>
                const togglePassword = document.querySelector('#togglePassword');
                const password = document.querySelector('#password');

                togglePassword.addEventListener('click', function (){
                const type = password.getAttribute('type') === 'password'?'text':'password';
                password.setAttribute('type', type);
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
                });
              </script>
            </div>
            <br>
      </section>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php require('C:\xampp\htdocs\RecipeSharing_WebApp\footer_page.php'); ?>

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
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
