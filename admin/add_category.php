<?php
  session_start();
  require_once('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');

  if (!isset($_SESSION['useremail']) && !isset($_SESSION['userpass'])){
    // Not logged in or not an admin
    header("Location: http://localhost/RecipeSharing_WebApp/login/signin.php");
    exit();
  }

  $category_error= "";
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
    $category_name= $_POST['category_name'];
    $category_criteria= $_POST['criteria'];

    //Category Form Validation
    if(empty($category_name)){
      $category_error= "Required";
    } else{
      $category_name= trim(htmlspecialchars($category_name));
      if(!preg_match("/^(?![0-9]+$).+$/", $category_name)){
        $category_error= "Must not contain only numbers.";
      }
    }

    if(empty($category_error)){
      insertdata2($category_name, $category_criteria);
      header("Location: http://localhost/RecipeSharing_WebApp/admin/rcp_category.php");
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
          <li class="nav-item">
            <a href="#" class="nav-link">
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
                <a href="http://localhost/RecipeSharing_WebApp/admin/add_user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item menu-open">
                <a href="#" class="nav-link active bg-orange">
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
                    <a href="http://localhost/RecipeSharing_WebApp/admin/add_category.php" class="nav-link active bg-gray">
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
              <li class="breadcrumb-item"><a href="rcp_category.php" class="text-warning">Bake Recipe Categories</a></li>
              <li class="breadcrumb-item active text-white-50">Add Recipe Category</li>
            </ol>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-auto">
            <h1><b>Add Recipe Category</b></h1>
            <span>Fill out the form to add a category to the platform.</span>
          </div>
        </div>
        <hr class="bg-gray pt-1 mt-2 mb-2">
      </div><!-- /.container-fluid -->
    </section>

<!-- --------------------------------FORM START----------------------------------------->
    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row p-0">
          <!-- left column -->
          <div class="col-9">
            <!-- general form elements -->
            <div class="card ml-5">
              <div class="card-header bg-dark d-inline-flex align-items-center">
                <h4 class="my-0">Category Details</h4>
                <a href="http://localhost/RecipeSharing_WebApp/admin/rcp_category.php" class="btn ml-auto">
                  <i class="bi bi-arrow-return-left h5"></i>
                </a>
              </div>
              <!-- /.card-header -->
              <form action="" method="post">
                <div class="card-body text-dark mb-0">
                <div class="row align-items-center">
                  <div class="col-6 form-group ml-3">
                    <label >Category Name</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($category_error)) echo'<i class="far fa-times-circle"></i> '.$category_error.'';?></label>
                    <input type="text" class="form-control <?php if(!empty($category_error))echo 'border-danger';?>" name="category_name" placeholder="Enter category name" vale="<?php if(isset($category_name)) echo $category_name;?>">
                    <label class="mt-3">Category Criteria</label>
                    <select class="custom-select" style="width: 100%;" name="criteria">
                      <option class="h6 bg-dark" value="Dessert">Dessert Type</option>
                      <option class="h6 bg-dark" value="Cuisine">Cuisine</option>
                      <option class="h6 bg-dark" value="Dietary">Dietary Restriction</option>
                      <option class="h6 bg-dark" value="Occasion">Occasion</option>
                    </select>
                    <button type="submit" name="add" value="submit" class="btn btn-success col-3 mt-4" >Add</button>
                    <button type="reset" class="btn btn-outline-danger col-3 mt-4" >Cancel</button>
                  </div>
                  <div class="col text-center opacity-25">
                    <i class="bi bi-cake" style="font-size: 150px; color: #adadad;"></i>
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
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
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>