/**
 * Created by dell on 2014/10/16.
 */
//CKEDITOR.plugins.add('insertcode', {
//    requires: ['dialogs'],
//    init: function(a){
//        var b = a.addCommand('insertcode', new CKEDITOR.dialogCommand('insertcode'));
//        a.ui.addButton('insertcode', {
//            label: a.lang.insertcode.toolbar,
//            command: 'insertcode',
//            icon: this.path + 'images/code.jpg'
//        });
//        CKEDITOR.dialog.add('insertcode', this.path + 'dialogs/insertcode.js');
//    }
//});
CKEDITOR.plugins.add('insertcode',
    {
        init: function(editor)
        {
            //plugin code goes here
            var pluginName = 'Insertcode';
            CKEDITOR.dialog.add(pluginName, this.path + 'insertcode.js');
            editor.config.flv_path = editor.config.flv_path || (this.path);
            editor.addCommand(pluginName, new CKEDITOR.dialogCommand(pluginName,
                {
                    allowedContent:'pre[class]'
                }));
            editor.ui.addButton('Insertcode',
                {
                    label: 'Insert Code',
                    command: pluginName,
                    icon: this.path + 'images/insertcode.gif'
                });
        }
    });