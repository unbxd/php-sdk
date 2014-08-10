<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 4:00:30 PM
 * Facets.php
 */

include_once (dirname(__FILE__).'/Facet.php');
include_once (dirname(__FILE__).'/RangeFacet.php');

class Facets {
	private $_facets;//array(Facet)
	private $_facetsMap;//array(String => Facet)
	
	public function __construct(array $params/*array(String=>Object)*/){
		$this->_facets = array();
		$this->_facetsMap = array();
		//var_dump($params);
		foreach ($params as $field=>$value) {
			$facetParams = $value;
			$type = $facetParams["type"];			
			$facet = ($type=="facet_fields")?(new Facet($field, $facetParams)):(new RangeFacet($field, $facetParams));
			array_push($this->_facets,$facet);
			$this->_facetsMap[$field]=$facet;
		}		
	}
	
	/**
     * @return List of {@link Facet}
     */
	
	public function getFacets(){
		return $this->_facets;
	}
	
	/**
     * @return Map of field --> {@link Facet}
     */
	
	public function getFacetsAsMap(){
		return $this->_facetsMap;
	}
	
	 /**
     * @param facetName
     * @return Facet for given field name
     */
	
	public function getFacet($facetName){
		return $this->_facetsMap[$facetName];
	}
}
