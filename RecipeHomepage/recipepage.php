<?php
  require_once('C:\xampp\htdocs\RecipeSharing_WebApp\functions.php');
  $result1= retrieve_dessert_type();
  $result2= retrieve_dietary();
  $result3= retrieve_cuisine();
  $result4= retrieve_occasion();

  $category_name = isset($_GET['ctr_name']) ? $_GET['ctr_name'] : null;
  //Retrive all the recipe details from its relations
  $recipe_ID = $_GET['recipe_id'];
  $recipedetails = getrecipedetails($recipe_ID);

  $created = new DateTime($recipedetails['Date_Created']);
  $created_at = $created->format('F d, Y');
  $updated = new DateTime($recipedetails['Date_Updated']);
  $updated_at = $updated->format('F d, Y');
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
      .star{
        cursor: pointer;
        color: gray;
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
<body class= "bg-dark">
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
<div class="col-11 ml-4 pt-2 pb-0 mb-0">
  <div aria-label="breadcrumb" class="col text-nowrap">
    <ol class="breadcrumb bg-dark" class="col">
      <li class="breadcrumb-item"><a href="http://localhost/RecipeSharing_WebApp/RecipeHomepage/rcp_homepage.php" class="text-warning">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($recipedetails['Recipe_Name']);?></li>
    </ol>
  </div>
</div>
<div class="col-11 mx-auto mb-5 pb-5 bg-light mt-0 rounded-5 shadow-lg">
<main class="container py-0 my-0">
  <div class="row">
    <!-- Image and Title Section -->
    <div class="col">
      <h1 class="text-center mt-5 bg-primary rounded-top-3 py-4 mb-0 text-bold" style="font-family: cursive;"><?php echo $recipedetails['Recipe_Name'];?></h1>
      <hr class="bg-warning mt-0 pb-2 rounded-bottom-2 opacity-100">
      <p class="text-center text-secondary pt-0">Published: <?php echo $created_at;?> • Modified: <?php echo $updated_at;?> • Recipe by: <span style="font-style: italic;"><?php echo htmlspecialchars($recipedetails['First_Name']).' '. htmlspecialchars($recipedetails['Last_Name']); ?></span></p>
      <hr class="bg-gradient-secondary py-2 mx-2">
      <p class="text-center">
      <strong class="mx-1 text-orange"><i class="bi bi-alarm fs-4"></i> Prep Time:</strong> <span class="fs-4"><?php echo $recipedetails['Preparation_Time'].' mins'; ?></span> <span class="pl-2 text-secondary">|</span> 
      <strong class="mx-1 text-orange"><i class="bi bi-fire fs-4"></i> Cook Time:</strong> <span class="fs-4"><?php echo $recipedetails['Cook_Time'].' mins';?></span> <span class="pl-2 text-secondary">|</span>  
      <strong class="mx-1 text-orange"><i class="bi bi-cookie fs-4"></i> Servings:</strong> <span class="fs-4"><?php echo htmlspecialchars($recipedetails['Servings']); ?></span>
      </p>
      <p class= "text-center"><strong class="mx-2 text-orange">Rating:</strong><i class="bi bi-star star h5" data-index="1"></i> <i class="bi bi-star star h5" data-index="2"></i> <i class="bi bi-star star h5" data-index="3"></i> <i class="bi bi-star star h5" data-index="4"></i> <i class="bi bi-star star h5" data-index="5"></i><strong class="mx-1"></strong><span class="px-2 text-secondary">|</span> <strong class="mx-1 text-orange"><i class="bi bi-tags fs-4"></i> Category/s:</strong>
      <?php foreach($recipedetails['categories'] as $category): ?>
        <span class="badge badge-secondary px-2 fs-6 position-relative"><?php echo htmlspecialchars($category['Category_Name']);?>
        <span class="position-absolute start-0 translate-middle-y bg-gradient-info badge border border-primary py-0 text-sm opacity-75" style="top: 1.7rem;"><small class="text-black text-bold"><?php echo htmlspecialchars($category['Category_Criteria']);?></small></span>
        </span>
      <?php endforeach;?>
      </p>
      <hr class="bg-gradient-secondary py-2 mx-2">
      <div class="py-1"></div>
      <div class="mb-4 mx-2">
      <h2 class="mb-3 text-orange">Description</h2>
        <p class="text-justify fs-5"><?php echo $recipedetails['Rcp_Description']; ?></p>
      </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const index = this.getAttribute('data-index');
                    updateStars(index);
                });
            });
        });
        function updateStars(index) {
            const stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                if (star.getAttribute('data-index') <= index) {
                    star.classList.add('checked');
                    star.classList.remove('bi-star');
                    star.classList.add('bi-star-fill');
                } else {
                    star.classList.remove('checked');
                    star.classList.remove('bi-star-fill');
                    star.classList.add('bi-star');
                }
            });
        }
  </script>
  </div>
  <div class="my-1"></div>
  <div class="container py-3">
    <div class="row">
        <div class="col ml-2">
            <!-- Image -->
            <div class="mb-4">
                <img src="http://localhost/RecipeSharing_WebApp/baker/<?php echo htmlspecialchars($recipedetails['Rcp_Picture']); ?>" class="img-fluid rounded pr-0" alt="Recipe Image" style= "width: 97%;">
            </div>
            <!-- Instructions -->
            <div class="py-2">
                <h2 class="text-orange">Instructions</h2>
                <ol class="fs-5 py-3 mr-2">
                  <?php foreach($recipedetails['steps'] as $step): ?>
                    <li class="pb-3 ml-0" style="display: flex; align-items: flex-start;">
                      <span class="badge rounded-4 badge-primary py-1 px-2 fs-6" style="margin-right: 10px;">
                        <?php echo htmlspecialchars($step['Step_num'])?>
                      </span>
                      <?php echo $step['Step_description']; ?></li>
                  <?php endforeach;?>
                </ol>
            </div>
        </div>
        <div class="col-4">
            <div class="h-100 fs-5" style="border-left: 18px solid lightgray;">
                <h2 class="text-orange px-4">Ingredients</h2>
                <ul class="py-2 ml-4">
                  <?php foreach($recipedetails['ingredients'] as $ingredient): ?>
                    <li class="py-1"><span class="text-primary fs-4"><?php echo $ingredient['Ingredient_quantity'].' '.$ingredient['Ingredient_unit'].'</span> '.$ingredient['Ingredient_Name'];?></li>
                  <?php endforeach; ?>
                </ul>
                <div class="mt-3"  style="border-top: 18px solid lightgray;">
                  <h2 class="text-orange my-3 px-4">Baking Reminders</h2>
                  <ul class="py-2 ml-4 mr-2 rounded-3 border-primary" style="border:5px outset blue;">
                  <?php foreach($recipedetails['reminders'] as $reminder): ?>
                    <li class="py-1 fs-5 pr-4 text-justify" style="font-family: Arial Narrow;"><?php echo $reminder['Reminder_description'];?></li>
                  <?php endforeach; ?>
                  </ul>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="col mt-4">
      <hr class="bg-warning mt-0 pb-2 rounded-top-2 mb-0 opacity-100">
      <div class="text-center bg-primary rounded-bottom-3 py-4 mb-0 text-bold"></div>
  </div>
</div>
</div>
</main><br>
<section class="p-5" id="aboutauth">
  <div class="container ">
    <div class="row">
      <div class="col d-flex justify-content-center align-items-center">
        <img src="aboutpic.png" alt="Author" class="img-rounded mx-auto" style=" width: 440px;" >
      </div>
      <div class="col-6" id="auth">
        <h1 class="mt-1">About Us</h1>
        <p class="mr-auto text-justify  mb-2" id="drisc">Hello there! Welcome to SimpleSweets, your go-to destination for exploring, sharing, and enjoying delicious sweet and simple recipes from all around the world! Whether you're a dedicated baker, a bakery owner, or someone just starting out, this platform provides a developing and sustainable community where everyone can share and make their favorite recipes, try new desserts, and interact with other dessert enthusiasts through our social media accounts, where we keep you up to date on everything sweet and baking-related.</p>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi-facebook fs-2" id="contact"></i></a></span>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi-instagram fs-2" id="contact"></i></a></span>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi bi-twitter-x fs-2" id="contact"></i></a></span>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi-pinterest fs-2" id="contact"></i></a></span>
        <span style="margin-right: 10px; vertical-align: top;"><a href="#"><i class="bi-envelope fs-2" id="contact"></i></a></span>  
      </div>
    </div>
  </div>
</section>
<hr class="bg-black py-2 my-0">
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