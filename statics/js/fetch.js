/**
 * Custom wrapper using the Fetch API.
 */
const Fetch = {
  async get (url) { return this.request(url, 'GET'); },

  async post (url, data={}) { return this.request(url, 'POST', data); },

  /**
   * Do a request.
   *
   * @param {string} url URL to fetch.
   * @param {string} method Fetch method (GET/POST/...).
   * @param {object} data (Optional) JSON data to send (POST/UPDATE only).
   * @return {object} Dictionary containing status, success and data.
   */
  async request(url, method, data={}, callback=() => {}) {
    let params = { method: method };

    // Add JSON data if necessary.
    if (['PATCH', 'POST', 'PUT'].includes(method)) {
      params = Object.assign(params, {
        body: JSON.stringify(data),
        headers: { 'Content-Type': 'application/json' },
      });
    }

    const response = await fetch(url, params);

    return response.json();
  },
};

export default Fetch;
