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
                Highcharts.chart('agent_weekly', {

                    title: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: 'فروش خالص'
                        }
                    },

                    xAxis: {
                        categories: data.days
                    },




                    series: [{
                        name: '',
                        data: data.sale
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500,
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    },
                    legend: {
                        enabled:false
                    },
                    credits: {
                        enabled: false
                    }
                });
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
                Highcharts.chart('agent_monthly', {

                    title: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: 'فروش خالص'
                        }
                    },

                    xAxis: {
                        categories: data.days
                    },




                    series: [{
                        name: '',
                        data: data.sale
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500,
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    },
                    legend: {
                        enabled:false
                    },
                    credits: {
                        enabled: false
                    }
                });
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
                Highcharts.chart('total_weekly', {

                    title: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: 'فروش خالص'
                        }
                    },

                    xAxis: {
                        categories: data.days
                    },




                    series: [{
                        name: '',
                        data: data.sale
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500,
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    },
                    legend: {
                        enabled:false
                    },
                    credits: {
                        enabled: false
                    }
                });
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
                Highcharts.chart('total_monthly', {

                    title: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: 'فروش خالص'
                        }
                    },

                    xAxis: {
                        categories: data.days
                    },




                    series: [{
                        name: '',
                        data: data.sale
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500,
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    },
                    legend: {
                        enabled:false
                    },
                    credits: {
                        enabled: false
                    }
                });
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
                Highcharts.chart('agent_total_weekly', {

                    title: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: 'فروش خالص'
                        }
                    },

                    xAxis: {
                        categories: data.days
                    },




                    series: [{
                        name: '',
                        data: data.sale
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500,
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    },
                    legend: {
                        enabled:false
                    },
                    credits: {
                        enabled: false
                    }
                });
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
                Highcharts.chart('agent_total_monthly', {

                    title: {
                        text: ''
                    },

                    yAxis: {
                        title: {
                            text: 'فروش خالص'
                        }
                    },

                    xAxis: {
                        categories: data.days
                    },




                    series: [{
                        name: '',
                        data: data.sale
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500,
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    },
                    legend: {
                        enabled:false
                    },
                    credits: {
                        enabled: false
                    }
                });
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
