<?php 
   require_once 'config.php'; 
?>
<!DOCTYPE html>
<html>
<head>
<title>Upload form</title>

<style>
    fieldset{
        border  : 1px solid #222;
        width   : 600px;
        margin  : 100px auto;
        padding : 0 30px;
    }
    label{
        display       : block; 
        margin-bottom : 5px; 
    }
    [type=text]{
        width   : 50%;
        display : block;
        height  : 24px;
    }
    button{
        padding:5px 20px;
    }
    .form__row{
        display : block;
        margin  : 30px 0;
    }
    pre{
        background-color : #eee;
        border           : 1px solid #ccc;
        padding          : 15px;
    }
</style>
</head>

<body>

<?php 

    // test data
    if ($_POST && !empty($_POST['field--name'])) {

        require_once "./classes/Csv.php";
        require_once "./classes/Import.php";

        $name = $_POST['field--name'];
        $file = $_FILES['field--file'];

        // demo display content
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {

            $importer = new Csv($file["tmp_name"],true);

            echo '<pre>';
                while($data = $importer->get(20)){
                   print_r($data);
                }
            echo '</pre>';
         
        }

        // save name to file record
        $import = new Import($connection);
        $import->insertFile($name);

    } elseif($_POST) {
       echo 'Some fields are empty!';
    }
?>

    <form action="./import.php" method='post' enctype="multipart/form-data">
    <fieldset>
        <legend>Upload datasheet</legend>

        <div class="form__row">
            <label for="field--name">Name:</label>
            <input type="text" name="field--name" id="field--name"/>
        </div>
        <div class="form__row">
            <label for="field--file">Import file:</label>
            <input type="file" name="field--file" id="field--file"/>
        </div>
        <div class="form__row">
            <button type="submit" name="upload__field">Upload</button>
        </div>

    </fieldset>
    </form>

</body>
</html>