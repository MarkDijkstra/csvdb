<?php 
    if (!$data && !isset($data['columns']) || !isset($data['fields'])) {
        echo '<div class="danger">File not found!</div>';
    } else {        
        ?>
        <form action="./index.php" method='post' enctype="multipart/form-data">
            <h2>File: <?= $data['name'] ?? 'unknown'?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <?php 
                            foreach ($data['columns'] as $col) {
                                echo '<th><input type="text" value="'.$col.'"></th>';
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($data['fields'] as $key => $field) {
                            echo '<tr>';
                            foreach ($field as $item) {
                                echo '<td><input type="text" value="'.$item.'"></td>';
                            }
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
            <div class="form__row">
                <button type="submit" name="save--button">Save file</button>
            </div>
        </form>
      
<?php } ?>
