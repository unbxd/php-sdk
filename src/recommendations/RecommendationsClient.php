<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 11:13:20 AM
 * RecommendationsClient.php
 */
include_once (dirname(__FILE__).'/exceptions/RecommendationsException.php');
include_once (dirname(__FILE__).'/response/RecommendationResponse.php');

class RecommendationsClient {
	private $siteKey;//String
	private $apiKey;//string
	private $secure;//bool
	
	private $_boxType;//RecommenderBoxType
	private $uid;//String
	private $ip;//String
	private $uniqueId;//String
	private $category;//String
	private $brand;//String
	
	public function __construct($siteKey/*string*/, $apiKey/*string*/, $secure/*bool*/){
		$this->siteKey = $siteKey;
		$this->apiKey = $apiKey;
		$this->secure = $secure;
		
	}

	private function getRecommendationUrl(){
		return (($this->secure)?"https://":"http://")."recommendations.unbxdapi.com/v1.0/".$this->apiKey."/".$this->siteKey."/";
	}
	
	
	 /**
     * Get Recently viewed items for the user : uid
     * @param uid value of the cookie : "unbxd.userId"
     * @return this
     */
	
	public function getRecentlyViewed($uid/*String*/ , $ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::RECENTLY_VIEWED);
		$this->uid = $uid;
		$this->ip  = $ip;
		return $this;
	}
	
	 /**
     * Get products recommended for user : uid
     * @param uid value of the cookie : "unbxd.userId"
     * @param ip IP address if the user for localization of results
     * @return this
     */
	
	public function getRecommendedForYou($uid/*String*/, $ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::RECOMMENDED_FOR_YOU);
		$this->uid = $uid;
		$this->ip = $ip;
		
		return $this;
	}
	
	/**
     * Get More products like product : uniqueId
     * @param uniqueId Unique Id of the product
     * @param uid value of the cookie : "unbxd.userId"
     * @return this
     */
	
	public function getMoreLikeThis($uniqueId/*String*/, $uid/*String*/,$ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::MORE_LIKE_THESE);
		$this->uid = $uid;
		$this->uniqueId = $uniqueId;
		$this->ip  = $ip;
		return $this;
	}
	
	
	 /**
     * Get products which were also viewed by users who viewed the product : uniqueId
     * @param uniqueId Unique Id of the product
     * @param uid value of the cookie : "unbxd.userId"
     * @return this
     */
	
	public function getAlsoViewed($uniqueId/*String*/, $uid/*String*/,$ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::ALSO_VIEWED);
		$this->uid = $uid;
		$this->uniqueId = $uniqueId;
		$this->ip  = $ip;
		return $this;
	}
	
	
	/**
     * Get products which were also bought by users who bought the product : uniqueId
     * @param uniqueId Unique Id of the product
     * @param uid value of the cookie : "unbxd.userId"
     * @return this
     */
	
	public function getAlsoBought($uniqueId/*String*/, $uid/*String*/,$ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::ALSO_BOUGHT);
		$this->uid = $uid;
		$this->uniqueId = $uniqueId;
		$this->ip  = $ip;
		return $this;
	}
	
	 /**
     * Get Top Selling products
     * @param uid value of the cookie : "unbxd.userId"
     * @param ip IP address if the user for localization of results
     * @return this
     */
	
	public function getTopSellers($uid/*String*/, $ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::TOP_SELLERS);
		$this->uid = $uid;
		$this->ip = $ip;
		return $this;
	}
	
	 /**
     * Get Top Selling products within this category
     * @param category name of the category
     * @param uid value of the cookie : "unbxd.userId"
     * @param ip IP address if the user for localization of results
     * @return this
     */
	
	public function getCategoryTopSellers($category/*String*/, $uid/*String*/, $ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::CATEGORY_TOP_SELLERS);
		$this->uid = $uid;
		$this->$ip = $ip;
		$this->category = $category;
		return $this;
	}
	
	/**
     * Get Top Selling products within this brand
     * @param brand name of the brand
     * @param uid value of the cookie : "unbxd.userId"
     * @param ip IP address if the user for localization of results
     * @return this
     */
	
	
	public function getBrandTopSellers($brand/*String*/, $uid/*String*/, $ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::BRAND_TOP_SELLERS);
		$this->uid = $uid;
		$this->ip = $ip;
		$this->brand = $brand;
		return $this;
	}
	
	 /**
     * Get Top Selling products among products similar to this product
     * @param uniqueId Unique Id of the product
     * @param uid value of the cookie : "unbxd.userId"
     * @param ip IP address if the user for localization of results
     * @return this
     */
	
	public function getPDPTopSellers($uniqueId/*String*/, $uid/*String*/, $ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::PDP_TOP_SELLERS);
		$this->uid = $uid;
		$this->ip = $ip;
		$this->uniqueId = $uniqueId;
		return $this;
	}
	
	/**
     * Get recommendations based on the products added in cart by the user : uid
     * @param uid value of the cookie : "unbxd.userId"
     * @param ip IP address if the user for localization of results
     * @return this
     */
	
	public function getCartRecommendations($uid/*String*/, $ip/*String*/){
		$this->_boxType = new RecommenderBoxType(RecommenderBoxType::CART_RECOMMEND);
		$this->uid = $uid;
		$this->ip  = $ip;
		return $this;
	}
	
	private function generateUrl(){
		try{
			$s="";
			
			if(isset($this->_boxType)){
				$s .= $this->getRecommendationUrl();
			}
			else{
				throw  new RecommendationsException("Couldn't determine which recommendation widget to call.");
			}
			
			if((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::ALSO_VIEWED))){
				$s .= "also-viewed/".urlencode(utf8_encode($this->uniqueId))."?format=json";
			}elseif ((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::ALSO_BOUGHT))){
				$s .= "also-bought/".urlencode(utf8_encode($this->uniqueId))."?format=json";
			}elseif((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::RECENTLY_VIEWED))){
				$s .= "recently-viewed/".urlencode(utf8_encode($this->uid))."?format=json";
			}elseif((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::RECOMMENDED_FOR_YOU))){
				$s .= "recommend/".urlencode(utf8_encode($this->uid))."?format=json";
			}elseif ((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::MORE_LIKE_THESE))){
				$s .= "more-like-these/".urlencode(utf8_encode($this->uniqueId))."?format=json";
			}elseif ((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::TOP_SELLERS))){
				$s .= "top-sellers/?format=json";
			}elseif ((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::CATEGORY_TOP_SELLERS))){
				$s .= "category-top-sellers/".urlencode(utf8_encode($this->category))."?format=json";
			}elseif ((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::BRAND_TOP_SELLERS))){
				$s .= "brand-top-sellers/".urlencode(utf8_encode($this->brand))."?format=json";
			}elseif ((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::PDP_TOP_SELLERS))){
				$s .= "pdp-top-sellers/".urlencode(utf8_encode($this->uniqueId))."?format=json";
			}elseif ((string)$this->_boxType === (string)(new RecommenderBoxType(RecommenderBoxType::CART_RECOMMEND))){
				$s .= "cart-recommend/".urlencode(utf8_encode($this->uid))."?format=json";
			}
			
			if(isset($this->uid)){
				$s .= "&uid=".urlencode(utf8_encode($this->uid));
			}
			
			if(isset($this->ip)){
				$s .= "&ip=".urlencode(utf8_encode($this->ip));
			}
			
			return $s;
		}catch (Exception $e){
			throw new RecommendationsException($e->getMessage());
		}
	}
	
	 /**
     * Executes a recommendations call
     * @return {@link RecommendationResponse}
     * @throws RecommendationsException
     */
	
	public function execute(){
		try{
			$errors=NULL;
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
				throw new RecommendationsException($errors);
			}
			if($info['http_code']!=200){
				throw  new RecommendationsException($response);
			}
			return new RecommendationResponse(json_decode($response,TRUE));
			
		}catch (Exception $e){
			throw new RecommendationsException($e->getMessage());
		}
	}	
	
}



abstract class Enum3 {
    protected $value;

    /**
     * Return string representation of this enum
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

   /**
     * Tries to set the value  of this enum
     *
     * @param string $value
     * @throws Exception If value is not part of this enum
     */
    public function setValue($value)
    {
        if ($this->isValidEnumValue($value))
            $this->value = $value;
        else
            throw new Exception("Invalid type specified!");
    }

   /**
     * Validates if the type given is part of this enum class
     *
     * @param string $checkValue
     * @return bool
     */
    public function isValidEnumValue($checkValue)
    {
        $reflector = new ReflectionClass(get_class($this));
        foreach ($reflector->getConstants() as $validValue)
        {
            if ($validValue == $checkValue) return true;
        }
        return false;
    }

    /**
     * @param string $value Value for this display type
     */
    function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * With a magic getter you can get the value from this enum using
     * any variable name as in:
     *
     * <code>
     *   $myEnum = new MyEnum(MyEnum::start);
     *   echo $myEnum->v;
     * </code>
     *
     * @param string $property
     * @return string
     */
    function __get($property)
    {
        return $this->value;
    }

    /**
     * With a magic setter you can set the enum value using any variable
     * name as in:
     *
     * <code>
     *   $myEnum = new MyEnum(MyEnum::Start);
     *   $myEnum->v = MyEnum::End;
     * </code>
     *
     * @param string $property
     * @param string $value
     * @throws Exception Throws exception if an invalid type is used
     */
    function __set($property, $value)
    {
        $this->setValue($value);
    }

    /**
     * If the enum is requested as a string then this function will be automatically
     * called and the value of this enum will be returned as a string.
     *
     * @return string
     */
    function __toString()
    {
        return (string)$this->value;
    }
}


class RecommenderBoxType extends Enum3{
	const ALSO_VIEWED="ALSO_VIEWED";
	const ALSO_BOUGHT="ALSO_BOUGHT";
	const RECENTLY_VIEWED="RECENTLY_VIEWED";
	const RECOMMENDED_FOR_YOU="RECOMMENDED_FOR_YOU";
	const MORE_LIKE_THESE="MORE_LIKE_THESE";
	const TOP_SELLERS="TOP_SELLERS";
	const CATEGORY_TOP_SELLERS="CATEGORY_TOP_SELLERS";
	const BRAND_TOP_SELLERS="BRAND_TOP_SELLERS";
	const PDP_TOP_SELLERS="PDP_TOP_SELLERS";
	const CART_RECOMMEND="CART_RECOMMEND";
}