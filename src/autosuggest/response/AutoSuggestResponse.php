<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 12:57:06 PM
 * AutoSuggestResponse.php
 */
include_once (dirname(__FILE__).'/AutoSuggestResults.php');

class AutoSuggestResponse{
	
	private $_statusCode;//int
	private $_errorCode;//int
	private $_message;//string
	private $_queryTime;//string
	private $_totalResultsCount;//int
	private $_results;//AutoSuggestResults
	
	public function __construct(array $params/*array(Object=>String)*/){
		if(array_key_exists("error", $params)){
			$error = $params["error"];
			$this->_errorCode = (int) $error["code"];
			$this->_message = (string) $error["msg"];
		}else{
			$this->_message = "OK";
			$metaData = $params["searchMetaData"];
			$this->_statusCode = (int) $metaData["status"];
			$this->_queryTime = (int) $metaData["queryTime"];
			if(array_key_exists("response", $params)){
				$response = $params["response"];
				$this->_totalResultsCount = (int) $response["numberOfProducts"];
				$this->_results = new AutoSuggestResults($response["products"]);
			}
		}
		
	}
	
	 /**
     * @return Status Code. 200 if OK.
     */
	
	public function getStatusCode(){
		return $this->_statusCode;
	}
	
	/**
     * @return Error code in case of an error.
     */
	
	public function getErrorCode(){
		return $this->_errorCode;
	}
	
	
	 /**
     * @return OK if successfull. Error message otherwise
     */
	
	public function getMessage(){
		return $this->_message;
	}
	
	/**
     * @return Time taken to query results in milliseconds
     */
	
	public function getQueryTime(){
		return $this->_queryTime;
	}
	
	 /**
     * @return Total number of results found.
     */
	
	public function getTotalResultsCount(){
		return $this->_totalResultsCount;
	}
	
	/**
     * @return Results. Refer {@link AutoSuggestResults}
     */
	
	public function getResults(){
		return $this->_results;
	}
}

