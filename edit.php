<?php 
    include 'partials/partials.header.php';
    require_once "./classes/Api.php";
?>
   <div class="content">
      <?php
         $id   = $_GET['id'] ?? false;
         $api  = new Api($connection);
         $data = $api->find($id);

         if (isset($data['columns'])) {
            $data['columns'] = unserialize($data['columns']);
         } else {
            $data['columns'] = [];
         }
         if (isset($data['fields'])) {
            $data['fields'] = unserialize($data['fields']);
         } else {
            $data['fields'] = [];
         }

         include 'partials/partials.editform.php'; 
      ?>
   </div>
</body>
</html>