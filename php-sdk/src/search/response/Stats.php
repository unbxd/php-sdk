<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 4:28:59 PM
 * Stats.php
 */
include_once (dirname(__FILE__).'/Stat.php');

class Stats {
	
	private $_stats;//array(String=>Stat)
	
	public function __construct(array $params/*array(String=>Object)*/){
		$this->_stats = array();
		foreach($params as $field=>$value){
			if(!is_null($value)){
				$this->_stats[$field] = new Stat($params[$field]);
			}
		}		
	}
	
	
    /**
     * @return Map of Field --> {@link Stat}
     */
	public function getStats(){
		return $this->_stats;
	}
	
	 /**
     * @param fieldName
     * @return Stat for the field name
     */
	
	public function getStat($fieldName/*String*/){
		return $this->_stats[$fieldName];
	}
	
}