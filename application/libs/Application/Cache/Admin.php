<?php

/**
 * Created by PhpStorm.
 * User: xitrumhaman
 * Date: 1/23/15
 * Time: 9:55 AM
 */
class Application_Cache_Admin extends Application_Cache
{
    public function adminModule()
    {
        return Application_Constant_Cache::ADMIN_MODULE;
    }

    public function resetAdminModule()
    {
        $this->remove($this->adminModule());
    }

    public function adminPrivilege()
    {
        return Application_Constant_Cache::ADMIN_PRIVILEGE;
    }

    public function resetAdminPrivilege()
    {
        $this->remove($this->adminPrivilege());
    }

    public function adminAcl($roleId)
    {
        return Application_Constant_Cache::ADMIN_ACL . $roleId;
    }

    public function resetadminAcl($roleId)
    {
        $this->remove($this->adminAcl($roleId));
    }

    public function adminPermission($adminId)
    {
        return Application_Constant_Cache::ADMIN_PERMISSION . $adminId;
    }

    public function resetAdminPermission($adminId)
    {
        $this->remove($this->adminPermission($adminId));
    }

    public function adminInfo()
    {
        return Application_Constant_Cache::ADMIN_ALL_INFO;
    }
}