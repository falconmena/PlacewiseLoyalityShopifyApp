<?php
require_once __DIR__ . "/../etc/admin_config.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Loyalty</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo root_path . "/assets/css/main.css"?>"></script>
</head>
    <body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo root_path. "/index.php?hmac=".$hmac."&shop=".$shop ."&locale=".$locale."&new_design_language=".$new_design_language."&session=".$session."&timestamp=".$timestamp; ?>">Techs Factory</a>
            </div> -->
            <ul class="nav navbar-nav">
            <li class="<?php if (pageName == "index")echo "active";?>"><a href="<?php echo root_path. "/index.php?hmac=".$hmac."&shop=".$shop ."&locale=".$locale."&new_design_language=".$new_design_language."&session=".$session."&timestamp=".$timestamp; ?>">Home</a></li>
            <li class="<?php if (pageName == "customers")echo "active";?>"><a href="<?php echo root_path . "/view/customers.php?hmac=".$hmac."&shop=".$shop."&locale=".$locale."&new_design_language=".$new_design_language."&session=".$session."&timestamp=".$timestamp;; ?>">Customers</a></li>
            <!-- <li class="<?php if (pageName == "products")echo "active";?>"><a href="<?php echo root_path . "/view/products.php?hmac=".$hmac."&shop=".$shop."&locale=".$locale."&new_design_language=".$new_design_language."&session=".$session."&timestamp=".$timestamp;; ?>">Products</a></li> -->
            <li class="<?php if (pageName == "discount")echo "active";?>"><a href="<?php echo root_path . "/view/discount.php?hmac=".$hmac."&shop=".$shop."&locale=".$locale."&new_design_language=".$new_design_language."&session=".$session."&timestamp=".$timestamp;; ?>">Discount</a></li>
            </ul>
        </div>
    </nav>
