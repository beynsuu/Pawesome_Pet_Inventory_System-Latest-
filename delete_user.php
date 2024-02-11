<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $c_user = current_user();
?>
<?php
  $useR = find_by_id('users',(int)$_GET['id']);
  if(!$useR){
    $session->msg("d","Missing User id.");
    redirect('users.php');
  }
?>
<?php
  $delete_id = delete_by_id('users',(int)$_GET['id']);
  $action = 'deleted account';
  $date   = make_date();
  $userID = isset($c_user['id']) ? (int)$c_user['id'] : 0;
  if($delete_id){

    $query = "INSERT INTO activity_log (userID, activity, time)
              VALUES ('{$userID}', '{$action}', '{$date}')";

    if($db->query($query)){
      $session->msg("s","Supplier deleted.");
      redirect('users.php');
    } else {
      $session->msg("d","Supplier deletion failed Or Missing Prm.");
      redirect('users.php');
    }
  }
?>
