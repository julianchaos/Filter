<?php

/**
 * Description of Filter
 *
 * @author julianandrade
 */
class Filter {
	private $method;
	
	public function __construct($method = "POST") {
		$this->setMethod($method);
	}
	public function setMethod($method)
	{
		switch ($method) {
			case 'POST':
				$this->method = INPUT_POST;
				break;
			case 'GET':
				$this->method = INPUT_GET;
				break;
		}
	}
	public function getMethod()
	{
		return $this->method;
	}

	
	public function sanitizeString($variable)
	{
		$filter = FILTER_SANITIZE_STRING;
		return $this->filter_input($variable, $filter);
	}
	public function sanitizeInteger($variable)
	{
		$filter = FILTER_SANITIZE_NUMBER_INT;
		return $this->filter_input($variable, $filter);
	}
	
	public function validateMoney($variable)
	{
		$variable = str_replace(",", ".", $this->filter_input($variable, FILTER_DEFAULT));
		$filter = FILTER_VALIDATE_FLOAT;
		return number_format($this->filter_var($variable, $filter), 2, '.', '');
	}
	public function validateFloat($variable)
	{
		$variable = str_replace(",", ".", $this->filter_input($variable, FILTER_DEFAULT));
		$filter = FILTER_VALIDATE_FLOAT;
		return $this->filter_var($variable, $filter);
	}
	public function validateBoolean($variable, $returnAsInteger = false)
	{
		$filter = FILTER_VALIDATE_BOOLEAN;
		$filteredInput = $this->filter_input($variable, $filter);
		
		$response = $filteredInput;
		if($returnAsInteger && !is_null($filteredInput))
		{
			$response = (int) $filteredInput;
		}
		return $response;
	}
	public function validateInteger($variable)
	{
		$filter = FILTER_VALIDATE_INT;
		return $this->filter_input($variable, $filter);
	}
	public function validateEmail($variable)
	{
		$filter = FILTER_VALIDATE_EMAIL;
		return $this->filter_input($variable, $filter);
	}
	
	private function filter_input($variable, $filter)
	{
		$type = $this->getMethod();
		return filter_input($type, $variable, $filter);
		
	}
	private function filter_var($variable, $filter)
	{
		return filter_var($variable, $filter);
	}
	
}
