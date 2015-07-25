/**
* Created by dell on 2014/10/16.
*/
CKEDITOR.dialog.add('Insertcode', function(editor){
    var escape = function(value){return value;};
    return{
        title: 'Insert Code',
        resizable: CKEDITOR.DIALOG_RESIZE_BOTH,
        minWidth: 720,
        minHeight: 520,
        contents: [{
            id: 'cb',
            name: 'cb',
            label: 'cb',
            title: 'cb',
            elements: [{
                type: 'select',
                label: 'Language',
                id: 'lang',
                required: true,
                'default': 'csharp',
                items: [['ActionScript3', 'as3'], ['Bash/shell', 'bash'], ['ColdFusion', 'cf'], ['C#', 'csharp'], ['C++', 'cpp'], ['CSS', 'css'], ['Delphi', 'delphi'], ['Diff', 'diff'], ['Groovy', 'groovy'], ['JavaScript', 'js'], ['Java', 'java'], ['JavaFX', 'jfx'], ['Perl', 'perl'], ['PHP', 'php'], ['Plain Text', 'plain'], ['PowerShell', 'ps'], ['Python', 'py'], ['Ruby', 'rails'], ['Scala', 'scala'], ['SQL', 'sql'], ['Visual Basic', 'vb'], ['XML', 'xml']]
            }, {
                type: 'textarea',
                style: 'width:718px;height:450px',
                label: 'Code',
                id: 'code',
                rows: 31,
                'default': ''
            }]
        }],
        onOk: function(){
            code = this.getValueOf('cb', 'code');
            lang = this.getValueOf('cb', 'lang');
            html = '' + escape(code) + '';
            var pre = editor.document.createElement('pre');
            // Set element attribute and text by getting the defined field values.
            pre.setAttribute('class', 'brush:' + lang);
            pre.setText(html);
            // Finally, insert the element into the editor at the caret position.
            editor.insertElement(pre);
        },
        onLoad: function(){}
    };
});