/*
 *Ref: http://wordpress.stackexchange.com/questions/72394/how-to-add-a-shortcode-button-to-the-tinymce-editor
 * Dropdown Ref : http://themeforest.net/forums/thread/little-dropdown-box-buttons-in-wordpress-39-tinymce-tutorial/127170 
 * 
 */
jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.wpse72394_plugin', {
        init : function(ed, url) {
                //1:Register command for when button is clicked :******* Footer notes upper
                ed.addCommand('wpse72394_insert_shortcode', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();
                   
             //condition : Non run when click on cancel button
                   
                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                         //get the id : 
                          var retVal = prompt("Enter unique id : ", ""); //alert(retVal);
                         if(retVal != "" && retVal !== null)
                         {
                        //content = '[footnotes id="'+retVal+'" position="up"]'+selected+'[/footnotes]';
                        content = '<a id="down'+retVal+'"  href="#up'+retVal+'" class="jumper">'+selected+'</a>';
                       }
                    }else{
                    	alert("Please select the text.");
                    }
                  
                    tinymce.execCommand('mceInsertContent', false, content);
                });
//alert(url);
            // Register buttons - trigger above command when clicked
            ed.addButton('wpse72394_button', {title : 'Eminds Foot Notes upper', cmd : 'wpse72394_insert_shortcode', image: url + '/h.png' });
        //2:**************************** Footer notes bottom    
                ed.addCommand('wpse72394_insert_shortcode2', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();
                   //get the id : 
                   //condition : Non run when click on cancel button
                   
                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                         //get the id : 
                          var retVal = prompt("Enter unique id : ", ""); //alert(retVal);
                         if(retVal != "" && retVal !== null)
                         {
                           //content = '[footnotes id="'+retVal+'" position="down"]'+selected+'[/footnotes]';
                           content = '<a id="up'+retVal+'"  href="#down'+retVal+'" class="jumper">'+selected+'</a>';
                       }
                    }else{
                    	alert("Please select the text.");
                    }
                    
                    tinymce.execCommand('mceInsertContent', false, content);
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('wpse72394_button2', {title : 'Eminds Foot Notes Lower', cmd : 'wpse72394_insert_shortcode2', image: url + '/f.png' });
            //3:*********************jumpto_section_number 
                ed.addCommand('wpse72394_insert_shortcode3', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();
                   //get the id : 
                   var retVal = prompt("Enter the section id : ", "Section id here");
                   //check for the integer value only  
                   if(parseInt(retVal)){
                   
                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content = '[jumpto_section_number id="'+retVal+'"]'+selected+'[/jumpto_section_number]';
                    }else{
                        content ='[jumpto_section_number id="'+retVal+'"]Enter section number [/jumpto_section_number]';
                    }
                    
                   }else{
                   	alert('Please enter the section number only.');
                   } 
                    
                    tinymce.execCommand('mceInsertContent', false, content);
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('wpse72394_button3',{title : 'Eminds jump to section number', cmd : 'wpse72394_insert_shortcode3', image: url + '/s.png' });
            //    *********************jumpto_section_number END
        },   
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('wpse72394_button', tinymce.plugins.wpse72394_plugin);
});
//******************************** TinyMCE *****************
(function() {

    tinymce.PluginManager.add('pushortcodes', function( editor )
    {
        var shortcodeValues = [];
        var inc=1;
        jQuery.each(shortcodes_button, function(i)
        {
        	/*
        	 *Specially for the 1st : to show the select section number.
        	 */
        	if(inc == 1){
        	shortcodeValues.push({text: "Select section "+shortcodes_button[i], value:0});	
        	}else{
        //	shortcodeValues.push({text: "Section "+shortcodes_button[i], value:i}); //correct in prev             
        //alert("shortcodes_button[i]="+shortcodes_button[i]+",i="+i);
        	shortcodeValues.push({text: "Section "+i, value:'"'+shortcodes_button[i]+'"'});	
        	} 
        	inc = inc + 1;
            
        });

        editor.addButton('pushortcodes', {
            type: 'listbox',
            text: 'Section No ',
            onselect: function(e) {
              //var v = e.control._value;
               var v  = e.control.settings.value;
                if(v === undefined){
                  v = e.control.settings.value;
                }
                console.log("v==",v);
               
                //console.log("e.control=",e.control);
                //console.log("value=",e.control._value);  
                   var selected = tinyMCE.activeEditor.selection.getContent();
                   if(selected == ""){
                   	alert("Please select the text.");
                   }else if(v == 0){
                   	alert("Please select the section number.");
                   }else{
                    //tinyMCE.activeEditor.selection.setContent( '[section num="' + v + '"]'+selected+'[/section]' );
                    //tinyMCE.activeEditor.selection.setContent( '<a href="' + v + '">'+selected+'</a>' );   	
                    tinyMCE.activeEditor.selection.setContent( '<a href=' + v + '>'+selected+'</a>' );    
                   }                 
            },
            values: shortcodeValues
        });
    });
})();

