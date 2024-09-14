## Recipe Sharing Web Application - SimpleSweets [2024] 
- developed by Harvey Pedrosa (BSIT-Sophomore: #learning_Web_Development)

SimpleSweets is a recipe-sharing web application specifically for desserts or sweet foods that provides users or visitors with a comprehensive platform for discovering, sharing, and exploring sweet creations from all around the world, regardless of any cultural diversities published by passionate bakers authorized by admin/s within the app.

This web application uses technological resources (languages, framework, admin_template, and more), such as in the front-end:
# HTML, CSS, Javascript, Bootstrap (Framework), & Admin_LTE (Template)
while in the back-end:
# PHP, MySQL, & XAMPP (Mini Web Server Platform)
all of which to develop the web application to serve its main objectives and purpose of promoting the love for creating sweets from scratch. Not to mention, this serves as my 2nd year final requirement for my course IT 263: Integrative Programming and Technologies 1. Other than that, this project is a personal project developed for my enthusiasm for baking cakes and other desserts.

**[App File Directory intended for Startup via Xampp]**

'This PC -> Local Disc (C:) -> xampp -> htdocs -> (_file_name) -replace the actual file name-'

For the Web Application's Database (using MySQL on PHPMyAdmin) - **swtrecipe_system**
  - Import the file 'swtrecipe_system.sql' to phpMyAdmin make sure the Xampp modules (Apache & MySQL) are On.
  - Initialization of Incrementation for the Primary_Keys of every table on the 'Operations' tab is as follows:

* User-ID: 1
* Category_ID: 119
* Rcp_num_Category: 494
* Recipe_ID: 1100
* Ingredient_ID: 800
* Rcp_Ingredient_ID: 931
* Rcp_Steps_ID: 448
* Rcp_reminder_ID 63


# Application's Main Functionalities / Features:
1. Add Users:
    a. The admin will be the one who will add new users.
    b. The user will be assigned in a particular role such as Admin, and Baker.
    c. The system shall have a platform for registered users to login.
2. Add Recipes:
    a. Registered users can add their own recipes to the platform.
    b. The recipe submission process includes fields for ingredients, preparation steps, cooking time,     
       serving size, and any special instructions.
    c. Users can publish their completed recipes to make them publicly accessible on the platform. 
3. Recipe Categorization:
    a. Recipes are categorized by various criteria such as cuisine (e.g., American, Filipino), dessert type (e.
       g., cake, bread), dietary restrictions (e.g., vegan, gluten-free), or occasion (e.g., holiday, party).
    b. Users can browse recipes by category to discover new recipes or find recipes that fit their dietary   
       preferences.
4. Search Recipes:
    a. Users can search for recipes based on keywords, ingredients, cuisine, or dessert type.
    b. The search functionality responsively robust and allow users to find recipes quickly and efficiently.
    c. Users can filter search results based on various criteria, such as ingredient availability, cooking time, 
       or serving size.
    d. Advanced search options allow users to refine their search queries and find recipes that 
       match specific criteria.
5. Recipe Details:
    a. Each recipe page displays detailed information such as ingredients, step-by-step instructions, description 
       overview, and baking notes.
    b. Rich media features like photos or animations enhance the presentation of recipes and help 
       users visualize the making process.


# Application's Page Accessibility:
1. Admin:
    a. Capable of managing the user accounts.
    b. Capable of managing recipe categorization.
2. Baker:
    a. Capable of managing recipes. 
3. Visitor: 
    a. Capable of viewing and searching the published recipes.

