
<?php 
    include 'partials/partials.header.php';
?>
    <div class="content">
        <?php        
            require_once "./classes/Csv.php";
            require_once "./classes/Api.php";

            if (isset($_POST['upload--button']) && !empty($_POST['field--name']) && isset($_FILES['field--file']) && $_FILES['field--file']['error'] === UPLOAD_ERR_OK) {
                $name      = $_POST['field--name'];
                $file      = $_FILES['field--file'];
                $delimiter = $_POST['field--delimiter'];           
                $csv       = new Csv($file["tmp_name"], false, $delimiter);    
                $getCsv    = $csv->get();
                $shift     = $getCsv;
                $data      = ['name'=> $name, 
                              'columns' => $getCsv[0], 
                              'fields'=> $shift
                             ];

                include 'partials/partials.editform.php';
                
            } elseif ($_POST && !empty($_POST['edit--name'])) {
                $merger    = array_merge($_POST['edit--columns'], $_POST['edit--fields']);
                $name      = $_POST['edit--name'];
                $delimiter = $_POST['edit--delimiter'];
                $api       = new Api($connection);
                $id        = $api->insert($name, $merger, $delimiter);              
                    
                if ($id) {
                    echo '<div class="success">File "<strong>'.$name.'</strong>"saved. File it <a href="view.php?id='.$id['id'].'">here</a>.</div>';
                }
            } else {
                if ($_POST) {
                    echo '<div class="danger">Some fields are empty!</div>';
                }

                include 'partials/partials.uploadform.php';    
            }          
        ?>
    </div>
</body>
</html>