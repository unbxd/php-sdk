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
		Unbxd::configure("demo-u1393483043451", "ae30782589df23780a9d98502388555f", "ae30782589df23780a9d98502388555f");
		$client = Unbxd::getRecommendationsClient();
		$response=$client->getMoreLikeThis("532062745e4016fd1c73b7a4",NULL)->execute();
		$this->assertNotNull($response);
		$this->assertEquals(200,$response->getStatusCode());	
		$this->assertEquals("OK",$response->getMessage());
		$this->assertEquals(6,$response->getTotalResultsCount());
		$this->assertEquals(6,$response->getResults()->getResultsCount());
		$this->assertNotNull($response->getResults()->getAt(0)->getUniqueId());
	}
}
