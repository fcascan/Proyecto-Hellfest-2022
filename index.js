import { disablePageScroll, enablePageScroll } from "/js/scroll-lock.js"

$(document).ready(function () {
	//Funcion que realiza el efecto parralax en los scrollDiv:
	$(window).scroll(function () {
		var wScroll = $(this).scrollTop();
		$(".scrollDiv1").css({
			transform: "translateX(" + -(wScroll / 7 - 70) + "vw)",
		});
		$(".scrollDiv2").css({
			transform: "translateX(" + -(wScroll / 7 - 370) + "vw)",
		});
		$(".scrollDiv3").css({
			transform: "translateX(" + -(wScroll / 7 - 530) + "vw)",
		});
	});

	//Funciones que configuran al lightslider (Carousel):
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
	var $scrollableElement = document.querySelector('body');
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
