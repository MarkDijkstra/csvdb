<?php 
   require_once 'config.php'; 
   require_once "./classes/Api.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>CSVDB edit</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
   <?php
      include 'partials/partials.navigation.php'; 
   ?>
   <div class="content">
      <?php
         $id   = $_GET['id'] ?? false;
         $api  = new Api($connection);
         $data = $api->find($id);

         if (isset($data['columns'])) {
            $columns = unserialize($data['columns']);
         } else {
            $columns = [];
         }
         if (isset($data['fields'])) {
            $fields = unserialize($data['fields']);
         } else {
            $fields = [];
         }

         include 'partials/partials.editform.php'; 
      ?>
   </div>
</body>
</html>