<?php

require_once('pipe.core.php');
require_once('google.pipe.php');

$stream = new google();

$q = 'example search term';

$result = $stream->query($q, $i);

echo('<h1>Google search result: </h1>');
echo('<hr>');

foreach($result as $item)
{
	echo('
		<div class="item">
			<div class="title">'.$item['title'].'</div>
			<div class="link">'.$item['link'].'</div>
			<div class="summary">'.$item['summary'].'</div>
		</div>
	');
}


function domainOf($link)
{
	return parse_url($link, PHP_URL_HOST);
}


?>
<style>
	.item{
		font-family: Verdana, Tahoma;
		font-size: 11px;
		padding: 10px;
		margin: 10px;
	}
	.item .title
	{
		color: red;
		font-weight: bold;
	}
	.item .link{
		font-size: 9px;
		margin-bottom: 3px;
		color: green; 
	}
	.item .summary
	{
		margin-left: 10px;
	}
</style>