const Shop = {
  $price: 38,
  $units: 50,
  $stock: 50,
  $total: 0,

  get price () { return this.$price; },

  get total () { return this.$total; },
  set total (value) {
    this.$total               = value;
    this.html.total.innerHTML = this.$total;
  },

  get units () { return this.$units; },
  set units (value) {
    this.$units           = Math.max(Math.min(value, this.$stock), 1);
    this.html.units.value = this.$units;
    this.total            = this.$units * this.price;
  },

  async initialize () {
    const elements = Array.from(document.querySelectorAll('[id]'));
    this.html      = Object.fromEntries(elements.map(x => [x.id, x]));

    this.html.country.onchange = () => this.onCountryOrNPAChange();
    this.html.npa.onchange     = () => this.onCountryOrNPAChange();

    this.onCountryOrNPAChange();
  },

  onCountryOrNPAChange () {
    const country = this.html.country.value == 'CH';
    const npa     = ['2300', '2400'].includes(this.html.npa.value);

    this.html.shippingLocal.classList.toggle('hidden', !country);
    this.html.shippingLocal.disabled = !(npa && country);

    // Replace selection if necessary.
    if (!(country && npa) && this.html.shippingLocal.checked) {
      this.html.shippingPickUp.checked = true;
    }
  },
};

Shop.initialize();
