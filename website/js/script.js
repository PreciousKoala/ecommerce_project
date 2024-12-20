async function updateCities(selectElement) {
    const citySelect = document.getElementById("city");
    const countryIndex = selectElement.selectedOptions[0]?.dataset.index;
    citySelect.disabled = true;

    if (!countryIndex) {
        citySelect.innerHTML = "<option value='' selected></option>";
        return;
    }

    try {
        const response = await fetch("https://countriesnow.space/api/v0.1/countries");
        const countriesData = await response.json();

        const selectedCountry = countriesData.data[countryIndex];
        if (!selectedCountry || !selectedCountry.cities) {
            citySelect.innerHTML = "<option value='' selected>No cities available</option>";
            return;
        }

        const cities = selectedCountry.cities;
        let options = "<option value='' selected></option>";
        options += cities.map(city => `<option value="${city}">${city}</option>`).join("");
        citySelect.innerHTML = options;
        citySelect.disabled = false;
    } catch (error) {
        console.error("Error fetching countries or updating cities:", error);
        citySelect.innerHTML = "<option value='' selected>Error loading cities</option>";
    }
}


