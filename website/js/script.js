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

var deleteModal = document.getElementById('deleteModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})

