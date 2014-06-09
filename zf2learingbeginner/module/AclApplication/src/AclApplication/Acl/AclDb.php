<?php
/**
 * Zend Framework 2 Authorization Module Table gataway
*/

namespace AclApplication\Acl;

use Zend\Permissions\Acl\Acl as ZendAcl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

/**
 * Class to handle Acl
 *
 * This class is for loading ACL defined in a database
 *
 */
class AclDb extends ZendAcl {
    /**
     * Default Role
     */
    const DEFAULT_ROLE = 'guest';

    /**
     * Constructor
     *
     * @param $entityManager Inject Doctrine's entity manager to load ACL from Database
     * @return void
     */
    public function __construct($sm)
    {
        $serviceTableGateway= $sm->get('serviceTableGateway');
    	$roles = $serviceTableGateway->get('role')->findAll();
        $resources = $entityManager->getRepository('resource')->findAll();
        $privileges = $entityManager->getRepository('privilege')->findAll();
        
        $this->_addRoles($roles)
             ->_addAclRules($resources, $privileges);
    }

    /**
     * Adds Roles to ACL
     *
     * @param array $roles
     * @return CsnAuthorization\Acl\AclDb
     */
    protected function _addRoles($roles)
    {
        foreach($roles as $role) {
            if (!$this->hasRole($role->getName())) {
                $parents = $role->getParents()->toArray();
                $parentNames = array();
                foreach($parents as $parent) {
                    $parentNames[] = $parent->getName();
                }
                $this->addRole(new Role($role->getName()), $parentNames);
            }
        }

        return $this;
    }

    /**
     * Adds Resources/privileges to ACL
     *
     * @param $resources
     * @param $privileges
     * @return User\Acl
     * @throws \Exception
     */
    protected function _addAclRules($resources, $privileges)
    {
        foreach ($resources as $resource) {
            if (!$this->hasResource($resource->getName())) {
                $this->addResource(new Resource($resource->getName()));
            }
        }
        
        foreach ($privileges as $privilege) {
            if($privilege->getPermissionAllow()) {
                $this->allow($privilege->getRole()->getName(), $privilege->getResource()->getName(), $privilege->getName());
            } else {
                $this->deny($privilege->getRole()->getName(), $privilege->getResource()->getName(), $privilege->getName());
            }
        }

        return $this;
    }
}
