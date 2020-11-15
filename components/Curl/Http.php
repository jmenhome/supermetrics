<?php

namespace Curl;

use Base\Component;

/**
 * Class Http
 *
 * Simple curl wrapper.
 * It is good to write api integrations using it.
 *
 * @package Curl
 */
class Http extends Component
{
	public $timeout=40;
	public $verbose=false;

	protected $postJson=true;

	const GET=1;
	const POST=2;

	private $ch = null;

	public $headers = [];

	public function __destruct()
	{
		if ($this->ch)
			curl_close($this->ch);
	}

	/**
	 * @param integer $method
	 * @param string $url
	 * @param array $params
	 * @param array $curlParams
	 * @param array $headers
	 * @return array
	 * @throws CurlTimeoutException
	 * @throws \Exception
	 */
	protected function request($method, $url, $params=[], $curlParams=[], $headers=[])
	{
		// our curl handle (initialize if required)
		if (is_null($this->ch)) {
			$this->ch = curl_init();
		} else {
			curl_reset($this->ch);
		}

		$cParams=[
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_USERAGENT=>'Mozilla/4.0 (compatible; PHP client; ' . php_uname('s') . '; PHP/' . phpversion() . ')',
			CURLOPT_SSL_VERIFYPEER=>true,
			CURLOPT_SSL_VERIFYHOST=>2,
			CURLOPT_CONNECTTIMEOUT=>$this->timeout,
			CURLOPT_TIMEOUT=>$this->timeout,
			CURLOPT_VERBOSE=>$this->verbose,
			CURLOPT_HEADER=>1,
		];

		foreach ($curlParams as $k=>$v) {
			$cParams[$k]=$v;
		}

		if (self::POST==$method) {
			$cParams[CURLOPT_POST] = true;

			if (true==$this->postJson) {
				$headers['content-type'] = 'Content-Type: application/json';
				$cParams[CURLOPT_POSTFIELDS] = json_encode($params);
			}
			else {
				$cParams[CURLOPT_POSTFIELDS] = http_build_query($params);
			}
		}
		elseif (self::GET==$method&&count($params)>0) {
			$cParams[CURLOPT_POST] = false;
			$url .= '?' . http_build_query($params);
		}

		$cParams[CURLOPT_URL]=$url;
		$cParams[CURLOPT_HTTPHEADER]=$headers;

		curl_setopt_array($this->ch, $cParams);

		$ret = curl_exec($this->ch);

		if ($ret === false) {
			$errno = curl_errno($this->ch);
			if (CURLE_OPERATION_TIMEOUTED == $errno)
				throw new CurlTimeoutException('Operation timeout');
			else
				throw new CurlErrorException('Could not get reply, code:' . $errno . ', description:' . curl_error($this->ch).', url: '.$url.', params: '.var_export($params, true));
		}

		$header_size = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
		$header = trim(substr($ret, 0, $header_size));
		$body = substr($ret, $header_size);
		unset($ret);

		$this->headers = [];
		foreach (explode("\n", $header) as $v) {
			$p = strpos($v, ':');
			if ($p!==false)
				$this->headers[strtolower(substr($v, 0, $p))] = trim(substr($v, $p+1));
			else
				$this->headers[] = trim($v);
		}

		$code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
		if (403==$code)
			throw new CurlForbiddenException('Request forbidden, url: '.$url.', params: '.var_export($params, true).', response:'.$body, 403);

		//parse body JSON
		$formatted = @json_decode($body, true);

		if (false===$formatted)
			throw new CurlWrongJsonException('Cannot parse JSON, url: '.$url.', params: '.var_export($params, true).', response:'.$body);

		return $formatted;
	}
}