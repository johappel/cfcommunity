jQuery(document).ready(function(t){function e(){regexp=new RegExp("&lt;!--:"+u+"--&gt;(.*?)&lt;!--:--&gt;","i"),t(".item-title").each(function(){void 0==t(this).data("qt-value")&&t(this).data("qt-value",t(this).html()),(matches=t(this).data("qt-value").match(regexp))&&(t(this).html(matches[1]),t(this).closest("li").find(".link-to-original a").text(matches[1]))}),regexp=new RegExp("<!--:"+u+"-->(.*?)<!--:-->","i"),t("input.edit-menu-item-title").each(function(){void 0==t(this).data("qt-value")&&t(this).data("qt-value",t(this).val()),(matches=t(this).data("qt-value").match(regexp))&&t(this).val(matches[1])}),t("label.menu-item-title").each(function(){var e=t(this).contents().get(1);void 0==t(this).data("qt-value")&&t(this).data("qt-value",e.nodeValue),(matches=t(this).data("qt-value").match(regexp))&&(e.nodeValue=" "+matches[1])})}function a(){t("input.edit-menu-item-title").each(function(){t(this).val(t(this).data("qt-value"))})}var i=wpNavMenu.addMenuItemToBottom;wpNavMenu.addMenuItemToBottom=function(t,a){i(t,a),e()};var n=wpNavMenu.addMenuItemToTop;wpNavMenu.addMenuItemToTop=function(t,a){n(t,a),e()};var u=t("#qt-languages :radio:checked").val();e(),t(document).ajaxComplete(function(){u=t("#qt-languages :radio:checked").val(),e()}),t("#qt-languages :radio").change(function(){u=t("#qt-languages :radio:checked").val(),e()}),t(".submit-add-to-menu").click(function(){u=t("#qt-languages :radio:checked").val(),e()}),t(document.body).on("change","input.edit-menu-item-title",null,function(){regexp=new RegExp("(<!--:"+u+"-->)(.*?)(<!--:-->)","i"),regexp.test(t(this).data("qt-value"))?t(this).data("qt-value",t(this).data("qt-value").replace(regexp,"$1"+t(this).val()+"$3")):t(this).data("qt-value",t(this).val())}),t(".menu-save").click(function(){a()}),window.onbeforeunload=function(){a()}});