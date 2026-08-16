function openProductSizeSelector(event, buttonType = null) {
    const button = event.currentTarget;
    const card = button.closest(".product-card");
    const overlay = card.querySelector(".product-size-overlay");
    const addToCartButton = overlay.querySelector(".proceed-add-to-cart");
    const buyNowButton = overlay.querySelector(".proceed-buy-now");
    addToCartButton.classList.remove("show");
    buyNowButton.classList.remove("show");
    if (buttonType === "add_to_cart") {
        addToCartButton.classList.add("show");
    } else if (buttonType === "buy_now") {
        buyNowButton.classList.add("show");
    }
    overlay.classList.add("show");
}
function closeProductSizeSelector(event) {
    const button = event.currentTarget;
    const card = button.closest(".product-card");
    const overlay = card.querySelector(".product-size-overlay");
    overlay.classList.remove("show");
}

function proceedProductSize(event) {
    const button = event.currentTarget;
    const card = button.closest(".product-card");
    const selectedSize = card.querySelector(
        '.product-size-overlay input[type="radio"]:checked',
    );
    if (!selectedSize) {
        alert("Please select a size");
        return;
    }
    const sizeId = selectedSize.value;
    const sizename = selectedSize.dataset.size_name;
    let size = {
        sizeid: sizeId,
        sizename: sizename,
    };
    const product = JSON.parse(
        card.querySelector(".data_container").dataset.thiscard,
    );
    card.querySelector(".product-size-overlay").classList.remove("show");
    addToCart(product, size, 1);
}

function proceedProductSizeByNow(product, event) {
    // const button = event.currentTarget;
    // const card = button.closest('.product-card');
    // const selectedSize = card.querySelector(
    //     '.product-size-overlay input[type="radio"]:checked'
    // );
    // if (!selectedSize) {
    //     alert('Please select a size');
    //     return;
    // }
    // const sizeId = selectedSize.value;
    // const sizename = selectedSize.dataset.size_name;
    // let size = {
    //     sizeid: sizeId, sizename: sizename
    // }
    // const product = JSON.parse(
    //     card.querySelector('.addToCart_css').dataset.product
    // );
    // card.querySelector('.product-size-overlay')
    //     .classList.remove('show'); 

} 