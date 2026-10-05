/**
 * START OF FILE: frontend/src/js/modules/charts.js
 * Purpose: Manages ApexCharts rendering for livelihood statistics and program distributions
 */

import ApexCharts from 'apexcharts';

// START OF CLASS: ChartManager - Configures and renders analytics charts
export class ChartManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes chart instance registry
   */
  constructor() {
    this.charts = new Map();
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Automatically discovers chart containers on current page and renders them
   */
  init() {
    this.renderBeneficiariesTrend();
    this.renderCategoryDistribution();
    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: renderBeneficiariesTrend
   * Purpose: Renders monthly beneficiaries bar/area chart
   */
  renderBeneficiariesTrend(containerId = 'chart-beneficiaries-trend') {
    const el = document.getElementById(containerId);
    if (!el) return;

    const options = {
      series: [{
        name: 'Beneficiaries Assisted',
        data: [42, 65, 88, 120, 156, 189, 210]
      }],
      chart: {
        height: 280,
        type: 'area',
        toolbar: { show: false },
        fontFamily: 'Poppins, sans-serif'
      },
      colors: ['#237D2C'],
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth', width: 3 },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.45,
          opacityTo: 0.05,
          stops: [20, 100]
        }
      },
      xaxis: {
        categories: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        axisBorder: { show: false },
        axisTicks: { show: false }
      },
      yaxis: {
        labels: {
          formatter: (val) => `${val}`
        }
      },
      grid: {
        borderColor: '#e2e8f0',
        strokeDashArray: 4
      }
    };

    const chart = new ApexCharts(el, options);
    chart.render();
    this.charts.set(containerId, chart);
  }
  // END OF FUNCTION: renderBeneficiariesTrend

  /**
   * START OF FUNCTION: renderCategoryDistribution
   * Purpose: Renders donut chart for livelihood project category shares
   */
  renderCategoryDistribution(containerId = 'chart-category-donut') {
    const el = document.getElementById(containerId);
    if (!el) return;

    const options = {
      series: [44, 28, 18, 10],
      labels: ['Agriculture / Agri-business', 'Food & Beverage', 'Retail & Trading', 'Crafts & Services'],
      chart: {
        height: 280,
        type: 'donut',
        fontFamily: 'Poppins, sans-serif'
      },
      colors: ['#237D2C', '#F29C38', '#0284c7', '#10b981'],
      legend: {
        position: 'bottom',
        fontSize: '13px'
      },
      dataLabels: {
        enabled: true,
        formatter: (val) => `${Math.round(val)}%`
      },
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
            labels: {
              show: true,
              total: {
                show: true,
                label: 'Total Projects',
                formatter: () => '100%'
              }
            }
          }
        }
      }
    };

    const chart = new ApexCharts(el, options);
    chart.render();
    this.charts.set(containerId, chart);
  }
  // END OF FUNCTION: renderCategoryDistribution

  /**
   * START OF FUNCTION: destroyAll
   * Purpose: Cleans up all chart instances
   */
  destroyAll() {
    this.charts.forEach((chart) => chart.destroy());
    this.charts.clear();
  }
  // END OF FUNCTION: destroyAll
}
// END OF CLASS: ChartManager

export const charts = new ChartManager();

/**
 * END OF FILE: frontend/src/js/modules/charts.js
 */
