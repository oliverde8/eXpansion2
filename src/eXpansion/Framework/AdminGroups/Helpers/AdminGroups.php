<?php

namespace eXpansion\Framework\AdminGroups\Helpers;

use eXpansion\Framework\AdminGroups\Exceptions\UnknownGroupException;
use eXpansion\Framework\AdminGroups\Services\AdminGroupConfiguration;
use eXpansion\Framework\Core\Model\UserGroups\Group;
use eXpansion\Framework\Core\Plugins\UserGroups\Factory;
use eXpansion\Framework\Core\Storage\Data\Player;

/**
 * Class AdminGroupConfiguration
 *
 * @package eXpansion\Bundle\AdminGroupConfiguration\Helpers;
 * @author oliver de Cramer <oliverde8@gmail.com>
 */
class AdminGroups
{
    /** @var  AdminGroupConfiguration */
    protected $adminGroupConfiguration;

    /** @var  Factory */
    protected $userGroupFactory;

    /**
     * GroupsPlugin constructor.
     *
     * @param AdminGroupConfiguration $adminGroupConfiguration
     * @param Factory $userGroupFactory
     */
    public function __construct(
        AdminGroupConfiguration $adminGroupConfiguration,
        Factory $userGroupFactory
    ) {
        $this->adminGroupConfiguration = $adminGroupConfiguration;
        $this->userGroupFactory = $userGroupFactory;
    }

    /**
     * Get list of all user groups.
     * Can be useful for creating group based GUI widgets.
     *
     * @return Group[]
     */
    public function getUserGroups()
    {
        $groups = [];
        foreach ($this->adminGroupConfiguration->getGroups() as $groupName) {
            $groups[] = $this->getUserGroup("$groupName");
        }

        return $groups;
    }

    /**
     * Get the group in which a user is.
     * This is useful for gui actions.
     *
     * @param string $login
     *
     * @return Group
     */
    public function getLoginUserGroups($login)
    {
        $groupName = $this->adminGroupConfiguration->getLoginGroupName($login);
        if (empty($groupName)) {
            $groupName = 'guest';
        }

        return $this->getUserGroup("$groupName");
    }

    /**
     * Get (or create a new) admin user group
     *
     * @param string $groupName
     *
     * @return Group
     */
    protected function getUserGroup($groupName)
    {
        $groupName = "admin:$groupName";

        $group = $this->userGroupFactory->getGroup($groupName);
        if (!$group) {
            $this->userGroupFactory->create($groupName);
            $group = $this->userGroupFactory->getGroup($groupName);
        }

        return $group;
    }

    /**
     * Checks if a login or player has a certain permission or not.
     *
     * @param string|Player $login      Login of the player to check for permission.
     * @param string $permission The permission to check for.
     *
     * @return bool
     */
    public function hasPermission($login, $permission)
    {
        if ($login instanceof Player) {
            $login = $login->getLogin();
        }

        return $this->adminGroupConfiguration->hasPermission($login, $permission);
    }

    /**
     * Check if a group has a certain permission or not.
     *
     * @param string $groupName  The name of the group to check permissions for.
     * @param string $permission The permission to check for.
     *
     * @return bool
     * @throws UnknownGroupException Thrown when group isn't an admin group.
     */
    public function hasGroupPermission($groupName, $permission)
    {

        if (strpos($groupName, 'admin:') === 0) {
          $groupName = str_replace("admin:", '', $groupName);
        }

        $logins = $this->adminGroupConfiguration->getGroupLogins($groupName);

        if (!empty($logins)) {
            return $this->hasPermission($logins[0], $permission);
        }

        if (is_null($logins)) {
            throw new UnknownGroupException("'$groupName' admin group does not exist.");
        }

        return false;
    }
}
