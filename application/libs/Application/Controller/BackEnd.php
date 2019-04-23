<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/7/15
 * Time: 11:32 AM
 */
class Application_Controller_BackEnd extends Application_Controller
{
    /**
     * @var
     */
    protected $adminInfo;

    /**
     * @var Zend_Config_Ini
     */
    protected $config;

    public function init()
    {
        parent::init();
        $this->config = Zend_Registry::get('config');
        $this->adminInfo = $this->getSession()->adminInfo;
    }

    public function preDispatch()
    {
        parent::preDispatch();
        if (!$this->adminInfo) {
            $this->gotoUrl('/login');
        }
    }

    public function postDispatch()
    {
        parent::postDispatch();
        $this->autoLoadResource($this->_getResourceCss(), 'css');
        $this->autoLoadResource($this->_getResourceJs(), 'js');

        $this->view->assign('adminInfo', $this->adminInfo);
        $this->view->assign('config', $this->config);
        $this->view->assign('controller', $this->getRequest()->getParam('controller'));
        $this->view->assign('action', $this->getRequest()->getParam('action'));
        $this->view->assign(
            'urlPath',
            sprintf(
                '%s/%s',
                $this->getRequest()->getParam('controller'),
                $this->getRequest()->getParam('action')
            )
        );
        $this->view->assign('isAdminRoot', $this->_isAdminRoot());
        $this->view->assign('adminRole', $this->getAdminRole());
    }

    protected function goto404()
    {
        $this->gotoUrl('/alert/error404');
    }

    /**
     * Show error message when form is submitted
     * @param string $message
     */
    protected function alertSubmitError($message)
    {
        echo sprintf('<script>parent.alert("%s")</script>', trim($message));
    }

    /**
     * Redirect form is submitted
     * @param string $url
     */
    protected function redirectSubmit($url)
    {
        echo sprintf('<script>parent.location.href="/%s";</script>', $url);
    }

    /**
     * Alert error message
     * @param array|string $message
     */
    protected function alertAppendMessage($message)
    {
        $script = '<script>';
        $script .= 'parent.AdminCommon.resetErrorMsg();';
        if (!is_array($message)) {
            $messageArr[] = $message;
        } else {
            $messageArr = $message;
        }
        foreach ($messageArr as $msg) {
            $script .= 'parent.AdminCommon.appendErrorMsg("'.$msg.'");';
        }
        $script .= '</script>';
        echo $script;
    }

    /**
     * Get ID of admin role
     * @return int
     */
    protected function getAdminRole()
    {
        return $this->adminInfo ? $this->adminInfo->{DbTable_Admin::COL_FK_ADMIN_ROLE} : 0;
    }

    /**
     * Get Administrator ID
     * @return mixed
     */
    protected function getAdminId()
    {
        return $this->adminInfo->{DbTable_Admin::COL_ADMIN_ID};
    }

    /**
     * Check if current use is Root
     * @return bool
     */
    protected function _isAdminRoot()
    {
        return $this->adminInfo && $this->adminInfo->{DbTable_Admin::COL_ADMIN_ID}==Application_Constant_Db_Admin::ADMIN_ROOT ;
    }


    /**
     * Get Css resource
     * @return array
     */
    private function _getResourceCss()
    {
        return array(
//            'css/main.css',
//            'css/bootstrap/bootstrap.min.css',
//            'css/bootstrap/bootstrap-theme.min.css',
//            'css/utils.css',
//            'autoload/css/common.css'
        );
    }

    /**
     * Get Js Resource
     * @return array
     */
    private function _getResourceJs()
    {
        return array(
//            'js/libs/jquery-3.4.0.js',
//            'js/plugins/spinner/ui.spinner.js',
//            'js/plugins/spinner/jquery.mousewheel.js',
//            'js/libs/jquery-ui.min.1.8.js',
//            'js/libs/jquery-blockui.js',
//            'js/plugins/charts/excanvas.min.js',
//            'js/plugins/charts/jquery.flot.js',
//            'js/plugins/charts/jquery.flot.orderBars.js',
//            'js/plugins/charts/jquery.flot.pie.js',
//            'js/plugins/charts/jquery.flot.resize.js',
//            'js/plugins/charts/jquery.sparkline.min.js',
//            'js/plugins/forms/uniform.js',
//            'js/plugins/forms/jquery.cleditor.js',
//            'js/plugins/forms/jquery.validationEngine-vi.js',
//            'js/plugins/forms/jquery.validationEngine.js',
//            'js/plugins/forms/jquery.tagsinput.min.js',
//            'js/plugins/forms/autogrowtextarea.js',
//            'js/plugins/forms/jquery.maskedinput.min.js',
//            'js/plugins/forms/jquery.dualListBox.js',
//            'js/plugins/forms/jquery.inputlimiter.min.js',
//            'js/plugins/forms/chosen.jquery.min.js',
//            'js/plugins/wizard/jquery.form.js',
//            'js/plugins/wizard/jquery.validate.min.js',
//            'js/plugins/wizard/jquery.form.wizard.js',
//            'js/plugins/uploader/plupload.js',
//            'js/plugins/uploader/plupload.html5.js',
//            'js/plugins/uploader/plupload.html4.js',
//            'js/plugins/uploader/jquery.plupload.queue.js',
//            'js/plugins/tables/datatable.js',
//            'js/plugins/tables/tablesort.min.js',
//            'js/plugins/tables/resizable.min.js',
//            'js/plugins/ui/jquery.tipsy.js',
//            'js/plugins/ui/jquery.collapsible.min.js',
//            'js/plugins/ui/jquery.prettyPhoto.js',
//            'js/plugins/ui/jquery.progress.js',
//            'js/plugins/ui/jquery.timeentry.min.js',
//            'js/plugins/ui/jquery.colorpicker.js',
//            'js/plugins/ui/jquery.jgrowl.js',
//            'js/plugins/ui/jquery.breadcrumbs.js',
//            'js/plugins/ui/jquery.sourcerer.js',
//            'js/plugins/calendar.min.js',
//            'js/plugins/elfinder.min.js',
//            '../libs/js/editor/ckeditor/ckeditor.js',
//            'js/custom.js',
//            'js/global.config.js',
//            'js/slideout/slideout.min.js',
//            'js/common.js',
//            'js/plugins/ui/jquery-ui.multidatespicker.js',
//            'js/plugins/forms/ajax-chosen.min.js',
//            'autoload/js/common/common.js'
        );
    }
}