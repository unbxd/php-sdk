<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 11:58:59 AM
 * RecommendationsClientFactory.php
 */

include_once (dirname(__FILE__).'/RecommendationsClient.php');

class RecommendationsClientFactory{
	public static function getRecommendationsClient($siteKey/*String*/, $apiKey/*String*/, $secure/*bool*/){
		return new RecommendationsClient($siteKey, $apiKey, $secure);
	}
}