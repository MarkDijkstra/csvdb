<?php 
   require_once 'config.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>CSVDB Upload form</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <?php 
        include 'partials/partials.navigation.php';
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
                $api       = new Api($connection);      
                $getCsv    = $csv->get();
                $shift     = $getCsv;
                array_shift($shift);
                $data   = ['name'=> $name, 
                           'columns' => $getCsv[0], 
                           'fields'=> $shift
                          ];             
                 
                include 'partials/partials.editform.php';  

            } elseif ($_POST && !empty($_POST['field--name']) && isset($_FILES['field--file']) && $_FILES['field--file']['error'] === UPLOAD_ERR_OK) {

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