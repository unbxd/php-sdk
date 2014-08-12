<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 12:03:46 PM
 * AutoSuggestResult.php
 */

class AutoSuggestResult{
	
	private $_attributes;//array(String=>Object)
	
	public function __construct(array $params/*array(String=>Object)*/){
		
		$this->_attributes = $params;		
	}
	
	/**
     * @return Attributes of the product
     */
	
	public function getAttributes(){
		return $this->_attributes;
	}
	
	 /**
     * @param fieldName
     * @return Attribute of the product for given field name
     */
	
	public function getAttribute($fieldName/*String*/){
		return $this->_attributes[$fieldName];
	}
	
	/**
     * @return Get Suggestion
     */
	
	public function getSuggestion(){
		return (string) $this->getAttribute("autosuggest");
	}
}