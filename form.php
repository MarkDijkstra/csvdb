<?php 
   require_once 'config.php'; 
?>
<!DOCTYPE html>
<html>
<head>
<title>CSVDB Upload form</title>

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
    select,
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

        $name      = $_POST['field--name'];
        $file      = $_FILES['field--file'];
        $delimiter = $_POST['field--delimiter'];

        // demo display content
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {

            $csv    = new Csv($file["tmp_name"], false, $delimiter);

            echo '<pre>';
                while($data = $csv->get(20)){
                   print_r($data);
                }
            echo '</pre>';

            // save name to file record
           
            $import = new Import($connection, $csv);
            $import->insertFile($name);
         
        }



    } elseif($_POST) {
       echo 'Some fields are empty!';
    }
?>

    <form action="./form.php" method='post' enctype="multipart/form-data">
    <fieldset>
        <legend>CSVDB Upload form</legend>

        <div class="form__row">
            <label for="field--name">Name:</label>
            <input type="text" name="field--name" id="field--name"/>
        </div>
        <div class="form__row">
            <label for="field--delimiter">Delimiter:</label>
            <select name="field--delimiter" id="field--delimiter">
                <option value="0">Automatic detection (default)</option>
                <option value="1">Tab</option>
                <option value="2">Semicolon (;)</option>
                <option value="3">Pipe (|)</option>
                <option value="4">Comma (,)</option>
            </select>
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