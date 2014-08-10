<?php
/**
 * @author suprit
 * Date: Aug 6, 2014
 * Time: 2:36:16 PM
 * FeedResponse.php
 */
class FeedResponse {
	private $_statusCode;//int
	private $_message;//string
	private $_uploadID;//string
	private $_unknownSchemaFields;//array of string
	private $_fieldErrors;//array of FeedFieldError
	private $_rowNum;//int
	private $_colNum;//int
	
	public function __construct(array $response/*Map<String, Object>*/){
		$this->_statusCode = $response["statusCode"];
		$this->$_message = $response["message"];
		$this->$_uploadID = $response["unbxdFileName"];
		$this->$_unknownSchemaFields = $response["unknownSchemaFields"];
		if(array_key_exists("fieldErrors", $response)){
			$fieldErrors = $response["fieldErrors"];
			$this->_fieldErrors = array();//array of FeedFieldError
			foreach( $fieldErrors as $value){
				array_push($this->_fieldErrors, $value);
			}
		}
		
		if(isset($response["rowNum"]) && !is_null($response["rowNum"])){
			$this->_rowNum = $response["rowNum"];
		}
		
		if(isset($response["colNum"]) && !is_null($response["colNum"])){
			$this->_colNum = $response["colNum"];
		}
		
		
	}
	
	public function getStatusCode(){
		return $this->_statusCode;
	}
	
	public function getMessage(){
		return $this->_message;
	}
	
	public function getUploadID(){
		return $this->_uploadID;
	}
	
	public function getFieldErrors(){
		return $this->_fieldErrors;
	}
	
	public function getUnknownSchemaFields(){
		return $this->_unknownSchemaFields;
	}
	
	public function getRowNum(){
		return $this->_rowNum;
	}
	
	public function getColNum(){
		return $this->_colNum;
	}
	
	public function __toString(){
		$s = "FeedResponse{";
		$s .= "_statusCode=$this->_statusCode";
		$s .= ", _message='$this->_message'";
		$s .= ", _uploadID='$this->_uploadID'";
		$s .= ", _unknownSchemaFields=$this->_unknownSchemaFields";
		$s .= ", _fieldErrors=$this->_fieldErrors";
		$s .= ", _rowNum=$this->_rowNum";
		$s .= ", _colNum=$this->_colNum";
		$s .= "}";
		
		return $s;
		
	}
	
	
}	