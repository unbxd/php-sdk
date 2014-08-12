<?php
/**
 * @author suprit
 * Date: Aug 6, 2014
 * Time: 1:49:58 PM
 * FeedUploadException.php
 */
class FeedUploadException extends Exception {
	
	public function __construct($msg){
		parent::__construct($msg);
		
	}
}