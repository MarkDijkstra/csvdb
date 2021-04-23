<?php 
    include 'partials/partials.header.php';

    $id      = $_GET['id'] ?? false;
    $api     = new Api($connection);
    $data    = $api->find($id);

    if (!$data) {
        echo '<div class="danger">File not found!</div>';
    } else {
        $columns = unserialize($data['columns']);
        $fields  = unserialize($data['fields']); 
        array_shift($fields);// quick fix
        ?>
      
         <h2>File: <?= $data['name'] ?? 'unknown'?></h2>
         <table class="table">
             <thead>
                <tr>
                   <?php 
                      foreach ($columns as $col) {
                         echo '<th>'.$col.'</th>';
                      }
                   ?>
               </tr>
             </thead>
             <tbody>
                  <?php 
                     foreach ($fields as $key => $field) {
                         echo '<tr>';
                         foreach ($field as $item) {
                            echo '<td>'.$item.'</td>';
                         }
                         echo 's</tr>';
                     }
                  ?>
             </tbody>
         </table>      
   <?php } ?>
</body>
</html>