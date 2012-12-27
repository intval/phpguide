<?php
/**
23/11/12 16:00 sasha
 */
class LoginExternalController extends PHPGController
{

    const returnUrl = 'returnUrl';

    /**
     * Fired when the user decides to login with external auth provider.
     */
    public function actionLogin($service)
    {
        $returnUrl = Yii::app()->request->getQuery('backto');
        $this->authWithExternalProvider($service, $returnUrl);
    }


    /**
     * Attempts to authenticate the user using external oAuth provider
     * @param string $providerName
     * @param string $returnUrl
     */
    private function authWithExternalProvider($providerName, $returnUrl)
    {
        /** @var IAuthService $authProvider  */
        $authProvider = Yii::app()->eauth->getIdentity($providerName);
        $authProvider->setRedirectUrl(bu($returnUrl,true));
        $authProvider->setCancelUrl(bu($returnUrl, true));

        if($authProvider->authenticate())
            $this->externalAuthSucceeded($authProvider);
        else
            $this->externalAuthFailed($authProvider);
    }



    /**
     * Called on external Authentication success
     * @param IAuthService $authProvider
     */
    private function externalAuthSucceeded(IAuthService $authProvider)
    {
        $identity = new ServiceUserIdentity($authProvider) ;

        // Did someone use this external ID in the past?
        if($identity ->isKnownUser())
        {
            Yii::app()->user->login($identity);
            $authProvider->redirect();
        }
        // external auth succeeded, but we don't know whom do this external ID belongs to
        else
        {
            $authInfo = $authProvider->getAttributes();
            $this->rememberExternalInfo($authProvider, $authInfo);

            $return_location = Yii::app()->session[self::returnUrl];
            if(!$return_location)
                $return_location = Yii::app()->request->getQuery('redir', Yii::app()->homeUrl );

            $this->addscripts('login');
            $this->render('chooseNameAfterExternalLogin',
                [
                    'provider' => $authProvider->getServiceName(),
                    'name' => $authInfo['name'],
                    'return_location' => $return_location
                ]
            );

        }
    }

    private function rememberExternalInfo(IAuthService $authProvider, array $authInfo)
    {
        $storedInfo = Yii::app()->session['externalAuth'];
        $providerName = $authProvider->getServiceName();

        if (null === $storedInfo)
            $storedInfo = array();

        $storedInfo[$providerName] = $authInfo;
        Yii::app()->session['externalAuth'] = $storedInfo;
    }


    private function externalAuthFailed(IAuthService $serviceAuthenticator)
    {
        Yii::app()->user->setFlash('externalAuthFail', 'הזדהות באמצעות ' . $serviceAuthenticator->getServiceName() . ' נכשלה');
        $this->redirect(array('login/index'));
    }

}
