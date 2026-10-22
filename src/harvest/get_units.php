    <?php
    require '../config/database.php';

    $db = new dbase;
    $property_id = (int)($_POST['property_id'] ?? 0);
        $result = $db->con->query("
             SELECT id, unit_number, rent
                FROM property_units
                    WHERE property_id = '$property_id' AND active ='1'
    ");

    echo '<option value="">Select Unit</option>';

        while($row = $result->fetch_assoc()){
            echo "<option value='{$row['id']}' data-rent='{$row['rent']}'>
                 Unit {$row['unit_number']} - KES {$row['rent']}
        </option>";
    }
    ?>
