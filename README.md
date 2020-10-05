# webhook_crm_invoice_bitrx24

Данные скрипты решают следующую задачу:
1. На событие Битрикс 24:
- Создание счета (ONCRMINVOICEADD)
- Обновление счета (ONCRMINVOICEUPDATE)
- Удаление счета (ONCRMINVOICEDELETE)
- Обновление статуса счета (ONCRMINVOICESETSTATUS)
в скрипте webhook_invoice_from_bitrix24.php получаем информацию из счета (его id)
2. В скрипт webhook_invoice_to_bitrix24.php передается id данного счета и происходят следующие операции:
- Получаем id сделки, к которой привязан счет
- Получаем все счета, который привязаны к сделке
- Суммирум сумму всех счетов и вносим итоговое число в пользовательское поле сделки.

Исходящий вебхук из Битрикс 24: webhook_invoice_from_bitrix24.php
Входящий вебхук в Битрикс 24: webhook_invoice_to_bitrix24.php
