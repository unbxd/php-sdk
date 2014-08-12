<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 10:46:55 AM
 * RecommendationResults.php
 */


include_once(dirname(__FILE__).'/RecommendationResult.php');
class RecommendationResults{
	
	private $_resultsCount;//int
	private $_results;//array(RecommendationResult)
	
	public function __construct($params/*array(array(String=>Object))*/){
		$this->_resultsCount = count($params);
		$this->_results = array();//array(RecommendationResult)
		
		foreach ($params as $result) {
			array_push($this->_results,new RecommendationResult($result));
		}
	}
	
	/**
     * @return Number of results
     */
	
	public function getResultsCount(){
		return $this->_resultsCount;
	}
	
	public function getAt($i/*int*/){
		if($i >= $this->_resultsCount){
			return NULL;
		}
		
		return $this->_results[$i];
	}
	
	/**
     * @return List of products. Refer {@link RecommendationResult}
     */
	
	public function getResults(){
		return $this->_results;
	}

}