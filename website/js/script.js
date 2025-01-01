document.addEventListener("DOMContentLoaded", async function () {
    const countrySelect = document.getElementById("country");
    const citySelect = document.getElementById("city");

    // enable city dropdown when city is already selected
    if (citySelect.value) {
        citySelect.disabled = false;
    }

    // call updateCities when country is already selected
    const preselectedCountryIndex =
        countrySelect.selectedOptions[0]?.dataset.index;
    if (preselectedCountryIndex) {
        await updateCities(countrySelect);
    }
});

async function updateCities(selectElement) {
    const citySelect = document.getElementById("city");
    const countryIndex = selectElement.selectedOptions[0]?.dataset.index;
    citySelect.disabled = true;

    if (!countryIndex) {
        citySelect.innerHTML = "<option value='' selected></option>";
        return;
    }

    const response = await fetch("https://countriesnow.space/api/v0.1/countries");
    const countriesData = await response.json();
    const selectedCountry = countriesData.data[countryIndex];
    const cities = selectedCountry.cities;

    let options = "<option value='' selected></option>";
    options += cities
        .map(
            (city) =>
                `<option value="${city}" ${city === citySelect.value ? "selected" : ""
                }>${city}</option>`
        )
        .join("");
    citySelect.innerHTML = options;
    citySelect.disabled = false;
}

// for admin user management

function showUserDetails(editButton) {
    var parent = editButton.parentElement.parentElement;
    var children = parent.children;

    var user_id = children[0].innerHTML;
    var email = children[1].innerHTML;
    var first_name = children[2].innerHTML;
    var last_name = children[3].innerHTML;
    var country = children[4].innerHTML;
    var city = children[5].innerHTML;
    var address = children[6].innerHTML;
    var role = children[8].innerHTML;

    document.getElementById("editUserId").value = user_id;
    document.getElementById("editModalUserId").innerHTML = user_id;
    document.getElementById("email").value = email;
    document.getElementById("first_name").value = first_name;
    document.getElementById("last_name").value = last_name;
    document.getElementById("country").value = country;
    document.getElementById("city").value = city;
    document.getElementById("address").value = address;

    var roleOptions = document.getElementById("role").children;
    roleOptions[0].removeAttribute("selected");
    roleOptions[1].removeAttribute("selected");

    if (role === "user") {
        roleOptions[0].setAttribute("selected", true);
    } else if (role === "admin") {
        roleOptions[1].setAttribute("selected", true);
    }
}

function showUserId(deleteButton) {
    var parent = deleteButton.parentElement.parentElement;
    var children = parent.children;
    var user_id = children[0].innerHTML;
    document.getElementById("deleteModalUserId").innerHTML = user_id;
    document.getElementById("deleteUserId").value = user_id;

    console.log(user_id);
}

// for user order history

function showInfo(infoButton) {
    const parent = infoButton.parentElement.parentElement;
    const orderInfo = parent.children[8];

    var infoModalList = document.getElementById("orderInfoList");

    infoModalList.children[0].children[1].innerHTML = orderInfo.children[0].innerHTML;
    infoModalList.children[1].children[1].innerHTML = orderInfo.children[1].innerHTML;
    infoModalList.children[2].children[1].innerHTML = orderInfo.children[2].innerHTML;
    infoModalList.children[3].children[1].innerHTML = orderInfo.children[3].innerHTML;
    infoModalList.children[4].children[1].innerHTML = orderInfo.children[4].innerHTML;
    infoModalList.children[5].children[1].innerHTML = orderInfo.children[5].innerHTML;
}

function showProducts(productsButton) { }

function showOrderId(cancelButton) {
    const parent = cancelButton.parentElement.parentElement;
    const children = parent.children;
    const order_id = children[0].innerHTML;
    document.getElementById("cancelModalOrderId").innerHTML = order_id;
    document.getElementById("cancelOrderId").value = order_id;
}

// for checkout

function showShippingForm() {
    document.getElementById("checkoutShipping").classList.remove("d-none");
    document.getElementById("checkoutPayment").classList.add("d-none");
}

function showPaymentForm() {
    document.getElementById("checkoutShipping").classList.add("d-none");
    document.getElementById("checkoutPayment").classList.remove("d-none");
    document.getElementById("checkoutConfirm").classList.add("d-none");
}

function showConfirmForm() {
    document.getElementById("checkoutPayment").classList.add("d-none");
    document.getElementById("checkoutConfirm").classList.remove("d-none");
}

function validateForm(formId) {
    const form = document.getElementById(formId);

    if (!form.checkValidity()) {
        form.reportValidity();
        return false;
    }

    return true;
}
