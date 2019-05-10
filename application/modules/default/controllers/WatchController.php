<?php
class WatchController extends Application_Controller_FrontEnd
{
    public function indexAction()
    {
        $idMachine = $this->getRequest()->getParam('machine');
        $idCord = $this->getRequest()->getParam('cord');
        $data = Model_Watch::getInstance()->getByFkMachineFkCord($idMachine, $idCord);
        $this->view->assign('watch', $data);

    }
    public function search()
    {


    }
    public function detailAction()
    {

    }

}