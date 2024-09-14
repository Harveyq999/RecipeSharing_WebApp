<?php
  // Connection to MySQL (PDO)
  function getDatabaseConnection(){
    $host= 'localhost';
    $dbname= 'swtrecipe_system';
    $user= 'root';
    $password= '';
    $dsn= "mysql:dbname=$dbname;host=$host";

    try{
      $conn= new PDO($dsn, $user, $password);
      return $conn;
    } catch (PDOException $e){
      echo 'Connection failed: ' . $e->getMessage() . "<br/>";
    }
  }
?>


<?php
//------------------------------------------Users Table------------------------------------------------
  //SQL Insert Users Data
  function insertdata($First_Name, $Last_Name, $Gender, $Email, $Role, $Password){
    $conn = getDatabaseConnection();
    
    $query = $conn->prepare("INSERT INTO users (First_Name, Last_Name, Gender, Email, Role, Password) VALUES (:First_Name, :Last_Name, :Gender, :Email, :Role, :Password)");

    $Password = password_hash($Password, PASSWORD_BCRYPT);

    $query->bindParam(':First_Name', $First_Name);
    $query->bindParam(':Last_Name', $Last_Name);
    $query->bindParam(':Gender', $Gender);
    $query->bindParam(':Email', $Email);
    $query->bindParam(':Role', $Role);
    $query->bindParam(':Password', $Password);
    $response= $query->execute();

    if($response){
      $_SESSION['message_display'] = "User has been added successfully!";
      return $conn->lastInsertId();
    }
    else{
      return FALSE;
    }
  }
?>


<?php
  //SQL Retrieve All User Data
  function retrieve_alldata($start = 1, $rowsper_page = 10){
    $conn = getDatabaseConnection();

    $offset = ($start - 1)  * $rowsper_page;

    $query= $conn->prepare("SELECT * FROM users ORDER BY Update_at DESC LIMIT :Limit OFFSET :Offset");
    $query->bindParam(':Limit', $rowsper_page, PDO::PARAM_INT);
    $query->bindParam(':Offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  //SQL Retrieve Maximum Number of Users
  function retrieve_allusers(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT COUNT(*) FROM users");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  //SQL Update User Data
  function updatedata($User_ID, $First_Name, $Last_Name, $Gender, $Email, $Role){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("UPDATE users SET First_Name= :First_Name, Last_Name= :Last_Name, Gender= :Gender, Email= :Email, Role= :Role WHERE User_ID= :User_ID");
    
    $query->bindparam(':User_ID', $User_ID);
    $query->bindParam(':First_Name', $First_Name);
    $query->bindParam(':Last_Name', $Last_Name);
    $query->bindParam(':Gender', $Gender);
    $query->bindParam(':Email', $Email);
    $query->bindParam(':Role', $Role);
    $response= $query->execute();
    $conn= NULL;

    if($response){
      $_SESSION['message_display'] = "User has been updated successfully!";
      header("Location: http://localhost/RecipeSharing_WebApp/admin/index.php");
      exit();
    }
    else{
      echo "Failed to update.";
    }
  }
?>


<?php
  //SQL Update User Data
  function updateprofile($User_ID, $First_Name, $Last_Name, $Gender, $Email, $Role){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("UPDATE users SET First_Name= :First_Name, Last_Name= :Last_Name, Gender= :Gender, Email= :Email, Role= :Role WHERE User_ID= :User_ID");
    
    $query->bindparam(':User_ID', $User_ID);
    $query->bindParam(':First_Name', $First_Name);
    $query->bindParam(':Last_Name', $Last_Name);
    $query->bindParam(':Gender', $Gender);
    $query->bindParam(':Email', $Email);
    $query->bindParam(':Role', $Role);
    $response= $query->execute();
    $conn= NULL;

    if($response && $_SESSION['user_role'] == 'Admin'){
      $_SESSION['message_displayprofile'] = "Your profile has been updated successfully!";
      header("Location: http://localhost/RecipeSharing_WebApp/admin/dashboard.php");
      exit();
    } elseif($response && $_SESSION['user_role'] == 'Baker'){
      $_SESSION['message_displayprofile'] = "Your profile has been updated successfully!";
      header("Location: http://localhost/RecipeSharing_WebApp/baker/dashboard2.php");
      exit();
    }
    else{
      echo "Failed to update.";
    }
  }
?>


<?php
  //SQL Deactivate User Data
  function deactivatedata($User_ID){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("UPDATE users SET Status = :Status WHERE User_ID = :User_ID");
    $Status= 'Deactivated';
    $query->bindparam(':User_ID', $User_ID);
    $query->bindparam(':Status', $Status);
    $response= $query->execute();
    $conn= NULL;

    if($response){
      $_SESSION['message_display'] = "User has been deactivated successfully!";
      header("Location: http://localhost/RecipeSharing_WebApp/admin/index.php");
      exit();
    } else{
      echo "Failed!";
    }
  }
?>


<?php
  //SQL Reactivate User Data
  function reactivatedata($User_ID){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("UPDATE users SET Status = :Status WHERE User_ID = :User_ID");
    $Status= 'Active';
    $query->bindparam(':User_ID', $User_ID);
    $query->bindparam(':Status', $Status);
    $response= $query->execute();
    $conn= NULL;

    if($response){
      $_SESSION['message_display'] = "User has been reactivated successfully!";
      header("Location: http://localhost/RecipeSharing_WebApp/admin/index.php");
      exit();
    } else{
      echo "Failed!";
    }
  }
?>


<?php
//---------------------------------------Rcp_Category Table---------------------------------------------
  //SQL Insert Rcp_Category Data
  function insertdata2($Category_Name, $Category_Criteria){
    $conn = getDatabaseConnection();
    
    $query = $conn->prepare("INSERT INTO rcp_categories (Category_Name, Category_Criteria) VALUES (:Category_Name, :Category_Criteria)");

    $query->bindParam(':Category_Name', $Category_Name);
    $query->bindParam(':Category_Criteria', $Category_Criteria);
    $response= $query->execute();

    if($response){
      $_SESSION['message_display2'] = "Recipe category has been added successfully!";
      return $conn->lastInsertId();
    }
    else{
      return FALSE;
    }
  }
?>


<?php
  //SQL Retrieve All Distinct Ingredient Names
  function retrieve_categories_names(){
    $conn = getDatabaseConnection();
  
    $query= $conn->prepare("SELECT * FROM rcp_categories WHERE Status = 'Active'");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;
  
    return $result;
  }

  //SQL Retrieve All Dessert Type Categories
  function retrieve_dessert_type(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT * FROM rcp_categories WHERE Category_Criteria = 'Dessert' AND Status = 'Active'");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }

  //SQL Retrieve Cuisine Categories
  function retrieve_cuisine(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT * FROM rcp_categories WHERE Category_Criteria = 'Cuisine' AND Status = 'Active'");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }

  //SQL Retrieve All Dietary Restriction Categories
  function retrieve_dietary(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT * FROM rcp_categories WHERE Category_Criteria = 'Dietary' AND Status = 'Active'");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }

  //SQL Retrieve All Occasion Categories
  function retrieve_occasion(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT * FROM rcp_categories WHERE Category_Criteria = 'Occasion' AND Status = 'Active'");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }

  //SQL Retrieve All Distinct Ingredient Names
  function retrieve_ingredients(){
    $conn = getDatabaseConnection();
  
    $query= $conn->prepare("SELECT DISTINCT Ingredient_Name FROM ingredients WHERE Ingredient_Name NOT LIKE '%[%' AND Ingredient_Name NOT LIKE '%]%' AND Ingredient_Name NOT LIKE '%(%' AND Ingredient_Name NOT LIKE '%)%'AND Ingredient_Name != BINARY UPPER(Ingredient_Name)");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;
  
    return $result;
  }
?>


<?php
  //SQL Retrieve Active Rcp_Category Data
  function retrieve_categories($start = 1, $rowsper_page = 10){
    $conn = getDatabaseConnection();

    $offset = ($start - 1)  * $rowsper_page;

    $query= $conn->prepare("SELECT * FROM rcp_categories WHERE Status = 'Active' ORDER BY Date_Updated DESC LIMIT :Limit OFFSET :Offset");
    $query->bindParam(':Limit', $rowsper_page, PDO::PARAM_INT);
    $query->bindParam(':Offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  //SQL Retrieve All Rcp_Category Data that are labelled on a criteria
  function retrieve_criteria($Category_Criteria, $start = 1, $rowsper_page = 10){
    $conn = getDatabaseConnection();

    $offset = ($start - 1)  * $rowsper_page;

    $query= $conn->prepare("SELECT * FROM rcp_categories WHERE Category_Criteria = :Category_Criteria AND Status = 'Active' ORDER BY Date_Updated DESC LIMIT :Limit OFFSET :Offset");
    $query->bindParam(':Category_Criteria', $Category_Criteria);
    $query->bindParam(':Limit', $rowsper_page, PDO::PARAM_INT);
    $query->bindParam(':Offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
//SQL Retrieve All Occasion Categories
  function retrieve_category_criteria(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT DISTINCT Category_Criteria FROM rcp_categories");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>

<?php
  //SQL Retrieve All Archived Rcp_Category Data
  function retrieve_alldata2archive($start = 1, $rowsper_page = 10){
    $conn = getDatabaseConnection();

    $offset = ($start - 1)  * $rowsper_page;

    $query= $conn->prepare("SELECT * FROM rcp_categories WHERE Status = 'Archived' ORDER BY Date_Updated DESC LIMIT :Limit OFFSET :Offset");
    $query->bindParam(':Limit', $rowsper_page, PDO::PARAM_INT);
    $query->bindParam(':Offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  //SQL Retrieve Maximum Number of Categories
  function retrieve_allcategories(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT COUNT(*) FROM rcp_categories WHERE Status = 'Active'");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  //SQL Update Rcp_Category Data
  function updatedata2($Category_ID, $Category_Name, $Category_Criteria){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("UPDATE rcp_categories SET Category_Name= :Category_Name, Category_Criteria = :Category_Criteria WHERE Category_ID= :Category_ID");

    $query->bindparam(':Category_ID', $Category_ID);
    $query->bindParam(':Category_Name', $Category_Name);
    $query->bindParam(':Category_Criteria', $Category_Criteria);
    $response= $query->execute();
    $conn= NULL;

    if($response){
      $_SESSION['message_display2'] = "Recipe category has been updated successfully!";
      header("Location: http://localhost/RecipeSharing_WebApp/admin/rcp_category.php");
      exit();
    }
    else{
      echo "Failed to update.";
    }
  }
?>


<?php
  //SQL Delete Category Data
  function deletedata2($Category_ID){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("DELETE FROM rcp_categories WHERE Category_ID = :Category_ID");
    $query->bindparam(':Category_ID', $Category_ID);
    $response= $query->execute();
    $conn= NULL;

    if($response){
      $_SESSION['message_display2'] = "Recipe category has been deleted successfully!";
      header("Location: http://localhost/RecipeSharing_WebApp/admin/rcp_category.php");
      exit();
    } else{
      echo "Failed!";
    }
  }
?>


<?php
  //SQL Archive Category Data
  function archivedata($Category_ID){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("UPDATE rcp_categories SET Status = :Status WHERE Category_ID = :Category_ID");
    $Status= 'Archived';
    $query->bindparam(':Category_ID', $Category_ID);
    $query->bindparam(':Status', $Status);
    $response= $query->execute();
    $conn= NULL;

    if($response){
      $_SESSION['message_display2'] = "Recipe category has been archived successfully!";
      header("Location: http://localhost/RecipeSharing_WebApp/admin/rcp_category.php");
      exit();
    } else{
      echo "Failed!";
    }
  }
?>


<?php
  //SQL Restore Category Data From Archive
  function restoredata($Category_ID){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("UPDATE rcp_categories SET Status = :Status WHERE Category_ID = :Category_ID");
    $Status= 'Active';
    $query->bindparam(':Category_ID', $Category_ID);
    $query->bindparam(':Status', $Status);
    $response= $query->execute();
    $conn= NULL;

    if($response){
      $_SESSION['message_display2'] = "Recipe category has been restored successfully!";
      header("Location: http://localhost/RecipeSharing_WebApp/admin/archive_category.php");
      exit();
    } else{
      echo "Failed!";
    }
  }
?>


<?php
  //---------------------------------------Recipes Relational Tables---------------------------------------------
  //SQL Insert Recipe Data
  function insertrecipe($User_ID, $Recipe_Name, $Rcp_Description, $Preparation_Time, $Cook_Time, $Servings, $Rcp_Picture, $Category_Names, $ingredients, $quantities, $units, $steps, $reminders){
    $conn = getDatabaseConnection();
    $conn->beginTransaction();

    try{
      // Insert the recipe primary details into the recipes table
      $query = $conn->prepare("INSERT INTO recipes (User_ID, Recipe_Name, Rcp_Description, Preparation_Time, Cook_Time, Servings, Rcp_Picture) VALUES (:User_ID, :Recipe_Name, :Rcp_Description, :Preparation_Time, :Cook_Time, :Servings, :Rcp_Picture)");
  
      $query->bindParam(':User_ID', $User_ID);
      $query->bindParam(':Recipe_Name', $Recipe_Name);
      $query->bindParam(':Rcp_Description', $Rcp_Description);
      $query->bindParam(':Preparation_Time', $Preparation_Time);
      $query->bindParam(':Cook_Time', $Cook_Time);
      $query->bindParam(':Servings', $Servings);
      $query->bindParam(':Rcp_Picture', $Rcp_Picture);
      $response = $query->execute();
      $Recipe_ID = $conn->lastInsertId();

      // Insert the categories into the rcp_num_categories table
      $categoryQuery = $conn->prepare("
      INSERT INTO rcp_num_categories (Recipe_ID, Category_ID) 
      VALUES (:Recipe_ID, :Category_ID)
      ");
      foreach ($Category_Names as $Category_ID) {
        $categoryQuery->bindParam(':Recipe_ID', $Recipe_ID);
        $categoryQuery->bindParam(':Category_ID', $Category_ID);
        $categoryQuery->execute();
      }

      // Insert the number_of_recipes into the rcp_num_categories table
      $updateQuery = "UPDATE rcp_categories c SET Num_of_Recipes = (SELECT COUNT(*) FROM rcp_num_categories rnc WHERE rnc.Category_ID = c.Category_ID)";
      $updateStmt = $conn->prepare($updateQuery);
      $updateStmt->execute();

      // Insert the recipe ingredients into the ingredients table and then into rcp_ingredients table
      $ingredientQuery = $conn->prepare("INSERT INTO ingredients (Ingredient_Name) VALUES (:Ingredient_Name) ON DUPLICATE KEY UPDATE Ingredient_ID = LAST_INSERT_ID(Ingredient_ID)");
      $rcpingredientQuery = $conn->prepare("INSERT INTO rcp_ingredients (Recipe_ID, Ingredient_ID, Ingredient_quantity, Ingredient_unit) VALUES (:Recipe_ID, :Ingredient_ID, :Ingredient_quantity, :Ingredient_unit)");

      for($i = 0; $i < count($ingredients); $i++){
        // Checks if the ingredient already exists
        $ingredientQuery->bindParam(':Ingredient_Name', $ingredients[$i]);
        $ingredientQuery->execute();
        $Ingredient_ID = $conn->lastInsertId();

        if ($Ingredient_ID == 0) {
          $ingredientCheckQuery = $conn->prepare("SELECT Ingredient_ID FROM ingredients WHERE Ingredient_Name = :Ingredient_Name");
          $ingredientCheckQuery->bindParam(':Ingredient_Name', $ingredients[$i]);
          $ingredientCheckQuery->execute();
          $ingredientResult = $ingredientCheckQuery->fetch(PDO::FETCH_ASSOC);
          $Ingredient_ID = $ingredientResult['Ingredient_ID'];
        }
        // Insert into rcp_ingredients
        $rcpingredientQuery->bindParam(':Recipe_ID', $Recipe_ID);
        $rcpingredientQuery->bindParam(':Ingredient_ID', $Ingredient_ID);
        $rcpingredientQuery->bindParam(':Ingredient_quantity', $quantities[$i]);
        $rcpingredientQuery->bindParam(':Ingredient_unit', $units[$i]);
        $rcpingredientQuery->execute();
      }

      // Insert recipe instructions into the rcp_steps table
      $stepQuery = $conn->prepare("INSERT INTO rcp_steps (Recipe_ID, Step_num, Step_description) VALUES (:Recipe_ID, :Step_num, :Step_description)");
      foreach ($steps as $i => $step){
        $stepNumber = $i + 1;
        $stepQuery->bindParam(':Recipe_ID', $Recipe_ID);
        $stepQuery->bindParam(':Step_num', $stepNumber);
        $stepQuery->bindParam(':Step_description', $step);
        $stepQuery->execute();
      }

      // Insert recipe baking reminders into the rcp_reminders table
      $reminderQuery = $conn->prepare("INSERT INTO rcp_reminders (Recipe_ID, Reminder_description) VALUES (:Recipe_ID, :Reminder_description)");
      foreach ($reminders as $reminder){
        $reminderQuery->bindParam(':Recipe_ID', $Recipe_ID);
        $reminderQuery->bindParam(':Reminder_description', $reminder);
        $reminderQuery->execute();
      }

      $conn->commit();
  
      if($response){
        $_SESSION['message_display3'] = "Recipe has been added successfully!";
        return $Recipe_ID;
      } else{
      return FALSE;
      }
    } catch (Exception $e) {
      $conn->rollBack();
      throw $e;
  }
}
?>


<?php
  //SQL Retrieve All Recipe in Category Data
  function retrieve_alldata3(){
    $conn = getDatabaseConnection();


    $query = $conn->prepare("SELECT recipes.Recipe_Name, rcp_categories.Category_Name FROM recipes JOIN rcp_num_categories ON recipes.Recipe_ID = rcp_num_categories.Recipe_ID JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID ORDER BY Category_Criteria");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    $groupedResults = [];
    foreach ($result as $row){
      $recipeName = $row['Recipe_Name'];
      $categoryName = $row['Category_Name'];
      if (!isset($groupedResults[$recipeName])) {
        $groupedResults[$recipeName] = [];
    }
    $groupedResults[$recipeName][] = $categoryName;
    }
    return $groupedResults;
  }
?>


<?php
  //SQL Retrieve All Recipe Data From A User
  function retrieve_allrecipe($start = 1, $rowsper_page = 5){
    $conn = getDatabaseConnection();

    $offset = ($start - 1)  * $rowsper_page;

    $query= $conn->prepare("SELECT * FROM recipes WHERE recipes.User_ID = :userID ORDER BY Date_Updated DESC LIMIT :Limit OFFSET :Offset");
    $query->bindParam(':userID', $_SESSION['userID']);
    $query->bindParam(':Limit', $rowsper_page, PDO::PARAM_INT);
    $query->bindParam(':Offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  //SQL Retrieve All Recipe Data
  function retrieve_allrecipe2($start = 1, $rowsper_page = 16){
    $conn = getDatabaseConnection();

    $offset = ($start - 1)  * $rowsper_page;

    $query= $conn->prepare("SELECT * FROM recipes ORDER BY Date_Updated DESC LIMIT :Limit OFFSET :Offset");
    $query->bindParam(':Limit', $rowsper_page, PDO::PARAM_INT);
    $query->bindParam(':Offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  //SQL Retrieve All Recipe Data that are labelled on a criteria
  function retrieve_allrecipe3_category($Category_Name, $start = 1, $rowsper_page = 16){
    $conn = getDatabaseConnection();

    $offset = ($start - 1)  * $rowsper_page;

    $query= $conn->prepare("SELECT recipes.* FROM recipes INNER JOIN rcp_num_categories ON recipes.Recipe_ID = rcp_num_categories.Recipe_ID INNER JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID WHERE rcp_categories.Category_Name = :Category_Name ORDER BY recipes.Date_Updated DESC LIMIT :Limit OFFSET :Offset");
    $query->bindParam(':Category_Name', $Category_Name);
    $query->bindParam(':Limit', $rowsper_page, PDO::PARAM_INT);
    $query->bindParam(':Offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  // SQL Retrieve the 4 Most Recently Added Recipes
  function retrieve_recent_recipes(){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("SELECT * FROM recipes ORDER BY Date_Created DESC LIMIT 4");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $conn = NULL;

    return $result;
  }
?>


<?php
  //SQL Retrieve the 12 Simplest Recipe Data
  function retrieve_featured_recipes(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT recipes.*, COUNT(DISTINCT rcp_ingredients.Ingredient_ID) AS ingredient_count,COUNT(DISTINCT rcp_steps.Step_num) AS instruction_count, (COUNT(DISTINCT rcp_ingredients.Ingredient_ID) + COUNT(DISTINCT rcp_steps.Step_num)) AS complex_recipe FROM recipes LEFT JOIN rcp_ingredients ON recipes.Recipe_ID = rcp_ingredients.Recipe_ID LEFT JOIN rcp_steps ON recipes.Recipe_ID = rcp_steps.Recipe_ID GROUP BY recipes.Recipe_ID ORDER BY complex_recipe ASC LIMIT 12");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  //SQL Get Recipe Data to Update
  function getrecipedetails($recipe_ID){
    $conn = getDatabaseConnection();
    // Fetch primary details of the recipe
    $query = $conn->prepare("SELECT * FROM recipes WHERE Recipe_ID = :Recipe_ID LIMIT 1");
    $query->bindParam(':Recipe_ID', $recipe_ID);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);

    // Fetch the author's name of the recipe
    $query = $conn->prepare("SELECT recipes.*, users.First_Name, users.Last_Name FROM recipes JOIN users ON recipes.User_ID = users.User_ID WHERE recipes.Recipe_ID = :Recipe_ID LIMIT 1");
    $query->bindParam(':Recipe_ID', $recipe_ID);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if($row){
        // Fetch categories associated with the recipe
        $categoryQuery = $conn->prepare("SELECT rcp_categories.Category_ID, rcp_categories.Category_Name,  rcp_categories.Category_Criteria FROM rcp_num_categories JOIN rcp_categories ON rcp_num_categories.Category_ID = rcp_categories.Category_ID WHERE rcp_num_categories.Recipe_ID = :Recipe_ID ORDER BY Category_Criteria");
        $categoryQuery->bindParam(':Recipe_ID', $recipe_ID);
        $categoryQuery->execute();
        $row['categories'] = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);

        // Fetch ingredients associated with the recipe
        $ingredientQuery = $conn->prepare("SELECT rcp_ingredients.Ingredient_ID, ingredients.Ingredient_Name, rcp_ingredients.Ingredient_quantity, rcp_ingredients.Ingredient_unit FROM rcp_ingredients JOIN ingredients ON rcp_ingredients.Ingredient_ID = ingredients.Ingredient_ID WHERE rcp_ingredients.Recipe_ID = :Recipe_ID");
        $ingredientQuery->bindParam(':Recipe_ID', $recipe_ID);
        $ingredientQuery->execute();
        $row['ingredients'] = $ingredientQuery->fetchAll(PDO::FETCH_ASSOC);

        // Fetch steps associated with the recipe
        $stepQuery = $conn->prepare("SELECT Step_num, Step_description FROM rcp_steps WHERE Recipe_ID = :Recipe_ID ORDER BY Step_num ASC");
        $stepQuery->bindParam(':Recipe_ID', $recipe_ID);
        $stepQuery->execute();
        $row['steps'] = $stepQuery->fetchAll(PDO::FETCH_ASSOC);

        // Fetch reminders associated with the recipe
        $reminderQuery = $conn->prepare("SELECT Reminder_description FROM rcp_reminders WHERE Recipe_ID = :Recipe_ID");
        $reminderQuery->bindParam(':Recipe_ID', $recipe_ID);
        $reminderQuery->execute();
        $row['reminders'] = $reminderQuery->fetchAll(PDO::FETCH_ASSOC);
    }
    $conn = NULL;
    return $row;
}
?>


<?php
  //SQL Delete Recipe and its Relational Data
  function deletedata3($Recipe_ID){
    $conn = getDatabaseConnection();

    $query = $conn->prepare("SELECT Ingredient_ID FROM rcp_ingredients WHERE Recipe_ID = :Recipe_ID");
    $query->bindParam(':Recipe_ID', $Recipe_ID);
    $query->execute();
    $ingredientIds = $query->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($ingredientIds)) {
      $inQuery = implode(',', array_fill(0, count($ingredientIds), '?'));
      $query = $conn->prepare("DELETE FROM ingredients WHERE Ingredient_ID IN ($inQuery)");
      foreach ($ingredientIds as $k => $id) {
        $query->bindValue(($k+1), $id);
      }
      $query->execute();
    }

    $query = $conn->prepare("DELETE FROM rcp_ingredients WHERE Recipe_ID = :Recipe_ID");
    $query->bindParam(':Recipe_ID', $Recipe_ID);
    $query->execute();

    $query = $conn->prepare("DELETE FROM recipes WHERE Recipe_ID = :Recipe_ID");
    $query->bindparam(':Recipe_ID', $Recipe_ID);
    $response= $query->execute();

    // Update the number_of_recipes into the rcp_num_categories table
    $updateQuery = "UPDATE rcp_categories c SET Num_of_Recipes = (SELECT COUNT(*) FROM rcp_num_categories rnc WHERE rnc.Category_ID = c.Category_ID)";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->execute();
    $conn = NULL;

    if($response){
      $_SESSION['message_display3'] = "Recipe has been permanently deleted!";
      header("Location: http://localhost/RecipeSharing_WebApp/baker/index2.php");
      exit();
    } else{
      echo "Failed!";
    }
  }
?>


<?php
  //SQL Update Recipe Data
  function updatedata3($Recipe_ID, $Recipe_Name, $Rcp_Description, $Preparation_Time, $Cook_Time, $Servings, $Rcp_Picture, $Category_Names, $ingredients, $quantities, $units, $steps, $reminders){
    $conn = getDatabaseConnection();
    $conn->beginTransaction();

    try{
      // Update the recipe primary details into the recipes table
      $query = $conn->prepare("UPDATE recipes SET Recipe_Name= :Recipe_Name, Rcp_Description= :Rcp_Description, Preparation_Time= :Preparation_Time, Cook_Time= :Cook_Time, Servings= :Servings, Rcp_Picture= :Rcp_Picture WHERE Recipe_ID= :Recipe_ID");
      $query->bindParam(':Recipe_ID', $Recipe_ID);
      $query->bindParam(':Recipe_Name', $Recipe_Name);
      $query->bindParam(':Rcp_Description', $Rcp_Description);
      $query->bindParam(':Preparation_Time', $Preparation_Time);
      $query->bindParam(':Cook_Time', $Cook_Time);
      $query->bindParam(':Servings', $Servings);
      $query->bindParam(':Rcp_Picture', $Rcp_Picture);
      $response = $query->execute();

      // Update the categories into the rcp_num_categories table
      $deleteQuery = $conn->prepare("DELETE FROM rcp_num_categories WHERE Recipe_ID = :Recipe_ID");
      $deleteQuery->bindParam(':Recipe_ID', $Recipe_ID);
      $deleteQuery->execute();

      foreach ($Category_Names as $Category_ID){
        $insertQuery = $conn->prepare("INSERT INTO rcp_num_categories (Recipe_ID, Category_ID) VALUES (:Recipe_ID, :Category_ID)");
        $insertQuery->bindValue(':Recipe_ID', $Recipe_ID);
        $insertQuery->bindValue(':Category_ID', $Category_ID);
        $insertQuery->execute();
      }


      // Update the number_of_recipes into the rcp_num_categories table
      $updateQuery = "UPDATE rcp_categories c SET Num_of_Recipes = (SELECT COUNT(*) FROM rcp_num_categories rnc WHERE rnc.Category_ID = c.Category_ID)";
      $updateStmt = $conn->prepare($updateQuery);
      $updateStmt->execute();

      // Update the recipe ingredients into the ingredients table and then into rcp_ingredients table
      $fetchIngredientIdsQuery = $conn->prepare("SELECT Ingredient_ID FROM rcp_ingredients WHERE Recipe_ID = :Recipe_ID");
      $fetchIngredientIdsQuery->bindParam(':Recipe_ID', $Recipe_ID);
      $fetchIngredientIdsQuery->execute();
      $existingIngredientIds = $fetchIngredientIdsQuery->fetchAll(PDO::FETCH_COLUMN, 0);

      // Delete existing ingredients from rcp_ingredients
      if (!empty($existingIngredientIds)) {
          $inQuery = implode(',', array_fill(0, count($existingIngredientIds), '?'));
          $deleteIngredientsQuery = $conn->prepare("DELETE FROM ingredients WHERE Ingredient_ID IN ($inQuery)");
          foreach ($existingIngredientIds as $k => $id) {
            $deleteIngredientsQuery->bindValue(($k+1), $id);
          }
          $deleteIngredientsQuery->execute();
      }
      $deleteRcpIngredientsQuery = $conn->prepare("DELETE FROM rcp_ingredients WHERE Recipe_ID = :Recipe_ID");
      $deleteRcpIngredientsQuery->bindParam(':Recipe_ID', $Recipe_ID);
      $deleteRcpIngredientsQuery->execute();

      $ingredientQuery = $conn->prepare("INSERT INTO ingredients (Ingredient_Name) VALUES (:Ingredient_Name) ON DUPLICATE KEY UPDATE Ingredient_ID = LAST_INSERT_ID(Ingredient_ID)");
      $ingredientCheckQuery = $conn->prepare("SELECT Ingredient_ID FROM ingredients WHERE Ingredient_Name = :Ingredient_Name");
      $rcpingredientQuery = $conn->prepare("INSERT INTO rcp_ingredients (Recipe_ID, Ingredient_ID, Ingredient_quantity, Ingredient_unit) VALUES (:Recipe_ID, :Ingredient_ID, :Ingredient_quantity, :Ingredient_unit)");

      for($i = 0; $i < count($ingredients); $i++){
        // Checks if the ingredient already exists
        $ingredientQuery->bindParam(':Ingredient_Name', $ingredients[$i]);
        $ingredientQuery->execute();
        $Ingredient_ID = $conn->lastInsertId();

        if ($Ingredient_ID == 0){
          $ingredientCheckQuery->bindParam(':Ingredient_Name', $ingredients[$i]);
          $ingredientCheckQuery->execute();
          $ingredientResult = $ingredientCheckQuery->fetch(PDO::FETCH_ASSOC);
          $Ingredient_ID = $ingredientResult['Ingredient_ID'];
        }
        // Insert into rcp_ingredients
        $rcpingredientQuery->bindValue(':Recipe_ID', $Recipe_ID);
        $rcpingredientQuery->bindValue(':Ingredient_ID', $Ingredient_ID);
        $rcpingredientQuery->bindValue(':Ingredient_quantity', $quantities[$i]);
        $rcpingredientQuery->bindValue(':Ingredient_unit', $units[$i]);
        $rcpingredientQuery->execute();
      }

      // Update recipe instructions into the rcp_steps table
      $deleteQuery = $conn->prepare("DELETE FROM rcp_steps WHERE Recipe_ID = :Recipe_ID");
      $deleteQuery->bindParam(':Recipe_ID', $Recipe_ID);
      $deleteQuery->execute();  

      $stepQuery = $conn->prepare("INSERT INTO rcp_steps (Recipe_ID, Step_num, Step_description) VALUES (:Recipe_ID, :Step_num, :Step_description) ON DUPLICATE KEY UPDATE Step_description = VALUES(Step_description)");

      foreach ($steps as $i => $step){
        $stepNumber = $i + 1;
        $stepQuery->bindValue(':Recipe_ID', $Recipe_ID);
        $stepQuery->bindValue(':Step_num', $stepNumber);
        $stepQuery->bindValue(':Step_description', $step);
        $stepQuery->execute();
      }

      // Update recipe baking reminders into the rcp_reminders table
      $deleteQuery = $conn->prepare("DELETE FROM rcp_reminders WHERE Recipe_ID = :Recipe_ID");
      $deleteQuery->bindParam(':Recipe_ID', $Recipe_ID);
      $deleteQuery->execute();  

      $reminderQuery = $conn->prepare("INSERT INTO rcp_reminders (Recipe_ID, Reminder_description) VALUES (:Recipe_ID, :Reminder_description) ON DUPLICATE KEY UPDATE Reminder_description = VALUES(Reminder_description)");

      foreach ($reminders as $reminder){
        $reminderQuery->bindValue(':Recipe_ID', $Recipe_ID);
        $reminderQuery->bindValue(':Reminder_description', $reminder);
        $reminderQuery->execute();
      }

      $conn->commit();
  
      if($response){
        $_SESSION['message_display3'] = "Recipe has been updated successfully!";
        return $Recipe_ID;
      } else{
      return FALSE;
      }
    } catch (Exception $e) {
      $conn->rollBack();
      throw $e;
    }
    $conn = NULL; 
}
?>


<?php
  //SQL Retrieve Maximum Number of Recipes From a Baker
  function retrieve_countrecipes(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT COUNT(*) FROM recipes WHERE User_ID = (SELECT User_ID FROM users WHERE Email = :useremail)");
    $query->bindParam(':useremail', $_SESSION['useremail']);
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>


<?php
  //SQL Retrieve Maximum Number of All Recipes
  function retrieve_allrecipes(){
    $conn = getDatabaseConnection();

    $query= $conn->prepare("SELECT COUNT(*) FROM recipes");
    $query->execute();
    $result= $query->fetchall(PDO::FETCH_ASSOC);
    $conn= NULL;

    return $result;
  }
?>