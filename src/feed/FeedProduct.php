<?php
/**
 * @author suprit
 * Date: Aug 5, 2014
 * Time: 5:33:52 PM
 * FeedProduct.php
 * Represents a product being added/updates in feed
 */

class FeedProduct {
	private $uniqueId; // Unique Id of the product. Generally corresponds to the SKU.
	private $_attributes; // associative array of string=>object
	private $_associatedDocuments; // array of associative array 
	
	/**
	 * @param uniqueId
	 * @param attributes
	 */
	public function __construct($uniqueId, array $attributes){
		if(is_null($attributes)){
			$attributes = array();
		}

		$attributes["uniqueId"]=$uniqueId;
		$this->_attributes = $attributes;
		$this->_associatedDocuments = array();
		$this->uniqueId = $uniqueId;
	}

	/**
     * @return Unique Id of the product
     */
	public function getUniqueId(){
		return $this->uniqueId;
	}
	
	/**
     * @return Product Attributes
     */
	public function getAttributes(){
		return $this->_attributes;
	}
	
	
    /**
     * @return get list of associated products
     */
	public function getAssociatedProducts(){
		return $this->_associatedDocuments;
	}
	
	public function addAssociatedProduct(array $product){
		array_push($this->_associatedDocuments, $product);
	}
	
	/**
     *
     * @param key
     * @return Attribute of the product
     */
	
	public function get($key){
		return $this->_attributes[$key];
	}
	
	public function __toString(){
		$s = "FeedProduct{";
		$s .= "uniqueId='$this->uniqueId'";
		$s .= ", _attributes=".json_encode($this->_attributes);
		$s .= ", _associatedDocuments=".json_encode($this->_associatedDocuments);
		$s .= "}";
		return $s;
	}
	
	
	
}