// Подключение функционала "Чертоги Фрилансера"
import { isMobile } from "./functions.js";
// Подключение списка активных модулей
import { flsModules } from "./modules.js";

document.addEventListener("click", documentActions);

function documentActions(e) {
	const targetElement = e.target;
	if (targetElement.closest('.top__user')) {
		document.querySelector('.top__drop-menu').classList.add('topmenu-open')
	} else {
		// document.querySelector('.top__drop-menu').classList.remove('topmenu-open')
		document.querySelector('.top__drop-menu') ? document.querySelector('.top__drop-menu').classList.remove('topmenu-open') : null
	}
	
	if (targetElement.closest('.main-bottom__button_menu')) {
		document.querySelector('.main-bottom__sublist').classList.add('exportmenu-open')
	} else {
		// document.querySelector('.main-bottom__sublist').classList.remove('exportmenu-open')
		document.querySelector('.main-bottom__sublist') ? document.querySelector('.main-bottom__sublist').classList.remove('exportmenu-open') : null
	}
}