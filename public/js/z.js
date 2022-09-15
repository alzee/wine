console.log('hi, z');

setTimeout(() => {
    let item = document.querySelector('#Org_type-ts-control .item');
    let upstream = document.querySelector('.upstream');
    if (item && item.dataset.value > '1') {
        upstream.classList.remove('d-none');
    }

    const node = document.querySelector('#Org_type-ts-control');
    const config = { attributes: true, childList: true, subtree: true };
    const callback = function (){
        item = document.querySelector('#Org_type-ts-control .item');
        if (item && item.dataset.value > '1') {
            upstream.classList.remove('d-none');
        } else {
            upstream.classList.add('d-none');
        }
    };
    let observer = new MutationObserver(callback);
    observer.observe(node, config);
}, 0);

