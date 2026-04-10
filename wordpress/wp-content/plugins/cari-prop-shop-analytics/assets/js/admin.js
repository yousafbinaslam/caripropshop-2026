jQuery(document).ready(function($) {
    'use strict';

    var CPSAnalytics = {
        init: function() {
            this.initCharts();
            this.bindEvents();
        },

        bindEvents: function() {
            $(document).on('change', '#cps-period-select', $.proxy(this.onPeriodChange, this));
        },

        initCharts: function() {
            var self = this;
            var viewsChart = document.getElementById('cps-views-chart');
            var leadsChart = document.getElementById('cps-leads-chart');

            if (viewsChart) {
                self.loadChartData('views', function(data) {
                    self.renderChart(viewsChart, data, 'Views');
                });
            }

            if (leadsChart) {
                self.loadChartData('leads', function(data) {
                    self.renderChart(leadsChart, data, 'Leads');
                });
            }
        },

        loadChartData: function(chartType, callback) {
            var urlParams = new URLSearchParams(window.location.search);
            var period = urlParams.get('period') || '30days';

            $.ajax({
                url: cpsAnalytics.ajaxUrl,
                type: 'GET',
                data: {
                    action: 'cps_get_chart_data',
                    chart_type: chartType,
                    period: period,
                    nonce: cpsAnalytics.nonce
                },
                success: function(response) {
                    if (response.success) {
                        callback(response.data);
                    }
                },
                error: function() {
                    console.error('Failed to load chart data');
                }
            });
        },

        renderChart: function(container, data, label) {
            if (!data || !data.length) {
                container.innerHTML = '<p class="no-data">' + cpsAnalytics.i18n.noData + '</p>';
                return;
            }

            var canvas = document.createElement('canvas');
            canvas.width = container.offsetWidth;
            canvas.height = 250;
            container.innerHTML = '';
            container.appendChild(canvas);

            var ctx = canvas.getContext('2d');
            var maxValue = Math.max.apply(null, data.map(function(item) { return parseInt(item.views || item.leads || item.searches); }));
            var barWidth = (canvas.width - 60) / data.length;
            var chartHeight = canvas.height - 40;
            var x = 30;

            ctx.fillStyle = '#f6f7f7';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            ctx.strokeStyle = '#e5e5e5';
            ctx.lineWidth = 1;
            for (var i = 0; i <= 4; i++) {
                var y = 20 + (chartHeight / 4) * i;
                ctx.beginPath();
                ctx.moveTo(30, y);
                ctx.lineTo(canvas.width, y);
                ctx.stroke();
            }

            var gradient = ctx.createLinearGradient(0, 20, 0, chartHeight + 20);
            gradient.addColorStop(0, '#2271b1');
            gradient.addColorStop(1, '#72aee6');

            ctx.fillStyle = gradient;
            data.forEach(function(item, index) {
                var value = parseInt(item.views || item.leads || item.searches);
                var barHeight = (value / maxValue) * chartHeight;

                var barX = x + (barWidth - 16) / 2;
                var barY = chartHeight + 20 - barHeight;

                ctx.beginPath();
                ctx.roundRect(barX, barY, 16, barHeight, [2, 2, 0, 0]);
                ctx.fill();

                if (barWidth > 30) {
                    ctx.fillStyle = '#1d2327';
                    ctx.font = '10px sans-serif';
                    ctx.textAlign = 'center';
                    var dateLabel = item.date || '';
                    if (dateLabel.length > 5) {
                        dateLabel = dateLabel.substring(5);
                    }
                    ctx.fillText(dateLabel, barX + 8, canvas.height - 5);
                    ctx.fillStyle = gradient;
                }

                x += barWidth;
            });

            ctx.fillStyle = '#1d2327';
            ctx.font = 'bold 12px sans-serif';
            ctx.textAlign = 'left';
            ctx.fillText(maxValue, 5, 25);
            ctx.fillText('0', 5, chartHeight + 20);
        },

        onPeriodChange: function(e) {
            var form = e.target.closest('form');
            if (form) {
                form.submit();
            }
        }
    };

    CPSAnalytics.init();
});

if (!HTMLCanvasElement.prototype.roundRect) {
    HTMLCanvasElement.prototype.roundRect = function(x, y, w, h, radii) {
        if (!Array.isArray(radii)) {
            radii = [radii, radii, radii, radii];
        }
        var r = Math.min(radii[0], w, h);
        this.moveTo(x + r, y);
        this.lineTo(x + w - radii[1], y);
        this.quadraticCurveTo(x + w, y, x + w, y + radii[1]);
        this.lineTo(x + w, y + h - radii[2]);
        this.quadraticCurveTo(x + w, y + h, x + w - radii[2], y + h);
        this.lineTo(x + radii[3], y + h);
        this.quadraticCurveTo(x, y + h, x, y + h - radii[3]);
        this.lineTo(x, y + radii[0]);
        this.quadraticCurveTo(x, y, x + radii[0], y);
        this.closePath();
    };
}