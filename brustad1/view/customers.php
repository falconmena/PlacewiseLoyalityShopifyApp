<?php

require_once __DIR__ . "/header.php";
$params = array(
//   'id' => '5456358277284',
//   'fields' => 'id,vendor',
  // 'limit' => 3
);
$customers = $shopify->Customer->get($params);
?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">first name</th>
      <th scope="col">last name</th>
      <th scope="col">currency</th>
      <th scope="col">email</th>
      <th scope="col">Points</th>
    </tr>
  </thead>
  <tbody>
    <?php
        foreach ($customers as $key => $value) {
            ?>
                <tr>
                    <th scope="row"><?php echo $value['id'];?></th>
                    <td><?php echo $value['first_name'];?></td>
                    <td><?php echo $value['last_name'];?></td>
                    <td><?php echo $value['currency'];?></td>
                    <td><?php echo $value['email'];?></td>
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