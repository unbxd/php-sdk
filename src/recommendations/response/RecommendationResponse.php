<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 10:57:40 AM
 * RecommendationResponse.php
 */

include_once (dirname(__FILE__).'/RecommendationResults.php');

class RecommendationResponse {
	
	private $_statusCode;//int
	private $_errorCode;//int
	private $_message;//string
	private $_queryTime;//int
	private $_totalResultsCount;//int
	private $_results;//RecommendationsResults
	
	public function __construct(array $params/*array(String=>Object)*/){
		if(array_key_exists("error", $params) && isset($params["error"]) && !is_null($params["error"])){
			$error = $params["error"];
			$this->_errorCode = (int) $params["code"];
			$this->_message = (string) $error["message"];
		}else{
			$this->_message="OK";
			$this->_statusCode = (int) $params["status"];
			$this->_queryTime = (int) $params["queryTime"];
			$this->_totalResultsCount = (int) $params["count"];
			
			if(array_key_exists("Recommendations", $params) && isset($params["Recommendations"])){
				$this->_results = new RecommendationResults($params["Recommendations"]);
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
     * @return Number of results in the response.
     */
	
	public function getTotalResultsCount(){
		return $this->_totalResultsCount;
	}
	
	/**
     * @return Results. Refer {@link RecommendationResults}
     */
	
	public function getResults(){
		return $this->_results;
	}
	
	

}

