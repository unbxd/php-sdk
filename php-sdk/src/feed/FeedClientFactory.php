<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 11:57:43 AM
 * FeedClientFactory.php
 */
require_once (dirname(__FILE__).'/FeedClient.php');
class FeedClientFactory {
	public static function getFeedClient($siteKey, $secretKey, $secure){
		return new FeedClient($siteKey, $secretKey, $secure);
	}
	
}