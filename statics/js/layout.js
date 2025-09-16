const Layout = {
  initialize () {
    // NOTE: Dropdown support, not needed now.
    // this.initializeDropdowns();
    this.initializeNumbers();
  },

  initializeDropdowns () {
    const dropdowns = document.querySelectorAll('.group.dropdown');
    dropdowns.forEach(container => {
      const button = container.querySelector('div > button');
      const input  = container.querySelector('input');
      // Show control if JS is enabled.
      button.classList.remove('hidden');

      input.onclick = () => {
        const event = new FocusEvent('focus', {
          view: window,
          bubbles: true,
          cancelable: true
        });

        input.dispatchEvent(event);
        input.focus();
      }

      // Handle click on menu items.
      const items = container.querySelectorAll('ul > li');
      items.forEach(item => {
        item.onmousedown = () => input.value = item.innerHTML;
      });
    });
  },

  initializeNumbers () {
    const numbers = document.querySelectorAll('.group.number');
    numbers.forEach(container => {
      const buttons = container.querySelectorAll('div > button');
      const input   = container.querySelector('input');
      // Show custom controls if JS is enabled.
      input.classList.add('hide-controls');
      buttons.forEach(button => button.classList.remove('hidden'));
      // Check input value when updated.
      const callback = this.updateNumber;
      buttons[0].onclick = () => callback(input, Number(input.value) - 1);
      buttons[1].onclick = () => callback(input, Number(input.value) + 1);
      input.onchange     = () => callback(input, input.value);
    });

  },

  updateNumber (input, value) {
    input.value = Math.max(Math.min(value, input.max), input.min);
  }
};

window.onload = function () {
  Layout.initialize();
}
