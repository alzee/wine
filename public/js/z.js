console.log('hi, z');

let type = document.querySelector('#Org_type-ts-control');
if (type.firstChild.dataset.value == '2') {
    let upstream = document.querySelector('.upstream');
    upstream.classList.remove('d-none');
}
