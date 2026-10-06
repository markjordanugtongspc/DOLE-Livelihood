/**
 * START OF FILE: frontend/src/js/modules/charts.js
 * Purpose: OOP ApexCharts architecture for livelihood dashboard statistics with Parent (BaseChart) and Subchild charts
 */

import ApexCharts from 'apexcharts';

// START OF CLASS: BaseChart — Parent class providing DOM mounting, chart lifecycle, and options merging
export class BaseChart {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes base chart properties, container identification, and instance storage
   */
  constructor(chartId, options = {}) {
    this.chartId = chartId;
    this.options = options;
    this.chartInstance = null;
    this.containerElement = null;
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: buildCardHTML
   * Purpose: Abstract template method overridden by subchild classes to render their card markup
   */
  buildCardHTML() {
    throw new Error('Subchild must implement buildCardHTML()');
  }
  // END OF FUNCTION: buildCardHTML

  /**
   * START OF FUNCTION: getChartOptions
   * Purpose: Abstract options factory overridden by subchild classes to supply ApexCharts configuration
   */
  getChartOptions() {
    throw new Error('Subchild must implement getChartOptions()');
  }
  // END OF FUNCTION: getChartOptions

  /**
   * START OF FUNCTION: mountCard
   * Purpose: Injects card shell into parent grid or container if not already in DOM
   */
  mountCard(parentGrid) {
    if (!parentGrid) return null;

    let existingCard = document.getElementById(this.getCardId());
    if (!existingCard) {
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = this.buildCardHTML().trim();
      existingCard = tempDiv.firstElementChild;
      parentGrid.appendChild(existingCard);
    }
    return existingCard;
  }
  // END OF FUNCTION: mountCard

  /**
   * START OF FUNCTION: getCardId
   * Purpose: Returns unique card ID derived from chart identifier
   */
  getCardId() {
    return `${this.chartId}-card`;
  }
  // END OF FUNCTION: getCardId

  /**
   * START OF FUNCTION: render
   * Purpose: Instantiates and renders the ApexCharts instance inside target mount element
   */
  render() {
    this.containerElement = document.getElementById(this.chartId);
    if (!this.containerElement) {
      return null;
    }

    if (this.chartInstance) {
      this.destroy();
    }

    const mergedOptions = this.getChartOptions();
    this.chartInstance = new ApexCharts(this.containerElement, mergedOptions);
    this.chartInstance.render();
    return this.chartInstance;
  }
  // END OF FUNCTION: render

  /**
   * START OF FUNCTION: resize
   * Purpose: Triggers redraw on active chart instance to adjust to container width
   */
  resize() {
    if (this.chartInstance) {
      this.chartInstance.render();
    }
  }
  // END OF FUNCTION: resize

  /**
   * START OF FUNCTION: update
   * Purpose: Updates chart series or configuration dynamically
   */
  update(newOptions) {
    if (this.chartInstance) {
      return this.chartInstance.updateOptions(newOptions);
    }
    return null;
  }
  // END OF FUNCTION: update

  /**
   * START OF FUNCTION: destroy
   * Purpose: Safely disposes active ApexCharts instance and clears DOM references
   */
  destroy() {
    if (this.chartInstance) {
      this.chartInstance.destroy();
      this.chartInstance = null;
    }
  }
  // END OF FUNCTION: destroy
}
// END OF CLASS: BaseChart

// START OF CLASS: BeneficiariesTrendChart — Subchild 1: Monthly Beneficiaries Assisted Area Chart
export class BeneficiariesTrendChart extends BaseChart {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Calls parent constructor with trend chart ID and custom options
   */
  constructor(options = {}) {
    super('chart-beneficiaries-trend', options);
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: getCardId
   * Purpose: Returns trend card container ID
   */
  getCardId() {
    return 'dashboard-chart-trend-card';
  }
  // END OF FUNCTION: getCardId

  /**
   * START OF FUNCTION: buildCardHTML
   * Purpose: Generates HTML structure for the 2-column Beneficiaries Trend card
   */
  buildCardHTML() {
    return `
      <div id="${this.getCardId()}" class="lg:col-span-2 min-w-0 bg-stone-50 dark:bg-slate-800 p-6 rounded-2xl border border-stone-200 dark:border-slate-700 shadow-xs flex flex-col justify-between">
          <div class="flex items-center justify-between mb-4">
              <div>
                  <h2 id="dashboard-chart-trend-title" class="text-base font-bold text-stone-900 dark:text-white">Beneficiaries Assisted (2026)</h2>
                  <p class="text-xs text-stone-500 dark:text-slate-400">Monthly breakdown of livelihood grants released</p>
              </div>
              <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                  Monthly Report
              </span>
          </div>
          <div id="${this.chartId}" class="w-full min-h-[300px]"></div>
      </div>
    `;
  }
  // END OF FUNCTION: buildCardHTML

  /**
   * START OF FUNCTION: getChartOptions
   * Purpose: Configures ApexCharts area series, gradient fills, and styling for trend data
   */
  getChartOptions() {
    return {
      series: [{
        name: 'Beneficiaries Assisted',
        data: [42, 65, 88, 120, 156, 189, 210]
      }],
      chart: {
        width: '100%',
        height: 310,
        type: 'area',
        toolbar: { show: false },
        fontFamily: 'Poppins, sans-serif',
        redrawOnParentResize: true,
        redrawOnWindowResize: true
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
        axisTicks: { show: false },
        labels: {
          style: {
            colors: '#64748b',
            fontSize: '12px',
            fontFamily: 'Poppins, sans-serif'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: '#64748b',
            fontSize: '12px',
            fontFamily: 'Poppins, sans-serif'
          },
          formatter: (val) => `${val}`
        }
      },
      grid: {
        borderColor: '#e2e8f0',
        strokeDashArray: 4,
        padding: {
          left: 10,
          right: 10
        }
      },
      tooltip: {
        theme: 'light',
        y: {
          formatter: (val) => `${val} Beneficiaries`
        }
      },
      ...this.options
    };
  }
  // END OF FUNCTION: getChartOptions
}
// END OF CLASS: BeneficiariesTrendChart

// START OF CLASS: CategoryDistributionChart — Subchild 2: Livelihood Project Categories Donut Chart
export class CategoryDistributionChart extends BaseChart {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Calls parent constructor with category donut chart ID and custom options
   */
  constructor(options = {}) {
    super('chart-category-donut', options);
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: getCardId
   * Purpose: Returns category distribution card container ID
   */
  getCardId() {
    return 'dashboard-chart-category-card';
  }
  // END OF FUNCTION: getCardId

  /**
   * START OF FUNCTION: buildCardHTML
   * Purpose: Generates HTML structure for the 1-column Project Categories Donut card
   */
  buildCardHTML() {
    return `
      <div id="${this.getCardId()}" class="min-w-0 bg-stone-50 dark:bg-slate-800 p-6 rounded-2xl border border-stone-200 dark:border-slate-700 shadow-xs flex flex-col justify-between">
          <div class="mb-4">
              <h2 id="dashboard-chart-category-title" class="text-base font-bold text-stone-900 dark:text-white">Project Categories</h2>
              <p class="text-xs text-stone-500 dark:text-slate-400">Distribution by industry sector</p>
          </div>
          <div id="${this.chartId}" class="w-full min-h-[310px]"></div>
      </div>
    `;
  }
  // END OF FUNCTION: buildCardHTML

  /**
   * START OF FUNCTION: getChartOptions
   * Purpose: Configures ApexCharts donut series, colors, centered total labels, and legend
   */
  getChartOptions() {
    return {
      series: [44, 28, 18, 10],
      labels: ['Agriculture / Agri-business', 'Food & Beverage', 'Retail & Trading', 'Crafts & Services'],
      chart: {
        width: '100%',
        height: 310,
        type: 'donut',
        fontFamily: 'Poppins, sans-serif',
        toolbar: { show: false },
        redrawOnParentResize: true,
        redrawOnWindowResize: true
      },
      colors: ['#237D2C', '#F29C38', '#0284c7', '#10b981'],
      stroke: {
        width: 2,
        colors: ['#ffffff']
      },
      legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '12px',
        fontFamily: 'Poppins, sans-serif',
        fontWeight: 500,
        itemMargin: {
          horizontal: 8,
          vertical: 4
        },
        markers: {
          width: 10,
          height: 10,
          radius: 12
        }
      },
      dataLabels: {
        enabled: true,
        formatter: (val) => `${Math.round(val)}%`,
        style: {
          fontSize: '11px',
          fontFamily: 'Poppins, sans-serif',
          fontWeight: 600
        },
        dropShadow: { enabled: false }
      },
      plotOptions: {
        pie: {
          customScale: 0.95,
          donut: {
            size: '68%',
            labels: {
              show: true,
              name: {
                show: true,
                fontSize: '12px',
                fontFamily: 'Poppins, sans-serif',
                fontWeight: 500,
                color: '#64748b',
                offsetY: -4
              },
              value: {
                show: true,
                fontSize: '22px',
                fontFamily: 'Poppins, sans-serif',
                fontWeight: 700,
                color: '#1e293b',
                offsetY: 4,
                formatter: () => '100%'
              },
              total: {
                show: true,
                label: 'Total Projects',
                fontSize: '12px',
                fontFamily: 'Poppins, sans-serif',
                fontWeight: 600,
                color: '#64748b',
                formatter: () => '100%'
              }
            }
          }
        }
      },
      responsive: [
        {
          breakpoint: 1024,
          options: {
            chart: { height: 290 },
            legend: { position: 'bottom' }
          }
        },
        {
          breakpoint: 640,
          options: {
            chart: { height: 270 },
            legend: { position: 'bottom' }
          }
        }
      ],
      ...this.options
    };
  }
  // END OF FUNCTION: getChartOptions
}
// END OF CLASS: CategoryDistributionChart

// START OF CLASS: ChartManager — Coordinator managing parent container injection and child chart instances
export class ChartManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes container reference and child chart instances
   */
  constructor(options = {}) {
    this.containerId = options.containerId || 'dashboard-charts-container';
    this.gridId = options.gridId || 'dashboard-charts-grid';
    this.trendChart = new BeneficiariesTrendChart();
    this.categoryChart = new CategoryDistributionChart();
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Injects chart cards into container or grid, renders ApexCharts instances
   */
  init() {
    const container = document.getElementById(this.containerId);
    let grid = document.getElementById(this.gridId);

    // If dedicated grid element does not exist, create it within container
    if (!grid && container) {
      grid = document.createElement('div');
      grid.id = this.gridId;
      grid.className = 'grid grid-cols-1 lg:grid-cols-3 gap-6';
      container.appendChild(grid);
    }

    const mountTarget = grid || container;

    // Mount cards via subchild classes
    if (mountTarget) {
      this.trendChart.mountCard(mountTarget);
      this.categoryChart.mountCard(mountTarget);
    }

    // Render both charts
    this.trendChart.render();
    this.categoryChart.render();

    // Trigger frame resize check to ensure SVG dimensions expand to container width
    requestAnimationFrame(() => {
      window.dispatchEvent(new Event('resize'));
    });

    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: destroyAll
   * Purpose: Cleans up both child chart instances
   */
  destroyAll() {
    this.trendChart.destroy();
    this.categoryChart.destroy();
  }
  // END OF FUNCTION: destroyAll
}
// END OF CLASS: ChartManager

export const charts = new ChartManager();

/**
 * END OF FILE: frontend/src/js/modules/charts.js
 */
