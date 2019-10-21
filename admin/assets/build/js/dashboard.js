$(document).ready(function($) {
  var site_url = $("#site_url").val();
  $.ajax({
      url: site_url + 'dashboard/GetAppointment',
      async: false,
      success: function (data) {
        var obj = JSON.parse(data);
        console.log(obj);
        new Morris.Area({
          element: 'myfirstchart',
          data: obj,
          xkey: 'Date',
          ykeys: ['amount'],
          labels: ['Earning'],
          parseTime: false,
          xLabelAngle: 60,
        });
      }
  });

  $.ajax({
      url: site_url + 'dashboard/get_country_data',
      async: false,
      success: function (data) {
        var obj = JSON.parse(data);
        console.log(obj);
        new Morris.Area({
          element: 'chartdiv',
          data: obj,
          xkey: 'State',
          ykeys: ['shop'],
          labels: ['Shop'],
          parseTime: false,
          xLabelAngle: 60,
          padding: 40,
        });
      }
  });

  $.ajax({
      url: site_url + 'dashboard/get_location_payment_data',
      async: false,
      success: function (data) {
        var obj = JSON.parse(data);
        // console.log(obj);
        new Morris.Area({
          element: 'chartdiv1',
          data: obj,
          xkey: 'State',
          ykeys: ['c', 'b', 'a'],
          labels: ['Cash($)', 'Square Up($)', 'Stripe($)'],
          parseTime: false,
          xLabelAngle: 60,
          padding: 40,
        });
      }
  });

  $.ajax({
      url: site_url + 'dashboard/get_payment_data',
      async: false,
      success: function (data) {
        var obj = JSON.parse(data);
        console.log(obj);
        window.onload = function() {

        var options = {
          backgroundColor: "#f7f7f7",
        	title: {
        		text: "Payment Matrix"
        	},
        	data: [{
        			type: "pie",
        			startAngle: 45,
        			showInLegend: "true",
        			legendText: "{label}",
        			indexLabel: "{label} ({y})",
        			yValueFormatString:"#,##0.#"%"",
        			dataPoints: obj
        	}]
        };
        $("#chartContainer").CanvasJSChart(options);
        }
      }
  });

  // $.ajax({
  //     url: site_url + 'dashboard/get_country_data',
  //     async: false,
  //     success: function (data) {
  //       var data_array = JSON.parse(data);
  //       console.log(data_array);
  //
  //       Morris.Donut({
  //           element: 'chartdiv',
  //           data: data_array,
  //           resize: true,
  //           formatter: function (y, data) { return y }
  //       });
  //     }
  // });
});
