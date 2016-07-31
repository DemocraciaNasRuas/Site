<?php

namespace App\Lib;

class DemocraciaNasRuas
{

	private   $endpoint = 'http://api.democracianasruas.com.br/protest';
	private   $body		= [];	
	protected $curl     = null;
	protected $method   = null;
	
	public function __construct($input)
	{        
		$this->body = [
			'protest' => [
				'title' => $input['title'],
				'description' => $input['description'],
				'date' => $input['date'],
				'street' => $input['street'],
				'number' => $input['number'],
				'neighborhood' => $input['neighborhood'],
				'postal_code' => $input['postal_code'],
				'complement' => $input['complement'],
				'reference' => $input['reference'],
				'state' => $input['state'],
				'city' => $input['city'],
				'url' => $input['url'],
				'image' => $input['image'],
				'url' => 'temp'
			],
			'organizer_protest' => [
				'title' => $input['title'],
				'description' => $input['description'],	
				'facebook' => $input['facebook'],
				'twitter' => $input['twitter'],
				'site' => $input['site'],
				'email' => $input['email'],
				'phone1' => $input['phone1'],
				'phone2' => $input['phone2']
			]
		];

		$this->valid();
	}

	public function valid()
	{
		return true;
	}

	public function get()
	{
		return json_decode($this->run());
	}
	
	public function post()
	{
		$this->method = "POST";

		return json_decode($this->run());
	}

	public function run()
	{
		$this->curl = curl_init();

		curl_setopt($this->curl, CURLOPT_URL, $this->endpoint);   
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);

		if ($this->method == "POST")
		{
			curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($this->curl, CURLOPT_POST, true);
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->body));
		}
		
		$response = curl_exec($this->curl);
		
		curl_close($this->curl);
		
		return $response;
	}

}