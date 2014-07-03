(function() {
    tinymce.create('tinymce.plugins.Rezdy', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            //console.log(url);

            ed.addButton('rezdy', {
                title : 'Insert Rezdy Shortcode',
                image : url + '/../../../assets/favicon.png',
                onclick : function(e)
                {
                    e.stopPropagation();

                    var help_path = 'https://support.rezdy.com/entries/47217670-How-to-use-Rezdy-Wordpress-plugin';

                    ed.windowManager.open( {
                        title: 'Insert Rezdy Shortcode',
                        body: [{
                            type: 'textbox',
                            name: 'catalog',
                            label: 'Catalog Url (Optional)'
                        },{
                            type: 'container',
                            name: 'help',
                            html: '<a href="' + help_path + '" target="_blank" style="text-align: right; display: block; font-size: 10px">Need help finding your catalog url?</a>',
                            label: ''
                        }],
                        buttons: [{
                            text: 'Close',
                            onclick: 'close'
                        },{
                                text: 'Insert Rezdy Shortcode',
                                onclick: 'submit',
                                classes: 'widget btn primary',
                                style: 'width: 170px;'
                        }],
                        onsubmit: function( e ) {

                            var catalog = e.data.catalog;

                            var shortcode;
                            if (catalog !== null && catalog != '')
                                shortcode = '[rezdy catalog="' + catalog + '"]';
                            else
                                shortcode = '[rezdy]';

                            ed.execCommand('mceInsertContent', 0, shortcode);
                        }
                    });



                }
            });

           // ed.addCommand('rezdy', function() {

            //});
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Rezdy Buttons',
                author : 'info@rezdy.com',
                authorurl : 'http://rezdy.com',
                infourl : 'http://rezdy.com',
                version : "1.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add( 'rezdy', tinymce.plugins.Rezdy );
})();