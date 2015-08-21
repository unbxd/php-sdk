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
		$this->_imageURL = NULL;
		$this->_landingURL = NULL;
		
		if(array_key_exists("imageUrl" , $params)){
			$this->_imageURL= $params["imageUrl"];
		}

		if(array_key_exists("imageUrl" , $params)){
			$this->_landingURL = $params["landingUrl"];
		}
	}
	
	public function getimageURL(){
		return $this->_imageURL;
	}

	public function getlandingURL(){
		return $this->_landingURL;
	}

}
