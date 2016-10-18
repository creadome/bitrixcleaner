<?
	/*
		Bitrix Cleaner v2.3 - https://github.com/creadome/bitrixcleaner
		Быстрая очистка 1С-Битрикс

		(c) 2016 Станислав Васильев - https://creado.me
		creadome@gmail.com
	*/

	if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

	CJSCore::Init('jquery');
?>

<div id="bitrix-cleaner" class="bitrix-cleaner"></div>

<style>
	.bitrix-cleaner { background: #f5f9f9; border-top: 1px solid #d7e0e8; }

	.bitrix-cleaner table { width: 100%; border-collapse: collapse; }
	.bitrix-cleaner th,
	.bitrix-cleaner td { vertical-align: top; text-align: left; padding: 10px; border-bottom: 1px solid #fff; }

	.bitrix-cleaner input { margin: 10px; }
</style>

<script>
	var cleaner = '<?=$arGadget['PATH_SITEROOT']?>/cleaner.php';

	$('#bitrix-cleaner').load(cleaner);

	$(document).on('click', '#bitrix-cleaner input', function(){
		$.get(cleaner, {clean: true}, function(data){
			$('#bitrix-cleaner').html(data);
		});
	});
</script>
