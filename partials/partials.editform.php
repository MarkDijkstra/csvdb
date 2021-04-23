<?php 

    if (!$data && !isset($data['columns']) || !isset($data['fields'])) {
        echo '<div class="danger">File not found!</div>';
    } else {
        $edit      = isset($_GET['action']) && $_GET['action'] == 'edit' ?  true : false;
        $name      = $data['name'] ?? '';  
        $columns   = $data['columns'] ?? [];  
        $fields    = $data['fields'] ?? []; 
        $delimiter = $_POST['field--delimiter'] ?? 1000;
        ?>
        <form action="./index.php" method='post' enctype="multipart/form-data">
            <h2>File:
                <?php 
                    if($edit) { 
                        echo '<input type="text" value="'.$name.'" name="edit--name"/>';
                    } else {
                        echo $name;
                    }
                ?>
            </h2>
            <table class="table">
                <thead>
                    <tr>
                        <?php 
                            foreach ($columns as $col) {
                                echo '<th>';
                                if($edit) { 
                                    echo '<input type="text" value="'.trim($col).'" name="edit--columns[0][]"/>';
                                } else {
                                    echo trim($col);
                                }
                                echo '</th>';                                
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $ii = 1;
                        foreach ($fields as $key => $field) {
                            echo '<tr>';
                            foreach ($field as $item) {
                                echo '<td>';
                                if($edit) { 
                                    echo '<input type="text" value="'.trim($item).'" name="edit--fields['.$ii.'][]"/>';
                                } else {
                                    echo trim($item);
                                }
                                echo '</td>';                                
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
            <input type="hidden" value="<?= $delimiter ?>" name="edit--delimiter"/>
        </form>      
<?php } ?>
