const App = {
  $price: 35,
  $units: 50,

  messages: {
    modal: {
      finishButton: ['Annuler', 'Fermer'],
      title: ['Acheter', 'Vérification...', 'Merci pour votre achat !', 'Oups...'],
    }
  },

  amountElement: null,
  emailElement: null,
  finishButtonElement: null,
  formAgeElement: null,
  formAmountElement: null,
  formElement: null,
  modalElement: null,
  modalTitleElement: null,
  navbarElement: null,
  paypalButtonElement: null,
  priceElement: null,
  retryButtonElement: null,
  stepElements: null,
  unitsElement: null,

  get isAgeConfirmed () { return this.formAgeElement.checked; },
  get navbarLimit () { return 80; },
  get price () { return this.$price; },
  set price (price) { this.setPrice(price); },
  get units () { return this.$units; },
  set units (units) { this.setUnits(units); },

  initialize () {
    this.amountElement = $('#amount');
    this.emailElement = $('#email');
    this.finishButtonElement = $('#finish-button');
    this.formAgeElement = $('#formAgeCheck')[0];
    this.formAmountElement = $('#formAmount')[0];
    this.formElement = $('#form');
    this.modalElement = $('#modal');
    this.modalTitleElement = $('#modal-title');
    this.navbarElement = $('.navbar');
    this.paypalButtonElement = $('#paypal-button');
    this.priceElement = $('#price');
    this.retryButtonElement = $('#retry-button');
    this.stepElements = $('.buy-step');
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

    this.modalElement.on('show.bs.modal', () => this.loadUnits());
    this.modalElement.on('hidden.bs.modal', () => this.setModalStep(0));
    this.retryButtonElement.on('click', () => this.setModalStep(0));

    this.setModalStep(0);
  },

  initializePaypal () {
    const app = this;
    paypal.Buttons({
      locale: 'fr_CH',
      style: {
        color: 'black',
        label: 'checkout',
        layout: 'horizontal',
        tagline: false,
        height: 38,
      },

      createOrder: function(data, actions) {
        const currency = 'CHF';
        const items = app.formAmountElement.value;
        const total = items * app.price;

        app.setModalStep(1);

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
            app.setModalStep(3);
            return;
          }

          $.post('/api/buy', JSON.stringify(details)).done((response) => {
            app.setModalStep(2);
            app.emailElement.html(response.email);
            app.loadUnits();
          });
        });
      },
      onCancel: function (data) {
        app.setModalStep(3);
      },
      onError: function (err) {
        app.setModalSetp(3);
      }
    }).render('#' + this.paypalButtonElement.attr('id'));
  },

  loadPrice () {
    $.get('/api/price', (response) => this.price = response);
  },

  loadUnits () {
    $.get('/api/units', (response) => this.units = response);
  },

  onAgeChanged () {
    this.paypalButtonElement.toggle(this.isAgeConfirmed);
  },

  onAmountChanged () {
    // Clamp units from 0 to available units.
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

  /**
   * setModalStep (step)
   * Steps:
   *  0: buying
   *  1: waiting
   *  2: confirmed
   *  3: cancelled
   *
   * @param step Purchase step
   */
  setModalStep (step) {
    const steps = this.stepElements.length;

    // Show current step.
    for (let i = 0; i < steps; i++) {
      $(this.stepElements[i]).toggle(step == i);
    }

    this.modalTitleElement.html(this.messages.modal.title[step]);
    this.retryButtonElement.toggle(step == 3);
    this.paypalButtonElement.toggle(step == 0 && this.isAgeConfirmed);

    if (step == 0) {
      this.finishButtonElement.html(this.messages.modal.finishButton[0]);
    } else if (step > 1) {
      this.finishButtonElement.html(this.messages.modal.finishButton[1]);
    }
  },

  setPrice (price) {
    this.$price = price;
    this.amountElement.html(price);
    this.priceElement.html(price);
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
