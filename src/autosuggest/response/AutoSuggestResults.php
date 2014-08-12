<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 12:28:12 PM
 * AutoSuggestResults.php
 */

include_once (dirname(__FILE__).'/AutoSuggestResultSection.php');
include_once(dirname(__FILE__).'/../AutoSuggestType.php');

class AutoSuggestResults{
	
	private $_resultSections;//array(AutoSuggestType=>AutoSuggestResultSection)
	
	
	public function __construct(array $params/*array(array(String=>Object))*/){
		$this->_resultSections = array();//array(string=>AutoSuggestResultSection)
		foreach ($params as $result) {
			$type = (string) $result["doctype"];
			if(!array_key_exists($type, $this->_resultSections)){
				if($type==="IN_FIELD"){
					$this->_resultSections[$type] = new AutoSuggestResultSection(new AutoSuggestType(AutoSuggestType::IN_FIELD));
				}elseif ($type==="POPULAR_PRODUCTS"){
					$this->_resultSections[$type] = new AutoSuggestResultSection(new AutoSuggestType(AutoSuggestType::POPULAR_PRODUCTS));
				}elseif ($type==="TOP_SEARCH_QUERIES"){
					$this->_resultSections[$type] = new AutoSuggestResultSection(new AutoSuggestType(AutoSuggestType::TOP_SEARCH_QUERIES));				
				}elseif($type==="KEYWORD_SUGGESTION"){
					$this->_resultSections[$type] = new AutoSuggestResultSection(new AutoSuggestType(AutoSuggestType::KEYWORD_SUGGESTION));
				}
			}
			$this->_resultSections[$type]->addResult($result);
		}
	}
	
	/**
     * @return Get response in sections. Map {@link AutoSuggestType} --> @{@link AutoSuggestResultSection}
     */
	
	public function getResultSections(){
		return $this->_resultSections;
	}
	
	/**
	 * @return Get suggestions in buckets
	 */
	
	public function getInFieldSuggestions(){
		return $this->_resultSections["IN_FIELD"];
	}
	
	/**
     * @return Get Popular products
     */
	
	public function getPopularProducts(){
		return $this->_resultSections["POPULAR_PRODUCTS"];

	}
	
	/**
     * @return Get suggestions based on keyword
     */
	
	public function getKeywordSuggestions(){
		return $this->_resultSections["KEYWORD_SUGGESTION"];
	}

	/**
     * @return Get Top Queries
     */
	
	public function getTopQueries(){
		return $this->_resultSections["TOP_SEARCH_QUERIES"];

	}



}

