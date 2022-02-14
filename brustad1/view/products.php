<?php

require_once __DIR__ . "/header.php";
$params = array(
//   'id' => '5456358277284',
//   'fields' => 'id,vendor',
  // 'limit' => 3
);
$products = $shopify->Product->get($params);
?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">title</th>
      <th scope="col">vendor</th>
      <th scope="col">status</th>
      <th scope="col">points</th>
    </tr>
  </thead>
  <tbody>
    <?php
        foreach ($products as $key => $value) {
            ?>
                <tr>
                    <th scope="row"><?php echo $value['id'];?></th>
                    <td><?php echo $value['title'];?></td>
                    <td><?php echo $value['vendor'];?></td>
                    <td><?php echo (!empty($value['status']) ? $value['status'] : '' );?></td>
                    <td>0</td>
                </tr>
            <?php
        }
    ?>  
  </tbody>
</table>
<?php
require_once __DIR__ . "/footer.php";
?>