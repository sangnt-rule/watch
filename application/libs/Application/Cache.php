<?php
/**
 * Created by Phong Pham <xitrumhaman@yahoo.com>.
 * User: Phong Pham
 * Date: 10/11/14
 * Time: 3:53 PM
 */

class Application_Cache extends Application_Singleton
{
    /**
     * @var Zend_Cache_Core
     */
    private $_cache;

    protected function __construct(){
        $this->_cache = Zend_Registry::get('cache');
    }

    public function save($data, $id, $life_time){
        return $this->_cache->save($data, $id, array(), $life_time);
    }

    public function load($id){
        return $this->_cache->load($id);
    }

    public function remove($id){
        return $this->_cache->remove($id);
    }

    public function clean()
    {
        return $this->_cache->clean();
    }
}