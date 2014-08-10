<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 6:59:25 PM
 * SearchClientFactory.php
 */

include_once (dirname(__FILE__).'/SearchClient.php');
class SearchClientFactory{
	public static function getSearchClient($siteKey/*string*/, $apiKey/*String*/, $secure/*bool*/){
		return new SearchClient($siteKey, $apiKey, $secure);
	}
}