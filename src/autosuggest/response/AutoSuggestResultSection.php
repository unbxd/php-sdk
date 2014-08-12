<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 12:07:04 PM
 * AutoSuggestResultSection.php
 */
include_once (dirname(__FILE__).'/AutoSuggestResult.php');
include_once (dirname(__FILE__).'/../AutoSuggestType.php');


class AutoSuggestResultSection{
	
	private $_type;//AutoSuggestType
	private $_resultsCount;//int
	private $_results;//array(AutoSuggestResult)
	
	public function __construct(AutoSuggestType $type){
		
		$this->_type = $type;
		$this->_results = array();//array(AutoSuggestResult)
		
	}
	
	public function addResult(array $params/*array(String=>Object)*/){
		array_push($this->_results,new AutoSuggestResult($params));
		$this->_resultsCount++;
	}
	
	/**
     * @return {@link AutoSuggestType}
     */
	
	public function getType(){
		return $this->_type;
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
     * @return List of Auto suggest results. Refer {@link AutoSuggestResult}
     */
	
	public function getResults(){
		return $this->_results;
	}
	
}