var PScript = PScript || {
    
    mode: 'online',
    outputFolder: 'in',
    ext: '.html',
    delay:1000, /* Delay for checking how it will work in slow environments */
    
    init : function() {
     
     self.domain = "{PSCRIPTdomain}"; 
     if(self.domain=="{PSCRIPTdomain}") { /* Didn't come from PScript, must be offline. */
      self.mode = 'offline';
      self.outputFolder = "myapp/offline";
      self.ext = '.html';
     }
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
        
        setTimeout(function() {
        self.jQuery.ajax({
            url : '/' + self.outputFolder + '/' + self.jQuery(elem).data('do') + PScript.ext,
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
        setTimeout(function() {
            
            
        self.jQuery.post({
            url : '/' + self.outputFolder + '/' + self.jQuery(elem).data('post') + PScript.ext,
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

$(document).ready(function() {
    PScript.init();
});
