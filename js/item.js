document.addEventListener("DOMContentLoaded", function () { //this script handles updating the max quantity of an item that can be added to cart in the item page forms, based on the available stock.
    const select = document.getElementById("varId");
    const qIn = document.querySelector("input[name='quantity']");

    function updateMax() {
        const selectedVar = select.options[select.selectedIndex];
        const stock = selectedVar.getAttribute("dstock");
        if (stock) {
            qIn.max = stock;

            if (parseInt(qIn.value) > parseInt(stock)) {
                qIn.value = stock;
            }

        }
    }
    select.addEventListener("change", updateMax);
    updateMax();
});