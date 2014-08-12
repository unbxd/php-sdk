<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 4:10:30 PM
 * SearchResponse.php
 */
include_once (dirname(__FILE__).'/SearchResults.php');
include_once (dirname(__FILE__).'/BucketResults.php');
include_once (dirname(__FILE__).'/Facets.php');
include_once (dirname(__FILE__).'/Stats.php');

class SearchResponse {
	
	private $_statusCode;//int
	private $_errorCode;//int
	private $_message;//String
	private $_queryTime;//int
	private $_totalResultsCount;//int
	private $_results;//SearchResults
	private $_buckets;//BucketResults
	private $_facets;//Facets
	private $_stats;//Stats
	private $_spellCorrections;//array(String)
	
	public function __construct(array $params/*array(String=>Object)*/){
		//var_dump($params);
		if(array_key_exists("error", $params) && isset($params["error"])){
			$error = $params["error"];
			$this->_errorCode = (int) $error["code"];
			$this->_message = $error["msg"];
		}else{
			$this->_message = "OK";
			$metaData = $params["searchMetaData"];
			$this->_statusCode = (int)$metaData["status"];
			$this->_queryTime = (int)$metaData["queryTime"];
			
			if(array_key_exists("response", $params) && isset($params["response"])){
				$response = $params["response"];
				$this->_totalResultsCount = (int) $response["numberOfProducts"];
				$this->_results = new SearchResults($response["products"]);
			}
			
			if(array_key_exists("buckets", $params) && isset($params["buckets"])){
				$response = $params["buckets"];
				$this->_totalResultsCount = (int) $response["totalProducts"];
				$this->_buckets = new BucketResults($response);
			}
			
			if(array_key_exists("facets", $params) && isset($params["facets"])){
				$facets = $params["facets"];
				$this->_facets = new Facets($facets);
			}
			
			if(array_key_exists("stats", $params) && isset($params["stats"])){
				$stats = $params["stats"];
				$this->_stats = new Stats($stats);
			}
			
			if(array_key_exists("didYouMean", $params) && isset($params["didYouMean"])){
				$this->_spellCorrections = array();
				$dym = $params["didYouMean"];
				foreach ($dym as $suggestion) {
					array_push($this->_spellCorrections,$suggestion["suggestion"]);
					
				}
			}
			
		}//
	}
	
	
	/**
     * @return  Status Code. 200 if OK.
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
     * @return Results. Refer {@link SearchResults}
     */
	
	public function getResults(){
		return $this->_results;
	}
	
	/**
     * @return Stats. Refer {@link Stats}
     */
	
	public function getStats(){
		return $this->_stats;
	}
	
	 /**
     * @return List of spell corrections in the order of relevance
     */
	
	public function getSpellCorrections(){
		return $this->_spellCorrections;
	}
	
	 /**
     * @return Bucketed Response. Refer {@link BucketResults}
     */
	
	public function getBuckets(){
		return $this->_buckets;
	}
}