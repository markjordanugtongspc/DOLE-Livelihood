/* START: ApiClient — wrapper for HTTP requests with automatic CSRF token injection */
export default class ApiClient {
  /* START: getCsrf — extracts CSRF token from page meta tag */
  static getCsrf() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
  }
  /* END: getCsrf */

  /* START: request — core fetch method handling JSON and headers */
  static async request(url, options = {}) {
    const defaultHeaders = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-Token': this.getCsrf(),
    };

    const config = {
      ...options,
      headers: {
        ...defaultHeaders,
        ...options.headers,
      },
    };

    try {
      const response = await fetch(url, config);
      const data = await response.json().catch(() => null);

      if (!response.ok) {
        return {
          success: false,
          status: response.status,
          message: data?.message || `Request failed with status ${response.status}`,
          data: data?.data || null,
          errors: data?.errors || null,
        };
      }

      return {
        success: true,
        status: response.status,
        message: data?.message || 'Success',
        data: data?.data || null,
      };
    } catch (error) {
      return {
        success: false,
        status: 0,
        message: error.message || 'Network connection error',
        data: null,
      };
    }
  }
  /* END: request */

  /* START: post — performs POST request with JSON payload */
  static async post(url, body = {}) {
    return this.request(url, {
      method: 'POST',
      body: JSON.stringify(body),
    });
  }
  /* END: post */

  /* START: get — performs GET request */
  static async get(url) {
    return this.request(url, { method: 'GET' });
  }
  /* END: get */
}
/* END: ApiClient */

export const apiClient = ApiClient;
export { ApiClient };

