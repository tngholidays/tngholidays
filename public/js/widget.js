
 (function(document, undefined) {
    var host = typeof window.host !== "undefined" ? window.host : "https://tngholidays.com";
    var hg_widget = {

        host: typeof window.host !== "undefined" ? window.host : "https://tngholidays.com",
        init: function() {
            var thisWidget = this;
            var cssId = 'myCss';  // you could encode the css path itself to generate id..
                if (!document.getElementById(cssId))
                {
                    var head  = document.getElementsByTagName('head')[0];
                    var link  = document.createElement('link');
                    link.id   = cssId;
                    link.rel  = 'stylesheet';
                    link.type = 'text/css';
                    link.href = 'https://tngholidays.com/css/widget.css?_ver=1.4.3';
                    link.media = 'all';
                    head.appendChild(link);
                }
            var host = typeof window.host !== "undefined" ? window.host : "https://tngholidays.com";
            var div = '<div style="width:230px;"><a class="hg_widget_button" href="javascript:void(0)">TNG Enquery</a></div>';
            var theDiv = document.getElementById("tng-widget");
            theDiv.innerHTML = div;
            theDiv.onclick = function() {
                thisWidget.openModal();
            };
        },
        openModal: function() {
            var htmlBody = document.getElementsByTagName("body");
            document.body.classList.add("customModal-open");
            var divModel = '<div class="customModal customFade show in" id="mycustomModal" role="dialog"> <div class="customModal-dialog"> <div class="customModal-content"> <div class="customModal-header"> <button type="button" class="close" id="closeModal" data-dismiss="customModal">&times;</button> </div> <div class="customModal-body"> <iframe loading="lazy" width="100%" height="650" src="'+host+'/embed_enquiry" frameborder="0" allowfullscreen=""></iframe> </div> </div> </div> </div> <div class="customModal-backdrop customFade in" id="customModal-backdrop"></div>';
            var z = document.createElement('div'); // is a node
            z.setAttribute("id", "customModal");
            z.innerHTML = divModel;
            htmlBody[0].appendChild(z);

            document.getElementById("closeModal").onclick = function() {
                var element = document.getElementById("customModal");
                document.body.classList.remove("customModal-open");
                element.remove();
            };
        }
    };
    if (typeof window.hg_widget !== "undefined") {
        window.hg_widget = hg_widget;
    }
    hg_widget.init();
})(document);