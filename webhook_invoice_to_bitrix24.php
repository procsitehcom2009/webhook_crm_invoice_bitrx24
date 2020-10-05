<?php 
$invoice_current_id=$_GET['invoice_current_id'];//Получаем данные данные из исходящего вебхука с битрикс 24
$rest_string='https://site.bitrix24.ru/rest/1/secret/';//Указываем строку для входящего вебхука в битрикс 24
$if_filed_id='UF_CRM_1601837696';//id пользовательского поля

$invoice_current_query = http_build_query(array('filter'=>array('ID'=>$invoice_current_id),'select'=>array('UF_DEAL_ID')));
$result = call($rest_string.'crm.invoice.list.json',$invoice_current_query);
$deal_current_id = $result['result'][0]['UF_DEAL_ID'];//Получаем текущий id сделки, к которой был привязан счет
$invoice_list_query = http_build_query(array('filter'=>array('UF_DEAL_ID'=>$deal_current_id)));
$result = call($rest_string.'crm.invoice.list.json',$invoice_list_query);
$invoice_list = $result['result'];//Получаем список счетов текущей сделки
$price=0;
for ($i=0;$i<count($invoice_list);$i++){
	$price = $price + $invoice_list[$i]['PRICE'];//Считаем сумму счетов
}
$deal_current_query = http_build_query(array('id'=>$deal_current_id,'fields'=>array($if_filed_id=>$price),'params'=>array('REGISTER_SONET_EVENT'=>'Y')));
$result = call($rest_string.'crm.deal.update.json',$deal_current_query);//Вносим итоговую сумму в пользовательское поле сделки

function call($queryUrl,$queryData){//Функция для отправки Curl запроса на вебхук в битрикс 24
	$curl = curl_init();
	curl_setopt_array($curl,array(
		CURLOPT_SSL_VERIFYPEER=>0,
		CURLOPT_POST=>1,
		CURLOPT_HEADER=>0,
		CURLOPT_RETURNTRANSFER=>1,
		CURLOPT_URL=>$queryUrl,
		CURLOPT_POSTFIELDS=>$queryData,
	));
	$result = json_decode(curl_exec($curl), true);
	curl_close($curl);
	return $result;
}
?>