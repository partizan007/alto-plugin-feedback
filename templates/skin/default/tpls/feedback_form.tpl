<div class="form-feedback">
    {if $aFormData.header}
        <div class="form-feedback-header">
            {if $aFormData.header.title}
                <h3>{$aFormData.header.title}</h3>
            {/if}
            {if $aFormData.header.text}
                <p>{$aFormData.header.text}</p>
            {/if}
        </div>
    {/if}
    <form method="post" role="form" class="js-feedback-form">
        <input type="hidden" name="security_key" value="{$ALTO_SECURITY_KEY}"/>
        <input type="hidden" name="feedback_name" value="{$aFormData.name}"/>
        {foreach $aFormData.fields as $sFieldName => $aField}
        <div class="form-group {$aField.group_css}">
            <label>{$aField.label}{if $aField.required}*{/if}</label>
            {if $aField.type=='radio' OR $aField.type=='checkbox'}
                {foreach $aField.options as $sOptionKey => $sOptionVal}
                    <div class="{$aField.type} {$aField.group_css}">
                        <label>
                            <input type="{$aField.type}" name="feedback_field_{$sFieldName}" value="{$sOptionKey}">
                            {$sOptionVal}
                        </label>
                    </div>
                {/foreach}
            {elseif $aField.type=='select'}
                <select class="form-control form-control-type-{$aField.type} {$aField.field_css}">
                    {foreach $aField.options as $sOptionKey => $sOptionVal}
                        <option value="{$sOptionKey}">{$sOptionVal}</option>
                    {/foreach}
                </select>
            {else}
                {if $aField.type=='text'}
                    <textarea class="form-control input-text form-control-type-{$aField.type} {$aField.field_css}"
                              name="feedback_field_{$sFieldName}"
                              placeholder="{$aField.placeholder}"
                              {if $aField.required}required{/if}>{$aField.value}</textarea>
                {else}
                    {if $aField.type=='number' OR $aField.type=='email'}
                        {$sType=$aField.type}
                    {else}
                        {$sType='text'}
                    {/if}
                    <input type="{$sType}" class="form-control input-text form-control-type-{$aField.type} {$aField.field_css}"
                           name="feedback_field_{$sFieldName}"
                           placeholder="{$aField.placeholder}"
                           value="{$aField.value}"
                           {if $aField.required}required{/if}>
                {/if}
                {if $aField.note}
                    <p class="help-block {$aField.note_css}">{$aField.note}</p>
                {/if}
            {/if}
        </div>
        {/foreach}
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="submit">{$aFormData.submit.label}</button>
        </div>
    </form>
    <div class="js-feedback-result alert alert-success alert-message" style="display: none;"></div>
</div>
