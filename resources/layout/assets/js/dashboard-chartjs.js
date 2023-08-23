(function(){

// COMPARACION DE MOTIVOS POR LINEAS
// Color Variables
const yellowColor = '#ffe800';
let borderColor, headingColor, gridColor, tickColor, cardColor, labelColor;
headingColor = config.colors.headingColor;
cardColor = config.colors.white;
legendColor = config.colors.primary
labelColor = "#000";
borderColor = '#f0f0f0';
gridColor = '#f0f0f0';
tickColor = 'rgba(0, 0, 0, 0.75)'; // x & y axis tick color


const comparation = document.getElementById('comparationMotivos');
let totalSeg = JSON.parse($("input[name=comparativa]").val());
let totalM = JSON.parse($("input[name=totalMotiveAlarm]").val());
let motivo = []
  let label = [];
  let cantidadMaxima = 0;
  let dataset = [];

  totalM.forEach(row => {
	  let label2 = [];
	  j=0;
	  totalSeg.forEach(rowb => {
		cantidadMaxima = (rowb.cantidad_registros*1)> cantidadMaxima ? rowb.cantidad_registros*1 : cantidadMaxima;
		if(row.name == rowb.name){
			label2.push(rowb.cantidad_registros);
		}
		label.push(rowb.fecha)
	  });

		let color = getRandomColor();

		let data = {
			 data: label2,
			 label: row.name,
			 borderColor: color,
			 tension: 0.5,
			 pointStyle: 'circle',
			 backgroundColor: color,
			 fill: false,
			 pointRadius: 10,
			 pointHoverRadius: 30,
			 pointHoverBorderWidth: 20,
			 pointBorderColor: 'transparent',
			 pointHoverBorderColor: cardColor,
			 pointHoverBackgroundColor: color
		 };

		 dataset.push(data);
	});


if (comparation) {
  const lineChartVar = new Chart(comparation, {
    type: 'line',
    data: {
      labels: label,
      datasets: dataset
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          grid: {
            color: borderColor,
            drawBorder: false,
            borderColor: borderColor
          },
          ticks: {
            color: labelColor,
				display: false
          },
			 scaleLabel: {
            display: true
          },
			 min: 0,
          max: cantidadMaxima-13,
        },
        y: {
          scaleLabel: {
            display: true
          },
          min: 0,
          max: cantidadMaxima+10,
          ticks: {
            color: labelColor,
            stepSize: 10
          },
          grid: {
            color: borderColor,
            drawBorder: false,
            borderColor: borderColor
          }
        }
      },
      plugins: {
        tooltip: {
          // Updated default tooltip UI
          //rtl: isRtl,
          backgroundColor: cardColor,
          titleColor: headingColor,
          bodyColor: legendColor,
          borderWidth: 1,
          borderColor: borderColor
        },
        legend: {
          position: 'top',
          align: 'start',
          //rtl: isRtl,
          labels: {
            usePointStyle: true,
            padding: 35,
            boxWidth: 6,
            boxHeight: 6,
            color: legendColor
          }
        }
      }
    }
  });
}
})();
