var GenesisAjaxPosts=function(e){var n=posts_object.ajaxurl,a=posts_object.action,o=posts_object._ajax_nonce,r=!1,i=null,c=1;function s(){var t=i.find(".pagination"),n=t.find(".prev").first(),a=t.find(".next").first(),o=t.find("a.page-numbers");a.click(function(t){return t.stopPropagation(),c++,u(),!1}),n.click(function(t){return t.stopPropagation(),c--,u(),!1}),o.click(function(t){return t.preventDefault(),c=e(t.target).attr("data-target"),u(),!1})}function u(){if(r)return!1;var t={action:a,_ajax_nonce:o,paged:c};i.addClass("loading"),r=!0,jQuery.get(n,t,function(t){i.html(t.data.html),i.removeClass("loading"),s(),r=!1})}e(document).ready(function(){i=jQuery("#posts-container"),s()})}(jQuery);