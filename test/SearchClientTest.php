<?php
/**
 * @author suprit
 * Date: Aug 10, 2014
 * Time: 6:24:46 PM
 * SearchClientTest.php
 */

include_once (dirname(__FILE__).'/../src/main/Unbxd.php');
include_once (dirname(__FILE__).'/../src/search/response/SearchResponse.php');



class SearchClientTest extends PHPUnit_Framework_TestCase{
	
	protected function setUp(){
		Unbxd::configure("demosite-u1407617955968", "64a4a2592a648ac8415e13c561e44991", "64a4a2592a648ac8415e13c561e44991");
	}
	
	public function test_search(){
		
		$queryParams = array();
		$queryParams["fl"]="uniqueId";
		$queryParams["stats"] = "price";
		$client = Unbxd::getSearchClient();
		$response = $client->search("*",$queryParams)
					->addTextFilter("category_fq",array("men"))
					->addTextFilter("brand_fq",array("abercrombie"))
					->addRangeFilter("price_fq",["1000","3000"])
					->addSort("price",new SortDir(SortDir::ASC))
					->setPage(0,10)
					->execute();
		$this->assertNotNull($response);
		$this->assertEquals(0,$response->getStatusCode());
		$this->assertNotEquals(0,$response->getQueryTime());
		$this->assertEquals(0,$response->getErrorCode());
		$this->assertEquals("OK",$response->getMessage());
		$this->assertNotEquals(0,$response->getTotalResultsCount());
		$this->assertEquals(10,$response->getResults()->getResultsCount());
		$this->assertNotEquals(0,count($response->getResults()->getAt(0)->getAttributes()));
		$this->assertNotNull($response->getResults()->getAt(0)->getAttributes());
		$this->assertNotNull($response->getStats());
		$this->assertNotNull($response->getStats()->getStat("price")->getMin());
		$this->assertGreaterThanOrEqual(1000,$response->getStats()->getStat("price")->getmin());
		$this->assertLessThanOrEqual(3000,$response->getStats()->getStat("price")->getmax());
	}
	
	public function test_browse(){
		$queryParams = array();
		$queryParams["fl"]="uniqueId";
		$queryParams["stats"] = "price";
		$response = Unbxd::getSearchClient()
					->browse("1",$queryParams)
					->addTextFilter("category_fq",array("men"))
					->addTextFilter("brand_fq",array("abercrombie"))
					->addRangeFilter("price_fq",["1000","3000"])
					->addSort("price",new SortDir(SortDir::ASC))
					->setPage(0,10)
					->execute();
		$this->assertNotNull($response);
		$this->assertEquals(0,$response->getStatusCode());
		$this->assertNotEquals(0,$response->getQueryTime());
		$this->assertEquals(0,$response->getErrorCode());
		$this->assertEquals("OK",$response->getMessage());
		$this->assertNotEquals(1,$response->getTotalResultsCount());
		$this->assertEquals(10,$response->getResults()->getResultsCount());
		$this->assertEquals(1,count($response->getResults()->getAt(0)->getAttributes()));
		$this->assertNotNull($response->getResults()->getAt(0)->getAttributes());
		$this->assertNotNull($response->getStats());
		$this->assertNotNull($response->getStats()->getStat("price")->getMin());
		$this->assertGreaterThanOrEqual(1000,$response->getStats()->getStat("price")->getmin());
		$this->assertLessThanOrEqual(3000,$response->getStats()->getStat("price")->getmax());
	}
	
	public function test_bucket(){
		$queryParams = array();
		$queryParams["fl"]="uniqueId";
		$queryParams["stats"] = "price";
		$response = Unbxd::getSearchClient()
					->bucket("*", "category", $queryParams)
					->addTextFilter("category_fq",array("men"))
					->addTextFilter("brand_fq",array("abercrombie"))
					->addRangeFilter("price_fq",["1000","3000"])
					->addSort("price",new SortDir(SortDir::ASC))
					->setPage(0,10)
					->execute();
		$this->assertNotNull($response);
		$this->assertEquals(0,$response->getStatusCode());
		$this->assertNotEquals(0,$response->getQueryTime());
		$this->assertEquals(0,$response->getErrorCode());
		$this->assertEquals("OK",$response->getMessage());
		$this->assertNotEquals(1,$response->getTotalResultsCount());
		$this->assertNull($response->getResults());
		$this->assertEquals(1,$response->getBuckets()->getNumberOfBuckets());
		$bucket = $response->getBuckets()->getBuckets();
		$this->assertNotEquals(0,$bucket[0]->getTotalResultsCount());
		$this->assertEquals(1,count($bucket[0]->getResults()->getAt(0)->getAttributes()));
		$attr=$bucket[0]->getResults()->getAt(0)->getAttributes();
		$this->assertNotNull($attr["uniqueId"]);
		$this->assertNotNull($response->getStats());
		$this->assertNotNull($response->getStats()->getStat("price")->getMin());
		$this->assertGreaterThanOrEqual(1000,$response->getStats()->getStat("price")->getmin());
		$this->assertLessThanOrEqual(3000,$response->getStats()->getStat("price")->getmax());
	}
	
}