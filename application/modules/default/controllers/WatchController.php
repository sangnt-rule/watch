<?php
class WatchController extends Application_Controller_FrontEnd
{
    public function indexAction()
    {
        $idMachine = $this->getRequest()->getParam('machine');
        $idCord = $this->getRequest()->getParam('cord','');
        $search = $this->getRequest()->getParam('search','');
        $data = Model_Watch::getInstance()->search($idMachine, $idCord, $search);
        $this->view->assign('idMachine', $idMachine);
        $this->view->assign('idCord', $idCord);
        $this->view->assign('search', $search);
        $this->view->assign('watch', $data);


    }
    public function detailAction()
    {
        $id = $this->getRequest()->getParam('id');
        $data = Model_Watch::getInstance()->getById($id);
        $this->view->assign('data', $data[0]);

    }

}