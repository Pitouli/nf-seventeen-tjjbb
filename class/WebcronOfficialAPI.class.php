<?php
#
# webcronAPI 
# version 0.1.1
# This is class has been written to help members of webcron.org to use the API.
# The latest version can be found at http://www.webcron.org/downloads/webcronAPI.zip
# Improvements, bugs or modifications can be send to info@webcron.org
#
# by Bastiaan Fronik @ Webcron.org
# <http://www.webcron.org>
#
#
# Copyright (c) 2010-2011, Webcron.org
# All rights reserved. 
#
# BSD License - http://www.opensource.org/licenses/bsd-license.php
# 
# Redistribution and use in source and binary forms, with or without modification, are permitted 
# provided that the following conditions are met:
#
# Redistributions of source code must retain the above copyright notice, this list of conditions 
# and the following disclaimer.
#
# Redistributions in binary form must reproduce the above copyright notice, this list of conditions 
# and the following disclaimer in the documentation and/or other materials provided with the distribution.
#
# Neither the name of Webcron.org nor the names of its contributors may be used to endorse or promote products 
# derived from this software without specific prior written permission.
#
# THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED 
# WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A 
# PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR 
# ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT 
# LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
# INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR 
# TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF 
# ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

class WebcronOfficialAPI
{
	// Your login and password to access the API
	// These can be found at https://www.webcron.org/component/option,com_webcron/task,api_key
	public $login;
	public $password;
	
	// set debug to 1 to see raw send and received data
	public $debug = 0;
	
	// uri of service
	public $uri = 'api.webcron.org';
	
	// whether to use a secure or non-secure connection
	public $ssl = 1;
	
	// package to use. these can be: 
	// curl (libcurl version 7.10.5 or greater)
	// pear_http (need PEAR::HTTP/Request package)
	public $package = 'curl';
	
	// timeout call
	public $timeout = 30;
	
	// contains returned status code
	public $response_code;
	
	// standard connection types used for guessing whether this is a POST or GET
	// Be sure you run the latest version of this class!
	public $type_mapping = array(
		'info' => 'GET',
		'time' => 'GET',
		'monitor.get' => 'GET',
		'monitor.add' => 'POST',
		'monitor.edit' => 'POST',
		'monitor.delete' => 'POST',
		'monitor.state' => 'GET',
		'monitor.contact.bind' => 'POST',
		'monitor.contact.edit' => 'POST',
		'monitor.contact.unbind' => 'POST',
		'cron.get' => 'GET',
		'cron.add' => 'POST',
		'cron.edit' => 'POST',
		'cron.delete' => 'GET',
		'cron.contact.bind' => 'POST',
		'cron.contact.edit' => 'POST',
		'cron.contact.unbind' => 'POST');
	
	// contains debug information
	public $debug_trace = array();
	
	// contains data to send to service
	public $data;
	
	// Your php version should be higher or equal to this value
	private $php_from_version = 5;
	
	// whether this is a GET or a POST request
	private $type;
	
	/**
	 *	Constructor, sets login and password, checks for php version and checks if cUrl or PEAR::HTTP_Request is available
	 */
	public function __construct($login = null, $password = null)
	{
		$this->login = $login;
		$this->password = $password;
		
		// check for php version
		if(phpversion() < $this->php_from_version) {
			trigger_error('Your php version should be >= ' . $this->php_from_version, E_USER_ERROR);
		}
		
		$this->check_package();
	}
	
	/**
	 *	Makes the actual call to the webcron services.
	 *	PARAM	$method	: string - the name of the method to caal (ex: 'info' or 'cron.get')
	 *	PARAM	$data	: array - array(name => value) pairs to send to service
	 *	PARAM	$type	: GET / POST - whether this should be a GET or a POST request
	 *					: NOTE: when empty, it will try to guess the type. be sure you run the latest available version for better guessing
	 *	RETURN			: array / false - will return any xml data returned by webcron or false if no html code 200
	 */
	public function call($method, $data = array(), $type = null)
	{
		$this->set_type($type, $method);
		$this->set_data($data);
		
		switch($this->package) {
		
			case 'curl':
				$res = $this->curl_call($method, $data);
				break;
				
			case 'pear_http':
				$res = $this->pear_http_call($method, $data);
				break;	
				
			default:
				trigger_error('Unknown package. ', E_USER_ERROR);
		}
		
		if(!$res) {
			$this->debug_trace('Connection error code',$this->response_code);
			$this->debug_trace('Received data','');
		} else {
			$this->debug_trace('Connection code',$this->response_code . ' (= OK)');
			$this->debug_trace('Received data','<pre>' . htmlspecialchars($res) . '</pre>');
		}

		$this->show_debug_trace();
		return $res;
	}
	
	/**
	 *	Makes a call using PEAR::HTTP_Request package
	 *	PARAM	$method	: string - name of method to call
	 *	PARAM	$data	: array - array(name => value) pairs to send to service
	 *	RETURN	string / false - data returned from service or false if nothing received
	 */
	private function pear_http_call($method, $data)
	{
		$url = ($this->ssl ? 'https://' : 'http://') . $this->uri . '/' . $method . ($this->type == 'GET' && !empty($this->data) ? '/' . $this->data : '');
		$this->debug_trace('Url called',$url);
		
		$hr = new HTTP_Request($url);
		$hr->setBasicAuth($this->login, $this->password);
		if($this->type == 'POST') {
			$hr->setMethod(HTTP_REQUEST_METHOD_POST);
			$hr->setBody($this->data);
		}
		
		if (!PEAR::isError($hr->sendRequest())) {
			$this->response_code = $hr->getResponseCode();
			$data = $hr->getResponseBody();
			return $data;
		} else {
			$this->response_code = $hr->getResponseCode();
			return false;
		}
	}
	
	/**
	 *	Makes a call using cURL package
	 *	PARAM	$method	: string - name of method to call
	 *	PARAM	$data	: array - array(name => value) pairs to send to service
	 *	RETURN	string / false - data returned from service or false if nothing received
	 */
	private function curl_call($method, $data)
	{
		$url = ($this->ssl ? 'https://' : 'http://') . $this->uri . '/' . $method . ($this->type == 'GET' && !empty($this->data) ? '/' . $this->data : '');
		$this->debug_trace('Url called',$url);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		if($this->type == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
		}
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_USERPWD, $this->login.':'.$this->password);
		$data = curl_exec($ch);
		$info = curl_getinfo($ch);
		$this->response_code = $info['http_code'];
		curl_close($ch);
		
		return ($this->response_code == 200 ? $data : false);
	}
	
	/**
	 *	Prepares POST or GET string
	 *	PARAM	$data	: array - array(name => value) pairs to send to service
	 */
	private function set_data($data)
	{
		if(!empty($data)) {
			$data = $this->data_encode($data);
			$sep = ($this->type == 'GET' ? '/' : '&');
			$is = ($this->type == 'GET' ? ':' : '=');
			$t = array();
			
			foreach($data AS $k => $v) {
				if(is_array($v)) {
					$t[] = $k . $is . implode(',',$v);
				} else {
					$t[] = $k . $is . $v;
				}
			}
			$this->data = implode($sep,$t);
			
		} else {
			$this->data = '';
		}
		
		$this->debug_trace('Request',$this->data);
		return;
	}

	/**
	 *	Shows debug information about call
	 *	Will show nothing when $debug is set to 0
	 */
	public function show_debug_trace()
	{
		if($this->debug) {
			echo '<div style="background-color:yellow; padding:6px;"><b>DEBUG ON:</b><br />';
			foreach($this->debug_trace AS $k => $t) {
				echo (is_numeric($k) ? '' : $k . ': ');
				if(is_array($t)) {
					echo '<pre>';
					print_r($t);
					echo '</pre><br />';
				} else {
					echo $t . '<br />';
				}
			}
			echo '</div>';
		}
		return;
	}
	
	/**
	 *	Adds data to debug window
	 */
	private function debug_trace($label,$string)
	{
		if($this->debug) {
			$this->debug_trace[$label] = $string;
		}
		return true;
	}
	
	/**
	 *	Encodes data to a transportable format
	 *	PARAM	$data	: array - array(name => value) pairs to send to service
	 *	RETURN			: array with encoded data
	 */
	private function data_encode($data)
	{
		foreach($data AS $k => $x) {
			if(is_array($x)) {
				$data[$k] = $this->data_encode($x);
			} else {
				$data[$k] = urlencode($x);
			}
		}
		return $data;
	}
	
	/**
	 *	Sets the type (GET or POST).
	 *	PARAM	$type	: GET / POST / NULL - if null, guesses the type
	 *	PARAM	$method	: string
	 */
	private function set_type($type, $method)
	{
		if($type == 'POST' || $type == 'GET') {
			$this->type = $type;
		} else {
			if(!empty($this->type_mapping[$method])) {
				$this->type = $this->type_mapping[$method];
			} else {
				$this->type = 'POST';
				trigger_error("Cannot guess type of connection... let's try a POST. Download latest version to get rid of this notice!", E_USER_NOTICE);
			}
		}
		
		$this->debug_trace('Connection type',$this->type);
		
		return;
	}
	
	/**
	 *	Check if package is available
	 *	Different packages can be found in comment above 'public $package'
	 */
	private function check_package()
	{
		if($this->package == 'curl') {
			function_exists('curl_init') or trigger_error('There is no cURLlib installed. use an other package instead.', E_USER_ERROR);
		} elseif($this->package == 'pear_http') {
			require_once 'HTTP/Request.php';
		} else {
			trigger_error('Unknown package used.', E_USER_ERROR);
		}
	}

}

?>