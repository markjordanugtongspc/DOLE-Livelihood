/**
 * START OF FILE: frontend/src/js/modules/drawer.js
 * Purpose: Universal Flowbite off-canvas Drawer controller wrapping Flowbite Drawer API with dynamic subchild injection & Proponent Viewer
 */

import { Drawer } from 'flowbite';

// START OF CONSTANT: PROPONENTS_DATA - Complete DOLE Proponent mock dataset for dynamic subchild injection
export const PROPONENTS_DATA = [
  {
    id: 1,
    name: 'Haidee L. Cañada',
    gender: 'female',
    genderLabel: 'Female (F)',
    phone: '(063) 228-7992',
    statusText: 'Subject for Re-Evaluation Upon Compliance',
    statusType: 're-eval',
    dateReceived: 'September 05, 2024',
    dateEvaluated: 'September 12, 2024',
    evaluatorName: 'KATE',
    remarksFindings: 'Incomplete business plan equity breakdown; requires revised quotation for frozen meat chiller.',
    dateReturned: 'September 15, 2024',
    dateResubmission: 'September 28, 2024',
    dateReEvaluation: 'October 04, 2024',
    reEvaluatorName: 'Marilou S. Tan, Senior LEO',
    finalFindings: 'Resubmitted updated equipment quotation. Awaiting barangay clearance confirmation.',
    finalRemarks: 'Subject for final regional committee endorsement.',
    contactPerson: 'Haidee L. Cañada / (063) 228-7992',
    location: 'Prk 1 Sapphire, Hinaplanon, Iligan City, Lanao del Norte',
    birthdate: 'May 14, 1988',
    age: '36 Years Old',
    doleRequestAmount: '₱ 30,000.00',
    proponentEquity: '₱ 5,500.00',
    totalAmount: '₱ 35,500.00',
    typeOfBeneficiaries: 'Low Income Earner',
    beneficiaryBadgeClass: 'bg-rose-50 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300 border-rose-200 dark:border-rose-900/60',
    beneficiaryDotClass: 'bg-rose-500',
    typeOfProject: 'Individual (Formation)',
    projectName: 'Rice with Frozen Products Retailer',
    numDependents: '3',
    dependentsList: '1. Joshua Cañada (12 yo), 2. Faith Cañada (8 yo), 3. Liam Cañada (5 yo)'
  },
  {
    id: 2,
    name: 'Juanito M. Dela Cruz',
    gender: 'male',
    genderLabel: 'Male (M)',
    phone: '0917-234-5678',
    statusText: 'Approved',
    statusType: 'approved',
    dateReceived: 'August 10, 2024',
    dateEvaluated: 'August 18, 2024',
    evaluatorName: 'KATE',
    remarksFindings: 'All required permits and farm land tenure documents submitted and verified.',
    dateReturned: 'N/A',
    dateResubmission: 'N/A',
    dateReEvaluation: 'N/A',
    reEvaluatorName: 'N/A',
    finalFindings: 'Eligible for agricultural grains retail starter grant under DOLE DILP.',
    finalRemarks: 'Approved for procurement of grains storage bins and digital weighing scale.',
    contactPerson: 'Juanito M. Dela Cruz / 0917-234-5678',
    location: 'Purok 4, Brgy. Tipanoy, Iligan City, Lanao del Norte',
    birthdate: 'March 22, 1979',
    age: '45 Years Old',
    doleRequestAmount: '₱ 28,500.00',
    proponentEquity: '₱ 6,000.00',
    totalAmount: '₱ 34,500.00',
    typeOfBeneficiaries: 'Small Farmer',
    beneficiaryBadgeClass: 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300 border-emerald-200 dark:border-emerald-900/60',
    beneficiaryDotClass: 'bg-emerald-600',
    typeOfProject: 'Individual (Enhancement)',
    projectName: 'Agricultural Grains Retailing',
    numDependents: '4',
    dependentsList: '1. Maria Dela Cruz (Spouse), 2. Juan Dela Cruz Jr. (16 yo), 3. Angelica Dela Cruz (14 yo), 4. Carlo Dela Cruz (10 yo)'
  },
  {
    id: 3,
    name: 'Elena S. Mendoza',
    gender: 'female',
    genderLabel: 'Female (F)',
    phone: '0928-876-5432',
    statusText: 'Fund Released',
    statusType: 'released',
    dateReceived: 'July 02, 2024',
    dateEvaluated: 'July 11, 2024',
    evaluatorName: 'KATE',
    remarksFindings: 'Fisherfolk cooperative membership verified; passed technical readiness assessment.',
    dateReturned: 'N/A',
    dateResubmission: 'N/A',
    dateReEvaluation: 'N/A',
    reEvaluatorName: 'N/A',
    finalFindings: 'Check issued and disbursed for procurement of stainless fish smoker and drying racks.',
    finalRemarks: 'Monitoring scheduled on Q4 2024 for enterprise sustainability inspection.',
    contactPerson: 'Elena S. Mendoza / 0928-876-5432',
    location: 'Coastal Zone, Poblacion, Kapatagan, Lanao del Norte',
    birthdate: 'November 18, 1983',
    age: '41 Years Old',
    doleRequestAmount: '₱ 30,000.00',
    proponentEquity: '₱ 7,200.00',
    totalAmount: '₱ 37,200.00',
    typeOfBeneficiaries: 'Fisherfolk (Woman)',
    beneficiaryBadgeClass: 'bg-cyan-50 text-cyan-700 dark:bg-cyan-950/50 dark:text-cyan-300 border-cyan-200 dark:border-cyan-900/60',
    beneficiaryDotClass: 'bg-cyan-500',
    typeOfProject: 'Individual (Formation)',
    projectName: 'Fish Drying & Smoked Fish Kit',
    numDependents: '2',
    dependentsList: '1. Rey Mendoza (17 yo), 2. Grace Mendoza (11 yo)'
  },
  {
    id: 4,
    name: 'Marites A. Rosal',
    gender: 'female',
    genderLabel: 'Female (F)',
    phone: '0919-555-1234',
    statusText: 'Approved',
    statusType: 'approved',
    dateReceived: 'August 14, 2024',
    dateEvaluated: 'August 22, 2024',
    evaluatorName: 'KATE',
    remarksFindings: 'Indigenous weaving skill certificate attached; raw material sourcing plan confirmed.',
    dateReturned: 'N/A',
    dateResubmission: 'N/A',
    dateReEvaluation: 'N/A',
    reEvaluatorName: 'N/A',
    finalFindings: 'Complete documentation for handloom restoration kit and threads.',
    finalRemarks: 'Ready for check issuance and orientation seminar.',
    contactPerson: 'Marites A. Rosal / 0919-555-1234',
    location: 'Brgy. Maranding, Lala, Lanao del Norte',
    birthdate: 'June 09, 1976',
    age: '48 Years Old',
    doleRequestAmount: '₱ 29,000.00',
    proponentEquity: '₱ 4,500.00',
    totalAmount: '₱ 33,500.00',
    typeOfBeneficiaries: 'Self-Employed (Woman)',
    beneficiaryBadgeClass: 'bg-fuchsia-50 text-fuchsia-700 dark:bg-fuchsia-950/50 dark:text-fuchsia-300 border-fuchsia-200 dark:border-fuchsia-900/60',
    beneficiaryDotClass: 'bg-fuchsia-500',
    typeOfProject: 'Individual (Restoration)',
    projectName: 'Native Handloom Weaving Production',
    numDependents: '3',
    dependentsList: '1. Sarah Rosal (20 yo - Student), 2. Bryan Rosal (15 yo), 3. Chloe Rosal (9 yo)'
  },
  {
    id: 5,
    name: 'Rodrigo P. Tan',
    gender: 'male',
    genderLabel: 'Male (M)',
    phone: '0939-112-9988',
    statusText: 'Subject for Approval',
    statusType: 'approval',
    dateReceived: 'September 20, 2024',
    dateEvaluated: 'September 29, 2024',
    evaluatorName: 'KATE',
    remarksFindings: 'DAR beneficiary certificate verified; solar dryer layout matches standard specs.',
    dateReturned: 'N/A',
    dateResubmission: 'N/A',
    dateReEvaluation: 'N/A',
    reEvaluatorName: 'N/A',
    finalFindings: 'Evaluation passed; endorsed to Regional Director for final approval signature.',
    finalRemarks: 'Pending final executive approval.',
    contactPerson: 'Rodrigo P. Tan / 0939-112-9988',
    location: 'Brgy. Poblacion, Tubod, Lanao del Norte',
    birthdate: 'February 04, 1968',
    age: '56 Years Old',
    doleRequestAmount: '₱ 30,000.00',
    proponentEquity: '₱ 8,000.00',
    totalAmount: '₱ 38,000.00',
    typeOfBeneficiaries: 'Agrarian Reform Beneficiary',
    beneficiaryBadgeClass: 'bg-teal-50 text-teal-700 dark:bg-teal-950/50 dark:text-teal-300 border-teal-200 dark:border-teal-900/60',
    beneficiaryDotClass: 'bg-teal-500',
    typeOfProject: 'Individual (Enhancement)',
    projectName: 'Solar Dryer & Grain Handling Kit',
    numDependents: '2',
    dependentsList: '1. Corazon Tan (Spouse), 2. Rodel Tan (18 yo)'
  },
  {
    id: 6,
    name: 'Maria Clara Santos',
    gender: 'female',
    genderLabel: 'Female (F)',
    phone: '0917-889-3344',
    statusText: 'Approved',
    statusType: 'approved',
    dateReceived: 'August 12, 2024',
    dateEvaluated: 'August 19, 2024',
    evaluatorName: 'KATE',
    remarksFindings: 'Displacement certificate from shuttered garment factory submitted and validated.',
    dateReturned: 'N/A',
    dateResubmission: 'N/A',
    dateReEvaluation: 'N/A',
    reEvaluatorName: 'N/A',
    finalFindings: 'Passed evaluation for heavy-duty industrial sewing machine starter package.',
    finalRemarks: 'Ready for batch orientation and releasing.',
    contactPerson: 'Maria Clara Santos / 0917-889-3344',
    location: 'Brgy. Saray, Iligan City, Lanao del Norte',
    birthdate: 'January 12, 1985',
    age: '39 Years Old',
    doleRequestAmount: '₱ 30,000.00',
    proponentEquity: '₱ 5,000.00',
    totalAmount: '₱ 35,000.00',
    typeOfBeneficiaries: 'Displaced Worker',
    beneficiaryBadgeClass: 'bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300 border-amber-200 dark:border-amber-900/60',
    beneficiaryDotClass: 'bg-amber-500',
    typeOfProject: 'Individual (Formation)',
    projectName: 'Sewing & Garments Production',
    numDependents: '3',
    dependentsList: '1. Justin Santos (13 yo), 2. Nicole Santos (10 yo), 3. Andrea Santos (6 yo)'
  },
  {
    id: 7,
    name: 'Danilo G. Reyes',
    gender: 'male',
    genderLabel: 'Male (M)',
    phone: '0920-776-5544',
    statusText: 'Fund Released',
    statusType: 'released',
    dateReceived: 'June 15, 2024',
    dateEvaluated: 'June 25, 2024',
    evaluatorName: 'LAI',
    remarksFindings: 'Senior citizen ID and Barangay Senior Association recommendation verified.',
    dateReturned: 'N/A',
    dateResubmission: 'N/A',
    dateReEvaluation: 'N/A',
    reEvaluatorName: 'N/A',
    finalFindings: 'Fund disbursed for hydraulic cold-press coconut oil extractor and filter machine.',
    finalRemarks: 'Project operating successfully; first quarter income report received.',
    contactPerson: 'Danilo G. Reyes / 0920-776-5544',
    location: 'Brgy. Poblacion, Baroy, Lanao del Norte',
    birthdate: 'October 03, 1958',
    age: '66 Years Old',
    doleRequestAmount: '₱ 30,000.00',
    proponentEquity: '₱ 9,000.00',
    totalAmount: '₱ 39,000.00',
    typeOfBeneficiaries: 'Senior Citizen (SR)',
    beneficiaryBadgeClass: 'bg-sky-50 text-sky-700 dark:bg-sky-950/50 dark:text-sky-300 border-sky-200 dark:border-sky-900/60',
    beneficiaryDotClass: 'bg-sky-500',
    typeOfProject: 'Individual (Enhancement)',
    projectName: 'Virgin Coconut Oil Processing Kit',
    mergedStatusNote: 'APPROVED FIRST QUARTER 2026 - PAWFED',
    numDependents: '1',
    dependentsList: '1. Teresa Reyes (Spouse)'
  },
  {
    id: 8,
    name: 'Nestor V. Villanueva',
    gender: 'male',
    genderLabel: 'Male (M)',
    phone: '0927-665-4433',
    statusText: 'Subject for Re-Evaluation Upon Compliance',
    statusType: 're-eval',
    dateReceived: 'September 18, 2024',
    dateEvaluated: 'September 26, 2024',
    evaluatorName: 'LAI',
    remarksFindings: 'OWAS repatriation papers attached; missing workshop safety clearance from LGU.',
    dateReturned: 'September 30, 2024',
    dateResubmission: 'October 05, 2024',
    dateReEvaluation: 'October 07, 2024',
    reEvaluatorName: 'Marilou S. Tan, Senior LEO',
    finalFindings: 'LGU zoning permit submitted; pending safety checklist on compressor storage.',
    finalRemarks: 'Subject to follow-up on tool safety certificate before release.',
    contactPerson: 'Nestor V. Villanueva / 0927-665-4433',
    location: 'Brgy. Riverside, Kolambugan, Lanao del Norte',
    birthdate: 'July 15, 1981',
    age: '43 Years Old',
    doleRequestAmount: '₱ 30,000.00',
    proponentEquity: '₱ 6,500.00',
    totalAmount: '₱ 36,500.00',
    typeOfBeneficiaries: 'Displaced / OFW Returnee',
    beneficiaryBadgeClass: 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300 border-indigo-200 dark:border-indigo-900/60',
    beneficiaryDotClass: 'bg-indigo-500',
    typeOfProject: 'Individual (Formation)',
    projectName: 'Small Engine & Motorboat Repair',
    numDependents: '4',
    dependentsList: '1. Marilou Villanueva (Spouse), 2. Kevin Villanueva (15 yo), 3. Sam Villanueva (12 yo), 4. Bea Villanueva (7 yo)'
  },
  {
    id: 9,
    name: 'Francisco B. Ramos',
    gender: 'male',
    genderLabel: 'Male (M)',
    phone: '0917-332-1100',
    statusText: 'Approved',
    statusType: 'approved',
    dateReceived: 'August 25, 2024',
    dateEvaluated: 'September 03, 2024',
    evaluatorName: 'KATE',
    remarksFindings: 'Food sanitation training certificate verified; business has existing local market stalls.',
    dateReturned: 'N/A',
    dateResubmission: 'N/A',
    dateReEvaluation: 'N/A',
    reEvaluatorName: 'N/A',
    finalFindings: 'Fully qualified for native delicacies processing equipment and gas burners.',
    finalRemarks: 'Approved for procurement of stainless cooking kettles and vacuum sealer.',
    contactPerson: 'Francisco B. Ramos / 0917-332-1100',
    location: 'Brgy. Tubod, Iligan City, Lanao del Norte',
    birthdate: 'August 29, 1974',
    age: '50 Years Old',
    doleRequestAmount: '₱ 29,500.00',
    proponentEquity: '₱ 7,000.00',
    totalAmount: '₱ 36,500.00',
    typeOfBeneficiaries: 'Self-Employed Worker',
    beneficiaryBadgeClass: 'bg-violet-50 text-violet-700 dark:bg-violet-950/50 dark:text-violet-300 border-violet-200 dark:border-violet-900/60',
    beneficiaryDotClass: 'bg-violet-500',
    typeOfProject: 'Individual (Enhancement)',
    projectName: 'Food Processing & Native Delicacies',
    numDependents: '3',
    dependentsList: '1. Linda Ramos (Spouse), 2. Paolo Ramos (19 yo), 3. Alyssa Ramos (14 yo)'
  },
  {
    id: 10,
    name: 'Josephina M. Alcantara',
    gender: 'female',
    genderLabel: 'Female (F)',
    phone: '0930-998-7766',
    statusText: 'Approved',
    statusType: 'approved',
    dateReceived: 'August 28, 2024',
    dateEvaluated: 'September 06, 2024',
    evaluatorName: 'LAI',
    remarksFindings: 'PWD ID and certificate of baking skills from TESDA submitted and validated.',
    dateReturned: 'N/A',
    dateResubmission: 'N/A',
    dateReEvaluation: 'N/A',
    reEvaluatorName: 'N/A',
    finalFindings: 'Eligible for commercial deck baking oven and planetary mixer starter package.',
    finalRemarks: 'Approved with priority delivery assistance for PWD accessibility.',
    contactPerson: 'Josephina M. Alcantara / 0930-998-7766',
    location: 'Brgy. San Roque, Iligan City, Lanao del Norte',
    birthdate: 'December 17, 1991',
    age: '33 Years Old',
    doleRequestAmount: '₱ 30,000.00',
    proponentEquity: '₱ 6,000.00',
    totalAmount: '₱ 36,000.00',
    typeOfBeneficiaries: 'Person with Disability (PWD)',
    beneficiaryBadgeClass: 'bg-purple-50 text-purple-700 dark:bg-purple-950/50 dark:text-purple-300 border-purple-200 dark:border-purple-900/60',
    beneficiaryDotClass: 'bg-purple-500',
    typeOfProject: 'Individual (Formation)',
    projectName: 'Commercial Baking Starter Kit',
    numDependents: '2',
    dependentsList: '1. Gabriel Alcantara (8 yo), 2. Sophia Alcantara (4 yo)'
  }
];

// START OF CLASS: DrawerManager - Universal Flowbite off-canvas Drawer controller with dynamic subchild injection
export class DrawerManager {
  /**
   * START OF FUNCTION: constructor
   * Purpose: Initializes Flowbite drawer target element and options
   */
  constructor(drawerId = 'app-drawer', options = {}) {
    this.drawerId = drawerId;
    this.drawerEl = document.getElementById(drawerId);
    this.flowbiteDrawer = null;
    this.currentProponentIndex = 0;
    this.options = {
      placement: 'right',
      backdrop: true,
      bodyScrolling: false,
      edge: false,
      edgeOffset: '',
      backdropClasses: 'bg-stone-950/60 dark:bg-slate-950/80 fixed inset-0 z-40 backdrop-blur-xs',
      ...options
    };
  }
  // END OF FUNCTION: constructor

  /**
   * START OF FUNCTION: init
   * Purpose: Instantiates Flowbite Drawer component and ensures clean integration
   */
  init() {
    if (!this.drawerEl) {
      this.drawerEl = document.getElementById(this.drawerId);
    }
    if (!this.drawerEl) return this;

    try {
      this.flowbiteDrawer = new Drawer(this.drawerEl, this.options);
    } catch (err) {
      console.warn('Flowbite Drawer initialization:', err);
    }

    // Auto-bind proponent viewer triggers for universal app-drawer
    if (this.drawerId === 'app-drawer') {
      this.bindProponentTriggers();
    }

    return this;
  }
  // END OF FUNCTION: init

  /**
   * START OF FUNCTION: bindProponentTriggers
   * Purpose: Attaches click handlers to all .proponent-view-trigger elements on the page
   */
  bindProponentTriggers() {
    document.querySelectorAll('.proponent-view-trigger').forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const id = parseInt(btn.getAttribute('data-proponent-id') || '1', 10);
        this.showProponentDetail(id);
      });
    });
  }
  // END OF FUNCTION: bindProponentTriggers

  setContent(title, htmlContent, subtitle = '') {
    if (!this.drawerEl) {
      this.drawerEl = document.getElementById(this.drawerId);
    }
    if (!this.drawerEl) return;
    const titleEl = this.drawerEl.querySelector(`#${this.drawerId}-heading`) || this.drawerEl.querySelector('h5 span') || this.drawerEl.querySelector('h3 span');
    const subtitleEl = this.drawerEl.querySelector(`#${this.drawerId}-subtitle`);
    const contentEl = this.drawerEl.querySelector(`#${this.drawerId}-content`);

    if (titleEl && title) {
      titleEl.textContent = title;
    }
    if (subtitleEl) {
      if (subtitle) {
        subtitleEl.textContent = subtitle;
        subtitleEl.classList.remove('hidden');
      } else {
        subtitleEl.textContent = '';
        subtitleEl.classList.add('hidden');
      }
    }
    if (contentEl && htmlContent) {
      contentEl.innerHTML = htmlContent;
    }
  }
  // END OF FUNCTION: setContent

  /**
   * START OF FUNCTION: showProponentDetail
   * Purpose: Dynamically generates comprehensive DOLE Proponent Detail subchild HTML and opens drawer
   */
  showProponentDetail(id = 1) {
    const index = PROPONENTS_DATA.findIndex((p) => p.id === id);
    this.currentProponentIndex = index >= 0 ? index : 0;
    this.renderProponentViewer();
    this.show();
  }
  // END OF FUNCTION: showProponentDetail

  /**
   * START OF FUNCTION: renderProponentViewer
   * Purpose: Builds rich modern viewer markup with Prev/Next cycling in drawer header, Hero Card, 3-Card Status Strip & Flowbite Tabs
   */
  renderProponentViewer() {
    const data = PROPONENTS_DATA[this.currentProponentIndex];
    if (!data) return;

    const formattedCurrent = String(this.currentProponentIndex + 1).padStart(2, '0');
    const formattedTotal = String(PROPONENTS_DATA.length).padStart(2, '0');

    // Inject Prev/Next & Counter into Drawer Header on the right side of Proponent Detail
    const headerActionsEl = this.drawerEl ? this.drawerEl.querySelector(`#${this.drawerId}-header-actions`) : null;
    if (headerActionsEl) {
      headerActionsEl.innerHTML = `
        <div class="flex items-center gap-1.5 sm:gap-2">
            <button
                type="button"
                id="dynamic-prev-btn"
                class="w-8 h-8 rounded-full border border-stone-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-stone-700 dark:text-slate-300 hover:bg-stone-50 dark:hover:bg-slate-800 flex items-center justify-center transition cursor-pointer active:scale-95 disabled:opacity-40 disabled:cursor-not-allowed"
                ${this.currentProponentIndex === 0 ? 'disabled' : ''}
                aria-label="Previous proponent"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button
                type="button"
                id="dynamic-next-btn"
                class="w-8 h-8 rounded-full border border-stone-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-stone-700 dark:text-slate-300 hover:bg-stone-50 dark:hover:bg-slate-800 flex items-center justify-center transition cursor-pointer active:scale-95 disabled:opacity-40 disabled:cursor-not-allowed"
                ${this.currentProponentIndex === PROPONENTS_DATA.length - 1 ? 'disabled' : ''}
                aria-label="Next proponent"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>
            <span class="text-xs text-stone-900 dark:text-white min-w-16 text-center select-none font-bold">
                <strong class="font-black">${formattedCurrent}</strong> <span class="font-normal text-stone-500 dark:text-slate-400">of</span> <strong class="font-black">${formattedTotal}</strong>
            </span>
        </div>
      `;
    }

    const genderSvg = data.gender === 'male'
      ? `<svg class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Male"><circle cx="10" cy="14" r="5"></circle><line x1="19" y1="5" x2="13.5" y2="10.5"></line><polyline points="15 5 19 5 19 9"></polyline></svg>`
      : `<svg class="w-5 h-5 text-pink-600 dark:text-pink-400 shrink-0 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-label="Female"><circle cx="12" cy="9" r="5"></circle><line x1="12" y1="14" x2="12" y2="21"></line><line x1="9" y1="18" x2="15" y2="18"></line></svg>`;

    let statusBadgeHtml = '';
    if (data.statusType === 're-eval') {
      statusBadgeHtml = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-amber-700 text-white dark:bg-amber-600 dark:text-amber-50 shadow-2xs whitespace-nowrap"><span class="w-1.5 h-1.5 rounded-full bg-white"></span>${data.statusText}</span>`;
    } else if (data.statusType === 'approval') {
      statusBadgeHtml = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-900 dark:bg-amber-950/70 dark:text-amber-200 border border-amber-300 dark:border-amber-700 shadow-2xs whitespace-nowrap"><span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>${data.statusText}</span>`;
    } else if (data.statusType === 'released') {
      statusBadgeHtml = `<span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300 shadow-2xs whitespace-nowrap"><span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>${data.statusText}</span>`;
    } else {
      statusBadgeHtml = `<span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 shadow-2xs whitespace-nowrap"><span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>${data.statusText}</span>`;
    }

    let evaluatorBadgeClass = 'bg-orange-100 text-orange-900 border border-orange-200 dark:bg-orange-950/60 dark:text-orange-300 dark:border-orange-800';
    if (data.evaluatorName.toUpperCase().includes('LAI')) {
      evaluatorBadgeClass = 'bg-sky-100 text-sky-900 border border-sky-200 dark:bg-sky-950/60 dark:text-sky-300 dark:border-sky-800';
    } else if (data.evaluatorName.toUpperCase().includes('DANILO')) {
      evaluatorBadgeClass = 'bg-emerald-100 text-emerald-900 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800';
    }

    const html = `
      <!-- START OF PROPONENT VIEWER SUBCHILD -->
      <div class="space-y-5">

        <!-- Hero Profile & Metadata Section -->
        <div class="space-y-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-black text-lg shrink-0 shadow-2xs">
                    ${data.id}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <h3 class="text-base sm:text-lg font-black text-stone-900 dark:text-white truncate">
                            ${data.name}
                        </h3>
                        ${genderSvg}
                    </div>
                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-bold rounded-full ${data.beneficiaryBadgeClass}">
                            <span class="w-1.5 h-1.5 rounded-full ${data.beneficiaryDotClass}"></span>
                            ${data.typeOfBeneficiaries}
                        </div>
                        <span class="text-stone-300 dark:text-slate-600 hidden sm:inline">|</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-md border border-sky-300 dark:border-sky-700/80 bg-sky-50/60 dark:bg-sky-950/40 text-sky-600 dark:text-sky-400 tracking-wide font-mono">
                            ${data.phone}
                        </span>
                        <span class="text-stone-300 dark:text-slate-600 hidden sm:inline">•</span>
                        <span class="text-xs text-stone-600 dark:text-slate-300 font-medium">${data.age}</span>
                    </div>
                </div>
            </div>

            <!-- 3-Column Metadata Strip with Vertical Dividers -->
            <div class="inline-flex flex-col sm:flex-row items-stretch sm:items-center divide-y sm:divide-y-0 sm:divide-x divide-stone-200 dark:divide-slate-700 bg-transparent rounded-xl p-2.5 sm:p-3 border border-stone-200/90 dark:border-slate-700/80 gap-2.5 sm:gap-0 max-w-full">
                <div class="sm:px-3.5 text-left py-0.5 sm:py-0 shrink-0">
                    <span class="block text-[10.5px] uppercase tracking-wider font-semibold text-stone-500 dark:text-slate-400 mb-0.5">
                        NAME OF EVALUATOR
                    </span>
                    <div class="whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 text-xs font-black uppercase tracking-wider rounded-full ${evaluatorBadgeClass} whitespace-nowrap shadow-2xs">
                            ${data.evaluatorName}
                        </span>
                    </div>
                </div>
                <div class="sm:px-3.5 text-left py-0.5 sm:py-0 shrink-0 max-w-full">
                    <span class="block text-[10.5px] uppercase tracking-wider font-semibold text-stone-500 dark:text-slate-400 mb-0.5">
                        Status
                    </span>
                    <div class="inline-block">${statusBadgeHtml}</div>
                </div>
                <div class="sm:px-3.5 text-left py-0.5 sm:py-0 shrink-0">
                    <span class="block text-[10.5px] uppercase tracking-wider font-semibold text-stone-500 dark:text-slate-400 mb-0.5">
                        DATE EVALUATED
                    </span>
                    <span class="font-bold text-stone-900 dark:text-white text-xs whitespace-nowrap">
                        ${data.dateEvaluated}
                    </span>
                </div>
            </div>
        </div>

        <!-- Segmented Tab Navigation -->
        <div class="border-b border-stone-200 dark:border-slate-800">
            <ul class="flex flex-wrap -mb-px text-sm font-semibold text-center text-stone-500 dark:text-slate-400" id="injected-tabs">
                <li class="me-2">
                    <button class="injected-tab-btn inline-flex items-center gap-2 p-3 sm:p-3.5 border-b-2 rounded-t-lg transition-colors cursor-pointer text-emerald-700 border-emerald-700 dark:text-emerald-400 dark:border-emerald-400 font-bold" data-target="pane-detail" type="button">
                        <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><circle cx="128" cy="96" r="64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M32,216c19.37-33.47,54.55-56,96-56s76.63,22.53,96,56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        Detail Information
                    </button>
                </li>
                <li class="me-2">
                    <button class="injected-tab-btn inline-flex items-center gap-2 p-3 sm:p-3.5 border-b-2 border-transparent hover:text-stone-700 hover:border-stone-300 dark:hover:text-slate-200 dark:hover:border-slate-700 transition-colors cursor-pointer" data-target="pane-financial" type="button">
                        <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><polyline points="184 48 224 48 224 88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="72 208 32 208 32 168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="224 168 224 208 184 208" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="32 88 32 48 72 48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polygon points="128 64 184 96 184 160 128 192 72 160 72 96 128 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="72 96 128 128 184 96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="128" y1="128" x2="128" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        Status & Projects
                    </button>
                </li>
                <li>
                    <button class="injected-tab-btn inline-flex items-center gap-2 p-3 sm:p-3.5 border-b-2 border-transparent hover:text-stone-700 hover:border-stone-300 dark:hover:text-slate-200 dark:hover:border-slate-700 transition-colors cursor-pointer" data-target="pane-eval" type="button">
                        <svg class="w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M200,224H56a8,8,0,0,1-8-8V40a8,8,0,0,1,8-8h96l56,56V216A8,8,0,0,1,200,224Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><rect x="80" y="120" width="96" height="72" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="112" y1="152" x2="112" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="144" y1="152" x2="144" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        Remarks & Dependents
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab 1: Detail Information -->
        <div id="pane-detail" class="injected-pane space-y-4">
            <div class="space-y-3 text-xs sm:text-sm">
                <div class="grid grid-cols-12 gap-2 py-1.5 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-stone-400 dark:text-slate-500 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><circle cx="128" cy="120" r="40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M104,35a95.51,95.51,0,0,1,48,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M35.49,102.3a95.54,95.54,0,0,1,24-41.56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M152,221a95.51,95.51,0,0,1-48,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M196.51,60.73a95.54,95.54,0,0,1,24,41.58" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M220.52,153.7a96,96,0,0,1-28.32,45.67,72,72,0,0,0-128.4,0A96,96,0,0,1,35.48,153.7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        <span>Full Name</span>
                    </div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white flex items-center gap-1.5">
                        <span>:</span>
                        <span>${data.name}</span>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-2 py-1.5 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-stone-400 dark:text-slate-500 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><circle cx="120" cy="112" r="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="120" y1="168" x2="120" y2="232" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="88" y1="200" x2="152" y2="200" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="168 32 208 32 208 72" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="163.4" y1="76.6" x2="208" y2="32" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        <span>Sex / Gender</span>
                    </div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white flex items-center gap-1.5">
                        <span>:</span>
                        <span>${data.genderLabel}</span>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-2 py-1.5 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-stone-400 dark:text-slate-500 shrink-0" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m 8.46875,2.3144531 -0.2636719,0.265625 c -0.1244427,0.124288 -0.2709286,0.3055081 -0.296875,0.6015625 -0.025946,0.2960545 0.149986,0.6053668 0.3125,0.7402344 0.325028,0.2697352 0.5510045,0.25 0.7792969,0.25 0.2282924,0 0.4542689,0.019735 0.7792969,-0.25 C 9.9418109,3.7870074 10.117743,3.4776951 10.091797,3.1816406 10.06585,2.8855862 9.9193646,2.7043661 9.7949219,2.5800781 L 9.53125,2.3144531 a 0.750075,0.750075 0 0 0 -1.0625,0 z m 3,0 -0.263672,0.265625 c -0.124443,0.124288 -0.270928,0.3055081 -0.296875,0.6015625 -0.02595,0.2960545 0.149986,0.6053668 0.3125,0.7402344 0.325028,0.2697352 0.551005,0.25 0.779297,0.25 0.228292,0 0.454269,0.019735 0.779297,-0.25 0.162514,-0.1348676 0.338446,-0.4441799 0.3125,-0.7402344 C 13.06585,2.8855862 12.919365,2.7043661 12.794922,2.5800781 L 12.53125,2.3144531 a 0.750075,0.750075 0 0 0 -1.0625,0 z m 3,0 -0.263672,0.265625 c -0.124443,0.124288 -0.270928,0.3055081 -0.296875,0.6015625 -0.02595,0.2960545 0.149986,0.6053668 0.3125,0.7402344 0.325028,0.2697352 0.551005,0.25 0.779297,0.25 0.228292,0 0.454269,0.019735 0.779297,-0.25 0.162514,-0.1348676 0.338446,-0.4441799 0.3125,-0.7402344 C 16.06585,2.8855862 15.919365,2.7043661 15.794922,2.5800781 L 15.53125,2.3144531 a 0.750075,0.750075 0 0 0 -1.0625,0 z M 9,2.671875 c -0.00843,0 -0.01991,-0.069939 0.1796875,0.095703 C 9.2794862,2.8503994 9.4214481,3.0945151 9.4023438,3.3125 9.3832394,3.5304849 9.2858454,3.6204298 9.265625,3.640625 L 9,3.90625 8.734375,3.640625 C 8.7141546,3.6204298 8.6167606,3.5304849 8.5976563,3.3125 8.5785519,3.0945151 8.7205138,2.8503994 8.8203125,2.7675781 9.0199099,2.6019356 9.0084299,2.671875 9,2.671875 Z m 3,0 c -0.0084,0 -0.01991,-0.069939 0.179688,0.095703 0.0998,0.082821 0.24176,0.326937 0.222656,0.5449219 -0.0191,0.2179849 -0.116499,0.3079298 -0.136719,0.328125 L 12,3.90625 11.734375,3.640625 C 11.714155,3.6204298 11.616761,3.5304849 11.597656,3.3125 11.578552,3.0945151 11.720514,2.8503994 11.820313,2.7675781 12.01991,2.6019356 12.00843,2.671875 12,2.671875 Z m 3,0 c -0.0084,0 -0.01991,-0.069939 0.179688,0.095703 0.0998,0.082821 0.24176,0.326937 0.222656,0.5449219 -0.0191,0.2179849 -0.116499,0.3079298 -0.136719,0.328125 L 15,3.90625 14.734375,3.640625 C 14.714155,3.6204298 14.616761,3.5304849 14.597656,3.3125 14.578552,3.0945151 14.720514,2.8503994 14.820313,2.7675781 15.01991,2.6019356 15.00843,2.671875 15,2.671875 Z M 9,6 A 0.75,0.75 0 0 0 8.25,6.75 V 7.6542969 C 8.1390019,7.6627384 8.0248578,7.6587845 7.9140625,7.6679687 6.3924352,7.7944347 5.25,9.1001752 5.25,10.607422 v 1.859375 c -0.1750124,0.02447 -0.3506528,0.04588 -0.5253906,0.07227 C 3.2859755,12.755312 2.25,14.020121 2.25,15.455078 V 20.625 c 0,1.02665 0.8483496,1.875 1.875,1.875 h 15.75 c 1.026797,0 1.875,-0.848203 1.875,-1.875 v -5.169922 c 0,-1.435165 -1.035184,-2.699848 -2.474609,-2.916015 h -0.002 C 19.09957,12.512945 18.924255,12.490982 18.75,12.466797 V 10.607422 C 18.75,9.1001752 17.607565,7.7944347 16.085937,7.6679687 15.975142,7.6587845 15.860998,7.6627384 15.75,7.6542969 V 6.75 A 0.75,0.75 0 0 0 15,6 0.75,0.75 0 0 0 14.25,6.75 V 7.5917969 C 13.750472,7.5690333 13.253234,7.5388877 12.75,7.53125 V 6.75 A 0.75,0.75 0 0 0 12,6 0.75,0.75 0 0 0 11.25,6.75 v 0.78125 c -0.503234,0.00764 -1.000472,0.037783 -1.5,0.060547 V 6.75 A 0.75,0.75 0 0 0 9,6 Z m 3,3 c 1.334336,0 2.656493,0.05577 3.962891,0.1640625 C 16.702308,9.2264919 17.25,9.8453161 17.25,10.607422 v 1.716797 C 15.505057,12.137413 13.755316,11.999487 12,12 10.222086,12 8.4793185,12.138691 6.75,12.324219 V 10.607422 C 6.75,9.8453161 7.2976922,9.2264919 8.0371094,9.1640625 9.3435069,9.0557703 10.665664,9 12,9 Z m 0,4.5 c 1.974066,-5.77e-4 3.947284,0.121546 5.90625,0.365234 6.45e-4,8.1e-5 0.0013,-8e-5 0.002,0 0.383863,0.04824 0.763665,0.101268 1.142578,0.158204 a 0.750075,0.750075 0 0 0 0.002,0 C 19.752371,14.128056 20.25,14.728842 20.25,15.455078 v 0.582031 l -1.085938,0.542969 c -0.733705,0.366867 -1.594419,0.366867 -2.328125,0 -1.15483,-0.577437 -2.517044,-0.577437 -3.671874,0 -0.733706,0.366867 -1.59442,0.366867 -2.328125,0 -1.1548314,-0.577437 -2.5170446,-0.577437 -3.6718755,0 -0.7337054,0.366867 -1.5944196,0.366867 -2.328125,0 L 3.75,16.037109 v -0.582031 c 0,-0.724444 0.4988363,-1.327105 1.1972656,-1.43164 a 0.750075,0.750075 0 0 0 0.00195,0 c 0.3790054,-0.05722 0.758381,-0.112218 1.1386719,-0.160157 a 0.75,0.75 0 0 0 0.00391,0.002 C 8.027109,13.624059 9.9990039,13.5 12,13.5 Z m -3,4.146484 c 0.3988635,0 0.7972098,0.09 1.164063,0.273438 1.15483,0.577437 2.517044,0.577437 3.671875,0 0.733705,-0.366867 1.594419,-0.366867 2.328124,0 1.154831,0.577437 2.517045,0.577437 3.671875,0 L 20.25,17.712891 V 20.625 C 20.25,20.840203 20.090203,21 19.875,21 H 4.125 C 3.9090097,21 3.75,20.84099 3.75,20.625 v -2.912109 l 0.4140625,0.207031 c 1.1548309,0.577437 2.5170441,0.577437 3.671875,0 C 8.2027902,17.736489 8.6011365,17.646484 9,17.646484 Z"/></svg>
                        <span>Birthdate</span>
                    </div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white flex items-center gap-1.5">
                        <span>:</span>
                        <span>${data.birthdate}</span>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-2 py-1.5 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-stone-400 dark:text-slate-500 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><rect x="40" y="40" width="176" height="176" rx="8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="176" y1="24" x2="176" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="80" y1="24" x2="80" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="40" y1="88" x2="216" y2="88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><circle cx="128" cy="132" r="12"/><circle cx="172" cy="132" r="12"/><circle cx="84" cy="172" r="12"/><circle cx="128" cy="172" r="12"/><circle cx="172" cy="172" r="12"/></svg>
                        <span>Age</span>
                    </div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white flex items-center gap-1.5">
                        <span>:</span>
                        <span>${data.age}</span>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-2 py-1.5 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-stone-400 dark:text-slate-500 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M200,224H56a8,8,0,0,1-8-8V40a8,8,0,0,1,8-8h96l56,56V216A8,8,0,0,1,200,224Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><rect x="80" y="120" width="96" height="72" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="112" y1="152" x2="112" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="144" y1="152" x2="144" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        <span>Contact Person / #</span>
                    </div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white">: ${data.contactPerson}</div>
                </div>
                <div class="grid grid-cols-12 gap-2 py-1.5 border-b border-stone-100 dark:border-slate-800/60 items-start">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium pt-0.5 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-stone-400 dark:text-slate-500 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><circle cx="128" cy="80" r="16"/><path d="M184,80c0,56-56,88-56,88S72,136,72,80a56,56,0,0,1,112,0Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M200,155.14c19.72,7.28,32,17.52,32,28.86,0,22.09-46.56,40-104,40S24,206.09,24,184c0-11.34,12.28-21.58,32-28.86" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        <span>Location</span>
                    </div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white">: ${data.location}</div>
                </div>
                <div class="grid grid-cols-12 gap-2 py-1.5 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-stone-400 dark:text-slate-500 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M131.84,25l88,48.18a8,8,0,0,1,4.16,7v95.64a8,8,0,0,1-4.16,7l-88,48.18a8,8,0,0,1-7.68,0l-88-48.18a8,8,0,0,1-4.16-7V80.18a8,8,0,0,1,4.16-7l88-48.18A8,8,0,0,1,131.84,25Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="128" y1="128" x2="128" y2="232" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="32.03 125.73 80 152 80 206.84" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="224 125.72 176 152 176 206.84" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="83.14 47.44 128 72 172.86 47.44" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="33.14 76.06 128 128 222.86 76.06" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        <span>Type of Project</span>
                    </div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white">: ${data.typeOfProject}</div>
                </div>
                <div class="grid grid-cols-12 gap-2 py-1.5 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-stone-400 dark:text-slate-500 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><polyline points="184 48 224 48 224 88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="72 208 32 208 32 168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="224 168 224 208 184 208" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="32 88 32 48 72 48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polygon points="128 64 184 96 184 160 128 192 72 160 72 96 128 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="72 96 128 128 184 96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="128" y1="128" x2="128" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        <span>Project Name</span>
                    </div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-emerald-800 dark:text-emerald-300">: ${data.projectName}</div>
                </div>
            </div>

            <!-- START OF SUBCHILD: Re-Evaluation & Status Workflow Tracking Grid -->
            <div class="mt-5 pt-4 border-t border-stone-200 dark:border-slate-800 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <h4 class="text-xs font-black uppercase tracking-wider text-stone-700 dark:text-slate-300">
                            Re-Evaluation & Submission Workflow
                        </h4>
                    </div>

                    <!-- Layout Mode Dropdown Selector -->
                    <div class="flex items-center gap-1.5">
                        <label for="reeval-mode-select" class="text-[11px] font-semibold text-stone-500 dark:text-slate-400">View Mode:</label>
                        <select
                            id="reeval-mode-select"
                            class="text-xs font-bold py-1 px-2.5 rounded-lg bg-stone-100 dark:bg-slate-800 border border-stone-300 dark:border-slate-700 text-stone-800 dark:text-slate-200 cursor-pointer focus:ring-1 focus:ring-amber-500 focus:border-amber-500 transition shadow-2xs"
                        >
                            <option value="cards" ${!data.mergedStatusNote ? 'selected' : ''}>4-Cards Breakdown</option>
                            <option value="merged" ${data.mergedStatusNote ? 'selected' : ''}>All-in-One Banner</option>
                        </select>
                    </div>
                </div>

                <!-- Mode A: 4 Interactive / Inputtable Cards (Solid Yellow Fill & Rounded Radious with custom note inputs) -->
                <div id="reeval-cards-container" class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 ${data.mergedStatusNote ? 'hidden' : ''}">
                    <!-- Card 1: DATE RETURNED -->
                    <div class="p-2.5 rounded-xl bg-amber-200/90 dark:bg-amber-950/80 border border-amber-400 dark:border-amber-700 flex flex-col justify-between shadow-2xs transition hover:border-amber-500">
                        <span class="block text-[10px] font-black uppercase tracking-wider text-amber-950 dark:text-amber-100 mb-1.5 leading-tight">
                            DATE RETURNED
                        </span>
                        <div class="relative mt-auto">
                            <input
                                type="text"
                                class="w-full text-xs font-black text-stone-900 dark:text-white bg-white dark:bg-slate-900 rounded-lg px-2.5 py-1.5 border border-amber-400/90 dark:border-amber-600 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-2xs cursor-text placeholder-stone-400"
                                value="${data.dateReturned || 'N/A'}"
                                placeholder="Enter date or note..."
                                title="${data.dateReturned || 'N/A'}"
                            />
                        </div>
                    </div>

                    <!-- Card 2: DATE OF RESUBMISSION -->
                    <div class="p-2.5 rounded-xl bg-amber-200/90 dark:bg-amber-950/80 border border-amber-400 dark:border-amber-700 flex flex-col justify-between shadow-2xs transition hover:border-amber-500">
                        <span class="block text-[10px] font-black uppercase tracking-wider text-amber-950 dark:text-amber-100 mb-1.5 leading-tight">
                            DATE OF RESUBMISSION
                        </span>
                        <div class="relative mt-auto">
                            <input
                                type="text"
                                class="w-full text-xs font-black text-stone-900 dark:text-white bg-white dark:bg-slate-900 rounded-lg px-2.5 py-1.5 border border-amber-400/90 dark:border-amber-600 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-2xs cursor-text placeholder-stone-400"
                                value="${data.dateResubmission || 'N/A'}"
                                placeholder="Enter date or note..."
                                title="${data.dateResubmission || 'N/A'}"
                            />
                        </div>
                    </div>

                    <!-- Card 3: DATE OF RE-EVALUATION -->
                    <div class="p-2.5 rounded-xl bg-amber-200/90 dark:bg-amber-950/80 border border-amber-400 dark:border-amber-700 flex flex-col justify-between shadow-2xs transition hover:border-amber-500">
                        <span class="block text-[10px] font-black uppercase tracking-wider text-amber-950 dark:text-amber-100 mb-1.5 leading-tight">
                            DATE OF RE-EVALUATION
                        </span>
                        <div class="relative mt-auto">
                            <input
                                type="text"
                                class="w-full text-xs font-black text-stone-900 dark:text-white bg-white dark:bg-slate-900 rounded-lg px-2.5 py-1.5 border border-amber-400/90 dark:border-amber-600 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-2xs cursor-text placeholder-stone-400"
                                value="${data.dateReEvaluation || 'N/A'}"
                                placeholder="Enter date or note..."
                                title="${data.dateReEvaluation || 'N/A'}"
                            />
                        </div>
                    </div>

                    <!-- Card 4: NAME OF RE-EVALUATOR -->
                    <div class="p-2.5 rounded-xl bg-amber-200/90 dark:bg-amber-950/80 border border-amber-400 dark:border-amber-700 flex flex-col justify-between shadow-2xs transition hover:border-amber-500">
                        <span class="block text-[10px] font-black uppercase tracking-wider text-amber-950 dark:text-amber-100 mb-1.5 leading-tight">
                            NAME OF RE-EVALUATOR
                        </span>
                        <div class="relative mt-auto">
                            <input
                                type="text"
                                class="w-full text-xs font-black text-stone-900 dark:text-white bg-white dark:bg-slate-900 rounded-lg px-2.5 py-1.5 border border-amber-400/90 dark:border-amber-600 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-2xs cursor-text placeholder-stone-400"
                                value="${data.reEvaluatorName || 'N/A'}"
                                placeholder="Enter evaluator name or note..."
                                title="${data.reEvaluatorName || 'N/A'}"
                            />
                        </div>
                    </div>
                </div>

                <!-- Mode B: All-in-One Banner Card (Rounded Radious Style with editable custom note) -->
                <div id="reeval-merged-container" class="p-3.5 rounded-2xl bg-cyan-400 dark:bg-cyan-500 text-stone-950 font-black text-center text-xs sm:text-sm tracking-wide uppercase border-2 border-cyan-500 dark:border-cyan-400 shadow-md transition hover:scale-[1.01] ${!data.mergedStatusNote ? 'hidden' : ''}">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 shrink-0 text-stone-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span id="reeval-merged-text">${data.mergedStatusNote || 'APPROVED FIRST QUARTER 2026 - PAWFED'}</span>
                    </div>
                </div>
            </div>
            <!-- END OF SUBCHILD: Re-Evaluation & Status Workflow Tracking Grid -->
        </div>

        <!-- START OF SUBCHILD: Tab 2 - Status & Projects -->
        <div id="pane-financial" class="injected-pane space-y-4 hidden">
            <!-- Project Identification Card -->
            <div class="p-4 rounded-xl bg-stone-50 dark:bg-slate-800/60 border border-stone-200/90 dark:border-slate-700/80 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-stone-200/80 dark:border-slate-700/80">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><polyline points="184 48 224 48 224 88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="72 208 32 208 32 168" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="224 168 224 208 184 208" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="32 88 32 48 72 48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polygon points="128 64 184 96 184 160 128 192 72 160 72 96 128 64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polyline points="72 96 128 128 184 96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="128" y1="128" x2="128" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        <span class="text-xs font-black uppercase tracking-wider text-stone-700 dark:text-slate-300">Project Identity & Status</span>
                    </div>
                    <div>${statusBadgeHtml}</div>
                </div>

                <div class="grid grid-cols-12 gap-2 text-xs sm:text-sm py-1 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium">PROJECT NAME</div>
                    <div class="col-span-7 sm:col-span-8 font-black text-emerald-800 dark:text-emerald-300 uppercase">: ${data.projectName}</div>
                </div>

                <div class="grid grid-cols-12 gap-2 text-xs sm:text-sm py-1 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium">TYPE OF PROJECT</div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white uppercase">: ${data.typeOfProject}</div>
                </div>

                <div class="grid grid-cols-12 gap-2 text-xs sm:text-sm py-1 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium">BENEFICIARY TYPE</div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white uppercase">: ${data.typeOfBeneficiaries}</div>
                </div>

                <div class="grid grid-cols-12 gap-2 text-xs sm:text-sm py-1 items-start">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium pt-0.5">PROJECT LOCATION</div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white uppercase">: ${data.location}</div>
                </div>
            </div>

            <!-- Capital Funding Breakdown (DOLE Request, Equity, Total Amount) -->
            <div>
                <div class="flex items-center gap-1.5 mb-2.5">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><circle cx="128" cy="128" r="96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="128" y1="80" x2="128" y2="176" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M104,112a24,24,0,0,1,48,0c0,16-24,20-24,28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><circle cx="128" cy="180" r="4"/></svg>
                    <span class="text-xs font-black uppercase tracking-wider text-stone-700 dark:text-slate-300">Capital Funding Allocation</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                    <div class="p-3.5 rounded-xl bg-emerald-50/70 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900/60 shadow-2xs">
                        <span class="text-[11px] font-bold text-emerald-800 dark:text-emerald-300 block mb-1">DOLE REQUEST AMOUNT</span>
                        <div class="text-base sm:text-lg font-black text-emerald-900 dark:text-emerald-200">${data.doleRequestAmount}</div>
                        <span class="text-[10px] uppercase font-bold text-emerald-700 dark:text-emerald-400">Grant Component</span>
                    </div>
                    <div class="p-3.5 rounded-xl bg-amber-50/70 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-900/60 shadow-2xs">
                        <span class="text-[11px] font-bold text-amber-800 dark:text-amber-300 block mb-1">PROPONENT EQUITY</span>
                        <div class="text-base sm:text-lg font-black text-amber-900 dark:text-amber-200">${data.proponentEquity}</div>
                        <span class="text-[10px] uppercase font-bold text-amber-700 dark:text-amber-400">Counterpart Equity</span>
                    </div>
                    <div class="p-3.5 rounded-xl bg-blue-50/70 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 shadow-2xs">
                        <span class="text-[11px] font-bold text-blue-800 dark:text-blue-300 block mb-1">TOTAL AMOUNT</span>
                        <div class="text-base sm:text-lg font-black text-blue-900 dark:text-blue-200">${data.totalAmount}</div>
                        <span class="text-[10px] uppercase font-bold text-blue-700 dark:text-blue-400">Total Project Capital</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END OF SUBCHILD: Tab 2 - Status & Projects -->

        <!-- START OF SUBCHILD: Tab 3 - Remarks & Dependents -->
        <div id="pane-eval" class="injected-pane space-y-4 hidden">
            <!-- Evaluation Log & Findings -->
            <div class="p-4 rounded-xl bg-stone-50 dark:bg-slate-800/60 border border-stone-200/90 dark:border-slate-700/80 space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-stone-200/80 dark:border-slate-700/80">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M200,224H56a8,8,0,0,1-8-8V40a8,8,0,0,1,8-8h96l56,56V216A8,8,0,0,1,200,224Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="96" y1="128" x2="160" y2="128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="96" y1="160" x2="160" y2="160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                    <span class="text-xs font-black uppercase tracking-wider text-stone-700 dark:text-slate-300">Evaluation Records & Findings</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                    <div class="p-2.5 rounded-lg bg-white dark:bg-slate-900 border border-stone-200 dark:border-slate-700/80">
                        <span class="text-[10px] font-bold text-stone-500 dark:text-slate-400 uppercase tracking-wider block mb-0.5">DATE RECEIVED</span>
                        <span class="font-extrabold text-stone-900 dark:text-white text-xs sm:text-sm">${data.dateReceived}</span>
                    </div>
                    <div class="p-2.5 rounded-lg bg-white dark:bg-slate-900 border border-stone-200 dark:border-slate-700/80">
                        <span class="text-[10px] font-bold text-stone-500 dark:text-slate-400 uppercase tracking-wider block mb-0.5">DATE EVALUATED</span>
                        <span class="font-extrabold text-stone-900 dark:text-white text-xs sm:text-sm">${data.dateEvaluated}</span>
                    </div>
                    <div class="p-2.5 rounded-lg bg-white dark:bg-slate-900 border border-stone-200 dark:border-slate-700/80">
                        <span class="text-[10px] font-bold text-stone-500 dark:text-slate-400 uppercase tracking-wider block mb-0.5">EVALUATOR</span>
                        <span class="font-extrabold text-stone-900 dark:text-white text-xs sm:text-sm uppercase">${data.evaluatorName}</span>
                    </div>
                </div>

                <div class="space-y-2 pt-1 text-xs sm:text-sm">
                    <div class="grid grid-cols-12 gap-2 py-1.5 border-b border-stone-100 dark:border-slate-800/60 items-start">
                        <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium pt-0.5">REMARKS / FINDINGS</div>
                        <div class="col-span-7 sm:col-span-8 font-semibold text-stone-800 dark:text-slate-200">: ${data.remarksFindings}</div>
                    </div>

                    <div class="grid grid-cols-12 gap-2 py-1.5 border-b border-stone-100 dark:border-slate-800/60 items-start">
                        <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium pt-0.5">FINDINGS</div>
                        <div class="col-span-7 sm:col-span-8 font-semibold text-stone-800 dark:text-slate-200">: ${data.finalFindings}</div>
                    </div>

                    <div class="grid grid-cols-12 gap-2 py-1.5 items-start">
                        <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium pt-0.5">REMARKS</div>
                        <div class="col-span-7 sm:col-span-8 font-semibold text-stone-800 dark:text-slate-200">: ${data.finalRemarks}</div>
                    </div>
                </div>
            </div>

            <!-- Beneficiary Dependents & Contact Record -->
            <div class="p-4 rounded-xl bg-stone-50 dark:bg-slate-800/60 border border-stone-200/90 dark:border-slate-700/80 space-y-3">
                <div class="flex items-center justify-between border-b border-stone-200/80 dark:border-slate-700/80 pb-2">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><circle cx="88" cy="108" r="52" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M155.41,57.94A52,52,0,0,1,168,160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M16,216a72,72,0,0,1,144,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M168,168.64a72,72,0,0,1,72,47.36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                        <span class="text-xs font-black uppercase tracking-wider text-stone-700 dark:text-slate-300">Dependents & Contact Info</span>
                    </div>
                    <span class="text-xs font-extrabold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">${data.numDependents} Dependents</span>
                </div>

                <div class="grid grid-cols-12 gap-2 text-xs sm:text-sm py-1 border-b border-stone-100 dark:border-slate-800/60 items-center">
                    <div class="col-span-5 sm:col-span-4 text-stone-500 dark:text-slate-400 font-medium">CONTACT PERSON / #</div>
                    <div class="col-span-7 sm:col-span-8 font-bold text-stone-900 dark:text-white">: ${data.contactPerson}</div>
                </div>

                <div>
                    <span class="text-xs text-stone-500 dark:text-slate-400 block mb-1.5 font-semibold">NAME & PARTICULARS OF DEPENDENT(S):</span>
                    <div class="p-3 bg-white dark:bg-slate-900 rounded-lg border border-stone-200 dark:border-slate-750 font-medium text-stone-800 dark:text-slate-200 text-xs sm:text-sm leading-relaxed">${data.dependentsList}</div>
                </div>
            </div>
        </div>
        <!-- END OF SUBCHILD: Tab 3 - Remarks & Dependents -->

      </div>
      <!-- END OF PROPONENT VIEWER SUBCHILD -->
    `;

    // Inject into drawer placeholder
    this.setContent('Proponent Detail', html);

    // Attach dynamic listeners for tabs and prev/next buttons
    const prevBtn = this.drawerEl.querySelector('#dynamic-prev-btn');
    const nextBtn = this.drawerEl.querySelector('#dynamic-next-btn');

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        if (this.currentProponentIndex > 0) {
          this.currentProponentIndex--;
          this.renderProponentViewer();
        }
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        if (this.currentProponentIndex < PROPONENTS_DATA.length - 1) {
          this.currentProponentIndex++;
          this.renderProponentViewer();
        }
      });
    }

    // Attach Tab Switching
    const tabButtons = this.drawerEl.querySelectorAll('.injected-tab-btn');
    const tabPanes = this.drawerEl.querySelectorAll('.injected-pane');

    tabButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-target');

        tabButtons.forEach((b) => {
          b.classList.remove('text-emerald-700', 'border-emerald-700', 'dark:text-emerald-400', 'dark:border-emerald-400', 'font-bold');
          b.classList.add('border-transparent', 'hover:text-stone-700', 'hover:border-stone-300', 'dark:hover:text-slate-200', 'dark:hover:border-slate-700');
        });

        btn.classList.add('text-emerald-700', 'border-emerald-700', 'dark:text-emerald-400', 'dark:border-emerald-400', 'font-bold');
        btn.classList.remove('border-transparent', 'hover:text-stone-700', 'hover:border-stone-300', 'dark:hover:text-slate-200', 'dark:hover:border-slate-700');

        tabPanes.forEach((p) => {
          if (p.id === targetId) {
            p.classList.remove('hidden');
          } else {
            p.classList.add('hidden');
          }
        });
      });
    });

    // START OF EVENT LISTENER: reevalModeToggle - Switch between 4-Cards breakdown and All-in-One banner
    const modeSelect = this.drawerEl.querySelector('#reeval-mode-select');
    const cardsContainer = this.drawerEl.querySelector('#reeval-cards-container');
    const mergedContainer = this.drawerEl.querySelector('#reeval-merged-container');

    if (modeSelect && cardsContainer && mergedContainer) {
      modeSelect.addEventListener('change', (e) => {
        const selectedMode = e.target.value;
        if (selectedMode === 'cards') {
          cardsContainer.classList.remove('hidden');
          mergedContainer.classList.add('hidden');
        } else {
          cardsContainer.classList.add('hidden');
          mergedContainer.classList.remove('hidden');
        }
      });
    }
    // END OF EVENT LISTENER: reevalModeToggle
  }
  // END OF FUNCTION: renderProponentViewer

  /**
   * START OF FUNCTION: open
   * Purpose: Sets dynamic content if provided and opens drawer
   */
  open(options = {}) {
    if (options.title || options.content) {
      this.setContent(options.title, options.content);
    }
    this.show();
  }
  // END OF FUNCTION: open

  /**
   * START OF FUNCTION: show
   * Purpose: Slides drawer smoothly into view using Flowbite API
   */
  show() {
    if (this.flowbiteDrawer) {
      this.flowbiteDrawer.show();
    } else {
      if (!this.drawerEl) this.drawerEl = document.getElementById(this.drawerId);
      if (this.drawerEl) {
        this.drawerEl.classList.remove('translate-x-full');
        this.drawerEl.classList.add('translate-x-0');
      }
    }
  }
  // END OF FUNCTION: show

  /**
   * START OF FUNCTION: hide
   * Purpose: Slides drawer out of view using Flowbite API
   */
  hide() {
    if (this.flowbiteDrawer) {
      this.flowbiteDrawer.hide();
    } else {
      if (!this.drawerEl) this.drawerEl = document.getElementById(this.drawerId);
      if (this.drawerEl) {
        this.drawerEl.classList.remove('translate-x-0');
        this.drawerEl.classList.add('translate-x-full');
      }
    }
  }
  // END OF FUNCTION: hide

  /**
   * START OF FUNCTION: toggle
   * Purpose: Toggles drawer open/closed state
   */
  toggle() {
    if (this.flowbiteDrawer) {
      this.flowbiteDrawer.toggle();
    }
  }
  // END OF FUNCTION: toggle

  /**
   * START OF FUNCTION: isVisible
   * Purpose: Returns current visibility status
   */
  isVisible() {
    return this.flowbiteDrawer ? this.flowbiteDrawer.isVisible() : false;
  }
  // END OF FUNCTION: isVisible
}
// END OF CLASS: DrawerManager

export const drawer = new DrawerManager('app-drawer');

/**
 * END OF FILE: frontend/src/js/modules/drawer.js
 */
