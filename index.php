<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
	
	$cache = array(		
		'Неуправляемый кеш' => '/bitrix/cache/',
		'Управляемый кеш' => '/bitrix/managed_cache/',
		'Миниатюры изображений' => '/upload/resize_cache/'
	);
	
	if ($_POST['cache']['clear']) {
		BXClearCache(true);
		foreach ($cache as $dir) DeleteDirFilesEx($dir);	
				
		header ('Location: /bitrix/admin/');
		exit;
	}
		
	function info($dir) {
		$info = array('count' => 0, 'size' => 0);
		
		foreach (scandir($dir) as $file) {
			if ($file != '.' && $file != '..') {
				if (is_dir($dir.'/'.$file)) { 
					$tmp = info($dir.'/'.$file); 

					$info['count'] += $tmp['count']; 
					$info['size'] += $tmp['size']; 
				} else { 
					$info['count']++;
					$info['size'] += filesize($dir.'/'.$file); 
				}
			}
		}
		
		return $info;	
	}
?>

<style>
	#gadget-cache { background: #f5f9f9; border-top: 1px solid #d7e0e8; }
	#gadget-cache table { width: 100%; border-collapse: collapse; }
	#gadget-cache table th,
	#gadget-cache table td { vertical-align: top; text-align: left; padding: 10px; border-bottom: 1px solid #fff; }
	#gadget-cache form { padding: 10px; }
</style>

<div id="gadget-cache">
	<table>
		<tr>
			<th>Тип кеша</th>
			<th>Путь</th>
			<th>Файлы</th>
			<th>Размер</th>
		</tr>

	<? 
		foreach ($cache as $name => $dir) { 
			$info = info($_SERVER['DOCUMENT_ROOT'].$dir);
			$info['size'] = round($info['size'] / 1024 / 1024, 2);
	?>	

		<tr>
			<td><?=$name?></td>
			<td><a href="/bitrix/admin/fileman_admin.php?lang=ru&path=<?=$dir?>"><?=$dir?></a></td>
			<td><?=$info['count']?></td>
			<td><?=$info['size']?> Мб</td>
		</tr>

	<? 
		} 
	?>

	</table>

	<form method="post" action="">	
		<input type="submit" name="cache[clear]" value="Очистить" class="adm-btn-save">		
	</form>
</div>