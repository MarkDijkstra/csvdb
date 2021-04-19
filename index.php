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
<?php include 'partials/partials.navigation.php';?>

<?php 
    if ($_POST && !empty($_POST['field--name'])) {
        require_once "./classes/Csv.php";
        require_once "./classes/Api.php";

        $name      = $_POST['field--name'];
        $file      = $_FILES['field--file'];
        $delimiter = $_POST['field--delimiter'];

        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $csv = new Csv($file["tmp_name"], false, $delimiter);
            $api = new Api($connection);
            $id  = $api->insert($name, $csv->get());               
            
            if ($id) {
                echo '<div class="success">File "<strong>'.$_POST['field--name'].'</strong>"saved. File it <a href="view.php?id='.$id['id'].'">here</a>.</div>';
            }
        }
    } elseif($_POST) {
       echo 'Some fields are empty!';
    }
?>
<div class="content">

    <form action="./index.php" method='post' enctype="multipart/form-data">
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
</div>
</body>
</html>