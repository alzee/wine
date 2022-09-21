setTimeout(() => {
  let input = document.querySelector('#Withdraw_amount');
  let more = document.querySelector('#withdrawHelp .more');
  if (more) {
    more.classList.remove('d-none');
  }
  if (input) {
    input.addEventListener('input', function () {
      let discount = document.querySelector('#withdrawHelp .discount').innerText;
      let amount = document.querySelector('#withdrawHelp .amount');
      amount.innerText = this.value;
      let actual = document.querySelector('#withdrawHelp .actual');
      actual.innerText = this.value * discount / 100;
    });

  }
}, 0);

