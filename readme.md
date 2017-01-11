# Open Id Connect

## Surcharge du userProvider
La surcharge du service userProvider ("waldo_oic_rp.user.provider") se décrite dans le fichier *\Waldo\ExempleBundle\Resources\config\services.xml*

La méthode *loadUserByUsername* de la class *\Waldo\OpenIdConnect\RelyingPartyBundle\Security\Core\User\OICUserProvider* retourne l'utilisateur authenitifié, sur la base du sub.
Elle est surchargée dans la class *\Waldo\ExempleBundle\Security\UserProvider*, afin de créer une nouvelle instance de *OICUser*, en incluant les rôles de l'utilisateur.

## Configuration

```yaml
#app/config/security.yml
parameters:
    roles:
        users:
            90342.ASDFJWFA: ['ROLE_OIC_USER', 'ROLE_APPLICATION_A']
            01921.FLANRJQW: ['ROLE_OIC_USER', 'ROLE_ADMIN']
            01922.FLANTEST: []
        default: ['ROLE_OIC_USER']
```

**parameters.roles.users** : Rôles à appliquer pour chaque sub

**parameters.roles.default** : Liste des rôles à appliquer par défaut

## Hiérarchie des roles

```yaml
#app/config/security.yml
security:
    role_hierarchy:
        ROLE_ADMIN: ['ROLE_APPLICATION_A', 'ROLE_APPLICATION_B']
```

[Pour en soiv plus](http://symfony.com/doc/current/security.html#security-role-hierarchy)
