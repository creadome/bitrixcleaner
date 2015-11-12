<?
	/*
		Bitrix Cleaner v2.2 - https://github.com/creadome/bitrixcleaner
		Быстрая очистка 1С-Битрикс

		(c) 2015 Станислав Васильев - http://creado.me
		creadome@gmail.com
	*/

	require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

	$trash = array(
		'cache' => array(
			'/bitrix/cache/' => 'Неуправляемый кеш',
			'/bitrix/managed_cache/' => 'Управляемый кеш',
			'/bitrix/html_pages/' => 'HTML кеш'
		),

		'files' => array(
			'/upload/resize_cache/' => 'Кеш изображений'
		)
	);

	if ($_GET['clean']) {
		BXClearCache(true);

		$GLOBALS['CACHE_MANAGER']->CleanAll();
		$GLOBALS['stackCacheManager']->CleanAll();

		$staticHtmlCache = \Bitrix\Main\Data\StaticHtmlCache::getInstance();
		$staticHtmlCache->deleteAll();

		foreach ($trash['files'] as $files => $name) DeleteDirFilesEx($files);
	}

	function countsize($directory) {
		$count = array('file' => 0, 'size' => 0);

		foreach (scandir($directory) as $file) {
			if ($file != '.' && $file != '..') {
				if (is_dir($directory.$file)) {
					$inner = countsize($directory.$file.'/');

					$count['file'] += $inner['file'];
					$count['size'] += $inner['size'];
				} else {
					$count['file'] ++;
					$count['size'] += filesize($directory.$file);
				}
			}
		}

		return $count;
	}
?>

<table>
	<tr>
		<th>Описание</th>
		<th>Путь</th>
		<th>Файлы</th>
		<th>Размер</th>
	</tr>

	<?
		foreach ($trash as $type) {
			foreach ($type as $directory => $name) {
				$count = countsize($_SERVER['DOCUMENT_ROOT'].$directory);
	?>

				<tr>
					<td><?=$name?></td>
					<td><a href="/bitrix/admin/fileman_admin.php?lang=ru&amp;path=<?=$directory?>"><?=$directory?></a></td>
					<td><?=$count['file']?></td>
					<td><?=round($count['size'] / 1048576, 2)?> Мб</td>
				</tr>

	<?
			}
		}
	?>
</table>

<input type="button" value="Очистить" class="adm-btn-save" data-action="clean">
