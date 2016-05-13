<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

class PluginFeedback_HookFeedback extends Hook {

    public function RegisterHook() {

        $aForms = E::PluginFeedback_ModuleFeedback_GetPageForms();
        if ($aForms) {
            foreach($aForms as $sFormName => $aFormData) {
                if (isset($aFormData['page']['hook']) && !empty($aFormData['enable'])) {
                    E::Hook_AddExecFunction($aFormData['page']['hook'], array($this, 'TplFormHook'));
                }
            }
        }
    }

    /**
     * @return string|null
     */
    public function TplFormHook() {

        $sResult = '';
        $aForms = E::PluginFeedback_ModuleFeedback_GetPageForms();
        if ($aForms) {
            foreach($aForms as $sFormName => $aFormData) {
                if (isset($aFormData['page']['hook']) && !empty($aFormData['enable'])) {
                    $aFormData['name'] = $sFormName;
                    E::Viewer_Assign('aFormData', $aFormData);
                    $sTemplate = (!empty($aFormData['template']) ? $aFormData['template'] : 'feedback_form.tpl');
                    $sResult .= E::Viewer_Fetch(Plugin::GetTemplateDir(__CLASS__) . 'tpls/' . $sTemplate);
                }
            }
        }
        return $sResult;
    }

}

// EOF