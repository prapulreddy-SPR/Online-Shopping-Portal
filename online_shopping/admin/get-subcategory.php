<?php

require_once("../includes/config.php");
require_once("../data_php/base.php");

$category_id = input("category_id");

$sub_cat =  getAll(json_sub_category, array("category_id" => $category_id));

foreach ($sub_cat as $row) :?>

  <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['sub_category']); ?></option>

<?php
endforeach ?>