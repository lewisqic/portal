function _classCallCheck(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}var _createClass=function(){function e(e,n){for(var a=0;a<n.length;a++){var i=n[a];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(n,a,i){return a&&e(n.prototype,a),i&&e(n,i),n}}(),Remark=function(){function e(){_classCallCheck(this,e),this.init()}return _createClass(e,[{key:"init",value:function(){this.bindEvents(),this.initScrollbar(),this.initSidebar()}},{key:"bindEvents",value:function(){var e=this;$(".toggle-sidebar").on("click",function(n){n.preventDefault(),e.toggleSidebar()}),$(".sidebar .dropdown-toggle").on("click",function(n){n.preventDefault(),e.showDropdown(this)}),$(".configurator .handle").on("click",function(n){n.preventDefault(),e.toggleConfigurator()}),$('.configurator #color input[name="primary_color"]').on("change",function(n){e.changePrimaryColor($(this).val())}),$('.configurator #style input[name="sidebar_skin"]').on("change",function(n){e.changeSidebarSkin($(this).val())}),$('.configurator #style input[name="navbar_type"]').on("change",function(n){e.toggleNavbarType()})}},{key:"initScrollbar",value:function(){$("body").hasClass("sidebar-minimized")||$(".sidebar-scrollbar").mCustomScrollbar({autoHideScrollbar:!0,theme:$("body").hasClass("sidebar-dark")?"minimal-dark":"minimal"})}},{key:"initSidebar",value:function(){var e=$(".sidebar .nav-item.dropdown .dropdown-item.active:first");e.length&&e.closest(".nav-item.dropdown").addClass("open")}},{key:"showDropdown",value:function(e){var n=$(e);$(".sidebar .dropdown.open .dropdown-menu").not(n.next(".dropdown-menu")).slideUp("fast",function(){$(".sidebar .dropdown").not(n.parent(".dropdown")).removeClass("open")}),n.next(".dropdown-menu").is(":visible")?n.next(".dropdown-menu").slideUp("fast",function(){n.parent(".dropdown").removeClass("open")}):(n.next(".dropdown-menu").slideDown("fast"),n.parent(".dropdown").addClass("open"))}},{key:"toggleConfigurator",value:function(){var e=$(".configurator");e.animate({right:"0px"==e.css("right")?"-220px":"0px"},"fast"),$(this).toggleClass("open")}},{key:"toggleSidebar",value:function(){var e=this;$("body").toggleClass("sidebar-minimized"),$("body").hasClass("sidebar-minimized")?($(".sidebar .nav-item.open .dropdown-menu").hide(),$(".sidebar .nav-item.open").removeClass("open"),$(".sidebar-scrollbar").mCustomScrollbar("destroy")):e.initScrollbar(),e.saveSetting("sidebar_minimized",$("body").hasClass("sidebar-minimized")?1:0)}},{key:"changePrimaryColor",value:function(e){var n=this,a=$("#skin_css").attr("href"),i=a.replace(/skins\/.*\.css/,"skins/"+e+".css");$("#skin_css").attr("href",i),n.saveSetting("primary_color",e)}},{key:"changeSidebarSkin",value:function(e){var n=this;$('.configurator #style input[name="sidebar_skin"]').each(function(){$("body").removeClass("sidebar-"+$(this).val())}),$("body").addClass("sidebar-"+e),$(".sidebar-scrollbar").mCustomScrollbar("destroy"),n.initScrollbar(),n.saveSetting("sidebar_skin",e)}},{key:"toggleNavbarType",value:function(){var e=this;$("body").toggleClass("navbar-inverse"),e.saveSetting("navbar_inverse",$("body").hasClass("navbar-inverse")?1:0)}},{key:"saveSetting",value:function(e,n){var a=$.url().attr("path").match(/^\/admin/)?"admin":"account";$.ajax({url:Core.url(a+"/remark-setting"),method:"POST",data:{key:e,value:n}})}}]),e}();$(function(){new Remark});