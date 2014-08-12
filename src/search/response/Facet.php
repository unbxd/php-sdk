<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 2:58:14 PM
 * Facet.php
 */
require_once (dirname(__FILE__).'/FacetEntry.php');

class Facet {
	
	protected $name;//String
	protected $_type;//String
	protected $_facetEntries;//array(FacetEntry)
	
	public function __construct($facetName/*String*/, array $params/*array(String => Object)*/ ){
		$this->name = $facetName;
		$this->_type = (string)$params["type"];
		
		if(is_array($params["values"])){
			$map = (array) $params["values"];
			if(array_key_exists("counts", $map)){
				$this->generateEntries($map["counts"]);
			}else{
				$this->generateEntries($map);
			}
		}	
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getType(){
		return $this->_type;
	}
	
	protected function generateEntries(array $values/*array(Object)*/){
		$this->_facetEntries = array();//array(FacetEntry)
		$term = NULL;
		for ($i = 0; $i < count($values); $i++) {
			if(($i%2) == 0){
				$term = (string)$values[$i];
			}else{
				$count = (int)$values[$i];
				array_push($this->_facetEntries,new FacetEntry($term, $count));
			}
			
		}
	}
	
	 /**
     * @return List of {@link FacetEntry}
     */
	
	public function getEntries(){
		return $this->_facetEntries;
	}
}