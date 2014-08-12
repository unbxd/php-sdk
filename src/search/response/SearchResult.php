<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 1:23:54 PM
 * SearchResult.php
 */
class SearchResult {
	private $_uniqueId;//String
	private $_attributes;//array(String => Object)
	
	public function __construct(array $product/*array(String => Object)*/){
		$this->_attributes = $product;
		$this->_uniqueId = (string) $this->_attributes["uniqueId"];		
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
	
	public function getAttribute($fieldName/*String*/){
		return $this->_attributes[$fieldName];
		
	}
	
}