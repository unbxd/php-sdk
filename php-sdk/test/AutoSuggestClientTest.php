<?php
/**
 * @author suprit
 * Date: Aug 10, 2014
 * Time: 1:31:47 PM
 * AutoSuggestClientTest.php
 */

include_once (dirname(__FILE__).'/../src/autosuggest/response/AutoSuggestResponse.php');
include_once (dirname(__FILE__).'/../src/main/Unbxd.php');

class AutoSuggestClientTest extends PHPUnit_Framework_TestCase{
	
	public function test_autosuggest(){
		Unbxd::configure("autosuggesttest-u1405357792247", "7db139ac885f6516fb276520668daf83", "7db139ac885f6516fb276520668daf83");
		$client = Unbxd::getAutoSuggestClient();
		$response = $client->autosuggest("sh")->setInFieldsCount(3)->setKeywordSuggestionsCount(5)->setPopularProductsCount(10)->setTopQueriesCount(4)->execute();
		$this->assertNotNull($response);
		$this->assertEquals(0,$response->getStatusCode());
		$this->assertNotEquals(0,$response->getQueryTime());
		$this->assertEquals(0,$response->getErrorCode());
		$this->assertEquals("OK",$response->getMessage());
		$this->assertNotEquals(0,$response->getTotalResultsCount());
	}
}