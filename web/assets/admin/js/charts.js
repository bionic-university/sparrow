(function ($) {
    $(function () {
        $('#articles').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Articles creation frequency'
            },
            subtitle: {
                text: 'Sparrow.com'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                title: {
                    text: 'Date'
                }
            },
            yAxis: {
                title: {
                    text: 'Quantity'
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
            },

            series: [
                articlesData
            ]
        });
    });

})(jQuery);
