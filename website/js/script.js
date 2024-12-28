document.addEventListener("DOMContentLoaded", async function () {
    const countrySelect = document.getElementById("country");
    const citySelect = document.getElementById("city");

    // enable city dropdown when city is already selected
    if (citySelect.value) {
        citySelect.disabled = false;
    }

    // call updateCities when country is already selected
    const preselectedCountryIndex = countrySelect.selectedOptions[0]?.dataset.index;
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
    options += cities.map((city) => `<option value="${city}" ${city === citySelect.value ? "selected" : ""}>${city}</option>`).join("");
    citySelect.innerHTML = options;
    citySelect.disabled = false;
}

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