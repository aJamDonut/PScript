var PScript = PScript || {};
PScript.jQuery = jQuery;

PScript.UI = {
    loading : function() {
     return 'Loading...';   
    }
};

PScript.actions = {
    do : function(elem) {
        self.jQuery(self.jQuery(elem).data('target')).html(PScript.UI.loading());
        setTimeout(function() {
        self.jQuery.ajax({
            url : '/in/' + self.jQuery(elem).data('do'),
            success : function(html) {
                self.jQuery(self.jQuery(elem).data('target')).html(html);
            }
        });
        }, 2000);
    }
};

$(document).ready(function() {

    $("body").append("Engine loads");
    $("[data-do]").click(function() {

        PScript.actions.do(this);

    });
});
