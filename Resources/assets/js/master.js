var LeooSendgridCharts = (function(Highcharts) {
    var generator = function(id, options) {
        var defaultOptions = {
            chart: {
                style: {
                    "fontFamily": "\"Lato\", \"Helvetica Neue\", Helvetica, Arial, sans-serif",
                    "fontSize": "12px"
                }
            },
            credits: {
                enabled: false
            }
        };

        options = deepmerge(defaultOptions, options);
        return Highcharts.chart(id, options);
    };
    return  {
        generator: generator
    };
}) (Highcharts);