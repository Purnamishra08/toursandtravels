
// Pie Chart Start
Highcharts.chart('pieChart', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    colors: ['#004256', '#FF7588', '#00B5B8','#fd5727', '#16D39A'],
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            slicedOffset: 0,
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Chrome',
            y: 74.77,
            sliced: true,
            selected: true
        },  {
            name: 'Edge',
            y: 12.82
        },  {
            name: 'Firefox',
            y: 4.63
        }, {
            name: 'Safari',
            y: 2.44
        }, {
            name: 'Internet Explorer',
            y: 2.02
        }, {
            name: 'Other',
            y: 3.28
        }]
    }]
});
// Pie Chart End

//Bar Chart Start
Highcharts.chart('barChart', {
    chart: {
        type: 'column',
		backgroundColor:"rgba(255, 255, 255, 0)"
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: ['Agriculture', 'BPSM', 'Planning']
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Success',
        color:'#004256',
        data: [2, 1, 3]
    }, {
        name: 'Failure',
        color:'#e85122',
        data: [3, 2, 1]
    }]
});
//Bar Chart End