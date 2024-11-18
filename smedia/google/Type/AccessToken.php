<?php

namespace sMedia\Google\Type;
/*
 * AccessToken structure
 **********************************************************************************/

class AccessToken
{
	public $Token, $CreatedAt, $ExpiresIn, $Provider, $RefreshToken;

	/**
	 * Constructs a new instance.
	 *
	 * @param      <type>  $token          The token
	 * @param      <type>  $refresh_token  The refresh token
	 * @param      <type>  $created_at     The created at
	 * @param      <type>  $expired_in     The expired in
	 * @param      <type>  $provider       The provider
	 */
	public function __construct($token, $refresh_token, $created_at, $expired_in, $provider)
	{
		$this->Token        = $token;
		$this->RefreshToken = $refresh_token;
		$this->CreatedAt    = $created_at;
		$this->ExpiresIn    = $expired_in;
		$this->Provider     = $provider;
	}
}
