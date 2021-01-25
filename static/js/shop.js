import Fetch from './fetch.js';

// if (window.$ === undefined) {
//   window.$ = (a) => { return document.querySelector(a); }
//   window.$$ = (a) => { return document.querySelectorAll(a); }
// }

const Shop = {
  $price: 38,
  $units: 50,
  $stock: 50,
  $total: 0,

  get price () { return this.$price; },

  get total () { return this.$total; },
  set total (value) {
    this.$total = value;
    this.html.total.innerHTML = this.$total;
  },

  get units () { return this.$units; },
  set units (value) {
    this.$units =  Math.max(Math.min(value, this.$stock), 1);
    this.html.units.value = this.$units;
    this.total = this.$units * this.price;
  },

  async initialize () {
    const elements = Array.from(document.querySelectorAll('[id]'));
    this.html = Object.fromEntries(elements.map(x => [x.id, x]));

    this.html.country.onchange = () => this.onCountryOrNPAChange();
    this.html.npa.onchange = () => this.onCountryOrNPAChange();

    this.onCountryOrNPAChange();

    // await Fetch.get('/api/price').then((response) => this.$price = response);
    // await Fetch.get('/api/units').then((response) => this.$stock = response);
    //  this.initializePaypal();
  },

  onAmountChange () {
    // TODO
  },

  onCountryOrNPAChange () {
    const country = this.html.country.value == 'CH';
    const npa = ['2300', '2400'].includes(this.html.npa.value);

    this.html.shippingLocal.classList.toggle('hidden', !country);
    this.html.shippingLocal.disabled = !(npa && country);

    // Replace selection if necessary.
    if (!(country && npa) && this.html.shippingLocal.checked) {
      this.html.shippingPickUp.checked = true;
    }
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
