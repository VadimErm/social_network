<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 03.06.17
 * Time: 19:43
 */

namespace api\filters\auth;


class HttpBearerAuth extends \yii\filters\auth\AuthMethod
{
    /**
     * @var string the HTTP authentication realm
     */
    public $realm = 'api';


    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');

        // Added following lines to support fastcgi issue.
        // To support this, must update .htaccess as below:
        //  # Authorization Headers
        //  RewriteCond %{HTTP:Authorization} .
        //  RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

        if($authHeader == null && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) && $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] != "") {
            $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $identity = $user->loginByAccessToken($matches[1], get_class($this));
            if ($identity === null) {
                $this->handleFailure($response);
            }
            return $identity;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function challenge($response)
    {
        $response->getHeaders()->set('WWW-Authenticate', "Bearer realm=\"{$this->realm}\"");
    }
}