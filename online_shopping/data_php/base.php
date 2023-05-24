<?php
$json_file_path = __DIR__ . '/../data_json/';

function put_json_files($filename, $data){
  $filepath = $GLOBALS['json_file_path'].$filename.".json";
  return file_put_contents($filepath, json_encode($data, JSON_PRETTY_PRINT));
}

function getAll($filename, $filters=[]){
  
  $filepath = $GLOBALS['json_file_path'].$filename.".json";
  $datas = json_decode(file_get_contents($filepath), associative: true);
  $result_data = $datas;

  if($filters)
  { 
    $result_data = [];
    foreach ($datas as $data) {
      $matched =[];
      foreach ($filters as $key => $value) {
        if($data[$key] == $value){
          array_push($matched, true);
        }
        else{
          array_push($matched, false);
        }
      }
      //if there is no false in matched then push to result data
      if(!in_array(false, $matched)){
        array_push($result_data, $data);
      }
    }
  }

  return $result_data ;
}

function get($filename, $filters){
  $existing_data = getAll($filename);
  
  foreach ($existing_data as $ex_data) {
    $matched =[];
      foreach ($filters as $key => $value) {
        if($ex_data[$key] == $value){
          array_push($matched, true);
        }
        else{
          array_push($matched, false);
        }
      }
      //if there is no false in matched then merge to existing data
      if(!in_array(false, $matched)){
        return $ex_data;
      }
  }
  return null;
}

function insert($filename, $data, $column="id")
{  
  $existing_data = getAll($filename);
  $id = 0;
  if (!$existing_data) {
    $id = 1;
  } else {
    $last = end($existing_data);
    $id = $last[$column] + 1;
  }
  
  $data = array($column => (int)$id) + $data;
  $existing_data[] = $data;

  return put_json_files($filename,$existing_data);  
}

function update($filename, $data, $filters=[])
{
  $existing_data = getAll($filename);

  foreach ($existing_data as $i => $ex_data) {
    $matched =[];
      foreach ($filters as $key => $value) {
        if($ex_data[$key] == $value){
          array_push($matched, true);
        }
        else{
          array_push($matched, false);
        }
      }
      //if there is no false in matched then merge to existing data
      if(!in_array(false, $matched)){
        $existing_data[$i] = array_merge($ex_data, $data);
      }
  }

  put_json_files($filename,$existing_data);  
}

function deleteData($filename, $filters=[]){
  $existing_data = getAll($filename);

  foreach($existing_data as $i => $ex_data){
    $matched =[];
      foreach ($filters as $key => $value) {
        if($ex_data[$key] == $value){
          array_push($matched, true);
        }
        else{
          array_push($matched, false);
        }
      }
      //if there is no false in matched then remove from existing data
      if(!in_array(false, $matched)){
        array_splice($existing_data, $i, 1);
      }
  }
 
  put_json_files($filename,$existing_data);
}


function getProductRatings($prod_id)
{
  $reviews = getAll(json_reviews, array("product_id" => (int)$prod_id));
  if($reviews)
  {
    $ratings = 0;
    $counts = 0;
    foreach ($reviews as $i => $review) {
      $ratings += (int)$review["rating"];
      $counts += $i+1;
    }
    $total_ratings = (float)($ratings / $counts);
    return array("ratings"=>$total_ratings, "counts"=>$counts);
  }
  return array("ratings"=>0, "counts"=>0);
}


//Filter Form Request Data
function input($data)
{
  $data = $_REQUEST[$data];
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


//File uploads
function uploadFiles($dir, $uploaded_file, $generateFileName = false)
{
  $tmp_name = $uploaded_file["tmp_name"];
  $file_name = $uploaded_file["name"];

  if ($generateFileName) {
    $uid = date('dmyHis');
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_name = $uid . "." . $ext;
  }

  if (move_uploaded_file($tmp_name, $dir . $file_name))
    return $file_name;
  else
    die($uploaded_file["error"]);
}