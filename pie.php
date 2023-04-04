<?php
// MySQL 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizza";

// MySQL 데이터베이스 연결
$conn = mysqli_connect($servername, $username, $password, $dbname);

// MySQL 연결 오류 발생 시
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// MySQL 데이터베이스에서 각각의 피자 비율을 가져와서 배열에 저장
$sql = "SELECT name, amount FROM pizzas ORDER BY name ASC"; // name으로 정렬
$result = mysqli_query($conn, $sql);

$pizzas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pizzas[] = [$row['name'], $row['amount']];
}
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        // PHP에서 저장된 피자 비율 데이터를 JavaScript에서 사용할 수 있도록 JSON으로 변환
        var pizzaData = <?php echo json_encode($pizzas); ?>;
        
        var data = google.visualization.arrayToDataTable(pizzaData);

        var options = {
          title: '피자'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
