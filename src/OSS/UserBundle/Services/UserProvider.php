<?php

namespace OSS\UserBundle\Services;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use OSS\CoreBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider extends FOSUBUserProvider
{
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();
        
        $service = $response->getResourceOwner()->getName();
        
        $setter = 'set' . ucfirst($service);
        $setterId = $setter . 'Id';
        $setterToken = $setter . 'AccessToken';
        
        // disconnect previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setterId(null);
            $previousUser->$setterToken(null);
            $this->userManager->updateUser($previousUser);
        }
        
        // connect current user
        $user->$setterId($username);
        $user->$setterToken($response->getAccessToken());
        
        $this->userManager->updateUser($user);
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $id = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $id));

        // user is registering
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($service);
            $setterId = $setter . 'Id';
            $setterToken = $setter . 'AccessToken';
            $password = $service . 'Password';

            /** @var User $user */
            $user = $this->userManager->createUser();
            $user->$setterId($id);
            $user->$setterToken($response->getAccessToken());

            $user->setUsername($id);
            $user->setEmail($response->getEmail() !== null ? $response->getEmail() : $id . '@nomail.com');
            $user->setPlainPassword($id);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);

            return $user;
        }

        // user exists
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        // update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }
}
