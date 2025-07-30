document.addEventListener('DOMContentLoaded', function () {
    // Recogemos las variables del Backend
    const useSame = window.useSameRangeForBoth || false;
    const selectedDate1 = window.selectedDate1 || null;
    const selectedDate2 = window.selectedDate2 || null;
    const dates = window.dates || {};
    const datesInput1 = document.getElementById('dates1') || null;
    const datesInput2 = document.getElementById('dates2') || null;
    const datesDropdown = document.getElementById('presetSelect') || null;
    let flatpickr1 = null;
    let flatpickr2 = null;

    if(datesInput1) {
        flatpickr1 = flatpickr(datesInput1, {
            dateFormat: "Y-m-d",
            mode: "range",
            altInput: true,
            altFormat: "d M y",
            locale: {firstDayOfWeek: 1},
            onReady: function (selectedDates1, dateStr, instance) {
                if (selectedDate1) {
                    instance.setDate(selectedDate1);
                }
            },
        });
    }

    if(datesInput2) {
        flatpickr2 = flatpickr(datesInput2, {
            dateFormat: "Y-m-d",
            mode: "range",
            altInput: true,
            altFormat: "d M y",
            locale: {firstDayOfWeek: 1},
            onReady: function (selectedDates2, dateStr, instance) {
                if (selectedDate2) {
                    instance.setDate(selectedDate2);
                }
            },
        });
    }



    // Agregamos las OPTIONS al Dropdown
    if(datesDropdown) {
        Object.entries(dates).forEach(([key, value]) => {
            const option = document.createElement('option');
            option.value = key;
            option.textContent = value.title;
            datesDropdown.appendChild(option);
        });
    }
    const applyDates = () => {
        const selectedValue = document.getElementById("presetSelect").value;
        const firstDates = [dates[selectedValue]?.thisYear?.initial, dates[selectedValue]?.thisYear?.final];
        const secondDates = useSame ? firstDates :
            [dates[selectedValue]?.lastYear?.initial, dates[selectedValue]?.lastYear?.final];
        if (flatpickr1 && firstDates[0] && firstDates[1]) flatpickr1.setDate(firstDates);
        if (flatpickr2 && secondDates[0] && secondDates[1]) flatpickr2.setDate(secondDates);
    }
    // Registrar la función en el ámbito global
    window.applyDates = applyDates;
});
