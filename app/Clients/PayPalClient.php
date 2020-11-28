<?php
namespace App\Clients;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
class PayPalClient
{
    /**
     * Returns PayPal HTTP context instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public function context()
    {
        return new ApiContext($this->credentials());
    }
    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     *
     * Paste your client_id and client secret as below
     */
    protected function credentials()
    {
        $clientId     = 'Adv3jhEKut2LArUJsrYLivAIyXznwWEgWG2Q2dpXUxVUbDwo40sqxZtSX6fdUVVxWb2I25qB0deSRdll';
        $clientSecret = 'EOqYgWNYRjmHw2a0mKBD6XyerOFdg-1gwujR8MdtldBJaDH3uDX4YmOaJarvlaP5fP1tNyu5bpuOJB2x';
        return new OAuthTokenCredential($clientId, $clientSecret);
    }
}