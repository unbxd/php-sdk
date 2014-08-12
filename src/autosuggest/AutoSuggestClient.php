<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 1:06:49 PM
 * AutoSuggestClient.php
 */

include_once (dirname(__FILE__).'/exceptions/AutoSuggestException.php');
include_once (dirname(__FILE__).'/response/AutoSuggestResponse.php');

class AutoSuggestClient{
	
	
	private $siteKey;//String
	private $apiKey;//String
	private $secure;//bool
	private $query;//String
	private $inFieldsCount;//int
	private $popularProductsCount;//int
	private $keywordSuggestionsCount;//int
	private $topQueriesCount;//int
	
	public function __construct($siteKey/*String*/, $apiKey/*String*/, $secure/*bool*/){
		
		$this->apiKey = $apiKey;
		$this->siteKey = $siteKey;
		$this->secure = $secure;
		
		$this->inFieldsCount = -1;
		$this->keywordSuggestionsCount = -1;
		$this->popularProductsCount = -1;
		$this->topQueriesCount = -1;
		
	}
	
	private function getAutoSuggestUrl(){
		return (($this->secure)?"https://":"http://")."$this->siteKey.search.unbxdapi.com/$this->apiKey/autosuggest?wt=json";
	}
	
	/**
     * Gets autosuggest results for query
     * @param query
     * @return this
     */
	
	public function autosuggest($query/*String*/){
		$this->query = $query;
		return $this;
	}
	
	/**
     * Sets number of in_fields to be returned in results
     * @param inFieldsCount
     * @return this
     */
	
	public function setInFieldsCount($inFieldsCount/*int*/){
		$this->inFieldsCount = $inFieldsCount;
		return $this;
	}
	
	/**
     * Sets number of popular products to be returned in results
     * @param popularProductsCount
     * @return this
     */
	
	public function setPopularProductsCount($popularProductsCount/*int*/){
		$this->popularProductsCount = $popularProductsCount;
		return $this;
	}
	
	
	/**
     * Sets number of keyword suggestions to be returned in results
     * @param keywordSuggestionsCount
     * @return this
     */
	
	public function setKeywordSuggestionsCount($keywordSuggestionsCount/*int*/){
		$this->keywordSuggestionsCount = $keywordSuggestionsCount;
		return $this;
	}
	
	/**
     * Sets number of popular queries to be returned in results
     * @param topQueriesCount
     * @return this
     */
	
	public function setTopQueriesCount($topQueriesCount/*int*/){
		$this->topQueriesCount = $topQueriesCount;
		return $this;
	}
	
	private function generateUrl(){
		try{
			$sb="";
			if(isset($this->query)){
				$sb .= $this->getAutoSuggestUrl();
				$sb .= "&q=".urlencode(utf8_encode($this->query));
			}
			if($this->inFieldsCount != -1){
				$sb .= "&inFields.count=".urlencode(utf8_encode(""+$this->inFieldsCount));
			}
			if($this->popularProductsCount != -1){
				$sb .= "&popularProducts.count=".urlencode(utf8_encode(""+$this->popularProductsCount));
			}
			if($this->keywordSuggestionsCount != -1){
				$sb .= "&keywordSuggestions.count=".urlencode(utf8_encode(""+$this->keywordSuggestionsCount));
			}
			if($this->topQueriesCount != -1){
				$sb .= "&topQueries.count=".urlencode(utf8_encode(""+$this->topQueriesCount));
			}
			return $sb;
		}catch (Exception $e){
			throw new AutoSuggestException($e);
		}
	}
	
	/**
     * Executes Auto Suggest Query.
     *
     * @return {@link AutoSuggestResponse}
     * @throws AutoSuggestException
     */
	
	public function execute(){
		try{
			
			$url = $this->generateUrl();
			$request = curl_init($url);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($request);
			if(curl_errno($request)){
				$errors = curl_error($request);
			}
			$info = curl_getinfo($request);
			curl_close($request);
			if(isset($errors) && !is_null($errors) && $errors!=""){
				throw new AutoSuggestException($errors);
			}
			if($info['http_code']!=200){
				throw  new AutoSuggestException($response);
			}
			return new AutoSuggestResponse(json_decode($response,TRUE));
		}catch (Exception $e){
			throw new AutoSuggestException($e->getMessage());
		}
	}
	
}