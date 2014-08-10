<?php
/**
 * @author suprit
 * Date: Aug 8, 2014
 * Time: 1:33:56 PM
 * ConfigException.php
 */
class ConfigException extends Exception{
	public function __construct($message){
		parent::__construct($message);
	}
}