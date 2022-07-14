//Actualizador de montos en tiempo real:
let quantity1 = document.getElementById("quantity1");
let pass1 = document.getElementById("pass1");
let price1 = document.getElementById("priceSpan1");
let individualPrice1 = document.getElementById("individualPrice1");

let quantity2 = document.getElementById("quantity2");
let pass2 = document.getElementById("pass2");
let price2 = document.getElementById("priceSpan2");
let individualPrice2 = document.getElementById("individualPrice2");

quantity1.addEventListener("input", updatePricesSpan);
quantity2.addEventListener("input", updatePricesSpan);
pass1.addEventListener("change", updatePricesSpan);
pass2.addEventListener("change", updatePricesSpan);
// HTMLInputElementObject.addEventListener('input', updatePricesSpan);

function updatePricesSpan() {
	let fourDayPass = 289; //Valor real
	let threeDayPass = 215; //Valor inventado
	let oneDayPass = 105; //Valor real
	if (pass1.options[pass1.selectedIndex].value == "1-day pass") {
		price1.innerHTML = "Price: $" + quantity1.value * oneDayPass;
        individualPrice1.innerHTML = " 1x $" + oneDayPass;
	} else {
		price1.innerHTML = "Price: $" + quantity1.value * threeDayPass;
        individualPrice1.innerHTML = " 3x $" + threeDayPass;
	}
	if(pass2.options[pass2.selectedIndex].value == "1-day pass"){
	    price2.innerHTML = "Price: $" + quantity2.value * oneDayPass;
        individualPrice2.innerHTML = " 1x $" + oneDayPass;
	} else {
	    price2.innerHTML = "Price: $" + quantity2.value * fourDayPass;
        individualPrice2.innerHTML = " 4x $" + fourDayPass;
	}
}

//Bloqueador de inputs incorrectos de cantidad de tickets:
document.getElementById("quantity1").addEventListener("keypress", function (e) {
	e.preventDefault();
	let input1 = e.target;
	let value = Number(input1.value);
	let key = Number(e.key);
	let maxValue = 10;
	if (Number.isInteger(key)) {
		value = Number("" + value + key);
		if (value > maxValue) {
			return false;
		}
		input1.value = value;
	}
	updatePricesSpan();
});
document.getElementById("quantity2").addEventListener("keypress", function (e) {
	e.preventDefault();
	let input2 = e.target;
	let value = Number(input2.value);
	let key = Number(e.key);
	let maxValue = 10;
	if (Number.isInteger(key)) {
		value = Number("" + value + key);
		if (value > maxValue) {
			return false;
		}
		input2.value = value;
	}
	updatePricesSpan();
});
