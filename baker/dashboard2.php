<?php
  session_start();
  require_once('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');
  $result = retrieve_countrecipes();
  $recipenum = $result[0]['COUNT(*)'];


  if (!isset($_SESSION['useremail']) && !isset($_SESSION['userpass'])){
    // Not logged in or not an admin
    header("Location: http://localhost/RecipeSharing_WebApp/login/signin.php");
    exit();
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
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center bg-dark shadow">
    <div class="animation__shake rounded-circle shadow p-3 bg-primary" style=" background: linear-gradient(120deg,  #e49217, #d6860d, #e79821, #3F4AA7, #28349e, #28349e);">
      <img class="animation__shake m-3" src="http://localhost/RecipeSharing_WebApp/RecipeHomepage/cookielogo.png" alt="SimpleSweets" height="130rem" width="130rem">
    </div>
  </div>
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
        <h6 class="m-0"><a href="http://localhost/RecipeSharing_WebApp/baker/updateuser_profile.php?user_id=<?php echo htmlentities($_SESSION['userID']); ?>" class="link h7 mr-1" title="Edit Profile"><i class="bi bi-person-lines-fill h5 border rounded px-1"></i></a><span class="badge border border-secondary text-uppercase" style="vertical-align: top; color:#a07b4a"> <?php echo htmlentities($_SESSION['user_role']); ?></span></h6>
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
                <a href="http://localhost/RecipeSharing_WebApp/baker/dashboard2.php" class="nav-link active bg-orange">
                <i class="nav-icon bi bi-columns-gap"></i>
                  <p>Dashboard</p>
                </a>
              </li>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon bi bi-cake" style= "font-size: 20px;"></i>
              <p>
                Recipes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="http://localhost/RecipeSharing_WebApp/baker/index2.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Recipes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="http://localhost/RecipeSharing_WebApp/baker/add_recipe.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Recipe</p>
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
              <li class="breadcrumb-item active text-white-50">Home</></li>
            </ol>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-auto">
            <h1><b>Dashboard</b></h1>
          </div>
        </div>
        <hr class="bg-gray pt-1 mt-2 mb-2">
      </div><!-- /.container-fluid -->
      <div class="col-6 ml-1">
        <?php require('C:\xampp\htdocs\RecipeSharing_WebApp\alert.php'); ?>
      </div>
    </section>

<!-- --------------------------------FORM START----------------------------------------->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row ml-1 align-items-center">
            <div class="col-12 col-sm-6 col-md-3" onclick="location.href='index2.php'" style="cursor: pointer;">
             <div class="info-box bg-dark">
              <span class="info-box-icon bg-olive elevation-1" style="border-radius: 50%;"><i class="bi bi-cake2"></i></span>
              <div class="info-box-content">
                <span class="ml-auto"><h2><b>
                <?php echo "$recipenum"; ?></b></h2></span>
                <span class="info-box-text h6 m-0 ml-auto">Published Recipes</span>
              </div>
            </div>
           </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>