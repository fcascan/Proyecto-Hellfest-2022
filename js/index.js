// import { disablePageScroll, enablePageScroll } from "scroll-lock.js";
// import lightSlider from "lightslider.js";

$(document).ready(() => {
	//Funcion que realiza el efecto parralax en los scrollDiv:
	$(window).scroll(function () {
		var wScroll = $(this).scrollTop();
		$(".scrollDiv1").css({
			transform: "translateX(" + -(wScroll / 6 - 70) + "vw)",
		});
		$(".scrollDiv2").css({
			transform: "translateX(" + -(wScroll / 6 - 400) + "vw)",
		});
		$(".scrollDiv3").css({
			transform: "translateX(" + -(wScroll / 6 - 600) + "vw)",
		});
	});

	//Funciones que configuran al lightslider (Carousel):
	$("#lightSlider").lightSlider(); 
	$("#content-slider").lightSlider({
		loop: false,
		keyPress: true,
	});
	$("#autoWidth").lightSlider({
		autoWidth: true,
		loop: true,
		onSliderLoad: function () {
			$("#autoWidth").removeClass("cS-hidden");
		},
	});
	//Funciones que realizan el avance y retroceso de Slides del carousel:
	var slider = $("#publicMethods").lightSlider({
		slideMargin: 4,
		slideWidth: 200,
		loop: false,
	});
	$("#goToPrevSlide").click(function () {
		slider.goToPrevSlide();
	});
	$("#goToNextSlide").click(function () {
		slider.goToNextSlide();
	});

	//Funcion que realiza el efecto de telón que sube al cargar la pagina:
	function moveCurtain() {
		const element = document.getElementById("curtain");
		let pos = 0;
		let tInterval = setInterval(frame, 13);
		function frame() {
			if (pos == 100) {
				enablePageScroll($scrollableElement);
				element.style.display = "none";
				clearInterval(tInterval);
			} else {
				// disablePageScroll($scrollableElement);
				pos--;
				element.style.top = pos + "%";
			}
		}
	}
	var $scrollableElement = document.querySelector("body");
	moveCurtain();
});

//Efecto parallax usado para el fondo del FAQ:
document.addEventListener("mousemove", parallax);
function parallax(event) {
	this.querySelectorAll(".mouse").forEach((shift) => {
		const position = shift.getAttribute("value");
		const x = -25 + (window.innerWidth - event.pageX * position) / 70;
		const y = -450 + (window.innerHeight - event.pageY * position) / 70;
		shift.style.transform = `translateX(${x}px) translateY(${y}px)`;
	});
}
