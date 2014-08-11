<?php
/**
 * @author suprit
 * Date: Aug 5, 2014
 * Time: 6:26:41 PM
 * FeedFile.php
 */

include_once (dirname(__FILE__).'/FeedField.php');
include_once (dirname(__FILE__).'/FeedProduct.php');
include_once (dirname(__FILE__).'/TaxonomyNode.php');
include_once (dirname(__FILE__).'/DataType.php');

class FeedFile {
	private $_doc;// an associative array object
	
	public function __construct(array $fields,
								array $addedDocs,
								array $updatedDocs,
								array $deletedDocs,
								array $taxonomyNodes,
								array $taxonomyMapping){
									
		   $this->_doc = array("feed"=>array());
		   if(count($fields)>0 || count($addedDocs)>0 || count($updatedDocs)>0 || count($deletedDocs)>0){
		   	
		   	$this->_doc["feed"]["catalog"]=array();
		   	
		   	if(count($fields)>0){
		   		$this->writeSchema($fields, $this->_doc["feed"]["catalog"]);
		   	}
		   	
		   	if(count($addedDocs)>0){
		   		$this->_doc["feed"]["catalog"]["add"]=array();
		   		$this->writeAdd($addedDocs, $this->_doc["feed"]["catalog"]["add"]);
		   		
		   		
		   	}
		   	
		   	if(count($updatedDocs)>0){
		   		$this->_doc["feed"]["catalog"]["update"]=array();
		   		$this->writeUpdate($updatedDocs, $this->_doc["feed"]["catalog"]["update"]);
		   		
		   		
		   	}
		   	
		   	if(count($deletedDocs)>0){
		   		$this->_doc["feed"]["catalog"]["delete"]=array();
		   		$this->writeDelete($deletedDocs, $this->_doc["feed"]["catalog"]["delete"]);
		   		
		   	}
		   	
		   	
		   	
		   }
		   
		   if(count($taxonomyNodes)>0 || count($taxonomyMapping)>0){
		   	$this->_doc["feed"]["taxonomy"]=array();
		   	
		   	if(count($taxonomyNodes)>0){
		   		$this->writeTree($taxonomyNodes, $this->_doc["feed"]["taxonomy"]);
		   	}
		   	if(count($taxonomyMapping)>0){
		   		$this->writeMapping($taxonomyMapping, $this->_doc["feed"]["taxonomy"]);
		   	}
		   }
	}
	
	private function writeSchema(array $fields, array &$parent){
		$parent["schema"]=array();
		foreach ($fields as $value) {
			$field = array("fieldName"=>$value->getName(),
							"dataType"=>(string)$value->getDataType(),
							"multiValued"=>($value->isMultiValued())?"true":"false",
							"autoSuggest"=>($value->isAutoSuggest())?"true":"false");
			array_push($parent["schema"], $field);	
		}
	}
	
	private function writeAttribute(array &$product, 
									$field,//product field its a string
									$o,/*value of the field*/
									$associated/*boolean*/){
			
			if(isset($o)){
				$product[$field.(($associated)?"Associated":"")]=$o;
			}			
					
		
	}
	
	private function writeAdd(array $addedDocs,array &$parent){
		$parent["items"]=array();
		foreach ($addedDocs as $value) {
			$product = array();
			foreach (array_keys($value->getAttributes()) as $field) {
				$this->writeAttribute($product, $field, $value->get($field), FALSE);
			}
			$prodAssociatedProducts = $value->getAssociatedProducts();
			if(isset($prodAssociatedProducts) && count($value->getAssociatedProducts())>0){
				$product["associatedProducts"]=array();
				foreach ($value->getAssociatedProducts() as $mapOfAssociatedProducts) {
					$variants=array();
					foreach ($mapOfAssociatedProducts as $key=>$val) {
						$this->writeAttribute($variants, $key, $val, TRUE);
					}
					array_push($product["associatedProducts"],$variants);
						
				}
			}
			array_push($parent["items"], $product);	
				
		}

	}
	
	private function writeUpdate(array $updatedDocs, array &$parent){
		/* Note variants cannot be updated, can be just added */
		$parent["items"]=array();
		foreach ($updatedDocs as $value) {
			$product = array();
			foreach (array_keys($value->getAttributes()) as $field) {
				$this->writeAttribute($product, $field, $value->get($field), FALSE);
			}
			array_push($parent["items"],$product);				
		}
	}
	
	private function writeDelete(array $deletedDocs, array &$parent){
		$parent["items"]=array();
		foreach($deletedDocs as $value){
			$product=array("uniqueId"=>$value);
			array_push($parent["items"],$product);			
		}
	}
	
	private function writeTree(array $nodes, array &$parent){
		$parent["tree"]=array();
		foreach ($nodes as $node/*Taxonomy Node*/) {
			
			$taxonomyNode = array("nodeId"=>$node->getNodeId(),
								  "nodeName"=>$node->getNodeName());
			$parentNdIds = $node->getParentNodeIds();
			if(isset($parentNdIds) && count($node->getParentNodeIds())>0 ){
				$parentNodeIds = array();
				foreach($node->getParentNodeIds() as $value){
					array_push($parentNodeIds,$value);
					
				}
				$taxonomyNode["parentNodeId"]=$parentNodeIds;
			}
			
		}
		array_push($parent["tree"],$taxonomyNode);
	}
	
	private function writeMapping(array $taxonomyMappings/*array(string => array(string))*/, array &$parent){
		$parent["mapping"]=array();
		foreach ($taxonomyMappings as $uniqueId=>$value) {
			
			$mappingNode = array("uniqueId"=>$uniqueId,
								 "nodeId"=>array());
			
			foreach ($value as $nodeIdValue) {
				array_push($mappingNode["nodeId"],$nodeIdValue);
				
			}
			array_push($parent["mapping"],$mappingNode);
		}
	}
	
	public function getDoc(){
		return $this->_doc;
	}
	
}