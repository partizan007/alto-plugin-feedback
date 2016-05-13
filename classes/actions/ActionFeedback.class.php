<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

class PluginFeedback_ActionFeedback extends ActionPlugin {

    protected $sPrefix = 'feedback_';
    protected $aFieldSet;

    /**
     * Register events
     */
    public function RegisterEvent() {

        $this->AddEvent('default', 'EventDefault');
    }

    /**
     * Initialization of action
     */
    public function Init() {

        $this->SetDefaultEvent('default');
    }

    /**
     * Default event
     */
    public function EventDefault() {

        if (!F::AjaxRequest()) {
            die('Oops');
        }
        $this->Viewer_SetResponseAjax('json');
        $sFormName = $this->GetPost('feedback_name');
        if ($sFormName && ($aForm = E::PluginFeedback_ModuleFeedback_GetForm($sFormName))) {
            if ($this->IsPost()) {
                $aData = array();
                $aKeys = array_keys($_POST);
                $sPrefix = 'feedback_field_';
                $aErrFields = array();
                foreach ($aKeys as $sKey) {
                    if (strpos($sKey, $sPrefix) === 0) {
                        $sFieldName = str_replace($sPrefix, '', $sKey);
                        if (isset($aForm['fields'][$sFieldName])) {
                            $sValue = $this->GetPost($sKey);
                            if (is_null($sValue) || trim($sValue) === '') {
                                $aErrFields[$sKey] = '';
                            } else {
                                $aData[$sFieldName] = array(
                                    'label' => $aForm['fields'][$sFieldName]['label'],
                                    'value' => $sValue,
                                );
                            }
                        }
                    }
                }
                if ($aErrFields) {
                    $this->Viewer_AssignAjax('aErrFields', $aErrFields);
                    $this->Message_AddErrorSingle($this->Lang_Get('plugin.feedback.message_fill_required'));
                } else {
                    $xEmailParams = $aForm['submit']['action']['mail'];
                    if (is_string($xEmailParams)) {
                        $xEmailParams = array(
                            array(
                                'address' => $xEmailParams,
                            ),
                        );
                    }
                    foreach ($xEmailParams as $aEmailParam) {
                        $xAddressee = (isset($aEmailParam['address']) ? $aEmailParam['address'] : Config::Get('sys.mail.from_email'));
                        $aEmail = F::Array_Str2Array($xAddressee);
                        $sTitle = (isset($aEmailParam['subject']) ? $this->Lang_Text($aEmailParam['subject']) : $this->Lang_Get('plugin.feedback.message_subject'));
                        $sTemplate = (isset($aEmailParam['template']) ? $aEmailParam['template'] : 'feedback.tpl');
                        if (isset($aForm['submit']['action']['mail'])) {
                            $sSuccess = $aForm['submit']['action']['success'];
                        } else {
                            $sSuccess = $this->Lang_Get('plugin.feedback.message_confirm');
                        }
                        foreach($aEmail as $sEmail) {
                            if ($this->_sendMessage($sEmail, $aData, $sTitle, $sTemplate)) {
                                $this->Message_AddNoticeSingle($sSuccess);
                            } else {
                                $this->Message_AddErrorSingle($this->Lang_Get('plugin.feedback.message_error'));
                            }
                        }
                    }
                }
            } else {
                $this->Message_AddErrorSingle($this->Lang_Get('plugin.feedback.message_fill_form'));
            }
        } else {
            $this->Message_AddErrorSingle($this->Lang_Get('system_error'));
        }
    }

    /**
     * @param string $sEmail
     * @param string $aFormData
     * @param string $sTitle
     * @param string $sTemplate
     *
     * @return bool
     */
    protected function _sendMessage($sEmail, $aFormData, $sTitle, $sTemplate) {

        return $this->Notify_Send($sEmail, $sTemplate, $sTitle, array('aFormData' => $aFormData), __CLASS__, true);
    }

}

// EOF