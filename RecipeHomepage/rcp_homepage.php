<?php
  require_once('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');
  $result1= retrieve_dessert_type();
  $result2= retrieve_dietary();
  $result3= retrieve_cuisine();
  $result4= retrieve_occasion();
  $recipe_count= retrieve_allrecipes();
  $recipenum = $recipe_count[0]['COUNT(*)'];

  $rcp_ingredients = retrieve_ingredients();
  $rcp_categories = retrieve_categories_names();

  $category_name = isset($_GET['ctr_name']) ? $_GET['ctr_name'] : null;
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
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="http://localhost/RecipeSharing_WebApp/assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
   <!-- Favicons -->
   <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
   <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
   <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
   <link rel="manifest" href="/docs/5.3/assets/img/favicons/manifest.json">
   <link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
   <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon.ico">
   <link rel="stylesheet" href="style.css">
   <style>
    .select2-container--default .select2-selection--multiple {
        background-color: #343a40 !important;
        color: #6c757d !important;
        border-color: #adb5bd !important;
    }
    .disabled-btn, .disabled-search{
    pointer-events: none;
    color: #adb5bd;
    cursor: not-allowed;
    }
    .enabled-btn, .enabled-search{
    pointer-events: auto;
    cursor: pointer;
    }
   </style>
</head>
<body>
<div>
<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" data-bs-theme="dark">
  <div class="container" id="navbarElements">
    <div class="mx-1" id="navbrand"> SimpleSweets</div><img src="cookielogo.png" alt="Brand Logo" width="33" style="margin-right: 5px;" class="rotate-in-center">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active mr-2 pr-2" style="font-size: 0.9rem;" aria-current="page" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/rcp_homepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mr-2 pr-2"  style="font-size: 0.9rem;" aria-current="page" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/allrecipe_page.php">All Recipes</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($category_name, array_column($result1, 'Category_Name')) ? 'active' : ''; ?>" style="font-size: 0.9rem;" data-bs-toggle="dropdown" aria-expanded="true">
            Desserts
          </a>
          <ul class="dropdown-menu dropdown-menu-end dark-mode">
          <?php foreach ($result1 as $index => $category): ?>
            <li><a class="dropdown-item text-sm py-1 <?php echo $category['Category_Name'] == $category_name ? 'active bg-gradient-orange disabled' : ''; ?>" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/allrecipe_page.php?ctr_name=<?php echo urlencode($category['Category_Name']); ?>"><?php echo $category['Category_Name'];?></a></li>
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
            <li><a class="dropdown-item text-sm py-1 <?php echo $category['Category_Name'] == $category_name ? 'active bg-gradient-orange disabled' : ''; ?>" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/allrecipe_page.php?ctr_name=<?php echo urlencode($category['Category_Name']); ?>"><?php echo $category['Category_Name'];?></a></li>
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
            <li><a class="dropdown-item text-sm py-1 <?php echo $category['Category_Name'] == $category_name ? 'active bg-gradient-orange disabled' : ''; ?>" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/allrecipe_page.php?ctr_name=<?php echo urlencode($category['Category_Name']); ?>"><?php echo $category['Category_Name'];?></a></li>
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
            <li><a class="dropdown-item text-sm py-1 <?php echo $category['Category_Name'] == $category_name ? 'active bg-gradient-orange disabled' : ''; ?>" href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/allrecipe_page.php?ctr_name=<?php echo urlencode($category['Category_Name']); ?>"><?php echo $category['Category_Name'];?></a></li>
            <?php if ($index < count($result4) - 1): ?>
                <hr class="dropdown-divider my-0">
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button" id="searchIcon">
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
</script>
<main>
<div id="carouselExampleSlidesOnly" class="my-2 text-center carousel slide carousel-fade" style="height: 35.2rem; overflow: hidden;" data-bs-ride="carousel">
  <div id="carousel_click" class="carousel-inner" >
    <div class="carousel-item active" style="height: 100%;" data-bs-interval="10000">
      <img src="backgroundcake1.jpg" class="d-block w-100" style="height: 100%; object-fit: cover;" alt="Background Image-1">
    </div>
    <div class="carousel-item" style="height: 100%;" data-bs-interval="12000">
    <img src="backgroundcake_2.jpg" class="d-block w-100" style="height: 100%; object-fit: cover;" alt="Background Image-2">
    </div>
    <div class="carousel-item" style="height: 100%;" data-bs-interval="1000">
      <img src="backgroundcake_3.jpg" class="d-block w-100" style="height: 100%; object-fit: cover;" alt="Background Image-3">
    </div>
  </div>
  <div class="row col-7 mx-auto carousel-caption d-none d-block" style="height: 72%">
      <h1 class="titleh text-pop-up-top" style="font-size: 3.5rem;">Let's Bake It Simple</h1>
      <p class="text-center text-white pb-3 fs-4" id="titlecont">Welcome to our platform, designed and offered to satisfy your passion for baking sweets! Discover an abundance of over <b><?php echo $recipenum;?></b> delightfully simple dessert recipes published for everyone to create from scratch.</p>
      <div class="row">
                <div class="col-10 offset-md-1">
                    <form method="GET" action="allrecipe_page.php">
                        <div class="input-group col">
                        <input type="hidden" name="page" value="1">
                        <input type="search" id="search-input" name="home_search" class="form-control form-control border-dark rounded-left border-2 border-right-0 py-md-4 fs-5" placeholder="Search recipes">
                            <div class="input-group-append">
                                <!-- Search Button-->
                                <button type="submit" id="search-button" class="btn btn-light px-3 fs-5 border-dark border-left-0 border-2 d-flex align-items-center disabled-btn">
                                  <i class="fa fa-search"></i>
                                </button>
                            </div>
                    </form>
                    <!-- Filter Search Button -->
                    <button type="button" class="btn bg-orange px-3 fs-5 border-dark border-2 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Advanced Search" style="margin-left: -1px;">
                      <i class="bi bi-sliders"></i>
                    </button>
                  </div>
                </div>
            </div>
      </div>
</div>
<!-- Modal Filter Search -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content bg-dark text-light">
      <form method="GET" action="allrecipe_page.php">
      <div class="modal-header px-4 bg-primary d-flex align-items-center justify-content-between border-transparent shadow">
        <h1 class="modal-title fs-4 mb-0" id="exampleModalLabel">Advanced Search</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
        <h3 class="col-2 col-form-label border-primary border-bottom mb-4 fs-5 text-monospace">Search by</h3>
        <div class="row">
          <div class="col-5 form-group mb-5">
            <p class="col-form-label">Recipe Name</p>
            <input type="text" class="form-control bg-dark text-light" name="recipe_name" placeholder="Search recipe name">
          </div>
          <div class="col form-group mb-5">
            <p class="col-form-label">Prep Time <small> (in minutes)</small></p>
            <input type="text" class="form-control bg-dark text-light" name="prep_time" placeholder="Enter number">
          </div>
          <div class="col form-group mb-5">
            <p class="col-form-label">Cook Time <small> (in minutes)</small></p>
            <input type="text" class="form-control bg-dark text-light" name="cook_time" placeholder="Enter number">
          </div>
          <div class="col form-group mb-5">
            <p class="col-form-label">Servings <small> (yields)</small></p>
            <input type="text" class="form-control bg-dark text-light" name="servings" placeholder="Enter number">
          </div>
        </div>
        <h3 class="col-2 col-form-label border-primary border-bottom mb-4 fs-5 text-monospace">Filter by</h3>
        <div class="row">
          <div class="col-5 form-group mb-5 mr-3 select2-warning">
            <p class="col-form-label">Ingredient/s Available</p>
            <select class="select2 mb-3" name="ingredients[]" multiple="multiple" data-placeholder="Select one or more recipe ingredients" data-dropdown-css-class="select2-orange" style="width: 100%;">
            <?php foreach ($rcp_ingredients as $ingredient): ?>
              <option value="<?php echo $ingredient['Ingredient_Name'];?>"><?php echo $ingredient['Ingredient_Name'];?></option>
            <?php endforeach; ?>
            </select>
          </div>
          <div class="col-5 form-group mb-5 select2-warning">
            <p class="col-form-label">Category/s</p>
            <select class="select2 mb-3" name="categories[]" multiple="multiple" data-placeholder="Select one or more recipe tagged categories" data-dropdown-css-class="select2-orange" style="width: 100%;">
            <?php foreach ($rcp_categories as $category_nm): ?>
              <option value="<?php echo $category_nm['Category_ID'];?>"><?php echo $category_nm['Category_Name'];?></option>
            <?php endforeach; ?>
            </select>
          </div>
        </div>
        </div>
      </div><hr class="bg-white mb-0">
      <div class="modal-body d-flex justify-content-end">
        <button type="submit" class="btn bg-orange px-5 mr-2">Search</button>
        <button type="reset" class="btn btn-outline-danger"  onclick="resetSelect2()">Clear Filters</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal End -->
<div class="album pt-0 pb-5 bg-dark">
<div class= "col bg-blue py-3">
  <h1 class="text-center">Recently Added Recipes</h1>
</div><hr class="bg-black py-2 my-0"><br><br>
  <div class="container mb-5 pb-4">
    <div class="row row-cols-2 row-cols- row-cols-3 g-lg-1">
    <?php
    $result_recent = retrieve_recent_recipes();

    if(empty($result_recent)){
      echo"<h3 class='container py-3 rounded bg-danger text-light text-center my-0'><strong>Sorry, no available recipes were found.</strong></h3>";
    } else{
      if (isset($result_recent) && !empty($result_recent)) {
        foreach ($result_recent as $key => $row) {
          $imagePath = 'http://localhost/RecipeSharing_WebApp/baker/'.$row['Rcp_Picture'];
          echo '<div class="col-3 my-1">
                    <div class="card img-thumbnail" style="box-shadow: 0px 5px 10px rgba(31, 31, 31, 0.993);">
                      <span class="position-absolute translate-middle p-1 bg-gradient-red border-dark shadow-lg rounded-circle" style="top: 173px; right: -15px; border: 3px solid blue">
                      <h5><small class="text-bold">New</small></h5>
                      </span>
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
<div class= "col bg-blue py-3">
  <h1 class="text-center">Featured Simple Recipes</h1>
</div><hr class="bg-black py-2 my-0"><br><br>
  <div class="container">
    <div class="row row-cols-2 row-cols- row-cols-3 g-lg-1">
    <?php
    $result = retrieve_featured_recipes();
    $resultc = retrieve_alldata3();

    if(empty($result) || empty($resultc)){
      echo"<h3 class='container py-3 rounded bg-danger text-light text-center my-0'><strong>Sorry, no available recipes were found.</strong></h3>";
    } else{
      if (isset($result) && !empty($result)) {
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
<script>
  const exampleModal = document.getElementById('exampleModal')
  if(exampleModal){
    exampleModal.addEventListener('show.bs.modal', event =>{
      // Button that triggered the modal
      const button = event.relatedTarget
      // Extract info from data-bs-* attributes
      const modalTitle = exampleModal.querySelector('.modal-title')
      const modalBodyInput = exampleModal.querySelector('.modal-body input')
      modalBodyInput.value = recipient
    })
  }
  document.addEventListener('DOMContentLoaded', function(){
    var carousel = new bootstrap.Carousel(document.getElementById('carouselExampleSlidesOnly'), {
      ride: false
    });
    // Add click event listener to the carousel
    document.getElementById('carousel_click').addEventListener('click', function() {
      carousel.next();
    });
  });
  document.addEventListener('DOMContentLoaded', function(){
    var searchInput = document.getElementById('search-input');
    var searchButton = document.getElementById('search-button');

    function toggleButtonState() {
        if (searchInput.value.trim()){
            searchButton.classList.remove('disabled-btn');
            searchButton.classList.add('enabled-btn');
        } else{
            searchButton.classList.remove('enabled-btn');
            searchButton.classList.add('disabled-btn');
        }
    }

    searchInput.addEventListener('input', toggleButtonState);
    toggleButtonState();
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
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"> </script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<!-- jQuery -->
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
<!-- bs-custom-file-input -->
<script src="http://localhost/RecipeSharing_WebApp/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="http://localhost/RecipeSharing_WebApp/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="http://localhost/RecipeSharing_WebApp/assets/dist/js/demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      theme: 'dark'
    });
  });
  function resetSelect2() {
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