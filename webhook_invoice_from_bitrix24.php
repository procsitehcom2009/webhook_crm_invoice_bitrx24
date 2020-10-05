<?php
//В массие $_REQUEST пришла информация из битрикса
$webhook_to_bitrix24='https://site.ru/webhook/webhook_invoice_from_bitrix24.php';//Указываем путь до скрипта где будет входящий вебхук в Битрикс 24
$queryUrl = $webhook_to_bitrix24.'?invoice_current_id='.$_REQUEST['data']['FIELDS']['ID'];//Передаем id счета, с которым были изменения
$query = call($queryUrl);//Вызываем через Curl входящий вебхук
function call($queryUrl){
	$curl = curl_init();
	curl_setopt_array($curl,array(
		CURLOPT_SSL_VERIFYPEER=>0,
		CURLOPT_POST=>1,
		CURLOPT_HEADER=>0,
		CURLOPT_RETURNTRANSFER=>1,
		CURLOPT_URL=>$queryUrl,
		CURLOPT_POSTFIELDS=>'',
	));
	$result = json_decode(curl_exec($curl), true);
	curl_close($curl);
	return $result;
}
?>