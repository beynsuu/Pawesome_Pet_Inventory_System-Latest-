<?php
  $page_title = 'Monthly Sales';
  require_once('includes/load.php');
  // Check what level of user has permission to view this page
  page_require_level(2);
  $year = date('Y');
  $sales = monthlySales($year);
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div id="barChart"></div>
  </div>
  <div class="col-md-6">
    <div id="pieChart"></div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Monthly Sales</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Product name</th>
              <th class="text-center" style="width: 15%;">Quantity sold</th>
              <th class="text-center" style="width: 15%;">Total</th>
              <th class="text-center" style="width: 15%;">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sales as $sale): ?>
              <tr>
                <td class="text-center"><?php echo count_id(); ?></td>
                <td><?php echo remove_junk($sale['name']); ?></td>
                <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
                <td class="text-center"><?php echo remove_junk($sale['total_saleing_price']); ?></td>
                <td class="text-center"><?php echo $sale['date']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', { 'packages': ['corechart'] });
  google.charts.setOnLoadCallback(drawCharts);

  function drawCharts() {
    drawBarChart();
    drawPieChart();
  }

  function drawBarChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Date');
    data.addColumn('number', 'Total Sales');

    var chartData = <?php echo json_encode($sales); ?>;

    var formattedData = chartData.map(function (sale) {
      return [sale.date, parseFloat(sale.total_saleing_price)];
    });

    data.addRows(formattedData);

    var options = {
      title: 'Monthly Sales Trend',
      hAxis: { title: 'Date' },
      vAxis: { title: 'Total Sales' },
      chartArea: { width: '60%' },
      colors: ['#ff006e'],
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('barChart'));
    chart.draw(data, options);
  }

  function drawPieChart() {
    var salesData = <?php echo json_encode($sales); ?>;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Product');
    data.addColumn('number', 'Total Sales');

    var chartData = salesData.map(function (sale) {
      return [sale.name, parseFloat(sale.total_saleing_price)];
    });

    data.addRows(chartData);

    var options = {
      title: 'Sales Distribution by Product',
      colors: ['#e76f51', '#f4a261', '#e9c46a', '#2a9d8f'],
    };

    var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
    chart.draw(data, options);
  }
</script>

<?php include_once('layouts/footer.php'); ?>
