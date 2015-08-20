<?php
/**
 * @author 
 * Date: Aug 19, 2015
 * Time: 4:00:30 PM
 * .php
 */

class Banners {
	private $_Banner;//array(Banner)
	private $_categories;
	
	
	public function __construct(array $params/*array(String=>Object)*/){

		$this->_Banner= $params["banners"];
		$this->_categories = $params["categories"];
	}
	
	public function getBanner(){
		return $this->_Banner;
	}
	

	public function getAppliedcategory(){
		return $this->_categories;
	}

}
