<?php
/**
 * @author suprit
 * Date: Aug 4, 2014
 * Time: 6:56:36 PM
 * Unbxd.php
 */

include_once (dirname(__FILE__).'/../autosuggest/AutoSuggestClientFactory.php');
include_once (dirname(__FILE__).'/../search/SearchClientFactory.php');
include_once (dirname(__FILE__).'/../feed/FeedClientFactory.php');
include_once (dirname(__FILE__).'/../recommendations/RecommendationsClientFactory.php');
include_once (dirname(__FILE__).'/ConfigException.php');

class Unbxd {
	
	private  static $secure = FALSE;
	private static $_configured = FALSE;
	private static $siteKey,$apiKey,$secretKey;

	/**
	 * Configure Unbxd Client. This method should be called while initializing you application.
	 * If you don't know the configuration details please get in touch with support@unbxd.com
	 *
	 * @param siteKey The Unique Identifier for Site created on Unbxd Platform
	 * @param apiKey API key for calling read APIs
	 * @param secretKey API key for calling Feed APIs
	 */
	
	public static function configure($siteKey, $apiKey, $secretKey=FALSE) {
		self::$siteKey = $siteKey;
		self::$apiKey = $apiKey;
		self::$secretKey = $secretKey;
		self::$_configured = TRUE;
	}
	
	
	 /**
     * Should return a new Feed Client
     * @return {@link FeedClient}
     * @throws ConfigException
     */
	
	public static function getFeedClient(){
		if(!self::$_configured){
			throw new ConfigException("Please configure first with Unbxd.configure()");
		}
		return FeedClientFactory::getFeedClient(self::$siteKey, self::$secretKey, self::$secure);
	}
	
	/**
	 * Should return a new Search Client
	 * @return {@link SearchClient}
	 * @throws ConfigException
	 */
	
	public static function getSearchClient(){
		if(!self::$_configured){
			throw new ConfigException("Please configure first with Unbxd.configure()");
		}
		return SearchClientFactory::getSearchClient(self::$siteKey, self::$apiKey, self::$secure);
		
	}
	
	 /**
     * Should return a new Autosuggest Client
     * @return {@link AutoSuggestClient}
     * @throws ConfigException
     */
	
	public static function getAutoSuggestClient(){
		if(!self::$_configured){
			throw new ConfigException("Please configure first with Unbxd.configure()");
		}
		return AutoSuggestClientFactory::getAutoSuggestClient(self::$siteKey, self::$apiKey, self::$secure);
	}
	
	
	 /**
     * Should return a new Recommendations Client
     * @return {@link RecommendationsClient}
     * @throws ConfigException
     */
	
	public static function getRecommendationsClient(){
		if(!self::$_configured){
			throw new ConfigException("Please configure first with Unbxd.configure()");
		}
		return RecommendationsClientFactory::getRecommendationsClient(self::$siteKey, self::$apiKey, self::$secure);
	}
	
}