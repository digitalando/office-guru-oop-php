var btnMenu = document.getElementById('menu-mobile');
//var backdrop = document.getElementById('backdrop');
var menu = document.getElementById('headernav-menu');

btnMenu.onclick = function() {
	//console.log(menu);
	if(menu.className == 'headernav-menu'){
		menu.className = 'headernav-menu is-visible';
	}
	else {
		menu.className = 'headernav-menu';	
	}
	
};


/*backdrop.onclick = function() {
	menuMobile.className = 'menu';
};*/ 