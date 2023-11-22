<?php

$file = 'http://localhost/project/weather/make_json.php';

$weather = file_get_contents($file);

$arr = json_decode($weather); // json 문자열 -> PHP 배열

echo "<table border='1'>";
echo "<tr>
  <th>도시</th>
  <th>현재기온</th>
  <th>날씨</th>
  </tr>";

foreach($arr as $row) {

  $row1 = (array) $row;

  echo "<tr>
    <td>".$row1['city']."</td>
    <td>".$row1['temp']."</td>
    <td>";

  echo '<img src="icon_weather/'.$row1['1'].'.png" width="20">';
  echo "</td>
    </tr>";
}

echo "</table>";