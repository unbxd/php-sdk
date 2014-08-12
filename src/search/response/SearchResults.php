<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 1:22:37 PM
 * SearchResults.php
 */

require_once (dirname(__FILE__).'/SearchResult.php');

class SearchResults {
	private $_resultsCount;//int
	private $_results;//array(SearchResult)
	
	public function __construct(array $products/*array(array(String => Object))*/){
		$this->_resultsCount = count($products);
		$this->_results = array();
		foreach ($products as $product) {
			array_push($this->_results, new SearchResult($product));			
		}
		
	}
	
	/**
     * @return Number of results
     */
	public function getResultsCount(){
		return $this->_resultsCount;
	}
	
	public function getAt($i){
		if($i > $this->_resultsCount){
			return NULL;
		}
		return $this->_results[$i];
	}
	
	 /**
     * @return List of products. Refer {@link SearchResult}
     */
	public  function getResults(){
		return $this->_results;
	}

}