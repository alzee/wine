setTimeout(() => {
  let input = document.querySelector('#Withdraw_amount');
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

