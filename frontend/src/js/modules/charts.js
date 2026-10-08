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

// START OF CLASS: ProponentTrendChart — Subchild 1: Monthly Proponent Assisted Area Chart
export class ProponentTrendChart extends BaseChart {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Calls parent constructor with trend chart ID and custom options
   */
  constructor(options = {}) {
    super('chart-proponent-trend', options);
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
   * Purpose: Generates HTML structure for the 2-column Proponent Trend card
   */
  buildCardHTML() {
    return `
      <div id="${this.getCardId()}" class="lg:col-span-2 min-w-0 bg-stone-50 dark:bg-slate-800 p-6 rounded-2xl border border-stone-200 dark:border-slate-700 shadow-xs flex flex-col justify-between">
          <div class="flex items-center justify-between mb-4">
              <div>
                  <h2 id="dashboard-chart-trend-title" class="text-base font-bold text-stone-900 dark:text-white">Proponent Assisted (2026)</h2>
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
        name: 'Proponent Assisted',
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
          formatter: (val) => `${val} Proponent`
        }
      },
      ...this.options
    };
  }
  // END OF FUNCTION: getChartOptions
}
// END OF CLASS: ProponentTrendChart

// START OF CLASS: GenderDemographicsRadialChart — Subchild 2: Gender & Demographic Radial Bar Chart
export class GenderDemographicsRadialChart extends BaseChart {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Calls parent constructor with radial chart IDj and custom options
   */
  constructor(options = {}) {
    super('chart-gender-radial', options);
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: getCardId
   * Purpose: Returns demographics radial card container ID
   */
  getCardId() {
    return 'dashboard-chart-gender-radial-card';
  }
  // END OF FUNCTION: getCardId

  /**
   * START OF FUNCTION: buildCardHTML
   * Purpose: Generates modern HTML structure for the Radial Bar Demographic Breakdown card
   */
  buildCardHTML() {
    return `
      <div id="${this.getCardId()}" class="min-w-0 bg-stone-50 dark:bg-slate-800 p-6 rounded-2xl border border-stone-200 dark:border-slate-700 shadow-xs flex flex-col justify-between">
          <div class="mb-2">
              <h2 id="dashboard-chart-gender-title" class="text-base font-bold text-stone-900 dark:text-white whitespace-nowrap truncate">Gender & Demographics</h2>
              <p class="text-xs text-stone-500 dark:text-slate-400 truncate">Beneficiary profile by gender & special categories</p>
          </div>
          
          <div id="${this.chartId}" class="w-full flex items-center justify-center min-h-[300px]"></div>

          <!-- Bottom summary breakdown legend badges -->
          <div class="pt-3 mt-1 border-t border-stone-200 dark:border-slate-700 grid grid-cols-2 gap-2 text-xs">
              <div class="flex items-center space-x-2">
                  <span class="w-2.5 h-2.5 rounded-full bg-blue-600 shrink-0"></span>
                  <div class="truncate">
                      <span class="text-stone-500 dark:text-slate-400 text-3xs block">Male (All)</span>
                      <span class="font-bold text-stone-900 dark:text-white">43.4% <span class="text-3xs text-stone-400 font-normal">(542)</span></span>
                  </div>
              </div>
              <div class="flex items-center space-x-2">
                  <span class="w-2.5 h-2.5 rounded-full bg-pink-500 shrink-0"></span>
                  <div class="truncate">
                      <span class="text-stone-500 dark:text-slate-400 text-3xs block">Female (All)</span>
                      <span class="font-bold text-stone-900 dark:text-white">56.6% <span class="text-3xs text-stone-400 font-normal">(706)</span></span>
                  </div>
              </div>
              <div class="flex items-center space-x-2">
                  <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span>
                  <div class="truncate">
                      <span class="text-stone-500 dark:text-slate-400 text-3xs block">Senior Citizens (SR)</span>
                      <span class="font-bold text-stone-900 dark:text-white">25.0% <span class="text-3xs text-stone-400 font-normal">(312)</span></span>
                  </div>
              </div>
              <div class="flex items-center space-x-2">
                  <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 shrink-0"></span>
                  <div class="truncate">
                      <span class="text-stone-500 dark:text-slate-400 text-3xs block">PWD</span>
                      <span class="font-bold text-stone-900 dark:text-white">8.7% <span class="text-3xs text-stone-400 font-normal">(108)</span></span>
                  </div>
              </div>
          </div>
      </div>
    `;
  }
  // END OF FUNCTION: buildCardHTML

  /**
   * START OF FUNCTION: getChartOptions
   * Purpose: Configures Flowbite/ApexCharts type: "radialBar" with multi-series tracks and DOLE palette
   */
  getChartOptions() {
    return {
      series: [56.6, 43.4, 25.0, 8.7],
      labels: ['Female (All)', 'Male (All)', 'Seniors (SR)', 'PWD'],
      chart: {
        height: 310,
        type: 'radialBar',
        fontFamily: 'Poppins, sans-serif',
        toolbar: { show: false },
        sparkline: { enabled: false }
      },
      colors: ['#ec4899', '#2563eb', '#f59e0b', '#059669'],
      plotOptions: {
        radialBar: {
          track: {
            background: '#e2e8f0',
            strokeWidth: '97%',
            margin: 5
          },
          dataLabels: {
            name: {
              fontSize: '12px',
              fontFamily: 'Poppins, sans-serif',
              fontWeight: 600,
              color: '#64748b',
              offsetY: -5
            },
            value: {
              fontSize: '22px',
              fontFamily: 'Poppins, sans-serif',
              fontWeight: 800,
              color: '#1e293b',
              offsetY: 5,
              formatter: (val) => `${val}%`
            },
            total: {
              show: true,
              label: 'Total Beneficiaries',
              fontSize: '11px',
              fontFamily: 'Poppins, sans-serif',
              fontWeight: 600,
              color: '#64748b',
              formatter: () => '1,248'
            }
          }
        }
      },
      legend: {
        show: false
      },
      stroke: {
        lineCap: 'round'
      },
      tooltip: {
        enabled: true,
        theme: 'light',
        y: {
          formatter: (val) => `${val}% of Total`
        }
      },
      ...this.options
    };
  }
  // END OF FUNCTION: getChartOptions
}
// END OF CLASS: GenderDemographicsRadialChart

// START OF CLASS: ChartManager — Coordinator managing parent container injection and child chart instances
export class ChartManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes container reference and child chart instances
   */
  constructor(options = {}) {
    this.containerId = options.containerId || 'dashboard-charts-container';
    this.gridId = options.gridId || 'dashboard-charts-grid';
    this.trendChart = new ProponentTrendChart();
    this.genderRadialChart = new GenderDemographicsRadialChart();
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
      this.genderRadialChart.mountCard(mountTarget);
    }

    // Render both charts
    this.trendChart.render();
    this.genderRadialChart.render();

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
    this.genderRadialChart.destroy();
  }
  // END OF FUNCTION: destroyAll
}
// END OF CLASS: ChartManager

export const charts = new ChartManager();

/**
 * END OF FILE: frontend/src/js/modules/charts.js
 */
