<?php
/**
 * @author 
 * Date: Aug 19, 2015
 * Time: 4:00:30 PM
 * .php
 */
require_once (dirname(__FILE__).'/Banner.php');
class Banners {
	private $_banner;//array(Banner)
	private $_categories;
		
	public function __construct(array $params/*array(String=>Object)*/){
		$this->_banner=array();
		$this->_categories = array();
		if(isset($params["banners"])){
			foreach ($params["banners"] as $name => $value) {
				$banner = new Banner($value);
				array_push($this->_banner,$banner);
			}
		}
		if(array_key_exists("categories" , $params)){
			$this->_categories = $params["categories"];
		}
	}
	
	public function getBanner(){
		return $this->_banner;
	}
	
	public function getAppliedcategory(){
		return $this->_categories;
	}

}
