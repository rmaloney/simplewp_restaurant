
(function(){
    tinymce.create('tinymce.plugins.wowslider', {
        init : function(ed, url){
            for (var id in tinymce_wowslider.sliders){
                tinymce_wowslider.last = id;
                break;
            }
            tinymce_wowslider.url = url;
            tinymce_wowslider.insert = function(){
                var id = (this.v ? this.v : tinymce_wowslider.last);
                tinymce.execCommand('mceInsertContent', false, '[wowslider id="' + id + '"]');
            };
        },
        createControl : function(n, cm){
            switch (n){
                case 'wowslider':
                    var c = cm.createSplitButton('wowslider', {
                        title : tinymce_wowslider.title,
                        image : tinymce_wowslider.url + '/icon.png',
                        onclick : tinymce_wowslider.insert
                    });
                    c.onRenderMenu.add(function(c, m){
                        for (var id in tinymce_wowslider.sliders){
                            m.add({
                                v : id,
                                title : tinymce_wowslider.sliders[id],
                                onclick : tinymce_wowslider.insert
                            });
                        }
                    });
                    return c;
            }
            return null;
        },
    });
    tinymce.PluginManager.add('wowslider', tinymce.plugins.wowslider);
})();
