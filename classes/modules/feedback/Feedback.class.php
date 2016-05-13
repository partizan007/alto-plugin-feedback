<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

class PluginFeedback_ModuleFeedback extends Module {

    protected $aPageForms;

    public function Init() {

    }

    public function GetPageForms() {

        if (F::AjaxRequest()) {
            return array();
        }
        if (is_null($this->aPageForms)) {
            $this->aPageForms = array();
            $aForms = Config::Get('plugin.feedback.form');
            foreach($aForms as $sFormName => $aData) {
                $bDisplay = false;
                if (!isset($aData['enable']) || $aData['enable']) {
                    if (!isset($aData['page']['on'])) {
                        $bDisplay = true;
                    } else {
                        $aIncludePaths = $aData['page']['on'];
                        if (!$aIncludePaths || Router::CompareWithLocalPath($aIncludePaths)) {
                            $bDisplay = true;
                        } else {
                            if (is_array($aIncludePaths)) {
                                foreach($aIncludePaths as $sPath) {
                                    if (Router::RealUrl(true) === $sPath) {
                                        $bDisplay = true;
                                        break;
                                    }
                                }
                            } elseif (Router::RealUrl(true) === $aIncludePaths) {
                                $bDisplay = true;
                            }
                        }
                    }
                    if ($bDisplay && isset($aData['fields'])) {
                        $this->aPageForms[$sFormName] = $this->_formParseTexts($aData);
                    }
                }
            }
        }
        return $this->aPageForms;
    }

    /**
     * @param string $sFormName
     *
     * @return null|array
     */
    public function GetForm($sFormName) {

        $aForms = Config::Get('plugin.feedback.form');
        if (isset($aForms[$sFormName])) {
            return $this->_formParseTexts($aForms[$sFormName]);
        }
        return null;
    }

    /**
     * @param array $aForm
     *
     * @return array
     */
    protected function _formParseTexts($aForm) {

        if (isset($aForm['header']['title'])) {
            $aForm['header']['title'] = E::Lang_Text($aForm['header']['title']);
        }
        if (isset($aForm['header']['text'])) {
            $aForm['header']['text'] = E::Lang_Text($aForm['header']['text']);
        }

        foreach ($aForm['fields'] as $sFieldName => $aFieldData) {
            if (isset($aFieldData['label'])) {
                $aForm['fields'][$sFieldName]['label'] = E::Lang_Text($aFieldData['label']);
            }
            if (isset($aFieldData['note'])) {
                $aForm['fields'][$sFieldName]['note'] = E::Lang_Text($aFieldData['note']);
            }
            if (isset($aFieldData['placeholder'])) {
                $aForm['fields'][$sFieldName]['placeholder'] = E::Lang_Text($aFieldData['placeholder']);
            }
        }

        return $aForm;
    }
}

// EOF