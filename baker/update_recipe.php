<?php
  session_start();
  require_once('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');
  $result1= retrieve_dessert_type();
  $result2= retrieve_dietary();
  $result3= retrieve_cuisine();
  $result4= retrieve_occasion();
  $conn = getDatabaseConnection();

  if (!isset($_SESSION['useremail']) && !isset($_SESSION['userpass'])){
    // Not logged in or not an admin
    header("Location: http://localhost/RecipeSharing_WebApp/login/signin.php");
    exit();
  }

  $recipe_ID = $_GET['recipe_id'];
  $recipedetails = getrecipedetails($recipe_ID);

  $rcp_error="";
  $descrp_error="";
  $prep_error="";
  $cook_error="";
  $serving_error="";
  $categoryerror="";
  $ingred_error="";
  $steperror="";
  $reminderror="";
  $pic_error="";
  $Category_Names = [];
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){
    $Recipe_ID = $recipe_ID;
    $Recipe_Name = $_POST['recipe_name'];
    $Rcp_Description = $_POST['description'];
    $Preparation_Time = $_POST['prep_time'];
    $Cook_Time = $_POST['cook_time'];
    $Servings = $_POST['servings'];
    $Category_Names = isset($_POST['categories']) ? $_POST['categories'] : [];
    $ingredients = isset($_POST['ingredient']) ? $_POST['ingredient'] : [];
    $quantities = isset($_POST['ingredient2']) ? $_POST['ingredient2'] : [];
    $units = isset($_POST['ingredient3']) ? $_POST['ingredient3'] : [];
    $steps = isset($_POST['step_description']) ? $_POST['step_description']: [];
    $reminders = isset($_POST['reminder_description']) ? $_POST['reminder_description']: [];

    // File image handling
    $Rcp_Picture = '';
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] == UPLOAD_ERR_OK){
      $upload_dir = 'uploads/';
      if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }
      $file_name = basename($_FILES['recipe_image']['name']);
      $target_file = $upload_dir . $file_name;
      if (move_uploaded_file($_FILES['recipe_image']['tmp_name'], $target_file)){
        $Rcp_Picture = $target_file;
      } else{
        // Handle upload failure
        echo "Failed to upload file.";
      }
    } else{
      $Rcp_Picture = htmlspecialchars($recipedetails['Rcp_Picture']);
    }

    //Recipe Form Validation
    if(empty($Recipe_Name)){
      $rcp_error= "Required";
    } else{
      $Recipe_Name= trim(htmlspecialchars($Recipe_Name));
      if(!preg_match("/^(?![0-9]+$).+$/", $Recipe_Name)){
        $rcp_error= "Must not contain only numbers.";
      }
    }
    if(empty($Rcp_Description)){
      $descrp_error= "Required";
    } else{
      $Rcp_Description= trim(htmlspecialchars($Rcp_Description));
    }
    if(empty($Preparation_Time)){
      $prep_error= "!";
    } else{
      $Preparation_Time= trim(htmlspecialchars($Preparation_Time));
    }
    if(empty($Cook_Time)){
      $cook_error= "!";
    } else{
      $Cook_Time= trim(htmlspecialchars($Cook_Time));
    }
    if(empty($Servings)){
      $serving_error= "!";
    } else{
      $Servings= trim(htmlspecialchars($Servings));
    }
    if(empty($Category_Names) || !is_array($Category_Names)){
      $categoryerror = "!";
    } else {
      foreach ($Category_Names as &$category){
        $category = trim(htmlspecialchars($category));
      }
      unset($category);
    }

    if(isset($ingredients) && isset($quantities) && isset($units)){
      if(empty($ingredients) || empty($quantities) || empty($units)){
        $ingred_error = "All ingredient details are required, avoid leaving empty values in the form. Please try again!";
      } else{
        $count_ingredients = count($ingredients);
        $count_quantities = count($quantities);
        $count_units = count($units);
        if($count_ingredients != $count_quantities || $count_quantities != $count_units){
          $ingred_error = "All ingredient details are required, avoid leaving empty values in the form. Please try again!";
        } else{
          $allfilled = true;
          for ($i = 0; $i < $count_ingredients; $i++){
            if(empty($ingredients[$i]) || empty($quantities[$i]) || empty($units[$i])) {
              $allfilled = false;
              break;
            }
          }
          if(!$allfilled){
            $ingred_error = "All ingredient details are required, avoid leaving empty values in the form. Please try again!";
          } else{
            foreach($ingredients as &$ingredient){
              $ingredient = trim(htmlspecialchars($ingredient));
            }
            foreach($quantities as &$quantity){
              $quantity = trim(htmlspecialchars($quantity));
            }
            foreach($units as &$unit){
              $unit = trim(htmlspecialchars($unit));
            }
            unset($ingredient);
            unset($quantity);
            unset($unit);
          }
        }
      }
    } else{
    $ingred_error = "All ingredient details are required, avoid leaving empty values in the form. Please try again!";
    }

    if(empty($steps)){
        $steperror= "Instruction details are required, avoid leaving empty values in the form. Please try again!";
    } else{
      $allStepsfilled = true;
      foreach($steps as &$step){
        $step= trim(htmlspecialchars($step));
        if(empty($step)){
          $allStepsfilled = false;
        }
      }
      unset($step);
      if(!$allStepsfilled){
        $steperror = "Instruction details are required, avoid leaving empty values in the form. Please try again!";
      }
    }
    if(empty($reminders)){
      $reminderror= "Reminder details are required, avoid leaving empty values in the form. Please try again!";
    } else{
      $allremindsfilled = true;
      foreach($reminders as &$reminder){
        $reminder= trim(htmlspecialchars($reminder));
        if(empty($reminder)){
          $allremindsfilled = false;
        }
      }
      unset($reminder);
      if(!$allremindsfilled){
        $reminderror= "Reminder details are required, avoid leaving empty values in the form. Please try again!";
      }
    }

    if($Rcp_Picture === 'http://localhost/RecipeSharing_WebApp/assets/dist/img/default_image.jpg'){
      $pic_error= "Required";
    }

    if(empty($rcp_error) && empty($descrp_error) && empty($prep_error) && empty($cook_error) && empty($serving_error) && empty($categoryerror) && empty($ingred_error) && empty($steperror) && empty($reminderror) && empty($pic_error)){
      try{
        updatedata3($Recipe_ID, $Recipe_Name, $Rcp_Description, $Preparation_Time, $Cook_Time, $Servings, $Rcp_Picture, $Category_Names, $ingredients, $quantities, $units, $steps, $reminders);
        header("Location: http://localhost/RecipeSharing_WebApp/baker/index2.php");
        exit();
      } catch(Exception $e){
        echo "Error: " . htmlspecialchars($e->getMessage());
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
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-gradient-dark">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard2.php" class="text-warning">Home</a></li>
              <li class="breadcrumb-item"><a href="index2.php" class="text-warning">Manage Recipes</a></li>
              <li class="breadcrumb-item active text-white-50">Update Recipe</li>
            </ol>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-auto">
            <h1><b>Update Recipe</b></h1>
            <span>Enter your recipe details to be updated on the platform.</span>
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
          <div class="col-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header bg-dark d-inline-flex align-items-center py-2">
                <h5 class="my-0">Recipe Details</h5>
                <a href="http://localhost/RecipeSharing_WebApp/baker/index2.php" class="btn ml-auto">
                  <i class="bi bi-arrow-return-left h5"></i>
                </a>
              </div>
              <!-- /.card-header -->
              <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="recipe_ID" value="<?php echo htmlspecialchars($recipedetails['Recipe_ID']); ?>">
                <div class="card-body text-dark">
                 <div class="row d-grid gx-3 align-items-center">
                  <div class="col-5 form-group mb-4">
                    <label >Recipe Name</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($rcp_error)) echo'<i class="far fa-times-circle"></i> '.$rcp_error.'';?></label>
                    <input type="text" class="form-control <?php if(!empty($rcp_error))echo 'border-danger';?>" name="recipe_name" placeholder="Enter recipe name" value="<?php echo $recipedetails['Recipe_Name']; ?>">
                  </div>
                  <div class="col form-group mb-4">
                    <label>Prep Time</label><span><small> (in minutes)</small></span><?php if(!empty($prep_error)) echo'<span class="bg-danger ml-1 px-2 rounded-pill text-xs text-bold" for="inputError"><i class="far fa-times-circle"></i> '.$prep_error.'';?></span>
                    <input type="text" class="form-control <?php if(!empty($prep_error))echo 'border-danger';?>" name="prep_time" placeholder="Enter number" value="<?php echo htmlspecialchars($recipedetails['Preparation_Time']); ?>">
                  </div>
                  <div class="col form-group mb-4">
                    <label>Cook Time</label><span><small> (in minutes)</small></span><?php if(!empty($cook_error)) echo'<span class="bg-danger ml-1 px-2 rounded-pill text-xs text-bold" for="inputError"><i class="far fa-times-circle"></i> '.$cook_error.'';?></span>
                    <input type="text" class="form-control <?php if(!empty($cook_error))echo 'border-danger';?>" name="cook_time" placeholder="Enter number" value="<?php echo htmlspecialchars($recipedetails['Cook_Time']); ?>">
                  </div>
                  <div class="col form-group mb-4">
                    <label >Servings</label><span><small> (yields)</small></span><?php if(!empty($serving_error)) echo'<span class="bg-danger ml-1 px-2 rounded-pill text-xs text-bold" for="inputError"><i class="far fa-times-circle"></i> '.$serving_error.'';?></span>
                    <input type="text" class="form-control <?php if(!empty($serving_error))echo 'border-danger';?>" name="servings" placeholder="Enter number" value="<?php echo htmlspecialchars($recipedetails['Servings']); ?>">
                  </div>
                 </div>
                 <div class="row d-grid gx-3">
                    <div class="col-7 form-group mb-4">
                      <label >Recipe Description</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($descrp_error)) echo'<i class="far fa-times-circle"></i> '.$descrp_error.'';?></label>
                        <textarea class="form-control pb-5 <?php if(!empty($descrp_error))echo 'border-danger';?>" name="description" placeholder="Enter recipe description"><?php echo $recipedetails['Rcp_Description']; ?></textarea>
                    </div>
                    <div class="col form-group mb-0 row">
                      <div class="col form-group select2-orange">
                        <label class="mb-0">Recipe Category/s</label><?php if(!empty($categoryerror)) echo'<span class="bg-danger ml-1 px-2 rounded-pill text-xs text-bold" for="inputError"><i class="far fa-times-circle"></i> '.htmlspecialchars($categoryerror).'';?></span><br>
                        <span>Dessert Type</span>
                        <select class="select2 mb-3" multiple="multiple" name="categories[]" data-placeholder="Select recipe category/s" data-dropdown-css-class="select2-dark" style="width: 100%;">
                          <?php foreach ($result1 as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['Category_ID']); ?>"
                              <?php foreach ($recipedetails['categories'] as $recipeCategory){
                                if($recipeCategory['Category_ID'] == $category['Category_ID']) {
                                  echo 'selected';
                                  break;
                                }
                              }
                            ?>>
                            <?php echo htmlspecialchars($category['Category_Name']); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <div class="mb-2"></div>
                        <span>Dietary Restriction</span>
                        <select class="select2" multiple="multiple" name="categories[]" data-placeholder="Select recipe category/s" data-dropdown-css-class="select2-dark" style="width: 100%;">
                          <?php foreach ($result2 as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['Category_ID']); ?>"
                              <?php foreach ($recipedetails['categories'] as $recipeCategory){
                                if($recipeCategory['Category_ID'] == $category['Category_ID']) {
                                  echo 'selected';
                                  break;
                                }
                              }
                            ?>>
                            <?php echo htmlspecialchars($category['Category_Name']); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col form-group select2-orange">
                        <br>
                        <span>Cuisine</span>
                        <select class="select2" multiple="multiple" name="categories[]" data-placeholder="Select recipe category/s" data-dropdown-css-class="select2-dark" style="width: 100%;">
                          <?php foreach ($result3 as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['Category_ID']); ?>"
                              <?php foreach ($recipedetails['categories'] as $recipeCategory){
                                if($recipeCategory['Category_ID'] == $category['Category_ID']) {
                                  echo 'selected';
                                  break;
                                }
                              }
                            ?>>
                            <?php echo htmlspecialchars($category['Category_Name']); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <div class="mb-2"></div>
                        <span>Occasion</span>
                        <select class="select2" multiple="multiple" name="categories[]" data-placeholder="Select recipe category/s" data-dropdown-css-class="select2-dark" style="width: 100%;">
                          <?php foreach ($result4 as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['Category_ID']); ?>"
                              <?php foreach ($recipedetails['categories'] as $recipeCategory){
                                if($recipeCategory['Category_ID'] == $category['Category_ID']) {
                                  echo 'selected';
                                  break;
                                }
                              }
                            ?>>
                            <?php echo htmlspecialchars($category['Category_Name']); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group mb-4">
                  <label for="customFile">Recipe Image</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($pic_error)) echo'<i class="far fa-times-circle"></i> '.$pic_error.'';?></label>
                    <div class="custom-fil col-7">
                      <input type="file" name="recipe_image" class="custom-file-input" id="customFile">
                      <label class="custom-file-label" for="customFile">Update image file</label>
                    </div>
                    <img id="imagePreview" src="<?php echo htmlspecialchars($recipedetails['Rcp_Picture']); ?>" alt="Image Preview" style=" max-width: 200px; margin-top: 10px; display: <?php echo !empty($recipedetails['Rcp_Picture']) ? 'block' : 'none'; ?>;">
                    </div>
                  <label>Recipe Ingredients</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($ingred_error)) echo'<i class="far fa-times-circle"></i> '.$ingred_error.'';?></label>
                    <button type="button" class="btn btn-success col" id="addIngredient"><i class="bi bi-file-earmark-plus h5"></i> Add Ingredient</button>
                  <div class="row d-grid pt-3 mb-2" id="ingredientList">
                    <?php if (!empty($recipedetails['ingredients'])): ?>
                      <?php foreach ($recipedetails['ingredients'] as $ingredient): ?>
                        <div class="col-12 form-group py-0 my-0">
                          <div class="input-group my-0">
                            <input type="text" name="ingredient[]" class="form-control" value="<?php echo $ingredient['Ingredient_Name']; ?>" placeholder="Enter ingredient name">
                            <input type="text" name="ingredient2[]" class="form-control" value="<?php echo $ingredient['Ingredient_quantity']; ?>" placeholder="Enter ingredient quantity">
                            <input type="text" name="ingredient3[]" class="form-control rounded-right" value="<?php echo $ingredient['Ingredient_unit']; ?>" placeholder="Enter ingredient unit (e.g. tsp, tbsp)">
                            <button class="btn remove-ingredient" type="button"><h5><i class="bi bi-x-circle text-danger"></i></h5></button>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                  <label>Recipe Instructions</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($steperror)) echo'<i class="far fa-times-circle"></i> '.$steperror.'';?></label>
                    <button type="button" class="btn btn-success col" id="addInstruction"><i class="bi bi-file-earmark-plus h5"></i> Add Instruction</button>
                  <div class="row d-grid pt-3 mb-2" id="instructionList">
                  <?php if (!empty($recipedetails['steps'])): ?>
                    <?php foreach ($recipedetails['steps'] as $index => $step): ?>
                      <div class="col-12 form-group py-0 my-0">
                        <div class="input-group mb-2">
                          <span class="input-group-text"><?php echo $index + 1; ?></span>
                          <textarea name="step_description[]" class="form-control pl-6 rounded-right <?php if(empty($step))echo 'border-danger';?>" placeholder="Enter the instruction description"><?php echo $step['Step_description']; ?></textarea>
                          <button class="btn remove-instruction" type="button"><h5><i class="bi bi-x-circle text-danger"></i></h5></button>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  </div>
                  <label>Recipe Baking Reminders</label><label class="bg-danger ml-1 px-2 rounded-pill text-xs" for="inputError"><?php if(!empty($reminderror)) echo'<i class="far fa-times-circle"></i> '.$reminderror.'';?></label>
                    <button type="button" class="btn btn-success col" id="addReminder"><i class="bi bi-file-earmark-plus h5"></i> Add Reminder</button>
                  <div class="row d-grid pt-3 mb-2" id="reminderList">
                  <?php if (!empty($recipedetails['reminders'])): ?>
                    <?php foreach ($recipedetails['reminders'] as $index => $reminder): ?>
                      <div class="col-12 form-group py-0 my-0">
                        <div class="input-group mb-2">
                          <span class="input-group-text"><?php echo $index + 1; ?></span>
                          <textarea name="reminder_description[]" class="form-control pl-6 rounded-right <?php if(empty($reminder))echo 'border-danger';?>" placeholder="Enter the baking reminder description"><?php echo $reminder['Reminder_description']; ?></textarea>
                          <button class="btn remove-reminder" type="button"><h5><i class="bi bi-x-circle text-danger"></i></h5></button>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
                </div>
                <div class="card-footer" style= "text-align:center; background-color: #272727;">
                  <button type="submit" name="save" value="submit" class="btn bg-gradient-orange col-4 py-2 mx-1">Update</button>
                  <button type="reset" class="btn btn-danger col-4 py-2" onclick="resetSelect2()">Cancel</button>
                </div>
              </form>
            </div>
      </section>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        $(document).ready(function() {
            $('#addIngredient').click(function() {
                $('#ingredientList').append(`
                    <div class="col-12 form-group py-0 my-0">
                        <div class="input-group my-0">
                        <input type="text" name="ingredient[]" class="form-control" placeholder="Enter ingredient name" class="form-control">
                        <input type="text" name="ingredient2[]" class="form-control" placeholder="Enter ingredient quantity">
                        <input type="text" name="ingredient3[]" class="form-control rounded-right" placeholder="Enter ingredient unit (e.g. tsp, tbsp)">
                        <button class="btn remove-ingredient" type="button"><h5><i class="bi bi-x-circle text-danger"></i></h5></button>
                        </div>
                    </div>
                `);
            });
            $(document).on('click', '.remove-ingredient', function() {
                $(this).closest('.form-group').remove();
            });
        });
    </script>
    <script>
    $('#addInstruction').click(function() {
      var stepNumber = $('#instructionList .input-group').length + 1;
        $('#instructionList').append(`
            <div class="col-12 form-group py-0 my-0">
              <div class="input-group mb-2">
              <span class="input-group-text">` + stepNumber + `</span>
              <textarea name="step_description[]" class="form-control pl-6 rounded-right" placeholder="Enter the instruction description"></textarea>
              <button class="btn remove-instruction" type="button"><h5><i class="bi bi-x-circle text-danger"></i></h5></button>
              </div>
            </div>
        `);
    });
    $(document).on('click', '.remove-instruction', function() {
        $(this).closest('.form-group').remove();
        // Update step numbers after removal
        $('#instructionList .input-group-text').each(function(index) {
            $(this).text(index + 1);
        });
    });

    $('#addReminder').click(function() {
      var reminderNumber = $('#reminderList .input-group').length + 1;
        $('#reminderList').append(`
            <div class="col-12 form-group py-0 my-0">
              <div class="input-group mb-2">
              <span class="input-group-text">` + reminderNumber + `</span>
              <textarea name="reminder_description[]" class="form-control pl-6 rounded-right" placeholder="Enter the baking reminder description"></textarea>
              <button class="btn remove-reminder" type="button"><h5><i class="bi bi-x-circle text-danger"></i></h5></button>
              </div>
            </div>
        `);
      });
      $(document).on('click', '.remove-reminder', function() {
        $(this).closest('.form-group').remove();
         // Update reminder numbers after removal
         $('#reminderList .input-group-text').each(function(index) {
            $(this).text(index + 1);
        });
      });
    </script>
    <script>
    $(document).ready(function(){
     $('#customFile').on('change', function(){
      var file = this.files[0];
      if(file){
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#imagePreview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);

        var fileName = file.name;
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      }
    });

    var existingImageUrl = "<?php echo htmlspecialchars($recipedetails['Rcp_Picture']); ?>";
    if (existingImageUrl){
      $('#imagePreview').attr('src', existingImageUrl).show();
    }
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

<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/moment/moment.min.js"></script>
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="http://localhost/RecipeSharing_WebApp/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="http://localhost/RecipeSharing_WebApp/assets/dist/js/demo.js"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script>
  function resetSelect2(){
    $('.select2').val(null).trigger('change');
  };
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
</body>
</html>