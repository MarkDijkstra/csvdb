<?php 
    include 'partials/partials.header.php';
?>
    <div class="content">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Added</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php             
                $api  = new Api($connection);
                $data = $api->findAll(API::TABLEFILE);

                if (empty($data)) {
                    echo '<tr>'; 
                    echo '<td colspan="5">No data found.</td>';
                    echo '</tr>'; 
                } else {
                    foreach ($data as $key => $value) {
                        $field = $data[$key];
                        echo '<tr>'; 
                        echo '<td>'.$field['id'].'</td>';
                        echo '<td><a href="view.php?id='.$field['id'].'">'.$field['name'].'</a></td>';
                        echo '<td>'.$field['created_at'].'</td>';
                        echo '<td>'.$field['updated_at'].'</td>';
                        echo '<td>
                            <a href="view.php?id='.$field['id'].'">View</a> | 
                            <a href="edit.php?id='.$field['id'].'">Edit</a>
                        </td>';
                        echo '</tr>'; 
                    }                
                } 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>