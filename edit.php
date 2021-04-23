<?php 
    include 'partials/partials.header.php';
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