<?php 
    include 'partials/partials.header.php';
    require_once "./classes/Api.php";
?>
   <div class="content">
      <?php
         $id   = $_GET['id'] ?? false;
         $api  = new Api($connection);
         $data = $api->find($id);
         
         include 'partials/partials.editform.php'; 
      ?>
   </div>
</body>
</html>