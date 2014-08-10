<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 2:53:46 PM
 * FacetEntry.php
 */
class FacetEntry {
	private $term;//String
	private $count;//int
	
	//public function __construct($count/*int*/){
		//$this->count = $count;		
	//}
	
	public function __construct($term/*String*/,$count/*int*/){
		$this->term = $term;
		$this->count = $count;	
	}

	public function getTerm(){
		return $this->term;
	}
	
	public function getCount(){
		return $this->count;
	}
	

}