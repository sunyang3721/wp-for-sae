!function($){function scrollTo(a,b){b||(b=300),a?$(a).length>0&&$("html,body").animate({scrollTop:$(a).offset().top},b):$("html,body").animate({scrollTop:0},b)}function exit_prev_edit(){$new_comm.show(),$new_sucs.show(),$("textarea").each(function(){this.value=""}),edit=""}function countdown(){wait>0?($submit.val(wait),wait--,setTimeout(countdown,1e3)):($submit.val(submit_val).attr("disabled",!1).fadeTo("slow",1),wait=15)}var elments,rollFirst,sheight,islogin,edit,txt1,txt2,txt3,cancel_edit,num,comm_array,wait,submit_val;with($("body").append('<div class="rollto"><a href="javascript:;"></a></div>'),$(".content .avatar").lazyload({placeholder:jui.uri+"/images/avatar-default.png",event:"scrollstop"}),$(".sidebar .avatar").lazyload({placeholder:jui.uri+"/images/avatar-default.png",event:"scrollstop"}),$(".content .thumb").lazyload({placeholder:jui.uri+"/images/thumbnail.png",event:"scrollstop"}),$(".sidebar .thumb").lazyload({placeholder:jui.uri+"/images/thumbnail.png",event:"scrollstop"}),$(".content .wp-smiley").lazyload({event:"scrollstop"}),$(".sidebar .wp-smiley").lazyload({event:"scrollstop"}),elments={sidebar:$(".sidebar"),footer:$(".footer")},$(".feed-weixin").popover({placement:"right",trigger:"hover",container:"body",html:!0}),elments.sidebar&&(rollFirst=elments.sidebar.find(".widget:eq("+(Number(jui.roll[0])-1)+")"),sheight=rollFirst.height(),rollFirst.on("affix-top.bs.affix",function(){var a,b,c;for(rollFirst.css({top:0}),sheight=rollFirst.height(),a=1;a<jui.roll.length;a++)b=Number(jui.roll[a])-1,c=elments.sidebar.find(".widget:eq("+b+")"),c.removeClass("affix").css({top:0})}),rollFirst.on("affix.bs.affix",function(){var a,b,c;for(rollFirst.css({top:20}),a=1;a<jui.roll.length;a++)b=Number(jui.roll[a])-1,c=elments.sidebar.find(".widget:eq("+b+")"),c.addClass("affix").css({top:sheight+30}),sheight+=c.height()+20}),rollFirst.affix({offset:{top:elments.sidebar.height(),bottom:(elments.footer.height()||0)+10}})),$(".excerpt header small").each(function(){$(this).tooltip({container:"body",title:"此文有 "+$(this).text()+"张 图片"})}),$(".article-tags a, .post-tags a").each(function(){$(this).tooltip({container:"body",placement:"bottom",title:"查看关于 "+$(this).text()+" 的文章"})}),$(".cat").each(function(){$(this).tooltip({container:"body",title:"查看关于 "+$(this).text()+" 的文章"})}),$(".widget_tags a, .slinks a, .feed-weibo, .feed-tqq, .feed-rss").tooltip({container:"body"}),$(".readers a, .widget_comments a").tooltip({container:"body",placement:"top"}),$(".article-meta li:eq(1) a").tooltip({container:"body",placement:"bottom"}),$(".post-edit-link").tooltip({container:"body",placement:"right",title:"去后台编辑此文章"}),$(".article-content").length&&$(".article-content img").attr("data-tag","bdshare"),window._bd_share_config={common:{bdText:"",bdMini:"2",bdMiniList:!1,bdPic:"",bdStyle:"0",bdSize:"24"},share:[{bdCustomStyle:jui.uri+"/css/share.css"}]},document)0[(getElementsByTagName("head")[0]||body).appendChild(createElement("script")).src="http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion="+~(-new Date/36e5)];$(".rollto a").on("click",function(){scrollTo()}),$(window).scroll(function(){var a=$(".rollto");document.documentElement.scrollTop+document.body.scrollTop>200?a.fadeIn():a.fadeOut()}),islogin=!1,$("body").hasClass("logged-in")&&(islogin=!0),$(document).on("click",function(a){var b,c,d,e,f;if(a=a||window.event,b=a.target||a.srcElement,c=$(b),!c.hasClass("disabled"))switch(c.parent().attr("data-event")&&(c=$(c.parent()[0])),c.parent().parent().attr("data-event")&&(c=$(c.parent().parent()[0])),d=c.attr("data-event")){case"like":if(e=c.attr("data-pid"),!e||!/^\d{1,10}$/.test(e))return;if(!islogin){if(f=LS.get("_likes")||"",-1!==f.indexOf(","+e+","))return alert("你已赞！");f?f.length>=160?(f=f.substring(0,f.length-1),f=f.substr(1).split(","),f.splice(0,1),f.push(e),f=f.join(","),LS.set("_likes",","+f+",")):LS.set("_likes",f+e+","):LS.set("_likes",","+e+",")}$.ajax({url:jui.uri+"/actions/index.php",type:"POST",dataType:"json",data:{key:"like",pid:e},success:function(a){return a.error?!1:(c.toggleClass("actived"),c.find("span").html(a.response),void 0)},error:function(){}});break;case"comment-user-change":$("#comment-author-info").slideDown(300),$("#comment-author-info input:first").focus();break;case"login":$("#modal-login").modal("show")}}),$(".commentlist .url").attr("target","_blank"),txt1='<div class="comt-tip comt-loading">正在提交, 请稍候...</div>',txt2='<div class="comt-tip comt-error">#</div>',txt3='">',cancel_edit="取消编辑",num=1,comm_array=[],comm_array.push(""),$comments=$("#comments-title"),$cancel=$("#cancel-comment-reply-link"),cancel_text=$cancel.text(),$submit=$("#commentform #submit"),$submit.attr("disabled",!1),$(".comt-tips").append(txt1+txt2),$(".comt-loading").hide(),$(".comt-error").hide(),$body=window.opera?"CSS1Compat"==document.compatMode?$("html"):$("body"):$("html,body"),$("#commentform").submit(function(){return $(".comt-loading").show(),$submit.attr("disabled",!0).fadeTo("slow",.5),edit&&$("#comment").after('<input type="text" name="edit_id" id="edit_id" value="'+edit+'" style="display:none;" />'),$.ajax({url:jui.uri+"/modules/comment.php",data:$(this).serialize(),type:$(this).attr("method"),error:function(a){$(".comt-loading").hide(),$(".comt-error").show().html(a.responseText),setTimeout(function(){$submit.attr("disabled",!1).fadeTo("slow",1),$(".comt-error").fadeOut()},3e3)},success:function(a){$(".comt-loading").hide(),comm_array.push($("#comment").val()),$("textarea").each(function(){this.value=""});var b=addComment,c=b.I("cancel-comment-reply-link"),d=b.I("wp-temp-form-div"),e=b.I(b.respondId),g=(b.I("comment_post_ID").value,b.I("comment_parent").value);!edit&&$comments.length&&(n=parseInt($comments.text().match(/\d+/)),$comments.text($comments.text().replace(n,n+1))),new_htm='" id="new_comm_'+num+'"></',new_htm="0"==g?'\n<ol style="clear:both;" class="commentlist commentnew'+new_htm+"ol>":'\n<ul class="children'+new_htm+"ul>",ok_htm='\n<span id="success_'+num+txt3,ok_htm+="</span><span></span>\n","0"==g?$("#postcomments .commentlist").length?$("#postcomments .commentlist").before(new_htm):$("#respond").after(new_htm):$("#respond").after(new_htm),$("#comment-author-info").slideUp(),$("#new_comm_"+num).hide().append(a),$("#new_comm_"+num+" li").append(ok_htm),$("#new_comm_"+num).fadeIn(1e3),$body.animate({scrollTop:$("#new_comm_"+num).offset().top-200},500),$(".comt-avatar .avatar").attr("src",$(".commentnew .avatar:last").attr("src")),countdown(),num++,edit="",$("*").remove("#edit_id"),c.style.display="none",c.onclick=null,b.I("comment_parent").value="0",d&&e&&(d.parentNode.insertBefore(e,d),d.parentNode.removeChild(d))}}),!1}),addComment={moveForm:function(a,b,c,d,e){var g,f=this,h=f.I(a),i=f.I(c),j=f.I("cancel-comment-reply-link"),k=f.I("comment_parent"),l=f.I("comment_post_ID");edit&&exit_prev_edit(),e?(f.I("comment").value=comm_array[e],edit=f.I("new_comm_"+e).innerHTML.match(/(comment-)(\d+)/)[2],$new_sucs=$("#success_"+e),$new_sucs.hide(),$new_comm=$("#new_comm_"+e),$new_comm.hide(),$cancel.text(cancel_edit)):$cancel.text(cancel_text),f.respondId=c,d=d||!1,f.I("wp-temp-form-div")||(g=document.createElement("div"),g.id="wp-temp-form-div",g.style.display="none",i.parentNode.insertBefore(g,i)),h?h.parentNode.insertBefore(i,h.nextSibling):(temp=f.I("wp-temp-form-div"),f.I("comment_parent").value="0",temp.parentNode.insertBefore(i,temp),temp.parentNode.removeChild(temp)),$body.animate({scrollTop:$("#respond").offset().top-180},400),l&&d&&(l.value=d),k.value=b,j.style.display="",j.onclick=function(){edit&&exit_prev_edit();var a=addComment,b=a.I("wp-temp-form-div"),c=a.I(a.respondId);return a.I("comment_parent").value="0",b&&c&&(b.parentNode.insertBefore(c,b),b.parentNode.removeChild(b)),this.style.display="none",this.onclick=null,!1};try{f.I("comment").focus()}catch(m){}return!1},I:function(a){return document.getElementById(a)}},wait=15,submit_val=$submit.val()}(jQuery);