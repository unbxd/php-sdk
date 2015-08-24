<?php
/**
 * @author suprit
 * Date: Aug 11, 2014
 * Time: 10:44:15 AM
 * FeedClientTest.php
 */

include_once (dirname(__FILE__).'/../src/main/Unbxd.php');
include_once (dirname(__FILE__).'/../src/feed/response/FeedResponse.php');
include_once (dirname(__FILE__).'/../src/feed/FeedProduct.php');
include_once (dirname(__FILE__).'/../src/feed/TaxonomyNode.php');



class FeedClientTest extends PHPUnit_Framework_TestCase{
	
	protected function setUp(){
		Unbxd::configure("sample-u1438008774548", "d9db733454a3fe3b16a3df9dc3ba4b33", "2f7be98856816b96ccc93353db5cbd51");
	}
	
	public function test_product_upload(){
		$product = array();
		$product["title"]="phodu joote";
		$product["some-field"] = "test-field-value";
		$product["brand"] = "Adidas";
		$product["category"] = array("Sports Shoes");
		$product["price"] = 1100;
		
		$variant = array("gender"=>"male");
		$response = Unbxd::getFeedClient()
					->addSchema("some-field",new DataType(DataType::TEXT))
					->addSchema("genderAssociated",new DataType(DataType::TEXT),TRUE,TRUE)
					->addProduct(new FeedProduct("testsku13", $product))
					->addProduct(new FeedProduct("testsku14", $product))
					->addVariant("testsku13",$variant)
					->push(FALSE);
		$this->assertNotNull($response);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertNotNull($response->getMessage());
		$this->assertNotNull($response->getUploadID());
		$this->assertEquals(0,count($response->getUnknownSchemaFields()));
		$this->assertEquals(0,count($response->getFieldErrors()));
		
		$product  = array();
		$product["title"] = "test-product-update";
		$response = Unbxd::getFeedClient()
					->updateProduct(new FeedProduct("testsku", $product))
					->push(FALSE);
		$this->assertNotNull($response);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertNotNull($response->getMessage());
		$this->assertNotNull($response->getUploadID());
		$this->assertEquals(0,count($response->getUnknownSchemaFields()));
		$this->assertEquals(0,count($response->getFieldErrors()));
	}
	
	public function test_product_upload_should_fail_unknown_fields(){
		
		$product = array();
		$product["title"]="phodu joote";
		$product["some-unknown-field"] = "test-field-value";
		$product["brand"] = "Adidas";
		$product["category"] = array("Sports Shoes");
		$product["price"] = 1100;
		
		$response = Unbxd::getFeedClient()
					->addProduct(new FeedProduct("testsku3",$product))
					->push(FALSE);
		$this->assertNotNull($response);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertNotNull($response->getMessage());
		$this->assertNotNull($response->getUploadID());
		$this->assertEquals(0,count($response->getUnknownSchemaFields()));
		$this->assertEquals(0,count($response->getFieldErrors()));
		
		
	}
	
	public function test_taxonomy_upload(){
		$response = Unbxd::getFeedClient()
					->addTaxonomyNode(new TaxonomyNode("1", "Men"))
					->addTaxonomyNode(new TaxonomyNode("2", "Shoes", array("1")))
					->addTaxonomyMapping("testsku2",array("1","2"))
					->push(FALSE);
		$this->assertNotNull($response);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertNotNull($response->getMessage());
		$this->assertNotNull($response->getUploadID());
		$this->assertEquals(0,count($response->getUnknownSchemaFields()));
		$this->assertEquals(0,count($response->getFieldErrors()));
	}
	
}
