import Fetch from '../static/fetch.js';

const Shop = {
  $price: 0,
  $units: 0,
  $stock: 0,
  $total: 0,

  ui: {},

  get price () { return this.$price; },

  get total () { return this.$total; },
  set total (value) {
    this.$total = value;
    this.ui.total.innerHTML = this.$total;
  },

  get units () { return this.$units; },
  set units (value) {
    this.$units =  Math.max(Math.min(value, this.$stock), 1);
    this.ui.units.value = this.$units;
    this.total = this.$units * this.price;
  },

  async initialize () {
    this.ui.total = document.querySelector('#total');
    this.ui.units = document.querySelector('#units');

    /* Handle amount. */
    const amount       = document.querySelector('.group.number div');
    const addButton    = amount.querySelector('button.add');
    const removeButton = amount.querySelector('button.remove');
    const input        = amount.querySelector('input');
    const min          = Number(input.min);
    const max          = Number(input.max);
    addButton.classList.remove('hidden');
    removeButton.classList.remove('hidden');
    addButton.onclick    = () => this.units = Number(input.value) + 1;
    removeButton.onclick = () => this.units = Number(input.value) - 1;
    input.onchange = () => this.units = Number(input.value);

    /* Handle shipping method. */
    const infoOnSite = document.querySelector('#infoOnSite');
    const shippingMethods = document.querySelectorAll('.group.radio input');
    for (var method of shippingMethods) {
      method.onchange = (e) => {
        infoOnSite.classList.toggle('hidden', e.target.value != 'onsite');
      };
    }
    const shippingOnSite = document.querySelector('#shippingOnSite');
    infoOnSite.classList.toggle('hidden', !shippingOnSite.checked);

    const dropdowns = document.querySelectorAll('form .group.dropdown');
    for (const dropdown of dropdowns) {
      const input = dropdown.querySelector('input');
      const dropdownItems = dropdown.querySelectorAll('ul > li');
      for (const dropdownItem of dropdownItems) {
        dropdownItem.onmousedown = () => input.value = dropdownItem.innerHTML;
      }
    }

    await Fetch.get('/api/price').then((response) => this.$price = response);
    await Fetch.get('/api/units').then((response) => this.$stock = response);
    //  this.initializePaypal();
  },

  initializePaypal () {
    const app = this;
    paypal.Buttons({
      locale: 'fr_CH',
      style: {
        label: 'pay',
        layout: 'horizontal',
        tagline: false,
        height: 38,
      },

      createOrder: function(data, actions) {
        const currency = 'CHF';
        const items = 1;
        const total = 35;

        // Set up the transaction
        return actions.order.create({
          purchase_units: [{
            amount: {
              currency_code: currency,
              value: total,
              breakdown: {
                item_total: {
                  value: total,
                  currency_code: currency
                }
              }
            },
            items: [{
              name: 'La Locloise',
              description: 'La Locloise, bouteille 5dl officielle du Loclathon.',
              quantity: items,
              unit_amount: {
                currency_code: currency,
                value: app.price
              }
            }]
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then((details) => {
          const success = 'status' in details && details['status'] == 'COMPLETED';

          if (!success) {
            return;
          }

          $.post('/api/buy', JSON.stringify(details)).done((response) => {

          });
        });
      },
      onCancel: function (data) {
      },
      onError: function (err) {

      }
    }).render('#payByPaypal');
  },
};

Shop.initialize();
