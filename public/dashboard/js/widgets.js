"use strict";

// Class definition
var KTWidgets = function() {
    // Private properties

    // General Controls
    var _initDaterangepicker = function() {
        if ($('#kt_dashboard_daterangepicker').length == 0) {
            return;
        }

        var picker = $('#kt_dashboard_daterangepicker');
        var start = moment();
        var end = moment();

        function cb(start, end, label) {
            var title = '';
            var range = '';

            if ((end - start) < 100 || label == 'امروز') {
                title = 'امروز:';
                range = start.format('MMM D');
            } else if (label == 'دیروز') {
                title = 'دیروز:';
                range = start.format('MMM D');
            } else {
                range = start.format('MMM D') + ' - ' + end.format('MMM D');
            }

            $('#kt_dashboard_daterangepicker_date').html(range);
            $('#kt_dashboard_daterangepicker_title').html(title);
        }

        picker.daterangepicker({
            direction: KTUtil.isRTL(),
            startDate: start,
            endDate: end,
            opens: 'left',
            applyClass: 'btn-primary',
            cancelClass: 'btn-light-primary',
            ranges: {
                'امروز': [moment(), moment()],
                'دیروز': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 روز گذشته': [moment().subtract(6, 'days'), moment()],
                '30 روز گذشته': [moment().subtract(29, 'days'), moment()],
                'این ماه': [moment().startOf('month'), moment().endOf('month')],
                'ماه گذشته': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end, '');
    }

    // Stats widgets
    var agentWeeklyChart= function() {
        var element = document.getElementById("agent_weekly");

        if (!element) {
            return;
        }

        let path = window.location.protocol + "//" + window.location.host + "/"; //URL Path
        let agent_id = element.dataset.user;
        let agent_percentage =  +element.dataset.percentage

        let url = path + `admin/chart/w/${agent_id}`

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                var options = {
                    series: [{
                        name: 'فروش خالص',
                        data:data.sale
                    }],
                    chart: {
                        type: 'area',
                        height: 150,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [KTApp.getSettings()['colors']['theme']['base']['success']]
                    },
                    xaxis: {
                        categories: data.days,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        },
                        crosshairs: {
                            show: false,
                            position: 'front',
                            stroke: {
                                color: KTApp.getSettings()['colors']['gray']['gray-300'],
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                                let total = val
                                let agent = (val / 100) * agent_percentage
                                let a = `سهم بازاریاب   ${agent}    هزار تومان `
                                return total + ' |  ' + a

                            }
                        },
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                    markers: {
                        colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                        strokeColor: [KTApp.getSettings()['colors']['theme']['base']['success']],
                        strokeWidth: 3
                    }
                };
                var chart = new ApexCharts(element, options);
                chart.render();
            })
    }
    var agentMonthlyChart= function() {
        var element = document.getElementById("agent_monthly");

        if (!element) {
            return;
        }

        let path = window.location.protocol + "//" + window.location.host + "/"; //URL Path
        let agent_id = element.dataset.user;
        let agent_percentage =  +element.dataset.percentage

        let url = path + `admin/chart/m/${agent_id}`

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                var options = {
                    series: [{
                        name: 'فروش خالص',
                        data:data.sale
                    }],
                    chart: {
                        type: 'area',
                        height: 150,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [KTApp.getSettings()['colors']['theme']['base']['danger']]
                    },
                    xaxis: {
                        categories: data.days,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        },
                        crosshairs: {
                            show: false,
                            position: 'front',
                            stroke: {
                                color: KTApp.getSettings()['colors']['gray']['gray-300'],
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                                let total = val
                                let agent = (val / 100) * agent_percentage
                                let a = `سهم بازاریاب   ${agent}    هزار تومان `
                                return total + ' |  ' + a

                            }
                        },
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['light']['danger']],
                    markers: {
                        colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                        strokeColor: [KTApp.getSettings()['colors']['theme']['base']['success']],
                        strokeWidth: 3
                    }
                };
                var chart = new ApexCharts(element, options);
                chart.render();
            })
    }

    var totalWeeklyChart= function() {
        var element = document.getElementById("total_weekly");

        if (!element) {
            return;
        }

        let path = window.location.protocol + "//" + window.location.host + "/"; //URL Path
        let url = path + `admin/chart/weekly`

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                var options = {
                    series: [{
                        name: 'فروش خالص',
                        data:data.sale
                    }],
                    chart: {
                        type: 'area',
                        height: 150,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [KTApp.getSettings()['colors']['theme']['base']['success']]
                    },
                    xaxis: {
                        categories: data.days,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        },
                        crosshairs: {
                            show: false,
                            position: 'front',
                            stroke: {
                                color: KTApp.getSettings()['colors']['gray']['gray-300'],
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                              return val
                            }
                        },
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                    markers: {
                        colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                        strokeColor: [KTApp.getSettings()['colors']['theme']['base']['success']],
                        strokeWidth: 3
                    }
                };
                var chart = new ApexCharts(element, options);
                chart.render();
            })
    }
    var totalMonthlyChart= function() {
        var element = document.getElementById("total_monthly");

        if (!element) {
            return;
        }

        let path = window.location.protocol + "//" + window.location.host + "/"; //URL Path
        let url = path + `admin/chart/monthly`

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                var options = {
                    series: [{
                        name: 'فروش خالص',
                        data:data.sale
                    }],
                    chart: {
                        type: 'area',
                        height: 150,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [KTApp.getSettings()['colors']['theme']['base']['danger']]
                    },
                    xaxis: {
                        categories: data.days,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        },
                        crosshairs: {
                            show: false,
                            position: 'front',
                            stroke: {
                                color: KTApp.getSettings()['colors']['gray']['gray-300'],
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                               return val
                            }
                        },
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['light']['danger']],
                    markers: {
                        colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                        strokeColor: [KTApp.getSettings()['colors']['theme']['base']['success']],
                        strokeWidth: 3
                    }
                };
                var chart = new ApexCharts(element, options);
                chart.render();
            })
    }

    var AgentTotalWeeklyChart= function() {
        var element = document.getElementById("agent_total_weekly");

        if (!element) {
            return;
        }

        let path = window.location.protocol + "//" + window.location.host + "/"; //URL Path
        let agent_id = element.dataset.user;
        let url = path + `agent/chart/w/${agent_id}`

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                var options = {
                    series: [{
                        name: 'فروش خالص',
                        data:data.sale
                    }],
                    chart: {
                        type: 'area',
                        height: 150,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [KTApp.getSettings()['colors']['theme']['base']['danger']]
                    },
                    xaxis: {
                        categories: data.days,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        },
                        crosshairs: {
                            show: false,
                            position: 'front',
                            stroke: {
                                color: KTApp.getSettings()['colors']['gray']['gray-300'],
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                               return val
                            }
                        },
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['light']['danger']],
                    markers: {
                        colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                        strokeColor: [KTApp.getSettings()['colors']['theme']['base']['success']],
                        strokeWidth: 3
                    }
                };
                var chart = new ApexCharts(element, options);
                chart.render();
            })
    }
    var AgentTotalMonthlyChart= function() {
        var element = document.getElementById("agent_total_monthly");

        if (!element) {
            return;
        }

        let path = window.location.protocol + "//" + window.location.host + "/"; //URL Path
        let agent_id = element.dataset.user;
        let url = path + `agent/chart/m/${agent_id}`

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                var options = {
                    series: [{
                        name: 'فروش خالص',
                        data:data.sale
                    }],
                    chart: {
                        type: 'area',
                        height: 150,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 3,
                        colors: [KTApp.getSettings()['colors']['theme']['base']['danger']]
                    },
                    xaxis: {
                        categories: data.days,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        },
                        crosshairs: {
                            show: false,
                            position: 'front',
                            stroke: {
                                color: KTApp.getSettings()['colors']['gray']['gray-300'],
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false,
                            style: {
                                colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                                fontSize: '12px',
                                fontFamily: KTApp.getSettings()['font-family']
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        },
                        y: {
                            formatter: function(val) {
                               return val
                            }
                        },
                    },
                    colors: [KTApp.getSettings()['colors']['theme']['light']['danger']],
                    markers: {
                        colors: [KTApp.getSettings()['colors']['theme']['light']['success']],
                        strokeColor: [KTApp.getSettings()['colors']['theme']['base']['success']],
                        strokeWidth: 3
                    }
                };
                var chart = new ApexCharts(element, options);
                chart.render();
            })
    }


    // Public methods
    return {
        init: function() {
            // General Controls
            _initDaterangepicker();
            // Stats Widgets
            agentWeeklyChart();
            agentMonthlyChart();
            totalWeeklyChart();
            totalMonthlyChart();

            AgentTotalWeeklyChart();
            AgentTotalMonthlyChart();
        }
    }
}();

// Webpack support
if (typeof module !== 'undefined') {
    module.exports = KTWidgets;
}

jQuery(document).ready(function() {
    KTWidgets.init();
});
