function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;SameSite=Lax";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// for product page

function increaseQuantity(stock) {
    var quantity = document.getElementById("product_quantity");
    if (Number(quantity.value) + 1 <= stock) {
        quantity.value = Number(quantity.value) + 1;
    } else {
        quantity.value = stock;
    }
}

function decreaseQuantity(stock) {
    var quantity = document.getElementById("product_quantity");
    if (Number(quantity.value) <= stock) {
        quantity.value = Number(quantity.value) - 1;
    } else {
        quantity.value = stock - 1;
    }
}

function addToCart(product_id, stock) {
    var quantity = Number(document.getElementById("product_quantity").value);
    var cartBadge = document.getElementById("cartItems");

    var cart = getCookie("cart");

    if (!cart) {
        cart = {};
    } else {
        cart = JSON.parse(cart);
    }

    if (stock != 0) {
        if (quantity > stock) {
            quantity = stock;
            document.getElementById("product_quantity").value = quantity;
        }

        const cartItem = {
            product_id: product_id,
            quantity: quantity
        };

        var itemExists = 0;
        for (let i in cart) {
            if (cart[i].product_id == Number(product_id)) {
                if (stock < cart[i].quantity + quantity) {
                    quantity = stock - cart[i].quantity;
                }
                cart[i].quantity += quantity;
                itemExists = 1;
                break;
            }
        };

        if (!itemExists) {
            cart[Object.keys(cart).length] = cartItem;
        }

        cartBadge.innerHTML = Number(cartBadge.innerHTML) + quantity;

        setCookie("cart", JSON.stringify(cart), 1);
    }
}

// for cart page

function increaseCartQuantity(product_id, stock) {
    var quantity = document.getElementById("quantity" + product_id);
    if (Number(quantity.value) + 1 <= stock) {
        quantity.value = Number(quantity.value) + 1;
    } else {
        quantity.value = stock;
    }
    updateCart(product_id, stock);
}

function decreaseCartQuantity(product_id, stock) {
    var quantity = document.getElementById("quantity" + product_id);
    console.log(quantity.value);

    if (Number(quantity.value) <= stock) {
        quantity.value = quantity.value - 1;
    } else {
        quantity.value = Number(stock) - 1;
    }
    updateCart(product_id, stock);
}

function updateCart(product_id, stock) {
    var cart = JSON.parse(getCookie("cart"));
    var quantity = Number(document.getElementById("quantity" + product_id).value);
    const price = Number(document.getElementById("cleanPrice" + product_id).innerHTML);
    const discount = Number(document.getElementById("cleanDiscount" + product_id).innerHTML);

    if (stock != 0) {
        if (quantity > stock) {
            quantity = stock;
            document.getElementById("quantity" + product_id).value = quantity;
        }

        var totalPrice = document.getElementById("totalPrice" + product_id);
        totalPrice.innerHTML = (quantity * price).toFixed(2) + "€";

        var discountTotalPrice = document.getElementById("discountTotalPrice" + product_id);
        if (discountTotalPrice != null && discount > 0) {
            discountTotalPrice.innerHTML = (quantity * price * (1 - discount)).toFixed(2) + "€";
        }

        if (quantity <= 0) {
            removeFromCart(product_id);
        } else {
            for (let i in cart) {
                if (cart[i].product_id == Number(product_id)) {
                    cart[i].quantity = quantity;
                    break;
                }
            };
            setCookie("cart", JSON.stringify(cart), 1);
        }

        cartItems = 0
        for (let i in cart) {
            cartItems += cart[i].quantity;
        }
        document.getElementById("cartItems").innerHTML = cartItems;
    }
    updateFinalPrice()
}

function removeFromCart(product_id) {
    var cart = JSON.parse(getCookie("cart"));

    if (Object.keys(cart).length == 1) {
        document.getElementById("cartMain").children[0].innerHTML = "Your Cart is Empty";
        document.getElementById("finalPrice").parentElement.parentElement.remove();
    }

    cart = Object.fromEntries(
        Object.entries(cart).
            filter(([key, value]) =>
                value.product_id !== product_id)
    );

    const row = document.getElementById("productRow" + product_id);
    row.remove();

    cartItems = 0
    for (let i in cart) {
        cartItems += cart[i].quantity;
    }
    document.getElementById("cartItems").innerHTML = cartItems;

    setCookie("cart", JSON.stringify(cart), 1)
    updateFinalPrice();
}

function updateFinalPrice() {
    const main = document.getElementById("cartMain");
    productRows = main.children;

    finalPrice = 0;
    // ignore first and last child (title and final price)
    for (let i = 1; i < productRows.length - 1; i++) {
        const product_id = productRows[i].id.slice("productRow".length, productRows[i].id.length);

        const quantity = Number(document.getElementById("quantity" + product_id).value);
        const price = Number(document.getElementById("cleanPrice" + product_id).innerHTML);
        const discount = Number(document.getElementById("cleanDiscount" + product_id).innerHTML);

        finalPrice += quantity * price * (1 - discount);
    }
    document.getElementById("finalPrice").innerHTML = "Total: " + finalPrice.toFixed(2) + "€";
}