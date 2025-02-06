
document.addEventListener('DOMContentLoaded', function () {
	fntStockMinimo();
//	fntProductosSalidas();
});
function fntStockMinimo() {
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
	var ajaxUrl = base_url + '/Dashboard/getStockMinimo/';
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			let nombres = [];
			let cantidad = [];
			for (let i = 0; i < objData.length; i++) {
				nombres.push(objData[i]['nombre']);
				cantidad.push(objData[i]['stock']);
			}
			var stockMinimo = document.getElementById("stockMinimo");
			var stockMinimoChart = new Chart(stockMinimo, {
				type: 'pie',
				data: {
					labels: nombres,
					datasets: [{
						data: cantidad,
						backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
					}],
				},
			});
		}
	}
}
//function fntProductosSalidas() {
//	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsorf.XMLHTTP');
//	var ajaxUrl = base_url + '/Dashboard/getProductoSalidas/';
//	request.open("GET", ajaxUrl, true);
//	request.send();
//
//	request.onreadystatechange = function () {
//		if (request.readyState == 4 && request.status == 200) {
//			var objData = JSON.parse(request.responseText);
//			let nombres = [];
//			let cantidades = [];
//			for (let i = 0; i < objData.length; i++) {
//				nombres.push(objData[i]['nombre']);
//				cantidades.push(objData[i]['cantidad']);
//			}
//			new Chart(document.getElementById("productoSalidas"), {
//				type: 'bar',
//				data: {
//				  labels: nombres,
//				  datasets: [
//					{
//					  label: "Productos con mas salidas",
//					  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
//					  data: cantidades
//					}
//				  ]
//				},
//				options: {
//				  legend: { display: false },
//				  title: {
//					display: true,
//					text: 'Predicted world population (millions) in 2050'
//				  }
//				}
//			});
//		}
//	}
//}
