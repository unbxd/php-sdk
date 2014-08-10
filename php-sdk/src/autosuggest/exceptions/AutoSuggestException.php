<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 12:01:53 PM
 * AutoSuggestException.php
 */
class AutoSuggestException extends Exception{
	public function __construct($message){
		parent::__construct($message);
	}
	
	/*public function __construct(Exception $e){
		parent::__construct($e->getMessage());
	}*/
}