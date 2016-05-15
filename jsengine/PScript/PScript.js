window.onpopstate = function(event) {
         console.debug("pop");
         data = event.state;
         console.debug(data);
         $("#autoload").remove();
         $('<div>').attr('id','autoload').appendTo($("body"));
         $('#autoload').attr('data-do', data.url);
         $('#autoload').attr('data-target', data.target);
         PScript.UI.attachListeners();
         PScript.actions.do($('#autoload'), false);

     };
var __PSDO = 'menu';
var __PSTARGET = '#main';


var PScript = PScript || {
    
    PSCRIPTCONFIG:function(){},
        
    init : function() {
        console.debug("init");
     
     
     path = window.location.pathname;
     if(path!="/") {
         $("#autoload").remove();
         $('<div>').attr('id','autoload').appendTo($("body"));
         $('#autoload').attr('data-do', path.substr(1));
         $('#autoload').attr('data-target', __PSTARGET);
        PScript.actions.do($('#autoload'), false);   
     }
     
     history.pushState({url : __PSDO, target : __PSTARGET}, null, '/');
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
    do : function(elem, record) {
        elem = self.jQuery(elem);
        
        if(elem[0].hasAttribute("data-transition")) {
        } else {
            elem.data('transition','fade'); 
        }
        PScript.transition(elem, function() {
            self.jQuery(elem.data('target')).html(PScript.UI.loading());
        });
        
        if(elem.data('target')=='html') {   
            
            requestUrl = '/' + PScript.outputFolder + '/page/' + self.jQuery(elem).data('do') + PScript.ext;
        
        } else {
            requestUrl = '/' + PScript.outputFolder + '/' + self.jQuery(elem).data('do') + PScript.ext;
        }
            console.debug({url : __PSDO, target : __PSTARGET});
            if(record===undefined) {
                history.pushState({url : __PSDO, target : __PSTARGET}, null, '/'+elem.data('do'));
            }
            __PSDO = elem.data('do');
            __PSTARGET = elem.data('target');
        setTimeout(function() {
            
            console.debug(requestUrl);
        self.jQuery.ajax({
            url : requestUrl,
            success : function(html) {
                if(elem.data('target')=='html') {   
                    var newDoc = document.open("text/html", "replace");
                    newDoc.write(html);
                    newDoc.close();
                } else {
                    self.jQuery(self.jQuery(elem).data('target')).html(html);
                }
                
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
        
        if(elem.data('target')=='html') {        
            requestUrl = "http://" + remoteURI + '/' + PScript.outputFolder + '/page/' + self.jQuery(elem).data('post') + PScript.ext;
        } else {
            requestUrl = "http://" + remoteURI + '/' + PScript.outputFolder + '/' + self.jQuery(elem).data('post') + PScript.ext;
        }
        
        console.debug(requestUrl);
        setTimeout(function() {
            
            
        self.jQuery.post({
            url : requestUrl,
            data: postData,
            success : function(html) {
                if(elem.data('target')=='html') {   
                    var newDoc = document.open("text/html", "replace");
                    newDoc.write(html);
                    newDoc.close();
                } else {
                    self.jQuery(self.jQuery(elem).data('target')).html(html);
                }
                
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
