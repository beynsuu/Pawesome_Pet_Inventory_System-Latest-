<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-shopping-cart"></span>
        <span>Products</span>
      </strong>
      <div class="pull-right">
        <a href="add_product.php" class="glypicon glyphicon-plus btn btn-primary">Add New</a>
      </div>
    </div>
    <div class="panel-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th class="text-center" style="width: 10%"> Photo</th>
            <th class="text-center"> Product Title </th>
            <th class="text-center" style="width: 10%;"> Categories </th>
            <th class="text-center" style="width: 10%;"> In-Stock </th>
            <th class="text-center" style="width: 10%;"> Buying Price </th>
            <th class="text-center" style="width: 10%;"> Selling Price </th>
            <th class="text-center" style="width: 20%;"> Product Added </th>
            <th class="text-center" style="width: 100px;"> Actions </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product):?>
          <tr>
            <td class="text-center"><?php echo count_id();?></td>
            <td>
              <?php if($product['media_id'] === '0'): ?>
                <img class="img-avatar img-square" src="uploads/products/no_image.png" alt="">
              <?php else: ?>
              <img class="img-avatar img-square" src="uploads/products/<?php echo $product['image']; ?>" alt="">
            <?php endif; ?>
            </td>
            <td> <?php echo remove_junk($product['name']); ?></td>
            <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
            <td class="text-center">
                <?php
                $quantity = remove_junk($product['quantity']);
                if ($quantity <= 0) {
                    echo '<span class="btn btn-danger btn-xs">Out of Stock</span>';
                } elseif ($quantity <= 20) {
                    echo '<span class="btn btn-warning btn-xs">Low in Stock</span>';
                } else {
                    echo $quantity;
                }
                ?>
            </td>
            <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
            <td class="text-center"> <?php echo remove_junk($product['sale_price']); ?></td>
            <td> <?php echo read_date($product['date']); ?></td>
            <td class="text-center">
              <div class="btn-group">
                <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                  <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                  <span class="glyphicon glyphicon-trash"></span>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </tabel>
    </div>
  </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
