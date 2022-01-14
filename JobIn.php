<?php
$host = '127.0.0.1'; // адрес сервера
$database = 'axmobioctobercms'; // имя базы данных
$user = 'axmobi_admin'; // имя пользователя
$password = 'E6tTysseJjTaApu'; // пароль

$name = $_POST['name'];
$tel = $_POST['tel'];
$typedevice = $_POST['type'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$service = $_POST['service'];
$priceService = $_POST['priceService'];
$desp = $_POST['desp'];
$nodeJob = $_POST['nodeJob'];
$istJob = $_POST['istJob'];
// $percent = $_POST['percent'];

$work_done = '';
if($service != NULL && $service != '' && $priceService != NULL && $priceService != ''){
  $priceService = preg_replace('/[^0-9]/', '', $priceService);
  $priceService = trim($priceService);
  $work_done = '[{"work_done_label":"'.$service.'","work_done_cost":"'.$priceService.'"}]';
}



if ($name != null && $name != false && $tel != null && $tel != false) {
  $link = mysqli_connect($host, $user, $password, $database)
      or die("Ошибка " . mysqli_error($link));

      $querySelectName = "SELECT * FROM `predeindmitry_maincrm_customers` WHERE `predeindmitry_maincrm_customers`.`name` = '".$name."'";
      $resultSelectName = mysqli_query($link, $querySelectName) or die("Ошибка " . mysqli_error($link));

      $fetch = mysqli_fetch_assoc($resultSelectName);

      if ($fetch == null || $fetch == false){

            $queryInsertCustomer = "INSERT INTO `predeindmitry_maincrm_customers`(`id`, `name`, `tel`, `address`, `mail`, `created_at`, `updated_at`) VALUES (NULL, '".$name."', '".$tel."', NULL, NULL, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'))";

            $resultInsertCustomer = mysqli_query($link, $queryInsertCustomer);

            $querySelectName = "SELECT * FROM `predeindmitry_maincrm_customers` WHERE `predeindmitry_maincrm_customers`.`name` = '".$name."'";

            $resultSelectName = mysqli_query($link, $querySelectName) or die("Ошибка " . mysqli_error($link));

            $fetch = mysqli_fetch_assoc($resultSelectName);

      }     

            $query = "INSERT INTO `predeindmitry_maincrm_jobs`(`id`, `master_id`, `manager_id`, `name_id`, `message_id`, `type_device`, `brand_device`, `devicemodel`, `imei`, `work_done`, `used_detail`, `status_job`, `cost`, `payment_method`, `descriptions`, `note`, `notehzzahcem`, `condition_device`, `info`, `type_job`, `patternlock`, `pinkod`, `created_at`, `updated_at`, `stock_id`, `orientir_cost`, `costpayMethod`, `discount_work`, `discount_details`, `deleted_at`, `is_status`, `is_warranty`, `warranty`, `is_check_conditions`) VALUES (NULL, NULL, NULL, '".$fetch['id']."', NULL, '".$typedevice."', '".$brand."', '".$model."', '-', '".$work_done."', NULL, 'Не обработана', '0', '-', '".$desp."', '".$nodeJob."', NULL, 'Неизвестно', NULL, '".$istJob."', '0', 'Неизвестно', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', '3', '".$priceService."', NULL, '0', '0', NULL, 'none', 'Не гарантийный', NULL, NULL)";
            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
}            
            
            
            
            
