var PScript = PScript || {
    
    PSCRIPTCONFIG:function(){},
        
    init : function() {

     PScript.UI.attachListeners();
    },
    
    transition : function (elem, callback) {
        console.debug("transition");
        container = self.jQuery(elem.data("target"));
        switch(elem.data("transition")) {
         
            case "slide" :
                container.slideUp(400, callback);
            break;
            case "fade" :
                container.fadeOut(400, callback);
            break; 
            
        }
        
    },
    
    endTransition : function (elem, callback) {
        console.debug("end transition");
        console.debug(elem);
        container = self.jQuery(elem.data("target"));
        switch(elem.data("transition")) {
         
            case "slide" :
                container.slideDown();
            break;
            case "fade" :
                container.fadeIn(); 
            break;
            default:
                container.fadeIn();
            break;
        }
        callback();
    }

};
PScript.jQuery = jQuery;

PScript.UI = {
    loading : function() {
     return 'Loading...';   
    },
    attachListeners: function() {
        $("[data-do]").click(function() {
            PScript.actions.do(this);
        });
        $("[data-post]").click(function() {
            PScript.actions.post(this);
        });
    }
};

PScript.actions = {
    do : function(elem) {
        elem = self.jQuery(elem);
        
        if(elem[0].hasAttribute("data-transition")) {
        } else {
            elem.data('transition','fade'); 
        }
        PScript.transition(elem, function() {
            self.jQuery(elem.data('target')).html(PScript.UI.loading());
        });
        requestUrl = '/' + PScript.outputFolder + '/' + self.jQuery(elem).data('do') + PScript.ext;
        setTimeout(function() {
            
            console.debug(requestUrl);
        self.jQuery.ajax({
            url : requestUrl,
            success : function(html) {
                self.jQuery(self.jQuery(elem).data('target')).html(html);
                PScript.UI.attachListeners();
                PScript.endTransition(elem, function(){});
            }
        });
        }, PScript.delay);
    },
    post : function(elem) {
        elem = self.jQuery(elem);
        
        if(elem[0].hasAttribute("data-transition")) {
        } else {
            elem.data('transition','fade'); 
        }
        PScript.transition(elem, function() {
            self.jQuery(elem.data('target')).html(PScript.UI.loading());
        });
        postData = self.jQuery(elem.data('form')).serialize();
        console.debug(self);
        requestUrl = "http://" + remoteURI + '/' + PScript.outputFolder + '/' + self.jQuery(elem).data('post') + PScript.ext;
        console.debug(requestUrl);
        setTimeout(function() {
            
            
        self.jQuery.post({
            url : requestUrl,
            data: postData,
            success : function(html) {
                self.jQuery(self.jQuery(elem).data('target')).html(html);
                PScript.UI.attachListeners();
                PScript.endTransition(elem, function(){});
            }
        });
        }, PScript.delay);
    }
};
var $PS = null;
$(document).ready(function() {
   $PS = PScript.init();
});
