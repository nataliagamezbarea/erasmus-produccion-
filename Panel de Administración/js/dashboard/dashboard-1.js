

(function($) {
    /* "use strict" */
	
 var dlabChartlist = function(){
	
	var screenWidth = $(window).width();	
	
	var chartBar = function(){
		
		var options = {
			  series: [
				{
					name: 'Income',
					data: [50, 18, 70, 40],
					//radius: 12,	
				}, 
				{
				  name: 'Outcome',
				  data: [80, 40, 55, 20]
				}, 
				
			],
				chart: {
				type: 'bar',
				height: 200,
				
				toolbar: {
					show: false,
				},
				
			},
			plotOptions: {
			  bar: {
				horizontal: false,
				columnWidth: '57%',
				borderRadius:12
			  },
			  
			},
			states: {
			  hover: {
				filter: 'none',
			  }
			},
			colors:['#80ec67', '#fe7d65'],
			dataLabels: {
			  enabled: false,
			},
			markers: {
		shape: "circle",
		},
		
		
			legend: {
				position: 'top',
				horizontalAlign: 'right', 
				show: false,
				fontSize: '12px',
				labels: {
					colors: '#000000',
					
					},
				markers: {
				width: 18,
				height: 18,
				strokeWidth: 0,
				strokeColor: '#fff',
				fillColors: undefined,
				radius: 12,	
				}
			},
			stroke: {
			  show: true,
			  width: 4,
			  colors: ['transparent']
			},
			grid: {
				borderColor: '#eee',
			},
			xaxis: {
				
			  categories: ['Lunes', 'Martes', 'Miércoles', 'Jueves'],
			  labels: {
			   style: {
				  colors: '#3e4954',
				  fontSize: '13px',
				  fontFamily: 'poppins',
				  fontWeight: 400,
				  cssClass: 'apexcharts-xaxis-label',
				},
			  },
			  crosshairs: {
			  show: false,
			  }
			},
			yaxis: {
				labels: {
					offsetX:-16,
				   style: {
					  colors: '#3e4954',
					  fontSize: '13px',
					   fontFamily: 'poppins',
					  fontWeight: 400,
					  cssClass: 'apexcharts-xaxis-label',
				  },
			  },
			},
			fill: {
			  opacity: 1,
			  colors:['#80ec67', '#fe7d65'],
			},
			tooltip: {
			  y: {
				formatter: function (val) {
				  return "$ " + val + " thousands"
				}
			  }
			},
			responsive: [{
				breakpoint: 1600,
				options: {
					chart: {
						height: 400,
					}
				},
			},
			{
				breakpoint: 575,
				options: {
					chart: {
						height: 250,
					}
				},
			}]
			};

			var chartBar1 = new ApexCharts(document.querySelector("#chartBar"), options);
			chartBar1.render();
	}	
	
	var chartBar2 = function() {
		// URL de tu script PHP
		const url = 'http://localhost/erasmus/backend/obtener_datos/obtener_todos_los_dias_publicaciones.php';
	
		// Realizar la solicitud HTTP usando fetch
		fetch(url)
			.then(response => response.json())
			.then(data => {
				// Aquí 'data' es un objeto JavaScript que contiene los resultados de la consulta PHP
				console.log(data);
	
				// Extraer los datos necesarios para la gráfica
				var diasSemana = data.map(item => item.DiaSemana);
				var numPublicaciones = data.map(item => item.NumPublicaciones);
	
				// Configurar las opciones de la gráfica
				var options = {
					series: [
						{
							name: 'Publicaciones',
							data: numPublicaciones,
						}
					],
					chart: {
						type: 'bar',
						height: 400,
						toolbar: {
							show: false,
						},
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: '70%',
							borderRadius: 10
						},
					},
					states: {
						hover: {
							filter: 'none',
						}
					},
					colors: ['#80ec67', '#fe7d65'],
					dataLabels: {
						enabled: false,
					},
					markers: {
						shape: "circle",
					},
					legend: {
						position: 'top',
						horizontalAlign: 'right',
						show: false,
						fontSize: '12px',
						labels: {
							colors: '#000000',
						},
						markers: {
							width: 18,
							height: 18,
							strokeWidth: 0,
							strokeColor: '#fff',
							fillColors: undefined,
							radius: 12,
						}
					},
					stroke: {
						show: true,
						width: 5,
						colors: ['transparent']
					},
					grid: {
						borderColor: '#eee',
					},
					xaxis: {
						categories: diasSemana,
						labels: {
							style: {
								colors: '#3e4954',
								fontSize: '13px',
								fontFamily: 'poppins',
								fontWeight: 400,
								cssClass: 'apexcharts-xaxis-label',
							},
						},
						crosshairs: {
							show: false,
						}
					},
					yaxis: {
						labels: {
							offsetX: -16,
							style: {
								colors: '#3e4954',
								fontSize: '10px', // Ajustar el tamaño de la fuente
								fontFamily: 'poppins',
								fontWeight: 400,
								cssClass: 'apexcharts-xaxis-label',
							},
						},
					},
					fill: {
						opacity: 1,
						colors: ['#80ec67', '#fe7d65'],
					},
					tooltip: {
						y: {
							formatter: function(val) {
								return val;

							}
						}
					},
					responsive: [{
						breakpoint: 575,
						options: {
							chart: {
								height: 250,
							}
						},
					}]
				};
	
				// Crear la gráfica
				var chartBar2 = new ApexCharts(document.querySelector("#chartBar2"), options);
				chartBar2.render();
			})
			.catch(error => console.error('Error al obtener datos:', error));
	};
	
	var polarChart = function(){
		 var ctx = document.getElementById("polarChart").getContext('2d');
			Chart.defaults.global.legend.display = false;
			var myChart = new Chart(ctx, {
				type: 'polarArea',
				data: {
					labels: ["Martes", "Miércoles", "Jueves", "Viernes"],
					datasets: [{
						backgroundColor: [
							"#496ecc",
							"#68e365",
							"#ffa755",
							"#c8c8c8"
						],
						data: [40, 35, 30, 20]
					}]
				},
				options: {
					maintainAspectRatio: false,
					scale: {
						scaleShowLine:false,
						display:false,
						 pointLabels:{
							fontSize: 0       
						 },
					},
					tooltips:{
						enabled:false,
					}
				}
			});
	}	
	
	var handleCard = function(){
		
		// Vars
		var reloadButton  = document.querySelector( '.change-btn' );
		var reloadIcon     = document.querySelector( '.reload' );
		var reloadEnabled = true;
		var rotation      = 0;
		// Events
		reloadButton.addEventListener('click', function() { reloadClick() });
		// Functions
		function reloadClick() {
		  reloadEnabled = false;
		  rotation += 360;
		  // Eh, this works.
		  reloadIcon.style.webkitTransform = 'translateZ(0px) rotateZ( ' + rotation + 'deg )';
		  reloadIcon.style.MozTransform  = 'translateZ(0px) rotateZ( ' + rotation + 'deg )';
		  reloadIcon.style.transform  = 'translateZ(0px) rotateZ( ' + rotation + 'deg )';
		}
		// Show button.
		setTimeout(function() {
		  reloadButton.classList.add('active');
		}, 1);
		
		//Number formatting
		var sliderFormat = document.getElementById('slider-format');
		noUiSlider.create(sliderFormat, {
			start: [20000],
			step: 1000,
			connect: [true, false],
			range: {
				'min': [20000],
				'max': [80000]
			},
			ariaFormat: wNumb({
				decimals: 3
			}),
			format: wNumb({
				decimals: 3,
				thousand: '.',
				//suffix: ' (US $)'
			})
		});

		var inputFormat = document.getElementById('input-format');
		sliderFormat.noUiSlider.on('update', function (values, handle) {
			inputFormat.value = values[handle];
		});

		inputFormat.addEventListener('change', function () {
			sliderFormat.noUiSlider.set(this.value);
		});
		//Number formatting ^
	}
 
	/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){
				
				chartBar();
				chartBar2();
				polarChart();
				handleCard();
			},
			
			resize:function(){
			}
		}
	
	}();

	
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dlabChartlist.load();
		}, 1000); 
		
	});

     

})(jQuery);