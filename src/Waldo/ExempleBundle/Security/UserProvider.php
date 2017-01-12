<?php

namespace Waldo\ExempleBundle\Security;

use Waldo\OpenIdConnect\RelyingPartyBundle\Security\Core\User\OICUser;
use Waldo\OpenIdConnect\RelyingPartyBundle\Security\Core\User\OICUserProvider;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * User Provider.
 *
 * @author Gilles Gallais <contact@gillesgallais.com>
 */
class UserProvider extends OICUserProvider
{
    private $roles = [];
    private $session;
    private $sessionKeyName = "waldo.oic.user.stored";

    /**
     * {@inheritDoc}
     */
    public function __construct(Session $session, array $roles)
    {
        $this->roles = $roles;
        $this->session = $session;

        parent::__construct($session);
    }

    /**
     * Recreate a user with correct roles.
     *
     * @param string $username
     *
     * @return OICUser
     */
    public function loadUserByUsername($username)
    {
        if($this->session->has($this->sessionKeyName . $username)) {
            $originalUser = $this->session->get($this->sessionKeyName . $username);

            $user = new OICUser($originalUser->getUsername(), $this->getUserRoles($originalUser), [
                "sub" => $originalUser->sub,
                "name" => $originalUser->name,
                "preferred_username" => $originalUser->preferred_username,
                "email" => $originalUser->email,
                "email_verified" => $originalUser->email_verified,
                "address" => $originalUser->address,
            ]);

            if($user->getUsername() === $username) {
                return $user;
            }
        }

        throw new UsernameNotFoundException(sprintf('Unable to find an active User object identified by "%s".', $username));
    }

    /**
     * Retrieves user roles.
     *
     * @param OICUser $user
     *
     * @return array
     */
     private function getUserRoles(OICUser $user)
     {
         $roles = $this->roles['users'][$user->getUsername()];
         if($roles) {
             return $roles;
         } else {
             return $this->roles['default'];
         }
     }
}
