<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 3:41:59 PM
 * RangeFacet.php
 */

include_once(dirname(__FILE__).'/Facet.php');
include_once(dirname(__FILE__).'/RangeFacetEntry.php');

class RangeFacet extends Facet{
	private $_gap;//double
	protected $_rangeFacetEntries;//array(RangeFacetEntry)


	public function __construct($facetName, $params){
		parent::__construct($facetName, $params);
		$this->_gap = (double)$params["values"]["gap"];
	}
	
	protected function generateEntries($values/*array(Object)*/){
		parent::generateEntries($values);
		
		$this->_rangeFacetEntries = array();
		foreach ($this->_facetEntries as $entry){
			$from = (double)$entry->getTerm();
			$to = $from + $this->_gap;
			array_push($this->_rangeFacetEntries, new RangeFacetEntry($from, $to, $entry->getCount()));			
		}
	}
	
	public function getRangeEntries(){
		return $this->_rangeFacetEntries;
	}
}