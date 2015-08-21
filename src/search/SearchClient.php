<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 5:14:50 PM
 * SearchClient.php
 */

include_once (dirname(__FILE__).'/exceptions/SearchException.php');
include_once (dirname(__FILE__).'/response/SearchResponse.php');




class SearchClient {
	
	private $siteKey;//string
	private $apiKey;//string
	private $secure;//boolean
	
	private $query;//string
	private $queryParams;//array(String=>String)
	private $bucketField;//String
	private $categoryIds;//array(string)
	private $filters;//array(String=>array(String))
	private $rangefilters;//array(String=>array(String))
	private $sorts;//array(String=>SortDir
	private $pageNo;//int
	private $pageSize;//int
	private $OtherParams;
	
	public function __construct($siteKey, $apiKey, $secure/*bool*/){
		$this->siteKey = $siteKey;
		$this->apiKey = $apiKey;
		$this->secure = $secure;
		$this->rangefilters = array();//array(String=>array(string))
		$this->filters = array();//array(String=>array(string))
		$this->sorts = array();//array(String=>SortDir)
		$this->OtherParams = array();
		$this->pageNo = 0;
		$this->pageSize = 10;
		
	}
	
	private function getSearchUrl(){
		return (($this->secure)?"https://":"http://")."search.unbxdapi.com/".$this->apiKey."/".$this->siteKey."/search?wt=json";
	}
	
	private function getBrowseUrl(){
		return (($this->secure)?"https://":"http://")."search.unbxdapi.com/".$this->apiKey."/".$this->siteKey."/browse?wt=json";
	}
	
	/**
     * Searches for a query and appends the query parameters in the call.
     * @param query
     * @param queryParams
     * @return this
     */
	
	public function search($query/*String*/, array $queryParams=array()){

		$this->query = $query;
		$this->queryParams = $queryParams;		
		return $this;
	}
	
	/**
     * Searches for a query, appends the query parameters in the call and responds with bucketed results.
     * @param query
     * @param bucketField Field on which buckets have to created.
     * @param queryParams
     * @return this
     */
	
	public function bucket($query/*String*/, $bucketField/*String*/, array $queryParams=array()){
		$this->query =  $query;
		$this->queryParams = $queryParams;
		$this->bucketField = $bucketField;
		return $this;
	}
	
	/**
     * Calls for browse query and fetches results for given nodeId
     * @param nodeId
     * @param queryParams
     * @return this
     */
	
	public function browse($nodeId, array $queryParams=array()){
		if(is_array($nodeId)){
			$this->categoryIds = $nodeId;
		}
		else{
		$this->categoryIds = array($nodeId);
		}
		$this->queryParams = $queryParams;
		return $this;	
	}
	
	/**
     * Filters the results
     * Values in the same fields are ORed and different fields are ANDed
     * @param fieldName
     * @param values
     * @return this
     */
	
	public function addTextFilter($fieldName, $values/*array(String)*/){
		$this->filters[$fieldName][]=$values;
		return $this;
	}
	
	public function addRangeFilter($fieldName, $Start , $Stop){		
		$this->rangefilters[$fieldName][]="[" . $Start . " TO " . $Stop ."]";
		return $this;
	}

	public function addOtherParams($Otherkey , $Othervalue){
		$this->OtherParams[$Otherkey] = $Othervalue;
		return $this;
	}
	
	/**
     * Sorts the results on a field
     * @param field
     * @param sortDir
     * @return this
     */
	
	public function addSort($field, SortDir $sortDir){
		$this->sorts[$field]=(string)$sortDir;
		return $this;
	}
		
	/**
     *
     * @param pageNo
     * @param pageSize
     * @return this
     */
	public function setPage($pageNo, $pageSize){
		if($pageNo > 0){
			$pageNo = $pageNo -1;
		}
		$this->pageNo = $pageNo;
		$this->pageSize = $pageSize;
		
		return $this;
	}
	
	private function generateUrl(){
		if(isset($this->query) && isset($this->categoryIds)){
			throw  new SearchException("Can't set query and node id at the same time");
		}
		
		try{

			$sb = "";
			if(isset($this->query)){
				$sb .= $this->getSearchUrl();
				$sb .= "&q=".urlencode(utf8_encode($this->query));				
				if(isset($this->bucketField)){
					$sb .= "&bucket.field=".urlencode(utf8_encode($this->bucketField));
				}
			}
			elseif (isset($this->categoryIds) && count($this->categoryIds)>0){
				$sb .= $this->getBrowseUrl();
				$sb .= "&category-id=".urlencode(utf8_encode(implode(",", $this->categoryIds)));
			}
			
			if(isset($this->queryParams) && count($this->queryParams)){
				foreach ($this->queryParams as $key=>$value){
					$sb .= "&$key=".urlencode(utf8_encode($this->queryParams[$key]));
				}
			}
			
			if(isset($this->filters) && count($this->filters)>0){
				foreach ($this->filters as $key=>$val){
					$sb.= "&filter=".urlencode($key.':"'.join(("\" OR " . $key .":\""), $val).'"');
				}
			}
			
			if(isset($this->rangefilters) && count($this->rangefilters)>0){
				foreach ($this->rangefilters as $key => $val){
					$sb.= "&filter=".urlencode($key.':'.join((" OR " . $key .":"), $val));
				}
		    }

			if(isset($this->sorts) && count($this->sorts)>0){
				$sorts = array();
				foreach($this->sorts as $key=>$val){
					array_push($sorts,$key.' '.strtolower((string)$val));
				}
				$sb .= "&sort=".urlencode(utf8_encode(implode(",", $sorts)));
			}
			

			$sb .= "&pageNumber=$this->pageNo";
			$sb .= "&rows=$this->pageSize";


			if(isset($this->otherparams) && count($this->otherparams)>0){
				foreach ($this->otherparams as $key=>$val){
					$sb .= "&".urlencode(utf8_encode($key.'='.$val));
				}
		  	}
			return (string)$sb;
		}
		catch (Exception $e){
			throw new SearchException($e);
			
		}
	}
	
	/**
     * Executes search.
     *
     * @return {@link SearchResponse}
     * @throws SearchException
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
				throw new SearchException($errors);
			}
			if($info['http_code']!=200){
				throw  new SearchException($response);
			}

			return new SearchResponse(json_decode($response,TRUE));
			
		}
		catch(Exception $e){
			throw new SearchException($e->getMessage());			
		}
	}
			
}

abstract class enum1 {
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


class SortDir extends enum1{
	const ASC="ASC";
	const DESC="DESC";
}