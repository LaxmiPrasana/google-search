<?php
/**
 * Google Search Result fetcher
 * This class is created to fetch google search results using Pars Pipe class.
 *
 * @version 0.0.1
 * @link http://code.google.com/p/pars-pipe/
 * @author Aram Alipoor <aram_alipoor2010#yahoo.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @requires Pars Pipe
 */

class google
{
	function query($q, $pagenum)
	{
		$url = 'http://www.google.com/search?q='.urlencode($q).'&start='.(($pagenum - 1) * 10);

		$result = $this->load_result($url);
		
		return $this->fetch_array($result);
	}
	
	private function load_result($url)
	{
		$ch = curl_init();
		
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/cookiefile");
			curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/cookiefile");
			curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent=Mozilla/5.0 (Windows NT 6.1; rv:6.0) Gecko/20100101 Firefox/6.0');
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
	
	private function fetch_array(&$result)
	{
		$pipe = new pipe();
		
		$pipe->append(new rule(new slice('<!--m-->', '<!--n-->'), HTML, MULTI_ITEM,
							array(
								'title'	=> new rule(new regexp('<!--m-->.*?<a .* onmousedown="return [^>]*>(.*?)</a></h3>.*'), PLAIN_TEXT, SINGLE_ITEM),
								'link'	 => new rule(new css('li.g div.vsc div.s div.f cite'), PLAIN_TEXT, SINGLE_ITEM),
								'summary'  => new rule(new css('div.s span.st'), PLAIN_TEXT, SINGLE_ITEM)
							)
						)
					);
			
		return $pipe->parse($result);
	}
}

?>