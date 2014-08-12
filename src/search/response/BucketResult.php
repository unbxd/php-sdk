<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 1:20:14 PM
 * BucketResult.php
 */
require_once (dirname(__FILE__).'/SearchResults.php');
class BucketResult {
	private $_totalResultsCount;//int
	private $_results;//SearchResults
	
	public function __construct($params/*array(String => Object)*/){
		$this->_totalResultsCount = $params["numberOfProducts"];
		$this->_results = new SearchResults($params["products"]);		
	}
	
	/**
     * @return Total number of results found.
     */
	
	public function getTotalResultsCount(){
		return $this->_totalResultsCount;
	}
	 /**
     * @return Results in this bucket. Refer {@link SearchResults}
     */
	public function getResults(){
		return $this->_results;
	}
}