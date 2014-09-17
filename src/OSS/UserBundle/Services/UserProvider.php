<?php

namespace OSS\UserBundle\Services;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use OSS\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider extends FOSUBUserProvider
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param UserManagerInterface $userManager
     * @param EventDispatcherInterface $dispatcher
     * @param array $properties
     */
    public function __construct(UserManagerInterface $userManager, EventDispatcherInterface $dispatcher, array $properties)
    {
        $this->dispatcher = $dispatcher;
        parent::__construct($userManager, $properties);
    }

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

        return $this->isUserExisting($user) ? $this->initExistingUser($response) : $this->createUser($response, $id);
    }

    /**
     * @param UserInterface|null $user
     *
     * @return bool
     */
    private function isUserExisting($user)
    {
        return null !== $user;
    }

    /**
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     */
    private function initExistingUser(UserResponseInterface $response)
    {
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        // update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }

    /**
     * @param UserResponseInterface $response
     * @param int $id
     *
     * @return User
     */
    public function createUser(UserResponseInterface $response, $id)
    {
        $service = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($service);
        $setterId = $setter . 'Id';
        $setterToken = $setter . 'AccessToken';

        /** @var User $user */
        $user = $this->userManager->createUser();
        $user->$setterId($id);
        $user->$setterToken($response->getAccessToken());

        $user->setUsername($id);
        $user->setEmail($response->getEmail() !== null ? $response->getEmail() : $id . '@nomail.com');
        $user->setPlainPassword($id);
        $user->setEnabled(true);
        $this->userManager->updateUser($user);

        $this->dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, new Request(), new Response()));

        return $user;
    }
}
