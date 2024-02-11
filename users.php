<?php
$page_title = 'All Supplier';
require_once('includes/load.php');
page_require_level(1);
$all_users = find_all_user();
$login_trail = login_trail();
$act_log = activity_log();
?>
<?php include_once('layouts/header.php');?>
<script src="/libs/js/modal_edit.js"></script>
<script src="/libs/js/modal_delete.js"></script>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-user"></span>
          <span>Accounts</span>
        </strong>
        <a href="add_user.php" class="btn btn-info pull-right">Add New Employee</a>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center">Name </th>
                <th class="text-center" style="width: 70px;">User ID</th>
                <th class="text-center">Username</th>
                <th class="text-center" style="width: 15%;">Role</th>
                <th class="text-center" style="width: 10%;">Status</th>
                <th class="text-center" style="width: 25%;">Last Login</th>
                <th class="text-center" style="width: 100px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($all_users as $a_user) : ?>
                <tr>
                  <td class="text-center"><?php echo count_id(); ?></td>
                  <td><?php echo remove_junk(ucwords($a_user['name'])) ?></td>
                  <td class="text-center"><?php echo remove_junk(ucwords($a_user['id'])) ?></td>
                  <td class="text-center"><?php echo remove_junk(ucwords($a_user['username'])) ?></td>
                  <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name'])) ?></td>
                  <td class="text-center">
                    <?php if ($a_user['status'] === '1') : ?>
                      <span class="label label-success"><?php echo "Active"; ?></span>
                    <?php else : ?>
                      <span class="label label-danger"><?php echo "Deactive"; ?></span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo read_date($a_user['last_login']) ?></td>
                  <td class="text-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-warning btn-xs glyphicon glyphicon-edit" data-toggle="modal" title="Edit" data-target="#edit_modal" data-whatever="@mdo" data-toggle="tooltip" title="Edit"></button>
                      <button type="button" class="btn btn-danger btn-xs glyphicon glyphicon-trash" data-toggle="modal" title="Delete" data-target="#delete_modal" data-whatever="@mdo" data-toggle="tooltip" title="Delete"></button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel"></h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="text" class="form-control" name="username" id="edit_username" placeholder="Username">
          </div>
          <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name="password" id="edit_password" class="form-control" placeholder="Password">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary login-button" onclick="confirmEdit()">Submit</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Verify</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="name" class="form-control" name="username" id="delete_username" placeholder="Username">
          </div>
          <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name="password" id="delete_password" class="form-control" placeholder="Password">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary login-button" onclick="confirmDelete()">Submit</button>
      </div>
    </div>
  </div>
</div>


<!-- Add sorting options and button above the login trail table -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-transfer"></span>
                    <span>Login Trail</span>
                </strong>
                <!-- Move sorting options and button to the right -->
                <div class="pull-right">
                    <select id="loginSortOption">
                        <option value="idAsc">ID (Asc)</option>
                        <option value="idDesc">ID (Desc)</option>
                        <option value="nameAsc">A-Z (Name)</option>
                        <option value="nameDesc">Z-A (Name)</option>
                        <option value="dateAsc">Date (Asc)</option>
                        <option value="dateDesc">Date (Desc)</option>
                    </select>
                    <button class="btn btn-info" onclick="sortTable1('loginTable')">Sort</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-container">
                    <table class="table table-bordered table-striped" id="loginTable">
                        <!-- Table headers remain unchanged -->
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 70px;">User ID</th>
                                <th class="text-center">Username</th>
                                <th class="text-center" style="width: 25%;">Time</th>
                                <th class="text-center" style="width: 25%;">Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table body content remains unchanged -->
                            <?php foreach ($login_trail as $trail) : ?>
                                <tr>
                                    <td class="text-center"><?php echo remove_junk(ucwords($trail['id'])) ?></td>
                                    <td><?php echo remove_junk(ucwords($trail['name'])) ?></td>
                                    <td><?php echo read_date($trail['login_time']) ?></td>
                                    <td class="text-center"><?php echo remove_junk(ucwords($trail['activity'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript function to sort the table based on selected option
    function sortTable1(tableId) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById(tableId);
        switching = true;
        var sortOption = document.getElementById("loginSortOption").value;

        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[getSortColumn(sortOption)];
                y = rows[i + 1].getElementsByTagName("td")[getSortColumn(sortOption)];

                if (compareValues(x.innerHTML, y.innerHTML, sortOption)) {
                    shouldSwitch = true;
                    break;
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

    // Function to get the column index based on the selected option
    function getSortColumn(sortOption) {
        switch (sortOption) {
            case "nameAsc":
            case "nameDesc":
                return 1;
            case "dateAsc":
            case "dateDesc":
                return 2;
            case "idAsc":
            case "idDesc":
                return 0;
            default:
                return 0;
        }
    }

    // Function to compare values based on selected option
    function compareValues(x, y, sortOption) {
        if (sortOption.endsWith("Asc")) {
            return x.toLowerCase() > y.toLowerCase();
        } else {
            return x.toLowerCase() < y.toLowerCase();
        }
    }
</script>




<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-transfer"></span>
                    <span>Activity Log</span>
                </strong>
                <!-- Add sorting options and button for the activity trail -->
                <div class="form-group">
                <div class="pull-right">
                <select id="activitySortOption">
                    <option value="nameAsc">A-Z (Name)</option>
                    <option value="nameDesc">Z-A (Name)</option>
                    <option value="dateAsc">Date (Ascending)</option>
                    <option value="dateDesc">Date (Descending)</option>
                    <option value="idAsc">ID (Ascending)</option>
                    <option value="idDesc">ID (Descending)</option>
                </select>
                <button class="btn btn-info " onclick="sortTable2('activityTable')">Sort</button>
                </div>
            </div>
            </div>
            <div class="panel-body">
                <div class="table-container">
                    <table class="table table-bordered table-striped" id="activityTable">
                        <!-- Table headers remain unchanged -->
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 70px;">User ID</th>
                                <th class="text-center">Username</th>
                                <th class="text-center" style="width: 25%;">Time</th>
                                <th class="text-center" style="width: 25%;">Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table body content remains unchanged -->
                            <?php foreach ($act_log as $a_log): ?>
                                <tr>
                                    <td class="text-center"><?php echo remove_junk(ucwords($a_log['userID'])) ?></td>
                                    <td><?php echo ($a_log['name'] !== null) ? remove_junk(ucwords($a_log['name'])) : 'N/A'; ?></td>
                                    <td><?php echo read_date($a_log['time']) ?></td>
                                    <td class="text-center"><?php echo remove_junk(ucwords($a_log['activity'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // JavaScript function to sort the table based on selected option
    function sortTable2(tableId) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById(tableId);
        switching = true;
        var sortOption = document.getElementById("activitySortOption").value;

        while (switching) {
            switching = false;
            rows = table.getElementsByTagName("tr");

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[getSortColumn(sortOption)];
                y = rows[i + 1].getElementsByTagName("td")[getSortColumn(sortOption)];

                if (compareValues(x.innerHTML, y.innerHTML, sortOption)) {
                    shouldSwitch = true;
                    break;
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }

</script>


<?php include_once('layouts/footer.php'); ?>