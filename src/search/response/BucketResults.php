<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 2:38:42 PM
 * BucketResults.php
 */

include_once (dirname(__FILE__).'/BucketResult.php');

class BucketResults {
	
	private $_numberOfBuckets;//int
	private $_buckets;//array(BucketResult)
	private $_bucketsMap;//array(String => BucketResult)
	
	public function __construct(array $params/*array(String => Object)*/){
		$this->_numberOfBuckets = $params["numberOfBuckets"];
		
		$this->_buckets = array();//array(BucketResult)
		$this->_bucketsMap = array();//array(String=>BucketResult)
		
		foreach ($params as $bucketKey=>$value) {
			if($bucketKey=="totalProducts" || $bucketKey=="numberOfBuckets"){
				continue;
			}
			
			$bucket = new BucketResult($params[$bucketKey]);
			array_push($this->_buckets,$bucket);
			$this->_bucketsMap[$bucketKey]=$bucket;			
		}		
	}
	
	/**
     * @return Number of buckets in response
     */
	
	public function getNumberOfBuckets(){
		return $this->_numberOfBuckets;
	}
	
	/**
     * @param value
     * @return Bucket for the field value
     */
	
	public function getBucket($value/*string*/){
		return $this->_bucketsMap[$value];
	}
	
	 /**
     * @return List of {@link BucketResult}
     */
	
	public function getBuckets(){
		return $this->_buckets;
	}
	
	
}