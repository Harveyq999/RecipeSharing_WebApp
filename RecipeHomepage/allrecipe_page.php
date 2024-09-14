<?php
  require_once('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');
  $conn = getDatabaseConnection();
  $result1= retrieve_dessert_type();
  $result2= retrieve_dietary();
  $result3= retrieve_cuisine();
  $result4= retrieve_occasion();
  // Simple search parameter
  $search_home = isset($_GET['home_search']) ? htmlspecialchars($_GET['home_search']) : '';
  // Pagination parameter
  $category_name = isset($_GET['ctr_name']) ? $_GET['ctr_name'] : null;
  // Advanced search parameters
  $recipe_name = isset($_GET['recipe_name']) ? $_GET['recipe_name'] : '';
  $prep_time = isset($_GET['prep_time']) ? $_GET['prep_time'] : '';
  $cook_time = isset($_GET['cook_time']) ? $_GET['cook_time'] : '';
  $servings = isset($_GET['servings']) ? $_GET['servings'] : '';
  $ingredients = isset($_GET['ingredients']) ? $_GET['ingredients'] : [];
  $categories = isset($_GET['categories']) ? $_GET['categories'] : [];

  function advanced_searchQuery($recipe_name = '', $ingredients = [], $categories = [], $prep_time = '', $cook_time = '', $servings = ''){
    $queryString = '';
    if(!empty($recipe_name)){
      $queryString .= '&recipe_name=' . urlencode($recipe_name);
    }
    if(!empty($ingredients)){
      foreach($ingredients as $ingredient){
        $queryString .= '&ingredients[]=' . urlencode($ingredient);
      }
    }
    if(!empty($categories)){
      foreach($categories as $category){
        $queryString .= '&categories[]=' . urlencode($category);
      }
    }
    if(!empty($prep_time)){
      $queryString .= '&prep_time=' . urlencode($prep_time);
    }
    if(!empty($cook_time)){
      $queryString .= '&cook_time=' . urlencode($cook_time);
    }
    if(!empty($servings)){
      $queryString .= '&servings=' . urlencode($servings);
    }
    return $queryString ? ltrim($queryString, '&') : '';
  }
?>


<!DOCTYPE html>
<html lang="en">
<head><script src="/docs/5.3/assets/js/color-modes.js"></script>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="IT263Act" content="">
   <meta name="author" content="">
   <title>SimpleSweets Recipe Sharing Application</title>
   <link rel="icon" type="image/jpg" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/cookielogo.png">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Pacifico&family=Russo+One&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/dist/css/adminlte.min.css">
   <!-- Favicons -->
   <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
   <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
   <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
   <link rel="manifest" href="/docs/5.3/assets/img/favicons/manifest.json">
   <link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
   <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon.ico">
   <link rel="stylesheet" href="style.css">
   <style>
    .page-item:not(.active) .pageback:hover{
      background-color: #6c757d !important;
    }

    .page-item:not(.disabled) .bi-chevron-left:hover, .page-item:not(.disabled) .bi-chevron-right:hover, .page-item:not(.disabled) .bi-chevron-double-right:hover, .page-item:not(.disabled) .bi-chevron-double-left:hover{
      color: rgba(255, 255, 255, 0.5) !important;
    }
    .disabled-search{
    pointer-events: none;
    color: #adb5bd;
    cursor: not-allowed;
    }
    .enabled-search{
    pointer-events: auto;
    cursor: pointer;
    }
   </style>
</head>
<body>
<div>
<nav class="navbar navbar-expand-md bg-body-tertiary sticky-top" data-bs-theme="dark">
  <div class="container" id="navbarElements">
    <div class="mx-1" id="navbrand"> SimpleSweets</div><img src="cookielogo.png" alt="Brand Logo" width="33" style="margin-right: 5px;" class="rotate-in-center">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link mr-2 pr-2" style="font-size: 0.9rem;" aria-current="page" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/rcp_homepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2 pr-2 <?php if(empty($category_name) && empty($search_home) && empty($recipe_name) && empty($ingredients) && empty($categories) && empty($prep_time) && empty($cook_time) && empty($servings)) echo 'active';?>"  style="font-size: 0.9rem;" aria-current="page" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/allrecipe_page.php">All Recipes</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($category_name, array_column($result1, 'Category_Name')) ? 'active' : ''; ?>" style="font-size: 0.9rem;" data-bs-toggle="dropdown" aria-expanded="true">
            Desserts
          </a>
          <ul class="dropdown-menu dropdown-menu-end dark-mode">
          <?php foreach ($result1 as $index => $category): ?>
            <li><a class="dropdown-item text-sm py-1 <?php echo $category['Category_Name'] == $category_name ? 'active bg-gradient-orange disabled' : ''; ?>" href="?ctr_name=<?php echo urlencode($category['Category_Name']); ?>"><?php echo $category['Category_Name'];?></a></li>
            <?php if ($index < count($result1) - 1): ?>
                <hr class="dropdown-divider my-0">
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($category_name, array_column($result2, 'Category_Name')) ? 'active' : ''; ?>"  style="font-size: 0.9rem;" data-bs-toggle="dropdown" aria-expanded="true">
            Dietaries
          </a>
          <ul class="dropdown-menu dropdown-menu-end dark-mode">
          <?php foreach ($result2 as $index => $category): ?>
            <li><a class="dropdown-item text-sm py-1 <?php echo $category['Category_Name'] == $category_name ? 'active bg-gradient-orange disabled' : ''; ?>" href="?ctr_name=<?php echo urlencode($category['Category_Name']); ?>"><?php echo $category['Category_Name'];?></a></li>
            <?php if ($index < count($result2) - 1): ?>
                <hr class="dropdown-divider my-0">
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($category_name, array_column($result3, 'Category_Name')) ? 'active' : ''; ?>"  style="font-size: 0.9rem;" data-bs-toggle="dropdown" aria-expanded="true">
            Cuisines
          </a>
          <ul class="dropdown-menu dropdown-menu-end dark-mode">
          <?php foreach ($result3 as $index => $category): ?>
            <li><a class="dropdown-item text-sm py-1 <?php echo $category['Category_Name'] == $category_name ? 'active bg-gradient-orange disabled' : ''; ?>" href="?ctr_name=<?php echo urlencode($category['Category_Name']); ?>"><?php echo $category['Category_Name'];?></a></li>
            <?php if ($index < count($result3) - 1): ?>
                <hr class="dropdown-divider my-0">
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($category_name, array_column($result4, 'Category_Name')) ? 'active' : ''; ?>" style="font-size: 0.9rem;" data-bs-toggle="dropdown" aria-expanded="true">
            Occasions
          </a>
          <ul class="dropdown-menu dropdown-menu-end dark-mode">
          <?php foreach ($result4 as $index => $category): ?>
            <li><a class="dropdown-item text-sm py-1 <?php echo $category['Category_Name'] == $category_name ? 'active bg-gradient-orange disabled' : ''; ?>" href="?ctr_name=<?php echo urlencode($category['Category_Name']); ?>"><?php echo $category['Category_Name'];?></a></li>
            <?php if ($index < count($result4) - 1): ?>
                <hr class="dropdown-divider my-0">
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(!empty($search_home) || !empty($recipe_name) || !empty($ingredients) || !empty($categories) || !empty($prep_time) || !empty($cook_time) || !empty($servings)) echo 'active';?>" data-widget="navbar-search" href="#" role="button" id="searchIcon">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block w-100" id="searchBar" style="display: none;">
          <form class="form-inline d-flex justify-content-center" method="GET" action="allrecipe_page.php">
          <input type="hidden" name="page" value="1">
            <div class="input-group input-group-sm col-sm-6">
              <input class="form-control form-control-navbar" id="navsearch-input" type="search" name="home_search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar disabled-search" id="navsearch-button" style="background-color: #fff; border: 1px solid #ced4da;" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar btn-light bg-gray-light" style="border: 1px solid #ced4da;" type="button" data-widget="navbar-search" id="closeSearch">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
        </li>
        <li class="nav-item">
          <a class="btn btn-link text-dark py-1 px-3 ml-3" href="http://localhost/RecipeSharing_WebApp/login/signin.php" style= "background-color:#fda41f;"><i class="bi bi-person-circle fs-5"></i><h7> Sign in</h7></a>
        </li>
      </ul>
    </div>
  </div>
  <div id="overlay" style="display: none;"></div>
</nav>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchIcon = document.getElementById('searchIcon');
    const searchBar = document.getElementById('searchBar');
    const navbarElements = document.getElementById('navbarElements');
    const closeSearch = document.getElementById('closeSearch');
    const overlay = document.getElementById('overlay');

    searchIcon.addEventListener('click', function(){
      searchBar.style.display = 'block';
      overlay.style.display = 'block';
    });

    closeSearch.addEventListener('click', function(){
      searchBar.style.display = 'none';
      navbarElements.style.display = 'flex';
      overlay.style.display = 'none';
    });

    overlay.addEventListener('click', function(){
    searchBar.style.display = 'none';
    navbarElements.style.display = 'flex';
    overlay.style.display = 'none';
    });
  });
  document.addEventListener('DOMContentLoaded', function(){
    var searchInputnav = document.getElementById('navsearch-input');
    var searchButtonnav = document.getElementById('navsearch-button');

    function toggleButtonStatenav(){
        if (searchInputnav.value.trim()) {
            searchButtonnav.classList.remove('disabled-search');
            searchButtonnav.classList.add('enabled-search');
        } else{
            searchButtonnav.classList.remove('enabled-search');
            searchButtonnav.classList.add('disabled-search');
        }
    }
    searchInputnav.addEventListener('input', toggleButtonStatenav);
    toggleButtonStatenav();
  });
</script>
<main>
<div class="album py-5 bg-dark">
<div class= "col bg-blue py-3">
  <h1 class="text-center scale-in-center"><?php if(!empty($category_name)){ echo $category_name.' '.'Recipes'; } elseif(!empty($search_home)){ echo 'Recipe Search'; } elseif(!empty($recipe_name) || !empty($ingredients) || !empty($categories) || !empty($prep_time) || !empty($cook_time) || !empty($servings)){ echo 'Advanced Recipe Search'; } else{ echo 'All Recipes';}?></h1>
</div><hr class="bg-black py-2 my-0"><br>
  <p class="container text-center text-white-50 pb-3 text-lg" style="font-family: Arial, sans-serif;"><?php if(!empty($search_home)){ echo 'Search results for:'.' "'.$search_home.'"'; } elseif(!empty($recipe_name) || !empty($ingredients) || !empty($categories) || !empty($prep_time) || !empty($cook_time) || !empty($servings)){ echo 'Here are the top results:';}?></p>
  <div class="container py-2 px-0">
    <div id="example2" class="row row-cols-2 g-lg-4">
    <?php
    $start = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if (isset($_GET['home_search'])){
      $search_home= htmlspecialchars($_GET['home_search']);
      // If the from home search query is empty, reset page to 1
      if (empty($search_home)){
      $search_home = '';
      $start = 1;
      }
    }
    $rowsper_page = 16;
    $offset = ($start - 1)  * $rowsper_page;
    $category_name = isset($_GET['ctr_name']) ? $_GET['ctr_name'] : null;
    $result2 = retrieve_alldata3();

    $result = [];
    $totalnum_records = 0;

    if(!empty($category_name)){
      $result = retrieve_allrecipe3_category($category_name, $start, $rowsper_page);
      // Calculate total number of pages for filtered categories
      $query = $conn->prepare(" SELECT COUNT(*) as total_num FROM recipes INNER JOIN rcp_num_categories ON recipes.Recipe_ID = rcp_num_categories.Recipe_ID INNER JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID WHERE rcp_categories.Category_Name = :Category_Name AND rcp_categories.Status = 'Active'");
      $query->bindParam(':Category_Name', $category_name);
      $query->execute();
      $totalnum_records = $query->fetch(PDO::FETCH_ASSOC)['total_num'];
    
    } elseif(!empty($search_home)){
      $searchParam = "%$search_home%";
      $query = $conn->prepare("SELECT DISTINCT recipes.* FROM recipes LEFT JOIN rcp_num_categories ON recipes.Recipe_ID = rcp_num_categories.Recipe_ID LEFT JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID LEFT JOIN rcp_ingredients ON recipes.Recipe_ID = rcp_ingredients.Recipe_ID LEFT JOIN ingredients ON rcp_ingredients.Ingredient_ID = ingredients.Ingredient_ID LEFT JOIN users ON recipes.User_ID = users.User_ID WHERE (Recipe_Name LIKE :searchParam OR Preparation_Time LIKE :searchParam OR CONCAT(Preparation_Time,' ', 'mins') LIKE :searchParam OR Cook_Time LIKE :searchParam OR CONCAT(Cook_Time,' ', 'mins') LIKE :searchParam OR Servings LIKE :searchParam OR CONCAT(Servings,' ', 'servings') LIKE :searchParam OR rcp_categories.Category_Name LIKE :searchParam OR ingredients.Ingredient_Name LIKE :searchParam OR CONCAT(users.First_Name, ' ', users.Last_Name) LIKE :searchParam) LIMIT :Limit OFFSET :Offset");
      $query->bindParam(':searchParam', $searchParam);
      $query->bindParam(':Limit', $rowsper_page, PDO::PARAM_INT);
      $query->bindParam(':Offset', $offset, PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);

      // Calculate total number of pages based on home search
      $query = $conn->prepare("SELECT COUNT(DISTINCT recipes.Recipe_ID) as total_num FROM recipes LEFT JOIN rcp_num_categories ON recipes.Recipe_ID = rcp_num_categories.Recipe_ID LEFT JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID LEFT JOIN rcp_ingredients ON recipes.Recipe_ID = rcp_ingredients.Recipe_ID LEFT JOIN ingredients ON rcp_ingredients.Ingredient_ID = ingredients.Ingredient_ID LEFT JOIN users ON recipes.User_ID = users.User_ID WHERE (Recipe_Name LIKE :searchParam OR Preparation_Time LIKE :searchParam OR CONCAT(Preparation_Time,' ', 'mins') LIKE :searchParam OR Cook_Time LIKE :searchParam OR CONCAT(Cook_Time,' ', 'mins') LIKE :searchParam OR Servings LIKE :searchParam OR CONCAT(Servings,' ', 'servings') LIKE :searchParam OR rcp_categories.Category_Name LIKE :searchParam OR ingredients.Ingredient_Name LIKE :searchParam OR CONCAT(users.First_Name, ' ', users.Last_Name) LIKE :searchParam)");
      $query->bindParam(':searchParam', $searchParam);
      $query->execute();
      $totalnum_records = $query->fetch(PDO::FETCH_ASSOC)['total_num'];

    } elseif(!empty($recipe_name) || !empty($ingredients) || !empty($categories) || !empty($prep_time) || !empty($cook_time) || !empty($servings)){
      //Advanced search filter functionality with series of conditions
      $sqlConditions = [];
      $params = [];

      // Handle recipe_name filter
      if(!empty($recipe_name)){
        $sqlConditions[] = "recipes.Recipe_Name LIKE :recipe_name";
        $params[':recipe_name'] = "%$recipe_name%";
      }
      // Handle ingredient filter
      if(!empty($ingredients)){
        $ingredientConditions = [];
        foreach($ingredients as $index => $ingredient){
          $ingredientConditions[] = "ingredients.Ingredient_Name = :ingredient_$index";
          $params[":ingredient_$index"] = $ingredient;
        }
        $sqlConditions[] = "(" . implode(' OR ', $ingredientConditions) . ")";
      }
      // Handle category filter
      if(!empty($categories)){
        $categoryConditions = [];
        foreach ($categories as $index => $category) {
          $categoryConditions[] = "rcp_categories.Category_ID = :category_$index";
          $params[":category_$index"] = $category;
        }
        $sqlConditions[] = "(" . implode(' OR ', $categoryConditions) . ")";
      }
      // Handle prep_time filter
      if(!empty($prep_time)){
        $sqlConditions[] = "recipes.Preparation_Time = :prep_time";
        $params[':prep_time'] = $prep_time;
      }
      // Handle cook_time filter
      if(!empty($cook_time)){
        $sqlConditions[] = "recipes.Cook_Time = :cook_time";
        $params[':cook_time'] = $cook_time;
      }
      // Handle servings filter
      if(!empty($servings)){
        $sqlConditions[] = "recipes.Servings = :servings";
        $params[':servings'] = $servings;
      }
      // Combine all conditions into the MySQL WHERE clause
      $joinConditions = implode(' AND ', $sqlConditions);
      if(empty($joinConditions)){
        $joinConditions = '1'; 
      } 

      $query = $conn->prepare("SELECT DISTINCT recipes.* FROM recipes LEFT JOIN rcp_num_categories ON recipes.Recipe_ID = rcp_num_categories.Recipe_ID LEFT JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID LEFT JOIN rcp_ingredients ON recipes.Recipe_ID = rcp_ingredients.Recipe_ID LEFT JOIN ingredients ON rcp_ingredients.Ingredient_ID = ingredients.Ingredient_ID LEFT JOIN users ON recipes.User_ID = users.User_ID WHERE ($joinConditions) LIMIT :Limit OFFSET :Offset");
      // Bind parameters dynamically
      foreach ($params as $key => $value) {
        $query->bindValue($key, $value);
      }
      $query->bindValue(':Limit', $rowsper_page, PDO::PARAM_INT);
      $query->bindValue(':Offset', $offset, PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);

      // Calculate total number of pages for advanced search
      $queryString = "SELECT COUNT(DISTINCT recipes.Recipe_ID) as total_num FROM recipes LEFT JOIN rcp_num_categories ON recipes.Recipe_ID = rcp_num_categories.Recipe_ID LEFT JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID LEFT JOIN rcp_ingredients ON recipes.Recipe_ID = rcp_ingredients.Recipe_ID LEFT JOIN ingredients ON rcp_ingredients.Ingredient_ID = ingredients.Ingredient_ID LEFT JOIN users ON recipes.User_ID = users.User_ID WHERE ($joinConditions)";
      $query = $conn->prepare($queryString);
      foreach ($params as $key => $value) {
        $query->bindValue($key, $value);
      }
      $query->execute();
      $totalnum_records = $query->fetch(PDO::FETCH_ASSOC)['total_num'];

    } else {
      $result = retrieve_allrecipe2($start, $rowsper_page);
      $query = $conn->prepare("SELECT COUNT(*) as total_num FROM recipes");
      $query->execute();
      $totalnum_records = $query->fetch(PDO::FETCH_ASSOC)['total_num']; 
    }
    $num_of_pages = ceil($totalnum_records / $rowsper_page);
    if(empty($result) || empty($result2)){
      echo"<h3 class='container py-3 my-5 rounded bg-danger text-light text-center my-0'><strong>Sorry, no available recipes were found.</strong></h3>";
    } else{
      if (isset($result) && !empty($result)){
        foreach ($result as $key => $row) {
          $imagePath = 'http://localhost/RecipeSharing_WebApp/baker/'.$row['Rcp_Picture'];
          echo '<div class="col-3 my-1">
                    <div class="card img-thumbnail" style="box-shadow: 0px 5px 10px rgba(31, 31, 31, 0.993);">
                      <img src="'.$imagePath.'" alt="Recipe Image" width="100%" height="200rem" class="recipes"></img>
                      <div class="card-body py-2">
                        <h4 class="text-nowrap border-bottom pb-1" style= "overflow: hidden; text-overflow: ellipsis;">'.$row['Recipe_Name'].'</h4>
                        <p class="text-secondary mr-2 my-0 text-nowrap"><i class="bi bi-alarm"></i><small> '.$row['Preparation_Time'].' mins ‖ '.$row['Cook_Time'].' mins ‖ <i class="bi bi-cookie fs-6"></i> '.$row['Servings'].' servings</small></p>          
                    </div>
                      <a href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/recipepage.php?recipe_id='.htmlentities($row['Recipe_ID']).'"  class="col text-monospace btn bg-orange btn-link">View Recipe</a>
                  </div>
          </div>';
        }
      }
    }
    ?>
  </div>
  </div>
  <!-- /.card-footer -->
  <div class="container" aria-label="Search results pages">
  <ul class="pagination pagination-md p-3 mb-0 h6 justify-content-center">
    <!-- First Page -->
    <li class="page-item <?php if($start <= 1){ echo 'disabled'; } ?>">
      <a class="page-link bg-transparent shadow-none border-transparent mx-3 p-0" href="?page=1<?php echo !empty($category_name) ? '&ctr_name='.urlencode($category_name) : ''; ?><?php echo !empty($search_home) ? '&home_search=' . urlencode($search_home) : ''; ?><?php echo !empty(advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings)) ? '&' . advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings) : ''; ?>" title="First"><i class="bi bi-chevron-double-left fs-4 <?php if($start > 1){ echo 'text-light'; } ?>"></i></a>
    </li>
    <!-- Previous Page Link -->
    <li class="page-item <?php if($start <= 1){ echo 'disabled'; } ?>">
      <a class="page-link bg-transparent shadow-none border-transparent mx-2 p-0" href="?page=<?php echo $start - 1; ?><?php echo !empty($category_name) ? '&ctr_name='.urlencode($category_name) : ''; ?><?php echo !empty($search_home) ? '&home_search=' . urlencode($search_home) : ''; ?><?php echo !empty(advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings)) ? '&' . advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings) : ''; ?>" title="Previous"><i class="bi bi-chevron-left fs-4 <?php if($start > 1){ echo 'text-light'; } ?>"></i></a>
    </li>
    <!-- Page Numbers -->
    <?php for($i = 1; $i <= $num_of_pages; $i++): ?>
      <li class="page-item <?php if($start == $i){ echo 'active'; } ?>"><a class="<?php if($start == $i){ echo 'bg-orange'; } ?> bg-transparent pageback border-warning page-link rounded-5 px-3 mx-1 <?php if($start != $i){ echo 'text-light'; } ?>" href="?page=<?php echo $i; ?><?php echo !empty($category_name) ? '&ctr_name='.urlencode($category_name) : ''; ?><?php echo !empty($search_home) ? '&home_search=' . urlencode($search_home) : ''; ?><?php echo !empty(advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings)) ? '&' . advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings) : ''; ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>
    <!-- Next Page Link -->
    <li class="page-item <?php if($start >= $num_of_pages){ echo 'disabled'; } ?>">
      <a class="page-link bg-transparent shadow-none border-transparent mx-2 p-0" href="?page=<?php echo $start + 1; ?><?php echo !empty($category_name) ? '&ctr_name='.urlencode($category_name) : ''; ?><?php echo !empty($search_home) ? '&home_search=' . urlencode($search_home) : ''; ?><?php echo !empty(advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings)) ? '&' . advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings) : ''; ?>"><i class="bi bi bi-chevron-right fs-4 <?php if($start < $num_of_pages){ echo 'text-light'; } ?>" title="Next"></i></a>
    </li>
    <!-- Last Page Link -->
    <li class="page-item <?php if($start >= $num_of_pages){ echo 'disabled'; } ?>">
      <a class="page-link bg-transparent shadow-none border-transparent mx-3 p-0" href="?page=<?php echo $num_of_pages; ?><?php echo !empty($category_name) ? '&ctr_name='.urlencode($category_name) : ''; ?><?php echo !empty($search_home) ? '&home_search=' . urlencode($search_home) : ''; ?><?php echo !empty(advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings)) ? '&' . advanced_searchQuery($recipe_name, $ingredients, $categories, $prep_time, $cook_time, $servings) : ''; ?>" title="Last"><i class="bi bi bi-chevron-double-right fs-4 <?php if($start < $num_of_pages){ echo 'text-light'; } ?>"></i></a>
    </li>
  </ul>
  </div>
  </div>
</div>
<section class="p-5" id="aboutauth">
  <div class="container ">
    <div class="row">
      <div class="col d-flex justify-content-center">
        <img src="aboutpic.png" alt="Author" class="img-rounded mx-auto" style=" width: 440px;" >
      </div>
      <div class="col-6" id="auth">
        <h1 class="mt-1">About Us</h1>
        <p class="mr-auto text-justify mb-2" id="drisc">Hello there! Welcome to SimpleSweets, your go-to destination for exploring, sharing, and enjoying delicious sweet and simple recipes from all around the world! Whether you're a dedicated baker, a bakery owner, or someone just starting out, this platform provides a developing and sustainable community where everyone can share and make their favorite recipes, try new desserts, and interact with other dessert enthusiasts through our social media accounts, where we keep you up to date on everything sweet and baking-related.</p>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi-facebook fs-2" id="contact"></i></a></span>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi-instagram fs-2" id="contact"></i></a></span>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi bi-twitter-x fs-2" id="contact"></i></a></span>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi-pinterest fs-2" id="contact"></i></a></span>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi-envelope fs-2" id="contact"></i></a></span>  
      </div>
    </div>
  </div>
</section>
<hr class="bg-gray py-2 my-0">
</main>
<footer class="footer mt-auto py-3 bg-dark">
<div class="container py-1">
  <p class="float-end mb-2">
    <a href="#"><i class="bi bi-arrow-up-square-fill" title="Back to top" style="font-size: 25px; color:#fda41f;"></i></a>
  </p>
  <span class="text-light" style="font-size: 14px;">© 2024 SimpleSweets. All rights reserved. </span>
</div>
</footer>
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"> </script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
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
</body>
</html>