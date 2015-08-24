<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 4:10:53 PM
 * Stat.php
 */

class Stat {
	
	private $_min;//double
	private $_max;//double
	private $_count;//double
	private $_sum;//double
	private $_mean;//double
	
	public function __construct(array $params/*array(String=>Object)*/){
		$this->_min = (double) $params["min"];
		$this->_max = (double) $params["max"];
		$this->_count = (int) $params["count"];
		$this->_sum = (double) $params["sum"];
		$this->_mean = (double) $params["mean"];
	}
	
	public function getCount(){
		return $this->_count;
	}
	
	public function getMin(){
		return $this->_min;
	}	
	
	public function getMax(){
		return $this->_max;
	}

	public function getSum(){
		return $this->_sum;
	}
	
	public function getMean(){
		return $this->_mean;
	}
}