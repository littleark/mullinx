/**
 * Multi Directional link jQuery plugin
 * @name mullinx.js
 * @version 0.2
 * @author Carlo Zapponi - info@makinguse.com
 * @site http://mullinx.makinguse.com
 * @date October 2, 2008
 * @category jQuery plugin
 * @license CC Attribution-Share Alike 2.5 Italy - http://creativecommons.org/licenses/by-sa/2.5/it/
 * @example Visit http://mullinx.makinguse.com for more informations about this jQuery plugin
 * @requires jQuery 1.2+
 */
(function($) {
	var jq=jQuery;
	jq.fn.mullinx = function(options) {
		
		var options = jq.extend({},jq.fn.mullinx.defaults,options);
		var tm=new Date().getTime();
		
		return this.each(function(index,el) {
				
			var $this=jQuery(this);
			
			$this.status="bottom";
			var pos=$this.offset();
			
			var dim={
				w:$this.width(),
				h:$this.height()
			};
			var mudim={};
			var addresses=$this.attr("rev").split(options.separator);
			
			if(addresses.length>0 && addresses[0]!="") {
				
				var mux=jq("<div></div>").attr("id","mux_"+index+"_"+tm).css({
					position:"absolute",
					top:pos.top+dim.h+"px",
					backgroundColor:"transparent",
					display:"none",
					fontFamily:options.fontFamily,
					letterSpacing:"-0.025em",
					fontWeight:"bold",
					//textShadow:"#555 1px 1px 2px", //works in safari
					fontSize:options.fontSize
				}).bind("mouseleave",function(e){
					mux.hide();
				});
				
				
				var links="<li><a href=\""+$this.attr("href")+"\" style=\"color:"+options.color+";display:block;text-decoration:none;white-space:nowrap;\" target=\""+$this.attr("target")+"\">"+$this.html()+"</a></li>";
				jq.each(addresses,function(){
					var $link=this.split(options.sub_separator);
					links+="<li style=\"margin:2px 0;\"><a href=\""+jq.trim($link[0])+"\" style=\"color:"+options.color+";display:block;text-decoration:none;white-space:nowrap;\" target=\""+$this.attr("target")+"\">"+jq.trim(($link[1]?$link[1]:$link[0]))+"</a></li>";
				});
				
				links="<ul style=\"margin:0;padding:0;list-style:none;list-style-image:none;\">"+links+"</ul>";
				
				jq(mux).roundbox({
					id:"mux_"+index+"_"+tm+"_rc",
					content:links,
					bgcolor:options.bgcolor,
					opacity:options.opacity
				});
				
				mux.appendTo(jq(document.body));
				
				mux.find("li a").hover(function() {
					jq(this).css({
						"text-decoration":"underline",
						color:options.hoverColor
					});
				},
				function() {
					jq(this).css({
						"text-decoration":"none",
						color:options.color
					});
				}).click(function(e){
					mux.hide();
				});
				function reverseSorting() {
					//resort link list in the box top->bottom / bottom->top
					mux.find("ul li").each(function(){
						$(this).prependTo($(this).parent());
					});
				}
				function switchVPosition(deltaY) {
					//function used to switch mullinx arrow depending on the position 
					//of the box: above/below the link
					if(deltaY<0) {
						if($this.status!="top") {
							reverseSorting();
							$this.status="top";
							mux.find("div.arrow").css({
								top:mudim.h+"px",
								height:"12px"
							}).find("span").eq(0).html("v").css({
								top:"-52px",
								marginLeft:"11px"
							});
						}
					} else {
						if($this.status!="bottom") {
							reverseSorting();
							$this.status="bottom";
							mux.find("div.arrow").css({
								top:"-8px",
								height:"8px"
							}).find("span").eq(0).html("A").css({
								top:"0px",
								marginLeft:"0px"
							});
						}
					}
				};
				
				jq("<div></div>").addClass("arrow").html("<span style=\"position:relative;top:0px;margin-left:0px;\">A</span>").css({
					position:"absolute",
					color:options.bgcolor,
					width:"40px",
					left:"-15px",
					top:"-8px",
					height:"8px",
					fontSize:"86px",
					lineHeight:"56px",
					fontFamily:"Times New Roman",
					fontWeight:"bold",
					overflow:"hidden",
					opacity:options.opacity
				}).appendTo("#"+mux.attr("id")+"_rc");

				$this.bind("mouseenter",function(e){
					pos=$this.offset();
					mux.show();
					mudim=(mudim.w)?mudim:{w:mux.children("div").eq(0).width(),h:mux.children("div").eq(0).height()}
					var delta=jq(window).width()-(pos.left+mudim.w);
					
					var deltaY = window.pageYOffset
					|| document.documentElement.scrollTop
					|| document.body.scrollTop
					|| 0;
					deltaY=(jq(window).height()+deltaY)-(pos.top+dim.h+mudim.h)
					switchVPosition(deltaY);
					
					mux.css({
						left:pos.left+(delta<0?(delta-5):0)+"px",
						width:mudim.w+"px",
						top:(deltaY<0)?(pos.top-19-mudim.h+"px"):(pos.top+dim.h+"px")
					}).children("div").eq(0).css({
						top:"8px"
					}).children("div.arrow").eq(0).css({
						left:(delta<0?(-delta):-15)+"px"
					});
					
				}).bind("mouseleave",function(e){
					if($this.status=='bottom' && !(e.pageY>=pos.top+dim.h))
						mux.hide();
					if($this.status=='top' && !(e.pageY<=pos.top))
						mux.hide();
				});
				
				jq(window).resize(function(e){
					pos=$this.offset();
					mux.css({
						top:pos.top+dim.h+"px"
					});
				});
			}
		});
	};

	jQuery.fn.roundbox=function() {
		// this is a jquery plugin with my personal rounded corners implementation,
		// the same I've used in PodiPodi.com
		var options = jQuery.extend({
			bgcolor:"#000",
			color:"#fff",
			opacity:0.8
		}, arguments[0] || {});
		
		var html="<em class=\"ctl\"><b>&bull;</b></em><em class=\"ct\">&nbsp;</em><em class=\"ctr\"><b>&bull;</b></em><em class=\"cl\">&nbsp;</em><em class=\"c_box\">&nbsp;</em><em class=\"cr\">&nbsp;</em><em class=\"cbl\"><b>&bull;</b></em><em class=\"cb\">&nbsp;</em><em class=\"cbr\"><b>&bull;</b></em>"+
		"<div style=\"z-index:1002;margin:5px;padding:8px;color:"+options.color+";position:relative;\">"+options.content+"</div><div style=\"clear:both;\"></div>";
		
		var rc=jQuery("<div>"+html+"</div>").attr("id",options.id).css("position","absolute").appendTo(this).children(".ctl,.ctr,.cbl,.cbr").css({
			width:"6px",
			height:"6px",
			color:options.bgcolor,
			background:"transparent",
			overflow:"hidden",
			fontStyle:"normal",
			zIndex:1
		}).end().find("em").css({
			position:"absolute",
			zIndex:1001,
			color:options.bgcolor,
			opacity:options.opacity
		}).end().find(".ct,.cr,.cb,.cl,.c_box").css("background",options.bgcolor).end().find(".ct").css({
			top:"0",
			height:"6px",
			left:"6px",
			right:"6px"
		}).end().find(".cl").css({
			top:"6px",
			width:"6px",
			left:"0",
			bottom:"6px"
		}).end().find(".c_box").css({
			top:"6px",
			bottom:"6px",
			left:"6px",
			right:"6px"
		}).end().find(".cr").css({
			top:"6px",
			bottom:"6px",
			width:"6px",
			right:"0"
		}).end().find(".cb").css({
			height:"6px",
			bottom:"0",
			left:"6px",
			right:"6px"
		}).end().find(".ctl").css({
			top:"0",
			left:"0",
			height:"6px"
		}).end().find(".cbl").css({
			bottom:"0",
			left:"0"
		}).end().find(".ctr").css({
			top:"0",
			right:"0",
			height:"6px"
		}).end().find(".cbr").css({
			bottom:"0",
			right:"0"
		}).end().find("em b").css({
			position:"absolute",
			fontSize:"60px",
			fontFamily:"arial",
			lineHeight:"16px",
			fontWeight:"normal",
			color:options.bgcolor
		}).end().find(".ctl b").css({
			left:"-3px",
			top:"0px"
		}).end().find(".ctr b").css({
			left:"-12px",
			top:"0"
		}).end().find(".cbl b").css({
			left:"-3px",
			top:"-9px",
			bottom:"0"
		}).end().find(".cbr b").css({
			left:"-12px",
			top:"-9px",
			bottom:"0"
		}).end();
		
		// workaround for IE6 in order to see the background
		// same technique used on PodiPodi.com
		if (jQuery.browser.msie && jQuery.browser.version<7) {
			rc.css("background-color",options.bgcolor);
		}
		
		return this;
	};
	// mullinx default options
	jq.fn.mullinx.defaults = {
		separator:";",
		sub_separator:"|",
		bgcolor:"#000",
		color:"#fff",
		hoverColor:"#ffff00",
		opacity:0.9,
		fontSize:"0.8em",
		fontFamily:"Arial"
	};
})(jQuery);
