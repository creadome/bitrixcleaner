<?
	/*
		Bitrix Cleaner v2.3 - https://github.com/creadome/bitrixcleaner
		Быстрая очистка 1С-Битрикс

		(c) 2015 Станислав Васильев - https://creado.me
		creadome@gmail.com
	*/

	require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

	$list = array(
		array(
			'path' => '/bitrix/managed_cache/',
			'type' => 'Управляемый кеш',

			'delete' => true
		),

		array(
			'path' => '/bitrix/stack_cache/',
			'type' => 'Управляемый кеш',

			'delete' => true
		),

		array(
			'path' => '/bitrix/cache/',
			'type' => 'Неуправляемый кеш'
		),

		array(
			'path' => '/bitrix/html_pages/',
			'type' => 'HTML кеш'
		),

		array(
			'path' => '/upload/resize_cache/',
			'type' => 'Кеш изображений',

			'delete' => true
		)
	);

	if ($_GET['clean']) {
		// /bitrix/modules/main/admin/cache.php

		BXClearCache(true);

		$GLOBALS['CACHE_MANAGER']->CleanAll();
		$GLOBALS['stackCacheManager']->CleanAll();

		$staticHtmlCache = \Bitrix\Main\Data\StaticHtmlCache::getInstance();
		$staticHtmlCache->deleteAll();

		foreach ($list as $item) if ($item['delete']) DeleteDirFilesEx($item['path']);
	}

	function countsize($path) {
		$count = array('file' => 0, 'size' => 0);

		foreach (scandir($path) as $file) {
			if ($file != '.' && $file != '..') {
				if (is_dir($path.$file)) {
					$inner = countsize($path.$file.'/');

					$count['file'] += $inner['file'];
					$count['size'] += $inner['size'];
				} else {
					$count['file'] ++;
					$count['size'] += filesize($path.$file);
				}
			}
		}

		return $count;
	}
?>

<table>
	<tr>
		<th>Тип</th>
		<th>Путь</th>
		<th>Файлы</th>
		<th>Размер</th>
	</tr>

	<?
		foreach ($list as $item) {
			$count = countsize($_SERVER['DOCUMENT_ROOT'].$item['path']);
	?>

			<tr>
				<td><?=$item['type']?></td>
				<td><a href="/bitrix/admin/fileman_admin.php?lang=ru&amp;path=<?=$item['path']?>"><?=$item['path']?></a></td>
				<td><?=$count['file']?></td>
				<td><?=round($count['size'] / 1048576, 2)?> Мб</td>
			</tr>

	<?
		}
	?>
</table>

<input type="button" value="Очистить" class="adm-btn-save" data-action="clean">