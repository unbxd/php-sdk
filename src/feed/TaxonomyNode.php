<?php
/**
 * @author suprit
 * Date: Aug 6, 2014
 * Time: 12:43:09 PM
 * TaxonomyNode.php
 */
class TaxonomyNode {
	
	// Node Id. Generally corresponds to Category id or brand id
	private $nodeId;
	
	private $nodeName;
	
	// List of parents in the order of nearest first
	private $parentNodeIds;
	
	public function __construct($nodeId, $nodeName, array $parentNodeIds=array()){
		$this->nodeId = $nodeId;
		$this->nodeName = $nodeName;
		$this->parentNodeIds = $parentNodeIds;
		
	}
	
	public function getNodeId(){
		return $this->nodeId;
	}
	
	public function getNodeName(){
		return $this->nodeName;
	}
	
	/**
	 * @return List of parents in the order of nearest first
	 */
	public function getParentNodeIds(){
		return $this->parentNodeIds;
	}
	
	public function __toString(){
		$s = "TaxonomyNode{";
		$s .= "nodeId='$this->nodeId'";
		$s .= ", nodeName='$this->nodeName'";
		$s .= ", parentNodeIds=".json_encode($this->parentNodeIds);
		$s .= "}";
		return $s;
	}
	
	
}