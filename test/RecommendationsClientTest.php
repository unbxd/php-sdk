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
		Unbxd::configure("demosite-u1407617955968", "64a4a2592a648ac8415e13c561e44991", "64a4a2592a648ac8415e13c561e44991");
		$client = Unbxd::getRecommendationsClient();
		$response=$client->getMoreLikeThis("5315b8555e4016e5737bda03","uid-1439879404487-19447","100.0.0.1")->execute();
		$this->assertNotNull($response);
		$this->assertEquals(200,$response->getStatusCode());	
		$this->assertEquals("OK",$response->getMessage());
		$this->assertEquals(8,$response->getTotalResultsCount());
		$this->assertEquals(8,$response->getResults()->getResultsCount());
	}
}
