<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';

$db = new dbase;

$types = $db->con->query("SELECT * FROM property_types WHERE status = 'active' ORDER BY id DESC");

if($types):
    foreach($types as $row):
?>
<tr class="border-b">
<td class="p-3"><?php echo $row['id']; ?></td>
<td class="p-3 font-medium"><?php echo $row['type_name']; ?></td>
<td class="p-3"><?php echo $row['description']; ?></td>
<td class="p-3 flex gap-2">
<a href="#" class="text-blue-600 hover:underline editType"
   data-id="<?php echo $row['id']; ?>"
   data-name="<?php echo $row['type_name']; ?>"
   data-desc="<?php echo $row['description']; ?>">Edit</a>
<a href="#" class="text-red-600 hover:underline deleteType"
   data-id="<?php echo $row['id']; ?>">Delete</a>
</td>
</tr>
<?php
    endforeach;
endif;
?>
