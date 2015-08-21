<?php
/**
 * @author 
 * Date: Aug 19, 2015
 * Time: 4:00:30 PM
 * .php
 */
require_once (dirname(__FILE__).'/Banner.php');
class Banners {
	private $_Banner;//array(Banner)
	private $_categories;
		
	public function __construct(array $params/*array(String=>Object)*/){
		$this->_Banner=array();
		$this->_categories = array();
		if(isset($params["banners"])){
			foreach ($params["banners"] as $name => $value) {
				$banner = new Banner($value);
				array_push($this->_Banner,$banner);
			}
		}
		if(array_key_exists("categories" , $params)){
			$this->_categories = $params["categories"];
		}
	}
	
	public function getBanner(){
		return $this->_Banner;
	}
	
	public function getAppliedcategory(){
		return $this->_categories;
	}

}
