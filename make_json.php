<?php

define('CACHE_INDEX_TIME', 4); // 4분 cache
define('WEATHER_JSON_FILE', './data/weather_simple.json');


if( file_exists(WEATHER_JSON_FILE) && filemtime(WEATHER_JSON_FILE) > time() - CACHE_INDEX_TIME * 60) {
  include WEATHER_JSON_FILE;
} else {
  define('APPID', '32c736775e4579e034cd78fd0974ee2d');
  // City
  $arr = [];
  $arr[] = ['code' => 'Seoul', 'name' => '서울'];
  $arr[] = ['code' => 'Busan', 'name' => '부산'];
  $arr[] = ['code' => 'Daejeon', 'name' => '대전'];
  $arr[] = ['code' => 'Gwangju', 'name' => '광주'];
  $arr[] = ['code' => 'Incheon', 'name' => '인천'];
  $arr[] = ['code' => 'Daegu', 'name' => '대구'];
  $arr[] = ['code' => 'Jeonju', 'name' => '전주'];
  $arr[] = ['code' => 'Suwon-si', 'name' => '수원'];
  $arr[] = ['code' => 'Jeju City', 'name' => '제주'];
  $arr[] = ['code' => 'Wonju', 'name' => '원주'];
  $arr[] = ['code' => 'Sokcho', 'name' => '속초'];
  $arr[] = ['code' => 'Chungju', 'name' => '청주'];

  $ch = curl_init(); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함

  $result = []; // 결과를 받을 배열

  foreach($arr as $val){
    $city = $val['code'];
    $url = 'http://api.openweathermap.org/data/2.5/weather?units=metric&q='.$city.'&appid=' . APPID;
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    $array = json_decode($response);

    if(isset($array->main->temp)) {
      $result[] = ['city' => $val['name'], 'temp' => $array->main->temp, 1, $array->weather[0]->icon];
    }
  }

  curl_close($ch);

  $out = json_encode($result); // 배열 to json

  file_put_contents(WEATHER_JSON_FILE, $out);

  echo $out;
}