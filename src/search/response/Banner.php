<?php
/**
 * @author 
 * Date: Aug 19, 2015
 * Time: 4:00:30 PM
 * .php
 */

class Banner {
	private $_imageURL;
	private $_landingURL;
	
	
	public function __construct(array $params/*array(String=>Object)*/){
		$this->_imageURL= $params["imageUrl"];
		$this->_landingURL = $params["landingUrl"];
	}
	
	public function getimageURL(){
		return $this->_imageURL;
	}
	

	public function getlandingURL(){
		return $this->_landingURL;
	}

}
