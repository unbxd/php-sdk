<?php
/**
 * @author suprit
 * Date: Aug 6, 2014
 * Time: 3:02:46 PM
 * FeedClient.php
 */

require_once (dirname(__FILE__).'/exceptions/FeedInputException.php');
require_once (dirname(__FILE__).'/exceptions/FeedUploadException.php');
require_once (dirname(__FILE__).'/response/FeedFieldError.php');
require_once (dirname(__FILE__).'/response/FeedResponse.php');
require_once (dirname(__FILE__).'/DataType.php');
require_once (dirname(__FILE__).'/FeedField.php');
require_once (dirname(__FILE__).'/FeedFile.php');
require_once (dirname(__FILE__).'/FeedProduct.php');
require_once (dirname(__FILE__).'/TaxonomyNode.php');

class FeedClient {
	
	private $siteKey;//string
	private $secretKey;//string
	private $secure;//bool
	private $_fields;//List<FeedField>
	private $_addedDocs;//Map<String, FeedProduct>
	private $_updatedDocs;//Map<String, FeedProduct>
	private $_deletedDocs;//Unique array of strings
	private $_taxonomyNodes;//List<TaxonomyNode>
	private $_taxonomyMappings;//Map<String, List<String>>
	
	public function __construct($siteKey, $secretKey="", $secure=FALSE){
		$this->siteKey = $siteKey;
		$this->secretKey = $secretKey;
		$this->secure = $secure;
		$this->_fields = array();
		$this->_addedDocs = array();
		$this->_updatedDocs = array();
		$this->_deletedDocs = array_unique(array());// Just for the sake of reminder that it is a set
		$this->_taxonomyNodes = array();
		$this->_taxonomyMappings = array();		
	}
	
	private function getFeedUrl(){
		return (($this->secure)?"https://":"http://")."feed.unbxdapi.com/upload/v2/$this->secretKey/$this->siteKey";
	}
	
	/**
     * Adds schema for a field. Schema needs to be added only once.
     *
     * @param fieldName Name of the field. Following rules apply for field names.
     *                  <ul>
     *                      <li>Should be alphnumeric</li>
     *                      <li>Can contain hyphens and underscores</li>
     *                      <li>Can not start and end with -- or __</li>
     *                      <li>Can not start with numbers</li>
     *                  </ul>
     * @param datatype Datatype of the field. Refer {@link DataType}
     * @param multivalued True for allowing multiple values for each document
     * @param autosuggest True to include field in autosuggest response
     * @return this
     */
	public function addSchema($fieldName,//String
							  DataType $dataType,
							  $multiValued=FALSE,
							  $autoSuggest=FALSE){
							  	
			array_push($this->_fields,new FeedField($fieldName, $dataType, $multiValued, $autoSuggest));
			return $this;							  
		}
	
	
	/**
     * Adds a product to the field. If a product with the same uniqueId is found to be already present the product will be overwritten
     * @param product
     * @return this
     */
	public function addProduct(FeedProduct $feedProduct){
		$this->_addedDocs[$feedProduct->getUniqueId()]=$feedProduct;
		return $this;
	}
	
	/**
     * Adds a list of products to the field. If a product with the same uniqueId is found to be already present the product will be overwritten
     * @param products
     * @return this
     */
	
	public function addProducts(array $products){
		foreach ($products as $product){
			$this->addProduct($product);
		}
		
		return $this;
	}
	
	/**
     * Add a variant to a product.
     * @param parentUniqueId Unique Id of the parent product
     * @param variantAttributes Attributes of the variant
     * @return this
     * @throws FeedInputException
     */
	
	public function addVariant($parentUniqueId,/*String*/
							   $variantAttributes/*Map<String, Object>*/){
			
			if(!array_key_exists($parentUniqueId, $this->_addedDocs)){
				throw new FeedInputException("Parent product needs to be added");
			}
				
			$this->_addedDocs["$parentUniqueId"]->addAssociatedProduct($variantAttributes);
			return $this;	
	}
	
	/**
     * Add variants to a product.
     * @param parentUniqueId Unique Id of the parent product
     * @param variants List of attributes of the variants
     * @return this
     * @throws FeedInputException
     */
	public function addVariants($parentUniqueId,/*String*/
							   $variants/*List<Map<String, Object>>*/){

			foreach ($variants as $value) {
				$this->addVariant($parentUniqueId, $value);
			}						   	
			return $this;
	}
	
	/**
     * Upserts a product.
     * @param productDelta Delta of product attributes. uniqueId is mandatory
     * @return this
     */
	
	public function updateProduct(FeedProduct $productDelta){
		$this->_updatedDocs[$productDelta->getUniqueId()]=$productDelta;
		return $this;
	}
	
	/**
     * Upserts products.
     * @param productsDeltas Deltas of products attributes. uniqueId is mandatory
     * @return this
     */
	
	public function updateProducts(array $productsDeltas/*List<FeedProduct>*/){
		
		foreach ($productsDelta as $product) {
			$this->updateProduct($product);
		}
		
		return $this;
	}
	
	 /**
     * Deletes a product with given uniqueId
     * @param uniqueId
     * @return this
     */
	
	public function deleteProduct($uniqueId/*String*/){
		array_push($this->_deletedDocs, $uniqueId);
		$this->_deletedDocs = array_unique($this->_deletedDocs);
		return $this;
	}
	
	/**
     * Deletes products with given uniqueIds
     * @param uniqueIds
     * @return this
     */
	
	public function deleteProducts(array $uniqueIds/*List<String>*/){
		foreach ($uniqueIds as $value) {
			$this->deleteProduct($value);	
		}
		return $this;
		
	}
	
	 /**
     * Adds a taxonomy node
     * @param node
     * @return this
     */
	
	public function addTaxonomyNode(TaxonomyNode $node){
		array_push($this->_taxonomyNodes, $node);
		
		return $this;
	}
	
	/**
     * Add taxonomy nodes
     * @param nodes
     * @return
     */
	
	public function addTaxonomyNodes(array $nodes){
		foreach ($nodes as $node) {
			$this->addTaxonomyNode($node);
		}
		return $this;
	}
	
	/**
     * Maps a uniqueId with taxonomy nodes
     * @param uniqueId
     * @param nodeIds List of taxnonomy node Id
     * @return this
     */
	
	public function addTaxonomyMapping($uniqueId, array $nodeIds/*List<String>*/){
		$this->_taxonomyMappings[$uniqueId]=$nodeIds;
		return $this;
	}
	
	/**
     * Maps uniqueIds with taxonomy nodes
     * @param mappings Map of Unique Id -> List of taxonomy nodes Ids
     * @return this
     */
	
	public function addTaxonomyMappings(array $mappings/*Map<String, List<String>>*/){
		
		foreach ($mappings as $key=>$value) {
			$this->addTaxonomyMapping($key, $value);
		}
		return $this;
				
	}
	
	private function zipIt($fileArchive, $file){
		$ziph = new ZipArchive();
		try{
			if(file_exists($fileArchive)){
				if($ziph->open($fileArchive,ZIPARCHIVE::CHECKCONS) !== TRUE){
					$error = "Unable to open $fileArchive";
				}
			}
			else{
				if($ziph->open($fileArchive,ZIPARCHIVE::CM_PKWARE_IMPLODE) !== TRUE){
					$error = "Could not Create $fileArchive";
				}
			}
			
			if(isset($error)){
				return $error;
			}
			
			if(!$ziph->addFile($file)){
				$error = "error archiving $file in $fileArchive";
			}
			
		}catch (Exception $e){
			return $e->getMessage();
		}
		$ziph->close();
		return TRUE;
		
	}
	
	public function push($isFullImport){
		$fileArchive = $this->siteKey.".zip";
		$doc = new FeedFile($this->_fields, array_values($this->_addedDocs), array_values($this->_updatedDocs), $this->_deletedDocs, $this->_taxonomyNodes, $this->_taxonomyMappings).getDoc();
		try{
			$file = $this->siteKey.".json";
			file_put_contents($file,json_encode($doc));
			$errors = $this->zipIt($fileArchive, $file);
			if($errors !== TRUE){
				throw new FeedUploadException($errors);
			}
			echo "Stored at: ".$fileArchive;
			$url = $this->getFeedUrl();
			if($isFullImport){
				$url .= "?fullimport=true";
			}
			
			$request = curl_init($url);
			curl_setopt($request, CURLOPT_POST, true);
			curl_setopt(
			$request,
			CURLOPT_POSTFIELDS,
			array(
      'file' => '@' . realpath($fileArchive)
			));
			curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($request);
			if(curl_errno($request)){
				$errors = curl_error($request);
			}
			$info = curl_getinfo($request);
			curl_close($request);
			if(isset($errors) && !is_null($errors) && $errors!=""){
				throw new FeedUploadException($errors);
			}
			if($info['http_code']!=200){
				throw  new FeedUploadException($response);
			}
			return new FeedResponse(json_decode($response,TRUE));		
		}catch (Exception $e){
			throw new FeedUploadException($e->getMessage());
						
		}
		
	}

	
	
	
	
	
	
}