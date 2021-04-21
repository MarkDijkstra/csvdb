<?php 
    if (!$data && !isset($data['columns']) || !isset($data['fields'])) {
        echo '<div class="danger">File not found!</div>';
    } else {        
        ?>
        <form action="./index.php" method='post' enctype="multipart/form-data">
            <h2>File: <input type="text" value="<?= $_POST['field--name'] ?? '';?>" name="edit--name"></h2>
            <table class="table">
                <thead>
                    <tr>
                        <?php 
                            foreach ($data['columns'] as $col) {
                                echo '<th><input type="text" value="'.trim($col).'" name="edit--columns[0][]"></th>';
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $ii = 1;
                        foreach ($data['fields'] as $key => $field) {
                            echo '<tr>';
                            foreach ($field as $item) {
                                echo '<td><input type="text" value="'.trim($item).'" name="edit--fields['.$ii.'][]"></td>';
                            }
                            $ii++;
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
            <div class="form__row">
                <button type="submit" name="save--button">Save file</button>
            </div>
            <input type="hidden" value="<?= $_POST['field--delimiter'] ?? 0;?>" name="edit--delimiter"/>
        </form>
      
<?php } ?>
