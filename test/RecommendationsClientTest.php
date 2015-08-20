<?php
/**
 * @author suprit
 * Date: Aug 10, 2014
 * Time: 6:05:58 PM
 * RecommendationsClientTest.php
 */

include_once (dirname(__FILE__).'/../src/main/Unbxd.php');
include_once (dirname(__FILE__).'/../src/recommendations/response/RecommendationResponse.php');

class RecommendationsClientTest extends PHPUnit_Framework_TestCase{
	
	public function test_recommendations(){
		Unbxd::configure("puravidabracelets_myshopify_com-u1405972064004", "3ad398748874973f87c1e27f7a798aa0", "3ad398748874973f87c1e27f7a798aa0");
		$client = Unbxd::getRecommendationsClient();
		$response=$client->getMoreLikeThis("504112772","uid-1439879404487-19447","100.0.0.1")->execute();
		$this->assertNotNull($response);
		$this->assertEquals(200,$response->getStatusCode());	
		$this->assertEquals("OK",$response->getMessage());
		$this->assertEquals(8,$response->getTotalResultsCount());
		$this->assertEquals(8,$response->getResults()->getResultsCount());
		$this->assertNotNull($response->getResults()->getAt(0)->getUniqueId());
	}
}
