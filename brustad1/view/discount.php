<?php

require_once __DIR__ . "/header.php";
$discount_obj = new Discount();
if(!empty($_POST['submit_form']) && $_POST['submit_form'] == 1){
  $title = $_POST['title'];
  $code = $_POST['code'];
  $points = $_POST['points'];
  $type = $_POST['type'];
  $value = $_POST['discount_value'];
  if($_POST['post_type'] == "add"){
    // $discount_obj->create($title,$code,$type,$value,$points);
    $discount_obj->create($title,$type,$value,$points);
  }else{
    $id = $_POST['post_id'];
    // $discount_obj->update($title,$code,$type,$value,$points,$id);
    $discount_obj->update($title,$type,$value,$points,$id);
  }
}
$discount_data = $discount_obj->getAllDiscount();
?>
<button type="button" onclick="addDiscount()"  class="btn btn-primary" >
  Add Discounts
</button>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <!-- <th scope="col">Code</th> -->
      <th scope="col">Type</th>
      <th scope="col">Value</th>
      <th scope="col">Points</th>
      <th scope="col">Customers</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php
        foreach ($discount_data as $key => $value) {
            ?>
                <tr>
                    <th scope="row"><?php echo $value['id'];?></th>
                    <td><?php echo $value['title'];?></td>
                    <!-- <td><?php echo $value['code'];?></td> -->
                    <td><?php if($value['type'] == 1){echo "Percentage";}elseif($value['type'] == 2){echo "Fixed amount";}?></td>
                    <td><?php echo $value['value'];?></td>
                    <td><?php echo $value['points'];?></td>
                    <td>0</td>
                    <td onclick="editDiscount(<?php echo $value['id'];?>,'<?php echo $value['title'];?>','<?php echo $value['code'];?>','<?php echo $value['type'];?>','<?php echo $value['value'];?>','<?php echo $value['points'];?>')">Edit</td>
                </tr>
            <?php
        }
    ?>  
  </tbody>
</table>
<div class="modal fade" id="addDiscounts" tabindex="-1" role="dialog" aria-labelledby="addDiscounts" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="discountLabel">Add Discount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?hmac=".$hmac."&shop=".$shop ."&locale=".$locale."&new_design_language=".$new_design_language."&session=".$session."&timestamp=".$timestamp; ?>">
          <input type="hidden" id="post_id" name="post_id" value="">
          <input type="hidden" id="post_type" name="post_type" value="">
          <input type="hidden" name="submit_form" value="1">
          <div class="form-group">
            <label for="code">Title</label>
            <input type="text" class="form-control" required="1" name="title" id="title" placeholder="Enter Title">
          </div>
          <!-- <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" required="1" name="code" id="code" placeholder="Enter Code">
          </div> -->
          <div class="form-group">
            <label for="type">Type</label>
            <div class="form-check">
              <input type="radio"  id=type_per name="type" value="1">
              <label for="type_per" style="padding-right:8px;">Percentage</label>
              <input type="radio" id="type_fixed" name="type" value="2">
              <label for="type_fixed">Fixed amount</label>
            </div>
          </div>
          <div class="form-group">
            <label for="value">Discount value</label>
            <input type="text" class="form-control" required="1" name="discount_value" id="discount_value" placeholder="Discount value">
          </div>
          <div class="form-group">
            <label for="points">Points</label>
            <input type="text" class="form-control" required="1" name="points" id="points" placeholder="Points">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
require_once __DIR__ . "/footer.php";
?>
