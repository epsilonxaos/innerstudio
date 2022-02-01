function getDataForms(idForm) {
    let obj = {};
    let form = document.getElementById(idForm);

    if (form.querySelector('input')) {
        form.querySelectorAll('input').forEach(elem => {
            if (elem.hasAttribute("getform")) {
                obj[elem.getAttribute("name")] = elem.value;
            }
        });
    }

    if (form.querySelector('select')) {
        form.querySelectorAll('select').forEach(elem => {
            if (elem.hasAttribute("getform")) {
                obj[elem.getAttribute("name")] = elem.value;
            }
        });
    }

    if (form.querySelector('textarea')) {
        form.querySelectorAll('textarea').forEach(elem => {
            if (elem.hasAttribute("getform")) {
                obj[elem.getAttribute("name")] = elem.value;
            }
        });
    }

    return obj;
}

export { getDataForms }