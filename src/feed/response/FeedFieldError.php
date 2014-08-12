<?php
/**
 * @author suprit
 * Date: Aug 6, 2014
 * Time: 2:13:29 PM
 * FeedFieldError.php
 */

include_once (dirname(__FILE__).'/../DataType.php');
class FeedFieldError {
	
	private $_fieldName;
	private $_fieldValue;
	private $_dataType;
	private $_multivalued;
	private $_errorCode;
	private $_message;
	private $_rowNum;
	private $_colNum;
	
	public function __construct(array $params=array()/*Map<String,Object>*/){
		$this->_fieldName = $params["fieldName"];//String
		$this->_fieldValue = $params["fieldValue"];//String
		$this->_dataType = (string) $params["dataType"];//String
		$this->_multivalued = $params["multiValue"];//bool
		$this->_errorCode = $params["errorCode"];//int'
		$this->_message = $params["messages"];//String
		
		if(isset($params["rowNum"]) && !is_null($params["rowNum"])){
			$this->_rowNum = $params["rowNum"];//int			
		}
		
		if(isset($params["colNum"]) && !is_null($params["colNum"])){
			$this->_colNum = $params["colNum"];//int
		}
	}
	
	public function getFieldName(){
		return $this->_fieldName;
	}
	
	public function getFieldValue(){
		return $this->_fieldValue;
	}
	
	public function getDataType(){
		return $this->_dataType;
	}
	
	public function isMultivalued(){
		return $this->_multivalued;
	}
	
	public function getErrorCode(){
		return $this->_errorCode;
	}
	
	public function getMessage(){
		return $this->_message;
	}
	
	public function getRowNum(){
		return $this->_rowNum;
	}
	
	public function getColNum(){
		return $this->_colNum;
	}
	
	public function __toString(){
		$s = "FeedFieldError{";
		$s .= "_fieldName='$this->_fieldName'";
		$s .= ", _fieldValue=$this->_fieldValue";
		$s .= ", _dataType=$this->_dataType";
		$s .= ", _multivalued=".(($this->_multivalued)?"true":"false");
		$s .= ", _errorCode=$this->_errorCode";
		$s .= ", _message='$this->_message'";
		$s .= ", _rowNum=$this->_rowNum";
		$s .= ", _colNum=$this->_colNum";
		$s .= "}";
		
		return (string)$s;
	}
	
}