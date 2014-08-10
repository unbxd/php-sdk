<?php
/**
 * @author suprit
 * Date: Aug 7, 2014
 * Time: 3:31:59 PM
 * RangeFacetEntry.php
 */

include_once(dirname(__FILE__).'/FacetEntry.php');

class RangeFacetEntry extends FacetEntry {
	private $from;
	private $to;
	
	public function __construct($from/*double*/,$to/*double*/,$count/*int*/){
		parent::__construct("",$count);
		
		$this->from = $from;
		$this->to =$to;		
	}
	
	public function getFrom(){
		return $this->from;
	}
	
	public function getTo(){
		return $this->to;
	}
	
}