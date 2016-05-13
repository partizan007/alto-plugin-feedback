<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

$config = [];

$config['form']['feedback'] = array(
    // Template to render form
    'template' => 'feedback_form.tpl',
    
    // Header of form (display before tag <form>)
    'header' => array(
        'title' => '{{plugin.feedback.form_title}}',
        'text' => '{{plugin.feedback.form_text}}',
    ),
    
    // Fields of form
    'fields' => array(
        'name' => array(
            //'label' => 'Your name', // You can write label text here... 
            'label' => '{{plugin.feedback.form_name}}', // ... or key of text file
            'note' => '{{plugin.feedback.form_name_note}}',
            'placeholder' => '{{plugin.feedback.form_name_placeholder}}', // write placeholder here
            'type' => 'string', // type: string, email, number, text (will display as textarea)
            'required' => true,
            'group_css' => '', // CSS class of group div
            'field_css' => '', // CSS class of field tag
            'note_css' => '',  // CSS class of note (help block)
        ),
        'email' => array(
            'label' => 'Эл.почта',
            'type' => 'string',
            'required' => true,
        ),
        'registered' => array(
            'label' => 'Are you registered here?',
            'type' => 'radio',
            'options' => array(
                1 => 'Yes', 
                2 => 'No',
            ),
        ),
        'country' => array(
            'label' => 'Your country',
            'type' => 'select',
            'options' => array(
                'RU' => 'Russia',
                'US' => 'USA',
                '**' => 'Other',
            ),
        ),
        'message' => array(
            'label' => 'Текст сообщения',
            'type' => 'text',
            'required' => true,
        ),
        /*
        'quantity' => array(
            'label' => 'Пример числового поля',
            'type' => 'number',
            'required' => true,
            'value' => 1,
        ),
        */
    ),
    'submit' => array(
        'label' => 'Отправить сообщение',
        'action' => array(
            'mail' => array(
                array(
                    'address' => 'admin@site.com, copy@admin.adm',
                    'subject' => 'Сообщение с сайта',
                    'template' => 'feedback.tpl',
                ),
            ),
            'success' => 'Ваше сообщение отправлено',
        ),
    ),
    'page' => array(
        'on' => 'page/about',
        'hook' => 'template_page_content_end'
    ),
    'enable' => true,
);

// EOF