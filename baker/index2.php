<?php
  session_start();
  require_once('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');
  $conn = getDatabaseConnection();

  if (!isset($_SESSION['useremail']) && !isset($_SESSION['userpass'])){
    // Not logged in or not an admin
    header("Location: http://localhost/RecipeSharing_WebApp/login/signin.php");
    exit();
  }

  if(isset($_POST['delete_true'])){ 
    $Recipe_ID = $_POST['recipe_id'];
    deletedata3($Recipe_ID);
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
                <a href="http://localhost/RecipeSharing_WebApp/baker/dashboard2.php" class="nav-link">
                <i class="nav-icon bi bi-columns-gap"></i>
                  <p>Dashboard</p>
                </a>
              </li>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active bg-orange">
            <i class="nav-icon bi bi-cake" style= "font-size: 20px;"></i>
              <p>
                Recipes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="http://localhost/RecipeSharing_WebApp/baker/index2.php" class="nav-link active bg-gray">
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

  <!------------------------------- Content Wrapper. Contains page content ------------------------------->
  <div class="content-wrapper bg-gradient-dark">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard2.php" class="text-warning">Home</a></li>
              <li class="breadcrumb-item active text-white-50">Manage Recipes</li>
            </ol>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-auto">
            <h1><b>Recipe Management</b></h1>
          </div>
        </div>
        <hr class="bg-gray pt-1 mt-2 mb-2">
      </div><!-- /.container-fluid -->
    </section>
<!-- --------------------------------LIST START----------------------------------------->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row px-2 justify-content-center">
          <!-- left column -->
          <div class="col">
          <div class="container">
          <?php require('C:\xampp\htdocs\RecipeSharing_WebApp\alert.php'); ?>
          </div>
            <div class="card">
            <div class="card-header bg-dark px-4 d-flex align-items-center">
                <h6 class="card-title" style="font-size: 23px;">Recipes</h6>
                <div class="input-group input-group-sm">
                  <button onclick="document.location='add_recipe.php'" style="width: 30px; height: 30px;border-radius:50%;" class="btn btn-success btn-sm ml-2" title="Add Recipe"><i class="bi bi-plus-circle d-flex" style="font-size: 20px; align-items: center;
                  justify-content: center;"></i></button>
                </div>
                <div class="card-tools ml-auto">
                <?php
                $start = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $search = isset($_GET['table_search']) ? htmlspecialchars($_GET['table_search']) : '';
                if (isset($_GET['table_search'])){
                  $search= htmlspecialchars($_GET['table_search']);
                  // If the search query is empty, reset page to 1
                  if (empty($search)){
                  $search = '';
                  $start = 1;
                  }
                }
                $rowsper_page = 7;
                ?> 
                <form method="GET" action="">
                  <div class="input-group input-group-sm" style="width: 180px; height: 35px;">
                    <input type="hidden" name="page" value="1">
                    <input type="text" name="table_search" class="form-control float-right rounded-left" placeholder="Search" value="<?php echo $search; ?>" style="height: 35px;">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <?php
                  $result = retrieve_allrecipe($start, $rowsper_page);
                  $result2 = retrieve_alldata3();

                  // Calculate total number of pages
                  if(!empty($search)){
                    $searchParam = "%$search%"; 
                    $query = $conn->prepare("SELECT COUNT(DISTINCT recipes.Recipe_ID) as total_num FROM recipes LEFT JOIN rcp_num_categories ON recipes.Recipe_ID = rcp_num_categories.Recipe_ID LEFT JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID WHERE recipes.User_ID = :userID AND (Recipe_Name LIKE :searchParam OR Preparation_Time LIKE :searchParam OR Cook_Time LIKE :searchParam OR Servings LIKE :searchParam OR rcp_categories.Category_Name LIKE :searchParam)");
                    $query->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
                    $query->bindParam(':searchParam', $searchParam);
                    $query->execute();
                    $totalnum_records = $query->fetch(PDO::FETCH_ASSOC)['total_num'];
                  } else{
                    $query = $conn->prepare("SELECT COUNT(*) as total_num FROM recipes WHERE recipes.User_ID = :userID");
                    $query->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
                    $query->execute();
                    $totalnum_records = $query->fetch(PDO::FETCH_ASSOC)['total_num'];
                  }
                  $num_of_pages = ceil($totalnum_records / $rowsper_page);
                  if(empty($result) && empty($result2)){
                    echo "<h5 class='text-danger d-flex justify-content-center py-2'><strong>Sorry, no result found.</strong></h5>";
                  } else{
                      if(!empty($search)){
                        $searchParam = "%$search%"; 
                        $offset = ($start - 1)  * $rowsper_page;

                        $query = $conn->prepare("SELECT DISTINCT recipes.* FROM recipes LEFT JOIN rcp_num_categories ON recipes.Recipe_ID = rcp_num_categories.Recipe_ID LEFT JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID WHERE recipes.User_ID = :userID AND (Recipe_Name LIKE :searchParam OR Preparation_Time LIKE :searchParam OR CONCAT(Preparation_Time,' ', 'mins') LIKE :searchParam OR Cook_Time LIKE :searchParam OR CONCAT(Cook_Time,' ', 'mins') LIKE :searchParam OR Servings LIKE :searchParam OR CONCAT(Servings,' ', 'servings') LIKE :searchParam OR rcp_categories.Category_Name LIKE :searchParam) LIMIT :Limit OFFSET :Offset");
                        $query->bindParam(':Limit', $rowsper_page, PDO::PARAM_INT);
                        $query->bindParam(':Offset', $offset, PDO::PARAM_INT);
                        $query->bindParam(':userID', $_SESSION['userID']);
                        $query->bindParam(':searchParam', $searchParam);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        if(isset($results) && !empty($results)){
                      ?>
                        <table id="example2" class="table table-black text-nowrap table-striped">
                        <thead>
                        <tr class="text-dark">
                          <th class="px-3 pr-4">Recipe Name</th>
                          <th class="px-3 text-center">Recipe Image</th>
                          <th class="pl-5 pr-0">Category/s</th>
                          <th class="px-3">Prep Time</th>
                          <th class="px-3">Cook Time</th>
                          <th class="px-2">Date Created</th>
                          <th class="px-0">Date Updated</th>
                          <th class="px-3 text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-dark text-wrap">
                        <?php
                         foreach($results as $key => $row){
                          $created_at = new DateTime($row['Date_Created']);
                          $f_created_at = $created_at->format('m/d/Y h:i:s');
                          $updated_at = new DateTime($row['Date_Updated']);
                          $f_updated_at = $updated_at->format('m/d/Y h:i:s');
                          echo'<tr class="align-items-center">';
                          echo'<td class="px-3 pr-4">'.$row['Recipe_Name'].'</td>';
                          echo'<td class="px-3 text-center"><img src="'.$row['Rcp_Picture'].'" alt="Recipe Image" style="max-width: 100px;"></td>';
                          if(isset($result2[$row['Recipe_Name']])){
                            $categories = $result2[$row['Recipe_Name']];
                            $categoryHTML = '';
                            foreach($categories as $index => $categoryname){
                              if($index > 0){
                                $categoryHTML .= ' ';
                              }
                              $categoryHTML .= '<span class="badge badge-warning">'.$categoryname.'</span>';
                            }
                            echo '<td class="pl-5 pr-0 py-2 text-wrap">'.$categoryHTML.'</td>';
      
                          echo'<td class="px-3">'.$row['Preparation_Time'].' mins</td>';
                          echo'<td class="px-3">'.$row['Cook_Time'].' mins</td>';
                          echo'<td class="px-2">'.$f_created_at.'</td>';
                          echo'<td class="px-0">'.$f_updated_at.'</td>';
                          echo'<td class="px-3 py-2 d-flex align-items-center text-nowrap">';
                          echo'<form action="" method="post">';
                          echo '<input type="hidden" name="recipe_name" value="'.htmlentities($row['Recipe_Name']).'">';
                          echo'<a href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/recipepage.php?recipe_id='.htmlentities($row['Recipe_ID']).'" target="_blank" class="link text-primary h4 mx-1" title="View Recipe"><i class="bi-box-arrow-in-right"></i></a>';
                          echo'<a href="http://localhost/RecipeSharing_WebApp/baker/update_recipe.php?recipe_id='.htmlentities($row['Recipe_ID']).'" class="link text-info h5 mx-1" title="Edit Recipe"><i class="bi bi-pencil-square"></i></a>';
                          echo '<button type="submit" value="' . htmlentities($row['Recipe_ID']) . '" name="delete" class="btn btn-link btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Delete Recipe" style="padding:0.1rem; padding-bottom: 0.1px; border: none;"><h5><i class="bi bi-trash3"></i></h5></button>';                    
                        } 
                        echo'</form>';
                        }
                       } else{
                        echo "<h5 class='text-danger d-flex justify-content-center py-2'><strong>Sorry, no result found.</strong></h5>";
                        }
                      } elseif(!empty($result)){
                        if(isset($result)){
                      ?>
                        <table id="example2" class="table table-black text-nowrap table-striped">
                        <thead>
                        <tr class="text-dark">
                          <th class="px-3 pr-4">Recipe Name</th>
                          <th class="px-3 text-center">Recipe Image</th>
                          <th class="pl-5 pr-0">Category/s</th>
                          <th class="px-3">Prep Time</th>
                          <th class="px-3">Cook Time</th>
                          <th class="px-2">Date Created</th>
                          <th class="px-0">Date Updated</th>
                          <th class="px-3 text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-dark text-wrap">
                        <?php
                          foreach($result as $key => $row){
                           $created_at = new DateTime($row['Date_Created']);
                           $f_created_at = $created_at->format('m/d/Y h:i:s');
                           $updated_at = new DateTime($row['Date_Updated']);
                           $f_updated_at = $updated_at->format('m/d/Y h:i:s');
                           echo'<tr class="align-items-center">';
                           echo'<td class="px-3 pr-4">'.$row['Recipe_Name'].'</td>';
                           echo'<td class="px-3 text-center"><img src="'.$row['Rcp_Picture'].'" alt="Recipe Image" style="max-width: 100px;"></td>';
                           if(isset($result2[$row['Recipe_Name']])){
                             $categories = $result2[$row['Recipe_Name']];
                             $categoryHTML = '';
                             foreach($categories as $index => $categoryname){
                               if($index > 0){
                                 $categoryHTML .= ' ';
                               }
                               $categoryHTML .= '<span class="badge badge-warning">'.$categoryname.'</span>';
                             }
                             echo '<td class="pl-5 pr-0 py-2 text-wrap">'.$categoryHTML.'</td>';
                           }
                           echo'<td class="px-3">'.$row['Preparation_Time'].' mins</td>';
                           echo'<td class="px-3">'.$row['Cook_Time'].' mins</td>';
                           echo'<td class="px-2">'.$f_created_at.'</td>';
                           echo'<td class="px-0">'.$f_updated_at.'</td>';
                           echo'<td class="px-3 py-2 d-flex align-items-center text-nowrap">';
                           echo'<form action="" method="post">';
                           echo '<input type="hidden" name="recipe_name" value="'.htmlentities($row['Recipe_Name']).'">';
                           echo'<a href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/recipepage.php?recipe_id='.htmlentities($row['Recipe_ID']).'" target="_blank" class="link text-primary h4 mx-1" title="View Recipe"><i class="bi-box-arrow-in-right"></i></a>';
                           echo'<a href="http://localhost/RecipeSharing_WebApp/baker/update_recipe.php?recipe_id='.htmlentities($row['Recipe_ID']).'" class="link text-info h5 mx-1" title="Edit Recipe"><i class="bi bi-pencil-square"></i></a>';
                           echo '<button type="submit" value="' . htmlentities($row['Recipe_ID']) . '" name="delete" class="btn btn-link btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Delete Recipe" style="padding:0.1rem; padding-bottom: 0.1px; border: none;"><h5><i class="bi bi-trash3"></i></h5></button>';
                         echo'</form>';
                         }
                      } else{
                        echo "<h5 class='text-danger d-flex justify-content-center py-2'><strong>Sorry, no result found.</strong></h5>";
                      }
                      }
                      // Display modal confirmation dialog
                      if(isset($_POST['delete'])){
                          $deleteRecipeId = $_POST['delete'];
                          $Recipe_Name = $_POST['recipe_name'];
                          echo '<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block; background-color: rgba(0,0,0,0.5); position: fixed; top: 0; bottom: 0; left: 0; right: 0;">
                          <div class="modal-dialog modal-dialog-centered" role="modal" style="margin: auto;max-width: 480px;">
                              <div class="modal-content">
                                  <div class="modal-header bg-dark py-2">
                                      <h4 class="modal-title" id="exampleModalLabel">Delete Confirmation</h4>
                                      <button type="button" class="btn-close col-sm-1 p-0 rounded" data-bs-dismiss="modal" style="background-color: transparent; color:white; font-size:22px; padding: 3px; margin: 0px;"aria-label="Close">&times;</button>
                                  </div>
                                  <div class="modal-body col text-wrap">
                                      <p>Are you sure you want to permanently delete this "'.$Recipe_Name.'" recipe?</p>
                                  </div>
                                  <div class="modal-footer py-1">
                                  <form id="deleteForm" action="" method="post">
                                        <input type="hidden" name="recipe_id" id="deleteUserID" value="'.htmlentities($deleteRecipeId).'">
                                        <button type="submit" name="delete_true" value="1" class="btn btn-danger col-6 mx-1">Delete</button>
                                        <button type="button" class="btn btn-outline-info btn-close col-6 mx-0"  data-bs-dismiss="modal">Cancel</button>
                                  </form> 
                                </div>
                              </div>
                          </div>
                        </div>';
                        } 
                      }
                  ?>
                  </td></tr> 
                </tbody>
              </table>
              </div>
              <!-- /.card-footer -->
              <div class="card-footer bg-transparent border rounded-bottom pb-0" aria-label="Page navigation example">
              <p class="text-muted float-left justify-content-start pt-2"><?php if($num_of_pages > 0){echo'Showing '.$start.' of '.$num_of_pages.' pages';} else{echo 'No pages to show';} ?></p>
                <ul class="pagination justify-content-end mb-2">
                <li class="page-item <?php if($start <= 1){ echo 'disabled'; } ?>">
                  <a class="page-link text-bold" href="?page=<?php echo $start - 1; ?><?php echo !empty($search) ? '&table_search=' . urlencode($search) : ''; ?>" aria-label="Previous">
                    <span aria-hidden="true">&lsaquo;</span>
                  </a>
                </li>
                <?php for($i = 1; $i <= $num_of_pages; $i++): ?>
                  <li class="page-item <?php if($start == $i){ echo 'active'; } ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&table_search=' . urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                  </li>
                <?php endfor; ?>
                <li class="page-item <?php if($start >= $num_of_pages){ echo 'disabled'; } ?>">
                  <a class="page-link text-bold" href="?page=<?php echo $start + 1; ?><?php echo !empty($search) ? '&table_search=' . urlencode($search) : ''; ?>" aria-label="Next">
                    <span aria-hidden="true">&rsaquo;</span>
                  </a>
                </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </section>
      <script>
        const exampleModal = document.getElementById('exampleModal');
        if (exampleModal) {
          // Closes the modal when clicking the cancel or x button
          const closeButton = exampleModal.querySelector('.btn-close');
          const cancelButton = exampleModal.querySelector('.btn.btn-outline-info.btn-close');
          closeButton.addEventListener('click', () => closeModal());
          cancelButton.addEventListener('click', () => closeModal());

          function closeModal(){
            exampleModal.classList.remove('show');
            exampleModal.setAttribute('aria-hidden', 'true');
            exampleModal.setAttribute('style', 'display: none;');
          }
        }
        // Delete Specifier (Recipe_ID)
        document.querySelectorAll('button[name="delete_true"]').forEach(button =>{
          button.addEventListener('click', function(){
            const userId = this.target.value;
            document.getElementById('deleteUserID').value = userId;
          });
        });
      </script>
  <!-- Control Sidebar -->
  <br>
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
