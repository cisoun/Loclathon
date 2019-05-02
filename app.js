const App = {
  $price: 35,
  $units: 50,

  amountElement: null,
  buyModalElement: null,
  emailElement: null,
  finishModalElement: null,
  formAgeElement: null,
  formAmountElement: null,
  navbarElement: null,
  paypalElement: null,
  unitsElement: null,

  get isAgeConfirmed () { return this.formAgeElement.checked; },
  get navbarLimit () { return 80; },
  get price () { return this.$price; },
  set price (price) { this.setPrice(price); },
  get units () { return this.$units; },
  set units (units) { this.setUnits(units); },

  initialize () {
    this.amountElement = $('#amount');
    this.buyModalElement = $('#buyModal');
    this.emailElement = $('#email');
    this.finishModalElement = $('#finishModal')
    this.formAgeElement = $('#formAgeCheck')[0];
    this.formAmountElement = $('#formAmount')[0];
    this.navbarElement = $('.navbar');
    this.paypalElement = $('#paypal-button');
    this.unitsElement = $('#units');

    this.initializePaypal();
    this.initializeModal();
    this.loadPrice();
    this.loadUnits();

    window.onscroll = () => this.onWindowScrolled();
    this.formAmountElement.onchange = () => this.onAmountChanged();

    this.onAmountChanged();
  },

  initializeModal () {
    this.formAgeElement.onchange = () => this.onAgeChanged();
    this.formAgeElement.value = false;
    this.onAgeChanged();

    this.buyModalElement.on('show.bs.modal', () => this.loadUnits());
  },

  initializePaypal () {
    const app = this;
    paypal.Buttons({
      locale: 'fr_CH',
      style: {
        size: 'small',
        color: 'black',
        shape: 'pill',
        label: 'checkout',
      },

      createOrder: function(data, actions) {
        const currency = 'CHF';
        const items = $('#formAmount').val();
        const price = 35;
        const total = items * price;

        // Set up the transaction
        return actions.order.create({
          purchase_units: [{
            amount: {
              currency_code: 'CHF',
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
                value: price
              }
            }]
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then((details) => {
          $.post('/api/buy', JSON.stringify(details)).done((response) => {
            app.loadUnits();
            app.buyModalElement.modal('hide');
            if (response.success) {
              app.buyModalElement.on('hidden.bs.modal', () => {
                app.finishModalElement.modal('show');
                app.emailElement.html(response.email);
              });
            }
          });
        });
      }
    }).render('#' + this.paypalElement.attr('id'));
  },

  loadPrice () {
    $.get('/api/price', (response) => this.price = response);
  },

  loadUnits () {
    $.get('/api/units', (response) => this.units = response);
  },

  onAgeChanged () {
    this.paypalElement.toggle(this.isAgeConfirmed);
  },

  onAmountChanged () {
    const units = Math.min(Math.max(this.formAmountElement.value, 0), this.units);
    this.formAmountElement.value = units;
    this.amountElement.html(units * this.price);
  },

  onWindowScrolled () {
    if (document.body.scrollTop > this.navbarLimit || document.documentElement.scrollTop > this.navbarLimit) {
      this.navbarElement.addClass('opaque');
    } else {
      this.navbarElement.removeClass('opaque');
    }
  },

  setPrice (price) {
    this.$price = price;
    this.amountElement.html(price);
  },

  setUnits (units) {
    this.$units = units;
    this.unitsElement.html(units);
    this.formAmountElement.max = units;
  },
};

$(function() {
  App.initialize();
});
