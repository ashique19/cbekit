<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <title>elFinder 2.0</title>

        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/elfinder.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/theme.css') }}">
        
        <style type="text/css">
            .ui-state-disabled, .ui-widget-content .ui-state-disabled, .ui-widget-header .ui-state-disabled{
                opacity: 1;
            }
        </style>

        <!-- elFinder JS (REQUIRED) -->
        <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>

        @if($locale)
            <!-- elFinder translation (OPTIONAL) -->
            <script src="{{ asset($dir."/js/i18n/elfinder.$locale.js") }}"></script>
        @endif

        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
            // Documentation for client options:
            // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
            $().ready(function() {
                $('#elfinder').elfinder({
                    // set your elFinder options here
                    @if($locale)
                        lang: '{{ $locale }}', // locale
                    @endif
                    customData: { 
                        _token: '{{ csrf_token() }}'
                    },
                    url : '{{ route("elfinder.connector") }}',  // connector URL
                    soundPath: '{{ asset($dir.'/sounds') }}',
                    commandsOptions: {
                        edit: {
                            editors : [
                                { 
                                    // ACE Editor
                                    // `mimes` is not set for support everything kind of text file
                                    load : function(textarea) {
                                        
                                        console.log(this.fm);
                                        
                                        var self = this,
                                            dfrd = $.Deferred(),
                                            cdn  = '//cdnjs.cloudflare.com/ajax/libs/ace/1.2.8',
                                            init = function() {
                                                if (typeof ace === 'undefined') {
                                                    self.fm.loadScript([
                                                        cdn+'/ace.js',
                                                        cdn+'/ext-modelist.js',
                                                        cdn+'/ext-settings_menu.js',
                                                        cdn+'/ext-language_tools.js'
                                                    ], start);
                                                } else {
                                                    start();
                                                }
                                            },
                                            start = function() {
                                                var editor, editorBase, mode,
                                                ta = $(textarea),
                                                taBase = ta.parent(),
                                                dialog = taBase.parent(),
                                                id = textarea.id + '_ace',
                                                ext = self.file.name.replace(/^.+\.([^.]+)|(.+)$/, '$1$2').toLowerCase(),
                                                // MIME/mode map
                                                mimeMode = {
                                                    'text/x-php'              : 'php',
                                                    'application/x-php'       : 'php',
                                                    'text/html'               : 'html',
                                                    'application/xhtml+xml'   : 'html',
                                                    'text/javascript'         : 'javascript',
                                                    'application/javascript'  : 'javascript',
                                                    'text/css'                : 'css',
                                                    'text/x-c'                : 'c_cpp',
                                                    'text/x-csrc'             : 'c_cpp',
                                                    'text/x-chdr'             : 'c_cpp',
                                                    'text/x-c++'              : 'c_cpp',
                                                    'text/x-c++src'           : 'c_cpp',
                                                    'text/x-c++hdr'           : 'c_cpp',
                                                    'text/x-shellscript'      : 'sh',
                                                    'application/x-csh'       : 'sh',
                                                    'text/x-python'           : 'python',
                                                    'text/x-java'             : 'java',
                                                    'text/x-java-source'      : 'java',
                                                    'text/x-ruby'             : 'ruby',
                                                    'text/x-perl'             : 'perl',
                                                    'application/x-perl'      : 'perl',
                                                    'text/x-sql'              : 'sql',
                                                    'text/xml'                : 'xml',
                                                    'application/docbook+xml' : 'xml',
                                                    'application/xml'         : 'xml'
                                                };
                                                
                                                // set basePath of ace
                                                ace.config.set('basePath', cdn);
                                                
                                                // set base height
                                                taBase.height(taBase.height());
                                                
                                                // detect mode
                                                mode = ace.require('ace/ext/modelist').getModeForPath('/' + self.file.name).name;
                                                if (mode === 'text') {
                                                    if (mimeMode[self.file.mime]) {
                                                        mode = mimeMode[self.file.mime];
                                                    }
                                                }
                    
                                                // show MIME:mode in title bar
                                                taBase.prev().children('.elfinder-dialog-title').append(' (' + self.file.mime + ' : ' + mode.split(/[\/\\]/).pop() + ')');
                    
                                                // TextArea button and Setting button
                                                $('<div class="ui-dialog-buttonset"/>').css('float', 'left')
                                                .append(
                                                    $('<button>TextArea</button>')
                                                    .button()
                                                    .on('click', function(){
                                                        if (ta.data('ace')) {
                                                            ta.removeData('ace');
                                                            editorBase.hide();
                                                            ta.val(editor.session.getValue()).show().focus();
                                                            $(this).text('AceEditor');
                                                        } else {
                                                            ta.data('ace', true);
                                                            editorBase.show();
                                                            editor.setValue(ta.hide().val(), -1);
                                                            editor.focus();
                                                            $(this).text('TextArea');
                                                        }
                                                    })
                                                )
                                                .append(
                                                    $('<button>Ace editor setting</button>')
                                                    .button({
                                                        icons: {
                                                            primary: 'ui-icon-gear',
                                                            secondary: 'ui-icon-triangle-1-e'
                                                        },
                                                        text: false
                                                    })
                                                    .on('click', function(){
                                                        editor.showSettingsMenu();
                                                    })
                                                )
                                                .prependTo(taBase.next());
                    
                                                // Base node of Ace editor
                                                editorBase = $('<div id="'+id+'" style="width:100%; height:100%;"/>').text(ta.val()).insertBefore(ta.hide());
                    
                                                // Ace editor configure
                                                ta.data('ace', true);
                                                editor = ace.edit(id);
                                                ace.require('ace/ext/language_tools');
                                                ace.require('ace/ext/settings_menu').init(editor);
                                                editor.$blockScrolling = Infinity;
                                                editor.setOptions({
                                                    theme: 'ace/theme/monokai',
                                                    mode: 'ace/mode/' + mode,
                                                    fontSize: '14px',
                                                    wrap: true,
                                                    enableBasicAutocompletion: true,
                                                    enableSnippets: true,
                                                    enableLiveAutocompletion: false
                                                });
                                                editor.commands.addCommand({
                                                    name : "saveFile",
                                                    bindKey: {
                                                        win : 'Ctrl-s',
                                                        mac : 'Command-s'
                                                    },
                                                    exec: function(editor) {
                                                        self.doSave();
                                                    }
                                                });
                                                editor.commands.addCommand({
                                                    name : "closeEditor",
                                                    bindKey: {
                                                        win : 'Ctrl-w|Ctrl-q',
                                                        mac : 'Command-w|Command-q'
                                                    },
                                                    exec: function(editor) {
                                                        self.doCancel();
                                                    }
                                                });
                                                
                                                editor.resize();
                                                
                                                dfrd.resolve(editor);
                                            };
                                        
                                        // init & start
                                        init();
                                        
                                        return dfrd;
                                    },
                                    close : function(textarea, instance) {
                                        if (instance) {
                                            instance.destroy();
                                            $(textarea).show();
                                        }
                                    },
                                    save : function(textarea, instance) {
                                        instance && $(textarea).data('ace') && (textarea.value = instance.session.getValue());
                                    },
                                    focus : function(textarea, instance) {
                                        instance && $(textarea).data('ace') && instance.focus();
                                    },
                                    resize : function(textarea, instance, e, data) {
                                        instance && instance.resize();
                                    }
                                }
                            ]
                        }
                    }
                });
            });
        </script>
    </head>
    <body>

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

    </body>
</html>
