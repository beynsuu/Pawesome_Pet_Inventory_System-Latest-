<?php
  $page_title = 'Add Supplier';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $c_user = current_user();
  $groups = find_all('user_groups');
?>
<?php
  if(isset($_POST['add_user'])){

  $req_fields = array('full-name','username','password','level' );
  validate_fields($req_fields);

  if(empty($errors)){
      $name   = remove_junk($db->escape($_POST['full-name']));
      $username   = remove_junk($db->escape($_POST['username']));
      $password   = remove_junk($db->escape($_POST['password']));
      $user_level = (int)$db->escape($_POST['level']);
      $password = sha1($password);
      $activity = 'added account';
      $date   = make_date();

      $sql = "INSERT INTO users (";
      $sql .="name,username,password,user_level,status";
      $sql .=") VALUES (";
      $sql .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
      $sql .=")";
      $db->query($sql);

      $user_ID = isset($c_user['id']) ? (int)$c_user['id'] : 0;

      $query = "INSERT INTO activity_log (userID, activity, time)
              VALUES ('{$user_ID}', '{$activity}', '{$date}')";

      if($db->query($query)){
        $session->msg('s',"User account has been creted! ");
        redirect('users.php', false);
      } else {
        //failed
        $session->msg('d',' Sorry failed to create account!');
        redirect('add_user.php', false);
      }
  } else {
    $session->msg("d", $errors);
    redirect('add_user.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>
  <?php echo display_msg($msg); ?>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New Supplier</span>
      </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <form method="post" action="add_user.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="full-name" placeholder="Full Name">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name ="password"  placeholder="Password">
            </div>
            <div class="form-group">
              <label for="level">Supply</label>
                <select class="form-control" name="level">
                  <?php foreach ($groups as $group ):?>
                  <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group clearfix">
              <button type="submit" name="add_user" class="btn btn-primary">Add Now</button>
            </div>
        </form>
        </div>

      </div>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
