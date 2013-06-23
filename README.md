BitrixCacheCleaner
==================

Гаджет для панели управления 1С-Битрикс, позволяющий быстро очистить неуправляемый кеш, управляемый и миниатюры изображений ([CFile::ResizeImageGet](http://dev.1c-bitrix.ru/api_help/main/reference/cfile/resizeimageget.php)).

Помимо вызова стандартной функции [BXClearCache](http://dev.1c-bitrix.ru/api_help/main/functions/other/bxclearcache.php), производится удаление директорий `/bitrix/cache/`, `/bitrix/managed_cache/` и `/upload/resize_cache/`.

Гаджет отображает статистику по количеству файлов кеша и их общему размеру.

Установка
---------

1. Создайте свое пространство имен для гаджетов, например `/bitrix/gadgets/tools/`;
2. Создайте внутри директорию для нового гаджета, например `cache`;
3. Скопируйте в `/bitrix/gadgets/tools/cache` файлы `.description.php` и `indedx.php`;
4. В панели управления добавьте на рабочий стол гаджет "Очистка кеша" (Добавить гаджет / Контент / Очистка кеша);
