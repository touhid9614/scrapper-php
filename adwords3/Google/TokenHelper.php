<?php

require_once 'Types.php';

/**
 * This class describes a token helper.
 */
class TokenHelper
{
    const ResponseTypeKey     = "response_type";
    const ClientIDKey         = "client_id";
    const ClientSecretKey     = "client_secret";
    const CodeKey             = "code";
    const ScopeKey            = "scope";
    const StateKey            = "state";
    const RedirectURIKey      = "redirect_uri";
    const AccessTokenKey      = "access_token";
    const RefreshTokenKey     = "refresh_token";
    const GrantTypeKey        = "grant_type";
    const GrantTypeAuth       = "authorization_code";
    const GrantTypeRefresh    = "refresh_token";
    const AccessTypeKey       = 'access_type';
    const AccessTypeOffline   = 'offline';
    const ResponseTypeCode    = 'code';
    const ApprovalPromptKey   = 'approval_prompt';
    const ApprovalPromptForce = 'force';

    // Auth request URL
    const code_uri = 'https://accounts.google.com/o/oauth2/auth';

    // URL to get access token from
    const access_token_uri = 'https://accounts.google.com/o/oauth2/token';

    // token check url
    const token_check_uri = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=';

    /*
     * @summary         : Get auth request url for the given provider
     * @param provider  : An instance of ProviderConfig class. Contains the AppId, AppSecret
     *                    and redirectUri for a provider
     * @return          : Authorization request url for the provider
     *****************************************************************************************/
    public function GetRequestURL(array $config)
    {
        //Create a new random state
        $state = $this->NewState("gp");

        $url = self::code_uri . "?" . self::ResponseTypeKey . "=" . self::ResponseTypeCode . "&"
        . self::ClientIDKey . "=" . $config['client_id'] . "&"
        . self::RedirectURIKey . "=" . urlencode($config['redirect_uri']) . "&"
        . self::ScopeKey . "=" . urlencode($config['scope']) . "&"
        . self::StateKey . "=" . $state . "&"
        . self::AccessTypeKey . "=" . self::AccessTypeOffline . "&"
        . self::ApprovalPromptKey . "=" . self::ApprovalPromptForce;
        return $url;
    }

    /*
     * @summary         : Get access token using auth response
     * @param provider  : An instance of ProviderConfig class. Contains the AppId, AppSecret
     *                    and redirectUri for a provider
     * @return          : An instance of AccessToken class containing the access_token
     *                    aquired through the oAuth process
     *****************************************************************************************/
    public function GetAccessToken(array $config, $print_log = false, $logfile = null)
    {
        $code = $this->ExtractCode();

        if (!$code) {
            $msg = "No code detected\n";

            if ($print_log) {
                echo $msg;
            }

            if ($logfile) {
                file_put_contents($logfile, time() . " $msg", FILE_APPEND);
            }

            return null;
        }

        $post_fields = array(
            self::CodeKey         => $code,
            self::ClientIDKey     => $config['client_id'],
            self::ClientSecretKey => $config['client_secret'],
            self::RedirectURIKey  => $config['redirect_uri'],
            self::GrantTypeKey    => self::GrantTypeAuth,
        );

        $response = $this->HttpPost(self::access_token_uri, $post_fields);

        if (!$response) {
            $msg = "No HTTP response detected.\n";

            if ($print_log) {
                echo $msg;
            }

            if ($logfile) {
                file_put_contents($logfile, time() . " $msg", FILE_APPEND);
            }

            return null;
        }

        $access_token = json_decode($response);

        if (isset($access_token->error)) {
            $msg = "There was an error: {$access_token->error}\n";

            if ($print_log) {
                echo $msg;
            }

            if ($logfile) {
                file_put_contents($logfile, time() . " $msg", FILE_APPEND);
            }

            return null;
        }

        try {
            $renewedAccessToken = new AccessToken($access_token->access_token,
                @$access_token->refresh_token, time(), $access_token->expires_in, Providers::Google);
        } catch (Exception $ex) {
            if ($logfile) {
                file_put_contents($logfile, time() . " New access token creation failed.", FILE_APPEND);
            }
        }

        return $renewedAccessToken;
    }

    /*
     * @summary             : Create a new access token from a given access token
     * @param provider      : An instance of ProviderConfig class. Contains the AppId, AppSecret
     *                        and redirectUri for a provider
     * @param accessToken    : An instance of AccessToken class
     * @return        : new accessToken if refress is possible otherwise false
     *****************************************************************************************/
    public function RefreshAccessToken(array $config, AccessToken $accessToken)
    {
        $refresh_token = $accessToken->RefreshToken;

        // must have a refresh token
        if (!$refresh_token) {
            return false;
        }

        $post_fields = array(
            self::GrantTypeKey    => self::GrantTypeRefresh,
            self::ClientIDKey     => $config['client_id'],
            self::ClientSecretKey => $config['client_secret'],
            self::RefreshTokenKey => $refresh_token,
        );

        $response = $this->HttpPost(self::access_token_uri, $post_fields);

        if (!$response) {
            return false;
        }

        $access_token = json_decode($response);

        if (isset($access_token->error)) {
            return false;
        }

        try {
            $renewedAccessToken = new AccessToken($access_token->access_token, isset($access_token->refresh_token) ? $access_token->refresh_token : $refresh_token, time(), $access_token->expires_in, Providers::Google);
        } catch (Exception $ex) {
            if ($logfile) {
                file_put_contents($logfile, time() . " New access token creation failed.", FILE_APPEND);
            }
        }

        return $renewedAccessToken;
    }

    /**
     * { function_description }
     *
     * @param      AccessToken  $accessToken  The access token
     *
     * @return     boolean      ( description_of_the_return_value )
     */
    public function CheckAccessToken(AccessToken $accessToken)
    {
        $url = self::token_check_uri . $accessToken->Token;

        $response = $this->HttpGet($url);

        if ($response) {
            $permits = json_decode($response);

            if (isset($permits->error)) {
                return false;
            } else {
                if (isset($permits->expires_in)) {
                    if ($permits->expires_in > 60) {
                        return true;
                    } else {
                        return false;
                    }

                } else {
                    return false;
                }
            }
        }

        return false;
    }

    /*
     * @summary    : Make http get request using CURL
     * @param url    : The url to make the GET request to
     * @return    : string data obtained through the get request
     **************************************************************************/
    protected function HttpGet($url)
    {
        // Initialize curl request
        $curl = curl_init();

        // configure curl
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        // execute curl request
        $contents = curl_exec($curl);
        // check error
        //$err  = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        //close curl request
        curl_close($curl);

        //return data if no error
        if ($contents) {
            return $contents;
        } else {
            return false;
        }
    }

    /*
     * @summary        : Make http post request using CURL
     * @param url    : The url to make the request to
     * @param fields: array of key value pears (data is sent as application/x-www-form-urlencoded)
     * @return        : string data obtained through the post request
     ****************************************************************************************************/
    protected function HttpPost($url, $fields)
    {
        // Initialize curl request
        $curl = curl_init();

        // url-ify the data for the POST
        $fields_string = '';
        foreach ($fields as $key => $value) {$fields_string .= $key . '=' . $value . '&';}
        rtrim($fields_string, '&');

        // set the url, number of POST vars, POST data
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, count($fields));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

        // execute curl request
        $contents = curl_exec($curl);
        // check error
        // $err  = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // close curl request
        curl_close($curl);

        // return data if no error
        if ($contents) {
            return $contents;
        } else {
            return false;
        }
    }

    /*
     * @summary    : Returns the last generated state for the current session
     *          Require to varify the state passed for the Authorization process
     *          for protection againist XSR attack
     * @return    : last generated state variable
     ****************************************************************************************/
    protected function LastState()
    {
        return $_SESSION['auth_state'];
    }

    /*
     * @summary             : Generate a new random state value
     *               also store it in a session variable for the current session
     * @param providerInit    : The provider initial to be used to generate the state
     * @return        : new random state
     ****************************************************************************************/
    protected function NewState($providerInit)
    {
        $state                  = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);
        $_SESSION['auth_state'] = $providerInit . '-' . $state;
        return $_SESSION['auth_state'];
    }

    /*
     * Shortcut of $_GET['code']
     ************************************************************************/

    /**
     * { function_description }
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    protected function ExtractCode()
    {
        if (isset($_GET['code'])) {
            return $_GET['code'];
        } else {
            return false;
        }
    }

    /*
     * Shortcut of $_GET['error_description']
     ************************************************************************/

    /**
     * { function_description }
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    protected function ExtractError()
    {
        if (isset($_GET['error_description'])) {
            return $_GET['error_description'];
        } else {
            return false;
        }
    }

    /*
     * Shortcut of $_GET['state']
     ************************************************************************/

    /**
     * { function_description }
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    protected function ExtractState()
    {
        if (isset($_GET['state'])) {
            return $_GET['state'];
        } else {
            return false;
        }
    }
}
