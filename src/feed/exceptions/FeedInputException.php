<?php
/**
 * @author suprit
 * Date: Aug 6, 2014
 * Time: 2:11:40 PM
 * FeedInputException.php
 */
class FeedInputException extends Exception {
	public function __construct($message){
		parent::__construct($message);
	}
}