const App = {
  $units: 50,

  ageElement: null,
  navbarElement: null,
  paypalElement: null,
  unitsElements: null,

  get isAgeConfirmed () { return this.ageElement.checked; },
  get navbarLimit () { return 80; },
  get units () { return this.$units; },
  set units (units) { this.setUnits(units); },

  initialize () {
    this.ageElement = $('#formAgeCheck');
    this.navbarElement = $('.navbar');
    this.paypalElement = $('#paypal-button');
    this.unitsElements = $('#units');

    this.initializePaypal();
    this.initializeModal();
    this.loadUnits();

    window.onscroll = () => this.onWindowScrolled();
  },

  initializeModal () {
    const element = this.ageElement[0];
    element.onchange = () => this.onAgeChanged();
    element.checked = false;
    this.onAgeChanged();
  },

  initializePaypal () {
    var app = this;
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
            console.log(response);
            app.loadUnits();
          });
        });
      }
    }).render('#' + this.paypalElement.attr('id'));
  },

  loadUnits () {
    $.get('/api/units', (response) => this.units = response);
  },

  onAgeChanged () {
    this.paypalElement.toggle(this.isAgeConfirmed);
  },

  onWindowScrolled () {
    if (document.body.scrollTop > this.navbarLimit || document.documentElement.scrollTop > this.navbarLimit) {
      this.navbarElement.addClass('opaque');
    } else {
      this.navbarElement.removeClass('opaque');
    }
  },

  setUnits (units) {
    this.$units = units;
    this.unitsElements.html(units);
  },
};

$(function() {
  App.initialize();
});
