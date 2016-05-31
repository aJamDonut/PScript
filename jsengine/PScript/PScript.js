function addJS(jsCode) {
    var s = document.createElement('script');

    s.type = 'text/javascript';
    s.innerText = jsCode;
    document.getElementsByTagName('head')[0].appendChild(s);
}

loadedUrls = [];
var requestUrl = "";
function addJSURL(jsCode) {
    if(loadedUrls.indexOf(jsCode)==-1) {
    var s = document.createElement('script');

    s.type = 'text/javascript';
    s.src = jsCode;
    document.getElementsByTagName('head')[0].appendChild(s);
    loadedUrls.push(jsCode);
    }
}

window.onpopstate = function(event) {
         console.debug("pop");
         data = event.state;
         console.debug(data.url);
         $("#autoload").remove();
         $('<div>').attr('id','autoload').appendTo($("body"));
         $('#autoload').attr('data-do', data.url);
         $('#autoload').attr('data-target', data.target);
         PScript.UI.attachListeners();
         PScript.actions.do($('#autoload'), false);
     };
var __PSDO = 'get_yummy';
var __PSTARGET = '#main';
var __PSLOADING = false;
function PSCRIPT_PUSH(o,n,e) {
    history.pushState(o, n, e);
    console.debug("Name: "+e);
}

var PScript = PScript || {
    
    PSCRIPTCONFIG:function(){},
        
    init : function() {
        console.debug("init");
     PScript.delay = 450;
     
     path = window.location.pathname;
     if(path!="/") {
         $("#autoload").remove();
         $('<div>').attr('id','autoload').appendTo($("body"));
         $('#autoload').attr('data-do', path.substr(1));
         $('#autoload').attr('data-target', __PSTARGET);
         __PSDO = path.substr(1);

        PScript.actions.do($('#autoload'), undefined, function(){console.debug("hideloader"); $("#loader").fadeOut('fast');});
     } else {
         console.debug('fadeloadermain');
        $("#loader").fadeOut('fast');
        PSCRIPT_PUSH({url : __PSDO, target : __PSTARGET}, null, '/');
            

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
                container.slideDown();
            break;
        }
        callback();
    }

};
PScript.jQuery = jQuery;

PScript.UI = {
    loading : function(elem) {
        if(loading==true) {
            self.jQuery(elem.data('target')).html('Loading...');
        } 
    },
    attachListeners: function() {
        $("[data-do]").off();
        $("[data-post]").off();
        $("[data-do]").click(function() {
            PScript.actions.do(this);
        });
        $("[data-post]").click(function() {
            PScript.actions.post(this);
        });
    }
};

PScript.actions = {
    do : function(elem, record, loader) {
        elem = self.jQuery(elem);
        
        if(elem.data('target')!=="#main") {
            record=false;
        }
        
        if(elem[0].hasAttribute("data-transition")) {
        } else {
            elem.data('transition','slide'); 
        }
        loading=true;
        if(loader===undefined) {
            
            PScript.transition(elem, function() {
                PScript.UI.loading(elem);
                
            });
        }
        if(elem.data('target')=='html') {   
            
            requestUrl = '/' + PScript.outputFolder + '/page/' + self.jQuery(elem).data('do') + PScript.ext;
        
        } else {
            requestUrl = '/' + PScript.outputFolder + '/' + self.jQuery(elem).data('do') + PScript.ext;
        }
            console.debug({url : __PSDO, target : __PSTARGET});
            if(record===undefined) {
                PSCRIPT_PUSH({url : __PSDO, target : __PSTARGET}, null, '/'+elem.data('do'));
            }
            __PSDO = elem.data('do');
            __PSTARGET = elem.data('target');
        setTimeout(function() {
            
            console.debug(requestUrl);
        self.jQuery.ajax({
            url : requestUrl,
            success : function(html) {
                loading=false;
                if(elem.data('target')=='html') {   
                    var newDoc = document.open("text/html", "replace");
                    newDoc.write(html);
                    newDoc.close();
                } else {
                    self.jQuery(self.jQuery(elem).data('target')).html(html);
                }
                
                PScript.UI.attachListeners();
                
                PScript.endTransition(elem, function(){});
                if(loader!==undefined) {
                   loader();   
                }
            }
        });
        }, PScript.delay);
    },
    post : function(elem, record) {
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
        
        console.debug({url : __PSDO, target : __PSTARGET});
        
        if(record===undefined) {
            PSCRIPT_PUSH({url : __PSDO, target : __PSTARGET}, null, '/'+elem.data('post'));
        }
        __PSDO = elem.data('do');
        __PSTARGET = elem.data('target');
        
        console.debug(requestUrl);
        setTimeout(function() {
            
            console.debug(requestUrl);
        self.jQuery.post({
            url : requestUrl,
            data: postData,
            success : function(html) {
                console.debug("got");
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
        }).always(function() {
            console.debug("did"+requestUrl);
        });
        }, PScript.delay);
    }
};
var $PS = null;
$(document).ready(function() {
   $PS = PScript.init();
});
