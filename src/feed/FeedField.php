<?php
/**
 * @author suprit
 * Date: Aug 5, 2014
 * Time: 4:06:30 PM
 * FeedField.php
 */

include_once (dirname(__FILE__).'/DataType.php');


class FeedField {
	private $name;
	private $value=NULL;
	private $multiValued;
	private $autoSuggest;
	private $dataType;
	
	
	
	public function __construct($name, DataType $dataType, $multiValued, $autoSuggest){
		$this->name = $name;
		$this->multiValued = $multiValued;
		$this->dataType = $dataType;
		$this->autoSuggest = $autoSuggest;		
	}
	
	/**
	 * @return the value for this field. If the field has multiple values, this
	 * will be a collection.
	 */
	
	public function getValue(){
		return $this->value;
	}
	
	public function setValue($value){
		$this->value = $value;
		
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function isMultiValued(){
		return $this->multiValued;
	}
	
	public function getDataType(){
		return $this->dataType;
	}
	
	public function isAutoSuggest(){
		return $this->autoSuggest;
	}
	
	public function __toString(){
		$s = "FeedInputField{";
		$s .= "name='$this->name'";
		$s .= ", value=$this->value";
		$s .= ", multiValued=".(($this->multiValued)?"true":"false");
		$s .= ", dataType=".(string)$this->dataType;
		$s .= "}";
		return $s;
	}

	
}
