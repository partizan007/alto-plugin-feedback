<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

class PluginFeedback extends Plugin {

    protected $aDelegates = array(
    );

    protected $aInherits = array(
        'entity' => array(
        ),
        'module' => array(
        ),
        'action' => array(
        ),
    );

    /**
     * Активация плагина
     */
    public function Activate() {

        return true;
    }

    /**
     * Инициализация плагина
     */
    public function Init() {

        $this->Viewer_AppendStyle(Plugin::GetTemplateDir(__CLASS__) . 'assets/css/feedback.css');
        $this->Viewer_AppendScript(Plugin::GetTemplateUrl(__CLASS__) . 'assets/js/feedback.js');

        return true;
    }
}

// EOF