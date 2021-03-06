<?php
include('autohandler.php');

$page_text = '';
if( is_readable(INDEX_TEXT_PATH) && is_file(INDEX_TEXT_PATH) ) {
	$page_text = file_get_contents(INDEX_TEXT_PATH);
}

$char_list = Doctrine_Query::create()
	->from('Player p')->orderBy('p.name')->execute();

$i = 0;
?>
<div id="PlayerList">
	<ul class="list rowBorder">
	<? foreach($char_list as $c): ?>
		<li class="row<?=$i;$i=($i+1)%2;?>">
			<div class="listLinks">
				<a href="<?=SITE_URL;?>/<?=$c->id;?>"><img class="icon" 
					src="<?=SITE_URL;?>/images/icon_magnifying-glass.png" /></a>
				<a href="<?=SITE_URL;?>/<?=$c->id;?>/edit"><img class="icon"
					src="<?=SITE_URL;?>/images/icon_gear.png"/></a>
			</div>
			<div class="listLabel">
				<?=$c->name;?>
			</div>
			<div class="listInfo">
				<?=$c->Race->name;?> <?=$c->Archetype->name;?> <?=$c->level;?>
			</div>
		</li>
	<? endforeach; ?>
	</ul>
</div>

<div id="MDInfo"><?=Markdown($page_text);?></div>
<?php include('footer.php'); ?>