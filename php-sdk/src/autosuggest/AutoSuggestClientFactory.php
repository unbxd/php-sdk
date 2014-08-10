<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 1:26:27 PM
 * AutoSuggestClientFactory.php
 */

include_once (dirname(__FILE__).'/AutoSuggestClient.php');

class AutoSuggestClientFactory{
	public static function getAutoSuggestClient($siteKey/*String*/, $apiKey/*string*/, $secure/*string*/){
		return new AutoSuggestClient($siteKey, $apiKey, $secure);
	}
}