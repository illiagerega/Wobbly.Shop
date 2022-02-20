
// ========== Sidebar Mobile Menu 

jQuery(function($){

	// Create html structure for Sidebar Mobile Menu
	$(".umenu-menu ul").each(function (){
		var list = $(this);
		var item = list.parent()
		var link	= item.find("> a");
		var title = link.text();

		link.append("<span></span>");
		item.append(`<div class="umenu-submenu">
	                     <div class="umenu-submenu__content">
	                        <h3 class="umenu-submenu__title"></h3>
	                        <button class="umenu-submenu__back">Назад</button>
	                     </div>
	                  </div>`);

		var submenu = item.find("> .umenu-submenu");
			 submenu_content = submenu.find("> .umenu-submenu__content");
			 submenu_title = submenu_content.find("> .umenu-submenu__title");


		submenu_title.html(title);
		submenu_content.append(list.detach()).html();
	});


	// Create overlay layer
	$(".umenu").after('<div class="umenu-overlay"></div>')


	// Set group title, use`s attribute [group-name]
	$("[group-name]").each(function (){
		$(this).prepend('<li class="umenu-group__title">'+ $(this).attr("group-name") + '</li>');
	});


	// Opening Sidebar Menu
	$(".umenu-open, .umenu-overlay, .umenu-close").click(function (){
		$("body").toggleClass("umenu-active");
	});


	var transform = 0;

	// Opening Sidebar Menu Level 
	$(".umenu-menu a > span").on("click", function(){
			
		var item = $(this).parent().parent();
			 submenu = item.find("> .umenu-submenu");
		
		transform = transform + 40;

		$(".umenu__wrapper").css("transform", "translate3d(" + transform + "px , 0, 0)").addClass("deactive");
		submenu.css("transform", "translate3d(-" + 40 + "px , 0, 0)");
		submenu.parents(".umenu-submenu").addClass("deactive");	
		submenu.addClass("active");		

		return false;
	});


	// Closes Sidebar Menu Level by click on back button
	$(".umenu-submenu__back").on("click", function (){
		var item = $(this).parent().parent();
		item.removeClass("active");	

		transform = transform - 40;
		$(".umenu__wrapper").css("transform", "translate3d(" + transform + "px , 0, 0)");
		item.css("transform", "translate3d(-" + 100 + "% , 0, 0)");
		item.parents(".umenu-submenu").filter(':first').removeClass("deactive");

		if($(".umenu-submenu.active").length == 0){		
			$(".umenu__wrapper").removeClass("deactive");
		}
	});


	// Closes Sidebar Menu Level by click out of element
	$(document).mouseup(function (e){
		$(".umenu-submenu.active").each(function() {
			if(!$(this).hasClass("deactive")){
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0){
					$(this).removeClass("active");
					$(this).parents(".umenu-submenu").filter(':first').removeClass("deactive");
					$(this).css("transform", "translate3d(-" + 100 + "% , 0, 0)");
					transform = transform - 40;
					$(".umenu__wrapper").css("transform", "translate3d(" + transform + "px , 0, 0)");	
					if($(".umenu-submenu.active").length == 0){		
						$(".umenu__wrapper").removeClass("deactive");
					}	
				}		
			}
		});
	});


	// Closes Sidebar Menu Level by click on Overlay 
	$(".umenu-overlay").click(function (){
		$(".umenu-submenu").removeClass("active");
		$(".umenu-submenu").removeClass("deactive");
		$(".umenu-submenu").css("transform", "translate3d(-100%, 0, 0)");
		transform = 0; 
		$(".umenu__wrapper").removeClass("deactive");
		$(".umenu__wrapper").css("transform", "translate3d(" + transform + "px , 0, 0)");	
	});


	// Profile dropdown toggler
	$(".umenu-profile__title").click(function (){
		$(".umenu-profile").toggleClass("active");
		$(".umenu-profile").find("> ul").slideToggle();
	});
});
























































	