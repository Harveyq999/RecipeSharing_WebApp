<?php
  session_start();
  require_once('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');
  $conn = getDatabaseConnection();

  if (!isset($_SESSION['useremail']) && !isset($_SESSION['userpass'])){
    // Not logged in or not an admin
    header("Location: http://localhost/RecipeSharing_WebApp/login/signin.php");
    exit();
  }

  $User_ID = $_GET['user_id'];
  $query = $conn->prepare("SELECT * FROM users WHERE User_ID = :User_ID LIMIT 1");
  $query->bindParam(':User_ID', $User_ID);
  $query->execute();
  $row= $query->fetch(PDO::FETCH_ASSOC);

  $f_error="";
  $l_error="";
  $emailerror="";
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){  
    $user_ID= $_POST['user_id'];
    $fname= $_POST['fname'];
    $lname= $_POST['lname'];
    $gender= $_POST['gender'];
    $email= $_POST['email'];
    $role= $_POST['role'];

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
    if(empty($email)){
      $emailerror= "Required";
    } else{
      $email= trim(htmlspecialchars($email));
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailerror= "Must be an email format which includes '@'.";
      }
    }
  
    if(empty($f_error) && empty($l_error) && empty($emailerror)){
      if($_SESSION['useremail'] == $row['Email']){
        $_SESSION['user_name']= $_POST['fname'].' '.$_POST['lname'];
      }
      updateprofile($user_ID, $fname, $lname, $gender, $email, $role);
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
        <h6 class="m-0"><a href="http://localhost/RecipeSharing_WebApp/admin/updateprofile.php?user_id=<?php echo htmlentities($_SESSION['userID']); ?>" class="link h7 mr-1" title="Edit Profile"><i class="bi bi-person-lines-fill h5 border rounded px-1 text-light"></i></a><span class="badge border border-secondary text-uppercase" style="vertical-align: top; color:#a07b4a"> <?php echo htmlentities($_SESSION['user_role']); ?></span></h6>
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
<!-- --------------------------------FORM START----------------------------------------->
    <!-- Main content -->
    <section class="content">
      <section class="content-header d-flex justify-content-end pb-0">
        <div class="col-3">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php" class="text-warning ">Home</a></li>
              <li class="breadcrumb-item active text-white-50">Update Profile</li>
            </ol>
        </div>
      </section>
      <div class="container">
        <div class="row p-3 justify-content-center">
          <!-- left column -->
          <div class="col-10">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header bg-dark d-inline-flex align-items-center">
                <h3 class="my-0">Edit Profile</h3>
              </div>
              <!-- /.card-header -->
              <form action="" method="post">
                <input type="hidden" name="user_id" value="<?php echo $row['User_ID'];?>">
                <div class="card-body text-dark pb-5">
                  <div class="form-group">
                    <label >First Name</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($f_error)) echo'<i class="far fa-times-circle"></i> '.$f_error.'';?></label>
                    <input type="text" class="form-control <?php if(!empty($f_error))echo 'border-danger';?>" name="fname" placeholder="Enter first name" value="<?php echo $row['First_Name'];?>">
                  </div>
                  <div class="form-group">
                    <label >Last Name</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($l_error)) echo'<i class="far fa-times-circle"></i> '.$l_error.'';?></label>
                    <input type="text" class="form-control <?php if(!empty($l_error))echo 'border-danger';?>" name="lname" placeholder="Enter last name" value="<?php echo $row['Last_Name'];?>">
                  </div>
                  <div class="input-group">
                    <label class="mr-4">Gender</label><br>
                    <input type="radio" name="gender" value="Male"<?php echo ($row['Gender'] == 'Male')?"checked":"";?> class="mr-1"> <label style="font-weight: normal;" class="col-form-label mr-3"> Male</label><br>
                    <input type="radio" name="gender" value="Female"<?php echo ($row['Gender'] == 'Female')? "checked":"";?> class="mr-1"> <label style="font-weight: normal;" class="col-form-label"> Female</label>
                  </div>
                  <br>
                  <div class="form-group">
                    <label>Email address</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($emailerror)) echo'<i class="far fa-times-circle"></i> '.$emailerror.'';?></label>
                    <input type="text" class="form-control <?php if(!empty($emailerror))echo 'border-danger';?>" name="email" placeholder="Enter email" value="<?php echo $row['Email'];?>">
                  </div>
                  <div class="form-group" style="display: none;">
                        <label>Role</label>
                        <select class="custom-select" style="width: 100%;" name="role"
                        <?php echo ($_SESSION['useremail'] == $row['Email']) ? '': $row['Role']; ?>>
                          <option class="h6 bg-dark" value="Baker"<?php echo ($row['Role'] == 'Baker') ?"selected":'';?>>Baker</option>
                          <option class="h6 bg-dark" value="Admin"<?php echo ($row['Role'] == 'Admin') ?"selected":'';?>>Admin</option>
                        </select>
                  </div>
                  <input type="hidden" name="role" value="<?php echo htmlentities($row['Role']); ?>">
                </div>
                <!-- /.card-body -->
                <div class="card-footer py-3" style= text-align:center;>
                  <button type="submit" name="save" value="submit" class="btn btn-success col-3" >Update</button>
                  <button type="reset" class="btn btn-outline-danger col-3" >Cancel</button>
                </div>
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
