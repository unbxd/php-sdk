<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 7:05:37 PM
 * RecommendationResult.php
 */
class RecommendationResult{
	
	private $_uniqueId;//string
	private $_attributes;//array(String=>Object)
	
	public function __construct(array $params/*array(String=>Object)*/){
		$this->_attributes = $params;
		$this->_uniqueId = $params["uniqueId"];
		
	}
	
	/**
     * @return Attributes of the product
     */
	
	public function getAttributes(){
		return $this->_attributes;
	}
	
	/**
     * @return Unique Id of the product
     */
	
	public function getUniqueId(){
		return $this->_uniqueId;
	}
	
	/**
     * @param fieldName
     * @return Attribute of the product for given field name
     */
	
	public function getAttribute($fieldName){
		return $this->_attributes[$fieldName];
	}
}