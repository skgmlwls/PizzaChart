<?php
// 데이터베이스 연결 정보
$host = "localhost";
$user = "root";
$password = "";
$dbname = "pizza";

// 데이터베이스 연결
$conn = mysqli_connect($host, $user, $password, $dbname);

// 연결 확인
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// POST 요청이 들어온 경우
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 각각의 피자 비율을 POST 데이터에서 가져와서 MySQL 데이터베이스에 업데이트
    $bulgogi = $_POST['bulgogi'];
    $cheese = $_POST['cheese'];
    $potato = $_POST['potato'];
    $goldpotato = $_POST['goldpotato'];
    $sweetpotato = $_POST['sweetpotato'];

    $sql = "UPDATE pizzas SET amount=$bulgogi WHERE name='불고기 피자'";
    mysqli_query($conn, $sql);

    $sql = "UPDATE pizzas SET amount=$cheese WHERE name='치즈 피자'";
    mysqli_query($conn, $sql);

    $sql = "UPDATE pizzas SET amount=$potato WHERE name='포테이토 피자'";
    mysqli_query($conn, $sql);

    $sql = "UPDATE pizzas SET amount=$goldpotato WHERE name='골드포테이토 피자'";
    mysqli_query($conn, $sql);

    $sql = "UPDATE pizzas SET amount=$sweetpotato WHERE name='고구마 피자'";
    mysqli_query($conn, $sql);
}

// MySQL 데이터베이스에서 저장된 피자 비율 데이터 가져오기
$sql = "SELECT * FROM pizzas";
$result = mysqli_query($conn, $sql);
$pizzas = [];
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        array_push($pizzas, [$row['name'], $row['amount']]);
    }
}

// MySQL 데이터베이스 연결 종료
mysqli_close($conn);
?>

<html>
  
  <head>
    <div id="piechart" style="width: 900px; height: 50px;"></div>

    <!-- 각각의 피자 비율을 입력받는 폼 -->
    <form method="post">
        불고기 피자: <input type="number" name="bulgogi" value="<?php echo $pizzas[0][1]; ?>"><br>
        치즈 피자: <input type="number" name="cheese" value="<?php echo $pizzas[1][1]; ?>"><br>
        포테이토 피자: <input type="number" name="potato" value="<?php echo $pizzas[2][1]; ?>"><br>
        골드포테이토 피자: <input type="number" name="goldpotato" value="<?php echo $pizzas[3][1]; ?>"><br>
        고구마 피자: <input type="number" name="sweetpotato" value="<?php echo $pizzas[4][1]; ?>"><br>
        <input type="submit" value="저장">
    </form>
  </head>
</html>

